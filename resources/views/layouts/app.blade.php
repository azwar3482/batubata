<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KOMPASKARIR') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('logo.JPG') }}" type="image/png" class="h-8 w-auto mr-2 rounded-lg">

    <!-- Google Fonts - Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Custom Slim Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mini Sidebar Styles */
        .mini-sidebar {
            width: 5rem !important;
            /* 80px */
        }

        .mini-sidebar .sidebar-text {
            display: none !important;
        }

        .mini-sidebar .sidebar-icon {
            margin-right: 0 !important;
        }

        .mini-sidebar .menu-link {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            position: relative;
        }

        .mini-sidebar .menu-tooltip {
            display: block !important;
        }

        .menu-tooltip {
            display: none;
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%) translateX(10px);
            background: #1e293b;
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s;
            z-index: 100;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .mini-sidebar .menu-link:hover .menu-tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        .mini-sidebar .logo-text {
            display: none !important;
        }

        .mini-sidebar .logo-container {
            justify-content: center !important;
            padding: 0 !important;
        }

        .mini-sidebar .user-info-text {
            display: none !important;
        }

        .mini-sidebar .user-card {
            padding: 0.5rem !important;
            justify-content: center !important;
            margin-left: 0.75rem !important;
            margin-right: 0.75rem !important;
        }

        .mini-sidebar .badge-pulse {
            position: absolute;
            top: -2px;
            right: -2px;
            margin: 0 !important;
        }

        .sidebar-nav {
            overflow-x: visible !important;
            overflow-y: visible !important;
        }

        /* Dark Mode Overrides for Sidebar */
        .dark .menu-link.text-slate-600 {
            color: #cbd5e1;
        }

        .dark .menu-link:hover {
            background-color: rgba(30, 41, 59, 0.8) !important;
            color: #f1f5f9 !important;
        }

        .dark .menu-link.bg-gradient-to-r {
            background: linear-gradient(to right, rgba(30, 58, 138, 0.2), rgba(49, 46, 129, 0.1)) !important;
            color: #60a5fa !important;
            border-color: #3b82f6 !important;
        }

        .dark .sidebar-icon.text-slate-400 {
            color: #64748b;
        }

        .dark .menu-tooltip {
            background: #0f172a;
            border: 1px solid #334155;
        }

        .dark .user-card {
            background: linear-gradient(to bottom right, #1e293b, rgba(49, 46, 129, 0.2));
            border-color: rgba(51, 65, 85, 0.8);
        }

        .dark .user-info-text p.text-slate-800 {
            color: #e2e8f0;
        }

        .dark .user-info-text span.bg-blue-50 {
            background-color: rgba(30, 58, 138, 0.3);
            color: #93c5fd;
            border-color: rgba(30, 58, 138, 0.5);
        }

        /* Dark Mode Overrides for Navbar & Dropdowns */
        .dark .bg-white.rounded-2xl {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }

        .dark .border-slate-50 {
            border-color: #334155 !important;
        }

        .dark .text-slate-700 {
            color: #e2e8f0 !important;
        }

        .dark .text-slate-800 {
            color: #f8fafc !important;
        }

        .dark .hover\:bg-slate-50\/80:hover {
            background-color: rgba(51, 65, 85, 0.5) !important;
        }

        .dark .bg-slate-50\/50 {
            background-color: rgba(30, 41, 59, 0.5) !important;
        }

        .dark .border-slate-100 {
            border-color: #334155 !important;
        }

        .dark .hover\:bg-slate-50:hover,
        .dark .hover\:bg-gray-50:hover,
        .dark .hover\:bg-gray-100:hover,
        .dark .hover\:bg-white:hover {
            background-color: #334155 !important;
            color: #f8fafc !important;
        }

        .dark .text-slate-600 {
            color: #cbd5e1 !important;
        }

        .dark .bg-rose-50 {
            background-color: rgba(159, 18, 57, 0.2) !important;
        }

        /* Native elements dark mode support (e.g. Calendar Icons) */
        .dark {
            color-scheme: dark;
        }

        /* ==========================================================================
           GLOBAL DARK MODE THEME OVERRIDES (Phase 2 - Tables, Cards, Text & Forms)
           ========================================================================== */

        /* 1. Core Background Overrides */
        .dark .bg-white {
            background-color: #1e293b !important;
            /* Elevated slate-800 card color */
        }

        .dark .bg-gray-50,
        .dark .bg-slate-50,
        .dark .bg-slate-100 {
            background-color: #0f172a !important;
            /* Deep slate-900 background */
        }

        .dark .bg-gray-100 {
            background-color: #1e293b !important;
        }

        /* 2. Content & Utility Card Backgrounds */
        .dark .bg-indigo-50\/40,
        .dark .bg-slate-50\/50,
        .dark .bg-slate-50\/80,
        .dark .bg-slate-100\/80 {
            background-color: rgba(30, 41, 59, 0.6) !important;
        }

        .dark .bg-gradient-to-br.from-slate-50.to-indigo-50\/40 {
            background: linear-gradient(to bottom right, #1e293b, rgba(30, 41, 59, 0.4)) !important;
        }

        .dark .bg-gradient-to-br.from-emerald-50.to-white {
            background: linear-gradient(to bottom right, rgba(6, 78, 59, 0.2), #1e293b) !important;
            border-color: rgba(6, 78, 59, 0.4) !important;
        }

        .dark .bg-gradient-to-br.from-amber-50.to-orange-50 {
            background: linear-gradient(to bottom right, rgba(120, 53, 4, 0.2), rgba(120, 53, 4, 0.1)) !important;
            border-color: rgba(120, 53, 4, 0.3) !important;
        }

        /* 3. Text Contrast Restorations (Ensuring absolutely NO low-contrast grey text in dark mode) */
        .dark .text-gray-900,
        .dark .text-slate-900,
        .dark .text-gray-800,
        .dark .text-slate-800,
        .dark .text-black,
        .dark .text-gray-700,
        .dark .text-slate-700 {
            color: #f8fafc !important;
            /* Slate-50 off-white for main titles, values & labels */
        }

        .dark .text-gray-600,
        .dark .text-slate-600,
        .dark .text-gray-550,
        .dark .text-gray-500,
        .dark .text-slate-500,
        .dark .text-gray-400,
        .dark .text-slate-400 {
            color: #cbd5e1 !important;
            /* Slate-300 bright gray for description texts and subtitles */
        }

        /* 4. Table Elements & Row Hovers */
        .dark table {
            border-color: #334155 !important;
        }

        .dark thead {
            background-color: #0f172a !important;
            border-bottom: 2px solid #334155 !important;
        }

        .dark thead th {
            color: #94a3b8 !important;
            /* Readable slate-400 headers */
            font-weight: 600 !important;
            background-color: #0f172a !important;
        }

        .dark tbody tr {
            background-color: #1e293b !important;
            border-bottom-color: #334155 !important;
        }

        .dark tbody td {
            color: #cbd5e1 !important;
        }

        .dark tr.hover\:bg-gray-50:hover,
        .dark tr.hover\:bg-slate-50:hover,
        .dark tr.bg-slate-800\/50\/80:hover,
        .dark tr:hover {
            background-color: #334155 !important;
            /* Highlight slate-700 on hover */
        }

        .dark td.text-gray-300 {
            color: #475569 !important;
            /* Proper placeholder dash color */
        }

        /* 5. Borders & Dividers */
        .dark .border-gray-100,
        .dark .border-gray-200,
        .dark .border-gray-300,
        .dark .border-slate-100,
        .dark .border-slate-200,
        .dark .border-slate-300 {
            border-color: #334155 !important;
        }

        .dark .divide-gray-50,
        .dark .divide-gray-100,
        .dark .divide-gray-200,
        .dark .divide-slate-200,
        .dark .divide-slate-700 {
            border-color: #334155 !important;
        }

        /* 6. Form Inputs & Selects */
        .dark input[type="text"],
        .dark input[type="email"],
        .dark input[type="number"],
        .dark input[type="password"],
        .dark input[type="date"],
        .dark select,
        .dark textarea {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        .dark input[type="text"]:focus,
        .dark input[type="email"]:focus,
        .dark input[type="date"]:focus,
        .dark select:focus,
        .dark textarea:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
        }

        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #64748b !important;
        }

        /* 7. Low-Opacity Semantic Badge/Card Color Fixes for High-Contrast Premium Visuals */
        /* Blue Badges / Containers */
        .dark .bg-blue-50,
        .dark .bg-blue-100 {
            background-color: rgba(30, 58, 138, 0.4) !important;
            border-color: rgba(30, 58, 138, 0.6) !important;
        }

        .dark .text-blue-600,
        .dark .text-blue-700,
        .dark .text-blue-800 {
            color: #93c5fd !important;
        }

        /* Indigo Badges / Containers */
        .dark .bg-indigo-50,
        .dark .bg-indigo-100 {
            background-color: rgba(49, 46, 129, 0.4) !important;
            border-color: rgba(49, 46, 129, 0.6) !important;
        }

        .dark .text-indigo-600,
        .dark .text-indigo-700,
        .dark .text-indigo-800 {
            color: #c7d2fe !important;
        }

        /* Green / Emerald Badges / Containers */
        .dark .bg-green-50,
        .dark .bg-emerald-50,
        .dark .bg-green-100,
        .dark .bg-emerald-100 {
            background-color: rgba(6, 78, 59, 0.4) !important;
            border-color: rgba(6, 78, 59, 0.6) !important;
        }

        .dark .text-green-600,
        .dark .text-green-700,
        .dark .text-green-800,
        .dark .text-emerald-600,
        .dark .text-emerald-700,
        .dark .text-emerald-800 {
            color: #34d399 !important;
        }

        /* Yellow / Orange / Amber Badges / Containers */
        .dark .bg-yellow-50,
        .dark .bg-amber-50,
        .dark .bg-yellow-100,
        .dark .bg-amber-100 {
            background-color: rgba(120, 53, 4, 0.4) !important;
            border-color: rgba(120, 53, 4, 0.6) !important;
        }

        .dark .text-yellow-600,
        .dark .text-yellow-700,
        .dark .text-yellow-800,
        .dark .text-amber-800,
        .dark .text-amber-900,
        .dark .text-orange-600 {
            color: #fbbf24 !important;
        }

        /* Red / Rose Badges / Containers */
        .dark .bg-red-50,
        .dark .bg-rose-50,
        .dark .bg-red-100,
        .dark .bg-rose-100 {
            background-color: rgba(159, 18, 57, 0.4) !important;
            border-color: rgba(159, 18, 57, 0.6) !important;
        }

        .dark .text-red-600,
        .dark .text-red-700,
        .dark .text-red-800,
        .dark .text-rose-600,
        .dark .text-rose-700,
        .dark .text-rose-800 {
            color: #fca5a5 !important;
        }

        /* Purple Badges / Containers */
        .dark .bg-purple-50,
        .dark .bg-purple-100 {
            background-color: rgba(88, 28, 135, 0.4) !important;
            border-color: rgba(88, 28, 135, 0.6) !important;
        }

        .dark .text-purple-600,
        .dark .text-purple-700,
        .dark .text-purple-800 {
            color: #e9d5ff !important;
        }

        /* 8. Specific Layout Fixes */
        /* Radar Chart Canvas container */
        .dark .h-64.bg-gray-50 {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
        }

        /* Timeline specific fixes in Roadmap */
        .dark .bg-purple-200 {
            background-color: rgba(139, 92, 246, 0.3) !important;
        }

        /* Quick Tips Specific Fixes */
        .dark .border-amber-200 {
            border-color: rgba(120, 53, 4, 0.4) !important;
        }

        .dark .text-amber-800,
        .dark .text-amber-900 {
            color: #fcd34d !important;
        }

        /* Standard Laravel Pagination elements inside dark mode */
        .dark .pagination {
            background-color: #1e293b !important;
        }

        .dark nav[role="navigation"] span,
        .dark nav[role="navigation"] a {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        .dark nav[role="navigation"] a:hover {
            background-color: #334155 !important;
            color: #f8fafc !important;
        }

        .dark nav[role="navigation"] span[aria-current="page"] span {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
    </style>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="antialiased bg-[#f8fafc] dark:bg-slate-900 text-slate-800 dark:text-slate-200 relative overflow-hidden transition-colors duration-300">
    <!-- Ambient Blur Lighting Glows -->
    <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-gradient-to-br from-indigo-200/20 to-violet-300/20 blur-[100px] -z-10 pointer-events-none dark:opacity-5"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-blue-100/30 to-indigo-100/20 blur-[120px] -z-10 pointer-events-none dark:opacity-5"></div>

    <div x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth >= 1024 }" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full lg:translate-x-0 mini-sidebar'"
            class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800 shadow-xl lg:shadow-none transform transition-all duration-300 ease-in-out lg:static flex flex-col h-full">

            <div class="flex-none">
                <!-- Logo & Close Button (Mobile) -->
                <div class="flex items-center justify-between px-6 h-16 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-700 text-white font-extrabold text-lg tracking-wider shadow-sm logo-container transition-all duration-300">
                    <div class="flex items-center">
                        <img src="{{ asset('logo.JPG') }}" alt="Logo" class="h-9 w-auto mr-3 rounded-lg ring-2 ring-white/20 transition-all duration-300 hover:rotate-6 sidebar-icon">
                        <span class="logo-text transition-all duration-300">KOMPASKARIR</span>
                    </div>
                    <button @click="sidebarOpen = false" class="text-white/80 hover:text-white focus:outline-none lg:hidden p-1 rounded-lg hover:bg-white/10 transition-colors" aria-label="Close Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- User Info Card Widget -->
                <div class="mx-4 my-4 p-4 rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50/40 dark:from-slate-800/50 dark:to-indigo-950/20 border border-slate-100/80 dark:border-slate-800/80 shadow-sm relative overflow-hidden group user-card transition-all duration-300">
                    <div class="absolute -right-3 -top-3 w-12 h-12 rounded-full bg-indigo-500/5 group-hover:scale-150 transition-all duration-500"></div>
                    <div class="flex items-center space-x-3 w-full">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-200 shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0 user-info-text transition-opacity duration-300">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100 capitalize">
                                {{ str_replace('_', ' ', Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scrollable Navigation Wrapper -->
            <div class="flex-1 pb-4" :class="sidebarOpen ? 'overflow-y-auto overflow-x-hidden' : 'overflow-visible'">
                <!-- Navigation Menu -->
                <nav class="px-3 space-y-1 sidebar-nav h-full">

                    @if (Auth::user()->role === 'job_seeker')
                    <!-- Menu Job Seeker -->
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <a href="{{ route('seeker.assessment.start') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('seeker.assessment.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.assessment.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.competency_assessment') }}</span>
                        <div class="menu-tooltip">{{ __('messages.competency_assessment') }}</div>
                    </a>

                    <a href="{{ route('seeker.roadmap.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('seeker.roadmap.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.roadmap.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.career_roadmap') }}</span>
                        <div class="menu-tooltip">{{ __('messages.career_roadmap') }}</div>
                    </a>

                    <a href="{{ route('seeker.jobs.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('seeker.jobs.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.jobs.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.job_vacancies') }}</span>
                        <div class="menu-tooltip">{{ __('messages.job_vacancies') }}</div>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                        <span class="ml-auto badge-pulse bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ring-2 ring-red-100 animate-pulse">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </a>

                    <a href="{{ route('seeker.courses.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('seeker.courses.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.courses.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.courses_learning') }}</span>
                        <div class="menu-tooltip">{{ __('messages.courses_learning') }}</div>
                    </a>
                    @elseif(Auth::user()->isIndustryOrStaff())
                    <!-- Menu Industry/HRD -->
                    <a href="{{ route('industry.dashboard') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('industry.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    @can('post_jobs')
                    <a href="{{ route('industry.jobs.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('industry.jobs.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.jobs.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.post_job') }}</span>
                        <div class="menu-tooltip">{{ __('messages.post_job') }}</div>
                    </a>
                    @endcan

                    @can('view_candidates')
                    <a href="{{ route('industry.candidates') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('industry.candidates*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.candidates*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.search_candidates') }}</span>
                        <div class="menu-tooltip">{{ __('messages.search_candidates') }}</div>
                    </a>
                    @endcan

                    @if(Auth::user()->isIndustry() || Auth::user()->role === 'staf_hr_manager')
                    <a href="{{ route('industry.team') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('industry.team*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.team*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.manage_team') }}</span>
                        <div class="menu-tooltip">{{ __('messages.manage_team') }}</div>
                    </a>
                    @endif
                    @elseif(Auth::user()->role === 'education')
                    <!-- Menu Education -->
                    <a href="{{ route('education.dashboard') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('education.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <a href="{{ route('education.analytics') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('education.analytics*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.analytics*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.graduate_analytics') }}</span>
                        <div class="menu-tooltip">{{ __('messages.graduate_analytics') }}</div>
                    </a>

                    <a href="{{ route('education.students') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('education.students*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.students*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">Data Siswa/Lulusan</span>
                        <div class="menu-tooltip">Data Siswa/Lulusan</div>
                    </a>

                    @elseif(Auth::user()->role === 'admin')
                    <!-- Menu Admin -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <a href="{{ route('admin.users') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.users*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">Kelola Pengguna</span>
                        <div class="menu-tooltip">Kelola Pengguna</div>
                    </a>

                    <a href="{{ route('admin.competencies') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.competencies*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.competencies*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">Kompetensi</span>
                        <div class="menu-tooltip">Kompetensi</div>
                    </a>

                    <a href="{{ route('admin.reports') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.reports*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.reports*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">Laporan</span>
                        <div class="menu-tooltip">Laporan</div>
                    </a>

                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-all duration-300">Master Data</div>

                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.categories*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.categories*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">Kategori</span>
                        <div class="menu-tooltip">Kategori</div>
                    </a>

                    <a href="{{ route('admin.positions.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.positions*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.positions*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.positions') }}</span>
                        <div class="menu-tooltip">{{ __('messages.positions') }}</div>
                    </a>

                    <a href="{{ route('admin.courses.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.courses*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.courses*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.course_management') }}</span>
                        <div class="menu-tooltip">{{ __('messages.course_management') }}</div>
                    </a>

                    <a href="{{ route('admin.document-weights.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.document-weights*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.document-weights*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.ai_document_weights') }}</span>
                        <div class="menu-tooltip">{{ __('messages.ai_document_weights') }}</div>
                    </a>

                    <a href="{{ route('admin.ai-workflow') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.ai-workflow*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.ai-workflow*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.ai_workflow') }}</span>
                        <div class="menu-tooltip">{{ __('messages.ai_workflow') }}</div>
                    </a>

                    <a href="{{ route('admin.skill-keywords.index') }}"
                        class="group flex items-center menu-link px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] {{ request()->routeIs('admin.skill-keywords*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.skill-keywords*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="sidebar-text transition-all duration-300">{{ __('messages.ai_dictionary') }}</span>
                        <div class="menu-tooltip">{{ __('messages.ai_dictionary') }}</div>
                    </a>
                    @endif

                </nav>
            </div>
        </aside>

        <!-- Overlay Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="flex items-center justify-between h-16 px-6 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40 shadow-sm shadow-slate-100/40 dark:shadow-none transition-colors duration-300">

                <!-- Left Side: Burger & Mobile Logo -->
                <div class="flex items-center">
                    <!-- Animated Burger Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 focus:outline-none hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 active:scale-95 relative w-10 h-10 flex items-center justify-center lg:hidden" aria-label="Toggle Sidebar">
                        <div class="w-6 h-5 flex flex-col justify-between relative">
                            <span :class="sidebarOpen ? 'rotate-45 translate-y-[9px]' : ''" class="w-6 h-[2px] bg-slate-600 dark:bg-slate-400 rounded-full transition-all duration-300 transform origin-center"></span>
                            <span :class="sidebarOpen ? 'opacity-0 translate-x-2' : ''" class="w-6 h-[2px] bg-slate-600 dark:bg-slate-400 rounded-full transition-all duration-300 transform"></span>
                            <span :class="sidebarOpen ? '-rotate-45 -translate-y-[9px]' : ''" class="w-6 h-[2px] bg-slate-600 dark:bg-slate-400 rounded-full transition-all duration-300 transform origin-center"></span>
                        </div>
                    </button>

                    <!-- Sidebar Toggle for Desktop -->
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex text-slate-500 focus:outline-none hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 active:scale-95 relative w-10 h-10 items-center justify-center" aria-label="Toggle Sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>

                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex items-center ml-3">
                        <img src="{{ asset('logo.JPG') }}" alt="Logo" class="h-8 w-auto rounded-lg shadow-sm">
                        <span class="ml-2 font-bold text-slate-800 dark:text-slate-100 tracking-wide text-sm">KOMPASKARIR</span>
                    </div>
                </div>

                <!-- Right Menu Header -->
                <div class="flex items-center ml-auto space-x-2 sm:space-x-6">
                    <!-- Tour Button -->
                    @if(request()->routeIs('*dashboard*'))
                    <button id="start-tour-btn" type="button" class="animate-pulse flex items-center space-x-1 text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 focus:outline-none transition-colors duration-200 p-1.5 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/30 text-sm font-medium" title="Mulai Tour Panduan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="hidden sm:inline">Tour App kompaskarir</span>
                    </button>
                    @endif

                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ openLang: false }">
                        <button @click="openLang = !openLang" @click.away="openLang = false" class="flex items-center space-x-1 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none transition-colors duration-200 p-1.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 text-sm font-medium">
                            <span>{{ app()->getLocale() == 'en' ? '🇬🇧 EN' : '🇮🇩 ID' }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="openLang ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openLang" style="display: none;"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-3 w-36 bg-white dark:bg-slate-800 rounded-2xl shadow-xl py-2 z-50 border border-slate-100 dark:border-slate-700/60">
                            <a href="{{ route('lang.switch', 'id') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ app()->getLocale() == 'id' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-slate-700/30' : '' }}">
                                <span class="mr-2">🇮🇩</span> Indonesia
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ app()->getLocale() == 'en' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-slate-700/30' : '' }}">
                                <span class="mr-2">🇬🇧</span> English
                            </a>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" type="button" class="text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none relative transition-colors duration-200 p-1.5 rounded-full hover:bg-slate-50 dark:hover:bg-slate-800">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Notifikasi Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none relative transition-colors duration-200 p-1.5 rounded-full hover:bg-slate-50 dark:hover:bg-slate-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            @if (Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-4 h-4 text-[9px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900 animate-pulse">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                            @endif
                        </button>

                        <!-- Dropdown Card -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-xl py-2 z-50 border border-slate-100 dark:border-slate-700/60 dark:shadow-slate-950/40">
                            <div class="px-4 py-2.5 border-b border-slate-50 dark:border-slate-700/60 font-semibold text-xs text-slate-700 dark:text-slate-300 tracking-wider uppercase">{{ __('messages.notifications') }}</div>

                            <div class="max-h-60 overflow-y-auto">
                                @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notif)
                                <a href="#"
                                    class="block px-4 py-3 hover:bg-slate-50/80 dark:hover:bg-slate-700/40 border-b border-slate-50 dark:border-slate-750/40 last:border-0 transition-colors duration-200">
                                    <p class="text-xs font-medium text-slate-800 dark:text-slate-200 leading-relaxed">
                                        {{ $notif->data['message'] ?? 'Notifikasi baru' }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $notif->created_at->diffForHumans() }}
                                    </p>
                                </a>
                                @empty
                                <div class="px-4 py-8 text-xs text-slate-400 dark:text-slate-500 text-center flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v2m16 4h-2a2 2 0 00-2 2v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3a2 2 0 00-2-2H2"></path>
                                    </svg>
                                    <span>{{ __('messages.no_new_notifications') }}</span>
                                </div>
                                @endforelse
                            </div>

                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-slate-850/30 border-t border-slate-50 dark:border-slate-700/60 text-center rounded-b-2xl">
                                <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                                    @csrf @method('PUT')
                                    <button type="submit" class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition">
                                        Tandai semua dibaca
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- User Badge & Dropdown -->
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center space-x-3 border-l border-slate-100 dark:border-slate-850 pl-6 h-8 select-none focus:outline-none group">
                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-300 transition-colors duration-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xs font-bold shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-105">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-transform duration-300" :class="openProfile ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="openProfile" style="display: none;"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-xl py-2 z-50 border border-slate-100 dark:border-slate-700/60 dark:shadow-slate-950/40">

                            <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-700/60">
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-medium text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-3 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('messages.edit_profile') }}
                                </a>
                            </div>

                            <div class="py-1 border-t border-slate-50 dark:border-slate-700/60">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group flex items-center w-full px-4 py-2.5 text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/20 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-3 text-rose-400 dark:text-rose-500 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        {{ __('messages.logout') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 relative">
                <!-- Success Floating Toast -->
                @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-[-20px]"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-[-20px]"
                    class="mb-6 bg-emerald-50/80 dark:bg-emerald-900/40 backdrop-blur border border-emerald-100 dark:border-emerald-800 p-4 rounded-2xl shadow-sm flex items-start space-x-3">
                    <div class="p-1 rounded-lg bg-emerald-500 dark:bg-emerald-600 text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xs font-bold text-emerald-800 dark:text-emerald-300">{{ __('messages.success') }}</h4>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @endif

                <!-- Error Floating Toast -->
                @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-[-20px]"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-[-20px]"
                    class="mb-6 bg-rose-50/80 dark:bg-rose-900/40 backdrop-blur border border-rose-100 dark:border-rose-800 p-4 rounded-2xl shadow-sm flex items-start space-x-3">
                    <div class="p-1 rounded-lg bg-rose-500 dark:bg-rose-600 text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xs font-bold text-rose-800 dark:text-rose-300">{{ __('messages.error') }}</h4>
                        <p class="text-xs text-rose-700 dark:text-rose-400 mt-0.5 leading-relaxed">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-rose-400 hover:text-rose-600 dark:hover:text-rose-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

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
        });
    </script>
</body>

</html>