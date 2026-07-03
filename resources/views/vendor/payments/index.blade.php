<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success message -->
            @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 rounded-xl">
                <p class="text-sm text-green-700 dark:text-green-300 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </p>
            </div>
            @endif

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Pengelolaan Pembayaran</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Daftar transaksi pembayaran kursus berbayar yang diambil oleh siswa untuk materi guru-guru di bawah {{ $vendor->name }}.</p>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 mb-8">
                <form action="{{ route('vendor.payments.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-grow w-full md:w-auto">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Status Pembayaran</label>
                        <select name="status" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Berhasil (Paid)</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal (Failed)</option>
                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-md hover:shadow-lg">
                        Terapkan Filter
                    </button>
                </form>
            </div>

            <!-- Payments List Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 text-left">
                        <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Siswa</th>
                                <th class="px-6 py-4">Kursus & Pengajar</th>
                                <th class="px-6 py-4">Nominal</th>
                                <th class="px-6 py-4">Metode & Ref</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Tanggal Transaksi</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700 text-sm">
                            @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $payment->user->name }}</div>
                                    <div class="text-xs text-gray-400 dark:text-slate-500">{{ $payment->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800 dark:text-slate-300 truncate max-w-xs">{{ $payment->teacherCourse->title }}</div>
                                    <div class="text-xs text-gray-400 dark:text-slate-500">Guru: {{ $payment->teacherCourse->teacher->name }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-mono text-xs uppercase text-gray-700 dark:text-slate-300">{{ str_replace('_', ' ', $payment->payment_method ?? 'transfer') }}</div>
                                    <div class="text-xs font-mono text-gray-400 dark:text-slate-500">{{ $payment->payment_reference ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->status === 'paid')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-950/30 dark:text-green-400">Berhasil</span>
                                    @elseif($payment->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/30 dark:text-amber-400">Menunggu</span>
                                    @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400">Gagal</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-slate-400 text-xs">
                                    {{ $payment->created_at ? $payment->created_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('vendor.payments.show', $payment->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/30 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-bold transition">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">Belum ada transaksi pembayaran yang sesuai filter.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($payments->hasPages())
                <div class="p-6 border-t border-gray-150 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/10">
                    {{ $payments->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
