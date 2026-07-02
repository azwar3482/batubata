<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 anim-1">
                <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.dashboard') }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('industry.jobs.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.vacancy') }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ __('messages.edit') }}</span>
            </nav>

            <div class="mb-6 flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('{{ __('messages.edit_job_vacancy') }}') }}
                </h2>
                <a href="{{ route('industry.jobs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                    Batal
                </a>
            </div>

            <!-- Quill Editor -->
            @include('partials.quill-styles')
            <style>
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

            <form action="{{ route('industry.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Kolom Kiri: {{ __('messages.basic_information') }} & {{ __('messages.job_details') }} -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Card: {{ __('messages.basic_information') }} -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">{{ __('messages.basic_information') }}</h3>

                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Searchable Dropdown for Position Category -->
                                    <div x-data="{
                                        open: false,
                                        search: '',
                                        selected: '{{ old('position_id', $job->position_id) }}',
                                        selectedName: 'Pilih {{ __('messages.position_category') }}...',
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
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.position_category') }} <span class="text-red-500">*</span></label>

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
                                                        + {{ __('messages.add') }} "<span x-text="search"></span>"
                                                    </button>
                                                </li>
                                                <li x-show="filteredOptions.length === 0 && search.trim() === ''" class="px-3 py-2 text-sm text-gray-500 dark:text-slate-400 text-center">
                                                    Ketik untuk mencari
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.specific_vacancy_title') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="title" value="{{ old('title', $job->title) }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors" placeholder="Contoh: Senior UI/UX Designer">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.deployment_location') }}<span class="text-red-500">*</span></label>
                                        <div x-data="{
                                            open: false,
                                            search: '',
                                            selected: '{{ old('location', $job->location ?? '') }}',
                                            options: ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Tangerang', 'Tangerang Selatan', 'Depok', 'Batam', 'Padang', 'Denpasar', 'Pekanbaru', 'Bogor', 'Malang', 'Yogyakarta', 'Surakarta', 'Balikpapan', 'Banjarmasin', 'Pontianak', 'Samarinda', 'Manado', 'Mataram', 'Cimahi', 'Banda Aceh', 'Ambon', 'Jayapura', 'Kupang', 'Palu', 'Kendari', 'Cirebon', 'Madiun', 'Kediri', 'Tegal', 'Pekalongan', 'Probolinggo', 'Pasuruan', 'Mojokerto', 'Bontang', 'Pangkalpinang', 'Dumai', 'Sorong', 'Bengkulu', 'Jambi', 'Gorontalo', 'Ternate', 'Remote', 'Luar Negeri'],
                                            get filteredOptions() {
                                                if (this.search === '') return this.options;
                                                return this.options.filter(i => i.toLowerCase().includes(this.search.toLowerCase()));
                                            },
                                            selectOption(opt) {
                                                this.selected = opt;
                                                this.open = false;
                                                this.search = '';
                                            }
                                        }" class="relative w-full" @click.away="open = false">

                                            <input type="text" name="location" :value="selected" required class="sr-only" tabindex="-1">

                                            <div @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
                                                class="flex items-center justify-between w-full rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm sm:text-sm p-3 transition-colors cursor-pointer focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500"
                                                :class="{'border-blue-500 ring-1 ring-blue-500': open}">
                                                <span x-text="selected ? selected : 'Contoh: Jakarta Selatan / Remote'" :class="{'text-gray-400 dark:text-gray-500': !selected}"></span>
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
                                                    <input type="text" x-model="search" placeholder="Cari kota..."
                                                        class="w-full text-sm rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-blue-500 focus:ring-blue-500 p-2"
                                                        @keydown.escape="open = false"
                                                        @keydown.enter.prevent="if(filteredOptions.length === 0 && search.trim() !== '') { selectOption(search) } else if (filteredOptions.length > 0) { selectOption(filteredOptions[0]) }"
                                                        x-ref="searchInput">
                                                </div>

                                                <ul class="max-h-60 overflow-y-auto p-1 custom-scrollbar">
                                                    <template x-for="option in filteredOptions" :key="option">
                                                        <li @click="selectOption(option)"
                                                            class="cursor-pointer px-3 py-2 rounded-lg text-sm transition-colors hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-700 dark:hover:text-blue-400"
                                                            :class="{'bg-blue-50 text-blue-600 dark:bg-slate-700 dark:text-blue-400 font-semibold': selected && selected.toLowerCase() === option.toLowerCase(), 'text-gray-700 dark:text-slate-200': !selected || selected.toLowerCase() !== option.toLowerCase()}">
                                                            <span x-text="option"></span>
                                                        </li>
                                                    </template>
                                                    <li x-show="filteredOptions.length === 0 && search.trim() !== ''" class="px-3 py-2 text-sm text-center">
                                                        <div class="mb-2 text-gray-500 dark:text-slate-400">Lokasi "<span x-text="search" class="font-semibold text-gray-700 dark:text-white"></span>" tidak ditemukan.</div>
                                                        <button type="button" @click="selectOption(search)" class="w-full px-3 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 rounded-lg text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                                            + Gunakan "<span x-text="search"></span>"
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.vacancy_status') }} <span class="text-red-500">*</span></label>
                                        <select name="is_active" required class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                            <option value="1" {{ old('is_active', $job->is_active) == 1 ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                            <option value="0" {{ old('is_active', $job->is_active) == 0 ? 'selected' : '' }}>{{ __('messages.finished_ended') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">{{ __('messages.work_type') }} <span class="text-red-500">*</span></label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="work_type" value="remote" required class="peer sr-only" {{ old('work_type', $job->work_type) == 'remote' ? 'checked' : '' }}>
                                                <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Remote</span>
                                                </div>
                                            </label>
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="work_type" value="hybrid" required class="peer sr-only" {{ old('work_type', $job->work_type) == 'hybrid' ? 'checked' : '' }}>
                                                <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Hybrid</span>
                                                </div>
                                            </label>
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="work_type" value="onsite" required class="peer sr-only" {{ old('work_type', $job->work_type) == 'onsite' ? 'checked' : '' }}>
                                                <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">On-site</span>
                                                </div>
                                            </label>
                                        </div>
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

                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.work_experience') }} <span class="text-red-500">*</span></label>

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
                                                    {{ __('messages.not_found') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.application_deadline') }} <span class="text-red-500">*</span></label>
                                        <input type="date" name="expires_date" required min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" value="{{ old('expires_date', \Carbon\Carbon::parse($job->expires_date)->format('Y-m-d')) }}"
                                            class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-colors">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.vacancy_banner_leave_empty') }}</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-xl transition-colors hover:border-blue-400 bg-gray-50 dark:bg-slate-800/50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-slate-400 justify-center">
                                                <label for="banner_image" class="relative cursor-pointer bg-white dark:bg-slate-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-1">
                                                    <span>{{ __('messages.upload_new_file') }}</span>
                                                    <input id="banner_image" name="banner_image" type="file" accept=".png, .jpg, .jpeg" class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-slate-500">PNG, JPG, JPEG up to 2MB</p>
                                        </div>
                                    </div>
                                    <!-- Image Preview -->
                                    <div id="image-preview" class="{{ $job->banner_image ? '' : 'hidden' }} mt-4 relative rounded-xl overflow-hidden border border-gray-200 shadow-sm max-w-sm mx-auto">
                                        <img src="{{ $job->banner_image ? Storage::url($job->banner_image) : '' }}" alt="Banner Preview" class="w-full h-auto object-cover max-h-48" loading="lazy">
                                        <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1.5 shadow-md hover:bg-red-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card: {{ __('messages.job_details') }} -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">{{ __('messages.job_details') }}</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.full_description') }} <span class="text-red-500">*</span></label>
                                    <input id="description" type="hidden" name="description" value="{{ old('description', $job->description) }}">
                                    <div id="quill-description"></div>
                                </div>

                                <div x-data="{ 
                                        skills: {{ old('required_skills') ? json_encode(explode(',', old('required_skills'))) : (isset($job) && is_array($job->required_skills) ? json_encode($job->required_skills) : (isset($job) && is_string($job->required_skills) ? json_encode(explode(',', $job->required_skills)) : '[]')) }}, 
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
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.required_skills') }} <span class="text-red-500">*</span></label>
                                    
                                    <div class="flex items-center mb-3 relative">
                                        <input type="text" x-model="new_skill" @keydown.enter.prevent="addSkill" placeholder="Ketik skill (cth: PHP) lalu Enter"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-l-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                        <button type="button" @click="addSkill" class="px-4 py-3 bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-r-xl text-sm font-semibold transition-colors">{{ __('messages.add') }}</button>
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
                                        {{ __('messages.ai_match_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Kriteria Demografis & Kompensasi -->
                        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Kriteria Demografis & Kompensasi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">{{ __('messages.gender') }} <span class="text-gray-400 font-normal">{{ __('messages.optional') }}</span></label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <label class="cursor-pointer relative">
                                            <input type="radio" name="gender" value="Semua {{ __('messages.gender') }}" class="peer sr-only" {{ old('gender', $job->gender ?? 'Semua {{ __('messages.gender') }}') == 'Semua {{ __('messages.gender') }}' ? 'checked' : '' }}>
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
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">{{ __('messages.blood_type') }} <span class="text-gray-400 font-normal">{{ __('messages.optional') }}</span></label>
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach(['Semua {{ __('messages.blood_type') }}' => 'Semua', 'A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'] as $val => $label)
                                        <label class="cursor-pointer relative">
                                            <input type="radio" name="blood_type" value="{{ $val }}" class="peer sr-only" {{ old('blood_type', $job->blood_type ?? 'Semua {{ __('messages.blood_type') }}') == $val ? 'checked' : '' }}>
                                            <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-2 text-center transition-all hover:bg-gray-50 dark:hover:bg-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 peer-checked:ring-1 peer-checked:ring-blue-500">
                                                <span class="block text-xs font-medium text-gray-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">{{ $label }}</span>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.max_age') }} <span class="text-gray-400 font-normal">{{ __('messages.optional') }}</span></label>
                                    <div class="relative">
                                        <input type="number" name="max_age" value="{{ old('max_age', $job->max_age ?? '') }}" min="17" max="100" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 pr-12 transition-colors" placeholder="Contoh: 35">
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-slate-400 sm:text-sm">Tahun</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">{{ __('messages.languages_mastered') }} <span class="text-gray-400 font-normal">(Opsional, bisa pilih lebih dari 1)</span></label>
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
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.salary_range') }} <span class="text-gray-400 font-normal">(Opsional, per bulan)</span></label>
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

                    <!-- Kolom Kanan: Gaji & Konfigurasi AI -->
                    <div class="space-y-6">

                        <!-- Card: AI Document Weight Config (Read Only) -->
                        <div class="bg-gradient-to-b from-blue-50 to-white dark:from-slate-800 dark:to-slate-900 shadow-sm rounded-2xl p-6 border border-blue-100 dark:border-slate-700">
                            <h3 class="text-md font-bold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2 border-b border-blue-200 dark:border-slate-700 pb-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 flex items-center justify-center shadow-inner">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                {{ __('messages.ai_matching_notes') }}
                            </h3>
                            <p class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                                {{ __('messages.weight_config_cannot_change') }}
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
                                {{ __('messages.ensure_changes_correct') }}
                            </p>

                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3.5 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('messages.save_changes') }}
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
    @vite(['resources/js/quill.js'])
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: 'Deskripsi lengkap pekerjaan...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existing = document.getElementById('description').value;
        if (existing) quill.root.innerHTML = existing;
        var form = document.getElementById('quill-description').closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('description').value = quill.root.innerHTML;
            });
        }
    });
    </script>
</x-app-layout>