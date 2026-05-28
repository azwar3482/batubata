<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Button -->
            <a href="{{ route('seeker.courses.index') }}"
                class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Daftar Kursus
            </a>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-medium mb-3">
                                {{ $course->platform }}
                            </span>
                            <h1 class="text-3xl font-bold mb-2">{{ $course->title }}</h1>
                            <p class="text-blue-100">{{ $course->competency->name ?? 'Umum' }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">
                                {{ $course->is_free ? 'Gratis' : 'Rp ' . number_format($course->price) }}
                            </div>
                            <div class="text-blue-200 text-sm">{{ $course->duration_hours }} Jam Pembelajaran</div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Kursus</h2>
                            <p class="text-gray-600 leading-relaxed mb-8">{{ $course->description }}</p>

                            <h3 class="text-lg font-bold text-gray-900 mb-4">Yang Akan Anda Pelajari</h3>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Memahami konsep dasar
                                        {{ $course->competency->name ?? 'materi ini' }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Praktik langsung dengan studi kasus real</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Mendapatkan sertifikat penyelesaian</span>
                                </li>
                            </ul>

                            @if ($progress)
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Progress Anda</h3>
                                <div class="mb-2">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>{{ $progress->status }}</span>
                                        <span>{{ $progress->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-green-500 h-3 rounded-full transition-all"
                                            style="width: {{ $progress->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                @if ($progress->status === 'completed')
                                <p class="text-green-600 text-sm mt-2">🎉 Selamat! Anda telah menyelesaikan
                                    kursus ini.</p>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-xl p-6 sticky top-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Kursus</h3>

                                <div class="space-y-4">
                                    <div>
                                        <span class="text-sm text-gray-500">Level</span>
                                        <p class="font-medium text-gray-900 capitalize">{{ $course->level }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Durasi</span>
                                        <p class="font-medium text-gray-900">{{ $course->duration_hours }} Jam</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kategori</span>
                                        <p class="font-medium text-gray-900 capitalize">{{ $course->category }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kompetensi</span>
                                        <p class="font-medium text-gray-900">{{ $course->competency->name ?? 'Umum' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    @if ($progress)
                                    <a href="{{ $course->url }}" target="_blank"
                                        class="block w-full text-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                        Lanjutkan Belajar
                                    </a>
                                    @else
                                    <form action="{{ route('seeker.courses.enroll', $course->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                            {{ $course->is_free ? 'Mulai Belajar Gratis' : 'Daftar Kursus' }}
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ $course->url }}" target="_blank"
                                        class="block w-full text-center mt-3 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                        Kunjungi Platform
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>