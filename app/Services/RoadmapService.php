<?php

namespace App\Services;

use App\Models\UserAssessment;
use App\Models\CareerRoadmap;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class RoadmapService
{
    /**
     * Mapping kata kunci untuk mengelompokkan kompetensi yang mirip
     */
    private array $skillGroups = [
        'seo_sem' => ['seo', 'sem', 'search engine', 'google ads', 'google tag'],
        'analytics' => ['analytics', 'google analytics', 'a/b testing', 'tag manager'],
        'social_media' => ['social media', 'facebook ads', 'instagram', 'tiktok'],
        'content' => ['content', 'copywriting', 'content strategy'],
        'email_automation' => ['email', 'marketing automation', 'automation'],
        'communication' => ['communication', 'komunikasi', 'presentasi'],
        'creative' => ['creative', 'kreativitas', 'problem solving', 'design thinking'],
        'analytical' => ['analytical', 'analisis', 'data-driven'],
        'management' => ['time management', 'project management', 'leadership'],
        'programming' => ['programming', 'coding', 'web development', 'software development', 'laravel', 'php', 'javascript', 'python', 'java', 'c++', 'database', 'sql'],
        'finance_accounting' => ['finance', 'accounting', 'pembukuan', 'tax', 'perpajakan', 'auditing', 'budgeting', 'financial analysis'],
        'engineering' => ['engineering', 'mechanical', 'electrical', 'civil', 'autocad', 'design engineering', 'pemeliharaan', 'maintenance'],
        'healthcare' => ['healthcare', 'medis', 'nursing', 'keperawatan', 'farmasi', 'pharmacy', 'klinis', 'clinical'],
        'sales_customer_service' => ['sales', 'penjualan', 'customer service', 'negotiation', 'negosiasi', 'telemarketing'],
    ];

    public function generateRoadmap(UserAssessment $assessment)
    {
        return DB::transaction(function () use ($assessment) {
            $deleteQuery = CareerRoadmap::where('user_id', $assessment->user_id);
            if ($assessment->position_id) {
                $deleteQuery->where('position_id', $assessment->position_id);
            }
            $deleteQuery->delete();

            // Ambil SEMUA skill yang memiliki gap > 0
            $scores = $assessment->scores()
                ->with('competency')
                ->where('gap_percentage', '>', 0)
                ->orderByDesc('gap_percentage')
                ->get();

            if ($scores->isEmpty()) {
                $this->createGenericRoadmap($assessment);
                return true;
            }

            // Kelompokkan kompetensi berdasarkan kesamaan topik
            $grouped = $this->groupCompetenciesByTheme($scores);

            // Distribusikan ke 6 bulan
            $monthBuckets = $this->distributeToMonths($grouped, 6);

            $roadmaps = [];
            $targetName = $assessment->target_name;

            foreach ($monthBuckets as $monthNumber => $bucket) {
                // Bulan 5 & 6: Portofolio & Persiapan Karir (special handling)
                if (isset($bucket['is_portfolio']) || isset($bucket['is_career'])) {
                    $roadmaps[] = [
                        'month_number' => $monthNumber,
                        'title' => "Bulan {$monthNumber}: {$bucket['theme']}",
                        'desc' => $bucket['description'],
                        'competency_ids' => [],
                        'skills_data' => [],
                    ];
                    continue;
                }

                if (empty($bucket['skills'])) continue;

                $skillNames = collect($bucket['skills'])->pluck('name')->join(', ');
                $avgGap = collect($bucket['skills'])->avg('gap_percentage');
                $maxGap = collect($bucket['skills'])->max('gap_percentage');
                $themeName = $bucket['theme'];

                // Bangun deskripsi detail dengan semua kompetensi di bulan ini
                $descLines = [];
                $descLines[] = "Fokus bulan ini: {$themeName}";
                $descLines[] = "";
                $descLines[] = "Kompetensi yang harus dipelajari:";

                $allCourses = [];
                foreach ($bucket['skills'] as $skill) {
                    $levelInfo = "Level {$skill['current_level']} → {$skill['target_level']}";
                    $descLines[] = "• {$skill['name']} (gap: {$skill['gap_formatted']}%, {$levelInfo})";

                    // Ambil kursus untuk kompetensi ini
                    if (!empty($skill['courses'])) {
                        foreach ($skill['courses'] as $course) {
                            $allCourses[] = $course;
                        }
                    }
                }

                // Tambahkan rekomendasi kursus
                if (!empty($allCourses)) {
                    $descLines[] = "";
                    $descLines[] = "Rekomendasi kursus:";
                    $uniqueCourses = collect($allCourses)->unique('title')->take(3);
                    foreach ($uniqueCourses as $course) {
                        $descLines[] = "- {$course['title']} ({$course['platform']}, {$course['duration_hours']}j)";
                    }
                }

                $descLines[] = "";
                $descLines[] = "Alokasi: 3-5 jam/minggu untuk belajar dan praktik.";

                $roadmaps[] = [
                    'month_number' => $monthNumber,
                    'title' => "Bulan {$monthNumber}: {$themeName}",
                    'desc' => implode("\n", $descLines),
                    'competency_ids' => collect($bucket['skills'])->pluck('competency_id')->toArray(),
                    'skills_data' => $bucket['skills'],
                ];
            }

            // Simpan ke Database
            foreach ($roadmaps as $item) {
                $createData = [
                    'user_id' => $assessment->user_id,
                    'position_id' => $assessment->position_id,
                    'month_number' => $item['month_number'],
                    'milestone_title' => $item['title'],
                    'milestone_description' => $item['desc'],
                    'is_completed' => false,
                    'gap_percentage' => collect($item['skills_data'])->avg('gap_percentage'),
                    'recommended_courses' => collect($item['skills_data'])->flatMap(fn($s) => $s['courses'] ?? [])->unique('title')->values()->toArray(),
                ];

                CareerRoadmap::create($createData);
            }

            return true;
        });
    }

    /**
     * Kelompokkan kompetensi berdasarkan kesamaan tema/topik
     */
    private function groupCompetenciesByTheme($scores): array
    {
        $grouped = [];
        $assigned = collect();

        foreach ($this->skillGroups as $groupKey => $keywords) {
            $matched = $scores->filter(function ($score) use ($keywords, $assigned) {
                if ($assigned->contains($score->id)) return false;
                $name = strtolower($score->competency->name);
                foreach ($keywords as $keyword) {
                    if (str_contains($name, $keyword)) return true;
                }
                return false;
            });

            if ($matched->isNotEmpty()) {
                $grouped[$groupKey] = [
                    'theme' => $this->getThemeName($groupKey),
                    'skills' => $matched->map(fn($s) => $this->formatSkill($s))->toArray(),
                ];
                $assigned = $assigned->merge($matched->pluck('id'));
            }
        }

        // Sisa kompetensi yang tidak masuk grup manapun
        $remaining = $scores->reject(fn($s) => $assigned->contains($s->id));
        if ($remaining->isNotEmpty()) {
            $grouped['other'] = [
                'theme' => 'Kompetensi Pendukung',
                'skills' => $remaining->map(fn($s) => $this->formatSkill($s))->toArray(),
            ];
        }

        return $grouped;
    }

    /**
     * Format data skill untuk penyimpanan
     */
    private function formatSkill($score): array
    {
        $courses = $this->getCoursesForCompetency($score->competency_id);

        return [
            'competency_id' => $score->competency_id,
            'name' => $score->competency->name,
            'gap_percentage' => $score->gap_percentage,
            'gap_formatted' => number_format($score->gap_percentage, 1),
            'current_level' => $score->self_assessed_level,
            'target_level' => $score->competency->min_level_required,
            'priority' => $score->priority,
            'courses' => $courses->map(fn($c) => [
                'id' => $c->id,
                'title' => $c->title,
                'platform' => $c->platform,
                'duration_hours' => $c->duration_hours,
                'level' => $c->level,
            ])->toArray(),
        ];
    }

    /**
     * Distribusikan grup kompetensi ke 6 bulan secara merata
     */
    private function distributeToMonths(array $grouped, int $totalMonths): array
    {
        $months = [];
        for ($i = 1; $i <= $totalMonths; $i++) {
            $months[$i] = ['theme' => '', 'skills' => []];
        }

        // Hitung total skill
        $totalSkills = 0;
        foreach ($grouped as $group) {
            $totalSkills += count($group['skills']);
        }

        // Bulan 5 & 6: Portofolio & Persiapan Karir (tidak diisi skill baru)
        $learningMonths = $totalMonths - 2; // 4 bulan belajar
        $skillsPerMonth = ceil($totalSkills / $learningMonths);

        $allGroups = array_values($grouped);
        $currentMonth = 1;
        $currentSkillCount = 0;
        $currentThemes = [];

        foreach ($allGroups as $group) {
            // Jika bulan ini sudah penuh, pindah ke bulan berikutnya
            if ($currentSkillCount >= $skillsPerMonth && $currentMonth < $learningMonths) {
                $months[$currentMonth]['theme'] = implode(' & ', $currentThemes);
                $currentMonth++;
                $currentSkillCount = 0;
                $currentThemes = [];
            }

            foreach ($group['skills'] as $skill) {
                // Jika bulan ini sudah penuh, pindah ke bulan berikutnya
                if ($currentSkillCount >= $skillsPerMonth && $currentMonth < $learningMonths) {
                    $months[$currentMonth]['theme'] = implode(' & ', $currentThemes);
                    $currentMonth++;
                    $currentSkillCount = 0;
                    $currentThemes = [];
                }

                $months[$currentMonth]['skills'][] = $skill;
                $currentSkillCount++;
            }

            if (!in_array($group['theme'], $currentThemes)) {
                $currentThemes[] = $group['theme'];
            }
        }

        // Set tema untuk bulan terakhir belajar
        if (!empty($currentThemes)) {
            $months[$currentMonth]['theme'] = implode(' & ', $currentThemes);
        }

        // Bulan 5: Integrasi & Portofolio
        $allSkillNames = [];
        foreach ($grouped as $group) {
            foreach ($group['skills'] as $skill) {
                $allSkillNames[] = $skill['name'];
            }
        }
        $skillList = collect($allSkillNames)->take(6)->join(', ');

        $months[5] = [
            'theme' => 'Integrasi Skill & Portofolio',
            'skills' => [],
            'is_portfolio' => true,
        ];

        // Bulan 6: Persiapan Karir
        $months[6] = [
            'theme' => 'Persiapan Karir',
            'skills' => [],
            'is_career' => true,
        ];

        // Override deskripsi bulan 5 & 6
        $months[5]['description'] = "Gabungkan semua skill yang dipelajari ({$skillList}) dalam proyek portofolio. "
            . "Buat 2-3 proyek nyata yang mendemonstrasikan kemampuan. Dokumentasikan di GitHub/Behance.";
        $months[6]['description'] = "Latihan interview teknis dan behavioral. Perbarui CV dan LinkedIn. "
            . "Mulai lamar ke perusahaan target dan bangun personal branding.";

        return $months;
    }

    /**
     * Ambil nama tema yang readable
     */
    private function getThemeName(string $groupKey): string
    {
        return match ($groupKey) {
            'seo_sem' => 'SEO & Search Marketing',
            'analytics' => 'Analytics & Data Tracking',
            'social_media' => 'Social Media Marketing',
            'content' => 'Content Marketing & Copywriting',
            'email_automation' => 'Email Marketing & Automation',
            'communication' => 'Komunikasi & Presentasi',
            'creative' => 'Kreativitas & Problem Solving',
            'analytical' => 'Berpikir Analitis',
            'management' => 'Manajemen Waktu & Proyek',
            'programming' => 'Programming & Software Development',
            'finance_accounting' => 'Finance & Accounting',
            'engineering' => 'Engineering & Maintenance',
            'healthcare' => 'Healthcare & Clinical Skills',
            'sales_customer_service' => 'Sales & Customer Service',
            default => 'Kompetensi Pendukung',
        };
    }

    /**
     * Ambil kursus yang relevan untuk kompetensi tertentu
     */
    private function getCoursesForCompetency(int $competencyId)
    {
        return Course::where('competency_id', $competencyId)
            ->orderByDesc('rating')
            ->take(2)
            ->get();
    }

    /**
     * Buat roadmap umum jika tidak ada skill gap
     */
    private function createGenericRoadmap(UserAssessment $assessment)
    {
        $targetName = $assessment->target_name;

        $genericRoadmaps = [
            [
                'month_number' => 1,
                'title' => "Bulan 1: Eksplorasi Mendalam {$targetName}",
                'desc' => "Pelajari tren terbaru dan skill lanjutan untuk posisi {$targetName}. Ikuti webinar dan workshop industri."
            ],
            [
                'month_number' => 2,
                'title' => "Bulan 2: Sertifikasi Profesional",
                'desc' => "Dapatkan sertifikasi industri yang diakui untuk memvalidasi kompetensi Anda."
            ],
            [
                'month_number' => 3,
                'title' => "Bulan 3: Proyek Open Source",
                'desc' => "Kontribusi ke proyek open source untuk membangun portofolio dan networking."
            ],
            [
                'month_number' => 4,
                'title' => "Bulan 4: Pengembangan Soft Skill",
                'desc' => "Tingkatkan kemampuan komunikasi, kepemimpinan, dan manajemen proyek."
            ],
            [
                'month_number' => 5,
                'title' => "Bulan 5: Integrasi Skill & Portofolio",
                'desc' => "Gabungkan semua skill dalam proyek portofolio lengkap. Dokumentasikan di GitHub."
            ],
            [
                'month_number' => 6,
                'title' => "Bulan 6: Persiapan Karir",
                'desc' => "Latihan interview, perbarui CV, dan mulai lamar ke perusahaan target."
            ]
        ];

        foreach ($genericRoadmaps as $item) {
            CareerRoadmap::create([
                'user_id' => $assessment->user_id,
                'position_id' => $assessment->position_id,
                'month_number' => $item['month_number'],
                'milestone_title' => $item['title'],
                'milestone_description' => $item['desc'],
                'is_completed' => false
            ]);
        }
    }
}
