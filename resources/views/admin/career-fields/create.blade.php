<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.career-fields.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
        <h1 class="text-2xl font-bold mb-6">Tambah Bidang Karir</h1>

        <form action="{{ route('admin.career-fields.store') }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Bidang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required placeholder="Teknik Informatika">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded-lg px-3 py-2" required placeholder="teknik-informatika">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Icon (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', '💼') }}" class="w-full border rounded-lg px-3 py-2" placeholder="💻">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Warna</label>
                    <select name="color" class="w-full border rounded-lg px-3 py-2">
                        @foreach(['blue','green','purple','yellow','pink','cyan','indigo','orange','red'] as $color)
                        <option value="{{ $color }}" {{ old('color') === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Permintaan (0-100)</label>
                    <input type="number" name="demand_score" value="{{ old('demand_score', 50) }}" class="w-full border rounded-lg px-3 py-2" min="0" max="100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Contoh Posisi (pisahkan koma)</label>
                <input type="text" name="job_titles" value="{{ old('job_titles') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Web Developer, Mobile Developer, Software Engineer">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Industri Terkait (pisahkan koma)</label>
                <input type="text" name="industries" value="{{ old('industries') }}" class="w-full border rounded-lg px-3 py-2" placeholder="IT, Startup, E-commerce">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min (Rp)</label>
                    <input type="number" name="avg_salary_min" value="{{ old('avg_salary_min') }}" class="w-full border rounded-lg px-3 py-2" placeholder="5000000">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max (Rp)</label>
                    <input type="number" name="avg_salary_max" value="{{ old('avg_salary_max') }}" class="w-full border rounded-lg px-3 py-2" placeholder="25000000">
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm">Aktif</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Simpan</button>
        </form>
    </div>
</div>
</x-app-layout>
