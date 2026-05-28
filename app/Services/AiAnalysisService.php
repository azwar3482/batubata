<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiAnalysisService
{
    protected $aiEndpoint;

    public function __construct()
    {
        $this->aiEndpoint = config('services.ai.endpoint', 'http://localhost:5000/analyze');
    }

    public function analyzeAssessment(array $assessmentData)
    {
        try {
            $response = Http::timeout(30)->post($this->aiEndpoint, $assessmentData);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            // Fallback to rule-based jika AI tidak tersedia
            return $this->fallbackAnalysis($assessmentData);
        }
    }

    protected function fallbackAnalysis(array $data)
    {
        // Rule-based analysis sebagai fallback
        return [
            'skill_gap' => [],
            'recommendations' => [],
            'matching_scores' => ['overall' => 70]
        ];
    }
}
