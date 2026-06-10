<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Cari Kandidat</h2>
                <p class="mt-2 text-gray-600">Temukan talenta yang sesuai dengan kebutuhan perusahaan Anda.</p>
            </div>

            <!-- Info Card -->
            <div class="mb-6 p-5 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-100 dark:border-emerald-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-emerald-900 dark:text-emerald-200 mb-1">Tentang Pencarian Kandidat</h4>
                        <p class="text-sm text-emerald-700 dark:text-emerald-300 leading-relaxed">Cari kandidat berdasarkan <strong>skill</strong> dan <strong>posisi</strong> yang dibutuhkan. Sistem akan menampilkan kandidat dengan <strong>skor kecocokan tertinggi</strong> berdasarkan hasil asesmen mereka. Anda dapat melihat <strong>profil lengkap</strong>, <strong>skill gap analysis</strong>, dan <strong>riwayat karir</strong> setiap kandidat.</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <form action="{{ route('industry.candidates') }}" method="GET" class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-350 mb-1">Cari Kandidat</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau ID..."
                            class="w-full border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-gray-950 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-350 mb-1">Cari Berdasarkan Skill</label>
                        <input type="text" name="skill" value="{{ request('skill') }}" placeholder="Contoh: Python, SEO, Excel..."
                            class="w-full border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-gray-950 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-350 mb-1">Posisi</label>
                        <select name="position"
                            class="w-full border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-gray-950 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">Semua Posisi</option>
                            @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ request('position') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition shadow-sm h-[38px] flex items-center justify-center">
                            🔍 Cari
                        </button>
                        @if(request('search') || request('skill') || request('position'))
                        <a href="{{ route('industry.candidates') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-650 text-gray-700 dark:text-white rounded-lg font-semibold text-sm transition text-center flex items-center justify-center h-[38px]">
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Candidate List -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
                <!-- Toolbar for Table Actions -->
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">Hasil Pencarian</h3>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-500 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 dark:hover:bg-emerald-600 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Data (CSV)
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-16 text-center">No</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kandidat</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Keahlian</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Kecocokan</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-750">
                            @forelse($candidates as $index => $application)
                            @php
                            $user = $application->user;
                            $initials = strtoupper(substr($user->name ?? 'U', 0, 1));
                            $match = round($application->matching_percentage ?? 0);
                            $matchColor = $match >= 80 ? 'emerald' : ($match >= 60 ? 'yellow' : 'orange');
                            $latestAssessment = $user->assessments->sortByDesc('assessment_date')->first();
                            $skills = $latestAssessment ? $latestAssessment->scores->take(3)->pluck('competency.name') : collect();
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-750/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-500 dark:text-slate-400">{{ $candidates->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $user->name }}</span>
                                                <span class="text-xs text-slate-400 font-medium">(ID: {{ $user->id }})</span>
                                                @if(isset($application->has_applied) && !$application->has_applied)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50">Rekomendasi</span>
                                                @else
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-400 border border-blue-100 dark:border-blue-900/50">Melamar</span>
                                                @endif
                                            </div>
                                            <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-0.5">{{ $user->email }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $user->education_level ?? '-' }} {{ $user->major ?? '' }} • {{ $user->experience_years ?? 0 }} Thn Pengalaman</div>
                                            @if(isset($application->jobListing))
                                            <div class="text-[11px] mt-0.5">
                                                @if(isset($application->has_applied) && !$application->has_applied)
                                                <span class="text-slate-500 dark:text-slate-400">Cocok posisi: </span>
                                                <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $application->jobListing->title }}</span>
                                                @else
                                                <span class="text-slate-500 dark:text-slate-400">Melamar posisi: </span>
                                                <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $application->jobListing->title }}</span>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($skills as $skill)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-sm font-bold text-{{ $matchColor }}-600 dark:text-{{ $matchColor }}-400">{{ $match }}%</span>
                                        <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
                                            <div class="h-full bg-{{ $matchColor }}-500 rounded-full" style="width: {{ $match }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('industry.candidates.show', ['id' => $user->id, 'job_id' => $application->jobListing?->id]) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 transition-colors">
                                        Lihat Profil
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500 dark:text-slate-400">
                                    Belum ada kandidat yang melamar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                        <span>Menampilkan {{ $candidates->firstItem() ?? 0 }} sampai {{ $candidates->lastItem() ?? 0 }} dari {{ $candidates->total() }} kandidat</span>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <div class="flex justify-center">
                    {{ $candidates->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>