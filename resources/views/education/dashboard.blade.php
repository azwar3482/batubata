<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Dashboard Institusi Pendidikan</h2>
                    <p class="mt-2 text-gray-600">
                        Pantau kompetensi lulusan, analisis skill gap, dan tingkatkan kolaborasi dengan industri.
                    </p>
                </div>
                <div class="flex gap-3 flex-wrap">
                    <button
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Export Data
                    </button>
                    {{-- <button
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg> --}}
                    <!-- Ganti tombol "Tambah Program" -->
                    <a href="{{ route('seeker.education.programs.create') }}"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                        + Tambah Program
                    </a>
                    {{-- </button> --}}
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Lulusan -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Lulusan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">1,245</p>
                            <p class="text-sm text-green-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                +12% tahun ini
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Skill Gap -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Rata-rata Skill Gap</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">38.5%</p>
                            <p class="text-sm text-green-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                                -5% dari semester lalu
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Placement Rate -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Rate Penempatan Kerja
                            </p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">72%</p>
                            <p class="text-sm text-gray-500 mt-1">dalam 6 bulan setelah lulus</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Asesmen Diselesaikan -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Asesmen Selesai</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">892</p>
                            <p class="text-sm text-gray-500 mt-1">tahun akademik ini</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                <!-- Chart 1: Skill Gap per Jurusan -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Skill Gap Rata-rata per Jurusan</h3>
                        <select
                            class="text-sm border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option>Tahun 2024</option>
                            <option>Tahun 2023</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="jurusanChart"></canvas>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-4 text-center">
                        *Data berdasarkan hasil asesmen kompetensi lulusan
                    </p>
                </div>

                <!-- Chart 2: Top Kompetensi Bermasalah -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top 5 Kompetensi dengan Gap Tertinggi</h3>
                        <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">Lihat Semua</button>
                    </div>
                    <div class="h-64">
                        <canvas id="competencyChart"></canvas>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-4 text-center">
                        *Kompetensi yang perlu menjadi fokus perbaikan kurikulum
                    </p>
                </div>
            </div>

            <!-- Recommendations Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div
                    class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h3 class="text-lg font-bold text-gray-900">Rekomendasi Penyesuaian Kurikulum</h3>
                    <div class="flex gap-2">
                        <button
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">Filter</button>
                        <button
                            class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Export
                            CSV</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    Kompetensi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jurusan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gap Rata-rata</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rekomendasi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prioritas</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">1</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Data Analysis</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">Technical Skill</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Teknik Informatika</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-red-500 h-2 rounded-full" style="width: 52%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-red-600">52%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Tambah mata kuliah praktis Data Analytics dengan studi kasus industri
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Tinggi
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('education.partners.show', 1) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Detail</a>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">2</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Digital Marketing</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">Technical Skill</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Manajemen</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 45%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-yellow-600">45%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Kolaborasi dengan industri untuk magang dan proyek nyata
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Sedang
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('education.partners.show', 1) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Detail</a>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">3</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Project Management</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">Soft Skill</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Sistem Informasi</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 38%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-yellow-600">38%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Integrasi metode Agile/Scrum dalam pembelajaran proyek akhir
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Sedang
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('education.partners.show', 1) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Detail</a>
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">4</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Communication</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">Soft Skill</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Komunikasi</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-green-600">25%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Workshop presentasi dan public speaking rutin tiap semester
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Rendah
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('education.partners.show', 1) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800 flex items-center justify-between">
                    <div class="text-sm text-gray-500 dark:text-slate-400">
                        Menampilkan <span class="font-medium text-gray-900 dark:text-white">1</span> sampai <span class="font-medium text-gray-900 dark:text-white">4</span> dari <span class="font-medium text-gray-900 dark:text-white">12</span> data
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600 disabled:opacity-50" disabled>Sebelumnya</button>
                        <button class="px-3 py-1 text-sm border border-indigo-500 rounded-md bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">1</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600">2</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600">3</button>
                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600">Selanjutnya</button>
                    </div>
                </div>
            </div>

            <!-- Industry Collaboration Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-lg p-8 text-white mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">🤝 Kolaborasi dengan Industri</h3>
                        <p class="text-indigo-100 max-w-2xl">
                            Tingkatkan relevansi kurikulum dan kesempatan kerja lulusan Anda melalui kemitraan strategis
                            dengan perusahaan mitra KOMPASKARIR.
                        </p>
                    </div>
                    {{-- <div class="flex flex-col sm:flex-row gap-3">
                        <button
                            class="px-6 py-3 bg-white text-indigo-700 rounded-lg font-medium hover:bg-indigo-50 transition shadow">
                            Lihat Mitra Industri
                        </button>
                        <button
                            class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white/10 transition">
                            Ajukan Kolaborasi
                        </button>
                    </div> --}}
                    <!-- Ganti bagian tombol di collaboration banner -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('education.partners') }}"
                            class="px-6 py-3 bg-white text-indigo-700 rounded-lg font-medium hover:bg-indigo-50 transition shadow text-center">
                            Lihat Mitra Industri
                        </a>
                        <a href="{{ route('education.collaboration.create') }}"
                            class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white/10 transition text-center">
                            Ajukan Kolaborasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    <!-- Activity 1 -->
                    <div class="p-6 flex items-start gap-4 hover:bg-gray-50 transition">
                        <div
                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                125 lulusan Teknik Informatika menyelesaikan asesmen kompetensi
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Rata-rata skill gap: 35.2% • Posisi target terbanyak: Software Engineer
                            </p>
                            <p class="text-xs text-gray-400 mt-2">2 jam yang lalu</p>
                        </div>
                        <a href="#"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap">
                            Lihat Detail
                        </a>
                    </div>

                    <!-- Activity 2 -->
                    <div class="p-6 flex items-start gap-4 hover:bg-gray-50 transition">
                        <div
                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                Laporan kompetensi semester ganjil 2024 siap diunduh
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Berisi analisis lengkap per jurusan dan rekomendasi kurikulum
                            </p>
                            <p class="text-xs text-gray-400 mt-2">Kemarin</p>
                        </div>
                        <a href="#"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap">
                            Unduh PDF
                        </a>
                    </div>

                    <!-- Activity 3 -->
                    <div class="p-6 flex items-start gap-4 hover:bg-gray-50 transition">
                        <div
                            class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                Tech Corp Indonesia membuka program magang untuk lulusan Manajemen
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Kuota: 15 orang • Deadline: 30 Maret 2024
                            </p>
                            <p class="text-xs text-gray-400 mt-2">3 hari yang lalu</p>
                        </div>
                        <a href="#"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap">
                            Sebar ke Mahasiswa
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<!-- Chart.js Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Colors
        const chartColors = {
            blue: 'rgba(59, 130, 246, 0.8)',
            blueBorder: 'rgb(59, 130, 246)',
            indigo: 'rgba(99, 102, 241, 0.8)',
            indigoBorder: 'rgb(99, 102, 241)',
            red: 'rgba(239, 68, 68, 0.8)',
            redBorder: 'rgb(239, 68, 68)',
            green: 'rgba(34, 197, 94, 0.8)',
            greenBorder: 'rgb(34, 197, 94)',
            yellow: 'rgba(234, 179, 8, 0.8)',
            yellowBorder: 'rgb(234, 179, 8)',
            purple: 'rgba(147, 51, 234, 0.8)',
            purpleBorder: 'rgb(147, 51, 234)',
        };

        // Chart 1: Average Skill Gap by Major
        const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
        const jurusanChart = new Chart(jurusanCtx, {
            type: 'bar',
            data: {
                labels: ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Komunikasi',
                    'Akuntansi'
                ],
                datasets: [{
                    label: 'Skill Gap (%)',
                    data: [38, 42, 35, 48, 30],
                    backgroundColor: [
                        chartColors.blue,
                        chartColors.purple,
                        chartColors.green,
                        chartColors.red,
                        chartColors.yellow
                    ],
                    borderColor: [
                        chartColors.blueBorder,
                        chartColors.purpleBorder,
                        chartColors.greenBorder,
                        chartColors.redBorder,
                        chartColors.yellowBorder
                    ],
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Gap: ${context.parsed.y}%`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart 2: Top Competency Gap (Horizontal Bar)
        const competencyCtx = document.getElementById('competencyChart').getContext('2d');
        const competencyChart = new Chart(competencyCtx, {
            type: 'bar',
            data: {
                labels: ['Data Analysis', 'Digital Marketing', 'Project Mgmt', 'Cloud Computing',
                    'Cybersecurity'
                ],
                datasets: [{
                    label: 'Gap (%)',
                    data: [52, 45, 38, 35, 32],
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.redBorder,
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Gap: ${context.parsed.x}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Dynamic Dark Mode for Chart.js
        function updateChartColors(chart, isDark) {
            const textColor = isDark ? '#9ca3af' : '#6b7280'; // gray-400 vs gray-500
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
            const tooltipBg = isDark ? 'rgba(31, 41, 55, 0.95)' : 'rgba(255, 255, 255, 0.95)';
            const tooltipText = isDark ? '#f9fafb' : '#1f2937';

            if (chart.options.plugins.legend) {
                if (chart.options.plugins.legend.labels) {
                    chart.options.plugins.legend.labels.color = textColor;
                }
            }
            if (chart.options.plugins.tooltip) {
                chart.options.plugins.tooltip.backgroundColor = tooltipBg;
                chart.options.plugins.tooltip.titleColor = tooltipText;
                chart.options.plugins.tooltip.bodyColor = tooltipText;
            }
            
            if (chart.options.scales.x) {
                if (chart.options.scales.x.ticks) chart.options.scales.x.ticks.color = textColor;
                if (!chart.options.scales.x.grid) chart.options.scales.x.grid = {};
                chart.options.scales.x.grid.color = gridColor;
            }
            if (chart.options.scales.y) {
                if (chart.options.scales.y.ticks) chart.options.scales.y.ticks.color = textColor;
                if (!chart.options.scales.y.grid) chart.options.scales.y.grid = {};
                chart.options.scales.y.grid.color = gridColor;
            }
            chart.update();
        }

        const isDark = document.documentElement.classList.contains('dark');
        updateChartColors(jurusanChart, isDark);
        updateChartColors(competencyChart, isDark);

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isDarkNow = document.documentElement.classList.contains('dark');
                    updateChartColors(jurusanChart, isDarkNow);
                    updateChartColors(competencyChart, isDarkNow);
                }
            });
        });
        
        observer.observe(document.documentElement, { attributes: true });
    });
</script>

<!-- Driver.js for Tour -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const driver = window.driver.js.driver;
        const tourConfig = {
            showProgress: true,
            nextBtnText: 'Lanjut ➔',
            prevBtnText: '⬅ Kembali',
            doneBtnText: 'Selesai',
            popoverClass: 'driverjs-theme',
            steps: [
                {
                    popover: {
                        title: '👋 Selamat Datang di Panel Edukasi',
                        description: 'Mari kita kenali berbagai fitur di dashboard ini yang membantu Anda memantau kompetensi lulusan dan menganalisis skill gap.',
                        align: 'center'
                    }
                },
                {
                    element: 'header',
                    popover: {
                        title: '🌐 Top Navbar',
                        description: 'Di menu atas ini Anda bisa mengubah bahasa (ID/EN), mengaktifkan Dark Mode, melihat notifikasi, mengakses profil, dan Log Out.',
                        side: "bottom",
                        align: 'center'
                    }
                },
                {
                    element: 'a[href*="education/dashboard"]',
                    popover: {
                        title: '📊 Dashboard',
                        description: 'Menu ini menampilkan ringkasan performa lulusan, analisis skill gap rata-rata per jurusan, dan peluang kolaborasi dengan industri.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'a[href*="education/analytics"]',
                    popover: {
                        title: '📈 Analitik Lulusan',
                        description: 'Lihat laporan analitik mendalam terkait kompetensi apa yang paling kurang dari lulusan agar dapat menyesuaikan kurikulum.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'a[href*="education/students"]',
                    popover: {
                        title: '👩‍🎓 Data Siswa / Lulusan',
                        description: 'Kelola data siswa atau alumni Anda. Lihat progress belajar dan skor asesmen masing-masing individu secara detail.',
                        side: "right",
                        align: 'start'
                    }
                }
            ]
        };

        const startTourBtn = document.getElementById('start-tour-btn');
        if (startTourBtn) {
            startTourBtn.addEventListener('click', () => {
                driver(tourConfig).drive();
            });
        }

        // Auto play saat halaman terbuka
        const autoDriver = driver(tourConfig);
        autoDriver.drive();
    });
</script>
<style>
    /* Driver.js Custom Styling */
    .driverjs-theme {
        font-family: inherit;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
    .driver-popover-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937; /* text-gray-900 */
    }
    .driver-popover-description {
        font-size: 13.5px;
        line-height: 1.5;
        color: #4b5563; /* text-gray-600 */
    }
    .driver-popover-footer {
        margin-top: 12px;
    }
    .driver-popover-progress-text {
        font-size: 12px;
        color: #6b7280;
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        html.dark .driverjs-theme {
            background-color: #1e293b; /* bg-slate-800 */
            color: #e2e8f0;
        }
        html.dark .driver-popover-title {
            color: #f8fafc;
        }
        html.dark .driver-popover-description {
            color: #cbd5e1; /* text-slate-300 */
        }
        html.dark .driver-popover-progress-text {
            color: #94a3b8;
        }
        html.dark .driver-popover-footer .driver-popover-btn {
            background-color: #334155;
            color: #f8fafc;
            border: 1px solid #475569;
            text-shadow: none;
        }
        html.dark .driver-popover-footer .driver-popover-btn:hover {
            background-color: #475569;
        }
        html.dark .driver-popover-arrow {
            border-color: #1e293b;
        }
    }
</style>