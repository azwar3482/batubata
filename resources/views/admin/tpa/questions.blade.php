<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Bank Soal TPA</h1>
        <a href="{{ route('admin.tpa.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">+ Tambah Soal</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari soal..." class="flex-1 border rounded-lg px-3 py-2">
        <select name="category" class="border rounded-lg px-3 py-2">
            <option value="">Semua Kategori</option>
            <option value="verbal" {{ request('category') === 'verbal' ? 'selected' : '' }}>Verbal</option>
            <option value="numerik" {{ request('category') === 'numerik' ? 'selected' : '' }}>Numerik</option>
            <option value="logika" {{ request('category') === 'logika' ? 'selected' : '' }}>Logika</option>
            <option value="spasial" {{ request('category') === 'spasial' ? 'selected' : '' }}>Spasial</option>
        </select>
        <select name="difficulty" class="border rounded-lg px-3 py-2">
            <option value="">Semua Level</option>
            <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Mudah</option>
            <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Sedang</option>
            <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Sulit</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Filter</button>
    </form>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Soal</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Sub</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Level</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Jawaban</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($questions as $q)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">{{ Str::limit($q->question_text, 80) }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $q->category === 'verbal' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $q->category === 'numerik' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $q->category === 'logika' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $q->category === 'spasial' ? 'bg-orange-100 text-orange-700' : '' }}">
                            {{ $q->category_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-500">{{ $q->subcategory ?? '-' }}</td>
                    <td class="px-4 py-3 text-center text-sm">{{ $q->difficulty_label }}</td>
                    <td class="px-4 py-3 text-center font-bold">{{ $q->correct_answer }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($q->is_active)<span class="text-green-600 text-xs">Aktif</span>
                        @else<span class="text-gray-400 text-xs">Nonaktif</span>@endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.tpa.questions.edit', $q) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.tpa.questions.destroy', $q) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
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
    <div class="mt-4">{{ $questions->appends(request()->query())->links() }}</div>
</div>
</x-app-layout>
