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
            <a href="{{ route('admin.chat-faqs.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Chat FAQs</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah FAQ Baru</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Buat pertanyaan umum untuk asisten chat AI.</p>
            </div>
            <a href="{{ route('admin.chat-faqs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.chat-faqs.store') }}" method="POST" x-data="faqForm()" class="space-y-6">
                @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <input type="text" name="question" value="{{ old('question') }}" class="w-full border rounded-lg px-3 py-2" required placeholder="Contoh: Bagaimana cara melamar kerja?">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jawaban <span class="text-red-500">*</span></label>
                <input type="hidden" name="answer" id="answer" value="{{ old('answer') }}">
                <div id="quill-answer"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg px-3 py-2">
                        <option value="umum" {{ old('category') === 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="job_seeker" {{ old('category') === 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                        <option value="industry" {{ old('category') === 'industry' ? 'selected' : '' }}>Industry</option>
                        <option value="education" {{ old('category') === 'education' ? 'selected' : '' }}>Education</option>
                        <option value="tpa" {{ old('category') === 'tpa' ? 'selected' : '' }}>TPA</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Prioritas (0-100)</label>
                    <input type="number" name="priority" value="{{ old('priority', 0) }}" class="w-full border rounded-lg px-3 py-2" min="0" max="100">
                    <p class="text-xs text-gray-500 mt-1">Semakin tinggi = semakin diprioritaskan</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Role yang Bisa Melihat</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="job_seeker" class="rounded"><span class="text-sm">Job Seeker</span></label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="industry" class="rounded"><span class="text-sm">Industry</span></label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="education" class="rounded"><span class="text-sm">Education</span></label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="admin" class="rounded"><span class="text-sm">Admin</span></label>
                </div>
                <p class="text-xs text-gray-500 mt-1">Kosongkan = terlihat oleh semua role</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Keywords (pisahkan koma)</label>
                <input type="text" name="keywords" value="{{ old('keywords') }}" class="w-full border rounded-lg px-3 py-2" placeholder="lamar, apply, melamar, pekerjaan">
                <p class="text-xs text-gray-500 mt-1">Kata kunci untuk pencarian yang lebih akurat</p>
            </div>

            {{-- Deep Links Builder --}}
            <div>
                <label class="block text-sm font-medium mb-1">Link Menu Terkait</label>
                <p class="text-xs text-gray-500 mb-2">Tambahkan link ke menu yang relevan agar user bisa langsung navigasi</p>

                <div class="space-y-2" id="links-container">
                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg">
                            <input type="text" x-model="link.label" class="flex-1 border rounded px-2 py-1.5 text-sm" placeholder="Label (contoh: Lamar Kerja)">
                            <select x-model="link.url" class="border rounded px-2 py-1.5 text-sm w-48">
                                <option value="">-- Pilih Menu --</option>
                                <optgroup label="Job Seeker">
                                    <option value="/dashboard">Dashboard</option>
                                    <option value="/profile">Profil</option>
                                    <option value="/seeker/assessment">Assessment</option>
                                    <option value="/seeker/roadmap">Roadmap</option>
                                    <option value="/seeker/jobs">Cari Lowongan</option>
                                    <option value="/seeker/jobs/my-applications">Lamaran Saya</option>
                                    <option value="/seeker/courses">Kursus</option>
                                    <option value="/seeker/tpa">Tes TPA</option>
                                    <option value="/notifications">Notifikasi</option>
                                </optgroup>
                                <optgroup label="Industry">
                                    <option value="/industry/dashboard">Dashboard Industry</option>
                                    <option value="/industry/jobs">Posting Lowongan</option>
                                    <option value="/industry/jobs/create">Buat Lowongan</option>
                                    <option value="/industry/candidates">Kandidat</option>
                                    <option value="/industry/tpa">Tes TPA</option>
                                    <option value="/industry/tpa/create">Buat Tes TPA</option>
                                    <option value="/industry/tpa/questions">Bank Soal</option>
                                    <option value="/industry/tpa/results">Hasil TPA</option>
                                    <option value="/industry/team">Kelola Tim</option>
                                </optgroup>
                                <optgroup label="Education">
                                    <option value="/education/dashboard">Dashboard Education</option>
                                    <option value="/education/courses">Kelola Kursus</option>
                                    <option value="/education/programs">Program</option>
                                    <option value="/education/partners">Mitra</option>
                                    <option value="/education/students">Mahasiswa</option>
                                </optgroup>
                                <optgroup label="Admin">
                                    <option value="/admin/dashboard">Dashboard Admin</option>
                                    <option value="/admin/users">Kelola User</option>
                                    <option value="/admin/competencies">Kompetensi</option>
                                    <option value="/admin/tpa">Tes TPA</option>
                                    <option value="/admin/chat-faqs">Chat FAQ</option>
                                </optgroup>
                            </select>
                            <input type="text" x-model="link.url" class="flex-1 border rounded px-2 py-1.5 text-sm" placeholder="Atau ketik URL manual">
                            <button type="button" @click="removeLink(index)" class="text-red-500 hover:text-red-700 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addLink()" class="mt-2 text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Link
                </button>

                <input type="hidden" name="deep_links" :value="JSON.stringify(links.filter(l => l.label && l.url))">
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm">Aktif</span>
                </label>
            </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                    <a href="{{ route('admin.chat-faqs.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan FAQ</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-answer', {
        theme: 'snow',
        placeholder: 'Tuliskan jawaban yang lengkap dan jelas...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var existing = document.getElementById('answer').value;
    if (existing) quill.root.innerHTML = existing;
    var form = document.getElementById('quill-answer').closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('answer').value = quill.root.innerHTML;
        });
    }
});
</script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('faqForm', () => ({
        links: [{ label: '', url: '' }],
        addLink() {
            this.links.push({ label: '', url: '' });
        },
        removeLink(index) {
            this.links.splice(index, 1);
            if (this.links.length === 0) {
                this.links.push({ label: '', url: '' });
            }
        }
    }));
});
</script>
</x-app-layout>
