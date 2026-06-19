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
                <trix-editor input="description" class="trix-content bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Tuliskan deskripsi untuk level karir ini..."></trix-editor>
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
                <trix-editor input="tips" class="trix-content bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Tips untuk mencapai level ini..."></trix-editor>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks.</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Simpan</button>
        </form>
    </div>
</div>
</x-app-layout>
