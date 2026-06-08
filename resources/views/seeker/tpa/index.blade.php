<x-app-layout>
@php
    $statusConfig = [
        'invited'     => ['label' => 'Undangan',     'color' => 'blue',    'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        'in_progress' => ['label' => 'Berlangsung',  'color' => 'amber',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        'completed'   => ['label' => 'Selesai',      'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        'expired'     => ['label' => 'Kedaluwarsa',  'color' => 'red',     'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    $colorMap = [
        'blue'    => ['bg' => 'bg-blue-50 dark:bg-blue-900/30',    'text' => 'text-blue-700 dark:text-blue-300',    'border' => 'border-blue-200 dark:border-blue-800',    'badge' => 'bg-blue-100 dark:bg-blue-900/50',    'dot' => 'bg-blue-500', 'ring' => 'ring-blue-500/20', 'icon-bg' => 'bg-blue-100 dark:bg-blue-900/50', 'icon-text' => 'text-blue-600 dark:text-blue-400'],
        'amber'   => ['bg' => 'bg-amber-50 dark:bg-amber-900/30',  'text' => 'text-amber-700 dark:text-amber-300',  'border' => 'border-amber-200 dark:border-amber-800',  'badge' => 'bg-amber-100 dark:bg-amber-900/50',  'dot' => 'bg-amber-500', 'ring' => 'ring-amber-500/20', 'icon-bg' => 'bg-amber-100 dark:bg-amber-900/50', 'icon-text' => 'text-amber-600 dark:text-amber-400'],
        'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300', 'border' => 'border-emerald-200 dark:border-emerald-800', 'badge' => 'bg-emerald-100 dark:bg-emerald-900/50', 'dot' => 'bg-emerald-500', 'ring' => 'ring-emerald-500/20', 'icon-bg' => 'bg-emerald-100 dark:bg-emerald-900/50', 'icon-text' => 'text-emerald-600 dark:text-emerald-400'],
        'red'     => ['bg' => 'bg-red-50 dark:bg-red-900/30',      'text' => 'text-red-700 dark:text-red-300',      'border' => 'border-red-200 dark:border-red-800',      'badge' => 'bg-red-100 dark:bg-red-900/50',      'dot' => 'bg-red-500', 'ring' => 'ring-red-500/20', 'icon-bg' => 'bg-red-100 dark:bg-red-900/50', 'icon-text' => 'text-red-600 dark:text-red-400'],
    ];

    $totalSessions = $stats['total'];
    $passedCount = $stats['passed'];
    $avgScore = $stats['avg_score'];

    $counts = [
        'all' => $stats['total'],
        'invited' => $statusCounts['invited'] ?? 0,
        'in_progress' => $statusCounts['in_progress'] ?? 0,
        'completed' => $statusCounts['completed'] ?? 0,
        'expired' => $statusCounts['expired'] ?? 0,
    ];
@endphp

<style>
    @keyframes fadeInUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .anim-1 { animation: fadeInUp .5s ease-out forwards; }
    .anim-2 { animation: fadeInUp .5s ease-out .1s forwards; opacity:0; }
    .anim-3 { animation: fadeInUp .5s ease-out .2s forwards; opacity:0; }
    .anim-4 { animation: fadeInUp .5s ease-out .3s forwards; opacity:0; }
</style>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-10">

    {{-- ============ HEADER ============ --}}
    <div class="mb-6 anim-1">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Tes TPA</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">Tes TPA</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola undangan dan hasil Tes Potensi Akademik Anda</p>
    </div>

    {{-- ============ INFORMASI CARD ============ --}}
    <div class="mb-8 bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg shadow-blue-500/20 anim-1 relative overflow-hidden border border-white/10">
        <!-- Decorative background shapes -->
        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 right-20 -mb-10 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-50"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center md:items-start">
            <div class="flex-shrink-0 w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-inner">
                <svg class="w-8 h-8 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2 tracking-tight text-white">Pusat Tes Potensi Akademik (TPA)</h2>
                <p class="text-blue-100 mb-5 text-sm leading-relaxed max-w-3xl">
                    Tes ini dirancang untuk mengukur kemampuan kognitif, logika, verbal, numerik, dan spasial Anda. 
                    Setiap perusahaan mungkin memberikan tes dengan bobot dan durasi yang berbeda. Pastikan Anda memiliki koneksi internet yang stabil dan lingkungan yang tenang sebelum mulai mengerjakan tes.
                </p>
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 text-xs font-medium bg-black/20 backdrop-blur-sm px-3.5 py-2 rounded-xl border border-white/10 shadow-sm transition-transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Perhatikan batas waktu
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium bg-black/20 backdrop-blur-sm px-3.5 py-2 rounded-xl border border-white/10 shadow-sm transition-transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Sesi tidak dapat dijeda
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium bg-black/20 backdrop-blur-sm px-3.5 py-2 rounded-xl border border-white/10 shadow-sm transition-transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Hasil terekam otomatis
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ FLASH MESSAGES ============ --}}
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 anim-1">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 anim-1">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Unavailable jobs warning --}}
    @php
        $unavailableJobs = $sessions->filter(fn($s) => $s->jobApplication && $s->jobApplication->jobListing && !$s->jobApplication->jobListing->is_available);
    @endphp
    @if($unavailableJobs->count() > 0)
    <div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 anim-1">
        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div>
            <h3 class="font-semibold text-amber-800 dark:text-amber-300 text-sm">Perhatian</h3>
            <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">{{ $unavailableJobs->count() }} lowongan terkait TPA sudah tidak aktif. Tes masih dapat dikerjakan selama undangan berlaku.</p>
        </div>
    </div>
    @endif

    @if($sessions->isEmpty())
    {{-- ============ EMPTY STATE ============ --}}
    <div class="rounded-2xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-12 text-center anim-2">
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Undangan Tes</h2>
        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">Anda belum memiliki undangan tes TPA dari perusahaan manapun. Undangan akan muncul di sini ketika perusahaan mengirimkan tes untuk Anda.</p>
    </div>

    @else
    {{-- ============ SUMMARY STATS ============ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 anim-2">
        <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Tes</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalSessions }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Lulus</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $passedCount }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Rata-rata Skor</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $avgScore > 0 ? number_format($avgScore, 0) : '-' }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Menunggu</p>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $counts['invited'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ TABS + SEARCH + SORT ============ --}}
    <div class="rounded-xl border border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden anim-3">
        {{-- Tabs --}}
        <div class="border-b border-gray-100 dark:border-slate-700 px-4 sm:px-6">
            <div class="flex items-center gap-1 overflow-x-auto no-scrollbar -mb-px" id="status-tabs">
                <button onclick="filterByStatus('all')" data-status="all"
                    class="status-tab shrink-0 flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 transition-all duration-200 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400">
                    Semua
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">{{ $counts['all'] }}</span>
                </button>
                @foreach($statusConfig as $key => $cfg)
                @if($counts[$key] > 0)
                <button onclick="filterByStatus('{{ $key }}')" data-status="{{ $key }}"
                    class="status-tab shrink-0 flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 transition-all duration-200 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-slate-600">
                    {{ $cfg['label'] }}
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $colorMap[$cfg['color']]['badge'] }} {{ $colorMap[$cfg['color']]['text'] }}">{{ $counts[$key] }}</span>
                </button>
                @endif
                @endforeach
            </div>
        </div>

        {{-- Search & Sort Bar --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 px-4 sm:px-6 py-4 bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-700">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="search-input" placeholder="Cari tes atau perusahaan..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    oninput="filterCards()">
            </div>
            <select id="sort-select" onchange="sortCards()"
                class="px-4 py-2.5 text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%236b7280%22%20d%3D%22M6%208L1%203h10z%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center] pr-8">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
                <option value="score_high">Skor Tertinggi</option>
                <option value="score_low">Skor Terendah</option>
                <option value="status">Status</option>
            </select>
        </div>

        {{-- ============ CARD LIST ============ --}}
        <div class="divide-y divide-gray-100 dark:divide-slate-700" id="cards-container">
            @foreach($sessions as $session)
            @php
                $sc = $statusConfig[$session->status] ?? ['label' => $session->status, 'color' => 'gray', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
                $cc = $colorMap[$sc['color']] ?? $colorMap['blue'];
                $title = $session->tpaTest->title;
                $company = $session->jobApplication->jobListing->company_name ?? '';
                $jobTitle = $session->jobApplication->jobListing->title ?? 'Tes Umum';
                $searchKey = strtolower($title . ' ' . $company . ' ' . $jobTitle);
            @endphp
            <div class="card-item group hover:bg-gray-50/80 dark:hover:bg-slate-700/30 transition-all duration-200"
                 data-status="{{ $session->status }}"
                 data-search="{{ $searchKey }}"
                 data-score="{{ $session->result->bappenas_score ?? 0 }}"
                 data-date="{{ $session->created_at->timestamp }}"
                 data-order-status="{{ $session->status === 'invited' ? 0 : ($session->status === 'in_progress' ? 1 : ($session->status === 'completed' ? 2 : 3)) }}">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        {{-- Left: Status Icon + Info --}}
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            <div class="flex-shrink-0 w-11 h-11 rounded-xl {{ $cc['icon-bg'] }} flex items-center justify-center">
                                <svg class="w-5 h-5 {{ $cc['icon-text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sc['icon'] }}"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white truncate">{{ $title }}</h3>
                                    @if($session->tpa_type === 'offline')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 border border-amber-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Offline
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700 border border-blue-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Online
                                    </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $cc['badge'] }} {{ $cc['text'] }} {{ $cc['border'] }} border">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $cc['dot'] }} {{ $session->status === 'invited' ? 'animate-pulse' : '' }}"></span>
                                        {{ $sc['label'] }}
                                    </span>
                                    @if($session->tpa_type === 'offline' && $session->seeker_response === 'accepted')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Diterima
                                    </span>
                                    @elseif($session->tpa_type === 'offline' && $session->seeker_response === 'reschedule_proposed')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        Reschedule
                                    </span>
                                    @elseif($session->tpa_type === 'offline' && $session->seeker_response === 'declined')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 border border-red-200">
                                        Ditolak
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                    {{ $jobTitle }}
                                    @if($company) <span class="text-gray-400 dark:text-gray-500">-</span> {{ $company }} @endif
                                    @if($session->jobApplication && $session->jobApplication->jobListing && !$session->jobApplication->jobListing->is_available)
                                    <span class="inline-flex items-center gap-1 ml-2 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Ditutup
                                    </span>
                                    @endif
                                </p>

                                {{-- Meta pills --}}
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                                        {{ $session->tpaTest->total_questions }} soal
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $session->tpaTest->time_limit_minutes }} menit
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Passing {{ $session->tpaTest->passing_score }}%
                                    </span>
                                    @if($session->expires_at)
                                    <span class="flex items-center gap-1 {{ $session->expires_at->isPast() ? 'text-red-500 font-semibold' : '' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $session->expires_at->format('d M Y H:i') }}
                                    </span>
                                    @endif
                                </div>

                                {{-- Category tags --}}
                                <div class="flex flex-wrap gap-1.5 mt-2.5">
                                    <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-[10px] font-semibold">Verbal {{ $session->tpaTest->verbal_count }}</span>
                                    <span class="px-2 py-0.5 bg-violet-50 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 rounded text-[10px] font-semibold">Numerik {{ $session->tpaTest->numerik_count }}</span>
                                    <span class="px-2 py-0.5 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded text-[10px] font-semibold">Logika {{ $session->tpaTest->logika_count }}</span>
                                    <span class="px-2 py-0.5 bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 rounded text-[10px] font-semibold">Spasial {{ $session->tpaTest->spasial_count }}</span>
                                </div>

                                {{-- Result preview (completed only) --}}
                                @if($session->result)
                                @php $r = $session->result; @endphp
                                <div class="mt-3 flex items-center gap-3 p-3 rounded-lg {{ $r->is_passed ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800' : 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' }}">
                                    <div class="flex items-center gap-2">
                                        @if($r->is_passed)
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">LULUS</span>
                                        @else
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-sm font-bold text-red-700 dark:text-red-300">TIDAK LULUS</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">|</span>
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Skor: {{ number_format($r->total_score, 0) }}%</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">(Bappenas: {{ $r->bappenas_score }})</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Actions --}}
                        <div class="flex lg:flex-col items-center gap-2 lg:ml-4 shrink-0">
                            @if($session->status === 'invited')
                                @if($session->tpa_type === 'offline')
                                {{-- Offline: tampilkan info jadwal dan link ke detail --}}
                                <a href="{{ route('seeker.tpa.show', $session) }}" class="w-full px-5 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-200 hover:-translate-y-0.5 text-center">
                                    Detail & Respon
                                </a>
                                @if($session->offline_scheduled_at)
                                <div class="text-xs text-center text-gray-500">
                                    {{ $session->offline_scheduled_at->format('d M Y H:i') }}
                                </div>
                                @endif
                                @else
                                {{-- Online: tombol mulai tes --}}
                                <form action="{{ route('seeker.tpa.start', $session) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-200 hover:-translate-y-0.5">
                                        Mulai Tes
                                    </button>
                                </form>
                                @endif

                            @elseif($session->status === 'in_progress')
                            <a href="{{ route('seeker.tpa.test', $session) }}" class="w-full px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-200 hover:-translate-y-0.5 text-center">
                                Lanjutkan
                            </a>

                            @elseif($session->status === 'completed')
                            @if($session->result)
                            <a href="{{ route('seeker.tpa.result', $session) }}" class="w-full px-5 py-2.5 bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 rounded-xl font-bold text-sm hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 text-center">
                                Lihat Hasil
                            </a>
                            @endif

                            @elseif($session->status === 'expired')
                            <span class="px-4 py-2 text-xs font-semibold text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-slate-700 rounded-lg">Kedaluwarsa</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- No results --}}
        <div id="no-results" class="hidden p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada tes yang sesuai filter</p>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">{{ $sessions->links() }}</div>
    @endif
