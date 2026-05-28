Saya sudah memahami sepenuhnya! Berdasarkan proposal **KOMPASKARIR** yang telah kita susun, berikut adalah **2 prompt lengkap dan detail** untuk membangun aplikasi:

---

## 📋 **PROMPT 1: WEBSITE (LARAVEL)**

```
# SPESIFIKASI PENGEMBANGAN PLATFORM KOMPASKARIR - WEB BASED

## INFORMASI UMUM PROYEK
Nama Platform    : KOMPASKARIR (Kompas Karir - Skill Gap Advisor)
Tema             : Digitalisasi Penciptaan Lapangan Kerja
Teknologi Utama  : Laravel 10/11 (Modular Monolith Architecture)
Database         : MySQL 8.0+
Frontend         : Laravel Blade + Livewire/Alpine.js + Tailwind CSS
Backend API      : Laravel Sanctum untuk autentikasi API
Server           : Nginx + PHP 8.2+
Cloud            : AWS/GCP (untuk deployment)

## DESKRIPSI PLATFORM
KOMPASKARIR adalah platform digital yang berfungsi sebagai "Skill Gap Advisor" 
untuk menjembatani kesenjangan kompetensi antara lulusan pendidikan dan kebutuhan 
industri digital. Platform menganalisis skill gap pengguna dan memberikan rekomendasi 
upskilling yang dipersonalisasi berbasis data real-time.

## FITUR UTAMA YANG HARUS DIBANGUN

### 1. SISTEM AUTENTIKASI & AUTHORIZASI
- Multi-role authentication (Job Seeker, Industry/HRD, Educational Institution, Admin)
- Registrasi dengan email verification
- Login dengan remember me
- Forgot password & reset password
- Profile management dengan upload foto & CV
- Role-Based Access Control (RBAC)

### 2. DASHBOARD PENGGUNA (JOB SEEKER)
- Welcome card dengan nama pengguna
- Statistik ringkas:
  * Total skill yang dinilai
  * Persentase skill gap rata-rata
  * Progress upskilling
  * Jumlah rekomendasi kursus
- Grafik radar (Radar Chart) untuk visualisasi kompetensi:
  * Sumbu: Komunikasi, Teknis, Digital, Leadership, Bahasa
  * 2 layer: Skill saat ini (solid) vs Target industri (dashed)
- Progress bar untuk setiap kategori skill dengan label gap (%)
- Quick access ke: Asesmen, Rekomendasi, Roadmap Karir
- Notifikasi progress belajar

### 3. MODUL ASESMEN KOMPETENSI
Form asesmen dengan kategori:
A. Data Diri & Target Karir
   - Pilih posisi target (Digital Marketing Specialist, Data Analyst, dll)
   - Tingkat pendidikan
   - Pengalaman kerja

B. Self-Assessment Skill Teknis (Skala 1-5)
   - Google Analytics
   - SEO/SEM
   - Content Management
   - Social Media Advertising
   - Email Marketing
   - Data Analysis
   - Programming (Python/SQL)
   - Dan lain-lain sesuai posisi

C. Soft Skill Assessment (Skala 1-5)
   - Komunikasi Efektif
   - Teamwork & Kolaborasi
   - Problem Solving
   - Critical Thinking
   - Adaptabilitas
   - Leadership

D. Upload Portofolio (opsional)
   - Link GitHub/Behance
   - Upload CV PDF
   - Link LinkedIn

### 4. SISTEM ANALISIS SKILL GAP (INTEGRASI AI)
- Endpoint API untuk mengirim data asesmen ke modul Python AI
- Modul AI melakukan:
  * NLP processing untuk ekstrak skill dari CV & job description
  * Cosine Similarity untuk hitung jarak antara skill user vs standar industri
  * Content-Based Filtering untuk rekomendasi
- Tampilkan hasil analisis:
  * Skill gap per kategori (dalam %)
  * Prioritas skill yang harus dipelajari
  * Level kompetensi saat ini vs target

### 5. REKOMENDASI UPSKILLING PERSONAL
- Daftar kursus yang direkomendasikan berdasarkan skill gap
- Setiap rekomendasi menampilkan:
  * Nama kursus (contoh: "Data Analytics Fundamentals")
  * Platform penyedia (Coursera, Dicoding, Udemy, dll)
  * Durasi (contoh: "8 jam")
  * Level (Beginner/Intermediate/Advanced)
  * Link ke kursus
  * Priority badge (High/Medium/Low)
- Filter berdasarkan:
  * Kategori skill
  * Durasi
  * Platform
  * Level kesulitan
- Fitur "Mark as Completed" untuk tracking progress

### 6. ROADMAP KARIR INTERAKTIF
- Timeline visual 6 bulan dengan milestones:
  * Bulan 1: Selesaikan modul Python dasar
  * Bulan 2: Bangun portfolio analisis data
  * Bulan 3: Ikuti simulasi sprint Scrum
  * Bulan 4: Presentasi hasil proyek
  * Bulan 5: Dampingi junior/mini-project
  * Bulan 6: Evaluasi & rencana lanjutan
- Checklist progress untuk setiap milestone
- Estimasi waktu penyelesaian
- Download roadmap dalam format PDF

### 7. JOB MATCHING & LOWONGAN KERJA
- Integrasi API eksternal (JobStreet, Glints, LinkedIn)
- Tampilkan lowongan yang sesuai dengan skill user
- Matching percentage antara profil user dan requirement lowongan
- Filter lowongan:
  * Posisi
  * Lokasi (Remote/Hybrid/On-site)
  * Salary range
  * Experience level
- Fitur "Apply Now" (redirect ke platform asli)
- Simpan lowongan favorit

### 8. DASHBOARD INDUSTRI/HRD
- Post lowongan kerja dengan requirement skill yang detail
- Lihat database talenta yang sudah terverifikasi skill-nya
- Search & filter kandidat berdasarkan:
  * Skill yang dimiliki
  * Level kompetensi
  * Pendidikan
  * Pengalaman
- Download laporan kompetensi kandidat
- Statistik rekrutmen

### 9. DASHBOARD INSTITUSI PENDIDIKAN
- Lihat data agregat kompetensi lulusan
- Analisis skill gap rata-rata per jurusan
- Rekomendasi penyesuaian kurikulum
- Export data untuk akreditasi
- Kolaborasi dengan industri

### 10. ADMIN PANEL
- User management (CRUD semua user)
- Kelola database kompetensi (CRUD skill standar)
- Kelola kategori posisi karir
- Moderasi konten kursus
- View analytics platform:
  * Total pengguna
  * Total asesmen
  * Rata-rata skill gap
  * Top skill yang diminati
  * Placement rate
- Generate laporan sistem

### 11. GENERATE LAPORAN PDF
- Laporan hasil asesmen kompetensi profesional dengan:
  * Header logo KOMPASKARIR
  * Data pengguna
  * Tabel ringkasan skill gap
  * Grafik radar
  * Rekomendasi personalisasi
  * Roadmap karir timeline
  * QR code untuk verifikasi
- Download & share functionality

### 12. NOTIFIKASI & ALERT
- Email notification untuk:
  * Hasil asesmen selesai
  * Rekomendasi kursus baru
  * Reminder progress belajar
  * Lowongan kerja yang match
- In-app notification center
- Browser push notification

## STRUKTUR DATABASE (TABEL UTAMA)

### users
- id (bigint, PK)
- name (varchar)
- email (varchar, unique)
- password (varchar)
- role (enum: job_seeker, industry, education, admin)
- phone (varchar, nullable)
- photo (varchar, nullable)
- education_level (varchar)
- major (varchar, nullable)
- experience_years (integer, default 0)
- email_verified_at (timestamp, nullable)
- created_at, updated_at

### positions
- id (bigint, PK)
- name (varchar) - contoh: "Digital Marketing Specialist"
- description (text)
- category (varchar)
- created_at, updated_at

### competencies
- id (bigint, PK)
- code (varchar, unique) - contoh: "DM-001"
- name (varchar) - contoh: "Google Analytics"
- category (enum: technical, soft_skill)
- position_id (bigint, FK to positions)
- min_level_required (integer 1-5)
- source_reference (varchar) - contoh: "BNSP, LinkedIn Jobs"
- created_at, updated_at

### user_assessments
- id (bigint, PK)
- user_id (bigint, FK to users)
- position_id (bigint, FK to positions)
- assessment_date (timestamp)
- total_gap_percentage (decimal)
- status (enum: draft, completed)
- created_at, updated_at

### user_competency_scores
- id (bigint, PK)
- assessment_id (bigint, FK to user_assessments)
- competency_id (bigint, FK to competencies)
- self_assessed_level (integer 1-5)
- ai_analyzed_level (integer 1-5, nullable)
- gap_percentage (decimal)
- priority (enum: high, medium, low)
- created_at, updated_at

### courses
- id (bigint, PK)
- title (varchar)
- description (text)
- platform (varchar) - contoh: "Coursera", "Dicoding"
- category (varchar)
- competency_id (bigint, FK to competencies)
- duration_hours (integer)
- level (enum: beginner, intermediate, advanced)
- url (varchar)
- price (decimal, nullable)
- is_free (boolean)
- created_at, updated_at

### user_course_progress
- id (bigint, PK)
- user_id (bigint, FK to users)
- course_id (bigint, FK to courses)
- status (enum: not_started, in_progress, completed)
- started_at (timestamp, nullable)
- completed_at (timestamp, nullable)
- progress_percentage (integer, default 0)
- created_at, updated_at

### career_roadmaps
- id (bigint, PK)
- user_id (bigint, FK to users)
- position_id (bigint, FK to positions)
- month_number (integer 1-6)
- milestone_title (varchar)
- milestone_description (text)
- is_completed (boolean, default false)
- completed_at (timestamp, nullable)
- created_at, updated_at

### job_listings
- id (bigint, PK)
- external_id (varchar, nullable) - ID dari JobStreet/Glints
- source_platform (varchar)
- title (varchar)
- company_name (varchar)
- location (varchar)
- work_type (enum: remote, hybrid, onsite)
- salary_min (decimal, nullable)
- salary_max (decimal, nullable)
- experience_required (varchar)
- description (text)
- required_skills (json)
- application_url (varchar)
- posted_date (date)
- expires_date (date)
- is_active (boolean, default true)
- created_at, updated_at

### user_job_applications
- id (bigint, PK)
- user_id (bigint, FK to users)
- job_listing_id (bigint, FK to job_listings)
- matching_percentage (decimal)
- applied_at (timestamp)
- status (enum: saved, applied, interviewed, offered, rejected)
- notes (text, nullable)
- created_at, updated_at

### notifications
- id (bigint, PK)
- user_id (bigint, FK to users)
- type (varchar)
- title (varchar)
- message (text)
- data (json, nullable)
- read_at (timestamp, nullable)
- created_at, updated_at

### institutions
- id (bigint, PK)
- user_id (bigint, FK to users)
- name (varchar)
- type (enum: university, polytechnic, vocational_school)
- address (text)
- accreditation (varchar)
- created_at, updated_at

### companies
- id (bigint, PK)
- user_id (bigint, FK to users)
- name (varchar)
- industry (varchar)
- size (varchar)
- website (varchar, nullable)
- created_at, updated_at

## API ENDPOINTS YANG DIBUTUHKAN

### Authentication
POST   /api/register
POST   /api/login
POST   /api/logout
POST   /api/forgot-password
POST   /api/reset-password
GET    /api/user/profile
PUT    /api/user/profile
POST   /api/user/upload-cv

### Assessments
GET    /api/assessments/positions - List semua posisi
POST   /api/assessments/start - Mulai asesmen baru
POST   /api/assessments/submit - Submit hasil asesmen
GET    /api/assessments/history - Riwayat asesmen
GET    /api/assessments/{id}/results - Hasil detail asesmen

### Skill Gap Analysis
POST   /api/skill-gap/analyze - Trigger AI analysis
GET    /api/skill-gap/results/{assessment_id}

### Recommendations
GET    /api/recommendations/courses - Rekomendasi kursus
GET    /api/recommendations/skills - Skill yang harus dipelajari
POST   /api/recommendations/mark-complete

### Roadmap
GET    /api/roadmap/generate - Generate roadmap karir
GET    /api/roadmap/my-roadmap
PUT    /api/roadmap/milestone/{id}/complete

### Jobs
GET    /api/jobs - List lowongan (dengan filter)
GET    /api/jobs/{id} - Detail lowongan
POST   /api/jobs/{id}/save - Simpan lowongan
POST   /api/jobs/{id}/apply - Apply lowongan
GET    /api/jobs/my-applications

### Courses
GET    /api/courses - List kursus
GET    /api/courses/{id} - Detail kursus
POST   /api/courses/{id}/enroll
GET    /api/courses/my-progress

### Reports
GET    /api/reports/assessment/{id}/pdf - Generate PDF laporan
GET    /api/reports/competency-summary

### Notifications
GET    /api/notifications
PUT    /api/notifications/{id}/read
PUT    /api/notifications/read-all

### Admin
GET    /api/admin/statistics
GET    /api/admin/users
PUT    /api/admin/users/{id}/role
GET    /api/admin/competencies
POST   /api/admin/competencies
PUT    /api/admin/competencies/{id}
DELETE /api/admin/competencies/{id}

## INTEGRASI EKSTERNAL

### 1. Python AI Module (Microservice)
- Endpoint: http://ai-module:5000/analyze
- Method: POST
- Request Body:
  {
    "user_cv_text": "...",
    "user_assessment": {...},
    "target_position": "..."
  }
- Response:
  {
    "skill_gap": {...},
    "recommendations": [...],
    "matching_scores": {...}
  }

### 2. JobStreet API
- Fetch job listings secara berkala (cron job setiap 6 jam)
- Sync required skills
- Update job status

### 3. Glints API
- Fetch job listings
- Get company information
- Salary benchmark data

### 4. BNSP API (jika tersedia)
- Get competency standards
- Verify certification schemes
- Update skill database

### 5. Email Service (SMTP/SendGrid/Mailgun)
- Transactional emails
- Newsletter
- Notifications

### 6. PDF Generation (DomPDF/Snappy)
- Generate laporan asesmen
- Generate sertifikat
- Generate roadmap

## TOOL & LIBRARY YANG DIBUTUHKAN

### Laravel Packages
- laravel/sanctum - API authentication
- laravel/livewire - Dynamic UI components
- spatie/laravel-permission - Role & permission management
- barryvdh/laravel-dompdf - PDF generation
- intervention/image - Image manipulation
- maatwebsite/excel - Export Excel
- pusher/pusher-php-server - Real-time notifications

### Frontend Libraries
- Tailwind CSS - Utility-first CSS framework
- Alpine.js - Lightweight JavaScript framework
- Chart.js - Data visualization (radar chart, bar chart)
- ApexCharts - Advanced charts
- SweetAlert2 - Beautiful alerts
- Select2 - Advanced select inputs

### Development Tools
- Git - Version control
- Composer - PHP dependency manager
- NPM - JavaScript package manager
- Laravel Mix/Vite - Asset compilation
- PHPUnit - Testing framework
- Laravel Debugbar - Debugging tool

### Deployment & DevOps
- Docker - Containerization
- GitHub Actions - CI/CD
- AWS EC2/S3/RDS - Cloud infrastructure
- Nginx - Web server
- Redis - Caching & queue
- Supervisor - Process manager

## KEAMANAN & PRIVACY

### Implementasi
- HTTPS/SSL encryption
- Password hashing (bcrypt)
- CSRF protection
- XSS prevention
- SQL injection prevention
- Rate limiting untuk API
- Input validation & sanitization
- Secure file upload validation
- Compliance dengan UU PDP (UU No. 27 Tahun 2022)
- Data encryption at rest
- Audit logging

### Role-Based Access Control
- Admin: Full access
- Job Seeker: Access ke fitur pencari kerja
- Industry: Access ke fitur rekrutmen
- Education: Access ke fitur institusi

## TESTING REQUIREMENTS

### Unit Testing
- Test semua model relationships
- Test service classes
- Test helper functions
- Test validation rules

### Feature Testing
- Test authentication flow
- Test assessment submission
- Test API endpoints
- Test PDF generation
- Test email notifications

### Integration Testing
- Test AI module integration
- Test external API sync
- Test database transactions
- Test file storage

## PERFORMANCE OPTIMIZATION

### Database
- Indexing pada kolom yang sering di-query
- Query optimization (eager loading)
- Database caching
- Connection pooling

### Application
- Route caching
- Config caching
- View caching
- Redis cache untuk data yang sering diakses
- Queue untuk proses berat (email, PDF generation)
- Image optimization & lazy loading

### Frontend
- Asset minification
- CDN untuk static assets
- Browser caching
- Lazy loading untuk gambar

## DEPLOYMENT CHECKLIST

### Pre-Deployment
- [ ] Environment variables configured
- [ ] Database migrations run
- [ ] Seeders executed (roles, permissions, competencies)
- [ ] Storage link created
- [ ] Cron jobs configured
- [ ] Queue workers configured
- [ ] SSL certificate installed
- [ ] Backup strategy implemented

### Post-Deployment
- [ ] Smoke testing
- [ ] Performance testing
- [ ] Security scanning
- [ ] Monitoring setup (Sentry/LogRocket)
- [ ] Analytics integration (Google Analytics)
- [ ] Error logging configured

## DOKUMENTASI YANG HARUS DIBUAT

- API Documentation (Postman/Swagger)
- Database Schema Diagram
- User Manual (untuk setiap role)
- Admin Guide
- Deployment Guide
- Troubleshooting Guide
- Code Documentation (PHPDoc)

## TIMELINE PENGEMBANGAN (Estimasi)

Phase 1 (Minggu 1-2): Setup & Authentication
Phase 2 (Minggu 3-4): Assessment Module
Phase 3 (Minggu 5-6): AI Integration & Skill Gap Analysis
Phase 4 (Minggu 7-8): Recommendations & Roadmap
Phase 5 (Minggu 9-10): Job Matching & External APIs
Phase 6 (Minggu 11-12): Dashboard & Reporting
Phase 7 (Minggu 13-14): Testing & Bug Fixing
Phase 8 (Minggu 15-16): Deployment & Pilot Project

## CATATAN PENTING

1. Gunakan Bahasa Indonesia untuk semua UI/UX
2. Desain harus responsive (mobile-first approach)
3. Aksesibilitas (WCAG 2.1 compliance)
4. Loading time maksimal 3 detik
5. Support browser modern (Chrome, Firefox, Safari, Edge)
6. Backup database harian otomatis
7. Version control dengan Git (feature branch workflow)
8. Code review sebelum merge
9. Follow PSR-12 coding standard
10. Write clean, maintainable, and documented code

## KONTAK & KOMUNIKASI

Jika ada pertanyaan teknis, hubungi:
- Product Owner: [Nama Ketua Tim]
- Technical Lead: [Email]
- Project Timeline: 4 bulan (16 minggu)

---

Silakan mulai pengembangan dengan fase 1 terlebih dahulu. Pastikan semua dependencies terinstall dan environment siap sebelum coding.
```

