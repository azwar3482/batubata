<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Roadmap Karir Anda</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Rencana aksi menuju posisi:
                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $latestAssessment->target_name }}</span>
                </p>
                @if($latestAssessment->total_gap_percentage > 0)
                <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-full">
                    <span class="text-sm font-medium text-amber-700 dark:text-amber-300">Skill Gap Saat Ini:</span>
                    <span class="text-sm font-bold text-amber-900 dark:text-amber-200">{{ number_format($latestAssessment->total_gap_percentage, 1) }}%</span>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="mt-5 flex flex-wrap justify-center gap-3">
                    @if ($latestAssessment->total_gap_percentage <= 30)
                    <a href="{{ route('seeker.jobs.all') }}"
                        class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-500/25">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Pilih Lowongan
                    </a>
                    @endif
                    <a href="{{ route('seeker.assessment.result', $latestAssessment->id) }}"
                        class="inline-flex items-center px-6 py-3 bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition border border-gray-200 dark:border-slate-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Lihat Hasil Asesmen
                    </a>
                </div>
            </div>

            {{-- ===== TAB NAVIGATION ===== --}}
            <div class="flex border-b border-gray-200 dark:border-slate-700 mb-8 gap-1">
                <button id="tab-timeline" onclick="switchTab('timeline')"
                    title="apa yang harus saya kerjakan bulan ini?"
                    class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 transition-all duration-200 rounded-t-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                    📅 Timeline Belajar
                </button>
                <button id="tab-skilltree" onclick="switchTab('skilltree')"
                    title="tempat pengguna merefleksikan diri, melihat gap mereka secara keseluruhan, dan merencanakan strategi belajar jangka panjang"
                    class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 dark:text-gray-400 transition-all duration-200 rounded-t-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                    🌳 Pohon Kompetensi
                </button>
            </div>

            {{-- ===========================
                 TAB 1: TIMELINE BELAJAR
                 =========================== --}}
            <div id="content-timeline">

                {{-- Info Card --}}
                @if ($latestAssessment->total_gap_percentage <= 30)
                <div class="mb-8 p-5 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-100 dark:border-green-800/50 rounded-xl">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-green-900 dark:text-green-200 mb-1">Skill Gap Rendah - Anda Siap!</h4>
                            <p class="text-sm text-green-700 dark:text-green-300 leading-relaxed">Selamat! Skill gap Anda hanya <strong>{{ number_format($latestAssessment->total_gap_percentage, 1) }}%</strong> yang berarti Anda sudah memenuhi kualifikasi untuk posisi ini. Anda bisa langsung melamar pekerjaan atau menggunakan roadmap ini untuk meningkatkan skill lebih lanjut.</p>
                            <a href="{{ route('seeker.jobs.all') }}" class="mt-3 inline-flex items-center text-sm font-bold text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100 transition">
                                🔍 Cari Lowongan Sekarang
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-8 p-5 bg-gradient-to-r from-purple-50 to-fuchsia-50 dark:from-purple-900/20 dark:to-fuchsia-900/20 border border-purple-100 dark:border-purple-800/50 rounded-xl">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-1">Tentang Roadmap Karir</h4>
                            <p class="text-sm text-purple-700 dark:text-purple-300 leading-relaxed">Roadmap karir adalah rencana aksi personal selama <strong>6 bulan</strong> menuju posisi target Anda. Setiap tahap berisi <strong>langkah konkret</strong> berdasarkan kompetensi yang perlu ditingkatkan. Klik pada kompetensi untuk melihat kursus yang tersedia.</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Container Timeline --}}
                <div class="relative pl-8 md:pl-0">
                    <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-1 bg-purple-200 dark:bg-purple-800 transform md:-translate-x-1/2"></div>

                    <div class="space-y-12">
                        @foreach ($roadmaps as $index => $item)
                            <div class="relative flex flex-col md:flex-row items-start {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">
                                <div class="flex-1 w-full md:w-1/2"></div>

                                <div class="absolute left-8 md:left-1/2 w-8 h-8 rounded-full border-4 border-white dark:border-slate-800 shadow-md z-10 transform -translate-x-1/2 flex items-center justify-center
                                    {{ $item->is_completed ? 'bg-green-500' : ($item->month_number <= 4 ? 'bg-purple-600' : ($item->month_number == 5 ? 'bg-blue-600' : 'bg-amber-600')) }}">
                                    @if ($item->is_completed)
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span class="text-xs font-bold text-white">{{ $item->month_number }}</span>
                                    @endif
                                </div>

                                <div class="flex-1 w-full md:w-1/2 pl-12 md:pl-0 {{ $index % 2 == 0 ? 'md:pr-12' : 'md:pl-12' }}">
                                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-md hover:shadow-lg transition border-l-4
                                        {{ $item->is_completed ? 'border-green-500' : ($item->month_number <= 4 ? 'border-purple-500' : ($item->month_number == 5 ? 'border-blue-500' : 'border-amber-500')) }}">
                                        <div class="flex justify-between items-start mb-3">
                                            <span class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/30 px-2.5 py-1 rounded">
                                                Bulan {{ $item->month_number }}
                                            </span>
                                            @if ($item->is_completed)
                                                <span class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @elseif($item->gap_percentage)
                                                <span class="text-xs font-bold {{ $item->gap_percentage > 50 ? 'text-red-600 dark:text-red-400' : 'text-amber-600 dark:text-amber-400' }}">
                                                    Gap: {{ number_format($item->gap_percentage, 1) }}%
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ $item->milestone_title }}</h3>

                                        @php
                                            $lines = explode("\n", $item->milestone_description);
                                            $focusLine   = '';
                                            $skillLines  = [];
                                            $courseLines = [];
                                            $otherLines  = [];

                                            foreach ($lines as $line) {
                                                $trimmed = trim($line);
                                                if (empty($trimmed)) continue;
                                                if (str_starts_with($trimmed, 'Fokus bulan ini:')) {
                                                    $focusLine = str_replace('Fokus bulan ini: ', '', $trimmed);
                                                } elseif ($trimmed === 'Kompetensi yang harus dipelajari:') {
                                                    // section header, skip
                                                } elseif ($trimmed === 'Rekomendasi kursus:') {
                                                    // section header, skip
                                                } elseif (str_starts_with($trimmed, '•')) {
                                                    $skillLines[] = $trimmed;
                                                } elseif (str_starts_with($trimmed, '-')) {
                                                    $courseLines[] = $trimmed;
                                                } else {
                                                    $otherLines[] = $trimmed;
                                                }
                                            }
                                            $courses = $item->recommended_courses ?? [];
                                        @endphp

                                        @if($focusLine)
                                        <div class="mb-3 px-3 py-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                            <p class="text-sm font-medium text-purple-800 dark:text-purple-300">{{ $focusLine }}</p>
                                        </div>
                                        @endif

                                        @if(!empty($skillLines))
                                        <div class="mb-4">
                                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Kompetensi yang harus dipelajari:</p>
                                            <div class="space-y-1.5">
                                                @foreach($skillLines as $skillLine)
                                                @php
                                                    $skillText   = str_replace('• ', '', $skillLine);
                                                    $skillName   = trim(preg_replace('/\(gap:.*$/', '', $skillText));
                                                    $matchedCourse = null;
                                                    foreach ($courses as $course) {
                                                        if (isset($course['id'])) { $matchedCourse = $course; break; }
                                                    }
                                                    $skillLower = strtolower($skillName);
                                                    foreach ($courses as $course) {
                                                        $titleLower = strtolower($course['title'] ?? '');
                                                        foreach (explode(' & ', $skillLower) as $kw) {
                                                            if (strlen(trim($kw)) > 3 && str_contains($titleLower, trim($kw))) {
                                                                $matchedCourse = $course; break 2;
                                                            }
                                                        }
                                                    }
                                                    $courseUrl = $matchedCourse
                                                        ? route('seeker.courses.show', $matchedCourse['id'])
                                                        : route('seeker.courses.index');
                                                @endphp
                                                <a href="{{ $courseUrl }}"
                                                   class="flex items-start gap-2 text-sm group px-2 py-1.5 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                                    <span class="text-purple-500 dark:text-purple-400 mt-0.5 flex-shrink-0">▸</span>
                                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-purple-700 dark:group-hover:text-purple-300 transition">{{ $skillText }}</span>
                                                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-purple-500 mt-0.5 flex-shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        @if(!empty($courseLines))
                                        <div class="mb-4">
                                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Rekomendasi Kursus:</p>
                                            <div class="space-y-1.5">
                                                @foreach($courseLines as $courseLine)
                                                @php
                                                    $courseTitle = trim(preg_replace('/\([^)]+\)$/', '', str_replace('- ', '', $courseLine)));
                                                    $courseTitle = trim(preg_replace('/\([^)]+\)$/', '', $courseTitle));
                                                    $matchedCourse = null;
                                                    foreach ($courses as $course) {
                                                        if (isset($course['title']) && str_contains(strtolower($course['title']), strtolower(substr($courseTitle, 0, 20)))) {
                                                            $matchedCourse = $course; break;
                                                        }
                                                    }
                                                    $courseUrl = $matchedCourse
                                                        ? route('seeker.courses.show', $matchedCourse['id'])
                                                        : route('seeker.courses.index');
                                                @endphp
                                                <a href="{{ $courseUrl }}"
                                                   class="flex items-center gap-2 p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-xs group hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition">
                                                    <svg class="w-3.5 h-3.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 transition flex-1">{{ str_replace('- ', '', $courseLine) }}</span>
                                                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-indigo-500 flex-shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        @if(!empty($otherLines))
                                        <div class="mb-4">
                                            @foreach($otherLines as $ol)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 italic">{{ $ol }}</p>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if(!empty($courses) && empty($courseLines))
                                        <div class="mb-4">
                                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Rekomendasi Kursus:</p>
                                            <div class="space-y-1.5">
                                                @foreach($courses as $course)
                                                <a href="{{ isset($course['id']) ? route('seeker.courses.show', $course['id']) : route('seeker.courses.index') }}"
                                                   class="flex items-center gap-2 p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-xs group hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition">
                                                    <span class="font-medium text-indigo-700 dark:text-indigo-300 group-hover:text-indigo-800 transition">{{ $course['title'] ?? '' }}</span>
                                                    <span class="text-gray-500">({{ $course['platform'] ?? '' }})</span>
                                                    @if(isset($course['duration_hours']))
                                                    <span class="text-gray-400 ml-auto">{{ $course['duration_hours'] }}j</span>
                                                    @endif
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        @if (!$item->is_completed)
                                            <form action="{{ route('seeker.roadmap.complete', $item->id) }}" method="POST" class="mt-4">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 dark:bg-purple-900/30 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/50 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Tandai Selesai
                                                </button>
                                            </form>
                                        @else
                                            <div class="mt-4 text-xs text-gray-400 dark:text-gray-500 italic flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Diselesaikan pada {{ $item->completed_at->format('d M Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-12 text-center space-y-4">
                    @if ($latestAssessment->total_gap_percentage <= 30)
                    <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl border border-green-200 dark:border-green-800 max-w-md mx-auto">
                        <div class="text-4xl mb-3">🎯</div>
                        <h3 class="text-lg font-bold text-green-800 dark:text-green-200 mb-2">Skill Gap Anda Rendah!</h3>
                        <p class="text-sm text-green-600 dark:text-green-400 mb-4">Anda sudah siap untuk melamar pekerjaan. Jelajahi lowongan yang tersedia sekarang!</p>
                        <a href="{{ route('seeker.jobs.all') }}"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-500/25">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Cari Lowongan Sekarang
                        </a>
                    </div>
                    @endif
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>{{-- /content-timeline --}}

            {{-- ===========================
                 TAB 2: POHON KOMPETENSI
                 =========================== --}}
            <div id="content-skilltree" class="hidden">

                @php
                    // ── Parse treeNodes dari milestone_description ──
                    $treeNodes  = [];
                    $nodeIndex  = 0;

                    foreach ($roadmaps as $roadmap) {
                        $descLines = explode("\n", $roadmap->milestone_description ?? '');
                        foreach ($descLines as $dline) {
                            $dline = trim($dline);
                            if (!str_starts_with($dline, '•')) continue;

                            $skillText = trim(ltrim($dline, '•'));
                            preg_match('/\(gap:\s*([\d.]+)%,\s*Level\s*(\d+)\s*→\s*(\d+)\)/', $skillText, $m);
                            $skillName = trim(preg_replace('/\s*\(gap:.*$/', '', $skillText));
                            $nodeIndex++;

                            $treeNodes[] = [
                                'id'            => 'node_' . $nodeIndex,
                                'name'          => $skillName,
                                'month'         => (int) $roadmap->month_number,
                                'gap_pct'       => isset($m[1]) ? (float)$m[1] : (float)($roadmap->gap_percentage ?? 0),
                                'current_level' => isset($m[2]) ? (int)$m[2]   : (int)($roadmap->current_level ?? 0),
                                'target_level'  => isset($m[3]) ? (int)$m[3]   : (int)($roadmap->target_level  ?? 5),
                                'priority'      => $roadmap->priority ?? 'medium',
                                'is_completed'  => (bool) $roadmap->is_completed,
                                'courses'       => $roadmap->recommended_courses ?? [],
                                'status'        => $roadmap->is_completed
                                                   ? 'unlocked'
                                                   : ($roadmap->month_number <= 2 ? 'gap' : 'locked'),
                            ];
                        }
                    }

                    // ── Fallback: gunakan assessmentScores jika format • tidak ada ──
                    if (empty($treeNodes) && !empty($assessmentScores)) {
                        foreach ($assessmentScores as $idx => $score) {
                            $month = match(true) {
                                $idx < 4  => 1,
                                $idx < 8  => 2,
                                $idx < 12 => 3,
                                $idx < 16 => 4,
                                $idx < 20 => 5,
                                default   => 6,
                            };
                            $treeNodes[] = [
                                'id'            => 'score_' . ($idx + 1),
                                'name'          => $score['name'],
                                'month'         => $month,
                                'gap_pct'       => (float) $score['gap_percentage'],
                                'current_level' => (int)   $score['current_level'],
                                'target_level'  => (int)   $score['target_level'],
                                'priority'      => $score['priority'],
                                'is_completed'  => false,
                                'courses'       => [],
                                'status'        => (float)$score['gap_percentage'] == 0
                                                   ? 'unlocked'
                                                   : ($month <= 2 ? 'gap' : 'locked'),
                            ];
                        }
                    }

                    $doneCount  = count(array_filter($treeNodes, fn($n) => $n['is_completed']));
                    $totalCount = count($treeNodes);
                @endphp

                {{-- ── JSON data untuk JS ── --}}
                <script>
                    var skillTreeData  = @json($treeNodes);
                    var stTarget       = @json($latestAssessment->target_name);
                    var stTotalGap     = {{ (float) $latestAssessment->total_gap_percentage }};
                    var stDone         = {{ $doneCount }};
                    var stTotal        = {{ $totalCount }};
                </script>

                {{-- ── Info card ── --}}
                @if ($latestAssessment->total_gap_percentage <= 30)
                <div class="mb-6 p-5 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-100 dark:border-green-800/50 rounded-xl">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center text-xl">🌳</div>
                        <div>
                            <h4 class="text-sm font-bold text-green-900 dark:text-green-200 mb-1">Pohon Kompetensi - Skill Gap Rendah!</h4>
                            <p class="text-sm text-green-700 dark:text-green-300 leading-relaxed">
                                Visualisasi menunjukkan Anda sudah menguasai sebagian besar kompetensi.
                                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Hijau</span> = dikuasai ·
                                <span class="font-semibold text-amber-500">Kuning</span> = perlu peningkatan minor.
                                <br><span class="font-semibold mt-1 inline-block">🎯 Anda sudah siap melamar pekerjaan!</span>
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-6 p-5 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-xl">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center text-xl">🌳</div>
                        <div>
                            <h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-200 mb-1">Pohon Kompetensi</h4>
                            <p class="text-sm text-indigo-700 dark:text-indigo-300 leading-relaxed">
                                Visualisasi seluruh kompetensi diurutkan per bulan &amp; prioritas.
                                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Hijau</span> = dikuasai ·
                                <span class="font-semibold text-red-500">Merah</span> = gap tinggi ·
                                <span class="font-semibold text-amber-500">Kuning</span> = gap sedang ·
                                <span class="font-semibold text-gray-400">Abu-abu</span> = terkunci.
                                <br><span class="font-semibold mt-1 inline-block">💡 Klik node untuk membuka modal dengan daftar kursus rekomendasi + tombol upload sertifikat.</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ── Stats bar ── --}}
                <div class="flex flex-wrap gap-3 mb-6 justify-center">
                    <div class="px-5 py-2.5 bg-indigo-600 text-white rounded-full text-sm font-bold shadow flex items-center gap-2">
                        🎯 <span>{{ $latestAssessment->target_name }}</span>
                    </div>
                    <div class="px-5 py-2.5 {{ $latestAssessment->total_gap_percentage <= 30 ? 'bg-green-500' : 'bg-amber-500' }} text-white rounded-full text-sm font-bold shadow flex items-center gap-2">
                        📊 Gap: {{ number_format($latestAssessment->total_gap_percentage, 1) }}%
                    </div>
                    <div class="px-5 py-2.5 bg-emerald-600 text-white rounded-full text-sm font-bold shadow flex items-center gap-2">
                        ✅ {{ $doneCount }}/{{ $totalCount }} Selesai
                    </div>
                    @if ($latestAssessment->total_gap_percentage <= 30)
                    <a href="{{ route('seeker.jobs.all') }}" class="px-5 py-2.5 bg-green-600 text-white rounded-full text-sm font-bold shadow flex items-center gap-2 hover:bg-green-700 transition">
                        🔍 Pilih Lowongan
                    </a>
                    @endif
                </div>

                {{-- ── Legend ── --}}
                <div class="flex flex-wrap gap-4 mb-8 justify-center text-xs font-medium text-gray-600 dark:text-gray-400">
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-emerald-500 inline-block"></span> Dikuasai</span>
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-red-400 inline-block"></span> Gap Tinggi</span>
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-amber-400 inline-block"></span> Gap Sedang</span>
                    <!-- <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-green-400 inline-block"></span> Gap Rendah</span> -->
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-gray-300 dark:bg-gray-600 inline-block"></span> Terkunci</span>
                </div>

                {{-- ── Canvas ── --}}
                @if($totalCount > 0)
                <div class="overflow-x-auto rounded-2xl bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 p-4">
                    <div id="skill-tree-canvas" style="position:relative; min-height:640px; min-width:660px;">

                        {{-- SVG untuk garis konektor --}}
                        <svg id="tree-svg"
                             style="position:absolute;top:0;left:0;width:100%;height:100%;overflow:visible;pointer-events:none;"
                             xmlns="http://www.w3.org/2000/svg"></svg>

                        {{-- Root node (posisi: tengah atas) --}}
                        <div id="root-node"
                             style="position:absolute;top:0;left:50%;transform:translateX(-50%);z-index:20;min-width:180px;"
                             class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white rounded-2xl px-5 py-3 shadow-xl text-center">
                            <div class="text-2xl mb-1">🎯</div>
                            <p class="text-sm font-extrabold leading-tight">{{ $latestAssessment->target_name }}</p>
                            <p class="text-xs text-indigo-200 mt-0.5">Posisi Target</p>
                        </div>

                        {{-- Nodes dirender oleh JS --}}
                        <div id="tree-nodes" style="position:absolute;top:0;left:0;width:100%;height:100%;"></div>

                    </div>
                </div>
                @else
                {{-- Empty state --}}
                <div class="text-center py-16 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-gray-300 dark:border-slate-700">
                    <div class="text-6xl mb-4">🌱</div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Pohon Kompetensi Belum Tersedia</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Generate roadmap terlebih dahulu dari halaman hasil asesmen.</p>
                    <a href="{{ route('seeker.assessment.history') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition">
                        Lihat Riwayat Asesmen →
                    </a>
                </div>
                @endif

            </div>{{-- /content-skilltree --}}

        </div>
    </div>

    {{-- ══════════════════ MODAL ══════════════════ --}}
    <div id="node-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         aria-modal="true" role="dialog">
        <div id="node-modal-box"
             class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto
                    transform scale-95 opacity-0 transition-all duration-200">

            {{-- Header --}}
            <div id="modal-header-bg" class="p-5 rounded-t-2xl bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <span id="modal-priority-badge"
                              class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-white/20 mb-2 inline-block"></span>
                        <h3 id="modal-title" class="text-base font-extrabold leading-snug mt-1"></h3>
                        <p class="text-indigo-100 text-xs mt-1">
                            Level <span id="modal-current-level" class="font-bold text-white"></span>
                            &rarr;
                            <span id="modal-target-level" class="font-bold text-white"></span>
                        </p>
                    </div>
                    <button onclick="closeNodeModal()"
                            class="flex-shrink-0 p-1.5 hover:bg-white/20 rounded-xl transition" aria-label="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                {{-- Progress bar --}}
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-white/80 mb-1">
                        <span>Kemajuan Penguasaan</span>
                        <span id="modal-progress-pct" class="font-bold text-white"></span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div id="modal-progress-bar" class="h-2 rounded-full bg-white transition-all duration-700" style="width:0%"></div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-5 space-y-4">

                {{-- Gap info --}}
                <div class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-700">
                    <span class="text-3xl">⚡</span>
                    <div>
                        <p class="text-sm font-bold text-amber-800 dark:text-amber-200">Skill Gap yang Perlu Ditutup</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">
                            <span id="modal-gap-pct" class="font-extrabold text-xl text-amber-700 dark:text-amber-300"></span>% perlu ditingkatkan
                        </p>
                    </div>
                </div>

                {{-- Kursus + Upload Sertifikat --}}
                <div>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">🚀 Pilihan Peningkatan Skill:</p>
                    <div id="modal-courses" class="space-y-2 mb-3"></div>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 p-3.5 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-200 dark:border-purple-700
                              hover:bg-purple-100 dark:hover:bg-purple-900/40 transition group">
                        <span class="text-2xl">📤</span>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-purple-800 dark:text-purple-200">Upload Sertifikat Kompetensi</p>
                            <p class="text-xs text-purple-600 dark:text-purple-400 mt-0.5">Buktikan kemampuan → UNLOCK Instan!</p>
                        </div>
                        <svg class="w-4 h-4 text-purple-400 group-hover:text-purple-600 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- Bulan badge --}}
                <div class="text-center">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs font-medium">
                        📅 <span id="modal-month-text"></span>
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════ SCRIPTS ══════════════════ --}}
    <script>
    /* ─────────────── TAB SWITCHING ─────────────── */
    function switchTab(tab) {
        var elTl = document.getElementById('content-timeline');
        var elSt = document.getElementById('content-skilltree');
        var btnTl = document.getElementById('tab-timeline');
        var btnSt = document.getElementById('tab-skilltree');

        var activeC   = ['border-indigo-600','text-indigo-600','dark:text-indigo-400','dark:border-indigo-400'];
        var inactiveC = ['border-transparent','text-gray-500','dark:text-gray-400'];

        if (tab === 'timeline') {
            elTl.classList.remove('hidden');
            elSt.classList.add('hidden');
            activeC.forEach(c => btnTl.classList.add(c));
            inactiveC.forEach(c => btnTl.classList.remove(c));
            inactiveC.forEach(c => btnSt.classList.add(c));
            activeC.forEach(c => btnSt.classList.remove(c));
        } else {
            elTl.classList.add('hidden');
            elSt.classList.remove('hidden');
            activeC.forEach(c => btnSt.classList.add(c));
            inactiveC.forEach(c => btnSt.classList.remove(c));
            inactiveC.forEach(c => btnTl.classList.add(c));
            activeC.forEach(c => btnTl.classList.remove(c));

            if (!window._treeRendered && typeof skillTreeData !== 'undefined' && skillTreeData.length > 0) {
                window._treeRendered = true;
                requestAnimationFrame(function() {
                    renderSkillTree(skillTreeData);
                });
            }
        }
    }

    /* ─────────────── SKILL TREE RENDERER ─────────────── */
    var NODE_W   = 160;
    var NODE_H   = 128;
    var COL_GAP  = 24;
    var ROW_GAP  = 72;
    var ROOT_BOT = 100; // root node bottom (top + height approx)
    var START_Y  = ROOT_BOT + 56;

    function renderSkillTree(data) {
        var canvas   = document.getElementById('tree-nodes');
        var svgEl    = document.getElementById('tree-svg');
        var canvasEl = document.getElementById('skill-tree-canvas');
        if (!canvas || !svgEl || !canvasEl) return;

        canvas.innerHTML = '';
        svgEl.innerHTML  = '';

        // Group by month
        var byMonth = {};
        data.forEach(function(node) {
            if (!byMonth[node.month]) byMonth[node.month] = [];
            byMonth[node.month].push(node);
        });
        var months = Object.keys(byMonth).map(Number).sort(function(a,b){return a-b;});

        var maxPerRow   = Math.max.apply(null, months.map(function(m){return byMonth[m].length;}));
        var canvasWidth = Math.max(680, maxPerRow * (NODE_W + COL_GAP) + COL_GAP * 2);

        canvasEl.style.minWidth  = canvasWidth + 'px';
        canvasEl.style.minHeight = (START_Y + months.length * (NODE_H + ROW_GAP) + 40) + 'px';

        var positions = {}; // id -> {cx, topY}

        months.forEach(function(month, mIdx) {
            var nodes        = byMonth[month];
            var rowW         = nodes.length * NODE_W + (nodes.length - 1) * COL_GAP;
            var rowStartX    = (canvasWidth - rowW) / 2;
            var rowY         = START_Y + mIdx * (NODE_H + ROW_GAP);

            nodes.forEach(function(node, nIdx) {
                var leftX = rowStartX + nIdx * (NODE_W + COL_GAP);
                var cx    = leftX + NODE_W / 2;

                positions[node.id] = { cx: cx, topY: rowY };

                var el = buildNodeEl(node, leftX, rowY);
                canvas.appendChild(el);
            });
        });

        // Root node center (calculated from canvasWidth)
        var rootCX = canvasWidth / 2;
        var rootCY = ROOT_BOT;

        drawLines(svgEl, rootCX, rootCY, byMonth, months, positions);
    }

    function buildNodeEl(node, leftX, topY) {
        var div = document.createElement('div');
        div.style.cssText = [
            'position:absolute',
            'left:' + leftX + 'px',
            'top:'  + topY  + 'px',
            'width:' + NODE_W + 'px',
            'min-height:' + NODE_H + 'px',
            'z-index:10',
            'box-sizing:border-box',
        ].join(';');

        var bg, border, icon, barColor;
        var clickable = (node.status !== 'locked');
        var hover = clickable ? ' cursor-pointer' : ' cursor-not-allowed opacity-60';

        if (node.status === 'unlocked') {
            bg = 'background:#ecfdf5'; border = '#34d399'; icon = '✅'; barColor = '#10b981';
        } else if (node.status === 'gap') {
            if (node.priority === 'high')       { bg='background:#fff1f2'; border='#f87171'; icon='🔴'; barColor='#f87171'; }
            else if (node.priority === 'low')   { bg='background:#f0fdf4'; border='#4ade80'; icon='🟢'; barColor='#4ade80'; }
            else                                { bg='background:#fffbeb'; border='#fbbf24'; icon='🟡'; barColor='#fbbf24'; }
        } else {
            bg='background:#f3f4f6'; border='#d1d5db'; icon='🔒'; barColor='#9ca3af';
        }

        div.className = hover;
        // dark mode approach: use inline style for background, rely on tailwind for text
        div.style.cssText += ';' + bg + ';border:2px solid ' + border + ';border-radius:12px;padding:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);transition:transform .15s,box-shadow .15s;';

        var pct = Math.max(0, 100 - node.gap_pct).toFixed(0);
        var levelHtml = '';
        if (node.status !== 'locked') {
            levelHtml = [
                '<div style="display:flex;justify-content:space-between;margin-top:8px;font-size:10px;color:#6b7280;">',
                '<span>Lv.' + node.current_level + '→' + node.target_level + '</span>',
                '<span style="font-weight:700;color:' + (node.gap_pct > 50 ? '#ef4444' : '#f59e0b') + '">-' + parseFloat(node.gap_pct).toFixed(0) + '%</span>',
                '</div>',
                '<div style="background:#e5e7eb;border-radius:999px;height:5px;margin-top:4px;">',
                '<div style="background:' + barColor + ';width:' + pct + '%;height:5px;border-radius:999px;transition:width .4s;"></div>',
                '</div>',
                '<p style="font-size:9px;font-weight:700;color:#7c3aed;text-align:center;margin-top:6px;">Bulan ' + node.month + '</p>',
            ].join('');
        } else {
            levelHtml = '<p style="font-size:9px;color:#9ca3af;text-align:center;margin-top:6px;font-style:italic;">Selesaikan bulan sebelumnya</p>' +
                        '<p style="font-size:9px;font-weight:700;color:#9ca3af;text-align:center;margin-top:2px;">Bulan ' + node.month + '</p>';
        }

        div.innerHTML = [
            '<div style="text-align:center;">',
            '<span style="font-size:18px;line-height:1;">' + icon + '</span>',
            '<p title="' + node.name.replace(/"/g,'&quot;') + '"',
               'style="font-size:11px;font-weight:700;color:#1f2937;margin-top:4px;line-height:1.3;',
               'display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">' + node.name + '</p>',
            levelHtml,
            '</div>',
        ].join('');

        if (clickable) {
            div.addEventListener('mouseenter', function(){ div.style.transform='translateY(-3px)'; div.style.boxShadow='0 6px 18px rgba(0,0,0,.14)'; });
            div.addEventListener('mouseleave', function(){ div.style.transform='';               div.style.boxShadow='0 2px 8px rgba(0,0,0,.08)'; });
            div.addEventListener('click', function(){ openNodeModal(node); });
        }

        return div;
    }

    function drawLines(svgEl, rootCX, rootCY, byMonth, months, positions) {
        var isDark   = document.documentElement.classList.contains('dark');
        var lineMain = isDark ? '#818cf8' : '#6366f1';
        var lineLock = isDark ? '#374151' : '#d1d5db';

        months.forEach(function(month, mIdx) {
            var nodes = byMonth[month];
            nodes.forEach(function(node) {
                var pos = positions[node.id];
                if (!pos) return;

                var x2 = pos.cx;
                var y2 = pos.topY;
                var x1, y1;

                if (mIdx === 0) {
                    x1 = rootCX;
                    y1 = rootCY;
                } else {
                    // connect from the row above's center-most node
                    var prevNodes = byMonth[months[mIdx - 1]];
                    var midNode   = prevNodes[Math.floor(prevNodes.length / 2)] || prevNodes[0];
                    var midPos    = positions[midNode.id];
                    if (!midPos) return;
                    x1 = midPos.cx;
                    y1 = midPos.topY + NODE_H;
                }

                var ctrl  = (y1 + y2) / 2;
                var color = (node.status === 'locked') ? lineLock : lineMain;
                var dash  = (node.status === 'locked') ? '5,4' : 'none';
                var op    = (node.status === 'locked') ? '0.4' : '0.65';

                var path = document.createElementNS('http://www.w3.org/2000/svg','path');
                path.setAttribute('d',    'M '+x1+' '+y1+' C '+x1+' '+ctrl+', '+x2+' '+ctrl+', '+x2+' '+y2);
                path.setAttribute('stroke', color);
                path.setAttribute('stroke-width', node.status==='locked' ? '1.5' : '2.5');
                path.setAttribute('fill', 'none');
                path.setAttribute('stroke-dasharray', dash);
                path.setAttribute('opacity', op);
                path.setAttribute('stroke-linecap','round');
                svgEl.appendChild(path);
            });
        });
    }

    /* ─────────────── MODAL ─────────────── */
    function openNodeModal(node) {
        var modal    = document.getElementById('node-modal');
        var modalBox = document.getElementById('node-modal-box');

        document.getElementById('modal-title').textContent         = node.name;
        document.getElementById('modal-current-level').textContent = node.current_level;
        document.getElementById('modal-target-level').textContent  = node.target_level;
        document.getElementById('modal-month-text').textContent    = 'Bulan ke-' + node.month;

        var gap  = parseFloat(node.gap_pct);
        var prog = Math.max(0, 100 - gap).toFixed(1);
        document.getElementById('modal-gap-pct').textContent        = gap.toFixed(1);
        document.getElementById('modal-progress-pct').textContent   = prog + '%';
        document.getElementById('modal-progress-bar').style.width   = prog + '%';

        var priorityMap = { high:'🔴 Prioritas Tinggi', medium:'🟡 Prioritas Sedang', low:'🟢 Prioritas Rendah' };
        document.getElementById('modal-priority-badge').textContent = priorityMap[node.priority] || node.priority;

        // header gradient
        var hdr = document.getElementById('modal-header-bg');
        var gradMap = {
            unlocked: 'from-emerald-600 to-teal-700',
            high:     'from-red-600 to-rose-700',
            low:      'from-green-600 to-emerald-700',
        };
        var gradKey = node.status === 'unlocked' ? 'unlocked' : (node.priority === 'high' ? 'high' : (node.priority === 'low' ? 'low' : ''));
        hdr.className = 'p-5 rounded-t-2xl bg-gradient-to-r ' + (gradMap[gradKey] || 'from-amber-500 to-orange-600') + ' text-white';

        // courses
        var cd = document.getElementById('modal-courses');
        cd.innerHTML = '';
        if (node.courses && node.courses.length > 0) {
            node.courses.forEach(function(c) {
                var href = c.id ? '/seeker/courses/' + c.id : '/seeker/courses';
                cd.innerHTML += '<a href="' + href + '" class="flex items-center gap-3 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-200 dark:border-indigo-700 hover:bg-indigo-100 transition group">'
                    + '<span class="text-2xl">📖</span>'
                    + '<div class="flex-1 min-w-0"><p class="text-sm font-bold text-indigo-800 dark:text-indigo-200 truncate">' + (c.title||'Kursus Terkait') + '</p>'
                    + '<p class="text-xs text-indigo-500 mt-0.5">' + (c.platform||'') + (c.duration_hours ? ' · '+c.duration_hours+' jam':'') + '</p></div>'
                    + '<svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>';
            });
        } else {
            cd.innerHTML = '<a href="/seeker/courses" class="flex items-center gap-3 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-200 dark:border-indigo-700 hover:bg-indigo-100 transition">'
                + '<span class="text-2xl">📚</span>'
                + '<div class="flex-1"><p class="text-sm font-bold text-indigo-800 dark:text-indigo-200">Jelajahi Kursus Terkait</p>'
                + '<p class="text-xs text-indigo-500 mt-0.5">Temukan kursus yang sesuai</p></div></a>';
        }

        // show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(function(){
            requestAnimationFrame(function(){
                modalBox.style.transform = 'scale(1)';
                modalBox.style.opacity   = '1';
            });
        });
    }

    function closeNodeModal() {
        var modal    = document.getElementById('node-modal');
        var modalBox = document.getElementById('node-modal-box');
        modalBox.style.transform = 'scale(0.95)';
        modalBox.style.opacity   = '0';
        setTimeout(function(){
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 180);
    }

    document.getElementById('node-modal').addEventListener('click', function(e) {
        if (e.target === this) closeNodeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeNodeModal();
    });

    /* resize: re-render tree */
    var _resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(_resizeTimer);
        _resizeTimer = setTimeout(function(){
            if (window._treeRendered && typeof skillTreeData !== 'undefined' && skillTreeData.length > 0) {
                renderSkillTree(skillTreeData);
            }
        }, 200);
    });
    </script>
</x-app-layout>
