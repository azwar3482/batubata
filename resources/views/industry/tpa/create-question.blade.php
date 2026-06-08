<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('industry.tpa.questions') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 dark:text-gray-400 dark:text-gray-500 dark:text-gray-400 dark:text-gray-500 hover:text-blue-600 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Bank Soal
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Soal TPA</h1>
        <p class="text-gray-500 dark:text-gray-400 dark:text-gray-500 text-sm mt-1">Buat soal baru untuk bank soal perusahaan Anda.</p>
    </div>

    <form action="{{ route('industry.tpa.questions.store') }}" method="POST" x-data="questionForm()" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- LEFT: Form Fields --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Section 1: Kategori & Level --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                            <div>
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200">Kategori Soal</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Tentukan jenis dan tingkat kesulitan</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Kategori --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 gap-2">
                                    @php
                                        $cats = [
                                            'verbal' => ['icon' => '💬', 'label' => 'Verbal', 'border' => 'peer-checked:border-blue-500', 'bg' => 'peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/40', 'text' => 'peer-checked:text-blue-700 dark:peer-checked:text-blue-400'],
                                            'numerik' => ['icon' => '🔢', 'label' => 'Numerik', 'border' => 'peer-checked:border-green-500', 'bg' => 'peer-checked:bg-green-50 dark:peer-checked:bg-green-900/40', 'text' => 'peer-checked:text-green-700 dark:peer-checked:text-green-400'],
                                            'logika' => ['icon' => '🧠', 'label' => 'Logika', 'border' => 'peer-checked:border-purple-500', 'bg' => 'peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/40', 'text' => 'peer-checked:text-purple-700 dark:peer-checked:text-purple-400'],
                                            'spasial' => ['icon' => '📐', 'label' => 'Spasial', 'border' => 'peer-checked:border-orange-500', 'bg' => 'peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/40', 'text' => 'peer-checked:text-orange-700 dark:peer-checked:text-orange-400'],
                                        ];
                                    @endphp
                                    @foreach($cats as $key => $cat)
                                    <label class="relative cursor-pointer" x-model="category">
                                        <input type="radio" name="category" value="{{ $key }}" x-model="category" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="p-3 border-2 rounded-xl text-center transition-all text-gray-700 dark:text-gray-400 {{ $cat['text'] }} {{ $cat['border'] }} {{ $cat['bg'] }} border-gray-200 dark:border-slate-700 hover:border-gray-300 dark:hover:border-slate-600">
                                            <div class="w-10 h-10 mx-auto bg-gray-50 dark:bg-slate-800 rounded-full flex items-center justify-center text-xl mb-2 shadow-sm border border-gray-100 dark:border-slate-700">{{ $cat['icon'] }}</div>
                                            <div class="text-xs font-semibold">{{ $cat['label'] }}</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Sub-kategori --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sub-kategori</label>
                                <input type="text" name="subcategory" x-model="subcategory"
                                       class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Contoh: sinonim">
                                <div class="mt-2 flex flex-wrap gap-1">
                                    <template x-for="tag in subcategoryTags" :key="tag">
                                        <button type="button" @click="subcategory = tag"
                                                class="px-2 py-0.5 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-300 rounded text-xs transition-colors"
                                                x-text="tag"></button>
                                    </template>
                                </div>
                            </div>

                            {{-- Level --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level <span class="text-red-500">*</span></label>
                                <div class="space-y-2">
                                    @php
                                        $levels = [
                                            'easy' => ['label' => 'Mudah', 'desc' => 'Dasar', 'dot' => 'bg-green-500', 'border' => 'peer-checked:border-green-500', 'bg' => 'peer-checked:bg-green-50 dark:peer-checked:bg-green-900/40', 'text' => 'peer-checked:text-green-700 dark:peer-checked:text-green-400'],
                                            'medium' => ['label' => 'Sedang', 'desc' => 'Menengah', 'dot' => 'bg-yellow-500', 'border' => 'peer-checked:border-yellow-500', 'bg' => 'peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/40', 'text' => 'peer-checked:text-yellow-700 dark:peer-checked:text-yellow-400'],
                                            'hard' => ['label' => 'Sulit', 'desc' => 'Lanjutan', 'dot' => 'bg-red-500', 'border' => 'peer-checked:border-red-500', 'bg' => 'peer-checked:bg-red-50 dark:peer-checked:bg-red-900/40', 'text' => 'peer-checked:text-red-700 dark:peer-checked:text-red-400'],
                                        ];
                                    @endphp
                                    @foreach($levels as $key => $level)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="difficulty" value="{{ $key }}" x-model="difficulty" class="peer sr-only" {{ $key === 'medium' ? 'checked' : '' }}>
                                        <div class="flex items-center gap-3 p-3 border-2 rounded-xl transition-all text-gray-700 dark:text-gray-400 {{ $level['text'] }} {{ $level['border'] }} {{ $level['bg'] }} border-gray-200 dark:border-slate-700 hover:border-gray-300 dark:hover:border-slate-600">
                                            <span class="w-3 h-3 rounded-full {{ $level['dot'] }}"></span>
                                            <div>
                                                <div class="text-sm font-semibold">{{ $level['label'] }}</div>
                                                <div class="text-[10px] text-gray-500 dark:text-gray-500">{{ $level['desc'] }}</div>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Teks Soal --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/30 dark:to-violet-900/30">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                            <div>
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200">Teks Soal</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Tuliskan pertanyaan dengan jelas</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Pertanyaan <span class="text-red-500">*</span></label>
                            <textarea name="question_text" x-model="questionText"
                                      class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl shadow-sm focus:ring-purple-500 focus:border-purple-500"
                                      rows="5" required placeholder="Tuliskan soal di sini...

Contoh:
Pilih kata yang memiliki arti SAMA dengan kata SEDIH:"></textarea>
                            <div class="flex items-center justify-between mt-1.5">
                                <span class="text-xs text-gray-400 dark:text-gray-500" x-text="questionText.length + ' karakter'"></span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">Minimal 10 karakter</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Gambar Soal <span class="text-gray-400 dark:text-gray-500 font-normal">(Opsional)</span></label>
                            <div class="border-2 border-dashed border-gray-200 dark:border-slate-700 rounded-xl p-4 text-center hover:border-purple-400 transition-colors cursor-pointer"
                                 x-data="{ dragover: false }"
                                 @dragover.prevent="dragover = true"
                                 @dragleave="dragover = false"
                                 @drop.prevent="dragover = false; $refs.fileInput.files = $event.dataTransfer.files"
                                 :class="dragover ? 'border-purple-400 bg-purple-50 dark:bg-purple-900/30' : ''"
                                 @click="$refs.fileInput.click()">
                                <input type="file" name="question_image" accept="image/*" x-ref="fileInput" class="hidden"
                                       @change="fileName = $event.target.files[0]?.name || ''">
                                <div x-show="!fileName">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 dark:text-gray-500">Klik atau drag & drop gambar</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PNG, JPG, GIF (max 2MB)</p>
                                </div>
                                <div x-show="fileName" class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="fileName"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Pilihan Jawaban --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                                <div>
                                    <h2 class="font-semibold text-gray-800 dark:text-gray-200">Pilihan Jawaban</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Isi minimal 2 pilihan, tandai jawaban benar</p>
                                </div>
                            </div>
                            <span x-show="correctAnswer" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">
                                Jawaban: <span x-text="correctAnswer"></span>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @php
                                $optionColors = ['A' => 'blue', 'B' => 'green', 'C' => 'purple', 'D' => 'amber', 'E' => 'red'];
                            @endphp
                            @foreach(['A', 'B', 'C', 'D'] as $i => $opt)
                            <div class="flex items-center gap-3 p-4 border-2 rounded-xl transition-all cursor-pointer"
                                 :class="correctAnswer === '{{ $opt }}' ? 'border-{{ $optionColors[$opt] }}-500 bg-{{ $optionColors[$opt] }}-50' : 'border-gray-200 dark:border-slate-700 hover:border-gray-300 dark:hover:border-slate-600'"
                                 @click="correctAnswer = '{{ $opt }}'">
                                <div class="flex-shrink-0">
                                    <input type="radio" name="correct_answer" value="{{ $opt }}"
                                           x-model="correctAnswer"
                                           class="w-5 h-5 text-{{ $optionColors[$opt] }}-600 focus:ring-{{ $optionColors[$opt] }}-500"
                                           {{ $opt === 'A' ? 'checked' : '' }}>
                                </div>
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-lg flex-shrink-0"
                                     :class="correctAnswer === '{{ $opt }}' ? 'bg-{{ $optionColors[$opt] }}-100 text-{{ $optionColors[$opt] }}-700' : 'bg-gray-100 text-gray-500 dark:text-gray-400 dark:text-gray-500'">
                                    {{ $opt }}
                                </div>
                                <input type="hidden" name="options[{{ $i }}][key]" value="{{ $opt }}">
                                <input type="text" name="options[{{ $i }}][text]"
                                       class="flex-1 border-0 bg-transparent dark:text-white rounded-lg focus:ring-0 focus:shadow-none text-sm"
                                       placeholder="Tuliskan pilihan {{ $opt }}..."
                                       required>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 p-3 bg-gray-50 dark:bg-slate-800/50 rounded-xl">
                            <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Klik pada pilihan atau radio button untuk menandai jawaban yang benar
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Section 4: Penjelasan --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-800 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/30 dark:to-yellow-900/30">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                            <div>
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200">Penjelasan Jawaban</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">Opsional - membantu kandidat belajar</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <textarea name="explanation" x-model="explanation"
                                  class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                  rows="3"
                                  placeholder="Jelaskan mengapa jawaban tersebut benar...

Contoh:
Murung memiliki arti yang sama dengan sedih, yaitu perasaan tidak gembira atau sedih."></textarea>
                        <div class="flex items-center justify-between mt-1.5">
                            <span class="text-xs text-gray-400 dark:text-gray-500" x-text="explanation.length + ' karakter'"></span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Tampilan: kandidat setelah menjawab</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Preview Sidebar --}}
            <div class="space-y-6">
                <div class="sticky top-24 space-y-4">
                    {{-- Preview Card --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
                        <div class="px-5 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                            <h3 class="font-bold text-sm">Preview Soal</h3>
                        </div>
                        <div class="p-5 space-y-4">
                            {{-- Category & Level --}}
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold"
                                      :class="{
                                          'bg-blue-100 text-blue-700': category === 'verbal',
                                          'bg-green-100 text-green-700': category === 'numerik',
                                          'bg-purple-100 text-purple-700': category === 'logika',
                                          'bg-orange-100 text-orange-700': category === 'spasial'
                                      }"
                                      x-text="categoryLabel"></span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold"
                                      :class="{
                                          'bg-green-100 text-green-700': difficulty === 'easy',
                                          'bg-yellow-100 text-yellow-700': difficulty === 'medium',
                                          'bg-red-100 text-red-700': difficulty === 'hard'
                                      }"
                                      x-text="difficultyLabel"></span>
                            </div>

                            {{-- Question Preview --}}
                            <div>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Soal</p>
                                <p class="text-sm text-gray-800 dark:text-gray-200" x-text="questionText || 'Belum diisi...'"></p>
                            </div>

                            {{-- Options Preview --}}
                            <div>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Pilihan</p>
                                <div class="space-y-1.5">
                                    @foreach(['A', 'B', 'C', 'D'] as $opt)
                                    <div class="flex items-center gap-2 text-xs p-2 rounded-lg"
                                         :class="correctAnswer === '{{ $opt }}' ? 'bg-green-50 text-green-700 font-bold' : 'bg-gray-50 text-gray-600 dark:text-gray-300'">
                                        <span class="w-5 h-5 rounded flex items-center justify-center text-[10px] font-bold flex-shrink-0"
                                              :class="correctAnswer === '{{ $opt }}' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-slate-700'">
                                            {{ $opt }}
                                        </span>
                                        <span x-text="'Pilihan {{ $opt }}'"></span>
                                        <svg x-show="correctAnswer === '{{ $opt }}'" class="w-3 h-3 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Explanation Preview --}}
                            <div x-show="explanation">
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Penjelasan</p>
                                <p class="text-xs text-gray-600 dark:text-gray-300 bg-amber-50 p-2 rounded-lg" x-text="explanation"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Validation Status --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 p-5">
                        <h3 class="font-bold text-sm text-gray-700 dark:text-gray-300 mb-3">Status Validasi</h3>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-xs">
                                <span x-show="questionText.length >= 10" class="text-green-500">✓</span>
                                <span x-show="questionText.length < 10" class="text-red-500">✗</span>
                                <span :class="questionText.length >= 10 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500'">Teks soal terisi</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span x-show="correctAnswer" class="text-green-500">✓</span>
                                <span x-show="!correctAnswer" class="text-red-500">✗</span>
                                <span :class="correctAnswer ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500'">Jawaban benar dipilih</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-green-500">✓</span>
                                <span class="text-gray-700 dark:text-gray-300">Kategori & level dipilih</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-100 dark:border-amber-900/30 p-5">
                        <h3 class="font-bold text-amber-800 dark:text-amber-500 text-sm mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            Tips Membuat Soal
                        </h3>
                        <ul class="text-xs text-amber-700 dark:text-amber-400 space-y-2">
                            <li class="flex items-start gap-2">
                                <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Gunakan bahasa yang jelas dan tidak ambigu
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Pastikan hanya ada 1 jawaban yang benar
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Tambahkan penjelasan untuk membantu kandidat belajar
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Sesuaikan level kesulitan dengan posisi target
                            </li>
                        </ul>
                    </div>

                    {{-- Actions --}}
                    <div class="space-y-3">
                        <button type="submit"
                                class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-sm transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5"
                                :disabled="questionText.length < 10 || !correctAnswer"
                                :class="questionText.length < 10 || !correctAnswer ? 'opacity-50 cursor-not-allowed' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Soal
                        </button>
                        <a href="{{ route('industry.tpa.questions') }}" class="block w-full text-center px-6 py-3 border border-gray-300 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>[x-cloak] { display: none !important; }</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('questionForm', () => ({
        category: 'verbal',
        subcategory: '',
        difficulty: 'medium',
        questionText: '',
        correctAnswer: 'A',
        explanation: '',
        fileName: '',
        get categoryLabel() {
            return { verbal: 'Verbal', numerik: 'Numerik', logika: 'Logika', spasial: 'Spasial' }[this.category] || '';
        },
        get difficultyLabel() {
            return { easy: 'Mudah', medium: 'Sedang', hard: 'Sulit' }[this.difficulty] || '';
        },
        get subcategoryTags() {
            const tags = {
                verbal: ['sinonim', 'antonim', 'analogi', 'pengelompokan'],
                numerik: ['aritmetik', 'seri_angka', 'soal_cerita', 'deret'],
                logika: ['silogisme', 'deduktif', 'analitis', 'logika_cerita'],
                spasial: ['pola_gambar', 'rotasi', 'bayangan_cermin', 'deret_gambar']
            };
            return tags[this.category] || [];
        }
    }));
});
</script>
</x-app-layout>