---

## 📱 **PROMPT 2: MOBILE APP (FLUTTER)**

```
# SPESIFIKASI PENGEMBANGAN APLIKASI MOBILE KOMPASKARIR

## INFORMASI UMUM PROYEK
Nama Aplikasi    : KOMPASKARIR Mobile
Platform         : Android & iOS (Cross-platform)
Framework        : Flutter 3.x (Dart)
State Management : Provider / Riverpod / Bloc (pilih salah satu)
Backend API      : Laravel REST API (dari web platform)
Local Database   : SQLite (sqflite) / Hive
Navigation       : GoRouter / AutoRoute
HTTP Client      : Dio / http
Image Caching    : CachedNetworkImage
Push Notification: Firebase Cloud Messaging (FCM)
Analytics        : Firebase Analytics

## DESKRIPSI APLIKASI
Aplikasi mobile KOMPASKARIR adalah companion app untuk platform web yang memberikan 
akses on-the-go bagi pengguna untuk melakukan asesmen kompetensi, melihat rekomendasi 
upskilling, tracking progress belajar, dan mencari lowongan kerja yang sesuai dengan 
profil skill mereka.

## FITUR UTAMA YANG HARUS DIBANGUN

### 1. SPLASH SCREEN & ONBOARDING
- Splash screen dengan logo KOMPASKARIR dan tagline
- 3 halaman onboarding untuk first-time user:
  * Halaman 1: "Temukan Skill Gap-mu" - ilustrasi + deskripsi
  * Halaman 2: "Dapatkan Rekomendasi Personal" - ilustrasi + deskripsi
  * Halaman 3: "Wujudkan Karir Impian" - ilustrasi + deskripsi
- Skip button & next button
- Get started button (navigate ke login/register)
- Simpan status onboarding di local storage

### 2. AUTHENTICATION FLOW
#### Login Screen
- Input email & password
- Remember me checkbox
- Forgot password link
- Login button
- Navigate ke register jika belum punya akun
- Biometric login (fingerprint/face ID) untuk returning users
- Social login (Google, LinkedIn) - optional

#### Register Screen
- Form registrasi:
  * Nama lengkap
  * Email
  * Password & confirm password
  * No. telepon
  * Pendidikan terakhir (dropdown)
  * Jurusan
  * Target posisi karir
- Email verification flow
- Navigate ke login setelah registrasi berhasil

#### Forgot Password
- Input email
- Send reset link
- Confirmation message

### 3. BOTTOM NAVIGATION BAR
4 Tab utama:
1. Beranda (Home) - icon: home
2. Asesmen (Assessment) - icon: assessment/analytics
3. Kursus (Courses) - icon: school/book
4. Profil (Profile) - icon: person

### 4. TAB BERANDA (HOME)
#### Header Section
- Selamat datang, [Nama User]!
- Profile picture (circular)
- Notification bell icon (dengan badge)
- Level badge (jika ada gamification)

#### Progress Summary Card
- Card dengan gradient background
- Statistik:
  * Total Skill Dinilai: [angka]
  * Rata-rata Skill Gap: [persentase]%
  * Kursus Selesai: [angka]/[total]
  * Progress Bar overall

#### Skill Gap Alert Card
- Card yang menampilkan:
  * "Skill Gap Teridentifikasi: 35%"
  * 3 skill prioritas yang harus dipelajari:
    - Google Analytics (Gap: 40%)
    - Public Speaking (Gap: 35%)
    - Excel Lanjut (Gap: 30%)
  * Button "Lihat Detail" → navigate ke asesmen

#### Quick Actions
- Grid 4 tombol quick access:
  * Mulai Asesmen (icon: assessment)
  * Rekomendasi Kursus (icon: school)
  * Roadmap Karir (icon: timeline)
  * Lowongan Kerja (icon: work)

#### Recent Activity
- List aktivitas terbaru:
  * "Selesai kursus Data Analytics - 2 jam yang lalu"
  * "Skill gap berkurang 5% - 1 hari yang lalu"
  * "Lowongan baru cocok dengan profilmu - 3 jam yang lalu"

#### Suggested Jobs Preview
- Horizontal scrollable list
- 3 lowongan kerja dengan matching percentage tertinggi
- Card menampilkan:
  * Posisi
  * Perusahaan
  * Lokasi
  * Matching % (dengan color coding)
  * Button "Lihat Detail"

### 5. TAB ASEMEN (ASSESSMENT)
#### Assessment Dashboard
- Status asesmen saat ini:
  * "Belum Ada Asesmen" - dengan button "Mulai Asesmen Pertama"
  * atau "Asesmen Terakhir: 15 April 2024"
  * Button "Ulangi Asesmen"

#### Assessment Form (Multi-step Wizard)
Step 1: Pilih Posisi Target
- Dropdown/list pilihan posisi:
  * Digital Marketing Specialist
  * Data Analyst
  * UI/UX Designer
  * Software Developer
  * dll
- Button "Lanjut"

Step 2: Data Diri & Pengalaman
- Form input:
  * Pendidikan terakhir
  * Jurusan
  * Tahun lulus
  * Pengalaman kerja (tahun)
  * Upload CV (PDF)
- Button "Lanjut"

Step 3: Self-Assessment Skill Teknis
- List kompetensi dengan rating scale (1-5 stars atau slider)
- Setiap item menampilkan:
  * Nama skill (contoh: "Google Analytics")
  * Deskripsi singkat
  * Rating input (1-5)
  * Helper text (1=Tidak Bisa, 5=Ahli)
- Progress indicator (Step 3 dari 5)
- Button "Lanjut" & "Kembali"

Step 4: Soft Skill Assessment
- Sama seperti step 3, tapi untuk soft skills:
  * Komunikasi Efektif
  * Teamwork
  * Problem Solving
  * Critical Thinking
  * Leadership
  * Adaptabilitas

Step 5: Review & Submit
- Summary semua jawaban
- Edit button untuk setiap section
- Checkbox "Saya yakin dengan jawaban saya"
- Button "Submit Asesmen"
- Confirmation dialog

#### Assessment Result Screen
- Loading screen dengan animasi (saat AI menganalisis)
- Hasil analisis ditampilkan:
  * Overall skill gap percentage
  * Radar chart visualisasi kompetensi
  * List skill gap per kategori dengan progress bar
  * Priority badges (High/Medium/Low)
  * Button "Lihat Rekomendasi" → navigate ke tab Kursus
  * Button "Download Laporan PDF"

#### Assessment History
- List riwayat asesmen yang pernah dilakukan
- Setiap item menampilkan:
  * Tanggal
  * Posisi yang dipilih
  * Overall gap percentage
  * Status (Completed/In Progress)
- Tap untuk lihat detail hasil

### 6. TAB KURSUS (COURSES)
#### Recommendation Section
- Header: "Rekomendasi Untukmu"
- Horizontal scrollable cards
- Setiap card menampilkan:
  * Icon/thumbnail kursus
  * Judul kursus
  * Platform (Coursera, Dicoding, dll)
  * Durasi (contoh: "8 jam")
  * Level badge (Beginner/Intermediate/Advanced)
  * Priority badge (High/Medium/Low)
  * Progress bar (jika sudah mulai)
  * Button "Mulai" atau "Lanjutkan"

#### All Courses List
- Filter chips di atas:
  * All
  * Technical Skills
  * Soft Skills
  * In Progress
  * Completed
- Search bar untuk cari kursus
- List view atau grid view toggle
- Infinite scroll atau pagination

#### Course Detail Screen
- Course header dengan thumbnail
- Judul & deskripsi lengkap
- Informasi:
  * Platform penyedia
  * Durasi
  * Level kesulitan
  * Rating (jika ada)
  * Harga (atau "Gratis")
- Skills yang akan dipelajari (chip tags)
- Prerequisites (jika ada)
- Button "Enroll Now" (open external link)
- Button "Mark as Completed" (setelah selesai)
- Related courses section

#### My Learning Progress
- Tab atau section terpisah
- List kursus yang sedang diikuti
- Progress bar untuk setiap kursus
- Status: Not Started / In Progress / Completed
- Resume button untuk lanjut belajar

### 7. ROADMAP KARIR SCREEN
(Akses dari quick action atau menu)

#### Roadmap Overview
- Header: "Roadmap Karir 6 Bulan"
- Posisi target ditampilkan
- Overall progress percentage
- Timeline horizontal atau vertical

#### Monthly Milestones
Untuk setiap bulan (1-6):
- Card dengan:
  * Bulan ke-[X]
  * Judul milestone
  * Deskripsi tugas
  * Checklist tugas-tugas kecil
  * Due date (estimasi)
  * Status: Pending / In Progress / Completed
  * Checkbox untuk mark as completed
  * Notes field (optional)

#### Progress Tracking
- Visual progress indicator
- Celebratory animation saat milestone selesai
- Statistics:
  * Milestones completed: X/6
  * Tasks completed: Y/Z
  * Estimated completion date

#### Download Roadmap
- Button untuk download PDF
- Share functionality

### 8. JOB MATCHING SCREEN
(Akses dari quick action atau menu tambahan)

#### Job Search & Filter
- Search bar untuk cari posisi/kata kunci
- Filter options:
  * Lokasi (Remote/Hybrid/On-site)
  * Salary range (slider)
  * Experience level
  * Company size
  * Date posted
- Sort by: Relevance, Date, Salary

#### Job Listing
- List lowongan kerja
- Setiap card menampilkan:
  * Logo perusahaan
  * Posisi
  * Nama perusahaan
  * Lokasi
  * Work type badge
  * Salary range (jika ada)
  * Matching percentage (dengan color: hijau=k tinggi, kuning=sedang, merah=rendah)
  * Posted date
  * Save/bookmark icon

#### Job Detail Screen
- Company logo & name
- Posisi & lokasi
- Matching score breakdown:
  * Skills match: 80%
  * Experience match: 70%
  * Education match: 90%
  * Overall: 80%
- Job description (expandable)
- Requirements (list)
- Benefits (list)
- Company info
- Button "Apply Now" (open external link)
- Button "Save Job"

#### Saved Jobs
- Tab atau screen terpisah
- List lowongan yang disimpan
- Swipe to delete
- Quick apply

### 9. TAB PROFIL (PROFILE)
#### Profile Header
- Profile picture (editable, dengan camera icon)
- Nama lengkap
- Email
- Edit profile button

#### Personal Information Section
- Pendidikan
- Jurusan
- Target posisi
- Pengalaman kerja
- Edit button

#### Skills & Competencies
- List skill yang dimiliki dengan level
- Visualisasi dengan progress bars atau chips
- Button "Update Skills"

#### Statistics
- Total asesmen dilakukan
- Total kursus selesai
- Total skill gap berkurang
- Total lowongan diapply
- Member since

#### Settings Section
- Account Settings:
  * Change password
  * Email notifications toggle
  * Push notifications toggle
  * Language (Indonesia/English)
  * Dark mode toggle
- Privacy & Security:
  * Privacy policy
  * Terms of service
  * Delete account
- About:
  * App version
  * Rate this app
  * Share app
  * Help & Support

#### Logout Button
- Confirmation dialog
- Navigate ke login screen

### 10. NOTIFICATION SYSTEM
#### In-App Notifications
- Notification center screen
- List notifikasi dengan:
  * Icon/type
  * Title
  * Message
  * Timestamp
  * Read/unread indicator
- Mark as read functionality
- Clear all button

#### Push Notifications (FCM)
- Notification types:
  * Hasil asesmen selesai
  * Rekomendasi kursus baru
  * Reminder progress belajar
  * Lowongan kerja yang match
  * Milestone roadmap selesai
- Deep linking ke screen yang relevan
- Notification preferences di settings

### 11. OFFLINE MODE
- Local caching untuk data yang sering diakses
- SQLite/Hive untuk storage
- Sync data saat online kembali
- Offline indicator UI
- Queue untuk actions yang dilakukan offline

### 12. ADDITIONAL FEATURES
#### Dark Mode
- Toggle di settings
- Persist preference
- Smooth transition

#### Multi-language Support
- Indonesia (default)
- English (optional)
- i18n implementation

#### Accessibility
- Screen reader support
- Sufficient color contrast
- Scalable text
- Keyboard navigation

#### Error Handling
- User-friendly error messages
- Retry mechanism
- Fallback UI
- Logging untuk debugging

## STRUKTUR FOLDER PROJECT

```
lib/
├── main.dart
├── app.dart
├── core/
│   ├── constants/
│   │   ├── app_colors.dart
│   │   ├── app_strings.dart
│   │   └── app_assets.dart
│   ├── theme/
│   │   ├── app_theme.dart
│   │   └── dark_theme.dart
│   ├── utils/
│   │   ├── validators.dart
│   │   ├── formatters.dart
│   │   └── helpers.dart
│   ├── network/
│   │   ├── api_client.dart
│   │   ├── api_endpoints.dart
│   │   └── network_info.dart
│   ├── error/
│   │   ├── exceptions.dart
│   │   └── failures.dart
│   └── di/
│       └── injection_container.dart
├── features/
│   ├── auth/
│   │   ├── data/
│   │   │   ├── datasources/
│   │   │   │   └── auth_remote_datasource.dart
│   │   │   ├── models/
│   │   │   │   └── user_model.dart
│   │   │   └── repositories/
│   │   │       └── auth_repository_impl.dart
│   │   ├── domain/
│   │   │   ├── entities/
│   │   │   │   └── user.dart
│   │   │   ├── repositories/
│   │   │   │   └── auth_repository.dart
│   │   │   └── usecases/
│   │   │       ├── login_usecase.dart
│   │   │       ├── register_usecase.dart
│   │   │       └── logout_usecase.dart
│   │   └── presentation/
│   │       ├── pages/
│   │       │   ├── login_page.dart
│   │       │   ├── register_page.dart
│   │       │   └── forgot_password_page.dart
│   │       ├── widgets/
│   │       │   ├── login_form.dart
│   │       │   └── social_login_buttons.dart
│   │       └── bloc/
│   │           ├── auth_bloc.dart
│   │           ├── auth_event.dart
│   │           └── auth_state.dart
│   ├── home/
│   │   ├── presentation/
│   │   │   ├── pages/
│   │   │   │   └── home_page.dart
│   │   │   ├── widgets/
│   │   │   │   ├── progress_summary_card.dart
│   │   │   │   ├── skill_gap_alert.dart
│   │   │   │   ├── quick_actions.dart
│   │   │   │   └── recent_activity_list.dart
│   │   │   └── bloc/
│   │   │       ├── home_bloc.dart
│   │   │       ├── home_event.dart
│   │   │       └── home_state.dart
│   ├── assessment/
│   │   ├── data/
│   │   │   ├── models/
│   │   │   │   └── assessment_model.dart
│   │   │   └── repositories/
│   │   │       └── assessment_repository_impl.dart
│   │   ├── domain/
│   │   │   ├── entities/
│   │   │   │   └── assessment.dart
│   │   │   └── repositories/
│   │   │       └── assessment_repository.dart
│   │   └── presentation/
│   │       ├── pages/
│   │       │   ├── assessment_dashboard_page.dart
│   │       │   ├── assessment_wizard_page.dart
│   │       │   └── assessment_result_page.dart
│   │       ├── widgets/
│   │       │   ├── skill_rating_item.dart
│   │       │   ├── progress_indicator.dart
│   │       │   └── radar_chart_widget.dart
│   │       └── bloc/
│   │           ├── assessment_bloc.dart
│   │           ├── assessment_event.dart
│   │           └── assessment_state.dart
│   ├── courses/
│   │   ├── data/
│   │   │   └── ...
│   │   ├── domain/
│   │   │   └── ...
│   │   └── presentation/
│   │       ├── pages/
│   │       │   ├── courses_page.dart
│   │       │   └── course_detail_page.dart
│   │       └── ...
│   ├── jobs/
│   │   └── ...
│   ├── profile/
│   │   └── ...
│   └── roadmap/
│       └── ...
├── shared/
│   ├── widgets/
│   │   ├── custom_button.dart
│   │   ├── custom_text_field.dart
│   │   ├── loading_overlay.dart
│   │   └── empty_state.dart
│   └── services/
│       ├── local_storage_service.dart
│       └── pdf_generator_service.dart
└── routes/
    └── app_routes.dart
