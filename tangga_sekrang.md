# Analisis Kepatuhan UU PDP — KOMPASKARIR
**Undang-Undang No. 27 Tahun 2022 tentang Perlindungan Data Pribadi**

**Tanggal:** 23 Juni 2026  
**Platform:** KOMPASKARIR (batubata) — Job Matching & Career Development  
**Scope:** Pengelolaan data pribadi job seeker

---

## 1. JENIS DATA PRIBADI YANG DIKELOLA

### 1.1 Data Pribadi Biasa
| Data | Tabel/Kolom | Kategori |
|------|-------------|----------|
| Nama lengkap | `users.name` | Identitas |
| Email | `users.email` | Kontak |
| Nomor telepon | `users.phone` | Kontak |
| Alamat | `users.address` | Lokasi |
| Tanggal lahir | `users.birth_date` | Identitas |
| Jenis kelamin | `users.gender` | Identitas |
| Foto profil | `user_documents` (type: photo) | Biometrik ringan |
| GPS (lat/long) | `users.latitude/longitude` | Geolokasi |
| IP address | `sessions.ip_address` | Teknis |
| User agent | `sessions.user_agent` | Teknis |
| Bio/Deskripsi diri | `users.bio` | Personal |

### 1.2 Data Pribadi Spesifik (Sensitif)
| Data | Tabel/Kolom | Kategori Sensitif |
|------|-------------|-------------------|
| Golongan darah | `users.blood_type` | **Data kesehatan** |
| Agama (jika tertera di CV) | `skill_analyses.cv_text` | Kepercayaan |
| Suku/etnis (jika tertera di CV) | `skill_analyses.cv_text` | Kepercayaan |
| Status perkawinan (jika tertera di CV) | `skill_analyses.cv_text` | Personal |
| Orientasi politik (jika tertera di CV) | `skill_analyses.cv_text` | Kepercayaan |
| Data biometrik (foto wajah) | `user_documents` (photo) | Biometrik |

### 1.3 Data Profesional/Akademik
| Data | Tabel/Kolom |
|------|-------------|
| Riwayat pendidikan | `users.education_level, major, graduation_year, institution_id` |
| Pengalaman kerja | `career_histories.*` |
| Keahlian/skills | `users.skills`, `user_document_scores.extracted_skills` |
| CV/Resume (file) | `user_documents` (type: cv) |
| Ijazah, Transkrip, Sertifikat | `user_documents` (various types) |
| Skor asesmen | `user_competency_scores.*` |
| Skor TPA | `tpa_results.*` |
| Embedding vector AI | `user_document_scores.skill_embedding_vector` |
| Teks CV penuh (ekstraksi) | `skill_analyses.cv_text` |

### 1.4 Data Komunikasi
| Data | Tabel/Kolom |
|------|-------------|
| Pesan chatbot AI | `chat_messages.content` |
| Pesan langsung | `direct_messages.message` |
| Catatan rekruter | `CandidateController@updateNotes` |

---

## 2. ANALISA KEPATUHAN TERHADAP UU PDP

### Pasal 3 — Prinsip Perlindungan Data Pribadi

| Prinsip | Status | Penjelasan |
|---------|--------|------------|
| **Keterbatasan tujuan** (purpose limitation) | ⚠️ SEBAGIAN | Data dikumpulkan untuk job matching, tapi juga digunakan untuk AI training, analytics, dan dibagikan ke institusi pendidikan tanpa kontrol granular |
| **Pembatasan pengumpulan** (data minimization) | ❌ TIDAK PATUH | `blood_type` (data kesehatan) tidak relevan untuk job matching. `cv_text` menyimpan seluruh teks CV termasuk data sensitif yang tidak perlu |
| **Pembatasan penggunaan** | ⚠️ SEBAGIAN | Tidak ada mekanisme pembatasan siapa yang bisa melihat data apa |
| **Akurasi** | ✅ PATUH | User bisa update profil kapan saja |
| **Akuntabilitas** | ❌ TIDAK PATUH | Tidak ada DPO (Data Protection Officer), tidak ada audit log akses data |
| **Integritas & kerahasiaan** | ⚠️ SEBAGIAN | Password di-hash, tapi data sensitif lain (phone, address, blood_type) **tidak dienkripsi** di database |
| **Penyimpanan terbatas** (storage limitation) | ❌ TIDAK PATUH | Tidak ada kebijakan retensi data otomatis. Chat, session, dan data lama disimpan tanpa batas waktu |
| **Perlindungan hukum yang sah** (lawful basis) | ⚠️ SEBAGIAN | Mengandalkan "consent by use" (dengan menggunakan layanan...), bukan consent eksplisit |

