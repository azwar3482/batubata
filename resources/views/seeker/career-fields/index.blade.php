<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Card --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 sm:p-8 mb-8 text-white shadow-lg flex items-start gap-4">
        <div class="p-3 bg-white/10 rounded-xl shrink-0">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold mb-1">Roadmap Jurusan & Bidang Pekerjaan</h1>
            <p class="text-indigo-100 text-sm sm:text-base">Jelajahi jalur karir untuk berbagai bidang pekerjaan, persiapkan skill, dan lihat proyeksi gaji di setiap level karir Anda.</p>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bidang karir, posisi, atau industri..." class="flex-1 border rounded-lg px-3 py-2">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('seeker.career-fields.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Reset</a>
        @endif
    </form>

    {{-- Info --}}
    <div class="flex items-center justify-between mb-3">
        <p class="text-sm text-gray-500">Menampilkan {{ $fields->count() }} dari {{ $fields->total() }} bidang karir</p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px]">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-12">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-48">Bidang</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-20">Level</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-32">Permintaan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-48">Contoh Posisi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-36">Industri</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-28">Gaji</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($fields as $i => $field)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- No --}}
                        <td class="px-4 py-4 text-center text-sm text-gray-500">
                            {{ ($fields->currentPage() - 1) * $fields->perPage() + $i + 1 }}
                        </td>

                        {{-- Bidang --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-{{ $field->color }}-100 flex items-center justify-center text-lg flex-shrink-0">
                                    {{ $field->icon }}
                                </div>
                                <div class="font-semibold text-gray-900 text-sm">{{ $field->name }}</div>
                            </div>
                        </td>

                        {{-- Deskripsi --}}
                        <td class="px-4 py-4">
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $field->description }}</p>
                        </td>

                        {{-- Level --}}
                        <td class="px-4 py-4 text-center">
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                {{ $field->paths->count() }}
                            </span>
                        </td>

                        {{-- Permintaan --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-{{ $field->demand_color }}-500 transition-all"
                                         style="width: {{ $field->demand_score }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 w-8 text-right">{{ $field->demand_score }}%</span>
                            </div>
                        </td>

                        {{-- Contoh Posisi --}}
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($field->job_titles ?? [], 0, 2) as $title)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs whitespace-nowrap">{{ $title }}</span>
                                @endforeach
                                @if(count($field->job_titles ?? []) > 2)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-400 rounded text-xs">+{{ count($field->job_titles) - 2 }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Industri --}}
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($field->industries ?? [], 0, 2) as $industry)
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-xs whitespace-nowrap">{{ $industry }}</span>
                                @endforeach
                                @if(count($field->industries ?? []) > 2)
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-400 rounded text-xs">+{{ count($field->industries) - 2 }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Gaji --}}
                        <td class="px-4 py-4 text-center text-sm text-gray-600 whitespace-nowrap">
                            @if($field->avg_salary_min)
                            {{ number_format($field->avg_salary_min / 1000000, 0) }}-{{ number_format($field->avg_salary_max / 1000000, 0) }}jt
                            @else
                            -
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('seeker.career-fields.show', $field->slug) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-{{ $field->color }}-50 text-{{ $field->color }}-700 rounded-lg text-xs font-medium hover:bg-{{ $field->color }}-100 transition-colors whitespace-nowrap">
                                Roadmap
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">Tidak ada bidang karir ditemukan</p>
                                <p class="text-sm text-gray-400 mt-1">Coba ubah kata kunci pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginasi --}}
    @if($fields->hasPages())
    <div class="mt-6">
        {{ $fields->appends(request()->query())->links() }}
    </div>
    @endif
</div>
</x-app-layout>
