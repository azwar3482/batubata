<x-app-layout>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow { border: 1px solid #e2e8f0; border-radius: 0.5rem 0.5rem 0 0; background: #f8fafc; }
    .ql-container.ql-snow { border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 0.5rem 0.5rem; min-height: 120px; font-size: 14px; }
    .ql-editor { min-height: 120px; }
    .dark .ql-toolbar.ql-snow { background: #1e293b; border-color: #475569; }
    .dark .ql-container.ql-snow { border-color: #475569; background: #0f172a; color: #e2e8f0; }
    .dark .ql-snow .ql-stroke { stroke: #94a3b8; }
    .dark .ql-snow .ql-fill { fill: #94a3b8; }
    .dark .ql-snow .ql-picker-label { color: #94a3b8; }
    .dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #475569; }
    .dark .ql-snow .ql-picker-item { color: #e2e8f0; }
    .dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
    .dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
    .dark .ql-toolbar.ql-snow button.ql-active .ql-stroke { stroke: #3b82f6; }
    .dark .ql-toolbar.ql-snow button.ql-active .ql-fill { fill: #3b82f6; }
</style>

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
            <div id="question-editor"></div>
            <input type="hidden" name="question_text" id="question-hidden" required>
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
            <div id="explanation-editor"></div>
            <input type="hidden" name="explanation" id="explanation-hidden" value="{{ $question->explanation }}">
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

<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    const toolbarOptions = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'align': [] }],
        ['link', 'image'],
        ['clean']
    ];

    const questionQuill = new Quill('#question-editor', {
        theme: 'snow',
        placeholder: 'Tuliskan soal di sini...',
        modules: { toolbar: toolbarOptions }
    });

    questionQuill.root.innerHTML = `{!! addslashes($question->question_text) !!}`;

    const explanationQuill = new Quill('#explanation-editor', {
        theme: 'snow',
        placeholder: 'Tulis penjelasan jawaban di sini...',
        modules: { toolbar: toolbarOptions }
    });

    explanationQuill.root.innerHTML = `{!! addslashes($question->explanation) !!}`;

    const form = document.querySelector('form');
    form.onsubmit = function() {
        document.getElementById('question-hidden').value = questionQuill.root.innerHTML;
        document.getElementById('explanation-hidden').value = explanationQuill.root.innerHTML;
    };
</script>
</x-app-layout>
