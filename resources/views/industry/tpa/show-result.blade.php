<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('industry.tpa.index') }}" class="text-blue-600 hover:underline text-sm">&laquo; Kembali</a>
            <a href="{{ route('industry.tpa.results.pdf', $result) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 {{ $result->is_passed ? 'bg-green-600' : 'bg-red-600' }} text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Hasil TPA: {{ $result->user->name }}</h1>
                        <p class="opacity-90">{{ $result->tpaTest->title }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-bold">{{ $result->bappenas_score }}</div>
                        <div class="text-sm opacity-90">Skor Bappenas</div>
                        <div class="mt-1 text-lg font-semibold">{{ $result->is_passed ? 'LULUS' : 'TIDAK LULUS' }}</div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    @foreach(['verbal' => 'Verbal', 'numerik' => 'Numerik', 'logika' => 'Logika', 'spasial' => 'Spasial'] as $key => $label)
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-500">{{ $label }}</div>
                        <div class="text-2xl font-bold">{{ $result->{$key . '_score'} }}%</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="h-2 rounded-full {{ $result->{$key . '_score'} >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $result->{$key . '_score'} }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <div class="text-xl font-bold text-blue-600">{{ $result->total_score }}%</div>
                        <div class="text-xs text-gray-500">Total</div>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <div class="text-xl font-bold text-green-600">{{ $result->total_correct }}</div>
                        <div class="text-xs text-gray-500">Benar</div>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <div class="text-xl font-bold text-red-600">{{ $result->total_wrong }}</div>
                        <div class="text-xs text-gray-500">Salah</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-xl font-bold text-gray-600">{{ $result->total_unanswered }}</div>
                        <div class="text-xs text-gray-500">Tidak Dijawab</div>
                    </div>
                </div>

                <p class="text-sm text-gray-500 mb-6">Waktu: {{ floor($result->session->time_spent_seconds / 60) }}m {{ $result->session->time_spent_seconds % 60 }}s | Passing Score: {{ $result->passing_score }}% | Grade: {{ $result->score_grade }}</p>

                <h3 class="font-bold text-lg mb-3">Detail Jawaban</h3>
                <div class="space-y-2">
                    @foreach($result->session->answers as $i => $answer)
                    <div class="border rounded-lg p-3 {{ $answer->is_correct ? 'border-green-200 bg-green-50' : ($answer->selected_answer ? 'border-red-200 bg-red-50' : 'border-gray-200 bg-gray-50') }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <span class="text-xs px-2 py-1 rounded bg-white">{{ $answer->question->category_label }}</span>
                                <p class="mt-1 text-sm">{{ Str::limit($answer->question->question_text, 120) }}</p>
                            </div>
                            <div class="text-right ml-3">
                                @if($answer->is_correct)
                                <span class="text-green-600 font-bold text-sm">&#10003; Benar</span>
                                @elseif($answer->selected_answer)
                                <span class="text-red-600 font-bold text-sm">&#10007; Salah</span>
                                <div class="text-xs text-gray-500">Jawaban: {{ $answer->selected_answer }} | Benar: {{ $answer->question->correct_answer }}</div>
                                @else
                                <span class="text-gray-400 text-sm">-- Tidak Dijawab</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>