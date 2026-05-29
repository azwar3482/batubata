<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Dashboard Industri</h2>
                    <p class="mt-2 text-gray-600 dark:text-slate-400">
                        Kelola lowongan kerja, temukan kandidat berkualitas, dan pantau proses rekrutmen Anda.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('industry.candidates') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Kandidat
                    </a>
                    <a href="{{ route('industry.jobs.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Posting Lowongan Baru
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Total Lowongan Aktif -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition cursor-pointer"
                    onclick="window.location='{{ route('industry.jobs.create') }}'">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Lowongan Aktif</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalJobs ?? 0 }}</p>
                            <p class="text-sm text-green-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                +3 minggu ini
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pelamar -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Pelamar</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalApplicants ?? 0 }}</p>
                            <p class="text-sm text-gray-500 mt-1">dari semua lowongan</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Kandidat Match Tinggi -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Match &gt; 80%</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $highMatchCandidates ?? 0 }}</p>
                            <p class="text-sm text-purple-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                                Kandidat berkualitas
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Waktu Rekrutmen -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Waktu Rekrutmen</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $avgHiringDays ?? 14 }} Hari</p>
                            <p class="text-sm text-gray-500 mt-1">rata-rata dari posting ke hire</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

                <!-- Left Column: Recent Jobs & Actions -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Recent Job Postings -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h3 class="text-lg font-bold text-gray-900">Lowongan Terbaru</h3>
                            <div class="flex gap-2">
                                <a href="{{ route('industry.jobs.create') }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    + Tambah Lowongan
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('industry.jobs.index') }}" class="text-sm text-gray-600 hover:text-gray-800">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Posisi</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Lokasi</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelamar</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentJobs ?? [] as $job)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $job->title }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $job->experience_required }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <span class="inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                                {{ $job->location }}
                                            </span>
                                            <span
                                                class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $job->work_type == 'remote' ? 'bg-green-100 text-green-700' : ($job->work_type == 'hybrid' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                                {{ ucfirst($job->work_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {{ $job->applications_count ?? rand(5, 50) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                            $expires = \Carbon\Carbon::parse(
                                            $job->expires_date ?? now()->addDays(30),
                                            );
                                            $isExpired = $expires->isPast() || !$job->is_active;
                                            $isSoon = $expires->diffInDays(now()) <= 7 && !$isExpired;
                                                @endphp
                                                @if ($isExpired)
                                                <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Berakhir
                                                </span>
                                                @elseif($isSoon)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Segera Berakhir
                                                </span>
                                                @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                                @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('industry.jobs.show', $job->id) }}" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('industry.jobs.edit', $job->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Lowongan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p class="mt-2 text-gray-500">Belum ada lowongan aktif</p>
                                            <a href="{{ route('industry.jobs.create') }}"
                                                class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium">Posting
                                                Lowongan Pertama</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recruitment Analytics Chart -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md p-6 border border-transparent dark:border-slate-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Analitik Rekrutmen</h3>
                            <select
                                class="text-sm border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option>30 Hari Terakhir</option>
                                <option>90 Hari Terakhir</option>
                                <option>Tahun Ini</option>
                            </select>
                        </div>
                        <div class="h-64">
                            <canvas id="recruitmentChart"></canvas>
                        </div>
                        <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">85%</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Resume Screened</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">42%</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Interview Completed</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">18%</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">Offer Accepted</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Stats & Candidates -->
                <div class="space-y-8">

                    <!-- Quick Actions Card -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
                        <h3 class="text-lg font-bold mb-4">⚡ Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('industry.jobs.create') }}"
                                class="flex items-center p-3 bg-white/10 rounded-lg hover:bg-white/20 transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-sm font-medium">Posting Lowongan Baru</span>
                            </a>
                            <a href="{{ route('industry.candidates') }}"
                                class="flex items-center p-3 bg-white/10 rounded-lg hover:bg-white/20 transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="text-sm font-medium">Cari Kandidat Berdasarkan Skill</span>
                            </a>
                            <a href="{{ route('industry.dashboard.report') }}"
                                class="flex items-center p-3 bg-white/10 rounded-lg hover:bg-white/20 transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Download Laporan Rekrutmen</span>
                            </a>
                            <a href="{{ route('industry.team') }}"
                                class="flex items-center p-3 bg-white/10 rounded-lg hover:bg-white/20 transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Kelola Tim Rekrutmen</span>
                            </a>
                        </div>
                    </div>

                    <!-- Top Matching Candidates -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Kandidat Match Tinggi</h3>
                            <p class="text-xs text-gray-500 mt-1">Berdasarkan lowongan aktif Anda</p>
                        </div>
                        <div class="divide-y divide-gray-200">

                            <!-- Candidate 1 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        BS
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 truncate">Budi Santoso</p>
                                            <span
                                                class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">
                                                92%
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">Digital Marketing Specialist</p>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            <span
                                                class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded">SEO</span>
                                            <span
                                                class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded">Analytics</span>
                                            <span
                                                class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded">Content</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <button
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-50 transition">
                                        Lihat Profil
                                    </button>
                                    <button
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                                        Hubungi
                                    </button>
                                </div>
                            </div>

                            <!-- Candidate 2 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        AS
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 truncate">Andi Saputra</p>
                                            <span
                                                class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">
                                                87%
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">Data Analyst</p>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            <span
                                                class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded">Python</span>
                                            <span
                                                class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded">SQL</span>
                                            <span
                                                class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded">Tableau</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <button
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-50 transition">
                                        Lihat Profil
                                    </button>
                                    <button
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                                        Hubungi
                                    </button>
                                </div>
                            </div>

                            <!-- Candidate 3 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        DP
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 truncate">Dewi Putri</p>
                                            <span
                                                class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">
                                                78%
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">Content Marketing</p>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            <span
                                                class="px-2 py-0.5 bg-green-50 text-green-700 text-xs rounded">Copywriting</span>
                                            <span class="px-2 py-0.5 bg-green-50 text-green-700 text-xs rounded">Social
                                                Media</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <button
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-50 transition">
                                        Lihat Profil
                                    </button>
                                    <button
                                        class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                                        Hubungi
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="p-4 border-t border-gray-200 bg-gray-50 text-center">
                            <a href="{{ route('industry.candidates') }}"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua Kandidat →
                            </a>
                        </div>
                    </div>

                    <!-- Company Profile Summary -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Profil Perusahaan</h3>
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                {{ substr(Auth::user()->company->name ?? 'Company', 0, 2) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ Auth::user()->company->name ?? 'Nama Perusahaan' }}
                                </p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->company->industry ?? 'Industri' }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Ukuran Perusahaan</span>
                                <span class="font-medium">{{ Auth::user()->company->size ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Website</span>
                                <a href="{{ Auth::user()->company->website ?? '#' }}" target="_blank"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ parse_url(Auth::user()->company->website ?? 'https://example.com', PHP_URL_HOST) }}
                                </a>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Lowongan Aktif</span>
                                <span class="font-medium text-blue-600">{{ $totalJobs ?? 0 }}</span>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="mt-4 block w-full text-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Edit Profil Perusahaan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Job Posting Tips Banner -->
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-amber-900 dark:text-amber-300">💡 Tips Posting Lowongan yang Efektif</h4>
                        <p class="text-sm text-amber-800 dark:text-amber-400/80 mt-1">
                            Sebutkan skill spesifik yang dibutuhkan, gunakan kata kunci yang relevan, dan cantumkan
                            benefit menarik untuk menarik kandidat berkualitas.
                        </p>
                    </div>
                    <a href="{{ route('industry.guide') }}"
                        class="px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 transition whitespace-nowrap inline-flex items-center">
                        Baca Panduan Lengkap
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<!-- Chart.js Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('recruitmentChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                        label: 'Pelamar Baru',
                        data: [12, 28, 19, 35],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Interview',
                        data: [3, 8, 5, 12],
                        borderColor: 'rgb(147, 51, 234)',
                        backgroundColor: 'rgba(147, 51, 234, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Diterima',
                        data: [1, 2, 1, 4],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1f2937',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Dynamic Dark Mode for Chart.js
        function updateChartColors(chart, isDark) {
            const textColor = isDark ? '#ffffff' : '#6b7280'; // white vs gray-500
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
            const tooltipBg = isDark ? 'rgba(31, 41, 55, 0.95)' : 'rgba(255, 255, 255, 0.95)';
            const tooltipText = isDark ? '#f9fafb' : '#1f2937';

            chart.options.plugins.legend.labels.color = textColor;
            chart.options.plugins.tooltip.backgroundColor = tooltipBg;
            chart.options.plugins.tooltip.titleColor = tooltipText;
            chart.options.plugins.tooltip.bodyColor = tooltipText;

            if (chart.options.scales.x) {
                chart.options.scales.x.ticks.color = textColor;
                if (!chart.options.scales.x.grid) chart.options.scales.x.grid = {};
                chart.options.scales.x.grid.color = gridColor;
            }
            if (chart.options.scales.y) {
                chart.options.scales.y.ticks.color = textColor;
                if (!chart.options.scales.y.grid) chart.options.scales.y.grid = {};
                chart.options.scales.y.grid.color = gridColor;
            }
            chart.update();
        }

        // Initial check
        const isDark = document.documentElement.classList.contains('dark');
        updateChartColors(chart, isDark);

        // Observer for class changes on html tag
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isDarkNow = document.documentElement.classList.contains('dark');
                    updateChartColors(chart, isDarkNow);
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true
        });
    });
