<x-app-layout>
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('admin.tpa.questions') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Edit Soal TPA</h1>

    <form action="{{ route('admin.tpa.questions.update', $question) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                    @foreach(['verbal','numerik','logika','spasial'] as $cat)
                    <option value="{{ $cat }}" {{ $question->category === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sub-kategori</label>
                <input type="text" name="subcategory" value="{{ $question->subcategory }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Level</label>
                <select name="difficulty" class="w-full border rounded-lg px-3 py-2" required>
                    @foreach(['easy','medium','hard'] as $d)
                    <option value="{{ $d }}" {{ $question->difficulty === $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Teks Soal</label>
            <textarea name="question_text" class="w-full border rounded-lg px-3 py-2" rows="4" required>{{ $question->question_text }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Gambar Soal (opsional)</label>
            @if($question->question_image)
            <div class="mb-2"><img src="{{ asset('storage/' . $question->question_image) }}" class="h-20"></div>
            @endif
            <input type="file" name="question_image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
        </div>

        <h3 class="font-bold mb-3">Pilihan Jawaban</h3>
        <div class="space-y-2 mb-4">
            @foreach($question->options as $i => $opt)
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="{{ $opt['key'] }}" {{ $question->correct_answer === $opt['key'] ? 'checked' : '' }} required>
                <input type="hidden" name="options[{{ $i }}][key]" value="{{ $opt['key'] }}">
                <span class="font-bold w-8">{{ $opt['key'] }}.</span>
                <input type="text" name="options[{{ $i }}][text]" value="{{ $opt['text'] }}" class="flex-1 border rounded-lg px-3 py-2" required>
            </div>
            @endforeach
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Penjelasan</label>
            <textarea name="explanation" class="w-full border rounded-lg px-3 py-2" rows="2">{{ $question->explanation }}</textarea>
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }} class="rounded">
                <span class="text-sm">Aktif</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">
            Update Soal
        </button>
    </form>
</div>
</x-app-layout>
