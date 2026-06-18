<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan - KOMPASKARIR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/jpeg">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Syarat & Ketentuan</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mb-8">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>

            <div class="prose prose-slate dark:prose-invert max-w-none space-y-6 text-gray-700 dark:text-slate-300 leading-relaxed">

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">1. Pendahuluan</h2>
                <p>Selamat datang di KOMPASKARIR, platform Skill Gap Advisor yang diselenggarakan oleh KOMPASKARIR INDONESIA ("KOMPASKARIR", "kami"). Syarat & Ketentuan ini mengatur akses dan penggunaan Anda terhadap platform kami yang tersedia melalui website dan aplikasi mobile ("Layanan").</p>
                <p>Dengan mendaftar, mengakses, atau menggunakan Layanan kami, Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat oleh Syarat & Ketentuan ini. Jika Anda tidak setuju, mohon untuk tidak menggunakan Layanan kami.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">2. Definisi</h2>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>"Platform"</strong> mengacu pada sistem KOMPASKARIR yang mencakup website dan aplikasi mobile.</li>
                    <li><strong>"Pengguna"</strong> adalah setiap individu atau entitas yang mengakses atau menggunakan Platform.</li>
                    <li><strong>"Pencari Kerja"</strong> adalah pengguna yang mendaftar dengan peran individu yang mencari peluang karir.</li>
                    <li><strong>"Perusahaan/HRD"</strong> adalah pengguna yang mendaftar dengan peran perusahaan atau perekrut tenaga kerja.</li>
                    <li><strong>"Institusi Pendidikan"</strong> adalah pengguna yang mendaftar dengan peran lembaga pendidikan.</li>
                    <li><strong>"Guru/Pengajar"</strong> adalah pengguna yang mendaftar dengan peran pengajar yang mengelola kursus dan kelas.</li>
                    <li><strong>"Konten"</strong> mencakup semua teks, gambar, dokumen, data, dan materi yang tersedia di Platform.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">3. Pendaftaran Akun</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">3.1 Persyaratan Pendaftaran</h3>
                <p>Untuk menggunakan Layanan, Anda harus:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Berusia minimal 17 tahun atau telah menikah</li>
                    <li>Memiliki kapasitas hukum untuk mengikatkan diri dalam perjanjian</li>
                    <li>Memberikan informasi yang akurat, terkini, dan lengkap saat mendaftar</li>
                    <li>Memiliki alamat email yang valid</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">3.2 Keamanan Akun</h3>
                <p>Anda bertanggung jawab untuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Menjaga kerahasiaan kata sandi akun Anda</li>
                    <li>Semua aktivitas yang terjadi di bawah akun Anda</li>
                    <li>Segera memberitahukan kami jika ada penggunaan akun tanpa izin</li>
                </ul>
                <p>Kami tidak bertanggung jawab atas kerugian yang timbul dari penggunaan akun Anda oleh pihak lain.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">3.3 Satu Akun per Pengguna</h3>
                <p>Setiap pengguna hanya diperbolehkan memiliki satu akun. Pembuatan akun ganda dapat mengakibatkan penangguhan atau penghapusan akun.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">4. Peran dan Tanggung Jawab Pengguna</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.1 Pencari Kerja</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Bertanggung jawab atas keakuratan informasi profil dan dokumen yang diunggah</li>
                    <li>Memahami bahwa hasil asesmen bersifat self-assessment dan dapat berbeda dari evaluasi pihak lain</li>
                    <li>Tidak menggunakan platform untuk tujuan penipuan atau pemalsuan dokumen</li>
                    <li>Memenuhi persyaratan kelengkapan profil sebelum melamar pekerjaan (minimal 100% kelengkapan dan skill gap maksimal 30%)</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.2 Perusahaan/HRD</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Bertanggung jawab atas keakuratan informasi lowongan pekerjaan yang dipublikasikan</li>
                    <li>Tidak mendiskriminasi kandidat berdasarkan SARA (Suku, Agama, Ras, dan Antargolongan)</li>
                    <li>Menjaga kerahasiaan data kandidat yang diperoleh melalui platform</li>
                    <li>Menggunakan data kandidat hanya untuk tujuan rekrutmen yang sah</li>
                    <li>Mematuhi ketenagakerjaan yang berlaku</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">4.3 Institusi Pendidikan</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Bertanggung jawab atas keakuratan informasi institusi dan program pendidikan</li>
                    <li>Menggunakan data mahasiswa/siswa hanya untuk tujuan pendidikan yang sah</li>
                    <li>Tidak menyebarkan data kompetensi mahasiswa tanpa persetujuan</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">5. Penggunaan yang Dilarang</h2>
                <p>Anda dilarang menggunakan Platform untuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Melanggar hukum atau peraturan yang berlaku</li>
                    <li>Memalsukan identitas atau dokumen</li>
                    <li>Mengunggah konten yang mengandung virus, malware, atau kode berbahaya</li>
                    <li>Melakukan scraping, crawling, atau pengambilan data secara otomatis tanpa izin</li>
                    <li>Mengganggu, merusak, atau membebani infrastruktur Platform</li>
                    <li>Mengirim spam, pesan berulang, atau komunikasi yang tidak diinginkan</li>
                    <li>Melakukan pelecehan, intimidasi, atau diskriminasi terhadap pengguna lain</li>
                    <li>Melanggar hak kekayaan intelektual pihak lain</li>
                    <li>Mencoba mendapatkan akses tidak sah ke akun atau sistem lain</li>
                    <li>Menggunakan fitur chat AI untuk tujuan yang melanggar hukum atau merugikan</li>
                    <li>Melakukan injeksi prompt atau manipulasi sistem AI</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">6. Konten dan Dokumen Pengguna</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">6.1 Kepemilikan Konten</h3>
                <p>Anda tetap memiliki hak atas konten dan dokumen yang Anda unggah ke Platform. Dengan mengunggah konten, Anda memberikan lisensi kepada kami untuk menggunakan, memproses, dan menampilkan konten tersebut dalam rangka menyediakan Layanan.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">6.2 Analisis Dokumen oleh AI</h3>
                <p>Dokumen yang Anda unghah (CV, ijazah, transkrip, sertifikat, portofolio) akan dianalisis secara otomatis menggunakan teknologi NLP dan AI. Hasil analisis bersifat otomatis dan mungkin tidak selalu 100% akurat. Anda bertanggung jawab untuk memverifikasi hasil analisis tersebut.</p>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">6.3 Konten yang Dilarang</h3>
                <p>Anda tidak diperbolehkan mengunggah konten yang:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Palsu, menyesatkan, atau memalsukan kualifikasi</li>
                    <li>Mengandung unsur pornografi, kekerasan, atau SARA</li>
                    <li>Melanggar hak cipta atau hak kekayaan intelektual pihak lain</li>
                    <li>Mengandung informasi pribadi pihak lain tanpa persetujuan</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">7. Asesmen dan Tes Potensi Akademik</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">7.1 Asesmen Kompetensi</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Asesmen kompetensi bersifat self-assessment (penilaian mandiri)</li>
                    <li>Hasil asesmen digunakan untuk analisis kesenjangan keahlian dan rekomendasi pengembangan karir</li>
                    <li>Kami tidak menjamin bahwa hasil asesmen akan menghasilkan panggilan wawancara atau penawaran kerja</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">7.2 Tes Potensi Akademik (TPA)</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>TPA diselenggarakan oleh perusahaan/HRD dan dapat bersifat online atau offline</li>
                    <li>Anda wajib menyelesaikan tes dalam waktu yang ditentukan</li>
                    <li>Curang dalam TPA dapat mengakibatkan diskualifikasi dan penangguhan akun</li>
                    <li>Hasil TPA menjadi milik perusahaan yang menyelenggarakan dan dapat digunakan dalam proses rekrutmen</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">8. Fitur Chat dan Komunikasi</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">8.1 Chatbot AI</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Chatbot AI menyediakan informasi dan panduan terkait penggunaan Platform</li>
                    <li>Respons chatbot dihasilkan oleh kecerdasan buatan dan mungkin tidak selalu akurat</li>
                    <li>Jangan membagikan informasi sensitif (kata sandi, nomor kartu kredit) melalui chatbot</li>
                    <li>Kami berhak memantau dan menyimpan riwayat chat untuk peningkatan layanan</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">8.2 Chat Langsung</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Fitur chat langsung memungkinkan komunikasi antara pencari kerja dan perusahaan</li>
                    <li>Gunakan fitur ini dengan sopan dan profesional</li>
                    <li>Dilarang menggunakan chat langsung untuk spam, penipuan, atau pelecehan</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">9. Kursus dan Pembelajaran</h2>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Kursus tersedia melalui institusi pendidikan dan pengajar yang terdaftar</li>
                    <li>Konten kursus adalah milik pengajar atau institusi yang membuatnya</li>
                    <li>Sertifikat penyelesaian diterbitkan berdasarkan kriteria yang ditetapkan oleh penyelenggara kursus</li>
                    <li>Kami tidak menjamin kualitas atau akurasi konten kursus dari pihak ketiga</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">10. Kekayaan Intelektual</h2>
                <p>Seluruh konten Platform yang tidak diunggah oleh pengguna, termasuk namun tidak terbatas pada desain, logo, teks, grafik, perangkat lunak, dan algoritma, adalah milik KOMPASKARIR dan dilindungi oleh hukum kekayaan intelektual Indonesia.</p>
                <p>Anda tidak diperbolehkan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Menyalin, memodifikasi, atau mendistribusikan konten Platform tanpa izin</li>
                    <li>Merekayasa balik (reverse engineer) perangkat lunak Platform</li>
                    <li>Menggunakan merek dagang, logo, atau identitas visual KOMPASKARIR tanpa izin tertulis</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">11. Batasan Tanggung Jawab</h2>
                <p>KOMPASKARIR menyediakan Platform "sebagaimana adanya" dan "sebagaimana tersedia". Kami tidak menjamin bahwa:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Platform akan selalu tersedia, bebas gangguan, atau bebas kesalahan</li>
                    <li>Hasil asesmen atau rekomendasi akan menghasilkan pekerjaan atau kesuksesan karir</li>
                    <li>Informasi di Platform selalu akurat, terkini, atau lengkap</li>
                    <li>Dokumen atau konten yang diunggah pengguna adalah asli atau akurat</li>
                </ul>
                <p>Dalam batas yang diizinkan oleh hukum, KOMPASKARIR tidak bertanggung jawab atas kerugian tidak langsung, insidental, khusus, atau konsekuensional yang timbul dari penggunaan atau ketidakmampuan menggunakan Platform.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">12. Penangguhan dan Penghapusan Akun</h2>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">12.1 Penangguhan oleh Kami</h3>
                <p>Kami berhak menangguhkan atau menghapus akun Anda jika:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Anda melanggar Syarat & Ketentuan ini</li>
                    <li>Anda menggunakan Platform untuk aktivitas ilegal</li>
                    <li>Akun Anda tidak aktif selama lebih dari 12 bulan</li>
                    <li>Kami diwajibkan oleh hukum untuk melakukannya</li>
                </ul>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-6">12.2 Penghapusan oleh Pengguna</h3>
                <p>Anda dapat menghapus akun Anda kapan saja melalui pengaturan profil. Penghapusan akun akan mengakibatkan:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Hilangnya akses ke semua data dan layanan</li>
                    <li>Tidak dapat memulihkan akun atau data setelah penghapusan</li>
                    <li>Beberapa data mungkin tetap tersimpan untuk kepatuhan hukum</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">13. Ganti Rugi</h2>
                <p>Anda setuju untuk mengganti rugi dan membebaskan KOMPASKARIR, termasuk direktur, karyawan, dan afiliasinya, dari segala klaim, kerugian, kewajiban, dan biaya (termasuk biaya hukum) yang timbul dari:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Pelanggaran Anda terhadap Syarat & Ketentuan ini</li>
                    <li>Penggunaan Platform yang melanggar hukum</li>
                    <li>Pelanggaran Anda terhadap hak pihak ketiga</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">14. Perubahan Syarat & Ketentuan</h2>
                <p>Kami berhak mengubah Syarat & Ketentuan ini kapan saja. Perubahan akan diberitahakan melalui email atau pemberitahuan di Platform. Penggunaan Platform yang berkelanjutan setelah perubahan merupakan persetujuan Anda terhadap Syarat & Ketentuan yang diperbarui.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">15. Hukum yang Berlaku</h2>
                <p>Syarat & Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Negara Republik Indonesia. Setiap sengketa yang timbul akan diselesaikan melalui musyawarah terlebih dahulu, dan jika tidak tercapai, akan diselesaikan melalui Pengadilan Negeri yang berwenang di Indonesia.</p>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">16. Ketentuan Lain</h2>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Jika ada ketentuan dalam Syarat & Ketentuan ini yang dianggap tidak sah atau tidak dapat dilaksanakan, ketentuan lainnya tetap berlaku penuh.</li>
                    <li>Kegagalan kami untuk menegakkan hak atau ketentuan dalam Syarat & Ketentuan ini tidak dianggap sebagai pengabaian hak tersebut.</li>
                    <li>Syarat & Ketentuan ini merupakan kesepakatan lengkap antara Anda dan KOMPASKARIR terkait penggunaan Platform.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">17. Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan atau keluhan terkait Syarat & Ketentuan ini, silakan hubungi kami:</p>
                <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 mt-4">
                    <p class="font-semibold">KOMPASKARIR INDONESIA</p>
                    <p>Email: <a href="mailto:legal@kompaskarir.id" class="text-blue-600 dark:text-blue-400 hover:underline">legal@kompaskarir.id</a></p>
                    <p>Instagram: <a href="https://instagram.com/_azwar" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">@_azwar</a></p>
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
