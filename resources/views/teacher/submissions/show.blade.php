<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Detail Pengiriman Tugas</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Periksa jawaban siswa dan berikan penilaian yang sesuai.</p>
                </div>
                <a href="{{ route('teacher.submissions.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-200 shrink-0">
                    &larr; {{ __('messages.back_to_submissions') }}
                </a>
            </div>

            @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 rounded-xl">
                <p class="text-sm text-green-700 dark:text-green-300 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Submission Content (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Detail Pengiriman -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.submission_detail') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">{{ __('messages.student') }}</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $submission->enrollment->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">{{ __('messages.class') }}</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $submission->enrollment->classRoom->name }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">{{ __('messages.assignment') }}</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $submission->material->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.module') }}: {{ $submission->material->module->title }} &middot; {{ $submission->material->module->course->title }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">{{ __('messages.submission_date') }}</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Text Answer -->
                    @if($submission->content)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.text_answer') }}</h3>
                        <div class="prose dark:prose-invert max-w-none text-sm text-gray-700 dark:text-slate-300 leading-relaxed">
                            {!! nl2br(e($submission->content)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Attached File -->
                    @if($submission->file_path)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.attached_file') }}</h3>
                        <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-grow min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $submission->file_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $submission->file_size ? number_format($submission->file_size / 1024, 1) . ' KB' : '' }}</p>
                            </div>
                            <!-- download link -->
                            <a href="{{ asset('storage/' . $submission->file_path) }}" download class="inline-flex items-center justify-center p-2 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Previous Feedback -->
                    @if($submission->feedback)
                    <div class="bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl border border-blue-200/50 dark:border-blue-800/30 p-6">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-200 mb-3 border-b pb-2 border-blue-200/50 dark:border-blue-800/30">{{ __('messages.previous_feedback') }}</h3>
                        <p class="text-sm text-blue-800 dark:text-blue-300 leading-relaxed">{!! nl2br(e($submission->feedback)) !!}</p>
                        @if($submission->score)
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-sm font-semibold text-blue-700 dark:text-blue-400">{{ __('messages.score') }}:</span>
                            <span class="px-2.5 py-0.5 rounded-full text-sm font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">{{ $submission->score }}/100</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Right Column: Grading Form (1/3) -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">{{ __('messages.give_grade') }}</h3>
                        
                        <form action="{{ route('teacher.submissions.grade', $submission) }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.score_0_100') }}</label>
                                <input type="number" name="score" value="{{ old('score', $submission->score) }}" min="0" max="100" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.feedback') }}</label>
                                <textarea name="feedback" rows="4" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200" placeholder="{{ __('messages.feedback_placeholder') }}">{{ old('feedback', $submission->feedback) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">{{ __('messages.status') }}</label>
                                <select name="status" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                    <option value="graded" {{ $submission->status === 'graded' ? 'selected' : '' }}>{{ __('messages.graded_pass') }}</option>
                                    <option value="revision" {{ $submission->status === 'revision' ? 'selected' : '' }}>{{ __('messages.needs_revision') }}</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-center">
                                {{ __('messages.save_grade') }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
