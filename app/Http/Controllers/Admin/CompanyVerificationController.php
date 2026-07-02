<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyVerificationController extends Controller
{
    public function index()
    {
        $companies = Company::where('verification_status', '!=', 'unverified')
                            ->orderByRaw("FIELD(verification_status, 'pending', 'verified', 'rejected')")
                            ->orderBy('updated_at', 'desc')
                            ->paginate(15);
        return view('admin.companies.verifications.index', compact('companies'));
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.verifications.show', compact('company'));
    }

    public function approve($id)
    {
        $company = Company::findOrFail($id);
        $company->verification_status = 'verified';
        $company->verified_at = now();
        $company->verified_by = auth()->id();
        $company->rejection_reason = null;
        $company->save();

        return redirect()->route('admin.verifications.index')
                         ->with('success', 'Perusahaan berhasil diverifikasi.');
    }
    public function verifyDocument(Request $request, $id, $documentType)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'reason' => 'required_if:status,rejected|nullable|string|max:255',
        ]);

        $company = Company::findOrFail($id);
        
        $statuses = $company->document_statuses ?? [];
        $statuses[$documentType] = [
            'status' => $request->status,
            'reason' => $request->status === 'rejected' ? $request->reason : null,
        ];
        $company->document_statuses = $statuses;
        $company->save();

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }


    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $company = Company::findOrFail($id);
        $company->verification_status = 'rejected';
        $company->rejection_reason = $request->rejection_reason;
        $company->save();

        return redirect()->route('admin.verifications.index')
                         ->with('success', 'Verifikasi perusahaan ditolak.');
    }

    public function reReview($id)
    {
        $company = Company::findOrFail($id);
        
        // Reset verification status to pending
        $company->verification_status = 'pending';
        $company->verified_at = null;
        $company->verified_by = null;
        $company->rejection_reason = null;
        
        // Reset all document statuses to pending
        $company->document_statuses = [
            'nib' => ['status' => 'pending', 'reason' => null],
            'siup' => ['status' => 'pending', 'reason' => null],
            'npwp' => ['status' => 'pending', 'reason' => null],
            'ktp_director' => ['status' => 'pending', 'reason' => null],
        ];
        
        $company->save();

        return redirect()->route('admin.companies.verifications.show', $company->id)
                         ->with('success', 'Verifikasi ulang telah dimulai. Silakan tinjau kembali semua dokumen.');
    }
}
