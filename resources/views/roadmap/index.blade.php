<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900">Roadmap Karir Anda</h2>
                <p class="mt-2 text-gray-600">Rencana aksi 6 bulan menuju posisi: <span
                        class="font-bold text-blue-600">{{ $latestAssessment->position->name }}</span></p>
            </div>

            <!-- Container Timeline -->
            <div class="relative pl-8 md:pl-0">
                <!-- Garis Vertikal Tengah (Desktop) / Kiri (Mobile) -->
                <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-1 bg-purple-200 transform md:-translate-x-1/2">
                </div>

                <div class="space-y-12">
                    @foreach ($roadmaps as $index => $item)
                        <!-- Item Timeline -->
                        <div
                            class="relative flex flex-col md:flex-row items-center {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">

                            <!-- Spacer untuk layout selang-seling -->
                            <div class="flex-1 w-full md:w-1/2"></div>

                            <!-- Titik Tengah (Bullet) -->
                            <div
                                class="absolute left-8 md:left-1/2 w-8 h-8 rounded-full border-4 border-white shadow-md z-10 transform -translate-x-1/2 flex items-center justify-center 
                                {{ $item->is_completed ? 'bg-green-500' : 'bg-purple-600' }}">
                                @if ($item->is_completed)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <span class="text-xs font-bold text-white">{{ $item->month_number }}</span>
                                @endif
                            </div>

                            <!-- Kartu Konten -->
                            <div
                                class="flex-1 w-full md:w-1/2 pl-8 md:pl-0 {{ $index % 2 == 0 ? 'md:pr-12 text-left' : 'md:pl-12 text-left md:text-right' }}">
                                <div
                                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition border-l-4 {{ $item->is_completed ? 'border-green-500' : 'border-purple-500' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <span
                                            class="text-xs font-bold uppercase tracking-wider text-purple-600 bg-purple-50 px-2 py-1 rounded">
                                            Bulan {{ $item->month_number }}
                                        </span>
                                        @if ($item->is_completed)
                                            <span class="text-xs text-green-600 font-semibold flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Selesai
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item->milestone_title }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                        {{ $item->milestone_description }}
                                    </p>

                                    @if (!$item->is_completed)
                                        <form action="{{ route('seeker.roadmap.complete', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center {{ $index % 2 != 0 ? 'md:justify-end' : '' }}">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-xs text-gray-400 italic">
                                            Diselesaikan pada {{ $item->completed_at->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-gray-500 hover:text-gray-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
