<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Notifikasi</h1>
                    <p class="text-slate-550 dark:text-slate-400 mt-1">Kelola semua pemberitahuan dan informasi penting Anda.</p>
                </div>
                
                @if($notifications->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST" class="shrink-0">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:shadow transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Semua Dibaca
                    </button>
                </form>
                @endif
            </div>

            <!-- Info Card Banner -->
            <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 border border-blue-100 dark:border-blue-900/30 rounded-2xl shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">Pusat Notifikasi & Pemberitahuan</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            Halaman ini merangkum semua pemberitahuan penting untuk Anda. Anda akan menerima pemberitahuan ketika ada <strong>lowongan baru yang cocok</strong>, <strong>perubahan status lamaran kerja</strong>, atau <strong>pengumuman penting</strong> terkait program pembelajaran Anda. Klik tombol "Lihat Detail" untuk langsung mengakses halaman terkait, atau hapus notifikasi yang sudah tidak diperlukan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Content Grid (2/3 Feed, 1/3 Info Sidebar) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Notifications Feed (Left Column) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        @if($notifications->count() > 0)
                            <ul class="divide-y divide-slate-105 dark:divide-slate-700">
                                @foreach($notifications as $notification)
                                    @php
                                        $type = $notification['data']['type'] ?? $notification['data']['icon'] ?? 'default';
                                        $isUnread = is_null($notification['read_at']);
                                    @endphp
                                    <li class="relative hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-200 {{ $isUnread ? 'bg-blue-50/20 dark:bg-blue-900/10' : '' }}">
                                        <div class="px-6 py-5 flex items-start gap-4">
                                            <!-- Icon Container -->
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                                    @if(in_array($type, ['job_match', 'new_application'])) bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                                                    @elseif(in_array($type, ['application_status', 'submission_graded'])) bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400
                                                    @elseif(in_array($type, ['application_withdrawn', 'verification_rejected'])) bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400
                                                    @elseif(in_array($type, ['verification_approved', 'course_completed'])) bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400
                                                    @elseif(in_array($type, ['class_enrollment', 'new_student_enrolled', 'team_invitation'])) bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400
                                                    @elseif(in_array($type, ['collaboration_proposal'])) bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400
                                                    @else bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 @endif">
                                                    
                                                    @if(in_array($notification['data']['icon'] ?? '', ['briefcase']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['clipboard-check']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['user-minus']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['check-circle']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['x-circle']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['users']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['user-plus']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['award']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['handshake']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    @elseif(in_array($notification['data']['icon'] ?? '', ['inbox']))
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                                    @endif
                                                </div>
                                            </div>
            
                                            <!-- Content -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-4">
                                                    <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                                        {{ $notification['data']['title'] ?? 'Pemberitahuan Baru' }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <p class="mt-1 text-sm text-slate-655 dark:text-slate-300 line-clamp-2 leading-relaxed">
                                                    {{ $notification['data']['message'] ?? 'Anda memiliki pemberitahuan sistem baru.' }}
                                                </p>
                                                
                                                <div class="mt-3.5 flex items-center gap-3">
                                                    @if(!empty($notification['data']['url']))
                                                        <a href="{{ $notification['data']['url'] }}" class="inline-flex items-center text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                                            Lihat Detail
                                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                        </a>
                                                    @endif
            
                                                    @if($isUnread)
                                                        <form action="{{ route('notifications.read', $notification['id']) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="text-sm font-semibold text-slate-550 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                                                                Tandai Dibaca
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('notifications.destroy', $notification['id']) }}" method="POST" class="inline ml-auto">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700/50" title="Hapus Notifikasi">
                                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <!-- Unread Dot -->
                                            @if($isUnread)
                                                <div class="flex-shrink-0 flex items-center justify-center self-center">
                                                    <span class="w-2.5 h-2.5 bg-blue-600 dark:bg-blue-500 rounded-full ring-4 ring-blue-50 dark:ring-blue-900/30"></span>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <!-- Pagination -->
                            @if($notifications->hasPages())
                                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                                    {{ $notifications->links() }}
                                </div>
                            @endif
                        @else
                            <div class="p-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-900/30 mb-4 text-blue-600 dark:text-blue-400 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Kotak Masuk Kosong</h3>
                                <p class="mt-2 text-slate-500 dark:text-slate-400 max-w-sm mx-auto text-sm">Saat ini Anda tidak memiliki pemberitahuan baru. Kami akan memberi tahu Anda jika ada aktivitas terbaru!</p>
                                <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl text-sm transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Sidebar (Right Column) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm space-y-4">
                        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-3">
                            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-slate-900 dark:text-white">Tentang Notifikasi</h4>
                        </div>
                        
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            Semua pemberitahuan penting ada di sini. Anda akan menerima notifikasi saat:
                        </p>
                        
                        <ul class="space-y-3.5 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                                <span><strong>Lowongan baru cocok</strong> dengan profil Anda.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mt-2 flex-shrink-0"></span>
                                <span><strong>Status lamaran berubah</strong> dari tim rekrutmen.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 bg-purple-500 rounded-full mt-2 flex-shrink-0"></span>
                                <span><strong>Informasi penting</strong> terkait TPA atau kursus.</span>
                            </li>
                        </ul>
                        
                        <p class="text-xs text-slate-400 dark:text-slate-500 pt-2 border-t border-slate-100 dark:border-slate-700">
                            Silakan klik tombol <strong>"Lihat Detail"</strong> untuk langsung mengarah ke halaman terkait.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
