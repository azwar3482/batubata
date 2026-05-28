<x-app-layout>
    <div class="py-8" x-data="{ currentStep: 1, totalSteps: 2 }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Penilaian Skill: {{ $position->name }}</h2>
                <p class="mt-2 text-gray-600">Jujurlah dalam menilai kemampuan Anda saat ini (Skala 1-5).</p>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8">
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" 
                         :style="'width: ' + ((currentStep / totalSteps) * 100) + '%'"></div>
                </div>

                <form action="{{ route('seeker.assessment.submit') }}" method="POST" id="assessmentForm">
                    @csrf
                    
                    <!-- STEP 1: Technical Skills -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">A. Skill Teknis</h3>
                        <div class="space-y-6">
                            @foreach($technicalSkills as $skill)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="mb-4 sm:mb-0 sm:w-1/2">
                                        <label class="font-semibold text-gray-700">{{ $skill->name }}</label>
                                        <p class="text-xs text-gray-500 mt-1">Target Industri: Level {{ $skill->min_level_required }}/5</p>
                                    </div>
                                    <div class="sm:w-1/2 flex flex-col">
                                        <div class="flex items-center space-x-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group">
                                                    <input type="radio" name="skills[{{ $skill->id }}]" value="{{ $i }}" required 
                                                        class="peer sr-only">
                                                    <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-400 font-bold peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:border-blue-400 transition">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between text-[11px] text-gray-500 mt-1.5 w-[216px]">
                                            <span>1: Kurang</span>
                                            <span>5: Sangat Baik</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="button" @click="currentStep++" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-lg">
                                Lanjut ke Soft Skill &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: Soft Skills -->
                    <div x-show="currentStep === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">B. Soft Skill</h3>
                        <div class="space-y-6">
                            @foreach($softSkills as $skill)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="mb-4 sm:mb-0 sm:w-1/2">
                                        <label class="font-semibold text-gray-700">{{ $skill->name }}</label>
                                        <p class="text-xs text-gray-500 mt-1">Target Industri: Level {{ $skill->min_level_required }}/5</p>
                                    </div>
                                    <div class="sm:w-1/2 flex flex-col">
                                        <div class="flex items-center space-x-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group">
                                                    <input type="radio" name="skills[{{ $skill->id }}]" value="{{ $i }}" required 
                                                        class="peer sr-only">
                                                    <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-400 font-bold peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:border-blue-400 transition">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between text-[11px] text-gray-500 mt-1.5 w-[216px]">
                                            <span>1: Kurang</span>
                                            <span>5: Sangat Baik</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="currentStep--" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                                &larr; Kembali
                            </button>
                            <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition shadow-lg flex items-center">
                                Selesai & Analisis <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>