<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Kelola Program</h2>
                        <p class="mt-2 text-gray-600">Buat dan kelola program kolaborasi dengan industri untuk
                            pengembangan kompetensi lulusan.</p>
                    </div>
                    <a href="{{ route('education.programs.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-600 to-teal-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-teal-800 transition shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Program Baru
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Total Program</p>
                    <p class="text-2xl font-bold">{{ $programs->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Aktif</p>
                    <p class="text-2xl font-bold">{{ $programs->where('status', 'active')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">Total Peserta</p>
                    <p class="text-2xl font-bold">{{ $programs->sum('students') }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-orange-500">
                    <p class="text-sm text-gray-500">Mitra Terlibat</p>
                    <p class="text-2xl font-bold">
                        {{ $programs->pluck('industry_partners')->flatten()->unique()->count() }}</p>
                </div>
            </div>

            <!-- Programs Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($programs as $program)
                    <div
                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100">
                        <!-- Program Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $program['type'] == 'Bootcamp' ? 'bg-blue-100 text-blue-800' : ($program['type'] == 'Sertifikasi' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $program['type'] }}
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $program['name'] }}</h3>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $program['status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $program['status'] == 'active' ? '● Aktif' : '○ Akan Datang' }}
                                </span>
                            </div>
                        </div>

                        <!-- Program Body -->
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $program['duration'] }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ $program['students'] }} Peserta
                                </div>
                                <div class="flex items-center text-gray-600 col-span-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Mulai: {{ \Carbon\Carbon::parse($program['start_date'])->format('d M Y') }}
                                </div>
                            </div>

                            <!-- Industry Partners -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-2">Mitra Industri:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($program['industry_partners'] as $partner)
                                        <span
                                            class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full border border-gray-200">{{ $partner }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Progress Bar (if active) -->
                            @if ($program['status'] == 'active')
                                <div>
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Progress Program</span>
                                        <span>65%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3 pt-4 border-t">
                                <button
                                    class="flex-1 px-4 py-2 text-sm font-medium text-green-600 border border-green-600 rounded-lg hover:bg-green-50 transition">
                                    Kelola
                                </button>
                                <button
                                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    Laporan
                                </button>
                                <button
                                    class="px-4 py-2 text-sm font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-xl shadow">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada program</h3>
                        <p class="mt-2 text-gray-500">Mulai dengan membuat program kolaborasi pertama Anda.</p>
                        <a href="{{ route('education.programs.create') }}"
                            class="mt-6 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                            + Tambah Program
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
