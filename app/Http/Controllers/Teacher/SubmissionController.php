<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\ClassEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $submissions = $query->latest()->paginate(20);

        $classes = \App\Models\TeacherClass::where('teacher_id', $teacherId)->get();

        return view('teacher.submissions.index', compact('submissions', 'classes'));
    }

    public function show(Submission $submission)
    {
        if ($submission->enrollment->classRoom->teacher_id !== Auth::id()) {
            abort(403);
        }

        $submission->load(['enrollment.user', 'material.module.course', 'enrollment.classRoom']);

        return view('teacher.submissions.show', compact('submission'));
    }

    public function grade(Request $request, Submission $submission)
    {
        if ($submission->enrollment->classRoom->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
            'status' => 'required|in:graded,revision',
        ]);

        $validated['graded_at'] = now();

        $submission->update($validated);

        return back()->with('success', 'Tugas berhasil dinilai.');
    }
}
