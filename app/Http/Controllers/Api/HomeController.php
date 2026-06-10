<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAssessment;
use App\Models\UserCourseProgress;
use App\Models\UserCompetencyScore;
use App\Models\UserJobApplication;
use App\Models\JobListing;
use App\Services\JobMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(JobMatchingService $matchingService)
    {
        $user = Auth::user()->load(['company', 'institution']);

        $photoDoc = $user->documents()->where('document_type', 'photo')->first();

        $data = [
            'user_name' => $user->name,
            'user_avatar' => $photoDoc ? asset('storage/' . $photoDoc->file_path) : null,
            'role' => $user->role,
            'notification_count' => $user->unreadNotifications()->count(),
            'level_badge' => $this->_getLevelBadge($user),
        ];

        switch ($user->role) {
            case 'admin':
                $data = array_merge($data, $this->_getAdminData($user));
                break;
            case 'industry':
                $data = array_merge($data, $this->_getIndustryData($user));
                break;
            case 'education':
                $data = array_merge($data, $this->_getEducationData($user));
                break;
            case 'job_seeker':
            default:
                $data = array_merge($data, $this->_getJobSeekerData($user, $matchingService));
                break;
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    private function _getLevelBadge($user)
    {
        if ($user->role === 'admin') return 'Super Admin';
        if ($user->role === 'industry') return 'Partner';
        if ($user->role === 'education') return 'Academic';
        return 'Professional';
    }

    private function _getJobSeekerData($user, $matchingService)
    {
        $totalAssessments = UserAssessment::where('user_id', $user->id)->count();
        $latestAssessment = UserAssessment::where('user_id', $user->id)
            ->with(['scores.competency'])
            ->latest('assessment_date')
            ->first();
            
        $coursesCompleted = UserCourseProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
            
        $coursesInProgress = UserCourseProgress::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();

        $matchedJobs = $matchingService->getMatchedJobs($user, 3);
        $formattedJobs = $matchedJobs->map(function ($job) {
            return [
                'id' => $job->id,
                'position' => $job->title,
                'company' => $job->company_name,
                'location' => $job->location,
                'work_type' => $job->type,
                'matching_percentage' => $job->match_percentage ?? 0,
                'posted_date' => $job->created_at->toISOString(),
            ];
        });

        $prioritySkills = [];
        if ($latestAssessment) {
            $prioritySkills = $latestAssessment->scores()
                ->with('competency')
                ->get()
                ->map(function ($score) {
                    $gap = $score->competency->min_level_required - $score->self_assessed_level;
                    return [
                        'skill_name' => $score->competency->name,
                        'gap_percentage' => max(0, $gap * 20),
                        'priority' => $gap > 1 ? 'High' : 'Medium',
                    ];
                })
                ->sortByDesc('gap_percentage')
                ->take(3)
                ->values();
        }

        return [
            'total_skills_assessed' => $totalAssessments,
            'average_skill_gap' => $latestAssessment ? $latestAssessment->total_gap_percentage : 0,
            'courses_completed' => $coursesCompleted,
            'total_courses' => $coursesCompleted + $coursesInProgress,
            'priority_skills' => $prioritySkills,
            'suggested_jobs' => $formattedJobs,
            'recent_activities' => $this->_getRecentActivities($user),
        ];
    }

    private function _getIndustryData($user)
    {
        $company = $user->company;
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');
        
        $activeJobsCount = JobListing::where('user_id', $user->id)->count();
        $totalApplicants = UserJobApplication::whereIn('job_listing_id', $jobIds)->count();
        $highMatchCandidates = UserJobApplication::whereIn('job_listing_id', $jobIds)
            ->where('matching_percentage', '>=', 80)
            ->count();

        return [
            'active_jobs' => $activeJobsCount,
            'total_applicants' => $totalApplicants,
            'high_match_candidates' => $highMatchCandidates,
            'company_name' => $company->name ?? 'N/A',
            'recent_activities' => $this->_getRecentActivities($user),
        ];
    }

    private function _getEducationData($user)
    {
        $institution = $user->institution;
        $studentIds = $institution ? $institution->students()->pluck('id') : collect();

        $totalGraduates = $studentIds->count();

        // Hitung rata-rata skill gap dari asesmen mahasiswa
        $avgInstitutionGap = $studentIds->isNotEmpty()
            ? round(UserCompetencyScore::whereHas('assessment', fn($q) => $q->whereIn('user_id', $studentIds))->avg('gap_percentage') ?? 0, 1)
            : 0;

        // Hitung placement rate dari lamaran yang diterima
        $totalApplications = UserJobApplication::whereIn('user_id', $studentIds)->count();
        $acceptedApplications = UserJobApplication::whereIn('user_id', $studentIds)->where('status', 'offered')->count();
        $placementRate = $totalApplications > 0 ? round(($acceptedApplications / $totalApplications) * 100) : 0;

        $totalAssessmentsGlobal = UserAssessment::whereIn('user_id', $studentIds)->count();

        // Top priority skills berdasarkan gap tertinggi
        $prioritySkills = $studentIds->isNotEmpty()
            ? UserCompetencyScore::whereHas('assessment', fn($q) => $q->whereIn('user_id', $studentIds))
                ->join('competencies', 'user_competency_scores.competency_id', '=', 'competencies.id')
                ->select('competencies.name', DB::raw('AVG(user_competency_scores.gap_percentage) as avg_gap'))
                ->groupBy('competencies.id', 'competencies.name')
                ->orderByDesc('avg_gap')
                ->take(3)
                ->get()
                ->map(fn($c) => [
                    'skill_name' => $c->name,
                    'gap_percentage' => round($c->avg_gap, 1),
                    'priority' => $c->avg_gap > 50 ? 'High' : 'Medium',
                ])
                ->toArray()
            : [];

        return [
            'institution_name' => $institution->name ?? 'N/A',
            'total_graduates' => $totalGraduates,
            'average_institution_gap' => $avgInstitutionGap,
            'placement_rate' => $placementRate,
            'total_assessments_global' => $totalAssessmentsGlobal,
            'priority_skills' => $prioritySkills,
            'recent_activities' => $this->_getRecentActivities($user),
        ];
    }

    private function _getAdminData($user)
    {
        return [
            'total_users' => \App\Models\User::count(),
            'total_assessments_global' => UserAssessment::count(),
            'active_jobs_global' => JobListing::count(),
            'system_health' => '98.5%',
            'recent_activities' => $this->_getRecentActivities($user),
        ];
    }

    private function _getRecentActivities($user)
    {
        $activities = [];
        $latestAssessment = UserAssessment::where('user_id', $user->id)->latest('assessment_date')->first();
        if ($latestAssessment) {
            $activities[] = [
                'title' => 'Asesmen Selesai',
                'description' => 'Anda menyelesaikan asesmen kompetensi',
                'timestamp' => $latestAssessment->created_at->toISOString(),
                'type' => 'assessment',
            ];
        }
        return $activities;
    }
}
