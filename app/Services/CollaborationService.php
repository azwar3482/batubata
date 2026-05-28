<?php

namespace App\Services;

use App\Jobs\SendCollaborationProposalJob;

class CollaborationService
{
    /**
     * Process collaboration proposal submission.
     *
     * @param array $validatedData
     * @param \Illuminate\Http\UploadedFile|null $attachment
     * @return void
     */
    public function processProposal(array $validatedData, $attachment = null)
    {
        $attachmentPath = null;
        if ($attachment) {
            $attachmentPath = $attachment->store('collaboration-proposals', 'public');
        }

        // Simulasi simpan ke database (sesuai instruksi USER untuk menunda pembuatan Model)
        // CollaborationRequest::create(array_merge($validatedData, ['attachment' => $attachmentPath]));

        // Dispatch job untuk simulasi pengiriman notifikasi email agar tidak blocking
        SendCollaborationProposalJob::dispatch($validatedData, $attachmentPath);
    }
}