---

### Pasal 9 — Persetujuan (Consent)

| Aspek | Status | Masalah |
|-------|--------|---------|
| Consent eksplisit saat registrasi | ❌ TIDAK ADA | Tidak ada checkbox consent untuk pemrosesan data |
| Consent untuk data sensitif | ❌ TIDAK ADA | `blood_type`, foto, GPS tidak minta consent terpisah |
| Catatan consent (consent log) | ❌ TIDAK ADA | Tidak ada record kapan user menyetujui apa |
| Pencabutan consent | ❌ TIDAK ADA | Tidak ada mekanisme untuk menolak pemrosesan tertentu tanpa hapus akun |
| Consent untuk berbagi data ke industri | ❌ TIDAK ADA | Saat apply job, semua data langsung dibagikan tanpa konfirmasi |
| Cookie consent | ❌ TIDAK ADA | Tidak ada cookie consent banner |

**Pasal 9 ayat (1):** _"Persetujuan Pemilik Data Pribadi merupakan dasar yang sah dalam pemrosesan Data Pribadi"_

---

### Pasal 13-14 — Data Pribadi Spesifik

**Masalah KRITIS:**

1. **`blood_type` (golongan darah)** — Ini adalah **data kesehatan** yang termasuk kategori data pribadi spesifik (Pasal 4 ayat 2). Pengumpulan data ini **tidak memiliki justifikasi** untuk platform job matching.

2. **Foto wajah** — Termasuk data biometrik. Harus ada consent khusus dan justifikasi yang jelas.

3. **Teks CV penuh** (`skill_analyses.cv_text`) — CV mungkin berisi informasi agama, suku, status perkawinan, dll. yang merupakan data spesifik. Harus ada filtering/anonymization.

---

### Pasal 16 — Hak-Hak Pemilik Data Pribadi

| Hak | Status | Penjelasan |
|-----|--------|------------|
| **Hak akses** (mendapat salinan data) | ❌ BELUM ADA | Tidak ada fitur download/export data pribadi user |
| **Hak koreksi** | ✅ ADA | User bisa edit profil |
| **Hak penghapusan** | ✅ ADA | `ProfileController@destroy` menghapus akun dan file |
| **Hak pembatasan pemrosesan** | ❌ BELUM ADA | Tidak ada cara membatasi data tertentu dari proses tertentu |
| **Hak keberatan** | ❌ BELUM ADA | Tidak ada mekanisme keberatan terhadap pemrosesan tertentu |
| **Hak portabilitas** | ❌ BELUM ADA | Tidak ada export data dalam format terstruktur (JSON/CSV) |
| **Hak tidak tunduk pada keputusan otomatis** | ⚠️ SEBAGIAN | Matching score menggunakan AI otomatis, tapi user tidak bisa minta review manual |

---

### Pasal 20 — Pemindahan Data ke Luar Negeri

**Masalah:**
- Google OAuth → data dikirim ke server Google (AS)
- Google Gemini AI → konten chat dikirim ke Google untuk diproses
- SentenceTransformer embeddings → diproses di Python service

**Kewajiban (Pasal 20):**
> Pemindahan Data Pribadi ke luar wilayah Indonesia hanya dapat dilakukan apabila negara tujuan memiliki tingkat perlindungan yang setara.

**Status:** ❌ TIDAK ADA mekanisme untuk memverifikasi bahwa Google atau pihak ketiga lain memiliki perlindungan yang memadai.

---

### Pasal 24 — Penunjukan DPO (Data Protection Officer)

> Pengendali Data Pribadi yang memproses data pribadi lebih dari 2.500 subjek data wajib menunjuk DPO.

