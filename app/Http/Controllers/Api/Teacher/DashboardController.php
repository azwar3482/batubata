<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherCourse;
use App\Models\TeacherClass;
use App\Models\ClassEnrollment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $totalCourses = TeacherCourse::where('teacher_id', $teacherId)->count();
        $activeClasses = TeacherClass::where('teacher_id', $teacherId)->where('status', 'active')->count();

        $classIds = TeacherClass::where('teacher_id', $teacherId)->pluck('id');
        $totalStudents = ClassEnrollment::whereIn('class_id', $classIds)->where('status', 'active')->count();

        $enrollmentIds = ClassEnrollment::whereIn('class_id', $classIds)->pluck('id');
        $pendingSubmissions = Submission::whereIn('enrollment_id', $enrollmentIds)
            ->where('status', 'submitted')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_courses' => $totalCourses,
                'active_classes' => $activeClasses,
                'total_students' => $totalStudents,
                'pending_submissions' => $pendingSubmissions,
            ]
        ]);
    }
}
