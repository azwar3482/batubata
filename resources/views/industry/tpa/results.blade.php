<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Hasil Tes TPA 66</h1>

        <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-3">
            <select name="test_id" class="border rounded-lg px-3 py-2">
                <option value="">Semua Tes</option>
                @foreach($tests as $test)
                <option value="{{ $test->id }}" {{ request('test_id') == $test->id ? 'selected' : '' }}>{{ $test->title }}</option>
                @endforeach
            </select>
            <select name="passed" class="border rounded-lg px-3 py-2">
                <option value="">Semua Status</option>
                <option value="1" {{ request('passed') === '1' ? 'selected' : '' }}>Lulus</option>
                <option value="0" {{ request('passed') === '0' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Filter</button>
        </form>

        @if($results->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <p class="text-gray-500">Belum ada hasil tes TPA.</p>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kandidat</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tes</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Verbal</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Numerik</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Logika</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Spasial</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Total</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Bappenas</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($results as $result)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $result->user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $result->tpaTest->title }}</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $result->verbal_score }}%</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $result->numerik_score }}%</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $result->logika_score }}%</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $result->spasial_score }}%</td>
                        <td class="px-4 py-3 text-center font-bold">{{ $result->total_score }}%</td>
                        <td class="px-4 py-3 text-center">{{ $result->bappenas_score }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($result->is_passed)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Lulus</span>
                            @else
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Tidak Lulus</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('industry.tpa.results.show', $result) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
                                <a href="{{ route('industry.tpa.results.pdf', $result) }}" class="text-red-600 hover:underline text-sm">PDF</a>
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