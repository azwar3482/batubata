<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 mb-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10 translate-x-12 -translate-y-12">
                    <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/></svg>
                </div>
                <div class="relative z-10">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold uppercase tracking-wider">Vendor Dashboard</span>
                    <h1 class="text-3xl font-extrabold mt-3">Selamat Datang, {{ $vendor->name }}</h1>
                    <p class="text-blue-100 mt-2 max-w-xl">Kelola pengajar, pantau pendaftaran siswa, dan verifikasi pembayaran kursus secara terpusat di satu dashboard premium.</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Teachers -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 border-l-4" style="border-left-color: #3b82f6 !important;">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-500 dark:text-slate-400">Total Pengajar</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-0.5">{{ $totalTeachers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Courses -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 border-l-4" style="border-left-color: #10b981 !important;">
                    <div class="flex items-center">
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-500 dark:text-slate-400">Total Kursus</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-0.5">{{ $totalCourses }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Enrollments -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 border-l-4" style="border-left-color: #8b5cf6 !important;">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-xl text-purple-600 dark:text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-500 dark:text-slate-400">Siswa Terdaftar</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-0.5">{{ $totalEnrollments }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 border-l-4" style="border-left-color: #f59e0b !important;">
                    <div class="flex items-center">
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl text-amber-600 dark:text-amber-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 12h4" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-500 dark:text-slate-400">Pendapatan Bersih</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white mt-0.5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Alert -->
            @if($pendingPaymentsCount > 0)
            <div class="mb-8 p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/50 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">Ada {{ $pendingPaymentsCount }} pembayaran siswa baru yang menunggu verifikasi bukti transfer.</p>
                </div>
                <a href="{{ route('vendor.payments.index', ['status' => 'pending']) }}" class="text-xs font-bold bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-xl transition">Kelola Transaksi &rarr;</a>
            </div>
            @endif

            <!-- Table Section -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-150 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-900/10">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Transaksi Pembelian Kursus Terbaru</h2>
                    <a href="{{ route('vendor.payments.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400">Lihat Semua &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 text-left">
                        <thead class="bg-gray-50/50 dark:bg-slate-900/20 text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Siswa</th>
                                <th class="px-6 py-4">Kursus</th>
                                <th class="px-6 py-4">Nominal</th>
                                <th class="px-6 py-4">Metode</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700 text-sm">
                            @forelse($latestPayments as $payment)
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
                                <td class="px-6 py-4 font-mono text-xs uppercase text-gray-600 dark:text-slate-400">
                                    {{ str_replace('_', ' ', $payment->payment_method ?? 'transfer') }}
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
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('vendor.payments.show', $payment->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/30 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-bold transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">Belum ada transaksi pembelian kursus yang tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
