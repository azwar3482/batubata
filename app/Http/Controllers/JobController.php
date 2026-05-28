<?php

namespace App\Http\Controllers;

use App\Services\JobSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    protected $jobSearchService;

    public function __construct(JobSearchService $jobSearchService)
    {
        $this->jobSearchService = $jobSearchService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $jobs = $this->jobSearchService->searchJobs($request->all(), $user);
        $filters = $this->jobSearchService->getFilters();

        return view('jobs.all', array_merge(['jobs' => $jobs], $filters));
    }

    public function show($id)
    {
        $user = Auth::user();
        $detailData = $this->jobSearchService->getJobDetail($id, $user);

        return view('jobs.detail', $detailData);
    }

    public function skillMatch($jobId)
    {
        $user = Auth::user();
        $breakdownData = $this->jobSearchService->getSkillMatchBreakdown($jobId, $user);

        return view('jobs.skill-match', $breakdownData);
    }
}
