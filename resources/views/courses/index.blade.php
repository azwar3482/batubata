<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Kursus & Pembelajaran</h2>
                <p class="mt-2 text-gray-600">Tingkatkan kompetensi Anda dengan kursus yang direkomendasikan.</p>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="technical">Teknis</option>
                            <option value="soft_skill">Soft Skill</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                        <select
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Level</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                        <select
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Platform</option>
                            <option value="Coursera">Coursera</option>
                            <option value="Dicoding">Dicoding</option>
                            <option value="Udemy">Udemy</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi Asesmen -->
            @if(isset($recommendedCourses) && $recommendedCourses->count() > 0)
            <div class="mb-10">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg mr-3 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Rekomendasi Berdasarkan Asesmen Anda</h3>
                        <p class="text-sm text-gray-500">Kursus berikut dapat membantu meningkatkan kompetensi yang masih kurang.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recommendedCourses as $course)
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl shadow border border-emerald-100 hover:shadow-md transition duration-300 overflow-hidden flex flex-col relative">
                        <div class="absolute top-3 right-3 bg-emerald-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">Rekomendasi</div>

                        <div class="p-6 pt-12 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-3 gap-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-blue-600 bg-blue-50 px-2 py-1 rounded truncate">
                                    {{ $course->platform }}
                                </span>
                                <span class="text-xs font-medium shrink-0 whitespace-nowrap {{ $course->is_free ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $course->is_free ? 'Gratis' : 'Rp ' . number_format($course->price) }}
                                </span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h4>
                            <p class="text-xs text-gray-600 mb-4 line-clamp-2 flex-1">{{ $course->description }}</p>

                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $course->duration_hours }} Jam
                                </span>
                                <span class="capitalize px-2 py-1 rounded {{ $course->level == 'beginner' ? 'bg-green-100 text-green-700' : ($course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $course->level }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('seeker.courses.show', $course->id) }}" class="flex-1 text-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium">
                                    Lihat Kursus
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Lanjutkan Belajar -->
            @if(isset($activeProgress) && $activeProgress->count() > 0)
            <div class="mb-10">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg mr-3 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Lanjutkan Belajar</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400">Teruskan kursus yang sedang Anda ikuti.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeProgress as $progress)
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 dark:border-slate-800 flex flex-col">
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">
                                    {{ $progress->course->platform }}
                                </span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $progress->course->title }}</h4>

                            <div class="mt-auto pt-4">
                                <div class="flex justify-between text-xs text-gray-600 dark:text-slate-400 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $progress->progress_percentage ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-4">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $progress->progress_percentage ?? 0 }}%"></div>
                                </div>

                                <a href="{{ route('seeker.courses.show', $progress->course_id) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    Lanjutkan Kursus
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Semua Kursus Grid -->
            <div class="mb-4 flex items-center">
                <h3 class="text-xl font-bold text-gray-900">Semua Kursus</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                <div
                    class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <!-- Course Header -->
                    <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-80" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>

                    <!-- Course Body -->
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <span
                                class="text-xs font-semibold uppercase tracking-wide text-blue-600 bg-blue-50 px-2 py-1 rounded truncate">
                                {{ $course->platform }}
                            </span>
                            <span
                                class="text-xs font-medium shrink-0 whitespace-nowrap {{ $course->is_free ? 'text-green-600' : 'text-orange-600' }}">
                                {{ $course->is_free ? 'Gratis' : 'Rp ' . number_format($course->price) }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3 flex-1">{{ $course->description }}</p>

                        <!-- Course Meta -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $course->duration_hours }} Jam
                            </span>
                            <span
                                class="capitalize px-2 py-1 rounded {{ $course->level == 'beginner'
                                        ? 'bg-green-100 text-green-700'
                                        : ($course->level == 'intermediate'
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-red-100 text-red-700') }}">
                                {{ $course->level }}
                            </span>
                        </div>

                        <!-- Progress Bar (Jika sudah enroll) -->
                        @if (in_array($course->id, $myProgress ?? []))
                        @php
                        $currentProgress = isset($activeProgress) ? $activeProgress->firstWhere('course_id', $course->id) : null;
                        $progressPercent = $currentProgress ? ($currentProgress->progress_percentage ?? 0) : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-600 dark:text-slate-400 mb-1">
                                <span>Progress</span>
                                <span>{{ $progressPercent }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('seeker.courses.show', $course->id) }}"
                                class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Lihat Detail
                            </a>
                            @if (!in_array($course->id, $myProgress ?? []))
                            <form action="{{ route('seeker.courses.enroll', $course->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm font-medium">
                                    Enroll
                                </button>
                            </form>
                            @else
                            <a href="{{ route('seeker.courses.show', $course->id) }}"
                                class="flex-1 text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                Lanjutkan
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kursus</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada kursus yang tersedia saat ini.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>