<?php

namespace App\Services;

use App\Models\Program;
use Illuminate\Http\UploadedFile;
use HTMLPurifier;
use HTMLPurifier_Config;

class ProgramService
{
    protected $purifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,strong,i,em,a[href],ul,ol,li,br,h2,h3,h4,blockquote');
        $config->set('HTML.Nofollow', true);
        $config->set('AutoFormat.RemoveEmpty', true);
        $this->purifier = new HTMLPurifier($config);
    }

    public function getProgramsData($filters = [])
    {
        $query = Program::withCount('enrollments');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Get stats from all programs (not paginated)
        $allPrograms = Program::withCount('enrollments')->get();
        $stats = [
            'total' => $allPrograms->count(),
            'active' => $allPrograms->where('status', 'active')->count(),
            'totalStudents' => $allPrograms->sum('enrollments_count'),
            'totalPartners' => $allPrograms->pluck('industry_partners')->flatten()->unique()->count(),
        ];

        // Get paginated results
        $programs = $query->latest()->paginate(12)->through(fn($p) => [
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

        return compact('programs', 'programTypes', 'durations', 'stats');
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

        $validatedData['max_students'] = $validatedData['target_students'] ?? 30;
        unset($validatedData['target_students']);

        $validatedData = $this->sanitizeData($validatedData);

        Program::create($validatedData);

        return true;
    }

    public function sanitizeData(array $data): array
    {
        if (isset($data['description'])) {
            $data['description'] = $this->purifier->purify($data['description']);
        }

        if (isset($data['learning_objectives']) && is_array($data['learning_objectives'])) {
            $data['learning_objectives'] = array_map(
                fn($objective) => $this->purifier->purify($objective),
                $data['learning_objectives']
            );
        }

        return $data;
    }
}
