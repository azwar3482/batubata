<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherClass;
use App\Models\TeacherCourse;
use App\Models\ClassEnrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = TeacherClass::where('teacher_id', Auth::id())
            ->with('course')
            ->withCount('enrollments');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhereHas('course', function($qCourse) use ($search) {
                      $qCourse->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $classes = $query->latest()->paginate(10);

        return view('teacher.classes.index', compact('classes'));
    }

    public function create()
    {
        $courses = TeacherCourse::where('teacher_id', Auth::id())
            ->where('status', 'published')
            ->get();

        return view('teacher.classes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:teacher_courses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:1|max:500',
            'meeting_link' => 'nullable|url|max:500',
            'schedule_info' => 'nullable|string',
        ]);

        $course = TeacherCourse::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated['teacher_id'] = Auth::id();
        $validated['code'] = strtoupper(Str::random(8));
        $validated['status'] = 'active';

        TeacherClass::create($validated);

        return redirect()->route('teacher.classes.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function show(TeacherClass $class)
    {
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $class->load(['course.modules.materials']);

        $totalModules = $class->course->modules()->count();

        // Paginate enrollments
        $enrollments = $class->enrollments()
            ->with(['user', 'submissions'])
            ->latest()
            ->paginate(10);

        return view('teacher.classes.show', compact('class', 'totalModules', 'enrollments'));
    }

    public function edit(TeacherClass $class)
    {
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $courses = TeacherCourse::where('teacher_id', Auth::id())
            ->where('status', 'published')
            ->get();

        return view('teacher.classes.edit', compact('class', 'courses'));
    }

    public function update(Request $request, TeacherClass $class)
    {
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:1|max:500',
            'status' => 'required|in:active,completed,archived',
            'meeting_link' => 'nullable|url|max:500',
            'schedule_info' => 'nullable|string',
        ]);

        $class->update($validated);

        return redirect()->route('teacher.classes.show', $class)->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(TeacherClass $class)
    {
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $class->delete();

        return redirect()->route('teacher.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }

    // Enrollment Management
    public function enrollStudent(Request $request, TeacherClass $class)
    {
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user->isJobSeeker()) {
            return back()->with('error', 'Hanya job seeker yang dapat didaftarkan ke kelas.');
        }

        if ($class->is_full) {
            return back()->with('error', 'Kelas sudah penuh.');
        }

        $enrollment = ClassEnrollment::firstOrCreate(
            ['class_id' => $class->id, 'user_id' => $user->id],
            ['status' => 'active', 'enrolled_at' => now()]
        );

        if (!$enrollment->wasRecentlyCreated) {
            return back()->with('error', 'Siswa sudah terdaftar di kelas ini.');
        }

        $enrollment->load('classRoom.course', 'classRoom.teacher', 'user');
        $user->notify(new \App\Notifications\ClassEnrollmentNotification($enrollment));

        if ($class->teacher) {
            $class->teacher->notify(new \App\Notifications\NewStudentEnrolledNotification($enrollment));
        }

        return back()->with('success', "Siswa {$user->name} berhasil didaftarkan.");
    }

    public function removeStudent(ClassEnrollment $enrollment)
    {
        $class = $enrollment->classRoom;
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $enrollment->update(['status' => 'dropped']);

        return back()->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    public function updateStudentStatus(Request $request, ClassEnrollment $enrollment)
    {
        $class = $enrollment->classRoom;
        if ($class->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:active,completed,dropped',
            'final_score' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $data = $request->only(['status', 'final_score', 'notes']);

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
            $data['progress_percentage'] = 100;
        }

        $enrollment->update($data);

        return back()->with('success', 'Status siswa berhasil diperbarui.');
    }
}
