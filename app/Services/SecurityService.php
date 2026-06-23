<?php

namespace App\Services;

use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SecurityAlertNotification;
use App\Notifications\DataBreachUserNotification;

class SecurityService
{
    // Thresholds for detection
    private int $maxProfileViewsPerMinute = 30;
    private int $maxLoginAttemptsPerHour = 10;
    private int $maxExportsPerDay = 5;
    private int $maxApiCallsPerMinute = 100;

    /**
     * Check for suspicious profile viewing behavior
     */
    public function checkProfileAccess(int $viewerId, int $targetId): void
    {
        $key = "profile_views:{$viewerId}";
        $views = Cache::get($key, 0);
        
        Cache::put($key, $views + 1, now()->addMinute());

        if ($views >= $this->maxProfileViewsPerMinute) {
            $this->createAlert(
                SecurityLog::EVENT_MASS_ACCESS,
                "User #{$viewerId} accessed {$views} profiles in 1 minute (threshold: {$this->maxProfileViewsPerMinute})",
                [
                    'severity' => SecurityLog::SEVERITY_HIGH,
                    'user_id' => $viewerId,
                    'context' => [
                        'view_count' => $views,
                        'threshold' => $this->maxProfileViewsPerMinute,
                        'target_id' => $targetId,
                    ]
                ]
            );
        }
    }

    /**
     * Check for suspicious login behavior
     */
    public function checkLoginAttempt(string $email, bool $success, ?string $ip = null): void
    {
        $ip = $ip ?? request()->ip();
        $key = "login_attempts:{$ip}";
        $attempts = Cache::get($key, 0);
        
        if (!$success) {
            Cache::put($key, $attempts + 1, now()->addHour());
            
            if ($attempts >= $this->maxLoginAttemptsPerHour) {
                $this->createAlert(
                    SecurityLog::EVENT_BRUTE_FORCE,
                    "Brute force detected from IP {$ip}: {$attempts} failed attempts in 1 hour",
                    [
                        'severity' => SecurityLog::SEVERITY_CRITICAL,
                        'ip' => $ip,
                        'context' => [
                            'email' => $email,
                            'attempt_count' => $attempts,
                            'threshold' => $this->maxLoginAttemptsPerHour,
                        ]
                    ]
                );
            }
        } else {
            // Check for login from new location/device
            $user = User::where('email', $email)->first();
            if ($user) {
                $this->checkNewDeviceLogin($user, $ip);
            }
            Cache::forget($key);
        }
    }

    /**
     * Check for login from new device/location
     */
    private function checkNewDeviceLogin(User $user, string $ip): void
    {
        $key = "user_ips:{$user->id}";
        $knownIps = Cache::get($key, []);
        
        if (!in_array($ip, $knownIps)) {
            $knownIps[] = $ip;
            Cache::put($key, array_slice($knownIps, -10), now()->addDays(30));
            
            if (count($knownIps) > 1) {
                $this->createAlert(
                    SecurityLog::EVENT_SUSPICIOUS_LOGIN,
                    "User #{$user->id} ({$user->email}) login from new IP: {$ip}",
                    [
                        'severity' => SecurityLog::SEVERITY_MEDIUM,
                        'user_id' => $user->id,
                        'ip' => $ip,
                        'context' => [
                            'known_ips' => $knownIps,
                            'new_ip' => $ip,
                        ]
                    ]
                );
            }
        }
    }

    /**
     * Check for data export anomaly
     */
    public function checkDataExport(int $userId): void
    {
        $key = "data_exports:{$userId}";
        $exports = Cache::get($key, 0);
        
        Cache::put($key, $exports + 1, now()->addDay());

        if ($exports >= $this->maxExportsPerDay) {
            $this->createAlert(
                SecurityLog::EVENT_DATA_EXPORT_ANOMALY,
                "User #{$userId} exported data {$exports} times today (threshold: {$this->maxExportsPerDay})",
                [
                    'severity' => SecurityLog::SEVERITY_HIGH,
                    'user_id' => $userId,
                    'context' => [
                        'export_count' => $exports,
                        'threshold' => $this->maxExportsPerDay,
                    ]
                ]
            );
        }
    }

    /**
     * Check for API rate limiting
     */
    public function checkApiRateLimit(int $userId, string $endpoint): void
    {
        $key = "api_calls:{$userId}:{$endpoint}";
        $calls = Cache::get($key, 0);
        
        Cache::put($key, $calls + 1, now()->addMinute());

        if ($calls >= $this->maxApiCallsPerMinute) {
            $this->createAlert(
                SecurityLog::EVENT_DATA_SCRAPING,
                "User #{$userId} made {$calls} API calls to {$endpoint} in 1 minute",
                [
                    'severity' => SecurityLog::SEVERITY_HIGH,
                    'user_id' => $userId,
                    'context' => [
                        'endpoint' => $endpoint,
                        'call_count' => $calls,
                        'threshold' => $this->maxApiCallsPerMinute,
                    ]
                ]
            );
        }
    }

    /**
     * Create security alert and notify admin + affected users
     */
    private function createAlert(string $eventType, string $description, array $options = []): SecurityLog
    {
        $log = SecurityLog::log($eventType, $description, $options);

        // Notify admin for high/critical severity
        if (in_array($options['severity'] ?? '', [SecurityLog::SEVERITY_HIGH, SecurityLog::SEVERITY_CRITICAL])) {
            $this->notifyAdmin($log);
        }

        // Notify affected user if applicable
        if (!empty($options['user_id']) && in_array($options['severity'] ?? '', [SecurityLog::SEVERITY_HIGH, SecurityLog::SEVERITY_CRITICAL])) {
            $this->notifyAffectedUser($log, $options['user_id']);
        }

        return $log;
    }

    /**
     * Notify admin about security alert
     */
    private function notifyAdmin(SecurityLog $log): void
    {
        try {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new SecurityAlertNotification($log));
            
            Log::channel('security')->warning('Security Alert Created', [
                'log_id' => $log->id,
                'event_type' => $log->event_type,
                'severity' => $log->severity,
                'description' => $log->description,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send security notification', [
                'error' => $e->getMessage(),
                'log_id' => $log->id,
            ]);
        }
    }

    /**
     * Notify affected user about data breach
     */
    private function notifyAffectedUser(SecurityLog $log, int $userId): void
    {
        try {
            $user = User::find($userId);
            if ($user) {
                $user->notify(new DataBreachUserNotification($log));
                
                Log::channel('security')->info('User notified about security event', [
                    'log_id' => $log->id,
                    'user_id' => $userId,
                    'event_type' => $log->event_type,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send user security notification', [
                'error' => $e->getMessage(),
                'log_id' => $log->id,
                'user_id' => $userId,
            ]);
        }
    }

    /**
     * Get security dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            'total_alerts' => SecurityLog::count(),
            'unresolved_alerts' => SecurityLog::unresolved()->count(),
            'critical_alerts' => SecurityLog::unresolved()->critical()->count(),
            'recent_alerts' => SecurityLog::recent(24)->count(),
            'alerts_by_type' => SecurityLog::selectRaw('event_type, COUNT(*) as count')
                ->groupBy('event_type')
                ->pluck('count', 'event_type'),
            'alerts_by_severity' => SecurityLog::selectRaw('severity, COUNT(*) as count')
                ->groupBy('severity')
                ->pluck('count', 'severity'),
            'latest_alerts' => SecurityLog::with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ];
    }
}
