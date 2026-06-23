<x-app-layout>
@include('partials.quill-styles')
<style>
    @keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}
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
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4 anim-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.positions.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Posisi</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah</span>
        </nav>

        <div class="flex justify-between items-center mb-6 anim-1">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Jabatan Baru</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Isi detail jabatan yang akan ditambahkan ke sistem.</p>
            </div>
            <a href="{{ route('admin.positions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 anim-2">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.positions.store') }}" method="POST" class="space-y-6" id="positionForm">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required placeholder="Contoh: Web Developer" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div class="relative" x-data="searchableDropdown({
                    name: 'category',
                    options: {{ json_encode($categories->map(fn($cat) => ['value' => $cat->name, 'label' => $cat->name])) }},
                    selected: '{{ old('category') }}',
                    placeholder: '-- Pilih Kategori Bidang --',
                    required: true
                })" x-init="init()" @click.away="open = false">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori Bidang <span class="text-red-500">*</span></label>
                    <input type="hidden" name="category" :value="selected">
                    <div @click="open = !open; if(open) $nextTick(() => $refs.search.focus())"
                        class="w-full px-4 py-2.5 border rounded-lg text-sm transition cursor-pointer flex items-center justify-between bg-white dark:bg-slate-700"
                        :class="open ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-200 dark:border-slate-600'">
                        <span :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" x-text="selectedLabel || placeholder"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input x-ref="search" x-model="search" type="text" class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari bidang...">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="select(opt)" class="px-4 py-2.5 text-sm cursor-pointer flex items-center justify-between transition-colors"
                                    :class="selected === opt.value ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700'">
                                    <span x-text="opt.label"></span>
                                    <svg x-show="selected === opt.value" class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </li>
                            </template>
                            <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-center text-gray-400 dark:text-gray-500">Tidak ditemukan</li>
                        </ul>
                    </div>
                    @error('category')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="hidden" name="description" id="description">
                    <div id="quill-editor"></div>
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('admin.positions.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Jabatan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<script>
window.searchableDropdown = function(config) {
    return {
        open: false,
        search: '',
        selected: config.selected || '',
        selectedLabel: '',
        options: config.options || [],
        placeholder: config.placeholder || '-- Pilih --',
        required: config.required || false,
        init() {
            const match = this.options.find(o => o.value === this.selected);
            if (match) this.selectedLabel = match.label;
        },
        get filtered() {
            if (!this.search) return this.options;
            const q = this.search.toLowerCase();
            return this.options.filter(o => o.label.toLowerCase().includes(q));
        },
        select(opt) {
            this.selected = opt.value;
            this.selectedLabel = opt.label;
            this.open = false;
            this.search = '';
        }
    };
};
</script>
@vite(['resources/js/quill.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Jelaskan tanggung jawab, kualifikasi, dan benefit jabatan ini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'header': [2, 3, false] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });

    document.getElementById('positionForm').addEventListener('submit', function() {
        document.getElementById('description').value = quill.root.innerHTML;
    });
});
</script>
</x-app-layout>
