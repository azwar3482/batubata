<?php

namespace App\Services;

class PartnerService
{
    /**
     * Get all mock partners data
     */
    protected function getMockPartners()
    {
        return [
            [
                'id' => 1,
                'name' => 'Tech Corp Indonesia',
                'logo' => 'TC',
                'industry' => 'Software House',
                'size' => '50-200 karyawan',
                'location' => 'Jakarta Selatan',
                'description' => 'Perusahaan teknologi yang fokus pada pengembangan aplikasi enterprise dan konsultasi digital transformation. Kami berkomitmen untuk mengembangkan talenta digital Indonesia melalui berbagai program kolaborasi dengan institusi pendidikan.',
                'collaboration_types' => ['Magang', 'Rekrutmen', 'Guest Lecture', 'Project Based Learning'],
                'active_opportunities' => 3,
                'website' => 'https://techcorp.id',
                'contact_email' => 'partnership@techcorp.id',
                'verified' => true,
                'benefits' => [
                    'Akses ke teknologi terbaru dan tools industri',
                    'Mentorship dari praktisi berpengalaman',
                    'Kesempatan rekrutmen prioritas untuk lulusan',
                    'Sertifikat kolaborasi yang diakui industri'
                ],
                'requirements' => [
                    'Kurikulum relevan dengan kebutuhan industri',
                    'Komitmen untuk program jangka panjang',
                    'Fasilitas pendukung yang memadai'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Digital Innovation Hub',
                'logo' => 'DIH',
                'industry' => 'Startup Incubator',
                'size' => '20-50 karyawan',
                'location' => 'Bandung',
                'description' => 'Inkubator startup yang mendukung inovasi digital dan pengembangan talenta teknologi muda.',
                'collaboration_types' => ['Magang', 'Mentorship', 'Hackathon', 'Curriculum Review'],
                'active_opportunities' => 5,
                'website' => 'https://dihub.id',
                'contact_email' => 'collab@dihub.id',
                'verified' => true,
                'benefits' => [],
                'requirements' => []
            ],
            [
                'id' => 3,
                'name' => 'FinTech Nusantara',
                'logo' => 'FTN',
                'industry' => 'Financial Technology',
                'size' => '200-500 karyawan',
                'location' => 'Jakarta Pusat',
                'description' => 'Perusahaan FinTech terkemuka yang mengembangkan solusi pembayaran digital dan financial inclusion.',
                'collaboration_types' => ['Rekrutmen', 'Research Collaboration', 'Internship', 'Case Study'],
                'active_opportunities' => 2,
                'website' => 'https://fintnus.com',
                'contact_email' => 'campus@fintnus.com',
                'verified' => true,
                'benefits' => [],
                'requirements' => []
            ],
            [
                'id' => 4,
                'name' => 'Creative Media Group',
                'logo' => 'CMG',
                'industry' => 'Digital Marketing & Media',
                'size' => '10-50 karyawan',
                'location' => 'Surabaya',
                'description' => 'Agency kreatif yang specializes dalam digital marketing, content creation, dan brand strategy.',
                'collaboration_types' => ['Magang', 'Project Collaboration', 'Workshop', 'Guest Lecture'],
                'active_opportunities' => 4,
                'website' => 'https://creativemedia.id',
                'contact_email' => 'hello@creativemedia.id',
                'verified' => false,
                'benefits' => [],
                'requirements' => []
            ],
            [
                'id' => 5,
                'name' => 'Data Analytics Pro',
                'logo' => 'DAP',
                'industry' => 'Data & AI Consulting',
                'size' => '50-100 karyawan',
                'location' => 'Remote / Jakarta',
                'description' => 'Konsultan data analytics dan AI yang membantu perusahaan memanfaatkan data untuk keputusan strategis.',
                'collaboration_types' => ['Research', 'Internship', 'Curriculum Development', 'Certification'],
                'active_opportunities' => 1,
                'website' => 'https://dataanalyticspro.id',
                'contact_email' => 'partnership@dataanalyticspro.id',
                'verified' => true,
                'benefits' => [],
                'requirements' => []
            ],
        ];
    }

    public function getPartnersData()
    {
        $partners = $this->getMockPartners();
        
        $industries = collect($partners)->pluck('industry')->unique()->toArray();
        $locations = collect($partners)->pluck('location')->unique()->toArray();

        return compact('partners', 'industries', 'locations');
    }

    public function getPartnerDetail($id)
    {
        $partners = collect($this->getMockPartners());
        return $partners->firstWhere('id', $id);
    }
}
