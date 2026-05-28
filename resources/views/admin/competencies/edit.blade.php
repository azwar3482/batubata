<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <a href="{{ route('admin.competencies') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Kompetensi
                </a>
                <h2 class="text-3xl font-extrabold text-gray-900">Edit Kompetensi</h2>
                <p class="mt-2 text-gray-600">Perbarui data spesifikasi kompetensi {{ $competency->name }}.</p>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <form action="{{ route('admin.competencies.update', $competency) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kode -->
                        <div class="md:col-span-1">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Kompetensi <span class="text-red-500">*</span></label>
                            <input type="text" name="code" id="code" required value="{{ old('code', $competency->code) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition uppercase"
                                placeholder="Misal: TECH-01">
                            @error('code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="md:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kompetensi <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" required value="{{ old('name', $competency->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Contoh: Pemrograman Python">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="md:col-span-1">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ old('category', $competency->category) == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Posisi Target -->
                        <div class="md:col-span-1">
                            <label for="position_id" class="block text-sm font-medium text-gray-700 mb-2">Posisi Target <span class="text-red-500">*</span></label>
                            <select name="position_id" id="position_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">-- Pilih Posisi Target --</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id', $competency->position_id) == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Level Minimal -->
                        <div class="md:col-span-1">
                            <label for="min_level_required" class="block text-sm font-medium text-gray-700 mb-2">Level Minimal (1-5) <span class="text-red-500">*</span></label>
                            <input type="number" name="min_level_required" id="min_level_required" required min="1" max="5" value="{{ old('min_level_required', $competency->min_level_required) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Cth: 3">
                            <p class="mt-1 text-xs text-gray-500">1: Novice, 2: Beginner, 3: Competent, 4: Proficient, 5: Expert</p>
                            @error('min_level_required')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Referensi (Opsional) -->
                        <div class="md:col-span-1">
                            <label for="source_reference" class="block text-sm font-medium text-gray-700 mb-2">Sumber/Referensi (Opsional)</label>
                            <input type="text" name="source_reference" id="source_reference" value="{{ old('source_reference', $competency->source_reference) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Link materi/referensi...">
                            @error('source_reference')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="pt-6 border-t border-gray-200 flex justify-end gap-3 mt-6">
                        <a href="{{ route('admin.competencies') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>
