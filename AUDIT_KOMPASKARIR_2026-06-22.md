# LAPORAN AUDIT & EVALUASI TEKNIS — KOMPASKARIR
**Tanggal:** 22 Juni 2026  
**Auditor:** Antigravity AI  
**Codebase:** `c:\laragon\www\batubata`  
**Branch:** `master`  
**Scope:** Full-stack Laravel Audit (Backend + Frontend + Security + Performance + Feature Sync)

---

## 1. OPTIMASI KECEPATAN

### 1.1 — N+1 Query Problem (KRITIS)

**Lokasi:** `JobMatchingService::getMatchedJobsPaginated()` dan `getMatchedJobs()`

**Masalah:**
```php
// Baris ~90-99 — JobMatchingService.php
$jobs = JobListing::where('is_active', true)
    ->where('expires_date', '>', now())
    ->get(); // Ambil SEMUA job sekaligus ke memori

$matchedJobs = $jobs->map(function ($job) use ($user) {
    $job->matching_percentage = $this->calculateMatch($user, $job);
    // calculateMatch memanggil DocumentScoringService yang query DB per-job
    return $job;
});
```
Setiap iterasi job memanggil `calculateMatch()` → `DocumentScoringService::calculateFinalMatchScore()` → query `UserDocumentScore` per job. Jika ada 200 lowongan, terjadi **200+ query terpisah**.

**Perbaikan yang Disarankan:**
- Pre-load semua `UserDocumentScore` user dalam satu query sebelum loop.
- Gunakan `JobListing::with(['position', 'company'])` agar relasi tidak lazy-load dalam map.
- Tambahkan index database pada kolom `is_active`, `expires_date`, `user_id` di tabel `user_document_scores`.

---

### 1.2 — Tidak Ada Caching pada Data Berulang

**Masalah:**
- `CompanyDocumentWeight::whereNull('company_id')` dipanggil berulang setiap kali ada perhitungan matching (sekali per job).
- `ChatAgentService::loadDocumentation()` membaca semua file `.md` dari disk di setiap request (meski ada flag `$docsLoaded`, ini tidak persisten antar request karena service di-instantiate ulang).

**Lokasi:**
- `DocumentScoringService::getWeightsForJob()` — tidak ada cache
- `ChatAgentService::loadDocumentation()` — membaca file disk tiap request baru

**Perbaikan yang Disarankan:**
```php
// DocumentScoringService.php
private function getWeightsForJob(JobListing $job): ?CompanyDocumentWeight
{
    return cache()->remember(
        "weights_job_{$job->company_id}",
        now()->addMinutes(60),
        fn() => CompanyDocumentWeight::whereNull('company_id')
                    ->where('is_active', true)
                    ->first()
    );
}
```
- Untuk `ChatAgentService`, simpan `$docSections` ke cache `database`/`redis` dengan key `chat_docs_sections` dan TTL 1 jam.

---

### 1.3 — Sorting In-Memory yang Tidak Efisien

**Lokasi:** `JobMatchingService::getMatchedJobsPaginated()` — baris ~242

**Masalah:**
```php
$matchedJobs = $matchedJobs->sortBy($sortCriteria); // Sorting setelah semua data di-load ke PHP
```
Seluruh data diambil dari DB ke PHP, baru diurutkan. Untuk sort berdasarkan `created_at` atau `salary_max`, ini seharusnya dilakukan di level SQL.

**Perbaikan:** Pisahkan jalur sorting — jika sort adalah `terbaru` atau `gaji`, lakukan di DB Query. Hanya sort `kecocokan` yang memerlukan in-memory sorting karena melibatkan perhitungan matching.

---

### 1.4 — Beban Berat di Sidebar Template (app.blade.php)

**Masalah:** `app.blade.php` melakukan banyak query DB di setiap halaman:
- `Auth::user()->documents->where(...)` — lazy load relasi `documents`
- `Auth::user()->unreadNotifications()->whereNotIn(...)` — query notif
- `Auth::user()->totalUnreadMessages()` — query pesan
- Duplikasi: foto user diambil 3 kali (sidebar user card, bottom sheet header, dan mobile header)

