<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb & Back -->
            <div class="mb-6">
                <a href="{{ route('education.partners') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Mitra
                </a>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar: Partner Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="text-center mb-6">
                            <div
                                class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg mb-4">
                                {{ $partner['logo'] }}
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $partner['name'] }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $partner['industry'] }}</p>

                            @if ($partner['verified'])
                                <div class="mt-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Mitra Terverifikasi
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4 border-t border-gray-100 pt-6">
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Ukuran
                                    Perusahaan</h4>
                                <div class="flex items-center text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ $partner['size'] }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Lokasi
                                    Pusat</h4>
                                <div class="flex items-center text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $partner['location'] }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Website
                                </h4>
                                <div class="flex items-center text-sm">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                        </path>
                                    </svg>
                                    <a href="{{ $partner['website'] }}" target="_blank"
                                        class="text-indigo-600 hover:underline truncate">
                                        {{ str_replace(['https://', 'http://'], '', $partner['website']) }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('education.collaboration.create', ['partner' => $partner['id']]) }}"
                                class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Ajukan Kolaborasi
                            </a>
                            <a href="mailto:{{ $partner['contact_email'] }}"
                                class="w-full mt-3 flex justify-center items-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Hubungi via Email
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- About -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Tentang Perusahaan</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $partner['description'] }}
                        </p>
                    </div>

                    <!-- Opportunities -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 bg-gray-50/50 p-6">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Peluang Kolaborasi ({{ $partner['active_opportunities'] }})
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach ($partner['collaboration_types'] as $type)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ $type }}
                                    </span>
                                @endforeach
                            </div>

                            @if (isset($partner['benefits']) && is_array($partner['benefits']))
                                <div class="mt-8 grid md:grid-cols-2 gap-8">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Manfaat Institusi
                                        </h4>
                                        <ul class="space-y-3">
                                            @foreach ($partner['benefits'] as $benefit)
                                                <li class="flex items-start text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="flex-1">{{ $benefit }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if (isset($partner['requirements']) && is_array($partner['requirements']))
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                                <svg class="w-5 h-5 text-orange-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                                Persyaratan
                                            </h4>
                                            <ul class="space-y-3">
                                                @foreach ($partner['requirements'] as $req)
                                                    <li class="flex items-start text-sm text-gray-600">
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full bg-orange-400 mr-2 mt-1.5"></span>
                                                        <span class="flex-1">{{ $req }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
