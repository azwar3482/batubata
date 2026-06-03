<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserJobApplication;

class CandidateService
{
    public function getCandidateDetail($candidateId)
    {
        $candidate = User::with(['assessments.scores.competency', 'documents'])
            ->findOrFail($candidateId);

        // Ambil assessment terbaru
        $latestAssessment = UserAssessment::where('user_id', $candidate->id)
            ->with('scores.competency')
            ->latest()
            ->first();

        // Hitung match percentage dari data assessment
        $matchPercentage = 0;
        if ($latestAssessment && $latestAssessment->scores->isNotEmpty()) {
            $totalGap = $latestAssessment->scores->avg('gap_percentage');
            $matchPercentage = round(max(0, 100 - $totalGap), 1);
        }

        return compact('candidate', 'matchPercentage', 'latestAssessment');
    }
}