**Perbaikan:**
```php
// Di AppServiceProvider atau middleware, bind shared data:
View::share('navPhoto', Auth::user()?->documents->where('document_type', 'photo')->first());
View::share('unreadNotifCount', cache()->remember("notif_{$user->id}", 60, fn() => ...));
```

---

### 1.5 — Session Driver `database` + Queue `database`

**Env:**
```
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```
Semua menggunakan database. Untuk load ringan ini oke, tapi pada saat traffic tinggi akan menjadi bottleneck karena setiap request menulis ke tabel `sessions`. Pertimbangkan migrasi ke Redis ketika aplikasi tumbuh.

---

## 2. CELAH KEAMANAN

### 2.1 — API Key Sensitive Terekspos di .env (TINGGI)

**Masalah:** File `.env` mengandung kredensial API yang sensitif:
```
XIAOMI_API_KEY="tp-s4349rlrzi5a6ivwgdb8c5xve45woxe8gi8zuxleex2z95v5"
GOOGLE_CLIENT_SECRET=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
MAIL_PASSWORD=d806e531c8fbff
```
Meski `.env` di `.gitignore`, jika file ini tidak terlindungi di server (izin file salah, atau terpublish melalui celah path traversal), semua API key bisa bocor.

**Rekomendasi:**
- Pastikan permission file `.env`: `chmod 640 .env` di server Linux
- Pertimbangkan penggunaan Laravel Vault atau enkripsi `.env` dengan `php artisan env:encrypt`
- Rotate semua API key yang tercantum di .env production secara berkala

---

### 2.2 — `SESSION_SECURE_COOKIE=true` tapi `APP_URL=http://` (SEDANG)

**Masalah di .env:**
```
APP_URL=http://localhost:8000   # HTTP, bukan HTTPS
SESSION_SECURE_COOKIE=true       # Hanya kirim cookie via HTTPS
```
Jika app berjalan di HTTP (development), cookie session tidak akan dikirim oleh browser karena `Secure` flag aktif. Di production, ini harus selalu HTTPS, tapi konfigurasi ini inkonsisten.

**Perbaikan:**
- Development: `SESSION_SECURE_COOKIE=false`
- Production: Pastikan `APP_URL` menggunakan `https://` dan `SESSION_SECURE_COOKIE=true`

---

### 2.3 — Otorisasi Lemah di `deleteDocument()` (SEDANG)

**Lokasi:** `ProfileController::deleteDocument()` — baris 110-121

**Masalah:**
```php
public function deleteDocument($id): RedirectResponse
{
    $document = \App\Models\UserDocument::where('user_id', Auth::id())->findOrFail($id);
```
Chaining `where('user_id', ...)->findOrFail($id)` adalah penanganan yang benar, namun:
- Tidak ada log aktivitas penghapusan dokumen penting.
- Tidak ada konfirmasi tambahan (CSRF sudah ada, tapi tidak ada throttle pada route ini).
- Dokumen `ijazah`, `cv` yang dihapus tidak memberikan notifikasi atau reset skor dokumen (`UserDocumentScore`) terkait.

**Risiko:** Jika dokumen dihapus, `UserDocumentScore` lama masih ada di DB dan matching score menjadi tidak akurat (ghost data).

**Perbaikan:** Tambahkan logic untuk menghapus `UserDocumentScore` terkait dan reset matching scores saat dokumen dihapus.

---

### 2.4 — Mass Assignment di `User::update()` (RENDAH)

**Lokasi:** `ProfileController::updateMobileLayout()` — baris 162

```php
$request->user()->update([
    'mobile_layout' => $validated['mobile_layout'],
]);
```
Meski menggunakan `$validated`, field `mobile_layout` perlu dikonfirmasi ada di `$fillable` Model. Sudah ada di fillable — ini OK. Namun secara umum, perlu diaudit bahwa semua field di `$fillable` memang aman untuk diupdate oleh user.

