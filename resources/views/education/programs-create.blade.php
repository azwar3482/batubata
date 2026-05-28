<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('seeker.education.programs') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Program
                </a>
                <h2 class="text-3xl font-extrabold text-gray-900">Tambah Program Baru</h2>
                <p class="mt-2 text-gray-600">Buat program kolaborasi dengan industri untuk meningkatkan kompetensi
                    lulusan Anda.</p>
            </div>

            <!-- Progress Steps -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-sm">
                            ✓</div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">Informasi Dasar</p>
                            <p class="text-xs text-gray-500">Nama, tipe, durasi</p>
                        </div>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                            2</div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">Kurikulum</p>
                            <p class="text-xs text-gray-500">Materi & learning objectives</p>
                        </div>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold text-sm">
                            3</div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-400">Konfirmasi</p>
                            <p class="text-xs text-gray-400">Review & publikasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('seeker.education.programs.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Section 1: Basic Information -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-4">📋 Informasi Program</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Program Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Program <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                placeholder="Contoh: Digital Marketing Bootcamp 2024"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-lg"
                                oninput="updatePreview()">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Program Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Program <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                onchange="updatePreview()">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach ($programTypes as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi <span class="text-red-500">*</span>
                            </label>
                            <select name="duration" id="duration" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">-- Pilih Durasi --</option>
                                @foreach ($durations as $dur)
                                    <option value="{{ $dur }}" {{ old('duration') == $dur ? 'selected' : '' }}>
                                        {{ $dur }}</option>
                                @endforeach
                            </select>
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Students -->
                        <div>
                            <label for="target_students" class="block text-sm font-medium text-gray-700 mb-2">
                                Kuota Peserta <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="target_students" id="target_students"
                                value="{{ old('target_students') }}" required min="1" max="500"
                                placeholder="Jumlah maksimal peserta"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('target_students')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Description & Objectives -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-4">🎯 Deskripsi & Tujuan</h3>

                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Program <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="4" required
                                placeholder="Jelaskan secara detail tentang program ini, manfaat bagi peserta, dan outline kegiatan..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                oninput="updatePreview()">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 2000 karakter. Gunakan bahasa yang jelas dan
                                menarik.</p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Learning Objectives (Dynamic) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tujuan Pembelajaran <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 mb-3">Sebutkan 3-5 kompetensi yang akan dicapai peserta
                                setelah menyelesaikan program.</p>

                            <div id="objectives-container" class="space-y-3">
                                @foreach (old('learning_objectives', ['']) as $index => $objective)
                                    <div class="flex gap-3">
                                        <span
                                            class="flex items-center justify-center w-8 h-10 bg-gray-100 rounded-lg text-sm font-medium text-gray-600">{{ $index + 1 }}.</span>
                                        <input type="text" name="learning_objectives[]"
                                            value="{{ $objective }}"
                                            placeholder="Contoh: Mampu membuat kampanye digital marketing menggunakan Google Ads"
                                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                        @if ($index > 0)
                                            <button type="button" onclick="removeObjective(this)"
                                                class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" onclick="addObjective()"
                                class="mt-3 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Tujuan
                            </button>
                            @error('learning_objectives')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Industry Partners -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-4">🤝 Mitra Industri</h3>

                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">Pilih perusahaan mitra yang akan terlibat dalam program ini.
                            Mitra dapat menyediakan mentor, studi kasus, atau kesempatan rekrutmen.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($industries as $industry)
                                <label
                                    class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="checkbox" name="industry_partners[]" value="{{ $industry }}"
                                        class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                                        {{ in_array($industry, old('industry_partners', [])) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $industry }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('industry_partners')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section 4: Curriculum Upload -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-4">📚 Dokumen Kurikulum</h3>

                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-400 transition cursor-pointer"
                            onclick="document.getElementById('curriculum_file').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">Upload Silabus/Kurikulum</p>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX • Maksimal 10MB</p>
                            <input type="file" name="curriculum_file" id="curriculum_file"
                                accept=".pdf,.doc,.docx" class="hidden" onchange="previewFile(this)">
                        </div>

                        @if (old('curriculum_file') || session('curriculum_preview'))
                            <div
                                class="p-4 bg-green-50 rounded-lg border border-green-200 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ old('curriculum_file') ? old('curriculum_file')->getClientOriginalName() : 'curriculum.pdf' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ old('curriculum_file') ? round(old('curriculum_file')->getSize() / 1024, 1) : '2.4' }}
                                            MB</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">Ganti</button>
                            </div>
                        @endif
                        @error('curriculum_file')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Card (Sticky on Desktop) -->
                <div
                    class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl p-6 border border-green-200 sticky top-6">
                    <h4 class="font-bold text-gray-900 mb-4">👁️ Preview Program</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama:</span>
                            <span class="font-medium text-gray-900" id="preview-name">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis:</span>
                            <span class="font-medium text-gray-900" id="preview-type">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Durasi:</span>
                            <span class="font-medium text-gray-900" id="preview-duration">-</span>
                        </div>
                        <div class="pt-3 border-t">
                            <p class="text-gray-500 mb-2">Deskripsi Singkat:</p>
                            <p class="text-gray-700 line-clamp-3" id="preview-description">-</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-start mb-6">
                        <input type="checkbox" name="terms" id="terms" required
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500 mt-1">
                        <label for="terms" class="ml-3 text-sm text-gray-600">
                            Saya menyatakan bahwa informasi program ini akurat dan saya memiliki wewenang untuk membuat
                            program atas nama institusi.
                        </label>
                    </div>
                    @error('terms')
                        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('seeker.education.programs') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-teal-800 transition shadow-lg transform hover:-translate-y-0.5">
                            Publikasikan Program
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Dynamic Features -->
    <script>
        // Add Learning Objective Field
        function addObjective() {
            const container = document.getElementById('objectives-container');
            const index = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'flex gap-3';
            div.innerHTML = `
                <span class="flex items-center justify-center w-8 h-10 bg-gray-100 rounded-lg text-sm font-medium text-gray-600">${index}.</span>
                <input type="text" name="learning_objectives[]" required
                    placeholder="Contoh: Mampu membuat kampanye digital marketing menggunakan Google Ads"
                    class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                <button type="button" onclick="removeObjective(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }

        // Remove Learning Objective Field
        function removeObjective(btn) {
            if (document.getElementById('objectives-container').children.length > 1) {
                btn.closest('.flex').remove();
                // Re-number the list
                document.querySelectorAll('#objectives-container .flex').forEach((el, idx) => {
                    el.querySelector('span').textContent = (idx + 1) + '.';
                });
            }
        }

        // Live Preview Update
        function updatePreview() {
            const name = document.getElementById('name').value || '-';
            const type = document.getElementById('type').options[document.getElementById('type').selectedIndex].text || '-';
            const duration = document.getElementById('duration').options[document.getElementById('duration').selectedIndex]
                .text || '-';
            const description = document.getElementById('description').value || '-';

            document.getElementById('preview-name').textContent = name;
            document.getElementById('preview-type').textContent = type;
            document.getElementById('preview-duration').textContent = duration;
            document.getElementById('preview-description').textContent = description.length > 100 ? description.substring(0,
                100) + '...' : description;
        }

        // File Preview
        function previewFile(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024).toFixed(1);
                // Show preview UI (simplified)
                alert(`File terpilih: ${fileName} (${fileSize} KB)`);
            }
        }

        // Initialize preview on load
        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
</x-app-layout>
