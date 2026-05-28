<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Result -->
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Asesmen Selesai!
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900">Hasil Analisis Kompetensi</h2>
                <p class="mt-2 text-gray-600">Posisi Target: <span
                        class="font-bold text-blue-600">{{ $assessment->position->name }}</span></p>
            </div>

            <!-- Overall Score Card -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 text-white mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <p class="text-blue-100 text-lg">Rata-rata Skill Gap Anda</p>
                        <p class="text-5xl font-extrabold mt-2">
                            {{ number_format($assessment->total_gap_percentage, 1) }}%</p>
                        <p class="text-blue-100 mt-2">
                            @if ($assessment->total_gap_percentage > 50)
                                🎯 Fokus pada skill prioritas untuk meningkatkan kesiapan karir
                            @elseif($assessment->total_gap_percentage > 25)
                                ✨ Anda sudah cukup siap, tingkatkan beberapa skill kunci
                            @else
                                🏆 Profil Anda sangat kompetitif! Pertahankan dan kembangkan
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('seeker.reports.assessment.pdf', $assessment->id) }}"
                            class="px-6 py-3 bg-white text-blue-700 rounded-lg font-medium hover:bg-blue-50 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download PDF
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white/10 transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: Skill Gap Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Competency Table -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Detail Kesenjangan Kompetensi</h3>
                            <p class="text-sm text-gray-500">Urutan berdasarkan prioritas perbaikan</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Kompetensi</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Level Anda</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Target</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Gap</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($assessment->scores->sortByDesc('gap_percentage') as $score)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $score->competency->name }}</div>
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ $score->competency->category }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-700 font-bold">
                                                    {{ $score->self_assessed_level }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-bold">
                                                    {{ $score->competency->min_level_required }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="text-sm font-bold {{ $score->gap_percentage > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                    {{ number_format($score->gap_percentage, 1) }}%
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if ($score->priority == 'high')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <span
                                                            class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5 animate-pulse"></span>
                                                        Tinggi
                                                    </span>
                                                @elseif($score->priority == 'medium')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Sedang
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Rendah
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Radar Chart Placeholder -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Visualisasi Kompetensi</h3>
                        <div class="h-64 flex items-center justify-center bg-gray-50 dark:bg-slate-800 rounded-lg">
                            <canvas id="skillRadarChart"></canvas>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 text-center mt-2">*Grafik radar menunjukkan perbandingan skill
                            Anda vs target industri</p>
                    </div>
                </div>

                <!-- Right: Recommendations Panel (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">

                        <!-- Recommendations Card -->
                        <div class="bg-white rounded-xl shadow-lg border-2 border-indigo-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-4 text-white">
                                <h3 class="font-bold text-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Rekomendasi Upskilling
                                </h3>
                                <p class="text-indigo-100 text-sm mt-1">Kursus terpilih untuk menutup skill gap Anda</p>
                            </div>

                            <div class="p-4 space-y-4 max-h-96 overflow-y-auto">
                                @forelse($recommendations ?? [] as $rec)
                                    <div
                                        class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-indigo-300 transition">
                                        <div class="flex justify-between items-start mb-2">
                                            <span
                                                class="text-xs font-semibold uppercase tracking-wide {{ $rec['priority'] == 'high' ? 'text-red-600' : 'text-yellow-600' }}">
                                                {{ $rec['priority'] }} Priority
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $rec['course']->platform }}</span>
                                        </div>
                                        <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $rec['course']->title }}
                                        </h4>
                                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">
                                            {{ $rec['course']->description }}</p>

                                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                            <span>⏱ {{ $rec['course']->duration_hours }} Jam</span>
                                            <span
                                                class="capitalize px-2 py-0.5 rounded {{ $rec['course']->level == 'beginner' ? 'bg-green-100 text-green-700' : ($rec['course']->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $rec['course']->level }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-indigo-600 font-medium mb-3">💡 {{ $rec['reason'] }}</p>

                                        <a href="{{ $rec['course']->url }}" target="_blank"
                                            class="block w-full text-center px-3 py-2 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700 transition">
                                            Mulai Belajar
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">🎉 Skill Anda sudah sangat baik!</p>
                                        <p class="text-xs text-gray-500">Tidak ada rekomendasi khusus saat ini.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="p-4 border-t border-gray-200 bg-gray-50">
                                <a href="{{ route('seeker.courses.index') }}"
                                    class="block w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    Jelajahi Semua Kursus →
                                </a>
                            </div>
                        </div>

                        <!-- Roadmap Preview -->
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">🗓️ Roadmap 6 Bulan</h3>

                            @if (($roadmapExists ?? false) && isset($roadmapMilestones) && count($roadmapMilestones) > 0)
                                <div class="space-y-3">
                                    @foreach ($roadmapMilestones as $milestone)
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                                {{ $milestone->month_number }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Bulan
                                                    {{ $milestone->month_number }}: {{ $milestone->milestone_title }}</p>
                                                <p class="text-xs text-gray-500">{{ $milestone->milestone_description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('seeker.roadmap.index') }}"
                                    class="mt-4 block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                    Lihat Roadmap Lengkap
                                </a>
                            @else
                                <p class="text-sm text-gray-600 mb-4">Roadmap personal akan dibuat otomatis setelah
                                    asesmen selesai.</p>
                                <form action="{{ route('seeker.roadmap.generate', $assessment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                        Generate Roadmap
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Quick Tips -->
                        <div
                            class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
                            <h4 class="font-bold text-amber-900 mb-3">💡 Tips Cepat</h4>
                            <ul class="space-y-2 text-sm text-amber-800">
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>Fokus pada skill dengan prioritas "Tinggi" terlebih dahulu</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>Alokasikan 3-5 jam/minggu untuk belajar konsisten</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>Dokumentasikan progress di portofolio Anda</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('skillRadarChart');
            if (!ctx) return;

            // Data dari controller
            const radarData = @json($radarData ?? []);

            const chart = new Chart(ctx.getContext('2d'), {
                type: 'radar',
                data: {
                    labels: radarData.map(d => d.label),
                    datasets: [{
                        label: 'Skill Saat Ini',
                        data: radarData.map(d => d.current),
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgb(59, 130, 246)',
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(59, 130, 246)'
                    }, {
                        label: 'Target Industri',
                        data: radarData.map(d => d.target),
                        fill: true,
                        backgroundColor: 'rgba(147, 51, 234, 0.2)',
                        borderColor: 'rgb(147, 51, 234)',
                        pointBackgroundColor: 'rgb(147, 51, 234)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(147, 51, 234)',
                        borderDash: [5, 5]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: {
                                display: true,
                                color: 'rgba(0,0,0,0.1)'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            },
                            pointLabels: {
                                font: {
                                    size: 11,
                                    weight: '500'
                                }
                            },
                            suggestedMin: 0,
                            suggestedMax: 5,
                            ticks: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });

            // Dynamic Dark Mode for Chart.js Radar
            function updateChartColors(chart, isDark) {
                const textColor = isDark ? '#9ca3af' : '#6b7280';
                const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                
                if (chart.options.plugins && chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                    chart.options.plugins.legend.labels.color = textColor;
                }
                
                if (chart.options.scales.r) {
                    if (!chart.options.scales.r.pointLabels) chart.options.scales.r.pointLabels = {};
                    chart.options.scales.r.pointLabels.color = textColor;
                    
                    if (!chart.options.scales.r.grid) chart.options.scales.r.grid = {};
                    chart.options.scales.r.grid.color = gridColor;
                    
                    if (!chart.options.scales.r.angleLines) chart.options.scales.r.angleLines = {};
                    chart.options.scales.r.angleLines.color = gridColor;
                }
                chart.update();
            }

            const isDark = document.documentElement.classList.contains('dark');
            updateChartColors(chart, isDark);

            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        const isDarkNow = document.documentElement.classList.contains('dark');
                        updateChartColors(chart, isDarkNow);
                    }
                });
            });
            
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</x-app-layout>
