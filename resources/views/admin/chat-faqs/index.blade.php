<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 sm:p-8 mb-8 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-white/10 rounded-xl shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-1">Kelola FAQ Chat Agent</h1>
                <p class="text-blue-100 text-sm sm:text-base">Kelola pertanyaan dan jawaban umum untuk membantu *chat agent* melayani pengguna lebih cepat dan akurat.</p>
            </div>
        </div>
        <a href="{{ route('admin.chat-faqs.create') }}" class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-sm shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah FAQ Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan atau jawaban..." class="flex-1 border rounded-lg px-3 py-2">
        <select name="category" class="border rounded-lg px-3 py-2">
            <option value="">Semua Kategori</option>
            <option value="umum" {{ request('category') === 'umum' ? 'selected' : '' }}>Umum</option>
            <option value="job_seeker" {{ request('category') === 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
            <option value="industry" {{ request('category') === 'industry' ? 'selected' : '' }}>Industry</option>
            <option value="education" {{ request('category') === 'education' ? 'selected' : '' }}>Education</option>
            <option value="tpa" {{ request('category') === 'tpa' ? 'selected' : '' }}>TPA</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Filter</button>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600 w-16">No</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Pertanyaan</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Role</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Prioritas</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($faqs as $faq)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-center text-sm text-gray-600">
                        {{ ($faqs->currentPage() - 1) * $faqs->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-800">{{ Str::limit($faq->question, 80) }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($faq->answer, 100) }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $faq->category ?? 'umum' }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($faq->roles)
                            @foreach($faq->roles as $role)
                            <span class="px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px]">{{ $role }}</span>
                            @endforeach
                        @else
                        <span class="text-xs text-gray-400">Semua</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-sm">{{ $faq->priority }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($faq->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Aktif</span>
                        @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.chat-faqs.edit', $faq) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.chat-faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                        Belum ada FAQ. Klik "Tambah FAQ" untuk menambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $faqs->appends(request()->query())->links() }}</div>
</div>
</x-app-layout>
