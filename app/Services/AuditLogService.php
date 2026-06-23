<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function logDataAccess(string $targetUserId, string $action, array $context = []): void
    {
        Log::channel('audit')->info('Data Access', array_merge([
            'actor_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'target_user_id' => $targetUserId,
            'action' => $action,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toIso8601String(),
        ], $context));
    }

    public static function logConsent(int $userId, string $consentType, bool $granted): void
    {
        Log::channel('audit')->info('Consent Change', [
            'user_id' => $userId,
            'consent_type' => $consentType,
            'granted' => $granted,
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public static function logDataExport(int $userId, string $format): void
    {
        Log::channel('audit')->info('Data Export', [
            'user_id' => $userId,
            'format' => $format,
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public static function logDataDeletion(int $userId, string $reason): void
    {
        Log::channel('audit')->info('Data Deletion', [
            'user_id' => $userId,
            'reason' => $reason,
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public static function logCandidateViewed(int $viewerId, int $candidateId, ?int $jobId = null): void
    {
        Log::channel('audit')->info('Candidate Profile Viewed', [
            'viewer_id' => $viewerId,
            'candidate_id' => $candidateId,
            'job_id' => $jobId,
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
