<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCollaborationProposalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validatedData;
    protected $attachmentPath;

    public function __construct(array $validatedData, ?string $attachmentPath)
    {
        $this->validatedData = $validatedData;
        $this->attachmentPath = $attachmentPath;
    }

    public function handle()
    {
        // Simulasi pengiriman email ke partner untuk diproses di latar belakang
        // Mail::to($this->validatedData['contact_email'])->send(new CollaborationRequestMail($this->validatedData, $this->attachmentPath));
    }
}
