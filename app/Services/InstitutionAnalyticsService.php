<?php

namespace App\Services;

use App\Models\User;
use App\Models\Institution;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\DB;

class InstitutionAnalyticsService
{
    /**
     * Get analytics data for the given user's institution.
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function getAnalyticsForUser(User $user)
    {
        $institution = Institution::where('user_id', $user->id)->first();

        if (!$institution) {
            $institution = Institution::create([
                'user_id' => $user->id,
                'name' => $user->name . ' University',
                'type' => 'University',
                'address' => 'Jl. Pendidikan No. 123',
                'accreditation' => 'A'
            ]);
            
            $user->institution_id = $institution->id;
            $user->save();
        }

        // 1. Basic Stats dari database
        $studentIds = User::where('institution_id', $institution->id)->pluck('id');
        $totalGraduates = $studentIds->count();

        // Jika belum ada mahasiswa, kaitkan job seeker yang ada untuk demo
        if ($totalGraduates == 0) {
            User::where('role', 'job_seeker')->limit(10)->update(['institution_id' => $institution->id]);
            $studentIds = User::where('institution_id', $institution->id)->pluck('id');
            $totalGraduates = $studentIds->count();
        }

        // Hitung rata-rata skill gap dari asesmen mahasiswa
        $avgSkillGap = round(
            UserCompetencyScore::whereHas('assessment', fn($q) => $q->whereIn('user_id', $studentIds))
                ->avg('gap_percentage') ?? 0,
            1
        );

        // Hitung placement rate dari lamaran yang diterima
        $totalApplications = UserJobApplication::whereIn('user_id', $studentIds)->count();
        $acceptedApplications = UserJobApplication::whereIn('user_id', $studentIds)
            ->where('status', 'offered')
            ->count();
        $placementRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100, 1)
            : 0;

        $assessmentsCompleted = UserAssessment::whereIn('user_id', $studentIds)->count();

        // 2. Skill Gap per Major (Chart Data) dari database
        $skillGapPerMajor = User::whereIn('id', $studentIds)
            ->whereNotNull('major')
            ->select('major', DB::raw('COUNT(*) as student_count'))
            ->groupBy('major')
            ->get()
            ->map(function ($group) use ($studentIds) {
                $avgGap = UserCompetencyScore::whereHas('assessment', function ($q) use ($studentIds, $group) {
                    $q->whereIn('user_id', User::whereIn('id', $studentIds)->where('major', $group->major)->pluck('id'));
                })->avg('gap_percentage');
                return [
                    'major' => $group->major,
                    'gap' => round($avgGap ?? 0, 1),
                ];
            })
            ->sortByDesc('gap')
            ->values()
            ->toArray();

        // 3. Top Priority Competencies (Top 5 gaps) dari database
        $topGaps = UserCompetencyScore::whereHas('assessment', fn($q) => $q->whereIn('user_id', $studentIds))
            ->join('competencies', 'user_competency_scores.competency_id', '=', 'competencies.id')
            ->select('competencies.name', DB::raw('AVG(user_competency_scores.gap_percentage) as avg_gap'))
            ->groupBy('competencies.id', 'competencies.name')
            ->orderByDesc('avg_gap')
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'gap' => round($c->avg_gap, 1),
            ])
            ->toArray();

        // 4. Recommendations berdasarkan data riil
        $recommendations = collect($topGaps)->map(function ($gap) {
            $priority = $gap['gap'] > 50 ? 'Tinggi' : ($gap['gap'] > 25 ? 'Sedang' : 'Rendah');
            $recommendation = match(true) {
                $gap['gap'] > 50 => "Tambah mata kuliah praktis {$gap['name']} dengan studi kasus industri",
                $gap['gap'] > 25 => "Kolaborasi dengan industri untuk magang dan proyek nyata terkait {$gap['name']}",
                default => "Workshop dan pelatihan rutin {$gap['name']} tiap semester",
            };
            return [
                'competency' => $gap['name'],
                'major' => '-',
                'gap' => $gap['gap'] . '%',
                'recommendation' => $recommendation,
                'priority' => $priority,
            ];
        })->toArray();

        return [
            'institution' => $institution->name,
            'stats' => [
                'total_graduates' => $totalGraduates,
                'avg_skill_gap' => $avgSkillGap,
                'placement_rate' => $placementRate,
                'assessments_completed' => $assessmentsCompleted,
            ],
            'charts' => [
                'skill_gap_per_major' => $skillGapPerMajor,
                'top_gaps' => $topGaps,
            ],
            'recommendations' => $recommendations
        ];
    }
}
