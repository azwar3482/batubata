<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherCourse;
use App\Models\TeacherClass;
use App\Models\ClassEnrollment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $totalCourses = TeacherCourse::where('teacher_id', $teacherId)->count();
        $publishedCourses = TeacherCourse::where('teacher_id', $teacherId)->where('status', 'published')->count();
        $totalClasses = TeacherClass::where('teacher_id', $teacherId)->count();
        $activeClasses = TeacherClass::where('teacher_id', $teacherId)->where('status', 'active')->count();

        $totalStudents = ClassEnrollment::whereHas('classRoom', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->where('status', 'active')->count();

        $pendingSubmissions = Submission::whereHas('enrollment.classRoom', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->where('status', 'submitted')->count();

        $recentCourses = TeacherCourse::where('teacher_id', $teacherId)
            ->withCount('classes')
            ->latest()
            ->take(5)
            ->get();

        $recentClasses = TeacherClass::where('teacher_id', $teacherId)
            ->with('course')
            ->withCount('enrollments')
            ->latest()
            ->take(5)
            ->get();

        $recentSubmissions = Submission::whereHas('enrollment.classRoom', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })
            ->with(['enrollment.user', 'material.module.course'])
            ->where('status', 'submitted')
            ->latest()
            ->take(10)
            ->get();

        return view('teacher.dashboard', compact(
            'totalCourses', 'publishedCourses', 'totalClasses', 'activeClasses',
            'totalStudents', 'pendingSubmissions', 'recentCourses', 'recentClasses',
            'recentSubmissions'
        ));
    }
}
