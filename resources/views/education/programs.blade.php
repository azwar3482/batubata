<x-app-layout>
    <div class="py-8" x-data="{ viewMode: localStorage.getItem('programs_view_mode') || 'grid' }" x-init="$watch('viewMode', val => localStorage.setItem('programs_view_mode', val))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.kelola_program') }}</h2>
                        <p class="mt-2 text-gray-600 dark:text-slate-400">{{ __('messages.buat_kelola_program_kolaborasi') }}</p>
                    </div>
                    <a href="{{ route('education.programs.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-600 to-teal-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-teal-800 transition shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        {{ __('messages.tambah_program_baru') }}
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 border border-green-100 dark:border-green-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-900 dark:text-green-200 mb-1">{{ __('messages.tentang_program') }}</h4>
                        <p class="text-sm text-green-700 dark:text-green-300 leading-relaxed">
                            {!! __('messages.tentang_program_desc') !!}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">{{ __('messages.total_program') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">{{ __('messages.aktif') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">{{ __('messages.total_peserta') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['totalStudents'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-orange-500">
                    <p class="text-sm text-gray-500">{{ __('messages.mitra_terlibat') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['totalPartners'] }}</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="mb-6 bg-white dark:bg-slate-900 rounded-xl shadow-md p-4 border border-gray-100 dark:border-slate-800">
                <form action="{{ route('education.programs') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="{{ __('messages.cari_nama_program_jenis') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <select name="status" class="px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg text-sm">
                        <option value="">{{ __('messages.semua_status') }}</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('messages.aktif') }}</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('messages.selesai') }}</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    <select name="type" class="px-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg text-sm">
                        <option value="">{{ __('messages.semua_jenis') }}</option>
                        @foreach($programTypes as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                            {{ __('messages.cari') }}
                        </button>
                        @if(request('search') || request('status') || request('type'))
                        <a href="{{ route('education.programs') }}" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition text-sm font-medium">
                            {{ __('messages.reset') }}
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Section Title & View Switcher -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.daftar_program_kerja_sama') }}</h3>
                <div class="flex items-center bg-gray-100 dark:bg-slate-800 p-1 rounded-lg border border-gray-200 dark:border-slate-700 w-fit self-end sm:self-auto shadow-sm">
                    <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white dark:bg-slate-700 shadow text-green-700 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200"
                        title="Grid View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        {{ __('messages.card_grid') }}
                    </button>
                    <button @click="viewMode = 'table'" 
                        :class="viewMode === 'table' ? 'bg-white dark:bg-slate-700 shadow text-green-700 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200"
                        title="Table View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{ __('messages.tabel_list') }}
                    </button>
                </div>
            </div>

            <!-- Programs Grid View -->
            <div x-show="viewMode === 'grid'" x-transition class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($programs as $program)
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 dark:border-slate-800/80">
                        <!-- Program Header -->
                        <div class="p-6 border-b border-gray-100 dark:border-slate-800/80">
                            <div class="flex items-start justify-between">
                                <div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $program['type'] == 'Bootcamp' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200' : ($program['type'] == 'Sertifikasi' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200') }}">
                                        {{ $program['type'] }}
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-2">{{ $program['name'] }}</h3>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $program['status'] == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-250' }}">
                                    {{ $program['status'] == 'active' ? '● ' . __('messages.aktif') : '○ ' . __('messages.akan_datang') }}
                                </span>
                            </div>
                        </div>

                        <!-- Program Body -->
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $program['duration'] }}
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ $program['students'] }} {{ __('messages.peserta') }}
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-slate-400 col-span-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ __('messages.mulai') }}: {{ $program['start_date'] ? \Carbon\Carbon::parse($program['start_date'])->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <!-- Industry Partners -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mb-2">{{ __('messages.mitra_industri') }}:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($program['industry_partners'] as $partner)
                                        <span
                                            class="px-3 py-1 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 text-xs rounded-full border border-gray-200 dark:border-slate-700/85">{{ $partner }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Progress Bar (if active) -->
                            @if ($program['status'] == 'active')
                                <div>
                                    <div class="flex justify-between text-xs text-gray-600 dark:text-slate-400 mb-1">
                                        <span>{{ __('messages.progress_program') }}</span>
                                        <span>65%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3 pt-4 border-t dark:border-slate-800/80">
                                <a href="{{ route('education.programs.edit', $program['id']) }}"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-center text-green-600 dark:text-green-400 border border-green-600 dark:border-green-500/50 rounded-lg hover:bg-green-50 dark:hover:bg-green-950/20 transition">
                                    {{ __('messages.kelola') }}
                                </a>
                                <a href="{{ route('education.programs.report', $program['id']) }}"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-600 dark:text-slate-300 border border-gray-300 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                    {{ __('messages.laporan') }}
                                </a>
                                <form action="{{ route('education.programs.destroy', $program['id']) }}" method="POST" onsubmit="return confirm('{{ __('messages.yakin_hapus_program') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-lg transition-colors" title="{{ __('messages.hapus') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-xl shadow border border-gray-100 dark:border-slate-800/80">
                        @if(request('search') || request('status') || request('type'))
                            <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.tidak_ada_program_sesuai') }}</h3>
                            <p class="mt-2 text-gray-500 dark:text-slate-400">{{ __('messages.coba_gunakan_kata_kunci_beda_atau') }} <a href="{{ route('education.programs') }}" class="text-green-600 hover:underline">{{ __('messages.reset_pencarian') }}</a></p>
                        @else
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.belum_ada_program') }}</h3>
                            <p class="mt-2 text-gray-500 dark:text-slate-400">{{ __('messages.mulai_buat_program_kolaborasi') }}</p>
                            <a href="{{ route('education.programs.create') }}"
                                class="mt-6 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                + {{ __('messages.tambah_program') }}
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links (Grid View) -->
            @if($programs->hasPages())
                <div class="mt-6">
                    {{ $programs->withQueryString()->links() }}
                </div>
            @endif

            <!-- Programs Table View -->
            <div x-show="viewMode === 'table'" x-transition class="bg-white dark:bg-slate-900 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">{{ __('messages.no') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.program') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.durasi') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.peserta') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.tanggal_mulai') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.mitra_industri') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ __('messages.aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800">
                            @forelse($programs as $program)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $program['type'] == 'Bootcamp' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200' : ($program['type'] == 'Sertifikasi' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200') }}">
                                                    {{ $program['type'] }}
                                                </span>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $program['name'] }}</span>
                                            @if ($program['status'] == 'active')
                                                <div class="mt-2 w-48">
                                                    <div class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-0.5">
                                                        <span>{{ __('messages.progress_program') }}</span>
                                                        <span>65%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-1.5">
                                                        <div class="bg-green-500 h-1.5 rounded-full" style="width: 65%"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $program['duration'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $program['students'] }} {{ __('messages.peserta') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $program['start_date'] ? \Carbon\Carbon::parse($program['start_date'])->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse ($program['industry_partners'] as $partner)
                                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 text-[10px] rounded-full border border-gray-200 dark:border-slate-700">{{ $partner }}</span>
                                            @empty
                                                <span class="text-xs text-gray-400 dark:text-slate-500">-</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $program['status'] == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-250' }}">
                                            {{ $program['status'] == 'active' ? '● ' . __('messages.aktif') : '○ ' . __('messages.akan_datang') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('education.programs.edit', $program['id']) }}" class="px-3 py-1.5 text-xs font-semibold text-green-600 dark:text-green-400 border border-green-600 dark:border-green-500/50 rounded-lg hover:bg-green-50 dark:hover:bg-green-950/20 transition">
                                                {{ __('messages.kelola') }}
                                            </a>
                                            <a href="{{ route('education.programs.report', $program['id']) }}" class="px-3 py-1.5 text-xs font-semibold text-gray-600 dark:text-slate-300 border border-gray-300 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                                {{ __('messages.laporan') }}
                                            </a>
                                            <form action="{{ route('education.programs.destroy', $program['id']) }}" method="POST" onsubmit="return confirm('{{ __('messages.yakin_hapus_program') }}')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-lg transition-colors" title="{{ __('messages.hapus') }}">
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
                                    <td colspan="8" class="text-center py-12 text-gray-500 dark:text-slate-400">
                                        @if(request('search') || request('status') || request('type'))
                                            <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.tidak_ada_program_sesuai') }}</h3>
                                            <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">{{ __('messages.coba_gunakan_kata_kunci_beda_atau') }} <a href="{{ route('education.programs') }}" class="text-green-600 hover:underline">{{ __('messages.reset_pencarian') }}</a></p>
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.belum_ada_program') }}</h3>
                                            <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">{{ __('messages.mulai_buat_program_kolaborasi') }}</p>
                                            <a href="{{ route('education.programs.create') }}" class="mt-4 inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">
                                                + {{ __('messages.tambah_program') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Links (Table View) -->
            @if($programs->hasPages())
                <div class="mt-6" x-show="viewMode === 'table'">
                    {{ $programs->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
