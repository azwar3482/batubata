<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.career-fields.paths', $careerField) }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
        <h1 class="text-2xl font-bold mb-6">Edit Level Karir</h1>

        <form action="{{ route('admin.career-fields.update-path', [$careerField, $path]) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" class="w-full border rounded-lg px-3 py-2" required>
                        @foreach(['entry','junior','mid','senior','lead','manager'] as $lvl)
                        <option value="{{ $lvl }}" {{ $path->level === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Label Level <span class="text-red-500">*</span></label>
                    <input type="text" name="level_label" value="{{ $path->level_label }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Min</label>
                    <input type="number" name="year_range_min" value="{{ $path->year_range_min }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Max</label>
                    <input type="number" name="year_range_max" value="{{ $path->year_range_max }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3">{{ $path->description }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Skill (koma)</label>
                <input type="text" name="skills_required" value="{{ implode(', ', $path->skills_required ?? []) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Sertifikasi (koma)</label>
                <input type="text" name="certifications" value="{{ implode(', ', $path->certifications ?? []) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kursus (koma)</label>
                <input type="text" name="courses" value="{{ implode(', ', $path->courses ?? []) }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min</label>
                    <input type="number" name="salary_min" value="{{ $path->salary_min }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max</label>
                    <input type="number" name="salary_max" value="{{ $path->salary_max }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tips</label>
                <textarea name="tips" class="w-full border rounded-lg px-3 py-2" rows="2">{{ $path->tips }}</textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Update</button>
        </form>
    </div>
</div>
</x-app-layout>
