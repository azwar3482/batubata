<?php

namespace App\Services;

use App\Models\UserAssessment;
use App\Models\Course;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function getRecommendedCourses(UserAssessment $assessment, int $limit = 5)
    {
        // Ambil skor kompetensi yang memiliki gap (prioritas high/medium dulu)
        $scores = $assessment->scores()
            ->with('competency')
            ->whereIn('priority', ['high', 'medium'])
            ->orderByDesc('gap_percentage')
            ->get();

        $recommendations = collect([]);

        foreach ($scores as $score) {
            // Cari kursus yang berhubungan dengan kompetensi ini
            $courses = Course::where('competency_id', $score->competency_id)
                ->orderBy('level', 'asc') // Mulai dari level beginner dulu
                ->limit(2) // Ambil maksimal 2 kursus per skill
                ->get();

            foreach ($courses as $course) {
                $recommendations->push([
                    'course' => $course,
                    'competency_name' => $score->competency->name,
                    'gap_percentage' => $score->gap_percentage,
                    'priority' => $score->priority,
                    'reason' => "Tingkatkan skill {$score->competency->name} (Gap: {$score->gap_percentage}%)"
                ]);
            }
        }

        // Batasi jumlah total rekomendasi
        return $recommendations->take($limit);
    }
}