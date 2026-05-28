<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Laporan & Analitik Platform</h2>
                <p class="mt-2 text-gray-600">Dashboard monitoring performa dan statistik platform KOMPASKARIR.</p>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <!-- Date Range Picker -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <form action="{{ route('admin.reports') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Generate Laporan</button>
                </form>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-sm">Total Pengguna</div>
                            <div class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers) }}</div>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm {{ $userGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $userGrowth >= 0 ? '↑' : '↓' }} {{ abs(round($userGrowth, 1)) }}% dari bulan lalu
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-sm">Total Asesmen</div>
                            <div class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalAssessments) }}</div>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm {{ $assessmentGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $assessmentGrowth >= 0 ? '↑' : '↓' }} {{ abs(round($assessmentGrowth, 1)) }}% dari bulan lalu
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-sm">Rata-rata Skill Gap</div>
                            <div class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($avgSkillGap, 1) }}%</div>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">Berdasarkan hasil asesmen</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-sm">Placement Rate</div>
                            <div class="text-3xl font-bold text-gray-900 mt-1">68%</div>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-green-600">↑ 8% dari bulan lalu</div>
                </div>
            </div>

            <!-- Charts & Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- User Growth Chart -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Pertumbuhan Pengguna</h3>
                    <canvas id="userGrowthChart" height="200"></canvas>
                </div>

                <!-- Top Skills Chart -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top Skill Paling Diminati</h3>
                    <canvas id="topSkillsChart" height="200"></canvas>
                </div>
            </div>

            <!-- Export Options -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Export Laporan</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.reports', ['export' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </a>
                    <a href="{{ route('admin.reports', ['export' => 'excel', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Excel
                    </a>
                    <a href="{{ route('admin.reports.send_email', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        📧 Kirim via Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Chart Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Detect Dark Mode for Chart Colors
        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? '#f8fafc' : '#475569'; // slate-50 or slate-600
        const gridColor = isDarkMode ? '#334155' : '#e2e8f0'; // slate-700 or slate-200
        
        Chart.defaults.color = textColor;
        Chart.defaults.borderColor = gridColor;

        // User Growth Chart
        const userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: @json($monthlyGrowth['labels']),
                datasets: [{
                    label: 'Pengguna Baru',
                    data: @json($monthlyGrowth['data']),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Top Skills Chart
        const topSkillsChart = new Chart(document.getElementById('topSkillsChart'), {
            type: 'bar',
            data: {
                labels: @json(array_column($topSkills, 'name')),
                datasets: [{
                    label: 'Jumlah Peminat',
                    data: @json(array_column($topSkills, 'count')),
                    backgroundColor: 'rgba(147, 51, 234, 0.6)',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Dynamic Dark Mode for Chart.js
        function updateChartColors(chart, isDark) {
            const textColor = isDark ? '#f8fafc' : '#475569';
            const gridColor = isDark ? '#334155' : '#e2e8f0';
            const tooltipBg = isDark ? 'rgba(31, 41, 55, 0.95)' : 'rgba(255, 255, 255, 0.95)';
            const tooltipText = isDark ? '#f9fafb' : '#1f2937';

            if (chart.options.plugins && chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                chart.options.plugins.legend.labels.color = textColor;
            }
            if (chart.options.plugins && chart.options.plugins.tooltip) {
                chart.options.plugins.tooltip.backgroundColor = tooltipBg;
                chart.options.plugins.tooltip.titleColor = tooltipText;
                chart.options.plugins.tooltip.bodyColor = tooltipText;
            }
            
            if (chart.options.scales.x) {
                if (!chart.options.scales.x.ticks) chart.options.scales.x.ticks = {};
                chart.options.scales.x.ticks.color = textColor;
                if (!chart.options.scales.x.grid) chart.options.scales.x.grid = {};
                chart.options.scales.x.grid.color = gridColor;
            }
            if (chart.options.scales.y) {
                if (!chart.options.scales.y.ticks) chart.options.scales.y.ticks = {};
                chart.options.scales.y.ticks.color = textColor;
                if (!chart.options.scales.y.grid) chart.options.scales.y.grid = {};
                chart.options.scales.y.grid.color = gridColor;
            }
            chart.update();
        }

        const isDark = document.documentElement.classList.contains('dark');
        updateChartColors(userGrowthChart, isDark);
        updateChartColors(topSkillsChart, isDark);

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isDarkNow = document.documentElement.classList.contains('dark');
                    updateChartColors(userGrowthChart, isDarkNow);
                    updateChartColors(topSkillsChart, isDarkNow);
                }
            });
        });
        
        observer.observe(document.documentElement, { attributes: true });
    });
</script>