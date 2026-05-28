<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    private function getPartners()
    {
        return [
            [
                'id' => 1,
                'name' => 'Tech Corp Indonesia',
                'logo_url' => 'https://ui-avatars.com/api/?name=Tech+Corp&background=0D8ABC&color=fff',
                'industry' => 'Software House',
                'size' => '50-200 karyawan',
                'location' => 'Jakarta Selatan',
                'description' => 'Perusahaan teknologi yang fokus pada pengembangan aplikasi enterprise dan konsultasi digital transformation.',
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
                'logo_url' => 'https://ui-avatars.com/api/?name=Digital+Innovation&background=22C55E&color=fff',
                'industry' => 'Startup Incubator',
                'size' => '20-50 karyawan',
                'location' => 'Bandung',
                'description' => 'Inkubator startup yang mendukung inovasi digital dan pengembangan talenta teknologi muda.',
                'collaboration_types' => ['Magang', 'Mentorship', 'Hackathon', 'Review Kurikulum'],
                'active_opportunities' => 5,
                'website' => 'https://dihub.id',
                'contact_email' => 'collab@dihub.id',
                'verified' => true,
            ],
            [
                'id' => 3,
                'name' => 'FinTech Nusantara',
                'logo_url' => 'https://ui-avatars.com/api/?name=FinTech+Nusantara&background=6366F1&color=fff',
                'industry' => 'Financial Technology',
                'size' => '200-500 karyawan',
                'location' => 'Jakarta Pusat',
                'description' => 'Perusahaan FinTech terkemuka yang mengembangkan solusi pembayaran digital dan financial inclusion.',
                'collaboration_types' => ['Rekrutmen', 'Kolaborasi Riset', 'Magang'],
                'active_opportunities' => 2,
                'website' => 'https://fintnus.com',
                'contact_email' => 'campus@fintnus.com',
                'verified' => true,
            ],
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->getPartners()
        ]);
    }

    public function show($id)
    {
        $partner = collect($this->getPartners())->firstWhere('id', (int)$id);

        if (!$partner) {
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $partner
        ]);
    }
}
