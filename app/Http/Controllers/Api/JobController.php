<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\UserJobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = JobListing::where('is_active', true)->with('company');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('required_skills', $search);
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Work type filter
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'salary_high':
                $query->orderBy('salary_max', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = $request->input('per_page', 15);
        $jobs = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'data' => $jobs->map(function ($job) use ($user) {
                    return $this->formatJob($job, $user);
                }),
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'total' => $jobs->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $job = JobListing::with('company')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatJobDetail($job, $user),
        ]);
    }

    public function apply(Request $request, $id)
    {
        $user = Auth::user();
        $job = JobListing::findOrFail($id);

        // Check if already applied
        $existing = UserJobApplication::where('user_id', $user->id)
            ->where('job_listing_id', $job->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melamar lowongan ini',
            ], 422);
        }

        $application = UserJobApplication::create([
            'user_id' => $user->id,
            'job_listing_id' => $job->id,
            'status' => 'applied',
            'applied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim',
            'data' => [
                'application_id' => $application->id,
            ],
        ]);
    }

    public function myApplications(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 15);

        $applications = UserJobApplication::where('user_id', $user->id)
            ->with(['jobListing.company'])
            ->latest('applied_at')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'data' => $applications->map(function ($app) {
                    return [
                        'id' => $app->id,
                        'job_id' => $app->job_listing_id,
                        'job_title' => $app->jobListing?->title ?? 'Posisi Tidak Diketahui',
                        'company' => $app->jobListing?->company?->name ?? 'Perusahaan',
                        'location' => $app->jobListing?->location,
                        'work_type' => $app->jobListing?->work_type,
                        'status' => $app->status,
                        'applied_at' => $app->applied_at?->toISOString(),
                        'matching_percentage' => $app->matching_percentage,
                    ];
                }),
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
                'per_page' => $applications->perPage(),
                'total' => $applications->total(),
            ],
        ]);
    }

    public function savedJobs()
    {
        $user = Auth::user();

        // Get saved jobs from user's saved_jobs relationship
        $savedJobs = $user->savedJobs()->with('company')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $savedJobs->map(function ($job) use ($user) {
                return $this->formatJob($job, $user);
            }),
        ]);
    }

    public function saveJob($id)
    {
        $user = Auth::user();
        $job = JobListing::findOrFail($id);

        // Check if already saved
        if ($user->savedJobs()->where('job_listing_id', $job->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan sudah tersimpan',
            ], 422);
        }

        $user->savedJobs()->attach($job->id);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil disimpan',
        ]);
    }

    public function unsaveJob($id)
    {
        $user = Auth::user();
        
        $user->savedJobs()->detach($id);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan dihapus dari tersimpan',
        ]);
    }

    private function formatJob($job, $user)
    {
        return [
            'id' => $job->id,
            'title' => $job->title,
            'company' => $job->company?->name ?? 'Perusahaan',
            'company_logo' => $job->company?->logo ? asset('storage/' . $job->company->logo) : null,
            'location' => $job->location,
            'work_type' => $job->work_type,
            'salary_min' => $job->salary_min,
            'salary_max' => $job->salary_max,
            'required_skills' => $job->required_skills ?? [],
            'posted_date' => $job->created_at?->toISOString(),
            'is_active' => $job->is_active,
        ];
    }

    private function formatJobDetail($job, $user)
    {
        return [
            'id' => $job->id,
            'title' => $job->title,
            'company' => $job->company?->name ?? 'Perusahaan',
            'company_logo' => $job->company?->logo ? asset('storage/' . $job->company->logo) : null,
            'location' => $job->location,
            'work_type' => $job->work_type,
            'salary_min' => $job->salary_min,
            'salary_max' => $job->salary_max,
            'experience_required' => $job->experience_required,
            'description' => $job->description,
            'required_skills' => $job->required_skills ?? [],
            'posted_date' => $job->created_at?->toISOString(),
            'is_active' => $job->is_active,
            'company_description' => $job->company?->description,
            'company_website' => $job->company?->website,
        ];
    }
}
