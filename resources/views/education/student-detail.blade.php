<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('education.dashboard') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 text-sm">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <a href="{{ route('education.students') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 ml-1 md:ml-2 text-sm">
                                    Data Siswa
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-900 dark:text-white ml-1 md:ml-2 text-sm font-medium">{{ $student->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Detail Siswa (Job Seeker)</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">Informasi lengkap profil, kursus, dan perkembangan karir siswa.</p>
                </div>
                <a href="{{ route('education.students') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Siswa
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border-l-4 border-blue-500">
                    <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Profil Lengkap</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['profile_completion'] }}%</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border-l-4 border-purple-500">
                    <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Asesmen</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_assessments'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border-l-4 border-orange-500">
                    <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Rata-rata Gap</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['avg_gap'], 1) }}%</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border-l-4 border-green-500">
                    <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Kelas Aktif</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['active_enrollments'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border-l-4 border-teal-500">
                    <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Kursus Selesai</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['completed_courses'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border-l-4 border-pink-500">
                    <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Lamaran Kerja</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_applications'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Profile Card -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-24"></div>
                        <div class="px-6 pb-6">
                            <div class="flex justify-center -mt-12">
                                @php $photoDoc = $student->documents->where('document_type', 'photo')->first(); @endphp
                                @if($photoDoc)
                                    <img src="{{ asset('storage/' . $photoDoc->file_path) }}" class="h-24 w-24 rounded-full object-cover border-4 border-white dark:border-slate-900 shadow-lg" loading="lazy">
                                @else
                                    <div class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white text-3xl font-bold border-4 border-white dark:border-slate-900 shadow-lg">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-center mt-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $student->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-slate-400">{{ $student->email }}</p>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex justify-center mt-3">
                                @if($student->status === 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Aktif Mencari Kerja
                                    </span>
                                @elseif($student->status === 'inactive')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-300">
                                        <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>Tidak Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>{{ ucfirst($student->status ?? 'Bekerja') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Info -->
                            <div class="mt-6 space-y-3">
                                @if($student->phone)
                                <div class="flex items-center text-sm text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $student->phone }}
                                </div>
                                @endif

                                @if($student->address)
                                <div class="flex items-center text-sm text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $student->address }}
                                </div>
                                @endif

                                @if($student->gender)
                                <div class="flex items-center text-sm text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                                @endif

                                @if($student->birth_date)
                                <div class="flex items-center text-sm text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($student->birth_date)->format('d M Y') }}
                                </div>
                                @endif

                                <div class="flex items-center text-sm text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Bergabung: {{ $student->created_at->format('d M Y') }}
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="mt-6 flex justify-center gap-3">
                                @if($student->linkedin_url)
                                <a href="{{ $student->linkedin_url }}" target="_blank" class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition" title="LinkedIn">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                                @endif
                                @if($student->github_url)
                                <a href="{{ $student->github_url }}" target="_blank" class="p-2 bg-gray-50 dark:bg-slate-800 rounded-lg text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" title="GitHub">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                </a>
                                @endif
                                @if($student->portfolio_url)
                                <a href="{{ $student->portfolio_url }}" target="_blank" class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/40 transition" title="Portfolio">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Skills Card -->
                    @if($student->skills && count($student->skills) > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            Keahlian / Skills
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($student->skills as $skill)
                                <span class="px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm font-medium">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Languages Card -->
                    @if($student->languages && count($student->languages) > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                            Bahasa
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($student->languages as $lang)
                                <span class="px-3 py-1.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm font-medium">
                                    {{ $lang }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Documents Card -->
                    @if($student->documents->where('document_type', '!=', 'photo')->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Dokumen
                        </h4>
                        <div class="space-y-2">
                            @foreach($student->documents->where('document_type', '!=', 'photo') as $doc)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <div class="flex items-center">
                                    @if($doc->document_type === 'cv')
                                        <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @else
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $doc->file_name ?? ucfirst(str_replace('_', ' ', $doc->document_type)) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                    Lihat
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Bio Card -->
                    @if($student->bio)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Tentang Saya
                        </h4>
                        <p class="text-gray-600 dark:text-slate-400 leading-relaxed">{{ $student->bio }}</p>
                    </div>
                    @endif

                    <!-- Education & Career Info -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                            Informasi Pendidikan & Karir
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase tracking-wide">Pendidikan</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $student->education_level ?? '-' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase tracking-wide">Jurusan</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $student->major ?? '-' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase tracking-wide">Tahun Lulus</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $student->graduation_year ?? '-' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase tracking-wide">Pengalaman Kerja</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $student->experience_years ? $student->experience_years . ' tahun' : 'Fresh Graduate' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase tracking-wide">Posisi Target</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $student->target_position ?? '-' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase tracking-wide">Status</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                    @if($student->status === 'active') Aktif Mencari Kerja
                                    @elseif($student->status === 'inactive') Tidak Aktif
                                    @else {{ ucfirst($student->status ?? 'Bekerja') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Class Enrollments (Kursus yang Diikuti) -->
                    @if($student->classEnrollments && $student->classEnrollments->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Kelas / Kursus yang Diikuti
                        </h4>
                        <div class="space-y-3">
                            @foreach($student->classEnrollments as $enrollment)
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg border-l-4 {{ $enrollment->status === 'completed' ? 'border-green-500' : ($enrollment->status === 'active' ? 'border-blue-500' : 'border-gray-400') }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $enrollment->classRoom->course->title ?? 'Kursus' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Kelas: {{ $enrollment->classRoom->name ?? '-' }} ({{ $enrollment->classRoom->code ?? '-' }})</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Terdaftar: {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('d M Y') : '-' }}</p>
                                    </div>
                                    <div class="text-right ml-4">
                                        @if($enrollment->status === 'completed')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 font-medium">Selesai</span>
                                            @if($enrollment->final_score)
                                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Nilai: {{ $enrollment->final_score }}</p>
                                            @endif
                                        @elseif($enrollment->status === 'active')
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-medium">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300 font-medium">{{ ucfirst($enrollment->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if($enrollment->progress_percentage !== null)
                                <div class="mt-3">
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400 mb-1">
                                        <span>Progress</span>
                                        <span>{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                        <div class="h-2 rounded-full {{ $enrollment->progress_percentage >= 100 ? 'bg-green-500' : ($enrollment->progress_percentage >= 50 ? 'bg-blue-500' : 'bg-yellow-500') }}" style="width: {{ min($enrollment->progress_percentage, 100) }}%"></div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Assessments -->
                    @if($student->assessments && $student->assessments->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            Hasil Asesmen Kompetensi
                        </h4>
                        <div class="space-y-4">
                            @foreach($student->assessments as $assessment)
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $assessment->target_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $assessment->assessment_date ? $assessment->assessment_date->format('d M Y') : '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        @php $gap = $assessment->total_gap_percentage ?? 0; @endphp
                                        @if($gap <= 20)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 font-medium">Gap: {{ number_format($gap, 1) }}%</span>
                                        @elseif($gap <= 50)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 font-medium">Gap: {{ number_format($gap, 1) }}%</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 font-medium">Gap: {{ number_format($gap, 1) }}%</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Competency Scores -->
                                @if($assessment->scores && $assessment->scores->count() > 0)
                                <div class="mt-2 space-y-1">
                                    @foreach($assessment->scores->take(5) as $score)
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600 dark:text-slate-400">{{ $score->competency->name ?? '-' }}</span>
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5">
                                                <div class="h-1.5 rounded-full {{ $score->score >= 80 ? 'bg-green-500' : ($score->score >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $score->score ?? 0 }}%"></div>
                                            </div>
                                            <span class="text-gray-500 dark:text-slate-400 w-8 text-right">{{ $score->score ?? 0 }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if($assessment->scores->count() > 5)
                                    <p class="text-xs text-gray-400 dark:text-slate-500">+{{ $assessment->scores->count() - 5 }} kompetensi lainnya</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Career Roadmaps -->
                    @if($student->roadmaps && $student->roadmaps->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Roadmap Karir
                        </h4>
                        <div class="space-y-3">
                            @foreach($student->roadmaps->groupBy('position_id') as $positionId => $milestones)
                            @php $firstMilestone = $milestones->first(); @endphp
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg border-l-4 border-orange-500">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $firstMilestone->position->name ?? 'Roadmap' }}</p>
                                    @php $completed = $milestones->where('is_completed', true)->count(); @endphp
                                    <span class="text-xs text-gray-500 dark:text-slate-400">{{ $completed }}/{{ $milestones->count() }} selesai</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-orange-500" style="width: {{ $milestones->count() > 0 ? round(($completed / $milestones->count()) * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Job Applications -->
                    @if($student->jobApplications && $student->jobApplications->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Lamaran Kerja
                        </h4>
                        <div class="space-y-3">
                            @foreach($student->jobApplications->take(5) as $application)
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->jobListing->title ?? 'Posisi' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $application->jobListing->company->name ?? '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        @if($application->status === 'pending')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 font-medium">Menunggu</span>
                                        @elseif($application->status === 'accepted')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 font-medium">Diterima</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 font-medium">Ditolak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300 font-medium">{{ ucfirst($application->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
