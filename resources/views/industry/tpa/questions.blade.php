<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bank Soal TPA</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola soal TPA perusahaan Anda. Soal global dari admin juga tersedia.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('industry.tpa.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Soal
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        {{-- INFO CARDS --}}
        @php
        $userId = auth()->id();
        $totalMyQuestions = \App\Models\TpaQuestion::where('created_by', $userId)->count();
        $totalGlobalQuestions = \App\Models\TpaQuestion::whereNull('created_by')->where('is_active', true)->count();
        $totalAvailable = $totalMyQuestions + $totalGlobalQuestions;

        $categoryStats = \App\Models\TpaQuestion::where(function($q) use ($userId) {
        $q->where('created_by', $userId)->orWhereNull('created_by');
        })->where('is_active', true)
        ->selectRaw('category, COUNT(*) as count')
        ->groupBy('category')
        ->pluck('count', 'category');

        $difficultyStats = \App\Models\TpaQuestion::where(function($q) use ($userId) {
        $q->where('created_by', $userId)->orWhereNull('created_by');
        })->where('is_active', true)
        ->selectRaw('difficulty, COUNT(*) as count')
        ->groupBy('difficulty')
        ->pluck('count', 'difficulty');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            {{-- Total Soal --}}
            <div class="group bg-white dark:bg-slate-800 rounded-xl p-5 shadow-lg shadow-blue-500/10 dark:shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/20 dark:hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4"
                style="border-left-color: #3b82f6 !important;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Total Soal</p>
                        <p class="text-3xl font-black text-gray-800 dark:text-white mt-1 tracking-tight">{{ $totalAvailable }}</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Tersedia untuk digunakan</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-500 dark:text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Soal Perusahaan --}}
            <div class="group bg-white dark:bg-slate-800 rounded-xl p-5 shadow-lg shadow-indigo-500/10 dark:shadow-indigo-500/20 hover:shadow-xl hover:shadow-indigo-500/20 dark:hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4"
                style="border-left-color: #6366f1 !important;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Soal Saya</p>
                        <p class="text-3xl font-black text-gray-800 dark:text-white mt-1 tracking-tight">{{ $totalMyQuestions }}</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Bisa edit & hapus</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center text-indigo-500 dark:text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Soal Global --}}
            <div class="group bg-white dark:bg-slate-800 rounded-xl p-5 shadow-lg shadow-purple-500/10 dark:shadow-purple-500/20 hover:shadow-xl hover:shadow-purple-500/20 dark:hover:shadow-purple-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4"
                style="border-left-color: #8b5cf6 !important;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Soal Global</p>
                        <p class="text-3xl font-black text-gray-800 dark:text-white mt-1 tracking-tight">{{ $totalGlobalQuestions }}</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Dari admin (read-only)</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-500 dark:text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Tes --}}
            <div class="group bg-white dark:bg-slate-800 rounded-xl p-5 shadow-lg shadow-emerald-500/10 dark:shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/20 dark:hover:shadow-emerald-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4"
                style="border-left-color: #10b981 !important;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Tes TPA</p>
                        <p class="text-3xl font-black text-gray-800 dark:text-white mt-1 tracking-tight">{{ \App\Models\TpaTest::where('created_by', $userId)->count() }}</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Tes yang dibuat</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-500 dark:text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- DISTRIBUTION CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            {{-- Distribusi Kategori --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-5">
                <h3 class="font-semibold text-gray-800 dark:text-white text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Distribusi per Kategori
                </h3>
                <div class="space-y-3">
                    @php
                    $categories = [
                    'verbal' => ['label' => 'Verbal', 'color' => 'blue', 'icon' => '💬'],
                    'numerik' => ['label' => 'Numerik', 'color' => 'green', 'icon' => '🔢'],
                    'logika' => ['label' => 'Logika', 'color' => 'purple', 'icon' => '🧠'],
                    'spasial' => ['label' => 'Spasial', 'color' => 'orange', 'icon' => '📐'],
                    ];
                    @endphp
                    @foreach($categories as $key => $cat)
                    @php $count = $categoryStats[$key] ?? 0; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300 flex items-center gap-1.5">
                                <span>{{ $cat['icon'] }}</span> {{ $cat['label'] }}
                            </span>
                            <span class="text-xs font-bold text-gray-800 dark:text-white">{{ $count }} soal</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                            <div class="h-2 rounded-full bg-{{ $cat['color'] }}-500 transition-all" style="width: {{ $totalAvailable > 0 ? ($count / $totalAvailable) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Distribusi Level --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-5">
                <h3 class="font-semibold text-gray-800 dark:text-white text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Distribusi per Level
                </h3>
                <div class="space-y-3">
                    @php
                    $levels = [
                    'easy' => ['label' => 'Mudah', 'color' => 'green', 'icon' => '🟢'],
                    'medium' => ['label' => 'Sedang', 'color' => 'yellow', 'icon' => '🟡'],
                    'hard' => ['label' => 'Sulit', 'color' => 'red', 'icon' => '🔴'],
                    ];
                    @endphp
                    @foreach($levels as $key => $level)
                    @php $count = $difficultyStats[$key] ?? 0; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300 flex items-center gap-1.5">
                                <span>{{ $level['icon'] }}</span> {{ $level['label'] }}
                            </span>
                            <span class="text-xs font-bold text-gray-800 dark:text-white">{{ $count }} soal</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                            <div class="h-2 rounded-full bg-{{ $level['color'] }}-500 transition-all" style="width: {{ $totalAvailable > 0 ? ($count / $totalAvailable) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Tips --}}
                <div class="mt-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/50 rounded-lg p-3">
                    <p class="text-xs text-amber-700 dark:text-amber-300 flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Disarankan memiliki minimal <strong>10 soal per kategori</strong> untuk variasi yang cukup saat tes.</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- UPLOAD SECTION --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <h2 class="font-bold text-lg mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Import Soal dari Excel/CSV
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Download Template --}}
                <div class="border-2 border-dashed border-gray-200 dark:border-slate-600 rounded-xl p-6 text-center hover:border-blue-400 hover:bg-blue-50/30 dark:hover:bg-blue-900/20 transition-all cursor-pointer group">
                    <div class="text-4xl mb-3">&#128196;</div>
                    <h3 class="font-semibold mb-2 text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Download Template</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Download template Excel dengan format yang benar untuk import soal.</p>
                    <a href="{{ route('industry.tpa.questions.download-template') }}"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Template
                    </a>
                </div>

                {{-- Upload File --}}
                <div class="border-2 border-dashed border-gray-200 dark:border-slate-600 rounded-xl p-6 text-center hover:border-purple-400 hover:bg-purple-50/30 dark:hover:bg-purple-900/20 transition-all cursor-pointer group">
                    <div class="text-4xl mb-3">&#128228;</div>
                    <h3 class="font-semibold mb-2 text-gray-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Upload File</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Upload file Excel (.xlsx) atau CSV (.csv) yang sudah diisi sesuai template.</p>
                    <form action="{{ route('industry.tpa.questions.import') }}" method="POST" enctype="multipart/form-data" id="import-form">
                        @csrf
                        <div class="mb-4">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv"
                                class="w-full border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-purple-500 focus:border-purple-500"
                                required id="file-input">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Upload & Import
                        </button>
                    </form>
                </div>
            </div>

            {{-- Format Guide --}}
            <div class="mt-5 bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4 border border-gray-100 dark:border-slate-600">
                <h4 class="font-semibold text-sm mb-3 flex items-center gap-2 text-gray-700 dark:text-gray-200">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Format Template Excel
                </h4>
                <div class="overflow-x-auto">
                    <table class="text-xs w-full">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-slate-600">
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">category</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">subcategory</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">difficulty</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">question_text</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">options</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">correct_answer</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">explanation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-600">
                                <td class="px-3 py-2 text-blue-600 dark:text-blue-400 font-medium">verbal</td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300">sinonim</td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300">easy</td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300">Pilih kata yang...</td>
                                <td class="px-3 py-2 text-orange-600 dark:text-orange-400">A. Gembira|B. Murung|C. Marah|D. Takut</td>
                                <td class="px-3 py-2 font-bold text-gray-700 dark:text-gray-200">B</td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300">Murung artinya...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <div class="bg-white dark:bg-slate-800 rounded-lg px-3 py-2 border border-gray-100 dark:border-slate-600">
                        <strong class="text-gray-700 dark:text-gray-200">Kategori:</strong> verbal, numerik, logika, spasial
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg px-3 py-2 border border-gray-100 dark:border-slate-600">
                        <strong class="text-gray-700 dark:text-gray-200">Level:</strong> easy, medium, hard
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg px-3 py-2 border border-gray-100 dark:border-slate-600">
                        <strong class="text-gray-700 dark:text-gray-200">Options:</strong> A. Teks|B. Teks (separator: |)
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg px-3 py-2 border border-gray-100 dark:border-slate-600">
                        <strong class="text-gray-700 dark:text-gray-200">Jawaban:</strong> Huruf saja (A/B/C/D/E)
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER & TABLE --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 mb-6">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    Daftar Soal
                </h3>
            </div>
            <form method="GET" class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari soal..."
                            class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-gray-400 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex gap-2">
                        <select name="category" class="border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="verbal" {{ request('category') === 'verbal' ? 'selected' : '' }}>Verbal</option>
                            <option value="numerik" {{ request('category') === 'numerik' ? 'selected' : '' }}>Numerik</option>
                            <option value="logika" {{ request('category') === 'logika' ? 'selected' : '' }}>Logika</option>
                            <option value="spasial" {{ request('category') === 'spasial' ? 'selected' : '' }}>Spasial</option>
                        </select>
                        <select name="difficulty" class="border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Level</option>
                            <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Mudah</option>
                            <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Sulit</option>
                        </select>
                        <select name="source" class="border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Sumber</option>
                            <option value="mine" {{ request('source') === 'mine' ? 'selected' : '' }}>Soal Saya</option>
                            <option value="global" {{ request('source') === 'global' ? 'selected' : '' }}>Global (Admin)</option>
                        </select>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'category', 'difficulty', 'source']))
                        <a href="{{ route('industry.tpa.questions') }}" class="bg-gray-100 dark:bg-slate-600 hover:bg-gray-200 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 px-3 py-2 rounded-lg text-sm">Reset</a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Soal</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Sub</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Level</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Jawaban</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Sumber</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($questions as $q)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-5 py-3.5 text-center text-sm text-gray-500 dark:text-slate-400">
                                {{ $questions->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="text-sm text-gray-800 dark:text-slate-200 max-w-md">{!! Str::limit(strip_tags($q->question_text), 100) !!}</div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $q->category === 'verbal' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800' : '' }}
                                {{ $q->category === 'numerik' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-100 dark:border-green-800' : '' }}
                                {{ $q->category === 'logika' ? 'bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border border-purple-100 dark:border-purple-800' : '' }}
                                {{ $q->category === 'spasial' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 border border-orange-100 dark:border-orange-800' : '' }}">
                                    {{ $q->category_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center text-sm text-gray-500 dark:text-slate-400">{{ $q->subcategory ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                {{ $q->difficulty === 'easy' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}
                                {{ $q->difficulty === 'medium' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}
                                {{ $q->difficulty === 'hard' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}">
                                    {{ $q->difficulty_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-700 font-bold text-sm text-gray-700 dark:text-gray-200">
                                    {{ $q->correct_answer }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($q->created_by === null)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-slate-600">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Global
                                </span>
                                @elseif($q->created_by === auth()->id())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Saya
                                </span>
                                @else
                                <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($q->created_by === auth()->id())
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('industry.tpa.questions.edit', $q) }}"
                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('industry.tpa.questions.destroy', $q) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">Read Only</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada soal ditemukan</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Coba ubah filter atau tambahkan soal baru</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($questions->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 [&_p]:dark:text-slate-300 [&_span]:dark:text-slate-300 [&_a]:dark:text-slate-300 [&_svg]:dark:text-slate-400 [&_.bg-white]:dark:bg-slate-800 [&_.border-gray-300]:dark:border-slate-700 [&_.text-gray-700]:dark:text-slate-200 [&_.text-gray-500]:dark:text-slate-400">
                {{ $questions->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
