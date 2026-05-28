<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Welcome Header -->
            <div
                class="relative overflow-hidden bg-gradient-to-r from-indigo-700 to-purple-800 rounded-3xl shadow-2xl p-8 text-white">
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold tracking-tight">Selamat Datang, Administrator</h2>
                    <p class="mt-2 text-indigo-100 text-lg max-w-2xl">Kendalikan ekosistem KompasKarir. Pantau
                        pertumbuhan pengguna, kualitas kompetensi, dan efisiensi sistem dalam satu panel kendali
                        terpadu.</p>
                </div>
                <!-- Abstract Background Shapes -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white dark:bg-slate-800/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-48 h-48 bg-indigo-500/20 rounded-full blur-2xl">
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div
                    class="group bg-white dark:bg-slate-800 p-1 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="flex items-center text-xs font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">+12.5%</span>
                        </div>
                        <h3 class="text-gray-500 dark:text-slate-400 text-sm font-medium">Total Pengguna</h3>
                        <div class="flex items-baseline space-x-2 mt-1">
                            <span
                                class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['total_users'] ?? 0) }}</span>
                            <span class="text-gray-400 dark:text-slate-500 text-xs font-normal">jiwa</span>
                        </div>
                    </div>
                </div>

                <!-- Total Assessments -->
                <div
                    class="group bg-white dark:bg-slate-800 p-1 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span
                                class="flex items-center text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Aktif</span>
                        </div>
                        <h3 class="text-gray-500 dark:text-slate-400 text-sm font-medium">Total Asesmen</h3>
                        <div class="flex items-baseline space-x-2 mt-1">
                            <span
                                class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['total_assessments'] ?? 0) }}</span>
                            <span class="text-gray-400 dark:text-slate-500 text-xs font-normal">kali</span>
                        </div>
                    </div>
                </div>

                <!-- Active Jobs -->
                <div
                    class="group bg-white dark:bg-slate-800 p-1 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="p-3 bg-emerald-50 rounded-xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+8
                                Baru</span>
                        </div>
                        <h3 class="text-gray-500 dark:text-slate-400 text-sm font-medium">Lowongan Aktif</h3>
                        <div class="flex items-baseline space-x-2 mt-1">
                            <span
                                class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['active_jobs'] ?? 0) }}</span>
                            <span class="text-gray-400 dark:text-slate-500 text-xs font-normal">posisi</span>
                        </div>
                    </div>
                </div>

                <!-- Average Gap -->
                <div
                    class="group bg-white dark:bg-slate-800 p-1 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="p-3 bg-orange-50 rounded-xl text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span
                                class="flex items-center text-xs font-bold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">Kritis</span>
                        </div>
                        <h3 class="text-gray-500 dark:text-slate-400 text-sm font-medium">Skill Gap Rata-rata</h3>
                        <div class="flex items-baseline space-x-2 mt-1">
                            <span class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">42</span>
                            <span class="text-gray-400 dark:text-slate-500 text-sm font-bold">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Table Section -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <div class="p-8 border-b border-gray-50 dark:border-slate-700 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pengguna Terdaftar Terbaru</h3>
                                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Pantau aktivitas pendaftaran real-time.</p>
                            </div>
                            <a href="{{ route('admin.users') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-xl hover:bg-indigo-100 transition">
                                Lihat Semua
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-slate-800/50/50 dark:bg-slate-900">
                                        <th
                                            class="px-8 py-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider tabular-nums">
                                            Pengguna</th>
                                        <th
                                            class="px-8 py-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider tabular-nums">
                                            Role</th>
                                        <th
                                            class="px-8 py-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider tabular-nums">
                                            Status</th>
                                        {{-- <th
                                            class="px-8 py-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider tabular-nums text-right">
                                            Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                                    @foreach ($stats['latest_users']->take(7) as $latest_user)
                                        <tr class="hover:bg-gray-50 dark:bg-slate-800/50/80 transition-colors">
                                            <td class="px-8 py-5">
                                                <div class="flex items-center space-x-4">
                                                    <div class="relative">
                                                        <div
                                                            class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                            {{ strtoupper(substr($latest_user->name, 0, 2)) }}
                                                        </div>
                                                        <div
                                                            class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                            {{ $latest_user->name }}</div>
                                                        <div class="text-xs text-gray-400 dark:text-slate-500">{{ $latest_user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-600">
                                                    {{ str_replace('_', ' ', ucwords($latest_user->role)) }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-5 text-sm text-gray-500 dark:text-slate-400">
                                                {{ $latest_user->created_at->diffForHumans() }}</td>
                                            {{-- <td class="px-8 py-5 text-right">
                                                <button class="p-2 text-gray-400 dark:text-slate-500 hover:text-indigo-600 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Quick Actions & Alerts -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Aksi Cepat
                        </h3>
                        <div class="grid grid-cols-1 gap-4">
                            <a href="{{ route('seeker.admin.settings') }}"
                                class="flex items-center p-4 bg-gray-50 dark:bg-slate-800/50 rounded-2xl hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all duration-300 group">
                                <div
                                    class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <span class="ml-4 text-sm font-bold text-gray-700">Kelola Kompetensi</span>
                                {{-- <h4 class="font-bold text-gray-800">Kelola Kompetensi & Pengaturan</h4>
                                <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Database skill, posisi karir, dan konfigurasi
                                    sistem.</p> --}}
                            </a>
                            <a href="#"
                                class="flex items-center p-4 bg-gray-50 dark:bg-slate-800/50 rounded-2xl hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all duration-300 group">
                                <div
                                    class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="ml-4 text-sm font-bold text-gray-700">Laporan Sistem</span>
                            </a>
                            <a href="#"
                                class="flex items-center p-4 bg-gray-50 dark:bg-slate-800/50 rounded-2xl hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all duration-300 group">
                                <div
                                    class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-4 text-sm font-bold text-gray-700">Pengaturan</span>
                            </a>
                        </div>
                    </div>

                    <!-- System Health -->
                    <div
                        class="bg-gradient-to-br from-gray-900 to-indigo-950 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold mb-4 flex items-center">
                                <span class="relative flex h-2 w-2 mr-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                System Health
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-400 dark:text-slate-500 font-medium">Server Uptime</span>
                                    <span class="font-bold text-green-400">99.9%</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-400 dark:text-slate-500 font-medium">Memory Usage</span>
                                    <span class="font-bold">42%</span>
                                </div>
                                <div class="mt-6">
                                    <div class="w-full bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 70%"></div>
                                    </div>
                                    <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-2 uppercase tracking-widest font-bold">
                                        Storage 240GB / 500GB</p>
                                </div>
                            </div>
                        </div>
                        <!-- Decoration -->
                        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-indigo-500/10 rounded-full"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
