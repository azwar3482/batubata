<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('seeker.career-fields.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Bidang Karir</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-800 dark:text-slate-200 font-medium">{{ $field->name }}</span>
    </nav>

    {{-- Header --}}
    <div class="bg-gradient-to-r from-{{ $field->color }}-500 to-{{ $field->color }}-600 rounded-2xl p-8 mb-8 text-white">
        <div class="flex items-start gap-4">
            <span class="text-5xl">{{ $field->icon }}</span>
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">{{ $field->name }}</h1>
                <p class="opacity-90 mb-4">{{ $field->description }}</p>
                <div class="flex flex-wrap gap-3">
                    @if($field->avg_salary_min)
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                        Gaji: Rp {{ number_format($field->avg_salary_min / 1000000, 0) }} - {{ number_format($field->avg_salary_max / 1000000, 0) }} Juta
                    </span>
                    @endif
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                        Permintaan: {{ $field->demand_label }} ({{ $field->demand_score }}%)
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Contoh Posisi --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
            <h3 class="font-bold text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contoh Posisi
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($field->job_titles ?? [] as $title)
                <span class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-sm">{{ $title }}</span>
                @endforeach
            </div>
        </div>

        {{-- Industri Terkait --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
            <h3 class="font-bold text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Industri Terkait
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($field->industries ?? [] as $industry)
                <span class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg text-sm border border-blue-100 dark:border-blue-800/50">{{ $industry }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ROADMAP TIMELINE --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-800 dark:text-slate-200 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-{{ $field->color }}-500 dark:text-{{ $field->color }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Roadmap Karir
        </h2>

        <div class="space-y-6">
            @foreach($paths as $i => $item)
            @php $path = $item['path']; @endphp
            <div class="relative">


                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                    {{-- Level Header --}}
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-850 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-{{ $field->color }}-500 dark:bg-{{ $field->color }}-600 text-white flex items-center justify-center font-bold text-lg">
                                    {{ $i + 1 }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-slate-800 dark:text-slate-200">{{ $path->level_label }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        @if($path->year_range_min !== null)
                                            {{ $path->year_range_min }}{{ $path->year_range_max ? '-' . $path->year_range_max : '+' }} tahun pengalaman
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($path->salary_min)
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Rp {{ number_format($path->salary_min / 1000000, 0) }} - {{ number_format($path->salary_max / 1000000, 0) }} Juta
                                </div>
                                @endif
                                @if($item['match_percentage'] > 0)
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $item['match_percentage'] >= 70 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $item['match_percentage'] >= 40 && $item['match_percentage'] < 70 ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                        {{ $item['match_percentage'] < 40 ? 'bg-red-100 text-red-700 dark:bg-rose-900/30 dark:text-rose-400' : '' }}">
                                        Skill Match: {{ $item['match_percentage'] }}%
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        @if($path->description)
                        <p class="text-slate-600 dark:text-slate-400 mb-4">{{ $path->description }}</p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Skills --}}
                            <div>
                                <h4 class="font-semibold text-sm text-slate-700 dark:text-slate-200 mb-2 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    Skill yang Dibutuhkan
                                </h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($path->skills_required ?? [] as $skill)
                                    <span class="px-2 py-0.5 rounded text-xs font-medium
                                        {{ in_array($skill, $userSkills) ? 'bg-green-100 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                        {{ in_array($skill, $userSkills) ? '✓' : '' }} {{ $skill }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Certifications --}}
                            <div>
                                <h4 class="font-semibold text-sm text-slate-700 dark:text-slate-200 mb-2 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    Sertifikasi
                                </h4>
                                <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-1">
                                    @foreach($path->certifications ?? [] as $cert)
                                    <li class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-amber-400 dark:bg-amber-500 rounded-full"></span>
                                        {{ $cert }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Courses --}}
                            <div>
                                <h4 class="font-semibold text-sm text-slate-700 dark:text-slate-200 mb-2 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Kursus Rekomendasi
                                </h4>
                                <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-1">
                                    @foreach($path->courses ?? [] as $course)
                                    <li class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-green-400 dark:bg-green-500 rounded-full"></span>
                                        {{ $course }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Tips --}}
                        @if($path->tips)
                        <div class="mt-4 p-3 bg-amber-50 border border-amber-100 dark:bg-amber-900/20 dark:border-amber-800/50 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-amber-500 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <div>
                                    <span class="font-semibold text-amber-800 dark:text-amber-500 text-xs">Tips:</span>
                                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">{{ $path->tips }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
