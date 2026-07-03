<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-6">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.dashboard') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('seeker.courses.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('messages.courses') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Pembayaran</span>
            </nav>

            <!-- Header Title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Selesaikan Pembayaran</h1>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Pilih metode pembayaran terbaik Anda untuk mulai mengakses materi belajar.</p>
                </div>
                <a href="{{ route('seeker.courses.show', ['id' => $course->id, 'type' => $courseType === 'teacher' ? 'teacher' : 'external']) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-350 dark:border-slate-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-200 shrink-0 shadow-sm">
                    &larr; Kembali ke Detail
                </a>
            </div>

            <!-- Error and Success Notifications -->
            @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-800/50 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-sm text-green-700 dark:text-green-300 font-semibold">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-8 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <p class="text-sm text-red-700 dark:text-red-300 font-semibold">{{ session('error') }}</p>
            </div>
            @endif

            <!-- Main Layout Form (2 Columns) -->
            <form action="{{ route('seeker.courses.process-payment', $payment->id) }}" method="POST" x-data="{ selectedMethod: 'bank_transfer' }">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Payment Methods Selection (2/3) -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">Metode Pembayaran</h3>
                            
                            <div class="space-y-4">
                                <!-- Bank Transfer option -->
                                <label 
                                    class="flex items-center gap-4 p-4 border rounded-2xl cursor-pointer transition-all duration-300"
                                    :class="selectedMethod === 'bank_transfer' ? 'border-blue-500 bg-blue-50/40 dark:bg-blue-950/20 shadow-sm ring-1 ring-blue-500/20' : 'border-gray-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/40'"
                                    @click="selectedMethod = 'bank_transfer'"
                                >
                                    <input type="radio" name="payment_method" value="bank_transfer" x-model="selectedMethod" class="text-blue-600 focus:ring-blue-500 focus:ring-offset-2 dark:bg-slate-900 dark:border-slate-700 h-4 w-4">
                                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/40 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="block font-bold text-gray-900 dark:text-white text-sm">Transfer Bank (Verifikasi Manual)</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">Transfer melalui BCA, Mandiri, BNI, atau BRI</span>
                                    </div>
                                </label>

                                <!-- E-Wallet option -->
                                <label 
                                    class="flex items-center gap-4 p-4 border rounded-2xl cursor-pointer transition-all duration-300"
                                    :class="selectedMethod === 'e_wallet' ? 'border-blue-500 bg-blue-50/40 dark:bg-blue-950/20 shadow-sm ring-1 ring-blue-500/20' : 'border-gray-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/40'"
                                    @click="selectedMethod = 'e_wallet'"
                                >
                                    <input type="radio" name="payment_method" value="e_wallet" x-model="selectedMethod" class="text-blue-600 focus:ring-blue-500 focus:ring-offset-2 dark:bg-slate-900 dark:border-slate-700 h-4 w-4">
                                    <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-950/40 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="block font-bold text-gray-900 dark:text-white text-sm">E-Wallet (Konfirmasi Instan)</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">GoPay, OVO, DANA, LinkAja</span>
                                    </div>
                                </label>

                                <!-- Credit Card option -->
                                <label 
                                    class="flex items-center gap-4 p-4 border rounded-2xl cursor-pointer transition-all duration-300"
                                    :class="selectedMethod === 'credit_card' ? 'border-blue-500 bg-blue-50/40 dark:bg-blue-950/20 shadow-sm ring-1 ring-blue-500/20' : 'border-gray-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/40'"
                                    @click="selectedMethod = 'credit_card'"
                                >
                                    <input type="radio" name="payment_method" value="credit_card" x-model="selectedMethod" class="text-blue-600 focus:ring-blue-500 focus:ring-offset-2 dark:bg-slate-900 dark:border-slate-700 h-4 w-4">
                                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/40 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="block font-bold text-gray-900 dark:text-white text-sm">Kartu Kredit / Debit</span>
                                        <span class="block text-xs text-gray-500 dark:text-slate-400 mt-0.5">Visa, MasterCard, JCB, American Express</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Order Summary & Pay button (1/3) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 sticky top-6 space-y-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b pb-2 border-gray-100 dark:border-slate-700/50">Ringkasan Pesanan</h3>
                            
                            <!-- Course details -->
                            <div class="flex gap-4">
                                <div class="w-14 h-14 rounded-xl {{ $courseType === 'teacher' ? 'bg-indigo-600 text-indigo-100' : 'bg-blue-600 text-blue-100' }} flex items-center justify-center shrink-0 shadow-sm font-bold text-xl uppercase font-mono">
                                    {{ substr($course->title, 0, 2) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate" title="{{ $course->title }}">{{ $course->title }}</h4>
                                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                                        @if($courseType === 'teacher')
                                            Pengajar: {{ $course->teacher->name ?? '-' }}
                                        @else
                                            Platform: {{ $course->platform ?? 'External' }}
                                        @endif
                                    </p>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $course->level == 'beginner' ? 'bg-green-50 text-green-700 dark:bg-green-950/30 dark:text-green-400' : ($course->level == 'intermediate' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400' : 'bg-red-50 text-red-700 dark:bg-red-950/30 dark:text-red-400') }}">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $course->duration_hours }} Jam</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-100 dark:border-slate-700/50">

                            <!-- Pricing details -->
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-slate-400">Harga Asli</span>
                                    <span class="font-semibold text-gray-800 dark:text-slate-300">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-slate-400">Pajak & Biaya Layanan</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">Gratis</span>
                                </div>
                                <div class="flex justify-between border-t border-gray-100 dark:border-slate-700/50 pt-3">
                                    <span class="font-bold text-gray-900 dark:text-white">Total Bayar</span>
                                    <span class="text-xl font-black text-blue-600 dark:text-blue-400">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Pay Action -->
                            <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-center">
                                Bayar Sekarang
                            </button>

                            <p class="text-[10px] text-gray-400 dark:text-slate-500 text-center leading-relaxed">
                                Dengan menekan tombol di atas, Anda menyetujui Ketentuan Layanan & Kebijakan Privasi KompasKarir.
                            </p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