```

## STATE MANAGEMENT ARCHITECTURE

Gunakan Clean Architecture dengan BLoC pattern:

```
Presentation Layer (UI)
    ↓↑
BLoC/Cubit Layer (State Management)
    ↓↑
Domain Layer (Business Logic)
    ↓↑
Data Layer (Repository Implementation)
    ↓↑
External APIs & Local Database
```

## API INTEGRATION

### Base URL
```dart
class ApiEndpoints {
  static const String baseUrl = 'https://api.kompaskarir.com/api';
  
  // Auth
  static const String login = '$baseUrl/login';
  static const String register = '$baseUrl/register';
  static const String logout = '$baseUrl/logout';
  
  // Assessment
  static const String startAssessment = '$baseUrl/assessments/start';
  static const String submitAssessment = '$baseUrl/assessments/submit';
  static const String getAssessmentResults = '$baseUrl/assessments/results';
  
  // Skill Gap
  static const String analyzeSkillGap = '$baseUrl/skill-gap/analyze';
  
  // Recommendations
  static const String getCourseRecommendations = '$baseUrl/recommendations/courses';
  
  // Courses
  static const String getCourses = '$baseUrl/courses';
  static const String markCourseComplete = '$baseUrl/courses/mark-complete';
  
  // Roadmap
  static const String generateRoadmap = '$baseUrl/roadmap/generate';
  static const String getMyRoadmap = '$baseUrl/roadmap/my-roadmap';
  static const String completeMilestone = '$baseUrl/roadmap/milestone/complete';
  
