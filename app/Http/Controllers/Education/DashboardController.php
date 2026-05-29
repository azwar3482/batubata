<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    { 
        $user = auth()->user();
        $institution = $user->institution;
        
        $stats = [
            'total_students' => 0,
            'total_applications' => 0,
            'accepted_applications' => 0,
            'rejected_applications' => 0,
            'processing_applications' => 0
        ];

        if ($institution) {
            $studentIds = $institution->students()->pluck('id');
            
            $stats['total_students'] = $studentIds->count();
            
            $applications = \App\Models\UserJobApplication::whereIn('user_id', $studentIds)
                ->selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'offered' THEN 1 ELSE 0 END) as accepted,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status IN ('applied', 'reviewed', 'interviewed') THEN 1 ELSE 0 END) as processing
                ")
                ->first();
                
            $stats['total_applications'] = $applications->total ?? 0;
            $stats['accepted_applications'] = $applications->accepted ?? 0;
            $stats['rejected_applications'] = $applications->rejected ?? 0;
            $stats['processing_applications'] = $applications->processing ?? 0;
        }

        return view('education.dashboard', compact('stats')); 
    }
}
