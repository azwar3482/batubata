<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('teacher.classes.show', $class) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; {{ __('messages.back_to_classes') }}</a>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.edit_class') }}</h2>
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

            <form action="{{ route('teacher.classes.update', $class) }}" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.class_name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $class->name) }}" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.description') }}</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">{{ old('description', $class->description) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.start_date') }}</label>
                                <input type="date" name="start_date" value="{{ old('start_date', $class->start_date?->format('Y-m-d')) }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.end_date') }}</label>
                                <input type="date" name="end_date" value="{{ old('end_date', $class->end_date?->format('Y-m-d')) }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.max_students') }}</label>
                                <input type="number" name="max_students" value="{{ old('max_students', $class->max_students) }}" min="1" max="500" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.status') }}</label>
                                <select name="status" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">
                                    <option value="active" {{ old('status', $class->status) === 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                    <option value="completed" {{ old('status', $class->status) === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                                    <option value="archived" {{ old('status', $class->status) === 'archived' ? 'selected' : '' }}>{{ __('messages.archived') }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.meeting_link') }}</label>
                            <input type="url" name="meeting_link" value="{{ old('meeting_link', $class->meeting_link) }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.class_schedule') }}</label>
                            <textarea name="schedule_info" rows="2" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm">{{ old('schedule_info', $class->schedule_info) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('teacher.classes.show', $class) }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">{{ __('messages.cancel') }}</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">{{ __('messages.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
