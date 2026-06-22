<x-app-layout>
<style>
    @keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
    .anim-1{animation:fadeInUp .4s ease-out}
    .anim-2{animation:fadeInUp .4s ease-out .1s forwards;opacity:0}
</style>
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4 anim-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tpa.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tes TPA</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium">Hasil Tes</span>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 anim-1">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Hasil Tes TPA</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Daftar nilai hasil ujian Tes Potensi Akademik peserta.</p>
            </div>
            <a href="{{ route('admin.tpa.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                &laquo; Kembali
            </a>
        </div>

        @php
            $totalResults = $results->total();
            $passedCount = $results->where('is_passed', true)->count();
            $failedCount = $results->where('is_passed', false)->count();
            $avgScore = $results->avg('total_score');
            $avgBappenas = $results->avg('bappenas_score');
        @endphp

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6 anim-2">
            <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalResults }}</div>
                <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Total Peserta</div>
            </div>
            <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $passedCount }}</div>
                <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Lulus</div>
            </div>
            <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $failedCount }}</div>
                <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Tidak Lulus</div>
            </div>
            <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($avgScore, 1) }}%</div>
                <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Rata-rata Total</div>
            </div>
            <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ number_format($avgBappenas, 1) }}</div>
                <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Rata-rata Bappenas</div>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-4 mb-6 flex gap-3 anim-2">
            <select name="test_id" class="border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Semua Tes</option>
                @foreach($tests as $test)
                <option value="{{ $test->id }}" {{ request('test_id') == $test->id ? 'selected' : '' }}>{{ $test->title }}</option>
                @endforeach
            </select>
            <select name="passed" class="border border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Semua Status</option>
                <option value="1" {{ request('passed') === '1' ? 'selected' : '' }}>Lulus</option>
                <option value="0" {{ request('passed') === '0' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
            <button type="submit" class="bg-gray-800 dark:bg-slate-700 hover:bg-gray-700 dark:hover:bg-slate-600 text-white px-5 py-2 rounded-lg text-sm font-semibold transition duration-150 shadow-sm">Filter</button>
        </form>

        @if($results->isEmpty())
        <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm p-12 text-center anim-2">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="text-gray-500 dark:text-slate-400">Belum ada hasil tes yang terdaftar.</p>
        </div>
        @else
        <!-- Results Table -->
        <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden anim-2">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-slate-900/50 text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-center">No</th>
                            <th class="px-6 py-4 text-left">Peserta</th>
                            <th class="px-6 py-4 text-center">Verbal</th>
                            <th class="px-6 py-4 text-center">Numerik</th>
                            <th class="px-6 py-4 text-center">Logika</th>
                            <th class="px-6 py-4 text-center">Spasial</th>
                            <th class="px-6 py-4 text-center">Total</th>
                            <th class="px-6 py-4 text-center">Bappenas</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                        @foreach($results as $r)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-center text-gray-500 dark:text-slate-400 font-medium">
                                {{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($r->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $r->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $r->tpaTest->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $r->verbal_score }}%</div>
                                <div class="w-16 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5 mx-auto mt-1.5">
                                    <div class="h-1.5 rounded-full {{ $r->verbal_score >= 60 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }}" style="width: {{ $r->verbal_score }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $r->numerik_score }}%</div>
                                <div class="w-16 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5 mx-auto mt-1.5">
                                    <div class="h-1.5 rounded-full {{ $r->numerik_score >= 60 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }}" style="width: {{ $r->numerik_score }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $r->logika_score }}%</div>
                                <div class="w-16 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5 mx-auto mt-1.5">
                                    <div class="h-1.5 rounded-full {{ $r->logika_score >= 60 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }}" style="width: {{ $r->logika_score }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $r->spasial_score }}%</div>
                                <div class="w-16 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5 mx-auto mt-1.5">
                                    <div class="h-1.5 rounded-full {{ $r->spasial_score >= 60 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }}" style="width: {{ $r->spasial_score }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="font-bold text-base text-gray-900 dark:text-white">{{ $r->total_score }}%</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $r->total_correct }}/{{ $r->total_correct + $r->total_wrong + $r->total_unanswered }} soal</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full {{ $r->is_passed ? 'bg-green-100/80 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100/80 text-red-700 dark:bg-red-900/30 dark:text-red-400' }} font-bold text-sm">
                                    {{ $r->bappenas_score }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($r->is_passed)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800">
                                        Lulus
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-800">
                                        Tidak Lulus
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.tpa.results.show', $r) }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold text-sm transition duration-150 gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.tpa.results.pdf', $r) }}" class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-semibold text-sm transition duration-150 gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6 anim-2">{{ $results->appends(request()->query())->links() }}</div>
        @endif
    </div>
</div>
</x-app-layout>
