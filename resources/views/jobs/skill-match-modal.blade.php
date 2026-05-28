<!-- Modal Version (bisa di-load via Alpine.js atau sebagai page terpisah) -->
<div x-data="{ open: false }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <!-- Backdrop -->
    <div x-show="open" @click="open = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal Content -->
    <div x-show="open" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative inline-block w-full max-w-2xl p-6 my-8 mx-4 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6 pb-4 border-b">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Detail Skill Match</h3>
                <p class="text-sm text-gray-500">{{ $job->title }} @ {{ $job->company_name }}</p>
            </div>
            <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Overall Score -->
        <div class="text-center mb-8">
            <div class="relative w-32 h-32 mx-auto mb-4">
                <svg class="w-32 h-32 transform -rotate-90">
                    <circle cx="64" cy="64" r="56" fill="none" stroke="#e5e7eb" stroke-width="8">
                    </circle>
                    <circle cx="64" cy="64" r="56" fill="none"
                        stroke="{{ $matchPercentage >= 80 ? '#22c55e' : ($matchPercentage >= 50 ? '#eab308' : '#ef4444') }}"
                        stroke-width="8" stroke-dasharray="{{ 2 * M_PI * 56 }}"
                        stroke-dashoffset="{{ 2 * M_PI * 56 * (1 - $matchPercentage / 100) }}" stroke-linecap="round">
                    </circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-bold text-gray-900">{{ round($matchPercentage) }}%</span>
                    <span class="text-xs text-gray-500">Overall Match</span>
                </div>
            </div>
            <p
                class="text-sm {{ $matchPercentage >= 80 ? 'text-green-600' : ($matchPercentage >= 50 ? 'text-yellow-600' : 'text-red-600') }} font-medium">
                @if ($matchPercentage >= 80)
                    🎯 Profil Anda sangat cocok dengan lowongan ini!
                @elseif($matchPercentage >= 50)
                    ⚡ Cocok di beberapa area, tingkatkan skill kunci untuk peluang lebih baik
                @else
                    📚 Ada kesenjangan skill, ikuti rekomendasi kursus untuk meningkatkan kecocokan
                @endif
            </p>
        </div>

        <!-- Skill Breakdown -->
        <div class="space-y-4 mb-8">
            <h4 class="font-semibold text-gray-900">Breakdown Kecocokan Skill</h4>

            @php
                // Dummy data - ganti dengan logic real dari controller
                $skills = [
                    ['name' => 'Google Analytics', 'user' => 4, 'required' => 5, 'match' => 80, 'priority' => 'high'],
                    ['name' => 'SEO/SEM', 'user' => 3, 'required' => 4, 'match' => 75, 'priority' => 'medium'],
                    ['name' => 'Content Strategy', 'user' => 5, 'required' => 4, 'match' => 100, 'priority' => 'low'],
                    ['name' => 'Social Media Ads', 'user' => 2, 'required' => 4, 'match' => 50, 'priority' => 'high'],
                    ['name' => 'Communication', 'user' => 4, 'required' => 4, 'match' => 100, 'priority' => 'low'],
                ];
            @endphp

            @foreach ($skills as $skill)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">{{ $skill['name'] }}</span>
                        <span
                            class="text-sm font-bold {{ $skill['match'] >= 80 ? 'text-green-600' : ($skill['match'] >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $skill['match'] }}%
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Level Anda: {{ $skill['user'] }}/5</span>
                                <span>Target: {{ $skill['required'] }}/5</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all {{ $skill['match'] >= 80 ? 'bg-green-500' : ($skill['match'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $skill['match'] }}%"></div>
                            </div>
                        </div>
                        @if ($skill['match'] < 80)
                            <a href="{{ route('seeker.courses.index') }}"
                                class="text-xs text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap">
                                Pelajari →
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Gap Summary -->
        @if ($matchPercentage < 100)
            <div class="bg-red-50 rounded-xl p-4 border border-red-100 mb-6">
                <h4 class="font-semibold text-red-900 mb-3">🔍 Skill yang Perlu Ditingkatkan</h4>
                <div class="space-y-2">
                    @foreach ($skills as $skill)
                        @if ($skill['match'] < 80)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-red-700">{{ $skill['name'] }}</span>
                                <span class="text-red-600 font-medium">Gap: {{ 100 - $skill['match'] }}%</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
            <button @click="open = false"
                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                Tutup
            </button>
            <a href="{{ route('seeker.courses.index') }}"
                class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-center">
                Lihat Kursus Rekomendasi
            </a>
            @if ($matchPercentage >= 70)
                <a href="{{ route('seeker.jobs.apply', $job->id) }}"
                    class="flex-1 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-center">
                    Lamar Sekarang
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Page Version (jika ingin sebagai halaman terpisah) -->
<!-- Simpan sebagai resources/views/jobs/skill-match.blade.php -->
