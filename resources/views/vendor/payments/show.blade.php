<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Verifikasi Pembayaran</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Periksa bukti transfer dan detail nominal transaksi sebelum memberikan persetujuan.</p>
                </div>
                <a href="{{ route('vendor.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-200 shrink-0">
                    &larr; Kembali ke Daftar
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Details & Proof (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Transaction details -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">Detail Transaksi</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Nama Siswa</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $payment->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $payment->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Kursus yang Dibeli</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white mt-1">{{ $payment->teacherCourse->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Pengajar: {{ $payment->teacherCourse->teacher->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Metode Pembayaran</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white mt-1 uppercase font-mono">{{ str_replace('_', ' ', $payment->payment_method ?? 'transfer') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Referensi Pembayaran</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white mt-1 font-mono">{{ $payment->payment_reference ?? 'CRS-' . $payment->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Nominal Pembayaran</p>
                                <p class="text-xl font-black text-gray-900 dark:text-white mt-1">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Tanggal & Waktu</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $payment->created_at ? $payment->created_at->format('d M Y H:i:s') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Proof of Payment placeholder -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">Bukti Transfer Pembayaran</h3>
                        
                        <div class="p-8 border border-dashed border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50/50 dark:bg-slate-900/20 text-center flex flex-col items-center justify-center min-h-[300px]">
                            <svg class="w-16 h-16 text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-sm font-bold text-gray-800 dark:text-white">Bukti Transfer Terlampir</span>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1.5 max-w-sm">Gambar bukti transfer manual diunggah oleh siswa. Pastikan nomor referensi, nominal transfer, dan nama pengirim di bukti transfer sesuai.</p>
                            
                            <!-- Demo mock image wrapper -->
                            <div class="mt-6 w-full max-w-md p-3 bg-white dark:bg-slate-800 shadow rounded-2xl border border-gray-100 dark:border-slate-700">
                                <div class="w-full h-48 bg-slate-100 dark:bg-slate-900/60 rounded-xl flex items-center justify-center border border-dashed border-gray-200 dark:border-slate-700 font-mono text-xs text-gray-400">
                                    [ BUKTI_TRANSFER_DEMO.JPG ]
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Verification Form (1/3) -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-100 dark:border-slate-700/50">Panel Verifikasi</h3>
                        
                        <div class="mb-5">
                            <span class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider block mb-1">Status Saat Ini</span>
                            @if($payment->status === 'paid')
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-950/30 dark:text-green-400">Berhasil (Paid)</span>
                            @elseif($payment->status === 'pending')
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/30 dark:text-amber-400">Menunggu (Pending)</span>
                            @else
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400">Gagal / Ditolak</span>
                            @endif
                        </div>

                        @if($payment->status === 'pending')
                        <form action="{{ route('vendor.payments.verify', $payment->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">Tindakan</label>
                                <select name="action" required class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                                    <option value="approve">Setujui Pembayaran (Approve)</option>
                                    <option value="reject">Tolak Pembayaran (Reject)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">Catatan / Alasan Penolakan</label>
                                <textarea name="reason" rows="3" placeholder="Tulis alasan jika menolak pembayaran..." class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200"></textarea>
                            </div>
                            <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-center">
                                Simpan Keputusan
                            </button>
                        </form>
                        @else
                        <div class="p-4 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-150 dark:border-slate-700 text-center">
                            <p class="text-xs text-gray-500 dark:text-slate-400">Verifikasi selesai dilakukan pada transaksi ini.</p>
                            @if($payment->paid_at)
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Waktu Verifikasi: {{ $payment->paid_at->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
