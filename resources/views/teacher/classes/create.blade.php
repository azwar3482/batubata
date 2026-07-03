<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ __('messages.open_new_class') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Buat kelas baru agar siswa dapat bergabung dan memulai proses pembelajaran.</p>
                </div>
                <a href="{{ route('teacher.classes.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-200 shrink-0">
                    &larr; {{ __('messages.back_to_classes') }}
                </a>
            </div>

            @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-xl">
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($courses->isEmpty())
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-dashed border-gray-200 dark:border-slate-700 p-12 text-center shadow-sm">
                <div class="w-16 h-16 bg-yellow-50 dark:bg-yellow-950/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Belum Ada Kursus yang Diterbitkan</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 max-w-md mx-auto mb-6">{{ __('messages.no_published_courses') }}</p>
                <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition shadow-md">
                    {{ __('messages.create_course') }} &rarr;
                </a>
            </div>
            @else
            <form action="{{ route('teacher.classes.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: inputs (2/3) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Class Information -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.class_information') }}</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.course') }}</label>
                                    <select name="course_id" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                        <option value="">{{ __('messages.select_course') }}</option>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.class_name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200" placeholder="{{ __('messages.class_name_placeholder') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.description') }}</label>
                                    <textarea name="description" rows="3" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200" placeholder="{{ __('messages.class_description_placeholder') }}">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Class Settings -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.settings') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.start_date') }}</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.end_date') }}</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.max_students') }}</label>
                                    <input type="number" name="max_students" value="{{ old('max_students', 30) }}" min="1" max="500" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.meeting_link') }}</label>
                                    <input type="url" name="meeting_link" value="{{ old('meeting_link') }}" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200" placeholder="https://meet.google.com/...">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.class_schedule') }}</label>
                                    <textarea name="schedule_info" rows="2" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200" placeholder="{{ __('messages.class_schedule_placeholder') }}">{{ old('schedule_info') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Actions (1/3) -->
                    <div class="lg:col-span-1">
                        <!-- Sticky Action Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-6 space-y-4">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-slate-700/50">Aksi Publikasi</h3>
                            
                            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-center">
                                {{ __('messages.open_class') }}
                            </button>
                            
                            <a href="{{ route('teacher.classes.index') }}" class="block w-full py-3 px-4 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-xl font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700/50 transition duration-200 text-center">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </div>

                </div>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>
