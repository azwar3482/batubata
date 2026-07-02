<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Kelola Pengguna</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">Manajemen semua pengguna platform KOMPASKARIR.</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengguna
                </a>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 border border-violet-100 dark:border-violet-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-violet-100 dark:bg-violet-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-violet-900 dark:text-violet-200 mb-1">Tentang Kelola Pengguna</h4>
                        <p class="text-sm text-violet-700 dark:text-violet-300 leading-relaxed">Kelola semua pengguna platform KompasKarir. Anda dapat <strong>menambah pengguna baru</strong>, <strong>mengedit profil</strong>, <strong>mengubah role</strong> (Admin, Job Seeker, Industri, Pendidikan), dan <strong>menghapus akun</strong> yang tidak diperlukan.</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-indigo-500/10 dark:shadow-indigo-500/20 hover:shadow-xl hover:shadow-indigo-500/20 dark:hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 border-l-4 dark:border-slate-700"
                    style="border-left-color: #6366f1 !important;">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Total User</div>
                    <div class="text-2xl font-black text-gray-900 dark:text-white tracking-tight mt-1">{{ number_format($stats['total'] ?? 0) }}</div>
                </div>
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-blue-500/10 dark:shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/20 dark:hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 border-l-4 dark:border-slate-700"
                    style="border-left-color: #3b82f6 !important;">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Job Seeker</div>
                    <div class="text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight mt-1">{{ number_format($stats['job_seeker'] ?? 0) }}</div>
                </div>
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-purple-500/10 dark:shadow-purple-500/20 hover:shadow-xl hover:shadow-purple-500/20 dark:hover:shadow-purple-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 border-l-4 dark:border-slate-700"
                    style="border-left-color: #8b5cf6 !important;">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Industry</div>
                    <div class="text-2xl font-black text-purple-600 dark:text-purple-400 tracking-tight mt-1">{{ number_format($stats['industry'] ?? 0) }}</div>
                </div>
                <div class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg shadow-emerald-500/10 dark:shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/20 dark:hover:shadow-emerald-500/30 hover:-translate-y-1 transition-all duration-300 border border-gray-100 border-l-4 dark:border-slate-700"
                    style="border-left-color: #10b981 !important;">
                    <div class="text-gray-500 dark:text-slate-400 text-sm">Education</div>
                    <div class="text-2xl font-black text-green-600 dark:text-emerald-400 tracking-tight mt-1">{{ number_format($stats['education'] ?? 0) }}</div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md border border-transparent dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Pengguna</h3>
                    <form action="{{ route('admin.users') }}" method="GET" class="flex gap-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau email..."
                                class="pl-10 border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <select name="role" onchange="this.form.submit()"
                            class="border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">Semua Role</option>
                            <option value="job_seeker" {{ request('role') == 'job_seeker' ? 'selected' : '' }}>Job Seeker
                            </option>
                            <option value="industry" {{ request('role') == 'industry' ? 'selected' : '' }}>Industry
                            </option>
                            <option value="education" {{ request('role') == 'education' ? 'selected' : '' }}>Education
                            </option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @if (request()->has('search') || request()->has('role'))
                            <a href="{{ route('admin.users') }}"
                                class="p-2 text-gray-500 hover:text-gray-700 flex items-center" title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </form>

                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase w-10">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">ID Pelamar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Terdaftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                        {{ $loop->iteration + ($users->firstItem() - 1) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($user->isJobSeeker())
                                            <span class="text-xs font-bold px-2.5 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl border border-indigo-100 font-mono shadow-sm">
                                                USR-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 font-mono text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">

                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-slate-400">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->isAdmin()
                                                ? 'bg-gray-800 text-white dark:bg-slate-700 dark:text-slate-100'
                                                : ($user->isIndustry()
                                                    ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300'
                                                    : ($user->isEducation()
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
                                                        : 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300')) }}">
                                            {{ str_replace('_', ' ', ucwords($user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Aktif</span>
                                    </td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Hapus User">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                    {{ $users->links() ?? '' }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
