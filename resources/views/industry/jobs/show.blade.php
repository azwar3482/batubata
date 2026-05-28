<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-2 flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Detail Lowongan: ') }} {{ $job->title }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('industry.jobs.report', $job->id) }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Laporan
                    </a>
                    <a href="{{ route('industry.jobs.edit', $job->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                        Edit Lowongan
                    </a>
                    <a href="{{ route('industry.jobs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                        Kembali
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($job->banner_image)
                    <div class="w-full h-64 overflow-hidden bg-gray-100 flex items-center justify-center">
                        <img src="{{ Storage::url($job->banner_image) }}" alt="Banner Lowongan" class="w-full h-full object-cover">
                    </div>
                @endif
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $job->title }}</h3>
                            <p class="text-lg text-gray-600 mb-4">{{ $job->company_name }} &bull; {{ $job->location }}</p>
                            
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium capitalize">{{ $job->work_type }}</span>
                                @if($job->salary_min || $job->salary_max)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        Rp {{ number_format($job->salary_min ?? 0) }} - Rp {{ number_format($job->salary_max ?? 0) }}
                                    </span>
                                @endif
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">{{ $job->experience_required }}</span>
                                @php
                                    $expires = \Carbon\Carbon::parse($job->expires_date ?? now()->addDays(30));
                                    $isExpired = $expires->isPast() || !$job->is_active;
                                @endphp
                                @if ($isExpired)
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Berakhir</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Aktif</span>
                                @endif
                            </div>

                            <h4 class="font-bold text-gray-900 mb-2">Deskripsi Pekerjaan</h4>
                            <p class="text-gray-700 whitespace-pre-line mb-6">{{ $job->description }}</p>

                            <h4 class="font-bold text-gray-900 mb-2">Keahlian (Skills) yang Dibutuhkan</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($job->required_skills as $skill)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-4">Pengaturan Penilaian AI</h4>
                            @if($job->use_custom_weight)
                                <ul class="space-y-3 text-sm text-gray-700">
                                    <li class="flex justify-between border-b border-gray-200 pb-2"><span>CV / Resume:</span> <span class="font-medium">{{ $job->cv_weight }}%</span></li>
                                    <li class="flex justify-between border-b border-gray-200 pb-2"><span>Ijazah:</span> <span class="font-medium">{{ $job->ijazah_weight }}%</span></li>
                                    <li class="flex justify-between border-b border-gray-200 pb-2"><span>Transkrip Nilai:</span> <span class="font-medium">{{ $job->transkrip_weight }}%</span></li>
                                    <li class="flex justify-between border-b border-gray-200 pb-2"><span>Sertifikat:</span> <span class="font-medium">{{ $job->sertifikat_weight }}%</span></li>
                                    <li class="flex justify-between"><span>Portofolio:</span> <span class="font-medium">{{ $job->portofolio_weight }}%</span></li>
                                </ul>
                            @else
                                <div class="bg-blue-50 text-blue-700 p-4 rounded-md">
                                    <p class="font-medium">Menggunakan Bobot Standar Perusahaan</p>
                                    <p class="text-sm mt-1">Bobot ini mengikuti pengaturan default yang telah Anda buat di profil perusahaan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Pelamar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Daftar Pelamar</h3>

                    <!-- Filter Tabs Pelamar -->
                    <div class="flex flex-wrap items-center border-b border-gray-200 mb-6 gap-1">
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
                                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <span>{{ $item['label'] }}</span>
                                <span class="px-2 py-0.5 text-xs rounded-full transition-all duration-200
                                {{ $isActive 
                                   ? 'bg-blue-100 text-blue-700' 
                                   : 'bg-gray-100 text-gray-600' }}">
                                    {{ $item['count'] }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    @if(isset($applicants) && $applicants->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelamar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecocokan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Melamar</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($applicants as $app)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                                        {{ strtoupper(substr($app->user->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $app->user->name ?? 'Unknown' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $app->user->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $app->matching_percentage ?? 0 }}%</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $app->status === 'applied' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $app->status === 'reviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $app->status === 'interviewed' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $app->status === 'offered' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $app->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('industry.candidates.show', ['id' => $app->user_id, 'job_id' => $job->id]) }}" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p>Tidak ada pelamar dalam kategori status ini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
