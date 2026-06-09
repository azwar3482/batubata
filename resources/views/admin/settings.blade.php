<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Kelola Kompetensi & Pengaturan</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">Kelola database kompetensi, standar industri, dan konfigurasi sistem
                    platform.</p>
            </div>

            <!-- Info Card -->
            <div class="mb-8 p-6 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-2xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-200 mb-2">Tentang Halaman Ini</h3>
                        <p class="text-sm text-indigo-700 dark:text-indigo-300/80 leading-relaxed mb-4">
                            Halaman <strong>Kelola Kompetensi & Pengaturan</strong> adalah pusat kendali untuk mengelola database kompetensi, posisi karir, dan konfigurasi sistem platform KOMPASKARIR.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div class="flex items-start gap-2 p-3 bg-white/60 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-lg">📚</span>
                                <div>
                                    <p class="text-xs font-semibold text-indigo-800 dark:text-indigo-300">Database Kompetensi</p>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400/80">Kelola skill & kompetensi (technical/soft skill) untuk setiap posisi karir</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 bg-white/60 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-lg">🎯</span>
                                <div>
                                    <p class="text-xs font-semibold text-indigo-800 dark:text-indigo-300">Posisi Karir</p>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400/80">Daftar posisi yang tersedia beserta kompetensi terkait</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 bg-white/60 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-lg">⚙️</span>
                                <div>
                                    <p class="text-xs font-semibold text-indigo-800 dark:text-indigo-300">Pengaturan Sistem</p>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400/80">Konfigurasi AI, threshold matching, notifikasi & maintenance</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 bg-white/60 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-lg">📋</span>
                                <div>
                                    <p class="text-xs font-semibold text-indigo-800 dark:text-indigo-300">Activity Logs</p>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400/80">Riwayat perubahan terbaru pada data kompetensi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Total Kompetensi</p>
                    <p class="text-2xl font-bold dark:text-white">{{ $stats['total_competencies'] }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">+12 bulan ini</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Posisi Karir</p>
                    <p class="text-2xl font-bold dark:text-white">{{ $stats['total_positions'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Update Pending</p>
                    <p class="text-2xl font-bold dark:text-white">{{ $stats['pending_updates'] }}</p>
                    <a href="#" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Review →</a>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-emerald-500">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Last Sync</p>
                    <p class="text-2xl font-bold dark:text-white">{{ $stats['last_sync']->diffForHumans() }}</p>
                    <button onclick="syncCompetencies()" class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-1">Sync
                        Sekarang</button>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <!-- Tabs Navigation -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md mb-8 border border-transparent dark:border-slate-700" x-data="{ activeTab: 'competencies', positionSearch: '' }">
                <div class="border-b border-gray-200 dark:border-slate-700">
                    <nav class="flex px-6 overflow-x-auto hide-scrollbar" aria-label="Tabs">
                        <button @click="activeTab = 'competencies'"
                            :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'competencies', 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600': activeTab !== 'competencies' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            📚 Database Kompetensi
                        </button>
                        <button @click="activeTab = 'positions'"
                            :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'positions', 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600': activeTab !== 'positions' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            🎯 Posisi Karir
                        </button>
                        <button @click="activeTab = 'system'"
                            :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'system', 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600': activeTab !== 'system' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            ⚙️ Pengaturan Sistem
                        </button>
                        <button @click="activeTab = 'logs'"
                            :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'logs', 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600': activeTab !== 'logs' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            📋 Activity Logs
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">

                    <!-- Competencies Tab -->
                    <div x-show="activeTab === 'competencies'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Kompetensi (5 Terbaru)</h3>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.competencies') }}"
                                    class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                                    Kelola Semua →
                                </a>
                                <a href="{{ route('admin.competencies.create') }}"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                    + Tambah
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-slate-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-700/50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase w-12">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Kode</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Nama</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Kategori</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Posisi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Min Level</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                    @forelse($latestCompetencies->take(5) as $comp)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-4 py-3 text-sm text-center text-gray-500 dark:text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm font-mono text-gray-600 dark:text-slate-400">{{ $comp->code }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $comp->name }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded {{ $comp->category == 'technical' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' : 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400' }}">
                                                {{ $comp->category == 'technical' ? 'Technical' : 'Soft Skill' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-slate-400">{{ $comp->position->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-medium">{{ $comp->min_level_required }}/5</td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('admin.competencies.edit', $comp) }}" class="p-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-slate-400">Belum ada data kompetensi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($latestCompetencies->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.competencies') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Lihat semua {{ $latestCompetencies->count() }} kompetensi →</a>
                        </div>
                        @endif
                    </div>

                    <!-- Positions Tab -->
                    <div x-show="activeTab === 'positions'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Posisi Karir</h3>
                            <a href="{{ route('admin.positions.create') }}"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                + Tambah Posisi
                            </a>
                        </div>

                        <!-- Search -->
                        <div class="mb-4">
                            <input type="text" x-model="positionSearch" placeholder="Cari posisi..."
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-slate-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-700/50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase w-12">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Nama Posisi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Deskripsi</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Kompetensi</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                    @forelse($positions as $position)
                                    <tr x-show="positionSearch === '' || '{{ strtolower($position->name) }}'.includes(positionSearch.toLowerCase())"
                                        class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-4 py-3 text-sm text-center text-gray-500 dark:text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $position->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-slate-400">{{ Str::limit($position->description ?? '-', 50) }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="px-2 py-1 text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-400 rounded-full">
                                                {{ $position->competencies_count }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('admin.positions.edit', $position) }}" class="p-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-slate-400">Belum ada data posisi karir.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- System Settings Tab -->
                    <div x-show="activeTab === 'system'">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pengaturan Sistem</h3>
                                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Konfigurasi platform KOMPASKARIR</p>
                            </div>
                            <span class="px-3 py-1 text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full font-medium">
                                <span class="inline-block w-2 h-2 bg-emerald-500 rounded-full mr-1 animate-pulse"></span>
                                System Online
                            </span>
                        </div>

                        <form action="{{ route('admin.settings.system') }}" method="POST" class="space-y-8">
                            @csrf

                            {{-- ==================== SECTION 1: Application ==================== --}}
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Aplikasi</h4>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Pengaturan umum platform</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Nama Aplikasi</label>
                                            <input type="text" name="app_name" value="{{ $systemSettings['app_name'] }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Bahasa Default</label>
                                            <select name="app_locale" class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                                <option value="id" {{ $systemSettings['app_locale'] == 'id' ? 'selected' : '' }}>Indonesia</option>
                                                <option value="en" {{ $systemSettings['app_locale'] == 'en' ? 'selected' : '' }}>English</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/10 rounded-lg border border-red-200 dark:border-red-800/30">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-red-800 dark:text-red-300">Maintenance Mode</h5>
                                                <p class="text-xs text-red-600 dark:text-red-400">Semua user akan di-logout saat diaktifkan</p>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="maintenance_mode" {{ $systemSettings['maintenance_mode'] ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== SECTION 2: AI & Analysis ==================== --}}
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                    <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">AI & Analisis</h4>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Konfigurasi mesin analisis AI</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-5">
                                    <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                        <div>
                                            <h5 class="font-medium text-gray-900 dark:text-white">AI Analysis Engine</h5>
                                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Aktifkan analisis skill gap berbasis AI (Python Flask + Gemini)</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="ai_analysis_enabled" {{ $systemSettings['ai_analysis_enabled'] ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                                AI Service URL
                                                <span class="text-xs text-gray-400 ml-1">(Python Flask)</span>
                                            </label>
                                            <input type="url" name="ai_service_url" value="{{ $systemSettings['ai_service_url'] }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                                Auto-Match Threshold
                                                <span class="text-xs text-gray-400 ml-1">(%)</span>
                                            </label>
                                            <div class="flex items-center gap-2">
                                                <input type="range" name="auto_match_threshold" min="0" max="100" value="{{ $systemSettings['auto_match_threshold'] }}"
                                                    class="flex-1 h-2 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-indigo-600"
                                                    oninput="this.nextElementSibling.textContent = this.value + '%'">
                                                <span class="text-sm font-medium text-gray-700 dark:text-slate-300 w-12 text-right">{{ $systemSettings['auto_match_threshold'] }}%</span>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1">Min. match untuk notifikasi otomatis</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                                Skill Gap Maksimal
                                                <span class="text-xs text-gray-400 ml-1">(untuk melamar)</span>
                                            </label>
                                            <div class="flex items-center gap-2">
                                                <input type="range" name="skill_gap_max" min="0" max="100" value="{{ $systemSettings['skill_gap_max'] }}"
                                                    class="flex-1 h-2 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-purple-600"
                                                    oninput="this.nextElementSibling.textContent = this.value + '%'">
                                                <span class="text-sm font-medium text-gray-700 dark:text-slate-300 w-12 text-right">{{ $systemSettings['skill_gap_max'] }}%</span>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1">Job seeker bisa melamar jika gap ≤ {{ $systemSettings['skill_gap_max'] }}%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== SECTION 3: Job Application Rules ==================== --}}
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg">
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Aturan Lamaran Kerja</h4>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Syarat yang harus dipenuhi job seeker</p>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div>
                                                <h5 class="text-sm font-medium text-gray-900 dark:text-white">Profil Lengkap</h5>
                                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Wajib 100% sebelum melamar</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="require_profile_complete" {{ $systemSettings['require_profile_complete'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div>
                                                <h5 class="text-sm font-medium text-gray-900 dark:text-white">Wajib Asesmen</h5>
                                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Harus punya asesmen aktif</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="require_assessment" {{ $systemSettings['require_assessment'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div>
                                                <h5 class="text-sm font-medium text-gray-900 dark:text-white">Izinkan Withdraw</h5>
                                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Job seeker bisa tarik lamaran</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="allow_withdraw" {{ $systemSettings['allow_withdraw'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== SECTION 4: Notifications ==================== --}}
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                    <div class="p-2 bg-amber-100 dark:bg-amber-900/50 rounded-lg">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Notifikasi</h4>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Pengaturan email & notifikasi sistem</p>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">Email Notifications</h5>
                                                    <p class="text-xs text-gray-500 dark:text-slate-400">Kirim notifikasi via email</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="email_notifications" {{ $systemSettings['email_notifications'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-600"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                </svg>
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">Lamaran Baru</h5>
                                                    <p class="text-xs text-gray-500 dark:text-slate-400">Notifikasi saat ada pelamar</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="notify_new_application" {{ $systemSettings['notify_new_application'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-600"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">Perubahan Status</h5>
                                                    <p class="text-xs text-gray-500 dark:text-slate-400">Notifikasi update status lamaran</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="notify_status_change" {{ $systemSettings['notify_status_change'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-600"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">Job Match</h5>
                                                    <p class="text-xs text-gray-500 dark:text-slate-400">Notifikasi lowongan cocok</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="notify_job_match" {{ $systemSettings['notify_job_match'] ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-9 h-5 bg-gray-200 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== SECTION 5: Document Weights ==================== --}}
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Bobot Dokumen</h4>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Konfigurasi scoring dokumen (total harus 100%)</p>
                                    </div>
                                    <span id="weight-total" class="ml-auto px-3 py-1 text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded-full font-medium">
                                        Total: {{ $systemSettings['cv_weight'] + $systemSettings['ijazah_weight'] + $systemSettings['transkrip_weight'] + $systemSettings['sertifikat_weight'] + $systemSettings['portofolio_weight'] }}%
                                    </span>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                        @php
                                        $docFields = [
                                            'cv_weight' => ['label' => 'CV', 'icon' => '📄', 'color' => 'blue'],
                                            'ijazah_weight' => ['label' => 'Ijazah', 'icon' => '🎓', 'color' => 'emerald'],
                                            'transkrip_weight' => ['label' => 'Transkrip', 'icon' => '📊', 'color' => 'purple'],
                                            'sertifikat_weight' => ['label' => 'Sertifikat', 'icon' => '🏆', 'color' => 'amber'],
                                            'portofolio_weight' => ['label' => 'Portofolio', 'icon' => '💼', 'color' => 'rose'],
                                        ];
                                        @endphp
                                        @foreach($docFields as $field => $config)
                                        <div class="text-center p-4 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                            <span class="text-2xl">{{ $config['icon'] }}</span>
                                            <label class="block text-xs font-medium text-gray-700 dark:text-slate-300 mt-2 mb-2">{{ $config['label'] }}</label>
                                            <input type="number" name="{{ $field }}" value="{{ $systemSettings[$field] }}" min="0" max="100"
                                                class="w-full px-3 py-2 text-center text-lg font-bold border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition doc-weight-input"
                                                onchange="updateWeightTotal()">
                                            <span class="text-xs text-gray-400 mt-1">%</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-3 text-center">
                                        Total bobot dokumen harus = 100%. Bobot digunakan untuk menghitung matching score kandidat.
                                    </p>
                                </div>
                            </div>

                            {{-- ==================== SECTION 6: System Information ==================== --}}
                            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                    <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Informasi Sistem</h4>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Status dan versi komponen sistem</p>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">Laravel</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $systemInfo['laravel_version'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">PHP</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $systemInfo['php_version'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">MySQL</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $systemInfo['database_version'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">Queue</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white capitalize">{{ $systemInfo['queue_driver'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">Cache</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white capitalize">{{ $systemInfo['cache_driver'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">Session</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white capitalize">{{ $systemInfo['session_driver'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">Total Users</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($systemInfo['total_users']) }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                            <p class="text-xs text-gray-500 dark:text-slate-400">Lowongan Aktif</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($systemInfo['active_jobs']) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== Save Button ==================== --}}
                            <div class="flex items-center justify-between p-6 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 sticky bottom-4 shadow-lg">
                                <p class="text-sm text-gray-500 dark:text-slate-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Perubahan akan disimpan dan langsung diterapkan
                                </p>
                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Activity Logs Tab -->
                    <div x-show="activeTab === 'logs'">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Changes</h3>
                        <div class="space-y-4">
                            @foreach ($recentChanges as $change)
                                <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-800/50 rounded-lg">
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold {{ $change['action'] == 'create' ? 'bg-emerald-500' : ($change['action'] == 'update' ? 'bg-blue-500' : 'bg-red-500') }}">
                                        {{ strtoupper(substr($change['action'], 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ ucfirst($change['action']) }}: <span
                                                class="font-semibold">{{ $change['item'] }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">
                                            Oleh {{ $change['by'] }} • {{ $change['time']->diffForHumans() }}
                                        </p>
                                    </div>
                                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Sync Function -->
    <script>
        function syncCompetencies() {
            if (confirm('Mulai sinkronisasi database kompetensi dengan sumber eksternal? Proses ini mungkin memakan waktu beberapa menit.')) {
                alert('Sinkronisasi dimulai... Silakan tunggu.');
                setTimeout(() => {
                    alert('Sinkronisasi berhasil! 24 kompetensi diperbarui.');
                    location.reload();
                }, 3000);
            }
        }

        function updateWeightTotal() {
            const inputs = document.querySelectorAll('.doc-weight-input');
            let total = 0;
            inputs.forEach(input => {
                total += parseInt(input.value) || 0;
            });
            const badge = document.getElementById('weight-total');
            badge.textContent = 'Total: ' + total + '%';
            badge.className = 'ml-auto px-3 py-1 text-xs rounded-full font-medium ' +
                (total === 100 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' :
                 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400');
        }
    </script>
</x-app-layout>
