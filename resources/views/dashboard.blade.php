<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Job Seeker') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6 border border-slate-100 dark:border-slate-800">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Halo, {{ $user->name }}! 👋</h3>
                <p class="text-gray-600 dark:text-slate-400 mt-2">Siap untuk menutup kesenjangan skill kamu hari ini?</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Total Asesmen</div>
                    <div class="text-2xl font-bold dark:text-white">{{ $totalAssessments }}</div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Rata-rata Skill Gap</div>
                    <div class="text-2xl font-bold dark:text-white">{{ number_format($avgGap, 1) }}%</div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Kursus Berjalan</div>
                    <div class="text-2xl font-bold dark:text-white">{{ $coursesInProgress }}</div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow border-l-4 border-yellow-500">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Rekomendasi</div>
                    <div class="text-2xl font-bold dark:text-white">{{ count($recommendedJobs) }} Lowongan</div>
                </div>
            </div>

            <!-- Charts & Recommendations -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Radar Chart -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow lg:col-span-2 border border-slate-100 dark:border-slate-800">
                    <h4 class="text-lg font-bold text-gray-700 dark:text-slate-200 mb-4">Analisis Kompetensi</h4>
                    <canvas id="skillRadarChart"></canvas>
                </div>

                <!-- Quick Actions / Jobs -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow border border-slate-100 dark:border-slate-800">
                    <h4 class="text-lg font-bold text-gray-700 dark:text-slate-200 mb-4">Lowongan Cocok</h4>
                    <div class="space-y-4">
                        @forelse($recommendedJobs as $job)
                            <div class="border-b dark:border-slate-700 pb-3 last:border-0 flex items-start gap-4">
                                @if($job->banner_image)
                                    <div class="w-16 h-16 rounded-md overflow-hidden shrink-0">
                                        <img src="{{ Storage::url($job->banner_image) }}" alt="Banner" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-md bg-blue-50 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-blue-600 dark:text-blue-400 truncate">{{ $job->title }}</h5>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 truncate">{{ $job->company_name }} • {{ $job->location }}</p>
                                    <span class="inline-block mt-1 px-2 py-1 text-xs bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded">Match: 85%</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Belum ada rekomendasi lowongan.</p>
                        @endforelse
                    </div>
                    <!-- Ganti tombol "Lihat Semua Lowongan" -->
                    <a href="{{ route('seeker.jobs.all') }}"
                        class="block mt-4 w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-sm transition">
                        Lihat Semua Lowongan →
                    </a>
                    {{-- <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-sm">Lihat Semua Lowongan</button> --}}
                </div>
            </div>

        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('skillRadarChart').getContext('2d');
            const data = @json($radarData);
            
            // Periksa mode dark lewat CSS/class atau media query
            const isDarkMode = () => document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;

            const getChartOptions = (isDark) => ({
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: isDark ? '#f8fafc' : '#374151',
                            font: { size: 13, weight: 'bold' }
                        }
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        grid: {
                            color: isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        pointLabels: {
                            color: isDark ? '#e2e8f0' : '#374151',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        },
                        ticks: {
                            backdropColor: 'transparent',
                            color: isDark ? '#cbd5e1' : '#6b7280',
                            font: { size: 10 }
                        },
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                }
            });

            const chart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: data.map(d => d.label),
                    datasets: [{
                        label: 'Skill Saat Ini',
                        data: data.map(d => d.current),
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgb(59, 130, 246)',
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(59, 130, 246)'
                    }, {
                        label: 'Target Industri',
                        data: data.map(d => d.target),
                        fill: true,
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: 'rgb(239, 68, 68)',
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(239, 68, 68)',
                        borderDash: [5, 5]
                    }]
                },
                options: getChartOptions(isDarkMode())
            });

            // Listen for dark mode toggle to update chart colors dynamically
            const observer = new MutationObserver(() => {
                chart.options = getChartOptions(isDarkMode());
                chart.update();
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
</x-app-layout>
