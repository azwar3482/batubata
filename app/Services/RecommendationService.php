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

        if ($scores->isEmpty()) {
            return collect([]);
        }

        // Ambil semua kursus sekaligus untuk semua competency_id (HINDARI N+1)
        $competencyIds = $scores->pluck('competency_id')->unique();
        $coursesByCompetency = Course::whereIn('competency_id', $competencyIds)
            ->orderBy('level', 'asc')
            ->get()
            ->groupBy('competency_id');

        $recommendations = collect([]);

        foreach ($scores as $score) {
            $matchingCourses = ($coursesByCompetency->get($score->competency_id) ?? collect())->take(2);

            foreach ($matchingCourses as $course) {
                $recommendations->push([
                    'course' => $course,
                    'competency_name' => $score->competency->name,
                    'gap_percentage' => $score->gap_percentage,
                    'priority' => $score->priority,
                    'reason' => "Tingkatkan skill {$score->competency->name} (Gap: {$score->gap_percentage}%)"
                ]);
            }
        }

        return $recommendations->take($limit);
    }
}
