<x-app-layout>
    <div class="py-6 h-[calc(100vh-64px)] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col">
            
            <!-- Page Header (hidden on mobile if chat is active) -->
            <div class="mb-4 {{ $activeConversation ? 'hidden md:block' : '' }}">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pesan Masuk</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400">Hubungi langsung kandidat pelamar kerja Anda di sini.</p>
            </div>

            <!-- Main Chat Container -->
            <div class="flex-1 min-h-0 bg-white dark:bg-slate-900 rounded-2xl shadow-md border border-gray-100 dark:border-slate-800 flex overflow-hidden mb-6"
                 x-data="directChat()" x-init="initChat()">
                
                <!-- Sidebar: Chats List (hidden on mobile if chat is active) -->
                <div class="w-full md:w-80 lg:w-96 border-r border-gray-100 dark:border-slate-800 flex flex-col {{ $activeConversation ? 'hidden md:flex' : 'flex' }}">
                    <!-- Search Bar -->
                    <div class="p-4 border-b border-gray-100 dark:border-slate-800">
                        <div class="relative">
                            <input type="text" x-model="searchQuery" placeholder="Cari kandidat..." 
                                   class="w-full pl-9 pr-4 py-2 border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-850 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- List items -->
                    <div class="flex-1 overflow-y-auto divide-y divide-gray-50 dark:divide-slate-800/50">
                        @forelse($conversations as $conv)
                            @php
                                $unread = $conv->unreadMessagesCount(auth()->id());
                                $lastMsg = $conv->messages->first();
                            @endphp
                            <a href="{{ route('industry.chats.index', $conv->id) }}" 
                               class="flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors {{ $activeConversation && $activeConversation->id === $conv->id ? 'bg-blue-50/50 dark:bg-blue-900/10 border-l-4 border-blue-600' : '' }}"
                               x-show="matchesSearch('{{ addslashes($conv->jobSeeker->name) }}')">
                                
                                <!-- User Avatar -->
                                <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white font-bold flex items-center justify-center text-sm shrink-0 shadow-sm">
                                    {{ substr($conv->jobSeeker->name, 0, 2) }}
                                </div>

                                <!-- User Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $conv->jobSeeker->name }}</h4>
                                        <span class="text-[10px] text-gray-400 shrink-0">
                                            {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans(null, true) : ($conv->updated_at ? $conv->updated_at->diffForHumans(null, true) : '') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-xs text-gray-500 dark:text-slate-400 truncate pr-2">
                                            @if($lastMsg)
                                                {{ $lastMsg->sender_id === auth()->id() ? 'Anda: ' : '' }}{{ $lastMsg->message }}
                                            @else
                                                Belum ada pesan.
                                            @endif
                                        </p>
                                        @if($unread > 0)
                                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shrink-0">
                                                {{ $unread }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-gray-500 dark:text-slate-400">
                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-sm">Belum ada percakapan.</p>
                                <p class="text-xs text-gray-400 mt-1">Mulai hubungi kandidat melalui halaman Detail Kandidat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Pane (visible on mobile if chat is active, otherwise hidden) -->
                <div class="flex-1 flex flex-col bg-slate-50/50 dark:bg-slate-900/40 {{ $activeConversation ? 'flex' : 'hidden md:flex' }}">
                    @if($activeConversation)
                        <!-- Pane Header -->
                        <div class="px-6 py-4 bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between shrink-0 shadow-sm">
                            <div class="flex items-center gap-3">
                                <!-- Mobile Back Button -->
                                <a href="{{ route('industry.chats.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition md:hidden mr-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </a>

                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white font-bold flex items-center justify-center text-sm">
                                    {{ substr($activeConversation->jobSeeker->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ $activeConversation->jobSeeker->name }}</h3>
                                    <p class="text-xs text-gray-400 leading-none mt-1">Job Seeker</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('industry.candidates.show', $activeConversation->job_seeker_id) }}" 
                                   class="text-xs font-semibold px-3 py-1.5 border border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all shadow-sm">
                                    Lihat Profil Seeker
                                </a>
                            </div>
                        </div>

                        <!-- Messages Log Container -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
                            <div class="text-center py-2">
                                <span class="text-[10px] bg-gray-200/60 dark:bg-slate-800 text-gray-500 dark:text-slate-400 px-3 py-1 rounded-full font-medium">Awal Percakapan</span>
                            </div>

                            @foreach($messages as $msg)
                                @php
                                    $isMe = $msg->sender_id === auth()->id();
                                @endphp
                                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} items-end gap-2">
                                    @if(!$isMe)
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white font-bold flex items-center justify-center text-[9px] shrink-0">
                                            {{ substr($msg->sender->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="max-w-[70%] sm:max-w-md">
                                        <div class="px-4 py-2.5 rounded-2xl shadow-sm text-sm leading-relaxed
                                            {{ $isMe 
                                                ? 'bg-blue-600 text-white rounded-br-none' 
                                                : 'bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-100 rounded-bl-none border border-gray-100 dark:border-slate-700/60' 
                                            }}">
                                            {!! nl2br(e($msg->message)) !!}
                                        </div>
                                        <div class="text-[9px] text-gray-400 mt-1 {{ $isMe ? 'text-right' : 'text-left' }} flex items-center justify-end gap-1">
                                            <span>{{ $msg->created_at->format('H:i') }}</span>
                                            @if($isMe)
                                                @if($msg->is_read)
                                                    <svg class="w-3.5 h-3.5 text-blue-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7m-5 0l-4 4m-4-4"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Local instant message list (Alpine.js) -->
                            <template x-for="m in localMessages" :key="m.id">
                                <div class="flex justify-end items-end gap-2">
                                    <div class="max-w-[70%] sm:max-w-md">
                                        <div class="px-4 py-2.5 rounded-2xl shadow-sm text-sm leading-relaxed bg-blue-600 text-white rounded-br-none" x-text="m.message"></div>
                                        <div class="text-[9px] text-gray-400 mt-1 text-right flex items-center justify-end gap-1">
                                            <span x-text="m.time"></span>
                                            <svg class="w-3.5 h-3.5 text-gray-300 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Message Input Form -->
                        <div class="px-6 py-4 bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-slate-800 shrink-0">
                            <form action="{{ route('industry.chats.send', $activeConversation->id) }}" method="POST"
                                  @submit.prevent="submitMessage($el)">
                                @csrf
                                <div class="flex gap-2 items-end">
                                    <div class="flex-1 relative">
                                        <textarea name="message" x-model="newMessage" rows="1" max-length="5000" required
                                                  placeholder="Ketik pesan..." @keydown.enter.prevent="if(newMessage.trim()){ $el.closest('form').dispatchEvent(new Event('submit')) }"
                                                  class="w-full pl-4 pr-4 py-2.5 border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-850 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none h-10 min-h-[40px] max-h-32 overflow-y-auto"></textarea>
                                    </div>
                                    <button type="submit" :disabled="!newMessage.trim()"
                                            class="w-10 h-10 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center shadow transition-colors disabled:opacity-40 shrink-0">
                                        <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- No Active Chat State -->
                        <div class="flex-1 flex flex-col items-center justify-center p-8 text-gray-400 dark:text-slate-500">
                            <div class="w-20 h-20 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4 text-gray-300 dark:text-slate-600">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-700 dark:text-slate-300">Pilih Percakapan</h3>
                            <p class="text-sm text-center mt-1">Pilih salah satu kandidat di sebelah kiri untuk mulai mengobrol.</p>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <!-- Scroll to bottom and Alpine chat management script -->
    <script>
        function directChat() {
            return {
                searchQuery: '',
                newMessage: '',
                localMessages: [],
                
                initChat() {
                    this.scrollToBottom();
                    
                    // Auto-expand textarea
                    const tx = document.querySelector('textarea');
                    if (tx) {
                        tx.addEventListener("input", function() {
                            this.style.height = "auto";
                            this.style.height = (this.scrollHeight) + "px";
                        });
                    }
                },
                
                matchesSearch(name) {
                    if (!this.searchQuery) return true;
                    return name.toLowerCase().includes(this.searchQuery.toLowerCase());
                },
                
                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('messages-container');
                        if (el) {
                            el.scrollTop = el.scrollHeight;
                        }
                    });
                },
                
                async submitMessage(form) {
                    const text = this.newMessage.trim();
                    if (!text) return;
                    
                    this.newMessage = '';
                    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    
                    // Add message locally for instant render
                    const tempId = Date.now();
                    this.localMessages.push({
                        id: tempId,
                        message: text,
                        time: time
                    });
                    
                    this.scrollToBottom();
                    
                    // Reset textarea height
                    const tx = form.querySelector('textarea');
                    if (tx) tx.style.height = "auto";
                    
                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ message: text })
                        });
                        
                        if (!res.ok) {
                            throw new Error('Gagal mengirim pesan');
                        }
                    } catch (e) {
                        console.error(e);
                        // Fallback reload if AJAX fails
                        form.submit();
                    }
                }
            };
        }
    </script>
</x-app-layout>
