<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('education.dashboard') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 text-sm">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <a href="{{ route('education.courses.index') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 ml-1 md:ml-2 text-sm">
                                    Kelola Kursus
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-900 dark:text-white ml-1 md:ml-2 text-sm font-medium">{{ Str::limit($course->title, 40) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Course Header -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 mb-8">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                @if($course->status === 'published')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Published</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300">Draft</span>
                                @endif
                                <span class="px-2 py-1 text-xs rounded-full {{ $course->level === 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($course->level === 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">{{ ucfirst($course->level) }}</span>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->title }}</h1>
                            <p class="mt-2 text-gray-600 dark:text-slate-400">{{ $course->description }}</p>
                            <div class="mt-4 flex items-center gap-6 text-sm text-gray-500 dark:text-slate-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $course->duration_hours }} jam
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    {{ $course->modules->count() }} modul
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    {{ $course->classes->count() }} kelas
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('education.courses.edit', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Edit
                            </a>
                            @if($course->status === 'draft')
                            <form action="{{ route('education.courses.publish', $course) }}" method="POST">
                                @csrf
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">Publikasikan</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Modules & Materials -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700">
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Modul & Materi
                            </h3>
                        </div>
                        <div class="p-6">
                            @forelse($course->modules as $module)
                            <div class="mb-6 last:mb-0" x-data="{ open: true }">
                                <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">{{ $module->order_number }}</span>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $module->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ $module->materials->count() }} materi &middot; {{ $module->duration_minutes }} menit</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                                <div x-show="open" x-transition class="mt-4 ml-11 space-y-2">
                                    @foreach($module->materials as $material)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-900 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $material->type_icon }}" /></svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $material->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-slate-400">{{ ucfirst($material->type) }} @if($material->file_name) &middot; {{ $material->file_size_formatted }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-slate-400 text-center py-4">Belum ada modul.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Info Kursus
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Kategori</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->category === 'technical' ? 'Teknis' : 'Soft Skill' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Harga</span>
                                <span class="font-medium {{ $course->is_free ? 'text-green-600' : 'text-gray-900 dark:text-white' }}">{{ $course->is_free ? 'Gratis' : 'Rp ' . number_format($course->price) }}</span>
                            </div>
                            @if($course->competency)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Kompetensi</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->competency->name }}</span>
                            </div>
                            @endif
                            @if($course->rating)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Rating</span>
                                <span class="font-medium text-yellow-600 dark:text-yellow-400">{{ $course->rating }} / 5.0</span>
                            </div>
                            @endif
                            @if($course->total_enrolled)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Terdaftar</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->total_enrolled }} siswa</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($course->tags && count($course->tags) > 0)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($course->tags as $tag)
                                <span class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg text-sm">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
