<?php

namespace App\Services;

use App\Models\Competency;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;

class AssessmentScoringService
{
    /**
     * Process and save the assessment scores using bulk insert to prevent N+1 writes.
     *
     * @param int $userId
     * @param int|null $positionId
     * @param array $submittedSkills Format: [competency_id => self_assessed_level]
     * @return UserAssessment|null
     */
    public function processAndSaveScores($userId, $positionId, array $submittedSkills)
    {
        if (!$positionId) {
            return null;
        }

        // 1. Buat Record Asesmen Utama
        $assessment = UserAssessment::create([
            'user_id' => $userId,
            'position_id' => $positionId,
            'assessment_date' => now(),
            'status' => 'completed',
            'total_gap_percentage' => 0, // Akan dihitung
        ]);

        // Hapus roadmap lama karena ada hasil asesmen baru
        \App\Models\CareerRoadmap::where('user_id', $userId)
            ->where('position_id', $positionId)
            ->delete();

        // 2. Ambil semua data kompetensi yang dibutuhkan dalam 1 Query (Mencegah N+1 Read)
        $competencyIds = array_keys($submittedSkills);
        $competencies = Competency::whereIn('id', $competencyIds)->get()->keyBy('id');

        $scoresToInsert = [];
        $totalGap = 0;
        $countSkills = 0;
        $now = now();

        // 3. Kalkulasi Gap di memori
        foreach ($submittedSkills as $compId => $selfLevel) {
            $competency = $competencies->get($compId);
            if (!$competency) continue;

            $targetLevel = $competency->min_level_required;
            
            // Rumus: ((Target - Current) / Target) * 100. Jika current > target, gap = 0
            $gap = $targetLevel > 0 ? max(0, (($targetLevel - $selfLevel) / $targetLevel) * 100) : 0;

            $totalGap += $gap;
            $countSkills++;

            $priority = $gap > 50 ? 'high' : ($gap > 20 ? 'medium' : 'low');

            $scoresToInsert[] = [
                'assessment_id' => $assessment->id,
                'competency_id' => $compId,
                'self_assessed_level' => $selfLevel,
                'ai_analyzed_level' => null,
                'gap_percentage' => $gap,
                'priority' => $priority,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 4. Update Rata-rata Gap pada Asesmen Utama
        $avgGap = $countSkills > 0 ? ($totalGap / $countSkills) : 0;
        $assessment->update(['total_gap_percentage' => $avgGap]);

        // 5. Simpan semua Skor sekaligus (Bulk Insert) untuk mencegah N+1 Writes
        if (!empty($scoresToInsert)) {
            UserCompetencyScore::insert($scoresToInsert);
        }

        return $assessment;
    }
}
