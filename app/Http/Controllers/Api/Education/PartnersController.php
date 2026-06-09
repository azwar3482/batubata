<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Company::with('user')
            ->get()
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'logo_url' => 'https://ui-avatars.com/api/?name=' . urlencode($company->name) . '&background=0D8ABC&color=fff',
                    'industry' => $company->industry ?? 'Umum',
                    'size' => $company->size ?? '-',
                    'location' => $company->user->address ?? '-',
                    'description' => $company->industry ? "Perusahaan di bidang {$company->industry}" : '-',
                    'collaboration_types' => ['Magang', 'Rekrutmen', 'Guest Lecture'],
                    'active_opportunities' => JobListing::where('company_id', $company->id)->where('is_active', true)->count(),
                    'website' => $company->website ?? '-',
                    'contact_email' => $company->user->email ?? '-',
                    'verified' => true,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $partners
        ]);
    }

    public function show($id)
    {
        $company = Company::with('user')->find($id);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak ditemukan'
            ], 404);
        }

        $partner = [
            'id' => $company->id,
            'name' => $company->name,
            'logo_url' => 'https://ui-avatars.com/api/?name=' . urlencode($company->name) . '&background=0D8ABC&color=fff',
            'industry' => $company->industry ?? 'Umum',
            'size' => $company->size ?? '-',
            'location' => $company->user->address ?? '-',
            'description' => $company->industry ? "Perusahaan di bidang {$company->industry}" : '-',
            'collaboration_types' => ['Magang', 'Rekrutmen', 'Guest Lecture'],
            'active_opportunities' => $company->jobListings()->where('is_active', true)->count(),
            'website' => $company->website ?? '-',
            'contact_email' => $company->user->email ?? '-',
            'verified' => true,
        ];

        return response()->json([
            'success' => true,
            'data' => $partner
        ]);
    }
}
