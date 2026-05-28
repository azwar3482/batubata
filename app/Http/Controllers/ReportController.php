<?php

namespace App\Http\Controllers;

use App\Models\UserAssessment;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadAssessment($id, RecommendationService $recService)
    {
        $assessment = UserAssessment::with(['position', 'scores.competency', 'user'])
            ->findOrFail($id);

        // Keamanan: Hanya pemilik atau admin yang bisa download
        if ($assessment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil rekomendasi untuk dimasukkan ke PDF
        $recommendations = $recService->getRecommendedCourses($assessment, 5);
        
        // Data untuk Grafik (Kita akan render gambar grafik atau tabel sederhana di PDF)
        // DomPDF terbatas untuk JS chart, jadi kita buat representasi tabel/bar sederhana
        
        $data = [
            'assessment' => $assessment,
            'recommendations' => $recommendations,
            'generated_at' => now()->format('d F Y, H:i'),
            'user' => $assessment->user
        ];

        $pdf = Pdf::loadView('reports.assessment-pdf', $data);
        
        // Set kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Laporan_Kompetensi_' . str_replace(' ', '_', $assessment->user->name) . '.pdf';

        return $pdf->download($filename);
    }
}