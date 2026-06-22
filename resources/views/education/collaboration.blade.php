<x-app-layout>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow { border-color: #e5e7eb; border-radius: 0.5rem 0.5rem 0 0; background: #f9fafb; }
        .ql-container.ql-snow { border-color: #e5e7eb; border-radius: 0 0 0.5rem 0.5rem; min-height: 150px; font-size: 0.875rem; }
        .ql-editor { min-height: 150px; }
        .dark .ql-toolbar.ql-snow { background: #1e293b; border-color: #334155; }
        .dark .ql-toolbar.ql-snow .ql-stroke { stroke: #cbd5e1; }
        .dark .ql-toolbar.ql-snow .ql-fill { fill: #cbd5e1; }
        .dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
        .dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
        .dark .ql-toolbar.ql-snow .ql-active .ql-stroke { stroke: #3b82f6; }
        .dark .ql-toolbar.ql-snow .ql-active .ql-fill { fill: #3b82f6; }
        .dark .ql-container.ql-snow { background: #1e293b; border-color: #334155; color: #f8fafc; }
        .dark .ql-editor.ql-blank::before { color: #64748b; }
        .dark .ql-snow .ql-picker { color: #cbd5e1; }
        .dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #334155; }
        .ql-snow .ql-tooltip { z-index: 50; }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('education.dashboard') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 text-sm">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <a href="{{ route('education.partners') }}" class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 ml-1 md:ml-2 text-sm">
                                    Mitra
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-900 dark:text-white ml-1 md:ml-2 text-sm font-medium">Ajukan Kolaborasi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Ajukan Kolaborasi</h2>
                <p class="mt-2 text-gray-600 dark:text-slate-400">Isi formulir berikut untuk mengajukan proposal kolaborasi dengan mitra industri pilihan Anda.</p>
            </div>

            <form action="{{ route('education.collaboration.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Step Indicator -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                                1</div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Pilih Mitra</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Tentukan partner kolaborasi</p>
                            </div>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-sm">
                                2</div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Detail Proposal</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Jelaskan rencana kolaborasi</p>
                            </div>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-800 text-gray-400 dark:text-slate-500 flex items-center justify-center font-bold text-sm">
                                3</div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-400 dark:text-slate-500">Konfirmasi</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500">Review & kirim</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 1: Partner Selection -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">🏢 Pilih Mitra Industri</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="partner_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Nama Perusahaan <span class="text-red-500">*</span>
                            </label>

                            <div x-data="{
                                open: false,
                                search: '',
                                selected: '{{ old('partner_id', request('partner')) }}',
                                selectedLabel: '-- Pilih Perusahaan --',
                                options: [
                                    @foreach ($partners as $partner)
                                        { id: '{{ $partner['id'] }}', name: '{{ addslashes($partner['name']) }}', industry: '{{ addslashes($partner['industry']) }}' },
                                    @endforeach
                                ],
                                get filteredOptions() {
                                    if (this.search === '') return this.options;
                                    return this.options.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()) || i.industry.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                selectOption(opt) {
                                    this.selected = opt.id;
                                    this.selectedLabel = opt.name + ' - ' + opt.industry;
                                    this.open = false;
                                    this.search = '';
                                    if (typeof updatePartnerInfo === 'function') {
                                        updatePartnerInfo(this.selected);
                                    }
                                },
                                init() {
                                    if (this.selected) {
                                        const match = this.options.find(o => o.id == this.selected);
                                        if (match) {
                                            this.selectedLabel = match.name + ' - ' + match.industry;
                                            // Delay to ensure global function is declared
                                            setTimeout(() => {
                                                if (typeof updatePartnerInfo === 'function') {
                                                    updatePartnerInfo(this.selected);
                                                }
                                            }, 50);
                                        }
                                    }
                                }
                            }" class="relative w-full" @click.away="open = false" x-init="init()">

                                <input type="text" name="partner_id" id="partner_id" :value="selected" required class="sr-only" tabindex="-1">

                                <div @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
                                    class="flex items-center justify-between w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 cursor-pointer transition"
                                    :class="{'ring-2 ring-indigo-500 border-indigo-500': open}">
                                    <span x-text="selected ? selectedLabel : '-- Pilih Perusahaan --'" :class="{'text-gray-400 dark:text-gray-500': !selected}"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>

                                <div x-show="open" style="display: none;"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg">

                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" placeholder="Cari perusahaan atau industri..."
                                            class="w-full text-sm rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 p-2"
                                            @keydown.escape="open = false"
                                            @keydown.enter.prevent="if(filteredOptions.length > 0) { selectOption(filteredOptions[0]) }"
                                            x-ref="searchInput">
                                    </div>

                                    <ul class="max-h-60 overflow-y-auto p-1 custom-scrollbar">
                                        <template x-for="option in filteredOptions" :key="option.id">
                                            <li @click="selectOption(option)"
                                                class="cursor-pointer px-3 py-2 rounded-lg text-sm transition-colors hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-slate-700 dark:hover:text-indigo-400"
                                                :class="{'bg-indigo-50 text-indigo-600 dark:bg-slate-700 dark:text-indigo-400 font-semibold': selected == option.id, 'text-gray-700 dark:text-slate-200': selected != option.id}">
                                                <span x-text="option.name + ' - ' + option.industry"></span>
                                            </li>
                                        </template>
                                        <li x-show="filteredOptions.length === 0" class="px-3 py-2 text-sm text-gray-500 dark:text-slate-400 text-center">
                                            Perusahaan tidak ditemukan
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @error('partner_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Partner Info Preview -->
                        <div id="partnerPreview" class="hidden p-4 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg border border-indigo-200 dark:border-indigo-800/50">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                                    TC</div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white" id="previewName">Tech Corp Indonesia</p>
                                    <p class="text-sm text-gray-600 dark:text-slate-300" id="previewIndustry">Software House</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1" id="previewContact">partnership@techcorp.id
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Collaboration Details -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📋 Detail Proposal Kolaborasi</h3>

                    <div class="space-y-6">
                        <!-- Collaboration Types -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Jenis Kolaborasi <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($collaborationTypes as $key => $label)
                                    <label
                                        class="flex items-center p-3 border border-gray-200 dark:border-slate-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                        <input type="checkbox" name="collaboration_type[]" value="{{ $key }}"
                                            class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500"
                                            {{ in_array($key, old('collaboration_type', [])) ? 'checked' : '' }}>
                                        <span class="ml-3 text-sm text-gray-700 dark:text-slate-300">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('collaboration_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Judul Proposal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                placeholder="Contoh: Program Magang Digital Marketing 2024"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Deskripsi Proposal <span class="text-red-500">*</span>
                            </label>
                            <input type="hidden" name="description" id="description" value="{{ old('description') }}" required>
                            <div id="quill-description"></div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expected Outcome -->
                        <div>
                            <label for="expected_outcome" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Hasil yang Diharapkan <span class="text-red-500">*</span>
                            </label>
                            <input type="hidden" name="expected_outcome" id="expected_outcome" value="{{ old('expected_outcome') }}" required>
                            <div id="quill-expected_outcome"></div>
                            @error('expected_outcome')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Timeline -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Timeline Pelaksanaan <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="timeline_start" class="block text-xs text-gray-500 dark:text-slate-400 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="timeline_start" id="timeline_start" value="{{ old('timeline_start') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('timeline_start')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="timeline_end" class="block text-xs text-gray-500 dark:text-slate-400 mb-1">Tanggal Selesai</label>
                                    <input type="date" name="timeline_end" id="timeline_end" value="{{ old('timeline_end') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @error('timeline_end')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Contact Information -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">👤 Informasi Kontak</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Nama Kontak Person <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="contact_person" id="contact_person"
                                value="{{ old('contact_person', $institution->user->name ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('contact_person')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Email Kontak <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="contact_email" id="contact_email"
                                value="{{ old('contact_email', $institution->user->email ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('contact_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Nomor Telepon / WhatsApp
                            </label>
                            <input type="tel" name="contact_phone" id="contact_phone"
                                value="{{ old('contact_phone') }}" placeholder="0812-3456-7890"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('contact_phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Attachment -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📎 Lampiran (Opsional)</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Dokumen Pendukung
                            </label>
                            <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx"
                                class="w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900">
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Format: PDF, DOC, DOCX • Maksimal 5MB</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Contoh: Proposal lengkap, company profile, atau
                                dokumen pendukung lainnya</p>
                        </div>
                    </div>
                </div>

                <!-- Terms & Submit -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                    <div class="flex items-start mb-6">
                        <input type="checkbox" name="terms" id="terms" required
                            class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500 mt-1">
                        <label for="terms" class="ml-3 text-sm text-gray-600 dark:text-slate-300">
                            Saya menyatakan bahwa informasi yang diisi adalah benar dan saya setuju dengan
                            <a href="#"
                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium underline">Syarat &
                                Ketentuan</a>
                            pengajuan kolaborasi KOMPASKARIR.
                        </label>
                    </div>
                    @error('terms')
                        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('education.dashboard') }}"
                            class="px-6 py-3 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 transition font-medium text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-800 transition shadow-lg transform hover:-translate-y-0.5">
                            Kirim Proposal Kolaborasi
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Partner Info Data for JavaScript -->
    <script>
        const partnerData = @json($partners instanceof \Illuminate\Contracts\Pagination\Paginator ? $partners->items() : $partners);

        function updatePartnerInfo(partnerId) {
            const preview = document.getElementById('partnerPreview');
            if (!partnerId) {
                preview.classList.add('hidden');
                return;
            }

            const partner = partnerData.find(p => p.id == partnerId);
            if (partner) {
                document.getElementById('previewName').textContent = partner.name;
                document.getElementById('previewIndustry').textContent = partner.industry;
                document.getElementById('previewContact').textContent = partner.contact_email;

                // Update logo initials
                const logoDiv = preview.querySelector('.w-10.h-10');
                logoDiv.textContent = partner.logo;

                preview.classList.remove('hidden');
            }
        }

        // Auto-trigger if partner is pre-selected from URL
        document.addEventListener('DOMContentLoaded', function() {
            const partnerSelect = document.getElementById('partner_id');
            if (partnerSelect.value) {
                updatePartnerInfo(partnerSelect.value);
            }
        });
    </script>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var quillDescription = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: 'Jelaskan secara detail rencana kolaborasi yang Anda ajukan...',
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
        if (existingDesc) quillDescription.root.innerHTML = existingDesc;

        var quillOutcome = new Quill('#quill-expected_outcome', {
            theme: 'snow',
            placeholder: 'Apa manfaat yang diharapkan dari kolaborasi ini untuk kedua belah pihak?',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        var existingOutcome = document.getElementById('expected_outcome').value;
        if (existingOutcome) quillOutcome.root.innerHTML = existingOutcome;

        var form = document.getElementById('quill-description').closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('description').value = quillDescription.root.innerHTML;
                document.getElementById('expected_outcome').value = quillOutcome.root.innerHTML;
            });
        }
    });
    </script>
</x-app-layout>
