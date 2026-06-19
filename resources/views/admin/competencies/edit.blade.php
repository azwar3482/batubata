<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 text-sm">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <a href="{{ route('admin.competencies') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 ml-1 md:ml-2 text-sm">
                                    Kompetensi
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-900 dark:text-white ml-1 md:ml-2 text-sm font-medium">Edit Kompetensi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Edit Kompetensi</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">Perbarui data kompetensi: <strong>{{ $competency->name }}</strong></p>
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.competencies.update', $competency) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Section 1: Basic Information -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">Informasi Kompetensi</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Kode Kompetensi <span class="text-red-500">*</span></label>
                            <input type="text" name="code" id="code" required value="{{ old('code', $competency->code) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition uppercase"
                                placeholder="Misal: TECH-01">
                            @error('code')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Nama Kompetensi <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" required value="{{ old('name', $competency->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Contoh: Pemrograman Python">
                            @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Category -->
                        <div x-data="{ category: '{{ old('category', $competency->category) }}' }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex p-4 border rounded-xl cursor-pointer focus-within:ring-2 focus-within:ring-blue-500 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition"
                                    :class="category === 'technical' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'">
                                    <input type="radio" name="category" value="technical" class="sr-only" x-model="category" required>
                                    <div>
                                        <span class="block text-sm font-bold text-gray-900 dark:text-white">Teknis</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pemrograman, data, infrastruktur, dll.</span>
                                    </div>
                                </label>
                                <label class="relative flex p-4 border rounded-xl cursor-pointer focus-within:ring-2 focus-within:ring-blue-500 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition"
                                    :class="category === 'soft_skill' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-slate-600'">
                                    <input type="radio" name="category" value="soft_skill" class="sr-only" x-model="category" required>
                                    <div>
                                        <span class="block text-sm font-bold text-gray-900 dark:text-white">Soft Skill</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">Komunikasi, kepemimpinan, kerja tim, dll.</span>
                                    </div>
                                </label>
                            </div>
                            @error('category')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Position Searchable Dropdown -->
                        <div class="relative" x-data="searchableDropdown({
                            name: 'position_id',
                            options: {{ json_encode(collect([['value' => '', 'label' => '-- Umum (Semua Posisi) --']])->concat($positions->map(fn($p) => ['value' => (string)$p->id, 'label' => $p->name]))) }},
                            selected: '{{ old('position_id', $competency->position_id ? (string)$competency->position_id : '') }}',
                            placeholder: '-- Umum (Semua Posisi) --',
                            required: false
                        })" x-init="init()" @click.away="open = false">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Posisi Target <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="hidden" name="position_id" :value="selected">
                            <div @click="open = !open; if(open) $nextTick(() => $refs.search.focus())"
                                class="w-full px-4 py-3 border rounded-lg text-sm transition cursor-pointer flex items-center justify-between bg-white dark:bg-slate-900"
                                :class="open ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-300 dark:border-slate-600'">
                                <span :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" x-text="selectedLabel || placeholder"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input x-ref="search" x-model="search" type="text"
                                        class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Cari posisi...">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.value">
                                        <li @click="select(opt)" class="px-4 py-2 text-sm cursor-pointer flex items-center justify-between transition-colors"
                                            :class="selected === opt.value ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700'">
                                            <span x-text="opt.label"></span>
                                            <svg x-show="selected === opt.value" class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </li>
                                    </template>
                                    <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-center text-gray-400 dark:text-gray-500">Tidak ditemukan</li>
                                </ul>
                            </div>
                            @error('position_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Min Level Required -->
                        <div>
                            <label for="min_level_required" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Level Minimal (1-10) <span class="text-red-500">*</span></label>
                            <input type="number" name="min_level_required" id="min_level_required" required min="1" max="10"
                                value="{{ old('min_level_required', $competency->min_level_required) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Cth: 5">
                            <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">1-2=Tidak Tahu, 3-4=Pemula, 5-6=Menengah, 7-8=Mahir, 9-10=Ahli</p>
                            @error('min_level_required')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <!-- Source Reference -->
                        <div>
                            <label for="source_reference" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Sumber/Referensi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="source_reference" id="source_reference"
                                value="{{ old('source_reference', $competency->source_reference) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Link materi/referensi...">
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('admin.competencies') }}"
                            class="px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-800 transition shadow-lg">
                            Simpan Perubahan
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
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
