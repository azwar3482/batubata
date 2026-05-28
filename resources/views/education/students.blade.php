<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Data Siswa / Lulusan</h2>
                        <p class="mt-2 text-gray-600 dark:text-slate-400">Pantau perkembangan kompetensi dan status pekerjaan siswa dari institusi Anda.</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400 uppercase tracking-wide">Total Siswa Terdaftar</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $students->total() }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400 uppercase tracking-wide">Lulusan Tahun Ini</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $students->where('graduation_year', date('Y'))->count() }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400 uppercase tracking-wide">Aktif Mencari Kerja</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $students->where('status', 'active')->count() }}</p>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-slate-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Siswa {{ $institution->name }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama & Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Jurusan & Lulus</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Posisi Target</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800">
                            @forelse ($students as $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                        {{ $loop->iteration + $students->firstItem() - 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-slate-400">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $student->major ?: '-' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">Tahun Lulus: {{ $student->graduation_year ?: '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $student->target_position ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($student->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Aktif
                                            </span>
                                        @elseif($student->status === 'inactive')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                Tidak Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ ucfirst($student->status ?? 'Bekerja') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                        Belum ada data siswa untuk institusi ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($students->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/50">
                    {{ $students->links() }}
                </div>
                @endif
                
            </div>
            
        </div>
    </div>
</x-app-layout>
