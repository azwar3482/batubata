<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 anim-1">
            <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('industry.competencies.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kompetensi</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tambah</span>
        </nav>

        <div class="mb-6">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">Tambah Kompetensi Perusahaan</h2>
            <p class="text-gray-500 dark:text-slate-400 mt-1">Buat standar kompetensi khusus untuk lowongan perusahaan Anda.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('industry.competencies.store') }}" method="POST" class="space-y-6">
                @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Kode Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" required value="{{ old('code') }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition uppercase" placeholder="Misal: TECH-01">
                    @error('code')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Nama Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" placeholder="Contoh: Pemrograman Python">
                    @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="soft_skill" {{ old('category') == 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                    </select>
                    @error('category')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div x-data="searchableDropdown()" x-init="options = [
                    @foreach($jobs as $job)
                    { value: '{{ $job->id }}', label: {{ json_encode($job->title) }} },
                    @endforeach
                ]; placeholder = '-- Semua Lowongan --'; if(selected) { const match = options.find(o => o.value === selected); if(match) selectedLabel = match.label; }" @click.away="open = false" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Untuk Lowongan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <div>
                        <div @click="open = !open; if(open) $nextTick(() => $refs.search.focus())"
                            class="w-full px-4 py-2.5 border rounded-lg text-sm transition cursor-pointer flex items-center justify-between bg-white dark:bg-slate-700"
                            :class="open ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-200 dark:border-slate-600'">
                            <span :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" x-text="selectedLabel || placeholder"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        <input type="hidden" name="job_listing_id" :value="selected">
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input x-ref="search" x-model="search" type="text" class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari lowongan...">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="select({value: '', label: '-- Semua Lowongan --'})" class="px-4 py-2.5 text-sm cursor-pointer transition-colors text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">-- Semua Lowongan --</li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="select(opt)" class="px-4 py-2.5 text-sm cursor-pointer transition-colors"
                                        :class="selected === opt.value ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700'">
                                        <span x-text="opt.label"></span>
                                    </li>
                                </template>
                                <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-center text-gray-400 dark:text-gray-500">Tidak ditemukan</li>
                            </ul>
                        </div>
                    </div>
                    @error('job_listing_id')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div x-data="searchableDropdown()" x-init="options = [
                    @foreach($positions as $position)
                    { value: '{{ $position->id }}', label: {{ json_encode($position->name) }} },
                    @endforeach
                ]; placeholder = '-- Umum (Semua Posisi) --'; if(selected) { const match = options.find(o => o.value === selected); if(match) selectedLabel = match.label; }" @click.away="open = false" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Posisi Target <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <div>
                        <div @click="open = !open; if(open) $nextTick(() => $refs.search.focus())"
                            class="w-full px-4 py-2.5 border rounded-lg text-sm transition cursor-pointer flex items-center justify-between bg-white dark:bg-slate-700"
                            :class="open ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-200 dark:border-slate-600'">
                            <span :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" x-text="selectedLabel || placeholder"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        <input type="hidden" name="position_id" :value="selected">
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input x-ref="search" x-model="search" type="text" class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari posisi...">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="select({value: '', label: '-- Umum (Semua Posisi) --'})" class="px-4 py-2.5 text-sm cursor-pointer transition-colors text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">-- Umum (Semua Posisi) --</li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="select(opt)" class="px-4 py-2.5 text-sm cursor-pointer transition-colors"
                                        :class="selected === opt.value ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700'">
                                        <span x-text="opt.label"></span>
                                    </li>
                                </template>
                                <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-center text-gray-400 dark:text-gray-500">Tidak ditemukan</li>
                            </ul>
                        </div>
                    </div>
                    @error('position_id')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="min_level_required" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Level Minimal (1-10) <span class="text-red-500">*</span></label>
                    <input type="number" name="min_level_required" id="min_level_required" required min="1" max="10" value="{{ old('min_level_required', 5) }}" class="w-full px-4 py-2.5 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    <p class="mt-1 text-xs text-gray-400 dark:text-slate-500">1-2=Tidak Tahu, 3-4=Pemula, 5-6=Menengah, 7-8=Mahir, 9-10=Ahli</p>
                    @error('min_level_required')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('industry.competencies.index') }}" class="px-5 py-2.5 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-lg font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">Simpan Kompetensi</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
<script>
window.searchableDropdown = function() {
    return {
        open: false,
        search: '',
        selected: '',
        selectedLabel: '',
        options: [],
        placeholder: '-- Pilih --',
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
