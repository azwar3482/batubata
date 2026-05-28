<?php

namespace App\Jobs;

use App\Models\UserDocument;
use App\Services\DocumentScoringService;
use App\Services\PythonAIService;
use App\Services\DocumentExtractionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDocumentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Jumlah percobaan ulang jika job gagal.
     */
    public int $tries = 3;

    /**
     * Timeout dalam detik sebelum job dianggap timeout.
     */
    public int $timeout = 120;

    private int $userId;
    private array $documentIds;

    /**
     * @param int $userId ID user pemilik dokumen
     * @param array $documentIds Array ID dokumen yang harus diproses
     */
    public function __construct(int $userId, array $documentIds)
    {
        $this->userId      = $userId;
        $this->documentIds = $documentIds;
    }

    /**
     * Eksekusi Job: Proses semua dokumen user menggunakan Python AI Service.
     */
    public function handle(PythonAIService $pythonService, DocumentScoringService $scoringService, DocumentExtractionService $extractionService): void
    {
        Log::info("ProcessDocumentsJob: Memulai pemrosesan " . count($this->documentIds) . " dokumen untuk user ID {$this->userId}");

        // Ambil semua dokumen sekaligus dalam 1 query (Anti N+1 Read)
        $documents = UserDocument::whereIn('id', $this->documentIds)
            ->where('user_id', $this->userId)
            ->get();

        if ($documents->isEmpty()) {
            Log::warning("ProcessDocumentsJob: Tidak ada dokumen ditemukan untuk user ID {$this->userId}");
            return;
        }

        // Tandai semua dokumen sebagai 'processing' menggunakan Bulk Update
        UserDocument::whereIn('id', $this->documentIds)->update(['status' => UserDocument::STATUS_PROCESSING]);

        foreach ($documents as $document) {
            try {
                // Panggil Python AI untuk analisis dokumen
                $aiResult = $pythonService->analyzeSkillGap([
                    'cv_text'         => $extractionService->extractTextFromFile($document),
                    'target_position' => 'General', // Tahap 1: analisis umum tanpa target spesifik
                    'user_id'         => $this->userId,
                    'document_type'   => $document->document_type,
                ]);

                if ($aiResult) {
                    $scoringService->saveDocumentScore($document, $aiResult);
                } else {
                    // Fallback: Buat skor awal dummy jika AI tidak merespons
                    $scoringService->createInitialDummyScore($document);
                }

            } catch (\Exception $e) {
                Log::error("ProcessDocumentsJob: Gagal memproses dokumen ID {$document->id}: " . $e->getMessage());

                // Fallback ke skor dummy agar user tidak stuck di 'processing'
                $scoringService->createInitialDummyScore($document);
            }
        }

        Log::info("ProcessDocumentsJob: Selesai memproses dokumen untuk user ID {$this->userId}");
    }

    /**
     * Tangani kegagalan job setelah semua percobaan ulang habis.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessDocumentsJob: Job GAGAL TOTAL untuk user ID {$this->userId}: " . $exception->getMessage());

        // Tandai semua dokumen yang gagal
        UserDocument::whereIn('id', $this->documentIds)->update([
            'status' => UserDocument::STATUS_FAILED,
            'notes'  => 'Gagal diproses: ' . $exception->getMessage(),
        ]);
    }
}
