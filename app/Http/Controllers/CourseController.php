<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'search', 'level']);
        $courses = $this->courseService->getCourses($filters);
        $myProgress = $this->courseService->getUserProgressIds(Auth::id());
        $activeProgress = $this->courseService->getAllUserProgress(Auth::id());

        // Get published teacher courses (hybrid data)
        $teacherCourses = \App\Models\TeacherCourse::with('teacher', 'competency')
            ->where('status', 'published')
            ->when(!empty($filters['category']), function ($q) use ($filters) {
                $q->where('category', $filters['category']);
            })
            ->when(!empty($filters['search']), function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%');
            })
            ->when(!empty($filters['level']), function ($q) use ($filters) {
                $q->where('level', $filters['level']);
            })
            ->latest()
            ->get();

        $recommendedCourses = collect();
        if (Auth::user()->isJobSeeker()) {
            $latestAssessment = \App\Models\UserAssessment::where('user_id', Auth::id())
                ->where('status', 'completed')
                ->latest()
                ->first();

            if ($latestAssessment) {
                $weakCompetencyIds = \App\Models\UserCompetencyScore::where('assessment_id', $latestAssessment->id)
                    ->where('gap_percentage', '>', 0)
                    ->pluck('competency_id')
                    ->toArray();

                $recommendedCourses = $this->courseService->getRecommendedCourses($weakCompetencyIds);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $courses,
                'teacher_courses' => $teacherCourses,
                'recommended' => $recommendedCourses,
                'my_progress' => $myProgress
            ]);
        }

        return view('courses.index', compact('courses', 'teacherCourses', 'recommendedCourses', 'myProgress', 'activeProgress'));
    }

    public function show($id, Request $request)
    {
        $type = $request->query('type', 'external');

        if ($type === 'teacher') {
            $course = \App\Models\TeacherCourse::with(['teacher.teacherProfile', 'competency', 'modules.materials', 'classes'])
                ->findOrFail($id);
            $progress = null;

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $course, 'progress' => $progress]);
            }

            return view('courses.show_teacher', compact('course', 'progress'));
        }

        $course = $this->courseService->getCourseDetails($id);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $course,
                'progress' => $progress
            ]);
        }

        return view('courses.show', compact('course', 'progress'));
    }

    public function learn($id)
    {
        $course = $this->courseService->getCourseDetails($id);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);

        if (!$progress) {
            return redirect()->route('seeker.courses.show', $id)->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu.');
        }

        return view('courses.learn', compact('course', 'progress'));
    }

    public function enroll($id, Request $request)
    {
        $progress = $this->courseService->enrollUser(Auth::id(), $id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftar kursus!',
                'data' => $progress
            ]);
        }

        return back()->with('success', 'Berhasil mendaftar kursus!');
    }

    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        $progress = $this->courseService->updateProgress(Auth::id(), $id, $request->progress_percentage);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Progress berhasil diperbarui!',
                'data' => $progress
            ]);
        }

        return back()->with('success', 'Progress berhasil diperbarui!');
    }

    public function complete($id, Request $request)
    {
        $progress = $this->courseService->completeCourse(Auth::id(), $id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Selamat! Kursus telah selesai!',
                'data' => $progress
            ]);
        }

        return back()->with('success', 'Selamat! Kursus telah selesai!');
    }

    public function myProgress(Request $request)
    {
        $progress = $this->courseService->getAllUserProgress(Auth::id());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $progress
            ]);
        }

        return view('courses.my_progress', compact('progress'));
    }
}
