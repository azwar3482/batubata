@props(['user'])

@php
$completionPercentage = $user->profile_completion_percentage;
$hasCV = $user->documents()->where('document_type', 'cv')->exists();
$skills = $user->skills ?? [];
$hasExperience = $user->careerHistories && $user->careerHistories->count() > 0;
@endphp

<div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Contoh CV Profesional
            </h3>
            <p class="text-sm text-gray-500 mt-1">Preview CV berdasarkan data profil Anda</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('seeker.cv.preview') }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Preview
            </a>
            <a href="{{ route('seeker.cv.download') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>

    <div class="p-6">
        {{-- CV Preview Mini --}}
        <!-- <div class="bg-gray-50 dark:bg-slate-800 rounded-xl p-6 mb-6 border-2 border-dashed border-gray-200 dark:border-slate-700">
            <div class="max-w-md mx-auto">
                {{-- Header Mini --}}
                <div class="flex items-center gap-4 mb-4 pb-4 border-b-2 border-blue-500">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xl font-bold">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div>
                        <div class="font-bold text-lg text-gray-900">{{ strtoupper($user->name) }}</div>
                        <div class="text-sm text-blue-600 font-medium">{{ $user->target_position ?? 'Profesional' }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $user->email }} @if($user->phone) &middot; {{ $user->phone }} @endif
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                @if($user->bio)
                <div class="mb-4">
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Ringkasan</div>
                    <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit(strip_tags($user->bio), 200) }}</p>
                </div>
                @endif

                {{-- Skills --}}
                @if(count($skills) > 0)
                <div class="mb-4">
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Keahlian</div>
                    <div class="flex flex-wrap gap-1">
                        @foreach(array_slice($skills, 0, 8) as $skill)
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ $skill }}</span>
                        @endforeach
                        @if(count($skills) > 8)
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs">+{{ count($skills) - 8 }} lagi</span>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Experience --}}
                @if($hasExperience)
                <div class="mb-4">
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Pengalaman</div>
                    @foreach($user->careerHistories->take(2) as $history)
                    <div class="mb-2 pl-3 border-l-2 border-gray-200">
                        <div class="text-sm font-semibold">{{ $history->position }}</div>
                        <div class="text-xs text-blue-600">{{ $history->company_name }}</div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Education --}}
                <div>
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Pendidikan</div>
                    <div class="text-sm font-semibold">{{ $user->education_level ?? '-' }}</div>
                    @if($user->major)
                    <div class="text-xs text-gray-500">{{ $user->major }}</div>
                    @endif
                </div>
            </div>
        </div> -->

        {{-- Status & Tips --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Status --}}
            <div class="bg-gray-50 dark:bg-slate-800 rounded-xl p-4">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Status CV</h4>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm">
                        @if($completionPercentage >= 100)
                        <span class="text-green-500">&#10003;</span>
                        @else
                        <span class="text-red-500">&#10007;</span>
                        @endif
                        <span>Profil {{ $completionPercentage }}% lengkap</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        @if(count($skills) > 0)
                        <span class="text-green-500">&#10003;</span>
                        @else
                        <span class="text-yellow-500">&#9888;</span>
                        @endif
                        <span>{{ count($skills) }} skill tercatat</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        @if($hasExperience)
                        <span class="text-green-500">&#10003;</span>
                        @else
                        <span class="text-yellow-500">&#9888;</span>
                        @endif
                        <span>{{ $hasExperience ? $user->careerHistories->count() . ' pengalaman kerja' : 'Belum ada pengalaman' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        @if($hasCV)
                        <span class="text-green-500">&#10003;</span>
                        @else
                        <span class="text-yellow-500">&#9888;</span>
                        @endif
                        <span>{{ $hasCV ? 'CV sudah diupload' : 'CV belum diupload' }}</span>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-900/30">
                <h4 class="font-semibold text-sm text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Tips CV Terbaik
                </h4>
                <ul class="text-xs text-blue-700 dark:text-blue-400 space-y-1.5">
                    <li class="flex items-start gap-1.5">
                        <span class="text-blue-500 mt-0.5">&#8226;</span>
                        Gunakan ringkasan profesional yang singkat dan menarik
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-blue-500 mt-0.5">&#8226;</span>
                        Sebutkan skill yang relevan dengan posisi target
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-blue-500 mt-0.5">&#8226;</span>
                        Gunakan action verbs: mengelola, mengembangkan, meningkatkan
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-blue-500 mt-0.5">&#8226;</span>
                        Cantumkan pencapaian terukur (angka, persentase)
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-blue-500 mt-0.5">&#8226;</span>
                        Format bersih, mudah dibaca, maksimal 2 halaman
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>