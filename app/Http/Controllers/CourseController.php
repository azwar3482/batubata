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
        $classEnrollments = \App\Models\ClassEnrollment::with(['classRoom.course', 'classRoom.teacher'])
            ->where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $progress,
                'class_enrollments' => $classEnrollments
            ]);
        }

        return view('courses.my_progress', compact('progress', 'classEnrollments'));
    }

    public function viewCertificate($enrollmentId)
    {
        $enrollment = \App\Models\ClassEnrollment::with(['classRoom.course', 'classRoom.teacher', 'user'])
            ->findOrFail($enrollmentId);

        $user = Auth::user();

        // Keamanan/Otorisasi:
        // 1. Siswa yang memiliki sertifikat
        // 2. Guru dari kelas tersebut
        // 3. Admin
        // 4. Perusahaan/Recruiter (Role: industry atau staffing roles)
        if ($enrollment->user_id !== $user->id &&
            !$user->isAdmin() &&
            !($user->isTeacher() && $enrollment->classRoom->teacher_id === $user->id) &&
            !$user->isIndustry() &&
            !$user->isStaff()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat sertifikat ini.');
        }

        // Kriteria: Status harus completed dan nilai >= 70
        if ($enrollment->status !== 'completed' || is_null($enrollment->final_score) || floatval($enrollment->final_score) < 70) {
            if ($user->isJobSeeker()) {
                return redirect()->route('seeker.courses.my-progress')
                    ->with('error', 'Sertifikat belum tersedia atau nilai akhir tidak memenuhi kriteria kelulusan (>= 70%).');
            }
            abort(404, 'Sertifikat tidak ditemukan atau belum memenuhi kriteria kelulusan.');
        }

        return view('courses.certificate', compact('enrollment'));
    }

    public function viewPlatformCertificate($progressId)
    {
        $progress = \App\Models\UserCourseProgress::with(['course.competency', 'user'])
            ->findOrFail($progressId);

        $user = Auth::user();

        // Keamanan/Otorisasi:
        // 1. Siswa yang memiliki sertifikat
        // 2. Admin
        // 3. Perusahaan/Recruiter (Role: industry atau staffing roles)
        if ($progress->user_id !== $user->id &&
            !$user->isAdmin() &&
            !$user->isIndustry() &&
            !$user->isStaff()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat sertifikat ini.');
        }

        // Kriteria: Status harus completed
        if ($progress->status !== 'completed') {
            if ($user->isJobSeeker()) {
                return redirect()->route('seeker.courses.my-progress')
                    ->with('error', 'Sertifikat belum tersedia.');
            }
            abort(404, 'Sertifikat tidak ditemukan.');
        }

        return view('courses.platform_certificate', compact('progress'));
    }

    public function downloadCertificatePdf($enrollmentId)
    {
        $enrollment = \App\Models\ClassEnrollment::with(['classRoom.course', 'classRoom.teacher', 'user'])
            ->findOrFail($enrollmentId);

        $user = Auth::user();

        // Keamanan/Otorisasi
        if ($enrollment->user_id !== $user->id &&
            !$user->isAdmin() &&
            !($user->isTeacher() && $enrollment->classRoom->teacher_id === $user->id) &&
            !$user->isIndustry() &&
            !$user->isStaff()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat sertifikat ini.');
        }

        if ($enrollment->status !== 'completed' || is_null($enrollment->final_score) || floatval($enrollment->final_score) < 70) {
            abort(404, 'Sertifikat tidak ditemukan atau belum memenuhi kriteria kelulusan.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.class_certificate', compact('enrollment'));
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'Sertifikat_Kelas_' . str_replace(' ', '_', $enrollment->classRoom->course->title) . '.pdf';
        return $pdf->download($filename);
    }

    public function downloadPlatformCertificatePdf($progressId)
    {
        $progress = \App\Models\UserCourseProgress::with(['course.competency', 'user'])
            ->findOrFail($progressId);

        $user = Auth::user();

        // Keamanan/Otorisasi
        if ($progress->user_id !== $user->id &&
            !$user->isAdmin() &&
            !$user->isIndustry() &&
            !$user->isStaff()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat sertifikat ini.');
        }

        if ($progress->status !== 'completed') {
            abort(404, 'Sertifikat tidak ditemukan.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.platform_certificate', compact('progress'));
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'Sertifikat_Kursus_' . str_replace(' ', '_', $progress->course->title) . '.pdf';
        return $pdf->download($filename);
    }
}
