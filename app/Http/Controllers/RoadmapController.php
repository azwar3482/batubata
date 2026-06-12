<?php
namespace App\Http\Controllers;

use App\Models\CareerRoadmap;
use Illuminate\Support\Facades\Auth;

class RoadmapController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Ambil roadmap terbaru berdasarkan posisi terakhir yang diasesmen
        $latestAssessment = $user->assessments()->with('position', 'jobListing', 'scores.competency')->latest('assessment_date')->first();
        
        if (!$latestAssessment) {
            if (request()->wantsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus menyelesaikan asesmen terlebih dahulu untuk melihat roadmap.',
                    'needs_assessment' => true
                ], 400);
            }
            return redirect()->route('seeker.assessment.create')->with('info', 'Anda harus menyelesaikan asesmen terlebih dahulu untuk melihat roadmap.');
        }

        $roadmapQuery = CareerRoadmap::where('user_id', $user->id);
        if ($latestAssessment->position_id) {
            $roadmapQuery->where('position_id', $latestAssessment->position_id);
        } else {
            $roadmapQuery->whereNull('position_id');
        }
        $roadmaps = $roadmapQuery->orderBy('month_number')->get();

        // Build assessment scores untuk fallback skill tree data
        $assessmentScores = $latestAssessment->scores
            ->filter(fn($s) => $s->competency !== null)
            ->sortByDesc('gap_percentage')
            ->values()
            ->map(fn($s) => [
                'name'           => $s->competency->name,
                'category'       => $s->competency->category,
                'current_level'  => (int) $s->self_assessed_level,
                'target_level'   => (int) $s->competency->min_level_required,
                'gap_percentage' => (float) $s->gap_percentage,
                'priority'       => $s->priority ?? 'medium',
            ])
            ->toArray();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => [
                    'roadmaps' => $roadmaps,
                    'latest_assessment' => $latestAssessment,
                    'assessment_scores' => $assessmentScores
                ]
            ]);
        }

        return view('roadmap.index', compact('roadmaps', 'latestAssessment', 'assessmentScores'));
    }
    
    public function generate($assessmentId)
    {
        $assessment = \App\Models\UserAssessment::findOrFail($assessmentId);
        
        // Ensure user owns this assessment
        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        // Generate roadmap using service
        app(\App\Services\RoadmapService::class)->generateRoadmap($assessment);

        return redirect()->route('seeker.roadmap.index')->with('success', 'Roadmap berhasil di-generate!');
    }
    
    // Nanti kita tambah fitur update progress di sini
    public function complete($id) {
        $roadmap = CareerRoadmap::findOrFail($id);
        if ($roadmap->user_id !== Auth::id()) abort(403);
        
        $roadmap->update([
            'is_completed' => true,
            'completed_at' => now()
        ]);
        
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Milestone berhasil diselesaikan!',
                'data' => $roadmap
            ]);
        }
        
        return back()->with('success', 'Milestone berhasil diselesaikan!');
    }
}