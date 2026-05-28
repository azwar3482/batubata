<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Kelola Pengguna</h2>
                    <p class="mt-2 text-gray-600">Manajemen semua pengguna platform KOMPASKARIR.</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengguna
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Total User</div>
                    <div class="text-2xl font-bold">{{ number_format($stats['total'] ?? 0) }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Job Seeker</div>
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['job_seeker'] ?? 0) }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Industry</div>
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($stats['industry'] ?? 0) }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Education</div>
                    <div class="text-2xl font-bold text-green-600">{{ number_format($stats['education'] ?? 0) }}</div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Pengguna</h3>
                    <form action="{{ route('admin.users') }}" method="GET" class="flex gap-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau email..."
                                class="pl-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <select name="role" onchange="this.form.submit()"
                            class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
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
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-10">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Pelamar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">
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
                                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->isAdmin()
                                                ? 'bg-gray-800 text-white'
                                                : ($user->isIndustry()
                                                    ? 'bg-purple-100 text-purple-800'
                                                    : ($user->isEducation()
                                                        ? 'bg-green-100 text-green-800'
                                                        : 'bg-blue-100 text-blue-800')) }}">
                                            {{ str_replace('_', ' ', ucwords($user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
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
                <div class="p-6 border-t border-gray-200">
                    {{ $users->links() ?? '' }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
