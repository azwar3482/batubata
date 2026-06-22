<x-app-layout>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('education.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('education.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kelola Kursus</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Buat Baru</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Kursus Baru</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Buat materi pembelajaran untuk siswa/mahasiswa institusi Anda.</p>
                </div>
                <a href="{{ route('education.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; Kembali
                </a>
            </div>

            <!-- Errors Alert -->
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-xl flex gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="text-sm font-bold text-red-800 dark:text-red-300 mb-1">Terjadi kesalahan input:</h4>
                    <ul class="text-xs text-red-700 dark:text-red-400 list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Main Form -->
            <form action="{{ route('education.courses.store') }}" method="POST" enctype="multipart/form-data" 
                x-data="{ 
                    category: '{{ old('category', 'technical') }}',
                    level: '{{ old('level', 'beginner') }}',
                    isFree: {{ old('is_free') !== null ? (old('is_free') ? 'true' : 'false') : 'true' }},
                    rawPrice: '{{ old('price', 0) }}',
                    get formattedPrice() {
                        if (!this.rawPrice || this.rawPrice === '0') return '';
                        return parseInt(this.rawPrice).toLocaleString('id-ID');
                    },
                    set formattedPrice(val) {
                        let clean = val.replace(/[^0-9]/g, '');
                        this.rawPrice = clean ? parseInt(clean) : 0;
                    }
                }"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf

                <!-- Left Column (Main Form Content - 2/3 Width) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Basic Information Card -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Informasi Dasar</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Judul Kursus *</label>
                                <input type="text" name="title" value="{{ old('title') }}" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Fullstack Web Development Bootcamp">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Deskripsi *</label>
                                <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                                <div id="quill-description"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tujuan Pembelajaran</label>
                                <input type="hidden" name="objectives" id="objectives" value="{{ old('objectives') }}">
                                <div id="quill-objectives"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail & Parameter Card -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Detail & Parameter</h3>
                        <div class="space-y-6">

                            <!-- Searchable Dropdown for Competency (Alpine.js Select2 Style) -->
                            <div x-data="{ 
                                open: false, 
                                search: '', 
                                selectedId: '{{ old('competency_id', '') }}',
                                selectedName: '{{ old('competency_id') ? $competencies->firstWhere('id', old('competency_id'))->name : 'Pilih Kompetensi' }}',
                                items: [
                                    @foreach($competencies as $comp)
                                        { id: '{{ $comp->id }}', name: '{{ addslashes($comp->name) }}' },
                                    @endforeach
                                ],
                                get filteredItems() {
                                    if (!this.search) return this.items;
                                    return this.items.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                select(id, name) {
                                    this.selectedId = id;
                                    this.selectedName = name;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" 
                            class="relative">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kompetensi Terkait</label>
                                
                                <!-- Trigger Button -->
                                <button type="button" 
                                    @click="open = !open" 
                                    @click.away="open = false"
                                    class="relative w-full bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg shadow-sm pl-3 pr-10 py-2.5 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <span class="block truncate" x-text="selectedName || 'Pilih Kompetensi'"></span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>

                                <!-- Hidden Input to submit to backend -->
                                <input type="hidden" name="competency_id" :value="selectedId">

                                <!-- Dropdown List -->
                                <div x-show="open" 
                                    x-transition:leave="transition ease-in duration-100" 
                                    x-transition:leave-start="opacity-100" 
                                    x-transition:leave-end="opacity-0" 
                                    class="absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 shadow-lg max-h-60 rounded-md py-1 text-sm ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none border border-gray-200 dark:border-slate-700">
                                    
                                    <!-- Search Input -->
                                    <div class="sticky top-0 bg-white dark:bg-slate-800 p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" 
                                            x-model="search"
                                            @click.stop
                                            class="w-full border border-gray-300 dark:border-slate-750 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-1.5 px-3" 
                                            placeholder="Cari kompetensi...">
                                    </div>

                                    <ul class="py-1">
                                        <li @click="select('', 'Pilih Kompetensi')" 
                                            class="text-gray-900 dark:text-gray-300 cursor-default select-none relative py-2.5 pl-3 pr-9 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition">
                                            <span class="block truncate">Pilih Kompetensi</span>
                                        </li>
                                        <template x-for="item in filteredItems" :key="item.id">
                                            <li @click="select(item.id, item.name)" 
                                                class="text-gray-900 dark:text-gray-300 cursor-default select-none relative py-2.5 pl-3 pr-9 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition">
                                                <span class="block truncate" x-text="item.name"></span>
                                            </li>
                                        </template>
                                        <template x-if="filteredItems.length === 0">
                                            <li class="text-gray-500 dark:text-slate-400 cursor-default select-none relative py-2.5 pl-3 pr-9">
                                                Tidak ditemukan kompetensi
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            <!-- Category and Level Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Custom Radio for Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Kategori *</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <button type="button" 
                                            @click="category = 'technical'"
                                            :class="category === 'technical' ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-750 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                            <svg class="w-6 h-6 mb-1.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                            </svg>
                                            <span class="text-xs">Teknis</span>
                                        </button>
                                        <button type="button" 
                                            @click="category = 'soft_skill'"
                                            :class="category === 'soft_skill' ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-750 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                            <svg class="w-6 h-6 mb-1.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                            </svg>
                                            <span class="text-xs">Soft Skill</span>
                                        </button>
                                    </div>
                                    <input type="hidden" name="category" :value="category">
                                </div>

                                <!-- Custom Radio for Level -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Level *</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <button type="button" 
                                            @click="level = 'beginner'"
                                            :class="level === 'beginner' ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-755 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                            class="flex flex-col items-center justify-center py-3.5 px-1.5 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                            <span class="text-xs">Beginner</span>
                                        </button>
                                        <button type="button" 
                                            @click="level = 'intermediate'"
                                            :class="level === 'intermediate' ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-755 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                            class="flex flex-col items-center justify-center py-3.5 px-1.5 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                            <span class="text-xs">Intermediate</span>
                                        </button>
                                        <button type="button" 
                                            @click="level = 'advanced'"
                                            :class="level === 'advanced' ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-755 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                            class="flex flex-col items-center justify-center py-3.5 px-1.5 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                            <span class="text-xs">Advanced</span>
                                        </button>
                                    </div>
                                    <input type="hidden" name="level" :value="level">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sidebar Settings - 1/3 Width) -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Price & Media Card -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Harga & Media</h3>
                        <div class="space-y-6">
                            
                            <!-- Custom Radio Price Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tipe Harga *</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="button" 
                                        @click="isFree = true"
                                        :class="isFree ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-750 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                        class="flex flex-col items-center justify-center p-3 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                        <svg class="w-6 h-6 mb-1 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs">Gratis</span>
                                    </button>
                                    <button type="button" 
                                        @click="isFree = false"
                                        :class="!isFree ? 'border-blue-500 ring-2 ring-blue-500/25 bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 font-semibold' : 'border-gray-200 dark:border-slate-750 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-400'"
                                        class="flex flex-col items-center justify-center p-3 rounded-xl border text-center transition-all duration-200 hover:border-blue-400">
                                        <svg class="w-6 h-6 mb-1 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs">Berbayar</span>
                                    </button>
                                </div>
                                <input type="checkbox" name="is_free" value="1" x-model="isFree" class="hidden">
                            </div>

                            <!-- Currency Input with Auto-formatting -->
                            <div x-show="!isFree" x-transition class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Harga Kursus (Rp) *</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 dark:text-slate-500 text-sm">Rp</span>
                                    </div>
                                    <input type="text" 
                                        x-model="formattedPrice"
                                        @input="formattedPrice = $event.target.value"
                                        class="w-full pl-10 border border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2.5" 
                                        placeholder="Contoh: 150.000">
                                    <input type="hidden" name="price" :value="rawPrice">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Thumbnail</label>
                                <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-200 dark:border-slate-700 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 text-slate-500 dark:text-slate-400 bg-gray-50 dark:bg-slate-800 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/40 dark:file:text-blue-200 hover:file:bg-blue-100">
                                <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-1.5">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Class Parameters Card -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-800">Parameter Kelas</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Durasi Belajar (Jam) *</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="number" name="duration_hours" value="{{ old('duration_hours', 1) }}" min="1" required class="w-full pr-12 border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2.5">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 dark:text-slate-550 text-xs">Jam</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Maks. Siswa per Kelas</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="number" name="max_students" value="{{ old('max_students', 30) }}" min="0" class="w-full pr-16 border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2.5" placeholder="0 = Unlimited">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 dark:text-slate-550 text-xs">Siswa</span>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-1.5">Masukkan angka 0 untuk kuota siswa tidak terbatas.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tags</label>
                                <input type="text" name="tags" value="{{ old('tags') }}" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2.5" placeholder="Pisahkan dengan koma (misal: php, sql)">
                            </div>
                        </div>
                    </div>

                    <!-- Action Save Card (Sticky) -->
                    <div class="sticky top-6 bg-white dark:bg-slate-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-slate-800 space-y-3">
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 transition-all duration-300 hover:-translate-y-0.5">
                            Simpan sebagai Draft
                        </button>
                        <a href="{{ route('education.courses.index') }}" class="block w-full text-center py-2.5 border border-gray-250 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-800 transition text-sm font-semibold">
                            Batal
                        </a>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var quillDesc = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: 'Jelaskan secara rinci mengenai kursus ini...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingDesc = document.getElementById('description').value;
        if (existingDesc) quillDesc.root.innerHTML = existingDesc;

        var quillObj = new Quill('#quill-objectives', {
            theme: 'snow',
            placeholder: 'Apa saja kompetensi/materi utama yang akan dicapai oleh siswa?',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingObj = document.getElementById('objectives').value;
        if (existingObj) quillObj.root.innerHTML = existingObj;

        var form = document.getElementById('quill-description').closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('description').value = quillDesc.root.innerHTML;
                document.getElementById('objectives').value = quillObj.root.innerHTML;
            });
        }
    });
    </script>
</x-app-layout>
