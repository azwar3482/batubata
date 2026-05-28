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
            <div class="space-y-4">
                <!-- Candidate Card 1 -->
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                BS
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Budi Santoso</h3>
                                <p class="text-gray-600 text-sm">S1 Teknik Informatika • 1 Tahun Pengalaman</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Google
                                        Analytics</span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">SEO</span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Content
                                        Marketing</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Skill Match</div>
                                <div class="text-2xl font-bold text-green-600">85%</div>
                            </div>
                            <a href="{{ route('seeker.industry.candidates.show', 1) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Candidate Card 2 -->
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                AS
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Andi Saputra</h3>
                                <p class="text-gray-600 text-sm">D3 Manajemen Informatika • 2 Tahun Pengalaman</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Python</span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">SQL</span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Data
                                        Visualization</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Skill Match</div>
                                <div class="text-2xl font-bold text-yellow-600">72%</div>
                            </div>
                            <a href="{{ route('seeker.industry.candidates.show', 2) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Candidate Card 3 -->
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                DP
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Dewi Putri</h3>
                                <p class="text-gray-600 text-sm">S1 Komunikasi • Fresh Graduate</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Social
                                        Media</span>
                                    <span
                                        class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Copywriting</span>
                                    <span
                                        class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">Communication</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Skill Match</div>
                                <div class="text-2xl font-bold text-orange-600">65%</div>
                            </div>
                            <a href="{{ route('seeker.industry.candidates.show', 3) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Lihat Profil
                            </a>
                        </div>
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
