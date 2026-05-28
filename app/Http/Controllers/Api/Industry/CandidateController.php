<?php

namespace App\Http\Controllers\Api\Industry;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Search candidates by skill and position.
     */
    public function index(Request $request)
    {
        $skillQuery = $request->query('skill');
        $positionId = $request->query('position_id');

        $query = User::where('role', 'job_seeker');

        // Filter by position (from assessments)
        if ($positionId) {
            $query->whereHas('assessments', function($q) use ($positionId) {
                $q->where('position_id', $positionId);
            });
        }

        // Filter by skill (from assessment scores)
        if ($skillQuery) {
            $query->whereHas('assessments', function($q) use ($skillQuery) {
                $q->whereHas('scores', function($sq) use ($skillQuery) {
                    $sq->whereHas('competency', function($cq) use ($skillQuery) {
                        $cq->where('name', 'LIKE', "%{$skillQuery}%");
                    });
                });
            });
        }

        $candidates = $query->with(['assessments' => function($q) {
            $q->latest()->with('scores.competency', 'position');
        }])->paginate(10);

        // Map data to a cleaner format for the API
        $formattedCandidates = collect($candidates->items())->map(function ($candidate) {
            $latestAssessment = $candidate->assessments->first();
            
            return [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'email' => $candidate->email,
                'education_level' => $candidate->education_level,
                'experience_years' => $candidate->experience_years,
                'target_position' => $latestAssessment->position->name ?? $candidate->target_position ?? 'Not Set',
                'skills' => $latestAssessment ? $latestAssessment->scores->map(function($score) {
                    return [
                        'name' => $score->competency->name,
                        'level' => $score->self_assessed_level,
                    ];
                }) : [],
                'match_percentage' => $latestAssessment->total_gap_percentage ?? 0, // In production, replace with actual match against search criteria
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedCandidates,
            'meta' => [
                'current_page' => $candidates->currentPage(),
                'last_page' => $candidates->lastPage(),
                'total' => $candidates->total(),
            ]
        ]);
    }

    /**
     * Get candidate details.
     */
    public function show($id)
    {
        $candidate = User::where('role', 'job_seeker')
            ->with(['assessments.scores.competency', 'assessments.position'])
            ->findOrFail($id);

        $latestAssessment = $candidate->assessments()->latest()->first();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'email' => $candidate->email,
                'phone' => $candidate->phone,
                'bio' => $candidate->bio,
                'location' => $candidate->location ?? 'Indonesia',
                'education_level' => $candidate->education_level,
                'major' => $candidate->major,
                'experience_years' => $candidate->experience_years,
                'target_position' => $latestAssessment->position->name ?? $candidate->target_position,
                'linkedin_url' => $candidate->linkedin_url,
                'portfolio_url' => $candidate->portfolio_url,
                'skills' => $latestAssessment ? $latestAssessment->scores->map(function($score) {
                    return [
                        'name' => $score->competency->name,
                        'level' => $score->self_assessed_level,
                    ];
                }) : [],
            ]
        ]);
    }
}
