<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Master Data: Skill Keywords (AI)') }}
                </h2>
                
                <div class="w-full sm:w-auto">
                    <a href="{{ route('admin.skill-keywords.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-sm transition-all whitespace-nowrap text-sm inline-block">
                        + Tambah Keyword
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-200 mb-1">Tentang Skill Keywords (AI)</h4>
                        <p class="text-sm text-indigo-700 dark:text-indigo-300 leading-relaxed">Skill keywords digunakan oleh <strong>AI</strong> untuk mengenali kemampuan dari CV dan dokumen. Saat job seeker mengupload CV, sistem akan mencocokkan teks dengan <strong>keyword</strong> ini untuk mengidentifikasi skill yang dimiliki. Keyword yang baik akan meningkatkan akurasi <strong>analisis AI</strong>.</p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
                <form action="{{ route('admin.skill-keywords.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end sm:items-center">
                    
                    <div class="w-full sm:w-1/3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keyword..." 
                                class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block pl-10 p-2.5">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                            <option value="">Semua Kategori</option>
                            @isset($categories)
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="w-full sm:w-1/4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto flex space-x-2">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'category', 'status']) && (request('search') != '' || request('category') != '' || request('status') != ''))
                            <a href="{{ route('admin.skill-keywords.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keyword</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($skillKeywords as $sk)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($skillKeywords->currentPage() - 1) * $skillKeywords->perPage() + $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sk->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $sk->keyword }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($sk->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('admin.skill-keywords.edit', $sk->id) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.skill-keywords.destroy', $sk->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus keyword ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $skillKeywords->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
