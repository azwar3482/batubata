<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb & Back -->
            <div class="mb-6">
                <a href="{{ route('seeker.jobs.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-blue-600 text-sm font-medium transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Lowongan
                </a>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Job Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Job Header Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Header Gradient -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center text-white font-bold text-xl backdrop-blur-sm">
                                        {{ substr($job->company_name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold">{{ $job->title }}</h1>
                                        <p class="text-blue-100 text-lg">{{ $job->company_name }}</p>
                                    </div>
                                </div>
                                @if ($matchPercentage >= 80)
                                <div class="text-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                                    <p class="text-xs text-blue-100 uppercase tracking-wide">Match Score</p>
                                    <p class="text-2xl font-bold text-white">{{ round($matchPercentage) }}%</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Job Meta -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $job->location }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span class="capitalize">{{ $job->work_type }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $job->experience_required }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Diposting {{ \Carbon\Carbon::parse($job->posted_date)->diffForHumans() }}
                                </div>
                            </div>

                            @if ($job->salary_min)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Rp {{ number_format($job->salary_min / 1000000, 0) }} -
                                    {{ number_format($job->salary_max / 1000000, 0) }} Juta / bulan
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Job Description -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Deskripsi Pekerjaan</h3>
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($job->description)) !!}
                            </div>
                        </div>

                        <!-- Required Skills -->
                        @if ($job->required_skills)
                        <div class="p-6 bg-gray-50 border-t border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Keahlian yang Dibutuhkan</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($job->required_skills as $skill)
                                @php
                                $userHasSkill = false; // Logic cek skill user nanti
                                $matchClass = $userHasSkill
                                ? 'bg-green-100 text-green-800 border-green-200'
                                : 'bg-blue-50 text-blue-700 border-blue-200';
                                @endphp
                                <span
                                    class="px-3 py-1.5 {{ $matchClass }} border rounded-lg text-sm font-medium flex items-center gap-1.5">
                                    @if ($userHasSkill)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    @endif
                                    {{ $skill }}
                                </span>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-3">
                                <span class="text-green-600">●</span> Skill yang Anda miliki &nbsp;
                                <span class="text-blue-600">●</span> Skill yang perlu dipelajari
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Skill Gap Analysis Card -->
                    @if ($matchPercentage < 100)
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Analisis Kecocokan Skill</h3>

                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Overall Match</span>
                                <span
                                    class="text-2xl font-bold {{ $matchPercentage >= 80 ? 'text-green-600' : ($matchPercentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ round($matchPercentage) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-500 {{ $matchPercentage >= 80 ? 'bg-green-500' : ($matchPercentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $matchPercentage }}%"></div>
                            </div>
                        </div>

                        @if ($matchPercentage < 80)
                            <div class="space-y-3">
                            <p class="text-sm font-medium text-gray-700">Skill yang perlu ditingkatkan:</p>
                            @foreach (['Data Analysis', 'Project Management', 'Cloud Computing'] as $gapSkill)
                            <div
                                class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-red-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $gapSkill }}</span>
                                </div>
                                <a href="{{ route('seeker.courses.index') }}"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">Pelajari
                                    →</a>
                            </div>
                            @endforeach
                </div>
                @else
                <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                    <p class="text-sm text-green-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        🎉 Profil Anda sangat cocok dengan lowongan ini! Segera lamar sebelum ditutup.
                    </p>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Right Column: Sticky Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">

                <!-- Apply Card -->
                <div
                    class="bg-white rounded-2xl shadow-lg p-6 border-2 {{ $alreadyApplied ? 'border-green-200 bg-green-50' : 'border-blue-200' }}">
                    @if ($alreadyApplied)
                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Lamaran Terkirim!</h3>
                        <p class="text-sm text-gray-600 mb-4">Anda sudah melamar posisi ini. Pantau status
                            lamaran di dashboard.</p>
                        <a href="{{ route('seeker.jobs.applications', ['highlight_job_id' => $job->id]) }}"
                            class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            Lihat Status Lamaran
                        </a>
                    </div>
                    @else
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tertarik dengan posisi ini?</h3>

                    <form action="{{ route('seeker.jobs.apply', $job->id) }}" method="POST" class="space-y-4" x-data @submit.prevent="if({{ $job->matching_percentage ?? 0 }} < 75) { $dispatch('open-low-match-modal'); } else { $el.submit(); }">
                        @csrf

                        <!-- CV Preview -->
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-2">CV yang akan dikirim:</p>
                            <div class="flex items-center gap-3">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        CV_{{ Auth::user()->name }}.pdf</p>
                                    <p class="text-xs text-gray-500">2.4 MB • Updated 2 days ago</p>
                                </div>
                                <a href="{{ route('profile.edit') }}"
                                    class="text-xs text-blue-600 hover:underline ml-auto">Ganti</a>
                            </div>
                        </div>

                        <!-- Note (Optional) -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Catatan untuk
                                Recruiter (Opsional)</label>
                            <textarea name="note" rows="3" placeholder="Tulis pesan singkat mengapa Anda cocok..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-800 transition shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Lamaran Sekarang
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Dengan mengirim lamaran, Anda menyetujui <a href="#"
                            class="text-blue-600 hover:underline">Syarat & Ketentuan</a> KOMPASKARIR
                    </p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    <div class="space-y-2">
                        @if(!$alreadyApplied)
                        <form action="{{ route('seeker.jobs.save', $job->id) }}" method="POST" class="block w-full">
                            @csrf
                            @if($isSaved)
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-yellow-50 border border-yellow-300 rounded-lg text-sm font-semibold text-yellow-800 hover:bg-yellow-100 transition shadow-sm">
                                <svg class="w-5 h-5 text-yellow-600 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                Batal Simpan Lowongan
                            </button>
                            @else
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                Simpan Lowongan
                            </button>
                            @endif
                        </form>
                        @endif
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                            Bagikan Lowongan
                        </button>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Ingatkan Saya
                        </button>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tentang Perusahaan</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Industri</span>
                            <span class="font-medium text-gray-900">Teknologi / Software</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ukuran</span>
                            <span class="font-medium text-gray-900">50-200 karyawan</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Website</span>
                            <a href="{{ $job->application_url }}" target="_blank"
                                class="font-medium text-blue-600 hover:underline">
                                {{ parse_url($job->application_url, PHP_URL_HOST) }}
                            </a>
                        </div>
                    </div>
                    <a href="{{ $job->application_url }}" target="_blank"
                        class="mt-4 block w-full text-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Kunjungi Website Perusahaan
                    </a>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <!-- Low Match Modal -->
    <div x-data="{ open: false }" 
         @open-low-match-modal.window="open = true"
         x-show="open" 
         style="display: none;" 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="open = false" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Kecocokan Belum Memenuhi Syarat
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Silahkan lakukan asesmen kompetensi untuk meningkatkan peluang Anda. Minimal kecocokan yang disarankan adalah 75%.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <a href="{{ url('/seeker/assessment') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Asesmen
                    </a>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>