  // Jobs
  static const String getJobs = '$baseUrl/jobs';
  static const String saveJob = '$baseUrl/jobs/save';
  
  // Profile
  static const String getProfile = '$baseUrl/user/profile';
  static const String updateProfile = '$baseUrl/user/profile';
  
  // Notifications
  static const String getNotifications = '$baseUrl/notifications';
}
```

### API Client Setup (Dio)
```dart
class ApiClient {
  late Dio _dio;
  
  ApiClient() {
    _dio = Dio(BaseOptions(
      baseUrl: ApiEndpoints.baseUrl,
      connectTimeout: const Duration(seconds: 30),
      receiveTimeout: const Duration(seconds: 30),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    ));
    
    // Add interceptors
    _dio.interceptors.add(AuthInterceptor());
    _dio.interceptors.add(LogInterceptor(
      requestBody: true,
      responseBody: true,
    ));
  }
  
  Future<Response> get(String path, {Map<String, dynamic>? queryParameters}) async {
    try {
      return await _dio.get(path, queryParameters: queryParameters);
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }
  
  Future<Response> post(String path, {dynamic data}) async {
    try {
      return await _dio.post(path, data: data);
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }
  
  // ... other HTTP methods
  
  CustomException _handleError(DioException error) {
    switch (error.type) {
      case DioExceptionType.connectionTimeout:
        return CustomException('Connection timeout');
      case DioExceptionType.receiveTimeout:
        return CustomException('Receive timeout');
      case DioExceptionType.badResponse:
        return CustomException.fromResponse(
          error.response?.statusCode,
          error.response?.data,
        );
      default:
        return CustomException('Something went wrong');
    }
  }
}
```

## LOCAL DATABASE (SQLite/Hive)

### Tables/Collections
1. **users** - Cache user profile
2. **assessments** - Cache assessment history
3. **courses** - Cache course list
4. **course_progress** - Track local progress
5. **roadmaps** - Cache roadmap data
6. **jobs** - Cache saved jobs
7. **notifications** - Cache notifications
8. **settings** - App preferences

## UI/UX GUIDELINES

### Design System
- **Primary Color**: #1E40AF (Blue 800)
- **Secondary Color**: #3B82F6 (Blue 500)
- **Accent Color**: #10B981 (Green 500)
- **Error Color**: #EF4444 (Red 500)
- **Background**: #F3F4F6 (Gray 100)
- **Surface**: #FFFFFF (White)
- **Text Primary**: #111827 (Gray 900)
- **Text Secondary**: #6B7280 (Gray 500)

### Typography
- **Font Family**: Poppins / Inter
- **Heading 1**: 24sp, Bold
- **Heading 2**: 20sp, SemiBold
- **Heading 3**: 18sp, SemiBold
- **Body Large**: 16sp, Regular
- **Body Medium**: 14sp, Regular
- **Body Small**: 12sp, Regular
- **Caption**: 10sp, Regular

### Spacing
- xs: 4dp
- sm: 8dp
- md: 16dp
- lg: 24dp
- xl: 32dp
- xxl: 48dp

### Components
- **Buttons**: 
  * Primary: Filled, rounded corners (8dp)
  * Secondary: Outlined
  * Text: Text only
- **Cards**: Elevation 2dp, rounded corners (12dp)
- **Input Fields**: Outlined, rounded corners (8dp)
- **Chips**: Rounded, with icon option
- **Bottom Navigation**: 4 items, with labels
- **App Bar**: Elevated, with back button

### Animations
- Page transitions: Fade + Slide
- Button press: Scale down 0.95
- Card tap: Ripple effect
- Loading: Shimmer effect
- Success: Checkmark animation
- Error: Shake animation

## CHARTS & VISUALIZATION

### Radar Chart (Skill Visualization)
Package: `fl_chart` atau `syncfusion_flutter_charts`

```dart
RadarChart(
  RadarChartData(
    dataSets: [
      RadarDataSet(
        dataEntries: [
          RadarEntry(value: 70), // Komunikasi
          RadarEntry(value: 60), // Teknis
          RadarEntry(value: 50), // Digital
          RadarEntry(value: 65), // Leadership
          RadarEntry(value: 55), // Bahasa
        ],
        borderColor: Colors.blue,
        fillColor: Colors.blue.withOpacity(0.3),
      ),
      RadarDataSet(
        dataEntries: [
          RadarEntry(value: 85), // Target industri
          RadarEntry(value: 80),
          RadarEntry(value: 75),
          RadarEntry(value: 80),
          RadarEntry(value: 70),
        ],
        borderColor: Colors.grey,
        fillColor: Colors.transparent,
        borderStyle: DrawingStyle.dashed,
      ),
    ],
    getTitle: (index, angle) {
      const titles = ['Komunikasi', 'Teknis', 'Digital', 'Leadership', 'Bahasa'];
      return RadarChartTitle(text: titles[index]);
    },
  ),
)
```

### Progress Bars
Package: `percent_indicator`

```dart
LinearPercentIndicator(
  width: MediaQuery.of(context).size.width - 64,
  animation: true,
  lineHeight: 12.0,
  percent: 0.65, // 65%
  backgroundColor: Colors.grey[200],
  progressColor: Colors.blue,
  barRadius: Radius.circular(6),
  leading: Text('Digital Skills'),
  trailing: Text('Gap: 35%'),
)
```

## PACKAGES & DEPENDENCIES

### Add to pubspec.yaml

```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # State Management
  flutter_bloc: ^8.1.3
  equatable: ^2.0.5
  
  # Navigation
  go_router: ^12.0.0
  
  # Network
  dio: ^5.3.3
  connectivity_plus: ^5.0.2
  
  # Local Storage
  shared_preferences: ^2.2.2
  sqflite: ^2.3.0
  hive: ^2.2.3
  hive_flutter: ^1.1.0
  
  # Authentication
  flutter_secure_storage: ^9.0.0
  local_auth: ^2.1.6
  
  # UI Components
  flutter_svg: ^2.0.9
  cached_network_image: ^3.3.0
  shimmer: ^3.0.0
  lottie: ^2.7.0
  
  # Charts
  fl_chart: ^0.65.0
  percent_indicator: ^4.2.3
  
  # Forms
  flutter_form_builder: ^9.1.1
  form_builder_validators: ^9.1.0
  
  # Date & Time
  intl: ^0.18.1
  
  # PDF
  pdf: ^3.10.7
  printing: ^5.11.1
  path_provider: ^2.1.1
  
  # Notifications
  firebase_core: ^2.24.2
  firebase_messaging: ^14.7.9
  flutter_local_notifications: ^16.2.0
  
  # Analytics
  firebase_analytics: ^10.7.9
  
  # Utilities
  url_launcher: ^6.2.1
  share_plus: ^7.2.1
  package_info_plus: ^5.0.1
  device_info_plus: ^9.1.0
  
  # Icons
  cupertino_icons: ^1.0.6
  font_awesome_flutter: ^10.6.0

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.1
  build_runner: ^2.4.7
  hive_generator: ^2.0.1
  bloc_test: ^9.1.5
  mockito: ^5.4.3
```

## FIREBASE SETUP

### firebase_core initialization
```dart
// In main.dart
await Firebase.initializeApp(
  options: DefaultFirebaseOptions.currentPlatform,
);
```

### FCM Setup
```dart
class PushNotificationService {
  final FirebaseMessaging _messaging = FirebaseMessaging.instance;
  
  Future<void> initialize() async {
    // Request permission
    await _messaging.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );
    
    // Get FCM token
    String? token = await _messaging.getToken();
    print('FCM Token: $token');
    
    // Handle foreground messages
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      // Show local notification
      _showLocalNotification(message);
    });
    
