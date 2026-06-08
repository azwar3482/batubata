<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TpaQuestionTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithMapping
{
    public function collection()
    {
        // Contoh data sample untuk template
        return collect([
            [
                'verbal',
                'sinonim',
                'easy',
                'Pilih kata yang memiliki arti SAMA dengan kata SEDIH:',
                'A. Gembira|B. Murung|C. Marah|D. Takut',
                'B',
                'Murung memiliki arti yang sama dengan sedih.',
            ],
            [
                'numerik',
                'aritmetik',
                'medium',
                'Hasil dari 125 x 8 : 5 adalah...',
                'A. 100|B. 150|C. 200|D. 250',
                'C',
                '125 x 8 = 1000. 1000 : 5 = 200.',
            ],
            [
                'logika',
                'silogisme',
                'hard',
                "Premis 1: Semua mahasiswa rajin.\nPremis 2: Budi adalah mahasiswa.\nKesimpulan:",
                'A. Budi rajin|B. Budi tidak rajin|C. Budi mungkin rajin|D. Tidak dapat disimpulkan',
                'A',
                'Karena semua mahasiswa rajin dan Budi adalah mahasiswa, maka Budi rajin.',
            ],
            [
                'spasial',
                'pola_gambar',
                'easy',
                'Lanjutkan pola: ○, △, □, ○, △, □, ...',
                'A. ○|B. △|C. □|D. ◇',
                'B',
                'Pola berulang: ○, △, □. Setelah ○, simbol berikutnya adalah △.',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'category',
            'subcategory',
            'difficulty',
            'question_text',
            'options',
            'correct_answer',
            'explanation',
        ];
    }

    public function map($row): array
    {
        return $row;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4472C4'],
                ],
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // category
            'B' => 18,  // subcategory
            'C' => 12,  // difficulty
            'D' => 50,  // question_text
            'E' => 60,  // options
            'F' => 15,  // correct_answer
            'G' => 40,  // explanation
        ];
    }
}
