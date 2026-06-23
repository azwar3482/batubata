<x-app-layout>
    <div class="py-6">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('manual-review.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 mb-2 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Pembayaran Review Manual</h1>
            </div>

            <!-- Order Summary -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 mb-6">
                <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600 dark:text-slate-400">Review Manual Profil</span>
                        <span class="font-medium text-slate-800 dark:text-slate-200">Rp 75.000</span>
                    </div>
                    <div class="border-t border-slate-200 dark:border-slate-700 pt-3 flex justify-between">
                        <span class="font-semibold text-slate-800 dark:text-slate-200">Total</span>
                        <span class="text-lg font-bold text-indigo-600">Rp 75.000</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
                <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-4">Pilih Metode Pembayaran</h3>

                <form action="{{ route('manual-review.process-payment', $reviewRequest->id) }}" method="POST">
                    @csrf

                    <div class="space-y-3 mb-6">
                        <!-- Bank Transfer -->
                        <label class="flex items-center gap-3 p-4 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <input type="radio" name="payment_method" value="bank_transfer" class="text-indigo-600 focus:ring-indigo-500" checked>
                            <div class="flex-1">
                                <span class="font-medium text-slate-800 dark:text-slate-200">Transfer Bank</span>
                                <p class="text-xs text-slate-500">BCA, Mandiri, BNI, BRI</p>
                            </div>
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </label>

                        <!-- E-Wallet -->
                        <label class="flex items-center gap-3 p-4 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <input type="radio" name="payment_method" value="e_wallet" class="text-indigo-600 focus:ring-indigo-500">
                            <div class="flex-1">
                                <span class="font-medium text-slate-800 dark:text-slate-200">E-Wallet</span>
                                <p class="text-xs text-slate-500">GoPay, OVO, DANA, ShopeePay</p>
                            </div>
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </label>

                        <!-- Credit Card -->
                        <label class="flex items-center gap-3 p-4 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <input type="radio" name="payment_method" value="credit_card" class="text-indigo-600 focus:ring-indigo-500">
                            <div class="flex-1">
                                <span class="font-medium text-slate-800 dark:text-slate-200">Kartu Kredit</span>
                                <p class="text-xs text-slate-500">Visa, Mastercard, JCB</p>
                            </div>
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors">
                        Bayar Rp 75.000
                    </button>
                </form>

                <p class="text-xs text-slate-500 dark:text-slate-400 text-center mt-4">
                    Pembayaran diproses secara aman. Anda akan menerima konfirmasi setelah pembayaran berhasil.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