**Status:** ❌ TIDAK ADA  
Dengan jumlah job seeker yang mendaftar, KOMPASKARIR kemungkinan besar wajib menunjuk DPO.

---

### Pasal 46-47 — Notifikasi Pelanggaran

> Dalam hal terjadi kegagalan perlindungan Data Pribadi, Pengendali wajib memberitahukan kepada subjek data pribadi dan otoritas dalam waktu **3×24 jam**.

**Status:** ❌ TIDAK ADA mekanisme notifikasi pelanggaran data (data breach notification).

---

### Pasal 67-68 — Sanksi

| Pelanggaran | Sanksi Administratif | Sanksi Pidana |
|-------------|---------------------|---------------|
| Pelanggaran prinsip PDP | Denda maks **2%** dari pendapatan tahunan | - |
| Tidak memberitahukan pelanggaran | Denda administratif | **Pidana penjara** maks 2 tahun |
| Memperoleh/mengungkapkan data secara melawan hukum | - | **Pidana penjara** maks 5 tahun |

---

## 3. RINGKASAN TEMUAN Kritis

### 🔴 KRITIS (Harus Segera Diperbaiki)

| No | Temuan | Pasal UU PDP | Risiko |
|----|--------|--------------|--------|
| 1 | **Tidak ada consent eksplisit** — registrasi dan pengisian profil tanpa checkbox consent | Pasal 9 | Consent tidak valid secara hukum |
| 2 | **Tidak ada cookie consent** | Pasal 9 | Pelanggaran consent |
| 3 | **Golongan darah (`blood_type`) dikumpulkan tanpa justifikasi** — data kesehatan sensitif | Pasal 13-14 | Pengumpulan data spesifik tanpa dasar hukum |
| 4 | **Data sensitif tidak dienkripsi** — phone, address, birth_date, blood_type, GPS tersimpan plaintext | Pasal 13, 35 | Risiko kebocoran data |
| 5 | **Tidak ada DPO** | Pasal 24 | Kewajiban hukum tidak dipenuhi |
| 6 | **Tidak ada data export/portability** | Pasal 16(1) | Hak subjek data tidak terpenuhi |
| 7 | **Tidak ada data breach notification mechanism** | Pasal 46-47 | Kewajiban hukum tidak terpenuhi |

### 🟠 TINGGI (Harus Diperbaiki dalam 1-3 Bulan)

| No | Temuan | Pasal UU PDP | Risiko |
|----|--------|--------------|--------|
| 8 | **Tidak ada audit log** akses data pribadi oleh pihak lain (industri, institusi) | Pasal 3 (akuntabilitas) | Tidak bisa buktikan kepatuhan |
| 9 | **Data sharing tanpa kontrol granular** — apply job = kirim semua data ke industri | Pasal 3, 16 | Data berlebih dibagikan |
| 10 | **Tidak ada kebijakan retensi data otomatis** | Pasal 3 (storage limitation) | Data disimpan tanpa batas |
| 11 | **`cv_text` menyimpan seluruh teks CV** termasuk data sensitif | Pasal 13-14 | Data spesifik terproses tanpa consent |
| 12 | **Transfer data ke Google tanpa verifikasi perlindungan** | Pasal 20 | Pemindahan data ke luar negeri tanpa jaminan |

### 🟡 SEDANG (Perlu Direncanakan)

| No | Temuan | Pasal UU PDP | Risiko |
|----|--------|--------------|--------|
| 13 | **Tidak ada mekanisme keberatan** (objection to processing) | Pasal 16(3) | Hak subjek data tidak terpenuhi |
| 14 | **Tidak ada pembatasan pemrosesan** (restriction) | Pasal 16(2) | Hak subjek data tidak terpenuhi |
| 15 | **AI matching score tanpa right to human review** | Pasal 16 | Keputusan otomatis tanpa intervensi manusia |
| 16 | **Google provider_id disimpan permanen** | Pasal 3 (storage limitation) | Data pihak ketiga tanpa retensi |

---

## 4. REKOMENDASI PERBAIKAN (Berdasarkan Prioritas)

### TAHAP 1: Kepatuhan Dasar (Minggu 1-2)

