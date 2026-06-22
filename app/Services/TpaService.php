<?php

namespace App\Services;

use App\Models\TpaQuestion;
use App\Models\TpaTest;
use App\Models\TpaTestSession;
use App\Models\TpaAnswer;
use App\Models\TpaResult;
use App\Models\UserJobApplication;
use App\Models\JobListing;
use App\Models\User;
use App\Notifications\TpaInvitationReceived;
use App\Notifications\TpaOfflineInvitation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TpaService
{
    /**
     * Buat tes TPA untuk lowongan kerja
     */
    public function createTest(array $data, int $createdBy): TpaTest
    {
        $totalQuestions = ($data['verbal_count'] ?? 10) +
                          ($data['numerik_count'] ?? 10) +
                          ($data['logika_count'] ?? 10) +
                          ($data['spasial_count'] ?? 10);

        return TpaTest::create([
            'job_listing_id' => $data['job_listing_id'] ?? null,
            'created_by' => $createdBy,
            'title' => $data['title'] ?? 'Tes Potensi Akademik',
            'description' => $data['description'] ?? null,
            'total_questions' => $data['total_questions'] ?? $totalQuestions,
            'time_limit_minutes' => $data['time_limit_minutes'] ?? 60,
            'verbal_count' => $data['verbal_count'] ?? 10,
            'numerik_count' => $data['numerik_count'] ?? 10,
            'logika_count' => $data['logika_count'] ?? 10,
            'spasial_count' => $data['spasial_count'] ?? 10,
            'passing_score' => $data['passing_score'] ?? 60,
            'verbal_weight' => $data['verbal_weight'] ?? 30,
            'numerik_weight' => $data['numerik_weight'] ?? 30,
            'logika_weight' => $data['logika_weight'] ?? 20,
            'spasial_weight' => $data['spasial_weight'] ?? 20,
            'randomize_questions' => $data['randomize_questions'] ?? true,
            'randomize_options' => $data['randomize_options'] ?? true,
            'show_result_after' => $data['show_result_after'] ?? true,
        ]);
    }

    /**
     * Update tes TPA
     */
    public function updateTest(TpaTest $test, array $data): TpaTest
    {
        $totalQuestions = ($data['verbal_count'] ?? $test->verbal_count) +
                          ($data['numerik_count'] ?? $test->numerik_count) +
                          ($data['logika_count'] ?? $test->logika_count) +
                          ($data['spasial_count'] ?? $test->spasial_count);

        $data['total_questions'] = $data['total_questions'] ?? $totalQuestions;
        $test->update($data);

        return $test->fresh();
    }

    /**
     * Kirim undangan TPA ke pelamar
     */
    public function inviteCandidate(UserJobApplication $application, TpaTest $test): TpaTestSession
    {
        $existingSession = TpaTestSession::where('job_application_id', $application->id)
            ->whereIn('status', ['invited', 'in_progress'])
            ->first();

        if ($existingSession) {
            throw new \Exception('Kandidat ini sudah memiliki undangan TPA yang aktif.');
        }

        $deadlineHours = $application->jobListing->tpa_deadline_hours ?? 48;

        $session = TpaTestSession::create([
            'tpa_test_id' => $test->id,
            'user_id' => $application->user_id,
            'job_application_id' => $application->id,
            'status' => 'invited',
            'expires_at' => now()->addHours($deadlineHours),
        ]);

        $application->update([
            'tpa_status' => 'invited',
            'tpa_session_id' => $session->id,
        ]);

        // Kirim notifikasi ke seeker
        try {
            $seeker = User::find($application->user_id);
            if ($seeker) {
                $seeker->notify(new TpaInvitationReceived($session, $test));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi TPA: ' . $e->getMessage());
        }

        return $session;
    }

    /**
     * Kirim undangan TPA offline ke pelamar
     */
    public function inviteOffline(UserJobApplication $application, ?TpaTest $test, array $offlineData): TpaTestSession
    {
        $existingSession = TpaTestSession::where('job_application_id', $application->id)
            ->whereIn('status', ['invited', 'in_progress'])
            ->first();

        if ($existingSession) {
            throw new \Exception('Kandidat ini sudah memiliki undangan TPA yang aktif.');
        }

        // Untuk offline, buat dummy test jika tidak ada
        if (!$test) {
            $test = TpaTest::where('title', 'Tes TPA Offline')->first();
            if (!$test) {
                $test = TpaTest::create([
                    'title' => 'Tes TPA Offline',
                    'description' => 'Template untuk tes TPA offline',
                    'created_by' => auth()->id(),
                    'total_questions' => 0,
                    'time_limit_minutes' => 0,
                    'passing_score' => $offlineData['passing_score'] ?? 60,
                    'verbal_count' => 0,
                    'numerik_count' => 0,
                    'logika_count' => 0,
                    'spasial_count' => 0,
                    'is_active' => true,
                ]);
            }
        }

        $session = TpaTestSession::create([
            'tpa_test_id' => $test->id,
            'user_id' => $application->user_id,
            'job_application_id' => $application->id,
            'status' => 'invited',
            'tpa_type' => 'offline',
            'offline_instructions' => $offlineData['instructions'] ?? null,
            'offline_scheduled_at' => $offlineData['scheduled_at'] ?? null,
            'offline_location' => $offlineData['location'] ?? null,
            'offline_contact_person' => $offlineData['contact_person'] ?? null,
            'offline_contact_phone' => $offlineData['contact_phone'] ?? null,
            'offline_notes' => $offlineData['notes'] ?? null,
            'seeker_response' => 'pending',
        ]);

        $application->update([
            'tpa_status' => 'invited',
            'tpa_session_id' => $session->id,
        ]);

        // Kirim notifikasi ke seeker
        try {
            $seeker = User::find($application->user_id);
            if ($seeker) {
                $seeker->notify(new TpaOfflineInvitation($session));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi TPA offline: ' . $e->getMessage());
        }

        return $session;
    }

    /**
     * Seeker merespon undangan TPA offline
     */
    public function respondToOfflineInvitation(TpaTestSession $session, string $response, ?string $rescheduleDate = null, ?string $rescheduleReason = null): bool
    {
        if ($response === 'accepted') {
            $session->update(['seeker_response' => 'accepted']);
        } elseif ($response === 'reschedule_proposed') {
            $session->update([
                'seeker_response' => 'reschedule_proposed',
                'reschedule_proposed_at' => $rescheduleDate,
                'reschedule_reason' => $rescheduleReason,
            ]);
        } elseif ($response === 'declined') {
            $session->update(['seeker_response' => 'declined']);
        } else {
            return false;
        }

        // Update application TPA status
        if ($session->job_application_id) {
            $application = UserJobApplication::find($session->job_application_id);
            if ($application) {
                $tpaStatus = match($response) {
                    'accepted' => 'in_progress',
                    'declined' => 'failed',
                    default => 'invited',
                };
                $application->update(['tpa_status' => $tpaStatus]);
            }
        }

        return true;
    }

    /**
     * Industry input hasil TPA offline
     */
    public function submitOfflineResult(TpaTestSession $session, float $score, bool $isPassed, ?string $notes = null): TpaResult
    {
        $session->update([
            'status' => 'completed',
            'completed_at' => now(),
            'offline_score' => $score,
            'offline_is_passed' => $isPassed,
            'offline_result_notes' => $notes,
        ]);

        // Buat TpaResult
        $result = TpaResult::create([
            'session_id' => $session->id,
            'user_id' => $session->user_id,
            'tpa_test_id' => $session->tpa_test_id,
            'verbal_score' => 0,
            'numerik_score' => 0,
            'logika_score' => 0,
            'spasial_score' => 0,
            'total_score' => $score,
            'bappenas_score' => 200 + ($score * 6),
            'total_correct' => 0,
            'total_wrong' => 0,
            'total_unanswered' => 0,
            'total_questions' => 0,
            'is_passed' => $isPassed,
            'passing_score' => $session->tpaTest->passing_score,
        ]);

        // Update application
        if ($session->job_application_id) {
            $application = UserJobApplication::find($session->job_application_id);
            if ($application) {
                $application->update([
                    'tpa_status' => $isPassed ? 'passed' : 'failed',
                    'tpa_score' => $score,
                ]);

                if ($isPassed && $application->status === 'applied') {
                    $application->update(['status' => 'reviewed']);
                }
            }
        }

        // Notifikasi ke seeker
        try {
            $seeker = User::find($session->user_id);
            if ($seeker) {
                $statusText = $isPassed ? 'LULUS' : 'TIDAK LULUS';
                $seeker->notify(new \App\Notifications\ApplicationStatusNotification(
                    $session->jobApplication ?? new \App\Models\UserJobApplication(),
                    'tpa_offline_result',
                    'Hasil Tes TPA Offline Anda: ' . $statusText . '. Skor: ' . $score . '%'
                ));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi hasil TPA offline: ' . $e->getMessage());
        }

        return $result;
    }

    /**
     * Mulai tes TPA (job seeker klik "Mulai Tes")
     */
    public function startTest(TpaTestSession $session): TpaTestSession
    {
        if ($session->status !== 'invited') {
            throw new \Exception('Tes ini sudah dimulai atau selesai.');
        }

        if ($session->expires_at && $session->expires_at->isPast()) {
            $session->update(['status' => 'expired']);
            throw new \Exception('Batas waktu undangan tes telah berakhir.');
        }

        // Pilih soal berdasarkan konfigurasi tes
        $questions = $this->selectQuestions($session->tpaTest);

        // Randomize urutan soal jika diaktifkan
        $questionOrder = $questions->pluck('id')->toArray();
        if ($session->tpaTest->randomize_questions) {
            shuffle($questionOrder);
        }

        $session->update([
            'status' => 'in_progress',
            'started_at' => now(),
            'question_order' => $questionOrder,
        ]);

        // Update application TPA status
        if ($session->job_application_id) {
            $session->jobApplication->update(['tpa_status' => 'in_progress']);
        }

        return $session->fresh();
    }

    /**
     * Pilih soal dari bank soal sesuai konfigurasi tes
     * Soal yang tersedia: global (admin) + milik industri yang membuat tes
     */
    protected function selectQuestions(TpaTest $test)
    {
        $questions = collect();
        $createdBy = $test->created_by;

        foreach (['verbal', 'numerik', 'logika', 'spasial'] as $category) {
            $count = $test->{$category . '_count'};
            $available = TpaQuestion::active()
                ->byCategory($category)
                ->where(function ($q) use ($createdBy) {
                    $q->whereNull('created_by')      // Soal global dari admin
                      ->orWhere('created_by', $createdBy); // Soal milik industri ini
                })
                ->inRandomOrder()
                ->limit($count)
                ->get();

            // Randomize options jika diaktifkan
            if ($test->randomize_options) {
                $available->each(function ($q) {
                    $options = $q->options;
                    shuffle($options);
                    $q->options = $options;
                });
            }

            $questions = $questions->merge($available);
        }

        return $questions;
    }

    /**
     * Ambil soal berikutnya untuk dikerjakan
     */
    public function getNextQuestion(TpaTestSession $session, int $currentIndex): ?array
    {
        $questionOrder = $session->question_order ?? [];

        if ($currentIndex >= count($questionOrder)) {
            return null;
        }

        $questionId = $questionOrder[$currentIndex];
        $question = TpaQuestion::find($questionId);

        if (!$question) {
            return null;
        }

        // Cek apakah sudah dijawab
        $existingAnswer = TpaAnswer::where('session_id', $session->id)
            ->where('question_id', $questionId)
            ->first();

        return [
            'id' => $question->id,
            'index' => $currentIndex,
            'total' => count($questionOrder),
            'category' => $question->category,
            'category_label' => $question->category_label,
            'difficulty' => $question->difficulty,
            'difficulty_label' => $question->difficulty_label,
            'question_text' => $question->question_text,
            'question_image' => $question->question_image,
            'options' => $question->options,
            'selected_answer' => $existingAnswer?->selected_answer,
            'is_flagged' => $existingAnswer?->is_flagged ?? false,
            'time_spent' => $existingAnswer?->time_spent_seconds ?? 0,
        ];
    }

    /**
     * Simpan jawaban sementara (auto-save)
     */
    public function saveAnswer(TpaTestSession $session, int $questionId, ?string $selectedAnswer, int $timeSpent = 0, bool $isFlagged = false): TpaAnswer
    {
        $question = TpaQuestion::findOrFail($questionId);

        return TpaAnswer::updateOrCreate(
            [
                'session_id' => $session->id,
                'question_id' => $questionId,
            ],
            [
                'selected_answer' => $selectedAnswer,
                'is_correct' => $selectedAnswer === $question->correct_answer,
                'time_spent_seconds' => $timeSpent,
                'is_flagged' => $isFlagged,
            ]
        );
    }

    /**
     * Submit tes dan hitung skor
     */
    public function submitTest(TpaTestSession $session): TpaResult
    {
        return DB::transaction(function () use ($session) {
            $session = TpaTestSession::lockForUpdate()->find($session->id);

            if ($session->status !== 'in_progress') {
                throw new \Exception('Tes ini tidak dalam status dikerjakan.');
            }

            $completedAt = now();
            $timeSpent = $session->started_at
                ? (int) abs($session->started_at->diffInSeconds($completedAt))
                : 0;

            $session->update([
                'status' => 'completed',
                'completed_at' => $completedAt,
                'time_spent_seconds' => $timeSpent,
            ]);

            // Hitung skor
            $result = $this->calculateScore($session);

            // Update application
            if ($session->job_application_id) {
                $application = $session->jobApplication;
                $application->update([
                    'tpa_status' => $result->is_passed ? 'passed' : 'failed',
                    'tpa_score' => $result->total_score,
                ]);

                // Jika passed, otomatis update status lamaran ke reviewed
                if ($result->is_passed && $application->status === 'applied') {
                    $application->update(['status' => 'reviewed']);
                }
            }

            return $result;
        });
    }

    /**
     * Hitung skor TPA
     */
    protected function calculateScore(TpaTestSession $session): TpaResult
    {
        $test = $session->tpaTest;
        $answers = $session->answers()->with('question')->get();

        $totalQuestions = $answers->count();
        $totalCorrect = $answers->where('is_correct', true)->count();
        $totalUnanswered = $answers->whereNull('selected_answer')->count();
        $totalWrong = $totalQuestions - $totalCorrect - $totalUnanswered;

        // Hitung skor per kategori
        $categories = ['verbal', 'numerik', 'logika', 'spasial'];
        $categoryScores = [];

        foreach ($categories as $cat) {
            $catAnswers = $answers->filter(fn($a) => $a->question->category === $cat);
            $catTotal = $catAnswers->count();
            $catCorrect = $catAnswers->where('is_correct', true)->count();

            $categoryScores[$cat] = $catTotal > 0
                ? round(($catCorrect / $catTotal) * 100, 2)
                : 0;
        }

        // Hitung total weighted score
        $totalScore = (
            ($categoryScores['verbal'] * $test->verbal_weight / 100) +
            ($categoryScores['numerik'] * $test->numerik_weight / 100) +
            ($categoryScores['logika'] * $test->logika_weight / 100) +
            ($categoryScores['spasial'] * $test->spasial_weight / 100)
        );

        // Konversi ke skor Bappenas (200-800)
        $bappenasScore = 200 + ($totalScore * 6);

        // Cek kelulusan
        $isPassed = $totalScore >= $test->passing_score;

        return TpaResult::create([
            'session_id' => $session->id,
            'user_id' => $session->user_id,
            'tpa_test_id' => $test->id,
            'verbal_score' => $categoryScores['verbal'],
            'numerik_score' => $categoryScores['numerik'],
            'logika_score' => $categoryScores['logika'],
            'spasial_score' => $categoryScores['spasial'],
            'total_score' => round($totalScore, 2),
            'bappenas_score' => round($bappenasScore),
            'total_correct' => $totalCorrect,
            'total_wrong' => $totalWrong,
            'total_unanswered' => $totalUnanswered,
            'total_questions' => $totalQuestions,
            'is_passed' => $isPassed,
            'passing_score' => $test->passing_score,
        ]);
    }

    /**
     * Cek apakah sesi tes sudah expired
     */
    public function checkAndExpireSession(TpaTestSession $session): bool
    {
        return DB::transaction(function () use ($session) {
            $session = TpaTestSession::lockForUpdate()->find($session->id);

            if ($session->status === 'in_progress' && $session->started_at) {
                $limitSeconds = $session->tpaTest->time_limit_minutes * 60;
                $elapsed = now()->diffInSeconds($session->started_at);

                if ($elapsed >= $limitSeconds) {
                    // Auto-submit jika melewati batas waktu
                    $this->submitTest($session);
                    return true;
                }
            }

            if ($session->status === 'invited' && $session->expires_at && $session->expires_at->isPast()) {
                $session->update(['status' => 'expired']);
                if ($session->job_application_id) {
                    $session->jobApplication->update(['tpa_status' => 'failed']);
                }
                return true;
            }

            return false;
        });
    }

    /**
     * Ambil semua soal untuk sesi ini (untuk navigasi)
     */
    public function getSessionQuestions(TpaTestSession $session): array
    {
        $questionOrder = $session->question_order ?? [];
        $answers = $session->answers()->get()->keyBy('question_id');
        $questions = [];

        foreach ($questionOrder as $index => $qId) {
            $answer = $answers->get($qId);
            $questions[] = [
                'index' => $index,
                'question_id' => $qId,
                'answered' => $answer?->selected_answer !== null,
                'flagged' => $answer?->is_flagged ?? false,
            ];
        }

        return $questions;
    }

    /**
     * Ambil statistik TPA untuk admin/industry
     */
    public function getStats(?int $testId = null, ?int $companyId = null): array
    {
        $query = TpaResult::query();

        if ($testId) {
            $query->where('tpa_test_id', $testId);
        }

        $results = $query->get();

        if ($results->isEmpty()) {
            return [
                'total_taken' => 0,
                'total_passed' => 0,
                'total_failed' => 0,
                'pass_rate' => 0,
                'avg_score' => 0,
                'avg_bappenas' => 200,
                'avg_verbal' => 0,
                'avg_numerik' => 0,
                'avg_logika' => 0,
                'avg_spasial' => 0,
            ];
        }

        return [
            'total_taken' => $results->count(),
            'total_passed' => $results->where('is_passed', true)->count(),
            'total_failed' => $results->where('is_passed', false)->count(),
            'pass_rate' => round($results->where('is_passed', true)->count() / $results->count() * 100, 1),
            'avg_score' => round($results->avg('total_score'), 1),
            'avg_bappenas' => round($results->avg('bappenas_score')),
            'avg_verbal' => round($results->avg('verbal_score'), 1),
            'avg_numerik' => round($results->avg('numerik_score'), 1),
            'avg_logika' => round($results->avg('logika_score'), 1),
            'avg_spasial' => round($results->avg('spasial_score'), 1),
        ];
    }
}
