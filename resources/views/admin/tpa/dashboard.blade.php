<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 sm:p-8 mb-8 text-white shadow-lg flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-white/10 rounded-xl shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-1">Dashboard TPA</h1>
                <p class="text-blue-100 text-sm sm:text-base">Ringkasan statistik dan hasil Tes Potensi Akademik.</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.tpa.questions') }}" class="bg-indigo-800/50 hover:bg-indigo-800 text-white font-medium px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Bank Soal
            </a>
            <a href="{{ route('admin.tpa.tests') }}" class="bg-indigo-800/50 hover:bg-indigo-800 text-white font-medium px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Tes TPA
            </a>
            <a href="{{ route('admin.tpa.results') }}" class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Hasil Tes
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-5 sm:p-6 transition-all hover:shadow-md">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Soal</div>
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalQuestions }}</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-5 sm:p-6 transition-all hover:shadow-md">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Tes</div>
            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totalTests }}</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-5 sm:p-6 transition-all hover:shadow-md">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Peserta</div>
            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_taken'] }}</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-5 sm:p-6 transition-all hover:shadow-md">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Tingkat Kelulusan</div>
            <div class="text-3xl font-bold {{ $stats['pass_rate'] >= 60 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">{{ $stats['pass_rate'] }}%</div>
        </div>
    </div>

    <!-- Charts / Stats Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Rata-rata Skor per Kategori -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-6">
            <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6">Rata-rata Skor per Kategori</h2>
            <div class="space-y-5">
                @foreach(['verbal' => 'Verbal', 'numerik' => 'Numerik', 'logika' => 'Logika', 'spasial' => 'Spasial'] as $key => $label)
                <div>
                    <div class="flex justify-between text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
                        <span>{{ $label }}</span>
                        <span>{{ $stats['avg_' . $key] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2.5">
                        <div class="bg-blue-500 dark:bg-blue-400 h-2.5 rounded-full transition-all duration-500" style="width: {{ $stats['avg_' . $key] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Statistik General -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-6">
            <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6">Statistik Keseluruhan</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                    <span class="text-slate-600 dark:text-slate-400 text-sm font-medium">Total Peserta Tes</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $stats['total_taken'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/30">
                    <span class="text-emerald-700 dark:text-emerald-400 text-sm font-medium">Lulus Tes</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['total_passed'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-xl bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800/30">
                    <span class="text-rose-700 dark:text-rose-400 text-sm font-medium">Tidak Lulus</span>
                    <span class="font-bold text-rose-600 dark:text-rose-400">{{ $stats['total_failed'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-xl bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30">
                    <span class="text-blue-700 dark:text-blue-400 text-sm font-medium">Rata-rata Skor Keseluruhan</span>
                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $stats['avg_score'] }}%</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-800/30">
                    <span class="text-indigo-700 dark:text-indigo-400 text-sm font-medium">Estimasi Skor Bappenas</span>
                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['avg_bappenas'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Results Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">Hasil Terbaru</h2>
            <a href="{{ route('admin.tpa.results') }}" class="text-sm text-blue-600 dark:text-blue-400 font-medium hover:underline">Lihat Semua</a>
        </div>
        
        @if($recentResults->isEmpty())
        <div class="p-8 text-center text-slate-500 dark:text-slate-400">
            Belum ada data hasil tes.
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Peserta</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tes</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Skor Akhir</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Skor Bappenas</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50">
                    @foreach($recentResults as $index => $r)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 text-center">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $r->user->name }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $r->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-700 dark:text-slate-300">{{ $r->tpaTest->title }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $r->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $r->total_score }}%</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $r->bappenas_score }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($r->is_passed)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    Lulus
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                    Tidak Lulus
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
</x-app-layout>
