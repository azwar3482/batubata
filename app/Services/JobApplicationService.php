<?php

namespace App\Services;

use App\Models\User;
use App\Models\JobListing;
use App\Models\UserJobApplication;
use App\Services\JobMatchingService;

class JobApplicationService
{
    protected $matchingService;

    public function __construct(JobMatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    public function applyForJob(User $user, int $jobId)
    {
        $job = JobListing::findOrFail($jobId);

        $application = UserJobApplication::where('user_id', $user->id)
            ->where('job_listing_id', $jobId)
            ->first();

        if ($application) {
            if ($application->status !== 'saved') {
                return ['success' => false, 'message' => 'Anda sudah melamar lowongan ini sebelumnya.'];
            }

            $matchPercentage = $this->matchingService->calculateMatch($user, $job);

            $application->update([
                'status' => 'applied',
                'matching_percentage' => $matchPercentage,
                'applied_at' => now(),
            ]);

            return ['success' => true, 'message' => 'Lamaran berhasil dikirim!'];
        }

        $matchPercentage = $this->matchingService->calculateMatch($user, $job);

        UserJobApplication::create([
            'user_id' => $user->id,
            'job_listing_id' => $jobId,
            'matching_percentage' => $matchPercentage,
            'applied_at' => now(),
            'status' => 'applied',
        ]);

        return ['success' => true, 'message' => 'Lamaran berhasil dikirim!'];
    }

    public function toggleSaveJob(User $user, int $jobId)
    {
        $job = JobListing::findOrFail($jobId);

        $application = UserJobApplication::where('user_id', $user->id)
            ->where('job_listing_id', $jobId)
            ->first();

        if ($application) {
            if ($application->status === 'saved') {
                $application->delete();
                return ['success' => true, 'saved' => false, 'message' => 'Lowongan dihapus dari daftar simpanan!'];
            }
            return ['success' => false, 'message' => 'Anda sudah melamar lowongan ini.'];
        }

        $matchPercentage = $this->matchingService->calculateMatch($user, $job);

        UserJobApplication::create([
            'user_id' => $user->id,
            'job_listing_id' => $jobId,
            'matching_percentage' => $matchPercentage,
            'applied_at' => now(),
            'status' => 'saved',
        ]);

        return ['success' => true, 'saved' => true, 'message' => 'Lowongan berhasil disimpan!'];
    }

    public function getUserApplications(User $user, int $perPage = 10, ?string $status = null, $highlightJobId = null)
    {
        $query = UserJobApplication::with(['jobListing'])
            ->where('user_id', $user->id);

        if ($status) {
            $query->where('status', $status);
        }

        if ($highlightJobId) {
            $query->orderByRaw("CASE WHEN job_listing_id = ? THEN 0 ELSE 1 END", [$highlightJobId]);
        }

        return $query->orderBy('applied_at', 'desc')
            ->paginate($perPage);
    }

    public function getApplicationStats(User $user)
    {
        $stats = UserJobApplication::where('user_id', $user->id)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status IN ('applied', 'reviewed', 'interviewed') THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 'offered' THEN 1 ELSE 0 END) as offered,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            ")
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'processing' => $stats->processing ?? 0,
            'offered' => $stats->offered ?? 0,
            'rejected' => $stats->rejected ?? 0,
        ];
    }

    public function withdrawApplication(User $user, int $jobId)
    {
        $application = UserJobApplication::where('user_id', $user->id)
            ->where('job_listing_id', $jobId)
            ->first();

        if (!$application) {
            return ['success' => false, 'message' => 'Lamaran tidak ditemukan.'];
        }

        $applicationClone = clone $application;
        $application->delete();

        event(new \App\Events\JobApplicationWithdrawn($applicationClone));

        return ['success' => true, 'message' => 'Lamaran berhasil ditarik!'];
    }
}
