<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityLog extends Model
{
    protected $fillable = [
        'user_id',
        'event_type',
        'severity',
        'ip_address',
        'user_agent',
        'description',
        'context',
        'is_resolved',
        'resolved_by',
        'resolution_notes',
        'resolved_at',
    ];

    protected $casts = [
        'context' => 'array',
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    // Event types
    const EVENT_SUSPICIOUS_LOGIN = 'suspicious_login';
    const EVENT_MASS_ACCESS = 'mass_access';
    const EVENT_DATA_SCRAPING = 'data_scraping';
    const EVENT_ACCOUNT_TAKEOVER = 'account_takeover';
    const EVENT_BRUTE_FORCE = 'brute_force';
    const EVENT_UNAUTHORIZED_ACCESS = 'unauthorized_access';
    const EVENT_DATA_EXPORT_ANOMALY = 'data_export_anomaly';
    const EVENT_MULTIPLE_FAILED_LOGINS = 'multiple_failed_logins';

    // Severity levels
    const SEVERITY_LOW = 'low';
    const SEVERITY_MEDIUM = 'medium';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function resolve(User $resolver, string $notes = ''): void
    {
        $this->update([
            'is_resolved' => true,
            'resolved_by' => $resolver->id,
            'resolution_notes' => $notes,
            'resolved_at' => now(),
        ]);
    }

    public function scopeUnresolved($query)
    {
        return $query->where('is_resolved', false);
    }

    public function scopeCritical($query)
    {
        return $query->where('severity', self::SEVERITY_CRITICAL);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    public static function log(string $eventType, string $description, array $options = []): self
    {
        return static::create([
            'user_id' => $options['user_id'] ?? auth()->id(),
            'event_type' => $eventType,
            'severity' => $options['severity'] ?? self::SEVERITY_MEDIUM,
            'ip_address' => $options['ip'] ?? request()->ip(),
            'user_agent' => $options['user_agent'] ?? request()->userAgent(),
            'description' => $description,
            'context' => $options['context'] ?? null,
        ]);
    }
}
