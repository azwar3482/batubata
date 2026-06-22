<x-app-layout>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
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
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4 anim-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.categories.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kategori</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah</span>
        </nav>

        <div class="flex justify-between items-center mb-6 anim-1">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Kategori Baru</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Isi detail kategori sesuai dengan jenis master data.</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 anim-2">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6" id="categoryForm">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required placeholder="Contoh: Teknis (Technical)" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div x-data="{
                    open: false,
                    search: '',
                    selected: 'competency',
                    options: [
                        { value: 'competency', label: 'Kompetensi' },
                        { value: 'position', label: 'Jabatan (Position)' },
                        { value: 'industry', label: 'Industri' },
                        { value: 'education', label: 'Pendidikan' }
                    ],
                    get filteredOptions() {
                        if (this.search === '') return this.options;
                        return this.options.filter(opt => opt.label.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    get selectedLabel() {
                        const opt = this.options.find(o => o.value === this.selected);
                        return opt ? opt.label : 'Pilih Jenis Kategori...';
                    }
                }" class="relative w-full" :class="open ? 'z-50' : 'z-10'" @click.away="open = false">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Jenis Kategori <span class="text-red-500">*</span></label>
                    <input type="hidden" name="type" :value="selected">
                    
                    <button type="button" @click="open = !open" 
                        class="w-full flex justify-between items-center px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <span x-text="selectedLabel"></span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95" 
                         class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden" 
                         style="display: none;">
                        
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" placeholder="Cari..." 
                                class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                                @keydown.enter.prevent="if(filteredOptions.length > 0) { selected = filteredOptions[0].value; open = false; }">
                        </div>
                        
                        <ul class="max-h-48 overflow-y-auto py-1 m-0 list-none p-0">
                            <template x-for="option in filteredOptions" :key="option.value">
                                <li @click="selected = option.value; open = false; search = ''" 
                                    class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 cursor-pointer flex justify-between items-center transition-colors">
                                    <span x-text="option.label"></span>
                                    <svg x-show="selected === option.value" class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </li>
                            </template>
                            <li x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-center text-gray-500 dark:text-gray-400">
                                Tidak ada hasil ditemukan.
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="hidden" name="description" id="description">
                    <div id="quill-editor"></div>
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Kategori</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Jelaskan penggunaan kategori ini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });

    document.getElementById('categoryForm').addEventListener('submit', function() {
        document.getElementById('description').value = quill.root.innerHTML;
    });
});
</script>
</x-app-layout>
