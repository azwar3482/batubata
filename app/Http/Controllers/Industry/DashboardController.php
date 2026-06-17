<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\User;
use App\Models\UserJobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('company');
        $cacheKey = 'industry.dashboard.' . $user->id;

        $stats = Cache::remember($cacheKey . '.stats', 300, function () use ($user) {
            $totalJobs = JobListing::where('user_id', $user->id)->where('is_active', true)->count();

            $totalApplicants = UserJobApplication::whereHas('jobListing', fn($q) => $q->where('user_id', $user->id))->count();

            // Kandidat dengan match > 80%
            $highMatchCandidates = UserJobApplication::whereHas('jobListing', fn($q) => $q->where('user_id', $user->id))
                ->where('matching_percentage', '>=', 80)
                ->count();

            // Rata-rata hari hiring (dari apply sampai diterima)
            $avgHiringDays = UserJobApplication::whereHas('jobListing', fn($q) => $q->where('user_id', $user->id))
                ->where('status', 'accepted')
                ->whereNotNull('applied_at')
                ->selectRaw('AVG(DATEDIFF(updated_at, applied_at)) as avg_days')
                ->value('avg_days');

            return [
                'totalJobs' => $totalJobs,
                'totalApplicants' => $totalApplicants,
                'highMatchCandidates' => $highMatchCandidates,
                'avgHiringDays' => $avgHiringDays ? round($avgHiringDays) : 0,
            ];
        });

        // Data yang selalu fresh (tidak di-cache)
        $recentJobs = JobListing::where('user_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $recentCandidates = UserJobApplication::whereHas('jobListing', fn($q) => $q->where('user_id', $user->id))
            ->with(['user', 'jobListing'])
            ->orderByDesc('matching_percentage')
            ->take(5)
            ->get();

        // Funnel rekrutmen
        $funnelData = Cache::remember($cacheKey . '.funnel', 300, function () use ($user) {
            $jobIds = JobListing::where('user_id', $user->id)->pluck('id');
            return UserJobApplication::whereIn('job_listing_id', $jobIds)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');
        });

        $totalFunnel = $funnelData->sum();
        $funnelPercentages = [
            'applied' => $totalFunnel > 0 ? round(($funnelData->get('applied', 0) / $totalFunnel) * 100) : 0,
            'reviewed' => $totalFunnel > 0 ? round(($funnelData->get('reviewed', 0) / $totalFunnel) * 100) : 0,
            'interview' => $totalFunnel > 0 ? round(($funnelData->get('interview', 0) / $totalFunnel) * 100) : 0,
            'accepted' => $totalFunnel > 0 ? round(($funnelData->get('accepted', 0) / $totalFunnel) * 100) : 0,
        ];

        return view('industry.dashboard', compact(
            'stats', 'recentJobs', 'recentCandidates', 'funnelPercentages'
        ));
    }

    public function downloadReport()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RecruitmentReportExport, 'laporan-rekrutmen.xlsx');
    }
}
