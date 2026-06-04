<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Kelola Kursus</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">Buat dan kelola materi pembelajaran untuk mahasiswa.</p>
                </div>
                <a href="{{ route('education.courses.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Kursus
                </a>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-100 dark:border-blue-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">Tentang Kelola Kursus</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed">
                            <strong>Kursus</strong> adalah materi pembelajaran individual yang terhubung ke platform eksternal (Dicoding, Udemy, Coursera, dll). 
                            Setiap kursus memiliki <strong>link URL</strong> ke materi, <strong>durasi dalam jam</strong>, dan terkait dengan <strong>kompetensi spesifik</strong>. 
                            Job seeker dapat mendaftar dan melacak progres belajarnya secara mandiri (self-paced). 
                            Berbeda dengan <strong>Program</strong> yang bersifat terstruktur dengan jadwal dan kapasitas peserta.
                        </p>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kursus</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Platform</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Durasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($courses as $course)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">{{ Str::limit($course->description, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->category === 'technical' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300' }}">
                                        {{ $course->category === 'technical' ? 'Teknis' : 'Soft Skill' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ ucfirst($course->level) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $course->platform }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $course->duration_hours }} jam</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($course->is_free)
                                        <span class="text-green-600 dark:text-green-400 font-medium">Gratis</span>
                                    @else
                                        <span class="text-gray-900 dark:text-white">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('education.courses.edit', $course) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('education.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kursus ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                    Belum ada kursus. <a href="{{ route('education.courses.create') }}" class="text-blue-600 hover:underline">Tambahkan sekarang</a>.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($courses->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                    {{ $courses->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
