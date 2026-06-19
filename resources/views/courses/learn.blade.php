<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kursus</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.show', $course->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Detail</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Belajar</span>
            </nav>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ruang Belajar</h2>
                <a href="{{ route('seeker.courses.show', $course->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm">
                    &laquo; Kembali
                </a>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-slate-800">
                <!-- Video Player Dummy -->
                <div class="relative bg-black w-full" style="padding-top: 56.25%;">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 cursor-pointer hover:bg-indigo-700 transition">
                                <svg class="w-10 h-10 text-white ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-white text-lg font-medium">Video Player Dummy</p>
                            <p class="text-gray-400 text-sm mt-2">Ini adalah simulasi halaman pembelajaran kursus.</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="inline-block px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded-full text-sm font-medium mb-3">
                                {{ $course->platform }}
                            </span>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->title }}</h1>
                        </div>
                        
                        <!-- Progress Complete Button -->
                        <div>
                            @if($progress && $progress->status === 'completed')
                                <div class="px-4 py-2 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg font-medium flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Kursus Selesai
                                </div>
                            @else
                                <form action="{{ route('seeker.courses.complete', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition flex items-center gap-2 shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Tandai Selesai
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Materi Pembelajaran</h3>
                        <p>Selamat datang di halaman pembelajaran! Pada halaman ini, Anda akan mempelajari materi-materi berikut yang relevan dengan <strong>{{ $course->competency->name ?? 'kompetensi' }}</strong>.</p>
                        <ul>
                            <li>Pengenalan dasar konsep dan teori.</li>
                            <li>Latihan studi kasus secara interaktif.</li>
                            <li>Ujian akhir (kuis mandiri) untuk mengukur pemahaman.</li>
                        </ul>
                        <p class="mt-4">Setelah selesai mempelajari semua materi di atas, silakan klik tombol <strong>"Tandai Selesai"</strong> di sudut kanan atas untuk memperbarui progres belajar Anda hingga 100% dan mendapatkan status <em>Completed</em>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
