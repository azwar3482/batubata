<x-app-layout>
    <div class="py-10 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('seeker.jobs.index') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Daftar Lowongan
                        </a>
                    </li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-900 dark:text-gray-100 font-medium truncate max-w-xs">{{ $job->title }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column: Main Content -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- Main Header Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                                <div class="flex items-start gap-5">
                                    <!-- Company Logo Placeholder -->
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center text-blue-600 font-bold text-2xl border border-blue-100 shadow-inner flex-shrink-0">
                                        {{ strtoupper(substr($job->company_name, 0, 2)) }}
                                    </div>
                                    
                                    <div>
                                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight mb-2">{{ $job->title }}</h1>
                                        <p class="text-lg text-blue-600 font-medium flex items-center gap-1.5 mb-4">
                                            {{ $job->company_name }}
                                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </p>
                                        
                                        <div class="flex flex-wrap items-center gap-3 text-sm">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 text-gray-700 border border-gray-200">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                {{ $job->location }}
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 text-gray-700 border border-gray-200">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                <span class="capitalize">{{ $job->work_type }}</span>
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 text-gray-700 border border-gray-200">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $job->experience_required }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end gap-3 min-w-fit">
                                    @if ($matchPercentage >= 80)
                                    <div class="inline-flex flex-col items-center justify-center px-4 py-3 bg-gradient-to-b from-green-50 to-white border border-green-200 rounded-xl shadow-sm">
                                        <span class="text-[10px] font-bold text-green-600 uppercase tracking-wider mb-1">Match Score</span>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-2xl font-black text-green-700 leading-none">{{ round($matchPercentage) }}</span>
                                            <span class="text-sm font-bold text-green-600">%</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Salary & Time Info Footer -->
                        <div class="bg-gray-50/80 border-t border-gray-100 px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                            @if ($job->salary_min)
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-gray-900 dark:text-gray-100 font-bold">
                                    Rp {{ number_format($job->salary_min / 1000000, 0) }} Jt - {{ number_format($job->salary_max / 1000000, 0) }} Jt <span class="text-gray-500 font-normal text-sm">/ bulan</span>
                                </span>
                            </div>
                            @endif
                            <div class="text-sm text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Diposting {{ \Carbon\Carbon::parse($job->posted_date)->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Deskripsi Pekerjaan
                        </h2>
                        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Skills & Requirements -->
                    @if ($job->required_skills)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Keahlian yang Dibutuhkan
                        </h2>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach ($job->required_skills as $skill)
                                @php
                                    // Dummy logic for now, or you can implement actual checking
                                    $userHasSkill = false; 
                                    $matchClass = $userHasSkill 
                                        ? 'bg-green-50 text-green-700 border-green-200' 
                                        : 'bg-gray-50 text-gray-700 border-gray-200 hover:border-gray-300';
                                @endphp
                                <span class="px-4 py-2 {{ $matchClass }} border rounded-xl text-sm font-medium flex items-center gap-2 transition-colors">
                                    @if ($userHasSkill)
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    @endif
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Skill Gap Analysis -->
                    @if ($matchPercentage < 100)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                Analisis Kecocokan Skill
                            </h2>
                            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $matchPercentage >= 80 ? 'bg-green-100 text-green-700' : ($matchPercentage >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ round($matchPercentage) }}% Match
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-8 overflow-hidden">
                            <div class="h-2.5 rounded-full transition-all duration-1000 ease-out {{ $matchPercentage >= 80 ? 'bg-green-500' : ($matchPercentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                style="width: {{ $matchPercentage }}%"></div>
                        </div>

                        @if ($matchPercentage < 80)
                            <div class="space-y-4">
                                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Skill yang perlu ditingkatkan</h3>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    @foreach (['Data Analysis', 'Project Management', 'Cloud Computing'] as $gapSkill)
                                    <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $gapSkill }}</span>
                                        </div>
                                        <a href="{{ route('seeker.courses.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            Pelajari <span aria-hidden="true">&rarr;</span>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Upskill CTA -->
                                <div class="mt-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div>
                                        <h4 class="text-base font-bold text-blue-900 mb-1">Ingin tahu skill gap Anda sebenarnya?</h4>
                                        <p class="text-sm text-blue-700/80">Ikuti asesmen kompetensi untuk mengetahui kekuatan dan kelemahan Anda secara presisi.</p>
                                    </div>
                                    <a href="{{ route('seeker.assessment.from-job', $job->id) }}" class="shrink-0 w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm text-center">
                                        Mulai Asesmen
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-green-50 rounded-xl border border-green-200 flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-sm font-bold text-green-900">Kandidat Sangat Cocok!</h4>
                                    <p class="text-sm text-green-700 mt-1">Profil Anda memenuhi kriteria utama untuk posisi ini. Peluang Anda sangat tinggi.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Right Column: Sidebar Actions -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="sticky top-6 space-y-6">

                        <!-- Action Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 {{ $alreadyApplied ? 'ring-2 ring-green-500/20' : '' }}">
                            @if ($alreadyApplied)
                                <div class="text-center py-4">
                                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4 ring-8 ring-green-50">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Lamaran Terkirim</h3>
                                    <p class="text-sm text-gray-500 mb-6">Anda telah melamar posisi ini. Silakan pantau status lamaran Anda melalui dashboard.</p>
                                    <a href="{{ route('seeker.jobs.applications', ['highlight_job_id' => $job->id]) }}" class="block w-full px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-900 dark:text-gray-100 border border-gray-200 rounded-xl transition-colors font-semibold text-center">
                                        Lihat Status Lamaran
                                    </a>
                                </div>
                            @elseif (!Auth::user()->hasCompletedProfile())
                                <div class="text-center py-2">
                                    <div class="w-16 h-16 mx-auto bg-amber-100 rounded-full flex items-center justify-center mb-4 ring-8 ring-amber-50">
                                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Profil Belum Lengkap</h3>
                                    <p class="text-sm text-gray-500 mb-4">Profil Anda baru lengkap <span class="font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->profile_completion_percentage }}%</span>. Lengkapi profil hingga 100% untuk dapat melamar.</p>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-6">
                                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ Auth::user()->profile_completion_percentage }}%"></div>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block w-full px-4 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-xl transition-colors font-semibold shadow-sm text-center">
                                        Lengkapi Profil Sekarang
                                    </a>
                                </div>
                            @else
                                @php
                                    $latestAssessment = \App\Models\UserAssessment::where('user_id', Auth::id())->latest()->first();
                                    $avgGap = $latestAssessment ? $latestAssessment->total_gap_percentage : 0;
                                @endphp

                                @if ($avgGap > 30)
                                    <div class="text-center py-2">
                                        <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4 ring-8 ring-red-50">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Celah Keahlian Tinggi</h3>
                                        <p class="text-sm text-gray-500 mb-6">Celah keahlian Anda <strong class="text-gray-900 dark:text-gray-100">{{ number_format($avgGap, 1) }}%</strong> (Batas: 30%). Silakan tingkatkan skill Anda melalui kursus yang direkomendasikan terlebih dahulu.</p>
                                        <a href="{{ route('seeker.courses.index') }}" class="block w-full px-4 py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-xl transition-colors font-semibold shadow-sm text-center">
                                            Lihat Rekomendasi Kursus
                                        </a>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">Siap untuk melamar?</h3>
                                        <p class="text-sm text-gray-500">Kirimkan profil dan CV terbaik Anda.</p>
                                    </div>

                                    <form action="{{ route('seeker.jobs.apply', $job->id) }}" method="POST" class="space-y-5" x-data @submit.prevent="if({{ $job->matching_percentage ?? 0 }} < 75) { $dispatch('open-low-match-modal'); } else { $el.submit(); }">
                                        @csrf

                                        <!-- CV Preview Mini Card -->
                                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl group relative overflow-hidden">
                                            <div class="flex items-start gap-3 relative z-10">
                                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center border border-gray-100 shrink-0">
                                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">CV_{{ Auth::user()->name }}.pdf</p>
                                                    <p class="text-xs text-gray-500 mt-0.5">Dokumen utama • Terhubung otomatis</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('profile.edit') }}" class="absolute inset-0 z-20 flex items-center justify-center bg-gray-900/5 backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-opacity">
                                                <span class="px-3 py-1.5 bg-white text-gray-900 dark:text-gray-100 text-xs font-bold rounded-lg shadow-sm border border-gray-200">Ganti Dokumen</span>
                                            </a>
                                        </div>

                                        <!-- Note Field -->
                                        <div>
                                            <label for="note" class="block text-sm font-semibold text-gray-700 mb-1.5">Pesan untuk Recruiter <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                            <textarea name="note" id="note" rows="3" placeholder="Sebutkan alasan mengapa Anda adalah kandidat terbaik..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-colors resize-none"></textarea>
                                        </div>

                                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-sm hover:shadow-md transform active:scale-[0.98]">
                                            Kirim Lamaran Sekarang
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    </form>

                                    <p class="text-[11px] text-gray-400 text-center mt-4">
                                        Dengan melamar, Anda menyetujui <a href="#" class="text-gray-600 hover:text-blue-600 underline decoration-gray-300 underline-offset-2">Syarat & Ketentuan</a> kami.
                                    </p>
                                @endif
                            @endif
                        </div>

                        <!-- Secondary Actions -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 space-y-2">
                            @if(!$alreadyApplied)
                                <form action="{{ route('seeker.jobs.save', $job->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $isSaved ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
                                        @if($isSaved)
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" /></svg>
                                            Disimpan
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                            Simpan Lowongan
                                        @endif
                                    </button>
                                </form>
                            @endif
                            <button type="button" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                Bagikan
                            </button>
                        </div>

                        <!-- Company Info Mini Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Profil Perusahaan</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Industri</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Teknologi / Software</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Ukuran Perusahaan</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">50-200 Karyawan</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Situs Web</p>
                                    <a href="{{ $job->application_url }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                                        {{ parse_url($job->application_url, PHP_URL_HOST) ?? 'Kunjungi Website' }}
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Low Match Modal -->
    <div x-data="{ open: false }" 
         @open-low-match-modal.window="open = true"
         x-show="open" 
         style="display: none;" 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="open = false" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 border border-gray-100">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-gray-100" id="modal-title">
                            Kecocokan Belum Memenuhi Syarat
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Mohon maaf, tingkat kecocokan profil Anda dengan persyaratan lowongan masih di bawah 75%. Silakan lakukan asesmen kompetensi untuk meningkatkan skor Anda.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:mt-5 sm:flex sm:flex-row-reverse gap-3">
                    <a href="{{ url('/seeker/assessment') }}" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-blue-600 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm transition-colors">
                        Mulai Asesmen
                    </a>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>