<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTeamInviteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $teamInvite;

    public function __construct($teamInvite)
    {
        $this->teamInvite = $teamInvite;
    }

    public function handle()
    {
        // Simulasi pengiriman email
        // \Illuminate\Support\Facades\Mail::to($this->teamInvite->email)
        //     ->send(new \App\Mail\TeamInvitationMail($this->teamInvite));
    }
}
