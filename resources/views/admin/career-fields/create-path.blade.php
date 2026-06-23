<x-app-layout>
@include('partials.quill-styles')
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
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.career-fields.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Bidang Karir</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah Jalur</span>
        </nav>
        <a href="{{ route('admin.career-fields.paths', $careerField) }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
        <h1 class="text-2xl font-bold mb-6">Tambah Level Karir</h1>

        <form action="{{ route('admin.career-fields.store-path', $careerField) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="entry">Entry</option>
                        <option value="junior">Junior</option>
                        <option value="mid">Mid</option>
                        <option value="senior">Senior</option>
                        <option value="lead">Lead</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Label Level <span class="text-red-500">*</span></label>
                    <input type="text" name="level_label" class="w-full border rounded-lg px-3 py-2" required placeholder="Junior Developer">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Min</label>
                    <input type="number" name="year_range_min" class="w-full border rounded-lg px-3 py-2" min="0" placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Max</label>
                    <input type="number" name="year_range_max" class="w-full border rounded-lg px-3 py-2" min="0" placeholder="2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                <div id="quill-description"></div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Skill yang Dibutuhkan (koma)</label>
                <input type="text" name="skills_required" class="w-full border rounded-lg px-3 py-2" placeholder="HTML, CSS, JavaScript, PHP">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Sertifikasi (koma)</label>
                <input type="text" name="certifications" class="w-full border rounded-lg px-3 py-2" placeholder="AWS Certified, Google ML">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kursus (koma)</label>
                <input type="text" name="courses" class="w-full border rounded-lg px-3 py-2" placeholder="Belajar Web Dev, Advanced Laravel">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min (Rp)</label>
                    <input type="number" name="salary_min" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max (Rp)</label>
                    <input type="number" name="salary_max" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tips</label>
                <input type="hidden" name="tips" id="tips" value="{{ old('tips') }}">
                <div id="quill-tips"></div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks.</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Simpan</button>
        </form>
    </div>
</div>
@vite(['resources/js/quill.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quillDesc = new Quill('#quill-description', {
        theme: 'snow',
        placeholder: 'Tuliskan deskripsi untuk level karir ini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var existingDesc = document.getElementById('description').value;
    if (existingDesc) quillDesc.root.innerHTML = existingDesc;

    var quillTips = new Quill('#quill-tips', {
        theme: 'snow',
        placeholder: 'Tips untuk mencapai level ini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var existingTips = document.getElementById('tips').value;
    if (existingTips) quillTips.root.innerHTML = existingTips;

    var form = document.getElementById('quill-description').closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('description').value = quillDesc.root.innerHTML;
            document.getElementById('tips').value = quillTips.root.innerHTML;
        });
    }
});
</script>
</x-app-layout>
