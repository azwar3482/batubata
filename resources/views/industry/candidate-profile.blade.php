<x-app-layout>
@include('partials.quill-styles')
<style>
.ql-toolbar.ql-snow { border-color: #e5e7eb; border-radius: 0.5rem 0.5rem 0 0; background: #f9fafb; }
.ql-container.ql-snow { border-color: #e5e7eb; border-radius: 0 0 0.5rem 0.5rem; min-height: 150px; font-size: 0.875rem; }
.ql-editor { min-height: 150px; }
.dark .ql-toolbar.ql-snow { background: #1e293b; border-color: #334155; }
.dark .ql-toolbar.ql-snow .ql-stroke { stroke: #cbd5e1; }
.dark .ql-toolbar.ql-snow .ql-fill { fill: #cbd5e1; }
.dark .ql-toolbar.ql-snow button:hover .ql-stroke { stroke: #60a5fa; }
.dark .ql-toolbar.ql-snow button:hover .ql-fill { fill: #60a5fa; }
.dark .ql-toolbar.ql-snow .ql-active .ql-stroke { stroke: #3b82f6; }
.dark .ql-toolbar.ql-snow .ql-active .ql-fill { fill: #3b82f6; }
.dark .ql-container.ql-snow { background: #1e293b; border-color: #334155; color: #f8fafc; }
.dark .ql-editor.ql-blank::before { color: #64748b; }
.dark .ql-snow .ql-picker { color: #cbd5e1; }
.dark .ql-snow .ql-picker-options { background: #1e293b; border-color: #334155; }
.ql-snow .ql-tooltip { z-index: 50; }
</style>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header & Actions -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ $jobId ? route('industry.jobs.show', $jobId) : route('industry.candidates') }}"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Profil Kandidat</h2>
                            <p class="text-gray-600">Detail kompetensi dan riwayat {{ $candidate->name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                            Share Profil
                        </button>
                        <button
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download CV
                        </button>
                        <form action="{{ route('industry.chats.initiate') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                            <button type="submit"
                                class="px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg hover:from-blue-700 hover:to-indigo-800 transition text-sm font-medium flex items-center gap-2 shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Hubungi Kandidat
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Candidate Info -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Profile Header Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Cover Image -->
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

                        <div class="px-6 pb-6">
                            <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-12">
                                <!-- Avatar -->
                                <div class="relative">
                                    @php $photoDoc = $candidate->documents->where('document_type', 'photo')->first(); @endphp
                                    <div
                                        class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg overflow-hidden">
                                        @if($photoDoc)
                                            <img src="{{ Storage::url($photoDoc->file_path) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            {{ substr($candidate->name, 0, 2) }}
                                        @endif
                                    </div>
                                    @if ($candidate->is_verified ?? false)
                                    <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-green-500 rounded-full flex items-center justify-center border-2 border-white"
                                        title="Profil Terverifikasi">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- Name & Title -->
                                <div class="flex-1 pb-2">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $candidate->name }}</h1>
                                    <p class="text-lg text-gray-600">
                                        {{ $candidate->target_position ?? 'Digital Marketing Specialist' }}
                                    </p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                            </svg>
                                            {{ $candidate->location ?? 'Jakarta' }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $candidate->experience_years ?? 0 }} Tahun Pengalaman
                                        </span>
                                    </div>
                                </div>

                                <!-- Match Score Badge -->
                                <div class="text-center sm:text-right pb-2">
                                    <div
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow">
                                        <span class="text-2xl font-bold">{{ $matchPercentage ?? 85 }}%</span>
                                        <span class="text-sm ml-2 opacity-90">Match</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Kecocokan dengan lowongan Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Tentang Kandidat</h3>
                        <div class="text-gray-600 leading-relaxed prose dark:prose-invert max-w-none text-sm">
                            @if($candidate->bio)
                                {!! $candidate->safe_bio !!}
                            @else
                                Profesional digital marketing dengan pengalaman 3+ tahun dalam mengelola kampanye iklan digital, SEO, dan content strategy. Berkomitmen untuk menghasilkan hasil yang terukur dan berdampak bagi bisnis.
                            @endif
                        </div>

                        @if ($candidate->linkedin_url || $candidate->portfolio_url)
                        <div class="mt-4 pt-4 border-t flex flex-wrap gap-3">
                            @if ($candidate->linkedin_url)
                            <a href="{{ $candidate->linkedin_url }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                                LinkedIn
                            </a>
                            @endif
                            @if ($candidate->portfolio_url)
                            <a href="{{ $candidate->portfolio_url }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                    </path>
                                </svg>
                                Portfolio
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Skills Assessment -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Hasil Asesmen Kompetensi</h3>
                            <span class="text-sm text-gray-500">Diperbarui
                                {{ $candidate->last_assessment_date?->diffForHumans() ?? '2 minggu lalu' }}</span>
                        </div>

                        <!-- Skill Categories -->
                        <div class="space-y-6">
                            @php
                            $skillCategories = [
                            'Technical Skills' => [
                            ['name' => 'Google Analytics', 'level' => 4, 'target' => 5, 'gap' => 20],
                            ['name' => 'SEO/SEM', 'level' => 4, 'target' => 4, 'gap' => 0],
                            ['name' => 'Social Media Ads', 'level' => 3, 'target' => 4, 'gap' => 25],
                            ['name' => 'Content Strategy', 'level' => 5, 'target' => 4, 'gap' => 0],
                            ],
                            'Soft Skills' => [
                            ['name' => 'Komunikasi Efektif', 'level' => 4, 'target' => 4, 'gap' => 0],
                            ['name' => 'Teamwork', 'level' => 5, 'target' => 4, 'gap' => 0],
                            ['name' => 'Problem Solving', 'level' => 4, 'target' => 5, 'gap' => 20],
                            ],
                            ];
                            @endphp

                            @foreach ($skillCategories as $category => $skills)
                            <div>
                                <h4 class="font-semibold text-gray-700 mb-3">{{ $category }}</h4>
                                <div class="space-y-3">
                                    @foreach ($skills as $skill)
                                    <div class="flex items-center gap-4">
                                        <div class="flex-1">
                                            <div class="flex justify-between text-sm mb-1">
                                                <span
                                                    class="font-medium text-gray-900">{{ $skill['name'] }}</span>
                                                <span class="text-gray-500">{{ $skill['level'] }}/5</span>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-2">
                                                <div class="h-2 rounded-full {{ $skill['gap'] > 0 ? 'bg-yellow-400' : 'bg-green-500' }}"
                                                    style="width: {{ ($skill['level'] / 5) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        @if ($skill['gap'] > 0)
                                        <span class="text-xs text-yellow-600 font-medium">Gap:
                                            {{ $skill['gap'] }}%</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Work History / Education -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Pendidikan & Pengalaman</h3>

                        <div class="space-y-6">
                            <!-- Education -->
                            <div>
                                <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Pendidikan
                                </h4>
                                <div class="p-4 bg-gray-50 rounded-xl">
                                    <p class="font-medium text-gray-900">S1 Teknik Informatika</p>
                                    <p class="text-sm text-gray-600">Universitas Indonesia • 2018 - 2022</p>
                                    <p class="text-sm text-gray-500 mt-1">IPK: 3.75/4.00 • Fokus: Data Analysis &
                                        Digital Systems</p>
                                </div>
                            </div>

                            <!-- Experience -->
                            <div>
                                <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Pengalaman Kerja
                                </h4>
                                <div class="space-y-3">
                                    <div class="p-4 bg-gray-50 rounded-xl">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900">Digital Marketing Specialist</p>
                                                <p class="text-sm text-gray-600">PT Startup Digital • Jan 2023 -
                                                    Sekarang</p>
                                            </div>
                                            <span
                                                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Current</span>
                                        </div>
                                        <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
                                            <li>Mengelola kampanye Google Ads dengan budget Rp 50jt/bulan</li>
                                            <li>Meningkatkan organic traffic sebesar 150% dalam 6 bulan</li>
                                            <li>Koordinasi dengan tim content untuk strategi SEO</li>
                                        </ul>
                                    </div>
                                    <div class="p-4 bg-gray-50 rounded-xl">
                                        <p class="font-medium text-gray-900">Marketing Intern</p>
                                        <p class="text-sm text-gray-600">PT Media Kreatif • Jun 2022 - Des 2022</p>
                                        <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
                                            <li>Membuat konten untuk media sosial perusahaan</li>
                                            <li>Analisis performa kampanye menggunakan Google Analytics</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments -->
                    @php $cvDoc = $candidate->documents->where('document_type', 'cv')->first(); @endphp
                    @if ($cvDoc)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Dokumen</h3>
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $cvDoc->original_name }}</p>
                                <p class="text-sm text-gray-500">{{ $cvDoc->file_size_human }} • {{ $cvDoc->updated_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ Storage::url($cvDoc->file_path) }}" target="_blank"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                Lihat
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Sticky Actions & Notes -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">

                        <!-- Quick Actions Card -->
                        <!-- Status Lamaran Card -->
                        @if ($application)
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Status Lamaran</h3>
                            
                            @if (session('success'))
                                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-xl border border-green-200 text-sm flex items-center gap-2 animate-fade-in">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            @php
                                $statuses = [
                                    'applied' => ['label' => 'Dikirim', 'bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'border' => 'border-blue-500', 'ring' => 'ring-blue-100'],
                                    'reviewed' => ['label' => 'Direview', 'bg' => 'bg-purple-500', 'text' => 'text-purple-600', 'border' => 'border-purple-500', 'ring' => 'ring-purple-100'],
                                    'interviewed' => ['label' => 'Interview', 'bg' => 'bg-amber-500', 'text' => 'text-amber-600', 'border' => 'border-amber-500', 'ring' => 'ring-amber-100'],
                                    'offered' => ['label' => 'Diterima', 'bg' => 'bg-green-500', 'text' => 'text-green-600', 'border' => 'border-green-500', 'ring' => 'ring-green-100'],
                                    'rejected' => ['label' => 'Ditolak', 'bg' => 'bg-red-500', 'text' => 'text-red-600', 'border' => 'border-red-500', 'ring' => 'ring-red-100'],
                                ];
                                $currentStatus = $application->status;
                                $statusOrder = ['applied', 'reviewed', 'interviewed', 'offered'];
                                $currentIndex = array_search($currentStatus, $statusOrder);
                                $isRejected = $currentStatus === 'rejected';
                            @endphp

                            @if ($isRejected)
                                <div class="p-4 bg-red-50 text-red-800 rounded-xl border border-red-200 text-center mb-6">
                                    <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <p class="font-bold text-base">Lamaran Ditolak</p>
                                    <p class="text-xs text-red-600 mt-1">Kandidat ini tidak dilanjutkan ke tahap berikutnya.</p>
                                </div>
                            @else
                                <!-- Premium Visual Stepper -->
                                <div class="relative flex items-center justify-between mb-8 px-2">
                                    <!-- Stepper Line -->
                                    <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-1 bg-gray-100 z-0">
                                        @php
                                            $widthPercent = $currentIndex !== false ? ($currentIndex / (count($statusOrder) - 1)) * 100 : 0;
                                        @endphp
                                        <div class="h-full bg-gradient-to-r from-blue-500 to-green-500 transition-all duration-500" style="width: {{ $widthPercent }}%"></div>
                                    </div>

                                    @foreach ($statusOrder as $index => $stepKey)
                                        @php
                                            $step = $statuses[$stepKey];
                                            $isCompleted = $currentIndex !== false && $index < $currentIndex;
                                            $isActive = $currentIndex !== false && $index === $currentIndex;
                                            $isFuture = $currentIndex !== false && $index > $currentIndex;
                                        @endphp
                                        <div class="relative flex flex-col items-center z-10">
                                            <!-- Circle Badge -->
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                                {{ $isCompleted ? 'bg-green-500 border-green-500 text-white' : '' }}
                                                {{ $isActive ? 'bg-white ' . $step['border'] . ' ' . $step['text'] . ' ring-4 ring-offset-2 ' . $step['ring'] : '' }}
                                                {{ $isFuture ? 'bg-white border-gray-200 text-gray-300' : '' }}
                                            ">
                                                @if ($isCompleted)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @else
                                                    <span class="text-xs font-bold">{{ $index + 1 }}</span>
                                                @endif
                                            </div>
                                            <span class="absolute top-10 whitespace-nowrap text-[10px] font-bold tracking-tight uppercase
                                                {{ $isCompleted ? 'text-green-600' : '' }}
                                                {{ $isActive ? $step['text'] : '' }}
                                                {{ $isFuture ? 'text-gray-400' : '' }}
                                            ">
                                                {{ $step['label'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="h-6"></div> <!-- spacer for labels -->
                            @endif

                            <!-- Action Buttons Forms -->
                            <form action="{{ route('industry.applications.update-status', $application->id) }}" method="POST" class="mt-4 space-y-3"
                                x-data="{ loading: false }" @submit="loading = true">
                                @csrf
                                @method('PUT')

                                <template x-if="loading">
                                    <div class="flex items-center justify-center gap-2 py-3 text-blue-600">
                                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Memproses...</span>
                                    </div>
                                </template>

                                <div x-show="!loading">
                                @if ($currentStatus === 'applied')
                                    <button type="submit" name="status" value="reviewed" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-150">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Pindahkan ke Direview
                                    </button>
                                    <button type="submit" name="status" value="rejected" class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-red-200 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-300 transition font-semibold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tolak Kandidat
                                    </button>
                                @elseif ($currentStatus === 'reviewed')
                                    <button type="submit" name="status" value="interviewed" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-150">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Jadwalkan Interview
                                    </button>
                                    <button type="submit" name="status" value="rejected" class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-red-200 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-300 transition font-semibold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tolak Kandidat
                                    </button>
                                    <div class="pt-2 border-t border-gray-100 mt-2">
                                        <button type="submit" name="status" value="applied" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 hover:text-gray-700 transition text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Kembalikan ke Dikirim
                                        </button>
                                    </div>
                                @elseif ($currentStatus === 'interviewed')
                                    <button type="submit" name="status" value="offered" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-150">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Terima Kandidat (Diterima)
                                    </button>
                                    <button type="submit" name="status" value="rejected" class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-red-200 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-300 transition font-semibold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tolak Kandidat
                                    </button>
                                    <div class="pt-2 border-t border-gray-100 mt-2">
                                        <button type="submit" name="status" value="reviewed" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 hover:text-gray-700 transition text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Kembalikan ke Direview
                                        </button>
                                    </div>
                                @elseif ($currentStatus === 'offered')
                                    <div class="p-4 bg-green-50 text-green-800 rounded-xl border border-green-200 text-center mb-2">
                                        <p class="font-bold">Kandidat Telah Diterima</p>
                                        <p class="text-xs mt-1">Kandidat telah berhasil diterima untuk posisi ini.</p>
                                    </div>
                                    <button type="submit" name="status" value="interviewed" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 hover:text-gray-700 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Kembalikan ke Interview
                                    </button>
                                @elseif ($currentStatus === 'rejected')
                                    <button type="submit" name="status" value="applied" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-150">
                                        Pulihkan / Aktifkan Kembali
                                    </button>
                                @endif
                                </div>
                            </form>
                        </div>
                        @endif

                        <!-- Quick Actions Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                            <div class="space-y-3">
                                <button
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg hover:from-blue-700 hover:to-indigo-800 transition font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Kirim Email
                                </button>

                                @if($application && $application->tpa_status === 'not_required')
                                @php
                                    $availableTests = \App\Models\TpaTest::where('created_by', auth()->id())
                                        ->orWhereHas('jobListing', fn($q) => $q->where('user_id', auth()->id()))
                                        ->active()
                                        ->get();
                                @endphp
                                @if($availableTests->count() > 0)
                                <div x-data="{ showTpaModal: false, selectedTest: '' }">
                                    <button @click="showTpaModal = true"
                                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-purple-600 to-violet-700 text-white rounded-lg hover:from-purple-700 hover:to-violet-800 transition font-medium">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                            </path>
                                        </svg>
                                        Undang Tes TPA
                                    </button>

                                    <!-- TPA Invite Modal -->
                                    <div x-show="showTpaModal" x-cloak
                                        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                                        @click.self="showTpaModal = false">
                                        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6" @click.stop>
                                            <h3 class="text-lg font-bold mb-4">Kirim Undangan TPA</h3>
                                            <form action="{{ route('industry.applications.invite-tpa', $application->id) }}" method="POST"
                                                x-data="{ loading: false }" @submit="loading = true">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium mb-2">Pilih Tes TPA</label>
                                                    <select name="tpa_test_id" class="w-full border rounded-lg px-3 py-2" required :disabled="loading">
                                                        <option value="">-- Pilih Tes --</option>
                                                        @foreach($availableTests as $test)
                                                        <option value="{{ $test->id }}">{{ $test->title }} ({{ $test->total_questions }} soal, {{ $test->time_limit_minutes }}m)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <p class="text-xs text-gray-500 mb-4">Kandidat akan menerima undangan untuk mengerjakan tes TPA secara online.</p>
                                                <div class="flex gap-3">
                                                    <button type="button" @click="showTpaModal = false" class="flex-1 px-4 py-2 border rounded-lg" :disabled="loading">Batal</button>
                                                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center justify-center gap-2" :disabled="loading">
                                                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        <span x-text="loading ? 'Mengirim...' : 'Kirim'"></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endif

                                @if($application && in_array($application->tpa_status, ['invited', 'in_progress', 'completed', 'passed', 'failed']))
                                <div class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg text-sm font-medium
                                    {{ $application->tpa_status === 'passed' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
                                    {{ $application->tpa_status === 'failed' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}
                                    {{ $application->tpa_status === 'invited' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : '' }}
                                    {{ $application->tpa_status === 'in_progress' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                    {{ $application->tpa_status === 'completed' ? 'bg-purple-50 text-purple-700 border border-purple-200' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    TPA: {{ ucfirst(str_replace('_', ' ', $application->tpa_status)) }}
                                    @if($application->tpa_score) - {{ $application->tpa_score }}% @endif
                                    @if($application->tpaSession && $application->tpaSession->result)
                                        <a href="{{ route('industry.tpa.results.show', $application->tpaSession->result->id) }}" class="ml-2 text-purple-600 underline">Lihat Hasil</a>
                                    @endif
                                </div>
                                @endif

                                <button
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    Simpan ke Shortlist
                                </button>
                                <button
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                        </path>
                                    </svg>
                                    Bagikan ke Tim
                                </button>
                            </div>
                        </div>

                        <!-- Match Analysis Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Analisis Kecocokan</h3>

                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Skill Match</span>
                                        <span class="font-bold text-green-600">92%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Experience Match</span>
                                        <span class="font-bold text-green-600">88%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 88%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Education Match</span>
                                        <span class="font-bold text-yellow-600">75%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t">
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold text-green-600">✓</span> Sangat kuat di technical skills
                                    yang dibutuhkan
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="font-semibold text-yellow-600">⚠</span> Pengalaman sedikit di bawah
                                    requirement
                                </p>
                            </div>
                        </div>

                        <!-- Internal Notes -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Catatan Internal</h3>
                            @if ($application)
                                <form action="{{ route('industry.applications.update-notes', $application->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="notes" id="notes" value="{{ old('notes', $application->notes) }}">
                                    <div id="quill-notes"></div>
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900 transition">
                                        Simpan Catatan
                                    </button>
                                </form>

                                @if ($application->notes)
                                <div class="mt-4 pt-4 border-t space-y-3">
                                    <div class="p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                                        <p class="text-xs text-blue-800 font-semibold">Catatan Tersimpan:</p>
                                        <div class="text-sm text-gray-700 mt-1.5 trix-content">
                                            {!! $application->notes !!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="text-center py-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-sm text-gray-500">Catatan internal hanya tersedia untuk kandidat dengan lamaran aktif.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Candidate Status -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-2xl p-6 border border-indigo-200 dark:border-indigo-800/50">
                            <h4 class="font-bold text-indigo-900 dark:text-indigo-300 mb-3">Status Kandidat</h4>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Aktif Mencari Pekerjaan</span>
                            </div>
                            <p class="text-xs text-indigo-700 dark:text-indigo-400">
                                Kandidat terakhir aktif
                                {{ $candidate->last_active?->diffForHumans() ?? '1 hari yang lalu' }} dan terbuka untuk
                                peluang baru.
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Informasi Profil Lengkap - Full Width -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Profil
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
                        <!-- ID Pelamar -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Pelamar</span>
                            <span class="text-sm font-mono font-bold text-gray-900">#{{ $candidate->id }}</span>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</span>
                            <a href="mailto:{{ $candidate->email }}" class="text-sm text-blue-600 hover:underline">{{ $candidate->email }}</a>
                        </div>

                        <!-- Telepon -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Telepon</span>
                            @if($candidate->phone)
                            <a href="tel:{{ $candidate->phone }}" class="text-sm text-blue-600 hover:underline">{{ $candidate->phone }}</a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kelamin</span>
                            @if($candidate->gender)
                            <span class="text-sm text-gray-900">{{ $candidate->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Lahir</span>
                            @if($candidate->birth_date)
                            <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($candidate->birth_date)->format('d M Y') }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Golongan Darah -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Golongan Darah</span>
                            @if($candidate->blood_type)
                            <span class="text-sm text-gray-900">{{ $candidate->blood_type }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Pendidikan -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pendidikan</span>
                            @if($candidate->education_level)
                            <span class="text-sm text-gray-900">{{ $candidate->education_level }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Jurusan -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jurusan</span>
                            @if($candidate->major)
                            <span class="text-sm text-gray-900">{{ $candidate->major }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Tahun Lulus -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tahun Lulus</span>
                            @if($candidate->graduation_year)
                            <span class="text-sm text-gray-900">{{ $candidate->graduation_year }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Pengalaman -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengalaman</span>
                            <span class="text-sm text-gray-900">{{ $candidate->experience_years ?? 0 }} Tahun</span>
                        </div>

                        <!-- Status Akun -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Akun</span>
                            @if($candidate->email_verified_at)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 px-2 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Terverifikasi
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-yellow-700 bg-yellow-50 px-2 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Belum Verifikasi
                            </span>
                            @endif
                        </div>

                        <!-- Tanggal Daftar -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</span>
                            <span class="text-sm text-gray-900">{{ $candidate->created_at->format('d M Y') }}</span>
                        </div>

                        <!-- Koordinat -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Koordinat</span>
                            @if($candidate->latitude && $candidate->longitude)
                            <span class="text-xs text-gray-600 font-mono">{{ $candidate->latitude }}, {{ $candidate->longitude }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- CV -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">CV</span>
                            @php $cvDoc = $candidate->documents->where('document_type', 'cv')->first(); @endphp
                            @if($cvDoc)
                            <a href="{{ Storage::url($cvDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download CV
                            </a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Ijazah -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ijazah</span>
                            @php $ijazahDoc = $candidate->documents->where('document_type', 'ijazah')->first(); @endphp
                            @if($ijazahDoc)
                            <a href="{{ Storage::url($ijazahDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Ijazah
                            </a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Transkrip -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Transkrip</span>
                            @php $transkripDoc = $candidate->documents->where('document_type', 'transkrip')->first(); @endphp
                            @if($transkripDoc)
                            <a href="{{ Storage::url($transkripDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Transkrip
                            </a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Sertifikat -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sertifikat</span>
                            @php $sertifikatDoc = $candidate->documents->where('document_type', 'sertifikat')->first(); @endphp
                            @if($sertifikatDoc)
                            <a href="{{ Storage::url($sertifikatDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Sertifikat
                            </a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Portofolio -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Portofolio</span>
                            @php $portoDoc = $candidate->documents->where('document_type', 'portofolio')->first(); @endphp
                            @if($portoDoc)
                            <a href="{{ Storage::url($portoDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Portofolio
                            </a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- LinkedIn -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">LinkedIn</span>
                            @if($candidate->linkedin_url)
                            <a href="{{ $candidate->linkedin_url }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate max-w-[200px]">Profil LinkedIn</a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Portfolio -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Portfolio</span>
                            @if($candidate->portfolio_url)
                            <a href="{{ $candidate->portfolio_url }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate max-w-[200px]">Lihat Portfolio</a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- GitHub -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">GitHub</span>
                            @if($candidate->github_url)
                            <a href="{{ $candidate->github_url }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate max-w-[200px]">Lihat GitHub</a>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Alamat - Full Width -->
                        <div class="py-2 border-b border-gray-100 md:col-span-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Alamat</span>
                            @if($candidate->address)
                            <span class="text-sm text-gray-900">{{ $candidate->address }}</span>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Skills - Full Width -->
                        <div class="py-2 border-b border-gray-100 md:col-span-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Keahlian</span>
                            @if($candidate->skills && count($candidate->skills) > 0)
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($candidate->skills as $skill)
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">{{ $skill }}</span>
                                @endforeach
                            </div>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>

                        <!-- Bahasa - Full Width -->
                        <div class="py-2 md:col-span-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Bahasa</span>
                            @if($candidate->languages && count($candidate->languages) > 0)
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($candidate->languages as $lang)
                                <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded-full">{{ $lang }}</span>
                                @endforeach
                            </div>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@vite(['resources/js/quill.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-notes', {
        theme: 'snow',
        placeholder: 'Tambahkan catatan tentang kandidat ini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var existing = document.getElementById('notes').value;
    if (existing) quill.root.innerHTML = existing;
    var form = document.getElementById('quill-notes').closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('notes').value = quill.root.innerHTML;
        });
    }
});
</script>
</x-app-layout>