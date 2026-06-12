<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\TeacherClass;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::id();

        $query = Submission::whereHas('enrollment.classRoom', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->with(['enrollment.user', 'material.module.course', 'enrollment.classRoom']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->class_id) {
            $query->whereHas('enrollment', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        $submissions = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $submissions->items(),
            'meta' => [
                'current_page' => $submissions->currentPage(),
                'last_page' => $submissions->lastPage(),
                'total' => $submissions->total(),
            ]
        ]);
    }

    public function show($id)
    {
        $submission = Submission::with(['enrollment.user', 'material.module.course', 'enrollment.classRoom'])->findOrFail($id);

        if ($submission->enrollment->classRoom->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $submission
        ]);
    }

    public function grade(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        if ($submission->enrollment->classRoom->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
            'status' => 'required|in:graded,revision',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['graded_at'] = now();

        $submission->update($validated);

        // Update enrollment progress/grade if completed
        $enrollment = $submission->enrollment;
        if ($enrollment) {
            // Count total assignment materials for this course
            $course = $enrollment->classRoom->course;
            $totalAssignments = CourseMaterial::whereIn('module_id', $course->modules()->pluck('id'))
                ->where('type', 'assignment')
                ->count();
            
            if ($totalAssignments > 0) {
                $gradedSubmissions = Submission::where('enrollment_id', $enrollment->id)
                    ->where('status', 'graded')
                    ->count();
                
                $progress = round(($gradedSubmissions / $totalAssignments) * 100);
                
                $avgScore = Submission::where('enrollment_id', $enrollment->id)
                    ->where('status', 'graded')
                    ->avg('score');
                
                $enrollment->update([
                    'progress_percentage' => $progress,
                    'final_score' => $avgScore
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dinilai.',
            'data' => $submission
        ]);
    }
}
