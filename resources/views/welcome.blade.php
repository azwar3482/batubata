<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="KOMPASKARIR - Skill Gap Advisor untuk menjembatani kesenjangan kompetensi antara lulusan dan industri">
    <title>KOMPASKARIR - Skill Gap Advisor Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased dark:bg-slate-900 dark:text-gray-100">

    <!-- Navigation -->
    <nav x-data="{ mobileMenuOpen: false }" class="bg-white dark:bg-slate-800 shadow-sm dark:border-b dark:border-slate-700 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto">
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent">KOMPASKARIR</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium transition">Fitur</a>
                    <a href="#manfaat" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium transition">Manfaat</a>
                    <a href="#testimoni" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium transition">Testimoni</a>
                    <a href="#faq" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium transition">FAQ</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Daftar Gratis
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden bg-white dark:bg-slate-800 border-t dark:border-slate-700">
            <div class="px-4 py-4 space-y-3">
                <a href="#fitur" class="block text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium">Fitur</a>
                <a href="#manfaat" class="block text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium">Manfaat</a>
                <a href="#testimoni" class="block text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium">Testimoni</a>
                <a href="{{ route('login') }}" class="block text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium">Login</a>
                <a href="{{ route('register') }}"
                    class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg">Daftar
                    Gratis</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 md:pt-32 md:pb-24 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-6">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Platform Skill Gap Advisor #1 di Indonesia
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
                        Temukan <span
                            class="bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent">Kesenjangan
                            Skill</span> & Raih Karir Impian
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto lg:mx-0">
                        KOMPASKARIR membantu Anda menganalisis kompetensi, mendapatkan rekomendasi pembelajaran
                        personal, dan menemukan lowongan kerja yang sesuai dengan skill Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Mulai Asesmen Gratis
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#fitur"
                            class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:border-blue-600 dark:hover:border-blue-400 hover:text-blue-600 dark:hover:text-blue-400 transition bg-white dark:bg-slate-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Lihat Demo
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-6">
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">10,000+</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Aktif</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">500+</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Perusahaan Mitra</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">85%</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Rate Penempatan</p>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Illustration -->
                <div class="relative">
                    <div
                        class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl p-8 transform rotate-2 hover:rotate-0 transition duration-500">
                        <!-- Dashboard Preview -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full">
                                    </div>
                                    <div>
                                        <div class="h-4 w-32 bg-gray-200 dark:bg-slate-700 rounded"></div>
                                        <div class="h-3 w-24 bg-gray-100 dark:bg-slate-700/50 rounded mt-1"></div>
                                    </div>
                                </div>
                                <div class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">85% Match</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-blue-50 rounded-xl p-4">
                                    <div class="h-3 w-16 bg-blue-200 rounded mb-2"></div>
                                    <div class="h-8 w-24 bg-blue-300 rounded"></div>
                                </div>
                                <div class="bg-purple-50 rounded-xl p-4">
                                    <div class="h-3 w-16 bg-purple-200 rounded mb-2"></div>
                                    <div class="h-8 w-24 bg-purple-300 rounded"></div>
                                </div>
                            </div>
                            <!-- Content Area -->
                            <div class="bg-gray-50 dark:bg-slate-900 rounded-xl p-4">
                                <div class="h-3 w-32 bg-gray-200 dark:bg-slate-700 rounded mb-3"></div>
                                <div class="space-y-2">
                                    <div class="h-2 w-full bg-gray-200 dark:bg-slate-700 rounded"></div>
                                    <div class="h-2 w-3/4 bg-gray-200 dark:bg-slate-700 rounded"></div>
                                    <div class="h-2 w-1/2 bg-gray-200 dark:bg-slate-700 rounded"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-4 -right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm font-semibold animate-bounce">
                            ✓ Skill Gap Teridentifikasi
                        </div>
                        <div
                            class="absolute -bottom-4 -left-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm font-semibold">
                            🎯 Rekomendasi Personal
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Platform lengkap untuk analisis kompetensi dan
                    pengembangan karir Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 rounded-2xl shadow-sm hover:shadow-md transition duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-slate-700 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Asesmen Kompetensi</h3>
                    <p class="text-gray-600 dark:text-gray-300">Analisis mendalam terhadap skill teknis dan soft skill Anda dengan standar
                        industri.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="p-8 bg-gradient-to-br from-green-50 to-teal-50 dark:from-slate-800 dark:to-slate-700 rounded-2xl shadow-sm hover:shadow-md transition duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-green-100 dark:bg-slate-700 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Analisis Skill Gap</h3>
                    <p class="text-gray-600 dark:text-gray-300">Identifikasi kesenjangan antara kemampuan Anda dengan requirement
                        industri.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="p-8 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-slate-800 dark:to-slate-700 rounded-2xl shadow-sm hover:shadow-md transition duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-purple-100 dark:bg-slate-700 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Rekomendasi Kursus</h3>
                    <p class="text-gray-600 dark:text-gray-300">Dapatkan rekomendasi pembelajaran personal untuk menutup skill gap Anda.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="p-8 bg-gradient-to-br from-orange-50 to-red-50 dark:from-slate-800 dark:to-slate-700 rounded-2xl shadow-sm hover:shadow-md transition duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-orange-100 dark:bg-slate-700 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Roadmap Karir</h3>
                    <p class="text-gray-600 dark:text-gray-300">Rencana pengembangan karir 6 bulan yang terstruktur dan terukur.</p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="p-8 bg-gradient-to-br from-teal-50 to-emerald-50 dark:from-slate-800 dark:to-slate-700 rounded-2xl shadow-sm hover:shadow-md transition duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-teal-100 dark:bg-slate-700 rounded-xl flex items-center justify-center text-teal-600 dark:text-teal-400 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Job Matching</h3>
                    <p class="text-gray-600 dark:text-gray-300">Temukan lowongan kerja yang sesuai dengan kompetensi dan minat Anda.</p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="p-8 bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-slate-800 dark:to-slate-700 rounded-2xl shadow-sm hover:shadow-md transition duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-amber-100 dark:bg-slate-700 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Laporan PDF</h3>
                    <p class="text-gray-600 dark:text-gray-300">Download laporan kompetensi profesional untuk portofolio dan lamaran
                        kerja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Users Section -->
    <section id="manfaat" class="py-20 bg-gray-50 dark:bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Siapa yang Bisa Menggunakan?</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Platform ini dirancang untuk berbagai kebutuhan
                    pengembangan karir</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Job Seeker -->
                <div class="bg-white dark:bg-slate-700 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Pencari Kerja</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Analisis skill gap, dapatkan rekomendasi kursus, dan temukan
                            lowongan yang sesuai dengan kompetensi Anda.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Asesmen kompetensi gratis
                            </li>
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Rekomendasi personal
                            </li>
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Job matching otomatis
                            </li>
                        </ul>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Daftar
                            Sekarang</a>
                    </div>
                </div>

                <!-- Industry -->
                <div class="bg-white dark:bg-slate-700 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Perusahaan / HRD</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Posting lowongan, temukan kandidat berkualitas dengan skill yang
                            sudah terverifikasi.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Akses database talenta
                            </li>
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Skill verification
                            </li>
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Matching score otomatis
                            </li>
                        </ul>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">Daftar
                            Perusahaan</a>
                    </div>
                </div>

                <!-- Education -->
                <div class="bg-white dark:bg-slate-700 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Institusi Pendidikan</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Pantau kompetensi lulusan, analisis skill gap, dan sesuaikan
                            kurikulum dengan industri.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Analytics lulusan
                            </li>
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kurriculum recommendation
                            </li>
                            <li class="flex items-center text-gray-700 dark:text-gray-200">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Industry collaboration
                            </li>
                        </ul>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">Daftar
                            Institusi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">Siap untuk Meningkatkan Karir Anda?</h2>
            <p class="text-xl text-blue-100 mb-8">Bergabunglah dengan ribuan profesional yang telah menemukan jalur
                karir terbaik mereka melalui KOMPASKARIR.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-semibold rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition shadow-lg transform hover:-translate-y-1">
                    Daftar Gratis Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition">
                    Sudah Punya Akun? Login
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="{{ asset('logo.JPG') }}" alt="Logo" class="h-8 w-auto mr-2 rounded-lg">
                        <span class="text-xl font-bold">KOMPASKARIR</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">Platform Skill Gap Advisor untuk menjembatani kesenjangan
                        kompetensi antara lulusan pendidikan dan kebutuhan industri digital.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#fitur" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-white transition">Harga</a></li>
                        <li><a href="#" class="hover:text-white transition">API</a></li>
                        <li><a href="#" class="hover:text-white transition">Integrasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} KOMPASKARIR. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
