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
                    {{ __('messages.assessment_completed') }}
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900">{{ __('messages.competency_analysis_result') }}</h2>
                <p class="mt-2 text-gray-600">{{ __('messages.target_position') }}: <span
                        class="font-bold text-blue-600">{{ $targetName }}</span></p>
            </div>

            <!-- Overall Score Card -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 text-white mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <p class="text-blue-100 text-lg">{{ __('messages.your_average_skill_gap') }}</p>
                        <p class="text-5xl font-extrabold mt-2">
                            {{ number_format($assessment->total_gap_percentage, 1) }}%
                        </p>
                        <p class="text-blue-100 mt-2">
                            @if ($assessment->total_gap_percentage > 50)
                            🎯 {{ __('messages.focus_priority_skills') }}
                            @elseif($assessment->total_gap_percentage > 30)
                            ✨ {{ __('messages.already_quite_ready') }}
                            @else
                            🏆 {{ __('messages.very_competitive_profile') }}
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-3">
                        @if ($assessment->total_gap_percentage <= 30)
                        <a href="{{ route('seeker.jobs.all') }}"
                            class="px-6 py-3 bg-green-500 text-white rounded-lg font-medium hover:bg-green-600 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('messages.choose_job') }}
                        </a>
                        @endif
                        <a href="{{ route('seeker.reports.assessment.pdf', $assessment->id) }}"
                            class="px-6 py-3 bg-white text-blue-700 rounded-lg font-medium hover:bg-blue-50 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            {{ __('messages.download_pdf') }}
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white/10 transition">
                            {{ __('messages.back_to_dashboard') }}
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
                            <h3 class="text-lg font-bold text-gray-900">{{ __('messages.competency_gap_detail') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('messages.sorted_by_priority') }}</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-10">{{ __('messages.no') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            {{ __('messages.competency') }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ __('messages.your_level') }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ __('messages.target') }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ __('messages.gap') }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ __('messages.priority') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($paginatedScores as $score)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ ($paginatedScores->currentPage() - 1) * $paginatedScores->perPage() + $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $score->competency->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 capitalize">
                                                {{ $score->competency->category }}
                                            </div>
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
                                                {{ __('messages.high') }}
                                            </span>
                                            @elseif($score->priority == 'medium')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ __('messages.medium') }}
                                            </span>
                                            @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ __('messages.low') }}
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        @if($paginatedScores->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $paginatedScores->links() }}
                        </div>
                        @endif
                    </div>

                    <!-- Radar Chart Placeholder -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.competency_visualization') }}</h3>
                        <div class="h-64 flex items-center justify-center bg-gray-50 dark:bg-slate-800 rounded-lg">
                            <canvas id="skillRadarChart"></canvas>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 text-center mt-2">*{{ __('messages.radar_chart_description') }}</p>
                    </div>
                </div>

                <!-- Right: Recommendations Panel (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">

                        @if ($assessment->total_gap_percentage > 30)
                        <!-- Recommendations Card -->
                        <div class="bg-white rounded-xl shadow-lg border-2 border-indigo-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-4 text-white">
                                <h3 class="font-bold text-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ __('messages.upskilling_recommendation') }}
                                </h3>
                                <p class="text-indigo-100 text-sm mt-1">{{ __('messages.selected_courses_close_gap') }}</p>
                            </div>

                            <div class="p-4 space-y-4 max-h-96 overflow-y-auto">
                                @forelse($recommendations ?? [] as $rec)
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-indigo-300 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wide {{ $rec['priority'] == 'high' ? 'text-red-600' : 'text-yellow-600' }}">
                                            {{ $rec['priority'] }} {{ __('messages.priority') }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $rec['course']->platform }}</span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $rec['course']->title }}
                                    </h4>
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">
                                        {{ $rec['course']->description }}
                                    </p>

                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                        <span>⏱ {{ $rec['course']->duration_hours }} {{ __('messages.hours') }}</span>
                                        <span
                                            class="capitalize px-2 py-0.5 rounded {{ $rec['course']->level == 'beginner' ? 'bg-green-100 text-green-700' : ($rec['course']->level == 'intermediate' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $rec['course']->level }}
                                        </span>
                                    </div>

                                    <p class="text-xs text-indigo-600 font-medium mb-3">💡 {{ $rec['reason'] }}</p>

                                    <a href="{{ route('seeker.courses.show', $rec['course']->id) }}"
                                        class="block w-full text-center px-3 py-2 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700 transition">
                                        {{ __('messages.view_detail') }}
                                    </a>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">🎉 {{ __('messages.skill_already_great') }}</p>
                                    <p class="text-xs text-gray-500">{{ __('messages.no_recommendations_needed') }}</p>
                                </div>
                                @endforelse
                            </div>

                            <div class="p-4 border-t border-gray-200 bg-gray-50">
                                <a href="{{ route('seeker.courses.index') }}"
                                    class="block w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ __('messages.browse_all_courses') }} →
                                </a>
                            </div>
                        </div>

                        <!-- Roadmap Preview -->
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">🗓️ {{ __('messages.month_roadmap') }}</h3>
                            <p class="text-xs text-gray-500 mb-4">{{ __('messages.learning_plan_based_on', ['count' => $assessment->scores->where('gap_percentage', '>', 0)->count()]) }}</p>

                            @if (($roadmapExists ?? false) && isset($roadmapMilestones) && count($roadmapMilestones) > 0)
                            <div class="space-y-3">
                                @foreach ($roadmapMilestones as $milestone)
                                @php
                                    $lines = explode("\n", $milestone->milestone_description);
                                    $skillCount = 0;
                                    $focusTheme = '';
                                    foreach ($lines as $line) {
                                        $trimmed = trim($line);
                                        if (str_starts_with($trimmed, 'Fokus bulan ini:')) {
                                            $focusTheme = str_replace('Fokus bulan ini: ', '', $trimmed);
                                        }
                                        if (str_starts_with($trimmed, '•')) $skillCount++;
                                    }
                                @endphp
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-6 h-6 rounded-full {{ $milestone->month_number <= 4 ? 'bg-purple-100 text-purple-600' : ($milestone->month_number == 5 ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600') }} flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        {{ $milestone->month_number }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $milestone->milestone_title }}
                                        </p>
                                        @if($focusTheme)
                                        <p class="text-xs text-purple-600 font-medium mt-0.5">{{ $focusTheme }}</p>
                                        @endif
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($skillCount > 0)
                                            <span class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded">{{ $skillCount }} {{ __('messages.competencies') }}</span>
                                            @endif
                                            @if($milestone->gap_percentage)
                                            <span class="text-[10px] px-1.5 py-0.5 {{ $milestone->gap_percentage > 50 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }} rounded">
                                                {{ __('messages.gap') }}: {{ number_format($milestone->gap_percentage, 1) }}%
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ route('seeker.roadmap.index') }}"
                                class="mt-4 block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                {{ __('messages.view_full_roadmap') }}
                            </a>
                            @else
                            <div class="mb-4 p-3 bg-indigo-50 rounded-lg">
                                <p class="text-xs text-indigo-700 font-medium">📊 {{ __('messages.your_skill_gap') }}: {{ number_format($assessment->total_gap_percentage, 1) }}%</p>
                                <p class="text-xs text-indigo-600 mt-1">{{ __('messages.roadmap_will_cover', ['count' => $assessment->scores->where('gap_percentage', '>', 0)->count()]) }}</p>
                            </div>
                            <form action="{{ route('seeker.roadmap.generate', $assessment->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                    🚀 {{ __('messages.generate_roadmap_from_skill_gap') }}
                                </button>
                            </form>
                            @endif
                        </div>
                        @else
                        <!-- Skill Gap Sudah OK -->
                        <div class="bg-white rounded-xl shadow-lg border-2 border-green-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 text-white">
                                <h3 class="font-bold text-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('messages.low_skill_gap') }}
                                </h3>
                                <p class="text-green-100 text-sm mt-1">{{ __('messages.ready_to_apply') }}</p>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ __('messages.gap') }} {{ number_format($assessment->total_gap_percentage, 1) }}%</p>
                                        <p class="text-xs text-gray-500">{{ __('messages.below_safe_threshold') }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">{{ __('messages.competency_meets_requirements') }}</p>
                                <a href="{{ route('seeker.jobs.all') }}"
                                    class="block w-full text-center px-4 py-3 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition">
                                    🔍 {{ __('messages.search_jobs_now') }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Quick Tips -->
                        <div
                            class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
                            <h4 class="font-bold text-amber-900 mb-3">💡 {{ __('messages.quick_tips') }}</h4>
                            <ul class="space-y-2 text-sm text-amber-800">
                                @if ($assessment->total_gap_percentage > 30)
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>{{ __('messages.tip_focus_high_priority') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>{{ __('messages.tip_alloc_hours_per_week') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>{{ __('messages.tip_document_progress') }}</span>
                                </li>
                                @else
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>{{ __('messages.tip_update_cv_portfolio') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>{{ __('messages.tip_research_company_culture') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">✓</span>
                                    <span>{{ __('messages.tip_practice_interview') }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    @vite(['resources/js/chart.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('skillRadarChart');
            if (!ctx) return;

            const radarData = @json($radarData ?? []);

            const chart = new Chart(ctx.getContext('2d'), {
                type: 'radar',
                data: {
                    labels: radarData.map(d => d.label),
                    datasets: [{
                        label: '{{ __("messages.current_skill") }}',
                        data: radarData.map(d => d.current),
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgb(59, 130, 246)',
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(59, 130, 246)'
                    }, {
                        label: '{{ __("messages.industry_target") }}',
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

            observer.observe(document.documentElement, {
                attributes: true
            });
        });
    </script>
</x-app-layout>
