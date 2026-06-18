<x-app-layout>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<style>
    .trix-button-group { background: white; }
    .dark .trix-button-group { background: #1e293b; border-color: #334155; }
    .dark trix-toolbar [data-trix-button] { color: #cbd5e1; border-color: #334155; }
    .dark trix-toolbar [data-trix-button]:hover { background: #334155; }
    .dark trix-toolbar [data-trix-button].trix-active { background: #475569; color: white; }
    trix-editor { min-height: 150px; }
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
                <trix-editor input="description" class="trix-content bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Jelaskan tentang bidang karir ini..."></trix-editor>
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
</x-app-layout>
