<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportMail;
use App\Services\ReportExportService;
use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;
use Illuminate\Support\Facades\DB;

class SendDashboardReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userEmail;
    protected $startDate;
    protected $endDate;

    public function __construct($userEmail, $startDate, $endDate)
    {
        $this->userEmail = $userEmail;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function handle(ReportExportService $exportService)
    {
        // Pengambilan data diletakkan di dalam Job agar tidak memberatkan request
        $totalUsers = User::count();
        $totalAssessments = UserAssessment::count();
        $avgSkillGap = UserAssessment::avg('total_gap_percentage') ?? 0;
        
        $lastMonthUsers = User::where('created_at', '<', now()->subMonth())->count();
        $userGrowth = $lastMonthUsers > 0 ? (($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 0;
        
        $lastMonthAssessments = UserAssessment::where('created_at', '<', now()->subMonth())->count();
        $assessmentGrowth = $lastMonthAssessments > 0 ? (($totalAssessments - $lastMonthAssessments) / $lastMonthAssessments) * 100 : 0;

        // Top Skills berdasarkan jumlah asesmen kompetensi
        $topSkills = UserCompetencyScore::join('competencies', 'user_competency_scores.competency_id', '=', 'competencies.id')
            ->select('competencies.name', DB::raw('COUNT(*) as count'))
            ->groupBy('competencies.id', 'competencies.name')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->toArray();

        // Pertumbuhan pengguna per bulan (6 bulan terakhir)
        $monthlyGrowthData = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'label' => $date->format('M'),
                'count' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        })->toArray();

        $monthlyGrowth = [
            'labels' => array_column($monthlyGrowthData, 'label'),
            'data' => array_column($monthlyGrowthData, 'count'),
        ];

        $data = [
            'totalUsers' => $totalUsers,
            'totalAssessments' => $totalAssessments,
            'userGrowth' => $userGrowth,
            'assessmentGrowth' => $assessmentGrowth,
            'avgSkillGap' => $avgSkillGap,
            'topSkills' => $topSkills,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'monthlyGrowth' => $monthlyGrowth
        ];

        // Generate PDF melalui service yang sudah dipisah
        $pdfContent = $exportService->generatePDFContent($data);

        // Kirim email
        Mail::to($this->userEmail)->send(new ReportMail($pdfContent, $this->startDate, $this->endDate));
    }
}
