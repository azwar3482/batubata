<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen" x-data="{ showInviteModal: false }">
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
            <div class="flex justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Manajemen Pengajar</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Daftar guru yang berafiliasi dengan {{ $vendor->name }}. Anda dapat mengundang guru baru atau menonaktifkan status mengajar mereka.</p>
                </div>
                <button @click="showInviteModal = true" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Undang Guru
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 p-6 mb-8">
                <form action="{{ route('vendor.teachers.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau email guru..." class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 font-semibold rounded-xl transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Teachers List Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-150 dark:border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 text-left">
                        <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama Guru</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Total Kursus</th>
                                <th class="px-6 py-4">Status Akun</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700 text-sm">
                            @forelse($teachers as $teacher)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    {{ $teacher->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-slate-300">
                                    {{ $teacher->email }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ $teacher->teacher_courses_count }} Kursus
                                </td>
                                <td class="px-6 py-4">
                                    @if($teacher->status === 'active')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-950/30 dark:text-green-400">Aktif</span>
                                    @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('vendor.teachers.status', $teacher->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 {{ $teacher->status === 'active' ? 'bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-950/30 dark:text-red-400' : 'bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-950/30 dark:text-green-400' }} rounded-lg text-xs font-bold transition">
                                            {{ $teacher->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">Belum ada guru yang terdaftar untuk vendor ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($teachers->hasPages())
                <div class="p-6 border-t border-gray-150 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/10">
                    {{ $teachers->links() }}
                </div>
                @endif
            </div>

        </div>

        <!-- Invite Modal -->
        <div x-show="showInviteModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;" x-transition>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-md w-full border border-gray-150 dark:border-slate-700/50 overflow-hidden" @click.away="showInviteModal = false">
                <div class="p-6 border-b border-gray-150 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Undang Pengajar Baru</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Masukkan nama dan alamat email pengajar untuk menambahkan mereka.</p>
                </div>
                <form action="{{ route('vendor.teachers.invite') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Contoh: Pak Eko Prasetyo" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Alamat Email</label>
                        <input type="email" name="email" required placeholder="Contoh: eko@ruangbelajar.com" class="w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="flex gap-3 pt-3 border-t border-gray-100 dark:border-slate-700/50">
                        <button type="button" @click="showInviteModal = false" class="w-1/2 py-2.5 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 font-semibold rounded-xl text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition">Batal</button>
                        <button type="submit" class="w-1/2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition shadow">Kirim Undangan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
