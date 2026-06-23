<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
                <a href="{{ route('industry.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('industry.jobs.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Lowongan</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 dark:text-white font-medium">Detail</span>
            </nav>

            <div class="mb-2 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                    {{ __('Detail Lowongan: ') }} {{ $job->title }}
                </h2>
                <div class="flex flex-wrap gap-2">
                    @if($job->is_active)
                    <a href="{{ route('industry.jobs.talent', $job->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Temukan Talenta
                    </a>
                    @endif
                    <a href="{{ route('industry.jobs.report', $job->id) }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Laporan
                    </a>
                    <a href="{{ route('industry.jobs.edit', $job->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                        Edit
                    </a>
                    <a href="{{ route('industry.jobs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Job Info Card -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-slate-700">
                @if($job->banner_image)
                <div class="w-full h-64 overflow-hidden bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                    <img src="{{ Storage::url($job->banner_image) }}" alt="Banner Lowongan" class="w-full h-full object-cover" loading="lazy">
                </div>
                @endif
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $job->title }}</h3>
                                @if($job->position)
                                <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 text-xs font-semibold whitespace-nowrap">{{ $job->position->name }}</span>
                                @endif
                            </div>
                            <p class="text-lg text-gray-600 dark:text-slate-400 mb-4">{{ $job->company_name }} &bull; {{ $job->location }}</p>

                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium capitalize">{{ $job->work_type }}</span>
                                @if($job->salary_min || $job->salary_max)
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm font-medium">
                                    Rp {{ number_format($job->salary_min ?? 0) }} - Rp {{ number_format($job->salary_max ?? 0) }}
                                </span>
                                @endif
                                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm font-medium">{{ $job->experience_required }}</span>
                                @php
                                $expires = \Carbon\Carbon::parse($job->expires_date ?? now()->addDays(30));
                                $isExpired = $expires->isPast() || !$job->is_active;
                                @endphp
                                @if ($isExpired)
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-sm font-medium">Berakhir</span>
                                @else
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm font-medium">Aktif</span>
                                @endif
                            </div>

                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Deskripsi Pekerjaan</h4>
                            <div class="text-gray-700 dark:text-slate-300 prose prose-sm max-w-none mb-6 whitespace-pre-line">{{ $job->description }}</div>

                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Keahlian (Skills) yang Dibutuhkan</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($job->required_skills as $skill)
                                <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-md text-sm">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-slate-900 p-6 rounded-lg border border-gray-200 dark:border-slate-700">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-4">Pengaturan Penilaian AI</h4>
                            @if($job->use_custom_weight)
                            <ul class="space-y-3 text-sm text-gray-700 dark:text-slate-300">
                                <li class="flex justify-between border-b border-gray-200 dark:border-slate-700 pb-2"><span>CV / Resume:</span> <span class="font-medium">{{ $job->cv_weight }}%</span></li>
                                <li class="flex justify-between border-b border-gray-200 dark:border-slate-700 pb-2"><span>Ijazah:</span> <span class="font-medium">{{ $job->ijazah_weight }}%</span></li>
                                <li class="flex justify-between border-b border-gray-200 dark:border-slate-700 pb-2"><span>Transkrip Nilai:</span> <span class="font-medium">{{ $job->transkrip_weight }}%</span></li>
                                <li class="flex justify-between border-b border-gray-200 dark:border-slate-700 pb-2"><span>Sertifikat:</span> <span class="font-medium">{{ $job->sertifikat_weight }}%</span></li>
                                <li class="flex justify-between"><span>Portofolio:</span> <span class="font-medium">{{ $job->portofolio_weight }}%</span></li>
                            </ul>
                            @else
                            <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 p-4 rounded-md">
                                <p class="font-medium">Menggunakan Bobot Standar Perusahaan</p>
                                <p class="text-sm mt-1">Bobot ini mengikuti pengaturan default yang telah Anda buat di profil perusahaan.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicants Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Pelamar</h3>
                        
                        <!-- Search Form -->
                        <form action="{{ route('industry.jobs.show', $job->id) }}" method="GET" class="flex gap-2">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari nama pelamar..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm w-64">
                                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Cari
                            </button>
                            @if(request('search'))
                            <a href="{{ route('industry.jobs.show', ['id' => $job->id, 'status' => $status]) }}" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition text-sm font-medium">
                                Reset
                            </a>
                            @endif
                        </form>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap items-center border-b border-gray-200 dark:border-slate-700 mb-6 gap-1">
                        @php
                        $activeStatus = $status ?? 'all';
                        $tabItems = [
                        'all' => ['label' => 'Semua', 'count' => $counts['all'] ?? 0],
                        'applied' => ['label' => 'Dikirim', 'count' => $counts['applied'] ?? 0],
                        'reviewed' => ['label' => 'Direview', 'count' => $counts['reviewed'] ?? 0],
                        'interviewed' => ['label' => 'Interview', 'count' => $counts['interviewed'] ?? 0],
                        'offered' => ['label' => 'Diterima', 'count' => $counts['offered'] ?? 0],
                        'rejected' => ['label' => 'Ditolak', 'count' => $counts['rejected'] ?? 0],
                        ];
                        @endphp

                        @foreach($tabItems as $key => $item)
                        @php
                        $isActive = $activeStatus === $key;
                        @endphp
                        <a href="{{ route('industry.jobs.show', ['id' => $job->id, 'status' => $key]) }}"
                            class="flex items-center gap-2 px-4 py-3 font-semibold text-sm border-b-2 transition-all duration-200 -mb-[2px]
                               {{ $isActive 
                                  ? 'border-blue-600 text-blue-600 font-bold' 
                                  : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600' }}">
                            <span>{{ $item['label'] }}</span>
                            <span class="px-2 py-0.5 text-xs rounded-full transition-all duration-200
                                {{ $isActive 
                                   ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' 
                                   : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400' }}">
                                {{ $item['count'] }}
                            </span>
                        </a>
                        @endforeach
                    </div>

                    @if(isset($applicants) && $applicants->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama Pelamar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kecocokan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tanggal Melamar</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach($applicants as $app)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        {{ ($applicants->currentPage() - 1) * $applicants->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                                                    {{ strtoupper(substr($app->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $app->user->name ?? 'Unknown' }}</div>
                                                <div class="text-sm text-gray-500 dark:text-slate-400">{{ $app->user->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $app->matching_percentage ?? 0 }}%</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $app->status === 'applied' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : '' }}
                                                {{ $app->status === 'reviewed' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300' : '' }}
                                                {{ $app->status === 'interviewed' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : '' }}
                                                {{ $app->status === 'offered' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : '' }}
                                                {{ $app->status === 'rejected' ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' : '' }}">
                                            @php
                                            $labels = [
                                            'applied' => 'Dikirim',
                                            'reviewed' => 'Direview',
                                            'interviewed' => 'Interview',
                                            'offered' => 'Diterima',
                                            'rejected' => 'Ditolak'
                                            ];
                                            @endphp
                                            {{ $labels[$app->status] ?? ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        {{ $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('industry.candidates.show', ['id' => $app->user_id, 'job_id' => $job->id]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($applicants->hasPages())
                    <div class="mt-4 px-4 py-3 border-t border-gray-200 dark:border-slate-700">
                        {{ $applicants->links() }}
                    </div>
                    @endif

                    @else
                    <div class="text-center py-12 text-gray-500 dark:text-slate-400">
                        @if(request('search'))
                            <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <p class="font-medium">Tidak ada pelamar yang sesuai dengan pencarian</p>
                            <p class="text-sm mt-1">Coba gunakan kata kunci yang berbeda atau <a href="{{ route('industry.jobs.show', ['id' => $job->id, 'status' => $status]) }}" class="text-blue-600 hover:underline">reset pencarian</a></p>
                        @else
                            <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p>Tidak ada pelamar dalam kategori status ini.</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