---

### 2.5 — Prompt Injection Detection — Lemah terhadap Obfuscasi (RENDAH)

**Lokasi:** `ChatAgentService::isPromptInjection()` — baris 695

**Masalah:** Pattern detection berbasis regex dapat di-bypass dengan Unicode lookalike characters, spasi berlebih, atau encoding alternatif. Contoh: "IgnOre aLL PrEviOuS iNstRucTions" lolos dari beberapa pattern karena case-insensitive sudah ditangani, namun Unicode substitution belum.

**Rekomendasi:** Tambahkan normalisasi teks (lowercase, normalize whitespace) sebelum pattern matching.

---

## 3. PENYEMPURNAAN FITUR YANG SUDAH ADA

### 3.1 — TPA Offline: `seeker_response` tidak di-reset saat ada Undangan Baru

**Lokasi:** `TpaService::inviteOffline()` — baris 104

**Masalah:** Jika seeker pernah menolak (`declined`) dan industri mengirim ulang undangan, session baru dibuat TAPI `seeker_response` diset `'pending'`. Namun `SeekerTpaController::respondOffline()` cek:
```php
if ($session->seeker_response !== 'pending') {
    return back()->with('error', 'Anda sudah merespon undangan ini.');
}
```
Session baru selalu dimulai dengan `pending`, jadi ini OK. Tapi tidak ada validasi bahwa user tidak memiliki **session aktif lain** untuk job yang sama — potensi duplikasi sesi.

---

### 3.2 — TPA: `checkAndExpireSession()` Memanggil `submitTest()` Tanpa Guard

**Lokasi:** `TpaService::checkAndExpireSession()` — baris 496-506

```php
if ($session->status === 'in_progress' && $session->started_at) {
    $limitSeconds = $session->tpaTest->time_limit_minutes * 60;
    $elapsed = now()->diffInSeconds($session->started_at);
    
    if ($elapsed >= $limitSeconds) {
        $this->submitTest($session);  // Bisa dipanggil berkali-kali jika ada race condition
        return true;
    }
}
```
**Masalah:** Tidak ada atomic lock. Jika dua request masuk bersamaan (misalnya user submit manual + auto-expire), `submitTest` bisa dipanggil dua kali → dua `TpaResult` untuk satu session.

**Perbaikan:**
```php
// Gunakan DB lock untuk atomicity
DB::transaction(function() use ($session) {
    $session = TpaTestSession::lockForUpdate()->find($session->id);
    if ($session->status === 'in_progress') {
        $this->submitTest($session);
    }
});
```

---

### 3.3 — Assessment: Tidak Ada Validasi Duplikasi per Hari

**Lokasi:** `AssessmentController::store()` & `AssessmentScoringService::processAndSaveScores()`

**Masalah:** Tidak ada validasi apakah user sudah melakukan asesmen untuk posisi yang sama dalam rentang waktu tertentu. User bisa spam asesmen → roadmap terus di-generate ulang → potensi data sampah.

**Perbaikan:** Tambahkan check:
```php
$existing = UserAssessment::where('user_id', $userId)
    ->where('position_id', $positionId)
    ->where('assessment_date', '>=', now()->subDays(7))
    ->exists();
if ($existing) {
    return ['error' => 'Anda sudah melakukan asesmen untuk posisi ini dalam 7 hari terakhir.'];
}
```

---

### 3.4 — Roadmap: Skill Group Sangat Spesifik ke Marketing Digital

**Lokasi:** `RoadmapService::$skillGroups` — baris 15-25

```php
private array $skillGroups = [
    'seo_sem' => ['seo', 'sem', 'search engine', 'google ads', 'google tag'],
    'social_media' => ['social media', 'facebook ads', 'instagram', 'tiktok'],
    'content' => ['content', 'copywriting', 'content strategy'],
    ...
];
```
Semua keyword mengarah ke marketing digital. Jika kompetensi yang diatur admin adalah IT, Finance, atau Engineering, semua skill akan masuk ke bucket `other → 'Kompetensi Pendukung'` yang tidak deskriptif.

