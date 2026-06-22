<x-app-layout>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow { border: 1px solid #e2e8f0; border-radius: 0.5rem 0.5rem 0 0; background: #f8fafc; }
    .ql-container.ql-snow { border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 0.5rem 0.5rem; min-height: 120px; font-size: 14px; }
    .ql-editor { min-height: 120px; }
    .dark .ql-toolbar.ql-snow { background: #0f172a; border-color: #334155; }
    .dark .ql-container.ql-snow { border-color: #334155; background: #1e293b; }
    .dark .ql-editor { color: #f8fafc; }
    .dark .ql-editor.ql-blank::before { color: #94a3b8; font-style: normal; }
    .dark .ql-snow .ql-stroke { stroke: #94a3b8; }
    .dark .ql-snow .ql-fill { fill: #94a3b8; }
    .dark .ql-snow .ql-picker-label { color: #94a3b8; }
    .dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #334155; }
    .dark .ql-snow .ql-picker-item { color: #e2e8f0; }
    .dark .ql-snow .ql-picker-item:hover { color: #60a5fa; }
    .dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
    .dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
    .dark .ql-toolbar.ql-snow button.ql-active .ql-stroke { stroke: #3b82f6; }
    .dark .ql-toolbar.ql-snow button.ql-active .ql-fill { fill: #3b82f6; }
</style>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tes TPA</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.questions') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Bank Soal</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah Soal</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Soal TPA</h2>
            <a href="{{ route('admin.tpa.questions') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <form action="{{ route('admin.tpa.questions.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Kategori</label>
                    <select name="category" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        <option value="verbal">Verbal</option>
                        <option value="numerik">Numerik</option>
                        <option value="logika">Logika</option>
                        <option value="spasial">Spasial</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Sub-kategori</label>
                    <input type="text" name="subcategory" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="sinonim, aritmetik, dll">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Level</label>
                    <select name="difficulty" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        <option value="easy">Mudah</option>
                        <option value="medium" selected>Sedang</option>
                        <option value="hard">Sulit</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Teks Soal</label>
                <div id="question-editor"></div>
                <input type="hidden" name="question_text" id="question-hidden" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Gambar Soal (opsional)</label>
                <input type="file" name="question_image" accept="image/*" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <div class="border-t border-gray-100 dark:border-slate-800 pt-6">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Pilihan Jawaban</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mb-4">Isi minimal 2 pilihan. Pilih jawaban yang benar di radio button.</p>

                <div class="space-y-4">
                    @foreach(['A', 'B', 'C', 'D'] as $index => $key)
                    <div class="flex items-center gap-3">
                        <input type="radio" name="correct_answer" value="{{ $key }}" class="rounded-full border-gray-300 dark:border-slate-650 text-blue-600 focus:ring-blue-500" {{ $index === 0 ? 'required' : '' }}>
                        <input type="hidden" name="options[{{ $index }}][key]" value="{{ $key }}">
                        <span class="font-bold text-gray-750 dark:text-slate-300 w-6 text-center">{{ $key }}.</span>
                        <input type="text" name="options[{{ $index }}][text]" class="flex-1 border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Pilihan {{ $key }}" {{ $index < 2 ? 'required' : '' }}>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-slate-800 pt-6">
                <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Penjelasan Jawaban (opsional)</label>
                <div id="explanation-editor"></div>
                <input type="hidden" name="explanation" id="explanation-hidden">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold transition duration-150 shadow-sm">
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
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
