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

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-sky-50 to-blue-50 dark:from-sky-900/20 dark:to-blue-900/20 border border-sky-100 dark:border-sky-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-sky-100 dark:bg-sky-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-sky-900 dark:text-sky-200 mb-1">Tentang Data Siswa/Lulusan</h4>
                        <p class="text-sm text-sky-700 dark:text-sky-300 leading-relaxed">Lihat daftar siswa dan lulusan dari institusi Anda. Pantau <strong>status pekerjaan</strong>, <strong>skill gap</strong>, dan <strong>progres asesmen</strong> setiap siswa. Data ini membantu Anda mengidentifikasi siswa yang membutuhkan <strong>bimbingan karir</strong> atau <strong>penyesuaian kurikulum</strong>.</p>
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
                <div class="p-6 border-b border-gray-200 dark:border-slate-800">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Siswa {{ $institution->name }}</h3>
                        <form action="{{ route('education.students') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari nama, email, jurusan..."
                                    class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <select name="status" class="px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg text-sm">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="employed" {{ request('status') === 'employed' ? 'selected' : '' }}>Bekerja</option>
                            </select>
                            <div class="flex gap-2">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    Cari
                                </button>
                                @if(request('search') || request('status'))
                                <a href="{{ route('education.students') }}" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition text-sm font-medium">
                                    Reset
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
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
                                            @php $photoDoc = $student->documents()->where('document_type', 'photo')->first(); @endphp
                                            @if($photoDoc)
                                                <img src="{{ asset('storage/' . $photoDoc->file_path) }}" class="h-10 w-10 rounded-full object-cover" loading="lazy">
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
                                        <a href="{{ route('education.students.show', $student) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                        @if(request('search') || request('status'))
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                                <p class="font-medium">Tidak ada siswa yang sesuai dengan pencarian</p>
                                                <p class="text-sm mt-1">Coba gunakan kata kunci yang berbeda atau <a href="{{ route('education.students') }}" class="text-blue-600 hover:underline">reset pencarian</a></p>
                                            </div>
                                        @else
                                            Belum ada data siswa untuk institusi ini.
                                        @endif
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
