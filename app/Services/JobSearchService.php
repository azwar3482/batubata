<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;

class JobSearchService
{
    protected $matchingService;
    protected $geoService;

    public function __construct(JobMatchingService $matchingService, GeoLocationService $geoService)
    {
        $this->matchingService = $matchingService;
        $this->geoService = $geoService;
    }

    public function searchJobs(array $filters, User $user, int $perPage = 12)
    {
        $query = JobListing::where('is_active', true)
            ->where('expires_date', '>', now());

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        if (!empty($filters['work_type'])) {
            $query->where('work_type', $filters['work_type']);
        }

        if (!empty($filters['salary_min'])) {
            $query->where('salary_max', '>=', $filters['salary_min']);
        }

        if (!empty($filters['experience'])) {
            $query->where('experience_required', $filters['experience']);
        }

        $jobs = $query->orderBy('posted_date', 'desc')->paginate($perPage);

        $jobsCollection = $jobs->getCollection();

        // 1. Tambahkan informasi jarak
        $jobsCollection = $this->geoService->appendDistanceToJobs($jobsCollection, $user);

        // 2. Jika filter nearby aktif (dan user punya lokasi), filter & urutkan ulang
        if (!empty($filters['nearby']) && $filters['nearby'] == 'true' && $user->latitude && $user->longitude) {
            $jobsCollection = $jobsCollection->filter(function($job) {
                return $job->distance_km !== null && $job->distance_km <= 50; // Radius 50km
            })->sortBy('distance_km')->values();
        }

        // 3. Tambahkan skor matching
        $jobsCollection->transform(function ($job) use ($user) {
            $job->matching_percentage = $this->matchingService->calculateMatch($user, $job);
            return $job;
        });

        $jobs->setCollection($jobsCollection);

        return $jobs;
    }

    public function getFilters()
    {
        $locations = JobListing::distinct()->pluck('location')->filter();
        $workTypes = JobListing::distinct()->pluck('work_type')->filter();

        return compact('locations', 'workTypes');
    }

    public function getJobDetail(int $jobId, User $user)
    {
        $job = JobListing::findOrFail($jobId);

        $matchPercentage = $this->matchingService->calculateMatch($user, $job);

        $alreadyApplied = $user->jobApplications()
            ->where('job_listing_id', $jobId)
            ->where('status', '!=', 'saved')
            ->exists();

        $isSaved = $user->jobApplications()
            ->where('job_listing_id', $jobId)
            ->where('status', 'saved')
            ->exists();

        return compact('job', 'matchPercentage', 'alreadyApplied', 'isSaved');
    }

    public function getSkillMatchBreakdown(int $jobId, User $user)
    {
        $job = JobListing::findOrFail($jobId);
        $matchPercentage = $this->matchingService->calculateMatch($user, $job);
        $skillBreakdown = $this->matchingService->getSkillBreakdown($user, $job);

        return compact('job', 'matchPercentage', 'skillBreakdown');
    }
}
