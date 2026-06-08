<x-app-layout>
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full mx-4">
        <div class="text-center">
            @if($session->status === 'completed')
            <div class="text-5xl mb-4 text-green-500">&#9989;</div>
            <h1 class="text-xl font-bold mb-2">Tes Sudah Selesai</h1>
            <p class="text-gray-500 mb-6">Anda sudah menyelesaikan tes ini sebelumnya.</p>
            <div class="flex gap-3">
                @if($session->result && $session->tpaTest->show_result_after)
                <a href="{{ route('seeker.tpa.result', $session) }}" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-center">
                    Lihat Hasil
                </a>
                @endif
                <a href="{{ route('seeker.tpa.index') }}" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium text-center">
                    Kembali
                </a>
            </div>
            @else
            <div class="text-5xl mb-4">&#9888;</div>
            <h1 class="text-xl font-bold mb-2">Konfirmasi Selesai</h1>
            <p class="text-gray-500 mb-6">Apakah Anda yakin ingin mengakhiri tes? Jawaban yang sudah dijawab akan disimpan dan tidak dapat diubah.</p>

            @php
            $answered = $session->answers()->whereNotNull('selected_answer')->count();
            $total = count($session->question_order ?? []);
            $unanswered = $total - $answered;
            @endphp

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <div class="flex justify-between text-sm">
                    <span>Dijawab:</span>
                    <span class="font-bold text-green-600">{{ $answered }} soal</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Belum dijawab:</span>
                    <span class="font-bold text-red-600">{{ $unanswered }} soal</span>
                </div>
            </div>

            @if($unanswered > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-6 text-sm text-yellow-700">
                Masih ada {{ $unanswered }} soal yang belum dijawab!
            </div>
            @endif

            <div class="flex gap-3">
                <a href="{{ route('seeker.tpa.test', $session) }}" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium text-center">
                    Kembali ke Tes
                </a>
                <form action="{{ route('seeker.tpa.submit', $session) }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">
                        Ya, Selesai
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
