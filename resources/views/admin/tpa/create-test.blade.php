<x-app-layout>
    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        .trix-button-group { background: white; }
        .dark .trix-button-group { background: #1e293b; border-color: #334155; }
        .dark trix-toolbar [data-trix-button] { color: #cbd5e1; border-color: #334155; }
        .dark trix-toolbar [data-trix-button]:hover { background: #334155; }
        .dark trix-toolbar [data-trix-button].trix-active { background: #475569; color: white; }
        trix-editor { min-height: 120px; }
        .dark trix-editor { background-color: #1e293b; color: #f8fafc; border-color: #334155; }
        .trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
        .trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
        .trix-content a { color: #3b82f6; text-decoration: underline; }
        .trix-content strong { font-weight: 700; }
        .trix-content h1 { font-size: 1.5rem; font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; }
    </style>

<div class="max-w-3xl mx-auto px-4 py-8">
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.tpa.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">TPA</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Tambah Tes</span>
    </nav>
    <a href="{{ route('admin.tpa.tests') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Buat Tes TPA</h1>
    <form action="{{ route('admin.tpa.tests.store') }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
        @csrf
        <div class="mb-4"><label class="block text-sm font-medium mb-1">Judul</label><input type="text" name="title" value="Tes Potensi Akademik" class="w-full border rounded-lg px-3 py-2" required></div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <input type="hidden" name="description" id="description" value="{{ old('description') }}">
            <trix-editor input="description" class="trix-content bg-white dark:bg-slate-800 border rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-gray-100" placeholder="Tuliskan deskripsi atau instruksi tes TPA di sini..."></trix-editor>
        </div>
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
