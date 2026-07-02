<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.submission_grading') }}</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">{{ __('messages.submission_grading_desc') }}</p>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 mb-6 border border-gray-100 dark:border-slate-700">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.status') }}</label>
                        <select name="status" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm text-sm">
                            <option value="">{{ __('messages.all_status') }}</option>
                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>{{ __('messages.waiting') }}</option>
                            <option value="graded" {{ request('status') === 'graded' ? 'selected' : '' }}>{{ __('messages.graded') }}</option>
                            <option value="revision" {{ request('status') === 'revision' ? 'selected' : '' }}>{{ __('messages.revision') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">{{ __('messages.class') }}</label>
                        <select name="class_id" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm text-sm">
                            <option value="">{{ __('messages.all_classes') }}</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">{{ __('messages.filter') }}</button>
                    </div>
                </form>
            </div>

            <!-- Submissions List -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-slate-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase w-12">{{ __('messages.no') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.student') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.assignment') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.class') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.score') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.date') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($submissions as $submission)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $loop->iteration + ($submissions->firstItem() ?: 1) - 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $submission->enrollment->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">{{ $submission->material->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">{{ $submission->enrollment->classRoom->name }}</td>
                                <td class="px-6 py-4">
                                    @if($submission->status === 'submitted')
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">{{ __('messages.waiting') }}</span>
                                    @elseif($submission->status === 'graded')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('messages.graded') }}</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ __('messages.revision') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $submission->score ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('teacher.submissions.show', $submission) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">{{ __('messages.detail') }}</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">{{ __('messages.no_submissions_found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($submissions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                    {{ $submissions->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
