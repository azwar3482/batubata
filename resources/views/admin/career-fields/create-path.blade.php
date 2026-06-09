<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.career-fields.paths', $careerField) }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">&laquo; Kembali</a>
        <h1 class="text-2xl font-bold mb-6">Tambah Level Karir</h1>

        <form action="{{ route('admin.career-fields.store-path', $careerField) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="entry">Entry</option>
                        <option value="junior">Junior</option>
                        <option value="mid">Mid</option>
                        <option value="senior">Senior</option>
                        <option value="lead">Lead</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Label Level <span class="text-red-500">*</span></label>
                    <input type="text" name="level_label" class="w-full border rounded-lg px-3 py-2" required placeholder="Junior Developer">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Min</label>
                    <input type="number" name="year_range_min" class="w-full border rounded-lg px-3 py-2" min="0" placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tahun Max</label>
                    <input type="number" name="year_range_max" class="w-full border rounded-lg px-3 py-2" min="0" placeholder="2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Skill yang Dibutuhkan (koma)</label>
                <input type="text" name="skills_required" class="w-full border rounded-lg px-3 py-2" placeholder="HTML, CSS, JavaScript, PHP">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Sertifikasi (koma)</label>
                <input type="text" name="certifications" class="w-full border rounded-lg px-3 py-2" placeholder="AWS Certified, Google ML">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kursus (koma)</label>
                <input type="text" name="courses" class="w-full border rounded-lg px-3 py-2" placeholder="Belajar Web Dev, Advanced Laravel">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Min (Rp)</label>
                    <input type="number" name="salary_min" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji Max (Rp)</label>
                    <input type="number" name="salary_max" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tips</label>
                <textarea name="tips" class="w-full border rounded-lg px-3 py-2" rows="2" placeholder="Tips untuk mencapai level ini..."></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">Simpan</button>
        </form>
    </div>
</div>
</x-app-layout>
