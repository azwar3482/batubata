<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyDocumentWeight;
use Illuminate\Http\Request;

class DocumentWeightController extends Controller
{
    /**
     * Tampilkan semua konfigurasi bobot dokumen.
     */
    public function index(Request $request)
    {
        $query = CompanyDocumentWeight::with('company')
            ->orderByRaw('company_id IS NULL DESC') // Default di atas
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $weights = $query->get();

        $companies = Company::orderBy('name')->get();

        return view('admin.document-weights.index', compact('weights', 'companies'));
    }

    /**
     * Simpan konfigurasi bobot baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'         => 'nullable|exists:companies,id|unique:company_document_weights,company_id',
            'name'               => 'required|string|max:255',
            'cv_weight'          => 'required|numeric|min:0|max:100',
            'ijazah_weight'      => 'required|numeric|min:0|max:100',
            'transkrip_weight'   => 'required|numeric|min:0|max:100',
            'sertifikat_weight'  => 'required|numeric|min:0|max:100',
            'portofolio_weight'  => 'required|numeric|min:0|max:100',
        ]);

        // Validasi total bobot harus 100
        $total = $validated['cv_weight'] + $validated['ijazah_weight'] + $validated['transkrip_weight']
               + $validated['sertifikat_weight'] + $validated['portofolio_weight'];

        if (abs($total - 100) > 0.01) {
            return back()->withInput()->withErrors([
                'total_weight' => "Total semua bobot harus 100%. Saat ini total: {$total}%"
            ]);
        }

        CompanyDocumentWeight::create($validated);

        return back()->with('success', 'Konfigurasi bobot dokumen berhasil disimpan!');
    }

    /**
     * Perbarui konfigurasi bobot yang sudah ada.
     */
    public function update(Request $request, CompanyDocumentWeight $documentWeight)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'cv_weight'          => 'required|numeric|min:0|max:100',
            'ijazah_weight'      => 'required|numeric|min:0|max:100',
            'transkrip_weight'   => 'required|numeric|min:0|max:100',
            'sertifikat_weight'  => 'required|numeric|min:0|max:100',
            'portofolio_weight'  => 'required|numeric|min:0|max:100',
            'is_active'          => 'boolean',
        ]);

        $total = $validated['cv_weight'] + $validated['ijazah_weight'] + $validated['transkrip_weight']
               + $validated['sertifikat_weight'] + $validated['portofolio_weight'];

        if (abs($total - 100) > 0.01) {
            return back()->withInput()->withErrors([
                'total_weight' => "Total semua bobot harus 100%. Saat ini total: {$total}%"
            ]);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $documentWeight->update($validated);

        return back()->with('success', 'Konfigurasi bobot dokumen berhasil diperbarui!');
    }

    /**
     * Hapus konfigurasi bobot.
     */
    public function destroy(CompanyDocumentWeight $documentWeight)
    {
        // Jangan izinkan menghapus konfigurasi default
        if (is_null($documentWeight->company_id)) {
            return back()->with('error', 'Konfigurasi default tidak dapat dihapus!');
        }

        $documentWeight->delete();

        return back()->with('success', 'Konfigurasi bobot dokumen berhasil dihapus.');
    }
}
