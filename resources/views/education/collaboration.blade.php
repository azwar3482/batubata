<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('education.partners') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Mitra
                </a>
                <h2 class="text-3xl font-extrabold text-gray-900">Ajukan Kolaborasi</h2>
                <p class="mt-2 text-gray-600">Isi formulir berikut untuk mengajukan proposal kolaborasi dengan mitra
                    industri pilihan Anda.</p>
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
                            <select name="partner_id" id="partner_id" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                onchange="updatePartnerInfo(this.value)">
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach ($partners as $partner)
                                    <option value="{{ $partner['id'] }}"
                                        {{ old('partner_id') == $partner['id'] || request('partner') == $partner['id'] ? 'selected' : '' }}>
                                        {{ $partner['name'] }} - {{ $partner['industry'] }}
                                    </option>
                                @endforeach
                            </select>
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
                            <textarea name="description" id="description" rows="4" required
                                placeholder="Jelaskan secara detail rencana kolaborasi yang Anda ajukan..."
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Maksimal 1000 karakter</p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expected Outcome -->
                        <div>
                            <label for="expected_outcome" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Hasil yang Diharapkan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="expected_outcome" id="expected_outcome" rows="3" required
                                placeholder="Apa manfaat yang diharapkan dari kolaborasi ini untuk kedua belah pihak?"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('expected_outcome') }}</textarea>
                            @error('expected_outcome')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Timeline -->
                        <div>
                            <label for="timeline" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Timeline Pelaksanaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="timeline" id="timeline" value="{{ old('timeline') }}"
                                required placeholder="Contoh: Januari - Juni 2024"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('timeline')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
        const partnerData = @json($partners);

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
</x-app-layout>
