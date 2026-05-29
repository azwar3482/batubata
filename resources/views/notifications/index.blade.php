<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Notifikasi</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Kelola semua pemberitahuan Anda di sini.</p>
            </div>
            
            @if($notifications->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            @if($notifications->count() > 0)
                <ul class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($notifications as $notification)
                        <li class="relative hover:bg-slate-50 dark:hover:bg-slate-750 transition-colors duration-200 {{ is_null($notification->read_at) ? 'bg-blue-50/30 dark:bg-blue-900/10' : '' }}">
                            <div class="px-6 py-5 flex items-start gap-4">
                                <!-- Icon Container -->
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                        @if($notification->data['type'] ?? '' === 'job_match') bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                                        @elseif($notification->data['type'] ?? '' === 'application_status') bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400
                                        @elseif($notification->data['type'] ?? '' === 'application_withdrawn') bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400
                                        @else bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 @endif">
                                        
                                        @if(($notification->data['icon'] ?? '') === 'briefcase')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        @elseif(($notification->data['icon'] ?? '') === 'clipboard-check')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                        @elseif(($notification->data['icon'] ?? '') === 'user-minus')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-4">
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                            {{ $notification->data['title'] ?? 'Pemberitahuan Baru' }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300 line-clamp-2">
                                        {{ $notification->data['message'] ?? 'Anda memiliki pemberitahuan sistem baru.' }}
                                    </p>
                                    
                                    <div class="mt-3 flex items-center gap-3">
                                        @if(isset($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                                Lihat Detail
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        @endif

                                        @if(is_null($notification->read_at))
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline ml-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors" title="Hapus Notifikasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Unread Dot -->
                                @if(is_null($notification->read_at))
                                    <div class="flex-shrink-0 flex items-center justify-center">
                                        <span class="w-2.5 h-2.5 bg-blue-600 rounded-full"></span>
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-slate-500 dark:text-slate-400">Saat ini Anda belum memiliki notifikasi apapun.</p>
                </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
