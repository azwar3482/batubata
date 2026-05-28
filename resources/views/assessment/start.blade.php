<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Kenali Potensi & <span class="text-blue-600">Kesenjangan Skill</span> Anda
                </h1>
                <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                    Dapatkan analisis mendalam tentang kompetensi Anda dibandingkan standar industri, serta rekomendasi
                    kursus personal untuk menutup gap tersebut.
                </p>
            </div>

            <!-- Cards Benefit -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div
                        class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Analisis Akurat</h3>
                    <p class="mt-2 text-gray-500 text-sm">Benchmarking skill Anda dengan data real-time dari kebutuhan
                        industri digital.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div
                        class="w-14 h-14 mx-auto bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Rekomendasi Personal</h3>
                    <p class="mt-2 text-gray-500 text-sm">Daftar kursus terpilih yang spesifik untuk menutup kelemahan
                        Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div
                        class="w-14 h-14 mx-auto bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Roadmap Jelas</h3>
                    <p class="mt-2 text-gray-500 text-sm">Peta jalan karir 6 bulan yang terstruktur untuk mencapai
                        target Anda.</p>
                </div>
            </div>

            <!-- Call to Action Box -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 md:p-12 text-center">
                    <h2 class="text-2xl font-bold text-gray-900">Siap untuk meningkatkan karir Anda?</h2>
                    <p class="mt-3 text-gray-600 mb-8">Proses asesmen hanya membutuhkan waktu sekitar 10-15 menit.</p>

                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('seeker.assessment.create') }}"
                            class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 md:text-xl shadow-lg transform hover:-translate-y-1 transition duration-200">
                            Mulai Asesmen Sekarang
                        </a>
                        <a href="{{ route('seeker.assessment.history') }}"
                            class="inline-flex justify-center items-center px-8 py-4 border border-gray-300 text-lg font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 md:text-xl shadow-sm transition duration-200">
                            Lihat Riwayat Asesmen
                        </a>
                    </div>

                    <p class="mt-6 text-xs text-gray-400">
                        Data Anda aman dan hanya digunakan untuk keperluan analisis pribadi.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
