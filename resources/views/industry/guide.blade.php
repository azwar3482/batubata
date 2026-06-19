<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
        <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Panduan Penggunaan</span>
    </nav>

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Panduan Penggunaan Platform</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Pelajari cara memaksimalkan fitur-fitur KOMPASKARIR untuk proses rekrutmen yang efektif.</p>
        </div>
        <a href="{{ route('industry.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
            &laquo; Kembali
        </a>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="text-sm font-medium opacity-90">Langkah 1</div>
            </div>
            <div class="text-lg font-bold">Posting Lowongan</div>
            <div class="text-blue-100 text-sm mt-1">Buat lowongan dengan deskripsi yang menarik</div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div class="text-sm font-medium opacity-90">Langkah 2</div>
            </div>
            <div class="text-lg font-bold">Evaluasi Kandidat</div>
            <div class="text-purple-100 text-sm mt-1">Gunakan TPA untuk menyaring kandidat terbaik</div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="text-sm font-medium opacity-90">Langkah 3</div>
            </div>
            <div class="text-lg font-bold">Rekrut Terbaik</div>
            <div class="text-green-100 text-sm mt-1">Pilih kandidat yang paling sesuai</div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Guide Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Section 1: Posting Lowongan --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                    <h2 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                        Posting Lowongan yang Efektif
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Tulis Deskripsi yang Jelas</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Sertakan tanggung jawab utama dan ekspektasi peran secara detail. Hindari deskripsi yang terlalu umum.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Sebutkan Skill Spesifik</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Sertakan keahlian teknis dan non-teknis yang benar-benar dibutuhkan. Kandidat berkualitas mencari kata kunci skill yang sesuai.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Jelaskan Benefit & Budaya</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Gaji bukan satu-satunya faktor. Sebutkan fleksibilitas, asuransi, lingkungan kerja, dan kesempatan pengembangan karir.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Proses Rekrutmen Transparan</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Berikan estimasi waktu proses lamaran dan langkah-langkah yang akan dilalui kandidat (tes teknis, wawancara, dll).</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('industry.jobs.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Mulai Posting Lowongan
                    </a>
                </div>
            </div>

            {{-- Section 2: Seleksi Kandidat --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/30 dark:to-violet-900/30">
                    <h2 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <span class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                        Seleksi Kandidat dengan TPA
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Buat Tes TPA</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Konfigurasi jumlah soal, bobot per kategori, durasi, dan passing score sesuai kebutuhan posisi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Kirim Undangan</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Pilih kandidat yang lolos seleksi dokumen dan kirim undangan TPA (online atau offline).</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Evaluasi Hasil</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Lihat hasil tes, download laporan PDF, dan pilih kandidat terbaik untuk tahap interview.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('industry.tpa.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Kelola Tes TPA
                    </a>
                </div>
            </div>

            {{-- Section 3: Kelola Tim --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30">
                    <h2 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <span class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                        Kelola Tim Rekrutmen
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Undang Staff</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Tambahkan HR Manager, Recruiter, Talent Sourcer, atau Interviewer untuk membantu proses rekrutmen.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white">Atur Permission</div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Setiap role staff memiliki permission yang berbeda. Atur sesuai kebutuhan akses masing-masing.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('industry.team') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Kelola Tim
                    </a>
                </div>
            </div>
        </div>

        {{-- Right Sidebar: Quick Links & Tips --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Aksi Cepat</h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('industry.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors group">
                        <div class="w-9 h-9 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-white">Dashboard</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Kembali ke beranda</div>
                        </div>
                    </a>
                    <a href="{{ route('industry.jobs.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors group">
                        <div class="w-9 h-9 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-white">Posting Lowongan</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Buat lowongan baru</div>
                        </div>
                    </a>
                    <a href="{{ route('industry.tpa.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors group">
                        <div class="w-9 h-9 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center group-hover:bg-purple-200 dark:group-hover:bg-purple-800/50 transition-colors">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-white">Buat Tes TPA</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Konfigurasi tes baru</div>
                        </div>
                    </a>
                    <a href="{{ route('industry.candidates') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors group">
                        <div class="w-9 h-9 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center group-hover:bg-green-200 dark:group-hover:bg-green-800/50 transition-colors">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-white">Lihat Kandidat</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Kelola pelamar</div>
                        </div>
                    </a>
                    <a href="{{ route('industry.team') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-amber-50 dark:hover:bg-amber-900/30 transition-colors group">
                        <div class="w-9 h-9 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center group-hover:bg-amber-200 dark:group-hover:bg-amber-800/50 transition-colors">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-white">Kelola Tim</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Undang & atur staff</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl shadow-sm border border-amber-100 dark:border-amber-800/50 overflow-hidden">
                <div class="px-5 py-4 border-b border-amber-100 dark:border-amber-800/50">
                    <h3 class="font-bold text-amber-800 dark:text-amber-300 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        Tips Rekrutmen
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-start gap-2 text-sm text-amber-700 dark:text-amber-300">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Gunakan TPA untuk menyaring kandidat secara objektif</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm text-amber-700 dark:text-amber-300">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Set passing score sesuai tingkat kesulitan posisi</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm text-amber-700 dark:text-amber-300">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Download laporan PDF untuk dokumentasi</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm text-amber-700 dark:text-amber-300">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Undang staff untuk kolaborasi rekrutmen</span>
                    </div>
                </div>
            </div>

            {{-- Support --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="p-5 text-center">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm mb-1">Butuh Bantuan?</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Hubungi tim support kami untuk bantuan teknis</p>
                    <a href="mailto:support@kompaskarir.com" class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        support@kompaskarir.com
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</x-app-layout>

