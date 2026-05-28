<?php

namespace App\Services;

use App\Models\UserDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DocumentExtractionService
{
    /**
     * Ekstrak teks dari file dokumen.
     * Untuk PDF menggunakan smalot/pdfparser, untuk file lain gunakan teks placeholder atau parser PHPWord.
     */
    public function extractTextFromFile(UserDocument $document): string
    {
        $fullPath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($fullPath)) {
            return "Dokumen tidak ditemukan: {$document->original_name}";
        }

        try {
            if (in_array($document->mime_type, ['application/pdf'])) {
                $parser = new \Smalot\PdfParser\Parser();
                $text = $parser->parseFile($fullPath)->getText();
                
                // Jika teks sangat pendek atau kosong, kemungkinan ini adalah hasil scan
                if (strlen(trim($text)) < 20) {
                    Log::info("DocumentExtractionService: PDF terdeteksi sebagai gambar/scan. Menggunakan OCR untuk {$document->original_name}");
                    return $this->extractViaOcr($fullPath);
                }
                
                return $text;
            }

            if (in_array($document->mime_type, [
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword'
            ])) {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullPath);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . ' ';
                        }
                    }
                }
                return $text;
            }
        } catch (\Exception $e) {
            Log::warning("DocumentExtractionService: Gagal ekstrak teks dari {$document->original_name}: " . $e->getMessage());
            return "Gagal mengekstrak dokumen: " . $e->getMessage();
        }

        return "Tipe dokumen: {$document->document_type}, Nama: {$document->original_name}";
    }

    /**
     * Ekstrak teks menggunakan layanan OCR.Space (Gratis)
     * 
     * @param string $filePath
     * @return string
     */
    private function extractViaOcr(string $filePath): string
    {
        try {
            $response = Http::timeout(60)->attach(
                'file', file_get_contents($filePath), basename($filePath)
            )->post('https://api.ocr.space/parse/image', [
                'apikey' => env('OCR_SPACE_API_KEY', 'helloworld'),
                'language' => 'eng',
                'isOverlayRequired' => 'false',
                'scale' => 'true',
                'isTable' => 'true',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['IsErroredOnProcessing']) && $data['IsErroredOnProcessing'] === false) {
                    $extractedText = '';
                    foreach ($data['ParsedResults'] as $result) {
                        $extractedText .= $result['ParsedText'] . " \n";
                    }
                    return trim($extractedText);
                }
                
                Log::warning("OCR Space Error: " . json_encode($data['ErrorMessage'] ?? 'Unknown Error'));
                return "Gagal melakukan OCR: Terjadi kesalahan dari API.";
            }

            Log::error("OCR Space HTTP Error: " . $response->status());
            return "Gagal menghubungi layanan OCR.";

        } catch (\Exception $e) {
            Log::error("OCR Exception: " . $e->getMessage());
            return "Gagal mengekstrak melalui OCR: " . $e->getMessage();
        }
    }
}
