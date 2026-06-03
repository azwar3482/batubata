<?php

namespace App\Services;

use App\Models\Program;
use Illuminate\Http\UploadedFile;

class ProgramService
{
    public function getProgramsData()
    {
        $programs = Program::withCount('enrollments')
            ->latest()
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'type' => $p->type,
                'duration' => $p->duration,
                'students' => $p->enrollments_count,
                'status' => $p->status,
                'start_date' => $p->start_date?->format('Y-m-d'),
                'industry_partners' => $p->industry_partners ?? [],
            ]);

        $programTypes = ['Bootcamp', 'Sertifikasi', 'Workshop', 'Magang', 'Research Project', 'Guest Lecture Series'];
        $durations = ['1 Hari', '2 Hari', '1 Minggu', '1 Bulan', '3 Bulan', '6 Bulan', '1 Tahun'];

        return compact('programs', 'programTypes', 'durations');
    }

    public function getProgramFormOptions()
    {
        $programTypes = ['Bootcamp', 'Sertifikasi', 'Workshop', 'Magang', 'Research Project', 'Guest Lecture Series'];
        $durations = ['1 Hari', '2 Hari', '1 Minggu', '1 Bulan', '3 Bulan', '6 Bulan', '1 Tahun'];
        $industries = ['Software House', 'FinTech', 'E-Commerce', 'Digital Marketing', 'Data & AI', 'Consulting'];

        return compact('programTypes', 'durations', 'industries');
    }

    public function storeProgram(array $validatedData, ?UploadedFile $curriculumFile)
    {
        if ($curriculumFile) {
            $path = $curriculumFile->store('curriculum', 'public');
            $validatedData['curriculum_path'] = $path;
        }

        Program::create($validatedData);

        return true;
    }
}
