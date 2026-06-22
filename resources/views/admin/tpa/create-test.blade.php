<x-app-layout>
    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow { border-color: #e5e7eb; border-radius: 0.5rem 0.5rem 0 0; background: #f9fafb; }
        .ql-container.ql-snow { border-color: #e5e7eb; border-radius: 0 0 0.5rem 0.5rem; min-height: 150px; font-size: 0.875rem; }
        .ql-editor { min-height: 150px; }
        .dark .ql-toolbar.ql-snow { background: #1e293b; border-color: #334155; }
        .dark .ql-toolbar.ql-snow .ql-stroke { stroke: #cbd5e1; }
        .dark .ql-toolbar.ql-snow .ql-fill { fill: #cbd5e1; }
        .dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
        .dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
        .dark .ql-toolbar.ql-snow .ql-active .ql-stroke { stroke: #3b82f6; }
        .dark .ql-toolbar.ql-snow .ql-active .ql-fill { fill: #3b82f6; }
        .dark .ql-container.ql-snow { background: #1e293b; border-color: #334155; color: #f8fafc; }
        .dark .ql-editor.ql-blank::before { color: #64748b; }
        .dark .ql-snow .ql-picker { color: #cbd5e1; }
        .dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #334155; }
        .ql-snow .ql-tooltip { z-index: 50; }
    </style>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tes TPA</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.tests') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Daftar Tes</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Buat Tes</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Tes TPA</h2>
            <a href="{{ route('admin.tpa.tests') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <form action="{{ route('admin.tpa.tests.store') }}" method="POST" class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm p-6 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="Tes Potensi Akademik" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-750 dark:text-slate-300 mb-1">Deskripsi</label>
                <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                <div id="quill-description"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-755 dark:text-slate-300 mb-1">Waktu (menit) <span class="text-red-500">*</span></label>
                    <input type="number" name="time_limit_minutes" value="60" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" min="10" max="180" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-755 dark:text-slate-300 mb-1">Passing Score (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="passing_score" value="60" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" min="0" max="100" step="0.01" required>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-slate-800 pt-6">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Jumlah Soal</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['verbal' => 'Verbal', 'numerik' => 'Numerik', 'logika' => 'Logika', 'spasial' => 'Spasial'] as $key => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $key }}_count" value="10" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" min="0">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-slate-800 pt-6">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Bobot (%)</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['verbal' => ['Verbal', 30], 'numerik' => ['Numerik', 30], 'logika' => ['Logika', 20], 'spasial' => ['Spasial', 20]] as $key => [$label, $defaultWeight])
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $key }}_weight" value="{{ $defaultWeight }}" class="w-full border border-gray-300 dark:border-slate-650 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" step="0.01">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-slate-800 pt-6 space-y-3">
                <label class="flex items-center gap-2 text-gray-700 dark:text-slate-300 cursor-pointer">
                    <input type="checkbox" name="randomize_questions" value="1" checked class="rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">Acak urutan soal</span>
                </label>
                <label class="flex items-center gap-2 text-gray-700 dark:text-slate-300 cursor-pointer">
                    <input type="checkbox" name="randomize_options" value="1" checked class="rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">Acak pilihan jawaban</span>
                </label>
                <label class="flex items-center gap-2 text-gray-700 dark:text-slate-300 cursor-pointer">
                    <input type="checkbox" name="show_result_after" value="1" checked class="rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">Tampilkan hasil setelah selesai</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold transition duration-150 shadow-sm">
                    Simpan Tes
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-description', {
        theme: 'snow',
        placeholder: 'Tuliskan deskripsi atau instruksi tes TPA di sini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var existing = document.getElementById('description').value;
    if (existing) quill.root.innerHTML = existing;
    var form = document.getElementById('quill-description').closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('description').value = quill.root.innerHTML;
        });
    }
});
</script>
</x-app-layout>
