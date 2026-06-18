<x-app-layout>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<style>
    trix-editor { min-height: 150px; }
    .dark trix-editor { background-color: #1e293b; color: #f8fafc; border-color: #334155; }
    .dark .trix-button-group { background: #1e293b; border-color: #334155; }
    .dark trix-toolbar [data-trix-button] { color: #cbd5e1; border-color: #334155; }
    .dark trix-toolbar [data-trix-button]:hover { background: #334155; }
    .dark trix-toolbar [data-trix-button].trix-active { background: #475569; color: white; }
    .trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .trix-content a { color: #3b82f6; text-decoration: underline; }
</style>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.chat-faqs.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
        <h1 class="text-2xl font-bold mb-6">Edit FAQ</h1>

        <form action="{{ route('admin.chat-faqs.update', $faq) }}" method="POST" x-data="faqForm()" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <input type="text" name="question" value="{{ old('question', $faq->question) }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jawaban <span class="text-red-500">*</span></label>
                <input type="hidden" name="answer" id="answer" value="{{ old('answer', $faq->answer) }}">
                <trix-editor input="answer" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm" placeholder="Tuliskan jawaban yang lengkap dan jelas..."></trix-editor>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg px-3 py-2">
                        @foreach(['umum', 'job_seeker', 'industry', 'education', 'tpa'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $faq->category) === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Prioritas (0-100)</label>
                    <input type="number" name="priority" value="{{ old('priority', $faq->priority) }}" class="w-full border rounded-lg px-3 py-2" min="0" max="100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Role yang Bisa Melihat</label>
                <div class="flex gap-4">
                    @foreach(['job_seeker', 'industry', 'education', 'admin'] as $role)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="roles[]" value="{{ $role }}" class="rounded" {{ in_array($role, old('roles', $faq->roles ?? [])) ? 'checked' : '' }}>
                        <span class="text-sm">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Keywords (pisahkan koma)</label>
                <input type="text" name="keywords" value="{{ old('keywords', implode(', ', $faq->keywords ?? [])) }}" class="w-full border rounded-lg px-3 py-2" placeholder="lamar, apply, melamar">
            </div>

            {{-- Deep Links Builder --}}
            <div>
                <label class="block text-sm font-medium mb-1">Link Menu Terkait</label>
                <p class="text-xs text-gray-500 mb-2">Tambahkan link ke menu yang relevan agar user bisa langsung navigasi</p>

                <div class="space-y-2">
                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg">
                            <input type="text" x-model="link.label" class="flex-1 border rounded px-2 py-1.5 text-sm" placeholder="Label">
                            <select x-model="link.url" class="border rounded px-2 py-1.5 text-sm w-48" @change="if($event.target.value) link.url = $event.target.value">
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
                            <input type="text" x-model="link.url" class="flex-1 border rounded px-2 py-1.5 text-sm" placeholder="URL">
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
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm">Aktif</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Update FAQ</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('faqForm', () => ({
        links: @json(old('deep_links', $faq->deep_links ?? [{ label: '', url: '' }])),
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
