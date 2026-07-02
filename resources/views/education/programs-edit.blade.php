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
                <span class="text-gray-900 dark:text-white font-medium">{{ __('messages.edit') }}</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.edit_program') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">{{ __('messages.perbarui_informasi_program') }}: <strong>{{ $program->name }}</strong></p>
                </div>
                <a href="{{ route('education.programs') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; {{ __('messages.kembali') }}
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
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">📋 {{ __('messages.informasi_program') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Program Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.nama_program') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required
                                placeholder="{{ __('messages.contoh_digital_marketing_bootcamp') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-lg">
                        </div>

                        <!-- Program Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.jenis_program') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">{{ __('messages.pilih_jenis') }}</option>
                                @foreach ($programTypes as $type)
                                    <option value="{{ $type }}" {{ old('type', $program->type) == $type ? 'selected' : '' }}>
                                        {{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.durasi') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="duration" id="duration" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">{{ __('messages.pilih_durasi') }}</option>
                                @foreach ($durations as $dur)
                                    <option value="{{ $dur }}" {{ old('duration', $program->duration) == $dur ? 'selected' : '' }}>
                                        {{ $dur }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Target Students -->
                        <div>
                            <label for="target_students" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.kuota_peserta') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="target_students" id="target_students"
                                value="{{ old('target_students', $program->max_students) }}" required min="1" max="500"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.tanggal_mulai') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ old('start_date', $program->start_date?->format('Y-m-d')) }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.status') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="active" {{ old('status', $program->status) == 'active' ? 'selected' : '' }}>{{ __('messages.aktif') }}</option>
                                <option value="upcoming" {{ old('status', $program->status) == 'upcoming' ? 'selected' : '' }}>{{ __('messages.akan_datang') }}</option>
                                <option value="completed" {{ old('status', $program->status) == 'completed' ? 'selected' : '' }}>{{ __('messages.selesai') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Description -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">🎯 {{ __('messages.deskripsi_tujuan') }}</h3>

                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.deskripsi_program') }} <span class="text-red-500">*</span>
                            </label>
                            <input id="description" type="hidden" name="description" value="{{ old('description', $program->description) }}">
                            <div id="quill-description"></div>
                        </div>

                        <!-- Learning Objectives -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('messages.tujuan_pembelajaran') }} <span class="text-red-500">*</span>
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
                                            <div id="quill-objective_{{ $index }}"></div>
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
                                {{ __('messages.tambah_tujuan') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Industry Partners -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">🤝 {{ __('messages.mitra_industri') }}</h3>

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
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-slate-700 pb-4">📚 {{ __('messages.dokumen_kurikulum') }}</h3>

                    <div class="space-y-4">
                        @if ($program->curriculum_path)
                            @php
                                $curriculumExt = strtolower(pathinfo($program->curriculum_path, PATHINFO_EXTENSION));
                                $isPdf = $curriculumExt === 'pdf';
                                $fileUrl = Storage::url($program->curriculum_path);
                            @endphp
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.file_kurikulum_saat_ini') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ basename($program->curriculum_path) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if ($isPdf)
                                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition"
                                                title="{{ __('messages.lihat_file') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ __('messages.lihat') }}
                                            </a>
                                        @endif
                                        <a href="{{ $fileUrl }}" download="{{ basename($program->curriculum_path) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition"
                                            title="{{ __('messages.download_file') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            {{ __('messages.download') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-xl p-8 text-center hover:border-green-400 transition cursor-pointer"
                            onclick="document.getElementById('curriculum_file').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.upload_silabus_kurikulum_baru') }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400">PDF, DOC, DOCX • {{ __('messages.maksimal_10mb') }}</p>
                            <input type="file" name="curriculum_file" id="curriculum_file" accept=".pdf,.doc,.docx" class="hidden" onchange="previewFile(this)">
                        </div>

                        <div id="file-preview" class="hidden p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800/50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p id="file-preview-name" class="text-sm font-medium text-gray-900 dark:text-white"></p>
                                        <p id="file-preview-size" class="text-xs text-gray-500 dark:text-slate-400"></p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition" title="{{ __('messages.hapus_file') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('education.programs') }}"
                            class="px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition font-medium text-center">
                            {{ __('messages.batal') }}
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-teal-800 transition shadow-lg">
                            {{ __('messages.simpan_perubahan') }}
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
            const quillId = 'quill-' + id;
            const div = document.createElement('div');
            div.className = 'flex items-start gap-3';
            div.innerHTML = `
                <span class="flex-shrink-0 flex items-center justify-center w-8 h-10 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm font-medium text-gray-600 dark:text-slate-300">${index}.</span>
                <div class="flex-1">
                    <input id="${id}" type="hidden" name="learning_objectives[]" required>
                    <div id="${quillId}"></div>
                </div>
                <button type="button" onclick="removeObjective(this)" class="flex-shrink-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition">
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
    </script>

    @vite(['resources/js/quill.js'])
    <script>
    window.quillEditors = {};
    document.addEventListener('DOMContentLoaded', function() {
        var quillDesc = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: '{{ __("messages.jelaskan_secara_detail_program_ini") }}',
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
