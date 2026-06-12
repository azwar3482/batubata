<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('seeker.courses.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; Kembali ke Kursus</a>
            </div>

            <!-- Course Header -->
            <div class="bg-gradient-to-r from-violet-600 to-indigo-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Kursus Pengajar</span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs capitalize">{{ $course->level }}</span>
                        </div>
                        <h1 class="text-3xl font-extrabold mb-3">{{ $course->title }}</h1>
                        <p class="text-violet-100 mb-4">{{ $course->description }}</p>
                        <div class="flex items-center gap-6 text-sm text-violet-100">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                {{ $course->teacher->name }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $course->duration_hours }} Jam
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                {{ $course->modules->count() }} Modul
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($course->is_free)
                        <span class="text-2xl font-bold text-green-300">Gratis</span>
                        @else
                        <span class="text-2xl font-bold">Rp {{ number_format($course->price) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Objectives -->
                    @if($course->objectives)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Tujuan Pembelajaran</h2>
                        <p class="text-gray-700 dark:text-slate-300 text-sm leading-relaxed">{{ $course->objectives }}</p>
                    </div>
                    @endif

                    <!-- Modules -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Kurikulum Kursus</h2>
                        <div class="space-y-4">
                            @foreach($course->modules as $module)
                            <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="border border-gray-200 dark:border-slate-700 rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50" @click="open = !open">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-lg flex items-center justify-center text-sm font-bold">{{ $module->order_number }}</span>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $module->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ $module->materials->count() }} materi &middot; {{ $module->duration_minutes }} menit</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                                <div x-show="open" x-transition class="border-t border-gray-200 dark:border-slate-700 p-4 space-y-2">
                                    @foreach($module->materials as $material)
                                    <div class="flex items-center gap-3 py-2 text-sm text-gray-700 dark:text-slate-300">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $material->type_icon }}" /></svg>
                                        <span>{{ $material->title }}</span>
                                        <span class="ml-auto text-xs text-gray-400 capitalize">{{ $material->type }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Enroll Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <div class="text-center mb-4">
                            @if($course->is_free)
                            <span class="text-3xl font-bold text-green-600 dark:text-green-400">Gratis</span>
                            @else
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($course->price) }}</span>
                            @endif
                        </div>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">Durasi</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->duration_hours }} jam</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">Level</span>
                                <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $course->level }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-slate-400">Modul</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->modules->count() }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 dark:text-slate-400">Kelas Tersedia</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->classes->where('status', 'active')->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Info -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tentang Pengajar</h3>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-tr from-violet-600 to-indigo-600 text-white rounded-xl flex items-center justify-center font-bold">
                                {{ substr($course->teacher->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $course->teacher->name }}</p>
                                @if($course->teacher->teacherProfile)
                                <p class="text-xs text-gray-500 dark:text-slate-400">{{ $course->teacher->teacherProfile->qualification }}</p>
                                @endif
                            </div>
                        </div>
                        @if($course->teacher->teacherProfile)
                        <p class="text-sm text-gray-600 dark:text-slate-400 mb-3">{{ Str::limit($course->teacher->teacherProfile->bio, 150) }}</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach(($course->teacher->teacherProfile->expertise_areas ?? []) as $area)
                            <span class="px-2 py-0.5 bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded text-xs">{{ $area }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
