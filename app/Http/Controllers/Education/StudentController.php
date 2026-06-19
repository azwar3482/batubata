<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Lazy create institution if missing, to prevent crashes
        $institution = $user->institution;
        if (!$institution) {
            $institution = Institution::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Institution',
                'type' => 'University',
                'address' => '-',
                'accreditation' => 'B'
            ]);
        }

        $query = User::where('role', 'job_seeker')
            ->where('institution_id', $institution->id);

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%")
                  ->orWhere('target_position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by graduation year
        if ($year = $request->input('graduation_year')) {
            $query->where('graduation_year', $year);
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('education.students', compact('students', 'institution'));
    }

    public function show(User $student)
    {
        $user = Auth::user();
        $institution = $user->institution;

        // Pastikan siswa adalah job_seeker
        if (!$student->isJobSeeker()) {
            abort(404, 'Data siswa tidak ditemukan.');
        }

        // Pastikan siswa berasal dari institusi yang sama
        if ($student->institution_id !== $institution?->id) {
            abort(403, 'Anda tidak memiliki akses ke data siswa ini.');
        }

        // Load relasi yang dibutuhkan untuk job_seeker
        $student->load([
            'documents',
            'roadmaps.position',
            'assessments.scores.competency',
            'assessments.position',
            'classEnrollments.classRoom.course',
            'jobApplications.jobListing.company',
        ]);

        // Hitung statistik
        $stats = [
            'total_assessments' => $student->assessments->count(),
            'avg_gap' => $student->assessments->avg('total_gap_percentage') ?? 0,
            'active_enrollments' => $student->classEnrollments->where('status', 'active')->count(),
            'completed_courses' => $student->classEnrollments->where('status', 'completed')->count(),
            'total_applications' => $student->jobApplications->count(),
            'profile_completion' => $student->profile_completion_percentage,
        ];

        return view('education.student-detail', compact('student', 'institution', 'stats'));
    }
}
