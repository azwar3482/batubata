<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Hasil Tes TPA</h1>

    @php
        $totalResults = $results->total();
        $passedCount = $results->where('is_passed', true)->count();
        $failedCount = $results->where('is_passed', false)->count();
        $avgScore = $results->avg('total_score');
        $avgBappenas = $results->avg('bappenas_score');
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $totalResults }}</div>
            <div class="text-xs text-gray-500">Total Peserta</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $passedCount }}</div>
            <div class="text-xs text-gray-500">Lulus</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-red-600">{{ $failedCount }}</div>
            <div class="text-xs text-gray-500">Tidak Lulus</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ number_format($avgScore, 1) }}%</div>
            <div class="text-xs text-gray-500">Rata-rata Total</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ number_format($avgBappenas, 1) }}</div>
            <div class="text-xs text-gray-500">Rata-rata Bappenas</div>
        </div>
    </div>

    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-3">
        <select name="test_id" class="border rounded-lg px-3 py-2">
            <option value="">Semua Tes</option>
            @foreach($tests as $test)
            <option value="{{ $test->id }}" {{ request('test_id') == $test->id ? 'selected' : '' }}>{{ $test->title }}</option>
            @endforeach
        </select>
        <select name="passed" class="border rounded-lg px-3 py-2">
            <option value="">Semua</option>
            <option value="1" {{ request('passed') === '1' ? 'selected' : '' }}>Lulus</option>
            <option value="0" {{ request('passed') === '0' ? 'selected' : '' }}>Tidak Lulus</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Filter</button>
    </form>
    @if($results->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-8 text-center"><p class="text-gray-500">Belum ada hasil.</p></div>
    @else
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50"><tr>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">No</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Peserta</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tes</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Verbal</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Numerik</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Logika</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Spasial</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Total</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Bappenas</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
            </tr></thead>
            <tbody class="divide-y">
                @foreach($results as $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-center text-sm">{{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ $r->is_passed ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center font-bold text-sm">
                                {{ $r->bappenas_score }}
                            </div>
                            <div>
                                <div class="font-medium">{{ $r->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $r->tpaTest->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $r->tpaTest->title }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="text-sm font-medium">{{ $r->verbal_score }}%</div>
                        <div class="w-16 bg-gray-200 rounded-full h-1.5 mx-auto mt-1">
                            <div class="h-1.5 rounded-full {{ $r->verbal_score >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $r->verbal_score }}%"></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="text-sm font-medium">{{ $r->numerik_score }}%</div>
                        <div class="w-16 bg-gray-200 rounded-full h-1.5 mx-auto mt-1">
                            <div class="h-1.5 rounded-full {{ $r->numerik_score >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $r->numerik_score }}%"></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="text-sm font-medium">{{ $r->logika_score }}%</div>
                        <div class="w-16 bg-gray-200 rounded-full h-1.5 mx-auto mt-1">
                            <div class="h-1.5 rounded-full {{ $r->logika_score >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $r->logika_score }}%"></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="text-sm font-medium">{{ $r->spasial_score }}%</div>
                        <div class="w-16 bg-gray-200 rounded-full h-1.5 mx-auto mt-1">
                            <div class="h-1.5 rounded-full {{ $r->spasial_score >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $r->spasial_score }}%"></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="font-bold text-lg">{{ $r->total_score }}%</div>
                        <div class="text-xs text-gray-500">{{ $r->total_correct }}/{{ $r->total_correct + $r->total_wrong + $r->total_unanswered }} soal</div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full {{ $r->is_passed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} font-bold">
                            {{ $r->bappenas_score }}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($r->is_passed)<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Lulus</span>
                        @else<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Tidak Lulus</span>@endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <a href="{{ route('admin.tpa.results.show', $r) }}" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Detail
                            </a>
                            <a href="{{ route('admin.tpa.results.pdf', $r) }}" class="text-red-600 hover:underline text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $results->appends(request()->query())->links() }}</div>
    @endif
</div>
</x-app-layout>
