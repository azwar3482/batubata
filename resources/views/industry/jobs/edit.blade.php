<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Edit Lowongan Kerja') }}
                </h2>
                <a href="{{ route('industry.jobs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                    Batal
                </a>
            </div>

            <!-- Trix Editor -->
            <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
            <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
            <style>
                .trix-button-group { background: white; }
                .dark .trix-button-group { background: #1e293b; border-color: #334155; }
                .dark trix-toolbar [data-trix-button] { color: #cbd5e1; border-color: #334155; }
                .dark trix-toolbar [data-trix-button]:hover { background: #334155; }
                .dark trix-toolbar [data-trix-button].trix-active { background: #475569; color: white; }
                trix-editor { min-height: 200px; }
                .dark trix-editor { background-color: #1e293b; color: #f8fafc; border-color: #334155; }
                /* Fix tailwind reset for trix content */
                .trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
                .trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
                .trix-content a { color: #3b82f6; text-decoration: underline; }
                .trix-content strong { font-weight: 700; }
                .trix-content h1 { font-size: 1.5rem; font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; }
            </style>

            <form action="{{ route('industry.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Kolom Kiri: Informasi Dasar & Detail Pekerjaan -->
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
                                        selected: '{{ old('position_id', $job->position_id) }}',
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
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
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
                                                <li x-show="filteredOptions.length === 0" class="px-3 py-2 text-sm text-gray-500 dark:text-slate-400 text-center">
                                                    Kategori tidak ditemukan
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Judul Spesifik Lowongan <span class="text-red-500">*</span></label>
                                        <input type="text" name="title" value="{{ old('title', $job->title) }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors" placeholder="Contoh: Senior UI/UX Designer">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Lokasi <span class="text-red-500">*</span></label>
                                        <input type="text" name="location" value="{{ old('location', $job->location) }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors" placeholder="Contoh: Jakarta Selatan / Remote">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Status Lowongan <span class="text-red-500">*</span></label>
                                        <select name="is_active" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                            <option value="1" {{ old('is_active', $job->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('is_active', $job->is_active) == 0 ? 'selected' : '' }}>Selesai / Berakhir</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Tipe Kerja <span class="text-red-500">*</span></label>
                                        <select name="work_type" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                            <option value="remote" {{ old('work_type', $job->work_type) == 'remote' ? 'selected' : '' }}>Remote</option>
                                            <option value="hybrid" {{ old('work_type', $job->work_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                            <option value="onsite" {{ old('work_type', $job->work_type) == 'onsite' ? 'selected' : '' }}>On-site</option>
                                        </select>
                                    </div>
                                    <div x-data="{
                                        open: false,
                                        search: '',
                                        selected: '{{ old('experience_level', $job->experience_level) }}',
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
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
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
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Batas Waktu Lamaran (Berakhir Pada) <span class="text-red-500">*</span></label>
                                        <input type="date" name="expires_date" required min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" value="{{ old('expires_date', \Carbon\Carbon::parse($job->expires_date)->format('Y-m-d')) }}"
                                            class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Banner Lowongan (Biarkan kosong jika tidak ingin mengubah)</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-xl transition-colors hover:border-blue-400 bg-gray-50 dark:bg-slate-800/50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-slate-400 justify-center">
                                                <label for="banner_image" class="relative cursor-pointer bg-white dark:bg-slate-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-1">
                                                    <span>Upload file baru</span>
                                                    <input id="banner_image" name="banner_image" type="file" accept=".png, .jpg, .jpeg" class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-slate-500">PNG, JPG, JPEG up to 2MB</p>
                                        </div>
                                    </div>
                                    <!-- Image Preview -->
                                    <div id="image-preview" class="{{ $job->banner_image ? '' : 'hidden' }} mt-4 relative rounded-xl overflow-hidden border border-gray-200 shadow-sm max-w-sm mx-auto">
                                        <img src="{{ $job->banner_image ? Storage::url($job->banner_image) : '' }}" alt="Banner Preview" class="w-full h-auto object-cover max-h-48">
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
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                                    <input id="description" type="hidden" name="description" value="{{ old('description', $job->description) }}">
                                    <trix-editor input="description" class="trix-content rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"></trix-editor>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Keahlian (Skills) yang Dibutuhkan <span class="text-red-500">*</span></label>
                                    <input type="text" name="required_skills" value="{{ old('required_skills', implode(', ', $job->required_skills ?? [])) }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pisahkan dengan koma (contoh: PHP, Laravel, React, Figma)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Gaji & Konfigurasi AI -->
                    <div class="space-y-6">
                        <!-- Card: Estimasi Gaji -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800 flex items-center gap-2">
                                Estimasi Gaji (Opsional)
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Gaji Minimum (Rp)</label>
                                    <input type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Gaji Maksimum (Rp)</label>
                                    <input type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Card: AI Document Weight Config (Read Only) -->
                        <div class="bg-gradient-to-b from-blue-50 to-white dark:from-slate-800 dark:to-slate-900 shadow-sm rounded-2xl p-6 border border-blue-100 dark:border-slate-700">
                            <h3 class="text-md font-bold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2 border-b border-blue-200 dark:border-slate-700 pb-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 flex items-center justify-center shadow-inner">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                Catatan AI Matching
                            </h3>
                            <p class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                                Konfigurasi bobot penilaian tidak dapat diubah setelah lowongan dipublikasikan agar proses evaluasi pelamar tetap konsisten.
                            </p>
                        </div>

                        <!-- Action Card -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800 sticky top-6">
                            @if($errors->any())
                                <div class="mb-5 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 rounded-r shadow-sm">
                                    <ul class="list-disc list-inside text-sm font-medium">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <p class="text-xs text-gray-500 dark:text-slate-400 mb-5 text-center leading-relaxed bg-slate-50 dark:bg-slate-800 p-3 rounded-lg">
                                Pastikan perubahan data sudah benar sebelum disimpan.
                            </p>

                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3.5 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('industry.jobs.index') }}" class="block text-center w-full mt-4 text-sm text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white font-semibold transition-colors">
                                Batal & Kembali
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('banner_image');
            const imagePreview = document.getElementById('image-preview');
            const previewImg = imagePreview.querySelector('img');
            const removeBtn = document.getElementById('remove-image');

            // Simpan state awal banner jika ada
            const initialBannerSrc = previewImg.src;

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB!');
                        this.value = '';
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
                // Jika sebelumnya ada gambar original, kita biarkan tapi dikosongkan input file nya
                // Namun jika user ingin benar-benar menghapus, kita harus menambah input hidden (opsional)
                // Di sini kita hanya menyembunyikan preview jika user tidak jadi ganti / hapus preview baru
                previewImg.src = initialBannerSrc;
                if (!initialBannerSrc || initialBannerSrc.includes('undefined') || initialBannerSrc === window.location.href) {
                    imagePreview.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>