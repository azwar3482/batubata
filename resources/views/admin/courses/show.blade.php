<x-app-layout>
    @include('partials.quill-styles')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kursus</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ Str::limit($course->title, 30) }}</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Kursus</h2>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">Edit</a>
                    <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                        &laquo; Kembali
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Course Header -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 mb-8">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ $course->platform }}</span>
                                <span class="px-2 py-1 text-xs rounded-full {{ $course->level === 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($course->level === 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">{{ ucfirst($course->level) }}</span>
                                @if($course->is_free)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Gratis</span>
                                @else
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">Rp {{ number_format($course->price) }}</span>
                                @endif
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->title }}</h1>
                            <p class="mt-2 text-gray-600 dark:text-slate-400">{!! Str::limit(strip_tags($course->description), 200) !!}</p>
                            <div class="mt-4 flex items-center gap-6 text-sm text-gray-500 dark:text-slate-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $course->duration_hours }} jam
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    {{ $course->chapters->count() }} chapter
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    {{ $course->total_materials }} materi
                                </span>
                            </div>
                        </div>
                        @if($course->url)
                        <a href="{{ $course->url }}" target="_blank" class="px-4 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            Link Eksternal
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Chapters & Materials -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700">
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Chapter & Materi
                            </h3>
                        </div>
                        <div class="p-6">
                            @forelse($course->chapters as $chapter)
                            <div class="mb-6 last:mb-0" x-data="{ open: true }">
                                <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">{{ $chapter->order_number }}</span>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $chapter->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ $chapter->materials->count() }} materi @if($chapter->duration_minutes) &middot; {{ $chapter->duration_minutes }} menit @endif</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.courses.destroy-chapter', $chapter) }}" method="POST" onsubmit="return confirm('Hapus chapter ini beserta semua materi?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1 text-red-500 hover:text-red-700 dark:text-red-400" title="Hapus Chapter">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                                <div x-show="open" x-transition class="mt-4 ml-11 space-y-2">
                                    @foreach($chapter->materials as $material)
                                    <div class="p-3 bg-gray-50 dark:bg-slate-900 rounded-lg" x-data="{ showQuiz: false }">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $material->type_icon }}" /></svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $material->title }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-slate-400">
                                                        @if($material->type === 'video') Video
                                                        @elseif($material->type === 'document') Dokumen
                                                        @elseif($material->type === 'link') Link
                                                        @elseif($material->type === 'text') Teks
                                                        @elseif($material->type === 'embed') Embed
                                                        @elseif($material->type === 'assignment') Tugas
                                                        @elseif($material->type === 'quiz') Kuis ({{ $material->quizQuestions->count() }} soal)
                                                        @endif
                                                        @if($material->file_name) &middot; {{ $material->file_size_formatted }} @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                @if($material->type === 'quiz')
                                                <button @click="showQuiz = !showQuiz" class="p-1 text-purple-500 hover:text-purple-700" title="Kelola Soal">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </button>
                                                @endif
                                                @if($material->external_url)
                                                <a href="{{ $material->external_url }}" target="_blank" class="p-1 text-green-500 hover:text-green-700" title="Buka Link">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                                </a>
                                                @endif
                                                @if($material->file_path)
                                                <a href="{{ route('admin.courses.download-material', $material) }}" class="p-1 text-blue-500 hover:text-blue-700" title="Download">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                </a>
                                                @endif
                                                <form action="{{ route('admin.courses.destroy-material', $material) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-1 text-red-500 hover:text-red-700" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Quiz Questions Management -->
                                        @if($material->type === 'quiz')
                                        <div x-show="showQuiz" x-transition class="mt-3 pt-3 border-t border-gray-200 dark:border-slate-700">
                                            <h5 class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-2">Soal Kuis</h5>
                                            @foreach($material->quizQuestions as $q)
                                            <div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $q->order_number }}. {{ $q->question }}</p>
                                                        <div class="mt-2 grid grid-cols-2 gap-1">
                                                            @foreach($q->options as $key => $opt)
                                                            <div class="text-xs px-2 py-1 rounded {{ $key === $q->correct_answer ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 font-bold' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400' }}">
                                                                {{ $key }}. {{ $opt }}
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @if($q->explanation)
                                                        <p class="mt-1 text-xs text-gray-400 italic">Penjelasan: {{ $q->explanation }}</p>
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('admin.courses.destroy-question', $q) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                                        @csrf @method('DELETE')
                                                        <button class="p-1 text-red-400 hover:text-red-600">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach

                                            <!-- Add Question Form -->
                                            <div x-data="{ showQForm: false }">
                                                <button @click="showQForm = !showQForm" class="text-xs text-purple-600 hover:text-purple-800 dark:text-purple-400 font-medium">+ Tambah Soal</button>
                                                <form x-show="showQForm" x-transition action="{{ route('admin.courses.store-question', $material) }}" method="POST" class="mt-2 p-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg space-y-2">
                                                    @csrf
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Pertanyaan *</label>
                                                        <textarea name="question" rows="2" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md"></textarea>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Opsi A *</label>
                                                            <input type="text" name="options[A]" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Opsi B *</label>
                                                            <input type="text" name="options[B]" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Opsi C</label>
                                                            <input type="text" name="options[C]" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Opsi D</label>
                                                            <input type="text" name="options[D]" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                        </div>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Jawaban Benar *</label>
                                                            <select name="correct_answer" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Poin</label>
                                                            <input type="number" name="points" value="1" min="1" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Penjelasan</label>
                                                        <textarea name="explanation" rows="1" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md"></textarea>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <button type="submit" class="px-3 py-1.5 bg-purple-600 text-white text-xs rounded-lg hover:bg-purple-700">Simpan Soal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach

                                    <!-- Add Material Form -->
                                    <div x-data="{ showForm: false }" class="mt-2">
                                        <button @click="showForm = !showForm" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">+ Tambah Materi</button>
                                        <form x-show="showForm" x-transition action="{{ route('admin.courses.store-material', $chapter) }}" method="POST" enctype="multipart/form-data" class="mt-3 p-4 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg space-y-3">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Judul Materi *</label>
                                                <input type="text" name="title" placeholder="Judul Materi" required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Tipe</label>
                                                    <select name="type" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md" x-data="{ type: 'document' }" x-model="type">
                                                        <option value="document">Dokumen</option>
                                                        <option value="video">Video</option>
                                                        <option value="link">Link</option>
                                                        <option value="text">Teks/HTML</option>
                                                        <option value="embed">Embed Code</option>
                                                        <option value="assignment">Tugas</option>
                                                        <option value="quiz">Kuis</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">File</label>
                                                    <input type="file" name="file" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">URL Eksternal (YouTube, Vimeo, Link)</label>
                                                <input type="url" name="external_url" placeholder="https://youtube.com/watch?v=..." class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Konten / Deskripsi</label>
                                                <textarea name="content" rows="3" placeholder="Konten teks/HTML atau deskripsi materi" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md"></textarea>
                                            </div>
                                            <div class="flex items-center">
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="is_downloadable" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="ml-2 text-xs text-gray-600 dark:text-slate-400">Dapat diunduh</span>
                                                </label>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Simpan Materi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-slate-400 text-center py-4">Belum ada chapter. Tambahkan chapter pertama di bawah.</p>
                            @endforelse

                            <!-- Add Chapter Form -->
                            <div x-data="{ showForm: false }" class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                <button @click="showForm = !showForm" class="inline-flex items-center px-4 py-2 border border-dashed border-gray-300 dark:border-slate-600 text-gray-600 dark:text-slate-400 rounded-lg hover:border-blue-500 hover:text-blue-600 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    Tambah Chapter
                                </button>
                                <form x-show="showForm" x-transition action="{{ route('admin.courses.store-chapter', $course) }}" method="POST" class="mt-4 p-4 bg-gray-50 dark:bg-slate-900 rounded-lg space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Judul Chapter *</label>
                                        <input type="text" name="title" placeholder="Contoh: Pendahuluan, Dasar-dasar, dll." required class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Deskripsi</label>
                                        <textarea name="description" rows="2" placeholder="Deskripsi chapter (opsional)" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">Durasi (menit)</label>
                                        <input type="number" name="duration_minutes" placeholder="0" min="0" class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-md">
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Simpan Chapter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Course Info -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Info Kursus</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Platform</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->platform }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Kategori</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->category === 'technical' ? 'Teknis' : 'Soft Skill' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Level</span>
                                <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $course->level }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Harga</span>
                                <span class="font-medium {{ $course->is_free ? 'text-green-600' : 'text-gray-900 dark:text-white' }}">{{ $course->is_free ? 'Gratis' : 'Rp ' . number_format($course->price) }}</span>
                            </div>
                            @if($course->competency)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Kompetensi</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $course->competency->name }}</span>
                            </div>
                            @endif
                            @if($course->rating)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-slate-400">Rating</span>
                                <span class="font-medium text-yellow-600 dark:text-yellow-400">{{ number_format($course->rating, 1) }} / 5.0</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistik</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $course->chapters->count() }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Chapter</p>
                            </div>
                            <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $course->total_materials }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Materi</p>
                            </div>
                        </div>
                    </div>

                    @if($course->url)
                    <!-- External Link -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Link Eksternal</h3>
                        <a href="{{ $course->url }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 break-all">{{ $course->url }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
