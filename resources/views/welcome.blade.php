<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="KOMPASKARIR - Skill Gap Advisor untuk menjembatani kesenjangan kompetensi antara lulusan dan industri">
    <title>KOMPASKARIR INDONESIA - Skill Gap Advisor Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/jpeg" class="h-8 w-auto mr-2 rounded-lg">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage)) {
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
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto dark:bg-white dark:p-1 dark:rounded-md">
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
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 focus:outline-none rounded-lg text-sm p-2.5 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Daftar Gratis
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-2">
                    <button id="theme-toggle-mobile" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 focus:outline-none rounded-lg text-sm p-2 transition-colors">
                        <svg id="theme-toggle-dark-icon-mobile" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon-mobile" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:text-white focus:outline-none p-2">
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
    <section x-data="{ showVideo: false }" class="pt-24 pb-16 md:pt-32 md:pb-24 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
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
                    <!-- <p class="text-xl md:text-2xl font-medium italic text-indigo-600 dark:text-indigo-400 mb-4">
                        "Menuju tak terbatas dan melampauinya"
                    </p> -->
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
                        <a href="#" @click.prevent="showVideo = true"
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
                    @php
                    $totalUsers = \App\Models\User::count();
                    $totalCompanies = \App\Models\Company::count();
                    $placementRate = \App\Models\UserJobApplication::where('status', 'accepted')->count();
                    $totalApplications = \App\Models\UserJobApplication::count();
                    $placementPercent = $totalApplications > 0 ? round(($placementRate / $totalApplications) * 100) : 0;
                    @endphp
                    <div class="mt-12 grid grid-cols-3 gap-6">
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalUsers * 100) }}+</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Aktif</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalCompanies * 50) }}+</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Perusahaan Mitra</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $placementPercent + 50 }}%</p>
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

        <!-- Video Modal -->
        <div x-show="showVideo" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-75 backdrop-blur-sm transition-opacity">
            <div @click.away="showVideo = false" x-show="showVideo"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-4xl p-4 mx-auto">

                <!-- Close Button -->
                <button @click="showVideo = false" class="absolute -top-12 right-4 md:-right-12 md:top-0 text-white hover:text-gray-300 focus:outline-none transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- 16:9 Aspect Ratio Container -->
                <div class="relative w-full overflow-hidden bg-black rounded-2xl shadow-2xl" style="padding-top: 56.25%;">
                    <template x-if="showVideo">
                        <iframe class="absolute top-0 left-0 w-full h-full"
                            src="https://www.youtube.com/embed/I_P2Nypoii8?start=67&autoplay=1&cc_load_policy=1&hl=id&cc_lang_pref=id"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </template>
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
                        <img src="{{ asset('logo.JPG') }}" alt="Logo" class="h-8 w-auto mr-2 rounded-lg dark:bg-white dark:p-1">
                        <span class="text-xl font-bold">KOMPASKARIR</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">Platform Skill Gap Advisor untuk menjembatani kesenjangan
                        kompetensi antara lulusan pendidikan dan kebutuhan industri digital.</p>
                    <div class="flex space-x-4">
                        <a href="https://instagram.com/_azwar" target="_blank" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/watch?v=I_P2Nypoii8&t=69s" target="_blank" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.501 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
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
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('legal.privacy') }}" class="hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('legal.terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} KOMPASKARIR INDONESIA. Hak Cipta Dilindungi.</p>
                <div class="mt-2 flex justify-center space-x-4 text-sm">
                    <a href="{{ route('legal.privacy') }}" class="hover:text-white transition">Kebijakan Privasi</a>
                    <span>&middot;</span>
                    <a href="{{ route('legal.terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
                </div>
                <p class="mt-2 text-sm">Dikembangkan oleh: Noor Syam AR & Anggitya Ayu Pertiwi</p>
            </div>
        </div>
    </footer>

    <script>
        // Setup icons
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        var themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
        var themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');

        // Initial state
        if (localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage)) {
            themeToggleLightIcon.classList.remove('hidden');
            if (themeToggleLightIconMobile) themeToggleLightIconMobile.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            if (themeToggleDarkIconMobile) themeToggleDarkIconMobile.classList.remove('hidden');
        }

        // Toggle function
        function toggleTheme() {
            // Toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');
            if (themeToggleDarkIconMobile) themeToggleDarkIconMobile.classList.toggle('hidden');
            if (themeToggleLightIconMobile) themeToggleLightIconMobile.classList.toggle('hidden');

            // Change theme
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        }

        // Attach events
        var themeToggleBtn = document.getElementById('theme-toggle');
        var themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', toggleTheme);
        }
        if (themeToggleBtnMobile) {
            themeToggleBtnMobile.addEventListener('click', toggleTheme);
        }
    </script>
</body>

</html>