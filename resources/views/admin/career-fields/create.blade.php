<x-app-layout>
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
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.career-fields.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Bidang Karir</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah</span>
        </nav>
        <div class="mb-6">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">Tambah Bidang Karir</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Buat bidang karir baru untuk rekomendasi jalur karir.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.career-fields.store') }}" method="POST" class="space-y-6">
                @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Bidang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required placeholder="Teknik Informatika">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded-lg px-3 py-2" required placeholder="teknik-informatika">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                <div id="quill-description"></div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks. Mendukung heading, list, link, dan blockquote.</p>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Icon (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', '💼') }}" class="w-full border rounded-lg px-3 py-2" placeholder="💻">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Warna</label>
                    <select name="color" class="w-full border rounded-lg px-3 py-2">
                        @foreach(['blue','green','purple','yellow','pink','cyan','indigo','orange','red'] as $color)
                        <option value="{{ $color }}" {{ old('color') === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Permintaan (0-100)</label>
                    <input type="number" name="demand_score" value="{{ old('demand_score', 50) }}" class="w-full border rounded-lg px-3 py-2" min="0" max="100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Contoh Posisi (pisahkan koma)</label>
                <input type="text" name="job_titles" value="{{ old('job_titles') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Web Developer, Mobile Developer, Software Engineer">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Industri Terkait (pisahkan koma)</label>
                <input type="text" name="industries" value="{{ old('industries') }}" class="w-full border rounded-lg px-3 py-2" placeholder="IT, Startup, E-commerce">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min (Rp)</label>
                    <input type="number" name="avg_salary_min" value="{{ old('avg_salary_min') }}" class="w-full border rounded-lg px-3 py-2" placeholder="5000000">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max (Rp)</label>
                    <input type="number" name="avg_salary_max" value="{{ old('avg_salary_max') }}" class="w-full border rounded-lg px-3 py-2" placeholder="25000000">
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm">Aktif</span>
                </label>
            </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                    <a href="{{ route('admin.career-fields.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Bidang Karir</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-description', {
        theme: 'snow',
        placeholder: 'Jelaskan tentang bidang karir ini...',
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