    // Handle notification tap
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      // Navigate to relevant screen
      _handleNotificationNavigation(message);
    });
  }
  
  void _showLocalNotification(RemoteMessage message) {
    // Implement local notification display
  }
  
  void _handleNotificationNavigation(RemoteMessage message) {
    // Deep linking logic
    final type = message.data['type'];
    switch (type) {
      case 'assessment':
        // Navigate to assessment results
        break;
      case 'course':
        // Navigate to course detail
        break;
      case 'job':
        // Navigate to job detail
        break;
    }
  }
}
```

## TESTING STRATEGY

### Unit Tests
- Test BLoC/Cubit states
- Test use cases
- Test validators
- Test helper functions

### Widget Tests
- Test UI components
- Test form validation
- Test navigation

### Integration Tests
- Test API calls
- Test database operations
- Test full user flows

### Example Test
```dart
// test/features/auth/presentation/bloc/auth_bloc_test.dart
void main() {
  group('AuthBloc Tests', () {
    late AuthBloc authBloc;
    late MockAuthRepository mockRepository;
    
    setUp(() {
      mockRepository = MockAuthRepository();
      authBloc = AuthBloc(repository: mockRepository);
    });
    
    tearDown(() {
      authBloc.close();
    });
    
    test('initial state should be AuthInitial', () {
      expect(authBloc.state, equals(AuthInitial()));
    });
    
    blocTest<AuthBloc, AuthState>(
      'emits [AuthLoading, AuthAuthenticated] when login succeeds',
      build: () {
        when(() => mockRepository.login(any(), any()))
            .thenAnswer((_) async => Right(testUser));
        return authBloc;
      },
      act: (bloc) => bloc.add(AuthLoginRequested(email: 'test@test.com', password: 'password')),
      expect: () => [
        AuthLoading(),
        AuthAuthenticated(user: testUser),
      ],
    );
  });
}
```

## PERFORMANCE OPTIMIZATION

### Code Splitting
- Lazy loading untuk routes
- Deferred loading untuk large libraries

### Image Optimization
- Use WebP format
- Compress images
- Use cached_network_image
- Implement lazy loading

### Memory Management
- Dispose controllers properly
- Use const constructors
- Avoid unnecessary rebuilds (RepaintBoundary)
- Limit list items (ListView.builder)

### Network Optimization
- Implement pagination
- Use caching strategies
- Compress API responses
- Implement retry logic with exponential backoff

## SECURITY

### Secure Storage
```dart
final storage = FlutterSecureStorage();

