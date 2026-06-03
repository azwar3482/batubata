<?php

namespace App\Services;

use App\Models\Company;
use App\Models\JobListing;

class PartnerService
{
    public function getPartnersData()
    {
        $partners = Company::withCount('jobListings')
            ->get()
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'logo' => strtoupper(substr($company->name, 0, 2)),
                    'industry' => $company->industry ?? '-',
                    'size' => $company->size ?? '-',
                    'location' => $company->user->address ?? '-',
                    'description' => $company->description ?? 'Perusahaan mitra KOMPASKARIR.',
                    'collaboration_types' => ['Magang', 'Rekrutmen', 'Guest Lecture'],
                    'active_opportunities' => $company->job_listings_count,
                    'website' => $company->website,
                    'contact_email' => $company->user->email ?? '-',
                    'verified' => $company->user->email_verified_at !== null,
                    'benefits' => [],
                    'requirements' => [],
                ];
            });

        $industries = $partners->pluck('industry')->unique()->filter()->values()->toArray();
        $locations = $partners->pluck('location')->unique()->filter()->values()->toArray();

        return compact('partners', 'industries', 'locations');
    }

    public function getPartnerDetail($id)
    {
        $company = Company::with('user')->withCount('jobListings')->find($id);

        if (!$company) {
            return null;
        }

        return [
            'id' => $company->id,
            'name' => $company->name,
            'logo' => strtoupper(substr($company->name, 0, 2)),
            'industry' => $company->industry ?? '-',
            'size' => $company->size ?? '-',
            'location' => $company->user->address ?? '-',
            'description' => $company->description ?? 'Perusahaan mitra KOMPASKARIR.',
            'collaboration_types' => ['Magang', 'Rekrutmen', 'Guest Lecture'],
            'active_opportunities' => $company->job_listings_count,
            'website' => $company->website,
            'contact_email' => $company->user->email ?? '-',
            'verified' => $company->user->email_verified_at !== null,
            'benefits' => [],
            'requirements' => [],
        ];
    }
}
