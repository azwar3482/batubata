<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Hasil -->
            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 text-white mb-8 text-center">
                <h2 class="text-3xl font-bold">Hasil Asesmen Selesai!</h2>
                <p class="mt-2 opacity-90">Posisi Target: <span
                        class="font-semibold">{{ $assessment->position->name }}</span></p>
                <div class="mt-6 inline-block bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                    <span class="text-sm uppercase tracking-wide">Rata-rata Skill Gap</span>
                    <div class="text-4xl font-extrabold mt-1">{{ number_format($assessment->total_gap_percentage, 1) }}%
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Detail Gap per Skill -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Kesenjangan Kompetensi</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Kompetensi</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Level Anda</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Target</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Gap</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($assessment->scores as $score)
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                                {{ $score->competency->name }}</td>
                                            <td class="px-4 py-4 text-sm text-center text-gray-600">
                                                {{ $score->self_assessed_level }}/5</td>
                                            <td class="px-4 py-4 text-sm text-center text-gray-600">
                                                {{ $score->competency->min_level_required }}/5</td>
                                            <td class="px-4 py-4 text-sm text-center">
                                                <span
                                                    class="{{ $score->gap_percentage > 0 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                                                    {{ number_format($score->gap_percentage, 1) }}%
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if ($score->priority == 'high')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Tinggi</span>
                                                @elseif($score->priority == 'medium')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">Sedang</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Rendah</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <!-- Section Rekomendasi Kursus -->
                            <div class="bg-white rounded-xl shadow-md p-6 mt-8 border-t-4 border-blue-500">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">Rekomendasi Kursus Prioritas</h3>
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold">AI
                                        Powered Selection</span>
                                </div>

                                @if ($recommendations->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($recommendations as $rec)
                                            <div
                                                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition bg-gray-50">
                                                <div class="flex justify-between items-start mb-2">
                                                    <span
                                                        class="text-xs font-bold uppercase tracking-wider 
                            {{ $rec['priority'] == 'high' ? 'text-red-600' : 'text-yellow-600' }}">
                                                        {{ $rec['priority'] }} Priority
                                                    </span>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $rec['course']->platform }}</span>
                                                </div>
                                                <h4 class="font-bold text-gray-900 mb-1">{{ $rec['course']->title }}
                                                </h4>
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                    {{ $rec['course']->description }}</p>

                                                <div
                                                    class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                                    <span>⏱ {{ $rec['course']->duration_hours }} Jam</span>
                                                    <span class="capitalize">{{ $rec['course']->level }}</span>
                                                </div>

                                                <div class="mt-2">
                                                    <p class="text-xs text-blue-600 font-semibold mb-2">💡
                                                        {{ $rec['reason'] }}</p>
                                                    <a href="{{ $rec['course']->url }}" target="_blank"
                                                        class="block w-full text-center bg-blue-600 text-white text-sm py-2 rounded hover:bg-blue-700 transition">
                                                        Mulai Belajar
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        <p>Tidak ada rekomendasi kursus spesifik saat ini. Skill Anda sudah sangat baik!
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Section Status Roadmap -->
                            <div class="bg-white rounded-xl shadow-md p-6 mt-8 border-t-4 border-purple-500">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">Roadmap Karir 6 Bulan</h3>
                                    @if ($roadmapExists)
                                        <span class="text-green-600 text-sm font-semibold flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Telah Dibuat
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Belum tersedia</span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm mb-4">
                                    Kami telah menyusun rencana belajar personal selama 6 bulan berdasarkan hasil
                                    asesmen Anda.
                                    Roadmap ini dirancang untuk menutup celah kompetensi secara bertahap.
                                </p>
                                <a href="{{ route('seeker.roadmap.index') }}"
                                    class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-800 transition">
                                    Lihat Detail Roadmap Interaktif &rarr;
                                </a>
                            </div>



                        </div>
                    </div>
                </div>

                <!-- Action Panel -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Langkah Selanjutnya</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    1</div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Lihat Rekomendasi Kursus</p>
                                    <p class="text-xs text-gray-500">Kami telah menyiapkan daftar kursus untuk menutup
                                        gap skill Anda.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold">
                                    2</div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Unduh Roadmap Karir</p>
                                    <p class="text-xs text-gray-500">Rencana belajar 6 bulan yang dipersonalisasi.</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-6 space-y-3">
                            <a href="#"
                                class="block w-full text-center px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                                Lihat Rekomendasi
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="block w-full text-center px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Placeholder untuk Download PDF -->
                    <div class="bg-gray-50 rounded-xl border border-dashed border-gray-300 p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Laporan Lengkap</h3>
                        <p class="mt-1 text-xs text-gray-500">Download laporan detail dalam format PDF.</p>
                        <div class="mt-4">
                            <button class="text-sm text-blue-600 hover:text-blue-500 font-medium">Download PDF
                                (Segera)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
