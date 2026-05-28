<?php

namespace App\Services;

use App\Models\SkillAnalysis;
use Illuminate\Http\UploadedFile;
use App\Services\PythonAIService;

class CVAnalysisService
{
    protected $pythonAIService;

    public function __construct(PythonAIService $pythonAIService)
    {
        $this->pythonAIService = $pythonAIService;
    }

    /**
     * Handle the full CV analysis pipeline.
     */
    public function analyze(UploadedFile $cvFile, string $targetPosition, string $userId)
    {
        // 1. Simpan file CV
        $cvPath = $cvFile->store('cvs', 'public');
        $fullPath = storage_path('app/public/' . $cvPath);

        // 2. Ekstrak teks dari CV
        $extension = $cvFile->getClientOriginalExtension();
        $cvText = $this->extractTextFromCV($fullPath, $extension);

        // 3. Panggil Python AI Service untuk analisis
        $analysisResult = $this->pythonAIService->analyzeSkillGap([
            'cv_text' => $cvText,
            'target_position' => $targetPosition,
            'user_id' => $userId
        ]);

        // 4. Simpan hasil analisis ke database
        SkillAnalysis::create([
            'user_id' => $userId,
            'cv_text' => $cvText,
            'extracted_skills' => json_encode($analysisResult['extracted_skills']),
            'target_skills' => json_encode($analysisResult['target_skills']),
            'skill_gap' => json_encode($analysisResult['skill_gap']),
            'gap_percentage' => $analysisResult['gap_percentage'],
            'recommendations' => json_encode($analysisResult['recommendations'])
        ]);

        return $analysisResult;
    }

    /**
     * Extract text from PDF or DOC/DOCX.
     */
    private function extractTextFromCV($filePath, $extension)
    {
        if ($extension === 'pdf') {
            return \Smalot\PdfParser\Parser::parseFile($filePath)->getText();
        } else {
            return \PhpOffice\PhpWord\IOFactory::load($filePath)->getText();
        }
    }
}
