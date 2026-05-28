<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 mb-2 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Kursus Baru</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
                <form action="{{ route('admin.courses.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Kursus</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Platform -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Platform</label>
                            <input type="text" name="platform" value="{{ old('platform') }}" placeholder="Contoh: Coursera, Udemy" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                            @error('platform') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                            <select name="category" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                                <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Teknis</option>
                                <option value="soft_skill" {{ old('category') == 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kompetensi -->
                        <div x-data="{ 
                            open: false, 
                            search: '', 
                            selectedId: '{{ old('competency_id') }}',
                            selectedName: '-- Pilih Kompetensi --',
                            options: [
                                @foreach($competencies as $comp)
                                    { id: '{{ $comp->id }}', name: '{{ addslashes($comp->name) }} ({{ $comp->category }})' },
                                @endforeach
                            ],
                            get filteredOptions() {
                                if (this.search === '') return this.options;
                                return this.options.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            init() {
                                if (this.selectedId) {
                                    let option = this.options.find(i => i.id == this.selectedId);
                                    if (option) this.selectedName = option.name;
                                }
                            },
                            selectOption(option) {
                                this.selectedId = option.id;
                                this.selectedName = option.name;
                                this.open = false;
                                this.search = '';
                            }
                        }" class="md:col-span-2 relative" @click.away="open = false">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kompetensi Terkait</label>
                            
                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="competency_id" x-model="selectedId">
                            
                            <!-- Custom Select Button -->
                            <button type="button" @click="open = !open" 
                                class="w-full flex justify-between items-center bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 p-3 transition-colors dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200">
                                <span x-text="selectedName" :class="{'text-slate-500 dark:text-slate-400': selectedId === ''}"></span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Dropdown Panel -->
                            <div x-show="open" style="display: none;" 
                                class="absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg max-h-60 overflow-hidden flex flex-col">
                                <!-- Search input -->
                                <div class="p-2 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                                    <input type="text" x-model="search" placeholder="Cari kompetensi..." 
                                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 p-2 dark:text-slate-200"
                                        @keydown.enter.prevent="">
                                </div>
                                <!-- Options List -->
                                <ul class="overflow-y-auto max-h-48 py-1">
                                    <li x-show="filteredOptions.length === 0" class="px-4 py-2 text-sm text-slate-500 text-center">Tidak ditemukan</li>
                                    <template x-for="option in filteredOptions" :key="option.id">
                                        <li @click="selectOption(option)" 
                                            class="px-4 py-2 text-sm cursor-pointer transition-colors"
                                            :class="{'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium': selectedId == option.id, 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50': selectedId != option.id}">
                                            <span x-text="option.name"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            
                            @error('competency_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Level -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Level</label>
                            <select name="level" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                                <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Durasi (Jam) -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Durasi (Jam)</label>
                            <input type="number" name="duration_hours" value="{{ old('duration_hours') }}" min="1" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                            @error('duration_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Is Free Checkbox -->
                        <div class="flex items-center mt-8">
                            <input type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_free" class="ml-2 text-sm text-slate-700 font-medium">Kursus Gratis</label>
                        </div>

                        <!-- URL -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">URL Kursus</label>
                            <input type="url" name="url" value="{{ old('url') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                            @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="4" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition shadow-sm">
                            Simpan Kursus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>