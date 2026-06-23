<x-app-layout>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Bank Soal TPA</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola daftar pertanyaan Tes Potensi Akademik untuk kandidat.</p>
        </div>
        <a href="{{ route('admin.tpa.questions.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Soal
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg shadow-sm animate-fade-in" role="alert">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">Berhasil!</span>&nbsp;{{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 transition-shadow hover:shadow-md">
        <div class="p-5">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Cari Soal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-colors" placeholder="Cari soal berdasarkan teks pertanyaan...">
                    </div>
                </div>
                <div>
                    <label for="category" class="sr-only">Kategori</label>
                    <select name="category" id="category" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-colors">
                        <option value="">Semua Kategori</option>
                        <option value="verbal" {{ request('category') === 'verbal' ? 'selected' : '' }}>Verbal</option>
                        <option value="numerik" {{ request('category') === 'numerik' ? 'selected' : '' }}>Numerik</option>
                        <option value="logika" {{ request('category') === 'logika' ? 'selected' : '' }}>Logika</option>
                        <option value="spasial" {{ request('category') === 'spasial' ? 'selected' : '' }}>Spasial</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label for="difficulty" class="sr-only">Level</label>
                        <select name="difficulty" id="difficulty" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-colors">
                            <option value="">Semua Level</option>
                            <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Mudah</option>
                            <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-16 text-center">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold min-w-[300px]">Soal & Subkategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center whitespace-nowrap">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center whitespace-nowrap">Level</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center whitespace-nowrap">Kunci</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center whitespace-nowrap">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @php $no = ($questions->currentPage() - 1) * $questions->perPage(); @endphp
                    @forelse($questions as $q)
                    @php $no++; @endphp
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">{{ $no }}</td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900 leading-snug break-words line-clamp-2" title="{{ strip_tags($q->question_text) }}">
                                {!! Str::limit(strip_tags($q->question_text), 120) !!}
                            </div>
                            @if($q->subcategory)
                            <div class="mt-1.5 text-xs text-gray-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                <span>{{ $q->subcategory }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border shadow-sm
                                {{ $q->category === 'verbal' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                {{ $q->category === 'numerik' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                {{ $q->category === 'logika' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                {{ $q->category === 'spasial' ? 'bg-orange-50 text-orange-700 border-orange-200' : '' }}">
                                {{ $q->category_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                {{ $q->difficulty === 'easy' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $q->difficulty === 'medium' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $q->difficulty === 'hard' ? 'bg-rose-100 text-rose-800' : '' }}">
                                {{ $q->difficulty_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 font-bold text-sm border border-gray-200 shadow-sm group-hover:bg-white group-hover:border-gray-300 transition-colors">
                                {{ $q->correct_answer }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($q->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-sm"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shadow-sm"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.tpa.questions.edit', $q) }}" class="p-1 text-blue-600 bg-blue-50 rounded hover:bg-blue-100 hover:text-blue-800 transition-colors" title="Edit Soal">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.tpa.questions.destroy', $q) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?\nTindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-red-600 bg-red-50 rounded hover:bg-red-100 hover:text-red-800 transition-colors" title="Hapus Soal">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="p-4 bg-gray-50 rounded-full mb-4 border border-gray-100">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 mb-1">Belum Ada Soal</h3>
                                <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">Bank soal TPA saat ini masih kosong atau tidak ada soal yang cocok dengan pencarian Anda.</p>
                                <a href="{{ route('admin.tpa.questions.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="-ml-1 mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Soal Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($questions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
            {{ $questions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    /* Optional smooth fade in for alerts */
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</x-app-layout>
