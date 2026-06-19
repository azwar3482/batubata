<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('education.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('education.programs') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Program</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Laporan</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Program</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Detail laporan program: <strong>{{ $program->name }}</strong></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('education.programs.edit', $program) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Program
                    </a>
                    <a href="{{ route('education.programs') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                        &laquo; Kembali
                    </a>
                </div>
            </div>

            <!-- Program Info Card -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 mb-8 border border-gray-100 dark:border-slate-800">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Nama Program</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $program->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Jenis</p>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $program->type == 'Bootcamp' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200' : ($program->type == 'Sertifikasi' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200') }}">
                                {{ $program->type }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Durasi</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $program->duration }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Status</p>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $program->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200' : ($program->status == 'completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-200') }}">
                                {{ $program->status == 'active' ? '● Aktif' : ($program->status == 'completed' ? '✓ Selesai' : '○ Akan Datang') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-md border-l-4 border-blue-500 border border-gray-100 dark:border-slate-800">
                    <div class="text-gray-500 dark:text-slate-400 text-sm font-semibold uppercase">Total Peserta</div>
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $totalEnrolled }}</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">dari {{ $program->max_students }} kuota</div>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-md border-l-4 border-green-500 border border-gray-100 dark:border-slate-800">
                    <div class="text-gray-500 dark:text-slate-400 text-sm font-semibold uppercase">Tingkat Penyelesaian</div>
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $completionRate }}%</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">peserta menyelesaikan program</div>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-md border-l-4 border-purple-500 border border-gray-100 dark:border-slate-800">
                    <div class="text-gray-500 dark:text-slate-400 text-sm font-semibold uppercase">Tanggal Mulai</div>
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $program->start_date?->format('d M Y') ?? '-' }}</div>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-md border-l-4 border-orange-500 border border-gray-100 dark:border-slate-800">
                    <div class="text-gray-500 dark:text-slate-400 text-sm font-semibold uppercase">Kuota Terpakai</div>
                    <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-2">{{ $program->max_students > 0 ? round(($totalEnrolled / $program->max_students) * 100) : 0 }}%</div>
                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mt-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $program->max_students > 0 ? min(round(($totalEnrolled / $program->max_students) * 100), 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Enrollment Trend -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Pendaftaran</h3>
                    <canvas id="enrollmentChart" height="200"></canvas>
                </div>

                <!-- Status Distribution -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Distribusi Status Peserta</h3>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>

            <!-- Participants Table -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-slate-800">
                <div class="p-6 border-b border-gray-200 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Peserta</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800">
                            @forelse($enrollments as $enrollment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $enrollment->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $enrollment->user->email ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $enrollment->created_at?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClass = match($enrollment->status) {
                                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
                                                'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200',
                                                'enrolled' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-200',
                                                'dropped' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',
                                                default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/40 dark:text-gray-200'
                                            };
                                            $statusLabel = match($enrollment->status) {
                                                'completed' => 'Selesai',
                                                'in_progress' => 'Sedang Berjalan',
                                                'enrolled' => 'Terdaftar',
                                                'dropped' => 'Berhenti',
                                                default => ucfirst($enrollment->status ?? 'pending')
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12 text-gray-500 dark:text-slate-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm">Belum ada peserta terdaftar</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mitra Industri -->
            @if($program->industry_partners && count($program->industry_partners) > 0)
            <div class="mt-8 bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Mitra Industri Terlibat</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($program->industry_partners as $partner)
                        <span class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 text-sm rounded-full border border-gray-200 dark:border-slate-700">
                            {{ $partner }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Export Actions -->
            <div class="mt-8 flex justify-end gap-4">
                <button onclick="window.print()" class="px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium">
                    🖨️ Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';

        // Enrollment Trend Chart
        new Chart(document.getElementById('enrollmentChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Peserta Baru',
                    data: [2, 5, 8, 12, {{ $totalEnrolled }}, {{ $totalEnrolled }}],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } },
                    x: { ticks: { color: textColor }, grid: { color: gridColor } }
                },
                plugins: { legend: { labels: { color: textColor } } }
            }
        });

        // Status Distribution Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Terdaftar', 'Sedang Berjalan', 'Selesai', 'Berhenti'],
                datasets: [{
                    data: [
                        {{ $enrollments->where('status', 'enrolled')->count() }},
                        {{ $enrollments->where('status', 'in_progress')->count() }},
                        {{ $enrollments->where('status', 'completed')->count() }},
                        {{ $enrollments->where('status', 'dropped')->count() }}
                    ],
                    backgroundColor: [
                        'rgba(234, 179, 8, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, padding: 20 }
                    }
                }
            }
        });
    });
    </script>
</x-app-layout>
