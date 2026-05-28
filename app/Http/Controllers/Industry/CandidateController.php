<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Services\CandidateService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserJobApplication;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    public function show(Request $request, $candidateId)
    {
        $jobId = $request->query('job_id');
        
        // Find the application
        $application = null;
        if ($jobId) {
            $application = UserJobApplication::where('user_id', $candidateId)
                ->where('job_listing_id', $jobId)
                ->first();
        } else {
            $application = UserJobApplication::where('user_id', $candidateId)
                ->orderBy('applied_at', 'desc')
                ->first();
        }

        $candidate = User::find($candidateId);
        
        // Fallback to Mock Data if user is not in database
        if (!$candidate) {
            $data = $this->candidateService->getCandidateDetail($candidateId);
            $candidate = (object) $data['candidate'];
            $matchPercentage = $data['matchPercentage'];
        } else {
            $matchPercentage = $application ? $application->matching_percentage : 75;
        }

        return view('industry.candidate-profile', compact('candidate', 'application', 'matchPercentage', 'jobId'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:applied,reviewed,interviewed,offered,rejected',
        ]);

        $application = UserJobApplication::findOrFail($id);
        
        // Ensure the current industry user owns the job listing associated with this application
        $job = JobListing::findOrFail($application->job_listing_id);
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update([
            'status' => $request->status,
        ]);

        $statusTranslations = [
            'applied' => 'Dikirim',
            'reviewed' => 'Direview',
            'interviewed' => 'Interview',
            'offered' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        $statusLabel = $statusTranslations[$request->status] ?? $request->status;

        return back()->with('success', "Status lamaran berhasil diperbarui menjadi {$statusLabel}!");
    }
}
