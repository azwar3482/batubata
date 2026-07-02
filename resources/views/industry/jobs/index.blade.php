<x-app-layout>
    <div class="py-12" x-data="{ showVerifyModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Daftar Lowongan Kerja') }}
                </h2>
                @if($isVerified)
                <a href="{{ route('industry.jobs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    + {{ __('messages.add_job_vacancy') }}
                </a>
                @else
                <button @click="showVerifyModal = true" class="bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                    + {{ __('messages.add_job_vacancy') }}
                </button>
                @endif
            </div>

            <!-- Modal Verifikasi Perusahaan -->
            <div x-show="showVerifyModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-amber-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">{{ __('messages.complete_company_profile') }}</h3>
                            <p class="text-sm text-gray-500 text-center mb-4">{{ __('messages.company_must_be_verified') }}</p>
                            
                            @if($company)
                            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">{{ __('messages.document_status') }}</h4>
                                <div class="space-y-2">
                                    @php
                                        $docs = [
                                            ['key' => 'nib', 'name' => 'NIB (Nomor Induk Berusaha)', 'path' => $company->nib_document ?? null],
                                            ['key' => 'siup', 'name' => 'SIUP', 'path' => $company->siup_document ?? null],
                                            ['key' => 'npwp', 'name' => 'NPWP Perusahaan', 'path' => $company->npwp_document ?? null],
                                            ['key' => 'ktp_director', 'name' => 'KTP Direktur', 'path' => $company->ktp_director_document ?? null],
                                        ];
                                    @endphp
                                    @foreach($docs as $doc)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">{{ $doc['name'] }}</span>
                                        @if($doc['path'])
                                            @php $status = $company->getDocumentStatus($doc['key']); @endphp
                                            @if($status === 'approved')
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">{{ __('messages.approved') }}</span>
                                            @elseif($status === 'rejected')
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">{{ __('messages.rejected') }}</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">{{ __('messages.pending') }}</span>
                                            @endif
                                        @else
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-xs font-semibold rounded-full">{{ __('messages.not_uploaded') }}</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-amber-800">{{ __('messages.company_profile_not_created') }}</p>
                                        <p class="text-sm text-amber-700 mt-1">{{ __('messages.create_company_profile_first') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(!$hasDocuments)
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">{{ __('messages.next_steps') }}</p>
                                        <ol class="text-sm text-blue-700 mt-1 list-decimal list-inside space-y-1">
                                            <li>{{ __('messages.upload_legal_documents') }}</li>
                                            <li>{{ __('messages.wait_for_admin_verification') }}</li>
                                            <li>{{ __('messages.after_approved_can_create') }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                            <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                {{ __('messages.complete_profile') }}
                            </a>
                            <button @click="showVerifyModal = false" type="button" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                                {{ __('messages.close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-100 dark:border-blue-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">{{ __('messages.about_job_listings') }}</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed">Kelola semua lowongan kerja yang diposting perusahaan Anda. Setiap lowongan akan <strong>otomatis dicocokkan</strong> dengan kandidat berdasarkan <strong>skor kecocokan AI</strong>. Anda dapat melihat <strong>jumlah pelamar</strong>, <strong>filter berdasarkan status</strong>, dan <strong>mengunduh laporan</strong> performa lowongan.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <div class="mb-6 flex justify-between items-center">
                        <form action="{{ route('industry.jobs.index') }}" method="GET" class="flex w-full md:w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari posisi, perusahaan, atau lokasi..." class="w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-md transition border border-transparent">{{ __('messages.search') }}</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.vacancy') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi & Pengalaman</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe & Gaji</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($jobs as $job)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $job->title }}
                                            @if($job->position)
                                                <span class="ml-1 px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-xs font-semibold whitespace-nowrap">{{ $job->position->name }}</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $job->company_name ?? 'Perusahaan' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $job->location }}</div>
                                        <div class="text-sm text-gray-500">{{ $job->experience_level ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white capitalize">{{ $job->work_type }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $job->salary_min ? 'Rp ' . number_format($job->salary_min, 0, ',', '.') : 'Rahasia' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                        $expires = \Carbon\Carbon::parse($job->expires_date ?? now()->addDays(30));
                                        $isExpired = $expires->isPast() || !$job->is_active;
                                        @endphp
                                        @if ($isExpired)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ __('messages.expired') }}</span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ __('messages.active') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('industry.jobs.report', $job->id) }}" class="p-2 text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 rounded-lg transition-colors" title="Download Laporan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('industry.jobs.show', $job->id) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('industry.jobs.edit', $job->id) }}" class="p-2 text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            @if($isExpired)
                                            <form action="{{ route('industry.jobs.destroy', $job->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        {{ __('messages.no_vacancies_posted') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $jobs->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
