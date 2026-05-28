<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\NewJobMatchNotification;
use App\Services\JobMatchingService;


class JobPostingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jobs = JobListing::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('location', 'like', "%{$search}%")
                             ->orWhere('company_name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('industry.jobs.index', compact('jobs', 'search'));
    }

    public function create()
    {
        $defaultWeight = \App\Models\CompanyDocumentWeight::default()->first();
        return view('industry.jobs.create', compact('defaultWeight'));
    }

    public function store(Request $request, JobMatchingService $matchingService)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string',
            'work_type' => 'required|in:remote,hybrid,onsite',
            'description' => 'required|string',
            'required_skills' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'weight_option' => 'required|in:default,custom',
            'cv_weight' => 'required_if:weight_option,custom|nullable|numeric|min:0|max:100',
            'ijazah_weight' => 'required_if:weight_option,custom|nullable|numeric|min:0|max:100',
            'transkrip_weight' => 'required_if:weight_option,custom|nullable|numeric|min:0|max:100',
            'sertifikat_weight' => 'required_if:weight_option,custom|nullable|numeric|min:0|max:100',
            'portofolio_weight' => 'required_if:weight_option,custom|nullable|numeric|min:0|max:100',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'expires_date' => 'required|date|after:today',
            'experience_level' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::in(array_merge(
                    array_map(fn($i) => "$i bulan", range(0, 11)),
                    array_map(fn($i) => "$i tahun", range(1, 5)),
                    ['Lebih dari 5 tahun']
                ))
            ],
        ]);

        $useCustomWeight = $request->weight_option === 'custom';
        if ($useCustomWeight) {
            $total = $request->cv_weight + $request->ijazah_weight + $request->transkrip_weight + $request->sertifikat_weight + $request->portofolio_weight;
            if (abs($total - 100) > 0.01) {
                return back()->withInput()->withErrors(['weight_option' => "Total bobot kustom harus 100%. Saat ini total: {$total}%"]);
            }
        }

        $skillsArray = array_map('trim', explode(',', $request->required_skills));

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('job_banners', 'public');
        }

        $job = JobListing::create([
            'user_id' => Auth::id(),
            'external_id' => 'INT-' . uniqid(),
            'source_platform' => 'Internal',
            'title' => $request->title,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'work_type' => $request->work_type,
            'experience_level' => $request->experience_level,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'experience_required' => $request->experience_required ?? 'Fresh Graduate',
            'description' => $request->description,
            'required_skills' => $skillsArray,
            'application_url' => '#',
            'posted_date' => now(),
            'expires_date' => $request->expires_date,
            'is_active' => true,
            'use_custom_weight' => $useCustomWeight,
            'cv_weight' => $useCustomWeight ? $request->cv_weight : null,
            'ijazah_weight' => $useCustomWeight ? $request->ijazah_weight : null,
            'transkrip_weight' => $useCustomWeight ? $request->transkrip_weight : null,
            'sertifikat_weight' => $useCustomWeight ? $request->sertifikat_weight : null,
            'portofolio_weight' => $useCustomWeight ? $request->portofolio_weight : null,
            'banner_image' => $bannerPath,
        ]);

        // Kirim notifikasi ke job seeker yang match
        $seekers = User::where('role', 'job_seeker')->get();
        
        foreach ($seekers as $seeker) {
            try {
                $matchScore = $matchingService->calculateMatch($seeker, $job);
                if ($matchScore >= 70) {
                    $seeker->notify(new NewJobMatchNotification($job, $matchScore));
                }
            } catch (\Exception $e) {
                // log error if needed
            }
        }

        return redirect()->route('industry.dashboard')->with('success', 'Lowongan berhasil diposting dengan pengaturan bobot AI!');
    }

    public function show(Request $request, $id)
    {
        $job = JobListing::where('user_id', Auth::id())->findOrFail($id);
        
        $status = $request->query('status', 'all');
        
        $query = $job->applications()->with('user');
        
        if ($status !== 'all' && in_array($status, ['applied', 'reviewed', 'interviewed', 'offered', 'rejected'])) {
            $query->where('status', $status);
        }
        
        $applicants = $query->orderBy('matching_percentage', 'desc')->get();
        
        // Hitung statistik counter untuk tab filter
        $stats = $job->applications()
            ->selectRaw("status, count(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $counts = [
            'all' => $job->applications()->count(),
            'applied' => $stats['applied'] ?? 0,
            'reviewed' => $stats['reviewed'] ?? 0,
            'interviewed' => $stats['interviewed'] ?? 0,
            'offered' => $stats['offered'] ?? 0,
            'rejected' => $stats['rejected'] ?? 0,
        ];
        
        return view('industry.jobs.show', compact('job', 'applicants', 'status', 'counts'));
    }

    public function edit($id)
    {
        $job = JobListing::where('user_id', Auth::id())->findOrFail($id);
        return view('industry.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = JobListing::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string',
            'work_type' => 'required|in:remote,hybrid,onsite',
            'description' => 'required|string',
            'required_skills' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'is_active' => 'required|boolean',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'expires_date' => 'required|date',
            'experience_level' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::in(array_merge(
                    array_map(fn($i) => "$i bulan", range(0, 11)),
                    array_map(fn($i) => "$i tahun", range(1, 5)),
                    ['Lebih dari 5 tahun']
                ))
            ],
        ]);

        $skillsArray = array_map('trim', explode(',', $request->required_skills));

        $bannerPath = $job->banner_image;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('job_banners', 'public');
        }

        $job->update([
            'title' => $request->title,
            'location' => $request->location,
            'work_type' => $request->work_type,
            'experience_level' => $request->experience_level,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'description' => $request->description,
            'required_skills' => $skillsArray,
            'is_active' => $request->is_active,
            'expires_date' => $request->expires_date,
            'banner_image' => $bannerPath,
        ]);

        return redirect()->route('industry.jobs.index')->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $job = JobListing::where('user_id', Auth::id())->findOrFail($id);
        
        $expires = \Carbon\Carbon::parse($job->expires_date ?? now()->addDays(30));
        $isExpired = $expires->isPast() || !$job->is_active;

        if (!$isExpired) {
            return redirect()->back()->with('error', 'Hanya lowongan yang sudah berakhir atau tidak aktif yang dapat dihapus.');
        }

        $job->delete();

        return redirect()->route('industry.jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    public function downloadReport($id)
    {
        $job = JobListing::where('user_id', Auth::id())->findOrFail($id);
        $applicants = $job->applications()->with('user')->orderBy('matching_percentage', 'desc')->get();
        
        $fileName = 'laporan_pelamar_' . Str::slug($job->title) . '_' . date('Ymd') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($job, $applicants) {
            $file = fopen('php://output', 'w');
            
            // Job Info
            fputcsv($file, ['INFO LOWONGAN']);
            fputcsv($file, ['ID', $job->id]);
            fputcsv($file, ['Posisi', $job->title]);
            fputcsv($file, ['Tipe Pekerjaan', $job->work_type]);
            fputcsv($file, ['Lokasi', $job->location]);
            fputcsv($file, ['Pengalaman', $job->experience_level]);
            fputcsv($file, ['Status', $job->is_active ? 'Aktif' : 'Non-aktif']);
            fputcsv($file, ['Total Pelamar', $applicants->count()]);
            
            fputcsv($file, []); // baris kosong sebagai pemisah
            
            fputcsv($file, ['DAFTAR PELAMAR']);
            fputcsv($file, ['No', 'Nama Pelamar', 'Email', 'Kecocokan (%)', 'Status', 'Tanggal Melamar', 'Catatan/Pesan']);
            
            $no = 1;
            foreach ($applicants as $app) {
                fputcsv($file, [
                    $no++,
                    $app->user->name ?? 'Unknown',
                    $app->user->email ?? '-',
                    $app->matching_percentage ?? 0,
                    ucfirst($app->status),
                    $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->format('Y-m-d H:i') : '-',
                    $app->notes ?? '-'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}