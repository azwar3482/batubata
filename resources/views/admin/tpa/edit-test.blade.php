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
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">TPA</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Edit Tes</span>
        </nav>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Tes TPA</h2>
            <a href="{{ route('admin.tpa.tests') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <form action="{{ route('admin.tpa.tests.update', $test) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Dasar -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Informasi Dasar</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-slate-300">Judul</label>
                                <input type="text" name="title" value="{{ $test->title }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-slate-300">Deskripsi</label>
                                <input type="hidden" name="description" id="description" value="{{ old('description', $test->description) }}">
                                <div id="quill-description"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Waktu & Nilai -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Pengaturan Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-slate-300">Waktu Tes (menit)</label>
                                <input type="number" name="time_limit_minutes" value="{{ $test->time_limit_minutes }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" min="10" max="180" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-slate-300">Passing Score (%)</label>
                                <input type="number" name="passing_score" value="{{ $test->passing_score }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <!-- Komposisi & Bobot -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Komposisi & Bobot Soal</h3>
                        
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-slate-200 mb-3">Jumlah Soal per Kategori</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Verbal</label><input type="number" name="verbal_count" value="{{ $test->verbal_count }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" min="0"></div>
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Numerik</label><input type="number" name="numerik_count" value="{{ $test->numerik_count }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" min="0"></div>
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Logika</label><input type="number" name="logika_count" value="{{ $test->logika_count }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" min="0"></div>
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Spasial</label><input type="number" name="spasial_count" value="{{ $test->spasial_count }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" min="0"></div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-slate-200 mb-3">Bobot Penilaian (%)</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Verbal</label><input type="number" name="verbal_weight" value="{{ $test->verbal_weight }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" step="0.01"></div>
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Numerik</label><input type="number" name="numerik_weight" value="{{ $test->numerik_weight }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" step="0.01"></div>
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Logika</label><input type="number" name="logika_weight" value="{{ $test->logika_weight }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" step="0.01"></div>
                                <div><label class="block text-xs font-medium mb-1 text-gray-600 dark:text-slate-400">Spasial</label><input type="number" name="spasial_weight" value="{{ $test->spasial_weight }}" class="w-full border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg px-3 py-2" step="0.01"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Content (1/3) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="sticky top-6 space-y-6">
                        <!-- Opsi Lanjutan -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Opsi Lanjutan</h3>
                            <div class="space-y-4">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="randomize_questions" value="1" {{ $test->randomize_questions ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:checked:bg-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Acak Urutan Soal</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">Soal akan diacak untuk setiap peserta.</span>
                                    </div>
                                </label>
                                
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="randomize_options" value="1" {{ $test->randomize_options ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:checked:bg-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Acak Pilihan Jawaban</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">Pilihan A,B,C,D,E akan diacak posisinya.</span>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="show_result_after" value="1" {{ $test->show_result_after ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:checked:bg-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Tampilkan Hasil</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">Tampilkan skor kepada peserta setelah selesai.</span>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 cursor-pointer group pt-2 border-t border-gray-100 dark:border-slate-800 mt-2">
                                    <input type="checkbox" name="is_active" value="1" {{ $test->is_active ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:checked:bg-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Status Aktif</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">Tes dapat diakses oleh peserta.</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Action Card -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition-all duration-300 shadow-sm hover:shadow-md flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
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
