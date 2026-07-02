<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('teacher.courses.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; {{ __('messages.back_to_courses') }}</a>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.create_new_course') }}</h2>
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

            <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.basic_information') }}</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.course_title') }}</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.course_title_placeholder') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.description') }}</label>
                            <textarea name="description" rows="4" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.course_description_placeholder') }}">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.learning_objectives') }}</label>
                            <textarea name="objectives" rows="3" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.learning_objectives_placeholder') }}">{{ old('objectives') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.course_settings') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.related_competency') }}</label>
                            <select name="competency_id" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('messages.select_competency') }}</option>
                                @foreach($competencies as $comp)
                                <option value="{{ $comp->id }}" {{ old('competency_id') == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.category') }}</label>
                            <select name="category" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>{{ __('messages.technical') }}</option>
                                <option value="soft_skill" {{ old('category') === 'soft_skill' ? 'selected' : '' }}>{{ __('messages.soft_skill') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.level') }}</label>
                            <select name="level" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="beginner" {{ old('level') === 'beginner' ? 'selected' : '' }}>{{ __('messages.beginner') }}</option>
                                <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>{{ __('messages.intermediate') }}</option>
                                <option value="advanced" {{ old('level') === 'advanced' ? 'selected' : '' }}>{{ __('messages.advanced') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.duration_hours') }}</label>
                            <input type="number" name="duration_hours" value="{{ old('duration_hours', 1) }}" min="1" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.max_students_per_class') }}</label>
                            <input type="number" name="max_students" value="{{ old('max_students', 30) }}" min="0" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.unlimited_placeholder') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.tags_comma_separated') }}</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="web, php, laravel">
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.price_and_thumbnail') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center gap-2 mb-2">
                                <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : 'checked' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('messages.free') }}</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="1000" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.price_placeholder') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.thumbnail') }}</label>
                            <input type="file" name="thumbnail" accept="image/*" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('teacher.courses.index') }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">{{ __('messages.cancel') }}</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">{{ __('messages.save_as_draft') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