**Perbaikan:** Tambahkan grup umum untuk IT, Finance, Engineering, dan Healthcare, atau buat skill groups bersifat configurable dari database.

---

### 3.5 — Logo Sidebar Link: `$dashboardRoute` Tidak Tersedia di Header Section

**Lokasi:** `app.blade.php` — baris 1440

```php
<a href="{{ $dashboardRoute ?? route('dashboard') }}" class="lg:hidden flex items-center">
```
Variabel `$dashboardRoute` hanya didefinisikan di blok PHP **dalam `<aside>`** (baris 861). Jika `aside` tidak di-render (mode bottombar menyembunyikan sidebar), `$dashboardRoute` tidak ada di scope blade header. Penggunaan `?? route('dashboard')` sudah sebagai fallback yang benar, tapi ini tidak akurat untuk role admin/industry.

**Perbaikan:** Pindahkan definisi `$dashboardRoute` ke `ViewServiceProvider` atau ke awal template (sebelum `<head>`).

---

## 4. KETIDAKSINKRONAN ANTAR FITUR

### 4.1 — Hapus Dokumen ≠ Reset Matching Score (KRITIS)

**Alur:** User upload CV → Diproses → `UserDocumentScore` dibuat → Matching score dihitung.  
**Masalah:** User hapus CV (`deleteDocument`) → `UserDocument` dihapus → `UserDocumentScore` **TIDAK** dihapus → Matching score masih menggunakan skor lama yang sudah tidak valid.

**Dampak:** Industri melihat kandidat dengan matching score tinggi padahal CV-nya sudah dihapus.

**Perbaikan:**
```php
// ProfileController::deleteDocument()
$document->delete();
// Tambahkan:
\App\Models\UserDocumentScore::where('document_id', $id)->delete();
// Invalidate cache matching score jika ada
```

---

### 4.2 — Lamaran Diterima (offered) tapi TPA Gagal — Status Tidak Konsisten

**Alur:** `status = offered` bisa terjadi setelah `tpa_status = failed`. Tidak ada validasi bahwa status lamaran harus konsisten dengan tpa_status.

**Masalah di `JobApplicationService::respondToOffer()`:** Ketika offer diterima, tidak ada cek apakah `tpa_status` adalah `passed`. Seorang kandidat yang gagal TPA bisa tetap menerima offer jika industri memilih untuk membuat offer manual.

**Rekomendasi:** Tambahkan warning/validasi di sisi industri jika mencoba membuat offer untuk kandidat yang `tpa_status = failed`.

---

### 4.3 — Penarikan Lamaran (withdraw) tidak Membatalkan Sesi TPA Aktif

**Lokasi:** `JobApplicationService::withdrawApplication()`

**Masalah:**
```php
$application->delete(); // Lamaran dihapus
event(new \App\Events\JobApplicationWithdrawn($applicationClone)); // Event
```
Tidak ada logic untuk menghapus atau menonaktifkan `TpaTestSession` yang aktif (`status = 'invited'` atau `'in_progress'`) yang terkait dengan lamaran yang ditarik. Akibatnya:
- User bisa tetap mengerjakan TPA walau lamarannya sudah ditarik.
- `TpaTestSession::job_application_id` merujuk ke record yang sudah tidak ada → potential orphan record dan error saat akses.

**Perbaikan di `JobApplicationWithdrawn` listener:**
```php
TpaTestSession::where('job_application_id', $application->id)
    ->whereIn('status', ['invited', 'in_progress'])
    ->update(['status' => 'cancelled']);
```

---

### 4.4 — Chat Agent tidak Mengetahui Konteks Fitur Baru (TPA Offline, Bidang Karir)

**Lokasi:** `ChatAgentService::getRoleMenus()` — baris 366-373

