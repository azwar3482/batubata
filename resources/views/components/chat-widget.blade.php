<div id="chat-widget" x-data="chatWidget()" x-cloak>
    {{-- Floating Button --}}
    <button @click="toggleChat()"
            class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-full shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:scale-110 flex items-center justify-center"
            :class="isOpen ? 'rotate-90' : ''">
        <svg x-show="!isOpen" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <svg x-show="isOpen" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Chat Window --}}
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="fixed bottom-20 right-2 sm:bottom-24 sm:right-6 z-50 w-[calc(100vw-1rem)] sm:w-96 h-[500px] sm:h-[600px] bg-white dark:bg-slate-900 rounded-xl sm:rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 flex flex-col overflow-hidden max-w-[400px]">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-sm">KOMPASKARIR Assistant</div>
                    <div class="text-xs opacity-80" x-text="isConfigured ? 'Online' : 'Offline - API belum dikonfigurasi'"></div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button @click="clearChat()" class="p-1.5 hover:bg-white/20 rounded-lg transition-colors" title="Hapus chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
            {{-- Welcome Message --}}
            <template x-if="messages.length === 0">
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white mb-2">Halo! 👋</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">Saya asisten virtual KOMPASKARIR. Ada yang bisa saya bantu?</p>
                </div>
            </template>

            {{-- Chat Messages --}}
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user'
                        ? 'bg-blue-600 text-white rounded-2xl rounded-br-md max-w-[80%]'
                        : 'bg-gray-100 dark:bg-slate-800 text-gray-800 dark:text-slate-200 rounded-2xl rounded-bl-md max-w-[80%]'"
                        class="px-4 py-3">
                        <div class="text-sm leading-relaxed" x-html="formatMessage(msg.content)"></div>

                        {{-- Deep Links --}}
                        <template x-if="msg.metadata?.deep_links?.length > 0">
                            <div class="mt-3 pt-2 border-t border-gray-200/30 dark:border-slate-700/50">
                                <template x-for="link in msg.metadata.deep_links" :key="link.url">
                                    <a :href="link.url" class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full mb-1"
                                       :class="msg.role === 'user' ? 'bg-white/20 hover:bg-white/30' : 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50'">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span x-text="link.label"></span>
                                    </a>
                                </template>
                            </div>
                        </template>

                        <div class="text-[10px] mt-1 opacity-60" x-text="formatTime(msg.created_at)"></div>
                    </div>
                </div>
            </template>

            {{-- Typing Indicator --}}
            <template x-if="isLoading">
                <div class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-slate-800 rounded-2xl rounded-bl-md px-4 py-3">
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 bg-gray-400 dark:bg-slate-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                            <div class="w-2 h-2 bg-gray-400 dark:bg-slate-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                            <div class="w-2 h-2 bg-gray-400 dark:bg-slate-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Suggestions --}}
        <div x-show="suggestions.length > 0 && messages.length > 0" class="px-4 pb-2 flex flex-wrap gap-1.5 bg-white dark:bg-slate-900">
            <template x-for="sug in suggestions" :key="sug">
                <button @click="sendMessage(sug)" class="text-xs px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors" x-text="sug"></button>
            </template>
        </div>

        {{-- Input --}}
        <div class="p-4 border-t border-gray-100 dark:border-slate-800 flex-shrink-0 bg-white dark:bg-slate-900">
            <form @submit.prevent="sendMessage()" class="flex gap-2">
                <input type="text" x-model="inputMessage"
                       placeholder="Ketik pertanyaan Anda..."
                       class="flex-1 border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-400 dark:placeholder-gray-500"
                       :disabled="isLoading"
                       @keydown.enter.prevent="sendMessage()">
                <button type="submit"
                        :disabled="!inputMessage.trim() || isLoading"
                        class="w-10 h-10 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-100 dark:disabled:bg-blue-900/30 disabled:text-blue-400 dark:disabled:text-blue-800 text-white rounded-xl flex items-center justify-center transition-colors flex-shrink-0">
                    <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <svg x-show="isLoading" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    #chat-messages::-webkit-scrollbar { width: 6px; }
    #chat-messages::-webkit-scrollbar-track { background: transparent; }
    #chat-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    #chat-messages::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
</style>

