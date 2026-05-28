<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadCVRequest;
use App\Services\CVAnalysisService;

class CVAnalysisController extends Controller
{
    public function uploadAndAnalyze(UploadCVRequest $request, CVAnalysisService $cvAnalysisService)
    {
        // Semua logika validasi, pemrosesan file, ekstraksi PDF, API call, 
        // dan penyimpanan database sudah dipindahkan dan diotomatiskan.
        $analysisResult = $cvAnalysisService->analyze(
            $request->file('cv_file'),
            $request->target_position,
            $request->user_id
        );

        return response()->json([
            'success' => true,
            'message' => 'CV berhasil dianalisis',
            'data' => $analysisResult
        ], 200);
    }
}
