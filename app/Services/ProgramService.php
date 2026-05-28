<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ProgramService
{
    public function getProgramsData()
    {
        // Data dummy program (nanti dari database)
        $programs = collect([
            [
                'id' => 1,
                'name' => 'dummy Digital Marketing Bootcamp',
                'type' => 'Bootcamp',
                'duration' => '3 Bulan',
                'students' => 45,
                'status' => 'active',
                'start_date' => '2024-03-01',
                'industry_partners' => ['Tech Corp', 'Digital Hub'],
            ],
            [
                'id' => 2,
                'name' => 'Data Analytics Certification',
                'type' => 'Sertifikasi',
                'duration' => '6 Bulan',
                'students' => 32,
                'status' => 'active',
                'start_date' => '2024-02-15',
                'industry_partners' => ['DataPro', 'FinTech Nusantara'],
            ],
            [
                'id' => 3,
                'name' => 'AI & Machine Learning Workshop',
                'type' => 'Workshop',
                'duration' => '2 Hari',
                'students' => 28,
                'status' => 'upcoming',
                'start_date' => '2024-04-10',
                'industry_partners' => ['AI Labs'],
            ],
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

        // Simpan ke database (simulasi)
        // Program::create($validatedData);

        return true;
    }
}
