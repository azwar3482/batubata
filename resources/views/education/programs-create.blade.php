<x-app-layout>
    @include('partials.quill-styles')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('education.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.dashboard') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('education.programs') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.program') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ __('messages.tambah') }}</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.tambah_program_baru') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.buat_program_kolaborasi_industri') }}</p>
                </div>
                <a href="{{ route('education.programs') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; {{ __('messages.kembali') }}
                </a>
            </div>

            <!-- Progress Steps -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 mb-8 border border-gray-100 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-sm">
                            ✓</div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">{{ __('messages.informasi_dasar') }}</p>
                            <p class="text-xs text-gray-500">{{ __('messages.nama_tipe_durasi') }}</p>
                        </div>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                            2</div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">{{ __('messages.kurikulum') }}</p>
                            <p class="text-xs text-gray-500">{{ __('messages.materi_learning_objectives') }}</p>
                        </div>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-slate-400 flex items-center justify-center font-bold text-sm">
                            3</div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-400 dark:text-slate-400">{{ __('messages.konfirmasi') }}</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500">{{ __('messages.review_publikasi') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('education.programs.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Section 1: Basic Information -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">📋 {{ __('messages.informasi_program') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Program Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.nama_program') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                placeholder="{{ __('messages.contoh_digital_marketing_bootcamp') }}"
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
                                {{ __('messages.jenis_program') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                onchange="updatePreview()">
                                <option value="">{{ __('messages.pilih_jenis') }}</option>
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
                                {{ __('messages.durasi') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="duration" id="duration" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">{{ __('messages.pilih_durasi') }}</option>
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
                                {{ __('messages.kuota_peserta') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="target_students" id="target_students"
                                value="{{ old('target_students') }}" required min="1" max="500"
                                placeholder="{{ __('messages.jumlah_maksimal_peserta') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('target_students')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.tanggal_mulai') }} <span class="text-red-500">*</span>
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
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">🎯 {{ __('messages.deskripsi_tujuan') }}</h3>

                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.deskripsi_program') }} <span class="text-red-500">*</span>
                            </label>
                            <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                            <div id="quill-description"></div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('messages.maksimal_2000_karakter') }}</p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Learning Objectives (Dynamic) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.tujuan_pembelajaran') }} <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 mb-3">{{ __('messages.sebutkan_3_5_kompetensi') }}</p>

                            <div id="objectives-container" class="space-y-3">
                                @foreach (old('learning_objectives', ['']) as $index => $objective)
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="flex-shrink-0 flex items-center justify-center w-8 h-10 bg-gray-100 rounded-lg text-sm font-medium text-gray-600">{{ $index + 1 }}.</span>
                                        <div class="flex-1">
                                            <input id="objective_{{ $index }}" type="hidden" name="learning_objectives[]" value="{{ $objective }}">
                                            <div id="quill-objective_{{ $index }}"></div>
                                        </div>
                                        @if ($index > 0)
                                            <button type="button" onclick="removeObjective(this)"
                                                class="flex-shrink-0 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
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
                                {{ __('messages.tambah_tujuan') }}
                            </button>
                            @error('learning_objectives')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Industry Partners -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">🤝 {{ __('messages.mitra_industri') }}</h3>

                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">{{ __('messages.pilih_perusahaan_mitra') }}</p>

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
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">📚 {{ __('messages.dokumen_kurikulum') }}</h3>

                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-400 transition cursor-pointer"
                            onclick="document.getElementById('curriculum_file').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.upload_silabus_kurikulum') }}</p>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX • {{ __('messages.maksimal_10mb') }}</p>
                            <input type="file" name="curriculum_file" id="curriculum_file"
                                accept=".pdf,.doc,.docx" class="hidden" onchange="previewFile(this)">
                        </div>

                        <div id="file-preview" class="hidden p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p id="file-preview-name" class="text-sm font-medium text-gray-900"></p>
                                        <p id="file-preview-size" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 p-1 rounded-lg hover:bg-red-50 transition" title="{{ __('messages.hapus_file') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
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
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">{{ __('messages.ganti') }}</button>
                            </div>
                        @endif
                        @error('curriculum_file')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Card (Sticky on Desktop) -->
                <div
                    class="bg-gradient-to-br from-green-50 to-teal-50 dark:from-green-900/30 dark:to-teal-900/30 rounded-xl p-6 border border-green-200 dark:border-green-800">
                    <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4">👁️ {{ __('messages.preview_program') }}</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('messages.nama') }}:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-200" id="preview-name">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('messages.jenis') }}:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-200" id="preview-type">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('messages.durasi') }}:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-200" id="preview-duration">-</span>
                        </div>
                        <div class="pt-3 border-t dark:border-slate-700">
                            <p class="text-gray-500 dark:text-gray-400 mb-2">{{ __('messages.deskripsi_singkat') }}:</p>
                            <div class="text-gray-700 dark:text-gray-300 line-clamp-3" id="preview-description">-</div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex items-start mb-6">
                        <input type="checkbox" name="terms" id="terms" required
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500 mt-1">
                        <label for="terms" class="ml-3 text-sm text-gray-600">
                            {{ __('messages.saya_menyatakan_informasi_program_akurat') }}
                        </label>
                    </div>
                    @error('terms')
                        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('education.programs') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                            {{ __('messages.batal') }}
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-teal-800 transition shadow-lg transform hover:-translate-y-0.5">
                            {{ __('messages.publikasikan_program') }}
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
        function addObjective() {
            const container = document.getElementById('objectives-container');
            const index = container.children.length + 1;
            const id = 'objective_new_' + Date.now();
            const quillId = 'quill-' + id;
            const div = document.createElement('div');
            div.className = 'flex items-start gap-3';
            div.innerHTML = `
                <span class="flex-shrink-0 flex items-center justify-center w-8 h-10 bg-gray-100 rounded-lg text-sm font-medium text-gray-600">${index}.</span>
                <div class="flex-1">
                    <input id="${id}" type="hidden" name="learning_objectives[]" required>
                    <div id="${quillId}"></div>
                </div>
                <button type="button" onclick="removeObjective(this)" class="flex-shrink-0 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(div);
            var newQuill = new Quill('#' + quillId, {
                theme: 'snow',
                placeholder: '{{ __("messages.contoh_mampu_membuat_kampanye") }}',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'blockquote'],
                        ['clean']
                    ]
                }
            });
            window.quillEditors[id] = newQuill;
        }

        function removeObjective(btn) {
            if (document.getElementById('objectives-container').children.length > 1) {
                btn.closest('.flex').remove();
                document.querySelectorAll('#objectives-container .flex').forEach((el, idx) => {
                    el.querySelector('span').textContent = (idx + 1) + '.';
                });
            }
        }

        function updatePreview() {
            const name = document.getElementById('name').value || '-';
            const type = document.getElementById('type').options[document.getElementById('type').selectedIndex].text || '-';
            const duration = document.getElementById('duration').options[document.getElementById('duration').selectedIndex]
                .text || '-';
            const description = document.getElementById('description').value || '-';

            document.getElementById('preview-name').textContent = name;
            document.getElementById('preview-type').textContent = type;
            document.getElementById('preview-duration').textContent = duration;
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = description;
            const plainText = tempDiv.textContent || tempDiv.innerText || '';
            document.getElementById('preview-description').textContent = plainText.length > 150 ? plainText.substring(0, 150) + '...' : (plainText || '-');
        }

        function previewFile(input) {
            const preview = document.getElementById('file-preview');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const sizeKB = (file.size / 1024).toFixed(1);
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                const sizeText = file.size > 1024 * 1024 ? sizeMB + ' MB' : sizeKB + ' KB';
                document.getElementById('file-preview-name').textContent = file.name;
                document.getElementById('file-preview-size').textContent = sizeText + ' • ' + '{{ __("messages.siap_diupload") }}';
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        function removeFile() {
            const input = document.getElementById('curriculum_file');
            input.value = '';
            document.getElementById('file-preview').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>

    @vite(['resources/js/quill.js'])
    <script>
    window.quillEditors = {};
    document.addEventListener('DOMContentLoaded', function() {
        var quillDesc = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: '{{ __("messages.jelaskan_secara_detail_program_ini_manfaat") }}',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingDesc = document.getElementById('description').value;
        if (existingDesc) quillDesc.root.innerHTML = existingDesc;
        quillDesc.on('text-change', function() {
            updatePreview();
        });

        document.querySelectorAll('[id^="objective_"]').forEach(function(input) {
            var quillId = 'quill-' + input.id;
            var quillContainer = document.getElementById(quillId);
            if (quillContainer) {
                var q = new Quill('#' + quillId, {
                    theme: 'snow',
                    placeholder: '{{ __("messages.contoh_mampu_membuat_kampanye") }}',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link', 'blockquote'],
                            ['clean']
                        ]
                    }
                });
                if (input.value) q.root.innerHTML = input.value;
                window.quillEditors[input.id] = q;
            }
        });

        var form = document.getElementById('quill-description').closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('description').value = quillDesc.root.innerHTML;
                Object.keys(window.quillEditors).forEach(function(key) {
                    var hiddenInput = document.getElementById(key);
                    if (hiddenInput) {
                        hiddenInput.value = window.quillEditors[key].root.innerHTML;
                    }
                });
            });
        }
    });
    </script>
</x-app-layout>
