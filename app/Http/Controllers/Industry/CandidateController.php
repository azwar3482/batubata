<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Services\CandidateService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserJobApplication;
use App\Models\JobListing;
use App\Models\TpaTest;
use App\Models\TpaTestSession;
use App\Services\TpaService;
use App\Services\JobMatchingService;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    protected $candidateService;
    protected $tpaService;

    public function __construct(CandidateService $candidateService, TpaService $tpaService)
    {
        $this->candidateService = $candidateService;
        $this->tpaService = $tpaService;
    }

    public function index(Request $request, JobMatchingService $matchingService)
    {
        $user = Auth::user();
        
        // 1. Get all jobs owned by the company (with eager loading)
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');
        $activeJobs = JobListing::where('user_id', $user->id)
            ->where('is_active', true)
            ->where('expires_date', '>', now())
            ->with('position')
            ->get();

        // 2. Fetch applicants who have applied (with eager loading)
        $applications = UserJobApplication::whereIn('job_listing_id', $jobIds)
            ->with(['user.assessments.scores.competency', 'jobListing'])
            ->get();

        $applicants = $applications->map(function ($app) {
            return (object)[
                'user' => $app->user,
                'matching_percentage' => $app->matching_percentage,
                'jobListing' => $app->jobListing,
                'status' => $app->status,
                'id' => $app->id,
                'has_applied' => true
            ];
        });

        // 3. Fetch qualified non-applicants (match >= 70%)
        // Use chunk to avoid loading all users at once
        $appliedUserIds = $applications->pluck('user_id')->unique()->toArray();
        $matchedNonApplicants = collect();
        
        if ($activeJobs->isNotEmpty()) {
            User::where('role', 'job_seeker')
                ->whereNotIn('id', $appliedUserIds)
                ->with(['assessments.scores.competency'])
                ->chunk(100, function ($jobSeekers) use ($activeJobs, $matchingService, $matchedNonApplicants) {
                    foreach ($jobSeekers as $seeker) {
                        $bestMatch = 0;
                        $bestJob = null;

                        foreach ($activeJobs as $job) {
                            $score = $matchingService->calculateMatch($seeker, $job);
                            if ($score > $bestMatch) {
                                $bestMatch = $score;
                                $bestJob = $job;
                            }
                        }

                        if ($bestMatch >= 70) {
                            $matchedNonApplicants->push((object)[
                                'user' => $seeker,
                                'matching_percentage' => $bestMatch,
                                'jobListing' => $bestJob,
                                'status' => 'not_applied',
                                'id' => null,
                                'has_applied' => false
                            ]);
                        }
                    }
                });
        }

        // 4. Combine collections
        $combinedCandidates = $applicants->concat($matchedNonApplicants);

        // 5. Apply filters
        // Search by Name, Email, or Applicant ID
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $combinedCandidates = $combinedCandidates->filter(function ($item) use ($search) {
                $u = $item->user;
                return $u && (
                    str_contains(strtolower($u->name), $search) ||
                    str_contains(strtolower($u->email), $search) ||
                    $u->id == $search
                );
            });
        }

        // Search by Skill
        if ($request->filled('skill')) {
            $skill = strtolower($request->skill);
            $combinedCandidates = $combinedCandidates->filter(function ($item) use ($skill) {
                $u = $item->user;
                if (!$u) return false;
                
                // Check competencies
                $hasCompetency = $u->assessments->flatMap->scores->contains(function ($score) use ($skill) {
                    return str_contains(strtolower($score->competency->name), $skill);
                });

                // Check profile skills array
                $hasSkillsArray = false;
                if (is_array($u->skills)) {
                    foreach ($u->skills as $s) {
                        if (str_contains(strtolower($s), $skill)) {
                            $hasSkillsArray = true;
                            break;
                        }
                    }
                }

                return $hasCompetency || $hasSkillsArray;
            });
        }

        // Filter by Position
        if ($request->filled('position')) {
            $positionId = $request->position;
            $combinedCandidates = $combinedCandidates->filter(function ($item) use ($positionId) {
                return $item->jobListing && $item->jobListing->position_id == $positionId;
            });
        }

        // 6. Sort by matching percentage descending
        $combinedCandidates = $combinedCandidates->sortByDesc('matching_percentage')->values();

        // 7. Paginate the collection manually
        $perPage = 15;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $currentItems = $combinedCandidates->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $candidates = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $combinedCandidates->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        $candidates->withQueryString();

        $positions = \App\Models\Position::all();

        return view('industry.candidates', compact('candidates', 'positions'));
    }

    public function show(Request $request, $candidateId)
    {
        $jobId = $request->query('job_id');
        
        $application = null;
        if ($jobId) {
            $application = UserJobApplication::where('user_id', $candidateId)
                ->where('job_listing_id', $jobId)
                ->first();
        } else {
            $application = UserJobApplication::where('user_id', $candidateId)
                ->orderBy('applied_at', 'desc')
                ->first();
        }

        $candidate = User::with(['assessments.scores.competency', 'documents'])->find($candidateId);
        
        if (!$candidate) {
            abort(404, 'Kandidat tidak ditemukan');
        }

        // Hitung match percentage dari assessment terbaru (gunakan eager loaded data)
        $latestAssessment = $candidate->assessments->sortByDesc('assessment_date')->first();
        $matchPercentage = $application ? $application->matching_percentage : 0;
        
        if (!$matchPercentage && $latestAssessment) {
            $totalGap = $latestAssessment->scores->avg('gap_percentage');
            $matchPercentage = round(max(0, 100 - $totalGap), 1);
        }

        return view('industry.candidate-profile', compact('candidate', 'application', 'matchPercentage', 'jobId', 'latestAssessment'));
    }

    public function inviteTpa(Request $request, $applicationId)
    {
        $request->validate([
            'tpa_test_id' => 'required|exists:tpa_tests,id',
        ]);

        $application = UserJobApplication::findOrFail($applicationId);
        $job = JobListing::findOrFail($application->job_listing_id);

        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $test = TpaTest::findOrFail($request->tpa_test_id);

        $existingSession = TpaTestSession::where('job_application_id', $application->id)
            ->whereIn('status', ['invited', 'in_progress'])
            ->first();

        if ($existingSession) {
            return back()->with('error', 'Kandidat sudah memiliki undangan TPA aktif.');
        }

        $this->tpaService->inviteCandidate($application, $test);

        return back()->with('success', 'Undangan TPA berhasil dikirim ke kandidat!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:applied,reviewed,interviewed,offered,rejected',
        ]);

        $application = UserJobApplication::findOrFail($id);
        
        $job = JobListing::findOrFail($application->job_listing_id);
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update([
            'status' => $request->status,
        ]);

        event(new \App\Events\JobApplicationStatusChanged($application));

        $statusTranslations = [
            'applied' => 'Dikirim',
            'reviewed' => 'Direview',
            'interviewed' => 'Interview',
            'offered' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        $statusLabel = $statusTranslations[$request->status] ?? $request->status;

        return back()->with('success', "Status lamaran berhasil diperbarui menjadi {$statusLabel}!");
    }
}
