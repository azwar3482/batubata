<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('teacher.courses.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; Kembali ke Kursus</a>
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
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $course->duration_hours }} jam
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    {{ $course->modules->count() }} modul
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    {{ $course->classes->count() }} kelas
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('teacher.courses.edit', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">Edit</a>
                            @if($course->status === 'draft')
                            <form action="{{ route('teacher.courses.publish', $course) }}" method="POST">
                                @csrf
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">Publikasikan</button>
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
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Modul & Materi</h3>
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
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('teacher.courses.destroy-module', $module) }}" method="POST" onsubmit="return confirm('Hapus modul ini?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1 text-red-500 hover:text-red-700 dark:text-red-400" title="Hapus Modul">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
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
                                        <div class="flex items-center gap-1">
                                            @if($material->file_path)
                                            <a href="{{ route('teacher.courses.download-material', $material) }}" class="p-1 text-blue-500 hover:text-blue-700" title="Download">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                            </a>
                                            @endif
                                            <form action="{{ route('teacher.courses.destroy-material', $material) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                                @csrf @method('DELETE')
                                                <button class="p-1 text-red-500 hover:text-red-700" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach

                                    <!-- Add Material Form -->
                                    <div x-data="{ showForm: false }" class="mt-2">
                                        <button @click="showForm = !showForm" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">+ Tambah Materi</button>
                                        <form x-show="showForm" x-transition action="{{ route('teacher.courses.store-material', $module) }}" method="POST" enctype="multipart/form-data" class="mt-3 p-4 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg space-y-3">
                                            @csrf
                                            <input type="text" name="title" placeholder="Judul Materi" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                            <div class="grid grid-cols-2 gap-3">
                                                <select name="type" class="text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                    <option value="document">Dokumen</option>
                                                    <option value="video">Video</option>
                                                    <option value="link">Link</option>
                                                    <option value="assignment">Tugas</option>
                                                    <option value="quiz">Kuis</option>
                                                </select>
                                                <input type="file" name="file" class="text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                            </div>
                                            <input type="url" name="external_url" placeholder="URL eksternal (opsional)" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                            <textarea name="content" rows="2" placeholder="Konten/deskripsi (opsional)" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md"></textarea>
                                            <div class="flex justify-end">
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-slate-400 text-center py-4">Belum ada modul. Tambahkan modul pertama di bawah.</p>
                            @endforelse

                            <!-- Add Module Form -->
                            <div x-data="{ showForm: false }" class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                <button @click="showForm = !showForm" class="inline-flex items-center px-4 py-2 border border-dashed border-gray-300 dark:border-slate-600 text-gray-600 dark:text-slate-400 rounded-lg hover:border-blue-500 hover:text-blue-600 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    Tambah Modul
                                </button>
                                <form x-show="showForm" x-transition action="{{ route('teacher.courses.store-module', $course) }}" method="POST" class="mt-4 p-4 bg-gray-50 dark:bg-slate-900 rounded-lg space-y-3">
                                    @csrf
                                    <input type="text" name="title" placeholder="Judul Modul" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                    <textarea name="description" rows="2" placeholder="Deskripsi modul (opsional)" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md"></textarea>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Simpan Modul</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Course Info -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Info Kursus</h3>
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
                            @if($course->tags)
                            <div class="pt-2">
                                <span class="text-gray-500 dark:text-slate-400 text-xs">Tags:</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($course->tags as $tag)
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded text-xs">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Kelas</h3>
                        @forelse($course->classes as $class)
                        <div class="py-2 {{ !$loop->last ? 'border-b border-gray-100 dark:border-slate-700' : '' }}">
                            <a href="{{ route('teacher.classes.show', $class) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ $class->name }}</a>
                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ $class->enrollments->where('status', 'active')->count() }}/{{ $class->max_students }} siswa</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 dark:text-slate-400">Belum ada kelas.</p>
                        @endforelse
                        @if($course->status === 'published')
                        <a href="{{ route('teacher.classes.create') }}?course_id={{ $course->id }}" class="mt-3 inline-block text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">+ Buka Kelas Baru</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
