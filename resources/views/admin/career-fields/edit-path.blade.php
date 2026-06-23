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
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.career-fields.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Bidang Karir</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Edit Jalur</span>
        </nav>
        <div class="mb-6">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">Edit Level Karir</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Ubah detail level karir {{ $path->level_label }}.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.career-fields.update-path', [$careerField, $path]) }}" method="POST" class="space-y-6">
                @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" class="w-full border rounded-lg px-3 py-2" required>
                        @foreach(['entry','junior','mid','senior','lead','manager'] as $lvl)
                        <option value="{{ $lvl }}" {{ $path->level === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Label Level <span class="text-red-500">*</span></label>
                    <input type="text" name="level_label" value="{{ $path->level_label }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Min</label>
                    <input type="number" name="year_range_min" value="{{ $path->year_range_min }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Max</label>
                    <input type="number" name="year_range_max" value="{{ $path->year_range_max }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <input type="hidden" name="description" id="description" value="{{ old('description', $path->description) }}">
                <div id="quill-description"></div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Skill (koma)</label>
                <input type="text" name="skills_required" value="{{ implode(', ', $path->skills_required ?? []) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Sertifikasi (koma)</label>
                <input type="text" name="certifications" value="{{ implode(', ', $path->certifications ?? []) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kursus (koma)</label>
                <input type="text" name="courses" value="{{ implode(', ', $path->courses ?? []) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min</label>
                    <input type="number" name="salary_min" value="{{ $path->salary_min }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max</label>
                    <input type="number" name="salary_max" value="{{ $path->salary_max }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tips</label>
                <input type="hidden" name="tips" id="tips" value="{{ old('tips', $path->tips) }}">
                <div id="quill-tips"></div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks.</p>
            </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                    <a href="{{ route('admin.career-fields.paths', $careerField) }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Update Level Karir</button>
                </div>
            </form>
            </div>
        </div>
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
