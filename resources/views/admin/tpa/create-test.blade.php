<x-app-layout>
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('admin.tpa.tests') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Buat Tes TPA</h1>
    <form action="{{ route('admin.tpa.tests.store') }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
        @csrf
        <div class="mb-4"><label class="block text-sm font-medium mb-1">Judul</label><input type="text" name="title" value="Tes Potensi Akademik" class="w-full border rounded-lg px-3 py-2" required></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-1">Deskripsi</label><textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="2"></textarea></div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-1">Waktu (menit)</label><input type="number" name="time_limit_minutes" value="60" class="w-full border rounded-lg px-3 py-2" min="10" max="180" required></div>
            <div><label class="block text-sm font-medium mb-1">Passing Score (%)</label><input type="number" name="passing_score" value="60" class="w-full border rounded-lg px-3 py-2" min="0" max="100" step="0.01" required></div>
        </div>
        <h3 class="font-bold mt-4 mb-3">Jumlah Soal</h3>
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-1">Verbal</label><input type="number" name="verbal_count" value="10" class="w-full border rounded-lg px-3 py-2" min="0"></div>
            <div><label class="block text-sm font-medium mb-1">Numerik</label><input type="number" name="numerik_count" value="10" class="w-full border rounded-lg px-3 py-2" min="0"></div>
            <div><label class="block text-sm font-medium mb-1">Logika</label><input type="number" name="logika_count" value="10" class="w-full border rounded-lg px-3 py-2" min="0"></div>
            <div><label class="block text-sm font-medium mb-1">Spasial</label><input type="number" name="spasial_count" value="10" class="w-full border rounded-lg px-3 py-2" min="0"></div>
        </div>
        <h3 class="font-bold mt-4 mb-3">Bobot (%)</h3>
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-1">Verbal</label><input type="number" name="verbal_weight" value="30" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
            <div><label class="block text-sm font-medium mb-1">Numerik</label><input type="number" name="numerik_weight" value="30" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
            <div><label class="block text-sm font-medium mb-1">Logika</label><input type="number" name="logika_weight" value="20" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
            <div><label class="block text-sm font-medium mb-1">Spasial</label><input type="number" name="spasial_weight" value="20" class="w-full border rounded-lg px-3 py-2" step="0.01"></div>
        </div>
        <div class="space-y-2 mb-6">
            <label class="flex items-center gap-2"><input type="checkbox" name="randomize_questions" value="1" checked class="rounded"><span class="text-sm">Acak urutan soal</span></label>
            <label class="flex items-center gap-2"><input type="checkbox" name="randomize_options" value="1" checked class="rounded"><span class="text-sm">Acak pilihan jawaban</span></label>
            <label class="flex items-center gap-2"><input type="checkbox" name="show_result_after" value="1" checked class="rounded"><span class="text-sm">Tampilkan hasil setelah selesai</span></label>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Simpan</button>
    </form>
</div>
</x-app-layout>
