<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;
use App\Models\UserJobApplication;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    { 
        $user = auth()->user();
        $institution = $user->institution;
        
        $stats = [
            'total_students' => 0,
            'total_applications' => 0,
            'accepted_applications' => 0,
            'rejected_applications' => 0,
            'processing_applications' => 0,
            'avg_skill_gap' => 0,
            'placement_rate' => 0,
            'total_assessments' => 0,
        ];

        $skillGapByMajor = [];
        $topGapCompetencies = [];
        $recentActivities = [];

        if ($institution) {
            $studentIds = $institution->students()->pluck('id');
            
            $stats['total_students'] = $studentIds->count();
            
            // Application stats
            $applications = UserJobApplication::whereIn('user_id', $studentIds)
                ->selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'offered' THEN 1 ELSE 0 END) as accepted,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status IN ('applied', 'reviewed', 'interviewed') THEN 1 ELSE 0 END) as processing
                ")
                ->first();
                
            $stats['total_applications'] = $applications->total ?? 0;
            $stats['accepted_applications'] = $applications->accepted ?? 0;
            $stats['rejected_applications'] = $applications->rejected ?? 0;
            $stats['processing_applications'] = $applications->processing ?? 0;

            // Placement rate
            $stats['placement_rate'] = $stats['total_applications'] > 0 
                ? round(($stats['accepted_applications'] / $stats['total_applications']) * 100) 
                : 0;

            // Total assessments & avg skill gap
            $assessments = UserAssessment::whereIn('user_id', $studentIds);
            $stats['total_assessments'] = $assessments->count();
            $stats['avg_skill_gap'] = round(UserCompetencyScore::whereHas('assessment', fn($q) => $q->whereIn('user_id', $studentIds))->avg('gap_percentage') ?? 0, 1);

            // Skill gap by major (education_level)
            $skillGapByMajor = User::whereIn('id', $studentIds)
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
                        'student_count' => $group->student_count,
                        'avg_gap' => round($avgGap ?? 0, 1),
                    ];
                })
                ->sortByDesc('avg_gap')
                ->values();

            // Top competencies with highest gap
            $topGapCompetencies = UserCompetencyScore::whereHas('assessment', fn($q) => $q->whereIn('user_id', $studentIds))
                ->join('competencies', 'user_competency_scores.competency_id', '=', 'competencies.id')
                ->select('competencies.name', 'competencies.category', DB::raw('AVG(user_competency_scores.gap_percentage) as avg_gap'))
                ->groupBy('competencies.id', 'competencies.name', 'competencies.category')
                ->orderByDesc('avg_gap')
                ->take(5)
                ->get()
                ->map(fn($c) => [
                    'name' => $c->name,
                    'category' => $c->category,
                    'avg_gap' => round($c->avg_gap, 1),
                    'priority' => $c->avg_gap > 50 ? 'Tinggi' : ($c->avg_gap > 25 ? 'Sedang' : 'Rendah'),
                ]);

            // Recent activities
            $recentAssessments = UserAssessment::whereIn('user_id', $studentIds)
                ->with('user')
                ->latest()
                ->take(3)
                ->get()
                ->map(fn($a) => [
                    'icon' => 'assessment',
                    'color' => 'blue',
                    'title' => "{$a->user->name} menyelesaikan asesmen kompetensi",
                    'detail' => "Skill gap: " . round($a->total_gap_percentage, 1) . "%",
                    'time' => $a->created_at->diffForHumans(),
                ]);

            $recentActivities = $recentAssessments->toArray();
        }

        return view('education.dashboard', compact('stats', 'skillGapByMajor', 'topGapCompetencies', 'recentActivities')); 
    }
}
