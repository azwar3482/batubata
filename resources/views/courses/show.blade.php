<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.dashboard') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.courses') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ __('messages.course_detail') }}</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.course_detail') }}</h2>
                <a href="{{ route('seeker.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; {{ __('messages.back') }}
                </a>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
            @endif

            <!-- Course Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 mb-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">{{ $course->platform }}</span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs capitalize">{{ $course->level }}</span>
                            @if($course->is_free)
                            <span class="px-3 py-1 bg-green-500/30 rounded-full text-xs font-bold">{{ __('messages.free') }}</span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-extrabold mb-3">{{ $course->title }}</h1>
                        <p class="text-blue-100 mb-4">{{ Str::limit(strip_tags($course->description), 200) }}</p>
                        <div class="flex items-center gap-6 text-sm text-blue-100">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $course->duration_hours }} {{ __('messages.hours') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                {{ $course->chapters->count() }} {{ __('messages.chapters') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                {{ $course->total_materials }} {{ __('messages.materials') }}
                            </span>
                            @if($course->competency)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                                {{ $course->competency->name }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        @if($course->is_free)
                        <span class="text-3xl font-bold text-green-300">{{ __('messages.free') }}</span>
                        @else
                        <span class="text-3xl font-bold">Rp {{ number_format($course->price) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Description -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('messages.course_description') }}</h2>
                        <div class="text-gray-700 dark:text-slate-300 text-sm leading-relaxed prose dark:prose-invert max-w-none">
                            {!! $course->description !!}
                        </div>
                    </div>

                    <!-- Curriculum -->
                    @if($course->chapters->count() > 0)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.course_curriculum') }}</h2>
                        <div class="space-y-4">
                            @foreach($course->chapters as $chapter)
                            <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="border border-gray-200 dark:border-slate-700 rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50" @click="open = !open">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">{{ $chapter->order_number }}</span>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $chapter->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ $chapter->materials->count() }} {{ __('messages.materials') }} @if($chapter->duration_minutes) &middot; {{ $chapter->duration_minutes }} {{ __('messages.minutes') }} @endif</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                                <div x-show="open" x-transition class="border-t border-gray-200 dark:border-slate-700 p-4 space-y-2">
                                    @foreach($chapter->materials as $material)
                                    <div class="flex items-center justify-between py-2 px-3 rounded-lg {{ in_array($material->id, $completedMaterialIds ?? []) ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 {{ in_array($material->id, $completedMaterialIds ?? []) ? 'text-green-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if(in_array($material->id, $completedMaterialIds ?? []))
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $material->type_icon }}" />
                                                @endif
                                            </svg>
                                            <div>
                                                <span class="text-sm text-gray-700 dark:text-slate-300 {{ in_array($material->id, $completedMaterialIds ?? []) ? 'line-through text-gray-400' : '' }}">{{ $material->title }}</span>
                                                <span class="ml-2 text-xs text-gray-400 capitalize">
                                                    @if($material->type === 'video') {{ __('messages.video') }}
                                                    @elseif($material->type === 'document') {{ __('messages.document') }}
                                                    @elseif($material->type === 'link') {{ __('messages.link') }}
                                                    @elseif($material->type === 'text') {{ __('messages.text') }}
                                                    @elseif($material->type === 'embed') {{ __('messages.embed') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        @if(in_array($material->id, $completedMaterialIds ?? []))
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">{{ __('messages.completed') }}</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Progress Section -->
                    @if($progress)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.learning_progress') }}</h2>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-slate-400 mb-2">
                                <span>{{ $progress->status === 'completed' ? __('messages.completed') : ($progress->status === 'in_progress' ? __('messages.learning') : __('messages.not_started')) }}</span>
                                <span class="font-bold">{{ $progress->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progress->progress_percentage }}%"></div>
                            </div>
                        </div>

                        @if($progress->status === 'completed')
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div>
                                <p class="text-green-800 dark:text-green-400 font-bold text-sm">{{ __('messages.congratulations_completed') }}</p>
                                <p class="text-green-600 dark:text-green-500 text-xs mt-0.5">{{ __('messages.certificate_issued') }}</p>
                            </div>
                            <a href="{{ route('courses.platform-certificate', $progress->id) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-lg transition shadow hover:shadow-md text-xs font-bold shrink-0">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                                {{ __('messages.view_certificate') }}
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Enroll Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <div class="text-center mb-4">
                            @if($course->is_free)
                            <span class="text-3xl font-bold text-green-600 dark:text-green-400">{{ __('messages.free') }}</span>
                            @else
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($course->price) }}</span>
                            @endif
                        </div>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.duration') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->duration_hours }} {{ __('messages.hours') }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.level') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $course->level }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.chapters') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->chapters->count() }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.materials') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->total_materials }}</span>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            @if($progress)
                            <a href="{{ route('seeker.courses.learn', $course->id) }}"
                                class="block w-full text-center px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg transition font-medium shadow-lg">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $progress->status === 'completed' ? __('messages.relearn') : __('messages.continue_learning') }}
                            </a>
                            @else
                            <form action="{{ route('seeker.courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg transition font-medium shadow-lg">
                                    {{ $course->is_free ? __('messages.start_free_learning') : __('messages.register_course') }}
                                </button>
                            </form>
                            @endif

                            @if($course->url)
                            <a href="{{ $course->url }}" target="_blank"
                                class="block w-full text-center px-4 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                {{ __('messages.visit_platform') }}
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.course_info') }}</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.platform') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->platform }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.category') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->category === 'technical' ? __('messages.technical') : __('messages.soft_skill') }}</span>
                            </div>
                            @if($course->competency)
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.competency') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->competency->name }}</span>
                            </div>
                            @endif
                            @if($course->rating)
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.rating') }}</span>
                                <span class="font-medium text-yellow-600 dark:text-yellow-400">{{ number_format($course->rating, 1) }} / 5.0</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
