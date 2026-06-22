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
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.career-fields.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Bidang Karir</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Edit</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Bidang Karir</h2>
            <a href="{{ route('admin.career-fields.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <form action="{{ route('admin.career-fields.update', $careerField) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf @method('PUT')

            <!-- Main Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Card: Informasi Utama -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Informasi Utama</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Bidang <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $careerField->name) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Slug <span class="text-red-500">*</span></label>
                            <input type="text" name="slug" value="{{ old('slug', $careerField->slug) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Deskripsi</label>
                        <input type="hidden" name="description" id="description" value="{{ old('description', $careerField->description) }}">
                        <div id="quill-description"></div>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-slate-400">Gunakan toolbar di atas untuk memformat teks. Mendukung heading, list, link, dan blockquote.</p>
                    </div>
                </div>

                <!-- Card: Kategori & Detail Tambahan -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Detail &amp; Klasifikasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Icon (Emoji atau SVG)</label>
                            <input type="text" name="icon" value="{{ old('icon', $careerField->icon) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" placeholder="Contoh: 💻, 📐">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Warna Aksen</label>
                            <select name="color" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                @foreach(['blue','green','purple','yellow','pink','cyan','indigo','orange','red'] as $color)
                                <option value="{{ $color }}" {{ old('color', $careerField->color) === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Skor Permintaan</label>
                            <input type="number" name="demand_score" value="{{ old('demand_score', $careerField->demand_score) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" min="0" max="100">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Contoh Posisi Pekerjaan (pisahkan dengan koma)</label>
                            <input type="text" name="job_titles" value="{{ old('job_titles', implode(', ', $careerField->job_titles ?? [])) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" placeholder="Contoh: Frontend Developer, Backend Developer, QA Engineer">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Industri Terkait (pisahkan dengan koma)</label>
                            <input type="text" name="industries" value="{{ old('industries', implode(', ', $careerField->industries ?? [])) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" placeholder="Contoh: Financial Technology, E-commerce, Healthcare">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Estimasi Gaji Minimum (IDR/Bulan)</label>
                                <input type="number" name="avg_salary_min" value="{{ old('avg_salary_min', $careerField->avg_salary_min) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" placeholder="Contoh: 5000000">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Estimasi Gaji Maksimum (IDR/Bulan)</label>
                                <input type="number" name="avg_salary_max" value="{{ old('avg_salary_max', $careerField->avg_salary_max) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" placeholder="Contoh: 15000000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (1/3) -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Action Card -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Aksi</h3>
                    
                    <div class="mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $careerField->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-white dark:bg-slate-800">
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">Aktifkan Bidang Karir</span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 pl-6">
                            Jika dinonaktifkan, bidang karir ini tidak akan muncul di sisi pengguna.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-lg text-sm font-bold transition shadow-sm hover:scale-[1.01]">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.career-fields.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-800/40 dark:to-indigo-950/20 rounded-2xl p-6 border border-blue-100/50 dark:border-slate-800/80">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Petunjuk Pengisian</h4>
                    <ul class="text-xs text-blue-800 dark:text-slate-400/90 space-y-2 list-disc list-inside">
                        <li><strong>Nama &amp; Slug</strong> wajib diisi dan mewakili bidang karir.</li>
                        <li><strong>Permintaan</strong> berupa skor 0 - 100 yang memengaruhi visual prioritas karir.</li>
                        <li><strong>Gaji</strong> membantu merekomendasikan karir dengan preferensi gaji user.</li>
                    </ul>
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
