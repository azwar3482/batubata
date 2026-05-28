<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik untuk HRD
        // Asumsi job listing terhubung ke company user ini, atau sederhana saja filter by creator jika ada kolom user_id di job_listing
        // Untuk simplifikasi, kita asumsikan HRD bisa melihat semua job yang mereka buat (nanti tambah kolom user_id di job_listing)

        $totalJobs = JobListing::where('user_id', $user->id)->count();

        // Kita butuh relasi jobs di model Company atau User. 
        // Mari tambahkan kolom user_id di tabel job_listings agar mudah tracking siapa yang post.
        // (Akan kita handle di migrasi tambahan bawah)

        $recentJobs = JobListing::where('user_id', $user->id)->latest()->take(5)->get();
        $totalApplicants = 0; // Nanti dihitung dari relasi applications

        // return view('industry.dashboard', compact('totalJobs', 'recentJobs', 'totalApplicants'));
        return view('industry.dashboard', [
            'totalJobs' => \App\Models\JobListing::where('user_id', $user->id)->where('is_active', true)->count(),
            'totalApplicants' => \App\Models\UserJobApplication::whereHas('jobListing', fn($q) => $q->where('user_id', $user->id))->count(),
            'highMatchCandidates' => 12, // Hitung dari logic matching > 80%
            'avgHiringDays' => 14,
            'recentJobs' => \App\Models\JobListing::where('user_id', $user->id)
                ->withCount('applications')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
    public function downloadReport()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RecruitmentReportExport, 'laporan-rekrutmen.xlsx');
    }
}
