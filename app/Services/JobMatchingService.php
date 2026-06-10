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
            ->latest('assessment_date')
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
    public function getMatchedJobsPaginated(User $user, int $perPage = 10, $search = null, $sort = 'terbaru', $tab = 'all')
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

        // Terapkan filter ketat HANYA jika tab 'matched' (Sesuai Kriteria) dipilih
        if ($user && $tab === 'matched') {
            $userAge = null;
            if ($user->birth_date) {
                $userAge = \Carbon\Carbon::parse($user->birth_date)->age;
            }
            $userGenderMap = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
            $userGender = $userGenderMap[$user->gender] ?? null;

            $jobs = $jobs->filter(function ($job) use ($user, $userAge, $userGender) {
                // 1. Gender Filter
                if (!empty($job->gender) && $job->gender !== 'Semua Jenis Kelamin') {
                    if ($userGender !== $job->gender) return false;
                }

                // 2. Blood Type Filter
                if (!empty($job->blood_type) && $job->blood_type !== 'Semua Golongan Darah') {
                    if ($user->blood_type !== $job->blood_type) return false;
                }

                // 3. Max Age Filter
                if ($job->max_age !== null && $userAge !== null) {
                    if ($userAge > $job->max_age) return false;
                }

                // 4. Expected Jobs & Salary Filter
                if (!empty($user->expected_jobs) && is_array($user->expected_jobs)) {
                    $jobMatchedPreference = false;
                    $jobPositionName = optional($job->position)->name;
                    
                    foreach ($user->expected_jobs as $pref) {
                        $prefPosition = $pref['position'] ?? null;
                        $prefSalaryMin = isset($pref['salary_min']) && $pref['salary_min'] !== '' ? (float)$pref['salary_min'] : null;
                        
                        if ($prefPosition && strcasecmp($prefPosition, $jobPositionName) === 0) {
                            // Jika posisi cocok, periksa gajinya.
                            // Lowongan disembunyikan HANYA JIKA salary_max lowongan < salary_min user.
                            // Artinya, selama salary_max >= salary_min user, atau salary_max belum diisi (null), maka tampilkan.
                            if ($prefSalaryMin !== null && $job->salary_max !== null) {
                                if ($job->salary_max >= $prefSalaryMin) {
                                    $jobMatchedPreference = true;
                                    break;
                                }
                            } else {
                                $jobMatchedPreference = true;
                                break;
                            }
                        }
                    }
                    
                    if (!$jobMatchedPreference) {
                        return false;
                    }
                }

                // 5. Languages Filter
                if (!empty($job->languages)) {
                    $userLangs = array_map('strtolower', $user->languages ?? []);
                    $jobLangs = array_map('strtolower', $job->languages);
                    // Check if user has ALL required languages
                    foreach ($jobLangs as $jl) {
                        if (!in_array($jl, $userLangs)) return false;
                    }
                }

                return true;
            });
        }

        // Terapkan filter untuk tab 'applying' (Sedang Dilamar) dan 'applied' (Sudah Dilamar)
        if ($user && in_array($tab, ['applying', 'applied'])) {
            $jobs = $jobs->filter(function ($job) use ($userApplications, $tab) {
                $status = $userApplications->get($job->id);
                if (!$status) return false;
                
                if ($tab === 'applying') {
                    return in_array($status, ['applied', 'reviewed', 'interviewed']);
                }
                
                if ($tab === 'applied') {
                    return in_array($status, ['applied', 'reviewed', 'interviewed', 'offered', 'rejected']);
                }
                
                return false;
            });
        }

        $matchedJobs = $jobs->map(function ($job) use ($user, $userApplications) {
            $job->matching_percentage = $this->calculateMatch($user, $job);
            $job->user_status = $userApplications->get($job->id);
            if ($user) {
                $job->shortcomings = $this->getJobShortcomings($user, $job);
            } else {
                $job->shortcomings = [];
            }
            return $job;
        });

        $sortCriteria = [];
        
        if ($tab === 'applied') {
            $sortCriteria[] = [function($job) {
                return in_array($job->user_status, ['applied', 'reviewed', 'interviewed']) ? 1 : 0;
            }, 'desc'];
        }

        if ($sort === 'kecocokan') {
            $sortCriteria[] = ['matching_percentage', 'desc'];
            $sortCriteria[] = ['created_at', 'desc'];
        } elseif ($sort === 'gaji') {
            $sortCriteria[] = ['salary_max', 'desc'];
            $sortCriteria[] = ['created_at', 'desc'];
        } else {
            $sortCriteria[] = ['created_at', 'desc'];
        }

        $matchedJobs = $matchedJobs->sortBy($sortCriteria);

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

    /**
     * Hitung kekurangan profil user terhadap syarat lowongan
     */
    public function getJobShortcomings(User $user, JobListing $job): array
    {
        $shortcomings = [];
        $userAge = null;
        if ($user->birth_date) {
            $userAge = \Carbon\Carbon::parse($user->birth_date)->age;
        }
        $userGenderMap = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
        $userGender = $userGenderMap[$user->gender] ?? null;

        if (!empty($job->gender) && $job->gender !== 'Semua Jenis Kelamin') {
            if ($userGender !== $job->gender) {
                $shortcomings[] = "Gender ({$job->gender})";
            }
        }

        if (!empty($job->blood_type) && $job->blood_type !== 'Semua Golongan Darah') {
            if ($user->blood_type !== $job->blood_type) {
                $shortcomings[] = "Gol. Darah ({$job->blood_type})";
            }
        }

        if ($job->max_age !== null && $userAge !== null) {
            if ($userAge > $job->max_age) {
                $shortcomings[] = "Batas Usia (Maks {$job->max_age}th)";
            }
        }

        if (!empty($user->expected_jobs) && is_array($user->expected_jobs)) {
            $jobMatchedPreference = false;
            $jobPositionName = optional($job->position)->name;
            
            foreach ($user->expected_jobs as $pref) {
                $prefPosition = $pref['position'] ?? null;
                $prefSalaryMin = isset($pref['salary_min']) && $pref['salary_min'] !== '' ? (float)$pref['salary_min'] : null;
                
                if ($prefPosition && strcasecmp($prefPosition, $jobPositionName) === 0) {
                    if ($prefSalaryMin !== null && $job->salary_max !== null) {
                        if ($job->salary_max >= $prefSalaryMin) {
                            $jobMatchedPreference = true;
                            break;
                        }
                    } else {
                        $jobMatchedPreference = true;
                        break;
                    }
                }
            }
            
            if (!$jobMatchedPreference) {
                $positionFound = false;
                foreach ($user->expected_jobs as $pref) {
                    if (strcasecmp($pref['position'] ?? '', $jobPositionName) === 0) {
                        $positionFound = true;
                        break;
                    }
                }
                if ($positionFound) {
                    $shortcomings[] = "Gaji di bawah ekspektasi";
                } else {
                    $shortcomings[] = "Posisi tidak diminati";
                }
            }
        } else {
            $shortcomings[] = "Minat pekerjaan belum diatur";
        }

        if (!empty($job->languages)) {
            $userLangs = array_map('strtolower', $user->languages ?? []);
            $jobLangs = array_map('strtolower', $job->languages);
            $missingLangs = [];
            foreach ($jobLangs as $jl) {
                if (!in_array($jl, $userLangs)) {
                    $missingLangs[] = ucfirst($jl);
                }
            }
            if (!empty($missingLangs)) {
                $shortcomings[] = "Bahasa (" . implode(', ', $missingLangs) . ")";
            }
        }

        if ($job->matching_percentage < 50) {
            $shortcomings[] = "Skill Gap terlalu jauh";
        }

        return $shortcomings;
    }
}