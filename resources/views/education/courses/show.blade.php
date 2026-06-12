<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('education.courses.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">&larr; Kembali ke Kursus</a>
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
                                <span>{{ $course->duration_hours }} jam</span>
                                <span>{{ $course->modules->count() }} modul</span>
                                <span>{{ $course->classes->count() }} kelas</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('education.courses.edit', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">Edit</a>
                            @if($course->status === 'draft')
                            <form action="{{ route('education.courses.publish', $course) }}" method="POST">
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
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
