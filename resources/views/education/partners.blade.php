<x-app-layout>
    <div class="py-8" x-data="{ viewMode: localStorage.getItem('partners_view_mode') || 'grid' }" x-init="$watch('viewMode', val => localStorage.setItem('partners_view_mode', val))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Mitra Industri</h2>
                        <p class="mt-2 text-gray-600 dark:text-slate-400">Jelajahi perusahaan mitra yang terbuka untuk kolaborasi dengan institusi pendidikan.</p>
                    </div>
                    <a href="{{ route('education.collaboration.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-purple-800 transition shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Ajukan Kolaborasi
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Total Mitra</p>
                    <p class="text-2xl font-bold">{{ count($partners) }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Terverifikasi</p>
                    <p class="text-2xl font-bold">{{ collect($partners)->where('verified', true)->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">Peluang Aktif</p>
                    <p class="text-2xl font-bold">{{ collect($partners)->sum('active_opportunities') }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-orange-500">
                    <p class="text-sm text-gray-500">Jenis Kolaborasi</p>
                    <p class="text-2xl font-bold">10+</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Mitra</label>
                        <input type="text" name="search" placeholder="Nama perusahaan..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Industri</label>
                        <select name="industry"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Industri</option>
                            @foreach ($industries as $industry)
                                <option value="{{ $industry }}"
                                    {{ request('industry') == $industry ? 'selected' : '' }}>{{ $industry }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <select name="location"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Lokasi</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location }}"
                                    {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Title & View Switcher -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Mitra</h3>
                <div class="flex items-center bg-gray-150 dark:bg-slate-800 p-1 rounded-lg border border-gray-200 dark:border-slate-700 w-fit self-end sm:self-auto shadow-sm">
                    <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white dark:bg-slate-700 shadow text-indigo-700 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200"
                        title="Grid View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Card Grid
                    </button>
                    <button @click="viewMode = 'table'" 
                        :class="viewMode === 'table' ? 'bg-white dark:bg-slate-700 shadow text-indigo-700 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200"
                        title="Table View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Tabel List
                    </button>
                </div>
            </div>

            <!-- Partners Grid View -->
            <div x-show="viewMode === 'grid'" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($partners as $partner)
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 dark:border-slate-800/80">
                        <!-- Partner Header -->
                        <div class="p-6 border-b border-gray-100 dark:border-slate-800/80">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                        {{ $partner['logo'] }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $partner['name'] }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-slate-450">{{ $partner['industry'] }}</p>
                                    </div>
                                </div>
                                @if ($partner['verified'])
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Partner Body -->
                        <div class="p-6 space-y-4">
                            <p class="text-sm text-gray-600 dark:text-slate-400 line-clamp-3">{{ $partner['description'] }}</p>

                            <div class="flex flex-wrap gap-2">
                                @foreach (array_slice($partner['collaboration_types'], 0, 3) as $type)
                                    <span
                                        class="px-2 py-1 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 text-xs rounded-md border border-indigo-100 dark:border-indigo-900/50">{{ $type }}</span>
                                @endforeach
                                @if (count($partner['collaboration_types']) > 3)
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-slate-800 text-gray-650 dark:text-slate-400 text-xs rounded-md border border-gray-200 dark:border-slate-700">+{{ count($partner['collaboration_types']) - 3 }}</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $partner['location'] }}
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ $partner['size'] }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t dark:border-slate-800/80">
                                <div class="text-center">
                                    <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $partner['active_opportunities'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-slate-450">Peluang Aktif</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('education.partners.show', $partner['id']) }}"
                                        class="px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 border border-indigo-600 dark:border-indigo-500 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/40 transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('education.collaboration.create', ['partner' => $partner['id']]) }}"
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 dark:bg-indigo-500 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
                                        Kolaborasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white dark:bg-slate-900 rounded-xl shadow border border-gray-100 dark:border-slate-800/80">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada mitra ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Coba ubah filter pencarian atau hubungi admin untuk menambahkan mitra baru.</p>
                    </div>
                @endforelse
            </div>

            <!-- Partners Table View -->
            <div x-show="viewMode === 'table'" x-transition class="bg-white dark:bg-slate-900 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Perusahaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Ukuran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Jenis Kolaborasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Peluang Aktif</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800">
                            @forelse($partners as $partner)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                {{ $partner['logo'] }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $partner['name'] }}</span>
                                                    @if ($partner['verified'])
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">
                                                            Verified
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $partner['industry'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $partner['location'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $partner['size'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1 max-w-xs">
                                            @forelse (array_slice($partner['collaboration_types'], 0, 2) as $type)
                                                <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 text-[10px] rounded border border-indigo-100 dark:border-indigo-900/50">{{ $type }}</span>
                                            @empty
                                                <span class="text-xs text-gray-400 dark:text-slate-500">-</span>
                                            @endforelse
                                            @if (count($partner['collaboration_types']) > 2)
                                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-slate-800 text-gray-650 dark:text-slate-400 text-[10px] rounded border border-gray-200 dark:border-slate-700">+{{ count($partner['collaboration_types']) - 2 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $partner['active_opportunities'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('education.partners.show', $partner['id']) }}"
                                                class="px-3 py-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 border border-indigo-600 dark:border-indigo-500 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/40 transition">
                                                Detail
                                            </a>
                                            <a href="{{ route('education.collaboration.create', ['partner' => $partner['id']]) }}"
                                                class="px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 dark:bg-indigo-500 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
                                                Kolaborasi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-500 dark:text-slate-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada mitra ditemukan</h3>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Coba ubah filter pencarian atau hubungi admin untuk menambahkan mitra baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <!-- Pagination for array is not natively supported like Eloquent -->
            </div>

            <!-- CTA Section -->
            <div class="mt-12 bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-3">Tidak menemukan mitra yang sesuai?</h3>
                <p class="text-indigo-100 mb-6 max-w-2xl mx-auto">Ajukan kolaborasi dengan perusahaan pilihan Anda. Tim
                    kami akan membantu menghubungkan institusi Anda dengan mitra industri yang relevan.</p>
                <a href="{{ route('education.collaboration.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg hover:bg-indigo-50 transition">
                    Ajukan Kolaborasi Baru
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
