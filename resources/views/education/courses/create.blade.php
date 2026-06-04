<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('education.courses.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Kursus
                    </a>
                    <h2 class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Tambah Kursus Baru</h2>
                    <p class="mt-1 text-gray-600 dark:text-slate-400">Lengkapi formulir di bawah ini untuk menambahkan materi pembelajaran baru.</p>
                </div>
            </div>

            <form action="{{ route('education.courses.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Informasi Dasar -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 md:p-8 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Dasar</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Judul Kursus <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors px-4 py-3"
                                placeholder="Contoh: Belajar Python untuk Data Science">
                            @error('title') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="4" required
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors px-4 py-3"
                                placeholder="Jelaskan secara detail materi apa saja yang akan dipelajari...">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="provider" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Provider / Pengajar</label>
                            <input type="text" name="provider" id="provider" value="{{ old('provider') }}"
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors px-4 py-3"
                                placeholder="Contoh: Dicoding, Udemy">
                        </div>
                        <div>
                            <label for="platform" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Platform <span class="text-red-500">*</span></label>
                            <input type="text" name="platform" id="platform" value="{{ old('platform') }}" required
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors px-4 py-3"
                                placeholder="Contoh: Coursera, Dicoding">
                            @error('platform') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Detail Kursus -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 md:p-8 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Detail Kursus</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="competency_id" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kompetensi Terkait <span class="text-red-500">*</span></label>
                            <select name="competency_id" id="competency_id" required
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors px-4 py-3">
                                <option value="">-- Pilih Kompetensi --</option>
                                @foreach($competencies as $comp)
                                <option value="{{ $comp->id }}" {{ old('competency_id') == $comp->id ? 'selected' : '' }}>
                                    {{ $comp->name }} ({{ $comp->category === 'technical' ? 'Teknis' : 'Soft Skill' }})
                                </option>
                                @endforeach
                            </select>
                            @error('competency_id') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors px-4 py-3">
                                <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>Teknis</option>
                                <option value="soft_skill" {{ old('category') === 'soft_skill' ? 'selected' : '' }}>Soft Skill</option>
                            </select>
                            @error('category') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="level" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Level <span class="text-red-500">*</span></label>
                            <select name="level" id="level" required
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors px-4 py-3">
                                <option value="beginner" {{ old('level') === 'beginner' ? 'selected' : '' }}>Beginner (Pemula)</option>
                                <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>Intermediate (Menengah)</option>
                                <option value="advanced" {{ old('level') === 'advanced' ? 'selected' : '' }}>Advanced (Mahir)</option>
                            </select>
                            @error('level') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="duration_hours" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Durasi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="duration_hours" id="duration_hours" value="{{ old('duration_hours') }}" required min="1"
                                    class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors px-4 py-3 pr-16"
                                    placeholder="Contoh: 10">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 dark:text-gray-400 font-medium">
                                    Jam
                                </div>
                            </div>
                            @error('duration_hours') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="url" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">URL Kursus <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <input type="url" name="url" id="url" value="{{ old('url') }}" required
                                    class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors py-3 pl-11 pr-4"
                                    placeholder="https://">
                            </div>
                            @error('url') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="image_url" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">URL Gambar Thumbnail</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                                    class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors py-3 pl-11 pr-4"
                                    placeholder="https://">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label for="skills_covered" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Skill yang Dipelajari</label>
                            <input type="text" name="skills_covered" id="skills_covered" value="{{ old('skills_covered') }}"
                                class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors px-4 py-3"
                                placeholder="Gunakan tanda koma (Contoh: Python, Pandas, NumPy, Matplotlib)">
                            <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Pisahkan setiap skill dengan tanda koma.</p>
                        </div>
                    </div>
                </div>

                <!-- Harga -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 md:p-8 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Harga Kursus</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                        <div class="pt-2 flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }} class="sr-only peer" onchange="document.getElementById('price').disabled = this.checked; if(this.checked) document.getElementById('price').value = '0';">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 dark:peer-focus:ring-amber-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-500"></div>
                                <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-slate-300">Kursus ini Gratis</span>
                            </label>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Harga (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500 dark:text-gray-400 font-medium">
                                    Rp
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0"
                                    class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-colors py-3 pl-12 pr-4 disabled:bg-gray-100 dark:disabled:bg-slate-800 disabled:text-gray-400 dark:disabled:text-slate-500 disabled:cursor-not-allowed"
                                    {{ old('is_free') ? 'disabled' : '' }}>
                            </div>
                            @error('price') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4">
                    <a href="{{ route('education.courses.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 font-medium transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batalkan
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-medium transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Kursus
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>