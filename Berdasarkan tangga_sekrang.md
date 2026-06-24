Berdasarkan tangga_sekrang.md, berikut aksi yang harus dilakukan:
TAHAP 1 — Kritis (Minggu 1-2)
1. Hapus blood_type dari database
Data kesehatan ini tidak relevan untuk job matching dan melanggar Pasal 13-14 UU PDP.
2. Tambahkan Consent Management
Checkbox di form registrasi (setuju privacy policy, setuju pemrosesan data, setuju sharing ke industri)
Tabel consents untuk log persetujuan
Cookie consent banner di frontend
3. Enkripsi data sensitif di database
Field phone, address, birth_date, latitude, longitude harus dienkripsi (bukan plaintext).
4. Data Breach Response Plan
Siapkan mekanisme notifikasi pelanggaran dalam 3×24 jam sesuai Pasal 46-47.
5. Fitur Export Data (Hak Portabilitas)
User harus bisa download semua data pribadinya dalam format terstruktur.
TAHAP 2 — Tinggi (Minggu 3-4)
6. Audit Log
Catat siapa yang akses data siapa, kapan, dari mana.
7. Granular Data Sharing
Saat apply job, user pilih data mana yang dibagikan ke industri (bukan kirim semua).
8. Kebijakan Retensi Data
Chat: hapus setelah 1 tahun
Session: hapus setelah 30 hari
Akun nonaktif: hapus/anonimkan setelah 2 tahun
9. Filter data sensitif dari cv_text
CV mungkin berisi agama, suku, status perkawinan — harus difilter sebelum disimpan.
TAHAP 3 — Tata Kelola (Minggu 5-8)
10. Tunjuk DPO (Data Protection Officer)
Wajib jika >2.500 user. Daftarkan ke Kominfo.
11. Transfer Impact Assessment
Dokumentasikan dan verifikasi perlindungan data untuk Google OAuth, Gemini AI, dll.
12. Update Privacy Policy
Tambahkan dasar hukum, info DPO, mekanisme hak subjek data, kebijakan retensi.


Jadi ada justifikasi bisnis. Berdasarkan UU PDP Pasal 13-14, data kesehatan boleh diproses jika:
Syarat	Penjelasan
Consent EKSPLISIT khusus	Bukan consent umum, harus checkbox terpisah: "Saya menyetujui pengumpulan data golongan darah untuk keperluan pencocokan pekerjaan"
Justifikasi jelas	Hanya untuk job yang memang butuh blood_type (misal: posisi tertentu di bidang kesehatan/darurat)
Bisa dicabut	User bisa cabut consent tanpa harus hapus akun
Tidak wajib	Tidak boleh memaksa user mengisi blood_type
Masalah saat ini: DashboardController.php:51 menampilkan warning "Golongan darah belum diisi" — ini kesan memaksa. Harus diubah menjadi opsional.
2. Fitur Download PDF — BELUM CUKUP untuk UU PDP
Fitur CV download yang ada (CvController@download) hanya mengekspor data CV:
- Nama, foto, kontak, pendidikan, pengalaman kerja, skills
Yang kurang untuk memenuhi hak portabilitas (Pasal 16):
Data yang TIDAK ada di PDF	Keterangan
Skor asesmen kompetensi	user_competency_scores
Hasil TPA	tpa_results
Riwayat lamaran	user_job_applications
Riwayat chat	chat_messages, direct_messages
Skill analysis/AI data	skill_analyses, user_document_scores
Career roadmap	career_roadmaps
Course progress	user_course_progress
Dokumen yang diupload	CV, ijazah, transkrip (file asli)
Selain itu, format harus:
- Machine-readable (JSON/CSV), bukan hanya PDF
- User harus bisa download SEMUA data pribadinya, bukan hanya yang tampil di CV
Ringkasan Aksi yang Perlu Dilakukan
No	Aksi	Status
1	Buat consent khusus untuk blood_type (checkbox terpisah)	Perlu dibuat
2	Hapus warning "golongan darah belum diisi" dari dashboard	Perlu diubah
3	Tambahkan fitur Data Export (JSON) yang mencakup SEMUA data user	Perlu dibuat
4	CV download yang ada tetap dipertahankan sebagai fitur terpisah	Sudah ada ✅
Mau saya mulai implementasi yang mana? Rekomendasi:
1. Consent khusus blood_type (cepat, langsung patuh)
2. Fitur Data Export JSON (butuh beberapa file baru)



Masalah berat:
- logo1.png (1.57MB), logo.png (0.66MB), dll - banyak logo redundan
- chart.js dimuat di SEMUA halaman via layout padahal tidak semua pakai chart
- cdn.tailwindcss.com dimuat via script di beberapa halaman (sangat berat)
- Quill editor dimuat berulang di ~20+ halaman via CDN
- Tidak ada library kompressi gambar


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


