<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use App\Models\CollaborationProposal;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaborationController extends Controller
{
    public function index()
    {
        $collaborationTypes = [
            ['id' => 'magang', 'name' => 'Program Magang / Internship'],
            ['id' => 'rekrutmen', 'name' => 'Rekrutmen Lulusan'],
            ['id' => 'guest_lecture', 'name' => 'Guest Lecture / Seminar'],
            ['id' => 'project_based', 'name' => 'Project Based Learning'],
            ['id' => 'curriculum', 'name' => 'Review & Pengembangan Kurikulum'],
            ['id' => 'research', 'name' => 'Kolaborasi Riset'],
            ['id' => 'certification', 'name' => 'Program Sertifikasi'],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'types' => $collaborationTypes,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $institution = Institution::where('user_id', $user->id)->first();

        if (!$institution) {
            return response()->json([
                'success' => false,
                'message' => 'Institusi belum terdaftar'
            ], 403);
        }

        $validated = $request->validate([
            'partner_name' => 'required|string|max:255',
            'partner_email' => 'required|email',
            'collaboration_types' => 'required|array',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'expected_outcome' => 'required|string',
            'timeline' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $proposal = CollaborationProposal::create(array_merge($validated, [
            'user_id' => $user->id,
            'institution_id' => $institution->id,
            'status' => 'pending'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Proposal kolaborasi berhasil dikirim',
            'data' => $proposal
        ], 201);
    }

    public function history()
    {
        $proposals = CollaborationProposal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $proposals
        ]);
    }
}
