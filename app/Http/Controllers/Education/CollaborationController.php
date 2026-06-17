<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\Company;
use App\Models\CollaborationProposal;
use App\Http\Requests\StoreCollaborationRequest;
use App\Services\CollaborationService;
use Illuminate\Support\Facades\Auth;
class CollaborationController extends Controller
{
    public function create()
    {
        $institution = Auth::user()->institution;

        // Data mitra dari database (perusahaan yang sudah terdaftar) - dengan pagination
        $partners = Company::select('id', 'name', 'industry')
            ->withCount('user as employees_count')
            ->paginate(20)
            ->through(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'industry' => $company->industry ?? 'Umum',
                    'logo' => strtoupper(substr($company->name, 0, 2)),
                    'contact_email' => $company->user->email ?? '-',
                ];
            });

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
        // Riwayat proposal kolaborasi user ini dari database
        $proposals = CollaborationProposal::where('user_id', Auth::id())
            ->select('id', 'partner_name', 'title', 'status', 'created_at as submitted_at', 'response_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($proposal) {
                return [
                    'id' => $proposal->id,
                    'partner_name' => $proposal->partner_name,
                    'type' => $proposal->title,
                    'status' => $proposal->status,
                    'submitted_at' => $proposal->submitted_at,
                    'response_at' => $proposal->response_at,
                ];
            });

        return view('education.collaboration-history', compact('proposals'));
    }
}
