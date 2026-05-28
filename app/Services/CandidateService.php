<?php

namespace App\Services;

class CandidateService
{
    public function getCandidateDetail($candidateId)
    {
        // In production, fetch from database with proper authorization
        $candidate = (object) [
            'id' => $candidateId,
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@email.com',
            'phone' => '0812-3456-7890',
            'location' => 'Jakarta Selatan',
            'target_position' => 'Digital Marketing Specialist',
            'experience_years' => 3,
            'education' => 'S1 Teknik Informatika',
            'bio' => 'Profesional digital marketing dengan pengalaman 3+ tahun...',
            'linkedin_url' => 'https://linkedin.com/in/budisantoso',
            'portfolio_url' => 'https://budisantoso.dev',
            'cv_path' => 'cvs/cv_budi_santoso.pdf',
            'is_verified' => true,
            'last_active' => now()->subDay(),
            'last_assessment_date' => now()->subWeek(),
        ];

        $matchPercentage = 85; // Calculate based on job requirements

        return compact('candidate', 'matchPercentage');
    }
}
