<x-app-layout>
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
            min-height: 150px;
        }

        .dark trix-editor {
            background-color: #1e293b;
            color: #f8fafc;
            border-color: #334155;
        }

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

    <div class="px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('industry.tpa.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 dark:text-gray-400 dark:text-gray-500 hover:text-blue-600 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Tes TPA</h1>
                    <p class="text-gray-500 dark:text-gray-400 dark:text-gray-500 text-sm mt-1">Sesuaikan konfigurasi tes untuk kebutuhan rekrutmen Anda.</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($test->is_active)
                    <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold border border-green-200">Aktif</span>
                    @else
                    <span class="px-3 py-1.5 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 dark:text-gray-500 rounded-full text-xs font-semibold border border-gray-200 dark:border-slate-700">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('industry.tpa.update', $test) }}" method="POST" x-data="tpaForm()" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- LEFT: Form Fields --}}
                <div class="lg:col-span-2 space-y-6 relative z-30">

                    {{-- Section 1: Informasi Dasar --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 relative z-20">
                        <div class="px-6 py-4 rounded-t-2xl border-b border-gray-50 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                                <div>
                                    <h2 class="font-semibold text-gray-800 dark:text-gray-200">Informasi Dasar</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Nama dan tujuan tes</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="flex items-center gap-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Judul Tes <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title', $test->title) }}"
                                    class="w-full border-gray-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: Tes TPA Software Engineer" required>
                                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi <span class="text-gray-400 dark:text-gray-500 font-normal">(Opsional)</span></label>
                                <input id="description" type="hidden" name="description" value="{{ old('description', $test->description) }}">
                                <trix-editor input="description" class="trix-content rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" placeholder="Jelaskan instruksi khusus atau tujuan tes ini..."></trix-editor>
                            </div>

                            {{-- Searchable Dropdown untuk Lowongan --}}
                            <div x-data="jobSearch()" x-init="init()">
                                <label class="flex items-center gap-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    2Lowongan Terkait
                                    <span class="relative group">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-56 bg-gray-800 text-white text-xs rounded-lg py-2 px-3 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                                            Kosongkan jika tes ini akan digunakan untuk semua lowongan
                                        </span>
                                    </span>
                                </label>

                                {{-- Selected Value Display --}}
                                <div class="relative" @click.away="isOpen = false" style="z-index: 50;">
                                    <div class="flex items-center bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all"
                                        :class="isOpen ? 'ring-2 ring-blue-500 border-blue-500' : ''">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 ml-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <input type="text"
                                            x-model="search"
                                            @focus="isOpen = true"
                                            @input="filterJobs()"
                                            class="flex-1 border-0 bg-transparent dark:text-white rounded-xl focus:ring-0 focus:shadow-none py-2.5 px-2 text-sm"
                                            placeholder="Cari lowongan...">
                                        <button type="button" x-show="selectedId" @click="clearSelection()" class="p-2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3 transition-transform" :class="isOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>

                                    {{-- Hidden Input --}}
                                    <input type="hidden" name="job_listing_id" :value="selectedId">

                                    {{-- Dropdown --}}
                                    <div x-show="isOpen" x-transition class="absolute z-20 w-full mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-lg overflow-hidden">
                                        {{-- Global Option --}}
                                        <div @click="selectJob('', 'Template Global (Semua Lowongan)')"
                                            class="flex items-center gap-3 px-4 py-3 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer transition-colors border-b border-gray-100 dark:border-slate-800"
                                            :class="selectedId === '' ? 'bg-blue-50 dark:bg-slate-800' : ''">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-800 dark:text-gray-200">Template Global</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Bisa digunakan untuk semua lowongan</div>
                                            </div>
                                            <svg x-show="selectedId === ''" class="w-5 h-5 text-blue-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>

                                        {{-- Job List --}}
                                        <div class="max-h-60 overflow-y-auto">
                                            <template x-for="job in filteredJobs" :key="job.id">
                                                <div @click="selectJob(job.id, job.title)"
                                                    class="flex items-center gap-3 px-4 py-3 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer transition-colors"
                                                    :class="selectedId == job.id ? 'bg-blue-50 dark:bg-slate-800' : ''">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate" x-text="job.title"></div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500" x-text="job.location || 'Lokasi tidak ditentukan'"></div>
                                                    </div>
                                                    <svg x-show="selectedId == job.id" class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <div x-show="filteredJobs.length === 0 && search.length > 0" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400 dark:text-gray-500">
                                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                                Lowongan tidak ditemukan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Parameter Ujian --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                        <div class="px-6 py-4 rounded-t-2xl border-b border-gray-50 bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/30 dark:to-violet-900/30">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                                <div>
                                    <h2 class="font-semibold text-gray-800 dark:text-gray-200">Parameter Ujian</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Durasi dan standar kelulusan</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Durasi Waktu <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="time_limit_minutes" x-model.number="timeLimit"
                                            value="{{ old('time_limit_minutes', $test->time_limit_minutes) }}"
                                            class="w-full border-gray-300 dark:border-slate-600 rounded-xl shadow-sm pr-16 focus:ring-purple-500 focus:border-purple-500"
                                            min="10" max="180" required>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 dark:text-gray-500 text-sm font-medium">Menit</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">
                                        <span x-text="timeLimit"></span> menit untuk <span x-text="totalQuestions"></span> soal
                                        = <span x-text="totalQuestions > 0 ? Math.round(timeLimit / totalQuestions) : 0" class="font-medium text-gray-600 dark:text-gray-400 dark:text-gray-500"></span> menit/soal
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Passing Score <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="passing_score" x-model.number="passingScore"
                                            value="{{ old('passing_score', $test->passing_score) }}"
                                            class="w-full border-gray-300 dark:border-slate-600 rounded-xl shadow-sm pr-12 focus:ring-purple-500 focus:border-purple-500"
                                            min="0" max="100" step="0.01" required>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 dark:text-gray-500 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center gap-2">
                                        <div class="flex-1 bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                            <div class="h-2 rounded-full transition-all duration-300"
                                                :class="passingScore >= 80 ? 'bg-green-500' : passingScore >= 60 ? 'bg-yellow-500' : 'bg-red-500'"
                                                :style="`width: ${passingScore}%`"></div>
                                        </div>
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                                            :class="passingScore >= 80 ? 'bg-green-100 text-green-700' : passingScore >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'"
                                            x-text="passingScore >= 80 ? 'Ketat' : passingScore >= 60 ? 'Sedang' : 'Longgar'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Komposisi Soal --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                        <div class="px-6 py-4 rounded-t-2xl border-b border-gray-50 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                                    <div>
                                        <h2 class="font-semibold text-gray-800 dark:text-gray-200">Komposisi Soal</h2>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Jumlah soal per kategori</p>
                                    </div>
                                </div>
                                <span class="text-xs bg-green-100 border border-green-200 text-green-700 px-3 py-1.5 rounded-full font-bold" x-text="`Total: ${totalQuestions} Soal`"></span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @php
                                $categories = [
                                'verbal' => ['icon' => '💬', 'color' => 'blue', 'desc' => 'Sinonim, Antonim, Analogi'],
                                'numerik' => ['icon' => '🔢', 'color' => 'green', 'desc' => 'Aritmetik, Deret, Soal Cerita'],
                                'logika' => ['icon' => '🧠', 'color' => 'purple', 'desc' => 'Silogisme, Deduktif, Analitis'],
                                'spasial' => ['icon' => '📐', 'color' => 'orange', 'desc' => 'Pola, Rotasi, Bayangan'],
                                ];
                                @endphp
                                @foreach($categories as $key => $cat)
                                <div class="bg-gray-50 dark:bg-slate-800/50 p-4 rounded-xl border border-gray-100 dark:border-slate-800 hover:border-gray-200 dark:border-slate-700 transition-colors">
                                    <div class="text-center mb-2">
                                        <span class="text-2xl">{{ $cat['icon'] }}</span>
                                    </div>
                                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1 text-center">{{ ucfirst($key) }}</label>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 text-center mb-3 h-6">{{ $cat['desc'] }}</p>
                                    <input type="number" name="{{ $key }}_count" x-model.number="counts.{{ $key }}"
                                        value="{{ old($key . '_count', $test->{$key . '_count'}) }}"
                                        class="w-full border-gray-300 dark:border-slate-600 rounded-lg text-center text-lg font-bold focus:ring-green-500 focus:border-green-500"
                                        min="0" max="50">
                                </div>
                                @endforeach
                            </div>

                            {{-- Visual Distribution --}}
                            <div x-show="totalQuestions > 0" class="mt-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl p-4">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 dark:text-gray-500 mb-2">Distribusi Soal:</p>
                                <div class="flex rounded-full overflow-hidden h-4">
                                    <div class="bg-blue-500 transition-all" :style="`width: ${(counts.verbal/totalQuestions)*100}%`" x-show="counts.verbal > 0"></div>
                                    <div class="bg-green-500 transition-all" :style="`width: ${(counts.numerik/totalQuestions)*100}%`" x-show="counts.numerik > 0"></div>
                                    <div class="bg-purple-500 transition-all" :style="`width: ${(counts.logika/totalQuestions)*100}%`" x-show="counts.logika > 0"></div>
                                    <div class="bg-orange-500 transition-all" :style="`width: ${(counts.spasial/totalQuestions)*100}%`" x-show="counts.spasial > 0"></div>
                                </div>
                                <div class="flex gap-4 mt-2 flex-wrap">
                                    <span class="text-[10px] flex items-center gap-1"><span class="w-2 h-2 bg-blue-500 rounded-full"></span> Verbal (<span x-text="counts.verbal || 0"></span>)</span>
                                    <span class="text-[10px] flex items-center gap-1"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Numerik (<span x-text="counts.numerik || 0"></span>)</span>
                                    <span class="text-[10px] flex items-center gap-1"><span class="w-2 h-2 bg-purple-500 rounded-full"></span> Logika (<span x-text="counts.logika || 0"></span>)</span>
                                    <span class="text-[10px] flex items-center gap-1"><span class="w-2 h-2 bg-orange-500 rounded-full"></span> Spasial (<span x-text="counts.spasial || 0"></span>)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 4: Bobot Penilaian --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                        <div class="px-6 py-4 rounded-t-2xl border-b border-gray-50 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/30 dark:to-yellow-900/30">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                                    <div>
                                        <h2 class="font-semibold text-gray-800 dark:text-gray-200">Bobot Penilaian</h2>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Kontribusi per kategori terhadap nilai akhir</p>
                                    </div>
                                </div>
                                <span class="text-xs px-3 py-1.5 rounded-full font-bold transition-colors border"
                                    :class="totalWeight === 100 ? 'bg-green-100 border-green-200 text-green-700' : 'bg-red-100 border-red-200 text-red-700'"
                                    x-text="`Total: ${totalWeight}%`"></span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach(['verbal', 'numerik', 'logika', 'spasial'] as $key)
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2 text-center">{{ ucfirst($key) }}</label>
                                    <div class="relative">
                                        <input type="number" name="{{ $key }}_weight" x-model.number="weights.{{ $key }}"
                                            value="{{ old($key . '_weight', $test->{$key . '_weight'}) }}"
                                            class="w-full border-gray-300 dark:border-slate-600 rounded-lg pr-8 text-center font-semibold focus:ring-amber-500 focus:border-amber-500"
                                            min="0" max="100" step="0.01">
                                        <span class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-sm">%</span>
                                    </div>
                                    <div class="mt-1.5 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full transition-all bg-amber-500" :style="`width: ${weights.{{ $key }} || 0}%`"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div x-show="totalWeight !== 100" class="mt-4 text-red-500 text-xs flex items-center gap-1.5 font-medium bg-red-50 border border-red-100 p-3 rounded-xl">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Total bobot harus tepat 100%. Saat ini: <span x-text="totalWeight" class="font-bold"></span>%
                            </div>
                        </div>
                    </div>

                    {{-- Section 5: Pengaturan --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                        <div class="px-6 py-4 rounded-t-2xl border-b border-gray-50 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-slate-800 dark:to-slate-900">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-gray-600 text-white rounded-full flex items-center justify-center text-sm font-bold">5</span>
                                <div>
                                    <h2 class="font-semibold text-gray-800 dark:text-gray-200">Pengaturan Tambahan</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Konfigurasi opsional</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:bg-slate-800/50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="randomize_questions" value="1" {{ old('randomize_questions', $test->randomize_questions) ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Acak Urutan Soal</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500 mt-0.5">Soal tampil dengan urutan acak</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:bg-slate-800/50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="randomize_options" value="1" {{ old('randomize_options', $test->randomize_options) ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Acak Pilihan Jawaban</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500 mt-0.5">Posisi A, B, C, D diacak</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:bg-slate-800/50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="show_result_after" value="1" {{ old('show_result_after', $test->show_result_after) ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Tampilkan Hasil Langsung</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500 mt-0.5">Kandidat langsung lihat skor</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:bg-slate-800/50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $test->is_active) ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Status Aktif</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500 mt-0.5">Tes dapat digunakan</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Preview Sidebar --}}
                <div class="space-y-6">
                    <div class="sticky top-24 space-y-4">
                        {{-- Preview Card --}}
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                            <div class="px-5 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                                <h3 class="font-bold text-sm">Preview Konfigurasi</h3>
                            </div>
                            <div class="p-5 space-y-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Judul Tes</p>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200" x-text="formTitle || 'Belum diisi'"></p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-blue-50 rounded-lg p-2.5 text-center">
                                        <p class="text-lg font-bold text-blue-600" x-text="totalQuestions"></p>
                                        <p class="text-[10px] text-blue-500">Soal</p>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-2.5 text-center">
                                        <p class="text-lg font-bold text-green-600" x-text="timeLimit + 'm'"></p>
                                        <p class="text-[10px] text-green-500">Durasi</p>
                                    </div>
                                </div>
                                <div class="bg-purple-50 rounded-lg p-2.5 text-center">
                                    <p class="text-lg font-bold text-purple-600" x-text="passingScore + '%'"></p>
                                    <p class="text-[10px] text-purple-500">Passing Score</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Bobot</p>
                                    <div class="space-y-1.5">
                                        @foreach(['verbal', 'numerik', 'logika', 'spasial'] as $key)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500 w-14">{{ ucfirst($key) }}</span>
                                            <div class="flex-1 bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                                <div class="h-2 rounded-full bg-purple-500 transition-all" :style="`width: ${weights.{{ $key }} || 0}%`"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400 dark:text-gray-500 w-10 text-right" x-text="(weights.{{ $key }} || 0) + '%'"></span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Validation Status --}}
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 p-5">
                            <h3 class="font-bold text-sm text-gray-700 dark:text-gray-300 mb-3">Status Validasi</h3>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-xs">
                                    <span x-show="totalQuestions > 0" class="text-green-500">✓</span>
                                    <span x-show="totalQuestions === 0" class="text-red-500">✗</span>
                                    <span :class="totalQuestions > 0 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500'">Jumlah soal > 0</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs">
                                    <span x-show="totalWeight === 100" class="text-green-500">✓</span>
                                    <span x-show="totalWeight !== 100" class="text-red-500">✗</span>
                                    <span :class="totalWeight === 100 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500'">Bobot total = 100%</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs">
                                    <span x-show="timeLimit >= 10" class="text-green-500">✓</span>
                                    <span x-show="timeLimit < 10" class="text-red-500">✗</span>
                                    <span :class="timeLimit >= 10 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500'">Durasi ≥ 10 menit</span>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="space-y-3">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-sm transition-all flex items-center justify-center gap-2"
                                :class="totalWeight !== 100 || totalQuestions === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:-translate-y-0.5'"
                                :disabled="totalWeight !== 100 || totalQuestions === 0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('industry.tpa.index') }}" class="block w-full text-center px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-50 dark:bg-slate-800/50 transition-colors">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tpaForm', () => ({
                formTitle: @json(old('title', $test->title)),
                timeLimit: {{ old('time_limit_minutes', $test->time_limit_minutes) }},
                passingScore: {{ old('passing_score', $test->passing_score) }},
                counts: {
                    verbal: {{ old('verbal_count', $test->verbal_count) }},
                    numerik: {{ old('numerik_count', $test->numerik_count) }},
                    logika: {{ old('logika_count', $test->logika_count) }},
                    spasial: {{ old('spasial_count', $test->spasial_count) }}
                },
                weights: {
                    verbal: {{ old('verbal_weight', $test->verbal_weight) }},
                    numerik: {{ old('numerik_weight', $test->numerik_weight) }},
                    logika: {{ old('logika_weight', $test->logika_weight) }},
                    spasial: {{ old('spasial_weight', $test->spasial_weight) }}
                },
                get totalQuestions() {
                    return (this.counts.verbal || 0) + (this.counts.numerik || 0) + (this.counts.logika || 0) + (this.counts.spasial || 0);
                },
                get totalWeight() {
                    return Math.round(((this.weights.verbal || 0) + (this.weights.numerik || 0) + (this.weights.logika || 0) + (this.weights.spasial || 0)) * 100) / 100;
                }
            }));
        });

        function jobSearch() {
            return {
                search: @json($test->jobListing->title ?? ''),
                selectedId: '{{ old("job_listing_id", $test->job_listing_id) }}',
                isOpen: false,
                jobs: [],
                filteredJobs: [],
                init() {
                    this.jobs = [
                        @foreach($jobs as $job)
                        { id: '{{ $job->id }}', title: @json($job->title), location: @json($job->location ?? '') },
                        @endforeach
                    ];
                    this.filteredJobs = [...this.jobs];
                },
                filterJobs() {
                    const q = this.search.toLowerCase();
                    this.filteredJobs = this.jobs.filter(j =>
                        j.title.toLowerCase().includes(q) ||
                        j.location.toLowerCase().includes(q)
                    );
                    this.isOpen = true;
                },
                selectJob(id, title) {
                    this.selectedId = id;
                    this.search = title;
                    this.isOpen = false;
                },
                clearSelection() {
                    this.selectedId = '';
                    this.search = '';
                    this.filteredJobs = [...this.jobs];
                }
            };
        }
    </script>
</x-app-layout>