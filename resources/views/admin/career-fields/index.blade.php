<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 sm:p-8 mb-8 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-white/10 rounded-xl shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-1">Kelola Bidang Karir</h1>
                <p class="text-blue-100 text-sm sm:text-base">Kelola roadmap jurusan dan bidang pekerjaan untuk job seeker.</p>
            </div>
        </div>
        <a href="{{ route('admin.career-fields.create') }}" class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-sm shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Bidang Baru
        </a>
    </div>

    <!-- Info Card: Panduan Level Karir -->
    <div x-data="{ open: false }" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 mb-8 overflow-hidden">
        <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors focus:outline-none">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Panduan Konsep "Level" pada Roadmap Karir</h2>
            </div>
            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div x-show="open" x-collapse x-cloak class="px-6 py-6 border-t border-slate-200 dark:border-slate-700 text-sm text-slate-600 dark:text-slate-400">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Kiri: Penjelasan & Contoh -->
                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 text-base mb-2">Apa itu "Level"?</h3>
                        <p class="leading-relaxed">Level adalah jenjang karir yang menunjukkan tingkat pengalaman dan tanggung jawab dalam suatu bidang pekerjaan.</p>
                        <div class="mt-4 bg-slate-50 dark:bg-slate-900/50 p-5 rounded-xl border border-slate-100 dark:border-slate-700/60">
                            <p class="font-medium text-slate-800 dark:text-slate-300 mb-4">Contoh: Bidang Teknik Informatika</p>
                            <div class="relative border-l-2 border-slate-200 dark:border-slate-700 ml-3 space-y-4">
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-[7px] top-1.5 ring-4 ring-white dark:ring-slate-900"></div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">Level 1:</span> Junior Developer (0-2 tahun)
                                </div>
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-[7px] top-1.5 ring-4 ring-white dark:ring-slate-900"></div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">Level 2:</span> Mid Developer (2-4 tahun)
                                </div>
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-[7px] top-1.5 ring-4 ring-white dark:ring-slate-900"></div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">Level 3:</span> Senior Developer (4-7 tahun)
                                </div>
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-[7px] top-1.5 ring-4 ring-white dark:ring-slate-900"></div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">Level 4:</span> Tech Lead (7-10 tahun)
                                </div>
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-[7px] top-1.5 ring-4 ring-white dark:ring-slate-900"></div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">Level 5:</span> Engineering Manager (10+ tahun)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 text-base mb-2">Fitur Skill Match</h3>
                        <p class="mb-3 leading-relaxed">Sistem menampilkan persentase kecocokan skill kandidat dengan setiap level:</p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800/50 font-mono text-xs sm:text-sm">
                            <div class="font-semibold text-blue-800 dark:text-blue-300">Level 1: Junior Developer</div>
                            <div class="text-blue-700 dark:text-blue-400 mt-2">├── Skill dibutuhkan: HTML, CSS, JavaScript, PHP, SQL</div>
                            <div class="text-blue-700 dark:text-blue-400">├── Skill Anda: HTML, CSS, JavaScript</div>
                            <div class="text-emerald-600 dark:text-emerald-400 font-semibold mt-1">├── Match: 60% (3 dari 5 skill)</div>
                            <div class="text-rose-600 dark:text-rose-400">└── Missing: PHP, SQL</div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Detail & Manfaat -->
                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 text-base mb-3">Detail & Pembeda Antar Level</h3>
                        <div class="space-y-3">
                            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800/50">
                                <div class="font-semibold text-slate-800 dark:text-slate-200 mb-2">Level 1 (Junior)</div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Pengalaman:</span> 0-2 tahun</li>
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Tugas:</span> Mengerjakan task sederhana dengan instruksi & bimbingan</li>
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Fokus:</span> Menguasai dasar dan 1 stack teknologi</li>
                                </ul>
                            </div>
                            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800/50">
                                <div class="font-semibold text-slate-800 dark:text-slate-200 mb-2">Level 3 (Senior)</div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Pengalaman:</span> 4-7 tahun</li>
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Tugas:</span> Arsitektur sistem, desain skala besar, mentoring junior</li>
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Fokus:</span> Membangun reputasi sebagai expert & problem solver</li>
                                </ul>
                            </div>
                            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800/50">
                                <div class="font-semibold text-slate-800 dark:text-slate-200 mb-2">Level 5 (Managerial)</div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Pengalaman:</span> 10+ tahun</li>
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Tugas:</span> Strategic planning, budget, hiring, mengelola tim lintas divisi</li>
                                    <li><span class="font-medium text-slate-700 dark:text-slate-300">Fokus:</span> Kepemimpinan, people management & pencapaian bisnis</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="bg-emerald-50 dark:bg-emerald-900/20 p-5 rounded-xl border border-emerald-100 dark:border-emerald-800/50 mt-6">
                        <h3 class="font-semibold text-emerald-800 dark:text-emerald-300 text-base mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Manfaat Roadmap bagi Job Seeker
                        </h3>
                        <ol class="list-decimal pl-5 space-y-2 text-emerald-700 dark:text-emerald-400/90 font-medium">
                            <li>Mengetahui posisi dan kapabilitas saat ini di jalur karir.</li>
                            <li>Mengidentifikasi skill spesifik yang perlu dipelajari untuk promosi.</li>
                            <li>Memahami target gaji rasional di setiap tahapan karir.</li>
                            <li>Mendapatkan rekomendasi sertifikasi yang relevan dengan level.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bidang karir..." class="flex-1 border rounded-lg px-3 py-2">
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Cari</button>
    </form>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600 w-16">No</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Bidang</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Level</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Permintaan</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Gaji</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($fields as $field)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-center text-sm text-gray-500">
                        {{ $fields->firstItem() + $loop->index }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">{{ $field->icon }}</span>
                            <div>
                                <div class="font-medium">{{ $field->name }}</div>
                                <div class="text-xs text-gray-500">{{ $field->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $field->paths_count }} level</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">{{ $field->demand_score }}%</td>
                    <td class="px-4 py-3 text-center text-sm">
                        @if($field->avg_salary_min)
                        {{ number_format($field->avg_salary_min / 1000000, 0) }}-{{ number_format($field->avg_salary_max / 1000000, 0) }}jt
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($field->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Aktif</span>
                        @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.career-fields.paths', $field) }}" class="text-purple-600 hover:underline text-sm">Level</a>
                            <a href="{{ route('admin.career-fields.edit', $field) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.career-fields.destroy', $field) }}" method="POST" onsubmit="return confirm('Hapus bidang karir ini beserta semua levelnya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $fields->links() }}</div>
</div>
</x-app-layout>
