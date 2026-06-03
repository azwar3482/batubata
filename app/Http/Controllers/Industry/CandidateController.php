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

    public function index()
    {
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');

        $candidates = UserJobApplication::whereIn('job_listing_id', $jobIds)
            ->with(['user', 'jobListing', 'user.assessments.scores.competency'])
            ->orderByDesc('matching_percentage')
            ->paginate(15);

        return view('industry.candidates', compact('candidates'));
    }

    public function show(Request $request, $candidateId)
    {
        $jobId = $request->query('job_id');
        
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

        $candidate = User::with(['assessments.scores.competency', 'documents'])->find($candidateId);
        
        if (!$candidate) {
            abort(404, 'Kandidat tidak ditemukan');
        }

        // Hitung match percentage dari assessment terbaru (gunakan eager loaded data)
        $latestAssessment = $candidate->assessments->sortByDesc('assessment_date')->first();
        $matchPercentage = $application ? $application->matching_percentage : 0;
        
        if (!$matchPercentage && $latestAssessment) {
            $totalGap = $latestAssessment->scores->avg('gap_percentage');
            $matchPercentage = round(max(0, 100 - $totalGap), 1);
        }

        return view('industry.candidate-profile', compact('candidate', 'application', 'matchPercentage', 'jobId', 'latestAssessment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:applied,reviewed,interviewed,offered,rejected',
        ]);

        $application = UserJobApplication::findOrFail($id);
        
        $job = JobListing::findOrFail($application->job_listing_id);
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update([
            'status' => $request->status,
        ]);

        event(new \App\Events\JobApplicationStatusChanged($application));

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
