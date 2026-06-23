<?php

namespace App\Services;

use App\Models\ManualReviewRequest;
use App\Models\User;
use App\Models\JobListing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManualReviewService
{
    /**
     * Create a new manual review request
     */
    public function createRequest(User $user, ?int $jobListingId = null, ?string $notes = null): ManualReviewRequest
    {
        // Check if user has pending request
        $pendingRequest = ManualReviewRequest::where('user_id', $user->id)
            ->where('status', ManualReviewRequest::STATUS_PENDING)
            ->exists();

        if ($pendingRequest) {
            throw new \Exception('Anda sudah memiliki permintaan review yang sedang diproses.');
        }

        // Get current matching score
        $originalScore = null;
        if ($jobListingId) {
            $job = JobListing::find($jobListingId);
            if ($job) {
                $matchingService = app(JobMatchingService::class);
                $originalScore = $matchingService->calculateMatch($user, $job);
            }
        }

        return ManualReviewRequest::create([
            'user_id' => $user->id,
            'job_listing_id' => $jobListingId,
            'status' => ManualReviewRequest::STATUS_PENDING,
            'amount' => ManualReviewRequest::PRICE,
            'payment_status' => ManualReviewRequest::PAYMENT_PENDING,
            'user_notes' => $notes,
            'original_score' => $originalScore,
        ]);
    }

    /**
     * Process payment for review request
     */
    public function processPayment(int $requestId, string $paymentMethod, string $paymentReference): ManualReviewRequest
    {
        $reviewRequest = ManualReviewRequest::findOrFail($requestId);

        if ($reviewRequest->payment_status === ManualReviewRequest::PAYMENT_PAID) {
            throw new \Exception('Pembayaran sudah diproses sebelumnya.');
        }

        $reviewRequest->update([
            'payment_status' => ManualReviewRequest::PAYMENT_PAID,
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
            'paid_at' => now(),
        ]);

        Log::info('Manual review payment processed', [
            'request_id' => $requestId,
            'user_id' => $reviewRequest->user_id,
            'amount' => $reviewRequest->amount,
            'method' => $paymentMethod,
        ]);

        return $reviewRequest;
    }

    /**
     * Admin: Start reviewing a request
     */
    public function startReview(int $requestId, User $admin): ManualReviewRequest
    {
        $reviewRequest = ManualReviewRequest::findOrFail($requestId);

        if ($reviewRequest->payment_status !== ManualReviewRequest::PAYMENT_PAID) {
            throw new \Exception('Pembayaran belum dilakukan.');
        }

        if ($reviewRequest->status !== ManualReviewRequest::STATUS_PENDING) {
            throw new \Exception('Permintaan review tidak dalam status pending.');
        }

        $reviewRequest->update([
            'status' => ManualReviewRequest::STATUS_IN_REVIEW,
            'reviewed_by' => $admin->id,
        ]);

        return $reviewRequest;
    }

    /**
     * Admin: Complete review with feedback
     */
    public function completeReview(int $requestId, User $admin, string $feedback, ?int $reviewedScore = null): ManualReviewRequest
    {
        $reviewRequest = ManualReviewRequest::findOrFail($requestId);

        if ($reviewRequest->status !== ManualReviewRequest::STATUS_IN_REVIEW) {
            throw new \Exception('Permintaan review belum dimulai.');
        }

        $reviewRequest->update([
            'status' => ManualReviewRequest::STATUS_COMPLETED,
            'admin_feedback' => $feedback,
            'reviewed_score' => $reviewedScore,
            'reviewed_at' => now(),
        ]);

        // Notify user
        $reviewRequest->user->notify(new \App\Notifications\ManualReviewCompletedNotification($reviewRequest));

        Log::info('Manual review completed', [
            'request_id' => $requestId,
            'admin_id' => $admin->id,
            'original_score' => $reviewRequest->original_score,
            'reviewed_score' => $reviewedScore,
        ]);

        return $reviewRequest;
    }

    /**
     * Cancel a review request (refund if paid)
     */
    public function cancelRequest(int $requestId, string $reason = ''): ManualReviewRequest
    {
        $reviewRequest = ManualReviewRequest::findOrFail($requestId);

        if ($reviewRequest->status === ManualReviewRequest::STATUS_COMPLETED) {
            throw new \Exception('Permintaan review yang sudah selesai tidak dapat dibatalkan.');
        }

        $reviewRequest->update([
            'status' => ManualReviewRequest::STATUS_CANCELLED,
            'payment_status' => ManualReviewRequest::PAYMENT_REFUNDED,
            'admin_feedback' => "Dibatalkan: {$reason}",
        ]);

        return $reviewRequest;
    }

    /**
     * Get user's review requests
     */
    public function getUserRequests(User $user, int $perPage = 10)
    {
        return ManualReviewRequest::where('user_id', $user->id)
            ->with('jobListing')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all pending requests for admin
     */
    public function getPendingRequests(int $perPage = 20)
    {
        return ManualReviewRequest::with(['user', 'jobListing'])
            ->where('status', ManualReviewRequest::STATUS_PENDING)
            ->where('payment_status', ManualReviewRequest::PAYMENT_PAID)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get admin dashboard stats
     */
    public function getStats(): array
    {
        return [
            'total_requests' => ManualReviewRequest::count(),
            'pending_requests' => ManualReviewRequest::where('status', ManualReviewRequest::STATUS_PENDING)->count(),
            'in_review' => ManualReviewRequest::where('status', ManualReviewRequest::STATUS_IN_REVIEW)->count(),
            'completed' => ManualReviewRequest::where('status', ManualReviewRequest::STATUS_COMPLETED)->count(),
            'total_revenue' => ManualReviewRequest::where('payment_status', ManualReviewRequest::PAYMENT_PAID)->sum('amount'),
            'today_requests' => ManualReviewRequest::whereDate('created_at', today())->count(),
        ];
    }
}
