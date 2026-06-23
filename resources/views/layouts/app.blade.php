@php
    $dashboardRoute = route('dashboard');
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) $dashboardRoute = route('admin.dashboard');
        elseif (Auth::user()->isIndustryOrStaff()) $dashboardRoute = route('industry.dashboard');
        elseif (Auth::user()->isTeacher()) $dashboardRoute = route('teacher.dashboard');
        elseif (Auth::user()->isEducation()) $dashboardRoute = route('education.dashboard');
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KOMPASKARIR INDONESIA') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/jpeg" class="h-8 w-auto mr-2 rounded-lg">

    <!-- Google Fonts - Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @stack('head-scripts')

    <style>
        [x-cloak] { display: none !important; }
        
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
            transition: opacity 0.2s ease, transform 0.2s ease;
            z-index: 50;
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

        /* Light Mode - Menu Link Hover Styles */
        .menu-link {
            position: relative;
            /* Hanya transisi property visual, bukan layout. Ini mencegah area klik bergeser */
            transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease !important;
            cursor: pointer !important;
            user-select: none;
            /* Pastikan elemen tidak bergerak karena transisi layout dari sidebar */
            transform: none !important;
        }

        .menu-link:hover {
            background-color: #f0f4ff !important;
            color: #1e40af !important;
        }

        .menu-link:hover .sidebar-icon {
            color: #2563eb !important;
        }

        .menu-link:hover .sidebar-text {
            color: #1e40af !important;
        }

        /* Active state - stronger visual */
        .menu-link.bg-gradient-to-r {
            background: linear-gradient(to right, #dbeafe, #e0e7ff) !important;
            color: #1e40af !important;
            border-left: 4px solid #2563eb !important;
            font-weight: 600 !important;
        }

        .menu-link.bg-gradient-to-r .sidebar-icon {
            color: #2563eb !important;
        }

        /* Remove scale transform that causes click issues */
        .menu-link:active {
            transform: none !important;
        }

        /* Saat sidebar sedang bertransisi, hanya blokir toggle button,
           menu link tetap bisa diklik agar navigasi tidak terganggu */
        aside.sidebar-transitioning .sidebar-toggle-btn {
            pointer-events: none !important;
            cursor: not-allowed !important;
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

        /* ============================================ */
        /* GLOBAL HOVER STYLES - LIGHT MODE             */
        /* ============================================ */

        /* Table Row Hover */
        tbody tr {
            transition: all 0.15s ease !important;
        }
        tbody tr:hover {
            background-color: #f0f4ff !important;
            box-shadow: inset 3px 0 0 #3b82f6;
        }

        /* Table Header Hover */
        thead th {
            transition: all 0.15s ease !important;
            cursor: default;
        }
        thead th:hover {
            background-color: #e8edf5 !important;
            color: #1e40af !important;
        }

        /* Link Hover */
        a:not(.menu-link):not(.btn) {
            transition: all 0.15s ease !important;
        }

        /* Button Hover */
        button:not([disabled]) {
            transition: all 0.15s ease !important;
        }

        /* Card/Section Hover */
        .bg-white.rounded-xl, .bg-white.rounded-2xl {
            transition: all 0.2s ease !important;
        }
        .bg-white.rounded-xl:hover, .bg-white.rounded-2xl:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }

        /* Input Focus */
        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            outline: none !important;
        }

        /* Pagination Link Hover */
        .pagination a, .pagination button {
            transition: all 0.15s ease !important;
        }
        .pagination a:hover, .pagination button:hover {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            border-color: #93c5fd !important;
        }

        /* Dark Mode Overrides for Sidebar */
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

        /* ============================================ */
        /* BOTTOM NAV BAR - MOBILE LAYOUT               */
        /* ============================================ */
        .bottom-nav-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid #e2e8f0;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }
        .dark .bottom-nav-bar {
            background: rgba(15, 23, 42, 0.95);
            border-top-color: #334155;
        }
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6px 0;
            min-width: 0;
            flex: 1;
            color: #94a3b8;
            transition: color 0.15s ease;
            -webkit-tap-highlight-color: transparent;
            text-decoration: none;
            position: relative;
        }
        .bottom-nav-item.active {
            color: #2563eb;
        }
        .dark .bottom-nav-item.active {
            color: #60a5fa;
        }
        .bottom-nav-item:not(.active):active {
            color: #64748b;
        }
        .dark .bottom-nav-item:not(.active):active {
            color: #cbd5e1;
        }
        .bottom-nav-badge {
            position: absolute;
            top: 0;
            right: 50%;
            transform: translateX(12px);
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            font-size: 9px;
            font-weight: 700;
            line-height: 16px;
            text-align: center;
            color: #fff;
            background: #ef4444;
            border-radius: 9999px;
            border: 2px solid #fff;
            animation: pulse 2s infinite;
        }
        .dark .bottom-nav-badge {
            border-color: #0f172a;
        }

        /* Bottom Sheet */
        .bottom-sheet-overlay {
            position: fixed;
            inset: 0;
            z-index: 55;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .bottom-sheet-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 56;
            background: #fff;
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
            max-height: 75vh;
            display: flex;
            flex-direction: column;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }
        .dark .bottom-sheet-panel {
            background: #1e293b;
        }
        .bottom-sheet-handle {
            width: 36px;
            height: 4px;
            border-radius: 9999px;
            background: #cbd5e1;
            margin: 10px auto 6px;
            flex-shrink: 0;
        }
        .dark .bottom-sheet-handle {
            background: #475569;
        }

        /* ============================================ */
        /* LEFT-HANDED MODE (Sidebar Right)             */
        /* ============================================ */
        body[data-sidebar-position="right"] > div.flex {
            flex-direction: row-reverse !important;
        }
        
        body[data-sidebar-position="right"] aside {
            border-right: none !important;
            border-left: 1px solid #e2e8f0 !important;
        }
        
        /* Mobile: sidebar closed = translate to right */
        @media (max-width: 1023px) {
            body[data-sidebar-position="right"] aside.translate-x-full {
                transform: translateX(100%) !important;
            }
            body[data-sidebar-position="right"] aside.translate-x-0 {
                transform: translateX(0) !important;
            }
        }
        
        /* Desktop: always visible */
        @media (min-width: 1024px) {
            body[data-sidebar-position="right"] aside {
                transform: none !important;
            }
        }
        
        .dark body[data-sidebar-position="right"] aside {
            border-left-color: #334155 !important;
            border-right: none !important;
        }
        
        body[data-sidebar-position="right"] .sidebar-overlay {
            left: auto !important;
            right: 0 !important;
        }
        
        body[data-sidebar-position="right"] .menu-tooltip {
            left: auto !important;
            right: 100% !important;
            transform: translateY(-50%) translateX(-10px) !important;
        }
        
        body[data-sidebar-position="right"] .mini-sidebar .menu-link:hover .menu-tooltip {
            transform: translateY(-50%) translateX(0) !important;
        }
        
        body[data-sidebar-position="right"] .menu-link.bg-gradient-to-r {
            border-left: none !important;
            border-right: 4px solid #2563eb !important;
            background: linear-gradient(to left, #dbeafe, #e0e7ff) !important;
        }

        /* Ensure sidebar is always visible on desktop */
        @media (min-width: 1024px) {
            aside[x-show] {
                display: flex !important;
            }
        }

        /* Hide sidebar on mobile when bottombar layout is active (before Alpine.js loads) */
        body[data-mobile-layout="bottombar"] aside {
            transform: translateX(-100%) !important;
            visibility: hidden !important;
        }
        @media (min-width: 1024px) {
            body[data-mobile-layout="bottombar"] aside {
                transform: none !important;
                visibility: visible !important;
            }
        }
        /* Hide overlay on mobile when bottombar layout is active */
        body[data-mobile-layout="bottombar"] .sidebar-overlay {
            display: none !important;
        }
        /* Adjust chat widget position when bottombar is active */
        body[data-mobile-layout="bottombar"] #chat-widget .fixed.bottom-4 {
            bottom: 4.5rem !important;
        }
        body[data-mobile-layout="bottombar"] #chat-widget .fixed.bottom-20 {
            bottom: 6.5rem !important;
        }
        @media (min-width: 640px) {
            body[data-mobile-layout="bottombar"] #chat-widget .fixed.bottom-4 {
                bottom: 4.5rem !important;
            }
            body[data-mobile-layout="bottombar"] #chat-widget .fixed.bottom-20 {
                bottom: 6.5rem !important;
            }
        }
        .bottom-sheet-scroll {
            overflow-y: auto;
            flex: 1;
            padding: 0 0 16px 0;
        }
        .bottom-sheet-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #334155;
            transition: background-color 0.15s ease;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
        }
        .bottom-sheet-item:hover,
        .bottom-sheet-item:active {
            background-color: #f1f5f9;
        }
        .dark .bottom-sheet-item {
            color: #e2e8f0;
        }
        .dark .bottom-sheet-item:hover,
        .dark .bottom-sheet-item:active {
            background-color: #334155;
        }
        .bottom-sheet-item.active {
            background: linear-gradient(to right, #dbeafe, #e0e7ff);
            color: #1e40af;
            font-weight: 600;
            border-left: 4px solid #2563eb;
        }
        .dark .bottom-sheet-item.active {
            background: linear-gradient(to right, rgba(30, 58, 138, 0.2), rgba(49, 46, 129, 0.1));
            color: #60a5fa;
            border-color: #3b82f6;
        }
        .bottom-sheet-category {
            padding: 12px 20px 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
        }
        .dark .bottom-sheet-category {
            color: #64748b;
        }
        .bottom-sheet-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 4px 0;
        }
        .dark .bottom-sheet-divider {
            background: #334155;
        }
    </style>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="antialiased bg-[#f8fafc] dark:bg-slate-900 text-slate-800 dark:text-slate-200 relative overflow-hidden transition-colors duration-300" data-mobile-layout="{{ Auth::user()->mobile_layout ?? 'sidebar' }}" data-sidebar-position="{{ Auth::user()->sidebar_position ?? 'left' }}">
    <!-- Ambient Blur Lighting Glows (hidden on mobile to prevent overflow) -->
    <div class="hidden md:block absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-gradient-to-br from-indigo-200/20 to-violet-300/20 blur-[100px] -z-10 pointer-events-none dark:opacity-5"></div>
    <div class="hidden md:block absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-blue-100/30 to-indigo-100/20 blur-[120px] -z-10 pointer-events-none dark:opacity-5"></div>

    <div x-data="{ 
            mobileLayout: '{{ Auth::user()->mobile_layout ?? 'sidebar' }}',
            sidebarPosition: '{{ Auth::user()->sidebar_position ?? 'left' }}',
            bottomSheetOpen: false,
            sidebarOpen: localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth >= 1024,
            _isTransitioning: false,
            sidebarToggle() {
                if (this._isTransitioning) return;
                this._isTransitioning = true;
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
                const aside = document.querySelector('aside');
                if (aside) aside.classList.add('sidebar-transitioning');
                setTimeout(() => {
                    this._isTransitioning = false;
                    if (aside) aside.classList.remove('sidebar-transitioning');
                }, 320);
            },
            getSidebarClasses() {
                if (this.sidebarOpen) {
                    return this.sidebarPosition === 'right' 
                        ? 'translate-x-0 w-[280px] sm:w-64 right-0' 
                        : 'translate-x-0 w-[280px] sm:w-64 left-0';
                } else if (this.sidebarPosition === 'right') {
                    return 'translate-x-full lg:translate-x-0 mini-sidebar right-0';
                } else {
                    return '-translate-x-full lg:translate-x-0 mini-sidebar left-0';
                }
            }
        }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="getSidebarClasses()"
            class="fixed inset-y-0 z-40 bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800 shadow-xl lg:shadow-none transform transition-[width,transform] duration-300 ease-in-out lg:static flex flex-col h-full"
            x-show="mobileLayout === 'sidebar'"
            x-transition>

            <div class="flex-none">
                <!-- Logo & Close Button (Mobile) -->
                <div class="flex items-center justify-between px-4 sm:px-6 h-14 sm:h-16 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-700 text-white font-extrabold text-lg tracking-wider shadow-sm logo-container transition-[width,opacity] duration-300">
                    <a href="{{ $dashboardRoute }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-8 w-auto mr-2 sm:mr-3 rounded-lg ring-2 ring-white/20 transition-transform duration-300 hover:rotate-6 sidebar-icon dark:bg-white dark:p-1">
                        <span class="logo-text transition-[opacity] duration-300 text-sm sm:text-base">KOMPASKARIR</span>
                    </a>
                    <button @click="sidebarToggle()" class="sidebar-toggle-btn text-white/80 hover:text-white focus:outline-none lg:hidden p-1.5 rounded-lg hover:bg-white/10 transition-colors" aria-label="Close Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- User Info Card Widget -->
                <div class="mx-3 sm:mx-4 my-3 sm:my-4 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50/40 dark:from-slate-800/50 dark:to-indigo-950/20 border border-slate-100/80 dark:border-slate-800/80 shadow-sm relative overflow-hidden group user-card transition-[opacity,margin] duration-300">
                    <div class="absolute -right-3 -top-3 w-12 h-12 rounded-full bg-indigo-500/5 group-hover:scale-150 transition-all duration-500"></div>
                    <div class="flex items-center space-x-2.5 sm:space-x-3 w-full">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-200 shrink-0 text-sm sm:text-base overflow-hidden">
                            @php $navPhoto1 = Auth::user()->documents->where('document_type', 'photo')->first(); @endphp
                            @if($navPhoto1)
                                <x-webp-image :storagePath="$navPhoto1->file_path" alt="Photo" class="w-full h-full object-cover" loading="lazy" />
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 user-info-text transition-opacity duration-300">
                            <p class="text-xs sm:text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center mt-1 px-1.5 sm:px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100 capitalize">
                                {{ str_replace('_', ' ', Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scrollable Navigation Wrapper -->
            <div class="flex-1 pb-3 sm:pb-4 flex flex-col" :class="sidebarOpen ? 'overflow-y-auto overflow-x-hidden' : 'overflow-visible'">
                <!-- Navigation Menu -->
                <nav @click="$event.target.closest('a') && window.innerWidth < 1024 && (sidebarOpen = false, localStorage.setItem('sidebarOpen', 'false'))" class="px-2 sm:px-3 space-y-0.5 sm:space-y-1 sidebar-nav">

                    @if (Auth::user()->role === 'job_seeker')
                    <!-- Menu Job Seeker -->
                    <div class="pt-2 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Ringkasan</div>
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Eksplorasi Karir</div>
                    <a href="{{ route('seeker.assessment.start') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.assessment.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.assessment.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.competency_assessment') }}</span>
                        <div class="menu-tooltip">{{ __('messages.competency_assessment') }}</div>
                    </a>

                    <a href="{{ route('seeker.roadmap.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.roadmap.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.roadmap.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.career_roadmap') }}</span>
                        <div class="menu-tooltip">{{ __('messages.career_roadmap') }}</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Peluang & Pengembangan</div>
                    <a href="{{ route('seeker.jobs.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.jobs.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.jobs.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.job_vacancies') }}</span>
                        <div class="menu-tooltip">{{ __('messages.job_vacancies') }}</div>
                        @php
                            $jobNotifCount = Auth::user()->unreadNotifications()
                                ->whereNotIn('data->type', ['tpa_invitation', 'tpa_offline_invitation'])
                                ->count();
                        @endphp
                        @if ($jobNotifCount > 0)
                        <span class="ml-auto badge-pulse bg-red-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-full ring-2 ring-red-100 animate-pulse">
                            {{ $jobNotifCount }}
                        </span>
                        @endif
                    </a>

                    <a href="{{ route('seeker.courses.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.courses.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.courses.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.courses_learning') }}</span>
                        <div class="menu-tooltip">{{ __('messages.courses_learning') }}</div>
                    </a>

                    <a href="{{ route('seeker.tpa.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.tpa.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.tpa.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Tes TPA</span>
                        <div class="menu-tooltip">Tes TPA</div>
                        @php
                            $tpaNotifCount = Auth::user()->unreadNotifications()
                                ->whereIn('data->type', ['tpa_invitation', 'tpa_offline_invitation'])
                                ->count();
                        @endphp
                        @if ($tpaNotifCount > 0)
                        <span class="ml-auto badge-pulse bg-purple-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-full ring-2 ring-purple-100 animate-pulse">
                            {{ $tpaNotifCount }}
                        </span>
                        @endif
                    </a>

                    <a href="{{ route('seeker.career-fields.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.career-fields.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.career-fields.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Bidang Karir</span>
                        <div class="menu-tooltip">Bidang Karir</div>
                    </a>

                    <a href="{{ route('seeker.chats.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('seeker.chats.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('seeker.chats.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.direct_chats') }}</span>
                        <div class="menu-tooltip">{{ __('messages.direct_chats') }}</div>
                        @php
                            $unreadCountSeeker = Auth::user()->totalUnreadMessages();
                        @endphp
                        @if ($unreadCountSeeker > 0)
                        <span class="ml-auto badge-pulse bg-red-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-full ring-2 ring-red-100 animate-pulse">
                            {{ $unreadCountSeeker }}
                        </span>
                        @endif
                    </a>
                    @elseif(Auth::user()->isIndustryOrStaff())
                    <!-- Menu Industry/HRD -->
                    <div class="pt-2 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Ringkasan</div>
                    <a href="{{ route('industry.dashboard') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Rekrutmen</div>
                    @can('post_jobs')
                    <a href="{{ route('industry.jobs.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.jobs.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.jobs.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.post_job') }}</span>
                        <div class="menu-tooltip">{{ __('messages.post_job') }}</div>
                    </a>
                    @endcan

                    @can('view_candidates')
                    <a href="{{ route('industry.candidates') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.candidates*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.candidates*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.search_candidates') }}</span>
                        <div class="menu-tooltip">{{ __('messages.search_candidates') }}</div>
                    </a>
                    @endcan

                    @can('view_candidates')
                    <a href="{{ route('industry.tpa.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.tpa.index') || request()->routeIs('industry.tpa.create') || request()->routeIs('industry.tpa.edit') || request()->routeIs('industry.tpa.results*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.tpa.index') || request()->routeIs('industry.tpa.create') || request()->routeIs('industry.tpa.edit') || request()->routeIs('industry.tpa.results*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kelola Tes TPA</span>
                        <div class="menu-tooltip">Kelola Tes TPA</div>
                    </a>

                    <a href="{{ route('industry.tpa.questions') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.tpa.questions*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.tpa.questions*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Bank Soal TPA</span>
                        <div class="menu-tooltip">Bank Soal TPA</div>
                    </a>

                    <a href="{{ route('industry.competencies.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.competencies*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.competencies*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kelola Kompetensi</span>
                        <div class="menu-tooltip">Kelola Kompetensi</div>
                    </a>
                    @endcan

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Manajemen Internal</div>
                    @if(Auth::user()->isIndustry() || Auth::user()->role === 'staf_hr_manager')
                    <a href="{{ route('industry.team') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.team*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.team*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.manage_team') }}</span>
                        <div class="menu-tooltip">{{ __('messages.manage_team') }}</div>
                    </a>
                    @endif

                    <a href="{{ route('industry.chats.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('industry.chats.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('industry.chats.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.direct_chats') }}</span>
                        <div class="menu-tooltip">{{ __('messages.direct_chats') }}</div>
                        @php
                            $unreadCountIndustry = Auth::user()->totalUnreadMessages();
                        @endphp
                        @if ($unreadCountIndustry > 0)
                        <span class="ml-auto badge-pulse bg-red-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-full ring-2 ring-red-100 animate-pulse">
                            {{ $unreadCountIndustry }}
                        </span>
                        @endif
                    </a>
                    @elseif(Auth::user()->role === 'teacher')
                    <!-- Menu Teacher -->
                    <div class="pt-2 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Ringkasan</div>
                    <a href="{{ route('teacher.dashboard') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('teacher.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('teacher.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Dashboard</span>
                        <div class="menu-tooltip">Dashboard</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Pembelajaran</div>
                    <a href="{{ route('teacher.courses.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('teacher.courses.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('teacher.courses.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kelola Kursus</span>
                        <div class="menu-tooltip">Kelola Kursus</div>
                    </a>

                    <a href="{{ route('teacher.classes.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('teacher.classes.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('teacher.classes.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kelola Kelas</span>
                        <div class="menu-tooltip">Kelola Kelas</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Penilaian</div>
                    <a href="{{ route('teacher.submissions.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('teacher.submissions.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('teacher.submissions.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Nilai Tugas</span>
                        <div class="menu-tooltip">Nilai Tugas</div>
                    </a>

                    @elseif(Auth::user()->role === 'education')
                    <!-- Menu Education -->
                    <div class="pt-2 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Ringkasan</div>
                    <a href="{{ route('education.dashboard') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('education.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <a href="{{ route('education.analytics') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('education.analytics*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.analytics*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.graduate_analytics') }}</span>
                        <div class="menu-tooltip">{{ __('messages.graduate_analytics') }}</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Manajemen Data</div>
                    <a href="{{ route('education.students') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('education.students*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.students*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Data Siswa/Lulusan</span>
                        <div class="menu-tooltip">Data Siswa/Lulusan</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Pembelajaran</div>
                    <a href="{{ route('education.courses.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('education.courses*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.courses*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kelola Kursus</span>
                        <div class="menu-tooltip">Kelola Kursus</div>
                    </a>
                        <a href="{{ route('education.programs') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('education.programs*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.programs*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Program</span>
                        <div class="menu-tooltip">Program</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Kemitraan</div>
                    <a href="{{ route('education.partners') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('education.partners*') || request()->routeIs('education.collaboration*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('education.partners*') || request()->routeIs('education.collaboration*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Mitra Industri</span>
                        <div class="menu-tooltip">Mitra Industri</div>
                    </a>

                    @elseif(Auth::user()->role === 'admin')
                    <!-- Menu Admin -->
                    <div class="pt-2 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Ringkasan</div>

                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.dashboard*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.dashboard*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.dashboard') }}</span>
                        <div class="menu-tooltip">{{ __('messages.dashboard') }}</div>
                    </a>

                    <a href="{{ route('admin.reports') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.reports*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.reports*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Laporan</span>
                        <div class="menu-tooltip">Laporan</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Manajemen Utama</div>

                    <a href="{{ route('admin.users') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.users*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kelola Pengguna</span>
                        <div class="menu-tooltip">Kelola Pengguna</div>
                    </a>

                    <a href="{{ route('admin.competencies') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.competencies*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.competencies*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kompetensi</span>
                        <div class="menu-tooltip">Kompetensi</div>
                    </a>

                    <a href="{{ route('admin.settings') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.settings') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.settings') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Pengaturan</span>
                        <div class="menu-tooltip">Pengaturan</div>
                    </a>

                    <a href="{{ route('admin.tpa.dashboard') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.tpa.*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.tpa.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Tes TPA</span>
                        <div class="menu-tooltip">Tes TPA</div>
                    </a>

                    <a href="{{ route('admin.courses.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.courses*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.courses*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.course_management') }}</span>
                        <div class="menu-tooltip">{{ __('messages.course_management') }}</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Master Data</div>

                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.categories*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.categories*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Kategori</span>
                        <div class="menu-tooltip">Kategori</div>
                    </a>

                    <a href="{{ route('admin.positions.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.positions*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.positions*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.positions') }}</span>
                        <div class="menu-tooltip">{{ __('messages.positions') }}</div>
                    </a>

                    <div class="pt-3 sm:pt-4 pb-1.5 sm:pb-2 px-3 sm:px-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest sidebar-text transition-[opacity,margin] duration-300">Sistem AI</div>

                    <a href="{{ route('admin.ai-workflow') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.ai-workflow*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.ai-workflow*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.ai_workflow') }}</span>
                        <div class="menu-tooltip">{{ __('messages.ai_workflow') }}</div>
                    </a>

                    <a href="{{ route('admin.document-weights.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.document-weights*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.document-weights*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.ai_document_weights') }}</span>
                        <div class="menu-tooltip">{{ __('messages.ai_document_weights') }}</div>
                    </a>

                    <a href="{{ route('admin.skill-keywords.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.skill-keywords*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.skill-keywords*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">{{ __('messages.ai_dictionary') }}</span>
                        <div class="menu-tooltip">{{ __('messages.ai_dictionary') }}</div>
                    </a>

                    <a href="{{ route('admin.chat-faqs.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.chat-faqs*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.chat-faqs*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Chat FAQ</span>
                        <div class="menu-tooltip">Chat FAQ</div>
                    </a>

                    <a href="{{ route('admin.career-fields.index') }}"
                        class="group flex items-center menu-link px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl  {{ request()->routeIs('admin.career-fields*') ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 transition-transform duration-300 group-hover:scale-110 sidebar-icon {{ request()->routeIs('admin.career-fields*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4"></path>
                        </svg>
                        <span class="sidebar-text transition-[opacity,margin] duration-300">Bidang Karir</span>
                        <div class="menu-tooltip">Bidang Karir</div>
                    </a>
                    @endif

                </nav>

                <!-- Kata Mutiara Card -->
                @php $quote = \App\Models\Quote::getRandom(); @endphp
                @if($quote)
                <div class="px-3 sm:px-4 pb-3 sm:pb-4 pt-2 mt-auto sidebar-text transition-[opacity,margin] duration-300">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 border border-indigo-100 dark:border-indigo-800/30">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-400 dark:text-indigo-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10H0z"/>
                            </svg>
                            <div class="min-w-0">
                                <p class="text-[11px] leading-relaxed text-slate-600 dark:text-slate-300 italic line-clamp-3">"{{ $quote->content }}"</p>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1.5 font-medium">
                                    @if($quote->author){{ $quote->author }}@endif
                                    @if($quote->author && $quote->category) <span class="mx-1">|</span> @endif
                                    @if($quote->category){{ ucfirst(str_replace('_', ' ', $quote->category)) }}@endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </aside>

        <!-- Overlay Mobile -->
        <div x-show="sidebarOpen && mobileLayout === 'sidebar'" @click="sidebarToggle()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden sidebar-overlay"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <!-- Top Navbar -->
            <header class="flex items-center justify-between h-14 sm:h-16 px-3 sm:px-6 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700/60 sticky top-0 z-30 shadow-md shadow-slate-200/50 dark:shadow-slate-900/50 transition-[opacity,margin] duration-300 mb-4 sm:mb-6 lg:mb-8">

                <!-- Left Side: Burger & Mobile Logo -->
                <div class="flex items-center gap-2">
                    <!-- Animated Burger Button -->
                    <button @click="sidebarToggle()" x-show="mobileLayout === 'sidebar'" class="sidebar-toggle-btn text-slate-500 focus:outline-none hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 active:scale-95 relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center lg:hidden" aria-label="Toggle Sidebar">
                        <div class="w-5 h-4 sm:w-6 sm:h-5 flex flex-col justify-between relative">
                            <span :class="sidebarOpen ? 'rotate-45 translate-y-[7px] sm:translate-y-[9px]' : ''" class="w-full h-[2px] bg-slate-600 dark:bg-slate-400 rounded-full transition-[opacity,margin] duration-300 transform origin-center"></span>
                            <span :class="sidebarOpen ? 'opacity-0 translate-x-2' : ''" class="w-full h-[2px] bg-slate-600 dark:bg-slate-400 rounded-full transition-[opacity,margin] duration-300 transform"></span>
                            <span :class="sidebarOpen ? '-rotate-45 -translate-y-[7px] sm:-translate-y-[9px]' : ''" class="w-full h-[2px] bg-slate-600 dark:bg-slate-400 rounded-full transition-[opacity,margin] duration-300 transform origin-center"></span>
                        </div>
                    </button>

                    <!-- Sidebar Toggle for Desktop -->
                    <button @click="sidebarToggle()" class="sidebar-toggle-btn hidden lg:flex text-slate-500 focus:outline-none hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 active:scale-95 relative w-10 h-10 items-center justify-center" aria-label="Toggle Sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>

                    <!-- Mobile Logo -->
                    <a href="{{ $dashboardRoute ?? route('dashboard') }}" class="lg:hidden flex items-center">
                        <img src="{{ asset('logo.JPG') }}" alt="Logo" class="h-7 w-auto sm:h-8 rounded-lg shadow-sm dark:bg-white dark:p-1">
                        <span class="ml-1.5 sm:ml-2 font-bold text-slate-800 dark:text-slate-100 tracking-wide text-xs sm:text-sm">KOMPASKARIR</span>
                    </a>
                </div>

                <!-- Right Menu Header -->
                <div class="flex items-center gap-1 sm:gap-3">
                    <!-- Tour Button (hidden on mobile) -->
                    @if(request()->routeIs('*dashboard*'))
                    <button id="start-tour-btn" type="button" class="hidden sm:flex animate-pulse items-center space-x-1 text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 focus:outline-none transition-colors duration-200 p-1.5 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/30 text-sm font-medium" title="Mulai Tour Panduan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="hidden md:inline">Tour App</span>
                    </button>
                    @endif

                    <!-- Language Switcher (hidden on small mobile) -->
                    <div class="relative hidden sm:block" x-data="{ openLang: false }">
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
                            class="absolute right-0 mt-3 w-36 bg-white dark:bg-slate-800 rounded-2xl shadow-xl py-2 z-20 border border-slate-100 dark:border-slate-700/60">
                            <a href="{{ route('lang.switch', 'id') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ app()->getLocale() == 'id' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-slate-700/30' : '' }}">
                                <span class="mr-2">🇮🇩</span> Indonesia
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ app()->getLocale() == 'en' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-slate-700/30' : '' }}">
                                <span class="mr-2">🇬🇧</span> English
                            </a>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" type="button" class="text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none relative transition-colors duration-200 p-1.5 sm:p-2 rounded-full hover:bg-slate-50 dark:hover:bg-slate-800">
                        <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Notifikasi Dropdown -->
                    <div class="relative" x-data="{ open: false }" x-cloak>
                        <button @click="open = !open"
                            class="text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none relative transition-colors duration-200 p-1.5 sm:p-2 rounded-full hover:bg-slate-50 dark:hover:bg-slate-800">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            @if (Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-3.5 h-3.5 sm:w-4 sm:h-4 text-[8px] sm:text-[9px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900 animate-pulse">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                            @endif
                        </button>

                        <!-- Dropdown Card -->
                        <div x-show="open" @click.away="open = false" style="display: none;"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-3 w-72 sm:w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-xl py-2 z-20 border border-slate-100 dark:border-slate-700/60 dark:shadow-slate-950/40">
                            <div class="px-4 py-2.5 border-b border-slate-50 dark:border-slate-700/60 font-semibold text-xs text-slate-700 dark:text-slate-300 tracking-wider uppercase">{{ __('messages.notifications') }}</div>

                            <div class="max-h-60 overflow-y-auto">
                                @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notif)
                                @php
                                    $notifUrl = '#';
                                    if (isset($notif->data['action_url'])) {
                                        $notifUrl = $notif->data['action_url'];
                                    } elseif (isset($notif->data['url'])) {
                                        $notifUrl = $notif->data['url'];
                                    } elseif (isset($notif->data['type'])) {
                                        $notifUrl = match($notif->data['type']) {
                                            'tpa_invitation' => route('seeker.tpa.index'),
                                            'tpa_offline_invitation' => route('seeker.tpa.show', $notif->data['session_id'] ?? 0),
                                            default => route('notifications.index'),
                                        };
                                    }
                                @endphp
                                <div class="flex items-start gap-2 {{ $notif->read_at ? '' : 'bg-blue-50/50 dark:bg-blue-900/10' }} border-b border-slate-50 dark:border-slate-750/40 last:border-0">
                                    <a href="{{ $notifUrl }}" class="flex-1 block px-4 py-3 hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors duration-200"
                                       onclick="markNotifRead('{{ $notif->id }}')">
                                        <div class="flex items-start gap-2">
                                            @if(!$notif->read_at)
                                            <span class="w-2 h-2 mt-1.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                @if(isset($notif->data['title']))
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-0.5 truncate">{{ $notif->data['title'] }}</p>
                                                @endif
                                                <p class="text-xs font-medium text-slate-800 dark:text-slate-200 leading-relaxed line-clamp-2">
                                                    {{ $notif->data['message'] ?? 'Notifikasi baru' }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 flex items-center">
                                                    <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $notif->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    @if(!$notif->read_at)
                                    <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="pr-2 pt-2">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-slate-400 hover:text-slate-600 p-1" title="Tandai dibaca">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @empty
                                <div class="px-4 py-8 text-xs text-slate-400 dark:text-slate-500 text-center flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v2m16 4h-2a2 2 0 00-2 2v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3a2 2 0 00-2-2H2"></path>
                                    </svg>
                                    <span>{{ __('messages.no_new_notifications') }}</span>
                                </div>
                                @endforelse
                            </div>

                            <div class="px-4 py-3 bg-slate-50/50 dark:bg-slate-850/30 border-t border-slate-50 dark:border-slate-700/60 flex items-center justify-between rounded-b-2xl">
                                <a href="{{ route('notifications.index') }}" class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition">
                                    Lihat Semua
                                </a>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                                    @csrf @method('PUT')
                                    <button type="submit" class="text-[11px] font-semibold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition">
                                        Tandai semua
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- User Badge & Dropdown -->
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center space-x-2 sm:space-x-3 border-l border-slate-100 dark:border-slate-850 pl-3 sm:pl-6 h-8 select-none focus:outline-none group">
                            <span class="hidden sm:inline text-xs font-semibold text-slate-600 dark:text-slate-300 transition-colors duration-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 max-w-[80px] truncate">{{ Auth::user()->name }}</span>
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xs font-bold shadow-sm group-hover:shadow-md transition-[opacity,margin] duration-300 group-hover:scale-105 overflow-hidden">
                                @php $navPhoto2 = Auth::user()->documents->where('document_type', 'photo')->first(); @endphp
                                @if($navPhoto2)
                                    <x-webp-image :storagePath="$navPhoto2->file_path" alt="Photo" class="w-full h-full object-cover" loading="lazy" />
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <svg class="hidden sm:block w-4 h-4 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-transform duration-300" :class="openProfile ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-xl py-2 z-20 border border-slate-100 dark:border-slate-700/60 dark:shadow-slate-950/40">

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
                                <button type="button" @click="$dispatch('open-theme-modal'); openProfile = false" class="w-full group flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 text-left">
                                    <svg class="w-4 h-4 mr-3 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                    Tema & Layout
                                </button>
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
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-3 sm:p-4 md:p-6 relative" :class="mobileLayout === 'bottombar' ? 'pb-20 lg:pb-6' : ''">
                <!-- Success Floating Toast -->
                @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-[-20px]"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-[-20px]"
                    class="mb-4 sm:mb-6 bg-emerald-50/80 dark:bg-emerald-900/40 backdrop-blur border border-emerald-100 dark:border-emerald-800 p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-sm flex items-start space-x-2 sm:space-x-3">
                    <div class="p-1 rounded-lg bg-emerald-500 dark:bg-emerald-600 text-white shadow-sm flex-shrink-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-emerald-800 dark:text-emerald-300">{{ __('messages.success') }}</h4>
                        <p class="text-[11px] sm:text-xs text-emerald-700 dark:text-emerald-400 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors flex-shrink-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    class="mb-4 sm:mb-6 bg-rose-50/80 dark:bg-rose-900/40 backdrop-blur border border-rose-100 dark:border-rose-800 p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-sm flex items-start space-x-2 sm:space-x-3">
                    <div class="p-1 rounded-lg bg-rose-500 dark:bg-rose-600 text-white shadow-sm flex-shrink-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-rose-800 dark:text-rose-300">{{ __('messages.error') }}</h4>
                        <p class="text-[11px] sm:text-xs text-rose-700 dark:text-rose-400 mt-0.5 leading-relaxed">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-rose-400 hover:text-rose-600 dark:hover:text-rose-300 transition-colors flex-shrink-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @endif

                {{ $slot }}

                <!-- Global Footer -->
                <footer class="mt-auto pt-6 sm:pt-8 pb-4 sm:pb-6 text-center">
                    <div class="border-t border-slate-200 dark:border-slate-800/60 pt-4 sm:pt-6">
                       <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} KOMPASKARIR INDONESIA. Hak Cipta Dilindungi.</p>
                <div class="mt-2 flex justify-center space-x-4 text-sm">
                    <a href="{{ route('legal.privacy') }}" class="hover:text-white transition">Kebijakan Privasi</a>
                    <span>&middot;</span>
                    <a href="{{ route('legal.terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
                    <span>&middot;</span>
                    <a href="{{ route('legal.tia') }}" class="hover:text-white transition">TIA</a>
                </div>
                <p class="mt-2 text-sm">Dikembangkan oleh: Noor Syam  AR & Anggitya Ayu Pertiwi</p>
            </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- BOTTOM NAV BAR (Mobile Layout: bottombar)    --}}
    {{-- ============================================ --}}
    @if(Auth::user()->mobile_layout === 'bottombar')
    <div x-data="{ bottomSheetOpen: false }">
    <!-- Bottom Tab Bar -->
    <div class="bottom-nav-bar lg:hidden">
        <div class="flex items-stretch justify-around">
            {{-- HOME / DASHBOARD --}}
            @if(Auth::user()->role === 'job_seeker')
                <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] mt-0.5">Home</span>
                </a>
            @elseif(Auth::user()->isIndustryOrStaff())
                <a href="{{ route('industry.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('industry.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] mt-0.5">Home</span>
                </a>
            @elseif(Auth::user()->role === 'teacher')
                <a href="{{ route('teacher.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('teacher.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] mt-0.5">Home</span>
                </a>
            @elseif(Auth::user()->role === 'education')
                <a href="{{ route('education.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('education.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] mt-0.5">Home</span>
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] mt-0.5">Home</span>
                </a>
            @endif

            {{-- SECOND TAB: Role-specific --}}
            @if(Auth::user()->role === 'job_seeker')
                <a href="{{ route('seeker.jobs.index') }}" class="bottom-nav-item {{ request()->routeIs('seeker.jobs.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-[10px] mt-0.5">Lowongan</span>
                    @php $jobNotifCount = Auth::user()->unreadNotifications()->whereNotIn('data->type', ['tpa_invitation', 'tpa_offline_invitation'])->count(); @endphp
                    @if($jobNotifCount > 0)<span class="bottom-nav-badge">{{ $jobNotifCount }}</span>@endif
                </a>
            @elseif(Auth::user()->isIndustryOrStaff())
                @can('post_jobs')
                <a href="{{ route('industry.jobs.index') }}" class="bottom-nav-item {{ request()->routeIs('industry.jobs.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-[10px] mt-0.5">Lowongan</span>
                </a>
                @endcan
            @elseif(Auth::user()->role === 'teacher')
                <a href="{{ route('teacher.courses.index') }}" class="bottom-nav-item {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="text-[10px] mt-0.5">Kursus</span>
                </a>
                <a href="{{ route('teacher.classes.index') }}" class="bottom-nav-item {{ request()->routeIs('teacher.classes.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    <span class="text-[10px] mt-0.5">Kelas</span>
                </a>
            @elseif(Auth::user()->role === 'education')
                <a href="{{ route('education.students') }}" class="bottom-nav-item {{ request()->routeIs('education.students*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="text-[10px] mt-0.5">Siswa</span>
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.users') }}" class="bottom-nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="text-[10px] mt-0.5">Pengguna</span>
                </a>
            @endif

            {{-- THIRD TAB: Role-specific --}}
            @if(Auth::user()->role === 'job_seeker')
                <a href="{{ route('seeker.chats.index') }}" class="bottom-nav-item {{ request()->routeIs('seeker.chats.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span class="text-[10px] mt-0.5">Chat</span>
                    @php $unreadCount = Auth::user()->totalUnreadMessages(); @endphp
                    @if($unreadCount > 0)<span class="bottom-nav-badge">{{ $unreadCount }}</span>@endif
                </a>
            @elseif(Auth::user()->isIndustryOrStaff())
                <a href="{{ route('industry.chats.index') }}" class="bottom-nav-item {{ request()->routeIs('industry.chats.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span class="text-[10px] mt-0.5">Chat</span>
                    @php $unreadCount = Auth::user()->totalUnreadMessages(); @endphp
                    @if($unreadCount > 0)<span class="bottom-nav-badge">{{ $unreadCount }}</span>@endif
                </a>
            @elseif(Auth::user()->role === 'teacher')
                <a href="{{ route('teacher.submissions.index') }}" class="bottom-nav-item {{ request()->routeIs('teacher.submissions.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span class="text-[10px] mt-0.5">Nilai</span>
                </a>
            @elseif(Auth::user()->role === 'education')
                <a href="{{ route('education.courses.index') }}" class="bottom-nav-item {{ request()->routeIs('education.courses*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="text-[10px] mt-0.5">Kursus</span>
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.reports') }}" class="bottom-nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-[10px] mt-0.5">Laporan</span>
                </a>
            @endif

            {{-- LAINNYA --}}
            <button @click="bottomSheetOpen = true" class="bottom-nav-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <span class="text-[10px] mt-0.5">Lainnya</span>
            </button>
        </div>
    </div>

    <!-- Bottom Sheet Overlay -->
    <div x-show="bottomSheetOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="bottomSheetOpen = false" class="bottom-sheet-overlay lg:hidden" style="display: none;" x-cloak></div>

    <!-- Bottom Sheet Panel -->
    <div x-show="bottomSheetOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="bottom-sheet-panel lg:hidden" style="display: none;" x-cloak>
        <div class="bottom-sheet-handle"></div>
        <div class="px-5 py-3 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md text-sm overflow-hidden">
                    @php $navPhoto3 = Auth::user()->documents->where('document_type', 'photo')->first(); @endphp
                    @if($navPhoto3)
                        <x-webp-image :storagePath="$navPhoto3->file_path" alt="Photo" class="w-full h-full object-cover" loading="lazy" />
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <button @click="bottomSheetOpen = false" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="bottom-sheet-scroll">
            {{-- Full menu list per role --}}
            @if(Auth::user()->role === 'job_seeker')
                <div class="bottom-sheet-category">Ringkasan</div>
                <a href="{{ route('dashboard') }}" class="bottom-sheet-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('messages.dashboard') }}
                </a>

                <div class="bottom-sheet-category">Eksplorasi Karir</div>
                <a href="{{ route('seeker.assessment.start') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.assessment.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    {{ __('messages.competency_assessment') }}
                </a>
                <a href="{{ route('seeker.roadmap.index') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.roadmap.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4"/></svg>
                    {{ __('messages.career_roadmap') }}
                </a>

                <div class="bottom-sheet-category">Peluang & Pengembangan</div>
                <a href="{{ route('seeker.jobs.index') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.jobs.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ __('messages.job_vacancies') }}
                </a>
                <a href="{{ route('seeker.courses.index') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.courses.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    {{ __('messages.courses_learning') }}
                </a>
                <a href="{{ route('seeker.tpa.index') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.tpa.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Tes TPA
                </a>
                <a href="{{ route('seeker.career-fields.index') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.career-fields.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4"/></svg>
                    Bidang Karir
                </a>
                <a href="{{ route('seeker.chats.index') }}" class="bottom-sheet-item {{ request()->routeIs('seeker.chats.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    {{ __('messages.direct_chats') }}
                </a>

            @elseif(Auth::user()->isIndustryOrStaff())
                <div class="bottom-sheet-category">Ringkasan</div>
                <a href="{{ route('industry.dashboard') }}" class="bottom-sheet-item {{ request()->routeIs('industry.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('messages.dashboard') }}
                </a>

                <div class="bottom-sheet-category">Rekrutmen</div>
                @can('post_jobs')
                <a href="{{ route('industry.jobs.index') }}" class="bottom-sheet-item {{ request()->routeIs('industry.jobs.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('messages.post_job') }}
                </a>
                @endcan
                @can('view_candidates')
                <a href="{{ route('industry.candidates') }}" class="bottom-sheet-item {{ request()->routeIs('industry.candidates*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    {{ __('messages.search_candidates') }}
                </a>
                @endcan
                @can('view_candidates')
                <a href="{{ route('industry.tpa.index') }}" class="bottom-sheet-item {{ request()->routeIs('industry.tpa.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Kelola Tes TPA
                </a>
                <a href="{{ route('industry.tpa.questions') }}" class="bottom-sheet-item {{ request()->routeIs('industry.tpa.questions*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Bank Soal TPA
                </a>
                <a href="{{ route('industry.competencies.index') }}" class="bottom-sheet-item {{ request()->routeIs('industry.competencies*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Kelola Kompetensi
                </a>
                @endcan

                <div class="bottom-sheet-category">Manajemen Internal</div>
                @if(Auth::user()->isIndustry() || Auth::user()->role === 'staf_hr_manager')
                <a href="{{ route('industry.team') }}" class="bottom-sheet-item {{ request()->routeIs('industry.team*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    {{ __('messages.manage_team') }}
                </a>
                @endif
                <a href="{{ route('industry.chats.index') }}" class="bottom-sheet-item {{ request()->routeIs('industry.chats.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    {{ __('messages.direct_chats') }}
                </a>

            @elseif(Auth::user()->role === 'teacher')
                <div class="bottom-sheet-category">Ringkasan</div>
                <a href="{{ route('teacher.dashboard') }}" class="bottom-sheet-item {{ request()->routeIs('teacher.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <div class="bottom-sheet-category">Pembelajaran</div>
                <a href="{{ route('teacher.courses.index') }}" class="bottom-sheet-item {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Kelola Kursus
                </a>
                <a href="{{ route('teacher.classes.index') }}" class="bottom-sheet-item {{ request()->routeIs('teacher.classes.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Kelola Kelas
                </a>

                <div class="bottom-sheet-category">Penilaian</div>
                <a href="{{ route('teacher.submissions.index') }}" class="bottom-sheet-item {{ request()->routeIs('teacher.submissions.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Nilai Tugas
                </a>

            @elseif(Auth::user()->role === 'education')
                <div class="bottom-sheet-category">Ringkasan</div>
                <a href="{{ route('education.dashboard') }}" class="bottom-sheet-item {{ request()->routeIs('education.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('messages.dashboard') }}
                </a>
                <a href="{{ route('education.analytics') }}" class="bottom-sheet-item {{ request()->routeIs('education.analytics*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    {{ __('messages.graduate_analytics') }}
                </a>

                <div class="bottom-sheet-category">Manajemen Data</div>
                <a href="{{ route('education.students') }}" class="bottom-sheet-item {{ request()->routeIs('education.students*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Data Siswa/Lulusan
                </a>

                <div class="bottom-sheet-category">Pembelajaran</div>
                <a href="{{ route('education.courses.index') }}" class="bottom-sheet-item {{ request()->routeIs('education.courses*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Kelola Kursus
                </a>
                <a href="{{ route('education.programs') }}" class="bottom-sheet-item {{ request()->routeIs('education.programs*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Program
                </a>

                <div class="bottom-sheet-category">Kemitraan</div>
                <a href="{{ route('education.partners') }}" class="bottom-sheet-item {{ request()->routeIs('education.partners*') || request()->routeIs('education.collaboration*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Mitra Industri
                </a>

            @elseif(Auth::user()->role === 'admin')
                <div class="bottom-sheet-category">Ringkasan</div>
                <a href="{{ route('admin.dashboard') }}" class="bottom-sheet-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('messages.dashboard') }}
                </a>
                <a href="{{ route('admin.reports') }}" class="bottom-sheet-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan
                </a>

                <div class="bottom-sheet-category">Manajemen Utama</div>
                <a href="{{ route('admin.users') }}" class="bottom-sheet-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Kelola Pengguna
                </a>
                <a href="{{ route('admin.competencies') }}" class="bottom-sheet-item {{ request()->routeIs('admin.competencies*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Kompetensi
                </a>
                <a href="{{ route('admin.settings') }}" class="bottom-sheet-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan
                </a>
                <a href="{{ route('admin.tpa.dashboard') }}" class="bottom-sheet-item {{ request()->routeIs('admin.tpa.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Tes TPA
                </a>
                <a href="{{ route('admin.courses.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    {{ __('messages.course_management') }}
                </a>

                <div class="bottom-sheet-category">Master Data</div>
                <a href="{{ route('admin.categories.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>
                <a href="{{ route('admin.positions.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.positions*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ __('messages.positions') }}
                </a>

                <div class="bottom-sheet-category">Sistem AI</div>
                <a href="{{ route('admin.ai-workflow') }}" class="bottom-sheet-item {{ request()->routeIs('admin.ai-workflow*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    {{ __('messages.ai_workflow') }}
                </a>
                <a href="{{ route('admin.document-weights.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.document-weights*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    {{ __('messages.ai_document_weights') }}
                </a>
                <a href="{{ route('admin.skill-keywords.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.skill-keywords*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    {{ __('messages.ai_dictionary') }}
                </a>
                <a href="{{ route('admin.chat-faqs.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.chat-faqs*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Chat FAQ
                </a>
                <a href="{{ route('admin.career-fields.index') }}" class="bottom-sheet-item {{ request()->routeIs('admin.career-fields*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.984A1 1 0 0119.5 7H15m0 0V3m0 4h4"/></svg>
                    Bidang Karir
                </a>
            @endif

            <div class="bottom-sheet-divider"></div>

            {{-- Common actions --}}
            <a href="{{ route('profile.edit') }}" class="bottom-sheet-item">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ __('messages.edit_profile') }}
            </a>
            <a href="{{ route('notifications.index') }}" class="bottom-sheet-item">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                {{ __('messages.notifications') }}
            </a>

            <div class="bottom-sheet-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bottom-sheet-item w-full text-left text-rose-600 dark:text-rose-400">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    {{ __('messages.logout') }}
                </button>
            </form>
        </div>
    </div>
    </div>
    @endif

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage)) {
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

        // Mark notification as read via AJAX
        function markNotifRead(notifId) {
            fetch(`/notifications/${notifId}/read`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            }).then(() => {
                // Update badge count
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    const count = parseInt(badge.textContent) - 1;
                    if (count <= 0) {
                        badge.remove();
                    } else {
                        badge.textContent = count;
                    }
                }
            }).catch(() => {});
        }
    </script>

    {{-- Chat Widget --}}
    @if(Auth::check())
    <x-chat-widget />
    @endif

    <!-- Theme & Layout Modal -->
    <div x-data="{ open: false }" @open-theme-modal.window="open = true" x-show="open" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="open = false" class="w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden" x-data="{ 
                theme: localStorage.getItem('color-theme') || 'light',
                sidebarPosition: '{{ Auth::user()->sidebar_position ?? 'left' }}',
                mobileLayout: '{{ Auth::user()->mobile_layout ?? 'sidebar' }}',
                saving: false,
                setTheme(newTheme) {
                    this.theme = newTheme;
                    if (newTheme === 'dark') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else if (newTheme === 'light') {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        localStorage.removeItem('color-theme');
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                },
                saveLayout(field, value) {
                    this.saving = true;
                    const body = {};
                    body[field] = value;
                    fetch('{{ route('profile.mobile-layout.update') }}', { 
                        method: 'PATCH', 
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                            'Accept': 'application/json' 
                        }, 
                        body: JSON.stringify(body) 
                    }).then(r => r.json()).then(data => { 
                        this.saving = false; 
                        if (data.success) { 
                            setTimeout(() => location.reload(), 500); 
                        } 
                    }).catch(() => { this.saving = false; });
                }
            }">
                <!-- Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-violet-50 to-indigo-50 dark:from-slate-800/80 dark:to-slate-800/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white dark:bg-slate-700 rounded-xl shadow-sm">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Tema & Layout</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kustomisasi tampilan sesuai preferensi Anda</p>
                        </div>
                    </div>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1 rounded-lg hover:bg-white/50 dark:hover:bg-slate-700/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Section 1: Tema -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Tema Warna</h4>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <!-- Light Theme -->
                            <button @click="setTheme('light')" :class="theme === 'light' ? 'border-amber-500 bg-amber-50/50 dark:bg-amber-950/20 dark:border-amber-400 ring-2 ring-amber-200 dark:ring-amber-800' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'" class="relative p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 text-center">
                                <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Terang</span>
                                <div x-show="theme === 'light'" class="absolute top-2 right-2 w-4 h-4 bg-amber-500 rounded-full flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                            </button>

                            <!-- Dark Theme -->
                            <button @click="setTheme('dark')" :class="theme === 'dark' ? 'border-indigo-500 bg-indigo-50/50 dark:bg-indigo-950/20 dark:border-indigo-400 ring-2 ring-indigo-200 dark:ring-indigo-800' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'" class="relative p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 text-center">
                                <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gelap</span>
                                <div x-show="theme === 'dark'" class="absolute top-2 right-2 w-4 h-4 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                            </button>

                            <!-- Auto Theme -->
                            <button @click="setTheme('auto')" :class="theme === 'auto' ? 'border-emerald-500 bg-emerald-50/50 dark:bg-emerald-950/20 dark:border-emerald-400 ring-2 ring-emerald-200 dark:ring-emerald-800' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'" class="relative p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 text-center">
                                <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Otomatis</span>
                                <div x-show="theme === 'auto'" class="absolute top-2 right-2 w-4 h-4 bg-emerald-500 rounded-full flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-3 text-center">Mode otomatis mengikuti pengaturan sistem perangkat Anda</p>
                    </div>

                    <hr class="border-slate-100 dark:border-slate-800">

                    <!-- Section 2: Desktop Layout -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Tata Letak Desktop</h4>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">Pengaturan sidebar untuk layar besar</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!-- Sidebar Left (Default) -->
                            <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200" :class="sidebarPosition === 'left' ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-950/20 dark:border-blue-400' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'">
                                <input type="radio" name="sidebar_position" value="left" x-model="sidebarPosition" class="mt-1 text-blue-600 focus:ring-blue-500" @change="saveLayout('sidebar_position', 'left')">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sidebar Kiri</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-medium">Default</span>
                                    </div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Menu navigasi di sisi kiri layar (standar)</p>
                                </div>
                            </label>

                            <!-- Sidebar Right (Left-handed) -->
                            <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200" :class="sidebarPosition === 'right' ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-950/20 dark:border-blue-400' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'">
                                <input type="radio" name="sidebar_position" value="right" x-model="sidebarPosition" class="mt-1 text-blue-600 focus:ring-blue-500" @change="saveLayout('sidebar_position', 'right')">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sidebar Kanan</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 font-medium">Kidal</span>
                                    </div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Menu navigasi di sisi kanan, cocok untuk kidal</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <hr class="border-slate-100 dark:border-slate-800">

                    <!-- Section 3: Mobile Layout -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 bg-violet-100 dark:bg-violet-900/30 rounded-lg">
                                <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Tata Letak Mobile</h4>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">Pilih tampilan navigasi di perangkat HP</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!-- Sidebar Option -->
                            <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200" :class="mobileLayout === 'sidebar' ? 'border-violet-500 bg-violet-50/50 dark:bg-violet-950/20 dark:border-violet-400' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'">
                                <input type="radio" name="mobile_layout_modal" value="sidebar" x-model="mobileLayout" class="mt-1 text-violet-600 focus:ring-violet-500" @change="saveLayout('mobile_layout', 'sidebar')">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sidebar</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-medium">Default</span>
                                    </div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Menu navigasi di sisi kiri, geser untuk buka/tutup</p>
                                </div>
                            </label>

                            <!-- Bottom Bar Option -->
                            <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200" :class="mobileLayout === 'bottombar' ? 'border-violet-500 bg-violet-50/50 dark:bg-violet-950/20 dark:border-violet-400' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'">
                                <input type="radio" name="mobile_layout_modal" value="bottombar" x-model="mobileLayout" class="mt-1 text-violet-600 focus:ring-violet-500" @change="saveLayout('mobile_layout', 'bottombar')">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Bottom Tab Bar</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 font-medium">Baru</span>
                                    </div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Navigasi di bawah layar seperti aplikasi mobile</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Saving Indicator -->
                    <div x-show="saving" x-transition class="flex items-center justify-center gap-2 text-xs font-medium text-violet-600 dark:text-violet-400 py-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan preferensi...
                    </div>

                    <!-- Info Footer -->
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3 flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">Perubahan akan disimpan secara otomatis. Halaman akan dimuat ulang untuk menerapkan perubahan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading Script --}}
    <x-loading-script />

    {{-- Cookie Consent Banner (UU PDP Compliance) --}}
    @if(!isset($_COOKIE['cookie_consent']))
    <div id="cookie-consent-banner" class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 shadow-lg p-4 md:p-6" style="display: none;">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">Penggunaan Cookie</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Kami menggunakan cookie untuk menjaga sesi login, menyimpan preferensi, dan meningkatkan pengalaman Anda. Dengan melanjutkan penggunaan situs ini, Anda menyetujui penggunaan cookie sesuai 
                            <a href="{{ route('legal.privacy') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Kebijakan Privasi</a> kami.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <button onclick="rejectCookies()" class="px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                    Tolak
                </button>
                <button onclick="acceptCookies()" class="px-5 py-2 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Terima Cookie
                </button>
            </div>
        </div>
    </div>

    <script>
        // Show cookie banner after page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('cookie-consent-banner').style.display = 'block';
            }, 1000);
        });

        function acceptCookies() {
            setCookie('cookie_consent', 'accepted', 365);
            // Log consent
            fetch('/profile/consent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    consent_type: 'cookies',
                    granted: true
                })
            });
            document.getElementById('cookie-consent-banner').style.display = 'none';
        }

        function rejectCookies() {
            setCookie('cookie_consent', 'rejected', 30);
            document.getElementById('cookie-consent-banner').style.display = 'none';
        }

        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/;SameSite=Lax';
        }
    </script>
    @endif
</body>

</html>
