<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitutionVerificationController extends Controller
{
    public function index()
    {
        $institutions = Institution::whereIn('verification_status', ['pending', 'verified', 'rejected'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.institutions.verifications.index', compact('institutions'));
    }

    public function show(Institution $institution)
    {
        return view('admin.institutions.verifications.show', compact('institution'));
    }

    public function verifyDocument(Request $request, Institution $institution, $type)
    {
        $validTypes = ['npsn', 'sk_pendirian', 'ktp_principal'];
        
        if (!in_array($type, $validTypes)) {
            return back()->with('error', 'Jenis dokumen tidak valid.');
        }

        $request->validate([
            'status' => 'required|in:verified,rejected',
            'reason' => 'required_if:status,rejected|nullable|string|max:255',
        ]);

        $statuses = $institution->document_statuses ?? [];
        $statuses[$type] = [
            'status' => $request->status,
            'reason' => $request->status === 'rejected' ? $request->reason : null,
        ];
        
        $institution->document_statuses = $statuses;
        $institution->save();

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    public function approve(Request $request, Institution $institution)
    {
        $statuses = $institution->document_statuses ?? [];
        $requiredTypes = ['npsn', 'sk_pendirian', 'ktp_principal'];
        
        // Ensure all required documents exist and are verified
        foreach ($requiredTypes as $type) {
            if (!isset($statuses[$type]) || $statuses[$type]['status'] !== 'verified') {
                return back()->with('error', 'Semua dokumen harus disetujui terlebih dahulu.');
            }
        }

        $institution->verification_status = 'verified';
        $institution->verified_at = now();
        $institution->verified_by = Auth::id();
        $institution->rejection_reason = null;
        $institution->save();

        if ($institution->user) {
            $institution->user->notify(new \App\Notifications\InstitutionVerificationApproved($institution));
        }

        return redirect()->route('admin.verifications.index')
            ->with('success', 'Institusi berhasil diverifikasi.');
    }

    public function reject(Request $request, Institution $institution)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $institution->verification_status = 'rejected';
        $institution->rejection_reason = $request->reason;
        $institution->save();

        if ($institution->user) {
            $institution->user->notify(new \App\Notifications\InstitutionVerificationRejected($institution));
        }

        return redirect()->route('admin.verifications.index')
            ->with('success', 'Pengajuan verifikasi institusi ditolak.');
    }

    public function reReview($id)
    {
        $institution = Institution::findOrFail($id);
        
        // Reset verification status to pending
        $institution->verification_status = 'pending';
        $institution->verified_at = null;
        $institution->verified_by = null;
        $institution->rejection_reason = null;
        
        // Reset all document statuses to pending
        $institution->document_statuses = [
            'npsn_document' => ['status' => 'pending', 'reason' => null],
            'sk_pendirian_document' => ['status' => 'pending', 'reason' => null],
            'ktp_principal_document' => ['status' => 'pending', 'reason' => null],
        ];
        
        $institution->save();

        return redirect()->route('admin.institutions.verifications.show', $institution->id)
                         ->with('success', 'Verifikasi ulang telah dimulai. Silakan tinjau kembali semua dokumen.');
    }
}
