<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Mitra Industri</h2>
                        <p class="mt-2 text-gray-600">Jelajahi perusahaan mitra yang terbuka untuk kolaborasi dengan
                            institusi pendidikan.</p>
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

            <!-- Partners Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($partners as $partner)
                    <div
                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100">
                        <!-- Partner Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                        {{ $partner['logo'] }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $partner['name'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $partner['industry'] }}</p>
                                    </div>
                                </div>
                                @if ($partner['verified'])
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
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
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $partner['description'] }}</p>

                            <div class="flex flex-wrap gap-2">
                                @foreach (array_slice($partner['collaboration_types'], 0, 3) as $type)
                                    <span
                                        class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs rounded-md">{{ $type }}</span>
                                @endforeach
                                @if (count($partner['collaboration_types']) > 3)
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-md">+{{ count($partner['collaboration_types']) - 3 }}</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $partner['location'] }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ $partner['size'] }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="text-center">
                                    <p class="text-lg font-bold text-indigo-600">{{ $partner['active_opportunities'] }}
                                    </p>
                                    <p class="text-xs text-gray-500">Peluang Aktif</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('education.partners.show', $partner['id']) }}"
                                        class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('education.collaboration.create', ['partner' => $partner['id']]) }}"
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                                        Kolaborasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl shadow">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada mitra ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian atau hubungi admin untuk
                            menambahkan mitra baru.</p>
                    </div>
                @endforelse
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
