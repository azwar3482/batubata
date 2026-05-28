<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header & Filter -->
            <div class="mb-8">
                <div class="mb-4">
                    <h2 class="text-3xl font-extrabold text-gray-900">1Lowongan Kerja</h2>
                    <p class="mt-1 text-gray-600">Ditemukan {{ $jobs->total() ?? count($jobs) }} lowongan yang cocok dengan profil Anda.</p>
                </div>

                <form method="GET" action="{{ route('seeker.jobs.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Lowongan</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Posisi, Perusahaan, atau Lokasi" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select name="sort" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="this.form.submit()">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="kecocokan" {{ request('sort', 'kecocokan') == 'kecocokan' ? 'selected' : '' }}>Kecocokan Tertinggi</option>
                            <option value="gaji" {{ request('sort') == 'gaji' ? 'selected' : '' }}>Gaji Tertinggi</option>
                        </select>
                    </div>
                    <div class="w-full md:w-32">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                        <select name="per_page" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 baris</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
                            <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>Semua Data</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium text-sm transition">
                        Terapkan
                    </button>
                </form>
            </div>

            <!-- Tabel Lowongan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lowongan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kecocokan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-4">
                                        @if($job->banner_image)
                                        <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0 hidden sm:block border border-gray-200">
                                            <img src="{{ Storage::url($job->banner_image) }}" alt="Banner" class="w-full h-full object-cover">
                                        </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('seeker.jobs.detail', $job->id) }}" class="text-base font-bold text-gray-900 hover:text-blue-600 transition">{{ $job->title }}</a>
                                            <p class="text-sm font-medium text-gray-700">{{ $job->company_name }}</p>
                                            <div class="mt-1 flex flex-wrap gap-2 items-center text-xs text-gray-500">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    {{ $job->location }}
                                                </span>
                                                <span>&bull;</span>
                                                <span class="capitalize">{{ $job->work_type }}</span>
                                                <span>&bull;</span>
                                                <span>{{ \Carbon\Carbon::parse($job->posted_date)->diffForHumans() }}</span>
                                            </div>
                                            <!-- Skill Tags (optional, just to show we kept data) -->
                                            <div class="mt-2 flex flex-wrap gap-1">
                                                @foreach (array_slice($job->required_skills ?? [], 0, 3) as $skill)
                                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded border border-gray-200">
                                                    {{ $skill }}
                                                </span>
                                                @endforeach
                                                @if (count($job->required_skills ?? []) > 3)
                                                <span class="px-2 py-0.5 bg-gray-50 text-gray-400 text-[10px] rounded">+{{ count($job->required_skills) - 3 }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">
                                        {{ $job->salary_min ? 'Rp ' . number_format($job->salary_min, 0, ',', '.') : 'Rahasia' }}
                                    </div>
                                    @if($job->salary_max)
                                    <div class="text-xs text-gray-500 mt-1">
                                        Hingga Rp {{ number_format($job->salary_max, 0, ',', '.') }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-xl font-extrabold text-blue-600">{{ $job->matching_percentage }}%</div>
                                    @if ($job->matching_percentage >= 80)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-800">Sangat Cocok</span>
                                    @elseif($job->matching_percentage >= 50)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800">Cukup Cocok</span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800">Perlu Upskill</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('seeker.jobs.detail', $job->id) }}" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 hover:bg-blue-50 text-xs font-medium rounded-md transition">
                                            Detail
                                        </a>
                                        @if(!$job->user_status || $job->user_status === 'saved')
                                        <form action="{{ route('seeker.jobs.save', $job->id) }}" method="POST" class="inline">
                                            @csrf
                                            @if($job->user_status === 'saved')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-yellow-300 bg-yellow-50 text-yellow-800 hover:bg-yellow-100 text-xs font-semibold rounded-md transition shadow-xs" title="Batal Simpan">
                                                <svg class="w-3.5 h-3.5 mr-1 text-yellow-600 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                </svg>
                                                Tersimpan
                                            </button>
                                            @else
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-gray-700 hover:bg-gray-50 text-xs font-medium rounded-md transition shadow-xs" title="Simpan Lowongan">
                                                <svg class="w-3.5 h-3.5 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                                Simpan
                                            </button>
                                            @endif
                                        </form>
                                        <form action="{{ route('seeker.jobs.apply', $job->id) }}" method="POST" class="inline" x-data @submit.prevent="if({{ $job->matching_percentage ?? 0 }} < -5) { $dispatch('open-low-match-modal'); } else { $el.submit(); }">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white hover:bg-blue-700 text-xs font-semibold rounded-md shadow-sm transition">
                                                Lamar Sekarang
                                            </button>
                                        </form>
                                        @else
                                        @if(in_array($job->user_status, ['applied', 'reviewed', 'interviewed']))
                                        <button disabled class="inline-flex items-center px-3 py-1.5 bg-gray-50 border border-gray-200 text-gray-400 text-xs font-medium rounded-md cursor-not-allowed">
                                            <svg class="w-3.5 h-3.5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Sudah Melamar
                                        </button>
                                        @elseif($job->user_status === 'offered')
                                        <button disabled class="inline-flex items-center px-3 py-1.5 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold rounded-md cursor-not-allowed animate-pulse">
                                            Diterima 🎉
                                        </button>
                                        @elseif($job->user_status === 'rejected')
                                        <button disabled class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 text-red-700 text-xs font-medium rounded-md cursor-not-allowed">
                                            Ditolak
                                        </button>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center bg-white rounded-b-xl">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada lowongan</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada lowongan yang sesuai kriteria pencarian Anda.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('seeker.assessment.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            Lakukan Asesmen Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $jobs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- Low Match Modal -->
    <div x-data="{ open: false }"
        @open-low-match-modal.window="open = true"
        x-show="open"
        style="display: none;"
        class="fixed inset-0 z-[100] overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="open = false"
                aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Kecocokan Belum Memenuhi Syarat
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Silahkan lakukan asesmen kompetensi untuk meningkatkan peluang Anda. Minimal kecocokan yang disarankan adalah 75%.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <a href="{{ url('/seeker/assessment') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Asesmen
                    </a>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Batal Melamar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>