<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Kelola Tes TPA</h1>
        <a href="{{ route('admin.tpa.tests.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">+ Buat Tes</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Lowongan</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Soal</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Waktu</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Passing</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($tests as $test)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $test->title }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $test->jobListing->title ?? 'Global' }}</td>
                    <td class="px-4 py-3 text-center text-sm">{{ $test->total_questions }}</td>
                    <td class="px-4 py-3 text-center text-sm">{{ $test->time_limit_minutes }}m</td>
                    <td class="px-4 py-3 text-center text-sm">{{ $test->passing_score }}%</td>
                    <td class="px-4 py-3 text-center">
                        @if($test->is_active)<span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Aktif</span>
                        @else<span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">Nonaktif</span>@endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.tpa.tests.edit', $test) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.tpa.tests.destroy', $test) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $tests->links() }}</div>
</div>
</x-app-layout>
