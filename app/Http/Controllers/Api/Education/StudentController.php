<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution;
        
        if (!$institution) {
            $institution = Institution::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Institution',
                'type' => 'University',
                'accreditation' => 'B'
            ]);
        }

        $students = User::where('role', 'job_seeker')
            ->where('institution_id', $institution->id)
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $students->items(),
            'meta' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'total' => $students->total(),
            ]
        ]);
    }
}
