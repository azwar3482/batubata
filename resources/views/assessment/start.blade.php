<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    {{ __('messages.know_potential_skill_gap') }}
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-slate-400 max-w-2xl mx-auto">
                    {{ __('messages.get_deep_analysis') }}
                </p>
            </div>

            <!-- Cards Benefit -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-blue-500/10 dark:shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/20 dark:hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4 text-center"
                    style="border-left-color: #3b82f6 !important;">
                    <div
                        class="w-14 h-14 mx-auto bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-300 mb-4 transition-colors duration-300 group-hover:bg-blue-500 group-hover:text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.accurate_analysis') }}</h3>
                    <p class="mt-2 text-gray-500 dark:text-slate-400 text-sm">{{ __('messages.accurate_analysis_desc') }}</p>
                </div>
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-emerald-500/10 dark:shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/20 dark:hover:shadow-emerald-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4 text-center"
                    style="border-left-color: #10b981 !important;">
                    <div
                        class="w-14 h-14 mx-auto bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center text-green-600 dark:text-emerald-300 mb-4 transition-colors duration-300 group-hover:bg-green-500 group-hover:text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.personal_recommendation') }}</h3>
                    <p class="mt-2 text-gray-500 dark:text-slate-400 text-sm">{{ __('messages.personal_recommendation_desc') }}</p>
                </div>
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-purple-500/10 dark:shadow-purple-500/20 hover:shadow-xl hover:shadow-purple-500/20 dark:hover:shadow-purple-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-slate-700 border-l-4 text-center"
                    style="border-left-color: #8b5cf6 !important;">
                    <div
                        class="w-14 h-14 mx-auto bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center text-purple-600 dark:text-purple-300 mb-4 transition-colors duration-300 group-hover:bg-purple-500 group-hover:text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.clear_roadmap') }}</h3>
                    <p class="mt-2 text-gray-500 dark:text-slate-400 text-sm">{{ __('messages.clear_roadmap_desc') }}</p>
                </div>
            </div>

            <!-- Call to Action Box -->
            <div class="bg-white dark:bg-slate-800 border border-transparent dark:border-slate-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 md:p-12 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.ready_improve_career') }}</h2>
                    <p class="mt-3 text-gray-600 dark:text-slate-400 mb-8">{{ __('messages.assessment_takes_10_15_minutes') }}</p>

                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('seeker.assessment.create') }}"
                            class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 md:text-xl shadow-lg transform hover:-translate-y-1 transition duration-200">
                            {{ __('messages.start_assessment_now') }}
                        </a>
                        <a href="{{ route('seeker.assessment.history') }}"
                            class="inline-flex justify-center items-center px-8 py-4 border border-gray-300 text-lg font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 md:text-xl shadow-sm transition duration-200">
                            {{ __('messages.view_assessment_history') }}
                        </a>
                    </div>

                    <p class="mt-6 text-xs text-gray-400">
                        {{ __('messages.data_safe_analysis_only') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