// Store token
await storage.write(key: 'auth_token', value: token);

// Read token
String? token = await storage.read(key: 'auth_token');

// Delete token
await storage.delete(key: 'auth_token');
```

### Certificate Pinning
```dart
// In Dio client
(dio.httpClientAdapter as DefaultHttpClientAdapter).onHttpClientCreate = (client) {
  client.badCertificateCallback = (X509Certificate cert, String host, int port) => false;
  return client;
};
```

### Obfuscation
```yaml
# In build.gradle (Android)
buildTypes {
  release {
    minifyEnabled true
    shrinkResources true
    proguardFiles getDefaultProguardFile('proguard-android-optimize.txt'), 'proguard-rules.pro'
  }
}
```

## BUILD & DEPLOYMENT

### Android
- Update version code & name in pubspec.yaml
- Generate keystore
- Update build.gradle with signing config
- Build APK: `flutter build apk --release`
- Build App Bundle: `flutter build appbundle --release`
- Upload to Google Play Console

### iOS
- Update version & build number
- Configure signing & capabilities in Xcode
- Update Info.plist (permissions)
- Build: `flutter build ios --release`
- Archive in Xcode
- Upload to App Store Connect

### CI/CD (GitHub Actions)
```yaml
name: Build & Deploy

on:
  push:
    branches: [ main ]

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: subosito/flutter-action@v2
        with:
          flutter-version: '3.x'
      - run: flutter pub get
      - run: flutter test
      - run: flutter build apk --release
      - run: flutter build ios --release
      # Add deployment steps
