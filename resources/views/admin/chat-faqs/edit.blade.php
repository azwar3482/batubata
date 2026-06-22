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
            <span class="text-gray-900 dark:text-white font-medium">Edit</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit FAQ</h2>
            <a href="{{ route('admin.chat-faqs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <form action="{{ route('admin.chat-faqs.update', $chat_faq) }}" method="POST" x-data="faqForm()" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf @method('PUT')

            <!-- Main Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Card: Isi FAQ -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Isi FAQ</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                            <input type="text" name="question" value="{{ old('question', $chat_faq->question) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Jawaban <span class="text-red-500">*</span></label>
                            <input type="hidden" name="answer" id="answer" value="{{ old('answer', $chat_faq->answer) }}">
                            <div id="quill-answer"></div>
                        </div>
                    </div>
                </div>

                <!-- Card: Deep Links Builder -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 border-b pb-2 border-gray-100 dark:border-slate-800">Link Menu Terkait</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-4">Tambahkan tautan navigasi instan untuk membantu pengguna berpindah menu secara langsung.</p>

                    <div class="space-y-3">
                        <template x-for="(link, index) in links" :key="index">
                            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3 bg-gray-50 dark:bg-slate-800/40 p-4 rounded-xl border border-gray-100 dark:border-slate-800">
                                <div class="flex-1">
                                    <input type="text" x-model="link.label" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Label Link (cth: Profil Saya)">
                                </div>
                                <div>
                                    <select x-model="link.url" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm md:w-48" @change="if($event.target.value) link.url = $event.target.value">
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
                                            <option value="/industry/candidates">Kandidat</option>
                                            <option value="/industry/tpa">Tes TPA</option>
                                            <option value="/industry/tpa/questions">Bank Soal</option>
                                            <option value="/industry/tpa/results">Hasil TPA</option>
                                            <option value="/industry/team">Kelola Tim</option>
                                        </optgroup>
                                        <optgroup label="Education">
                                            <option value="/education/dashboard">Dashboard Education</option>
                                            <option value="/education/courses">Kelola Kursus</option>
                                            <option value="/education/programs">Program</option>
                                            <option value="/education/partners">Mitra</option>
                                        </optgroup>
                                        <optgroup label="Admin">
                                            <option value="/admin/dashboard">Dashboard Admin</option>
                                            <option value="/admin/users">Kelola User</option>
                                            <option value="/admin/competencies">Kompetensi</option>
                                            <option value="/admin/tpa">Tes TPA</option>
                                            <option value="/admin/chat-faqs">Chat FAQ</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="text" x-model="link.url" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="URL Kustom (cth: /seeker/roadmap)">
                                </div>
                                <button type="button" @click="removeLink(index)" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addLink()" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Link
                    </button>

                    <input type="hidden" name="deep_links" :value="JSON.stringify(links.filter(l => l.label && l.url))">
                </div>
            </div>

            <!-- Right Column (1/3) -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Card: Klasifikasi & Akses -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Klasifikasi &amp; Urutan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kategori</label>
                            <select name="category" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                @foreach(['umum', 'job_seeker', 'industry', 'education', 'tpa'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $chat_faq->category) === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Prioritas (0-100)</label>
                            <input type="number" name="priority" value="{{ old('priority', $chat_faq->priority) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" min="0" max="100">
                        </div>
                    </div>
                </div>

                <!-- Card: Otoritas Role -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Target Role</h3>
                    
                    <div class="space-y-3">
                        @foreach(['job_seeker', 'industry', 'education', 'admin'] as $role)
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="{{ $role }}" class="rounded border-gray-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-white dark:bg-slate-800" {{ in_array($role, old('roles', $chat_faq->roles ?? [])) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Card: Pencarian & Metadata -->
                <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Metadata &amp; Aksi</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Keywords (pisahkan koma)</label>
                            <input type="text" name="keywords" value="{{ old('keywords', implode(', ', $chat_faq->keywords ?? [])) }}" class="w-full rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" placeholder="lamar, apply, melamar">
                        </div>

                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chat_faq->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-white dark:bg-slate-800">
                                <span class="text-sm font-medium text-gray-700 dark:text-slate-300">Tampilkan FAQ (Aktif)</span>
                            </label>
                        </div>

                        <div class="space-y-3 pt-2">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-lg text-sm font-bold transition shadow-sm hover:scale-[1.01]">
                                Update FAQ
                            </button>
                            <a href="{{ route('admin.chat-faqs.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                                Batal
                            </a>
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
        links: @json(old('deep_links', $chat_faq->deep_links ?? [['label' => '', 'url' => '']])),
        init() {
            if (!this.links || this.links.length === 0) {
                this.links = [{ label: '', url: '' }];
            }
        },
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

