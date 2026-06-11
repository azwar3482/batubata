<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Roadmap Karir Anda</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Rencana aksi 6 bulan menuju posisi: <span
                        class="font-bold text-blue-600 dark:text-blue-400">{{ $latestAssessment->target_name }}</span></p>
                @if($latestAssessment->total_gap_percentage > 0)
                <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-full">
                    <span class="text-sm font-medium text-amber-700 dark:text-amber-300">Skill Gap Saat Ini:</span>
                    <span class="text-sm font-bold text-amber-900 dark:text-amber-200">{{ number_format($latestAssessment->total_gap_percentage, 1) }}%</span>
                </div>
                @endif
            </div>

            <!-- Info Card -->
            <div class="mb-8 p-5 bg-gradient-to-r from-purple-50 to-fuchsia-50 dark:from-purple-900/20 dark:to-fuchsia-900/20 border border-purple-100 dark:border-purple-800/50 rounded-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-1">Tentang Roadmap Karir</h4>
                        <p class="text-sm text-purple-700 dark:text-purple-300 leading-relaxed">Roadmap karir adalah rencana aksi personal selama <strong>6 bulan</strong> menuju posisi target Anda. Setiap tahap berisi <strong>langkah konkret</strong> berdasarkan kompetensi yang perlu ditingkatkan. Klik pada kompetensi untuk melihat kursus yang tersedia.</p>
                    </div>
                </div>
            </div>

            <!-- Container Timeline -->
            <div class="relative pl-8 md:pl-0">
                <!-- Garis Vertikal Tengah (Desktop) / Kiri (Mobile) -->
                <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-1 bg-purple-200 dark:bg-purple-800 transform md:-translate-x-1/2">
                </div>

                <div class="space-y-12">
                    @foreach ($roadmaps as $index => $item)
                        <!-- Item Timeline -->
                        <div
                            class="relative flex flex-col md:flex-row items-start {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">

                            <!-- Spacer untuk layout selang-seling -->
                            <div class="flex-1 w-full md:w-1/2"></div>

                            <!-- Titik Tengah (Bullet) -->
                            <div
                                class="absolute left-8 md:left-1/2 w-8 h-8 rounded-full border-4 border-white dark:border-slate-800 shadow-md z-10 transform -translate-x-1/2 flex items-center justify-center 
                                {{ $item->is_completed ? 'bg-green-500' : ($item->month_number <= 4 ? 'bg-purple-600' : ($item->month_number == 5 ? 'bg-blue-600' : 'bg-amber-600')) }}">
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
                                class="flex-1 w-full md:w-1/2 pl-12 md:pl-0 {{ $index % 2 == 0 ? 'md:pr-12 text-left' : 'md:pl-12 text-left md:text-left' }}">
                                <div
                                    class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-md hover:shadow-lg transition border-l-4 {{ $item->is_completed ? 'border-green-500' : ($item->month_number <= 4 ? 'border-purple-500' : ($item->month_number == 5 ? 'border-blue-500' : 'border-amber-500')) }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <span
                                            class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/30 px-2.5 py-1 rounded">
                                            Bulan {{ $item->month_number }}
                                        </span>
                                        @if ($item->is_completed)
                                            <span class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
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
                                    
                                    {{-- Parse dan tampilkan deskripsi terstruktur --}}
                                    @php
                                        $lines = explode("\n", $item->milestone_description);
                                        $focusLine = '';
                                        $skillLines = [];
                                        $courseLines = [];
                                        $otherLines = [];
                                        $section = 'focus';
                                        
                                        foreach ($lines as $line) {
                                            $trimmed = trim($line);
                                            if (empty($trimmed)) {
                                                continue;
                                            } elseif (str_starts_with($trimmed, 'Fokus bulan ini:')) {
                                                $focusLine = str_replace('Fokus bulan ini: ', '', $trimmed);
                                            } elseif ($trimmed === 'Kompetensi yang harus dipelajari:') {
                                                $section = 'skills';
                                            } elseif ($trimmed === 'Rekomendasi kursus:') {
                                                $section = 'courses';
                                            } elseif (str_starts_with($trimmed, '•')) {
                                                $skillLines[] = $trimmed;
                                            } elseif (str_starts_with($trimmed, '-')) {
                                                $courseLines[] = $trimmed;
                                            } else {
                                                $otherLines[] = $trimmed;
                                            }
                                        }

                                        // Siapkan data kursus untuk mapping
                                        $courses = $item->recommended_courses ?? [];
                                    @endphp

                                    @if($focusLine)
                                    <div class="mb-3 px-3 py-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <p class="text-sm font-medium text-purple-800 dark:text-purple-300">{{ $focusLine }}</p>
                                    </div>
                                    @endif

                                    {{-- Daftar Kompetensi (Clickable) --}}
                                    @if(!empty($skillLines))
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Kompetensi yang harus dipelajari:</p>
                                        <div class="space-y-1.5">
                                            @foreach($skillLines as $skillLine)
                                            @php
                                                // Extract skill name from line: "• SEO (Search Engine Optimization) (gap: 85.7%, Level 1 → 7)"
                                                $skillText = str_replace('• ', '', $skillLine);
                                                // Get just the skill name (before the parenthesis with gap info)
                                                $skillName = trim(preg_replace('/\(gap:.*$/', '', $skillText));
                                                
                                                // Find matching course in recommended_courses
                                                $matchedCourse = null;
                                                foreach ($courses as $course) {
                                                    if (isset($course['id'])) {
                                                        $matchedCourse = $course;
                                                        break; // Use first available course as fallback
                                                    }
                                                }
                                                
                                                // Try to find a more specific match based on skill name
                                                $skillLower = strtolower($skillName);
                                                foreach ($courses as $course) {
                                                    $titleLower = strtolower($course['title'] ?? '');
                                                    // Check if course title contains keywords from skill name
                                                    $keywords = explode(' & ', $skillLower);
                                                    foreach ($keywords as $keyword) {
                                                        $keyword = trim($keyword);
                                                        if (strlen($keyword) > 3 && str_contains($titleLower, $keyword)) {
                                                            $matchedCourse = $course;
                                                            break 2;
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
                                                <span class="text-gray-700 dark:text-gray-300 group-hover:text-purple-700 dark:group-hover:text-purple-300 transition">
                                                    {{ $skillText }}
                                                </span>
                                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-purple-500 mt-0.5 flex-shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Rekomendasi Kursus --}}
                                    @if(!empty($courseLines))
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Rekomendasi Kursus:</p>
                                        <div class="space-y-1.5">
                                            @foreach($courseLines as $courseLine)
                                            @php
                                                // Extract course title from line: "- Mastering SEO & SEM (Google Ads) (Dicoding, 40j)"
                                                $courseTitle = trim(preg_replace('/\([^)]+\)$/', '', str_replace('- ', '', $courseLine)));
                                                $courseTitle = trim(preg_replace('/\([^)]+\)$/', '', $courseTitle)); // Remove second set of parens
                                                
                                                // Find matching course by title
                                                $matchedCourse = null;
                                                foreach ($courses as $course) {
                                                    if (isset($course['title']) && str_contains(strtolower($course['title']), strtolower(substr($courseTitle, 0, 20)))) {
                                                        $matchedCourse = $course;
                                                        break;
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

                                    {{-- Catatan lain --}}
                                    @if(!empty($otherLines))
                                    <div class="mb-4">
                                        @foreach($otherLines as $otherLine)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 italic">{{ $otherLine }}</p>
                                        @endforeach
                                    </div>
                                    @endif

                                    {{-- Rekomendasi Kursus dari JSON (backup) --}}
                                    @if(!empty($courses) && empty($courseLines))
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Rekomendasi Kursus:</p>
                                        <div class="space-y-1.5">
                                            @foreach($courses as $course)
                                            <a href="{{ isset($course['id']) ? route('seeker.courses.show', $course['id']) : route('seeker.courses.index') }}" 
                                               class="flex items-center gap-2 p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-xs group hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition">
                                                <span class="font-medium text-indigo-700 dark:text-indigo-300 group-hover:text-indigo-800 dark:group-hover:text-indigo-200 transition">{{ $course['title'] ?? '' }}</span>
                                                <span class="text-gray-500">({{ $course['platform'] ?? '' }})</span>
                                                @if(isset($course['duration_hours']))
                                                <span class="text-gray-400 ml-auto">{{ $course['duration_hours'] }}j</span>
                                                @endif
                                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-indigo-500 flex-shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
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
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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

            <div class="mt-12 text-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium">
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
