<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    /**
     * Preview CV di browser
     */
    public function preview()
    {
        $user = Auth::user();
        $user->load(['careerHistories', 'documents', 'institution']);

        return view('pdf.cv-template', compact('user'));
    }

    /**
     * Download CV sebagai PDF
     */
    public function download()
    {
        $user = Auth::user();
        $user->load(['careerHistories', 'documents', 'institution']);

        $pdf = Pdf::loadView('pdf.cv-template', compact('user'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Helvetica',
            ]);

        $filename = 'CV_' . str_replace(' ', '_', $user->name) . '_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Preview CV kandidat (untuk industry)
     */
    public function previewCandidate($userId)
    {
        $user = User::findOrFail($userId);
        $user->load(['careerHistories', 'documents', 'institution']);

        return view('pdf.cv-template', compact('user'));
    }

    /**
     * Download CV kandidat (untuk industry)
     */
    public function downloadCandidate($userId)
    {
        $user = User::findOrFail($userId);
        $user->load(['careerHistories', 'documents', 'institution']);

        $pdf = Pdf::loadView('pdf.cv-template', compact('user'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Helvetica',
            ]);

        $filename = 'CV_' . str_replace(' ', '_', $user->name) . '_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
