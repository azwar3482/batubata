<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Riwayat Asesmen2</h2>
                    <p class="mt-2 text-gray-600">Lihat semua hasil asesmen kompetensi yang pernah Anda lakukan.</p>
                </div>
                <a href="{{ route('seeker.assessment.create') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    + Asesmen Baru
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12 text-center">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi Target
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skill Gap</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assessments as $assessment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                    {{ $assessments->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $assessment->position->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $assessment->position->category }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $assessment->assessment_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2" style="width: 100px">
                                            <div class="bg-{{ $assessment->total_gap_percentage > 50 ? 'red' : ($assessment->total_gap_percentage > 25 ? 'yellow' : 'green') }}-500 h-2.5 rounded-full"
                                                style="width: {{ min($assessment->total_gap_percentage, 100) }}%"></div>
                                        </div>
                                        <span
                                            class="text-sm font-medium">{{ number_format($assessment->total_gap_percentage, 1) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $assessment->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($assessment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('seeker.assessment.result', $assessment->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm font-medium mr-3">
                                        Lihat Hasil
                                    </a>
                                    <a href="{{ route('seeker.reports.assessment.pdf', $assessment->id) }}"
                                        class="text-green-600 hover:text-green-900 text-sm font-medium mr-3">
                                        📄 PDF
                                    </a>
                                    <button
                                        onclick="if(confirm('Ulangi asesmen ini?')) window.location='{{ route('seeker.assessment.retake', $assessment->id) }}'"
                                        class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                        Ulangi
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Belum ada riwayat asesmen</p>
                                    <a href="{{ route('seeker.assessment.start') }}"
                                        class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium">Mulai
                                        Asesmen Pertama</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6 border-t border-gray-200">
                    {{ $assessments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
