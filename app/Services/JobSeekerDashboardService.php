<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserCourseProgress;
use App\Models\JobListing;
use App\Services\JobMatchingService;

class JobSeekerDashboardService
{
    protected $matchingService;

    public function __construct(JobMatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    public function getDashboardData(User $user)
    {
        $totalAssessments = UserAssessment::where('user_id', $user->id)->count();
        $latestAssessment = UserAssessment::where('user_id', $user->id)->with('scores.competency')->latest('assessment_date')->first();
        $avgGap = $latestAssessment ? $latestAssessment->total_gap_percentage : 0;

        $coursesInProgress = UserCourseProgress::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count() + \App\Models\ClassEnrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        $matchedJobs = $this->matchingService->getMatchedJobs($user, 3);
        $recommendedJobs = JobListing::where('is_active', true)->take(3)->get();

        $radarData = $this->calculateRadarData($latestAssessment);

        return compact(
            'user', 'totalAssessments', 'avgGap', 'coursesInProgress', 
            'matchedJobs', 'recommendedJobs', 'radarData', 'latestAssessment'
        );
    }

    private function calculateRadarData($latestAssessment)
    {
        if (!$latestAssessment) {
            return [
                ['label' => 'Skill Teknis', 'current' => 0, 'target' => 4],
                ['label' => 'Soft Skill', 'current' => 0, 'target' => 4],
            ];
        }

        $scores = $latestAssessment->scores()->with('competency')->get();

        if ($scores->isEmpty()) {
            return [
                ['label' => 'Skill Teknis', 'current' => 0, 'target' => 4],
                ['label' => 'Soft Skill', 'current' => 0, 'target' => 4],
            ];
        }

        // Group by actual competency category (technical / soft_skill)
        $technicalScores = $scores->where('competency.category', 'technical');
        $softScores = $scores->where('competency.category', 'soft_skill');

        $radarData = [];

        // Technical skills
        if ($technicalScores->isNotEmpty()) {
            $radarData[] = [
                'label' => 'Skill Teknis',
                'current' => round($technicalScores->avg('self_assessed_level'), 1),
                'target' => round($technicalScores->avg(function ($s) {
                    return $s->competency->min_level_required;
                }), 1),
            ];
        }

        // Soft skills
        if ($softScores->isNotEmpty()) {
            $radarData[] = [
                'label' => 'Soft Skill',
                'current' => round($softScores->avg('self_assessed_level'), 1),
                'target' => round($softScores->avg(function ($s) {
                    return $s->competency->min_level_required;
                }), 1),
            ];
        }

        // Per-competency detail (top 5 by gap, untuk radar lebih informatif)
        $topGaps = $scores->sortByDesc(function ($s) {
            return $s->competency->min_level_required > 0
                ? max(0, (($s->competency->min_level_required - $s->self_assessed_level) / $s->competency->min_level_required) * 100)
                : 0;
        })->take(5);

        foreach ($topGaps as $score) {
            $radarData[] = [
                'label' => $score->competency->name,
                'current' => (float) $score->self_assessed_level,
                'target' => (float) $score->competency->min_level_required,
            ];
        }

        // Fallback jika tidak ada data
        if (empty($radarData)) {
            $radarData = [
                ['label' => 'Skill Teknis', 'current' => 0, 'target' => 4],
                ['label' => 'Soft Skill', 'current' => 0, 'target' => 4],
            ];
        }

        return $radarData;
    }
}
