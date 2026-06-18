<x-app-layout>
<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}.anim-1{animation:fadeInUp .4s ease-out}.anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}</style>

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

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-1">
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 anim-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.competencies') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kompetensi</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Tambah</span>
    </nav>
    <div class="mb-6 anim-1">
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Tambah Kompetensi Baru</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Buat data kompetensi baru untuk lowongan dan penilaian.</p>
    </div>
    <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden anim-2">
        <form action="{{ route('admin.competencies.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kode Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" required value="{{ old('code') }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition uppercase" placeholder="Misal: TECH-01">
                    @error('code')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Contoh: Pemrograman Python">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                {{-- Category Radio Cards --}}
                <div x-data="{ category: '{{ old('category', 'technical') }}' }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex p-4 border rounded-xl cursor-pointer focus-within:ring-2 focus-within:ring-blue-500 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition duration-155" :class="category === 'technical' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'">
                            <input type="radio" name="category" value="technical" class="sr-only" x-model="category" required>
                            <div>
                                <span class="block text-sm font-bold text-gray-900 dark:text-white">Teknis</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pemrograman, data, infrastruktur, dll.</span>
                            </div>
                        </label>
                        <label class="relative flex p-4 border rounded-xl cursor-pointer focus-within:ring-2 focus-within:ring-blue-500 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition duration-155" :class="category === 'soft_skill' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'">
                            <input type="radio" name="category" value="soft_skill" class="sr-only" x-model="category" required>
                            <div>
                                <span class="block text-sm font-bold text-gray-900 dark:text-white">Soft Skill</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">Komunikasi, kepemimpinan, kerja tim, dll.</span>
                            </div>
                        </label>
                    </div>
                    @error('category')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                {{-- Position Searchable Dropdown --}}
                <div class="relative" x-data="searchableDropdown({
                    name: 'position_id',
                    options: {{ json_encode(collect([['value' => '', 'label' => '-- Umum (Semua Posisi) --']])->concat($positions->map(fn($p) => ['value' => (string)$p->id, 'label' => $p->name]))) }},
                    selected: '{{ old('position_id') }}',
                    placeholder: '-- Umum (Semua Posisi) --',
                    required: false
                })" x-init="init()" @click.away="open = false">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Posisi Target <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="hidden" name="position_id" :value="selected">
                    <div @click="open = !open; if(open) $nextTick(() => $refs.search.focus())"
                        class="w-full px-4 py-2.5 border rounded-lg text-sm transition cursor-pointer flex items-center justify-between bg-white dark:bg-slate-700"
                        :class="open ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-200 dark:border-slate-600'">
                        <span :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" x-text="selectedLabel || placeholder"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input x-ref="search" x-model="search" type="text" class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari posisi...">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="select(opt)" class="px-4 py-2 text-sm cursor-pointer flex items-center justify-between transition-colors"
                                    :class="selected === opt.value ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700'">
                                    <span x-text="opt.label"></span>
                                    <svg x-show="selected === opt.value" class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </li>
                            </template>
                            <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-center text-gray-400 dark:text-gray-500">Tidak ditemukan</li>
                        </ul>
                    </div>
                    @error('position_id')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="min_level_required" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Level Minimal (1-10) <span class="text-red-500">*</span></label>
                    <input type="number" name="min_level_required" id="min_level_required" required min="1" max="10" value="{{ old('min_level_required', 5) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Cth: 5">
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">1-2=Tidak Tahu, 3-4=Pemula, 5-6=Menengah, 7-8=Mahir, 9-10=Ahli</p>
                    @error('min_level_required')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="source_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Sumber/Referensi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="source_reference" id="source_reference" value="{{ old('source_reference') }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Link materi/referensi...">
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('admin.competencies') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Kompetensi</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
