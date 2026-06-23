<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-950/20 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Review Manual Profil</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Dapatkan feedback personal dari reviewer ahli</p>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 mb-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold mb-2">Review Manual oleh Ahli</h2>
                        <p class="text-indigo-100 text-sm mb-4">Profil Anda akan direview oleh reviewer ahli yang akan memberikan feedback personal untuk meningkatkan peluang karir Anda.</p>
                        <ul class="text-sm text-indigo-100 space-y-1">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Feedback tertulis dari reviewer
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Saran perbaikan profil
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Estimasi selesai: 1-3 hari kerja
                            </li>
                        </ul>
                    </div>
                    <div class="text-center md:text-right">
                        <div class="text-3xl font-bold">Rp 75.000</div>
                        <div class="text-indigo-200 text-sm">per review</div>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl mb-6">
                {{ session('error') }}
            </div>
            @endif

            <!-- Request Form -->
            @if(!$hasPending)
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 mb-8">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4">Ajukan Review Manual</h3>
                
                <form action="{{ route('manual-review.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Catatan untuk Reviewer (Opsional)</label>
                        <textarea name="notes" rows="3" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Contoh: Saya ingin melamar posisi Marketing Manager, mohon review profil saya untuk posisi tersebut."></textarea>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Biaya Review Manual</span>
                            <span class="text-lg font-bold text-slate-800 dark:text-slate-200">Rp 75.000</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors">
                        Ajukan Review Manual
                    </button>
                </form>
            </div>
            @else
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-6 mb-8">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-amber-800 dark:text-amber-300">Permintaan Review Sedang Diproses</h3>
                        <p class="text-sm text-amber-600 dark:text-amber-400">Anda sudah memiliki permintaan review yang sedang menunggu atau diproses.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- History -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4">Riwayat Review</h3>

                @if($requests->isEmpty())
                <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-8">Belum ada riwayat review manual.</p>
                @else
                <div class="space-y-4">
                    @foreach($requests as $request)
                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                @if($request->status === 'completed')
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">Selesai</span>
                                @elseif($request->status === 'pending')
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">Menunggu</span>
                                @elseif($request->status === 'in_review')
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">Sedang Direview</span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400 rounded-full">{{ ucfirst($request->status) }}</span>
                                @endif
                                <span class="text-xs text-slate-500">{{ $request->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Rp {{ number_format($request->amount, 0, ',', '.') }}</span>
                        </div>

                        @if($request->admin_feedback)
                        <div class="mt-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                            <p class="text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Feedback Reviewer:</p>
                            <p class="text-sm text-slate-700 dark:text-slate-300">{{ $request->admin_feedback }}</p>
                        </div>
                        @endif

                        @if($request->status === 'pending' && $request->payment_status === 'pending')
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('manual-review.payment', $request->id) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Bayar Sekarang</a>
                            <span class="text-slate-300">|</span>
                            <form action="{{ route('manual-review.cancel', $request->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Batalkan</button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
