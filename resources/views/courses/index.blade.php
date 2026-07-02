<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.dashboard') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ __('messages.courses_and_learning') }}</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.courses_and_learning') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.enhance_competencies') }}</p>
                </div>
                <a href="{{ route('seeker.courses.my-progress') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-650 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('messages.my_learning_progress') }}
                </a>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-100 dark:border-blue-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">{{ __('messages.about_courses') }}</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed">{!! __('messages.courses_description') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 mb-8 border border-gray-100 dark:border-slate-800">
                <form action="{{ route('seeker.courses.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.search_courses') }}</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.keywords') }}"
                                class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.category') }}</label>
                            <select name="category"
                                class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('messages.all_categories') }}</option>
                                <option value="technical" {{ request('category') == 'technical' ? 'selected' : '' }}>{{ __('messages.technical') }}</option>
                                <option value="soft_skill" {{ request('category') == 'soft_skill' ? 'selected' : '' }}>{{ __('messages.soft_skill') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.level') }}</label>
                            <select name="level"
                                class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('messages.all_levels') }}</option>
                                <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>{{ __('messages.beginner') }}</option>
                                <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>{{ __('messages.intermediate') }}</option>
                                <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>{{ __('messages.advanced') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.platform') }}</label>
                            <select name="platform"
                                class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-800 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('messages.all_platforms') }}</option>
                                <option value="Coursera" {{ request('platform') == 'Coursera' ? 'selected' : '' }}>Coursera</option>
                                <option value="Dicoding" {{ request('platform') == 'Dicoding' ? 'selected' : '' }}>Dicoding</option>
                                <option value="Udemy" {{ request('platform') == 'Udemy' ? 'selected' : '' }}>Udemy</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                {{ __('messages.search') }}
                            </button>
                            @if(request()->hasAny(['search', 'category', 'level', 'platform']))
                                <a href="{{ route('seeker.courses.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 transition flex items-center justify-center" title="{{ __('messages.reset') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Main Content Container with Toggle -->
            <div x-data="{ viewMode: localStorage.getItem('courseViewMode') || 'card' }" x-init="$watch('viewMode', val => localStorage.setItem('courseViewMode', val))">
                
                <!-- View Toggle & Summary Bar -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div class="text-sm text-gray-500 dark:text-slate-400">
                        {{ __('messages.showing_course_list') }}
                    </div>
                    <div class="flex items-center gap-2 bg-gray-100 dark:bg-slate-800/80 p-1 rounded-xl shadow-inner border border-gray-200/50 dark:border-slate-800/50">
                        <button @click="viewMode = 'card'" 
                            :class="viewMode === 'card' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200'"
                            class="flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-bold transition duration-200 focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            {{ __('messages.card_grid') }}
                        </button>
                        <button @click="viewMode = 'table'" 
                            :class="viewMode === 'table' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200'"
                            class="flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-bold transition duration-200 focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            {{ __('messages.list_table') }}
                        </button>
                    </div>
                </div>

                <!-- Rekomendasi dari Pengajar -->
                @if(isset($teacherCourses) && $teacherCourses->count() > 0)
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-lg mr-3 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.recommendations') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.courses_from_expert_teachers') }}</p>
                        </div>
                    </div>

                    <!-- Card View -->
                    <div x-show="viewMode === 'card'" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($teacherCourses as $tCourse)
                        <div class="bg-gradient-to-br from-violet-50 to-white dark:from-violet-900/20 dark:to-slate-900 rounded-xl shadow border border-violet-100 dark:border-violet-800/30 hover:shadow-md transition duration-300 overflow-hidden flex flex-col relative">
                            <div class="absolute top-3 right-3 bg-violet-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">{{ __('messages.recommendation') }}</div>

                            <div class="p-6 pt-12 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-3 gap-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-violet-600 bg-violet-50 dark:bg-violet-900/30 dark:text-violet-400 px-2 py-1 rounded truncate">
                                        {{ $tCourse->teacher->name }}
                                    </span>
                                    <span class="text-xs font-medium shrink-0 whitespace-nowrap {{ $tCourse->is_free ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $tCourse->is_free ? __('messages.free') : 'Rp ' . number_format($tCourse->price) }}
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $tCourse->title }}</h4>
                                <p class="text-xs text-gray-600 dark:text-slate-400 mb-4 line-clamp-2 flex-1">{{ $tCourse->description }}</p>

                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400 mb-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $tCourse->duration_hours }} {{ __('messages.hours') }}
                                    </span>
                                    <span class="capitalize px-2 py-1 rounded {{ $tCourse->level == 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($tCourse->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                                        {{ $tCourse->level }}
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('seeker.courses.show', ['id' => $tCourse->id]) }}?type=teacher" class="flex-1 text-center px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition text-sm font-medium">
                                        {{ __('messages.view_detail') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Table View -->
                    <div x-show="viewMode === 'table'" x-transition x-cloak class="overflow-x-auto bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl shadow-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800 text-left">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.no') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.course_name') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.teacher') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.duration') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.level') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.price') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider text-right">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-slate-800">
                                @foreach($teacherCourses as $tCourse)
                                <tr class="hover:bg-violet-50/10 dark:hover:bg-violet-900/10 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 font-medium text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $tCourse->title }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $tCourse->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-violet-600 bg-violet-50 dark:bg-violet-900/30 dark:text-violet-400 rounded">
                                            {{ $tCourse->teacher->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        {{ $tCourse->duration_hours }} {{ __('messages.hours') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="capitalize px-2.5 py-1 text-xs rounded font-semibold {{ $tCourse->level == 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($tCourse->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                                            {{ $tCourse->level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $tCourse->is_free ? 'text-green-600 dark:text-green-400' : 'text-orange-600 dark:text-orange-400' }}">
                                        {{ $tCourse->is_free ? __('messages.free') : 'Rp ' . number_format($tCourse->price) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('seeker.courses.show', ['id' => $tCourse->id]) }}?type=teacher" class="text-violet-600 dark:text-violet-400 hover:text-violet-900 dark:hover:text-violet-300 font-bold">
                                            {{ __('messages.view_detail') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Rekomendasi Asesmen -->
                @if(isset($recommendedCourses) && $recommendedCourses->count() > 0)
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg mr-3 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.recommendations_based_on_assessment') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.courses_help_improve_competencies') }}</p>
                        </div>
                    </div>

                    <!-- Card View -->
                    <div x-show="viewMode === 'card'" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recommendedCourses as $course)
                        <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl shadow border border-emerald-100 hover:shadow-md transition duration-300 overflow-hidden flex flex-col relative">
                            <div class="absolute top-3 right-3 bg-emerald-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">{{ __('messages.recommendation') }}</div>

                            <div class="p-6 pt-12 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-3 gap-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-blue-600 bg-blue-50 px-2 py-1 rounded truncate">
                                        {{ $course->platform }}
                                    </span>
                                    <span class="text-xs font-medium shrink-0 whitespace-nowrap {{ $course->is_free ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $course->is_free ? __('messages.free') : 'Rp ' . number_format($course->price) }}
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h4>
                                <p class="text-xs text-gray-600 mb-4 line-clamp-2 flex-1">{{ $course->description }}</p>

                                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $course->duration_hours }} {{ __('messages.hours') }}
                                    </span>
                                    <span class="capitalize px-2 py-1 rounded {{ $course->level == 'beginner' ? 'bg-green-100 text-green-700' : ($course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $course->level }}
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('seeker.courses.show', $course->id) }}" class="flex-1 text-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium">
                                        {{ __('messages.view_course') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Table View -->
                    <div x-show="viewMode === 'table'" x-transition x-cloak class="overflow-x-auto bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl shadow-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800 text-left">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.no') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.course_name') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.platform') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.duration') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.level') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.price') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider text-right">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-slate-800">
                                @foreach($recommendedCourses as $course)
                                <tr class="hover:bg-emerald-50/10 dark:hover:bg-emerald-900/10 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 font-medium text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $course->title }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $course->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-blue-600 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 rounded">
                                            {{ $course->platform }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        {{ $course->duration_hours }} {{ __('messages.hours') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="capitalize px-2.5 py-1 text-xs rounded font-semibold {{ $course->level == 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                                            {{ $course->level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $course->is_free ? 'text-green-600 dark:text-green-400' : 'text-orange-600 dark:text-orange-400' }}">
                                        {{ $course->is_free ? __('messages.free') : 'Rp ' . number_format($course->price) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('seeker.courses.show', $course->id) }}" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300 font-bold">
                                            {{ __('messages.view_course') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Lanjutkan Belajar -->
                @if(isset($activeProgress) && $activeProgress->count() > 0)
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg mr-3 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.continue_learning') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.continue_your_courses') }}</p>
                        </div>
                    </div>

                    <!-- Card View -->
                    <div x-show="viewMode === 'card'" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($activeProgress as $progress)
                        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 dark:border-slate-800 flex flex-col">
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">
                                        {{ $progress->course->platform }}
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $progress->course->title }}</h4>

                                <div class="mt-auto pt-4">
                                    <div class="flex justify-between text-xs text-gray-600 dark:text-slate-400 mb-1">
                                        <span>{{ __('messages.progress') }}</span>
                                        <span>{{ $progress->progress_percentage ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-4">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $progress->progress_percentage ?? 0 }}%"></div>
                                    </div>

                                    <a href="{{ route('seeker.courses.show', $progress->course_id) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                        {{ __('messages.continue_course') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Table View -->
                    <div x-show="viewMode === 'table'" x-transition x-cloak class="overflow-x-auto bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl shadow-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800 text-left">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.no') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.course_name') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.platform') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.learning_progress') }}</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider text-right">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-slate-800">
                                @foreach($activeProgress as $progress)
                                <tr class="hover:bg-blue-50/10 dark:hover:bg-blue-900/10 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 font-medium text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $progress->course->title }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $progress->course->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-blue-600 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 rounded">
                                            {{ $progress->course->platform }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400" style="width: 250px;">
                                        <div class="flex items-center gap-3">
                                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $progress->progress_percentage ?? 0 }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold shrink-0 text-blue-600 dark:text-blue-400">{{ $progress->progress_percentage ?? 0 }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('seeker.courses.show', $progress->course_id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-bold">
                                            {{ __('messages.continue') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Semua Kursus Grid (External Platforms) -->
                <div class="mb-4 flex items-center">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.external_platform_courses') }}</h3>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">Dicoding, Udemy, Coursera</span>
                    </div>
                </div>

                <!-- Card View -->
                <div x-show="viewMode === 'card'" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($courses as $course)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 dark:border-slate-800 flex flex-col">
                        <!-- Course Header -->
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>

                        <!-- Course Body -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded truncate">
                                    {{ $course->platform }}
                                </span>
                                <span class="text-xs font-medium shrink-0 whitespace-nowrap {{ $course->is_free ? 'text-emerald-600 dark:text-emerald-400' : 'text-orange-600 dark:text-orange-400' }}">
                                    {{ $course->is_free ? __('messages.free') : 'Rp ' . number_format($course->price) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-slate-400 mb-4 line-clamp-3 flex-1">{{ $course->description }}</p>

                            <!-- Course Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $course->duration_hours }} {{ __('messages.hours') }}
                                </span>
                                <span class="capitalize px-2 py-1 rounded {{ $course->level == 'beginner' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : ($course->level == 'intermediate' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400') }}">
                                    {{ $course->level }}
                                </span>
                            </div>

                            <!-- Progress Bar (Jika sudah enroll) -->
                            @if (in_array($course->id, $myProgress ?? []))
                            @php
                            $currentProgress = isset($activeProgress) ? $activeProgress->firstWhere('course_id', $course->id) : null;
                            $progressPercent = $currentProgress ? ($currentProgress->progress_percentage ?? 0) : 0;
                            @endphp
                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-gray-600 dark:text-slate-400 mb-1">
                                    <span>{{ __('messages.progress') }}</span>
                                    <span>{{ $progressPercent }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                </div>
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('seeker.courses.show', $course->id) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 dark:bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-700 transition text-sm font-medium">
                                    {{ __('messages.view_detail') }}
                                </a>
                                @if (!in_array($course->id, $myProgress ?? []))
                                <form action="{{ route('seeker.courses.enroll', $course->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 border border-blue-600 dark:border-blue-500 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/40 transition text-sm font-medium">
                                        {{ __('messages.enroll') }}
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('seeker.courses.show', $course->id) }}" class="flex-1 text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                    {{ __('messages.continue') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl shadow">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_courses_found') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_courses_available') }}</p>
                    </div>
                    @endforelse
                </div>

                <!-- Table View -->
                <div x-show="viewMode === 'table'" x-transition x-cloak class="overflow-x-auto bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl shadow-md">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800 text-left">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.no') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.course_name') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.platform') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.duration') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.level') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.price') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.progress') }}</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider text-right">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-800">
                            @forelse($courses as $course)
                            <tr class="hover:bg-blue-50/10 dark:hover:bg-blue-900/10 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 font-medium text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $course->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                    <span class="px-2.5 py-1 text-xs font-semibold text-blue-750 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 rounded">
                                        {{ $course->platform }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                    {{ $course->duration_hours }} {{ __('messages.hours') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="capitalize px-2.5 py-1 text-xs rounded font-semibold {{ $course->level == 'beginner'
                                        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                        : ($course->level == 'intermediate'
                                            ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400'
                                            : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400') }}">
                                        {{ $course->level }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $course->is_free ? 'text-emerald-600 dark:text-emerald-400' : 'text-orange-600 dark:text-orange-400' }}">
                                    {{ $course->is_free ? __('messages.free') : 'Rp ' . number_format($course->price) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400" style="width: 150px;">
                                    @if (in_array($course->id, $myProgress ?? []))
                                    @php
                                    $currentProgress = isset($activeProgress) ? $activeProgress->firstWhere('course_id', $course->id) : null;
                                    $progressPercent = $currentProgress ? ($currentProgress->progress_percentage ?? 0) : 0;
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5">
                                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-green-600 dark:text-green-400">{{ $progressPercent }}%</span>
                                    </div>
                                    @else
                                    <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('seeker.courses.show', $course->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-bold">
                                            {{ __('messages.detail') }}
                                        </a>
                                        @if (!in_array($course->id, $myProgress ?? []))
                                        <form action="{{ route('seeker.courses.enroll', $course->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300 font-bold focus:outline-none">
                                                {{ __('messages.enroll') }}
                                            </button>
                                        </form>
                                        @else
                                        <a href="{{ route('seeker.courses.show', $course->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 font-bold">
                                            {{ __('messages.continue') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-slate-400">
                                    {{ __('messages.no_courses_available') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mb-6"></div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
