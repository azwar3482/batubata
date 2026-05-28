<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Analitik Kompetensi Lulusan</h2>
                <p class="mt-2 text-gray-600">Dashboard monitoring kompetensi dan skill gap rata-rata lulusan.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Lulusan Terdaftar</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">1,245</div>
                    <div class="text-xs text-green-600 mt-1">↑ 15% semester ini</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Rata-rata Skill Gap</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">38.5%</div>
                    <div class="text-xs text-green-600 mt-1">↓ 5% dari semester lalu</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Rate Penempatan Kerja</div>
                    <div class="text-3xl font-bold text-purple-600 mt-2">72%</div>
                    <div class="text-xs text-gray-500 mt-1">dalam 6 bulan setelah lulus</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-orange-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Asesmen Diselesaikan</div>
                    <div class="text-3xl font-bold text-orange-600 mt-2">892</div>
                    <div class="text-xs text-gray-500 mt-1">tahun ini</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Skill Gap per Jurusan -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Skill Gap Rata-rata per Jurusan</h3>
                    <canvas id="jurusanChart" height="200"></canvas>
                </div>

                <!-- Kompetensi Paling Bermasalah -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top 5 Kompetensi dengan Gap Tertinggi</h3>
                    <canvas id="competencyChart" height="200"></canvas>
                </div>
            </div>

            <!-- Recommendations Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Rekomendasi Penyesuaian Kurikulum</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kompetensi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gap Rata-rata</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rekomendasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Data Analysis</td>
                                <td class="px-6 py-4 text-sm text-gray-500">52%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">Tambah mata kuliah praktis Data Analytics</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tinggi</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Digital Marketing</td>
                                <td class="px-6 py-4 text-sm text-gray-500">45%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">Kolaborasi dengan industri untuk studi kasus</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Sedang</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Project Management</td>
                                <td class="px-6 py-4 text-sm text-gray-500">38%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">Integrasi metode Agile/Scrum dalam pembelajaran</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Sedang</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Communication</td>
                                <td class="px-6 py-4 text-sm text-gray-500">25%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">Workshop presentasi dan public speaking</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Rendah</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Export Actions -->
            <div class="mt-8 flex justify-end gap-4">
                <button class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    📊 Export Excel
                </button>
                <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    📄 Download Laporan PDF
                </button>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Chart.js Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Jurusan Chart
    const jurusanChart = new Chart(document.getElementById('jurusanChart'), {
        type: 'bar',
        data: {
            labels: ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Komunikasi', 'Akuntansi'],
            datasets: [{
                label: 'Skill Gap (%)',
                data: [38, 42, 35, 48, 30],
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Competency Chart
    const competencyChart = new Chart(document.getElementById('competencyChart'), {
        type: 'bar',
        data: {
            labels: ['Data Analysis', 'Digital Marketing', 'Project Management', 'Cloud Computing', 'Cybersecurity'],
            datasets: [{
                label: 'Gap (%)',
                data: [52, 45, 38, 35, 32],
                backgroundColor: 'rgba(239, 68, 68, 0.6)',
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Dynamic Dark Mode for Chart.js
    function updateChartColors(chart, isDark) {
        const textColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
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
            if (chart.options.scales.x.ticks) chart.options.scales.x.ticks.color = textColor;
            if (!chart.options.scales.x.grid) chart.options.scales.x.grid = {};
            chart.options.scales.x.grid.color = gridColor;
        }
        if (chart.options.scales.y) {
            if (chart.options.scales.y.ticks) chart.options.scales.y.ticks.color = textColor;
            if (!chart.options.scales.y.grid) chart.options.scales.y.grid = {};
            chart.options.scales.y.grid.color = gridColor;
        }
        chart.update();
    }

    const isDark = document.documentElement.classList.contains('dark');
    updateChartColors(jurusanChart, isDark);
    updateChartColors(competencyChart, isDark);

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                const isDarkNow = document.documentElement.classList.contains('dark');
                updateChartColors(jurusanChart, isDarkNow);
                updateChartColors(competencyChart, isDarkNow);
            }
        });
    });
    
    observer.observe(document.documentElement, { attributes: true });
});
</script>