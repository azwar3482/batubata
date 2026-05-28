<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Http\Requests\StoreCollaborationRequest;
use App\Services\CollaborationService;
use Illuminate\Support\Facades\Auth;
class CollaborationController extends Controller
{
    public function create()
    {
        $institution = Auth::user()->institution;

        // Data mitra untuk dropdown
        $partners = [
            ['id' => 1, 'name' => 'Tech Corp Indonesia', 'industry' => 'Software House', 'logo' => 'TC', 'contact_email' => 'partnership@techcorp.id'],
            ['id' => 2, 'name' => 'Digital Innovation Hub', 'industry' => 'Startup Incubator', 'logo' => 'DIH', 'contact_email' => 'collab@dihub.id'],
            ['id' => 3, 'name' => 'FinTech Nusantara', 'industry' => 'Financial Technology', 'logo' => 'FTN', 'contact_email' => 'campus@fintnus.com'],
            ['id' => 4, 'name' => 'Creative Media Group', 'industry' => 'Digital Marketing & Media', 'logo' => 'CMG', 'contact_email' => 'hello@creativemedia.id'],
            ['id' => 5, 'name' => 'Data Analytics Pro', 'industry' => 'Data & AI Consulting', 'logo' => 'DAP', 'contact_email' => 'partnership@dataanalyticspro.id'],
        ];

        $collaborationTypes = [
            'magang' => 'Program Magang / Internship',
            'rekrutmen' => 'Rekrutmen Lulusan',
            'guest_lecture' => 'Guest Lecture / Seminar',
            'project_based' => 'Project Based Learning',
            'curriculum' => 'Review & Pengembangan Kurikulum',
            'research' => 'Kolaborasi Riset',
            'certification' => 'Program Sertifikasi',
            'hackathon' => 'Hackathon / Competition',
            'mentorship' => 'Program Mentorship',
            'other' => 'Lainnya',
        ];

        return view('education.collaboration', compact('institution', 'partners', 'collaborationTypes'));
    }

    public function store(StoreCollaborationRequest $request, CollaborationService $collaborationService)
    {
        $collaborationService->processProposal(
            $request->validated(), 
            $request->file('attachment')
        );

        return redirect()->route('education.collaboration.success')
            ->with('success', 'Proposal kolaborasi berhasil dikirim! Tim kami akan menghubungi Anda dalam 3-5 hari kerja.');
    }

    public function success()
    {
        return view('education.collaboration-success');
    }

    public function history()
    {
        // Riwayat proposal kolaborasi user ini
        $proposals = collect([
            [
                'id' => 1,
                'partner_name' => 'Tech Corp Indonesia',
                'type' => 'Program Magang',
                'status' => 'approved',
                'submitted_at' => now()->subDays(15),
                'response_at' => now()->subDays(10),
            ],
            [
                'id' => 2,
                'partner_name' => 'Digital Innovation Hub',
                'type' => 'Guest Lecture',
                'status' => 'pending',
                'submitted_at' => now()->subDays(3),
                'response_at' => null,
            ],
            [
                'id' => 3,
                'partner_name' => 'FinTech Nusantara',
                'type' => 'Curriculum Review',
                'status' => 'rejected',
                'submitted_at' => now()->subMonths(1),
                'response_at' => now()->subDays(20),
                'rejection_reason' => 'Jadwal tidak sesuai dengan timeline perusahaan',
            ],
        ]);

        return view('education.collaboration-history', compact('proposals'));
    }
}
