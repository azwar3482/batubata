<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.kelola_kursus_institusi') }}</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">{{ __('messages.buat_dan_kelola_materi_pembelajaran') }}</p>
                </div>
                <a href="{{ route('education.courses.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('messages.tambah_kursus') }}
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
                        <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">{{ __('messages.tentang_kelola_kursus') }}</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed">
                            <strong>{{ __('messages.kursus_institusi') }}</strong> {{ __('messages.adalah_materi_pembelajaran_dibuat_langsung') }}
                            {{ __('messages.setiap_kursus_memiliki_modul_dan_materi') }}
                            {{ __('messages.setelah_dipublikasikan_dapat_membuka_kelas') }}
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
                <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                    <form action="{{ route('education.courses.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="{{ __('messages.cari_judul_kursus_deskripsi') }}"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <select name="status" class="px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg text-sm">
                            <option value="">{{ __('messages.semua_status') }}</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        <select name="level" class="px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg text-sm">
                            <option value="">{{ __('messages.semua_level') }}</option>
                            <option value="beginner" {{ request('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ request('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ request('level') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        <select name="category" class="px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg text-sm">
                            <option value="">{{ __('messages.semua_kategori') }}</option>
                            <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>{{ __('messages.teknis') }}</option>
                            <option value="soft_skill" {{ request('category') === 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                        </select>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                {{ __('messages.cari') }}
                            </button>
                            @if(request('search') || request('status') || request('level') || request('category'))
                            <a href="{{ route('education.courses.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition text-sm font-medium">
                                {{ __('messages.reset') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.kursus') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.kategori') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.level') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.modul') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.kelas') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($courses as $course)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $loop->iteration + ($courses->firstItem() ?: 1) - 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">{{ Str::limit($course->description, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->category === 'technical' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300' }}">
                                        {{ $course->category === 'technical' ? __('messages.teknis') : 'Soft Skill' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ ucfirst($course->level) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $course->modules_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $course->classes_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($course->status === 'published')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Published</span>
                                    @elseif($course->status === 'draft')
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300">Draft</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">Archived</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('education.courses.show', $course) }}" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50 dark:text-slate-400 dark:hover:text-slate-300 rounded-lg transition-colors" title="{{ __('messages.lihat') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('education.courses.edit', $course) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 dark:text-blue-400 dark:hover:text-blue-300 rounded-lg transition-colors" title="{{ __('messages.edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($course->status === 'draft')
                                        <form action="{{ route('education.courses.publish', $course) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 dark:text-green-400 rounded-lg transition-colors" title="{{ __('messages.publikasikan') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('education.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.konfirmasi_hapus_kursus') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:text-red-400 rounded-lg transition-colors" title="{{ __('messages.hapus') }}">
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
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                    @if(request('search') || request('status') || request('level') || request('category'))
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                            <p class="font-medium">{{ __('messages.tidak_ada_kursus_sesuai_pencarian') }}</p>
                                            <p class="text-sm mt-1">{{ __('messages.coba_kata_kunci_berbeda_atau') }} <a href="{{ route('education.courses.index') }}" class="text-blue-600 hover:underline">{{ __('messages.reset_pencarian') }}</a></p>
                                        </div>
                                    @else
                                        {{ __('messages.belum_ada_kursus') }} <a href="{{ route('education.courses.create') }}" class="text-blue-600 hover:underline">{{ __('messages.tambahkan_sekarang') }}</a>.
                                    @endif
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
