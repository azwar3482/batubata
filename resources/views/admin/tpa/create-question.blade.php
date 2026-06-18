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
    <h1 class="text-2xl font-bold mb-6">Tambah Soal TPA</h1>

    <form action="{{ route('admin.tpa.questions.store') }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
        @csrf

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="verbal">Verbal</option>
                    <option value="numerik">Numerik</option>
                    <option value="logika">Logika</option>
                    <option value="spasial">Spasial</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sub-kategori</label>
                <input type="text" name="subcategory" class="w-full border rounded-lg px-3 py-2" placeholder="sinonim, aritmetik, dll">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Level</label>
                <select name="difficulty" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="easy">Mudah</option>
                    <option value="medium" selected>Sedang</option>
                    <option value="hard">Sulit</option>
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
            <input type="file" name="question_image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
        </div>

        <h3 class="font-bold mb-3">Pilihan Jawaban</h3>
        <p class="text-xs text-gray-500 mb-3">Isi minimal 2 pilihan. Pilih jawaban yang benar di radio button.</p>

        <div class="space-y-2 mb-4">
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="A" required>
                <input type="hidden" name="options[0][key]" value="A">
                <span class="font-bold w-8">A.</span>
                <input type="text" name="options[0][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan A" required>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="B">
                <input type="hidden" name="options[1][key]" value="B">
                <span class="font-bold w-8">B.</span>
                <input type="text" name="options[1][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan B" required>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="C">
                <input type="hidden" name="options[2][key]" value="C">
                <span class="font-bold w-8">C.</span>
                <input type="text" name="options[2][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan C">
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="D">
                <input type="hidden" name="options[3][key]" value="D">
                <span class="font-bold w-8">D.</span>
                <input type="text" name="options[3][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan D">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Penjelasan Jawaban (opsional)</label>
            <div id="explanation-editor"></div>
            <input type="hidden" name="explanation" id="explanation-hidden">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">
            Simpan Soal
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

    const explanationQuill = new Quill('#explanation-editor', {
        theme: 'snow',
        placeholder: 'Tulis penjelasan jawaban di sini...',
        modules: { toolbar: toolbarOptions }
    });

    const form = document.querySelector('form');
    form.onsubmit = function() {
        document.getElementById('question-hidden').value = questionQuill.root.innerHTML;
        document.getElementById('explanation-hidden').value = explanationQuill.root.innerHTML;
    };
</script>
</x-app-layout>
