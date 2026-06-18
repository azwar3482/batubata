<x-app-layout>
@php
    $result = $session->result;
    $isPassed = $result->is_passed;
    $scoreColor = $isPassed ? 'emerald' : 'red';
    $gradeColor = match(true) {
        $result->bappenas_score >= 700 => 'emerald',
        $result->bappenas_score >= 600 => 'blue',
        $result->bappenas_score >= 500 => 'amber',
        default => 'red',
    };
    $categories = [
        'verbal'  => ['label' => 'Verbal',  'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'blue', 'bg' => 'from-blue-500 to-blue-600'],
        'numerik' => ['label' => 'Numerik', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'violet', 'bg' => 'from-violet-500 to-violet-600'],
        'logika'  => ['label' => 'Logika',  'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'color' => 'amber', 'bg' => 'from-amber-500 to-orange-500'],
        'spasial' => ['label' => 'Spasial', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9', 'color' => 'teal', 'bg' => 'from-teal-500 to-emerald-500'],
    ];
    $colorClasses = [
        'blue'   => ['text' => 'text-blue-600 dark:text-blue-400',   'bg' => 'bg-blue-50 dark:bg-blue-900/30',   'border' => 'border-blue-200 dark:border-blue-800',   'ring' => 'ring-blue-500/20',   'bar' => 'bg-blue-500'],
        'violet' => ['text' => 'text-violet-600 dark:text-violet-400', 'bg' => 'bg-violet-50 dark:bg-violet-900/30', 'border' => 'border-violet-200 dark:border-violet-800', 'ring' => 'ring-violet-500/20', 'bar' => 'bg-violet-500'],
        'amber'  => ['text' => 'text-amber-600 dark:text-amber-400',  'bg' => 'bg-amber-50 dark:bg-amber-900/30',  'border' => 'border-amber-200 dark:border-amber-800',  'ring' => 'ring-amber-500/20',  'bar' => 'bg-amber-500'],
        'teal'   => ['text' => 'text-teal-600 dark:text-teal-400',   'bg' => 'bg-teal-50 dark:bg-teal-900/30',   'border' => 'border-teal-200 dark:border-teal-800',   'ring' => 'ring-teal-500/20',   'bar' => 'bg-teal-500'],
    ];
@endphp

<style>
    @keyframes scoreCountUp {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes progressBar {
        from { width: 0%; }
    }
    @keyframes pulse-ring {
        0% { transform: scale(0.95); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.7; }
        100% { transform: scale(0.95); opacity: 1; }
    }
    @keyframes drawCircle {
        from { stroke-dashoffset: 283; }
    }
    .animate-score { animation: scoreCountUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-fade-in-up-1 { animation: fadeInUp 0.6s ease-out 0.1s forwards; opacity: 0; }
    .animate-fade-in-up-2 { animation: fadeInUp 0.6s ease-out 0.2s forwards; opacity: 0; }
    .animate-fade-in-up-3 { animation: fadeInUp 0.6s ease-out 0.3s forwards; opacity: 0; }
    .animate-fade-in-up-4 { animation: fadeInUp 0.6s ease-out 0.4s forwards; opacity: 0; }
    .animate-bar { animation: progressBar 1.2s ease-out forwards; }
    .animate-draw { animation: drawCircle 1.5s ease-out forwards; }
    .score-gauge-circle {
        transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center justify-between mb-6 animate-fade-in-up">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('seeker.tpa.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tes TPA</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Hasil Tes</span>
        </div>
        <a href="{{ route('seeker.tpa.result.pdf', $session) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download PDF
        </a>
    </nav>

    {{-- ============ MAIN RESULT HERO CARD ============ --}}
    <div class="relative overflow-hidden rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 mb-6 animate-fade-in-up">
        {{-- Decorative background gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br {{ $isPassed ? 'from-emerald-50 via-white to-teal-50 dark:from-emerald-950/30 dark:via-slate-800 dark:to-teal-950/20' : 'from-red-50 via-white to-orange-50 dark:from-red-950/30 dark:via-slate-800 dark:to-orange-950/20' }}"></div>
        <div class="absolute top-0 right-0 w-64 h-64 rounded-full {{ $isPassed ? 'bg-emerald-200/20 dark:bg-emerald-500/10' : 'bg-red-200/20 dark:bg-red-500/10' }} blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full {{ $isPassed ? 'bg-teal-200/20 dark:bg-teal-500/10' : 'bg-orange-200/20 dark:bg-orange-500/10' }} blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative p-6 sm:p-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                {{-- Circular Score Gauge --}}
                <div class="flex-shrink-0 animate-score">
                    <div class="relative w-44 h-44 sm:w-52 sm:h-52">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                            {{-- Background circle --}}
                            <circle cx="50" cy="50" r="45" fill="none" stroke-width="8"
                                class="stroke-gray-200 dark:stroke-slate-600" />
                            {{-- Score arc --}}
                            @php
                                $normalizedScore = max(200, min(800, $result->bappenas_score));
                                $percentage = ($normalizedScore - 200) / 600 * 100;
                                $circumference = 2 * 3.14159 * 45;
                                $offset = $circumference - ($percentage / 100 * $circumference);
                            @endphp
                            <circle cx="50" cy="50" r="45" fill="none" stroke-width="8"
                                stroke-linecap="round"
                                class="score-gauge-circle animate-draw {{ $isPassed ? 'stroke-emerald-500' : 'stroke-red-500' }}"
                                stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $offset }}" />
                        </svg>
                        {{-- Center content --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-4xl sm:text-5xl font-extrabold {{ $isPassed ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} tracking-tight">
                                {{ $result->bappenas_score }}
                            </span>
                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-1">Skor Bappenas</span>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-3
                        {{ $isPassed ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800' }}">
                        <span class="w-2 h-2 rounded-full {{ $isPassed ? 'bg-emerald-500 animate-pulse' : 'bg-red-500' }}"></span>
                        {{ $isPassed ? 'LULUS' : 'TIDAK LULUS' }}
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white mb-1">Hasil Tes TPA</h1>
                    <p class="text-gray-600 dark:text-gray-300 text-base sm:text-lg mb-4">{{ $session->tpaTest->title }}</p>

                    {{-- Grade Badge --}}
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-white/80 dark:bg-slate-700/80 backdrop-blur border border-gray-200 dark:border-slate-600 shadow-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Grade: {{ $result->score_grade }}</span>
                        </div>
                        <div class="w-px h-5 bg-gray-300 dark:bg-slate-600"></div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Skor 200-800</span>
                    </div>

                    {{-- Time & Passing Info --}}
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-4 text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ floor($session->time_spent_seconds / 60) }}m {{ $session->time_spent_seconds % 60 }}d
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Passing: {{ $result->passing_score }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ CATEGORY SCORES ============ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($categories as $key => $cat)
        @php $score = $session->result->{$key . '_score'}; @endphp
        <div class="group relative overflow-hidden rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate-fade-in-up-{{ $loop->iteration }}">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-br {{ $cat['bg'] }} opacity-10 blur-2xl group-hover:opacity-20 transition-opacity"></div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $cat['bg'] }} flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"/></svg>
                </div>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $cat['label'] }}</span>
            </div>
            <div class="flex items-end justify-between mb-3">
                <span class="text-3xl font-extrabold {{ $colorClasses[$cat['color']]['text'] }}">{{ number_format($score, 0) }}%</span>
                @if($score >= 70)
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">Baik</span>
                @elseif($score >= 50)
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2 py-0.5 rounded-full">Cukup</span>
                @else
                    <span class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-2 py-0.5 rounded-full">Kurang</span>
                @endif
            </div>
            <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                <div class="h-2.5 rounded-full {{ $colorClasses[$cat['color']]['bar'] }} animate-bar" style="width: {{ $score }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ============ SCORE DETAILS ROW ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Weighted Total Score --}}
        <div class="lg:col-span-1 rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm animate-fade-in-up-2">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Skor Total</h3>
            <div class="text-center">
                <div class="text-5xl font-extrabold text-blue-600 dark:text-blue-400 mb-2">{{ number_format($result->total_score, 0) }}%</div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Weighted Average</p>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">Passing: {{ $result->passing_score }}%</span>
                </div>
            </div>
        </div>

        {{-- Donut Chart: Correct / Wrong / Unanswered --}}
        <div class="lg:col-span-1 rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm animate-fade-in-up-3">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Detail Jawaban</h3>
            <div class="flex items-center justify-center gap-6">
                <div class="relative w-28 h-28">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                        @php
                            $total = $result->total_questions;
                            $correctPct = $total > 0 ? ($result->total_correct / $total) * 100 : 0;
                            $wrongPct = $total > 0 ? ($result->total_wrong / $total) * 100 : 0;
                            $unansweredPct = $total > 0 ? ($result->total_unanswered / $total) * 100 : 0;
                            $circ = 2 * 3.14159 * 40;
                            $correctLen = $correctPct / 100 * $circ;
                            $wrongLen = $wrongPct / 100 * $circ;
                            $unansweredLen = $unansweredPct / 100 * $circ;
                        @endphp
                        <circle cx="50" cy="50" r="40" fill="none" stroke-width="10" class="stroke-gray-100 dark:stroke-slate-700"/>
                        <circle cx="50" cy="50" r="40" fill="none" stroke-width="10" stroke-linecap="round"
                            class="stroke-emerald-500 animate-draw"
                            stroke-dasharray="{{ $correctLen }} {{ $circ }}"
                            stroke-dashoffset="0" />
                        <circle cx="50" cy="50" r="40" fill="none" stroke-width="10" stroke-linecap="round"
                            class="stroke-red-500 animate-draw"
                            stroke-dasharray="{{ $wrongLen }} {{ $circ }}"
                            stroke-dashoffset="-{{ $correctLen }}" />
                        <circle cx="50" cy="50" r="40" fill="none" stroke-width="10" stroke-linecap="round"
                            class="stroke-gray-400 dark:stroke-slate-500 animate-draw"
                            stroke-dasharray="{{ $unansweredLen }} {{ $circ }}"
                            stroke-dashoffset="-{{ $correctLen + $wrongLen }}" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-extrabold text-gray-900 dark:text-white">{{ $total }}</span>
                        <span class="text-[10px] text-gray-400">Soal</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Benar</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white ml-auto">{{ $result->total_correct }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Salah</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white ml-auto">{{ $result->total_wrong }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-gray-400 dark:bg-slate-500"></span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Lewati</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white ml-auto">{{ $result->total_unanswered }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="lg:col-span-1 rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm animate-fade-in-up-4">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                    <span class="text-sm text-gray-600 dark:text-gray-300">Akurasi</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $total > 0 ? number_format($correctPct, 1) : 0 }}%</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                    <span class="text-sm text-gray-600 dark:text-gray-300">Waktu</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ floor($session->time_spent_seconds / 60) }}:{{ str_pad($session->time_spent_seconds % 60, 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                    <span class="text-sm text-gray-600 dark:text-gray-300">Rata-rata/Soal</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $total > 0 ? number_format($session->time_spent_seconds / $total, 1) : 0 }}d</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ ANSWER REVIEW ============ --}}
    @if($session->tpaTest->show_result_after)
    <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden animate-fade-in-up-4">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Review Jawaban
                </h2>
                {{-- Category Filter Tabs --}}
                <div class="flex flex-wrap gap-2" id="review-tabs">
                    <button onclick="filterReview('all')" data-filter="all"
                        class="review-tab px-3 py-1.5 text-xs font-semibold rounded-lg transition-all duration-200 bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        Semua <span class="opacity-70">({{ $session->answers->count() }})</span>
                    </button>
                    @foreach($categories as $key => $cat)
                    @php $count = $session->answers->where('question.category', $key)->count(); @endphp
                    @if($count > 0)
                    <button onclick="filterReview('{{ $key }}')" data-filter="{{ $key }}"
                        class="review-tab px-3 py-1.5 text-xs font-semibold rounded-lg transition-all duration-200 bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300 border border-gray-200 dark:border-slate-600 hover:bg-gray-200 dark:hover:bg-slate-600">
                        {{ $cat['label'] }} <span class="opacity-70">({{ $count }})</span>
                    </button>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="p-6 space-y-3" id="review-list">
            @foreach($session->answers->sortBy('question.category') as $answer)
            @php
                $catKey = $answer->question->category;
                $catInfo = $categories[$catKey] ?? ['label' => $catKey, 'color' => 'blue'];
                $cc = $colorClasses[$catInfo['color']] ?? $colorClasses['blue'];
            @endphp
            <div class="review-item rounded-xl border p-4 transition-all duration-200 hover:shadow-md
                {{ $answer->is_correct ? 'border-emerald-200 dark:border-emerald-800 bg-emerald-50/50 dark:bg-emerald-900/20' : ($answer->selected_answer ? 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/20' : 'border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/30') }}"
                data-category="{{ $catKey }}">
                <div class="flex items-start gap-4">
                    {{-- Status Icon --}}
                    <div class="flex-shrink-0 mt-0.5">
                        @if($answer->is_correct)
                        <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        @elseif($answer->selected_answer)
                        <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        @else
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8"/></svg>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $cc['bg'] }} {{ $cc['text'] }} {{ $cc['border'] }} border">
                                {{ $answer->question->category_label }}
                            </span>
                            @if($answer->is_correct)
                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Benar</span>
                            @elseif($answer->selected_answer)
                                <span class="text-xs font-bold text-red-600 dark:text-red-400">Salah</span>
                            @else
                                <span class="text-xs font-bold text-gray-400">Tidak Dijawab</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-800 dark:text-gray-200 leading-relaxed">{!! Str::limit(strip_tags($answer->question->question_text), 180) !!}</p>

                        @if(!$answer->is_correct)
                        <div class="mt-3 flex flex-wrap gap-3 text-xs">
                            @if($answer->selected_answer)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Jawaban: {{ $answer->selected_answer }}
                            </span>
                            @endif
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Benar: {{ $answer->question->correct_answer }}
                            </span>
                        </div>
                        @endif

                        @if($answer->question->explanation && !$answer->is_correct)
                        <div class="mt-3 p-3 rounded-lg bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                            <span class="font-bold text-gray-800 dark:text-gray-200">Penjelasan:</span> {!! $answer->question->explanation !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ============ ACTION BUTTONS ============ --}}
    <div class="mt-8 flex flex-col sm:flex-row gap-3 animate-fade-in-up-4">
        <a href="{{ route('seeker.tpa.index') }}"
            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 font-semibold bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-gray-300 dark:hover:border-slate-500 transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Tes
        </a>
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Ke Dashboard
        </a>
    </div>
</div>

<script>
function filterReview(category) {
    const items = document.querySelectorAll('.review-item');
    const tabs = document.querySelectorAll('.review-tab');

    tabs.forEach(tab => {
        const isActive = tab.dataset.filter === category;
        if (isActive) {
            tab.className = 'review-tab px-3 py-1.5 text-xs font-semibold rounded-lg transition-all duration-200 bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-800';
        } else {
            tab.className = 'review-tab px-3 py-1.5 text-xs font-semibold rounded-lg transition-all duration-200 bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300 border border-gray-200 dark:border-slate-600 hover:bg-gray-200 dark:hover:bg-slate-600';
        }
    });

    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = '';
            item.style.opacity = '1';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
</x-app-layout>
