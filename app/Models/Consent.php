<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consent extends Model
{
    protected $fillable = [
        'user_id',
        'consent_type',
        'granted',
        'ip_address',
        'user_agent',
        'consent_version',
        'granted_at',
        'revoked_at',
    ];

    protected $casts = [
        'granted' => 'boolean',
        'granted_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function TYPES(): array
    {
        return [
            'blood_type' => 'Persetujuan pengumpulan data golongan darah',
            'data_processing' => 'Persetujuan pemrosesan data pribadi',
            'data_sharing' => 'Persetujuan berbagi data dengan perusahaan',
            'cookies' => 'Persetujuan penggunaan cookies',
        ];
    }

    public static function hasConsent(int $userId, string $type): bool
    {
        return static::where('user_id', $userId)
            ->where('consent_type', $type)
            ->where('granted', true)
            ->whereNull('revoked_at')
            ->exists();
    }

    public static function grant(int $userId, string $type, ?string $ip = null, ?string $agent = null): self
    {
        // Revoke previous consent if exists (use DB to avoid Eloquent update issues)
        \DB::table('consents')
            ->where('user_id', $userId)
            ->where('consent_type', $type)
            ->where('granted', true)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now(), 'updated_at' => now()]);

        return static::create([
            'user_id' => $userId,
            'consent_type' => $type,
            'granted' => true,
            'ip_address' => $ip,
            'user_agent' => $agent,
            'granted_at' => now(),
        ]);
    }

    public static function revoke(int $userId, string $type): void
    {
        \DB::table('consents')
            ->where('user_id', $userId)
            ->where('consent_type', $type)
            ->where('granted', true)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now(), 'updated_at' => now()]);
    }
}