#### 4.1 Implementasi Consent Management
```
File yang perlu dibuat/diubah:
- app/Http/Controllers/Auth/RegisteredUserController.php
- app/Models/Consent.php (baru)
- database/migrations/..._create_consents_table.php (baru)
- resources/views/auth/register.blade.php
- resources/views/profile/partials/consent-form.blade.php (baru)
```

**Yang perlu dilakukan:**
1. Tambahkan checkbox consent di form registrasi:
   - ☑ Saya menyetujui Kebijakan Privasi dan Syarat & Ketentuan
   - ☑ Saya menyetujui pemrosesan data pribadi saya untuk tujuan job matching
   - ☑ (Opsional) Saya menyetujui berbagi data dengan perusahaan yang saya lamar
2. Buat tabel `consents` untuk mencatat:
   - `user_id`, `consent_type`, `consent_version`, `ip_address`, `granted_at`, `revoked_at`
3. Tambahkan cookie consent banner di frontend

#### 4.2 Hapus atau Batasi `blood_type`
```
File: database/migrations/..._remove_blood_type_from_users.php (baru)
```
- **Rekomendasi:** Hapus field `blood_type` dari database
- Jika tetap diperlukan, pastikan ada consent khusus untuk data kesehatan (Pasal 14)

#### 4.3 Enkripsi Data Sensitif
```
File: app/Models/User.php
```
Tambahkan encrypted cast untuk field sensitif:
```php
protected $casts = [
    'phone' => 'encrypted',
    'address' => 'encrypted',
    'birth_date' => 'encrypted:date',
    'blood_type' => 'encrypted',
    'latitude' => 'encrypted:decimal:8',
    'longitude' => 'encrypted:decimal:8',
];
```
**Catatan:** Perlu migrasi data untuk mengenkripsi data yang sudah ada.

#### 4.4 Data Breach Response Plan
```
File baru:
- app/Services/DataBreachService.php
- app/Notifications/DataBreachNotification.php
- config/data-breach.php
```

---

### TAHAP 2: Hak Subjek Data (Minggu 3-4)

#### 4.5 Implementasi Data Export (Right to Portability)
```
File baru:
- app/Http/Controllers/DataRightsController.php
- app/Services/DataExportService.php
- resources/views/data-rights/export.blade.php
```
Export harus mencakup:
- Semua data profil (JSON)
- Semua dokumen (file download)
- Riwayat lamaran
- Skor asesmen dan TPA
- Riwayat chat (opsional)

#### 4.6 Implementasi Data Restriction & Objection
```
File: app/Http/Controllers/DataRightsController.php
```
Tambahkan fitur:
- Batasi data tertentu dari proses tertentu
- Tolak pemrosesan untuk tujuan analitik/AI
- Keberatan terhadap keputusan otomatis (matching score)

#### 4.7 Anonymization Pipeline
```
File baru:
- app/Services/DataAnonymizationService.php
- app/Jobs/AnonymizeOldDataJob.php
```
- Filter data sensitif dari `cv_text` sebelum disimpan
- Anonimkan data lama yang sudah tidak relevan
- Buat scheduled job untuk pembersihan otomatis

---

### TAHAP 3: Tata Kelola & Pelaporan (Minggu 5-8)

#### 4.8 Penunjukan DPO
- Identifikasi atau rekrut DPO
- Publikasikan kontak DPO di privacy policy
- Daftarkan DPO ke Kominfo

#### 4.9 Audit Trail & Logging
```
File: app/Services/AuditLogService.php (sudah direkomendasikan di audit sebelumnya)
```
Log akses data pribadi:
- Siapa yang mengakses data siapa
- Kapan dan dari IP mana
- Data apa yang diakses/diubah/dihapus

#### 4.10 Data Retention Policy
```
File baru:
- app/Jobs/EnforceRetentionPolicyJob.php
- config/data-retention.php
```

| Data Type | Retention Period | Action After |
|-----------|-----------------|--------------|
| Akun aktif | Selama aktif | - |
| Akun nonaktif > 2 tahun | 2 tahun | Hapus/anonimkan |
| Chat messages | 1 tahun | Hapus |
| Session data | 30 hari | Hapus |
| Audit logs | 3 tahun | Arsip |
| Dokumen dihapus | 30 hari (soft delete) | Hapus permanen |

