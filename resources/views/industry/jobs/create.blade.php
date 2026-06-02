<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Posting Lowongan Kerja</h2>
                        <p class="mt-2 text-gray-600 dark:text-slate-400">Buat lowongan baru dan temukan talenta terbaik untuk perusahaan Anda.</p>
                    </div>
                </div>
            </div>

            <!-- Trix Editor -->
            <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
            <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
            <style>
                .trix-button-group {
                    background: white;
                }

                .dark .trix-button-group {
                    background: #1e293b;
                    border-color: #334155;
                }

                .dark trix-toolbar [data-trix-button] {
                    color: #cbd5e1;
                    border-color: #334155;
                }

                .dark trix-toolbar [data-trix-button]:hover {
                    background: #334155;
                }

                .dark trix-toolbar [data-trix-button].trix-active {
                    background: #475569;
                    color: white;
                }

                trix-editor {
                    min-height: 200px;
                }

                .dark trix-editor {
                    background-color: #1e293b;
                    color: #f8fafc;
                    border-color: #334155;
                }

                /* Fix tailwind reset for trix content */
                .trix-content ul {
                    list-style-type: disc;
                    padding-left: 1.5rem;
                    margin-bottom: 1rem;
                }

                .trix-content ol {
                    list-style-type: decimal;
                    padding-left: 1.5rem;
                    margin-bottom: 1rem;
                }

                .trix-content a {
                    color: #3b82f6;
                    text-decoration: underline;
                }

                .trix-content strong {
                    font-weight: 700;
                }

                .trix-content h1 {
                    font-size: 1.5rem;
                    font-weight: bold;
                    margin-top: 1rem;
                    margin-bottom: 0.5rem;
                }
            </style>

            <form action="{{ route('industry.jobs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Left Column (Main Details) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Card: Informasi Dasar -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Informasi Dasar</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Searchable Dropdown for Position Category -->
                                    <div x-data="{
                                        open: false,
                                        search: '',
                                        selected: '{{ old('position_id') }}',
                                        selectedName: 'Pilih Kategori Posisi...',
                                        options: [
                                            @foreach($positions as $position)
                                                { id: '{{ $position->id }}', name: '{{ addslashes($position->name) }}' },
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
                                        },
                                        init() {
                                            if (this.selected) {
                                                const opt = this.options.find(o => o.id == this.selected);
                                                if (opt) this.selectedName = opt.name;
                                            }
                                        }
                                    }" class="relative w-full" @click.away="open = false" x-init="init()">

                                        <input type="hidden" name="position_id" :value="selected">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Kategori Posisi <span class="text-red-500">*</span></label>

                                        <div @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
                                            class="flex items-center justify-between w-full rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm sm:text-sm p-3 transition-colors cursor-pointer focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500"
                                            :class="{'border-blue-500 ring-1 ring-blue-500': open}">
                                            <span x-text="selectedName" :class="{'text-gray-400 dark:text-gray-500': !selected}"></span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>

                                        <div x-show="open" style="display: none;"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-lg">

                                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                                <input type="text" x-model="search" placeholder="Cari kategori..."
                                                    class="w-full text-sm rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-blue-500 focus:ring-blue-500 p-2"
                                                    @keydown.escape="open = false"
                                                    @keydown.enter.prevent="if(filteredOptions.length === 0 && search.trim() !== '') { selectOption({id: search, name: search}) } else if (filteredOptions.length > 0) { selectOption(filteredOptions[0]) }"
                                                    x-ref="searchInput">
                                            </div>

                                            <ul class="max-h-60 overflow-y-auto p-1 custom-scrollbar">
                                                <template x-for="option in filteredOptions" :key="option.id">
                                                    <li @click="selectOption(option)"
                                                        class="cursor-pointer px-3 py-2 rounded-lg text-sm transition-colors hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-700 dark:hover:text-blue-400"
                                                        :class="{'bg-blue-50 text-blue-600 dark:bg-slate-700 dark:text-blue-400 font-semibold': selected == option.id, 'text-gray-700 dark:text-slate-200': selected != option.id}">
                                                        <span x-text="option.name"></span>
                                                    </li>
                                                </template>
                                                <li x-show="filteredOptions.length === 0 && search.trim() !== ''" class="px-3 py-2 text-sm text-center">
                                                    <div class="mb-2 text-gray-500 dark:text-slate-400">Kategori "<span x-text="search" class="font-semibold text-gray-700 dark:text-white"></span>" tidak ditemukan.</div>
                                                    <button type="button" @click="selectOption({id: search, name: search})" class="w-full px-3 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 rounded-lg text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                                        + Tambah "<span x-text="search"></span>"
                                                    </button>
                                                </li>
                                                <li x-show="filteredOptions.length === 0 && search.trim() === ''" class="px-3 py-2 text-sm text-gray-500 dark:text-slate-400 text-center">
                                                    Ketik untuk mencari
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Judul Spesifik Lowongan <span class="text-red-500">*</span></label>
                                        <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Senior UI/UX Designer"
                                            class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Nama Perusahaan <span class="text-red-500">*</span></label>
                                    <input type="text" name="company_name" required value="{{ old('company_name', Auth::user()->company->name ?? '') }}"
                                        class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Lokasi Penempatan<span class="text-red-500">*</span></label>
                                        <div x-data="{
                                            open: false,
                                            search: '{{ old('location') }}',
                                            options: ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Tangerang', 'Tangerang Selatan', 'Depok', 'Batam', 'Padang', 'Denpasar', 'Pekanbaru', 'Bogor', 'Malang', 'Yogyakarta', 'Surakarta', 'Balikpapan', 'Banjarmasin', 'Pontianak', 'Samarinda', 'Manado', 'Mataram', 'Cimahi', 'Banda Aceh', 'Ambon', 'Jayapura', 'Kupang', 'Palu', 'Kendari', 'Cirebon', 'Madiun', 'Kediri', 'Tegal', 'Pekalongan', 'Probolinggo', 'Pasuruan', 'Mojokerto', 'Bontang', 'Pangkalpinang', 'Dumai', 'Sorong', 'Bengkulu', 'Jambi', 'Gorontalo', 'Ternate', 'Remote', 'Luar Negeri'],
                                            get filteredOptions() {
                                                if (this.search === '') return this.options;
                                                return this.options.filter(i => i.toLowerCase().includes(this.search.toLowerCase()));
                                            },
                                            selectOption(opt) {
                                                this.search = opt;
                                                this.open = false;
                                            }
                                        }" class="relative w-full" @click.away="open = false">

                                            <input type="text" name="location" x-model="search" placeholder="Contoh: Jakarta Selatan / Remote" required autocomplete="off"
                                                @focus="open = true" @keydown.escape="open = false"
                                                class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">

                                            <div x-show="open" style="display: none;"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-lg">

                                                <ul class="max-h-60 overflow-y-auto p-1 custom-scrollbar">
                                                    <template x-for="option in filteredOptions" :key="option">
                                                        <li @click="selectOption(option)"
                                                            class="cursor-pointer px-3 py-2 rounded-lg text-sm transition-colors hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-700 dark:hover:text-blue-400"
                                                            :class="{'bg-blue-50 text-blue-600 dark:bg-slate-700 dark:text-blue-400 font-semibold': search.toLowerCase() === option.toLowerCase(), 'text-gray-700 dark:text-slate-200': search.toLowerCase() !== option.toLowerCase()}">
                                                            <span x-text="option"></span>
                                                        </li>
                                                    </template>
                                                    <li x-show="filteredOptions.length === 0 && search.trim() !== ''" class="px-3 py-2 text-sm text-center text-gray-500 dark:text-slate-400">
                                                        Tekan Enter atau klik di luar untuk menggunakan &quot;<span x-text="search" class="font-semibold text-gray-700 dark:text-white"></span>&quot;
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Tipe Kerja <span class="text-red-500">*</span></label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="work_type" value="remote" required class="peer sr-only" {{ old('work_type') == 'remote' ? 'checked' : '' }}>
                                                <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Remote</span>
                                                </div>
                                            </label>
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="work_type" value="hybrid" required class="peer sr-only" {{ old('work_type') == 'hybrid' ? 'checked' : '' }}>
                                                <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Hybrid</span>
                                                </div>
                                            </label>
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="work_type" value="onsite" required class="peer sr-only" {{ old('work_type') == 'onsite' ? 'checked' : '' }}>
                                                <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">On-site</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div x-data="{
                                        open: false,
                                        search: '',
                                        selected: '{{ old('experience_level') }}',
                                        options: [
                                            @for ($i = 0; $i <= 11; $i++) '{{ $i }} bulan', @endfor
                                            @for ($i = 1; $i <= 5; $i++) '{{ $i }} tahun', @endfor
                                            'Lebih dari 5 tahun'
                                        ],
                                        get filteredOptions() {
                                            if (this.search === '') return this.options;
                                            return this.options.filter(opt => opt.toLowerCase().includes(this.search.toLowerCase()));
                                        },
                                        selectOption(opt) {
                                            this.selected = opt;
                                            this.open = false;
                                            this.search = '';
                                        }
                                    }"
                                        class="relative"
                                        @click.away="open = false"
                                        x-init="$watch('open', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 50) })">

                                        <input type="hidden" name="experience_level" :value="selected">

                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Pengalaman Kerja <span class="text-red-500">*</span></label>

                                        <div @click="open = !open"
                                            class="flex items-center justify-between w-full rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm sm:text-sm p-3 transition-colors cursor-pointer focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500"
                                            :class="{'border-blue-500 ring-1 ring-blue-500': open}">
                                            <span x-text="selected ? selected : 'Pilih Pengalaman'" :class="{'text-gray-400': !selected}"></span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>

                                        <div x-show="open"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-lg"
                                            style="display: none;">

                                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                                <input type="text" x-model="search" placeholder="Cari pengalaman..."
                                                    class="w-full text-sm rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-blue-500 focus:ring-blue-500 p-2"
                                                    @keydown.escape="open = false"
                                                    x-ref="searchInput">
                                            </div>

                                            <ul class="max-h-60 overflow-y-auto p-1 custom-scrollbar">
                                                <template x-for="option in filteredOptions" :key="option">
                                                    <li @click="selectOption(option)"
                                                        class="cursor-pointer px-3 py-2 rounded-lg text-sm transition-colors hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-700 dark:hover:text-blue-400"
                                                        :class="{'bg-blue-50 text-blue-600 dark:bg-slate-700 dark:text-blue-400 font-semibold': selected === option, 'text-gray-700 dark:text-slate-200': selected !== option}">
                                                        <span x-text="option"></span>
                                                    </li>
                                                </template>
                                                <li x-show="filteredOptions.length === 0" class="px-3 py-2 text-sm text-gray-500 dark:text-slate-400 text-center">
                                                    Tidak ditemukan
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Batas Waktu Lamaran (Berakhir Pada) <span class="text-red-500">*</span></label>
                                    <input type="date" name="expires_date" required min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" value="{{ old('expires_date', \Carbon\Carbon::now()->addDays(30)->format('Y-m-d')) }}"
                                        class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Banner Lowongan (Opsional)</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-xl transition-colors hover:border-blue-400 bg-gray-50 dark:bg-slate-800/50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-slate-400 justify-center">
                                                <label for="banner_image" class="relative cursor-pointer bg-white dark:bg-slate-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-1">
                                                    <span>Upload file</span>
                                                    <input id="banner_image" name="banner_image" type="file" accept=".png, .jpg, .jpeg" class="sr-only">
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-slate-500">PNG, JPG, JPEG up to 2MB</p>
                                        </div>
                                    </div>
                                    <!-- Image Preview Container -->
                                    <div id="image-preview" class="hidden mt-4 relative rounded-xl overflow-hidden border border-gray-200 dark:border-slate-700 shadow-sm max-w-sm mx-auto">
                                        <img src="" alt="Banner Preview" class="w-full h-auto object-cover max-h-48">
                                        <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1.5 shadow-md hover:bg-red-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Detail Pekerjaan -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Detail Pekerjaan</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                                    <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                                    <trix-editor input="description" class="trix-content rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors placeholder:text-gray-400" placeholder="Jelaskan secara detail mengenai tanggung jawab, kualifikasi, dan benefit..."></trix-editor>
                                </div>
                                <div x-data="{ 
                                        skills: {{ old('required_skills') ? json_encode(explode(',', old('required_skills'))) : '[]' }}, 
                                        new_skill: '', 
                                        addSkill() { 
                                            let s = this.new_skill.trim(); 
                                            if(s && !this.skills.includes(s)) this.skills.push(s); 
                                            this.new_skill = ''; 
                                        }, 
                                        removeSkill(index) { 
                                            this.skills.splice(index, 1); 
                                        } 
                                    }">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Keahlian Wajib <span class="text-red-500">*</span></label>
                                    
                                    <div class="flex items-center mb-3 relative">
                                        <input type="text" x-model="new_skill" @keydown.enter.prevent="addSkill" placeholder="Ketik skill (cth: PHP) lalu Enter"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-l-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                        <button type="button" @click="addSkill" class="px-4 py-3 bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-r-xl text-sm font-semibold transition-colors">Tambah</button>
                                    </div>

                                    <!-- Tags Display -->
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <template x-for="(skill, index) in skills" :key="index">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                <span x-text="skill"></span>
                                                <button type="button" @click="removeSkill(index)" class="ml-2 focus:outline-none hover:text-blue-900 dark:hover:text-blue-100">
                                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                    </div>

                                    <input type="hidden" name="required_skills" :value="skills.join(',')">
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Sistem AI akan mencocokkan ini dengan profil dan asesmen kandidat secara otomatis.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Kriteria Demografis & Kompensasi -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Kriteria Demografis & Kompensasi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Jenis Kelamin <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <label class="cursor-pointer relative">
                                            <input type="radio" name="gender" value="Semua Jenis Kelamin" class="peer sr-only" {{ old('gender', $job->gender ?? 'Semua Jenis Kelamin') == 'Semua Jenis Kelamin' ? 'checked' : '' }}>
                                            <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-2 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                <span class="block text-xs font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Semua</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer relative">
                                            <input type="radio" name="gender" value="Pria" class="peer sr-only" {{ old('gender', $job->gender ?? '') == 'Pria' ? 'checked' : '' }}>
                                            <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-2 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                <span class="block text-xs font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Pria</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer relative">
                                            <input type="radio" name="gender" value="Wanita" class="peer sr-only" {{ old('gender', $job->gender ?? '') == 'Wanita' ? 'checked' : '' }}>
                                            <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-2 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                <span class="block text-xs font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Wanita</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Golongan Darah <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach(['Semua Golongan Darah' => 'Semua', 'A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'] as $val => $label)
                                        <label class="cursor-pointer relative">
                                            <input type="radio" name="blood_type" value="{{ $val }}" class="peer sr-only" {{ old('blood_type', $job->blood_type ?? 'Semua Golongan Darah') == $val ? 'checked' : '' }}>
                                            <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-2 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                <span class="block text-xs font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">{{ $label }}</span>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Maksimal Umur <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                    <div class="relative">
                                        <input type="number" name="max_age" value="{{ old('max_age', $job->max_age ?? '') }}" min="17" max="100" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 pr-12 transition-colors" placeholder="Contoh: 35">
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-slate-400 sm:text-sm">Tahun</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Bahasa yang Dikuasai <span class="text-gray-400 font-normal">(Opsional, bisa pilih lebih dari 1)</span></label>
                                    <div class="flex flex-wrap gap-3">
                                        @php $availableLangs = ['Indonesia', 'Inggris', 'Mandarin', 'Jepang', 'Korea', 'Arab', 'Jerman', 'Prancis']; @endphp
                                        @foreach($availableLangs as $lang)
                                        <label class="cursor-pointer relative inline-block">
                                            <input type="checkbox" name="languages[]" value="{{ $lang }}" class="peer sr-only" {{ in_array($lang, old('languages', $job->languages ?? [])) ? 'checked' : '' }}>
                                            <div class="rounded-full border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">{{ $lang }}</span>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Rentang Gaji yang Ditawarkan <span class="text-gray-400 font-normal">(Opsional, per bulan)</span></label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{
                                        salary_min: '{{ old('salary_min', (isset($job) && $job->salary_min) ? (int)$job->salary_min : '') }}',
                                        salary_max: '{{ old('salary_max', (isset($job) && $job->salary_max) ? (int)$job->salary_max : '') }}',
                                        formatCurrency(value) {
                                            if (!value) return '';
                                            let val = value.toString().replace(/\D/g, '');
                                            return new Intl.NumberFormat('id-ID').format(val);
                                        }
                                    }" x-init="salary_min = formatCurrency(salary_min); salary_max = formatCurrency(salary_max);">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-slate-400 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="hidden" name="salary_min" :value="salary_min ? salary_min.toString().replace(/\D/g, '') : ''">
                                            <input type="text" x-model="salary_min" @input="salary_min = formatCurrency($event.target.value)" class="block w-full pl-9 rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors" placeholder="Minimal (Misal: 5.000.000)">
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-slate-400 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="hidden" name="salary_max" :value="salary_max ? salary_max.toString().replace(/\D/g, '') : ''">
                                            <input type="text" x-model="salary_max" @input="salary_max = formatCurrency($event.target.value)" class="block w-full pl-9 rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors" placeholder="Maksimal (Misal: 10.000.000)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Sidebar Configs) -->
                    <div class="space-y-6">
                        <!-- Card: AI Document Weight Config -->
                        <div class="bg-gradient-to-b from-blue-50 to-white dark:from-slate-800 dark:to-slate-900 shadow-sm rounded-2xl p-6 border border-blue-100 dark:border-slate-700">
                            <h3 class="text-md font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 border-b border-blue-200 dark:border-slate-700 pb-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 flex items-center justify-center shadow-inner">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                Pembobotan Berkas AI
                            </h3>

                            <div class="space-y-4">
                                <label class="relative flex cursor-pointer rounded-xl border bg-white dark:bg-slate-800 p-4 shadow-sm focus:outline-none border-blue-500 ring-1 ring-blue-500 transition-all duration-200" id="label_default">
                                    <input type="radio" id="weight_default" name="weight_option" value="default" checked class="sr-only">
                                    <div class="flex flex-1">
                                        <div class="flex flex-col">
                                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Gunakan Referensi Admin</span>
                                            <span class="mt-1 flex items-center text-xs text-gray-500 dark:text-slate-400">
                                                Otomatis menggunakan pengaturan ideal dari sistem pusat.
                                            </span>
                                            @if(isset($defaultWeight))
                                            <div class="mt-3 text-[10px] bg-blue-50 dark:bg-slate-700/50 text-blue-700 dark:text-blue-300 p-2.5 rounded-lg font-mono flex flex-wrap gap-1.5 shadow-inner">
                                                <span>CV: {{(int)$defaultWeight->cv_weight}}%</span>|
                                                <span>Ijazah: {{(int)$defaultWeight->ijazah_weight}}%</span>|
                                                <span>Transkrip: {{(int)$defaultWeight->transkrip_weight}}%</span>|
                                                <span>Sertifikat: {{(int)$defaultWeight->sertifikat_weight}}%</span>|
                                                <span>Porto: {{(int)$defaultWeight->portofolio_weight}}%</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-3 flex items-start">
                                        <svg class="h-5 w-5 text-blue-600 check-icon" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </label>

                                <label class="relative flex cursor-pointer rounded-xl border bg-white dark:bg-slate-800 p-4 shadow-sm focus:outline-none border-gray-300 dark:border-slate-700 transition-all duration-200 hover:border-gray-400" id="label_custom">
                                    <input type="radio" id="weight_custom" name="weight_option" value="custom" class="sr-only">
                                    <div class="flex flex-1">
                                        <div class="flex flex-col">
                                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Kustomisasi Bobot</span>
                                            <span class="mt-1 flex items-center text-xs text-gray-500 dark:text-slate-400">
                                                Sesuaikan prioritas bobot dokumen secara spesifik untuk posisi ini.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex items-start">
                                        <svg class="h-5 w-5 text-blue-600 hidden check-icon" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </label>
                            </div>

                            <!-- Custom Weight Inputs (Hidden by default) -->
                            <div id="custom_weight_section" class="mt-4 p-5 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 hidden shadow-inner transition-all duration-300">
                                <p class="text-[11px] font-bold text-gray-500 dark:text-slate-400 mb-4 uppercase tracking-wider">Atur Bobot Penilaian (%)</p>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700 dark:text-slate-300">CV</label>
                                        <input type="number" name="cv_weight" id="cw_cv" value="50" min="0" max="100" class="weight-input w-24 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 text-center">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700 dark:text-slate-300">Ijazah</label>
                                        <input type="number" name="ijazah_weight" id="cw_ijazah" value="20" min="0" max="100" class="weight-input w-24 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 text-center">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700 dark:text-slate-300">Transkrip</label>
                                        <input type="number" name="transkrip_weight" id="cw_transkrip" value="15" min="0" max="100" class="weight-input w-24 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 text-center">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700 dark:text-slate-300">Sertifikat</label>
                                        <input type="number" name="sertifikat_weight" id="cw_sertifikat" value="10" min="0" max="100" class="weight-input w-24 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 text-center">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700 dark:text-slate-300">Portofolio</label>
                                        <input type="number" name="portofolio_weight" id="cw_porto" value="5" min="0" max="100" class="weight-input w-24 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 text-center">
                                    </div>
                                </div>
                                <div class="mt-5 pt-4 border-t border-gray-200 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50 -mx-5 -mb-5 p-5 rounded-b-xl">
                                    <span class="text-xs font-bold text-gray-600 dark:text-slate-400">Total Akumulasi:</span>
                                    <span id="weight_total_display" class="font-bold text-lg text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-3 py-1 rounded-lg border border-green-200 dark:border-green-800 shadow-sm">100%</span>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <p id="weight_error" class="text-[11px] font-medium text-red-600 dark:text-red-400 mt-2 hidden bg-red-50 dark:bg-red-900/30 p-2 rounded-lg border border-red-100 dark:border-red-800 transition-all">⚠️ Total bobot wajib tepat 100%.</p>
                            </div>
                        </div>

                        <!-- Action Card -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800 sticky top-6">
                            @if($errors->any())
                            <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r shadow-sm">
                                <ul class="list-disc list-inside text-sm font-medium">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <p class="text-xs text-gray-500 dark:text-slate-400 mb-5 text-center leading-relaxed bg-slate-50 dark:bg-slate-800 p-3 rounded-lg">
                                Pastikan informasi sudah benar. Lowongan akan langsung tayang dan dapat dilihat oleh pencari kerja.
                            </p>

                            <button type="submit" id="submit_btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3.5 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Publikasikan Lowongan
                            </button>
                            <a href="{{ route('industry.dashboard') }}" class="block text-center w-full mt-4 text-sm text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white font-semibold transition-colors">
                                Batal & Kembali
                            </a>
                        </div>
                    </div>

                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const radioDefault = document.getElementById('weight_default');
                    const radioCustom = document.getElementById('weight_custom');
                    const customSection = document.getElementById('custom_weight_section');
                    const weightInputs = document.querySelectorAll('.weight-input');
                    const totalDisplay = document.getElementById('weight_total_display');
                    const errorDisplay = document.getElementById('weight_error');
                    const submitBtn = document.getElementById('submit_btn');

                    const labelDefault = document.getElementById('label_default');
                    const labelCustom = document.getElementById('label_custom');

                    function updateRadioStyles() {
                        // Reset
                        labelDefault.className = 'relative flex cursor-pointer rounded-xl border bg-white dark:bg-slate-800 p-4 shadow-sm focus:outline-none border-gray-300 dark:border-slate-700 transition-all duration-200 hover:border-gray-400';
                        labelCustom.className = 'relative flex cursor-pointer rounded-xl border bg-white dark:bg-slate-800 p-4 shadow-sm focus:outline-none border-gray-300 dark:border-slate-700 transition-all duration-200 hover:border-gray-400';
                        labelDefault.querySelector('.check-icon').classList.add('hidden');
                        labelCustom.querySelector('.check-icon').classList.add('hidden');

                        // Apply Active
                        if (radioDefault.checked) {
                            labelDefault.className = 'relative flex cursor-pointer rounded-xl border bg-blue-50 dark:bg-blue-900/20 p-4 shadow-sm focus:outline-none border-blue-500 ring-1 ring-blue-500 transition-all duration-200';
                            labelDefault.querySelector('.check-icon').classList.remove('hidden');
                        } else {
                            labelCustom.className = 'relative flex cursor-pointer rounded-xl border bg-blue-50 dark:bg-blue-900/20 p-4 shadow-sm focus:outline-none border-blue-500 ring-1 ring-blue-500 transition-all duration-200';
                            labelCustom.querySelector('.check-icon').classList.remove('hidden');
                        }
                    }

                    function toggleCustomSection() {
                        updateRadioStyles();
                        if (radioCustom.checked) {
                            customSection.classList.remove('hidden');
                            calculateTotal();
                        } else {
                            customSection.classList.add('hidden');
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'hover:from-blue-700', 'hover:to-indigo-700', 'hover:-translate-y-0.5', 'hover:shadow-xl');
                            submitBtn.classList.add('hover:from-blue-700', 'hover:to-indigo-700'); // restore hover just in case
                        }
                    }

                    function calculateTotal() {
                        if (!radioCustom.checked) return;

                        let total = 0;
                        weightInputs.forEach(input => {
                            total += parseInt(input.value) || 0;
                        });

                        totalDisplay.textContent = total + '%';

                        if (total === 100) {
                            totalDisplay.className = 'font-bold text-lg text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-3 py-1 rounded-lg border border-green-200 dark:border-green-800 shadow-sm';
                            errorDisplay.classList.add('hidden');
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            totalDisplay.className = 'font-bold text-lg text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30 px-3 py-1 rounded-lg border border-red-200 dark:border-red-800 shadow-sm';
                            errorDisplay.classList.remove('hidden');
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    }

                    radioDefault.addEventListener('change', toggleCustomSection);
                    radioCustom.addEventListener('change', toggleCustomSection);

                    weightInputs.forEach(input => {
                        input.addEventListener('input', calculateTotal);
                    });

                    // Initial call
                    toggleCustomSection();

                    // Image Upload Preview Logic
                    const imageInput = document.getElementById('banner_image');
                    const imagePreview = document.getElementById('image-preview');
                    const previewImg = imagePreview.querySelector('img');
                    const removeBtn = document.getElementById('remove-image');

                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            if (file.size > 2 * 1024 * 1024) {
                                alert('Ukuran file maksimal 2MB!');
                                this.value = ''; // clear input
                                return;
                            }
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImg.src = e.target.result;
                                imagePreview.classList.remove('hidden');
                            }
                            reader.readAsDataURL(file);
                        }
                    });

                    removeBtn.addEventListener('click', function() {
                        imageInput.value = '';
                        imagePreview.classList.add('hidden');
                        previewImg.src = '';
                    });
                });
            </script>
        </div>
    </div>
</x-app-layout>