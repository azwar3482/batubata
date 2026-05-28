<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Kelola Kompetensi & Pengaturan</h2>
                <p class="mt-2 text-gray-600">Kelola database kompetensi, standar industri, dan konfigurasi sistem
                    platform.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Total Kompetensi</p>
                    <p class="text-2xl font-bold">{{ $stats['total_competencies'] }}</p>
                    <p class="text-xs text-green-600 mt-1">+12 bulan ini</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">Posisi Karir</p>
                    <p class="text-2xl font-bold">{{ $stats['total_positions'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500">Update Pending</p>
                    <p class="text-2xl font-bold">{{ $stats['pending_updates'] }}</p>
                    <a href="#" class="text-xs text-blue-600 hover:underline">Review →</a>
                </div>
                <div class="bg-white rounded-xl p-4 shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Last Sync</p>
                    <p class="text-2xl font-bold">{{ $stats['last_sync']->diffForHumans() }}</p>
                    <button onclick="syncCompetencies()" class="text-xs text-blue-600 hover:underline mt-1">Sync
                        Sekarang</button>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white rounded-xl shadow-md mb-8">
                <div class="border-b border-gray-200" x-data="{ activeTab: 'competencies' }">
                    <nav class="flex px-6" aria-label="Tabs">
                        <button @click="activeTab = 'competencies'"
                            :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'competencies', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'competencies' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            📚 Database Kompetensi
                        </button>
                        <button @click="activeTab = 'positions'"
                            :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'positions', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'positions' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            🎯 Posisi Karir
                        </button>
                        <button @click="activeTab = 'system'"
                            :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'system', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'system' }"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition">
                            ⚙️ Pengaturan Sistem
                        </button>
                        <button @click="activeTab = 'logs'"
                            :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'logs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'logs' }"
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
                            <h3 class="text-lg font-bold text-gray-900">Daftar Kompetensi</h3>
                            <div class="flex gap-2">
                                <input type="text" placeholder="Cari kompetensi..."
                                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                <button
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">+
                                    Tambah</button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Kategori</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Posisi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min
                                            Level</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-mono text-gray-600">DM-001</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Google Analytics</td>
                                        <td class="px-4 py-3"><span
                                                class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">Technical</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">Digital Marketing Specialist</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">4/5</td>
                                        <td class="px-4 py-3 text-right">
                                            <button
                                                class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mr-3">Edit</button>
                                            <button
                                                class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                                        </td>
                                    </tr>
                                    <!-- More rows... -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Positions Tab -->
                    <div x-show="activeTab === 'positions'" class="hidden">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <p class="mt-4 text-gray-500">Fitur manajemen posisi karir akan tersedia segera.</p>
                        </div>
                    </div>

                    <!-- System Settings Tab -->
                    <div x-show="activeTab === 'system'" class="hidden">
                        <form action="{{ route('seeker.admin.settings.system') }}" method="POST"
                            class="space-y-6 max-w-2xl">
                            @csrf

                            <div class="flex items-center justify-between py-4 border-b">
                                <div>
                                    <h4 class="font-medium text-gray-900">AI Analysis Engine</h4>
                                    <p class="text-sm text-gray-500">Aktifkan analisis skill gap berbasis AI</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="ai_analysis_enabled"
                                        {{ $systemSettings['ai_analysis_enabled'] ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between py-4 border-b">
                                <div>
                                    <h4 class="font-medium text-gray-900">Auto-Match Threshold</h4>
                                    <p class="text-sm text-gray-500">Minimal persentase match untuk notifikasi otomatis
                                    </p>
                                </div>
                                <input type="number" name="auto_match_threshold"
                                    value="{{ $systemSettings['auto_match_threshold'] }}" min="0"
                                    max="100"
                                    class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div class="flex items-center justify-between py-4 border-b">
                                <div>
                                    <h4 class="font-medium text-gray-900">Email Notifications</h4>
                                    <p class="text-sm text-gray-500">Kirim notifikasi email untuk update sistem</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications"
                                        {{ $systemSettings['email_notifications'] ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between py-4">
                                <div>
                                    <h4 class="font-medium text-gray-900">Maintenance Mode</h4>
                                    <p class="text-sm text-red-500">⚠️ Aktifkan untuk maintenance (semua user akan
                                        di-logout)</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="maintenance_mode"
                                        {{ $systemSettings['maintenance_mode'] ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">Simpan
                                    Pengaturan</button>
                            </div>
                        </form>
                    </div>

                    <!-- Activity Logs Tab -->
                    <div x-show="activeTab === 'logs'" class="hidden">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Changes</h3>
                        <div class="space-y-4">
                            @foreach ($recentChanges as $change)
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold {{ $change['action'] == 'create' ? 'bg-green-500' : ($change['action'] == 'update' ? 'bg-blue-500' : 'bg-red-500') }}">
                                        {{ strtoupper(substr($change['action'], 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($change['action']) }}: <span
                                                class="font-semibold">{{ $change['item'] }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Oleh {{ $change['by'] }} • {{ $change['time']->diffForHumans() }}
                                        </p>
                                    </div>
                                    <button class="text-gray-400 hover:text-gray-600">
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
            if (confirm(
                    'Mulai sinkronisasi database kompetensi dengan sumber eksternal? Proses ini mungkin memakan waktu beberapa menit.'
                )) {
                // Show loading state
                alert('Sinkronisasi dimulai... Silakan tunggu.');

                // Simulasi AJAX call
                setTimeout(() => {
                    alert('✅ Sinkronisasi berhasil! 24 kompetensi diperbarui.');
                    location.reload();
                }, 3000);
            }
        }
    </script>
</x-app-layout>
