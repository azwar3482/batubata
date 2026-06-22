<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Models\Course;
use App\Models\AdminCourseChapter;
use App\Models\AdminCourseMaterial;
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
                $weakCompetencies = \App\Models\UserCompetencyScore::where('assessment_id', $latestAssessment->id)
                    ->where('gap_percentage', '>', 0)
                    ->with('competency')
                    ->get();

                $weakCompetencyIds = $weakCompetencies->pluck('competency_id')->toArray();
                
                if (!empty($weakCompetencyIds)) {
                    $recommendedCourses = $this->courseService->getRecommendedCourses($weakCompetencyIds);
                    
                    $recommendedCourses = $recommendedCourses->map(function ($course) use ($weakCompetencies) {
                        $relatedGap = $weakCompetencies->firstWhere('competency_id', $course->competency_id);
                        $matchScore = $relatedGap ? max(0, 100 - $relatedGap->gap_percentage) : 70;
                        
                        $course->match_score = $matchScore;
                        $course->priority = $matchScore >= 70 ? 'High' : ($matchScore >= 50 ? 'Medium' : 'Low');
                        $course->reason = $relatedGap 
                            ? 'Meningkatkan kompetensi ' . ($relatedGap->competency?->name ?? '') . ' (gap: ' . number_format($relatedGap->gap_percentage, 1) . '%)'
                            : 'Kursus rekomendasi untuk Anda';
                        $course->instructor = $course->creator?->name ?? 'Kompaskarir';
                        
                        return $course;
                    });
                }
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

        // Admin course with chapters
        $course = $this->courseService->getCourseDetails($id);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);
        $completedMaterialIds = $progress ? $this->courseService->getCompletedMaterialIds(Auth::id(), $course->id) : [];

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $course,
                'progress' => $progress
            ]);
        }

        return view('courses.show', compact('course', 'progress', 'completedMaterialIds'));
    }

    public function learn($id, Request $request)
    {
        $course = $this->courseService->getCourseDetails($id);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);

        if (!$progress) {
            return redirect()->route('seeker.courses.show', $id)->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu.');
        }

        $completedMaterialIds = $this->courseService->getCompletedMaterialIds(Auth::id(), $course->id);

        // Get current material (first incomplete or first)
        $currentMaterial = null;
        $allMaterials = $course->chapters->flatMap->materials;
        foreach ($allMaterials as $material) {
            if (!in_array($material->id, $completedMaterialIds)) {
                $currentMaterial = $material;
                break;
            }
        }
        if (!$currentMaterial && $allMaterials->count() > 0) {
            $currentMaterial = $allMaterials->first();
        }

        // Override with specific material if requested
        if ($materialId = $request->query('material')) {
            $currentMaterial = AdminCourseMaterial::with(['chapter', 'quizQuestions'])->find($materialId);
        }

        return view('courses.learn', compact('course', 'progress', 'completedMaterialIds', 'currentMaterial'));
    }

    public function learnMaterial($courseId, $materialId)
    {
        $course = $this->courseService->getCourseDetails($courseId);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);

        if (!$progress) {
            return redirect()->route('seeker.courses.show', $courseId)->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu.');
        }

        $currentMaterial = AdminCourseMaterial::with(['chapter', 'quizQuestions'])->findOrFail($materialId);
        $completedMaterialIds = $this->courseService->getCompletedMaterialIds(Auth::id(), $course->id);

        return view('courses.learn', compact('course', 'progress', 'completedMaterialIds', 'currentMaterial'));
    }

    public function downloadMaterial($courseId, $materialId)
    {
        $course = $this->courseService->getCourseDetails($courseId);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);

        if (!$progress) {
            abort(403, 'Anda harus mendaftar kursus ini terlebih dahulu.');
        }

        $material = AdminCourseMaterial::findOrFail($materialId);

        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file_path)) {
            abort(404);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    public function viewMaterial($courseId, $materialId)
    {
        $course = $this->courseService->getCourseDetails($courseId);
        $progress = $this->courseService->getUserCourseProgress(Auth::id(), $course->id);

        if (!$progress) {
            abort(403, 'Anda harus mendaftar kursus ini terlebih dahulu.');
        }

        $material = AdminCourseMaterial::findOrFail($materialId);

        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file_path)) {
            abort(404);
        }

        $filePath = \Illuminate\Support\Facades\Storage::disk('public')->path($material->file_path);
        $mimeType = $material->mime_type ?: mime_content_type($filePath);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $material->file_name . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        return new \Symfony\Component\HttpFoundation\BinaryFileResponse($filePath, 200, $headers, true);
    }

    public function completeMaterial(Request $request, $courseId, $materialId)
    {
        $result = $this->courseService->toggleMaterialCompletion(Auth::id(), $materialId, $courseId);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        }

        if ($result['course_completed']) {
            return back()->with('success', 'Selamat! Anda telah menyelesaikan semua materi kursus ini!');
        }

        return back()->with('success', $result['material_completed'] ? 'Materi ditandai selesai.' : 'Materi ditandai belum selesai.');
    }

    public function submitQuiz(Request $request, $courseId, $materialId)
    {
        $material = AdminCourseMaterial::with('quizQuestions')->findOrFail($materialId);

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $questions = $material->quizQuestions;
        $correctCount = 0;
        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($questions as $question) {
            $totalPoints += $question->points;
            if (isset($validated['answers'][$question->id]) && $validated['answers'][$question->id] === $question->correct_answer) {
                $correctCount++;
                $earnedPoints += $question->points;
            }
        }

        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
        $passed = $score >= 70;

        $attempt = \App\Models\AdminQuizAttempt::create([
            'user_id' => Auth::id(),
            'material_id' => $materialId,
            'course_id' => $courseId,
            'answers' => $validated['answers'],
            'score' => $score,
            'total_points' => $totalPoints,
            'correct_count' => $correctCount,
            'total_questions' => $questions->count(),
            'passed' => $passed,
            'submitted_at' => now(),
        ]);

        if ($passed) {
            $this->courseService->toggleMaterialCompletion(Auth::id(), $materialId, $courseId);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'score' => $score,
                    'correct_count' => $correctCount,
                    'total_questions' => $questions->count(),
                    'passed' => $passed,
                ],
            ]);
        }

        $message = $passed
            ? "Selamat! Anda lulus kuis dengan skor {$score}%."
            : "Skor Anda {$score}%. Minimal 70% untuk lulus. Silakan coba lagi.";

        return back()->with($passed ? 'success' : 'error', $message);
    }

    public function submitAssignment(Request $request, $courseId, $materialId)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,webp,zip,rar',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['material_id'] = $materialId;
        $validated['course_id'] = $courseId;
        $validated['submitted_at'] = now();
        $validated['status'] = 'submitted';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('assignments', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
        }

        \App\Models\AdminAssignmentSubmission::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dikumpulkan.',
            ]);
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan. Menunggu review.');
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

        if ($enrollment->user_id !== $user->id &&
            !$user->isAdmin() &&
            !($user->isTeacher() && $enrollment->classRoom->teacher_id === $user->id) &&
            !$user->isIndustry() &&
            !$user->isStaff()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat sertifikat ini.');
        }

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

        if ($progress->user_id !== $user->id &&
            !$user->isAdmin() &&
            !$user->isIndustry() &&
            !$user->isStaff()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat sertifikat ini.');
        }

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
        $pdf->setPaper([0, 0, 842, 595]);
        $pdf->setOption('isRemoteEnabled', true);
        
        $filename = 'Sertifikat_Kursus_' . str_replace(' ', '_', $progress->course->title) . '.pdf';
        return $pdf->download($filename);
    }
}
