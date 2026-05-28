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
        $filters = $request->only(['category', 'search']);
        $courses = $this->courseService->getCourses($filters);
        $myProgress = $this->courseService->getUserProgressIds(Auth::id());
        $activeProgress = $this->courseService->getAllUserProgress(Auth::id());
        
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
                'recommended' => $recommendedCourses,
                'my_progress' => $myProgress
            ]);
        }

        return view('courses.index', compact('courses', 'recommendedCourses', 'myProgress', 'activeProgress'));
    }

    public function show($id, Request $request)
    {
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