```

## MONITORING & ANALYTICS

### Crash Reporting
- Firebase Crashlytics
- Sentry

### Analytics Events
- Track screen views
- Track button clicks
- Track conversion funnels
- Track user engagement

### Performance Monitoring
- Firebase Performance Monitoring
- Custom traces for critical paths

## DOCUMENTATION

### Code Documentation
- Use dartdoc comments
- Document public APIs
- README.md dengan setup instructions

### User Documentation
- In-app tutorials
- Help center
- FAQ section

## TIMELINE PENGEMBANGAN

Phase 1 (Minggu 1-2): Setup Project & Authentication
Phase 2 (Minggu 3-4): Home Screen & Navigation
Phase 3 (Minggu 5-7): Assessment Module
Phase 4 (Minggu 8-9): Courses & Recommendations
Phase 5 (Minggu 10-11): Roadmap & Job Matching
Phase 6 (Minggu 12): Profile & Settings
Phase 7 (Minggu 13): Notifications & Offline Mode
Phase 8 (Minggu 14): Testing & Bug Fixing
Phase 9 (Minggu 15): Performance Optimization
Phase 10 (Minggu 16): Deployment & Pilot Testing

## CATATAN PENTING

1. Gunakan Bahasa Indonesia untuk semua UI text
2. Follow Material Design 3 guidelines
3. Support Android 8.0+ (API 26+) dan iOS 12+
4. Test di multiple device sizes
5. Implement proper error handling
6. Write clean, maintainable code
7. Use version control (Git)
8. Code review sebelum merge
9. Write tests untuk critical features
10. Optimize untuk performa & battery life

## KONTAK & SUPPORT

Untuk pertanyaan teknis:
- Tech Lead: [Email]
- Repository: [GitHub URL]
- Project Board: [Trello/Jira URL]

---

Selamat mengembangkan! Pastikan untuk testing di device nyata sebelum deployment.
```

