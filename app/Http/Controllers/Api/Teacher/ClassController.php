<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherClass;
use App\Models\TeacherCourse;
use App\Models\ClassEnrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index()
    {
        $classes = TeacherClass::where('teacher_id', Auth::id())
            ->with('course')
            ->withCount('enrollments')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $classes->items(),
            'meta' => [
                'current_page' => $classes->currentPage(),
                'last_page' => $classes->lastPage(),
                'total' => $classes->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:teacher_courses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:1|max:500',
            'meeting_link' => 'nullable|url|max:500',
            'schedule_info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $course = TeacherCourse::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validated['teacher_id'] = Auth::id();
        $validated['code'] = strtoupper(Str::random(8));
        $validated['status'] = 'active';

        $class = TeacherClass::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dibuat.',
            'data' => $class
        ], 201);
    }

    public function show($id)
    {
        $class = TeacherClass::with(['course.modules.materials', 'enrollments.user', 'enrollments.submissions'])->findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $totalModules = $class->course->modules()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'class' => $class,
                'total_modules' => $totalModules
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $class = TeacherClass::findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:1|max:500',
            'status' => 'required|in:active,completed,archived',
            'meeting_link' => 'nullable|url|max:500',
            'schedule_info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $class->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diperbarui.',
            'data' => $class
        ]);
    }

    public function destroy($id)
    {
        $class = TeacherClass::findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $class->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus.'
        ]);
    }

    // Enrollment Management
    public function enrollStudent(Request $request, $classId)
    {
        $class = TeacherClass::findOrFail($classId);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->isJobSeeker()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya job seeker yang dapat didaftarkan ke kelas.'
            ], 400);
        }

        if ($class->is_full) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas sudah penuh.'
            ], 400);
        }

        $enrollment = ClassEnrollment::firstOrCreate(
            ['class_id' => $class->id, 'user_id' => $user->id],
            ['status' => 'active', 'enrolled_at' => now()]
        );

        if (!$enrollment->wasRecentlyCreated) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah terdaftar di kelas ini.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => "Siswa {$user->name} berhasil didaftarkan.",
            'data' => $enrollment->load('user')
        ]);
    }

    public function removeStudent($enrollmentId)
    {
        $enrollment = ClassEnrollment::with('classRoom')->findOrFail($enrollmentId);
        $class = $enrollment->classRoom;

        if ($class->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $enrollment->update(['status' => 'dropped']);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil dikeluarkan dari kelas.'
        ]);
    }

    public function updateStudentStatus(Request $request, $enrollmentId)
    {
        $enrollment = ClassEnrollment::with('classRoom')->findOrFail($enrollmentId);
        $class = $enrollment->classRoom;

        if ($class->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,completed,dropped',
            'final_score' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
            $data['progress_percentage'] = 100;
        }

        $enrollment->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status siswa berhasil diperbarui.',
            'data' => $enrollment
        ]);
    }
}
