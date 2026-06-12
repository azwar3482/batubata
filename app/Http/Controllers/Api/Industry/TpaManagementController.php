<?php

namespace App\Http\Controllers\Api\Industry;

use App\Http\Controllers\Controller;
use App\Models\TpaQuestion;
use App\Models\TpaTest;
use App\Models\TpaResult;
use App\Models\TpaTestSession;
use App\Models\UserJobApplication;
use App\Models\JobListing;
use App\Services\TpaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TpaManagementController extends Controller
{
    protected $tpaService;

    public function __construct(TpaService $tpaService)
    {
        $this->tpaService = $tpaService;
    }

    /**
     * List all TPA tests created by the company.
     */
    public function index()
    {
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');

        $tests = TpaTest::whereIn('job_listing_id', $jobIds)
            ->orWhere('created_by', $user->id)
            ->with('jobListing')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tests
        ]);
    }

    /**
     * Create a new TPA test.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:10|max:180',
            'verbal_count' => 'required|integer|min:0|max:50',
            'numerik_count' => 'required|integer|min:0|max:50',
            'logika_count' => 'required|integer|min:0|max:50',
            'spasial_count' => 'required|integer|min:0|max:50',
            'passing_score' => 'required|numeric|min:0|max:100',
            'verbal_weight' => 'required|numeric|min:0|max:100',
            'numerik_weight' => 'required|numeric|min:0|max:100',
            'logika_weight' => 'required|numeric|min:0|max:100',
            'spasial_weight' => 'required|numeric|min:0|max:100',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'show_result_after' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $totalWeight = $validated['verbal_weight'] + $validated['numerik_weight'] +
                       $validated['logika_weight'] + $validated['spasial_weight'];

        if ($totalWeight != 100) {
            return response()->json([
                'success' => false,
                'message' => 'Total bobot kategori harus tepat 100%.'
            ], 422);
        }

        $test = $this->tpaService->createTest($validated, Auth::id());

        if (!empty($validated['job_listing_id'])) {
            JobListing::where('id', $validated['job_listing_id'])->update(['use_tpa' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tes TPA berhasil dibuat.',
            'data' => $test
        ], 201);
    }

    /**
     * Update TPA test.
     */
    public function update(Request $request, $id)
    {
        $test = TpaTest::findOrFail($id);

        if ($test->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:10|max:180',
            'verbal_count' => 'required|integer|min:0|max:50',
            'numerik_count' => 'required|integer|min:0|max:50',
            'logika_count' => 'required|integer|min:0|max:50',
            'spasial_count' => 'required|integer|min:0|max:50',
            'passing_score' => 'required|numeric|min:0|max:100',
            'verbal_weight' => 'required|numeric|min:0|max:100',
            'numerik_weight' => 'required|numeric|min:0|max:100',
            'logika_weight' => 'required|numeric|min:0|max:100',
            'spasial_weight' => 'required|numeric|min:0|max:100',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'show_result_after' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $totalWeight = $validated['verbal_weight'] + $validated['numerik_weight'] +
                       $validated['logika_weight'] + $validated['spasial_weight'];

        if ($totalWeight != 100) {
            return response()->json([
                'success' => false,
                'message' => 'Total bobot kategori harus tepat 100%.'
            ], 422);
        }

        $test = $this->tpaService->updateTest($test, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Tes TPA berhasil diperbarui.',
            'data' => $test
        ]);
    }

    /**
     * Delete TPA test.
     */
    public function destroy($id)
    {
        $test = TpaTest::findOrFail($id);

        if ($test->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $test->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tes TPA berhasil dihapus.'
        ]);
    }

    /**
     * Invite candidate to a TPA test.
     */
    public function inviteCandidate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tpa_test_id' => 'required|exists:tpa_tests,id',
            'application_id' => 'required|exists:user_job_applications,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $test = TpaTest::findOrFail($request->tpa_test_id);
        $application = UserJobApplication::findOrFail($request->application_id);

        $job = JobListing::findOrFail($application->job_listing_id);
        if ($job->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $existingSession = TpaTestSession::where('job_application_id', $application->id)
            ->where('tpa_test_id', $test->id)
            ->whereIn('status', ['invited', 'in_progress'])
            ->first();

        if ($existingSession) {
            return response()->json([
                'success' => false,
                'message' => 'Kandidat ini sudah memiliki undangan TPA yang aktif.'
            ], 400);
        }

        $session = $this->tpaService->inviteCandidate($application, $test);

        return response()->json([
            'success' => true,
            'message' => 'Undangan TPA berhasil dikirim.',
            'data' => $session
        ]);
    }

    /**
     * Get TPA results for candidates.
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');

        $query = TpaResult::with(['user', 'tpaTest', 'session.jobApplication'])
            ->whereHas('tpaTest', function ($q) use ($jobIds) {
                $q->whereIn('job_listing_id', $jobIds);
            });

        if ($request->test_id) {
            $query->where('tpa_test_id', $request->test_id);
        }
        if ($request->passed !== null) {
            $query->where('is_passed', $request->passed === 'true' || $request->passed == 1);
        }

        $results = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }

    /**
     * Get detail of a specific TPA Result.
     */
    public function showResult($id)
    {
        $result = TpaResult::with(['user', 'tpaTest', 'session.answers.question'])->findOrFail($id);

        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');
        $testIds = TpaTest::whereIn('job_listing_id', $jobIds)->pluck('id');

        if (!in_array($result->tpa_test_id, $testIds->toArray()) && $result->tpaTest->created_by !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Get TPA Questions bank.
     */
    public function questions(Request $request)
    {
        $user = Auth::user();

        $query = TpaQuestion::where(function ($q) use ($user, $request) {
            if ($request->source === 'mine') {
                $q->where('created_by', $user->id);
            } elseif ($request->source === 'global') {
                $q->whereNull('created_by');
            } else {
                $q->where('created_by', $user->id)->orWhereNull('created_by');
            }
        });

        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }
        if ($request->search) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }

        $questions = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    /**
     * Create a TPA question in the bank.
     */
    public function storeQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:verbal,numerik,logika,spasial',
            'subcategory' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.key' => 'required|string|max:5',
            'options.*.text' => 'required|string',
            'correct_answer' => 'required|string|max:5',
            'explanation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['created_by'] = Auth::id();
        $validated['is_active'] = true;

        $question = TpaQuestion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal TPA berhasil ditambahkan ke bank soal.',
            'data' => $question
        ], 201);
    }

    /**
     * Update TPA Question.
     */
    public function updateQuestion(Request $request, $id)
    {
        $question = TpaQuestion::findOrFail($id);

        if ($question->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'category' => 'required|in:verbal,numerik,logika,spasial',
            'subcategory' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.key' => 'required|string|max:5',
            'options.*.text' => 'required|string',
            'correct_answer' => 'required|string|max:5',
            'explanation' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $question->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Soal TPA berhasil diperbarui.',
            'data' => $question
        ]);
    }

    /**
     * Delete TPA question from bank.
     */
    public function destroyQuestion($id)
    {
        $question = TpaQuestion::findOrFail($id);

        if ($question->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal TPA berhasil dihapus.'
        ]);
    }
}
