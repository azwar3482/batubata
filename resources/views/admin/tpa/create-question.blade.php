<x-app-layout>
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('admin.tpa.questions') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Tambah Soal TPA</h1>

    <form action="{{ route('admin.tpa.questions.store') }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
        @csrf

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="verbal">Verbal</option>
                    <option value="numerik">Numerik</option>
                    <option value="logika">Logika</option>
                    <option value="spasial">Spasial</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sub-kategori</label>
                <input type="text" name="subcategory" class="w-full border rounded-lg px-3 py-2" placeholder="sinonim, aritmetik, dll">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Level</label>
                <select name="difficulty" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="easy">Mudah</option>
                    <option value="medium" selected>Sedang</option>
                    <option value="hard">Sulit</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Teks Soal</label>
            <textarea name="question_text" class="w-full border rounded-lg px-3 py-2" rows="4" required placeholder="Tuliskan soal di sini..."></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Gambar Soal (opsional)</label>
            <input type="file" name="question_image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
        </div>

        <h3 class="font-bold mb-3">Pilihan Jawaban</h3>
        <p class="text-xs text-gray-500 mb-3">Isi minimal 2 pilihan. Pilih jawaban yang benar di radio button.</p>

        <div class="space-y-2 mb-4">
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="A" required>
                <input type="hidden" name="options[0][key]" value="A">
                <span class="font-bold w-8">A.</span>
                <input type="text" name="options[0][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan A" required>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="B">
                <input type="hidden" name="options[1][key]" value="B">
                <span class="font-bold w-8">B.</span>
                <input type="text" name="options[1][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan B" required>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="C">
                <input type="hidden" name="options[2][key]" value="C">
                <span class="font-bold w-8">C.</span>
                <input type="text" name="options[2][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan C">
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="correct_answer" value="D">
                <input type="hidden" name="options[3][key]" value="D">
                <span class="font-bold w-8">D.</span>
                <input type="text" name="options[3][text]" class="flex-1 border rounded-lg px-3 py-2" placeholder="Pilihan D">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Penjelasan Jawaban (opsional)</label>
            <textarea name="explanation" class="w-full border rounded-lg px-3 py-2" rows="2" placeholder="Penjelasan mengapa jawaban tersebut benar..."></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">
            Simpan Soal
        </button>
    </form>
</div>
</x-app-layout>
