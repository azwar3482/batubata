<?php

namespace App\Services;

use App\Models\Competency;
use App\Models\JobListing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DynamicCompetencyService
{
    /**
     * Default soft skills to include when no position-based soft skills exist.
     */
    const DEFAULT_SOFT_SKILLS = [
        'Communication' => 5,
        'Teamwork' => 5,
        'Problem Solving' => 5,
        'Time Management' => 5,
        'Adaptability' => 5,
    ];

    /**
     * Generate or retrieve competencies from a job listing's required_skills.
     *
     * @param JobListing $job
     * @return Collection Collection of Competency models
     */
    public function generateFromJobListing(JobListing $job): Collection
    {
        $technicalSkills = $job->required_skills ?? [];
        $sourceRef = 'job_listing:' . $job->id;

        // Priority 1: Company-specific competencies for this job listing
        if ($job->company_id) {
            $companyCompetencies = Competency::where('company_id', $job->company_id)
                ->where(function ($q) use ($job) {
                    $q->whereNull('position_id')
                      ->orWhereHas('position', function ($pq) use ($job) {
                          $pq->where('id', $job->position_id);
                      });
                })
                ->get();

            if ($companyCompetencies->isNotEmpty()) {
                return $companyCompetencies;
            }
        }

        // Priority 2: Admin competencies for the position (if exists)
        if ($job->position_id) {
            $positionCompetencies = Competency::where('position_id', $job->position_id)
                ->whereNull('company_id')
                ->get();

            if ($positionCompetencies->isNotEmpty()) {
                return $positionCompetencies;
            }
        }

        // Priority 3: Generate from required_skills + default soft skills
        return $this->generateFromSkills($technicalSkills, array_keys(self::DEFAULT_SOFT_SKILLS), $sourceRef);
    }

    /**
     * Generate or retrieve competencies from skill arrays.
     *
     * @param array $technicalSkills Array of technical skill names
     * @param array $softSkills Array of soft skill names
     * @param string $sourceReference Source reference identifier
     * @return Collection Collection of Competency models
     */
    public function generateFromSkills(array $technicalSkills, array $softSkills, string $sourceReference = 'dynamic'): Collection
    {
        $competencies = collect([]);

        // Process technical skills
        foreach ($technicalSkills as $index => $skillName) {
            $skillName = trim($skillName);
            if (empty($skillName)) continue;

            $competency = $this->findOrCreateCompetency(
                $skillName,
                'technical',
                $sourceReference,
                $index + 1
            );
            if ($competency) {
                $competencies->push($competency);
            }
        }

        // Process soft skills
        foreach ($softSkills as $index => $skillName) {
            $skillName = trim($skillName);
            if (empty($skillName)) continue;

            $minLevel = self::DEFAULT_SOFT_SKILLS[$skillName] ?? 3;

            $competency = $this->findOrCreateCompetency(
                $skillName,
                'soft_skill',
                $sourceReference,
                $index + 1,
                $minLevel
            );
            if ($competency) {
                $competencies->push($competency);
            }
        }

        return $competencies;
    }

    /**
     * Find an existing competency by name or create a new dynamic one.
     */
    protected function findOrCreateCompetency(
        string $name,
        string $category,
        string $sourceReference,
        int $index,
        int $minLevelRequired = 5
    ): ?Competency {
        try {
            // First, try to find an existing competency with the same name (case-insensitive)
            $existing = Competency::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

            if ($existing) {
                return $existing;
            }

            // Create a new dynamic competency
            $code = strtoupper(substr($category, 0, 4)) . '-' . str_pad($index, 3, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5($sourceReference . $name), 0, 6));

            return Competency::create([
                'code' => $code,
                'name' => $name,
                'category' => $category,
                'position_id' => null,
                'min_level_required' => $minLevelRequired,
                'source_reference' => $sourceReference,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create dynamic competency', [
                'name' => $name,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Get competencies for a position, falling back to dynamic generation if empty.
     *
     * @param int|null $positionId
     * @param JobListing|null $job
     * @return Collection
     */
    public function getCompetenciesForAssessment(?int $positionId, ?JobListing $job = null): Collection
    {
        // If position has competencies, use those
        if ($positionId) {
            $position = \App\Models\Position::with('competencies')->find($positionId);
            if ($position && $position->competencies->isNotEmpty()) {
                return $position->competencies;
            }
        }

        // Fallback: generate from job listing
        if ($job) {
            return $this->generateFromJobListing($job);
        }

        return collect([]);
    }
}
