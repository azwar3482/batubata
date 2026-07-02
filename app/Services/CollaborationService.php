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

        $partnerName = '';
        if (!empty($validatedData['partner_id'])) {
            $partner = \App\Models\Company::find($validatedData['partner_id']);
            $partnerName = $partner->name ?? '';
        }

        $proposal = new \App\Models\CollaborationProposal();
        $proposal->user_id = \Illuminate\Support\Facades\Auth::id();
        $proposal->partner_name = $partnerName;
        $proposal->title = is_array($validatedData['collaboration_type'] ?? null)
            ? implode(', ', $validatedData['collaboration_type'])
            : ($validatedData['collaboration_type'] ?? '');
        $proposal->description = $validatedData['description'] ?? '';
        $proposal->status = 'pending';
        $proposal->save();

        $proposal->load('user');
        if ($proposal->user) {
            $proposal->user->notify(new \App\Notifications\CollaborationProposalNotification($proposal));
        }

        SendCollaborationProposalJob::dispatch($validatedData, $attachmentPath);
    }
}
