<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.career-fields.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
        <h1 class="text-2xl font-bold mb-6">Edit Bidang Karir</h1>

        <form action="{{ route('admin.career-fields.update', $careerField) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Bidang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $careerField->name) }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $careerField->slug) }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3">{{ old('description', $careerField->description) }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $careerField->icon) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Warna</label>
                    <select name="color" class="w-full border rounded-lg px-3 py-2">
                        @foreach(['blue','green','purple','yellow','pink','cyan','indigo','orange','red'] as $color)
                        <option value="{{ $color }}" {{ old('color', $careerField->color) === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Permintaan</label>
                    <input type="number" name="demand_score" value="{{ old('demand_score', $careerField->demand_score) }}" class="w-full border rounded-lg px-3 py-2" min="0" max="100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Contoh Posisi (koma)</label>
                <input type="text" name="job_titles" value="{{ old('job_titles', implode(', ', $careerField->job_titles ?? [])) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Industri (koma)</label>
                <input type="text" name="industries" value="{{ old('industries', implode(', ', $careerField->industries ?? [])) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min</label>
                    <input type="number" name="avg_salary_min" value="{{ old('avg_salary_min', $careerField->avg_salary_min) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max</label>
                    <input type="number" name="avg_salary_max" value="{{ old('avg_salary_max', $careerField->avg_salary_max) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $careerField->is_active) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm">Aktif</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Update</button>
        </form>
    </div>
</div>
</x-app-layout>
