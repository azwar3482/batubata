<?php

namespace App\Services;

use App\Models\User;
use App\Models\JobListing;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class JobMatchingService
{
    protected $documentScoringService;

    public function __construct(DocumentScoringService $documentScoringService)
    {
        $this->documentScoringService = $documentScoringService;
    }

    /**
     * Hitung matching percentage antara user dan lowongan
     */
    public function calculateMatch(User $user, JobListing $job): float
    {
        // 1. Ambil skor dari dokumen AI (NLP) - Bobot 60%
        $documentScore = $this->documentScoringService->calculateFinalMatchScore($user, $job);

        // 2. Ambil skill terbaik user dari asesmen manual terakhir - Bobot 40%
        $latestAssessment = $user->assessments()
            ->with('scores.competency')
            ->latest()
            ->first();

        $assessmentScore = 0.0;

        if ($latestAssessment) {
            // Mapping skill user: [Nama Skill => Level]
            $userSkills = [];
            foreach ($latestAssessment->scores as $score) {
                $userSkills[strtolower($score->competency->name)] = $score->self_assessed_level;
            }

            // 2. Ambil requirement lowongan
            $requiredSkills = array_map('strtolower', $job->required_skills ?? []);
            
            if (!empty($requiredSkills)) {
                $matchCount = 0;
                $totalScore = 0;
                $maxPossibleScore = count($requiredSkills) * 5; // Asumsi max level 5

                foreach ($requiredSkills as $reqSkill) {
                    $foundLevel = 0;
                    
                    foreach ($userSkills as $uSkillName => $uLevel) {
                        if (str_contains($uSkillName, $reqSkill) || str_contains($reqSkill, $uSkillName)) {
                            $foundLevel = $uLevel;
                            break;
                        }
                    }

                    $totalScore += $foundLevel;
                    if ($foundLevel >= 3) { // Threshold dianggap "bisa"
                        $matchCount++;
                    }
                }

                $assessmentScore = ($totalScore / $maxPossibleScore) * 100;
            } else {
                $assessmentScore = 50.0; // Default jika tidak ada syarat skill
            }
        }

        // 3. Gabungkan skor (Blended Score)
        // Jika ada document score, gunakan proporsi (60% doc, 40% asesmen)
        // Jika belum ada document score, gunakan 100% asesmen
        if ($documentScore > 0) {
            $finalPercentage = ($documentScore * 0.6) + ($assessmentScore * 0.4);
        } else {
            $finalPercentage = $assessmentScore > 0 ? $assessmentScore : 0.0;
        }
        
        return round($finalPercentage, 1);
    }

    /**
     * Dapatkan daftar lowongan yang sudah di-sortir berdasarkan matching score untuk user tertentu
     */
    public function getMatchedJobs(User $user, int $limit = 10)
    {
        $jobs = JobListing::where('is_active', true)
            ->where('expires_date', '>', now())
            ->get();

        $matchedJobs = $jobs->map(function ($job) use ($user) {
            $job->matching_percentage = $this->calculateMatch($user, $job);
            return $job;
        })->sortByDesc('matching_percentage');

        return $matchedJobs->take($limit);
    }

    /**
     * Dapatkan daftar lowongan dengan pagination manual
     */
    public function getMatchedJobsPaginated(User $user, int $perPage = 10, $search = null, $sort = 'terbaru')
    {
        $query = JobListing::where('is_active', true)
            ->where('expires_date', '>', now());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $userApplications = collect();
        if ($user) {
            $userApplications = \App\Models\UserJobApplication::where('user_id', $user->id)
                ->pluck('status', 'job_listing_id');
        }

        $jobs = $query->get();

        $matchedJobs = $jobs->map(function ($job) use ($user, $userApplications) {
            $job->matching_percentage = $this->calculateMatch($user, $job);
            $job->user_status = $userApplications->get($job->id);
            return $job;
        });

        if ($sort === 'kecocokan') {
            $matchedJobs = $matchedJobs->sortBy([
                ['matching_percentage', 'desc'],
                ['created_at', 'desc'],
            ]);
        } elseif ($sort === 'gaji') {
            $matchedJobs = $matchedJobs->sortByDesc('salary_max');
        } else {
            $matchedJobs = $matchedJobs->sortByDesc('created_at');
        }

        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $currentItems = $matchedJobs->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator(
            $currentItems,
            $matchedJobs->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}