```php
'job_seeker' => 'Dashboard, Competency Assessment, Career Roadmap, Job Vacancies, Courses, Tes TPA, Profile, Notifications',
```
Fitur `Bidang Karir (Career Fields)` dan `Direct Chats` tidak tercantum dalam daftar menu yang diberikan ke AI. AI mungkin tidak bisa mengarahkan user ke fitur tersebut.

**Perbaikan:** Update daftar menu di semua role termasuk Chats, Career Fields, dll.

---

### 4.5 — Bottom Tab Bar tidak Sinkron dengan Sidebar untuk Role `teacher`

**Lokasi:** `app.blade.php` bottom nav section

**Masalah di Sidebar Teacher:** Terdapat menu `Dashboard, Courses, Classes, Submissions`.  
**Di Bottom Tab Bar Teacher:** Hanya ada `Dashboard, Kursus, Nilai`. Menu `Kelas` tidak ada di bottom tab bar.

---

## 5. FITUR YANG PERLU DIBANGUN UNTUK MENDUKUNG FITUR YANG ADA

### 5.1 — Notifikasi Push / Real-time untuk Chat Langsung (Direct Chat)

**Kebutuhan:** Fitur `DirectChatController` sudah ada, tapi tidak ada notifikasi real-time. User harus refresh halaman untuk melihat pesan baru.

**Rekomendasi:** Implementasi Laravel Echo + Pusher/Ably atau Server-Sent Events (SSE) untuk pesan real-time. Minimal, tambahkan polling setiap 30 detik menggunakan AJAX.

---

### 5.2 — Job Alert / Pemberitahuan Lowongan Baru

**Kebutuhan:** Tidak ada fitur notifikasi otomatis ketika ada lowongan baru yang cocok dengan profil user.

**Rekomendasi:**
- Buat scheduled command (`php artisan app:notify-new-jobs`) yang berjalan harian.
- Gunakan `JobMatchingService` untuk mencocokkan lowongan baru (dibuat dalam 24 jam terakhir) dengan user aktif.
- Kirim notifikasi Laravel ke user yang memiliki matching > 60%.

---

### 5.3 — Rate Limiting pada Endpoint Dokumen Upload

**Masalah:** Route upload dokumen sudah ada throttle (`throttle:10,1`) untuk CV dan Photo, tapi:
- `uploadDocuments` (multi-dokumen) tidak ada throttle eksplisit di route — hanya validasi `required|array`.
- Tidak ada validasi total ukuran batch.

**Rekomendasi:** Tambahkan throttle `throttle:5,1` di `profile.documents.upload` dan validasi total ukuran semua file dalam satu batch.

---

### 5.4 — Dashboard Admin: Monitoring Queue Job

**Kebutuhan:** Queue `ProcessDocumentsJob` berjalan di background tapi tidak ada dashboard untuk memantau:
- Berapa job yang pending/failed
- Waktu rata-rata processing
- Job yang stuck

**Rekomendasi:** Implementasi Horizon (jika Redis) atau buat endpoint admin sederhana yang menampilkan data dari tabel `jobs` dan `failed_jobs`.

---

### 5.5 — Fitur Expiry Reminder untuk Lowongan

**Masalah:** Tidak ada notifikasi ke industri bahwa lowongan mereka akan kadaluarsa dalam X hari. Lowongan yang expired langsung hilang dari listing tanpa pemberitahuan.

**Rekomendasi:** Buat scheduled command yang mengirim notifikasi 3 hari sebelum `expires_date`.

---

## 6. ERROR HANDLING — DATA SALING BERKORELASI

### 6.1 — `applyForJob()`: Tidak Ada Transaction

**Lokasi:** `JobApplicationService::applyForJob()` — baris 40-62

**Masalah:**
```php
$application->update([...]); // Step 1: update application
// Jika terjadi exception di sini, data sudah ter-update tapi tidak konsisten
return ['success' => true, ...]; // Step 2
```
Tidak ada `DB::transaction()`. Jika terjadi error di tengah proses (misalnya koneksi DB putus setelah update tapi sebelum response), data bisa terkunci di state yang tidak valid.

