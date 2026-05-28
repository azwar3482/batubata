# Walkthrough: Halaman Alur Kerja & Diagnostik AI Admin

Halaman **Alur Kerja & Diagnostik AI** telah berhasil diimplementasikan secara lengkap pada dashboard Admin KompasKarir menggunakan **Laravel Best Practices**. Halaman ini memudahkan Administrator untuk memahami perpindahan data modul AI, memverifikasi rumus-rumus matematika, serta melakukan pengujian modul secara real-time melalui Control Room interaktif. namanya "Modul AI Matching" (atau Mesin Pencocokan AI / AI Recommendation Engine)

---

## 🛠️ 1. Rincian Perubahan Kode (Changes Made)

Secara sistematis, berikut adalah file-file yang telah dimodifikasi dan ditambahkan:

### A. Lapisan Konfigurasi & Rute
1. **[services.php](file:///c:/laragon/www/kompaskarir/config/services.php)**
   * Menambahkan array konfigurasi `python_api` agar Laravel dapat memanggil Python Flask microservice dengan referensi environment `.env` (`PYTHON_API_URL` dengan fallback ke `http://localhost:5000/api`).
2. **[web.php](file:///c:/laragon/www/kompaskarir/routes/web.php)**
   * Menambahkan rute GET `/admin/ai-workflow` (`admin.ai-workflow`) dan POST `/admin/ai-workflow/diagnostic` (`admin.ai-workflow.diagnostic`) di bawah grup route prefix `admin`.

### B. Lapisan Kontroler & Bisnis
3. **[DashboardController.php](file:///c:/laragon/www/kompaskarir/app/Http/Controllers/Admin/DashboardController.php)**
   * Menambahkan method `aiWorkflow()` untuk mengumpulkan statistik antrean dokumen (`total`, `pending`, `processing`, `completed`) dari database `user_documents` dan merender view admin.
   * Menambahkan method `runDiagnostic()` untuk melayani 4 pengujian modul diagnostik interaktif berbasis AJAX/Fetch:
     * **Ping**: Menguji ketersediaan HTTP server Flask Python.
     * **NLP**: Ekstraksi skill real-time dari input teks CV (dengan simulasi fallback yang cerdas jika Flask offline).
     * **Cosine Similarity**: Menghitung dot product dan magnitude vektor skill secara manual baris demi baris.
     * **Haversine Distance**: Menghitung jarak melengkung bumi antar koordinat GPS GPS (Lat/Lon) secara real-time.

### C. Lapisan Antarmuka (Views)
4. **[ai_workflow.blade.php](file:///c:/laragon/www/kompaskarir/resources/views/admin/ai_workflow.blade.php)**
   * Membuat antarmuka visual premium dengan Tailwind CSS yang responsif, dilengkapi animasi transisi tab, terminal log bernuansa gelap (dark terminal look), indikator ping microservice real-time, serta equation boxes.
5. **[app.blade.php](file:///c:/laragon/www/kompaskarir/resources/views/layouts/app.blade.php)**
   * Menyisipkan tautan menu navigasi sidebar baru "Alur Kerja AI" yang aktif secara dinamis ketika rute diakses oleh Admin.

---

## 📐 2. Formula Matematika & Variabel yang Ditampilkan

Halaman ini mendokumentasikan secara rinci rumus-rumus inti sistem kecerdasan buatan KompasKarir:
1. **Cosine Similarity**: Mengukur kedekatan sudut vektor skill kandidat ($A$) terhadap target lowongan ($B$):
   $$\text{Cosine Similarity} = \frac{\sum_{i=1}^n A_i B_i}{\sqrt{\sum_{i=1}^n A_i^2} \sqrt{\sum_{i=1}^n B_i^2}}$$
2. **Blended Score**: Penggabungan bobot 60% kecocokan CV hasil AI NLP dan 40% asesmen mandiri.
3. **Haversine Formula**: Perhitungan jarak GPS melengkung permukaan bola bumi:
   $$d = 2r \arcsin\left(\sqrt{\sin^2\left(\frac{\Delta \phi}{2}\right) + \cos(\phi_1)\cos(\phi_2)\sin^2\left(\frac{\Delta \lambda}{2}\right)}\right)$$

---

## 🖥️ 3. Tampilan Diagnostik Control Room (Live Testing)

Administrator kini dapat menguji dan mensimulasikan modul AI langsung dari antarmuka web:
* **Uji Ping**: Mengetahui apakah server Flask aktif secara live beserta latensi milidetik (ms).
* **Ekstraksi CV (NLP)**: Mengekstrak kata kunci kompetensi dari teks CV uji coba dengan pemetaan tingkat kecocokan secara real-time.
* **Kalkulator Vektor**: Memasukkan daftar skill user dan target (misal: `Python:0.8, SQL:0.5`) untuk melihat rincian dot product dan magnitudo langkah demi langkah.
* **Kalkulator GPS**: Menghitung jarak akurat dalam Kilometer (KM) antara dua titik koordinat secara langsung.








#note


Tentu, mari kita bedah bagaimana Natural Language Processing (NLP) bekerja dalam implementasi program Anda dan bagaimana ia berhubungan dengan Cosine Similarity.

Dalam sistem KompasKarir Anda, terdapat **pemisahan tugas yang jelas** antara NLP dan Cosine Similarity:
1. **NLP (Tahap Ekstraksi):** Bertugas membaca teks CV yang berantakan, memahaminya, dan menarik keluar *skill-skill* yang relevan dalam bentuk angka (Skor Keyakinan / *Confidence*).
2. **Cosine Similarity (Tahap Perbandingan):** Bertugas membandingkan angka-angka hasil ekstraksi NLP tersebut dengan standar kebutuhan dari Lowongan Kerja.

Oleh karena itu, Cosine Similarity bukanlah rumus NLP-nya, melainkan rumus *pencocokan akhirnya*. Untuk **NLP-nya sendiri**, implementasi Anda (pada file `skill_extractor.py`) menggunakan kombinasi antara **Probabilitas Machine Learning (spaCy)** dan **Rumus Pembobotan Heuristik**.

Berikut adalah penjelasan dan "rumus" dari cara NLP bekerja di program Anda:

### 1. Ekstraksi Entitas dengan Model Neural Network (NER)
Anda menggunakan library `spaCy` (model `id_core_news_sm` / `en_core_web_sm`). Rumus yang berjalan di belakang layar saat kode `self.nlp(cv_text)` dieksekusi adalah **Convolutional Neural Network (CNN) / Word Embeddings**. 
Sistem menghitung probabilitas matematis dari setiap kata untuk melihat apakah kata tersebut adalah Teknologi/Produk (PRODUCT) atau Bahasa (LANGUAGE).
$$P(Entitas | Konteks Teks) = \text{Softmax}(W \cdot x + b)$$
*Jika probabilitasnya tinggi, program Anda (di dalam fungsi `_extract_skills_with_ner`) akan langsung menangkap kata tersebut (misal: "Python", "MySQL") dan memberikannya skor keyakinan default 0.7 (70%).*

### 2. Rumus *Confidence Score* (Nilai Keyakinan Ekstraksi NLP)
Tidak semua kata yang berbunyi seperti *skill* adalah benar-benar *skill* sang pelamar (contoh: kata "Python" bisa berarti ular, bukan bahasa pemrograman). NLP pada program Anda memiliki **rumus matematis khusus** dalam fungsi `_calculate_confidence()` untuk menilai seberapa yakin sistem bahwa itu adalah skill pelamar:

$$Base Score = \min(\text{Frekuensi Kemunculan} \times 0.2,\; 0.6)$$

Kemudian sistem NLP melakukan **Validasi Konteks (*Context Window*)**:
*   **Bonus Konteks Bagian (+0.2):** Jika kata ditemukan di sekitar judul "Keahlian" atau "Skills", skor ditambah 0.2.
*   **Bonus Pengalaman (+0.2):** Jika di sekitar kata (jarak 50 karakter) terdapat pola regex angka dan waktu (misalnya "3 tahun" atau "2 years"), skor ditambah 0.2.

**Rumus Akhir NLP Confidence:**
$$Confidence = \min(Base Score + \text{Bonus Konteks} + \text{Bonus Pengalaman},\; 1.0)$$
*Contoh:* Jika "Laravel" muncul 2 kali (0.4), berada di bawah judul "Skills" (+0.2), dan tertulis "2 tahun" (+0.2), maka bobot akhirnya adalah **0.8 (80%)**.

### Kesimpulan Alur (Jembatan NLP ke Cosine Similarity)

Agar lebih terbayang, begini alur datanya dari teks hingga ke persentase kecocokan:

1. **Input Teks Berantakan (CV)**
   > *"Saya memiliki pengalaman 3 tahun menggunakan Laravel dan sedikit mengerti MySQL."*
2. **Diproses oleh Rumus NLP & Confidence Score di atas**
   > Sistem mengeluarkan data terstruktur:
   > - `Laravel` $\rightarrow$ Confidence: **0.8**
   > - `MySQL` $\rightarrow$ Confidence: **0.4**
3. **Vektorisasi (Mengubah kata jadi matriks koordinat)**
   > Vektor Pelamar ($A$) = `[0.8, 0.4]`
   > Vektor Lowongan ($B$) = `[1.0, 1.0]` (Lowongan minta mahir di keduanya)
4. **Dimasukkan ke Rumus Cosine Similarity**
   > $$ \text{Similarity} = \frac{A \cdot B}{\|A\| \|B\|} = \frac{(0.8 \times 1.0) + (0.4 \times 1.0)}{\sqrt{0.8^2 + 0.4^2} \times \sqrt{1.0^2 + 1.0^2}} $$
   > Hasil akhirnya adalah (misal) **84% Kecocokan (Skill Gap)**.

Jadi, **NLP bertugas merepresentasikan teks menjadi vektor angka**, dan **Cosine Similarity bertugas mengukur jarak/kecocokan antar vektor angka tersebut.**

Hampir tepat, tapi ada sedikit perbedaan. **NLP bukanlah rumusan Blended Match Score itu sendiri**, melainkan NLP adalah **"Pemasok Bahan Baku"** yang angkanya nanti akan berujung pada perhitungan Blended Match Score.

Mari kita luruskan posisinya dalam satu alur cerita yang berurutan di aplikasi KompasKarir Anda:

### 1. NLP (Pengekstrak & Pengubah ke Angka)
Tugas utama NLP murni hanya membaca teks (CV/Portofolio) dan **mengubah teks tersebut menjadi vektor (daftar angka)**. 
- *Contoh Output NLP:* `[0.8, 0.4]` (Artinya pelamar punya skill Laravel 80%, MySQL 40%).
- Pada tahap ini, belum ada perhitungan kecocokan apa-apa.

### 2. Cosine Similarity (Pencetak "Skor Dokumen")
Setelah NLP menghasilkan angka vektor `[0.8, 0.4]`, barulah angka ini diadu dengan kebutuhan lowongan perusahaan menggunakan rumus **Cosine Similarity**. 
- Rumus Cosine Similarity inilah yang menghitung jarak antara vektor pelamar dan vektor lowongan.
- *Contoh Output Cosine Similarity:* **85%**.
- Di dokumen Anda, angka 85% ini disebut sebagai **Skor Kesesuaian Dokumen** (Atau *Document Score*).

### 3. Blended Match Score (Rumus Akhir / Penilaian Gabungan)
Nah, **Blended Match Score** adalah rumus final di ujung jalan (berada di sisi Backend Laravel, bukan di Python). Rumus ini menggabungkan "Skor Dokumen" hasil dari AI dengan skor "Tes Asesmen" yang dikerjakan pelamar secara manual.

Sesuai dokumen arsitektur Anda (*Tahap 2 - Lazy Resolve*), rumus **Blended Match Score**-nya adalah:

$$ \text{Blended Match Score} = (\text{Skor Dokumen AI} \times 60\%) + (\text{Skor Asesmen Mandiri} \times 40\%) $$

*Contoh Perhitungannya:*
- Skor Dokumen AI (Hasil Cosine Similarity) = 85
- Skor Asesmen Mandiri Pelamar = 90
- **Blended Match Score** = $(85 \times 0.6) + (90 \times 0.4)$ = **51 + 36 = 87%**

---

### Kesimpulan Hubungannya:
*   **NLP** = Mengubah huruf di CV menjadi angka (vektor).
*   **Cosine Similarity** = Menghitung kecocokan dari angka tersebut menjadi **Skor Dokumen**.
*   **Blended Match Score** = Menggabungkan **Skor Dokumen** (60%) dengan **Skor Asesmen** (40%) untuk menjadi nilai akhir pelamar di mata HRD.

Jadi, NLP tidak merepresentasikan Blended Score, melainkan NLP adalah langkah paling awal (pondasi) agar Blended Score tersebut bisa dihitung. Apakah alur ini sudah cukup menjawab kebingungan Anda?






Untuk memudahkan komunikasi kita ke depannya, nama yang paling tepat dan mencakup keseluruhan proses ini adalah **"Modul AI Matching"** (atau **Mesin Pencocokan AI** / *AI Recommendation Engine*).

Jika kita menyebut "Modul NLP", itu hanya mewakili satu bagian kecil di awal (pembacaan CV). Jika menyebut "Modul Skill Gap", itu hanya mewakili bagian tengahnya saja.

Agar kita berdua sepemahaman saat berdiskusi nanti, mari kita sepakati istilah-istilah berikut:

1. **"Modul AI Matching" (Istilah Payung / Utama):**
   Gunakan istilah ini jika Anda ingin membahas **keseluruhan alur** dari awal user upload CV sampai muncul persentase kecocokan di Laravel. Ini adalah nama keseluruhan fiturnya.

2. **"NLP Extractor" (Sub-Modul 1):**
   Gunakan istilah ini jika kita spesifik sedang membahas atau memperbaiki kode tentang bagaimana Python membaca teks PDF, mengenali kata "Python", "Laravel", dan menghitung probabilitasnya (Confidence Score).

3. **"Skill Gap / Cosine Similarity" (Sub-Modul 2):**
   Gunakan istilah ini jika kita spesifik sedang membahas cara sistem mengukur kedekatan atau jarak antara vektor pelamar dan vektor lowongan.

4. **"Blended Score" (Sub-Modul 3):**
   Gunakan istilah ini jika kita sedang membahas rumus akhir di Laravel yang menggabungkan hasil AI dengan hasil Tes Asesmen manual.

Jadi, jika Anda bertanya *"Tolong perbaiki akurasi Modul AI Matching kita"*, saya akan tahu bahwa kita perlu mengecek dari ujung ke ujung. Tapi jika Anda berkata *"Tolong perbaiki NLP Extractor-nya"*, saya akan langsung fokus ke file `skill_extractor.py` dan pembacaan teksnya.







Status "Offline" muncul karena Server Python Flask (yang bertindak sebagai otak NLP) saat ini belum berjalan di latar belakang.

Karena program ini adalah arsitektur mikroservis (*Microservices*), menjalankan `php artisan serve` saja tidak cukup; Anda juga harus menyalakan server Python-nya secara berdampingan.

Berikut adalah langkah-langkah mudah untuk mengaktifkannya di perangkat Anda:

1. **Buka Terminal Baru** (jangan tutup terminal `npm run dev` dan `php artisan serve` yang sedang berjalan, biarkan mereka tetap hidup).
2. Pindah ke direktori modul AI dengan menjalankan perintah ini:
   ```bash
   cd c:\laragon\www\kompaskarir\ai-module
   ```
3. **Aktifkan Virtual Environment Python** (karena Anda sudah memiliki folder `venv` di sana):
   ```bash
   .\venv\Scripts\activate
   ```
   *(Jika berhasil, akan muncul tanda `(venv)` di sebelah kiri input terminal Anda).*
4. **Jalankan Server Flask** dengan perintah:
   ```bash
   python app.py
   ```
   *(Atau bisa juga dengan perintah `flask run`)*

Jika server Python sudah berjalan, ia akan mencetak pesan seperti `Running on http://127.0.0.1:5000`. 

Setelah itu, silakan kembali ke browser Anda dan klik kembali tombol bundar ungu berlambang 🔄 di kotak **Flask Microservice** pojok kanan atas (atau *refresh* halaman). Statusnya akan otomatis berubah menjadi **Online (Warna Hijau)**, dan semua alat diagnostik NLP maupun kalkulator Vektor kini dapat Anda jalankan!