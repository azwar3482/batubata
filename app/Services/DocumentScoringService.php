<?php

namespace App\Services;

use App\Models\CompanyDocumentWeight;
use App\Models\JobListing;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\UserDocumentScore;
use Illuminate\Support\Facades\Log;

class DocumentScoringService
{
    /**
     * TAHAP 2: Hitung skor kecocokan final antara User dan Lowongan.
     *
     * Metode ini ringan dan cepat karena hanya melakukan:
     * 1. Ambil skor dokumen user yang sudah di-precompute dari DB
     * 2. Ambil bobot perusahaan dari DB
     * 3. Kalkulasi perkalian (tidak ada API call ke Python)
     *
     * @param User $user
     * @param JobListing $job
     * @return float Persentase kecocokan (0-100)
     */
    public function calculateFinalMatchScore(User $user, JobListing $job): float
    {
        // 1. Ambil bobot perusahaan (spesifik atau default)
        $weights = $this->getWeightsForJob($job);
        if (!$weights) {
            return 0.0;
        }
        $weightArray = $weights->toWeightArray();

        // 2. Ambil semua dokumen user yang sudah selesai diproses dengan satu query (Anti N+1)
        $documentScores = UserDocumentScore::where('user_id', $user->id)
            ->with('document:id,document_type')
            ->get()
            ->keyBy(fn($score) => $score->document->document_type);

        if ($documentScores->isEmpty()) {
            // Fallback ke perhitungan lama jika dokumen belum diproses
            return 0.0;
        }

        // 3. Hitung skor final berbobot
        $totalWeightedScore = 0.0;
        $totalWeight = 0.0;

        foreach ($weightArray as $docType => $weight) {
            if ($weight <= 0) continue;

            $score = $documentScores->get($docType)?->overall_score ?? 0;
            $totalWeightedScore += ($score * $weight / 100);
            $totalWeight += $weight;
        }

        if ($totalWeight <= 0) return 0.0;

        return round($totalWeightedScore, 1);
    }

    /**
     * TAHAP 1 (Pasca-Queue): Simpan hasil pemrosesan NLP dari Python AI ke database.
     *
     * @param UserDocument $document
     * @param array $aiResult Hasil JSON dari Python Flask
     */
    public function saveDocumentScore(UserDocument $document, array $aiResult): void
    {
        UserDocumentScore::updateOrCreate(
            ['document_id' => $document->id],
            [
                'user_id'                => $document->user_id,
                'extracted_data'         => $aiResult['extracted_data'] ?? $aiResult['extracted_skills'] ?? [],
                'skill_embedding_vector' => json_encode($aiResult['embedding_vector'] ?? []),
                'overall_score'          => $aiResult['overall_score'] ?? 50.0,
                'processed_at'           => now(),
            ]
        );

        // Update status dokumen menjadi 'completed'
        $document->update(['status' => UserDocument::STATUS_COMPLETED]);

        Log::info("DocumentScoringService: Skor dokumen ID {$document->id} ({$document->document_type}) berhasil disimpan.");
    }

    /**
     * Buat skor awal dummy saat Python AI tidak tersedia (fallback).
     * Skor awal menggunakan heuristik sederhana berdasarkan jenis dokumen.
     */
    public function createInitialDummyScore(UserDocument $document): void
    {
        $defaultScores = [
            'cv'          => 65.0,
            'ijazah'      => 70.0,
            'transkrip'   => 68.0,
            'sertifikat'  => 75.0,
            'portofolio'  => 60.0,
        ];

        UserDocumentScore::updateOrCreate(
            ['document_id' => $document->id],
            [
                'user_id'                => $document->user_id,
                'extracted_data'         => [],
                'skill_embedding_vector' => json_encode([]),
                'overall_score'          => $defaultScores[$document->document_type] ?? 60.0,
                'processed_at'           => now(),
            ]
        );

        $document->update(['status' => UserDocument::STATUS_COMPLETED]);
    }

    /**
     * Ambil konfigurasi bobot untuk lowongan tertentu.
     * Prioritas: bobot khusus perusahaan → bobot default (company_id = null).
     */
    private function getWeightsForJob(JobListing $job): ?CompanyDocumentWeight
    {
        // Coba ambil bobot spesifik perusahaan
        if ($job->company_id) {
            $specific = CompanyDocumentWeight::where('company_id', $job->company_id)
                ->where('is_active', true)
                ->first();
            if ($specific) return $specific;
        }

        // Fallback ke bobot default (company_id = null)
        return CompanyDocumentWeight::whereNull('company_id')
            ->where('is_active', true)
            ->first();
    }
}
