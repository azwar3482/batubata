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
        $latestAssessment = $user->assessments()->latest()->first();
        
        if (!$latestAssessment) {
            return redirect()->route('seeker.assessment.create')->with('info', 'Anda harus menyelesaikan asesmen terlebih dahulu untuk melihat roadmap.');
        }

        $roadmaps = CareerRoadmap::where('user_id', $user->id)
            ->where('position_id', $latestAssessment->position_id)
            ->orderBy('month_number')
            ->get();

        return view('roadmap.index', compact('roadmaps', 'latestAssessment'));
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
    
    return back()->with('success', 'Milestone berhasil diselesaikan!');
}
}