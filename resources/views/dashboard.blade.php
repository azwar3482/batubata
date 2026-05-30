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
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Halo, {{ $user->name }}! 👋</h3>
                        <p class="text-gray-600 dark:text-slate-400 mt-2">Siap untuk menutup kesenjangan skill kamu hari ini?</p>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-red-800 dark:text-red-400 px-4 py-3 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-green-800 dark:text-green-400 px-4 py-3 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(!$user->hasCompletedProfile())
                <!-- Onboarding Widget (Opsi A) -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-xl p-6 mb-6 transition-all duration-300">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div>
                            <span class="px-3 py-1 text-xs font-bold text-amber-600 bg-amber-50 dark:text-amber-400 dark:bg-amber-900/30 rounded-full border border-amber-200 dark:border-amber-800">
                                ⚠️ Profil Belum Lengkap
                            </span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-3">Langkah Terakhir Sebelum Mulai Karirmu!</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Lengkapi profil Anda untuk membuka fitur pencarian kerja dan rekomendasi kursus otomatis.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <span class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $user->profile_completion_percentage }}%</span>
                                <p class="text-xs text-gray-400">Kekuatan Profil</p>
                            </div>
                            <div class="w-32 bg-gray-100 dark:bg-slate-800 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full" style="width: {{ $user->profile_completion_percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Checklist -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Step 1: Data Diri (Name, Photo, Phone, Gender, Address) -->
                        @php
                            $step1Complete = !empty($user->name) && !empty($user->photo) && !empty($user->phone) && !empty($user->gender) && !empty($user->address);
                        @endphp
                        @if($step1Complete)
                            <div class="p-4 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-start gap-3">
                                <div class="p-1 bg-green-500 text-white rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">1. Data Diri Lengkap</h4>
                                    <p class="text-xs text-gray-500">Selesai diisi</p>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('profile.edit') }}" class="p-4 rounded-xl border border-gray-200 dark:border-slate-800 flex items-start gap-3 hover:border-blue-300 dark:hover:border-blue-800 transition cursor-pointer bg-white dark:bg-slate-900">
                                <div class="w-6 h-6 flex items-center justify-center border-2 border-blue-500 text-blue-500 rounded-full font-bold text-xs shrink-0">1</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">1. Isi Data Diri</h4>
                                    <p class="text-xs text-gray-500">Nama, Foto, Telepon, Jenis Kelamin, Alamat</p>
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 mt-1 inline-block">Isi Sekarang →</span>
                                </div>
                            </a>
                        @endif

                        <!-- Step 2: Pendidikan & Jurusan -->
                        @php
                            $step2Complete = !empty($user->education_level) && !empty($user->major);
                        @endphp
                        @if($step2Complete)
                            <div class="p-4 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-start gap-3">
                                <div class="p-1 bg-green-500 text-white rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">2. Riwayat Pendidikan</h4>
                                    <p class="text-xs text-gray-500">Selesai diisi</p>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('profile.edit') }}" class="p-4 rounded-xl border border-gray-200 dark:border-slate-800 flex items-start gap-3 hover:border-blue-300 dark:hover:border-blue-800 transition cursor-pointer bg-white dark:bg-slate-900">
                                <div class="w-6 h-6 flex items-center justify-center border-2 border-blue-500 text-blue-500 rounded-full font-bold text-xs shrink-0">2</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">2. Riwayat Pendidikan</h4>
                                    <p class="text-xs text-gray-500">Tingkat Pendidikan, Jurusan</p>
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 mt-1 inline-block">Isi Sekarang →</span>
                                </div>
                            </a>
                        @endif

                        <!-- Step 3: Unggah CV -->
                        @php
                            $step3Complete = !empty($user->cv_path);
                        @endphp
                        @if($step3Complete)
                            <div class="p-4 rounded-xl border border-green-200 bg-green-50/50 dark:border-green-900/30 dark:bg-green-950/10 flex items-start gap-3">
                                <div class="p-1 bg-green-500 text-white rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">3. Unggah Dokumen CV</h4>
                                    <p class="text-xs text-gray-500">Selesai diunggah</p>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('profile.edit') }}" class="p-4 rounded-xl border border-gray-200 dark:border-slate-800 flex items-start gap-3 hover:border-blue-300 dark:hover:border-blue-800 transition cursor-pointer bg-white dark:bg-slate-900">
                                <div class="w-6 h-6 flex items-center justify-center border-2 border-blue-500 text-blue-500 rounded-full font-bold text-xs shrink-0">3</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">3. Unggah CV Anda</h4>
                                    <p class="text-xs text-gray-500">File CV format PDF</p>
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 mt-1 inline-block">Unggah Sekarang →</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

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

    <!-- Driver.js for Tour -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const driver = window.driver.js.driver;

            const tourConfig = {
                showProgress: true,
                nextBtnText: 'Lanjut ➔',
                prevBtnText: '⬅ Kembali',
                doneBtnText: 'Selesai',
                popoverClass: 'driverjs-theme',
                steps: [
                    {
                        popover: {
                            title: '👋 Selamat Datang Job Seeker!',
                            description: 'Mari kita kenali berbagai fitur di dashboard Job Seeker ini untuk membantu Anda mencapai karir impian.',
                            align: 'center'
                        }
                    },
                    {
                        element: 'header',
                        popover: {
                            title: '🌐 Top Navbar',
                            description: 'Di menu atas ini Anda bisa mengubah bahasa (ID/EN), mengaktifkan Dark Mode, melihat notifikasi lowongan, dan mengatur profil.',
                            side: "bottom",
                            align: 'center'
                        }
                    },
                    {
                        element: 'a[href*="dashboard"]',
                        popover: {
                            title: '📊 Dashboard Utama',
                            description: 'Membawa Anda kembali ke halaman ini untuk melihat ringkasan statistik: total asesmen, gap skill, dan lowongan yang cocok.',
                            side: "right",
                            align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/assessment"]',
                        popover: {
                            title: '📝 Asesmen Kompetensi',
                            description: 'Fitur untuk mengikuti tes dan asesmen. AI akan mengukur level skill Anda secara akurat berdasarkan jawaban tes.',
                            side: "right",
                            align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/roadmap"]',
                        popover: {
                            title: '🗺️ Roadmap Karir',
                            description: 'Fitur ini menampilkan peta jalan karir Anda, berisi panduan skill apa saja yang harus dipelajari untuk mencapai target posisi.',
                            side: "right",
                            align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/jobs"]',
                        popover: {
                            title: '💼 Lowongan Pekerjaan',
                            description: 'Temukan berbagai lowongan pekerjaan dan lihat seberapa tinggi skor kecocokan (Fit Score) profil Anda terhadap posisi tersebut.',
                            side: "right",
                            align: 'start'
                        }
                    },
                    {
                        element: 'a[href*="seeker/courses"]',
                        popover: {
                            title: '📚 Kursus & Pembelajaran',
                            description: 'Akses berbagai kursus dan materi pembelajaran. AI merekomendasikan kursus khusus untuk menutupi gap skill Anda.',
                            side: "right",
                            align: 'start'
                        }
                    }
                ]
            };

            const driverObj = driver(tourConfig);
            
            // Auto play saat halaman terbuka
            driverObj.drive();

            const startTourBtn = document.getElementById('start-tour-btn');
            if (startTourBtn) {
                startTourBtn.addEventListener('click', () => {
                    driverObj.drive();
                });
            }
        });
    </script>
    <style>
        /* Driver.js Custom Styling */
        .driverjs-theme {
            font-family: inherit;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        .driver-popover-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1f2937; /* text-gray-900 */
        }
        .driver-popover-description {
            font-size: 13.5px;
            line-height: 1.5;
            color: #4b5563; /* text-gray-600 */
        }
        .driver-popover-footer {
            margin-top: 12px;
        }
        .driver-popover-progress-text {
            font-size: 12px;
            color: #6b7280;
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            html.dark .driverjs-theme {
                background-color: #1e293b; /* bg-slate-800 */
                color: #e2e8f0;
            }
            html.dark .driver-popover-title {
                color: #f8fafc;
            }
            html.dark .driver-popover-description {
                color: #cbd5e1; /* text-slate-300 */
            }
            html.dark .driver-popover-progress-text {
                color: #94a3b8;
            }
            html.dark .driver-popover-footer .driver-popover-btn {
                background-color: #334155;
                color: #f8fafc;
                border: 1px solid #475569;
                text-shadow: none;
            }
            html.dark .driver-popover-footer .driver-popover-btn:hover {
                background-color: #475569;
            }
            html.dark .driver-popover-arrow {
                border-color: #1e293b;
            }
        }
    </style>
</x-app-layout>
