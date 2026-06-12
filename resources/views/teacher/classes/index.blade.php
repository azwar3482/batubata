<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Kelola Kelas</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">Buat dan kelola kelas dari kursus yang sudah dipublikasikan.</p>
                </div>
                <a href="{{ route('teacher.classes.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Buka Kelas
                </a>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($classes as $class)
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="h-3 bg-gradient-to-r {{ $class->status === 'active' ? 'from-emerald-500 to-teal-500' : 'from-gray-400 to-gray-500' }}"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-1 text-xs rounded-full {{ $class->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }}">{{ ucfirst($class->status) }}</span>
                            <span class="text-xs text-gray-500 dark:text-slate-400 font-mono">{{ $class->code }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $class->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-slate-400 mb-4">{{ $class->course->title }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-slate-400 mb-4">
                            <span>{{ $class->enrollments_count }}/{{ $class->max_students }} siswa</span>
                            @if($class->start_date)
                            <span>{{ $class->start_date->format('d M Y') }}</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-4">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $class->max_students > 0 ? ($class->enrollments_count / $class->max_students * 100) : 0 }}%"></div>
                        </div>
                        <a href="{{ route('teacher.classes.show', $class) }}" class="block w-full text-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium">Kelola Kelas</a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-slate-800 rounded-xl shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada kelas</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Buat kelas dari kursus yang sudah dipublikasikan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $classes->links() }}</div>
        </div>
    </div>
</x-app-layout>
