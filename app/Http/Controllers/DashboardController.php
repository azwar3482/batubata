<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\JobMatchingService;
use App\Services\JobSeekerDashboardService;
use App\Services\JobApplicationService;

class DashboardController extends Controller
{
    public function index(JobSeekerDashboardService $dashboardService)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $data = $dashboardService->getDashboardData($user);

        return view('dashboard', $data);
    }

    public function jobs(Request $request, JobMatchingService $matchingService)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
            'sort' => 'nullable|in:terbaru,terlama,relevansi',
            'per_page' => 'nullable|integer|min:5|max:50',
            'tab' => 'nullable|in:all,saved,applied',
        ]);

        $search = $validated['search'] ?? null;
        $sort = $validated['sort'] ?? 'terbaru';
        $perPage = $validated['per_page'] ?? 10;
        $tab = $validated['tab'] ?? 'all';

        $jobs = $matchingService->getMatchedJobsPaginated($user, $perPage, $search, $sort, $tab);

        $latestAssessment = \App\Models\UserAssessment::where('user_id', $user->id)->latest('assessment_date')->first();
        $avgGap = $latestAssessment ? $latestAssessment->total_gap_percentage : 0;

        return view('jobs.index', compact('jobs', 'avgGap'));
    }

    public function jobDetail($id, JobMatchingService $matchingService)
    {
        $job = JobListing::with('position')->findOrFail($id);
        $user = Auth::user();
        if ($user) {
            $job->matching_percentage = $matchingService->calculateMatch($user, $job);
        }
        
        return view('jobs.detail', compact('job'));
    }

    public function saveJob($id, JobApplicationService $applicationService)
    {
        $user = Auth::user();
        $result = $applicationService->toggleSaveJob($user, $id);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function myApplications(Request $request, JobApplicationService $applicationService)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'status' => 'nullable|string|max:50',
            'highlight_job_id' => 'nullable|integer|min:1',
        ]);

        $status = $validated['status'] ?? null;
        $highlightJobId = $validated['highlight_job_id'] ?? null;

        $applications = $applicationService->getUserApplications($user, 10, $status, $highlightJobId);
        $counts = $applicationService->getApplicationStats($user);

        return view('jobs.applications', compact('applications', 'counts', 'highlightJobId'));
    }

    public function withdrawApplication($id, JobApplicationService $applicationService)
    {
        $user = Auth::user();
        $result = $applicationService->withdrawApplication($user, $id);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function applyJob($id, JobApplicationService $applicationService)
    {
        $user = Auth::user();

        if (!$user->hasCompletedProfile()) {
            return back()->with('error', 'Profil Anda belum lengkap (' . $user->profile_completion_percentage . '%). Silakan lengkapi profil dan unggah CV Anda terlebih dahulu.');
        }

        $latestAssessment = \App\Models\UserAssessment::where('user_id', $user->id)->latest('assessment_date')->first();
        $avgGap = $latestAssessment ? $latestAssessment->total_gap_percentage : 0;
        if ($avgGap > 30) {
            return back()->with('error', 'Maaf, celah keahlian (Skill Gap) Anda sebesar ' . number_format($avgGap, 1) . '% melebihi batas maksimal 30%. Silakan ikuti kursus rekomendasi terlebih dahulu.');
        }

        $result = $applicationService->applyForJob($user, $id);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function respondToOffer(Request $request, $id, JobApplicationService $applicationService)
    {
        $request->validate([
            'response' => 'required|in:accepted,declined',
        ]);

        $user = Auth::user();
        $result = $applicationService->respondToOffer($user, $id, $request->response);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
