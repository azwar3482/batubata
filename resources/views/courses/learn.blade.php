<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kursus</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.show', $course->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ Str::limit($course->title, 20) }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Belajar</span>
            </nav>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar - Course Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 sticky top-6">
                        <div class="p-4 border-b border-gray-100 dark:border-slate-700">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">{{ Str::limit($course->title, 40) }}</h3>
                            <div class="mt-2">
                                <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $progress->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all" style="width: {{ $progress->progress_percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 max-h-[60vh] overflow-y-auto">
                            @foreach($course->chapters as $chapter)
                            <div class="mb-4" x-data="{ open: true }">
                                <div class="flex items-center justify-between cursor-pointer mb-2" @click="open = !open">
                                    <h4 class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Chapter {{ $chapter->order_number }}: {{ $chapter->title }}</h4>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                                <div x-show="open" x-transition class="space-y-1">
                                    @foreach($chapter->materials as $material)
                                    <a href="{{ route('seeker.courses.learn-material', [$course->id, $material->id]) }}"
                                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors {{ $currentMaterial && $currentMaterial->id === $material->id ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                                        @if(in_array($material->id, $completedMaterialIds))
                                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        @else
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $material->type_icon }}" /></svg>
                                        @endif
                                        <span class="truncate {{ in_array($material->id, $completedMaterialIds) ? 'line-through opacity-60' : '' }}">{{ $material->title }}</span>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-3">
                    @if($currentMaterial)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <!-- Material Header -->
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-1">
                                        Chapter {{ $currentMaterial->chapter->order_number }}: {{ $currentMaterial->chapter->title }}
                                    </p>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $currentMaterial->title }}</h2>
                                    <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 capitalize">
                                        @if($currentMaterial->type === 'video') Video
                                        @elseif($currentMaterial->type === 'document') Dokumen
                                        @elseif($currentMaterial->type === 'link') Link Eksternal
                                        @elseif($currentMaterial->type === 'text') Teks / HTML
                                        @elseif($currentMaterial->type === 'embed') Embed
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if(in_array($currentMaterial->id, $completedMaterialIds))
                                    <form action="{{ route('seeker.courses.complete-material', [$course->id, $currentMaterial->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-sm font-medium hover:bg-green-200 dark:hover:bg-green-900/50 transition">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Selesai
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('seeker.courses.complete-material', [$course->id, $currentMaterial->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            Tandai Selesai
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Material Content -->
                        <div class="p-6">
                            @if($currentMaterial->type === 'video')
                                <!-- Video Player -->
                                @if($currentMaterial->external_url)
                                    @php
                                        $url = $currentMaterial->external_url;
                                        $embedUrl = '';
                                        // YouTube
                                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
                                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                        }
                                        // Vimeo
                                        elseif (preg_match('/(?:vimeo\.com\/)(\d+)/', $url, $matches)) {
                                            $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                        }
                                    @endphp
                                    @if($embedUrl)
                                    <div class="relative w-full" style="padding-top: 56.25%;">
                                        <iframe class="absolute inset-0 w-full h-full rounded-lg" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                    @else
                                    <div class="text-center py-12">
                                        <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <a href="{{ $url }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            Buka Video
                                        </a>
                                    </div>
                                    @endif
                                @endif
                                @if($currentMaterial->file_path)
                                <div class="mt-4">
                                    <video controls class="w-full rounded-lg">
                                        <source src="{{ asset('storage/' . $currentMaterial->file_path) }}" type="{{ $currentMaterial->mime_type }}">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                                @endif

                            @elseif($currentMaterial->type === 'document')
                                <!-- Document Viewer -->
                                @if($currentMaterial->file_path)
                                    @php
                                        $ext = pathinfo($currentMaterial->file_name, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(in_array($ext, ['pdf']))
                                    <div class="w-full" style="height: 70vh;">
                                        <iframe src="{{ route('seeker.courses.view-material', [$course->id, $currentMaterial->id]) }}" class="w-full h-full rounded-lg border-0"></iframe>
                                    </div>
                                    @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <div class="text-center">
                                        <img src="{{ route('seeker.courses.view-material', [$course->id, $currentMaterial->id]) }}" alt="{{ $currentMaterial->title }}" class="max-w-full h-auto rounded-lg mx-auto">
                                    </div>
                                    @else
                                    <div class="text-center py-12">
                                        <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <p class="text-gray-600 dark:text-slate-400 mb-4">{{ $currentMaterial->file_name }}</p>
                                        @if($currentMaterial->is_downloadable)
                                        <a href="{{ route('seeker.courses.download-material', [$course->id, $currentMaterial->id]) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                            Download Dokumen
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                @endif
                                @if($currentMaterial->content)
                                <div class="mt-6 prose dark:prose-invert max-w-none">
                                    {!! $currentMaterial->content !!}
                                </div>
                                @endif

                            @elseif($currentMaterial->type === 'text')
                                <!-- Text/HTML Content -->
                                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-slate-300 leading-relaxed">
                                    {!! $currentMaterial->content !!}
                                </div>

                            @elseif($currentMaterial->type === 'link')
                                <!-- External Link -->
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $currentMaterial->title }}</h3>
                                    @if($currentMaterial->content)
                                    <p class="text-gray-600 dark:text-slate-400 mb-6 max-w-lg mx-auto">{{ $currentMaterial->content }}</p>
                                    @endif
                                    @if($currentMaterial->external_url)
                                    <a href="{{ $currentMaterial->external_url }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                        Buka Link
                                    </a>
                                    @endif
                                </div>

                            @elseif($currentMaterial->type === 'embed')
                                <!-- Embed Code -->
                                @if($currentMaterial->external_url)
                                <div class="relative w-full" style="padding-top: 56.25%;">
                                    <iframe class="absolute inset-0 w-full h-full rounded-lg" src="{{ $currentMaterial->external_url }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                                @endif
                                @if($currentMaterial->content)
                                <div class="mt-6">
                                    {!! $currentMaterial->content !!}
                                </div>
                                @endif

                            @elseif($currentMaterial->type === 'quiz')
                                <!-- Quiz -->
                                @php
                                    $questions = $currentMaterial->quizQuestions;
                                    $lastAttempt = \App\Models\AdminQuizAttempt::where('user_id', Auth::id())
                                        ->where('material_id', $currentMaterial->id)
                                        ->latest()
                                        ->first();
                                @endphp

                                @if($currentMaterial->content)
                                <div class="mb-6 prose dark:prose-invert max-w-none text-gray-700 dark:text-slate-300">
                                    {!! $currentMaterial->content !!}
                                </div>
                                @endif

                                @if($lastAttempt)
                                <div class="mb-6 p-4 rounded-lg {{ $lastAttempt->passed ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' }}">
                                    <h3 class="font-bold {{ $lastAttempt->passed ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                                        {{ $lastAttempt->passed ? 'Lulus!' : 'Belum Lulus' }} - Skor: {{ $lastAttempt->score }}%
                                    </h3>
                                    <p class="text-sm {{ $lastAttempt->passed ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                                        {{ $lastAttempt->correct_count }}/{{ $lastAttempt->total_questions }} soal benar
                                    </p>
                                </div>
                                @endif

                                @if($questions->count() > 0)
                                <form action="{{ route('seeker.courses.submit-quiz', [$course->id, $currentMaterial->id]) }}" method="POST" x-data="{ submitted: false }">
                                    @csrf
                                    <div class="space-y-6">
                                        @foreach($questions as $q)
                                        <div class="p-4 bg-gray-50 dark:bg-slate-900 rounded-lg">
                                            <p class="font-medium text-gray-900 dark:text-white mb-3">{{ $q->order_number }}. {{ $q->question }}</p>
                                            <div class="space-y-2">
                                                @foreach($q->options as $key => $opt)
                                                <label class="flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-white dark:hover:bg-slate-800 transition">
                                                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $key }}" required
                                                        class="text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-gray-700 dark:text-slate-300">{{ $key }}. {{ $opt }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-6">
                                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Jawab Kuis
                                        </button>
                                    </div>
                                </form>
                                @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 dark:text-slate-400">Belum ada soal dalam kuis ini.</p>
                                </div>
                                @endif

                            @elseif($currentMaterial->type === 'assignment')
                                <!-- Assignment -->
                                @php
                                    $submission = \App\Models\AdminAssignmentSubmission::where('user_id', Auth::id())
                                        ->where('material_id', $currentMaterial->id)
                                        ->latest()
                                        ->first();
                                @endphp

                                @if($currentMaterial->content)
                                <div class="mb-6 prose dark:prose-invert max-w-none text-gray-700 dark:text-slate-300">
                                    {!! $currentMaterial->content !!}
                                </div>
                                @endif

                                @if($submission)
                                <div class="mb-6 p-4 rounded-lg {{ $submission->status === 'reviewed' ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800' }}">
                                    <h3 class="font-bold {{ $submission->status === 'reviewed' ? 'text-green-700 dark:text-green-400' : 'text-yellow-700 dark:text-yellow-400' }}">
                                        @if($submission->status === 'reviewed')
                                            Sudah Dinilai - Skor: {{ $submission->score }}
                                        @elseif($submission->status === 'revision')
                                            Perlu Revisi
                                        @else
                                            Sudah Dikumpulkan
                                        @endif
                                    </h3>
                                    @if($submission->feedback)
                                    <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Feedback: {{ $submission->feedback }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Dikumpulkan: {{ $submission->submitted_at->format('d M Y H:i') }}</p>
                                </div>
                                @endif

                                <form action="{{ route('seeker.courses.submit-assignment', [$course->id, $currentMaterial->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Jawaban Teks</label>
                                            <textarea name="content" rows="6" placeholder="Tulis jawaban Anda di sini..." class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('content', $submission->content ?? '') }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Upload File</label>
                                            <input type="file" name="file" class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 rounded-lg text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, JPG, PNG, ZIP (Max 50MB)</p>
                                        </div>
                                        <div>
                                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                {{ $submission ? 'Kumpulkan Ulang' : 'Kumpulkan Tugas' }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            @if($currentMaterial->file_path && $currentMaterial->is_downloadable && $currentMaterial->type !== 'document')
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                                <a href="{{ route('seeker.courses.download-material', [$course->id, $currentMaterial->id]) }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    Download Lampiran ({{ $currentMaterial->file_size_formatted }})
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Navigation -->
                        @php
                            $allMaterials = $course->chapters->flatMap->materials;
                            $currentIndex = $allMaterials->search(fn($m) => $m->id === $currentMaterial->id);
                            $prevMaterial = $currentIndex > 0 ? $allMaterials[$currentIndex - 1] : null;
                            $nextMaterial = $currentIndex < $allMaterials->count() - 1 ? $allMaterials[$currentIndex + 1] : null;
                        @endphp
                        <div class="p-6 border-t border-gray-100 dark:border-slate-700 flex justify-between items-center">
                            @if($prevMaterial)
                            <a href="{{ route('seeker.courses.learn-material', [$course->id, $prevMaterial->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                Sebelumnya
                            </a>
                            @else
                            <div></div>
                            @endif

                            <span class="text-sm text-gray-500 dark:text-slate-400">{{ $currentIndex + 1 }} / {{ $allMaterials->count() }}</span>

                            @if($nextMaterial)
                            <a href="{{ route('seeker.courses.learn-material', [$course->id, $nextMaterial->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                            @else
                            <div></div>
                            @endif
                        </div>
                    </div>
                    @else
                    <!-- No Material -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-gray-100 dark:border-slate-700 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Belum Ada Materi</h3>
                        <p class="text-gray-600 dark:text-slate-400">Kursus ini belum memiliki materi pembelajaran.</p>
                        <a href="{{ route('seeker.courses.show', $course->id) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                            Kembali ke Detail Kursus
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
