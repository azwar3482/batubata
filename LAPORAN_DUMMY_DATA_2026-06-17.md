# Laporan Dummy/Mock Data
## Aplikasi KOMPASKARIR (Batubata)
### Tanggal: 17 Juni 2026

---

## Daftar Isi

1. [Ringkasan](#1-ringkasan)
2. [Data Kritis (Produksi)](#2-data-kritis-produksi)
3. [Data Seeders](#3-data-seeders)
4. [Data Dummy/Fallback](#4-data-dummyfallback)
5. [Konfigurasi](#5-konfigurasi)
6. [File Duplikat](#6-file-duplikat)
7. [Rekomendasi](#7-rekomendasi)

---

## 1. Ringkasan

| Kategori | Jumlah | Severity |
|----------|--------|----------|
| Mock Auth System | 2 file | 🔴 Kritis |
| Database Seeders | 14 file | 🔴 Tinggi |
| Dummy Score Fallbacks | 3 file | 🟡 Sedang |
| Config Defaults | 2 file | 🟡 Sedang |
| Test Files | 10 file | 🟢 Normal |
| Placeholder Values | ~50+ | 🟢 Normal |
| File Duplikat | 1 file | 🟡 Sedang |

---

## 2. Data Kritis (Produksi)

### 2.1 Mock Authentication System

**File:** `app/Services/GoogleAuthService.php`
```php
// Line 77-102
public function getOrCreateMockUser(string $role): User
{
    $user = User::where('role', $role)->first();
    
    if (!$user) {
        $user = User::create([
            'name' => 'Mock Google User (' . $role . ')',
            'email' => 'mock.' . $role . '@google.com',
            // ...
        ]);
    }
    return $user;
}
```

**File:** `app/Http/Controllers/Auth/GoogleAuthController.php`
```php
// Line 88-98
protected function handleMockLogin()
{
    $role = session('social_role', 'job_seeker');
    $user = $this->googleAuthService->getOrCreateMockUser($role);
    Auth::login($user);
    return redirect()->route('dashboard')->with('status', 'Logged in via Mock Google...');
}
```

**Risiko:** Jika Google OAuth tidak dikonfigurasi, siapa saja bisa login tanpa credentials.

---

## 3. Data Seeders

### 3.1 KompskarirSeeder (446 baris)

| Tipe Data | Jumlah | Contoh |
|-----------|--------|--------|
| Admin | 1 | `admin@kompaskarir.id` / `password` |
| Job Seeker | 10 | `budi@seeker.com`, `andi@seeker.com`, etc. |
| Industry/HRD | 5 | `hrd@techcorp.com`, `hrd@bumn.id`, etc. |
| Education | 3 | `info@univdigital.ac.id`, etc. |
| Job Listings | 20 | Data lowongan dummy |
| Programs | 15 | Data program dummy |
| Assessments | 15 | Skor hardcoded |
| Job Applications | 20 | Status hardcoded |

**Password semua:** `password`

---

### 3.2 TestLolosApplicantSeeder

| Field | Value |
|-------|-------|
| Company | `PT Dummy Testing Lolos` |
| Email | `company_{random}@test.com` |
| Website | `https://dummytesting.com` |
| Pelamar | 30 user (`pelamar_lolos_{1-30}@test.com`) |
| Phone | `081234567{000-030}` |

---

### 3.3 TeacherSeeder

| Teacher | Email | Password |
|---------|-------|----------|
| Pak Budi Santoso | `teacher@batubata.test` | `password` |
| Ibu Sari Dewi | `teacher2@batubata.test` | `password` |

**Video URL:** `https://www.youtube.com/watch?v=dQw4w9WgXcQ` (Rick Roll)

---

### 3.4 TeacherCourseSeeder (837 baris)

| Teacher | Email | Password |
|---------|-------|----------|
| Pak Ahmad Fauzi | `ahmad.fauzi@kompaskarir.com` | `password` |
| Dr. Siti Nurhaliza | `siti.nurhaliza@kompaskarir.com` | `password` |
| Rizky Pratama | `rizky.pratama@kompaskarir.com` | `password` |
| Education | `info@bootcamp-nusantara.id` | `password` |

**Data Dummy:**
- LinkedIn: `https://linkedin.com/in/ahmad-fauzi-dev`
- Google Meet: `https://meet.google.com/abc-defg-hij`
- YouTube: `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
- Progress: 75%, 60%, 45%, 90%, 30%

---

### 3.5 RecruitmentTeamSeeder

| Staff | Pattern Email |
|-------|---------------|
| Rina HR Manager | `staf_{counter}_{company}@{company}.id` |
| Budi Recruiter | Same pattern |
| Dewi Sourcer | Same pattern |

**Password semua:** `password`

---

### 3.6 TpaSeeder (545 baris)

- 35+ soal TPA dengan jawaban hardcoded
- Default `created_by`: `1` (admin)

---

### 3.7 CourseSeeder

| Field | Contoh |
|-------|--------|
| URLs | `https://www.dicoding.com/academies/155` |
| URLs | `https://www.udemy.com/course/react-the-complete-guide/` |
| Rating | 4.8, 4.7, 4.9 |
| Reviews | 2350, 1890, 85000 |

---

### 3.8 ProgramSeeder

**Industry Partners:**
```php
['Tokopedia', 'Gojek', 'Traveloka']
['Bank Mandiri', 'BCA', 'Bukalapak']
```

---

### 3.9 DataRelationshipSeeder

- Google Meet: `https://meet.google.com/sql-batch-a1`
- Google Meet: `https://meet.google.com/flutter-batch-a1`
- Submission content hardcoded
- Feedback text hardcoded

---

### 3.10 ChatFaqSeeder (654 baris)

**Contact:** `support@kompaskarir.com`

---

### 3.11 SettingSeeder

**AI URL:** `http://localhost:5000`

---

### 3.12 CareerFieldSeeder

- Salary ranges hardcoded
- Skills hardcoded
- Certifications hardcoded

---

## 4. Data Dummy/Fallback

### 4.1 DocumentScoringService

**File:** `app/Services/DocumentScoringService.php:92-133`

```php
private function createInitialDummyScore($document)
{
    // Fallback scores
    $scores = [
        'cv' => 50.0,
        'ijazah' => 60.0,
        'transkrip' => 55.0,
        'sertifikat' => 65.0,
        'portofolio' => 50.0,
    ];
}
```

**Risiko:** Dokumen mendapat skor dummy jika AI tidak merespons.

---

### 4.2 ProcessDocumentsJob

**File:** `app/Jobs/ProcessDocumentsJob.php:76-84`

```php
// Fallback: Buat skor awal dummy jika AI tidak merespons
// Fallback ke skor dummy agar user tidak stuck di processing
```

---

### 4.3 TpaService

**File:** `app/Services/TpaService.php:106-123`

```php
// Untuk offline, buat dummy test jika tidak ada
$test = TpaTest::create([
    'title' => 'Tes TPA Offline',
    // ...
]);
```

---

## 5. Konfigurasi

### 5.1 Mail Config

**File:** `config/mail.php:114`
```php
'from' => ['address' => 'hello@example.com', 'name' => 'App Name'],
```

---

### 5.2 Services Config

**File:** `config/services.php`
```php
'ai' => [
    'endpoint' => env('AI_SERVICE_ENDPOINT', 'http://localhost:5000/analyze'),
],
'python_api' => [
    'url' => env('PYTHON_API_URL', 'http://localhost:5000/api'),
],
```

---

## 6. File Duplikat

### 6.1 GeminiService copy

**File:** `app/Services/GeminiService copy.php`

- Backup file dari GeminiService
- Berisi kode Xiaomi API yang dikomentari
- Menggunakan `env('XIAOMI_API_KEY')` langsung

---

## 7. Rekomendasi

### 🔴 Harus Dihapus Sebelum Produksi

| # | Item | File |
|---|------|------|
| 1 | Mock Login System | `GoogleAuthService.php`, `GoogleAuthController.php` |
| 2 | Semua Seeders | `database/seeders/*.php` (jangan jalankan di produksi) |
| 3 | File duplikat | `app/Services/GeminiService copy.php` |

### 🟡 Perlu Diganti dengan Data Real

| # | Item | Saat Ini | Ganti Dengan |
|---|------|----------|--------------|
| 1 | Dummy scores | Skor hardcoded 50-65 | Skor dari AI service |
| 2 | Config defaults | `localhost:5000` | URL server AI produksi |
| 3 | Mail config | `hello@example.com` | Email admin real |

### 🟢 Boleh Tetap Ada

| Item | Alasan |
|------|--------|
| Test files | Untuk testing, tidak di-deploy |
| Placeholder values | UX pattern yang normal |
| Factory | Untuk testing |

---

## Catatan

- **Jangan jalankan seeder di produksi** (`php artisan db:seed`)
- **Hapus atau nonaktifkan mock login** sebelum deploy
- **Ganti semua URL localhost** dengan URL produksi
- **File seeders tetap ada** di repository untuk development lokal

---

*Laporan ini dibuat pada 17 Juni 2026*