</script>

<!-- Helper Function for URL parsing (optional, can be moved to helper file) -->
@php
if (!function_exists('parse_url')) {
function parse_url_helper($url, $component)
{
$parsed = parse_url($url);
return $parsed[$component] ?? $url;
}
}
@endphp

<!-- Driver.js for Tour -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const driver = window.driver.js.driver;
        const tourConfig = {
            showProgress: true,
            nextBtnText: 'Lanjut ➔',
            prevBtnText: '⬅ Kembali',
            doneBtnText: 'Selesai',
            popoverClass: 'driverjs-theme',
            steps: [
                {
                    popover: {
                        title: '👋 Selamat Datang di Panel Industri',
                        description: 'Mari kita kenali berbagai fitur di dashboard ini yang akan membantu Anda menemukan talenta terbaik.',
                        align: 'center'
                    }
                },
                {
                    element: 'header',
                    popover: {
                        title: '🌐 Top Navbar',
                        description: 'Di menu atas ini Anda bisa mengubah bahasa (ID/EN), mengaktifkan Dark Mode, melihat notifikasi, mengakses profil, dan Log Out.',
                        side: "bottom",
                        align: 'center'
                    }
                },
                {
                    element: 'a[href*="industry/dashboard"]',
                    popover: {
                        title: '📊 Dashboard',
                        description: 'Menu ini membawa Anda kembali ke halaman ini untuk melihat ringkasan statistik rekrutmen perusahaan Anda.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'a[href*="industry/jobs"]',
                    popover: {
                        title: '📢 Pasang Lowongan',
                        description: 'Gunakan menu ini untuk mempublikasikan lowongan kerja baru, mengatur detail pekerjaan, dan melihat lowongan yang sedang aktif.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'a[href*="industry/candidates"]',
                    popover: {
                        title: '🔍 Cari Kandidat',
                        description: 'Ingin mencari talent secara proaktif? Menu ini memungkinkan Anda mencari dan memfilter kandidat berdasarkan skill dan fit score.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'a[href*="industry/team"]',
                    popover: {
                        title: '👥 Kelola Tim',
                        description: 'Tambahkan atau atur hak akses staf HRD lainnya dalam mengelola lowongan dan rekrutmen perusahaan Anda di sini.',
                        side: "right",
                        align: 'start'
                    }
                }
            ]
        };

        const startTourBtn = document.getElementById('start-tour-btn');
        if (startTourBtn) {
            startTourBtn.addEventListener('click', () => {
                driver(tourConfig).drive();
            });
        }

        // Auto play saat halaman terbuka
        const autoDriver = driver(tourConfig);
        autoDriver.drive();
    });
</script>
<style>
    /* Driver.js Custom Styling */
    .driverjs-theme {
        font-family: inherit;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
    .driver-popover-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937; /* text-gray-900 */
    }
    .driver-popover-description {
        font-size: 13.5px;
        line-height: 1.5;
        color: #4b5563; /* text-gray-600 */
    }
    .driver-popover-footer {
        margin-top: 12px;
    }
    .driver-popover-progress-text {
        font-size: 12px;
        color: #6b7280;
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        html.dark .driverjs-theme {
            background-color: #1e293b; /* bg-slate-800 */
            color: #e2e8f0;
        }
        html.dark .driver-popover-title {
            color: #f8fafc;
        }
        html.dark .driver-popover-description {
            color: #cbd5e1; /* text-slate-300 */
        }
        html.dark .driver-popover-progress-text {
            color: #94a3b8;
        }
        html.dark .driver-popover-footer .driver-popover-btn {
            background-color: #334155;
            color: #f8fafc;
            border: 1px solid #475569;
            text-shadow: none;
        }
        html.dark .driver-popover-footer .driver-popover-btn:hover {
            background-color: #475569;
        }
        html.dark .driver-popover-arrow {
            border-color: #1e293b;
        }
    }
</style>