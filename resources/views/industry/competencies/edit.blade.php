<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
            <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('industry.competencies.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kompetensi</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Edit</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Kompetensi</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Perbarui data kompetensi {{ $competency->name }}.</p>
            </div>
            <a href="{{ route('industry.competencies.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
        <form action="{{ route('industry.competencies.update', $competency) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Kode Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" required value="{{ old('code', $competency->code) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition uppercase">
                    @error('code')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Nama Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $competency->name) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="technical" {{ old('category', $competency->category) == 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="soft_skill" {{ old('category', $competency->category) == 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                    </select>
                    @error('category')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div x-data="{
                    open: false,
                    search: '',
                    selectedId: '{{ old('position_id', $competency->position_id) }}',
                    options: [
                        { id: '', text: '-- Umum (Semua Posisi) --' },
                        @foreach($positions as $pos)
                        { id: '{{ $pos->id }}', text: '{{ addslashes($pos->name) }}' },
                        @endforeach
                    ],
                    get selectedText() {
                        const selected = this.options.find(opt => opt.id == this.selectedId);
                        return selected ? selected.text : '-- Umum (Semua Posisi) --';
                    },
                    get filteredOptions() {
                        if (this.search === '') return this.options;
                        return this.options.filter(opt => opt.text.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    toggle() {
                        this.open = !this.open;
                        if (this.open) {
                            this.search = '';
                            this.$nextTick(() => { this.$refs.search.focus() });
                        }
                    },
                    close() {
                        this.open = false;
                    },
                    selectOption(option) {
                        this.selectedId = option.id;
                        this.close();
                    }
                }" class="relative" @click.away="close()">
                    <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Posisi Target <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="hidden" name="position_id" id="position_id" :value="selectedId">
                    
                    <button type="button" @click="toggle()"
                        class="relative w-full text-left px-4 py-2.5 border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition shadow-sm">
                        <span x-text="selectedText" class="block truncate"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <svg class="h-5 w-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" x-transition.opacity x-cloak
                        class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-800 shadow-lg rounded-xl border border-gray-100 dark:border-slate-700 py-1 text-sm ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="sticky top-0 z-20 px-3 py-2 bg-white dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" x-model="search" x-ref="search" placeholder="Cari posisi..."
                                    class="w-full pl-9 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>
                        <ul class="max-h-60 overflow-y-auto py-1">
                            <template x-for="option in filteredOptions" :key="option.id">
                                <li @click="selectOption(option)"
                                    class="text-gray-700 dark:text-slate-300 cursor-pointer select-none relative py-2.5 pl-4 pr-9 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors flex items-center"
                                    :class="{'bg-blue-50/50 dark:bg-slate-700/30 text-blue-700 dark:text-blue-400 font-medium': selectedId == option.id}">
                                    <span class="block truncate" x-text="option.text"></span>
                                    <span x-show="selectedId == option.id" class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600 dark:text-blue-400">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </li>
                            </template>
                            <li x-show="filteredOptions.length === 0" class="text-gray-500 dark:text-slate-400 cursor-default select-none relative py-3 px-4 text-center">
                                Tidak ada data yang cocok.
                            </li>
                        </ul>
                    </div>
                    @error('position_id')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="min_level_required" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Level Minimal (1-10) <span class="text-red-500">*</span></label>
                    <input type="number" name="min_level_required" id="min_level_required" required min="1" max="10" value="{{ old('min_level_required', $competency->min_level_required) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    <p class="mt-1 text-xs text-gray-400 dark:text-slate-500">1-2=Tidak Tahu, 3-4=Pemula, 5-6=Menengah, 7-8=Mahir, 9-10=Ahli</p>
                    @error('min_level_required')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('industry.competencies.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</div>
</x-app-layout>
