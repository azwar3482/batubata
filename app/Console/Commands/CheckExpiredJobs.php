<?php

namespace App\Console\Commands;

use App\Jobs\CheckExpiredJobsAndNotify;
use Illuminate\Console\Command;

class CheckExpiredJobs extends Command
{
    protected $signature = 'jobs:check-expired';
    protected $description = 'Cek lowongan yang sudah expired dan kirim notifikasi ke pelamar';

    public function handle()
    {
        $this->info('Menjalankan pengecekan lowongan expired...');

        CheckExpiredJobsAndNotify::dispatch();

        $this->info('Job dispatched. Notifikasi akan dikirim secara background.');
        return 0;
    }
}
