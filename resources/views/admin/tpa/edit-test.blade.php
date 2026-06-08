<x-app-layout>
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('admin.tpa.tests') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Edit Tes TPA</h1>
    <form action="{{ route('admin.tpa.tests.update', $test) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
        @csrf @method('PUT')
        <div class="mb-4"><label class="block text-sm font-medium mb-1">Judul</label><input type="text" name="title" value="{{ $test->title }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-1">Deskripsi</label><textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="2">{{ $test->description }}</textarea></div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-1">Waktu (menit)</label><input type="number" name="time_limit_minutes" value="{{ $test->time_limit_minutes }}" class="w-full border rounded-lg px-3 py-2" min="10" max="180" required></div>
            <div><label class="block text-sm font-medium mb-1">Passing Score (%)</label><input type="number" name="passing_score" value="{{ $test->passing_score }}" class="w-full border rounded-lg px-3 py-2" step="0.01" required></div>
        </div>
        <h3 class="font-bold mt-4 mb-3">Jumlah Soal</h3>
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-1">Verbal</label><input type="number" name="verbal_count" value="{{ $test->verbal_count }}" class="w-full border rounded-lg px-3 py-2" min="0"></div>
            <div><label class="block text-sm font-medium mb-1">Numerik</label><input type="number" name="numerik_count" value="{{ $test->numerik_count }}" class="w-full border rounded-lg px-3 py-2" min="0"></div>
            <div><label class="block text-sm font-medium mb-1">Logika</label><input type="number" name="logika_count" value="{{ $test->logika_count }}" class="w-full border rounded-lg px-3 py-2" min="0"></div>
            <div><label class="block text-sm font-medium mb-1">Spasial</label><input type="number" name="spasial_count" value="{{ $test->spasial_count }}" class="w-full border rounded-lg px-3 py-2" min="0"></div>
        </div>
        <h3 class="font-bold mt-4 mb-3">Bobot (%)</h3>
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-1">Verbal</label><input type="number" name="verbal_weight" value="{{ $test->verbal_weight }}" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
            <div><label class="block text-sm font-medium mb-1">Numerik</label><input type="number" name="numerik_weight" value="{{ $test->numerik_weight }}" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
            <div><label class="block text-sm font-medium mb-1">Logika</label><input type="number" name="logika_weight" value="{{ $test->logika_weight }}" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
            <div><label class="block text-sm font-medium mb-1">Spasial</label><input type="number" name="spasial_weight" value="{{ $test->spasial_weight }}" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
        </div>
        <div class="space-y-2 mb-6">
            <label class="flex items-center gap-2"><input type="checkbox" name="randomize_questions" value="1" {{ $test->randomize_questions ? 'checked' : '' }} class="rounded"><span class="text-sm">Acak urutan soal</span></label>
            <label class="flex items-center gap-2"><input type="checkbox" name="randomize_options" value="1" {{ $test->randomize_options ? 'checked' : '' }} class="rounded"><span class="text-sm">Acak pilihan jawaban</span></label>
            <label class="flex items-center gap-2"><input type="checkbox" name="show_result_after" value="1" {{ $test->show_result_after ? 'checked' : '' }} class="rounded"><span class="text-sm">Tampilkan hasil</span></label>
            <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ $test->is_active ? 'checked' : '' }} class="rounded"><span class="text-sm">Aktif</span></label>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Update</button>
    </form>
</div>
</x-app-layout>
