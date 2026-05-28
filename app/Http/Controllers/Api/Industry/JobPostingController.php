<?php

namespace App\Http\Controllers\Api\Industry;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\User;
use App\Notifications\NewJobMatchNotification;
use App\Services\JobMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobPostingController extends Controller
{
    /**
     * Store a newly created job listing in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string',
            'work_type' => 'required|in:remote,hybrid,onsite',
            'description' => 'required|string',
            'required_skills' => 'required', // Can be array or string
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'experience_required' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle required_skills (ensure it's an array)
        $skills = $request->required_skills;
        if (is_string($skills)) {
            $skills = array_map('trim', explode(',', $skills));
        }

        try {
            $job = JobListing::create([
                'user_id' => Auth::id(),
                'external_id' => 'INT-' . strtoupper(uniqid()),
                'source_platform' => 'Internal',
                'title' => $request->title,
                'company_name' => $request->company_name,
                'location' => $request->location,
                'work_type' => $request->work_type,
                'salary_min' => $request->salary_min,
                'salary_max' => $request->salary_max,
                'experience_required' => $request->experience_required ?? 'Fresh Graduate',
                'description' => $request->description,
                'required_skills' => $skills,
                'application_url' => '#',
                'posted_date' => now(),
                'expires_date' => now()->addDays(30),
                'is_active' => true,
            ]);

            // Notify matching candidates (Job Matching Logic)
            $matchingService = new JobMatchingService();
            $seekers = User::where('role', 'job_seeker')->get();
            
            $notifiedCount = 0;
            foreach ($seekers as $seeker) {
                /** @var \App\Models\User $seeker */
                // We need to pass the actual JobListing model to the service
                $matchScore = $matchingService->calculateMatch($seeker, $job);
                
                if ($matchScore >= 70) {
                    $seeker->notify(new NewJobMatchNotification($job, $matchScore));
                    $notifiedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Lowongan berhasil diposting!',
                'data' => [
                    'job' => $job,
                    'notified_candidates' => $notifiedCount
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memposting lowongan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get jobs posted by the current industry user.
     */
    public function index()
    {
        $jobs = JobListing::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jobs
        ]);
    }
}
