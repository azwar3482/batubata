<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        
        $photoDoc = $user->documents()->where('document_type', 'photo')->first();
        
        // Build avatar URL using request base URL for ngrok compatibility
        $avatarUrl = null;
        if ($photoDoc) {
            $avatarUrl = $request->root() . '/storage/' . $photoDoc->file_path;
        }

        // Calculate completion percentage directly
        $completionPercentage = $this->calculateCompletionPercentage($user);
        
        $data = [
            'id' => (string)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $avatarUrl,
            'education_level' => $user->education_level,
            'education' => $user->education_level, // backward compatibility
            'major' => $user->major,
            'graduation_year' => $user->graduation_year,
            'experience_years' => $user->experience_years ?? 0,
            'target_position' => $user->target_position,
            'role' => $user->role,
            'gender' => $user->gender,
            'blood_type' => $user->blood_type,
            'birth_date' => $user->birth_date?->toDateString(),
            'address' => $user->address,
            'latitude' => $user->latitude,
            'longitude' => $user->longitude,
            'bio' => $user->bio,
            'linkedin_url' => $user->linkedin_url,
            'github_url' => $user->github_url,
            'portfolio_url' => $user->portfolio_url,
            'skills' => $user->skills ?? [],
            'languages' => $user->languages ?? [],
            'expected_jobs' => $user->expected_jobs ?? [],
            'job_preferences' => $user->job_preferences,
            'career_histories' => $user->careerHistories()->orderBy('start_date', 'desc')->get()->map(fn($ch) => [
                'id' => $ch->id,
                'company_name' => $ch->company_name,
                'position' => $ch->position,
                'start_date' => $ch->start_date?->toDateString(),
                'end_date' => $ch->end_date?->toDateString(),
                'is_current' => (bool) $ch->is_current,
                'description' => $ch->description,
            ]),
            'member_since' => $user->created_at->toISOString(),
            'completion_percentage' => $completionPercentage,
            'statistics' => [
                'total_assessments' => $user->assessments()->count(),
                'total_courses_completed' => $user->courseProgress()->where('status', 'completed')->count(),
                'average_skill_gap' => $user->assessments()->latest('assessment_date')->first()?->total_gap_percentage ?? 0,
                'total_jobs_applied' => $user->jobApplications()->count(),
                'skills_improved' => $this->getSkillsImprovedCount($user),
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
            'blood_type' => 'nullable|string|in:A,B,AB,O',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:1000',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'bio' => 'nullable|string|max:1000',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:100',
            'expected_jobs' => 'nullable|array',
            'expected_jobs.*.position' => 'nullable|string|max:255',
            'expected_jobs.*.salary_min' => 'nullable|numeric|min:0',
            'job_preferences' => 'nullable|string|max:1000',
            'career_histories' => 'nullable|array',
            'career_histories.*.company_name' => 'nullable|string|max:255',
            'career_histories.*.position' => 'nullable|string|max:255',
            'career_histories.*.start_date' => 'nullable|date',
            'career_histories.*.end_date' => 'nullable|date',
            'career_histories.*.is_current' => 'nullable|boolean',
            'career_histories.*.description' => 'nullable|string|max:1000',
        ]);

        // Handle career histories separately
        $careerHistories = $validated['career_histories'] ?? null;
        unset($validated['career_histories']);

        // Cast expected numeric fields
        if (isset($validated['latitude'])) {
            $validated['latitude'] = (float) $validated['latitude'];
        }
        if (isset($validated['longitude'])) {
            $validated['longitude'] = (float) $validated['longitude'];
        }

        $user->update($validated);

        // Sync career histories if provided
        if ($careerHistories !== null) {
            // Delete existing and recreate
            $user->careerHistories()->delete();
            foreach ($careerHistories as $ch) {
                if (!empty($ch['company_name']) || !empty($ch['position'])) {
                    $user->careerHistories()->create([
                        'company_name' => $ch['company_name'] ?? null,
                        'position' => $ch['position'] ?? null,
                        'start_date' => $ch['start_date'] ?? null,
                        'end_date' => !empty($ch['is_current']) ? null : ($ch['end_date'] ?? null),
                        'is_current' => !empty($ch['is_current']),
                        'description' => $ch['description'] ?? null,
                    ]);
                }
            }
        }

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

        $avatarUrl = $request->root() . '/storage/' . $path;

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar berhasil diupload',
            'data' => [
                'avatar' => $avatarUrl,
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

    public function documents(Request $request)
    {
        $user = Auth::user();
        $documents = $user->documents()->where('document_type', '!=', 'photo')->get();

        $result = [];
        foreach (UserDocument::TYPES as $type => $label) {
            if ($type === 'photo') continue;
            $doc = $documents->firstWhere('document_type', $type);
            $result[$type] = [
                'type' => $type,
                'label' => $label,
                'uploaded' => $doc !== null,
                'id' => $doc?->id,
                'original_name' => $doc?->original_name,
                'file_path' => $doc ? $request->root() . '/storage/' . $doc->file_path : null,
                'mime_type' => $doc?->mime_type,
                'file_size' => $doc?->file_size,
                'file_size_human' => $doc?->file_size_human,
                'status' => $doc?->status ?? 'not_uploaded',
                'status_label' => $doc?->status_label ?? 'Belum diunggah',
                'uploaded_at' => $doc?->created_at?->toISOString(),
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }

    public function uploadDocument(Request $request, string $type)
    {
        if (!array_key_exists($type, UserDocument::TYPES) || $type === 'photo') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipe dokumen tidak valid.',
            ], 422);
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();

        // Delete old document of same type
        $oldDoc = $user->documents()->where('document_type', $type)->first();
        if ($oldDoc) {
            Storage::disk('public')->delete($oldDoc->file_path);
            $oldDoc->delete();
        }

        $path = $request->file('file')->store('documents/' . $user->id, 'public');

        $doc = $user->documents()->create([
            'document_type' => $type,
            'file_path' => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
            'mime_type' => $request->file('file')->getMimeType(),
            'file_size' => $request->file('file')->getSize(),
            'status' => UserDocument::STATUS_PENDING,
        ]);

        $fileUrl = $request->root() . '/storage/' . $path;

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(UserDocument::TYPES[$type]) . ' berhasil diunggah.',
            'data' => [
                'id' => $doc->id,
                'type' => $type,
                'original_name' => $doc->original_name,
                'file_path' => $fileUrl,
                'status' => $doc->status,
            ],
        ]);
    }

    public function deleteDocument(Request $request, string $type)
    {
        if (!array_key_exists($type, UserDocument::TYPES) || $type === 'photo') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipe dokumen tidak valid.',
            ], 422);
        }

        $user = Auth::user();
        $doc = $user->documents()->where('document_type', $type)->first();

        if (!$doc) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen tidak ditemukan.',
            ], 404);
        }

        Storage::disk('public')->delete($doc->file_path);
        $doc->delete();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(UserDocument::TYPES[$type]) . ' berhasil dihapus.',
        ]);
    }

    private function calculateCompletionPercentage($user)
    {
        if ($user->role !== 'job_seeker') {
            return 100;
        }

        $percentage = 0;

        // name (10%)
        if (!empty($user->name)) $percentage += 10;

        // photo (10%)
        if ($user->documents()->where('document_type', 'photo')->exists()) $percentage += 10;

        // phone (10%)
        if (!empty($user->phone)) $percentage += 10;

        // gender (10%)
        if (!empty($user->gender)) $percentage += 10;

        // address (10%)
        if (!empty($user->address) || (!empty($user->latitude) && !empty($user->longitude))) $percentage += 10;

        // education_level (10%)
        if (!empty($user->education_level)) $percentage += 10;

        // major (15%)
        if (!empty($user->major) || $user->education_level === 'Tidak Sekolah') $percentage += 15;

        // cv (25%)
        if ($user->documents()->where('document_type', 'cv')->exists()) $percentage += 25;

        return $percentage;
    }

    private function getSkillsImprovedCount($user)
    {
        // Count skills that have improved between assessments
        $assessments = $user->assessments()
            ->where('status', 'completed')
            ->orderBy('assessment_date', 'asc')
            ->get();

        if ($assessments->count() < 2) {
            return 0;
        }

        $improvedCount = 0;
        $previousScores = [];
        
        foreach ($assessments as $assessment) {
            $currentScores = $assessment->scores()
                ->with('competency')
                ->get()
                ->keyBy('competency_id');

            if (!empty($previousScores)) {
                foreach ($currentScores as $compId => $currentScore) {
                    if (isset($previousScores[$compId])) {
                        $previousLevel = $previousScores[$compId]->self_assessed_level;
                        $currentLevel = $currentScore->self_assessed_level;
                        
                        if ($currentLevel > $previousLevel) {
                            $improvedCount++;
                        }
                    }
                }
            }

            $previousScores = $currentScores->toArray();
        }

        return $improvedCount;
    }
}
