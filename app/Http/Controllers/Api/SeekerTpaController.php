<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TpaTestSession;
use App\Models\TpaAnswer;
use App\Models\TpaResult;
use App\Services\TpaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SeekerTpaController extends Controller
{
    protected $tpaService;

    public function __construct(TpaService $tpaService)
    {
        $this->tpaService = $tpaService;
    }

    /**
     * Get TPA invitations for the seeker.
     */
    public function index()
    {
        $user = Auth::user();
        
        $sessions = TpaTestSession::where('user_id', $user->id)
            ->with(['tpaTest', 'result', 'jobApplication.jobListing'])
            ->latest()
            ->get();

        $stats = [
            'total' => $sessions->count(),
            'passed' => $sessions->where('result.is_passed', true)->count(),
            'avg_score' => TpaResult::whereIn('session_id', $sessions->pluck('id'))->avg('bappenas_score') ?? 0,
        ];

        return response()->json([
            'success' => true,
            'data' => $sessions,
            'stats' => $stats
        ]);
    }

    /**
     * Get detail of a specific TPA session.
     */
    public function show($id)
    {
        $session = TpaTestSession::with(['tpaTest', 'result', 'jobApplication.jobListing'])
            ->findOrFail($id);

        if ($session->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $this->tpaService->checkAndExpireSession($session);
        $session->refresh();

        return response()->json([
            'success' => true,
            'data' => $session
        ]);
    }

    /**
     * Start the TPA test.
     */
    public function start($id)
    {
        $session = TpaTestSession::findOrFail($id);

        if ($session->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            $session = $this->tpaService->startTest($session);
            return response()->json([
                'success' => true,
                'message' => 'Tes dimulai.',
                'data' => $session
            ]);
        } catch (\Exception $e) {
            Log::error('API Seeker TPA start failed', ['session_id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memulai tes. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Get the questions list for the TPA test in progress.
     */
    public function questions($id)
    {
        $session = TpaTestSession::findOrFail($id);

        if ($session->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $this->tpaService->checkAndExpireSession($session);
        $session->refresh();

        if ($session->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Tes ini sudah selesai atau expired.'
            ], 400);
        }

        $allQuestions = $this->tpaService->getSessionQuestions($session);
        
        // Load existing answers to pre-fill
        $answers = TpaAnswer::where('session_id', $session->id)->get()->keyBy('question_id');

        $questionsData = $allQuestions->map(function ($q) use ($answers) {
            $ans = $answers->get($q->id);
            return [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'option_a' => $q->option_a,
                'option_b' => $q->option_b,
                'option_c' => $q->option_c,
                'option_d' => $q->option_d,
                'option_e' => $q->option_e,
                'section' => $q->section, // verbal, numerical, logical
                'selected_answer' => $ans ? $ans->selected_answer : null,
                'is_flagged' => $ans ? (bool) $ans->is_flagged : false,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'questions' => $questionsData,
                'remaining_seconds' => $session->remaining_time_seconds,
            ]
        ]);
    }

    /**
     * Save/Auto-save single answer.
     */
    public function saveAnswer(Request $request, $id)
    {
        $session = TpaTestSession::findOrFail($id);

        if ($session->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if ($session->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Tes tidak aktif'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:tpa_questions,id',
            'selected_answer' => 'nullable|string|max:5',
            'time_spent' => 'integer|min:0',
            'is_flagged' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $answer = $this->tpaService->saveAnswer(
            $session,
            $request->question_id,
            $request->selected_answer,
            $request->time_spent ?? 0,
            $request->is_flagged ?? false
        );

        return response()->json([
            'success' => true,
            'data' => [
                'question_id' => $answer->question_id,
                'selected_answer' => $answer->selected_answer,
                'is_flagged' => (bool)$answer->is_flagged,
            ]
        ]);
    }

    /**
     * Submit and complete the TPA test.
     */
    public function submit($id)
    {
        $session = TpaTestSession::findOrFail($id);

        if ($session->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $session->refresh();

        if ($session->status === 'completed') {
            return response()->json([
                'success' => true,
                'message' => 'Tes TPA sudah diselesaikan.',
                'data' => $session->load('result')
            ]);
        }

        try {
            $result = $this->tpaService->submitTest($session);
            $session->refresh();
            
            return response()->json([
                'success' => true,
                'message' => 'Tes TPA berhasil diselesaikan!',
                'data' => $session->load('result')
            ]);
        } catch (\Exception $e) {
            Log::error('API Seeker TPA submit failed', ['session_id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengakhiri tes. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Respond to Offline invitation.
     */
    public function respondOffline(Request $request, $id)
    {
        $session = TpaTestSession::findOrFail($id);

        if ($session->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if ($session->tpa_type !== 'offline') {
            return response()->json([
                'success' => false,
                'message' => 'Ini bukan undangan TPA offline.'
            ], 400);
        }

        if ($session->seeker_response !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah merespon undangan ini.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'response' => 'required|in:accepted,reschedule_proposed,declined',
            'reschedule_date' => 'required_if:response,reschedule_proposed|nullable|date|after:now',
            'reschedule_reason' => 'required_if:response,reschedule_proposed|nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->tpaService->respondToOfflineInvitation(
            $session,
            $request->response,
            $request->reschedule_date,
            $request->reschedule_reason
        );

        return response()->json([
            'success' => true,
            'message' => 'Respon undangan offline berhasil disimpan.'
        ]);
    }
}
