<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Lazy create institution if missing, to prevent crashes
        $institution = $user->institution;
        if (!$institution) {
            $institution = Institution::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Institution',
                'type' => 'University',
                'accreditation' => 'B'
            ]);
        }

        // Fetch job seekers that belong to this institution
        $students = User::where('role', 'job_seeker')
            ->where('institution_id', $institution->id)
            ->latest()
            ->paginate(10);

        return view('education.students', compact('students', 'institution'));
    }
}
