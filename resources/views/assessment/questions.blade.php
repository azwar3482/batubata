<x-app-layout>
    <style>
        .rating-btn input[type="radio"]:checked + .rating-box {
            transform: scale(1.1);
            color: white;
        }
        .rating-btn input[type="radio"]:checked + .rating-box[data-color="red"] {
            background-color: #ef4444;
            border-color: #ef4444;
        }
        .rating-btn input[type="radio"]:checked + .rating-box[data-color="orange"] {
            background-color: #f97316;
            border-color: #f97316;
        }
        .rating-btn input[type="radio"]:checked + .rating-box[data-color="yellow"] {
            background-color: #eab308;
            border-color: #eab308;
        }
        .rating-btn input[type="radio"]:checked + .rating-box[data-color="blue"] {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .rating-btn input[type="radio"]:checked + .rating-box[data-color="green"] {
            background-color: #22c55e;
            border-color: #22c55e;
        }
        .rating-btn:hover .rating-box[data-color="red"] {
            border-color: #f87171;
        }
        .rating-btn:hover .rating-box[data-color="orange"] {
            border-color: #fb923c;
        }
        .rating-btn:hover .rating-box[data-color="yellow"] {
            border-color: #facc15;
        }
        .rating-btn:hover .rating-box[data-color="blue"] {
            border-color: #60a5fa;
        }
        .rating-btn:hover .rating-box[data-color="green"] {
            border-color: #4ade80;
        }
        .rating-btn input[type="radio"]:checked + .rating-box + .rating-label {
            opacity: 1;
        }
        #sticky-legend {
            background-color: #eff6ff !important; /* solid blue-50 */
        }
        html.dark #sticky-legend, .dark #sticky-legend {
            background-color: #0f172a !important; /* solid slate-900 */
        }
    </style>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Penilaian Skill: {{ $targetName }}</h2>
                
                 <p class="mt-2 text-gray-600 dark:text-slate-400">Orang yang terbiasa berbohong lupa bahwa kepercayaan itu tidak bisa dibeli, hanya bisa dijaga.</p>
            <p class="mt-2 text-gray-600 dark:text-slate-400">Nilai kemampuan Anda secara jujur (Skala 1-10).</p>
        </div>

            {{-- Legend (Sticky) --}}
            <div id="sticky-legend" class="sticky top-16 z-50 mb-6 py-6 px-4 border border-blue-200 dark:border-slate-800 rounded-xl shadow-md">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200">Panduan Penilaian</h4>
                    <div class="flex gap-2 text-xs">
                        <span class="px-2 py-1 bg-red-500 text-white rounded">1-2 Tidak Tahu</span>
                        <span class="px-2 py-1 bg-orange-500 text-white rounded">3-4 Pemula</span>
                        <span class="px-2 py-1 bg-yellow-500 text-white rounded">5-6 Menengah</span>
                        <span class="px-2 py-1 bg-blue-500 text-white rounded">7-8 Mahir</span>
                        <span class="px-2 py-1 bg-green-500 text-white rounded">9-10 Ahli</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('seeker.assessment.submit') }}" method="POST" id="assessmentForm">
                @csrf
                
                {{-- Technical Skills --}}
                @if($technicalSkills->isNotEmpty())
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl p-6 sm:p-8 border border-slate-100 dark:border-slate-800 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b dark:border-slate-700 pb-2 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        A. Skill Teknis
                        <span class="text-sm font-normal text-gray-500 dark:text-slate-400">({{ $technicalSkills->count() }} skill)</span>
                    </h3>
                    <div class="space-y-6">
                        @foreach($technicalSkills as $index => $skill)
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-xl border border-transparent hover:border-blue-200 dark:hover:border-blue-800/30 transition">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                    <label class="font-semibold text-gray-700 dark:text-slate-200">{{ $skill->name }}</label>
                                    <span class="text-xs text-gray-500 dark:text-slate-400 ml-auto">Target: Level {{ $skill->min_level_required }}/10</span>
                                </div>
                                
                                {{-- Rating Buttons --}}
                                <div class="flex flex-wrap justify-between gap-2">
                                    @for($i = 1; $i <= 10; $i++)
                                        @php
                                            $color = $i <= 2 ? 'red' : ($i <= 4 ? 'orange' : ($i <= 6 ? 'yellow' : ($i <= 8 ? 'blue' : 'green')));
                                            $label = $i <= 2 ? 'Tidak Tahu' : ($i <= 4 ? 'Pemula' : ($i <= 6 ? 'Menengah' : ($i <= 8 ? 'Mahir' : 'Ahli')));
                                        @endphp
                                        <label class="rating-btn cursor-pointer group relative">
                                            <input type="radio" name="skills[{{ $skill->id }}]" value="{{ $i }}" required class="sr-only">
                                            <div class="rating-box w-12 h-12 flex flex-col items-center justify-center rounded-lg border-2 border-gray-300 dark:border-slate-600 text-gray-400 dark:text-slate-500 font-bold transition-all duration-200" data-color="{{ $color }}">
                                                <span class="text-sm">{{ $i }}</span>
                                            </div>
                                            <div class="rating-label absolute -bottom-5 left-1/2 -translate-x-1/2 text-[9px] text-gray-500 dark:text-slate-400 whitespace-nowrap opacity-0 transition-opacity">
                                                {{ $label }}
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                
                                {{-- Scale Labels --}}
                                <div class="flex justify-between mt-7 text-[10px] text-gray-500 dark:text-slate-400">
                                    <span>1: Tidak Tahu</span>
                                    <span>3: Pemula</span>
                                    <span>5: Menengah</span>
                                    <span>7: Mahir</span>
                                    <span>10: Ahli</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Soft Skills --}}
                @if($softSkills->isNotEmpty())
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl p-6 sm:p-8 border border-slate-100 dark:border-slate-800 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b dark:border-slate-700 pb-2 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        B. Soft Skill
                        <span class="text-sm font-normal text-gray-500 dark:text-slate-400">({{ $softSkills->count() }} skill)</span>
                    </h3>
                    <div class="space-y-6">
                        @foreach($softSkills as $index => $skill)
                            <div class="p-4 bg-gray-50 dark:bg-slate-800 rounded-xl border border-transparent hover:border-purple-200 dark:hover:border-purple-800/30 transition">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-full flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                    <label class="font-semibold text-gray-700 dark:text-slate-200">{{ $skill->name }}</label>
                                    <span class="text-xs text-gray-500 dark:text-slate-400 ml-auto">Target: Level {{ $skill->min_level_required }}/10</span>
                                </div>
                                
                                {{-- Rating Buttons --}}
                                <div class="flex flex-wrap justify-between gap-2">
                                    @for($i = 1; $i <= 10; $i++)
                                        @php
                                            $color = $i <= 2 ? 'red' : ($i <= 4 ? 'orange' : ($i <= 6 ? 'yellow' : ($i <= 8 ? 'blue' : 'green')));
                                            $label = $i <= 2 ? 'Tidak Tahu' : ($i <= 4 ? 'Pemula' : ($i <= 6 ? 'Menengah' : ($i <= 8 ? 'Mahir' : 'Ahli')));
                                        @endphp
                                        <label class="rating-btn cursor-pointer group relative">
                                            <input type="radio" name="skills[{{ $skill->id }}]" value="{{ $i }}" required class="sr-only">
                                            <div class="rating-box w-12 h-12 flex flex-col items-center justify-center rounded-lg border-2 border-gray-300 dark:border-slate-600 text-gray-400 dark:text-slate-500 font-bold transition-all duration-200" data-color="{{ $color }}">
                                                <span class="text-sm">{{ $i }}</span>
                                            </div>
                                            <div class="rating-label absolute -bottom-5 left-1/2 -translate-x-1/2 text-[9px] text-gray-500 dark:text-slate-400 whitespace-nowrap opacity-0 transition-opacity">
                                                {{ $label }}
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                
                                {{-- Scale Labels --}}
                                <div class="flex justify-between mt-7 text-[10px] text-gray-500 dark:text-slate-400">
                                    <span>1: Tidak Tahu</span>
                                    <span>3: Pemula</span>
                                    <span>5: Menengah</span>
                                    <span>7: Mahir</span>
                                    <span>10: Ahli</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Submit Button --}}
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl p-6 sm:p-8 border border-slate-100 dark:border-slate-800">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('seeker.assessment.create') }}" class="px-6 py-3 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-xl font-medium hover:bg-gray-300 dark:hover:bg-slate-600 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Kembali
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl font-medium hover:from-green-700 hover:to-emerald-800 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                            Selesai & Analisis
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