**Perbaikan:**
```php
return DB::transaction(function() use ($user, $jobId, $job) {
    $matchPercentage = $this->matchingService->calculateMatch($user, $job);
    UserJobApplication::create([...]);
    return ['success' => true, ...];
});
```

---

### 6.2 — `submitTest()` di TpaService: Tidak Ada Transaction

**Lokasi:** `TpaService::submitTest()` — baris 396

**Masalah:**
```php
$session->update(['status' => 'completed', ...]); // Step 1
$result = $this->calculateScore($session);         // Step 2: TpaResult::create
// Jika Step 2 gagal, session sudah 'completed' tapi result tidak ada
$application->update(['tpa_status' => ...]); // Step 3
```
Tiga operasi DB yang tidak di-wrap dalam transaction. Kegagalan di step 2 atau 3 menyebabkan data inkonsisten.

**Perbaikan:** Wrap seluruh method dalam `DB::transaction()`.

---

### 6.3 — `generateRoadmap()`: Tidak Ada Transaction saat Delete + Insert

**Lokasi:** `RoadmapService::generateRoadmap()` — baris 28-133

**Masalah:**
```php
$deleteQuery->delete(); // Hapus roadmap lama
// Jika terjadi error di bawah, roadmap sudah terhapus dan tidak diganti
foreach ($roadmaps as $item) {
    CareerRoadmap::create($createData); // Insert roadmap baru
}
```
Jika insert gagal di tengah loop, user tidak memiliki roadmap sama sekali.

**Perbaikan:**
```php
DB::transaction(function() use ($assessment, $deleteQuery, $roadmaps) {
    $deleteQuery->delete();
    foreach ($roadmaps as $item) {
        CareerRoadmap::create($createData);
    }
});
```

---

### 6.4 — `respondToOffer()`: Notifikasi Gagal tapi Tidak Di-log

**Lokasi:** `JobApplicationService::respondToOffer()` — baris 169-172

```php
$jobOwner = $application->jobListing->user;
if ($jobOwner) {
    $jobOwner->notify(new \App\Notifications\JobOfferResponseNotification(...));
    // Tidak ada try-catch di sini!
}
```
Jika notifikasi gagal (misal mailtrap down), exception akan propagate dan respons `accepted` bisa gagal total. Padahal update DB sudah berhasil.

**Perbaikan:**
```php
try {
    $jobOwner->notify(new JobOfferResponseNotification(...));
} catch (\Exception $e) {
    Log::warning('Gagal kirim notifikasi offer response', [
        'application_id' => $application->id,
        'error' => $e->getMessage()
    ]);
    // Jangan re-throw, biarkan alur berlanjut
}
```

---

## 7. SISTEM LOGGING YANG LEBIH DETAIL

### 7.1 — Log Performa (Performance Monitoring)

**Saat ini:** Hanya ada log error sporadis di beberapa controller. Tidak ada log performa sistematis.

**Rekomendasi: Buat Middleware `LogRequestPerformance`:**

```php
// app/Http/Middleware/LogRequestPerformance.php
class LogRequestPerformance
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = round((microtime(true) - $start) * 1000, 2); // ms

        if ($duration > 2000) { // Log jika > 2 detik
            Log::channel('performance')->warning('Slow Request Detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => auth()->id(),
                'duration_ms' => $duration,
                'timestamp' => now()->toDateTimeString(),
            ]);
        }

        return $response;
    }
}
```

**Config logging channel baru di `config/logging.php`:**
```php
'performance' => [
    'driver' => 'daily',
    'path' => storage_path('logs/performance.log'),
    'level' => 'debug',
    'days' => 30,
],
'security' => [
    'driver' => 'daily',
    'path' => storage_path('logs/security.log'),
    'level' => 'warning',
    'days' => 90,
],
'audit' => [
    'driver' => 'daily',
    'path' => storage_path('logs/audit.log'),
    'level' => 'info',
    'days' => 365,
],
```

---

### 7.2 — Log Audit Trail untuk Aksi Kritis

**Aksi yang perlu di-log:**

