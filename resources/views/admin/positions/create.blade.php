<x-app-layout>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<style>
    @keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}
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
        <div class="mb-6 anim-1">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">Buat Jabatan Baru</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Isi detail jabatan yang akan ditambahkan ke sistem.</p>
        </div>
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 anim-2">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.positions.store') }}" method="POST" class="space-y-6">
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
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="hidden" name="description" id="description" value="">
                    <trix-editor input="description" class="trix-content bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Jelaskan tanggung jawab, kualifikasi, dan benefit jabatan ini..."></trix-editor>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Gunakan toolbar di atas untuk memformat teks. Mendukung heading, list, link, dan blockquote.</p>
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
</x-app-layout>
