<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('education.courses.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">
                    &larr; Kembali ke Daftar Kursus
                </a>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">Edit Kursus</h2>
            </div>

            <form action="{{ route('education.courses.update', $course) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Judul Kursus *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Deskripsi *</label>
                            <textarea name="description" id="description" rows="4" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $course->description) }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Provider / Pengajar</label>
                            <input type="text" name="provider" id="provider" value="{{ old('provider', $course->provider) }}"
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Platform *</label>
                            <input type="text" name="platform" id="platform" value="{{ old('platform', $course->platform) }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('platform') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Kursus</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="competency_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kompetensi Terkait *</label>
                            <select name="competency_id" id="competency_id" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Kompetensi</option>
                                @foreach($competencies as $comp)
                                <option value="{{ $comp->id }}" {{ old('competency_id', $course->competency_id) == $comp->id ? 'selected' : '' }}>
                                    {{ $comp->name }} ({{ $comp->category === 'technical' ? 'Teknis' : 'Soft Skill' }})
                                </option>
                                @endforeach
                            </select>
                            @error('competency_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kategori *</label>
                            <select name="category" id="category" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="technical" {{ old('category', $course->category) === 'technical' ? 'selected' : '' }}>Teknis</option>
                                <option value="soft_skill" {{ old('category', $course->category) === 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                            </select>
                        </div>
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Level *</label>
                            <select name="level" id="level" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                        <div>
                            <label for="duration_hours" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Durasi (jam) *</label>
                            <input type="number" name="duration_hours" id="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" required min="1"
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">URL Kursus *</label>
                            <input type="url" name="url" id="url" value="{{ old('url', $course->url) }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">URL Gambar Thumbnail</label>
                            <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $course->image_url) }}"
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="skills_covered" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Skill yang Dipelajari (pisahkan koma)</label>
                            <input type="text" name="skills_covered" id="skills_covered" 
                                value="{{ old('skills_covered', $course->skills_covered ? implode(', ', $course->skills_covered) : '') }}"
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Harga</h3>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-slate-700 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="document.getElementById('price').disabled = this.checked">
                            <span class="ml-2 text-sm text-gray-700 dark:text-slate-300">Gratis</span>
                        </label>
                        <div class="flex-1">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Harga (Rp)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $course->price) }}" min="0"
                                class="w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                {{ old('is_free', $course->is_free) ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('education.courses.index') }}"
                        class="px-6 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Perbarui Kursus
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
