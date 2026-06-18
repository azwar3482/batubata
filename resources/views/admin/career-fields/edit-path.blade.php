<x-app-layout>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<style>
    .trix-button-group { background: white; }
    .dark .trix-button-group { background: #1e293b; border-color: #334155; }
    .dark trix-toolbar [data-trix-button] { color: #cbd5e1; border-color: #334155; }
    .dark trix-toolbar [data-trix-button]:hover { background: #334155; }
    .dark trix-toolbar [data-trix-button].trix-active { background: #475569; color: white; }
    trix-editor { min-height: 120px; }
    .dark trix-editor { background-color: #1e293b; color: #f8fafc; border-color: #334155; }
    .trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .trix-content a { color: #3b82f6; text-decoration: underline; }
    .trix-content strong { font-weight: 700; }
    .trix-content h1 { font-size: 1.5rem; font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; }
    .trix-content h2 { font-size: 1.25rem; font-weight: bold; margin-top: 0.75rem; margin-bottom: 0.5rem; }
    .trix-content p { margin-bottom: 0.5rem; }
    .trix-content blockquote { border-left: 3px solid #cbd5e1; padding-left: 1rem; margin-left: 0; color: #64748b; }
</style>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                <trix-editor input="description" class="trix-content bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Tuliskan deskripsi untuk level karir ini..."></trix-editor>
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
                <trix-editor input="tips" class="trix-content bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Tips untuk mencapai level ini..."></trix-editor>
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
</x-app-layout>
