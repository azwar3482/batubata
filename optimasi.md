# Laporan Optimasi Aplikasi Batubata
**Tanggal:** 23 Juni 2026
**Scope:** Kompressi file upload, optimasi asset berat, CDN audit

---

## Ringkasan Eksekutif

| Metrik | Sebelum | Sesudah | Penghematan |
|--------|---------|---------|-------------|
| Total logo di `public/` | ~3.65 MB | ~0.17 MB | **95.3%** |
| Foto profil storage | ~3.16 MB | ~1.12 MB | **64.6%** |
| Chart.js loading | SEMUA halaman | 7 halaman saja | ~85% halaman lebih ringan |
| Upload foto baru | Tanpa kompresi | Auto compress 80%+ | Otomatis |

---

## 1. Kompressi File Upload (IMPLEMENTED)

### Masalah
- Foto dan dokumen di-upload apa adanya tanpa kompresi
- Foto profil bisa 1-2 MB langsung tersimpan
- Tidak ada resize dimensi gambar

### Solusi yang Diterapkan

#### a. `FileCompressionService` (BARU)
**File:** `app/Services/FileCompressionService.php`

Fitur:
- **Auto-resize** gambar yang > 1200px (maintain aspect ratio)
- **Progressive quality reduction** - jika file masih > 500KB, kualitas diturunkan otomatis (80% → 70% → 60% → dst)
- **Format-aware** - mendukung JPEG, PNG, WebP
- **Logging** - setiap kompresi dicatat di log

#### b. Update `ProfileService`
**File:** `app/Services/ProfileService.php`

Semua method upload sekarang otomatis mengkompres gambar:
- `uploadDocument()` - foto profil, CV, dokumen
- `uploadDocuments()` - batch upload dokumen
- `uploadCustomDocument()` - dokumen custom

#### c. Config Kompressi
**File:** `config/compression.php`

```php
'max_width' => 1200,      // Lebar maksimum
'max_height' => 1200,     // Tinggi maksimum
'quality' => 80,           // Kualitas JPEG/WebP (0-100)
'photo_max_size_kb' => 500 // Target ukuran foto profil
```

---

## 2. Optimasi Logo Public (IMPLEMENTED)

### Masalah
| File | Sebelum | Masalah |
|------|---------|---------|
| `logo1.png` | 1.57 MB | Sangat besar, tidak ada yang pakai |
| `logo.png` | 675 KB | Duplikat |
| `logo - Copy.png` | 675 KB | Duplikat |
| `logo_v1.png` | 548 KB | Versi lama |
| `logo_.png` | 69 KB | Bisa dioptimasi |
| `images/logo_new.png` | 169 KB | Bisa dioptimasi |
| **TOTAL** | **~3.65 MB** | |

### Hasil Optimasi
| File | Sesudah | Hemat |
|------|---------|-------|
| `logo1.png` | 58 KB | 96.4% |
| `logo.png` | 25 KB | 96.3% |
| `logo - Copy.png` | 25 KB | 96.3% |
| `logo_v1.png` | 42 KB | 92.4% |
| `logo_.png` | 8 KB | 88.2% |
| `images/logo_new.png` | 15 KB | 91.0% |
| **TOTAL** | **~173 KB** | **95.3%** |

### Command
```bash
php artisan optimize:logos           # Jalankan kompresi
php artisan optimize:logos --dry-run # Preview tanpa mengubah
```

---

## 3. Kompressi Foto Existing (IMPLEMENTED)

### Masalah
Foto yang sudah di-upload sebelumnya tetap besar.

### Command
```bash
php artisan compress:existing-photos           # Kompres semua foto
php artisan compress:existing-photos --dry-run # Preview
```

### Hasil
- 3 file dikompres, total hemat ~2 MB
- Foto 717 KB → 116 KB (hemat 83.8%)

---

## 4. CDN Audit & Rekomendasi

### 4a. Chart.js - LOADED GLOBALLY (FIXED)

**Masalah:** `chart.js` (~200KB) dimuat di `layouts/app.blade.php` → semua halaman keberatan.

**Solusi:** Pindah ke `@push('head-scripts')` hanya di halaman yang pakai:
- `dashboard.blade.php` (job seeker)
- `industry/dashboard.blade.php`
- `education/dashboard.blade.php`
- `education/analytics.blade.php`
- `education/programs-report.blade.php`
- `admin/reports.blade.php`
- `assessment/result.blade.php` (sudah punya script sendiri)

**Dampak:** ~85% halaman tidak lagi memuat Chart.js = **hemat ~200KB per page load**

