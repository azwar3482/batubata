<?php

namespace App\Http\Controllers;

use App\Models\TpaTestSession;
use App\Models\TpaAnswer;
use App\Models\TpaResult;
use App\Services\TpaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class SeekerTpaController extends Controller
{
    protected $tpaService;

    public function __construct(TpaService $tpaService)
    {
        $this->tpaService = $tpaService;
    }

    /**
     * Daftar undangan TPA saya
     */
    public function index()
    {
        $user = Auth::user();

        $baseQuery = TpaTestSession::where('user_id', $user->id);

        $sessions = (clone $baseQuery)
            ->with(['tpaTest', 'result', 'jobApplication.jobListing'])
            ->latest()
            ->paginate(15);

        $statusCounts = (clone $baseQuery)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $stats = [
            'total'     => $baseQuery->count(),
            'passed'    => (clone $baseQuery)->whereHas('result', fn($q) => $q->where('is_passed', true))->count(),
            'avg_score' => TpaResult::whereIn('session_id', (clone $baseQuery)->pluck('id'))->avg('bappenas_score') ?? 0,
            'invited'   => $statusCounts['invited'] ?? 0,
        ];

        return view('seeker.tpa.index', compact('sessions', 'stats', 'statusCounts'));
    }

    /**
     * Detail undangan TPA
     */
    public function show(TpaTestSession $session)
    {
        $this->authorizeSession($session);

        $session->load(['tpaTest', 'result', 'jobApplication.jobListing']);

        // Cek status lowongan terkait
        $jobStatusMessage = null;
        if ($session->jobApplication && $session->jobApplication->jobListing) {
            $job = $session->jobApplication->jobListing;
            if (!$job->is_available) {
                $jobStatusMessage = 'Lowongan terkait (' . $job->title . ') sudah tidak aktif. ';
                if ($session->status === 'invited' || $session->status === 'in_progress') {
                    $jobStatusMessage .= 'Tes TPA masih dapat dikerjakan.';
                }
            }
        }

        // Cek expired session
        $this->tpaService->checkAndExpireSession($session);
        $session->refresh();

        return view('seeker.tpa.show', compact('session', 'jobStatusMessage'));
    }

    /**
     * Mulai tes TPA
     */
    public function start(TpaTestSession $session)
    {
        $this->authorizeSession($session);

        try {
            $session = $this->tpaService->startTest($session);
        } catch (\Exception $e) {
            Log::error('Gagal start TPA test', ['session_id' => $session->id, 'error' => $e->getMessage()]);
            return redirect()->route('seeker.tpa.show', $session)->with('error', 'Gagal memulai tes. Silakan coba lagi.');
        }

        return redirect()->route('seeker.tpa.test', $session);
    }

    /**
     * Halaman utama tes (soal + timer + navigasi)
     */
    public function test(TpaTestSession $session, Request $request)
    {
        $this->authorizeSession($session);

        // Cek expired
        $this->tpaService->checkAndExpireSession($session);
        $session->refresh();

        if ($session->status !== 'in_progress') {
            return redirect()->route('seeker.tpa.show', $session)
                ->with('error', 'Tes ini sudah selesai atau expired.');
        }

        $currentIndex = $request->input('q', 0);
        $questionData = $this->tpaService->getNextQuestion($session, $currentIndex);
        $allQuestions = $this->tpaService->getSessionQuestions($session);

        // Hitung remaining time
        $remainingSeconds = $session->remaining_time_seconds;

        return view('seeker.tpa.test', compact('session', 'questionData', 'allQuestions', 'currentIndex', 'remainingSeconds'));
    }

    /**
     * Simpan jawaban (auto-save via AJAX)
     */
    public function saveAnswer(Request $request, TpaTestSession $session)
    {
        $this->authorizeSession($session);

        if ($session->status !== 'in_progress') {
            return response()->json(['error' => 'Tes tidak aktif'], 400);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:tpa_questions,id',
            'selected_answer' => 'nullable|string|max:5',
            'time_spent' => 'integer|min:0',
            'is_flagged' => 'boolean',
        ]);

        $answer = $this->tpaService->saveAnswer(
            $session,
            $validated['question_id'],
            $validated['selected_answer'] ?? null,
            $validated['time_spent'] ?? 0,
            $validated['is_flagged'] ?? false
        );

        return response()->json([
            'success' => true,
            'answer' => [
                'question_id' => $answer->question_id,
                'selected_answer' => $answer->selected_answer,
                'is_flagged' => $answer->is_flagged,
            ],
        ]);
    }

    /**
     * Submit tes (selesai)
     */
    public function submit(TpaTestSession $session, Request $request)
    {
        $this->authorizeSession($session);

        // Refresh session data
        $session->refresh();

        // Jika sudah selesai, redirect ke hasil
        if ($session->status === 'completed') {
            if ($session->tpaTest->show_result_after) {
                return redirect()->route('seeker.tpa.result', $session);
            }
            return redirect()->route('seeker.tpa.show', $session)
                ->with('success', 'Tes TPA sudah diselesaikan sebelumnya.');
        }

        if ($session->status !== 'in_progress') {
            return redirect()->route('seeker.tpa.show', $session)
                ->with('error', 'Tes ini tidak dalam status dikerjakan.');
        }

        // Konfirmasi
        if ($request->input('confirm') !== 'yes') {
            return view('seeker.tpa.confirm-submit', compact('session'));
        }

        try {
            $result = $this->tpaService->submitTest($session);
        } catch (\Exception $e) {
            Log::error('Gagal submit TPA test', ['session_id' => $session->id, 'error' => $e->getMessage()]);
            return redirect()->route('seeker.tpa.show', $session)
                ->with('error', 'Gagal submit tes. Silakan coba lagi atau hubungi admin.');
        }

        // Refresh untuk memastikan data terbaru
        $session->refresh();

        if ($session->tpaTest->show_result_after) {
            return redirect()->route('seeker.tpa.result', $session);
        }

        return redirect()->route('seeker.tpa.show', $session)
            ->with('success', 'Tes TPA berhasil diselesaikan! Hasil akan dikirim oleh perusahaan.');
    }

    /**
     * Lihat hasil TPA
     */
    public function result(TpaTestSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->result) {
            return redirect()->route('seeker.tpa.show', $session)
                ->with('error', 'Hasil tes belum tersedia.');
        }

        $session->load(['tpaTest', 'result', 'answers.question']);

        return view('seeker.tpa.result', compact('session'));
    }

    /**
     * Download hasil TPA dalam format PDF
     */
    public function downloadPdf(TpaTestSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->result) {
            return redirect()->route('seeker.tpa.show', $session)
                ->with('error', 'Hasil tes belum tersedia.');
        }

        $session->load(['tpaTest', 'result', 'answers.question']);
        $result = $session->result;
        $result->load(['user', 'tpaTest', 'session.answers.question']);

        $pdf = Pdf::loadView('pdf.tpa-result', compact('result'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Helvetica',
            ]);

        $filename = 'TPA_Result_' . str_replace(' ', '_', $result->user->name) . '_' . $result->created_at->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Respon undangan TPA offline
     */
    public function respondOffline(Request $request, TpaTestSession $session)
    {
        $this->authorizeSession($session);

        if ($session->tpa_type !== 'offline') {
            return back()->with('error', 'Ini bukan undangan TPA offline.');
        }

        if ($session->seeker_response !== 'pending') {
            return back()->with('error', 'Anda sudah merespon undangan ini.');
        }

        $request->validate([
            'response' => 'required|in:accepted,reschedule_proposed,declined',
            'reschedule_date' => 'required_if:response,reschedule_proposed|nullable|date|after:now',
            'reschedule_reason' => 'required_if:response,reschedule_proposed|nullable|string|max:500',
        ]);

        $this->tpaService->respondToOfflineInvitation(
            $session,
            $request->response,
            $request->reschedule_date,
            $request->reschedule_reason
        );

        $message = match($request->response) {
            'accepted' => 'Anda menerima undangan TPA offline.',
            'reschedule_proposed' => 'Anda mengusulkan jadwal baru.',
            'declined' => 'Anda menolak undangan TPA offline.',
        };

        return redirect()->route('seeker.tpa.show', $session)->with('success', $message);
    }

    /**
     * Otorisasi: pastikan sesi milik user ini
     */
    protected function authorizeSession(TpaTestSession $session): void
    {
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tes ini.');
        }
    }
}
