<x-app-layout>
    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileForm', () => ({
            isExtracting: false,
            saving: false,
            successMessage: '',
            errorMessage: '',
            education_level: '{{ addslashes(old("education_level", Auth::user()->education_level ?? "")) }}',
            major: '{{ addslashes(old("major", Auth::user()->major ?? "")) }}',
            career_histories: JSON.parse('{!! addslashes(json_encode(old("career_histories", Auth::user()->careerHistories ?? []))) !!}'),
            skills: JSON.parse('{!! addslashes(json_encode(old("skills", Auth::user()->skills ?? []))) !!}'),
            new_skill: '',
            languages: JSON.parse('{!! addslashes(json_encode(old("languages", Auth::user()->languages ?? []))) !!}'),
            new_language: '',
            positions: JSON.parse('{!! addslashes(json_encode($positions->pluck('name'))) !!}'),
            
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
                    const response = await fetch('{{ route("profile.extract.ijazah") }}', {
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
            },

            async submitForm(event) {
                event.preventDefault();
                this.saving = true;
                this.successMessage = '';
                this.errorMessage = '';

                try {
                    const form = document.getElementById('profile-update-form');
                    const formData = new FormData(form);
                    
                    // Set education_level and major from Alpine state
                    formData.set('education_level', this.education_level || '');
                    formData.set('major', this.major || '');
                    
                    if (this.skills && this.skills.length > 0) {
                        this.skills.forEach((skill, index) => {
                            formData.set('skills[' + index + ']', skill);
                        });
                    }
                    
                    if (this.languages && this.languages.length > 0) {
                        this.languages.forEach((lang, index) => {
                            formData.set('languages[' + index + ']', lang);
                        });
                    }
                    
                    if (this.career_histories && this.career_histories.length > 0) {
                        this.career_histories.forEach((history, index) => {
                            formData.set('career_histories[' + index + '][company_name]', history.company_name || '');
                            formData.set('career_histories[' + index + '][position]', history.position || '');
                            formData.set('career_histories[' + index + '][start_date]', history.start_date || '');
                            if (!history.is_current && history.end_date) {
                                formData.set('career_histories[' + index + '][end_date]', history.end_date);
                            }
                            formData.set('career_histories[' + index + '][is_current]', history.is_current ? '1' : '0');
                            formData.set('career_histories[' + index + '][description]', history.description || '');
                        });
                    }

                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.successMessage = data.message || 'Profil berhasil diperbarui!';
                        setTimeout(() => { this.successMessage = ''; }, 5000);
                    } else {
                        if (data.errors) {
                            this.errorMessage = Object.values(data.errors).flat().join('\n');
                        } else {
                            this.errorMessage = data.message || 'Gagal menyimpan profil.';
                        }
                    }
                } catch (error) {
                    console.error('Submit error:', error);
                    this.errorMessage = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                }
                this.saving = false;
            }
        }));
    });
    </script>
    <style>
        .trix-button-group {
            background: white;
        }

        .dark .trix-button-group {
            background: #1e293b;
            border-color: #334155;
        }

        .dark trix-toolbar [data-trix-button] {
            color: #cbd5e1;
            border-color: #334155;
        }

        .dark trix-toolbar [data-trix-button]:hover {
            background: #334155;
        }

        .dark trix-toolbar [data-trix-button].trix-active {
            background: #475569;
            color: white;
        }

        trix-editor {
            min-height: 200px;
        }

        .dark trix-editor {
            background-color: #1e293b;
            color: #f8fafc;
            border-color: #334155;
        }

        .trix-content ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .trix-content ol {
            list-style-type: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .trix-content a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .trix-content strong {
            font-weight: 700;
        }

        .trix-content h1 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Profil Saya</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi pribadi, foto, dan preferensi akun Anda.</p>
            </div>

            {{-- Success Notification --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl flex items-center gap-3">
                <div class="p-1 bg-green-500 text-white rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif

            {{-- Error Notification --}}
            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl flex items-center gap-3">
                <div class="p-1 bg-red-500 text-white rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</p>
                <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any() && !$errors->hasAny(['documents', 'documents.*', 'current_password', 'password', 'photo']))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-1 bg-red-500 text-white rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-red-800 dark:text-red-300">Terdapat kesalahan:</p>
                    <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        @if(!str_contains($error, 'Dokumen') && !str_contains($error, 'sandi') && !str_contains($error, 'password'))
                        <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="profileForm()">

                <!-- Left Sidebar: Photo & CV Upload (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Profile Photo Card -->
                    <div x-data="webcamUpload()" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="h-24 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>
                        <div class="px-6 pb-6 relative text-center">

                                <div class="w-32 h-32 mx-auto rounded-full bg-white dark:bg-slate-800 p-1.5 absolute -top-16 left-1/2 -translate-x-1/2 shadow-md">
                                <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-4xl font-bold overflow-hidden ring-4 ring-white dark:ring-slate-900">
                                    @php $photoDoc = Auth::user()->documents->where('document_type', 'photo')->first(); @endphp
                                    @if ($photoDoc)
                                    <img src="{{ Storage::url($photoDoc->file_path) }}" alt="Photo" class="w-full h-full object-cover">
                                    @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                    @endif
                                </div>
                            </div>

                            <div class="pt-20">
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>

                                <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data" id="photoForm"
                                    x-data="{ uploading: false }" @submit="uploading = true">
                                    @csrf

                                    <div x-show="uploading" class="mt-2 flex items-center justify-center gap-2 py-2">
                                        <svg class="w-5 h-5 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-blue-600">Mengunggah foto...</span>
                                    </div>

                                    <div x-show="!uploading" class="mt-2 flex justify-center gap-2">
                                        <label class="relative cursor-pointer bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200 rounded-xl px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 flex items-center shadow-sm justify-center flex-1">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            </svg>
                                            Pilih File
                                            <input type="file" name="photo" accept="image/*" class="sr-only" onchange="this.form.submit()" id="photoInput">
                                        </label>

                                        <button type="button" @click="openCamera()" class="bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-800/50 transition-all duration-200 rounded-xl px-4 py-2 text-sm font-medium text-indigo-700 dark:text-indigo-300 flex items-center shadow-sm justify-center flex-1">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Kamera
                                        </button>
                                    </div>
                                    <p x-show="!uploading" class="text-[11px] text-slate-400 dark:text-slate-500 mt-2">JPG, GIF, atau PNG. Maks 2MB.</p>
                                </form>

                                <!-- Webcam Modal -->
                                <div x-show="showWebcam" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-75 backdrop-blur-sm">
                                    <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-2xl w-full max-w-md relative">
                                        <button @click="closeCamera()" type="button" class="absolute top-4 right-4 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <h3 class="text-lg font-bold mb-4 text-slate-900 dark:text-white text-left">Ambil Foto</h3>
                                        <div class="relative bg-black rounded-lg overflow-hidden aspect-square mb-4">
                                            <video x-ref="video" class="w-full h-full object-cover transform -scale-x-100" autoplay playsinline muted></video>
                                        </div>
                                        <div class="flex justify-center gap-4">
                                            <button @click="takeSnapshot()" type="button" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl flex items-center shadow-md transition-all w-full justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                </svg>
                                                Jepret & Simpan
                                            </button>
                                        </div>
                                        <canvas x-ref="canvas" style="display: none;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->role === 'job_seeker')
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 hover:shadow-md transition-all duration-300 mt-6">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-indigo-50 dark:bg-indigo-950/20 rounded-lg text-indigo-600 dark:text-indigo-400 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Latar Belakang & Tautan</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mb-8">
                            <!-- Pendidikan -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                                    <button type="button" @click="extractIjazah" :disabled="isExtracting" class="text-xs bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 px-2 py-1 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900/30 font-semibold transition-colors disabled:opacity-50">
                                        <span x-show="!isExtracting">✨ Isi Otomatis dari Ijazah</span>
                                        <span x-show="isExtracting">Sedang memproses...</span>
                                    </button>
                                </div>
                                <select name="education_level" form="profile-update-form" x-model="education_level" @change="if(education_level === 'Tidak Sekolah') major = ''" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block p-3 transition-all duration-200">
                                    <option value="" disabled>Pilih Tingkat Pendidikan</option>
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="D3">Diploma 3 (D3)</option>
                                    <option value="S1">Strata 1 (S1)</option>
                                    <option value="S2">Strata 2 (S2)</option>
                                    <option value="S3">Strata 3 (S3)</option>
                                    <option value="Prof">Profesor (Prof)</option>
                                    <option value="Gelar Non Akademik">Gelar Non Akademik</option>
                                </select>
                                @error('education_level') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Jurusan -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Program Studi / Jurusan <span class="text-red-500" x-show="education_level !== 'Tidak Sekolah'">*</span></label>
                                <input type="text" name="major" form="profile-update-form" x-model="major" placeholder="Contoh: Teknik Informatika"
                                    :disabled="education_level === 'Tidak Sekolah'"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block p-3 transition-all duration-200 disabled:opacity-50 disabled:bg-slate-100 dark:disabled:bg-slate-800">
                                @error('major') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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
                                    <input type="url" name="linkedin_url" form="profile-update-form" value="{{ Auth::user()->linkedin_url ?? '' }}" placeholder="https://linkedin.com/in/..."
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
                                    <input type="url" name="portfolio_url" form="profile-update-form" value="{{ Auth::user()->portfolio_url ?? '' }}" placeholder="https://github.com/..."
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 block pl-10 p-3 transition-all duration-200">
                                </div>
                            </div>
                        </div>

                        <!-- Keahlian & Bahasa -->
                    </div>
                    @endif

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

                        <form method="post" action="{{ route('password.update') }}" class="space-y-4"
                            x-data="{ show: false, loading: false }" @submit="loading = true">
                            @csrf
                            @method('put')

                            <div x-data="{ show: false }">
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="current_password" required
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 block p-3 pr-10 transition-all duration-200">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none">
                                        <!-- Eye Icon (Show) -->
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <!-- Eye Off Icon (Hide) -->
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
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
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
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
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @if($errors->updatePassword->has('password_confirmation'))
                                <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm flex items-center justify-center gap-2" :disabled="loading">
                                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Kata Sandi'"></span>
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

                        <form action="{{ route('profile.documents.upload') }}" method="POST" enctype="multipart/form-data"
                            x-data="{ uploading: false }" @submit="uploading = true">
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
                                            <label class="cursor-pointer text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 bg-white dark:bg-slate-800 px-2 py-1 border border-blue-200 dark:border-blue-900/40 rounded shadow-sm transition-all">
                                                Ubah
                                                <input type="file" name="documents[{{ $type }}]" class="hidden" accept=".pdf" @change="selectedFiles['{{ $type }}'] = $event.target.files.length > 0 ? $event.target.files[0].name : null">
                                            </label>
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

                            <button type="submit" class="w-full py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition shadow-sm flex items-center justify-center gap-2" :disabled="uploading">
                                <svg x-show="uploading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="uploading ? 'Mengunggah & Memproses...' : 'Upload & Proses AI'"></span>
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

                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8">
                        <div class="flex items-center mb-6">
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
                                <textarea form="profile-update-form" name="address" rows="2" placeholder="Contoh: Jl. Sudirman No. 1, Jakarta Pusat"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">{{ Auth::user()->address ?? '' }}</textarea>
                                @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Latitude</label>
                                    <input form="profile-update-form" type="text" id="input-lat" name="latitude" value="{{ Auth::user()->latitude ?? '' }}"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl p-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Longitude</label>
                                    <input form="profile-update-form" type="text" id="input-lng" name="longitude" value="{{ Auth::user()->longitude ?? '' }}"
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

                    </div>


                </div>

                <!-- Right Content: Profile Form (lg:col-span-8) -->
                <div class="lg:col-span-8">
                    <div>
                        <form id="profile-update-form" action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            <div hidden>
                                @csrf
                                @method('PATCH')
                            </div>

                            {{-- AJAX Success Message --}}
                            <div x-show="successMessage" x-transition x-cloak class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl flex items-center gap-3">
                                <div class="p-1 bg-green-500 text-white rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-green-800 dark:text-green-300" x-text="successMessage"></p>
                            </div>

                            {{-- AJAX Error Message --}}
                            <div x-show="errorMessage" x-transition x-cloak class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl flex items-start gap-3">
                                <div class="p-1 bg-red-500 text-white rounded-full mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-red-800 dark:text-red-300">Gagal menyimpan:</p>
                                    <p class="text-sm text-red-700 dark:text-red-400 whitespace-pre-line" x-text="errorMessage"></p>
                                </div>
                            </div>

                            @if($errors->any() && !$errors->hasAny(['documents', 'documents.*', 'current_password', 'password']))
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r shadow-sm">
                                <div class="flex items-center text-red-800 font-bold mb-2 text-sm">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Terdapat kesalahan pada isian form:
                                </div>
                                <ul class="list-disc list-inside text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                    @if(!str_contains($error, 'Dokumen') && !str_contains($error, 'sandi') && !str_contains($error, 'password'))
                                    <li>{{ $error }}</li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif


                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8">
                                <div class="flex items-center mb-6">
                                    <div class="p-2 bg-blue-50 dark:bg-blue-950/20 rounded-lg text-blue-600 dark:text-blue-400 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Informasi Dasar</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <!-- ID Pelamar -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">ID Pelamar</label>
                                        <div class="relative">
                                            <input type="text" value="{{ Auth::user()->id }}" disabled
                                                class="w-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-750 text-slate-500 dark:text-slate-450 text-sm rounded-xl block p-3 cursor-not-allowed font-mono">
                                            <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Nama -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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
                                        @error('birth_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Telepon -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">No. Telepon</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Contoh: 08123456789"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                                        <select name="gender" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                            <option value="" disabled {{ empty(Auth::user()->gender) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                            <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Golongan Darah -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Golongan Darah</label>
                                        <select name="blood_type" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-all duration-200">
                                            <option value="" {{ empty(Auth::user()->blood_type) ? 'selected' : '' }}>Belum Diketahui</option>
                                            <option value="A" {{ Auth::user()->blood_type == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ Auth::user()->blood_type == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ Auth::user()->blood_type == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ Auth::user()->blood_type == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                        @error('blood_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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
                                        @error('experience_years') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if(Auth::user()->role === 'job_seeker')
                            <!-- CV Preview Accordion -->
                            <div x-data="{ open: false }" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8 hover:shadow-md transition-all duration-300 mb-6">
                                <button @click="open = !open" type="button" class="flex items-center justify-between w-full focus:outline-none">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-blue-50 dark:bg-blue-950/20 rounded-lg text-blue-600 dark:text-blue-400 mr-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Pratinjau CV</h3>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition.opacity.duration.300ms style="display: none;" class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <x-cv-preview :user="Auth::user()" />
                                </div>
                            </div>
                            @endif

                            @if(Auth::user()->role === 'job_seeker')
                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8">
                                <div class="mb-2">
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Ringkasan Pribadi</label>
                                    <input id="bio" type="hidden" name="bio" form="profile-update-form" value="{{ Auth::user()->bio ?? '' }}">
                                    <trix-editor input="bio" class="trix-content bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block transition-all duration-200" placeholder="Ceritakan singkat tentang diri Anda, keahlian, dan tujuan karir..."></trix-editor>
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-2 text-right">Tuliskan profil/ringkasan yang menarik untuk memikat perekrut.</p>
                                </div>
                            </div>
                            @endif

                            @if(Auth::user()->role === 'job_seeker')
                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8">
                                <div class="flex items-center mb-6">
                                    <div class="p-2 bg-purple-50 dark:bg-purple-950/20 rounded-lg text-purple-600 dark:text-purple-400 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Keahlian & Bahasa</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <!-- Keahlian -->
                                    <div x-data="{
                                        showSuggestions: false,
                                        suggestions: ['PHP', 'Laravel', 'JavaScript', 'Python', 'Java', 'C++', 'Go', 'HTML', 'CSS', 'React', 'Vue', 'Node.js', 'SQL', 'Git', 'Docker', 'AWS', 'UI/UX', 'Project Management', 'Data Analysis', 'Machine Learning', 'Flutter', 'Android', 'iOS', 'Kotlin', 'Swift', 'TailwindCSS', 'Bootstrap', 'Figma', 'SEO', 'Digital Marketing'],
                                        get filteredSuggestions() {
                                            if (this.new_skill === '') return [];
                                            return this.suggestions.filter(s => s.toLowerCase().includes(this.new_skill.toLowerCase()) && !this.skills.includes(s)).slice(0, 5);
                                        },
                                        selectSuggestion(suggestion) {
                                            this.new_skill = suggestion;
                                            this.addSkill(new Event('click'));
                                            this.showSuggestions = false;
                                        }
                                    }">
                                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Keahlian (Skills)</label>
                                        <div class="flex items-center mb-3 relative">
                                            <input type="text" x-model="new_skill" @keydown.enter.prevent="addSkill($event)" @focus="showSuggestions = true" @click.away="showSuggestions = false" placeholder="Ketik skill (cth: PHP)"
                                                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-l-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 block p-3 transition-all duration-200">
                                            <button type="button" @click="addSkill" class="px-4 py-3 bg-purple-600 dark:bg-purple-500 hover:bg-purple-700 dark:hover:bg-purple-600 text-white rounded-r-xl text-sm font-semibold transition-colors">Tambah</button>

                                            <!-- Suggestions Dropdown -->
                                            <div x-show="showSuggestions && filteredSuggestions.length > 0" style="display: none;"
                                                x-transition.opacity.duration.200ms
                                                class="absolute z-10 w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg mt-1 top-full overflow-hidden">
                                                <ul class="py-1">
                                                    <template x-for="suggestion in filteredSuggestions" :key="suggestion">
                                                        <li @click="selectSuggestion(suggestion)"
                                                            class="cursor-pointer px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-purple-900/30 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                                                            <span x-text="suggestion"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="(skill, index) in skills" :key="index">
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-950/30 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800/40">
                                                    <input type="hidden" :name="'skills['+index+']'" :value="skill">
                                                    <span x-text="skill"></span>
                                                    <button type="button" @click="removeSkill(index)" class="ml-1.5 text-purple-500 hover:text-purple-700 focus:outline-none">
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
                                            <input type="text" x-model="new_language" @keydown.enter="addLanguage($event)" placeholder="Ketik bahasa (contoh: Indonesia) lalu Enter"
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
                            </div>
                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8">
                                <div class="flex items-center mb-6">
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
                                                    <input type="text" x-model="history.company_name" :name="'career_histories['+index+'][company_name]'" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500">
                                                </div>
                                                <div x-data="{
                                                    open: false,
                                                    search: history.position || '',
                                                    get filteredPositions() {
                                                        if (!this.search) return positions;
                                                        return positions.filter(p => p.toLowerCase().includes(this.search.toLowerCase()));
                                                    },
                                                    selectPosition(pos) {
                                                        history.position = pos;
                                                        this.search = pos;
                                                        this.open = false;
                                                    }
                                                }" x-init="$watch('history.position', val => search = val)">
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Posisi / Jabatan</label>
                                                    <div class="relative">
                                                        <input type="text" x-model="search" @focus="open = true" @click.away="open = false" @input="history.position = search" placeholder="Pilih atau ketik posisi" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500">
                                                        <div x-show="open && filteredPositions.length > 0" style="display: none;" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg max-h-40 overflow-y-auto">
                                                            <ul class="py-1">
                                                                <template x-for="pos in filteredPositions" :key="pos">
                                                                    <li @click="selectPosition(pos)" class="px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-green-50 dark:hover:bg-green-900/30 cursor-pointer" x-text="pos"></li>
                                                                </template>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" :name="'career_histories['+index+'][position]'" :value="history.position">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Tanggal Mulai</label>
                                                    <input type="date" x-model="history.start_date" :name="'career_histories['+index+'][start_date]'" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2.5 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-green-500/20 focus:border-green-500">
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
                            </div>
                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 md:p-8">
                                <div class="flex items-center mb-6">
                                    <div class="p-2 bg-teal-50 dark:bg-teal-950/20 rounded-lg text-teal-600 dark:text-teal-400 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Preferensi Pekerjaan</h3>
                                </div>

                                <div class="mb-8" x-data="{
                                    expected_jobs: {{ json_encode(old('expected_jobs', Auth::user()->expected_jobs ?? [])) }},
                                    positions: [
                                        @foreach($positions ?? [] as $position)
                                        '{{ addslashes($position->name) }}',
                                        @endforeach
                                    ],
                                    addJob() {
                                        this.expected_jobs.push({ position: '', salary_min: '' });
                                    },
                                    removeJob(index) {
                                        this.expected_jobs.splice(index, 1);
                                    },
                                    formatRupiah(value) {
                                        if(!value) return '';
                                        let number_string = value.toString().replace(/[^,\d]/g, ''),
                                            split = number_string.split(','),
                                            sisa = split[0].length % 3,
                                            rupiah = split[0].substr(0, sisa),
                                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                                        
                                        if (ribuan) {
                                            let separator = sisa ? '.' : '';
                                            rupiah += separator + ribuan.join('.');
                                        }
                                        return rupiah;
                                    }
                                }"
                                    x-init="if (expected_jobs.length === 0) addJob()">

                                    <template x-for="(job, index) in expected_jobs" :key="index">
                                        <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 mb-4 relative">
                                            <button type="button" @click="removeJob(index)" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Position -->
                                                <div x-data="{
                                                    open: false,
                                                    get filteredOptions() {
                                                        if (!job.position) return positions;
                                                        return positions.filter(i => i.toLowerCase().includes(job.position.toLowerCase()));
                                                    },
                                                    selectOption(opt) {
                                                        job.position = opt;
                                                        this.open = false;
                                                    }
                                                }">
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Jenis Pekerjaan</label>
                                                    <div class="relative w-full">
                                                        <input type="text" :name="'expected_jobs['+index+'][position]'" x-model="job.position" @focus="open = true" @click.away="open = false" autocomplete="off" placeholder="Pilih / ketik pekerjaan"
                                                            class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 block p-3 transition-all duration-200">
                                                        <!-- Dropdown Indicator -->
                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </div>
                                                        <div x-show="open && filteredOptions.length > 0" style="display: none;" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                                                            <ul class="py-1">
                                                                <template x-for="opt in filteredOptions" :key="opt">
                                                                    <li @click="selectOption(opt)" class="px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-300 cursor-pointer">
                                                                        <span x-text="opt"></span>
                                                                    </li>
                                                                </template>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Salary Min -->
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Gaji Minimal</label>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-slate-500 dark:text-slate-400 sm:text-sm font-semibold">Rp</span>
                                                        </div>
                                                        <input type="hidden" :name="'expected_jobs['+index+'][salary_min]'" x-model="job.salary_min">
                                                        <input type="text" :value="formatRupiah(job.salary_min)" @input="job.salary_min = $event.target.value.replace(/\D/g, '')" placeholder="5.000.000"
                                                            class="w-full pl-10 pr-3 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 block transition-all duration-200">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </template>

                                <button type="button" @click="addJob" class="flex items-center text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 transition-colors mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Preferensi Pekerjaan
                                </button>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">Catatan Preferensi Pekerjaan</label>
                                    <textarea name="job_preferences" rows="2" placeholder="Contoh: Bersedia ditempatkan di luar kota, preferensi WFH, dll..."
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 block p-3 transition-all duration-200">{{ Auth::user()->job_preferences }}</textarea>
                                </div>
                            </div>
                            @endif

                    </div>


                    <div class="flex items-center justify-end gap-3 pt-6">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="button" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 active:scale-95 transition-all duration-200 flex items-center gap-2" :disabled="saving" @click="submitForm($event)">
                            <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                        </button>
                    </div>
                </div>

                </form>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('webcamUpload', () => ({
        showWebcam: false,
        stream: null,
        openCamera() {
            this.showWebcam = true;
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
                .then(stream => {
                    this.stream = stream;
                    this.$refs.video.srcObject = stream;
                })
                .catch(err => {
                    alert("Kamera tidak dapat diakses. Pastikan Anda memberikan izin akses kamera.");
                    this.showWebcam = false;
                });
        },
        closeCamera() {
            this.showWebcam = false;
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
        },
        takeSnapshot() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            // Set canvas size to video's actual size with fallbacks
            const width = video.videoWidth || video.clientWidth || 640;
            const height = video.videoHeight || video.clientHeight || 480;
            
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            
            // Flip the image if facing user to act like a mirror
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            canvas.toBlob(blob => {
                if (!blob || blob.size === 0) {
                    alert("Gagal mengambil gambar. Pastikan kamera menyala dan terlihat.");
                    return;
                }
                
                const formData = new FormData();
                formData.append('photo', blob, 'webcam_capture.jpg');
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                
                this.closeCamera();
                
                // Show loading state (optional, or just wait for reload)
                document.body.style.cursor = 'wait';
                
                fetch(document.getElementById('photoForm').action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        document.body.style.cursor = 'default';
                        response.json().then(data => {
                            let errorMsg = "Gagal mengunggah foto.";
                            if (data.errors && data.errors.photo) {
                                errorMsg = data.errors.photo.join('\n');
                            } else if (data.message) {
                                errorMsg = data.message;
                            }
                            alert(errorMsg);
                        }).catch(() => {
                            alert("Gagal mengunggah foto. Terjadi kesalahan server.");
                        });
                    }
                })
                .catch(err => {
                    document.body.style.cursor = 'default';
                    alert("Terjadi kesalahan jaringan: " + err);
                });
            }, "image/jpeg", 0.9);
        }
    }));
});
</script>
</x-app-layout>