### 4b. Quill Editor (REKOMENDASI)

**Masalah:** Quill.js + CSS dimuat via CDN di ~20+ halaman.

**Status:** Masih menggunakan CDN. Tidak bisa di-bundle karena halaman yang pakai Quill sangat banyak.

**Rekomendasi masa depan:**
- Buat partial `@include('partials.quill')` agar konsisten
- Pertimbangkan lazy-load Quill hanya saat user klik area editor

### 4c. Tailwind CDN (PERLU DIPERBAIKI)

**Masalah:** `cdn.tailwindcss.com` dimuat via `<script>` di 3 halaman:
- `courses/certificate.blade.php`
- `courses/platform_certificate.blade.php`
- `seeker/tpa/test.blade.php`

Ini sangat berat (~300KB+), dan konflik dengan Tailwind yang sudah di-build via Vite.

**Rekomendasi:** Hapus `cdn.tailwindcss.com` dari halaman-halaman ini dan gunakan class yang sudah ada di build output, atau buat file CSS terpisah untuk kebutuhan khusus (misal: certificate print).

### 4d. Driver.js (TOUR GUIDE)

**Status:** Dimuat via CDN di 5 halaman (dashboard, admin dashboard, education dashboard, login, register).

**Rekomendasi:** Sudah cukup baik karena hanya dimuat di halaman yang membutuhkan. Pertimbangkan lazy-load.

### 4e. Google Fonts

**Status:** Dimuat di layout utama. Sudah menggunakan `preconnect` untuk optimasi.

**Rekomendasi:** Sudah optimal. Bisa ditambahkan `font-display: swap` jika belum.

---

## 5. Rekomendasi Lanjutan (BELUM DITERAPKAN)

### 5a. Hapus File Logo Tidak Terpakai
Beberapa logo mungkin sudah tidak dipakai:
```bash
# Cek mana yang dipakai di codebase
grep -r "logo1.png" resources/
grep -r "logo - Copy.png" resources/
grep -r "logo_v1.png" resources/
```
Jika tidak ada referensi, hapus file-nya.

### 5b. Implementasi `<picture>` dengan WebP
```html
<picture>
    <source srcset="{{ asset('photo.webp') }}" type="image/webp">
    <img src="{{ asset('photo.jpg') }}" alt="...">
</picture>
```

### 5c. Lazy Loading Images
```html
<img src="..." loading="lazy" alt="...">
```

### 5d. CDN Self-Hosting
Untuk production, pertimbangkan self-host library eksternal:
```bash
npm install chart.js quill driver.js
```
Lalu bundle via Vite. Ini menghilangkan dependency CDN.

---

## File yang Dibuat/Dimodifikasi

### File Baru
| File | Fungsi |
|------|--------|
| `app/Services/FileCompressionService.php` | Service kompressi gambar |
| `config/compression.php` | Konfigurasi kompresi |
| `app/Console/Commands/OptimizeLogos.php` | Artisan command kompresi logo |
| `app/Console/Commands/CompressExistingPhotos.php` | Artisan command kompresi foto existing |

### File Dimodifikasi
| File | Perubahan |
|------|-----------|
| `app/Services/ProfileService.php` | Inject FileCompressionService, auto-compress upload |
| `resources/views/layouts/app.blade.php` | Hapus Chart.js global, tambah `@stack('head-scripts')` |
| `resources/views/dashboard.blade.php` | Tambah Chart.js via `@push` |
| `resources/views/industry/dashboard.blade.php` | Tambah Chart.js via `@push` |
| `resources/views/education/dashboard.blade.php` | Tambah Chart.js via `@push` |
| `resources/views/education/analytics.blade.php` | Tambah Chart.js via `@push` |
| `resources/views/education/programs-report.blade.php` | Tambah Chart.js via `@push` |
| `resources/views/admin/reports.blade.php` | Tambah Chart.js via `@push` |

---

## Cara Penggunaan

### Upload Foto (Otomatis)
Tidak ada perubahan di UI. Kompresi berjalan otomatis saat upload.

### Kompresi Manual
```bash
# Kompres logo yang ada
php artisan optimize:logos

# Kompres foto yang sudah di-upload
php artisan compress:existing-photos

# Preview tanpa mengubah file
php artisan optimize:logos --dry-run
php artisan compress:existing-photos --dry-run
```

### Monitoring Log
Kompresi dicatat di `storage/logs/laravel.log`:
```
[INFO] Image compressed: photo.jpg {"original_size":"717 KB","compressed_size":"116 KB","reduction":"83.8%"}
```
