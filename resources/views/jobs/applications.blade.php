<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Status Lamaran Saya</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Pantau progress lamaran kerja Anda dari awal hingga hasil akhir.</p>
                    </div>
                    <a href="{{ route('seeker.jobs.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Lowongan Lain
                    </a>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-blue-500 dark:border-blue-600">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Lamaran</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $counts['total'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-yellow-500 dark:border-yellow-600">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dalam Proses</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $counts['processing'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-green-500 dark:border-green-600">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Diterima</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $counts['offered'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow border-l-4 border-red-500 dark:border-red-600">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $counts['rejected'] }}</p>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border dark:border-slate-700 mb-6">
                <div class="border-b border-gray-200 dark:border-slate-700">
                    <nav class="flex px-4 overflow-x-auto" aria-label="Tabs">
                        @php $statuses = ['all' => 'Semua', 'applied' => 'Dikirim', 'reviewed' => 'Direview', 'interviewed' => 'Interview', 'offered' => 'Diterima', 'rejected' => 'Ditolak']; @endphp
                        @foreach ($statuses as $key => $label)
                        <a href="{{ request()->fullUrlWithQuery(['status' => $key === 'all' ? null : $key]) }}"
                            class="py-4 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition {{ request('status') == $key || (!$key && !request('status')) ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                            {{ $label }}
                        </a>
                        @endforeach
                    </nav>
                </div>
            </div>

            <!-- Applications List -->
            <div class="space-y-4">
                @forelse($applications as $app)
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden border {{ (isset($highlightJobId) && $app->job_listing_id == $highlightJobId) ? 'border-2 border-emerald-500 shadow-emerald-100' : 'border-gray-100 dark:border-slate-700' }}">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                            <!-- Job Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                        {{ substr($app->jobListing->company_name ?? 'NA', 0, 2) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                            {{ $app->jobListing->title ?? 'Lowongan Tidak Ditemukan' }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            {{ $app->jobListing->company_name ?? '-' }}
                                        </p>

                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200">
                                                <svg class="w-3 h-3 mr-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                                {{ $app->jobListing->location ?? '-' }}
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $app->jobListing->work_type == 'remote' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' }}">
                                                {{ ucfirst($app->jobListing->work_type ?? 'onsite') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Match Score & Status -->
                            <div class="flex flex-col items-center lg:items-end gap-4">
                                <div class="text-center lg:text-right">
                                    <div class="relative w-14 h-14 mx-auto lg:mx-0">
                                        <svg class="w-14 h-14 transform -rotate-90">
                                            <circle cx="28" cy="28" r="24" fill="none"
                                                class="stroke-gray-200 dark:stroke-slate-700" stroke-width="4"></circle>
                                            <circle cx="28" cy="28" r="24" fill="none"
                                                stroke="{{ $app->matching_percentage >= 80 ? '#22c55e' : ($app->matching_percentage >= 50 ? '#eab308' : '#ef4444') }}"
                                                stroke-width="4" stroke-dasharray="{{ 2 * M_PI * 24 }}"
                                                stroke-dashoffset="{{ 2 * M_PI * 24 * (1 - $app->matching_percentage / 100) }}"
                                                stroke-linecap="round"></circle>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span
                                                class="text-sm font-bold text-gray-900 dark:text-white">{{ round($app->matching_percentage) }}%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Match Score</p>
                                </div>

                                <div>
                                    @php
                                    $statusConfig = [
                                    'saved' => [
                                    'label' => 'Disimpan',
                                    'class' => 'bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200',
                                    'icon' => 'bookmark',
                                    ],
                                    'applied' => [
                                    'label' => 'Dikirim',
                                    'class' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                                    'icon' => 'send',
                                    ],
                                    'reviewed' => [
                                    'label' => 'Direview',
                                    'class' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300',
                                    'icon' => 'eye',
                                    ],
                                    'interviewed' => [
                                    'label' => 'Interview',
                                    'class' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                    'icon' => 'chat',
                                    ],
                                    'offered' => [
                                    'label' => 'Diterima 🎉',
                                    'class' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                    'icon' => 'check',
                                    ],
                                    'rejected' => [
                                    'label' => 'Ditolak',
                                    'class' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                                    'icon' => 'x',
                                    ],
                                    ];
                                    $status = $statusConfig[$app->status] ?? $statusConfig['applied'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $status['class'] }}">
                                        @if ($status['icon'] == 'check')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        @elseif($status['icon'] == 'x')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        @endif
                                        {{ $status['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Progress -->
                        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3">Timeline Progress</p>
                            <div class="flex items-center justify-between">
                                @php
                                $steps = ['applied', 'reviewed', 'interviewed', 'offered'];
                                $currentStep = array_search($app->status, $steps);
                                if ($app->status === 'rejected') {
                                $currentStep = -1;
                                }
                                if ($app->status === 'saved') {
                                $currentStep = -2;
                                }
                                @endphp

                                @foreach ($steps as $index => $step)
                                @php
                                    $isCompleted = $index <= $currentStep;
                                    $isCurrent = $index == $currentStep;
                                    $labels = ['Dikirim', 'Direview', 'Interview', 'Diterima'];
                                @endphp
                                <div class="flex flex-col items-center flex-1">
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold 
                                                {{ $isCompleted ? 'bg-green-500 text-white' : ($isCurrent ? 'bg-blue-500 text-white ring-4 ring-blue-100 dark:ring-blue-900/30' : 'bg-gray-200 dark:bg-slate-700 text-gray-500 dark:text-gray-400') }}">
                                        @if ($isCompleted && !$isCurrent)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        @else
                                        {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <span
                                        class="text-xs mt-2 text-center {{ $isCompleted ? 'text-gray-900 dark:text-white font-semibold' : 'text-gray-500 dark:text-gray-400' }}">{{ $labels[$index] }}</span>
                                </div>
                                @if (!$loop->last)
                                <div
                                    class="flex-1 h-1 mx-2 {{ $index < $currentStep ? 'bg-green-500' : 'bg-gray-200 dark:bg-slate-700' }}">
                                </div>
                                @endif
                                @endforeach
                            </div>

                            @if ($app->status === 'rejected' && $app->notes)
                            <div class="mt-4 p-3 bg-red-50 dark:bg-red-950/20 rounded-lg border border-red-100 dark:border-red-900/30">
                                <p class="text-sm text-red-700 dark:text-red-300">
                                    <strong>Alasan:</strong> {{ $app->notes }}
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700 flex flex-wrap gap-3">
                            @if ($app->status === 'offered')
                            <button
                                class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Terima Penawaran
                            </button>
                            <button
                                class="px-4 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                Negosiasi
                            </button>
                            @elseif($app->status === 'interviewed')
                            <button
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                Kirim Follow-up Email
                            </button>
                            @elseif($app->status === 'rejected')
                            <button
                                class="px-4 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                Minta Feedback
                            </button>
                            <a href="{{ route('courses.index') }}"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                Tingkatkan Skill
                            </a>
                            @endif

                            <form action="{{ route('seeker.jobs.withdraw', $app->jobListing->id) }}" method="POST" class="ml-auto inline" onsubmit="return confirm('Apakah Anda yakin ingin menarik lamaran Anda untuk posisi {{ $app->jobListing->title }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 text-sm font-medium transition flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Tarik Lamaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-xl shadow border dark:border-slate-700">
                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Belum ada lamaran</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Mulai karir Anda dengan melamar lowongan yang sesuai.</p>
                    <a href="{{ route('seeker.jobs.index') }}"
                        class="mt-6 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        Cari Lowongan Sekarang
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>