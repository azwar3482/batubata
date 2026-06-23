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

        $profileWarnings = [];
        if (!$user->gender) $profileWarnings[] = 'Jenis kelamin belum diisi';
        if (!$user->birth_date) $profileWarnings[] = 'Tanggal lahir belum diisi';
        if (empty($user->expected_jobs)) $profileWarnings[] = 'Posisi yang diharapkan belum diisi';
        if (empty($user->languages)) $profileWarnings[] = 'Bahasa yang dikuasai belum diisi';

        $hasAssessment = $user->assessments()->exists();
        if (!$hasAssessment) $profileWarnings[] = 'Asesmen kompetensi belum dilakukan';

        return view('jobs.index', array_merge(['jobs' => $jobs, 'profileWarnings' => $profileWarnings, 'hasAssessment' => $hasAssessment], $filters));
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
