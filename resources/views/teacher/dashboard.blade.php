<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Dashboard Pengajar</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">Selamat datang, {{ Auth::user()->name }}. Kelola kursus dan kelas Anda.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Kursus</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCourses }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400">{{ $publishedCourses }} dipublikasikan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Kelas Aktif</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeClasses }}</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500">dari {{ $totalClasses }} total kelas</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Siswa</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalStudents }}</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500">siswa aktif</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Tugas Pending</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingSubmissions }}</p>
                            <p class="text-xs text-amber-600 dark:text-amber-400">perlu dinilai</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Courses -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-100 dark:border-slate-700">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Kursus Terbaru</h3>
                        <a href="{{ route('teacher.courses.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        @forelse($recentCourses as $course)
                        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-slate-700' : '' }}">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">{{ $course->modules_count }} modul &middot; {{ ucfirst($course->level) }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $course->status === 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 dark:text-slate-400 text-center py-4">Belum ada kursus.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Classes -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-100 dark:border-slate-700">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Kelas Terbaru</h3>
                        <a href="{{ route('teacher.classes.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        @forelse($recentClasses as $class)
                        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-slate-700' : '' }}">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $class->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">{{ $class->course->title }} &middot; {{ $class->enrollments_count }} siswa</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $class->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }}">
                                {{ ucfirst($class->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 dark:text-slate-400 text-center py-4">Belum ada kelas.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pending Submissions -->
            @if($recentSubmissions->count() > 0)
            <div class="mt-8 bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 border border-gray-100 dark:border-slate-700">
                <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tugas Menunggu Penilaian</h3>
                    <a href="{{ route('teacher.submissions.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Materi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($recentSubmissions as $submission)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $submission->enrollment->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">{{ $submission->material->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">{{ $submission->enrollment->classRoom->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $submission->submitted_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('teacher.submissions.show', $submission) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Nilai</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('teacher.courses.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 text-white hover:from-blue-700 hover:to-indigo-700 transition">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <h4 class="text-lg font-bold">Buat Kursus Baru</h4>
                    <p class="text-sm text-blue-100 mt-1">Tambahkan kursus dengan modul dan materi pembelajaran.</p>
                </a>

                <a href="{{ route('teacher.classes.create') }}" class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 text-white hover:from-emerald-700 hover:to-teal-700 transition">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h4 class="text-lg font-bold">Buka Kelas Baru</h4>
                    <p class="text-sm text-emerald-100 mt-1">Buat kelas dari kursus yang sudah dipublikasikan.</p>
                </a>

                <a href="{{ route('teacher.submissions.index') }}" class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50 p-6 text-white hover:from-amber-700 hover:to-orange-700 transition">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <h4 class="text-lg font-bold">Nilai Tugas</h4>
                    <p class="text-sm text-amber-100 mt-1">{{ $pendingSubmissions }} tugas menunggu penilaian Anda.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
