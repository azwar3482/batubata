<x-app-layout>
<div class="max-w-5xl mx-auto px-4 py-8" x-data="tpaForm()">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('industry.tpa.index') }}" class="text-gray-500 hover:text-purple-600 transition-colors text-sm flex items-center gap-1 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Buat Tes TPA Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Konfigurasi parameter tes Potensi Akademik untuk kandidat Anda.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- FORM SECTION -->
        <div class="flex-1">
            <form action="{{ route('industry.tpa.store') }}" method="POST" class="space-y-5" id="tpa-form" @submit="return validateForm()">
                @csrf

                <!-- STEP 1: Informasi Dasar -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-purple-50 to-indigo-50">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                            <div>
                                <h2 class="font-semibold text-gray-800">Informasi Dasar</h2>
                                <p class="text-xs text-gray-500">Tentukan nama dan tujuan tes</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="flex items-center gap-1 text-sm font-medium text-gray-700 mb-1.5">
                                Judul Tes <span class="text-red-500">*</span>
                                <span class="relative group">
                                    <svg class="w-4 h-4 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 bg-gray-800 text-white text-xs rounded-lg py-2 px-3 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                                        Berikan nama yang deskriptif agar mudah diidentifikasi
                                    </span>
                                </span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', 'Tes Potensi Akademik') }}"
                                   class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-shadow"
                                   placeholder="Misal: Tes TPA Software Engineer" required>
                            @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <textarea name="description" class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-shadow" rows="2"
                                      placeholder="Jelaskan instruksi khusus atau tujuan tes ini...">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="flex items-center gap-1 text-sm font-medium text-gray-700 mb-1.5">
                                Lowongan Terkait
                                <span class="relative group">
                                    <svg class="w-4 h-4 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-56 bg-gray-800 text-white text-xs rounded-lg py-2 px-3 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                                        Kosongkan jika tes ini akan digunakan untuk semua lowongan
                                    </span>
                                </span>
                            </label>
                            <select name="job_listing_id" class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-shadow">
                                <option value="">Template Global (Semua Lowongan)</option>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ old('job_listing_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Parameter Ujian -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-blue-50 to-cyan-50">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                            <div>
                                <h2 class="font-semibold text-gray-800">Parameter Ujian</h2>
                                <p class="text-xs text-gray-500">Atur durasi dan standar kelulusan</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="flex items-center gap-1 text-sm font-medium text-gray-700 mb-1.5">
                                    Durasi Waktu <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="time_limit_minutes" x-model.number="timeLimit"
                                           class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm pr-16"
                                           min="10" max="180" required>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm font-medium">Menit</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1.5">
                                    <span x-text="timeLimit"></span> menit untuk <span x-text="totalQuestions"></span> soal
                                    = <span x-text="totalQuestions > 0 ? Math.round(timeLimit / totalQuestions) : 0" class="font-medium text-gray-600"></span> menit/soal
                                </p>
                            </div>
                            <div>
                                <label class="flex items-center gap-1 text-sm font-medium text-gray-700 mb-1.5">
                                    Passing Score <span class="text-red-500">*</span>
                                    <span class="relative group">
                                        <svg class="w-4 h-4 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-52 bg-gray-800 text-white text-xs rounded-lg py-2 px-3 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                                            Skor minimum yang harus dicapai kandidat untuk dinyatakan lulus
                                        </span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="passing_score" x-model.number="passingScore"
                                           class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm pr-12"
                                           min="0" max="100" step="0.01" required>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm font-medium">%</span>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
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

                <!-- STEP 3: Komposisi Soal -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-green-50 to-emerald-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                                <div>
                                    <h2 class="font-semibold text-gray-800">Komposisi Soal</h2>
                                    <p class="text-xs text-gray-500">Atur jumlah soal per kategori</p>
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
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="text-center mb-2">
                                    <span class="text-2xl">{{ $cat['icon'] }}</span>
                                </div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1 text-center">{{ ucfirst($key) }}</label>
                                <p class="text-[10px] text-gray-400 text-center mb-3 h-6">{{ $cat['desc'] }}</p>
                                <input type="number" name="{{ $key }}_count" x-model.number="counts.{{ $key }}"
                                       class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg text-center text-lg font-bold"
                                       min="0" max="50">
                            </div>
                            @endforeach
                        </div>

                        <!-- Visual Distribution -->
                        <div x-show="totalQuestions > 0" class="mt-4 bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-medium text-gray-500 mb-2">Distribusi Soal:</p>
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

                <!-- STEP 4: Bobot Penilaian -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-amber-50 to-yellow-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                                <div>
                                    <h2 class="font-semibold text-gray-800">Bobot Penilaian</h2>
                                    <p class="text-xs text-gray-500">Kontribusi setiap kategori terhadap nilai akhir</p>
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
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 text-center">{{ ucfirst($key) }}</label>
                                <div class="relative">
                                    <input type="number" name="{{ $key }}_weight" x-model.number="weights.{{ $key }}"
                                           class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg pr-8 text-center font-semibold"
                                           min="0" max="100" step="0.01">
                                    <span class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 text-sm">%</span>
                                </div>
                                <div class="mt-1.5 bg-gray-200 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full transition-all bg-purple-500" :style="`width: ${weights.{{ $key }} || 0}%`"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div x-show="totalWeight !== 100" class="mt-4 text-red-500 text-xs flex items-center gap-1.5 font-medium bg-red-50 border border-red-100 p-3 rounded-xl" x-cloak>
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Total bobot harus tepat 100%. Saat ini: <span x-text="totalWeight" class="font-bold"></span>%
                        </div>
                    </div>
                </div>

                <!-- STEP 5: Pengaturan Tambahan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-gray-50 to-slate-50">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-gray-600 text-white rounded-full flex items-center justify-center text-sm font-bold">5</span>
                            <div>
                                <h2 class="font-semibold text-gray-800">Pengaturan Tambahan</h2>
                                <p class="text-xs text-gray-500">Konfigurasi opsional untuk keamanan dan transparansi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <label class="flex items-start gap-4 cursor-pointer group bg-gray-50/50 hover:bg-gray-50 p-4 rounded-xl border border-transparent hover:border-gray-100 transition-all">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="randomize_questions" value="1" {{ old('randomize_questions', 1) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-purple-600 focus:ring-purple-500 transition-colors cursor-pointer">
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">Acak Urutan Soal</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Soal ditampilkan dengan urutan berbeda untuk setiap kandidat.</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-4 cursor-pointer group bg-gray-50/50 hover:bg-gray-50 p-4 rounded-xl border border-transparent hover:border-gray-100 transition-all">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="randomize_options" value="1" {{ old('randomize_options', 1) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-purple-600 focus:ring-purple-500 transition-colors cursor-pointer">
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">Acak Pilihan Jawaban</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Posisi pilihan A, B, C, D diacak pada setiap soal.</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-4 cursor-pointer group bg-gray-50/50 hover:bg-gray-50 p-4 rounded-xl border border-transparent hover:border-gray-100 transition-all">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="show_result_after" value="1" {{ old('show_result_after', 1) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-purple-600 focus:ring-purple-500 transition-colors cursor-pointer">
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">Tampilkan Hasil Langsung</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Kandidat langsung melihat skor setelah submit tes.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4 pb-12">
                    <a href="{{ route('industry.tpa.index') }}" class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors text-center shadow-sm">
                        Batal
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 text-sm font-bold text-white bg-purple-600 rounded-xl shadow-md shadow-purple-200 transition-all flex items-center justify-center gap-2"
                            :class="totalWeight !== 100 || totalQuestions === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-purple-700 hover:-translate-y-0.5'"
                            :disabled="totalWeight !== 100 || totalQuestions === 0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Tes TPA
                    </button>
                </div>
            </form>
        </div>

        <!-- SIDEBAR: LIVE PREVIEW -->
        <div class="lg:w-80 flex-shrink-0">
            <div class="sticky top-24 space-y-4">
                <!-- Preview Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                        <h3 class="font-bold text-sm">Preview Konfigurasi</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Judul Tes</p>
                            <p class="text-sm font-semibold text-gray-800" x-text="formTitle || 'Belum diisi'"></p>
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
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-2">Bobot per Kategori</p>
                            <div class="space-y-1.5">
                                @foreach(['verbal', 'numerik', 'logika', 'spasial'] as $key)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 w-14">{{ ucfirst($key) }}</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full bg-purple-500 transition-all" :style="`width: ${weights.{{ $key }} || 0}%`"></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-600 w-10 text-right" x-text="(weights.{{ $key }} || 0) + '%'"></span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validation Status -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-bold text-sm text-gray-700 mb-3">Status Validasi</h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-xs">
                            <span x-show="totalQuestions > 0" class="text-green-500">✓</span>
                            <span x-show="totalQuestions === 0" class="text-red-500">✗</span>
                            <span :class="totalQuestions > 0 ? 'text-gray-700' : 'text-gray-400'">Jumlah soal > 0</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span x-show="totalWeight === 100" class="text-green-500">✓</span>
                            <span x-show="totalWeight !== 100" class="text-red-500">✗</span>
                            <span :class="totalWeight === 100 ? 'text-gray-700' : 'text-gray-400'">Bobot total = 100%</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span x-show="timeLimit >= 10" class="text-green-500">✓</span>
                            <span x-show="timeLimit < 10" class="text-red-500">✗</span>
                            <span :class="timeLimit >= 10 ? 'text-gray-700' : 'text-gray-400'">Durasi ≥ 10 menit</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span x-show="passingScore >= 0 && passingScore <= 100" class="text-green-500">✓</span>
                            <span x-show="passingScore < 0 || passingScore > 100" class="text-red-500">✗</span>
                            <span :class="passingScore >= 0 && passingScore <= 100 ? 'text-gray-700' : 'text-gray-400'">Passing score valid</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>[x-cloak] { display: none !important; }</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('tpaForm', () => ({
        formTitle: '{{ old("title", "Tes Potensi Akademik") }}',
        timeLimit: {{ old('time_limit_minutes', 60) }},
        passingScore: {{ old('passing_score', 60) }},
        counts: {
            verbal: {{ old('verbal_count', 10) }},
            numerik: {{ old('numerik_count', 10) }},
            logika: {{ old('logika_count', 10) }},
            spasial: {{ old('spasial_count', 10) }}
        },
        weights: {
            verbal: {{ old('verbal_weight', 30) }},
            numerik: {{ old('numerik_weight', 30) }},
            logika: {{ old('logika_weight', 20) }},
            spasial: {{ old('spasial_weight', 20) }}
        },
        get totalQuestions() {
            return (this.counts.verbal || 0) + (this.counts.numerik || 0) + (this.counts.logika || 0) + (this.counts.spasial || 0);
        },
        get totalWeight() {
            return Math.round(((this.weights.verbal || 0) + (this.weights.numerik || 0) + (this.weights.logika || 0) + (this.weights.spasial || 0)) * 100) / 100;
        },
        validateForm() {
            if (this.totalWeight !== 100) {
                alert('Total bobot penilaian harus tepat 100%! Saat ini: ' + this.totalWeight + '%');
                return false;
            }
            if (this.totalQuestions === 0) {
                alert('Jumlah soal tidak boleh 0!');
                return false;
            }
            return true;
        }
    }))
})
</script>
</x-app-layout>
