<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TIAController extends Controller
{
    /**
     * Show TIA document
     */
    public function show()
    {
        return view('legal.tia-document');
    }

    /**
     * Download TIA as PDF
     */
    public function download()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('legal.tia-document')
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Helvetica',
            ]);

        $filename = 'KOMPASKARIR_Transfer_Impact_Assessment_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