</div>

<script>
let activeStatus = 'all';

function filterByStatus(status) {
    activeStatus = status;
    const tabs = document.querySelectorAll('.status-tab');
    tabs.forEach(tab => {
        const isActive = tab.dataset.status === status;
        if (isActive) {
            tab.className = 'status-tab shrink-0 flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 transition-all duration-200 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400';
        } else {
            tab.className = 'status-tab shrink-0 flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 transition-all duration-200 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-slate-600';
        }
    });
    applyFilters();
}

function applyFilters() {
    const search = document.getElementById('search-input').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.card-item');
    let visible = 0;

    cards.forEach(card => {
        const matchesStatus = activeStatus === 'all' || card.dataset.status === activeStatus;
        const matchesSearch = !search || card.dataset.search.includes(search);
        const show = matchesStatus && matchesSearch;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('no-results').classList.toggle('hidden', visible > 0);
}

function filterCards() {
    applyFilters();
}

function sortCards() {
    const container = document.getElementById('cards-container');
    const cards = Array.from(container.querySelectorAll('.card-item'));
    const sortBy = document.getElementById('sort-select').value;

    cards.sort((a, b) => {
        switch(sortBy) {
            case 'newest': return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            case 'oldest': return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            case 'score_high': return parseInt(b.dataset.score) - parseInt(a.dataset.score);
            case 'score_low': return parseInt(a.dataset.score) - parseInt(b.dataset.score);
            case 'status': return parseInt(a.dataset.orderStatus) - parseInt(b.dataset.orderStatus);
            default: return 0;
        }
    });

    cards.forEach(card => container.appendChild(card));
}
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</x-app-layout>
