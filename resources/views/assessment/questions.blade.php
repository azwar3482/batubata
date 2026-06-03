<x-app-layout>
    <div class="py-8" x-data="{ 
        currentStep: 1, 
        totalSteps: {{ $totalSteps }},
        steps: @json($steps),
        stepLabels: { 'technical': 'Skill Teknis', 'soft_skill': 'Soft Skill' }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Penilaian Skill: {{ $position->name }}</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">Jujurlah dalam menilai kemampuan Anda saat ini (Skala 1-5).</p>
            </div>

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl p-6 sm:p-8 border border-slate-100 dark:border-slate-800">
                
                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2.5 mb-8">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full transition-all duration-500" 
                         :style="'width: ' + ((currentStep / totalSteps) * 100) + '%'"></div>
                </div>

                {{-- Step Indicator --}}
                <div class="flex items-center justify-center gap-3 mb-8">
                    <template x-for="(step, index) in steps" :key="step">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300"
                                 :class="currentStep > index + 1 ? 'bg-green-500 text-white' : currentStep === index + 1 ? 'bg-blue-600 text-white ring-4 ring-blue-200 dark:ring-blue-900' : 'bg-gray-200 dark:bg-slate-700 text-gray-500'">
                                <template x-if="currentStep > index + 1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="currentStep <= index + 1">
                                    <span x-text="index + 1"></span>
                                </template>
                            </div>
                            <span class="text-xs font-medium hidden sm:inline" 
                                  :class="currentStep === index + 1 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-slate-500'"
                                  x-text="stepLabels[step]"></span>
                            <template x-if="index < steps.length - 1">
                                <div class="w-8 h-0.5 bg-gray-200 dark:bg-slate-700"></div>
                            </template>
                        </div>
                    </template>
                </div>

                <form action="{{ route('seeker.assessment.submit') }}" method="POST" id="assessmentForm">
                    @csrf
                    
                    {{-- STEP 1: Technical Skills --}}
                    @if($technicalSkills->isNotEmpty())
                    <div x-show="currentStep === {{ array_search('technical', $steps) + 1 }}" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-10" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b dark:border-slate-700 pb-2 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            A. Skill Teknis
                            <span class="text-sm font-normal text-gray-500 dark:text-slate-400">({{ $technicalSkills->count() }} skill)</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($technicalSkills as $index => $skill)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 dark:bg-slate-800 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700/50 transition border border-transparent hover:border-blue-200 dark:hover:border-blue-800/30">
                                    <div class="mb-4 sm:mb-0 sm:w-1/2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                            <label class="font-semibold text-gray-700 dark:text-slate-200">{{ $skill->name }}</label>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 ml-8">
                                            Target Industri: 
                                            <span class="font-medium text-amber-600 dark:text-amber-400">Level {{ $skill->min_level_required }}/5</span>
                                        </p>
                                    </div>
                                    <div class="sm:w-1/2 flex flex-col">
                                        <div class="flex items-center space-x-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group">
                                                    <input type="radio" name="skills[{{ $skill->id }}]" value="{{ $i }}" required 
                                                        class="peer sr-only">
                                                    <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-slate-600 text-gray-400 dark:text-slate-500 font-bold peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 peer-checked:scale-110">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between text-[11px] text-gray-500 dark:text-slate-400 mt-1.5 w-[216px]">
                                            <span>1: Kurang</span>
                                            <span>5: Sangat Baik</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="button" @click="currentStep++" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl font-medium hover:from-blue-700 hover:to-indigo-800 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                                Lanjut ke {{ $totalSteps > 1 ? 'Soft Skill' : 'Selesai' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    {{-- STEP 2: Soft Skills --}}
                    @if($softSkills->isNotEmpty())
                    <div x-show="currentStep === {{ array_search('soft_skill', $steps) + 1 }}" 
                         style="display: none;" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-10" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b dark:border-slate-700 pb-2 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            B. Soft Skill
                            <span class="text-sm font-normal text-gray-500 dark:text-slate-400">({{ $softSkills->count() }} skill)</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($softSkills as $index => $skill)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 dark:bg-slate-800 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700/50 transition border border-transparent hover:border-purple-200 dark:hover:border-purple-800/30">
                                    <div class="mb-4 sm:mb-0 sm:w-1/2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-full flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                            <label class="font-semibold text-gray-700 dark:text-slate-200">{{ $skill->name }}</label>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 ml-8">
                                            Target Industri: 
                                            <span class="font-medium text-amber-600 dark:text-amber-400">Level {{ $skill->min_level_required }}/5</span>
                                        </p>
                                    </div>
                                    <div class="sm:w-1/2 flex flex-col">
                                        <div class="flex items-center space-x-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group">
                                                    <input type="radio" name="skills[{{ $skill->id }}]" value="{{ $i }}" required 
                                                        class="peer sr-only">
                                                    <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-slate-600 text-gray-400 dark:text-slate-500 font-bold peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 hover:border-purple-400 dark:hover:border-purple-500 transition-all duration-200 peer-checked:scale-110">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between text-[11px] text-gray-500 dark:text-slate-400 mt-1.5 w-[216px]">
                                            <span>1: Kurang</span>
                                            <span>5: Sangat Baik</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="currentStep--" class="px-6 py-3 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-xl font-medium hover:bg-gray-300 dark:hover:bg-slate-600 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                Kembali
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl font-medium hover:from-green-700 hover:to-emerald-800 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                                Selesai & Analisis
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                    </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
