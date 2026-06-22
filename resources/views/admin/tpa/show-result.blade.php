<x-app-layout>
<style>
    @keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
    .anim-1{animation:fadeInUp .4s ease-out}
    .anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}
    .anim-3{animation:fadeInUp .4s ease-out .2s forwards;opacity:0}
</style>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4 anim-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tes TPA</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.results') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Hasil Tes</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Detail</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 anim-1">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Hasil Tes</h2>
                <p class="text-xs text-gray-500 dark:text-slate-300 mt-1">Detail penilaian hasil Tes Potensi Akademik dari {{ $result->user->name }}.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tpa.results.pdf', $result) }}" class="inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('admin.tpa.results') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; Kembali
                </a>
            </div>
        </div>

        @php
            $totalQuestions = $result->total_correct + $result->total_wrong + $result->total_unanswered;
            $accuracyRate = $totalQuestions > 0 ? round(($result->total_correct / $totalQuestions) * 100, 1) : 0;
        @endphp

        <!-- Profile Card -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden mb-6 anim-2">
            <div class="p-6 {{ $result->is_passed ? 'bg-gradient-to-r from-emerald-600 to-teal-600' : 'bg-gradient-to-r from-rose-600 to-red-600' }} text-white">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-3xl font-bold backdrop-blur-sm shadow-inner">
                            {{ strtoupper(substr($result->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white leading-tight">{{ $result->user->name }}</h1>
                            <p class="opacity-90 text-white text-sm">{{ $result->user->email }}</p>
                            <p class="opacity-80 text-xs mt-1 text-white flex items-center gap-1.5 justify-center sm:justify-start">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Tes: {{ $result->tpaTest->title }}
                            </p>
                        </div>
                    </div>
                    <div class="text-center sm:text-right">
                        <div class="text-5xl font-extrabold text-white tracking-tight">{{ $result->bappenas_score }}</div>
                        <div class="text-xs uppercase tracking-wider opacity-90 text-white font-semibold mt-0.5">Skor Bappenas</div>
                        <div class="mt-2.5 px-4 py-1.5 bg-white/25 rounded-full text-xs font-bold inline-flex items-center gap-1 text-white border border-white/10">
                            @if($result->is_passed)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                LULUS
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                TIDAK LULUS
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2 Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Detail Jawaban (2/3 width) -->
            <div class="lg:col-span-2 space-y-6 anim-2">
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Detail Jawaban</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Total {{ $result->session->answers->count() }} soal dikerjakan</p>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-slate-800">
                        @foreach($result->session->answers as $index => $answer)
                        <div class="p-5 hover:bg-gray-50/50 dark:hover:bg-slate-800/30 transition-colors {{ $answer->is_correct ? 'border-l-4 border-l-emerald-500' : ($answer->selected_answer ? 'border-l-4 border-l-rose-500' : 'border-l-4 border-l-slate-300 dark:border-l-slate-650') }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 rounded-full flex items-center justify-center text-xs font-semibold">{{ $index + 1 }}</span>
                                        <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $answer->question->category_label == 'Verbal' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-200 border border-blue-100 dark:border-blue-700/50' : ($answer->question->category_label == 'Numerik' ? 'bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-200 border border-purple-100 dark:border-purple-700/50' : ($answer->question->category_label == 'Logika' ? 'bg-orange-50 text-orange-700 dark:bg-orange-900/40 dark:text-orange-200 border border-orange-100 dark:border-orange-700/50' : 'bg-teal-50 text-teal-700 dark:bg-teal-900/40 dark:text-teal-200 border border-teal-100 dark:border-teal-700/50')) }}">
                                            {{ $answer->question->category_label }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-800 dark:text-slate-200 leading-relaxed">{!! Str::limit(strip_tags($answer->question->question_text), 180) !!}</p>
                                </div>
                                <div class="text-right shrink-0">
                                    @if($answer->is_correct)
                                    <div class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-full text-xs font-semibold border border-emerald-100 dark:border-emerald-700/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Benar
                                    </div>
                                    @elseif($answer->selected_answer)
                                    <div class="inline-flex items-center gap-1 px-3 py-1 bg-rose-50 dark:bg-rose-900/40 text-rose-700 dark:text-rose-300 rounded-full text-xs font-semibold border border-rose-100 dark:border-rose-700/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Salah
                                    </div>
                                    <div class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">Dipilih: <span class="font-bold text-gray-700 dark:text-slate-200">{{ $answer->selected_answer }}</span></div>
                                    <div class="text-[10px] text-emerald-600 dark:text-emerald-300">Kunci: <span class="font-bold">{{ $answer->question->correct_answer }}</span></div>
                                    @else
                                    <div class="inline-flex items-center gap-1 px-3 py-1 bg-slate-50 dark:bg-slate-700/80 text-gray-600 dark:text-slate-200 rounded-full text-xs font-semibold border border-slate-200 dark:border-slate-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Kosong
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @if($answer->question->explanation && !$answer->is_correct)
                            <div class="mt-3 text-xs text-gray-700 dark:text-slate-200 bg-amber-50/50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-900/30 p-3 rounded-lg flex gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <strong class="text-amber-700 dark:text-amber-400">Penjelasan:</strong> {!! $answer->question->explanation !!}
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar (1/3 width) -->
            <div class="lg:col-span-1 space-y-6 anim-3">
                <!-- Scores Card -->
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-slate-800">Skor Kategori</h3>
                    <div class="space-y-4">
                        @foreach([
                            'verbal' => ['Verbal', 'bg-blue-50/50 dark:bg-blue-900/40', 'text-blue-600 dark:text-blue-300', 'border-blue-100 dark:border-blue-700/50'],
                            'numerik' => ['Numerik', 'bg-purple-50/50 dark:bg-purple-900/40', 'text-purple-600 dark:text-purple-300', 'border-purple-100 dark:border-purple-700/50'],
                            'logika' => ['Logika', 'bg-orange-50/50 dark:bg-orange-900/40', 'text-orange-600 dark:text-orange-300', 'border-orange-100 dark:border-orange-700/50'],
                            'spasial' => ['Spasial', 'bg-teal-50/50 dark:bg-teal-900/40', 'text-teal-600 dark:text-teal-300', 'border-teal-100 dark:border-teal-700/50']
                        ] as $key => [$label, $bgColor, $textColor, $borderColor])
                        @php
                            $score = $result->{$key . '_score'};
                            $isPassed = $score >= 60;
                        @endphp
                        <div class="flex flex-col gap-1.5 p-3.5 rounded-xl border {{ $bgColor }} {{ $borderColor }} hover:scale-[1.02] hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-gray-800 dark:text-slate-200">{{ $label }}</span>
                                <span class="text-base font-extrabold {{ $textColor }}">{{ $score }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700/50 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $isPassed ? 'bg-emerald-500 dark:bg-emerald-400' : 'bg-rose-500 dark:bg-rose-400' }}" style="width: {{ $score }}%"></div>
                            </div>
                            <div class="flex justify-between text-[11px] text-gray-500 dark:text-slate-400">
                                <span>Nilai min: 60%</span>
                                <span class="{{ $isPassed ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} font-bold">
                                    {{ $isPassed ? 'Lulus' : 'Gagal' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-slate-800">Statistik Jawaban</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3.5 bg-blue-50/50 dark:bg-blue-900/40 border border-blue-100 dark:border-blue-700/50 rounded-xl text-center">
                            <span class="text-[11px] text-gray-500 dark:text-slate-300 block mb-1">Total Skor</span>
                            <span class="text-xl font-extrabold text-blue-600 dark:text-blue-300">{{ $result->total_score }}%</span>
                        </div>
                        <div class="p-3.5 bg-emerald-50/50 dark:bg-emerald-900/40 border border-emerald-100 dark:border-emerald-700/50 rounded-xl text-center">
                            <span class="text-[11px] text-gray-500 dark:text-slate-300 block mb-1">Benar</span>
                            <span class="text-xl font-extrabold text-emerald-600 dark:text-emerald-300">{{ $result->total_correct }}</span>
                        </div>
                        <div class="p-3.5 bg-rose-50/50 dark:bg-rose-900/40 border border-rose-100 dark:border-rose-700/50 rounded-xl text-center">
                            <span class="text-[11px] text-gray-500 dark:text-slate-300 block mb-1">Salah</span>
                            <span class="text-xl font-extrabold text-rose-600 dark:text-rose-300">{{ $result->total_wrong }}</span>
                        </div>
                        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-150 dark:border-slate-600/50 rounded-xl text-center">
                            <span class="text-[11px] text-gray-600 dark:text-slate-300 block mb-1">Kosong</span>
                            <span class="text-xl font-extrabold text-slate-700 dark:text-white">{{ $result->total_unanswered }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-slate-800">Informasi Tes</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-slate-400">Total Soal:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $totalQuestions }} soal</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-slate-400">Akurasi:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $accuracyRate }}%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-slate-400">Waktu Pengerjaan:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $result->tpaTest->time_limit_minutes }} menit</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-slate-400">Passing Score:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $result->tpaTest->passing_score }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