---

## ️ **TOOL PENDUKUNG YANG DIBUTUHKAN**

### Untuk Development
1. **Visual Studio Code** / **Android Studio** / **IntelliJ IDEA**
2. **Git** - Version control
3. **Postman** - API testing
4. **Figma** / **Adobe XD** - UI/UX design (jika perlu modifikasi)
5. **Xcode** (untuk iOS development - macOS only)
6. **Android SDK** (untuk Android development)

### Untuk Backend & Database
1. **Laravel** - Backend framework
2. **MySQL Workbench** / **phpMyAdmin** - Database management
3. **Composer** - PHP dependency manager
4. **Node.js & NPM** - Untuk asset compilation

### Untuk Deployment
1. **AWS** / **Google Cloud Platform** - Cloud hosting
2. **Docker** - Containerization
3. **GitHub** / **GitLab** - Code repository & CI/CD
4. **Firebase Console** - Untuk mobile app services

### Untuk Testing
1. **Android Emulator** / **iOS Simulator**
2. **Physical devices** (Android & iOS) untuk testing nyata
3. **BrowserStack** - Cross-device testing (optional)

### Untuk Monitoring
1. **Sentry** - Error tracking
2. **Google Analytics** / **Firebase Analytics** - User analytics
3. **New Relic** / **Datadog** - Performance monitoring (optional)

---

Apakah ada yang perlu saya jelaskan lebih detail atau ada pertanyaan tentang kedua prompt ini? 🚀