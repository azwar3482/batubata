<x-app-layout>
    @push('head-scripts')
    @vite(['resources/js/chart.js'])
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('education.dashboard') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 text-sm">
                                {{ __('messages.dashboard') }}
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-900 dark:text-white ml-1 md:ml-2 text-sm font-medium">{{ __('messages.analitik') }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('messages.analitik_kompetensi_lulusan') }}</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">{{ __('messages.dashboard_monitoring_kompetensi') }}</p>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 border border-violet-100 dark:border-violet-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-violet-100 dark:bg-violet-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-violet-900 dark:text-violet-200 mb-1">{{ __('messages.tentang_analitik_kompetensi') }}</h4>
                        <p class="text-sm text-violet-700 dark:text-violet-300 leading-relaxed">{!! __('messages.analisis_mendalam_kompetensi_lulusan') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">{{ __('messages.total_lulusan_terdaftar') }}</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">1,245</div>
                    <div class="text-xs text-green-600 mt-1">↑ 15% {{ __('messages.semester_ini') }}</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">{{ __('messages.rata_rata_skill_gap') }}</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">38.5%</div>
                    <div class="text-xs text-green-600 mt-1">↓ 5% {{ __('messages.dari_semester_lalu') }}</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">{{ __('messages.rate_penempatan_kerja') }}</div>
                    <div class="text-3xl font-bold text-purple-600 mt-2">72%</div>
                    <div class="text-xs text-gray-500 mt-1">{{ __('messages.dalam_6_bulan_setelah_lulus') }}</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-orange-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">{{ __('messages.asesmen_diselesaikan') }}</div>
                    <div class="text-3xl font-bold text-orange-600 mt-2">892</div>
                    <div class="text-xs text-gray-500 mt-1">{{ __('messages.tahun_ini') }}</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Skill Gap per Jurusan -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.skill_gap_rata_rata_per_jurusan') }}</h3>
                    <canvas id="jurusanChart" height="200"></canvas>
                </div>

                <!-- Kompetensi Paling Bermasalah -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-md border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.top_5_kompetensi_gap_tertinggi') }}</h3>
                    <canvas id="competencyChart" height="200"></canvas>
                </div>
            </div>

            <!-- Recommendations Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('messages.rekomendasi_penyesuaian_kurikulum') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.no') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.kompetensi') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.gap_rata_rata') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.rekomendasi') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('messages.prioritas') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">1</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Data Analysis</td>
                                <td class="px-6 py-4 text-sm text-gray-500">52%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ __('messages.tambah_mata_kuliah_praktis_data_analytics') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">{{ __('messages.tinggi') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">2</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Digital Marketing</td>
                                <td class="px-6 py-4 text-sm text-gray-500">45%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ __('messages.kolaborasi_industri_studi_kasus') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ __('messages.sedang') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">3</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Project Management</td>
                                <td class="px-6 py-4 text-sm text-gray-500">38%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ __('messages.integrasi_metode_agile_scrum') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ __('messages.sedang') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">4</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Communication</td>
                                <td class="px-6 py-4 text-sm text-gray-500">25%</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ __('messages.workshop_presentasi_public_speaking') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ __('messages.rendah') }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Export Actions -->
            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('education.analytics.export.excel') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium inline-flex items-center">
                    📊 {{ __('messages.export_excel') }}
                </a>
                <a href="{{ route('education.analytics.export.pdf') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center">
                    📄 {{ __('messages.download_laporan_pdf') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Chart.js Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jurusanChart = new Chart(document.getElementById('jurusanChart'), {
        type: 'bar',
        data: {
            labels: ['{{ __("messages.teknik_informatika") }}', '{{ __("messages.sistem_informasi") }}', '{{ __("messages.manajemen") }}', '{{ __("messages.komunikasi") }}', '{{ __("messages.akuntansi") }}'],
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