| Aksi | Channel | Level |
|------|---------|-------|
| User login/logout | `audit` | info |
| Hapus dokumen | `audit` | info |
| Update status lamaran | `audit` | info |
| Submit TPA | `audit` | info |
| Login gagal berulang | `security` | warning |
| Prompt injection detected | `security` | warning |
| Slow request > 2s | `performance` | warning |
| Queue job failed | `audit` | error |
| Matching score calculated (waktu) | `performance` | debug |

**Implementasi sederhana:**
```php
// app/Services/AuditLogService.php (Baru)
class AuditLogService
{
    public static function log(string $action, array $context = []): void
    {
        Log::channel('audit')->info($action, array_merge([
            'user_id'    => auth()->id(),
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp'  => now()->toIso8601String(),
        ], $context));
    }

    public static function security(string $event, array $context = []): void
    {
        Log::channel('security')->warning($event, array_merge([
            'user_id'    => auth()->id(),
            'ip'         => request()->ip(),
            'timestamp'  => now()->toIso8601String(),
        ], $context));
    }

    public static function performance(string $operation, float $durationMs, array $context = []): void
    {
        if ($durationMs > 1000) {
            Log::channel('performance')->warning("Slow: {$operation}", array_merge([
                'duration_ms' => $durationMs,
                'timestamp'   => now()->toIso8601String(),
            ], $context));
        }
    }
}
```

---

### 7.3 — Log DB Query Lambat (Slow Query Log)

**Rekomendasi: Tambahkan di `AppServiceProvider::boot()`:**

```php
if (config('app.debug') || app()->environment('staging')) {
    DB::listen(function ($query) {
        if ($query->time > 500) { // Query > 500ms
            Log::channel('performance')->warning('Slow DB Query', [
                'sql'      => $query->sql,
                'bindings' => $query->bindings,
                'time_ms'  => $query->time,
                'url'      => request()->url(),
            ]);
        }
    });
}
```

---

## RINGKASAN PRIORITAS PERBAIKAN

| No | Item | Prioritas | Dampak | Effort |
|----|------|-----------|--------|--------|
| 6.1 | Tambah DB::transaction di applyForJob | 🔴 Kritis | Data inkonsisten | Rendah |
| 6.2 | Tambah DB::transaction di submitTest | 🔴 Kritis | TPA result hilang | Rendah |
| 6.3 | Tambah DB::transaction di generateRoadmap | 🔴 Kritis | Roadmap terhapus tanpa ganti | Rendah |
| 4.1 | Hapus UserDocumentScore saat dokumen dihapus | 🔴 Kritis | Matching score tidak akurat | Rendah |
| 3.2 | Race condition di TPA auto-expire | 🟠 Tinggi | Duplikasi TPA result | Sedang |
| 1.1 | N+1 query di JobMatchingService | 🟠 Tinggi | Performa lambat | Sedang |
| 4.3 | Withdraw lamaran tidak cancel sesi TPA | 🟠 Tinggi | Orphan TPA sessions | Sedang |
| 7.1 | Implementasi performance logging | 🟡 Sedang | Visibilitas masalah | Sedang |
| 7.2 | Implementasi audit logging | 🟡 Sedang | Keamanan & compliance | Sedang |
| 1.2 | Cache CompanyDocumentWeight | 🟡 Sedang | Performa DB | Rendah |
| 6.4 | Try-catch notifikasi di respondToOffer | 🟡 Sedang | UX error | Rendah |
| 3.1 | Validasi duplikasi asesmen | 🟢 Rendah | Data quality | Rendah |
| 5.2 | Job Alert lowongan baru | 🟢 Rendah | Engagement | Tinggi |
| 3.4 | Roadmap skill groups lebih general | 🟢 Rendah | Kualitas roadmap | Sedang |

---

*Laporan ini dihasilkan berdasarkan analisis statis kode pada tanggal 22 Juni 2026. Pengujian dinamis (runtime testing) belum dilakukan dan disarankan sebagai langkah selanjutnya.*
