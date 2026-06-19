<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kursus</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Progres Belajar</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Progres Belajar Saya</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Pantau kemajuan belajar Anda.</p>
                </div>
                <a href="{{ route('seeker.courses.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-650 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Jelajahi Kursus
                </a>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-100 dark:border-green-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-900 dark:text-green-200 mb-1">Tentang Progres Kursus</h4>
                        <p class="text-sm text-green-700 dark:text-green-300 leading-relaxed">Pantau semua kursus yang sudah Anda daftarkan. Lihat <strong>status</strong> (sedang berjalan/selesai), <strong>persentase progres</strong>, dan <strong>tanggal penyelesaian</strong>. Klik <strong>"Lanjutkan"</strong> untuk melanjutkan belajar atau <strong>"Selesai"</strong> jika sudah menyelesaikan kursus.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $totalEnrolled = $progress->count();
                    $completed = $progress->where('status', 'completed')->count();
                    $inProgress = $progress->where('status', 'in_progress')->count();
                    $avgProgress = $totalEnrolled > 0 ? round($progress->avg('progress_percentage')) : 0;
                @endphp
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-slate-400">Total Kursus</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalEnrolled }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-slate-400">Sedang Berjalan</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $inProgress }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-slate-400">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completed }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-slate-400">Rata-rata Progress</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $avgProgress }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation & Content -->
            <div x-data="{ activeTab: 'classes' }" class="mt-8">
                <!-- Tabs -->
                <div class="mb-6 flex border-b border-gray-200 dark:border-slate-700">
                    <button @click="activeTab = 'classes'" 
                        :class="activeTab === 'classes' ? 'border-blue-600 text-blue-600 dark:text-blue-400 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-slate-400'"
                        class="py-3 px-6 border-b-2 text-sm font-medium transition focus:outline-none flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Kelas & Pelatihan Pengajar
                        <span class="ml-1.5 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 rounded-full font-bold">
                            {{ $classEnrollments->count() }}
                        </span>
                    </button>
                    <button @click="activeTab = 'courses'" 
                        :class="activeTab === 'courses' ? 'border-blue-600 text-blue-600 dark:text-blue-400 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-slate-400'"
                        class="py-3 px-6 border-b-2 text-sm font-medium transition focus:outline-none flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Kursus Mandiri
                        <span class="ml-1.5 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 rounded-full font-bold">
                            {{ $progress->count() }}
                        </span>
                    </button>
                </div>

                <!-- Tab 1: Kelas & Pelatihan Pengajar -->
                <div x-show="activeTab === 'classes'" x-transition class="space-y-4">
                    @forelse($classEnrollments as $enrollment)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-md transition duration-300">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $enrollment->classRoom->course->title }}
                                        </h3>
                                        @if($enrollment->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                                Selesai
                                            </span>
                                        @elseif($enrollment->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                                Aktif
                                            </span>
                                        @elseif($enrollment->status === 'dropped')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">
                                                Dikeluarkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400 mb-4">
                                        Kelas: <span class="font-bold text-gray-850 dark:text-slate-200">{{ $enrollment->classRoom->name }}</span> 
                                        &middot; Kode Kelas: <span class="font-mono bg-gray-100 dark:bg-slate-700 px-1.5 py-0.5 rounded text-xs text-gray-700 dark:text-slate-300">{{ $enrollment->classRoom->code }}</span>
                                    </p>
                                    <div class="flex flex-wrap items-center gap-5 text-xs text-gray-500 dark:text-slate-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Pengajar: <strong>{{ $enrollment->classRoom->teacher->name }}</strong>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Terdaftar: {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('d M Y') : '-' }}
                                        </span>
                                        @if($enrollment->final_score !== null)
                                            <span class="flex items-center gap-1 px-2.5 py-1 rounded font-bold text-xs {{ $enrollment->final_score >= 70 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400' }}">
                                                Nilai Akhir: {{ $enrollment->final_score }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0 self-start md:self-center">
                                    @if($enrollment->status === 'completed' && $enrollment->final_score !== null && $enrollment->final_score >= 70)
                                        <a href="{{ route('courses.certificate', $enrollment->id) }}" target="_blank"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-lg transition shadow hover:shadow-md text-sm font-bold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                            Lihat Sertifikat
                                        </a>
                                    @elseif($enrollment->status === 'completed' && $enrollment->final_score !== null && $enrollment->final_score < 70)
                                        <span class="text-xs font-semibold text-red-500 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg max-w-[200px] text-center md:text-right">
                                            Nilai akhir ({{ $enrollment->final_score }}%) tidak memenuhi kriteria sertifikat (min. 70%)
                                        </span>
                                    @elseif($enrollment->status === 'completed')
                                        <span class="text-xs font-semibold text-gray-500 bg-gray-50 dark:bg-slate-700 px-3 py-2 rounded-lg">
                                            Menunggu Penilaian Pengajar
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-3 py-2 rounded-lg flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                            Pembelajaran Berlangsung
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 dark:text-slate-650 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Terdaftar di Kelas</h3>
                        <p class="text-gray-500 dark:text-slate-400 mb-6">Hubungi pengajar Anda untuk didaftarkan ke kelas pelatihan.</p>
                        <a href="{{ route('seeker.courses.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Jelajahi Kursus
                        </a>
                    </div>
                    @endforelse
                </div>

                <!-- Tab 2: Kursus Mandiri -->
                <div x-show="activeTab === 'courses'" x-transition class="space-y-4" style="display: none;">
                    @forelse($progress as $item)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $item->course->title }}</h3>
                                        @if($item->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                                Selesai
                                            </span>
                                        @elseif($item->status === 'in_progress')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-green-300">
                                                Sedang Berjalan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300">
                                                Belum Dimulai
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400 mb-3">{{ Str::limit($item->course->description, 150) }}</p>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $item->course->duration_hours }} jam
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            {{ $item->course->competency->name ?? '-' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                            </svg>
                                            {{ ucfirst($item->course->level) }}
                                        </span>
                                        @if($item->started_at)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Mulai: {{ $item->started_at->format('d M Y') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-6 flex flex-col items-end gap-3">
                                    <!-- Progress Bar -->
                                    <div class="w-32">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ $item->progress_percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full transition-all duration-500 {{ $item->status === 'completed' ? 'bg-green-500' : 'bg-blue-500' }}" 
                                                style="width: {{ $item->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        @if($item->status === 'completed')
                                        <a href="{{ route('courses.platform-certificate', $item->id) }}" target="_blank"
                                            class="inline-flex items-center px-3 py-1.5 text-xs bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-lg transition shadow-sm hover:shadow font-bold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                            Sertifikat
                                        </a>
                                        @endif
                                        <a href="{{ route('seeker.courses.show', $item->course->id) }}" 
                                            class="inline-flex items-center px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            {{ $item->status === 'completed' ? 'Review' : 'Lanjutkan' }}
                                        </a>
                                        @if($item->status === 'in_progress')
                                        <form action="{{ route('seeker.courses.complete', $item->course->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                Selesai
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($item->completed_at)
                            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-slate-700">
                                <p class="text-sm text-green-600 dark:text-green-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Selesai pada {{ $item->completed_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Kursus</h3>
                        <p class="text-gray-500 dark:text-slate-400 mb-6">Anda belum terdaftar di kursus manapun.</p>
                        <a href="{{ route('seeker.courses.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Jelajahi Kursus
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
