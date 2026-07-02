<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('teacher.classes.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; {{ __('messages.back_to_classes') }}</a>
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

            <!-- Class Header -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 mb-8">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-2 py-1 text-xs rounded-full {{ $class->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }}">{{ ucfirst($class->status) }}</span>
                                <span class="text-xs text-gray-500 dark:text-slate-400 font-mono">{{ __('messages.code') }}: {{ $class->code }}</span>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $class->name }}</h1>
                            <p class="mt-1 text-gray-600 dark:text-slate-400">{{ __('messages.course') }}: <a href="{{ route('teacher.courses.show', $class->course) }}" class="text-blue-600 hover:underline dark:text-blue-400">{{ $class->course->title }}</a></p>
                            @if($class->schedule_info)
                            <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">{{ $class->schedule_info }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $class->enrollments->where('status', 'active')->count() }}/{{ $class->max_students }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ __('messages.students_enrolled') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Students List -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700">
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('messages.student_list') }}</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-900/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.student') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.progress') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.status') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.score') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @forelse($class->enrollments as $enrollment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50" x-data="{ showStatus: false }">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $enrollment->user->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-slate-400">{{ $enrollment->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-20 bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-slate-400">{{ $enrollment->progress_percentage }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($enrollment->status === 'active')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('messages.active') }}</span>
                                            @elseif($enrollment->status === 'completed')
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ __('messages.completed') }}</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ __('messages.dropped') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $enrollment->final_score ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <button @click="showStatus = !showStatus" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">{{ __('messages.manage') }}</button>
                                            <div x-show="showStatus" x-transition class="absolute right-4 mt-2 p-4 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg z-10 w-72">
                                                <form action="{{ route('teacher.classes.update-student', $enrollment) }}" method="POST" class="space-y-3">
                                                    @csrf @method('PUT')
                                                    <select name="status" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                        <option value="active" {{ $enrollment->status === 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                                        <option value="completed" {{ $enrollment->status === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                                                        <option value="dropped" {{ $enrollment->status === 'dropped' ? 'selected' : '' }}>{{ __('messages.dropped') }}</option>
                                                    </select>
                                                    <input type="number" name="final_score" value="{{ $enrollment->final_score }}" placeholder="{{ __('messages.score_0_100') }}" min="0" max="100" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                    <textarea name="notes" rows="2" placeholder="{{ __('messages.notes_placeholder') }}" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">{{ $enrollment->notes }}</textarea>
                                                    <button type="submit" class="w-full px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">{{ __('messages.save') }}</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">{{ __('messages.no_students_enrolled') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Enroll Student -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.add_student') }}</h3>
                        <form action="{{ route('teacher.classes.enroll-student', $class) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="email" name="email" placeholder="{{ __('messages.student_email_placeholder') }}" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm">{{ __('messages.register') }}</button>
                        </form>
                    </div>

                    <!-- Class Info -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.class_info') }}</h3>
                        <div class="space-y-3 text-sm">
                            @if($class->start_date)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.start') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $class->start_date->format('d M Y') }}</span>
                            </div>
                            @endif
                            @if($class->end_date)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.end') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $class->end_date->format('d M Y') }}</span>
                            </div>
                            @endif
                            @if($class->meeting_link)
                            <div>
                                <span class="text-gray-500 dark:text-slate-400">{{ __('messages.meeting') }}:</span>
                                <a href="{{ $class->meeting_link }}" target="_blank" class="block text-blue-600 hover:underline dark:text-blue-400 text-xs mt-1 truncate">{{ $class->meeting_link }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
