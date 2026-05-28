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
        $latestAssessment = UserAssessment::where('user_id', $user->id)->with('scores.competency')->latest()->first();
        $avgGap = $latestAssessment ? $latestAssessment->total_gap_percentage : 0;

        $coursesInProgress = UserCourseProgress::where('user_id', $user->id)
            ->where('status', 'in_progress')
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
                ['label' => 'Teknis', 'current' => 0, 'target' => 4],
                ['label' => 'Soft Skill', 'current' => 0, 'target' => 4],
                ['label' => 'Digital', 'current' => 0, 'target' => 4],
                ['label' => 'Leadership', 'current' => 0, 'target' => 4],
                ['label' => 'Bahasa', 'current' => 0, 'target' => 4],
            ];
        }

        $scores = $latestAssessment->scores()->with('competency')->get();
        $categories = ['Komunikasi', 'Teknis', 'Digital', 'Leadership', 'Bahasa'];

        $radarData = [];

        foreach ($categories as $cat) {
            $currentScore = 0;
            $targetScore = 0;

            $relatedScores = $scores->filter(function ($s) use ($cat) {
                return stripos($s->competency->name, $cat) !== false ||
                    ($cat == 'Teknis' && $s->competency->category == 'technical') ||
                    ($cat == 'Soft Skill' && $s->competency->category == 'soft_skill');
            });

            if ($relatedScores->isNotEmpty()) {
                $currentScore = $relatedScores->avg('self_assessed_level');
                $targetScore = $relatedScores->avg(function ($s) {
                    return $s->competency->min_level_required;
                });
            } else {
                $currentScore = $cat == 'Teknis' ? 2 : 3;
                $targetScore = 4;
            }

            $radarData[] = [
                'label' => $cat,
                'current' => round($currentScore, 1),
                'target' => round($targetScore, 1)
            ];
        }

        return $radarData;
    }
}
