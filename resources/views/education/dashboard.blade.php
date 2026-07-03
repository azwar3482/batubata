<x-app-layout>
    @push('head-scripts')
    @vite(['resources/js/chart.js'])
    @endpush
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.education_dashboard') }}</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">
                        {{ __('messages.education_desc') }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        {{ __('messages.export_data') }}
                    </button>
                    <!-- Tombol Tambah Program -->
                    <a href="{{ route('education.programs.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 dark:hover:bg-indigo-600 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('messages.add_program') }}
                    </a>
                </div>
            </div>
            <!-- Peringatan Verifikasi Institusi -->
            @if(Auth::user()->institution && !Auth::user()->institution->isVerified())
                <div class="mb-8 bg-amber-50 border border-amber-200 rounded-xl p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="relative z-10 flex flex-col sm:flex-row gap-5 items-start sm:items-center">
                        <div class="flex-shrink-0 bg-amber-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="flex-grow">
                            @if(Auth::user()->institution->isRejected())
                                 <h3 class="text-lg font-bold text-red-800">{{ __('messages.verification_rejected') }}</h3>
                                 <p class="text-sm text-red-700 mt-1 mb-2">{{ __('messages.verification_rejected_desc') }} <strong>{{ Auth::user()->institution->rejection_reason }}</strong></p>
                                 <p class="text-sm text-red-600">{{ __('messages.check_documents') }}</p>
                             @elseif(Auth::user()->institution->isPending())
                                 <h3 class="text-lg font-bold text-amber-800">{{ __('messages.waiting_verification') }}</h3>
                                 <p class="text-sm text-amber-700 mt-1">{{ __('messages.waiting_verification_desc') }}</p>
                             @else
                                 <h3 class="text-lg font-bold text-amber-800">{{ __('messages.profile_incomplete') }}</h3>
                                 <p class="text-sm text-amber-700 mt-1">{{ __('messages.profile_incomplete_desc') }}</p>
                            @endif
                        </div>
                        <div class="flex-shrink-0 mt-4 sm:mt-0">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                 {{ __('messages.complete_documents') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-teal-50 to-emerald-50 dark:from-teal-900/20 dark:to-emerald-900/20 border border-teal-100 dark:border-teal-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-teal-100 dark:bg-teal-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                         <h4 class="text-sm font-bold text-teal-900 dark:text-teal-200 mb-1">{{ __('messages.about_education_dashboard') }}</h4>
                         <p class="text-sm text-teal-700 dark:text-teal-300 leading-relaxed">{{ __('messages.about_education_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Lulusan -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-blue-500/20 dark:shadow-blue-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-blue-500/40 transition" style="border-left-color: #3b82f6 !important;">
                    <div class="flex items-center justify-between">
                        <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.total_graduates') }}</p>
                             <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_students']) }}</p>
                             <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.registered_in_system') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Skill Gap -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-orange-500/20 dark:shadow-orange-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-orange-500/40 transition" style="border-left-color: #f97316 !important;">
                    <div class="flex items-center justify-between">
                        <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.average_skill_gap') }}</p>
                             <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['avg_skill_gap'] }}%</p>
                             <p class="text-sm {{ $stats['avg_skill_gap'] > 30 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} mt-1">
                                 {{ $stats['avg_skill_gap'] > 30 ? __('messages.needs_attention') : __('messages.within_safe_limit') }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center text-orange-600 dark:text-orange-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Placement Rate -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-green-500/20 dark:shadow-green-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-green-500/40 transition" style="border-left-color: #22c55e !important;">
                    <div class="flex items-center justify-between">
                        <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.placement_rate') }}</p>
                             <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['placement_rate'] }}%</p>
                             <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.from_total_applications') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Asesmen Diselesaikan -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-purple-500/20 dark:shadow-purple-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-purple-500/40 transition" style="border-left-color: #a855f7 !important;">
                    <div class="flex items-center justify-between">
                        <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.completed_assessments') }}</p>
                             <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_assessments']) }}</p>
                             <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.total_graduate_assessments') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Lamaran Kerja Siswa -->
            <div class="mb-6">
                 <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-slate-600 pb-2">{{ __('messages.graduate_job_application_status') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Lamaran -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-blue-500/20 dark:shadow-blue-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-blue-500/40 transition" style="border-left-color: #3b82f6 !important;">
                        <div class="flex items-center justify-between">
                            <div>
                                 <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.total_applications') }}</p>
                                 <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total_applications'] ?? 0 }}</p>
                                 <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.submitted_applications') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Diproses -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-yellow-500/20 dark:shadow-yellow-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-yellow-500/40 transition" style="border-left-color: #eab308 !important;">
                        <div class="flex items-center justify-between">
                            <div>
                                 <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.being_processed') }}</p>
                                 <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['processing_applications'] ?? 0 }}</p>
                                 <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.in_selection_stage') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Diterima -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-green-500/20 dark:shadow-green-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-green-500/40 transition" style="border-left-color: #22c55e !important;">
                        <div class="flex items-center justify-between">
                            <div>
                                 <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.hired') }}</p>
                                 <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['accepted_applications'] ?? 0 }}</p>
                                 <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.offer_received') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Ditolak -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-red-500/20 dark:shadow-red-500/20 p-6 border border-gray-200 dark:border-slate-600 border-l-4 hover:shadow-xl hover:shadow-red-500/40 transition" style="border-left-color: #ef4444 !important;">
                        <div class="flex items-center justify-between">
                            <div>
                                 <p class="text-sm font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">{{ __('messages.not_successful') }}</p>
                                 <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $stats['rejected_applications'] ?? 0 }}</p>
                                 <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.rejected_by_industry') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center text-red-600 dark:text-red-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                <!-- Chart 1: Skill Gap per Jurusan -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 border border-gray-200 dark:border-slate-600">
                    <div class="flex items-center justify-between mb-4">
                         <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.average_skill_gap_per_major') }}</h3>
                        <select
                            class="text-sm border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                             <option>{{ __('messages.year_2024') }}</option>
                             <option>{{ __('messages.year_2023') }}</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="jurusanChart"></canvas>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-4 text-center">
                         *{{ __('messages.assessment_based_data') }}
                    </p>
                </div>

                <!-- Chart 2: Top Kompetensi Bermasalah -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 border border-gray-200 dark:border-slate-600">
                    <div class="flex items-center justify-between mb-4">
                         <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.top_5_highest_gap') }}</h3>
                         <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">{{ __('messages.view_all') }}</button>
                    </div>
                    <div class="h-64">
                        <canvas id="competencyChart"></canvas>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-4 text-center">
                         *{{ __('messages.curriculum_focus') }}
                    </p>
                </div>
            </div>

            <!-- Recommendations Table -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-200 dark:border-slate-600 overflow-hidden mb-8">
                <div
                    class="p-6 border-b border-gray-200 dark:border-slate-600 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                     <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.curriculum_adjustment_recommendations') }}</h3>
                    <div class="flex gap-2">
                        <button
                                     class="px-4 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-gray-700 dark:text-slate-300">{{ __('messages.filter') }}</button>
                         <button
                             class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">{{ __('messages.export_csv') }}
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                     {{ __('messages.competency') }}</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                     {{ __('messages.major') }}</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                     {{ __('messages.average_gap') }}</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                     {{ __('messages.recommendation') }}</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                     {{ __('messages.priority') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                            @forelse($curriculumRecommendations as $index => $rec)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $rec['name'] }}</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">{{ $rec['category'] }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $rec['major'] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 dark:bg-slate-600 rounded-full h-2 mr-3">
                                            <div class="{{ $rec['avg_gap'] > 50 ? 'bg-red-500' : ($rec['avg_gap'] > 25 ? 'bg-yellow-500' : 'bg-green-500') }} h-2 rounded-full" style="width: {{ $rec['avg_gap'] }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium {{ $rec['avg_gap'] > 50 ? 'text-red-600' : ($rec['avg_gap'] > 25 ? 'text-yellow-600' : 'text-green-600') }}">{{ $rec['avg_gap'] }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                    {{ $rec['recommendation'] }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rec['priority'] === 'Tinggi' ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' : ($rec['priority'] === 'Sedang' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300') }}">
                                        {{ $rec['priority'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 text-sm">
                                     {{ __('messages.no_recommendation_data') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800 flex items-center justify-between">
                    <div class="text-sm text-gray-500 dark:text-slate-400">
                         {{ __('messages.based_on_real_assessment') }}
                    </div>
                </div>
            </div>

            <!-- Industry Collaboration Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-lg p-8 text-white mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                         <h3 class="text-2xl font-bold mb-2">🤝 {{ __('messages.industry_collaboration') }}</h3>
                         <p class="text-indigo-100 max-w-2xl">
                             {{ __('messages.collaboration_desc') }}
                        </p>
                    </div>
                    {{-- <div class="flex flex-col sm:flex-row gap-3">
                        <button
                            class="px-6 py-3 bg-white text-indigo-700 rounded-lg font-medium hover:bg-indigo-50 transition shadow">
                            Lihat Mitra Industri
                        </button>
                        <button
                            class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white/10 transition">
                            Ajukan Kolaborasi
                        </button>
                    </div> --}}
                    <!-- Ganti bagian tombol di collaboration banner -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('education.partners') }}"
                            class="px-6 py-3 bg-white text-indigo-700 rounded-lg font-medium hover:bg-indigo-50 transition shadow text-center">
                             {{ __('messages.view_industry_partners') }}
                         </a>
                         <a href="{{ route('education.collaboration.create') }}"
                             class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white/10 transition text-center">
                             {{ __('messages.propose_collaboration') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-200 dark:border-slate-600 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-slate-600">
                     <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.latest_activities') }}</h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-slate-600">
                    @forelse($recentActivities as $activity)
                    <div class="p-6 flex items-start gap-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                        <div
                            class="w-10 h-10 {{ $activity['color'] === 'blue' ? 'bg-blue-100 text-blue-600' : ($activity['color'] === 'green' ? 'bg-green-100 text-green-600' : ($activity['color'] === 'red' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600')) }} rounded-full flex items-center justify-center flex-shrink-0">
                            @if($activity['icon'] === 'assessment')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $activity['title'] }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                                {{ $activity['detail'] }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-2">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                         <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">{{ __('messages.no_recent_activities') }}</p>
                         <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">{{ __('messages.activities_appear_after') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<!-- Chart.js Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Colors
        const chartColors = {
            blue: 'rgba(59, 130, 246, 0.8)',
            blueBorder: 'rgb(59, 130, 246)',
            indigo: 'rgba(99, 102, 241, 0.8)',
            indigoBorder: 'rgb(99, 102, 241)',
            red: 'rgba(239, 68, 68, 0.8)',
            redBorder: 'rgb(239, 68, 68)',
            green: 'rgba(34, 197, 94, 0.8)',
            greenBorder: 'rgb(34, 197, 94)',
            yellow: 'rgba(234, 179, 8, 0.8)',
            yellowBorder: 'rgb(234, 179, 8)',
            purple: 'rgba(147, 51, 234, 0.8)',
            purpleBorder: 'rgb(147, 51, 234)',
        };

        // Chart 1: Average Skill Gap by Major
        const jurusanData = @json($skillGapByMajor);
        const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
        const jurusanChart = new Chart(jurusanCtx, {
            type: 'bar',
            data: {
                    labels: jurusanData.length > 0 ? jurusanData.map(d => d.major) : ['{{ __("messages.no_data") }}'],
                datasets: [{
                    label: 'Skill Gap (%)',
                    data: jurusanData.length > 0 ? jurusanData.map(d => d.avg_gap) : [0],
                    backgroundColor: jurusanData.map((_, i) => [chartColors.blue, chartColors.purple, chartColors.green, chartColors.red, chartColors.yellow][i % 5]),
                    borderColor: jurusanData.map((_, i) => [chartColors.blueBorder, chartColors.purpleBorder, chartColors.greenBorder, chartColors.redBorder, chartColors.yellowBorder][i % 5]),
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Gap: ${context.parsed.y}%`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart 2: Top Competency Gap (Horizontal Bar)
        const competencyData = @json($topGapCompetencies);
        const competencyCtx = document.getElementById('competencyChart').getContext('2d');
        const competencyChart = new Chart(competencyCtx, {
            type: 'bar',
            data: {
                    labels: competencyData.length > 0 ? competencyData.map(d => d.name) : ['{{ __("messages.no_data") }}'],
                datasets: [{
                    label: 'Gap (%)',
                    data: competencyData.length > 0 ? competencyData.map(d => d.avg_gap) : [0],
                    backgroundColor: competencyData.map(d => d.avg_gap > 50 ? chartColors.red : (d.avg_gap > 25 ? chartColors.yellow : chartColors.green)),
                    borderColor: competencyData.map(d => d.avg_gap > 50 ? chartColors.redBorder : (d.avg_gap > 25 ? chartColors.yellowBorder : chartColors.greenBorder)),
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Gap: ${context.parsed.x}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Dynamic Dark Mode for Chart.js
        function updateChartColors(chart, isDark) {
            const textColor = isDark ? '#9ca3af' : '#6b7280'; // gray-400 vs gray-500
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
            const tooltipBg = isDark ? 'rgba(31, 41, 55, 0.95)' : 'rgba(255, 255, 255, 0.95)';
            const tooltipText = isDark ? '#f9fafb' : '#1f2937';

            if (chart.options.plugins.legend) {
                if (chart.options.plugins.legend.labels) {
                    chart.options.plugins.legend.labels.color = textColor;
                }
            }
            if (chart.options.plugins.tooltip) {
                chart.options.plugins.tooltip.backgroundColor = tooltipBg;
                chart.options.plugins.tooltip.titleColor = tooltipText;
                chart.options.plugins.tooltip.bodyColor = tooltipText;
            }

            if (chart.options.scales.x) {
                if (chart.options.scales.x.ticks) chart.options.scales.x.ticks.color = textColor;
                if (!chart.options.scales.x.grid) chart.options.scales.x.grid = {};
                chart.options.scales.x.grid.color = gridColor;
            }
            if (chart.options.scales.y) {
                if (chart.options.scales.y.ticks) chart.options.scales.y.ticks.color = textColor;
                if (!chart.options.scales.y.grid) chart.options.scales.y.grid = {};
                chart.options.scales.y.grid.color = gridColor;
            }
            chart.update();
        }

        const isDark = document.documentElement.classList.contains('dark');
        updateChartColors(jurusanChart, isDark);
        updateChartColors(competencyChart, isDark);

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isDarkNow = document.documentElement.classList.contains('dark');
                    updateChartColors(jurusanChart, isDarkNow);
                    updateChartColors(competencyChart, isDarkNow);
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true
        });
    });
</script>

<!-- Driver.js for Tour -->
@vite(['resources/js/driver.js'])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tourSteps = [
            {
                popover: {
                        title: '{{ __("messages.welcome") }} {{ __("messages.education_role") }}',
                        description: '{{ __("messages.tour_app") }}',
                    align: 'center'
                }
            },
            {
                element: 'header',
                    popover: {
                        title: '{{ __("messages.notifications") }}',
                        description: '{{ __("messages.general_settings") }}',
                    side: "bottom",
                    align: 'center'
                }
            },
            {
                element: 'a[href*="education/dashboard"]',
                    popover: {
                        title: '{{ __("messages.education_dashboard") }}',
                        description: '{{ __("messages.education_desc") }}',
                    side: "right",
                    align: 'start'
                }
            },
            {
                element: 'a[href*="education/analytics"]',
                    popover: {
                        title: '{{ __("messages.graduate_analytics") }}',
                        description: '{{ __("messages.monitor_realtime") }}',
                    side: "right",
                    align: 'start'
                }
            },
            {
                element: 'a[href*="education/students"]',
                    popover: {
                        title: '{{ __("messages.users") }}',
                        description: '{{ __("messages.manage_competencies") }}',
                    side: "right",
                    align: 'start'
                }
            },
            {
                element: 'a[href*="education/courses"]',
                    popover: {
                        title: '{{ __("messages.course_management") }}',
                        description: '{{ __("messages.recommendation_based_desc") }}',
                    side: "right",
                    align: 'start'
                }
            },
            {
                element: 'a[href*="education/programs"]',
                    popover: {
                        title: '{{ __("messages.add_program") }}',
                        description: '{{ __("messages.manage_competencies") }}',
                    side: "right",
                    align: 'start'
                }
            },
            {
                element: 'a[href*="education/partners"]',
                    popover: {
                        title: '{{ __("messages.view_industry_partners") }}',
                        description: '{{ __("messages.collaboration_desc") }}',
                    side: "right",
                    align: 'start'
                }
            }
        ];

        const driverObj = window.createTour(tourSteps);

        const startTourBtn = document.getElementById('start-tour-btn');
        if (startTourBtn) {
            startTourBtn.addEventListener('click', () => driverObj.drive());
        }
    });
</script>
<style>
    /* Driver.js Custom Styling */
    .driverjs-theme {
        font-family: inherit;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    .driver-popover-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937;
        /* text-gray-900 */
    }

    .driver-popover-description {
        font-size: 13.5px;
        line-height: 1.5;
        color: #4b5563;
        /* text-gray-600 */
    }

    .driver-popover-footer {
        margin-top: 12px;
    }

    .driver-popover-progress-text {
        font-size: 12px;
        color: #6b7280;
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        html.dark .driverjs-theme {
            background-color: #1e293b;
            /* bg-slate-800 */
            color: #e2e8f0;
        }

        html.dark .driver-popover-title {
            color: #f8fafc;
        }

        html.dark .driver-popover-description {
            color: #cbd5e1;
            /* text-slate-300 */
        }

        html.dark .driver-popover-progress-text {
            color: #94a3b8;
        }

        html.dark .driver-popover-footer .driver-popover-btn {
            background-color: #334155;
            color: #f8fafc;
            border: 1px solid #475569;
            text-shadow: none;
        }

        html.dark .driver-popover-footer .driver-popover-btn:hover {
            background-color: #475569;
        }

        html.dark .driver-popover-arrow {
            border-color: #1e293b;
        }
    }
</style>