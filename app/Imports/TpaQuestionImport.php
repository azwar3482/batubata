<?php

namespace App\Imports;

use App\Models\TpaQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TpaQuestionImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsErrors;

    protected $createdBy;

    public function __construct(int $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function model(array $row): TpaQuestion
    {
        // Parse options dari format "A. Pilihan A|B. Pilihan B|C. Pilihan C|D. Pilihan D"
        $options = $this->parseOptions($row['options'] ?? '');

        if (empty($options)) {
            return null;
        }

        return new TpaQuestion([
            'category' => $row['category'] ?? 'verbal',
            'subcategory' => $row['subcategory'] ?? null,
            'difficulty' => $row['difficulty'] ?? 'medium',
            'question_text' => $row['question_text'] ?? '',
            'options' => $options,
            'correct_answer' => strtoupper($row['correct_answer'] ?? 'A'),
            'explanation' => $row['explanation'] ?? null,
            'is_active' => true,
            'created_by' => $this->createdBy,
        ]);
    }

    public function rules(): array
    {
        return [
            'category' => 'required|in:verbal,numerik,logika,spasial',
            'subcategory' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_text' => 'required|string|max:5000',
            'options' => 'required|string|max:2000',
            'correct_answer' => 'required|string|max:5',
            'explanation' => 'nullable|string|max:2000',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'category.required' => 'Kategori wajib diisi',
            'category.in' => 'Kategori harus: verbal, numerik, logika, spasial',
            'difficulty.required' => 'Level wajib diisi',
            'difficulty.in' => 'Level harus: easy, medium, hard',
            'question_text.required' => 'Teks soal wajib diisi',
            'options.required' => 'Pilihan jawaban wajib diisi',
            'correct_answer.required' => 'Jawaban benar wajib diisi',
        ];
    }

    protected function parseOptions(string $optionsStr): array
    {
        // Format: "A. Pilihan A|B. Pilihan B|C. Pilihan C|D. Pilihan D"
        // Atau: "A: Pilihan A;B: Pilihan B;C: Pilihan C;D: Pilihan D"
        $options = [];

        // Coba separator "|" atau ";"
        $parts = str_contains($optionsStr, '|') ? explode('|', $optionsStr) : explode(';', $optionsStr);

        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) continue;

            // Parse "A. Text" atau "A: Text" atau "A Text"
            if (preg_match('/^([A-E])[\.\:\s]+(.+)$/i', $part, $matches)) {
                $options[] = [
                    'key' => strtoupper($matches[1]),
                    'text' => trim($matches[2]),
                ];
            }
        }

        return $options;
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
