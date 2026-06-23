<x-app-layout>
    @push('head-scripts')
    @vite(['resources/js/chart.js'])
    @endpush
    {{-- Skip to content untuk accessibility --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-600 focus:text-white focus:rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        Langsung ke konten utama
    </a>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Job Seeker') }}
            </h2>
            <button type="button" id="start-tour-btn"
                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 rounded-full transition-all duration-200 border border-blue-200 dark:border-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Mulai Tour
            </button>
        </div>
    </x-slot>

    <div class="py-4" id="main-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Session Messages --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-red-800 dark:text-red-400 px-4 py-3 rounded-xl flex items-start gap-3" role="alert">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-green-800 dark:text-green-400 px-4 py-3 rounded-xl flex items-start gap-3" role="alert">
                    <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- SECTION 1: Welcome + Onboarding + Streak (DIGABUNGKAN) --}}
            {{-- ============================================================ --}}
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl mb-4 sm:mb-6 border border-slate-100 dark:border-slate-800">
                <div class="p-4 sm:p-6">
                    {{-- Welcome + Streak --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg sm:text-xl font-bold shrink-0">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-2xl font-bold text-gray-800 dark:text-white">Halo, {{ $user->name }}! 👋</h3>
                                <p class="text-sm sm:text-base text-gray-600 dark:text-slate-400 mt-0.5 sm:mt-1">Siap untuk menutup kesenjangan skill kamu hari ini?</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3">
                            {{-- Login Streak --}}
                            @php
                                $streak = $user->login_streak ?? 1;
                            @endphp
                            <div class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/30 rounded-lg sm:rounded-xl">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                </svg>
                                <div>
                                    <span class="text-base sm:text-lg font-black text-amber-600 dark:text-amber-400">{{ $streak }}</span>
                                    <span class="text-[10px] sm:text-xs text-amber-600 dark:text-amber-400 font-medium">hari</span>
                                </div>
                            </div>
                            {{-- Achievement Badge --}}
                            @if($user->hasCompletedProfile())
                                <div class="hidden sm:flex items-center gap-1.5 px-3 py-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/30 rounded-xl achievement-badge">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    <span class="text-xs font-bold text-green-600 dark:text-green-400">Profil Sempurna</span>
                                </div>
                            @endif

                            @if(isset($totalAssessments) && $totalAssessments > 0 && isset($avgGap) && $avgGap < 30)
                                <div class="hidden sm:flex items-center gap-1.5 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/30 rounded-xl achievement-badge" style="animation-delay: 0.5s;">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400">Skill OK</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Profile Strength Bar --}}
                    <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1 sm:mb-1.5">
                                <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-slate-400">Kekuatan Profil</span>
                                <span class="text-xs sm:text-sm font-bold text-blue-600 dark:text-blue-400">{{ $user->profile_completion_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-slate-800 rounded-full h-2.5 sm:h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full progress-bar-animate" 
                                     style="width: {{ $user->profile_completion_percentage }}%"
                                     role="progressbar" 
                                     aria-valuenow="{{ $user->profile_completion_percentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"
                                     aria-label="Profil {{ $user->profile_completion_percentage }}% lengkap">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Onboarding Checklist --}}
                    @if(!$user->hasCompletedProfile())
                    <div class="border-t border-slate-100 dark:border-slate-800 pt-4 sm:pt-6">
                        <h4 class="text-xs sm:text-sm font-bold text-gray-700 dark:text-slate-300 mb-3 sm:mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Langkah Melengkapi Profil
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3">
                            {{-- Step 1: Data Diri --}}
                            @php
                                $hasPhoto = \App\Models\UserDocument::where('user_id', $user->id)->where('document_type', 'photo')->exists();
                                $step1Complete = !empty($user->name) && $hasPhoto && !empty($user->phone) && !empty($user->gender) && !empty($user->address);
                            @endphp
                            @if($step1Complete)
                                <div class="p-3 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-center gap-3 checklist-complete">
                                    <div class="p-1 bg-green-500 text-white rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">1. Data Diri Lengkap</h5>
                                        <p class="text-[10px] text-gray-500">✓ Selesai</p>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('profile.edit') }}" class="p-3 rounded-xl border border-gray-200 dark:border-slate-800 flex items-center gap-3 hover:border-blue-300 dark:hover:border-blue-800 hover:shadow-md transition-all duration-200 cursor-pointer bg-white dark:bg-slate-900 group">
                                    <div class="w-6 h-6 flex items-center justify-center border-2 border-blue-500 text-blue-500 rounded-full font-bold text-xs shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-colors">1</div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">Isi Data Diri</h5>
                                        <p class="text-[10px] text-gray-500 truncate">Nama, Foto, Telepon, Alamat</p>
                                    </div>
                                    <svg class="w-4 h-4 text-blue-400 shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif

                            {{-- Step 2: Pendidikan --}}
                            @php
                                $step2Complete = !empty($user->education_level) && !empty($user->major);
                            @endphp
                            @if($step2Complete)
                                <div class="p-3 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-center gap-3 checklist-complete">
                                    <div class="p-1 bg-green-500 text-white rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">2. Pendidikan</h5>
                                        <p class="text-[10px] text-gray-500">✓ Selesai</p>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('profile.edit') }}" class="p-3 rounded-xl border border-gray-200 dark:border-slate-800 flex items-center gap-3 hover:border-blue-300 dark:hover:border-blue-800 hover:shadow-md transition-all duration-200 cursor-pointer bg-white dark:bg-slate-900 group">
                                    <div class="w-6 h-6 flex items-center justify-center border-2 border-blue-500 text-blue-500 rounded-full font-bold text-xs shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-colors">2</div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">Riwayat Pendidikan</h5>
                                        <p class="text-[10px] text-gray-500 truncate">Tingkat & Jurusan</p>
                                    </div>
                                    <svg class="w-4 h-4 text-blue-400 shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif

                            {{-- Step 3: CV --}}
                            @php
                                $step3Complete = \App\Models\UserDocument::where('user_id', $user->id)->where('document_type', 'cv')->exists();
                            @endphp
                            @if($step3Complete)
                                <div class="p-3 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-center gap-3 checklist-complete">
                                    <div class="p-1 bg-green-500 text-white rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">3. Unggah CV</h5>
                                        <p class="text-[10px] text-gray-500">✓ Selesai</p>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('profile.edit') }}" class="p-3 rounded-xl border border-gray-200 dark:border-slate-800 flex items-center gap-3 hover:border-blue-300 dark:hover:border-blue-800 hover:shadow-md transition-all duration-200 cursor-pointer bg-white dark:bg-slate-900 group">
                                    <div class="w-6 h-6 flex items-center justify-center border-2 border-blue-500 text-blue-500 rounded-full font-bold text-xs shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-colors">3</div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">Unggah CV</h5>
                                        <p class="text-[10px] text-gray-500 truncate">Format PDF</p>
                                    </div>
                                    <svg class="w-4 h-4 text-blue-400 shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif

                            {{-- Step 4: Profil 100% --}}
                            @php
                                $step4Complete = $user->profile_completion_percentage === 100;
                            @endphp
                            @if($step4Complete)
                                <div class="p-3 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-center gap-3 checklist-complete">
                                    <div class="p-1 bg-green-500 text-white rounded-full shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">4. Profil 100%</h5>
                                        <p class="text-[10px] text-gray-500">✓ Semua kolom terisi</p>
                                    </div>
                                </div>
                            @else
                                <div class="p-3 rounded-xl border border-gray-200 dark:border-slate-800 flex items-center gap-3 bg-white dark:bg-slate-900 opacity-60">
                                    <div class="w-6 h-6 flex items-center justify-center border-2 border-gray-400 text-gray-400 rounded-full font-bold text-xs shrink-0">4</div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-xs text-gray-900 dark:text-white">Profil 100%</h5>
                                        <p class="text-[10px] text-gray-500 truncate">Isi semua kolom wajib (*)</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @else
                        {{-- Profil Lengkap - Achievement --}}
                        <div class="border-t border-slate-100 dark:border-slate-800 pt-6 text-center">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/30 rounded-full">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">Profil Anda Sudah Sempurna!</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Fitur pencarian kerja dan rekomendasi telah optimal.</p>
                            @if($totalAssessments == 0)
                                <a href="{{ url('/seeker/assessment') }}" class="inline-flex items-center mt-4 px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 transition transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    Ukur Skill Sekarang
                                </a>
                            @elseif($avgGap < 30)
                                <a href="{{ url('/seeker/jobs') }}" class="inline-flex items-center mt-4 px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 transition transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Cari Pekerjaan
                                </a>
                            @else
                                <a href="{{ url('/seeker/roadmap') }}" class="inline-flex items-center mt-4 px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 transition transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    Lihat Roadmap
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- SECTION 2: Stats Grid (dengan Ikon & Responsive) --}}
            {{-- ============================================================ --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6" role="region" aria-label="Statistik ringkasan">
                {{-- Total Asesmen --}}
                <div class="bg-white dark:bg-slate-900 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-2 sm:gap-3 mb-1.5 sm:mb-2">
                        <div class="p-1.5 sm:p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-gray-500 dark:text-slate-400 text-[10px] sm:text-xs font-medium">Total Asesmen</div>
                    <div class="text-lg sm:text-xl md:text-2xl font-bold dark:text-white mt-0.5 sm:mt-1">{{ $totalAssessments }}</div>
                </div>

                {{-- Skill Gap --}}
                <div class="bg-white dark:bg-slate-900 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl shadow-sm border {{ $avgGap > 30 ? 'border-red-200 dark:border-red-800/30' : 'border-green-200 dark:border-green-800/30' }} hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-2 sm:gap-3 mb-1.5 sm:mb-2">
                        <div class="p-1.5 sm:p-2 {{ $avgGap > 30 ? 'bg-red-100 dark:bg-red-900/30' : 'bg-green-100 dark:bg-green-900/30' }} rounded-lg">
                            @if($avgGap > 30)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            @else
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="text-gray-500 dark:text-slate-400 text-[10px] sm:text-xs font-medium">Rata-rata Skill Gap</div>
                    <div class="text-lg sm:text-xl md:text-2xl font-bold dark:text-white mt-0.5 sm:mt-1">{{ number_format($avgGap, 1) }}%</div>
                    @if($avgGap > 30)
                        <p class="text-[9px] sm:text-[10px] text-red-500 mt-1.5 sm:mt-2 leading-tight">Skill gap tinggi. Upskill sekarang!</p>
                        <a href="{{ url('/seeker/courses') }}" class="inline-flex items-center mt-1.5 sm:mt-2 px-2 sm:px-3 py-1 sm:py-1.5 border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-semibold transition">
                            Mulai Upskill →
                        </a>
                    @else
                        <p class="text-[9px] sm:text-[10px] text-green-600 mt-1.5 sm:mt-2 leading-tight">Skill gap aman. Pertahankan!</p>
                    @endif
                </div>

                {{-- Kursus Berjalan --}}
                <div class="bg-white dark:bg-slate-900 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-2 sm:gap-3 mb-1.5 sm:mb-2">
                        <div class="p-1.5 sm:p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-gray-500 dark:text-slate-400 text-[10px] sm:text-xs font-medium">Kursus Berjalan</div>
                    <div class="text-lg sm:text-xl md:text-2xl font-bold dark:text-white mt-0.5 sm:mt-1">{{ $coursesInProgress }}</div>
                </div>

                {{-- Rekomendasi --}}
                <div class="bg-white dark:bg-slate-900 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-2 sm:gap-3 mb-1.5 sm:mb-2">
                        <div class="p-1.5 sm:p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-gray-500 dark:text-slate-400 text-[10px] sm:text-xs font-medium">Rekomendasi</div>
                    <div class="text-lg sm:text-xl md:text-2xl font-bold dark:text-white mt-0.5 sm:mt-1">{{ count($recommendedJobs) }} Lowongan</div>
                </div>
            </div>


            {{-- ============================================================ --}}
            {{-- SECTION 3: Charts & Recommendations --}}
            {{-- ============================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

                {{-- Radar Chart --}}
                <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 md:p-6 rounded-lg sm:rounded-xl shadow-sm lg:col-span-2 border border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-4 mb-3 sm:mb-4">
                        <div>
                            <h4 class="text-base sm:text-lg font-bold text-gray-700 dark:text-slate-200">Analisis Kompetensi</h4>
                            <p class="text-[11px] sm:text-xs text-gray-500 dark:text-slate-400 mt-0.5 sm:mt-1">Perbandingan skill Anda dengan target industri</p>
                        </div>
                        <div class="hidden sm:flex items-center gap-4 text-xs">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                <span class="text-gray-500 dark:text-slate-400">Skill Saat Ini</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                <span class="text-gray-500 dark:text-slate-400">Target Industri</span>
                            </span>
                        </div>
                    </div>
                    {{-- Skeleton Loading --}}
                    <div id="chart-skeleton" class="animate-pulse">
                        <div class="flex items-center justify-center h-48 sm:h-56 md:h-64">
                            <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-full bg-gray-200 dark:bg-slate-700"></div>
                        </div>
                    </div>
                    <canvas id="skillRadarChart" class="hidden" aria-label="Grafik radar menunjukkan perbandingan skill Anda dengan target industri" role="img"></canvas>
                </div>

                {{-- Lowongan Cocok --}}
                <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 md:p-6 rounded-lg sm:rounded-xl shadow-sm border border-slate-100 dark:border-slate-800">
                    <h4 class="text-base sm:text-lg font-bold text-gray-700 dark:text-slate-200 mb-3 sm:mb-4">Lowongan Cocok</h4>
                    <div class="space-y-2 sm:space-y-3">
                        @forelse($recommendedJobs as $job)
                            <div class="border-b dark:border-slate-700 pb-2 sm:pb-3 last:border-0 flex items-start gap-2 sm:gap-3 group hover:bg-gray-50 dark:hover:bg-slate-800/50 -mx-1 sm:-mx-2 px-1 sm:px-2 py-1.5 sm:py-2 rounded-lg transition-colors">
                                @if($job->banner_image)
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-lg overflow-hidden shrink-0">
                                        <img src="{{ Storage::url($job->banner_image) }}" alt="Banner {{ $job->title }}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                @else
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-300 dark:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-xs sm:text-sm text-blue-600 dark:text-blue-400 truncate group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">{{ $job->title }}</h5>
                                    <p class="text-[10px] sm:text-xs text-gray-500 dark:text-slate-400 truncate mt-0.5">{{ $job->company_name }} • {{ $job->location }}</p>
                                    <span class="inline-block mt-1 px-1.5 sm:px-2 py-0.5 text-[9px] sm:text-[10px] bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full font-medium match-badge">Match: {{ $job->match_score ?? rand(70, 95) }}%</span>
                                </div>
                            </div>
                        @empty
                            {{-- Empty State --}}
                            <div class="text-center py-6 sm:py-8">
                                <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-slate-400 font-medium">Belum ada rekomendasi</p>
                                <p class="text-[10px] sm:text-xs text-gray-400 dark:text-slate-500 mt-1">Lengkapi profil Anda untuk mendapatkan rekomendasi lowongan</p>
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center mt-3 px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-600 text-white text-[11px] sm:text-xs font-medium rounded-lg hover:bg-blue-700 transition">
                                    Lengkapi Profil →
                                </a>
                            </div>
                        @endforelse
                    </div>
                    @if(count($recommendedJobs) > 0)
                        <a href="{{ route('seeker.jobs.all') }}"
                            class="block mt-3 sm:mt-4 w-full text-center bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-2 sm:py-2.5 rounded-lg sm:rounded-xl hover:from-blue-700 hover:to-indigo-800 text-xs sm:text-sm font-medium transition transform hover:-translate-y-0.5">
                            Lihat Semua Lowongan →
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STYLES (inline karena layout tidak support @push) --}}
    {{-- ============================================================ --}}
    <style>
        /* Progress bar animation */
        .progress-bar-animate {
            animation: progressGrow 1.5s ease-out forwards;
            transform-origin: left;
        }
        @keyframes progressGrow {
            from { width: 0%; }
        }

        /* Checklist complete animation */
        .checklist-complete {
            animation: checkPop 0.4s ease-out;
        }
        @keyframes checkPop {
            0% { transform: scale(0.95); opacity: 0.7; }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Match badge hover */
        .match-badge {
            transition: transform 0.2s ease;
        }
        .group:hover .match-badge {
            transform: scale(1.05);
        }

        /* Achievement badge pulse */
        .achievement-badge {
            animation: achievementPulse 2s ease-in-out infinite;
        }
        @keyframes achievementPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            50% { box-shadow: 0 0 0 4px rgba(34, 197, 94, 0); }
        }

        /* Driver.js Custom Styling */
        .driverjs-theme {
            font-family: inherit;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        .driver-popover-title { font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #1f2937; }
        .driver-popover-description { font-size: 13.5px; line-height: 1.5; color: #4b5563; }
        .driver-popover-footer { margin-top: 12px; }
        .driver-popover-progress-text { font-size: 12px; color: #6b7280; }
        @media (prefers-color-scheme: dark) {
            html.dark .driverjs-theme { background-color: #1e293b; color: #e2e8f0; }
            html.dark .driver-popover-title { color: #f8fafc; }
            html.dark .driver-popover-description { color: #cbd5e1; }
            html.dark .driver-popover-progress-text { color: #94a3b8; }
            html.dark .driver-popover-footer .driver-popover-btn { background-color: #334155; color: #f8fafc; border: 1px solid #475569; text-shadow: none; }
            html.dark .driver-popover-footer .driver-popover-btn:hover { background-color: #475569; }
            html.dark .driver-popover-arrow { border-color: #1e293b; }
        }
    </style>

    {{-- ============================================================ --}}
    {{-- SCRIPTS --}}
    {{-- ============================================================ --}}
    {{-- Chart.js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('skillRadarChart');
            const skeleton = document.getElementById('chart-skeleton');
            const data = @json($radarData);
            
            const isDarkMode = () => document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;

            const getChartOptions = (isDark) => ({
                elements: { line: { borderWidth: 3 } },
                plugins: {
                    legend: {
                        labels: {
                            color: isDark ? '#f8fafc' : '#374151',
                            font: { size: 13, weight: 'bold' }
                        }
                    }
                },
                scales: {
                    r: {
                        angleLines: { display: true, color: isDark ? 'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.1)' },
                        grid: { color: isDark ? 'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.1)' },
                        pointLabels: { color: isDark ? '#e2e8f0' : '#374151', font: { size: 12, weight: '500' } },
                        ticks: { backdropColor: 'transparent', color: isDark ? '#cbd5e1' : '#6b7280', font: { size: 10 } },
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                }
            });

            // Skeleton loading effect
            setTimeout(() => {
                skeleton.classList.add('hidden');
                ctx.classList.remove('hidden');

                const chart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: data.map(d => d.label),
                        datasets: [{
                            label: 'Skill Saat Ini',
                            data: data.map(d => d.current),
                            fill: true,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgb(59, 130, 246)',
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(59, 130, 246)'
                        }, {
                            label: 'Target Industri',
                            data: data.map(d => d.target),
                            fill: true,
                            backgroundColor: 'rgba(239, 68, 68, 0.2)',
                            borderColor: 'rgb(239, 68, 68)',
                            pointBackgroundColor: 'rgb(239, 68, 68)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(239, 68, 68)',
                            borderDash: [5, 5]
                        }]
                    },
                    options: getChartOptions(isDarkMode())
                });

                const observer = new MutationObserver(() => {
                    chart.options = getChartOptions(isDarkMode());
                    chart.update();
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }, 800);
        });
    </script>

    {{-- Driver.js Tour --}}
    @vite(['resources/js/driver.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const driver = driver;
            const driverObj = driver({
                showProgress: true,
                nextBtnText: 'Lanjut ➔',
                prevBtnText: '⬅ Kembali',
                doneBtnText: 'Selesai',
                popoverClass: 'driverjs-theme',
                allowClose: true,
                overlayClickNext: false,
                steps: [
                    {
                        popover: {
                            title: '👋 Selamat Datang Job Seeker!',
                            description: 'Mari kita kenali berbagai fitur di dashboard ini untuk membantu Anda mencapai karir impian.',
                            align: 'center'
                        }
                    },
                    {
                        element: 'a[href*="dashboard"]',
                        popover: {
                            title: '📊 Dashboard Utama',
                            description: 'Ringkasan statistik: total asesmen, gap skill, dan lowongan yang cocok.',
                            side: "right", align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/assessment"]',
                        popover: {
                            title: '📝 Asesmen Kompetensi',
                            description: 'AI mengukur level skill Anda secara akurat berdasarkan jawaban tes.',
                            side: "right", align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/roadmap"]',
                        popover: {
                            title: '🗺️ Roadmap Karir',
                            description: 'Peta jalan karir berisi panduan skill yang harus dipelajari.',
                            side: "right", align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/jobs"]',
                        popover: {
                            title: '💼 Lowongan Pekerjaan',
                            description: 'Temukan lowongan dan lihat skor kecocokan (Fit Score) profil Anda.',
                            side: "right", align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/courses"]',
                        popover: {
                            title: '📚 Kursus & Pembelajaran',
                            description: 'AI merekomendasikan kursus khusus untuk menutupi gap skill Anda.',
                            side: "right", align: 'start'
                        }
                    }
                ]
            });

            // TIDAK auto-start, hanya via tombol
            const startTourBtn = document.getElementById('start-tour-btn');
            if (startTourBtn) {
                startTourBtn.addEventListener('click', () => driverObj.drive());
            }
        });
    </script>

</x-app-layout>
