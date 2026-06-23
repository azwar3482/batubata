<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - KOMPASKARIR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/jpeg">
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-slate-900 dark:text-gray-100">

    <!-- Navigation -->
    <nav class="bg-white dark:bg-slate-800 shadow-sm dark:border-b dark:border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto dark:bg-white dark:p-1 dark:rounded-md">
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent">KOMPASKARIR</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="/" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium text-sm transition">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-8 md:p-12">

            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Kebijakan Privasi</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mb-8">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>

            <div class="prose prose-slate dark:prose-invert max-w-none space-y-6 text-gray-700 dark:text-slate-300 leading-relaxed">

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">1. Pendahuluan</h2>
                <p>KOMPASKARIR INDONESIA ("KOMPASKARIR", "kami", "milik kami") berkomitmen untuk melindungi privasi dan keamanan data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan platform KOMPASKARIR yang tersedia di website dan aplikasi mobile kami ("Layanan").</p>
                <p>Dengan menggunakan Layanan kami, Anda menyetujui praktik yang dijelaskan dalam Kebijakan Privasi ini. Jika Anda tidak setuju, mohon untuk tidak menggunakan Layanan kami.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">2. Informasi yang Kami Kumpulkan</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">2.1 Informasi Pendaftaran</h3>
                <p>Saat Anda mendaftar akun, kami mengumpulkan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Nama lengkap</li>
                    <li>Alamat email</li>
                    <li>Kata sandi (disimpan dalam bentuk terenkripsi)</li>
                    <li>Peran pengguna (Pencari Kerja, Perusahaan/HRD, atau Institusi Pendidikan)</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">2.2 Informasi Profil</h3>
                <p>Setelah mendaftar, Anda dapat melengkapi profil dengan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Foto profil</li>
                    <li>Jenis kelamin, golongan darah, tanggal lahir</li>
                    <li>Nomor telepon dan alamat</li>
                    <li>Informasi pendidikan (jenjang, jurusan, tahun lulus, institusi)</li>
                    <li>Pengalaman kerja dan keahlian</li>
                    <li>Bahasa yang dikuasai</li>
                    <li>URL LinkedIn, GitHub, dan portofolio</li>
                    <li>Preferensi kerja (posisi target, ekspektasi gaji)</li>
                    <li>Biografi singkat</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">2.3 Dokumen</h3>
                <p>Anda dapat mengunggah dokumen berikut ke platform kami:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Curriculum Vitae (CV)</li>
                    <li>Ijazah</li>
                    <li>Transkrip nilai</li>
                    <li>Sertifikat</li>
                    <li>Portofolio</li>
                </ul>
                <p>Dokumen yang diunggah akan dianalisis secara otomatis menggunakan teknologi Natural Language Processing (NLP) untuk mengekstrak data kompetensi dan melakukan pemetaan keahlian.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">2.4 Data Asesmen dan Tes</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Hasil asesmen kompetensi (self-assessment terhadap keahlian yang dibutuhkan industri)</li>
                    <li>Skor dan hasil Tes Potensi Akademik (TPA)</li>
                    <li>Data analisis kesenjangan keahlian (skill gap)</li>
                    <li>Progres dan penyelesaian roadmap karir</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">2.5 Data Aktivitas</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Riwayat lamaran pekerjaan dan statusnya</li>
                    <li>Riwayat kursus dan progres pembelajaran</li>
                    <li>Pesan dalam fitur chat langsung dan chatbot AI</li>
                    <li>Notifikasi dan interaksi dengan pengguna lain</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">2.6 Informasi Perangkat dan Teknis</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Alamat IP dan lokasi perkiraan (latitude, longitude)</li>
                    <li>Jenis perangkat dan browser</li>
                    <li>Cookie dan data sesi</li>
                    <li>Log aktivitas untuk keamanan dan debugging</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">3. Bagaimana Kami Menggunakan Informasi Anda</h3>
                <p>Kami menggunakan informasi yang dikumpulkan untuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Menyediakan Layanan:</strong> Mengelola akun, asesmen kompetensi, analisis kesenjangan keahlian, rekomendasi kursus, dan pencocokan pekerjaan.</li>
                    <li><strong>Analisis Dokumen:</strong> Menganalisis CV dan dokumen pendidikan menggunakan AI untuk mengekstrak keahlian dan memberikan rekomendasi karir yang relevan.</li>
                    <li><strong>Pencocokan Pekerjaan:</strong> Mencocokkan profil pencari kerja dengan lowongan pekerjaan berdasarkan keahlian, lokasi, dan preferensi.</li>
                    <li><strong>Pengembangan Karir:</strong> Membuat roadmap karir personal dan merekomendasi kursus untuk menutup kesenjangan keahlian.</li>
                    <li><strong>Komunikasi:</strong> Mengirim notifikasi terkait lamaran, undangan tes, hasil asesmen, dan informasi penting lainnya.</li>
                    <li><strong>Keamanan:</strong> Melindungi akun Anda dari akses tidak sah dan mendeteksi aktivitas mencurigakan.</li>
                    <li><strong>Peningkatan Layanan:</strong> Menganalisis penggunaan platform untuk meningkatkan fitur dan pengalaman pengguna.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">4. Berbagi Informasi dengan Pihak Ketiga</h2>
                <p>Kami dapat membagikan informasi Anda dalam situasi berikut:</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.1 Dengan Perusahaan/HRD</h3>
                <p>Saat Anda melamar pekerjaan atau menerima undangan dari perusahaan, informasi profil dan dokumen Anda (CV, ijazah, transkrip, sertifikat, portofolio) akan dibagikan kepada perusahaan tersebut. Perusahaan juga dapat melihat skor asesmen dan hasil TPA Anda jika relevan dengan proses rekrutmen.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.2 Dengan Institusi Pendidikan</h3>
                <p>Jika Anda terdaftar melalui institusi pendidikan, data kompetensi dan progres pembelajaran Anda dapat dibagikan kepada institusi tersebut untuk tujuan analisis dan peningkatan kurikulum.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.3 Penyedia Layanan Pihak Ketiga</h3>
                <p>Kami menggunakan layanan pihak ketiga berikut untuk mengoperasikan platform:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Google OAuth:</strong> Untuk autentikasi sosial (login dengan Google)</li>
                    <li><strong>Google Gemini AI:</strong> Untuk fitur chatbot AI dan analisis konten</li>
                    <li><strong>Layanan AI Lainnya:</strong> Untuk pemrosesan bahasa alami (NLP) dan analisis dokumen</li>
                </ul>
                <p>Penyedia layanan ini memiliki akses terbatas hanya untuk menjalankan tugas tertentu atas nama kami dan wajib menjaga kerahasiaan informasi Anda.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.4 Kewajiban Hukum</h3>
                <p>Kami dapat mengungkapkan informasi Anda jika diwajibkan oleh hukum, perintah pengadilan, atau permintaan resmi dari otoritas yang berwenang.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">5. Keamanan Data</h2>
                <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi untuk melindungi data pribadi Anda, termasuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Enkripsi kata sandi menggunakan algoritma hashing yang aman</li>
                    <li>Enkripsi cookie dan token autentikasi</li>
                    <li>Autentikasi berbasis token (Laravel Sanctum) untuk API</li>
                    <li>Perlindungan terhadap serangan XSS, CSRF, dan SQL Injection</li>
                    <li>Rate limiting untuk mencegah serangan brute force</li>
                    <li>Deteksi dan pencegahan injeksi prompt pada fitur AI</li>
                    <li>Akses berbasis peran (role-based access control)</li>
                    <li>Audit keamanan berkala</li>
                </ul>
                <p>Meskipun kami berusaha melindungi data Anda, tidak ada metode transmisi atau penyimpanan elektronik yang 100% aman. Kami tidak dapat menjamin keamanan absolut.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">6. Penyimpanan dan Retensi Data</h2>
                <p>Data pribadi Anda disimpan selama akun Anda aktif atau selama diperlukan untuk menyediakan Layanan. Kami akan menghapus atau menganonimkan data Anda setelah:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Anda menghapus akun Anda</li>
                    <li>Data tidak lagi diperlukan untuk tujuan pengumpulannya</li>
                    <li>Periode retensi hukum berakhir</li>
                </ul>
                <p>Beberapa data mungkin disimpan lebih lama jika diperlukan untuk kepatuhan hukum, penyelesaian sengketa, atau penegakan perjanjian kami.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">7. Hak Anda</h2>
                <p>Anda memiliki hak berikut terkait data pribadi Anda:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Akses:</strong> Melihat dan mengunduh data pribadi Anda</li>
                    <li><strong>Koreksi:</strong> Memperbarui atau memperbaiki data yang tidak akurat</li>
                    <li><strong>Penghapusan:</strong> Meminta penghapusan data pribadi Anda</li>
                    <li><strong>Pembatasan:</strong> Membatasi pemrosesan data Anda dalam situasi tertentu</li>
                    <li><strong>Portabilitas:</strong> Meminta data Anda dalam format yang dapat dibaca mesin</li>
                    <li><strong>Keberatan:</strong> Menolak pemrosesan data Anda untuk tujuan tertentu</li>
                </ul>
                <p>Untuk menggunakan hak-hak ini, silakan hubungi kami melalui informasi kontak yang tersedia di bawah.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">8. Cookie dan Teknologi Pelacakan</h2>
                <p>Kami menggunakan cookie untuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Menjaga sesi login Anda</li>
                    <li>Menyimpan preferensi tema (terang/gelap)</li>
                    <li>Menyimpan preferensi bahasa</li>
                    <li>Mengingat pilihan Anda di halaman formulir</li>
                </ul>
                <p>Anda dapat mengatur browser Anda untuk menolak cookie, namun beberapa fitur Layanan mungkin tidak berfungsi dengan baik.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">9. Privasi Anak</h2>
                <p>Layanan kami ditujukan untuk pengguna berusia 17 tahun ke atas. Kami tidak secara sengaja mengumpulkan data pribadi dari anak di bawah usia 17 tahun. Jika Anda adalah orang tua atau wali dan mengetahui bahwa anak Anda telah memberikan data pribadi kepada kami, silakan hubungi kami agar kami dapat menghapus informasi tersebut.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">10. Transfer Data Internasional</h2>
                <p>Data Anda mungkin diproses di server yang terletak di luar Indonesia, termasuk oleh penyedia layanan pihak ketiga seperti Google. Kami memastikan bahwa transfer data dilakukan dengan perlindungan yang memadai sesuai dengan standar keamanan yang berlaku.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">11. Dasar Hukum Pemrosesan</h2>
                <p>Kami memproses data pribadi Anda berdasarkan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Persetujuan (Consent):</strong> Anda memberikan persetujuan eksplisit untuk pemrosesan data tertentu, termasuk data kesehatan (golongan darah)</li>
                    <li><strong>Pelaksanaan Kontrak:</strong> Pemrosesan diperlukan untuk penyediaan layanan platform KOMPASKARIR</li>
                    <li><strong>Kepentingan Sah:</strong> Pemrosesan untuk keamanan, pencegahan penipuan, dan peningkatan layanan</li>
                    <li><strong>Kewajiban Hukum:</strong> Pemrosesan yang diwajibkan oleh peraturan perundang-undangan</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">12. Data Pribadi Spesifik</h2>
                <p>Beberapa data yang kami kumpulkan termasuk kategori <strong>data pribadi spesifik</strong> sesuai UU PDP:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Golongan Darah:</strong> Hanya dikumpulkan dengan persetujuan eksplisit terpisah dan bersifat opsional</li>
                    <li><strong>Foto Wajah:</strong> Digunakan untuk identifikasi profil dengan persetujuan Anda</li>
                    <li><strong>Lokasi GPS:</strong> Digunakan untuk pencocokan pekerjaan berdasarkan lokasi dengan persetujuan Anda</li>
                </ul>
                <p>Anda dapat menarik persetujuan untuk data spesifik kapan saja melalui halaman profil.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">13. Hak-Hak Anda sebagai Subjek Data</h2>
                <p>Sesuai UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi, Anda memiliki hak-hak berikut:</p>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mt-4 space-y-3">
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">1. Hak Akses (Pasal 16 ayat 1)</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda berhak mendapatkan salinan data pribadi Anda. Gunakan fitur "Ekspor Data" di halaman profil untuk mengunduh data Anda dalam format JSON atau CSV.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">2. Hak Koreksi (Pasal 16 ayat 1)</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda dapat memperbarui atau memperbaiki data yang tidak akurat melalui halaman profil.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">3. Hak Penghapusan (Pasal 16 ayat 1)</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda dapat menghapus akun dan seluruh data pribadi Anda melalui halaman profil. Data akan dihapus permanen dari sistem kami.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">4. Hak Pembatasan Pemrosesan (Pasal 16 ayat 2)</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda dapat membatasi pemrosesan data Anda untuk tujuan tertentu dengan mengatur preferensi berbagi data di halaman profil.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">5. Hak Keberatan (Pasal 16 ayat 3)</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda berhak menolak pemrosesan data Anda untuk tujuan tertentu. Hubungi kami untuk menyampaikan keberatan.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">6. Hak Portabilitas Data (Pasal 16 ayat 1)</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda berhak mendapatkan data Anda dalam format yang dapat dibaca mesin (JSON/CSV).</p>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">7. Hak Menarik Persetujuan</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">Anda dapat menarik persetujuan kapan saja melalui halaman profil tanpa mempengaruhi pemrosesan yang telah dilakukan sebelumnya.</p>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">14. Pengendalian Berbagi Data</h2>
                <p>Anda memiliki kontrol penuh atas data yang dibagikan kepada perusahaan/HRD saat melamar pekerjaan. Melalui halaman profil, Anda dapat mengatur data mana yang ingin Anda bagikan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Profil dasar dan foto</li>
                    <li>Informasi kontak (email, telepon)</li>
                    <li>Informasi pendidikan</li>
                    <li>Pengalaman kerja</li>
                    <li>Keahlian dan bahasa</li>
                    <li>Dokumen (CV, ijazah, transkrip, sertifikat)</li>
                    <li>Hasil asesmen kompetensi</li>
                    <li>Skor TPA</li>
                    <li>Golongan darah</li>
                    <li>Lokasi</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">15. Retensi Data</h2>
                <p>Kami menyimpan data pribadi Anda selama diperlukan untuk tujuan pengumpulan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Akun aktif:</strong> Selama akun Anda aktif</li>
                    <li><strong>Akun nonaktif:</strong> Data akan dianonimkan setelah 2 tahun tidak aktif</li>
                    <li><strong>Pesan chat:</strong> Disimpan maksimal 1 tahun</li>
                    <li><strong>Session data:</strong> Disimpan maksimal 30 hari</li>
                    <li><strong>Log persetujuan:</strong> Disimpan 3 tahun setelah pencabutan</li>
                    <li><strong>Audit log:</strong> Disimpan 3 tahun</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">16. Pelanggaran Data</h2>
                <p>Dalam hal terjadi pelanggaran data pribadi yang menimbulkan kerugian material atau immaterial bagi Anda, kami akan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Memberitahukan kepada Anda dalam waktu <strong>3×24 jam</strong> sejak diketahuinya pelanggaran</li>
                    <li>Melaporkan kepada otoritas yang berwenang sesuai ketentuan peraturan</li>
                    <li>Mengambil langkah-langkah mitigasi untuk meminimalkan dampak</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">17. Perlindungan Anak</h2>
                <p>Layanan kami ditujukan untuk pengguna berusia 17 tahun ke atas. Kami tidak secara sengaja mengumpulkan data pribadi dari anak di bawah usia 17 tahun. Jika Anda adalah orang tua atau wali dan mengetahui bahwa anak Anda telah memberikan data pribadi kepada kami, silakan hubungi kami agar kami dapat menghapus informasi tersebut.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">18. Perubahan pada Kebijakan Privasi</h2>
                <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan signifikan akan diberitahukan melalui email atau notifikasi di platform. Tanggal "Terakhir diperbarui" di bagian atas akan diubah sesuai dengan revisi terbaru.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">19. Petugas Perlindungan Data (DPO)</h2>
                <p>Kami telah menunjuk Petugas Perlindungan Data (Data Protection Officer/DPO) yang bertanggung jawab atas kepatuhan perlindungan data pribadi. Anda dapat menghubungi DPO untuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Pertanyaan tentang pemrosesan data pribadi Anda</li>
                    <li>Menyampaikan keluhan terkait privasi</li>
                    <li>Menggunakan hak-hak Anda sebagai subjek data</li>
                    <li>Melaporkan pelanggaran data</li>
                </ul>
                <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 mt-4">
                    <p class="font-semibold">Petugas Perlindungan Data (DPO)</p>
                    <p>KOMPASKARIR INDONESIA</p>
                    <p>Email: <a href="mailto:dpo@kompaskarir.id" class="text-blue-600 dark:text-blue-400 hover:underline">dpo@kompaskarir.id</a></p>
                    <p>Waktu respons: Maksimal 3 hari kerja</p>
                </div>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">20. Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan, keluhan, atau permintaan terkait Kebijakan Privasi ini atau data pribadi Anda, silakan hubungi kami:</p>
                <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 mt-4">
                    <p class="font-semibold">KOMPASKARIR INDONESIA</p>
                    <p>Email: <a href="mailto:privacy@kompaskarir.id" class="text-blue-600 dark:text-blue-400 hover:underline">privacy@kompaskarir.id</a></p>
                    <p>DPO: <a href="mailto:dpo@kompaskarir.id" class="text-blue-600 dark:text-blue-400 hover:underline">dpo@kompaskarir.id</a></p>
                    <p>Instagram: <a href="https://instagram.com/_azwar" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">@_azwar</a></p>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mt-6">
                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                        <strong>Catatan Hukum:</strong> Kebijakan Privasi ini disusun berdasarkan Undang-Undang No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP) dan peraturan pelaksanaannya. Jika terjadi perbedaan antara versi bahasa Indonesia dan terjemahan, versi bahasa Indonesia yang berlaku.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} KOMPASKARIR INDONESIA. Hak Cipta Dilindungi.</p>
            <div class="mt-4 flex justify-center space-x-6 text-sm">
                <a href="{{ route('legal.privacy') }}" class="text-gray-400 hover:text-white transition">Kebijakan Privasi</a>
                <a href="{{ route('legal.terms') }}" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a>
                <a href="/" class="text-gray-400 hover:text-white transition">Beranda</a>
            </div>
        </div>
    </footer>

</body>
</html>
