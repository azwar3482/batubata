<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Models\UserJobApplication;
use App\Models\TpaTestSession;
use App\Notifications\JobNoLongerAvailable;
use App\Notifications\ApplicationStatusNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckExpiredJobsAndNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Log::info('CheckExpiredJobsAndNotify: Starting...');

        // 1. Cek lowongan yang sudah expired (expires_date sudah lewat tapi masih active)
        $expiredJobs = JobListing::where('is_active', true)
            ->whereNotNull('expires_date')
            ->where('expires_date', '<', now())
            ->get();

        foreach ($expiredJobs as $job) {
            $job->update(['is_active' => false]);

            // Notifikasi ke semua pelamar yang masih aktif
            $applications = UserJobApplication::where('job_listing_id', $job->id)
                ->whereIn('status', ['applied', 'reviewed'])
                ->with('user')
                ->get();

            foreach ($applications as $application) {
                $application->user->notify(new ApplicationStatusNotification(
                    $application,
                    'job_expired',
                    'Lowongan "' . $job->title . '" telah berakhir pada ' . $job->expires_date->format('d M Y') . '. Lamaran Anda tidak dapat diproses lebih lanjut.'
                ));
            }

            Log::info("CheckExpiredJobsAndNotify: Job {$job->id} marked as expired, notified {$applications->count()} applicants");
        }

        // 2. Cek lowongan yang sudah tidak aktif dan punya pelamar dengan TPA aktif
        $inactiveJobs = JobListing::where('is_active', false)
            ->whereHas('applications.tpaSession', function ($q) {
                $q->whereIn('status', ['invited', 'in_progress']);
            })
            ->get();

        foreach ($inactiveJobs as $job) {
            // TPA tetap bisa diakses, tapi beri tahu seeker bahwa lowongan sudah tidak aktif
            $applications = UserJobApplication::where('job_listing_id', $job->id)
                ->where('tpa_status', 'invited')
                ->with('user')
                ->get();

            foreach ($applications as $application) {
                $application->user->notify(new ApplicationStatusNotification(
                    $application,
                    'job_closed',
                    'Lowongan "' . $job->title . '" sudah ditutup oleh perusahaan. Tes TPA Anda masih dapat dikerjakan jika undangan masih aktif.'
                ));
            }

            Log::info("CheckExpiredJobsAndNotify: Job {$job->id} is inactive, notified TPA applicants");
        }

        // 3. Cek TPA session yang sudah expired
        $expiredSessions = TpaTestSession::where('status', 'invited')
            ->where('expires_at', '<', now())
            ->with(['user', 'tpaTest'])
            ->get();

        foreach ($expiredSessions as $session) {
            $session->update(['status' => 'expired']);

            // Update application TPA status
            if ($session->job_application_id) {
                $application = UserJobApplication::find($session->job_application_id);
                if ($application) {
                    $application->update(['tpa_status' => 'failed']);
                }
            }

            $session->user->notify(new ApplicationStatusNotification(
                $session->jobApplication ?? new \App\Models\UserJobApplication(),
                'tpa_expired',
                'Undangan Tes TPA "' . $session->tpaTest->title . '" telah berakhir. Anda tidak dapat mengerjakan tes ini lagi.'
            ));

            Log::info("CheckExpiredJobsAndNotify: TPA session {$session->id} expired");
        }

        Log::info('CheckExpiredJobsAndNotify: Completed');
    }
}
