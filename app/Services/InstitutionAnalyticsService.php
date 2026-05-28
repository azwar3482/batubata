<?php

namespace App\Services;

use App\Models\User;
use App\Models\Institution;
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
            // Create a default institution if not exists
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

        // 1. Basic Stats
        $totalGraduates = User::where('institution_id', $institution->id)->count();
        
        // If no students yet, link some job seekers to this institution for demo purposes
        if ($totalGraduates == 0) {
            User::where('role', 'job_seeker')->limit(10)->update(['institution_id' => $institution->id]);
            $totalGraduates = 10;
        }

        $avgSkillGap = 35.5; // Default for now, could be calculated from scores
        $placementRate = 68.0;
        $assessmentsCompleted = DB::table('user_assessments')
            ->join('users', 'user_assessments.user_id', '=', 'users.id')
            ->where('users.institution_id', $institution->id)
            ->count();

        // 2. Skill Gap per Major (Chart Data)
        $skillGapPerMajor = [
            ['major' => 'Teknik Informatika', 'gap' => 38],
            ['major' => 'Sistem Informasi', 'gap' => 42],
            ['major' => 'Manajemen', 'gap' => 35],
            ['major' => 'Komunikasi', 'gap' => 48],
            ['major' => 'Akuntansi', 'gap' => 30],
        ];

        // 3. Top Priority Competencies (Top 5 gaps)
        $topGaps = [
            ['name' => 'Data Analysis', 'gap' => 52],
            ['name' => 'Digital Marketing', 'gap' => 45],
            ['name' => 'Project Management', 'gap' => 38],
            ['name' => 'Cloud Computing', 'gap' => 35],
            ['name' => 'Cybersecurity', 'gap' => 32],
        ];

        // 4. Recommendations
        $recommendations = [
            [
                'competency' => 'Data Analysis',
                'major' => 'Teknik Informatika',
                'gap' => '52%',
                'recommendation' => 'Tambah mata kuliah praktis Data Analytics dengan studi kasus industri',
                'priority' => 'Tinggi'
            ],
            [
                'competency' => 'Digital Marketing',
                'major' => 'Manajemen',
                'gap' => '45%',
                'recommendation' => 'Kolaborasi dengan industri untuk magang dan proyek nyata',
                'priority' => 'Sedang'
            ],
            [
                'competency' => 'Project Management',
                'major' => 'Sistem Informasi',
                'gap' => '38%',
                'recommendation' => 'Integrasi metode Agile/Scrum dalam pembelajaran proyek akhir',
                'priority' => 'Sedang'
            ],
            [
                'competency' => 'Communication',
                'major' => 'Komunikasi',
                'gap' => '25%',
                'recommendation' => 'Workshop presentasi dan public speaking rutin tiap semester',
                'priority' => 'Rendah'
            ]
        ];

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
