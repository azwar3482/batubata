<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        // 1. Hapus foto profil dari disk
        if ($this->user->photo && Storage::disk('public')->exists($this->user->photo)) {
            Storage::disk('public')->delete($this->user->photo);
        }

        // 2. Hapus CV dari disk
        if ($this->user->cv_path && Storage::disk('public')->exists($this->user->cv_path)) {
            Storage::disk('public')->delete($this->user->cv_path);
        }

        // 3. Di sini kita juga bisa menghapus data relasional berat secara aman
        // Contoh: $this->user->jobApplications()->delete();
        // Contoh: $this->user->assessments()->delete();

        // 4. Hapus record user dari database
        $this->user->delete();
    }
}
