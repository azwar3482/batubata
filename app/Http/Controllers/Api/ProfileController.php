<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        $photoDoc = $user->documents()->where('document_type', 'photo')->first();
        
        $data = [
            'id' => (string)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $photoDoc ? asset('storage/' . $photoDoc->file_path) : null,
            'education_level' => $user->education_level,
            'education' => $user->education_level, // backward compatibility
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
            'completion_percentage' => $user->profile_completion_percentage ?? 0,
            'statistics' => [
                'total_assessments' => $user->assessments()->count(),
                'total_courses_completed' => $user->courseProgress()->where('status', 'completed')->count(),
                'average_skill_gap' => $user->assessments()->latest('assessment_date')->first()?->total_gap_percentage ?? 0,
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

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo document if exists
        $oldPhoto = $user->documents()->where('document_type', 'photo')->first();
        if ($oldPhoto) {
            Storage::disk('public')->delete($oldPhoto->file_path);
            $oldPhoto->delete();
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars/' . $user->id, 'public');

        // Create or update document record
        $user->documents()->create([
            'document_type' => 'photo',
            'file_path' => $path,
            'original_name' => $request->file('avatar')->getClientOriginalName(),
            'mime_type' => $request->file('avatar')->getMimeType(),
            'file_size' => $request->file('avatar')->getSize(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar berhasil diupload',
            'data' => [
                'avatar' => asset('storage/' . $path),
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password saat ini tidak sesuai',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah',
        ]);
    }

    public function skills()
    {
        $user = Auth::user();
        
        // Get skills from latest assessment
        $latestAssessment = $user->assessments()->with('scores.competency')->latest('assessment_date')->first();
        
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
