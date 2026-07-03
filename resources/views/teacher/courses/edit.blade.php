<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ __('messages.edit_course') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Lakukan penyesuaian detail informasi kursus di bawah ini.</p>
                </div>
                <a href="{{ route('teacher.courses.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-200 shrink-0">
                    &larr; {{ __('messages.back_to_courses') }}
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

            <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Form Inputs (2/3) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Basic Information Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.basic_information') }}</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.course_title') }}</label>
                                    <input type="text" name="title" value="{{ old('title', $course->title) }}" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.description') }}</label>
                                    <textarea name="description" rows="4" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">{{ old('description', $course->description) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.learning_objectives') }}</label>
                                    <textarea name="objectives" rows="3" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">{{ old('objectives', $course->objectives) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Course Settings Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.course_settings') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.related_competency') }}</label>
                                    <select name="competency_id" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                        <option value="">{{ __('messages.select_competency') }}</option>
                                        @foreach($competencies as $comp)
                                        <option value="{{ $comp->id }}" {{ old('competency_id', $course->competency_id) == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.category') }}</label>
                                    <select name="category" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                        <option value="technical" {{ old('category', $course->category) === 'technical' ? 'selected' : '' }}>{{ __('messages.technical') }}</option>
                                        <option value="soft_skill" {{ old('category', $course->category) === 'soft_skill' ? 'selected' : '' }}>{{ __('messages.soft_skill') }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.level') }}</label>
                                    <select name="level" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                        <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>{{ __('messages.beginner') }}</option>
                                        <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>{{ __('messages.intermediate') }}</option>
                                        <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>{{ __('messages.advanced') }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.duration_hours') }}</label>
                                    <input type="number" name="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" min="1" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.max_students_per_class') }}</label>
                                    <input type="number" name="max_students" value="{{ old('max_students', $course->max_students) }}" min="0" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.tags') }}</label>
                                    <input type="text" name="tags" value="{{ old('tags', $course->tags ? implode(', ', $course->tags) : '') }}" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Media, Price & Actions (1/3) -->
                    <div class="lg:col-span-1 space-y-6">
                        
                        <!-- Price and Thumbnail Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.price_and_thumbnail') }}</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="flex items-center gap-2 mb-2">
                                        <input type="checkbox" name="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-slate-300">{{ __('messages.free') }}</span>
                                    </label>
                                    <input type="number" name="price" value="{{ old('price', $course->price) }}" min="0" step="1000" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.thumbnail') }}</label>
                                    @if($course->thumbnail_path)
                                    <div class="mb-3 relative group overflow-hidden rounded-xl border border-gray-100 dark:border-slate-700">
                                        <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="Thumbnail" class="w-full h-32 object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                    </div>
                                    @endif
                                    <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl p-2 text-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                </div>
                            </div>
                        </div>

                        <!-- Sticky Action Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-6 space-y-4">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-slate-700/50">Aksi Pembaharuan</h3>
                            
                            <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-center">
                                {{ __('messages.update_course') }}
                            </button>
                            
                            <a href="{{ route('teacher.courses.index') }}" class="block w-full py-3 px-4 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-xl font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700/50 transition duration-200 text-center">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
