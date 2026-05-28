<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Competency;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;
use App\Models\CareerRoadmap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\RecommendationService;
use App\Services\RoadmapService;


class AssessmentController extends Controller
{
    public function create()
    {
        $positions = Position::all();
        return view('assessment.create', compact('positions'));
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

    public function store(Request $request)
    {
        // Validasi awal
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'experience_years' => 'nullable|integer|min:0',
            'education_level' => 'required|string',
        ]);

        // Simpan sesi sementara untuk data diri (bisa juga langsung simpan ke user jika mau update profil)
        session()->put('assessment_data', [
            'position_id' => $request->position_id,
            'experience_years' => $request->experience_years,
            'education_level' => $request->education_level,
        ]);

        return redirect()->route('seeker.assessment.questions');
    }

    public function questions()
    {
        $data = session()->get('assessment_data');
        if (!$data) {
            return redirect()->route('seeker.assessment.create')->with('error', 'Silakan mulai asesmen dari awal.');
        }

        $position = Position::with('competencies')->find($data['position_id']);

        // Kelompokkan kompetensi berdasarkan kategori untuk tampilan yang lebih rapi
        $technicalSkills = $position->competencies->where('category', 'technical');
        $softSkills = $position->competencies->where('category', 'soft_skill');

        return view('assessment.questions', compact('position', 'technicalSkills', 'softSkills'));
    }

    public function submit(Request $request, \App\Services\AssessmentScoringService $scoringService)
    {
        $data = session()->get('assessment_data');
        $user = Auth::user();

        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'required|integer|min:1|max:5',
            'education_level' => 'nullable|string',
            'experience_years' => 'nullable|integer',
        ]);

        if (!$data) {
            // Fallback for API calls where session might be missing
            $firstSkillId = array_key_first($request->skills);
            $competency = Competency::find($firstSkillId);
            
            $data = [
                'position_id' => $competency ? $competency->position_id : null,
                'education_level' => $request->education_level ?? $user->education_level,
                'experience_years' => $request->experience_years ?? $user->experience_years,
            ];
        }

        if (!$data['position_id']) {
             return response()->json(['success' => false, 'message' => 'Position ID not found'], 400);
        }

        DB::beginTransaction();
        try {
            // Mendelegasikan logika kalkulasi dan Bulk Insert ke Service
            $assessment = $scoringService->processAndSaveScores($user->id, $data['position_id'], $request->skills);

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
                    'data' => $assessment->load(['position', 'scores.competency'])
                ]);
            }

            return redirect()->route('seeker.assessment.result', $assessment->id)
                ->with('success', 'Asesmen berhasil diselesaikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    // public function result($id)
    // {
    //     $assessment = UserAssessment::with(['position', 'scores.competency'])
    //         ->findOrFail($id);

    //     // Pastikan hanya user pemilik yang bisa lihat
    //     if ($assessment->user_id !== Auth::id()) {
    //         abort(403);
    //     }

    //     return view('assessment.result', compact('assessment'));
    // }
    public function result($id, RecommendationService $recService)
    {
        $assessment = UserAssessment::with(['position', 'scores.competency'])
            ->findOrFail($id);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil rekomendasi kursus
        $recommendations = $recService->getRecommendedCourses($assessment, 6);

        // Cek apakah roadmap sudah ada
        $roadmapExists = CareerRoadmap::where('user_id', $assessment->user_id)
            ->where('position_id', $assessment->position_id)
            ->exists();

        $roadmapMilestones = [];
        if ($roadmapExists) {
            $roadmapMilestones = CareerRoadmap::where('user_id', $assessment->user_id)
                ->where('position_id', $assessment->position_id)
                ->orderBy('month_number')
                ->take(3)
                ->get();
        }

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => [
                    'assessment' => $assessment,
                    'recommendations' => $recommendations,
                    'roadmap_exists' => $roadmapExists,
                    'roadmap_milestones' => $roadmapMilestones
                ]
            ]);
        }

        return view('assessment.result', compact('assessment', 'recommendations', 'roadmapExists', 'roadmapMilestones'));
    }
    public function history()
    {
        $user = Auth::user();
        $assessments = UserAssessment::with(['position', 'scores'])
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

        // Load data asesmen sebelumnya untuk referensi
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

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        // Handle CV Upload
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
            // Simpan path CV di tabel terpisah atau user_meta jika perlu
            // Untuk simplifikasi, kita simpan di session atau buat tabel user_documents
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
