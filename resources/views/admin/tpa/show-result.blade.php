<x-app-layout>
<div class="max-w-4xl mx-auto px-4 py-8">
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.tpa.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">TPA</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Hasil</span>
    </nav>
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.tpa.results') }}" class="text-blue-600 hover:underline text-sm">&laquo; Kembali</a>
        <a href="{{ route('admin.tpa.results.pdf', $result) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download PDF
        </a>
    </div>

    @php
        $totalQuestions = $result->total_correct + $result->total_wrong + $result->total_unanswered;
        $accuracyRate = $totalQuestions > 0 ? round(($result->total_correct / $totalQuestions) * 100, 1) : 0;
    @endphp

    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="p-6 {{ $result->is_passed ? 'bg-gradient-to-r from-green-600 to-green-700' : 'bg-gradient-to-r from-red-600 to-red-700' }} text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-3xl font-bold">
                        {{ strtoupper(substr($result->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $result->user->name }}</h1>
                        <p class="opacity-90">{{ $result->user->email }}</p>
                        <p class="opacity-80 text-sm mt-1">Tes: {{ $result->tpaTest->title }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-5xl font-bold">{{ $result->bappenas_score }}</div>
                    <div class="text-sm opacity-90">Skor Bappenas</div>
                    <div class="mt-2 px-4 py-1 {{ $result->is_passed ? 'bg-white/20' : 'bg-white/20' }} rounded-full text-sm font-semibold inline-block">
                        {{ $result->is_passed ? '✓ LULUS' : '✗ TIDAK LULUS' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach(['verbal' => ['Verbal', 'bg-blue-50', 'text-blue-600'], 'numerik' => ['Numerik', 'bg-purple-50', 'text-purple-600'], 'logika' => ['Logika', 'bg-orange-50', 'text-orange-600'], 'spasial' => ['Spasial', 'bg-teal-50', 'text-teal-600']] as $key => [$label, $bgColor, $textColor])
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-sm text-gray-500 mb-2">{{ $label }}</div>
            <div class="text-3xl font-bold {{ $textColor }}">{{ $result->{$key . '_score'} }}%</div>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div class="h-2 rounded-full {{ $result->{$key . '_score'} >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $result->{$key . '_score'} }}%"></div>
            </div>
            <div class="text-xs text-gray-500 mt-2">Nilai minimum: 60%</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div class="text-2xl font-bold text-blue-600">{{ $result->total_score }}%</div>
            <div class="text-xs text-gray-500">Total Skor</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-2xl font-bold text-green-600">{{ $result->total_correct }}</div>
            <div class="text-xs text-gray-500">Jawaban Benar</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-2xl font-bold text-red-600">{{ $result->total_wrong }}</div>
            <div class="text-xs text-gray-500">Jawaban Salah</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-2xl font-bold text-gray-600">{{ $result->total_unanswered }}</div>
            <div class="text-xs text-gray-500">Tidak Dijawab</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h3 class="font-bold text-lg mb-4">Informasi Tes</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <div class="text-sm text-gray-500">Total Soal</div>
                <div class="font-semibold">{{ $totalQuestions }} soal</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Akurasi</div>
                <div class="font-semibold">{{ $accuracyRate }}%</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Waktu Pengerjaan</div>
                <div class="font-semibold">{{ $result->tpaTest->time_limit_minutes }} menit</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Passing Score</div>
                <div class="font-semibold">{{ $result->tpaTest->passing_score }}%</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="font-bold text-lg">Detail Jawaban</h3>
            <p class="text-sm text-gray-500 mt-1">Total {{ $result->session->answers->count() }} soal dikerjakan</p>
        </div>
        <div class="divide-y">
            @foreach($result->session->answers as $index => $answer)
            <div class="p-4 hover:bg-gray-50 {{ $answer->is_correct ? 'border-l-4 border-l-green-500' : ($answer->selected_answer ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-gray-300') }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-medium">{{ $index + 1 }}</span>
                            <span class="text-xs px-2 py-1 rounded-full {{ $answer->question->category_label == 'Verbal' ? 'bg-blue-100 text-blue-700' : ($answer->question->category_label == 'Numerik' ? 'bg-purple-100 text-purple-700' : ($answer->question->category_label == 'Logika' ? 'bg-orange-100 text-orange-700' : 'bg-teal-100 text-teal-700')) }}">
                                {{ $answer->question->category_label }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700">{!! Str::limit(strip_tags($answer->question->question_text), 150) !!}</p>
                    </div>
                    <div class="text-right ml-4">
                        @if($answer->is_correct)
                        <div class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Benar
                        </div>
                        @elseif($answer->selected_answer)
                        <div class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Salah
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Jawaban: {{ $answer->selected_answer }}</div>
                        <div class="text-xs text-green-600">Benar: {{ $answer->question->correct_answer }}</div>
                        @else
                        <div class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tidak Dijawab
                        </div>
                        @endif
                    </div>
                </div>
                @if($answer->question->explanation && !$answer->is_correct)
                <div class="mt-3 text-xs text-gray-600 bg-yellow-50 border border-yellow-200 p-3 rounded-lg">
                    <strong class="text-yellow-700">Penjelasan:</strong> {!! $answer->question->explanation !!}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
