<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Lamaran Saya</h2>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perusahaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Match Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($applications as $app)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $app->jobListing->title }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $app->jobListing->company_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $app->applied_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $app->matching_percentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium">{{ number_format($app->matching_percentage, 0) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'saved' => 'bg-gray-100 text-gray-800',
                                            'applied' => 'bg-blue-100 text-blue-800',
                                            'interviewed' => 'bg-yellow-100 text-yellow-800',
                                            'offered' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$app->status] ?? 'bg-gray-100' }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ $app->jobListing->application_url }}" target="_blank" 
                                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Lihat Lowongan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada lamaran kerja
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6 border-t border-gray-200">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>