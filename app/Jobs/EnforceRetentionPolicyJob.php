<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EnforceRetentionPolicyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $now = Carbon::now();
        $deletedCounts = [];

        // 1. Hapus session data > 30 hari
        $deleted = DB::table('sessions')
            ->where('last_activity', '<', $now->copy()->subDays(30)->timestamp)
            ->delete();
        $deletedCounts['sessions'] = $deleted;

        // 2. Hapus chat messages > 1 tahun
        $deleted = DB::table('chat_messages')
            ->where('created_at', '<', $now->copy()->subYear())
            ->delete();
        $deletedCounts['chat_messages'] = $deleted;

        // 3. Hapus direct messages > 1 tahun
        $deleted = DB::table('direct_messages')
            ->where('created_at', '<', $now->copy()->subYear())
            ->delete();
        $deletedCounts['direct_messages'] = $deleted;

        // 4. Anonimkan data user nonaktif > 2 tahun
        $inactiveUsers = DB::table('users')
            ->where('updated_at', '<', $now->copy()->subYears(2))
            ->whereNull('email_verified_at')
            ->pluck('id');

        if ($inactiveUsers->isNotEmpty()) {
            foreach ($inactiveUsers->chunk(100) as $chunk) {
                DB::table('users')
                    ->whereIn('id', $chunk)
                    ->update([
                        'name' => 'Deleted User',
                        'email' => DB::raw("CONCAT('deleted_', id, '@anonymized.local')"),
                        'phone' => null,
                        'address' => null,
                        'bio' => null,
                        'latitude' => null,
                        'longitude' => null,
                        'blood_type' => null,
                        'birth_date' => null,
                        'linkedin_url' => null,
                        'github_url' => null,
                        'portfolio_url' => null,
                        'skills' => null,
                        'languages' => null,
                        'expected_jobs' => null,
                        'job_preferences' => null,
                        'provider_id' => null,
                        'updated_at' => $now,
                    ]);
            }
            $deletedCounts['anonymized_users'] = $inactiveUsers->count();
        }

        // 5. Hapus consent logs yang sudah dicabut > 3 tahun
        $deleted = DB::table('consents')
            ->where('revoked_at', '<', $now->copy()->subYears(3))
            ->delete();
        $deletedCounts['old_consents'] = $deleted;

        Log::channel('audit')->info('RetentionPolicy executed', [
            'deleted_counts' => $deletedCounts,
            'timestamp' => $now->toIso8601String(),
        ]);
    }
}
