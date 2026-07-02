<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('teacher.classes.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; {{ __('messages.back_to_classes') }}</a>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.open_new_class') }}</h2>
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($courses->isEmpty())
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
                <p class="text-yellow-700 dark:text-yellow-300">{{ __('messages.no_published_courses') }} <a href="{{ route('teacher.courses.create') }}" class="underline font-medium">{{ __('messages.create_course') }}</a> {{ __('messages.first') }}</p>
            </div>
            @else
            <form action="{{ route('teacher.classes.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.class_information') }}</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.course') }}</label>
                            <select name="course_id" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('messages.select_course') }}</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.class_name') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.class_name_placeholder') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.description') }}</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.class_description_placeholder') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.settings') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.start_date') }}</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.end_date') }}</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.max_students') }}</label>
                            <input type="number" name="max_students" value="{{ old('max_students', 30) }}" min="1" max="500" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.meeting_link') }}</label>
                            <input type="url" name="meeting_link" value="{{ old('meeting_link') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://meet.google.com/...">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.class_schedule') }}</label>
                            <textarea name="schedule_info" rows="2" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.class_schedule_placeholder') }}">{{ old('schedule_info') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('teacher.classes.index') }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">{{ __('messages.cancel') }}</a>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">{{ __('messages.open_class') }}</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>
