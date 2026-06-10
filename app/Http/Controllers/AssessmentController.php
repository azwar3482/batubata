<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Competency;
use App\Models\JobListing;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;
use App\Models\CareerRoadmap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\RecommendationService;
use App\Services\RoadmapService;
use App\Services\DynamicCompetencyService;


class AssessmentController extends Controller
{
    public function create()
    {
        $positions = Position::withCount(['competencies as technical_count' => function ($q) {
            $q->where('category', 'technical');
        }, 'competencies as soft_count' => function ($q) {
            $q->where('category', 'soft_skill');
        }])->get();

        $jobListings = JobListing::where('is_active', true)
            ->where('expires_date', '>', now())
            ->get();

        return view('assessment.create', compact('positions', 'jobListings'));
    }

    public function positions()
    {
        $positions = Position::all();
        return response()->json([
            'success' => true,
            'data' => $positions
        ]);
    }

    public function skills(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string',
        ]);

        $position = Position::with('competencies')->where('name', $request->position_name)->first();

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found'
            ], 404);
        }

        $query = $position->competencies();
        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    /**
     * Start assessment from a job listing (dynamic competency generation).
     */
    public function fromJob($jobId, DynamicCompetencyService $dynamicService)
    {
        $job = JobListing::findOrFail($jobId);
        $user = Auth::user();

        // Generate competencies from job listing
        $competencies = $dynamicService->generateFromJobListing($job);

        if ($competencies->isEmpty()) {
            return redirect()->route('seeker.jobs.detail', $jobId)
                ->with('error', 'Lowongan ini tidak memiliki data skill yang dapat digunakan untuk assessment.');
        }

        // Store in session
        session()->put('assessment_data', [
            'position_id' => $job->position_id,
            'job_listing_id' => $job->id,
            'experience_years' => $user->experience_years ?? 0,
            'education_level' => $user->education_level ?? 'SMA/SMK',
        ]);

        return redirect()->route('seeker.assessment.questions');
    }

    public function store(Request $request)
    {
        // Convert empty strings to null before validation
        $request->merge([
            'position_id' => $request->position_id ?: null,
            'job_listing_id' => $request->job_listing_id ?: null,
        ]);

        $request->validate([
            'position_id' => 'nullable|exists:positions,id',
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'experience_years' => 'nullable|integer|min:0',
            'education_level' => 'required|string',
        ]);

        // Must have at least one of position_id or job_listing_id
        if (!$request->position_id && !$request->job_listing_id) {
            return back()->with('error', 'Silakan pilih posisi atau lowongan.');
        }

        session()->put('assessment_data', [
            'position_id' => $request->position_id,
            'job_listing_id' => $request->job_listing_id,
            'experience_years' => $request->experience_years,
            'education_level' => $request->education_level,
        ]);

        return redirect()->route('seeker.assessment.questions');
    }

    public function questions(DynamicCompetencyService $dynamicService)
    {
        $data = session()->get('assessment_data');
        if (!$data) {
            return redirect()->route('seeker.assessment.create')->with('error', 'Silakan mulai asesmen dari awal.');
        }

        \Log::info('Assessment questions - session data:', $data);

        $position = null;
        $jobListing = null;
        $technicalSkills = collect([]);
        $softSkills = collect([]);

        if (!empty($data['position_id'])) {
            // Position-based assessment
            $position = Position::with('competencies')->find($data['position_id']);
            if ($position && $position->competencies->isNotEmpty()) {
                $technicalSkills = $position->competencies->where('category', 'technical');
                $softSkills = $position->competencies->where('category', 'soft_skill');
            }
        }

        \Log::info('After position check:', ['tech' => $technicalSkills->count(), 'soft' => $softSkills->count(), 'job_listing_id' => $data['job_listing_id'] ?? 'not set']);

        // If no competencies from position, try job listing
        if ($technicalSkills->isEmpty() && $softSkills->isEmpty() && !empty($data['job_listing_id'])) {
            \Log::info('Loading from job listing:', ['job_listing_id' => $data['job_listing_id']]);
            $jobListing = JobListing::find($data['job_listing_id']);
            if ($jobListing) {
                $competencies = $dynamicService->generateFromJobListing($jobListing);
                $technicalSkills = $competencies->where('category', 'technical');
                $softSkills = $competencies->where('category', 'soft_skill');
                \Log::info('Generated from job listing:', ['tech' => $technicalSkills->count(), 'soft' => $softSkills->count()]);
            }
        }

        // Fallback: if still empty, try generating from job listing even with position
        if ($technicalSkills->isEmpty() && $softSkills->isEmpty() && !empty($data['job_listing_id'])) {
            $jobListing = $jobListing ?? JobListing::find($data['job_listing_id']);
            if ($jobListing) {
                $competencies = $dynamicService->generateFromJobListing($jobListing);
                $technicalSkills = $competencies->where('category', 'technical');
                $softSkills = $competencies->where('category', 'soft_skill');
            }
        }

        // Build steps dynamically
        $steps = [];
        if ($technicalSkills->isNotEmpty()) $steps[] = 'technical';
        if ($softSkills->isNotEmpty()) $steps[] = 'soft_skill';
        $totalSteps = count($steps);

        if ($totalSteps === 0) {
            return redirect()->route('seeker.assessment.create')->with('error', 'Tidak ada kompetensi yang ditemukan. Silakan pilih posisi lain atau lowongan yang memiliki data skill.');
        }

        // Determine display name
        $targetName = $position ? $position->name : ($jobListing ? $jobListing->title : 'Assessment Umum');

        return view('assessment.questions', compact('position', 'jobListing', 'technicalSkills', 'softSkills', 'steps', 'totalSteps', 'targetName'));
    }

    public function submit(Request $request, \App\Services\AssessmentScoringService $scoringService)
    {
        $data = session()->get('assessment_data');
        $user = Auth::user();

        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'required|integer|min:1|max:10',
            'education_level' => 'nullable|string',
            'experience_years' => 'nullable|integer',
        ]);

        $positionId = null;
        $jobListingId = null;

        if ($data) {
            $positionId = $data['position_id'] ?? null;
            $jobListingId = $data['job_listing_id'] ?? null;
        } else {
            // Fallback for API calls where session might be missing
            $firstSkillId = array_key_first($request->skills);
            $competency = Competency::find($firstSkillId);
            
            $positionId = $competency ? $competency->position_id : null;
        }

        if (!$positionId && !$jobListingId) {
             return response()->json(['success' => false, 'message' => 'Position or Job Listing ID not found'], 400);
        }

        DB::beginTransaction();
        try {
            $assessment = $scoringService->processAndSaveScores(
                $user->id,
                $positionId,
                $request->skills,
                $jobListingId
            );

            if (!$assessment) {
                throw new \Exception("Gagal memproses skor asesmen.");
            }

            // Hapus sesi
            session()->forget('assessment_data');

            DB::commit();

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Asesmen berhasil diselesaikan!',
                    'data' => $assessment->load(['position', 'jobListing', 'scores.competency'])
                ]);
            }

            return redirect()->route('seeker.assessment.result', $assessment->id)
                ->with('success', 'Asesmen berhasil diselesaikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan assessment', ['error' => $e->getMessage()]);
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function result($id, RecommendationService $recService)
    {
        $assessment = UserAssessment::with(['position', 'jobListing', 'scores.competency'])
            ->findOrFail($id);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil rekomendasi kursus
        $recommendations = $recService->getRecommendedCourses($assessment, 6);

        // Cek apakah roadmap sudah ada
        $roadmapQuery = CareerRoadmap::where('user_id', $assessment->user_id);
        if ($assessment->position_id) {
            $roadmapQuery->where('position_id', $assessment->position_id);
        }
        $roadmapExists = $roadmapQuery->exists();

        $roadmapMilestones = [];
        if ($roadmapExists) {
            $roadmapMilestones = (clone $roadmapQuery)
                ->orderBy('month_number')
                ->take(3)
                ->get();
        }

        // Generate radar data dari assessment scores (sudah eager loaded)
        $radarData = [];
        $scores = $assessment->scores;

        if ($scores->isNotEmpty()) {
            $technicalScores = $scores->where('competency.category', 'technical');
            $softScores = $scores->where('competency.category', 'soft_skill');

            if ($technicalScores->isNotEmpty()) {
                $radarData[] = [
                    'label' => 'Skill Teknis',
                    'current' => round($technicalScores->avg('self_assessed_level'), 1),
                    'target' => round($technicalScores->avg(fn($s) => $s->competency->min_level_required), 1),
                ];
            }
            if ($softScores->isNotEmpty()) {
                $radarData[] = [
                    'label' => 'Soft Skill',
                    'current' => round($softScores->avg('self_assessed_level'), 1),
                    'target' => round($softScores->avg(fn($s) => $s->competency->min_level_required), 1),
                ];
            }

            // Top 5 skills by gap
            $topGaps = $scores->sortByDesc(fn($s) => $s->competency->min_level_required > 0
                ? max(0, (($s->competency->min_level_required - $s->self_assessed_level) / $s->competency->min_level_required) * 100)
                : 0
            )->take(5);

            foreach ($topGaps as $score) {
                $radarData[] = [
                    'label' => $score->competency->name,
                    'current' => (float) $score->self_assessed_level,
                    'target' => (float) $score->competency->min_level_required,
                ];
            }
        }

        // Determine target name
        $targetName = $assessment->target_name;

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => [
                    'assessment' => $assessment,
                    'recommendations' => $recommendations,
                    'roadmap_exists' => $roadmapExists,
                    'roadmap_milestones' => $roadmapMilestones,
                    'radar_data' => $radarData,
                    'target_name' => $targetName,
                ]
            ]);
        }

        return view('assessment.result', compact('assessment', 'recommendations', 'roadmapExists', 'roadmapMilestones', 'radarData', 'targetName'));
    }

    public function history()
    {
        $user = Auth::user();
        $assessments = UserAssessment::with(['position', 'jobListing', 'scores'])
            ->where('user_id', $user->id)
            ->orderBy('assessment_date', 'desc')
            ->paginate(10);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $assessments->items(),
                'meta' => [
                    'current_page' => $assessments->currentPage(),
                    'last_page' => $assessments->lastPage(),
                ]
            ]);
        }

        return view('assessment.history', compact('assessments'));
    }

    public function retake($id)
    {
        $assessment = UserAssessment::findOrFail($id);
        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        session()->put('previous_assessment_id', $id);

        return redirect()->route('seeker.assessment.create');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'education_level' => 'required|string',
            'major' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
