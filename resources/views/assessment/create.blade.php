<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Mulai Asesmen Kompetensi</h2>
                <p class="mt-2 text-gray-600">Pilih posisi karir target Anda untuk menganalisis kesenjangan skill.</p>
            </div>

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-slate-100 dark:border-slate-800">
                <form action="{{ route('seeker.assessment.store') }}" method="POST">
                    @csrf

                    <!-- Step Indicator -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                                1</div>
                            <span class="text-xs mt-2 font-semibold text-blue-600 dark:text-blue-400">Data Diri</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                        <div class="flex flex-col items-center opacity-50">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-500 dark:text-slate-400 flex items-center justify-center font-bold">
                                2</div>
                            <span class="text-xs mt-2 font-semibold text-gray-500 dark:text-slate-400">Penilaian Skill</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                        <div class="flex flex-col items-center opacity-50">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-500 dark:text-slate-400 flex items-center justify-center font-bold">
                                3</div>
                            <span class="text-xs mt-2 font-semibold text-gray-500 dark:text-slate-400">Hasil</span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Pilih Posisi -->
                        <div>
                            <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Posisi Target Karir</label>

                            <!-- Searchable Dropdown Alpine.js -->
                            <div x-data="{
                                search: '',
                                selected: '',
                                selectedName: 'Pilih posisi...',
                                open: false,
                                options: [
                                    @foreach ($positions as $pos)
                                    { id: '{{ $pos->id }}', name: '{{ addslashes($pos->name) }} ({{ addslashes($pos->category) }})' },
                                    @endforeach
                                ],
                                get filteredOptions() {
                                    if (this.search === '') return this.options;
                                    return this.options.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                selectOption(opt) {
                                    this.selected = opt.id;
                                    this.selectedName = opt.name;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" class="relative">
                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="position_id" :value="selected" required>

                                <!-- Trigger Button -->
                                <div @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())" @click.away="open = false"
                                    class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 transition shadow-sm cursor-pointer flex justify-between items-center">
                                    <span x-text="selectedName" :class="selected === '' ? 'text-gray-500 dark:text-slate-400' : 'text-gray-900 dark:text-white'"></span>
                                    <svg class="w-5 h-5 text-gray-400 dark:text-slate-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                                    class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl max-h-60 flex flex-col overflow-hidden">

                                    <!-- Search Input -->
                                    <div class="p-3 bg-slate-50 dark:bg-slate-800/80 border-b border-gray-100 dark:border-slate-700">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </div>
                                            <input x-model="search" type="text" x-ref="searchInput"
                                                class="w-full pl-9 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-sm transition-shadow"
                                                placeholder="Cari posisi..." @keydown.escape="open = false">
                                        </div>
                                    </div>

                                    <!-- Options List -->
                                    <ul class="flex-1 overflow-y-auto py-2">
                                        <template x-for="option in filteredOptions" :key="option.id">
                                            <li @click="selectOption(option)"
                                                class="px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-700/50 cursor-pointer text-gray-700 dark:text-slate-200 text-sm flex items-center transition-colors"
                                                :class="selected === option.id ? 'bg-blue-50/50 dark:bg-slate-700/30 font-medium text-blue-700 dark:text-blue-400' : ''">
                                                <span x-text="option.name"></span>
                                                <svg x-show="selected === option.id" class="w-4 h-4 ml-auto text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </li>
                                        </template>
                                        <li x-show="filteredOptions.length === 0" class="px-4 py-3 text-center text-gray-500 dark:text-slate-400 text-sm">
                                            Posisi tidak ditemukan
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End Alpine.js Dropdown -->

                            @error('position_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pendidikan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pendidikan Terakhir</label>
                            <div class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-lg text-gray-600 dark:text-slate-400 shadow-sm cursor-not-allowed">
                                {{ auth()->user()->education_level ?? 'Belum diisi' }}
                            </div>
                            <input type="hidden" name="education_level" value="{{ auth()->user()->education_level ?? 'SMA/SMK' }}">
                        </div>

                        <!-- Pengalaman -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pengalaman Kerja (Tahun)</label>
                            <div class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-lg text-gray-600 dark:text-slate-400 shadow-sm cursor-not-allowed">
                                {{ auth()->user()->experience_years ?? 0 }} Tahun
                            </div>
                            <input type="hidden" name="experience_years" value="{{ auth()->user()->experience_years ?? 0 }}">
                        </div>
                    </div>

                    <div class="mt-8">
                        @if(Auth::user()->hasCompletedProfile())
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                                Lanjut ke Penilaian Skill
                            </button>
                        @else
                            <div class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-4 flex items-start shadow-sm">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-300">Profil Anda Belum Lengkap</h4>
                                    <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">
                                        Anda harus melengkapi profil 100% untuk dapat memulai asesmen skill. Saat ini profil Anda baru <span class="font-bold">{{ Auth::user()->profile_completion_percentage }}%</span> lengkap.
                                    </p>
                                    <a href="{{ route('profile.edit') }}" class="inline-block mt-3 text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 transition-colors">
                                        Lengkapi Profil Sekarang &rarr;
                                    </a>
                                </div>
                            </div>
                            <button type="button" disabled
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gray-400 dark:bg-slate-700 text-gray-200 dark:text-slate-400 cursor-not-allowed transition">
                                Lanjut ke Penilaian Skill (Profil Belum Lengkap)
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>