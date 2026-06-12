<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ view: localStorage.getItem('classesView') || 'card' }" x-init="$watch('view', val => localStorage.setItem('classesView', val))">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Kelola Kelas</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">Buat dan kelola kelas dari kursus yang sudah dipublikasikan.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-gray-100 dark:bg-slate-800 p-1 rounded-lg flex items-center">
                        <button @click="view = 'card'" :class="{ 'bg-white dark:bg-slate-700 shadow': view === 'card', 'text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200': view !== 'card' }" class="p-2 rounded-md transition-colors" title="Grid View">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        </button>
                        <button @click="view = 'list'" :class="{ 'bg-white dark:bg-slate-700 shadow': view === 'list', 'text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200': view !== 'list' }" class="p-2 rounded-md transition-colors" title="List View">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                    </div>
                    <a href="{{ route('teacher.classes.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Buka Kelas
                    </a>
                </div>
            </div>

            <!-- Search Form -->
            <div class="mb-6">
                <form action="{{ route('teacher.classes.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas, kode, atau kursus..." class="w-full md:w-1/3 rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-slate-700 text-white rounded-lg hover:bg-gray-700 dark:hover:bg-slate-600 transition text-sm font-medium">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('teacher.classes.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-slate-800 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-700 transition text-sm font-medium">Reset</a>
                    @endif
                </form>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Grid/Card View -->
            <div x-show="view === 'card'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: none;">
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
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada kelas {{ request('search') ? 'yang sesuai dengan pencarian' : '' }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Buat kelas dari kursus yang sudah dipublikasikan.</p>
                </div>
                @endforelse
            </div>

            <!-- List View -->
            <div x-show="view === 'list'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 overflow-hidden" style="display: none;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700 border-b border-gray-100 dark:border-slate-600 text-sm font-medium text-gray-500 dark:text-slate-300">
                                <th class="p-4 w-12">No</th>
                                <th class="p-4">Kode</th>
                                <th class="p-4">Nama Kelas</th>
                                <th class="p-4">Kursus</th>
                                <th class="p-4">Siswa</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse($classes as $class)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <td class="p-4 text-sm text-gray-500 dark:text-slate-400">{{ $loop->iteration + ($classes->firstItem() ?: 1) - 1 }}</td>
                                <td class="p-4 text-sm font-mono text-gray-500 dark:text-slate-400">{{ $class->code }}</td>
                                <td class="p-4 text-sm font-bold text-gray-900 dark:text-white">{{ $class->name }}</td>
                                <td class="p-4 text-sm text-gray-600 dark:text-slate-400">{{ $class->course->title }}</td>
                                <td class="p-4">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-slate-400">
                                        <span class="mr-2">{{ $class->enrollments_count }}/{{ $class->max_students }}</span>
                                        <div class="w-16 bg-gray-200 dark:bg-slate-600 rounded-full h-1.5">
                                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $class->max_students > 0 ? ($class->enrollments_count / $class->max_students * 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $class->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-slate-600 dark:text-slate-300' }}">{{ ucfirst($class->status) }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('teacher.classes.show', $class) }}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 text-sm font-medium">Kelola</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 dark:text-slate-400">Belum ada kelas {{ request('search') ? 'yang sesuai dengan pencarian' : '' }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">{{ $classes->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
