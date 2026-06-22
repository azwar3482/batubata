<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('industry.tpa.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">TPA</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-900 dark:text-white font-medium">Hasil</span>
                </nav>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                    Hasil TPA: {{ $result->user->name }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('industry.tpa.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 text-sm font-medium flex items-center gap-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <a href="{{ route('industry.tpa.results.pdf', $result) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Score Header Card --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden mb-6 border border-slate-100 dark:border-slate-700">
                <div class="p-6 sm:p-8 {{ $result->is_passed ? 'bg-gradient-to-r from-emerald-600 to-green-600' : 'bg-gradient-to-r from-red-600 to-rose-600' }} text-white">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $result->tpaTest->title }}</h3>
                            <p class="opacity-90 mt-1">{{ $result->user->name }} &middot; {{ $result->user->email }}</p>
                        </div>
                        <div class="text-center sm:text-right">
                            <div class="text-5xl font-black">{{ $result->bappenas_score }}</div>
                            <div class="text-sm opacity-90 mt-1">Skor Bappenas</div>
                            <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $result->is_passed ? 'bg-white/20' : 'bg-white/20' }}">
                                {{ $result->is_passed ? '✓ LULUS' : '✗ TIDAK LULUS' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Score Breakdown --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @foreach(['verbal' => 'Verbal', 'numerik' => 'Numerik', 'logika' => 'Logika', 'spasial' => 'Spasial'] as $key => $label)
                <div class="bg-white dark:bg-slate-800 rounded-xl p-5 text-center shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-sm text-gray-500 dark:text-slate-400 font-medium">{{ $label }}</div>
                    <div class="text-3xl font-bold mt-1 {{ $result->{$key . '_score'} >= 60 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $result->{$key . '_score'} }}%</div>
                    <div class="w-full bg-gray-200 dark:bg-slate-600 rounded-full h-2 mt-3">
                        <div class="h-2 rounded-full {{ $result->{$key . '_score'} >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $result->{$key . '_score'} }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Summary Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 text-center shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $result->total_score }}%</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1 font-medium">Total Skor</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 text-center shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $result->total_correct }}</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1 font-medium">Benar</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 text-center shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $result->total_wrong }}</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1 font-medium">Salah</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 text-center shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-2xl font-bold text-gray-600 dark:text-slate-400">{{ $result->total_unanswered }}</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1 font-medium">Tidak Dijawab</div>
                </div>
            </div>

            {{-- Test Info --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 mb-6 shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-slate-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Waktu: <strong class="text-gray-800 dark:text-white">{{ floor($result->session->time_spent_seconds / 60) }}m {{ $result->session->time_spent_seconds % 60 }}s</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Passing Score: <strong class="text-gray-800 dark:text-white">{{ $result->passing_score }}%</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Grade: <strong class="text-gray-800 dark:text-white">{{ $result->score_grade }}</strong></span>
                    </div>
                </div>
            </div>

            {{-- Detail Jawaban --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden border border-slate-100 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-white">Detail Jawaban</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-3">
                        @foreach($result->session->answers as $i => $answer)
                        <div class="border rounded-xl p-4 {{ $answer->is_correct ? 'border-green-200 dark:border-green-800 bg-green-50/50 dark:bg-green-900/10' : ($answer->selected_answer ? 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10' : 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50') }}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs px-2 py-1 rounded-lg bg-white dark:bg-slate-700 text-gray-600 dark:text-slate-300 font-medium border border-slate-200 dark:border-slate-600">{{ $answer->question->category_label }}</span>
                                        <span class="text-xs text-gray-400 dark:text-slate-500">#{{ $i + 1 }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-slate-300">{!! Str::limit(strip_tags($answer->question->question_text), 150) !!}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    @if($answer->is_correct)
                                    <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 font-bold text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Benar
                                    </span>
                                    @elseif($answer->selected_answer)
                                    <span class="inline-flex items-center gap-1 text-red-600 dark:text-red-400 font-bold text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Salah
                                    </span>
                                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Jawaban: {{ $answer->selected_answer }} | Benar: {{ $answer->question->correct_answer }}</div>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-gray-400 dark:text-slate-500 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01"/></svg>
                                        Tidak Dijawab
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
