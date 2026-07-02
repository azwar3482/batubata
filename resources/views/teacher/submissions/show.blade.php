<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('teacher.submissions.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; {{ __('messages.back_to_submissions') }}</a>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Submission Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.submission_detail') }}</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.student') }}</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $submission->enrollment->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.assignment') }}</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $submission->material->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">{{ __('messages.module') }}: {{ $submission->material->module->title }} &middot; {{ $submission->material->module->course->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.class') }}</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $submission->enrollment->classRoom->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('messages.submission_date') }}</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($submission->content)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('messages.text_answer') }}</h3>
                        <div class="prose dark:prose-invert max-w-none text-sm text-gray-700 dark:text-slate-300">{!! nl2br(e($submission->content)) !!}</div>
                    </div>
                    @endif

                    @if($submission->file_path)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('messages.attached_file') }}</h3>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-900 rounded-lg">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $submission->file_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">{{ $submission->file_size ? number_format($submission->file_size / 1024, 1) . ' KB' : '' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Previous Feedback -->
                    @if($submission->feedback)
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-200 mb-2">{{ __('messages.previous_feedback') }}</h3>
                        <p class="text-sm text-blue-800 dark:text-blue-300">{!! nl2br(e($submission->feedback)) !!}</p>
                        @if($submission->score)
                        <p class="mt-2 text-sm font-bold text-blue-900 dark:text-blue-200">{{ __('messages.score') }}: {{ $submission->score }}/100</p>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Grading Form -->
                <div>
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6 sticky top-8">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.give_grade') }}</h3>
                        <form action="{{ route('teacher.submissions.grade', $submission) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.score_0_100') }}</label>
                                <input type="number" name="score" value="{{ old('score', $submission->score) }}" min="0" max="100" required class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.feedback') }}</label>
                                <textarea name="feedback" rows="4" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('messages.feedback_placeholder') }}">{{ old('feedback', $submission->feedback) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.status') }}</label>
                                <select name="status" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="graded" {{ $submission->status === 'graded' ? 'selected' : '' }}>{{ __('messages.graded_pass') }}</option>
                                    <option value="revision" {{ $submission->status === 'revision' ? 'selected' : '' }}>{{ __('messages.needs_revision') }}</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">{{ __('messages.save_grade') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
