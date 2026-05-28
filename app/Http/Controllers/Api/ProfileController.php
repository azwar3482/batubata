<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        $data = [
            'id' => (string)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->photo ? (filter_var($user->photo, FILTER_VALIDATE_URL) ? $user->photo : asset('storage/' . $user->photo)) : null,
            'education' => $user->education_level,
            'major' => $user->major,
            'graduation_year' => $user->graduation_year,
            'experience_years' => $user->experience_years ?? 0,
            'target_position' => $user->target_position,
            'role' => $user->role,
            'gender' => $user->gender,
            'bio' => $user->bio,
            'linkedin_url' => $user->linkedin_url,
            'github_url' => $user->github_url,
            'portfolio_url' => $user->portfolio_url,
            'member_since' => $user->created_at->toISOString(),
            'statistics' => [
                'total_assessments' => $user->assessments()->count(),
                'total_courses_completed' => $user->courseProgress()->where('status', 'completed')->count(),
                'average_skill_gap' => $user->assessments()->latest()->first()?->total_gap_percentage ?? 0,
                'total_jobs_applied' => $user->jobApplications()->count(),
                'skills_improved' => 5, // Mocked for now
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'nullable|string',
            'education_level' => 'nullable|string',
            'major' => 'nullable|string',
            'graduation_year' => 'nullable|integer',
            'experience_years' => 'nullable|integer',
            'target_position' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female',
            'bio' => 'nullable|string',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
        ]);

        $user->update($validated);

        return $this->show(); // Return the refreshed profile
    }

    public function skills()
    {
        $user = Auth::user();
        
        // Get skills from latest assessment
        $latestAssessment = $user->assessments()->with('scores.competency')->latest()->first();
        
        $skills = [];
        if ($latestAssessment) {
            $skills = $latestAssessment->scores->map(function($score) {
                return [
                    'name' => $score->competency->name,
                    'level' => $score->self_assessed_level,
                    'category' => $score->competency->category,
                ];
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $skills
        ]);
    }
}
