# scan
 php artisan brain:scan
# Select2
"Buatkan searchable dropdown (ala Select2) menggunakan Alpine.js untuk input [Nama Input], lengkap dengan styling Tailwind dan dukungan dark mode."

"Tolong jalankan perintah php artisan brain:export-context dan analisa masalah yang paling kritis."

Tolong analisa bug baru di file brain-context.md.

Fat Controller" (Controller yang terlalu gemuk) dan "N+1 / Query Overload"

"Tolong gunakan perintah php artisan brain:export-context untuk melihat seluruh masalah di proyek ini"
ngrok http 8000 //pastikan sudah menjalankn php artisan bluid
C:\laragon\www\kompaskarir_mobile\lib\core\di\injection_container.dart
php artisan storage:link

Kelola Kompetensi
Laporan Sistem
Pengaturan

setiap membuat sintak misal sintak view yang baru dibuat,beritahu diimplementasikan dimana ,beritahu pact nya, dan pastikan viewnya mengikuti kaidah uiux

Illuminate\Database\QueryException
vendor\laravel\framework\src\Illuminate\Database\Connection.php:838
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'user_competency_scores.user_assessment_id' in 'where clause' (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: kompskarir_db, SQL: select * from `user_competency_scores` where `user_competency_scores`.`user_assessment_id` = 1 and `user_competency_scores`.`user_assessment_id` is not null)

ErrorException
resources\views\dashboard.blade.php:13
Undefined variable $user

<https://chat.qwen.ai/c/1ff0adf8-8046-4689-adc1-26c07cd32378>

<https://chat.qwen.ai/c/2a4ad454-d4e2-4e98-95a9-0673f0659eb3> pei

### 4. SISTEM ANALISIS SKILL GAP (INTEGRASI AI)

- Endpoint API untuk mengirim data asesmen ke modul Python AI
- Modul AI melakukan:
  - NLP processing untuk ekstrak skill dari CV & job description
  - Cosine Similarity untuk hitung jarak antara skill user vs standar industri
  - Content-Based Filtering untuk rekomendasi
- Tampilkan hasil analisis:
  - Skill gap per kategori (dalam %)
  - Prioritas skill yang harus dipelajari
  - Level kompetensi saat ini vs target

  ### 5. REKOMENDASI UPSKILLING PERSONAL

- Daftar kursus yang direkomendasikan berdasarkan skill gap
- Setiap rekomendasi menampilkan:
  - Nama kursus (contoh: "Data Analytics Fundamentals")
  - Platform penyedia (Coursera, Dicoding, Udemy, dll)
  - Durasi (contoh: "8 jam")
  - Level (Beginner/Intermediate/Advanced)
  - Link ke kursus
  - Priority badge (High/Medium/Low)
- Filter berdasarkan:
  - Kategori skill
  - Durasi
  - Platform
  - Level kesulitan
- Fitur "Mark as Completed" untuk tracking progress

## INTEGRASI EKSTERNAL

### 1. Python AI Module (Microservice)

- Endpoint: <http://ai-module:5000/analyze>
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
