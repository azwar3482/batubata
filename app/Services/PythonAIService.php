<?php
// app/Services/PythonAIService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PythonAIService
{
    protected $pythonApiUrl;

    public function __construct()
    {
        $this->pythonApiUrl = config('services.python_api.url');
        // http://localhost:5000/api atau http://python-ai-service:5000/api
    }

    /**
     * Analisis Skill Gap dengan memanggil Python AI Module
     */
    public function analyzeSkillGap($data)
    {
        try {
            $response = Http::timeout(30)->post("{$this->pythonApiUrl}/extract-document", [
                'text' => $data['cv_text'] ?? $data['text'] ?? '',
                'target_position' => $data['target_position'] ?? 'General',
                'user_id' => $data['user_id'] ?? null,
                'document_type' => $data['document_type'] ?? 'cv'
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Python AI Service Error: ' . $response->body());
                throw new \Exception('Gagal menganalisis skill gap');
            }
        } catch (\Exception $e) {
            Log::error('Python AI Service Exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get rekomendasi kursus dari Python AI
     */
    public function getCourseRecommendations($skillGap, $userId)
    {
        $response = Http::post("{$this->pythonApiUrl}/recommend-courses", [
            'skill_gap' => $skillGap,
            'user_id' => $userId
        ]);

        return $response->json();
    }
}
