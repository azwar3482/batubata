<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Profil Saya</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi pribadi, foto, dan preferensi akun Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Sidebar: Photo & CV Upload (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Profile Photo Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="h-24 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>
                        <div class="px-6 pb-6 relative text-center">

                            <div class="w-32 h-32 mx-auto rounded-full bg-white dark:bg-slate-800 p-1.5 absolute -top-16 left-1/2 -translate-x-1/2 shadow-md">
                                <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-4xl font-bold overflow-hidden ring-4 ring-white dark:ring-slate-900">
                                    @if (Auth::user()->photo)
                                    <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo" class="w-full h-full object-cover">
                                    @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                    @endif
                                </div>
                            </div>

                            <div class="pt-20">
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>

                                <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mt-2 flex justify-center">
                                        <label class="relative cursor-pointer bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200 rounded-xl px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 flex items-center shadow-sm w-full justify-center">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Ganti Foto
                                            <input type="file" name="photo" accept="image/*" class="sr-only" onchange="this.form.submit()">
                                        </label>
                                    </div>
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-2">JPG, GIF, atau PNG. Maks 2MB.</p>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Update Password Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 hover:shadow-md transition-all duration-300 mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-rose-50 dark:bg-rose-950/20 rounded-lg text-rose-600 dark:text-rose-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Ubah Kata Sandi</h3>
                            </div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('put')

                            <div x-data="{ show: false }">
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="current_password" required
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 block p-3 pr-10 transition-all duration-200">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none">
                                        <!-- Eye Icon (Show) -->
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" /></svg>
                                        <!-- Eye Off Icon (Hide) -->
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                    </button>
                                </div>
                                @if($errors->updatePassword->has('current_password'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('current_password') }}</p>
                                @endif
                            </div>

                            <div x-data="{ show: false }">
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="password" required
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 block p-3 pr-10 transition-all duration-200">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none">
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" /></svg>
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                    </button>
                                </div>
                                @if($errors->updatePassword->has('password'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('password') }}</p>
                                @endif
                            </div>

                            <div x-data="{ show: false }">
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="password_confirmation" required
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 block p-3 pr-10 transition-all duration-200">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none">
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" /></svg>
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                    </button>
                                </div>
                                @if($errors->updatePassword->has('password_confirmation'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                                    Simpan Kata Sandi
                                </button>
                            </div>
                            
                            @if (session('status') === 'password-updated')
                                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mt-2 text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 p-2 rounded-lg text-center font-medium border border-green-200 dark:border-green-800">
                                    Kata sandi berhasil diperbarui.
                                </div>
                            @endif
                        </form>
                    </div>


                    @if(Auth::user()->isJobSeeker())
                    <!-- Multi-Document Upload Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 hover:shadow-md transition-all duration-300" x-data="{ selectedFiles: {} }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-emerald-50 dark:bg-emerald-950/20 rounded-lg text-emerald-600 dark:text-emerald-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Dokumen Saya</h3>
                            </div>
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-950/25 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full border border-green-200 dark:border-green-900/40">
                                Dokumen anda lengkap
                            </span>
                        </div>

                        <form action="{{ route('profile.documents.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @php
                            $userDocs = \App\Models\UserDocument::where('user_id', Auth::id())->get()->keyBy('document_type');
                            @endphp

                            @if($errors->hasAny(['documents', 'documents.*']))
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center text-red-600 font-semibold mb-1 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Gagal Mengunggah Dokumen
                                </div>
                                <ul class="list-disc list-inside text-xs text-red-600">
                                    @foreach($errors->get('documents.*') as $errorsArray)
                                    @foreach((array)$errorsArray as $error)
                                    <li>{{ str_replace('documents.', 'Dokumen ', $error) }}</li>
                                    @endforeach
                                    @endforeach
                                    @error('documents')
                                    <li>{{ $message }}</li>
                                    @enderror
                                </ul>
                            </div>
                            @endif

                            <div class="space-y-4 mb-4">
                                @foreach(\App\Models\UserDocument::TYPES as $type => $label)
                                <div class="flex flex-col p-3 border border-slate-200 dark:border-slate-800 rounded-lg bg-slate-50 dark:bg-slate-850/40">
                                    <div class="flex items-center justify-between w-full">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</p>
                                            @if($userDocs->has($type))
                                            <div class="flex items-center mt-1">
                                                @if($userDocs[$type]->status == 'completed')
                                                <span class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Selesai
                                                </span>
                                                @elseif($userDocs[$type]->status == 'processing')
                                                <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center">
                                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                    Diproses...
                                                </span>
                                                @elseif($userDocs[$type]->status == 'failed')
                                                <span class="text-xs text-red-600 dark:text-rose-400 font-semibold flex items-center" title="Perlu diperbaiki">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Ditolak
                                                </span>
                                                @else
                                                <span class="text-xs text-slate-500 dark:text-slate-450 font-semibold">Pending</span>
                                                @endif
                                            </div>
                                            @else
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Belum diunggah</p>
                                            @endif
                                        </div>
                                        <div class="ml-4 shrink-0 flex items-center space-x-2">
                                            @if($userDocs->has($type))
                                            <a href="{{ Storage::url($userDocs[$type]->file_path) }}" target="_blank" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 bg-white dark:bg-slate-800 px-2 py-1 border border-indigo-200 dark:border-indigo-800/40 rounded shadow-sm transition-all">
                                                Preview
                                            </a>
                                            <button type="button" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus dokumen ini?')) document.getElementById('delete-doc-{{ $userDocs[$type]->id }}').submit();" class="text-xs font-bold text-red-600 dark:text-rose-400 hover:text-red-800 dark:hover:text-rose-350 bg-white dark:bg-slate-800 px-2 py-1 border border-red-200 dark:border-rose-900/40 rounded shadow-sm transition-all">
                                                Hapus
                                            </button>
                                            @else
                                            <label class="cursor-pointer text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 bg-white dark:bg-slate-800 px-2 py-1 border border-blue-200 dark:border-blue-900/40 rounded shadow-sm transition-all">
                                                Pilih
                                                <input type="file" name="documents[{{ $type }}]" class="hidden" accept=".pdf" @change="selectedFiles['{{ $type }}'] = $event.target.files.length > 0 ? $event.target.files[0].name : null">
                                            </label>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Dynamic preview for new file selection -->
                                    <template x-if="selectedFiles['{{ $type }}']">
                                        <div class="mt-2 text-xs text-slate-600 dark:text-slate-400 flex items-center bg-blue-50 dark:bg-blue-950/20 p-1.5 rounded border border-blue-100 dark:border-blue-900/40">
                                            <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span class="font-medium">Akan diunggah: </span>
                                            <span class="ml-1 truncate max-w-[150px] sm:max-w-xs" x-text="selectedFiles['{{ $type }}']"></span>
                                        </div>
                                    </template>
                                </div>
                                @endforeach
                            </div>

                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-3 text-center">Hanya menerima format PDF (Maksimal 2MB).</p>

                            <button type="submit" class="w-full py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition shadow-sm">
                                Upload & Proses AI
                            </button>
                        </form>

                        <!-- Hidden Delete Forms -->
                        @foreach(\App\Models\UserDocument::TYPES as $type => $label)
                        @if($userDocs->has($type))
                        <form id="delete-doc-{{ $userDocs[$type]->id }}" action="{{ route('profile.documents.destroy', $userDocs[$type]->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                        @endforeach
                    </div>
                    @endif

                </div>

                <!-- Right Content: Profile Form (lg:col-span-8) -->
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-8">
                        <form action="{{ route('profile.update') }}" method="POST" x-data="{
                            isExtracting: false,
                            education_level: '{{ old('education_level', Auth::user()->education_level) }}',
                            major: '{{ old('major', Auth::user()->major) }}',
                            career_histories: {{ json_encode(old('career_histories', Auth::user()->careerHistories ?? [])) ?: '[]' }},
                            skills: {{ json_encode(old('skills', Auth::user()->skills ?? [])) ?: '[]' }},
                            new_skill: '',
                            languages: {{ json_encode(old('languages', Auth::user()->languages ?? [])) ?: '[]' }},
                            new_language: '',
                            
                            addCareerHistory() {
                                this.career_histories.push({ company_name: '', position: '', start_date: '', end_date: '', is_current: false, description: '' });
                            },
                            removeCareerHistory(index) {
                                this.career_histories.splice(index, 1);
                            },
                            
                            addSkill(e) {
                                e.preventDefault();
                                if(this.new_skill.trim() !== '' && !this.skills.includes(this.new_skill.trim())) {
                                    this.skills.push(this.new_skill.trim());
                                    this.new_skill = '';
                                }
                            },
                            removeSkill(index) {
                                this.skills.splice(index, 1);
                            },
                            
                            addLanguage(e) {
                                e.preventDefault();
                                if(this.new_language.trim() !== '' && !this.languages.includes(this.new_language.trim())) {
                                    this.languages.push(this.new_language.trim());
                                    this.new_language = '';
                                }
                            },
                            removeLanguage(index) {
                                this.languages.splice(index, 1);
                            },

                            async extractIjazah() {
                                this.isExtracting = true;
                                try {
                                    const response = await fetch('{{ route('profile.extract.ijazah') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    });
                                    const data = await response.json();
                                    if(data.success) {
                                        if(data.data.education_level) this.education_level = data.data.education_level;
                                        if(data.data.major) this.major = data.data.major;
                                        alert(data.message || 'Berhasil mengekstrak data dari Ijazah!');
                                    } else {
                                        alert(data.message || 'Gagal mengekstrak data.');
                                    }
                                } catch(error) {
                                    alert('Terjadi kesalahan jaringan.');
                                }
                                this.isExtracting = false;
                            }
                        }">
                            @csrf
                            @method('PATCH')

                            <div class="flex items-center mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                                <div class="p-2 bg-blue-50 dark:bg-blue-950/20 rounded-lg text-blue-600 dark:text-blue-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Informasi Dasar</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Nama -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                </div>

                                <!-- Email (Disabled) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                                    <div class="relative">
                                        <input type="email" value="{{ Auth::user()->email }}" disabled
                                            class="w-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-750 text-slate-500 dark:text-slate-450 text-sm rounded-xl block p-3 cursor-not-allowed">
                                        <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" value="{{ Auth::user()->birth_date }}"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                </div>

                                <!-- Telepon -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">No. Telepon</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Contoh: 08123456789"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                </div>

                                <!-- Pengalaman -->
                                @if(Auth::user()->role === 'job_seeker')
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Pengalaman Kerja</label>
                                    <div class="relative">
                                        <input type="number" name="experience_years" value="{{ Auth::user()->experience_years }}" min="0" placeholder="0"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                        <span class="absolute right-4 top-3.5 text-xs text-slate-400 dark:text-slate-500 font-medium">Tahun</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if(Auth::user()->role === 'job_seeker')
                            <div class="flex items-center mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-950/20 rounded-lg text-indigo-600 dark:text-indigo-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Latar Belakang & Tautan</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Pendidikan -->
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pendidikan Terakhir</label>
                                        <button type="button" @click="extractIjazah" :disabled="isExtracting" class="text-xs bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 px-2 py-1 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900/30 font-semibold transition-colors disabled:opacity-50">
                                            <span x-show="!isExtracting">✨ Isi Otomatis dari Ijazah</span>
                                            <span x-show="isExtracting">Sedang memproses...</span>
                                        </button>
                                    </div>
                                    <select name="education_level" x-model="education_level" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block p-3 transition-all duration-200">
                                        <option value="" disabled>Pilih Tingkat Pendidikan</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">Diploma 3 (D3)</option>
                                        <option value="S1">Strata 1 (S1)</option>
                                        <option value="S2">Strata 2 (S2)</option>
                                    </select>
                                </div>

                                <!-- Jurusan -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Program Studi / Jurusan</label>
                                    <input type="text" name="major" x-model="major" placeholder="Contoh: Teknik Informatika"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block p-3 transition-all duration-200">
                                </div>

                                <!-- LinkedIn -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Profil LinkedIn</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                            </svg>
                                        </div>
                                        <input type="url" name="linkedin_url" value="{{ Auth::user()->linkedin_url ?? '' }}" placeholder="https://linkedin.com/in/..."
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block pl-10 p-3 transition-all duration-200">
                                    </div>
                                </div>

                                <!-- Portfolio/Github -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Portfolio / GitHub</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                            </svg>
                                        </div>
                                        <input type="url" name="portfolio_url" value="{{ Auth::user()->portfolio_url ?? '' }}" placeholder="https://github.com/..."
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 block pl-10 p-3 transition-all duration-200">
                                    </div>
                                </div>
                            </div>

                            <!-- Keahlian & Bahasa -->
                            <div class="flex items-center mb-6 pb-4 border-b border-slate-100 dark:border-slate-800 mt-8">
                                <div class="p-2 bg-purple-50 dark:bg-purple-950/20 rounded-lg text-purple-600 dark:text-purple-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Keahlian & Bahasa</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Keahlian -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Keahlian (Skills)</label>
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="new_skill" @keydown.enter="addSkill($event)" placeholder="Ketik keahlian (contoh: PHP) lalu Enter"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-l-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 block p-3 transition-all duration-200">
                                        <button type="button" @click="addSkill" class="px-4 py-3 bg-purple-600 dark:bg-purple-500 hover:bg-purple-700 dark:hover:bg-purple-600 text-white rounded-r-xl text-sm font-semibold transition-colors">Tambah</button>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(skill, index) in skills" :key="index">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-950/30 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800/40">
                                                <input type="hidden" :name="'skills['+index+']'" :value="skill">
                                                <span x-text="skill"></span>
                                                <button type="button" @click="removeSkill(index)" class="ml-1.5 text-purple-500 hover:text-purple-700">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-2">Tambahkan lebih dari 1 keahlian teknis/non-teknis.</p>
                                </div>

                                <!-- Bahasa -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Bahasa yang Dikuasai</label>
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="new_language" @keydown.enter="addLanguage($event)" placeholder="Ketik bahasa (contoh: Inggris) lalu Enter"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-l-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 block p-3 transition-all duration-200">
                                        <button type="button" @click="addLanguage" class="px-4 py-3 bg-purple-600 dark:bg-purple-500 hover:bg-purple-700 dark:hover:bg-purple-600 text-white rounded-r-xl text-sm font-semibold transition-colors">Tambah</button>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(lang, index) in languages" :key="index">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-950/30 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800/40">
                                                <input type="hidden" :name="'languages['+index+']'" :value="lang">
                                                <span x-text="lang"></span>
                                                <button type="button" @click="removeLanguage(index)" class="ml-1.5 text-blue-500 hover:text-blue-700">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Karier -->
                            <div class="flex items-center mb-6 pb-4 border-b border-slate-100 dark:border-slate-800 mt-8">
                                <div class="p-2 bg-green-50 dark:bg-green-950/20 rounded-lg text-green-600 dark:text-green-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Riwayat Karier</h3>
                                <button type="button" @click="addCareerHistory" class="ml-auto px-4 py-1.5 text-xs font-semibold bg-green-50 dark:bg-green-950/30 text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800/50 transition-colors">
                                    + Tambah Pengalaman
                                </button>
                            </div>
                            <div class="space-y-6 mb-8">
                                <template x-for="(history, index) in career_histories" :key="index">
                                    <div class="p-5 border border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50 dark:bg-slate-900/60 relative group">
                                        <button type="button" @click="removeCareerHistory(index)" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Riwayat">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Nama Perusahaan / Organisasi</label>
                                                <input type="text" x-model="history.company_name" :name="'career_histories['+index+'][company_name]'" required class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Posisi / Jabatan</label>
                                                <input type="text" x-model="history.position" :name="'career_histories['+index+'][position]'" required class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Tanggal Mulai</label>
                                                <input type="date" x-model="history.start_date" :name="'career_histories['+index+'][start_date]'" required class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Tanggal Berakhir</label>
                                                <input type="date" x-model="history.end_date" :name="'career_histories['+index+'][end_date]'" :disabled="history.is_current" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 disabled:bg-slate-100 dark:disabled:bg-slate-850">
                                                <div class="mt-2 flex items-center">
                                                    <input type="checkbox" x-model="history.is_current" :name="'career_histories['+index+'][is_current]'" value="1" class="rounded text-green-600 focus:ring-green-500 mr-2">
                                                    <span class="text-xs text-slate-600 dark:text-slate-400">Saat ini masih bekerja di sini</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Deskripsi Pekerjaan (Opsional)</label>
                                            <textarea x-model="history.description" :name="'career_histories['+index+'][description]'" rows="2" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500"></textarea>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="career_histories.length === 0" class="text-center py-6 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50 dark:bg-slate-900/40">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada riwayat karier yang ditambahkan.</p>
                                </div>
                            </div>
                            <!-- Preferensi Pekerjaan -->
                            <div class="flex items-center mb-6 pb-4 border-b border-slate-100 dark:border-slate-800 mt-8">
                                <div class="p-2 bg-teal-50 dark:bg-teal-950/20 rounded-lg text-teal-600 dark:text-teal-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Preferensi Pekerjaan</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Jenis Pekerjaan yang Diharapkan</label>
                                    <select name="expected_job_type" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 block p-3 transition-all duration-200">
                                        <option value="" disabled {{ !Auth::user()->expected_job_type ? 'selected' : '' }}>Pilih Jenis Pekerjaan</option>
                                        @foreach($positions ?? [] as $position)
                                        <option value="{{ $position->name }}" {{ Auth::user()->expected_job_type == $position->name ? 'selected' : '' }}>{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Gaji yang Diharapkan (IDR)</label>
                                    <input type="number" name="expected_salary" value="{{ Auth::user()->expected_salary }}" placeholder="Contoh: 8000000" min="0" step="100000"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 block p-3 transition-all duration-200">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Catatan Preferensi Pekerjaan</label>
                                    <textarea name="job_preferences" rows="2" placeholder="Contoh: Bersedia ditempatkan di luar kota, preferensi WFH, dll..."
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 block p-3 transition-all duration-200">{{ Auth::user()->job_preferences }}</textarea>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center mb-6 pb-4 border-b border-slate-100 dark:border-slate-800 mt-8">
                                <div class="p-2 bg-orange-50 dark:bg-orange-950/20 rounded-lg text-orange-600 dark:text-orange-400 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Lokasi & Alamat (Geolokasi)</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-6 mb-8">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                                    <textarea name="address" rows="2" placeholder="Contoh: Jl. Sudirman No. 1, Jakarta Pusat"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">{{ Auth::user()->address ?? '' }}</textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Latitude</label>
                                        <input type="text" id="input-lat" name="latitude" value="{{ Auth::user()->latitude ?? '' }}"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl p-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Longitude</label>
                                        <input type="text" id="input-lng" name="longitude" value="{{ Auth::user()->longitude ?? '' }}"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl p-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <button type="button" onclick="getBrowserLocation()" class="px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-700 dark:hover:bg-slate-650 text-white text-sm rounded-lg transition-colors">
                                        📍 Ambil Koordinat Saat Ini (Browser GPS)
                                    </button>
                                    <span id="geo-status" class="ml-3 text-sm text-slate-500 dark:text-slate-400"></span>
                                </div>
                            </div>

                            <script>
                                function getBrowserLocation() {
                                    const status = document.getElementById('geo-status');
                                    status.textContent = "Mencari lokasi...";

                                    if (!navigator.geolocation) {
                                        status.textContent = "Geolokasi tidak didukung oleh browser Anda.";
                                        return;
                                    }

                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            document.getElementById('input-lat').value = position.coords.latitude;
                                            document.getElementById('input-lng').value = position.coords.longitude;
                                            status.textContent = "✅ Koordinat berhasil didapatkan!";
                                        },
                                        (error) => {
                                            status.textContent = "❌ Gagal mendapatkan lokasi: " + error.message;
                                        }
                                    );
                                }
                            </script>

                            <div class="mb-8 mt-8 border-t border-slate-100 dark:border-slate-800 pt-8">
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Ringkasan Pribadi</label>
                                <textarea name="bio" rows="4" placeholder="Ceritakan singkat tentang diri Anda, keahlian, dan tujuan karir..."
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">{{ Auth::user()->bio ?? '' }}</textarea>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-2 text-right">Tuliskan profil/ringkasan yang menarik untuk memikat perekrut.</p>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
                                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750 rounded-xl transition-colors">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 active:scale-95 transition-all duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                    </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>