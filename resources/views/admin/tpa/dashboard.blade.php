<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Dashboard TPA</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.tpa.questions') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Bank Soal</a>
            <a href="{{ route('admin.tpa.tests') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Tes TPA</a>
            <a href="{{ route('admin.tpa.results') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg">Hasil Tes</a>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-sm text-gray-500">Total Soal</div>
            <div class="text-3xl font-bold text-blue-600">{{ $totalQuestions }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-sm text-gray-500">Total Tes</div>
            <div class="text-3xl font-bold text-green-600">{{ $totalTests }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-sm text-gray-500">Total Peserta</div>
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_taken'] }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-sm text-gray-500">Pass Rate</div>
            <div class="text-3xl font-bold {{ $stats['pass_rate'] >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $stats['pass_rate'] }}%</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-bold mb-4">Rata-rata Skor per Kategori</h2>
            <div class="space-y-3">
                @foreach(['verbal' => 'Verbal', 'numerik' => 'Numerik', 'logika' => 'Logika', 'spasial' => 'Spasial'] as $key => $label)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $label }}</span>
                        <span class="font-bold">{{ $stats['avg_' . $key] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $stats['avg_' . $key] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-bold mb-4">Statistik</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Total Peserta:</span><span class="font-bold">{{ $stats['total_taken'] }}</span></div>
                <div class="flex justify-between"><span>Lulus:</span><span class="font-bold text-green-600">{{ $stats['total_passed'] }}</span></div>
                <div class="flex justify-between"><span>Tidak Lulus:</span><span class="font-bold text-red-600">{{ $stats['total_failed'] }}</span></div>
                <div class="flex justify-between"><span>Rata-rata Skor:</span><span class="font-bold">{{ $stats['avg_score'] }}%</span></div>
                <div class="flex justify-between"><span>Rata-rata Bappenas:</span><span class="font-bold">{{ $stats['avg_bappenas'] }}</span></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold mb-4">Hasil Terbaru</h2>
        @if($recentResults->isEmpty())
        <p class="text-gray-500 text-sm">Belum ada hasil tes.</p>
        @else
        <table class="w-full">
            <thead><tr class="text-left text-sm text-gray-500 border-b">
                <th class="pb-2">Peserta</th><th class="pb-2">Tes</th><th class="pb-2 text-center">Skor</th><th class="pb-2 text-center">Bappenas</th><th class="pb-2 text-center">Status</th>
            </tr></thead>
            <tbody class="divide-y">
                @foreach($recentResults as $r)
                <tr>
                    <td class="py-2">{{ $r->user->name }}</td>
                    <td class="py-2 text-sm text-gray-500">{{ $r->tpaTest->title }}</td>
                    <td class="py-2 text-center font-bold">{{ $r->total_score }}%</td>
                    <td class="py-2 text-center">{{ $r->bappenas_score }}</td>
                    <td class="py-2 text-center">
                        @if($r->is_passed)<span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Lulus</span>
                        @else<span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Tidak Lulus</span>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
</x-app-layout>
