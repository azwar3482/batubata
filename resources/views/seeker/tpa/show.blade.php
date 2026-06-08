<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:text-blue-400 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('seeker.tpa.index') }}" class="hover:text-blue-600 dark:text-blue-400 transition-colors">Tes TPA</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 dark:text-white font-medium">Detail Tes</span>
    </nav>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700/50 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    @if(!empty($jobStatusMessage))
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700/50 text-yellow-800 dark:text-yellow-200 px-4 py-3 rounded-xl mb-4 flex items-start gap-2">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div>
            <p class="font-semibold text-sm">Informasi Lowongan</p>
            <p class="text-sm mt-1">{{ $jobStatusMessage }}</p>
        </div>
    </div>
    @endif

    {{-- HEADER CARD --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-6">
        <div class="p-6 {{ $session->tpa_type === 'offline' ? 'bg-gradient-to-r from-amber-500 to-orange-500' : 'bg-gradient-to-r from-blue-500 to-indigo-600' }} text-white">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white dark:bg-slate-800/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        @if($session->tpa_type === 'offline')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 bg-white dark:bg-slate-800/20 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wider">
                                {{ $session->tpa_type === 'offline' ? 'Offline' : 'Online' }}
                            </span>
                            @if($session->status === 'invited')
                            <span class="px-2.5 py-0.5 bg-white dark:bg-slate-800/20 backdrop-blur-sm rounded-full text-xs font-bold animate-pulse">Menunggu Respon</span>
                            @endif
                        </div>
                        <h1 class="text-2xl font-bold">{{ $session->tpaTest->title }}</h1>
                        <p class="opacity-90 mt-1 text-sm">
                            {{ $session->jobApplication->jobListing->title ?? 'Tes Umum' }}
                            @if($session->jobApplication->jobListing->company_name)
                            &middot; {{ $session->jobApplication->jobListing->company_name }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATUS BAR --}}
        <div class="px-6 py-4 bg-gray-50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-700">
            <div class="flex items-center justify-between flex-wrap gap-3">
                {{-- Status Badge --}}
                <div class="flex items-center gap-2">
                    @if($session->tpa_type === 'offline')
                        @if($session->seeker_response === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 rounded-full text-sm font-semibold border border-amber-200 dark:border-amber-700/50">
                            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Menunggu Respon Anda
                        </span>
                        @elseif($session->seeker_response === 'accepted')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full text-sm font-semibold border border-green-200 dark:border-green-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Diterima
                        </span>
                        @elseif($session->seeker_response === 'reschedule_proposed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300 rounded-full text-sm font-semibold border border-yellow-200 dark:border-yellow-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Mengusulkan Jadwal Baru
                        </span>
                        @elseif($session->seeker_response === 'declined')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 rounded-full text-sm font-semibold border border-red-200 dark:border-red-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Ditolak
                        </span>
                        @endif
                    @else
                        @if($session->status === 'invited')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-full text-sm font-semibold border border-blue-200 dark:border-blue-700/50">
                            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Undangan Baru
                        </span>
                        @elseif($session->status === 'in_progress')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300 rounded-full text-sm font-semibold border border-yellow-200 dark:border-yellow-700/50">
                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Sedang Dikerjakan
                        </span>
                        @elseif($session->status === 'completed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full text-sm font-semibold border border-green-200 dark:border-green-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Selesai
                        </span>
                        @elseif($session->status === 'expired')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 rounded-full text-sm font-semibold border border-red-200 dark:border-red-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Kedaluwarsa
                        </span>
                        @endif
                    @endif
                </div>

                {{-- Quick Info --}}
                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                    @if($session->offline_scheduled_at)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $session->offline_scheduled_at->format('d M Y H:i') }}
                    </span>
                    @endif
                    @if($session->expires_at)
                    <span class="flex items-center gap-1.5 {{ $session->expires_at->isPast() ? 'text-red-500 dark:text-red-400' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $session->expires_at->isPast() ? 'Kedaluwarsa' : 'Batas: ' . $session->expires_at->format('d M H:i') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="space-y-6">

        {{-- SECTION: Detail Tes Offline --}}
        @if($session->tpa_type === 'offline')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-amber-50 dark:bg-amber-900/20">
                <h2 class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Informasi Tes Offline
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Jadwal --}}
                    @if($session->offline_scheduled_at)
                    <div class="flex items-start gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800">
                        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-amber-600 dark:text-amber-400 uppercase tracking-wider">Jadwal Tes</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $session->offline_scheduled_at->format('l, d F Y') }}</div>
                            <div class="text-gray-600 dark:text-gray-400 font-medium">{{ $session->offline_scheduled_at->format('H:i') }} WIB</div>
                        </div>
                    </div>
                    @endif

                    {{-- Lokasi --}}
                    @if($session->offline_location)
                    <div class="flex items-start gap-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider">Lokasi Tes</div>
                            <div class="text-gray-900 dark:text-white mt-1 font-medium">{{ $session->offline_location }}</div>
                        </div>
                    </div>
                    @endif

                    {{-- PIC --}}
                    @if($session->offline_contact_person || $session->offline_contact_phone)
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-slate-700">
                        <div class="w-10 h-10 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penanggung Jawab</div>
                            <div class="text-gray-900 dark:text-white mt-1 font-medium">{{ $session->offline_contact_person ?? '-' }}</div>
                            @if($session->offline_contact_phone)
                            <a href="tel:{{ $session->offline_contact_phone }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">{{ $session->offline_contact_phone }}</a>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Passing Score --}}
                    <div class="flex items-start gap-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-purple-600 dark:text-purple-400 uppercase tracking-wider">Passing Score</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $session->tpaTest->passing_score ?? 60 }}%</div>
                        </div>
                    </div>
                </div>

                {{-- Instruksi --}}
                @if($session->offline_instructions)
                <div class="mt-6 p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Instruksi Tes
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed whitespace-pre-line">{{ $session->offline_instructions }}</p>
                </div>
                @endif

                {{-- Catatan --}}
                @if($session->offline_notes)
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-100 dark:border-yellow-800">
                    <h3 class="font-semibold text-yellow-700 dark:text-yellow-300 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        Catatan Tambahan
                    </h3>
                    <p class="text-yellow-700 dark:text-yellow-300 text-sm">{{ $session->offline_notes }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- SECTION: Detail Tes Online --}}
        @if($session->tpa_type === 'online')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-blue-50 dark:bg-blue-900/20">
                <h2 class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Informasi Tes Online
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $session->tpaTest->total_questions }}</div>
                        <div class="text-xs text-blue-500 dark:text-blue-400 font-medium mt-1">Soal</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-100 dark:border-green-800">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $session->tpaTest->time_limit_minutes }}</div>
                        <div class="text-xs text-green-500 dark:text-green-400 font-medium mt-1">Menit</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $session->tpaTest->passing_score }}%</div>
                        <div class="text-xs text-purple-500 dark:text-purple-400 font-medium mt-1">Passing</div>
                    </div>
                    <div class="text-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800">
                        <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $session->tpaTest->verbal_count + $session->tpaTest->numerik_count + $session->tpaTest->logika_count + $session->tpaTest->spasial_count }}</div>
                        <div class="text-xs text-amber-500 dark:text-amber-400 font-medium mt-1">Total Soal</div>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-4 gap-2">
                    <div class="text-center p-2 bg-gray-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $session->tpaTest->verbal_count }}</div>
                        <div class="text-[10px] text-gray-500 dark:text-gray-400">Verbal</div>
                    </div>
                    <div class="text-center p-2 bg-gray-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $session->tpaTest->numerik_count }}</div>
                        <div class="text-[10px] text-gray-500 dark:text-gray-400">Numerik</div>
                    </div>
                    <div class="text-center p-2 bg-gray-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $session->tpaTest->logika_count }}</div>
                        <div class="text-[10px] text-gray-500 dark:text-gray-400">Logika</div>
                    </div>
                    <div class="text-center p-2 bg-gray-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $session->tpaTest->spasial_count }}</div>
                        <div class="text-[10px] text-gray-500 dark:text-gray-400">Spasial</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION: Respon Undangan Offline --}}
        @if($session->tpa_type === 'offline' && $session->seeker_response === 'pending')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h2 class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Respon Undangan
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pilih respon Anda terhadap undangan tes ini</p>
            </div>
            <div class="p-6">
                <form action="{{ route('seeker.tpa.respond-offline', $session) }}" method="POST" x-data="{ response: '' }">
                    @csrf
                    <div class="space-y-3 mb-6">
                        {{-- Terima --}}
                        <label class="relative cursor-pointer" @click="response = 'accepted'">
                            <input type="radio" name="response" value="accepted" x-model="response" class="peer sr-only">
                            <div class="p-4 border-2 rounded-xl transition-all peer-checked:border-green-500 dark:peer-checked:border-green-400 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/30 border-gray-200 dark:border-slate-600 hover:border-gray-300 dark:hover:border-slate-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-green-700 dark:text-green-300">Terima Undangan</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Saya akan hadir sesuai jadwal yang ditentukan</div>
                                    </div>
                                </div>
                            </div>
                        </label>

                        {{-- Reschedule --}}
                        <label class="relative cursor-pointer" @click="response = 'reschedule_proposed'">
                            <input type="radio" name="response" value="reschedule_proposed" x-model="response" class="peer sr-only">
                            <div class="p-4 border-2 rounded-xl transition-all peer-checked:border-yellow-500 dark:peer-checked:border-yellow-400 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/30 border-gray-200 dark:border-slate-600 hover:border-gray-300 dark:hover:border-slate-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-yellow-700 dark:text-yellow-300">Usulkan Jadwal Lain</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Saya tidak bisa hadir pada jadwal yang ditentukan</div>
                                    </div>
                                </div>
                            </div>
                        </label>

                        {{-- Tolak --}}
                        <label class="relative cursor-pointer" @click="response = 'declined'">
                            <input type="radio" name="response" value="declined" x-model="response" class="peer sr-only">
                            <div class="p-4 border-2 rounded-xl transition-all peer-checked:border-red-500 dark:peer-checked:border-red-400 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/30 border-gray-200 dark:border-slate-600 hover:border-gray-300 dark:hover:border-slate-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-red-700 dark:text-red-300">Tolak Undangan</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Saya tidak berminat dengan posisi ini</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    {{-- Form Reschedule --}}
                    <div x-show="response === 'reschedule_proposed'" x-transition class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700/50 rounded-xl p-5 mb-6">
                        <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-4">Usulkan Jadwal Baru</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal & Waktu yang Diusulkan <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="datetime-local" name="reschedule_date" class="w-full border-gray-300 dark:border-slate-500 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan <span class="text-red-500 dark:text-red-400">*</span></label>
                                <textarea name="reschedule_reason" rows="3" class="w-full border-gray-300 dark:border-slate-500 rounded-lg focus:ring-yellow-500 focus:border-yellow-500" placeholder="Jelaskan alasan Anda tidak bisa hadir pada jadwal yang ditentukan..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Form Tolak --}}
                    <div x-show="response === 'declined'" x-transition class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50 rounded-xl p-5 mb-6">
                        <p class="text-sm text-red-700 dark:text-red-300">Anda yakin ingin menolak undangan ini? Tindakan ini tidak dapat dibatalkan.</p>
                    </div>

                    <button type="submit" :disabled="!response"
                            class="w-full py-3 rounded-xl font-bold text-lg transition-all disabled:bg-gray-300 dark:disabled:bg-slate-700 disabled:cursor-not-allowed"
                            :class="{
                                'bg-green-600 hover:bg-green-700 dark:hover:bg-green-600 text-white': response === 'accepted',
                                'bg-yellow-600 hover:bg-yellow-700 dark:hover:bg-yellow-600 text-white': response === 'reschedule_proposed',
                                'bg-red-600 hover:bg-red-700 dark:hover:bg-red-600 text-white': response === 'declined',
                                'bg-gray-300 dark:bg-slate-700 text-gray-500 dark:text-gray-400': !response
                            }">
                        <span x-show="response === 'accepted'">Konfirmasi Kehadiran</span>
                        <span x-show="response === 'reschedule_proposed'">Kirim Usulan Jadwal</span>
                        <span x-show="response === 'declined'">Tolak Undangan</span>
                        <span x-show="!response">Pilih Respon Terlebih Dahulu</span>
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- SECTION: Status Respon (sudah merespon) --}}
        @if($session->tpa_type === 'offline' && $session->seeker_response === 'accepted')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center gap-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-700/50">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-green-800 dark:text-green-200">Anda telah menerima undangan ini</div>
                        <div class="text-sm text-green-600 dark:text-green-400 mt-1">Silakan hadir sesuai jadwal dan lokasi yang tertera di atas.</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($session->tpa_type === 'offline' && $session->seeker_response === 'reschedule_proposed')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-200 dark:border-yellow-700/50">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/40 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-yellow-800 dark:text-yellow-200">Anda mengusulkan jadwal baru</div>
                        @if($session->reschedule_proposed_at)
                        <div class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">Jadwal usulan: <strong>{{ \Carbon\Carbon::parse($session->reschedule_proposed_at)->format('d M Y H:i') }}</strong></div>
                        @endif
                        @if($session->reschedule_reason)
                        <div class="text-sm text-yellow-600 dark:text-yellow-400 mt-1">Alasan: {{ $session->reschedule_reason }}</div>
                        @endif
                        <div class="text-xs text-yellow-500 dark:text-yellow-400 mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Menunggu konfirmasi dari perusahaan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($session->tpa_type === 'offline' && $session->seeker_response === 'declined')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center gap-4 p-4 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-700/50">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/40 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-red-800 dark:text-red-200">Anda telah menolak undangan ini</div>
                        <div class="text-sm text-red-600 dark:text-red-400 mt-1">Undangan ini tidak berlaku lagi untuk Anda.</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION: Hasil Tes Offline --}}
        @if($session->status === 'completed' && $session->tpa_type === 'offline')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h2 class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Hasil Tes Offline
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center p-6 rounded-xl {{ $session->offline_is_passed ? 'bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-700/50' : 'bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-700/50' }}">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Skor Anda</div>
                        <div class="text-4xl font-bold {{ $session->offline_is_passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $session->offline_score }}%
                        </div>
                    </div>
                    <div class="text-center p-6 rounded-xl {{ $session->offline_is_passed ? 'bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-700/50' : 'bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-700/50' }}">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Status</div>
                        <div class="text-3xl font-bold {{ $session->offline_is_passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $session->offline_is_passed ? 'LULUS' : 'TIDAK LULUS' }}
                        </div>
                    </div>
                </div>

                @if($session->offline_result_notes)
                <div class="p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-slate-700">
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan dari Perusahaan</div>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">{{ $session->offline_result_notes }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- SECTION: Hasil Tes Online --}}
        @if($session->status === 'completed' && $session->tpa_type === 'online' && $session->result)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h2 class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Hasil Tes
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center p-6 rounded-xl {{ $session->result->is_passed ? 'bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-700/50' : 'bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-700/50' }}">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Skor Total</div>
                        <div class="text-4xl font-bold {{ $session->result->is_passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $session->result->total_score }}%
                        </div>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-700/50">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Skor Bappenas</div>
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $session->result->bappenas_score }}
                        </div>
                    </div>
                </div>

                <div class="text-center mb-4">
                    @if($session->result->is_passed)
                    <span class="inline-flex items-center gap-2 px-6 py-3 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full text-lg font-bold border border-green-200 dark:border-green-700/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        LULUS
                    </span>
                    @else
                    <span class="inline-flex items-center gap-2 px-6 py-3 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 rounded-full text-lg font-bold border border-red-200 dark:border-red-700/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        TIDAK LULUS
                    </span>
                    @endif
                </div>

                <a href="{{ route('seeker.tpa.result', $session) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition-colors">
                    Lihat Detail Hasil Lengkap
                </a>
            </div>
        </div>
        @endif

        {{-- SECTION: Aksi Online (Mulai/Lanjutkan) --}}
        @if($session->tpa_type === 'online' && $session->status === 'invited')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700/50 rounded-xl p-4 mb-6">
                    <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Petunjuk Pengerjaan
                    </h3>
                    <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-2">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Pastikan koneksi internet stabil sebelum memulai tes
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Gunakan browser terbaru (Chrome, Firefox, atau Edge)
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Timer akan berjalan setelah Anda memulai tes
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Jawaban disimpan otomatis, Anda bisa berpindah soal
                        </li>
                    </ul>
                </div>

                @if($session->expires_at)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 text-center">
                    Batas waktu pengerjaan: <strong class="text-gray-700 dark:text-gray-300">{{ $session->expires_at->format('d M Y H:i') }}</strong>
                </p>
                @endif

                <form action="{{ route('seeker.tpa.start', $session) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all hover:-translate-y-0.5">
                        Mulai Tes Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($session->tpa_type === 'online' && $session->status === 'in_progress')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <a href="{{ route('seeker.tpa.test', $session) }}" class="block w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white py-4 rounded-xl font-bold text-lg text-center shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all hover:-translate-y-0.5">
                    Lanjutkan Tes
                </a>
            </div>
        </div>
        @endif

    </div>
</div>

<style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