<script>
function chatWidget() {
    return {
        isOpen: false,
        messages: [],
        suggestions: [],
        inputMessage: '',
        isLoading: false,
        sessionId: null,
        isConfigured: true,

        async init() {
            // Cek status API
            try {
                const res = await fetch('/chat/status');
                const data = await res.json();
                this.isConfigured = data.configured;
            } catch (e) {
                this.isConfigured = false;
            }

            // Restore sessionId dari localStorage
            this.sessionId = localStorage.getItem('chat_session_id') || null;

            // Load history jika ada session tersimpan
            if (this.sessionId) {
                this.loadHistory();
            }

            // Load suggestions
            this.loadSuggestions();
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen && this.messages.length === 0) {
                this.loadHistory();
            }
            this.$nextTick(() => this.scrollToBottom());
        },

        async loadSuggestions() {
            try {
                const res = await fetch('/chat/suggestions');
                const data = await res.json();
                if (data.success) {
                    this.suggestions = data.suggestions.slice(0, 4);
                }
            } catch (e) {}
        },

        async loadHistory() {
            if (!this.sessionId) return;
            try {
                const res = await fetch(`/chat/history?session_id=${this.sessionId}`);
                const data = await res.json();
                if (data.success) {
                    this.messages = data.messages;
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (e) {}
        },

        async sendMessage(text) {
            const message = text || this.inputMessage.trim();
            if (!message || this.isLoading) return;

            // Validasi panjang pesan
            if (message.length > 1000) {
                this.messages.push({
                    role: 'assistant',
                    content: 'Pesan terlalu panjang. Maksimal 1000 karakter.',
                    created_at: new Date().toISOString(),
                });
                this.$nextTick(() => this.scrollToBottom());
                return;
            }

            // Cek apakah pesan mengandung URL/file media
            if (/\.(jpg|jpeg|png|gif|mp4|mp3|wav|webm|svg|bmp)/i.test(message)) {
                this.messages.push({
                    role: 'assistant',
                    content: 'Maaf, saya hanya dapat memproses pesan teks. Saya tidak bisa memproses gambar atau video.',
                    created_at: new Date().toISOString(),
                });
                this.$nextTick(() => this.scrollToBottom());
                return;
            }

            this.inputMessage = '';
            this.messages.push({
                role: 'user',
                content: message,
                created_at: new Date().toISOString(),
            });

            this.$nextTick(() => this.scrollToBottom());
            this.isLoading = true;

            try {
                const res = await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        message: message,
                        session_id: this.sessionId,
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    this.sessionId = data.session_id;
                    localStorage.setItem('chat_session_id', this.sessionId);
                    this.messages.push({
                        role: 'assistant',
                        content: data.text,
                        metadata: {
                            deep_links: data.deep_links || [],
                        },
                        created_at: new Date().toISOString(),
                    });

                    if (data.suggestions?.length > 0) {
                        this.suggestions = data.suggestions.slice(0, 4);
                    }
                } else {
                    this.messages.push({
                        role: 'assistant',
                        content: data.error || 'Maaf, terjadi kesalahan. Silakan coba lagi.',
                        created_at: new Date().toISOString(),
                    });
                }
            } catch (e) {
                this.messages.push({
                    role: 'assistant',
                    content: 'Gagal menghubungi server. Periksa koneksi internet Anda.',
                    created_at: new Date().toISOString(),
                });
            }

            this.isLoading = false;
            this.$nextTick(() => this.scrollToBottom());
        },

        async clearChat() {
            if (!confirm('Hapus semua percakapan?')) return;

            try {
                await fetch(`/chat/history?session_id=${this.sessionId || ''}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    },
                });
            } catch (e) {}

            this.messages = [];
            this.sessionId = null;
            localStorage.removeItem('chat_session_id');
            this.suggestions = [];
            this.loadSuggestions();
        },

        formatMessage(text) {
            if (!text) return '';
            // Escape HTML terlebih dahulu untuk mencegah XSS
            const escaped = text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
            // Convert markdown-like formatting
            return escaped
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/`(.*?)`/g, '<code class="bg-gray-200 px-1 rounded text-xs">$1</code>')
                .replace(/\n/g, '<br>');
        },

        formatTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        },

        scrollToBottom() {
            const el = document.getElementById('chat-messages');
            if (el) {
                el.scrollTop = el.scrollHeight;
            }
        }
    };
}
</script>
