<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\CourseVendor;
use App\Models\CoursePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $vendor = $user->ownedVendor;

        if (!$vendor) {
            // Auto create profile for testing/seeding purposes if missing
            $vendor = CourseVendor::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Course Academy',
                'description' => 'Course Provider on KOMPASKARIR Platform.',
                'status' => 'active'
            ]);
        }

        // 1. Total Teachers under vendor
        $totalTeachers = $vendor->teachers()->count();

        // 2. Total Courses created by vendor's teachers
        $teacherIds = $vendor->teachers()->pluck('id');
        
        $totalCourses = \App\Models\TeacherCourse::whereIn('teacher_id', $teacherIds)->count();

        // 3. Total Enrollments in vendor's teachers' classes
        $classIds = \App\Models\TeacherClass::whereIn('teacher_id', $teacherIds)->pluck('id');
        $totalEnrollments = \App\Models\ClassEnrollment::whereIn('class_id', $classIds)->count();

        // 4. Payments associated with these courses
        $paymentsQuery = CoursePayment::whereIn('teacher_course_id', function ($query) use ($teacherIds) {
            $query->select('id')->from('teacher_courses')->whereIn('teacher_id', $teacherIds);
        });

        $totalRevenue = (clone $paymentsQuery)->paid()->sum('amount');
        $pendingPaymentsCount = (clone $paymentsQuery)->pending()->count();

        // Latest transactions
        $latestPayments = $paymentsQuery->with(['user', 'teacherCourse'])->latest()->take(5)->get();

        return view('vendor.dashboard', compact(
            'vendor',
            'totalTeachers',
            'totalCourses',
            'totalEnrollments',
            'totalRevenue',
            'pendingPaymentsCount',
            'latestPayments'
        ));
    }
}
