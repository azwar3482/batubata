<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Cari Kandidat</h2>
                <p class="mt-2 text-gray-600">Temukan talenta yang sesuai dengan kebutuhan perusahaan Anda.</p>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Berdasarkan Skill</label>
                        <input type="text" placeholder="Contoh: Python, Digital Marketing, SEO..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                        <select
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Posisi</option>
                            <option value="1">Digital Marketing Specialist</option>
                            <option value="2">Data Analyst</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            🔍 Cari Kandidat
                        </button>
                    </div>
                </div>
            </div>

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
                            <!-- Candidate 1 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-750/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-500 dark:text-slate-400">1</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                            BS
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 dark:text-white text-sm">Budi Santoso</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">S1 Teknik Informatika • 1 Thn Pengalaman</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Google Analytics</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">SEO</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Content Marketing</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">85%</span>
                                        <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: 85%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('industry.candidates.show', 1) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 transition-colors">
                                        Lihat Profil
                                    </a>
                                </td>
                            </tr>

                            <!-- Candidate 2 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-750/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-500 dark:text-slate-400">2</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold shadow-sm">
                                            AS
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 dark:text-white text-sm">Andi Saputra</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">D3 Manajemen Informatika • 2 Thn Pengalaman</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Python</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">SQL</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Data Visualization</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-sm font-bold text-yellow-600 dark:text-yellow-400">72%</span>
                                        <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
                                            <div class="h-full bg-yellow-500 rounded-full" style="width: 72%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('industry.candidates.show', 2) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 transition-colors">
                                        Lihat Profil
                                    </a>
                                </td>
                            </tr>

                            <!-- Candidate 3 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-750/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-500 dark:text-slate-400">3</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold shadow-sm">
                                            DP
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 dark:text-white text-sm">Dewi Putri</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">S1 Komunikasi • Fresh Graduate</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Social Media</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Copywriting</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">Communication</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-sm font-bold text-orange-600 dark:text-orange-400">65%</span>
                                        <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
                                            <div class="h-full bg-orange-500 rounded-full" style="width: 65%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('industry.candidates.show', 3) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 transition-colors">
                                        Lihat Profil
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination (Optional Layout Element) -->
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                        <span>Menampilkan 1 sampai 3 dari 3 kandidat</span>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <div class="flex justify-center">
                    <nav class="flex items-center gap-2">
                        <button
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">Previous</button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md">1</button>
                        <button
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">2</button>
                        <button
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">3</button>
                        <button
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">Next</button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
