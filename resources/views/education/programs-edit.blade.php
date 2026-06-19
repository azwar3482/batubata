<x-app-layout>
    @include('partials.trix-styles')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('education.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('education.programs') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Program</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Edit</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Program</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Perbarui informasi program: <strong>{{ $program->name }}</strong></p>
                </div>
                <a href="{{ route('education.programs') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; Kembali
                </a>
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('education.programs.update', $program) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Section 1: Basic Information -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">📋 Informasi Program</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Program Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Nama Program <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required
                                placeholder="Contoh: Digital Marketing Bootcamp 2024"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-lg">
                        </div>

                        <!-- Program Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Jenis Program <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach ($programTypes as $type)
                                    <option value="{{ $type }}" {{ old('type', $program->type) == $type ? 'selected' : '' }}>
                                        {{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Durasi <span class="text-red-500">*</span>
                            </label>
                            <select name="duration" id="duration" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">-- Pilih Durasi --</option>
                                @foreach ($durations as $dur)
                                    <option value="{{ $dur }}" {{ old('duration', $program->duration) == $dur ? 'selected' : '' }}>
                                        {{ $dur }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Target Students -->
                        <div>
                            <label for="target_students" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Kuota Peserta <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="target_students" id="target_students"
                                value="{{ old('target_students', $program->max_students) }}" required min="1" max="500"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ old('start_date', $program->start_date?->format('Y-m-d')) }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="active" {{ old('status', $program->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="upcoming" {{ old('status', $program->status) == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="completed" {{ old('status', $program->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Description -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">🎯 Deskripsi & Tujuan</h3>

                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Deskripsi Program <span class="text-red-500">*</span>
                            </label>
                            <input id="description" type="hidden" name="description" value="{{ old('description', $program->description) }}">
                            <trix-editor input="description"
                                class="trix-content w-full border border-gray-300 dark:border-slate-600 rounded-lg"
                                placeholder="Jelaskan secara detail tentang program ini..."></trix-editor>
                        </div>

                        <!-- Learning Objectives -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Tujuan Pembelajaran <span class="text-red-500">*</span>
                            </label>
                            <div id="objectives-container" class="space-y-3">
                                @php
                                    $objectives = old('learning_objectives', $program->learning_objectives ?? ['']);
                                @endphp
                                @foreach ($objectives as $index => $objective)
                                    <div class="flex items-start gap-3">
                                        <span class="flex-shrink-0 flex items-center justify-center w-8 h-10 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm font-medium text-gray-600 dark:text-slate-300">{{ $index + 1 }}.</span>
                                        <div class="flex-1">
                                            <input id="objective_{{ $index }}" type="hidden" name="learning_objectives[]" value="{{ $objective }}">
                                            <trix-editor input="objective_{{ $index }}"
                                                class="trix-content border border-gray-300 dark:border-slate-600 rounded-lg"></trix-editor>
                                        </div>
                                        @if ($index > 0)
                                            <button type="button" onclick="removeObjective(this)"
                                                class="flex-shrink-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addObjective()"
                                class="mt-3 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Tujuan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Industry Partners -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">🤝 Mitra Industri</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($industries as $industry)
                            <label class="flex items-center p-4 border border-gray-200 dark:border-slate-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <input type="checkbox" name="industry_partners[]" value="{{ $industry }}"
                                    class="rounded border-gray-300 dark:border-slate-600 text-green-600 focus:ring-green-500"
                                    {{ in_array($industry, old('industry_partners', $program->industry_partners ?? [])) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-slate-300">{{ $industry }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Section 4: Curriculum Upload -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">📚 Dokumen Kurikulum</h3>

                    <div class="space-y-4">
                        @if ($program->curriculum_path)
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800/50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">File kurikulum saat ini</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ basename($program->curriculum_path) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-xl p-8 text-center hover:border-green-400 transition cursor-pointer"
                            onclick="document.getElementById('curriculum_file').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Upload Silabus/Kurikulum Baru</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400">PDF, DOC, DOCX • Maksimal 10MB</p>
                            <input type="file" name="curriculum_file" id="curriculum_file" accept=".pdf,.doc,.docx" class="hidden">
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('education.programs') }}"
                            class="px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-teal-800 transition shadow-lg">
                            Simpan Perubahan
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addObjective() {
            const container = document.getElementById('objectives-container');
            const index = container.children.length + 1;
            const id = 'objective_new_' + Date.now();
            const div = document.createElement('div');
            div.className = 'flex items-start gap-3';
            div.innerHTML = `
                <span class="flex-shrink-0 flex items-center justify-center w-8 h-10 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm font-medium text-gray-600 dark:text-slate-300">${index}.</span>
                <div class="flex-1">
                    <input id="${id}" type="hidden" name="learning_objectives[]" required>
                    <trix-editor input="${id}" class="trix-content border border-gray-300 dark:border-slate-600 rounded-lg" placeholder="Contoh: Mampu membuat kampanye digital marketing..."></trix-editor>
                </div>
                <button type="button" onclick="removeObjective(this)" class="flex-shrink-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }

        function removeObjective(btn) {
            if (document.getElementById('objectives-container').children.length > 1) {
                btn.closest('.flex').remove();
                document.querySelectorAll('#objectives-container .flex').forEach((el, idx) => {
                    el.querySelector('span').textContent = (idx + 1) + '.';
                });
            }
        }
    </script>
</x-app-layout>
