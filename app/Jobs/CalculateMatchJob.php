<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\JobListing;
use App\Models\UserJobApplication;
use App\Services\JobMatchingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CalculateMatchJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public int $jobId,
        public ?int $applicationId = null
    ) {}

    /**
     * Execute the job.
     */
    public function handle(JobMatchingService $matchingService): void
    {
        $user = User::find($this->userId);
        $job = JobListing::find($this->jobId);

        if (!$user || !$job) {
            Log::warning('CalculateMatchJob: User or Job not found', [
                'user_id' => $this->userId,
                'job_id' => $this->jobId,
            ]);
            return;
        }

        try {
            $matchPercentage = $matchingService->calculateMatch($user, $job);
            $shortcomings = $matchingService->getJobShortcomings($user, $job);

            if ($this->applicationId) {
                // Update existing application
                UserJobApplication::where('id', $this->applicationId)
                    ->update(['matching_percentage' => $matchPercentage]);
            } else {
                // Create or update direct offer
                UserJobApplication::updateOrCreate(
                    ['user_id' => $user->id, 'job_listing_id' => $job->id],
                    [
                        'matching_percentage' => $matchPercentage,
                        'applied_at' => now(),
                        'status' => 'offered',
                        'is_direct_offer' => true,
                        'direct_offer_status' => 'pending',
                    ]
                );
            }

            Log::info('CalculateMatchJob: Match calculated successfully', [
                'user_id' => $this->userId,
                'job_id' => $this->jobId,
                'match_percentage' => $matchPercentage,
            ]);
        } catch (\Exception $e) {
            Log::error('CalculateMatchJob: Error calculating match', [
                'user_id' => $this->userId,
                'job_id' => $this->jobId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