#### 4.11 Transfer Impact Assessment (TIA)
Untuk pihak ketiga (Google OAuth, Google Gemini, dll):
- Buat dokumen TIA
- Verifikasi level perlindungan di negara tujuan
- Implementasi Standard Contractual Clauses (SCC) jika diperlukan

---

### TAHAP 4: Penyempurnaan (Bulan 3-6)

#### 4.12 Granular Data Sharing Controls
```
File: app/Http/Controllers/DashboardController.php (applyJob)
```
Saat apply job, tampilkan pilihan:
- ☑ Bagikan profil dasar
- ☑ Bagikan CV
- ☑ Bagikan skor asesmen
- ☑ Bagikan data pendidikan
- Jangan bagikan: golongan darah, data kesehatan

#### 4.13 Privacy by Design di Codebase
- Implementasi `PrivacyFilter` middleware
- Buat `DataClassification` enum untuk kategorisasi data
- Tambahkan annotation/decorator untuk field sensitif
- Implementasi `PurposeBinding` service

#### 4.14 Update Privacy Policy
```
File: resources/views/legal/privacy-policy.blade.php
```
Tambahkan:
- Dasar hukum pemrosesan (Pasal 9 UU PDP)
- Rincian data spesifik yang dikumpulkan dan alasannya
- Mekanisme penggunaan hak subjek data
- Informasi DPO
- Prosedur penanganan keluhan
- Kebijakan retensi data yang spesifik

---

## 5. CEKLIS KEPATUHAN UU PDP

| No | Kewajiban | Status | Prioritas |
|----|-----------|--------|-----------|
| 1 | Dasar hukum pemrosesan (consent) | ❌ | 🔴 |
| 2 | Perlindungan data spesifik | ❌ | 🔴 |
| 3 | Penunjukan DPO | ❌ | 🔴 |
| 4 | Hak akses data | ❌ | 🔴 |
| 5 | Hak koreksi | ✅ | - |
| 6 | Hak penghapusan | ✅ | - |
| 7 | Hak portabilitas | ❌ | 🟠 |
| 8 | Hak pembatasan pemrosesan | ❌ | 🟠 |
| 9 | Hak keberatan | ❌ | 🟠 |
| 10 | Hak atas keputusan otomatis | ⚠️ | 🟡 |
| 11 | Notifikasi pelanggaran | ❌ | 🔴 |
| 12 | Audit log | ❌ | 🟠 |
| 13 | Kebijakan retensi | ❌ | 🟠 |
| 14 | Enkripsi data at rest | ❌ | 🔴 |
| 15 | Transfer impact assessment | ❌ | 🟠 |
| 16 | Privacy by design | ❌ | 🟡 |
| 17 | Record of processing activities | ❌ | 🟡 |

---

## 6. ESTIMASI UPAYA

| Tahap | Durasi | Prioritas |
|-------|--------|-----------|
| Tahap 1: Kepatuhan Dasar | 2 minggu | 🔴 Kritis |
| Tahap 2: Hak Subjek Data | 2 minggu | 🟠 Tinggi |
| Tahap 3: Tata Kelola | 4 minggu | 🟠 Tinggi |
| Tahap 4: Penyempurnaan | 3 bulan | 🟡 Sedang |

---

## 7. REFERENSI HUKUM

1. **UU No. 27 Tahun 2022** tentang Perlindungan Data Pribadi
2. **PP No. 71 Tahun 2019** tentang Penyelengsaraan Sistem dan Transaksi Elektronik
3. **Permenkominfo No. 20 Tahun 2016** tentang Perlindungan Data Pribadi dalam Sistem Elektronik
4. **UU No. 11 Tahun 2008** tentang Informasi dan Transaksi Elektronik (UU ITE)
5. **Peraturan BSSN No. 8 Tahun 2020** tentang Sistem Manajemen Pengamanan Informasi

---

*Analisis ini berdasarkan review kode sumber pada 23 Juni 2026. Diperlukan review hukum oleh praktisi hukum yang kompeten untuk implementasi yang tepat.*

**Kontak DPO (belum ditunjuk):** -  
**Kontak terkait privasi:** privacy@kompaskarir.id
