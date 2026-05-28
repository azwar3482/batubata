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
        
        $search = $request->input('search');
        $sort = $request->input('sort', 'kecocokan');
        $perPage = $request->input('per_page', 10);
        
        $jobs = $matchingService->getMatchedJobsPaginated($user, $perPage, $search, $sort);
        
        return view('jobs.index', compact('jobs'));
    }

    public function jobDetail($id, JobMatchingService $matchingService)
    {
        $job = JobListing::findOrFail($id);
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
        $status = $request->input('status');
        $highlightJobId = $request->input('highlight_job_id');
        
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
        $result = $applicationService->applyForJob($user, $id);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
