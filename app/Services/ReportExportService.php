<?php

namespace App\Services;

class ReportExportService
{
    public function exportPDF($data)
    {
        $data['userGrowthChartBase64'] = $this->getChartBase64($this->getUserGrowthChartConfig($data));
        $data['topSkillsChartBase64'] = $this->getChartBase64($this->getTopSkillsChartConfig($data));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports_pdf', $data);
        return $pdf->download('laporan-platform-' . now()->format('Y-m-d') . '.pdf');
    }

    public function generatePDFContent($data)
    {
        $data['userGrowthChartBase64'] = $this->getChartBase64($this->getUserGrowthChartConfig($data));
        $data['topSkillsChartBase64'] = $this->getChartBase64($this->getTopSkillsChartConfig($data));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports_pdf', $data);
        return $pdf->output();
    }

    public function exportExcel($data)
    {
        $filename = "laporan-platform-" . now()->format('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['Laporan Platform KOMPASKARIR']);
        fputcsv($handle, ['Periode', $data['startDate'] . ' s/d ' . $data['endDate']]);
        fputcsv($handle, []);
        fputcsv($handle, ['Metrik Utama', 'Nilai']);
        fputcsv($handle, ['Total Pengguna', $data['totalUsers']]);
        fputcsv($handle, ['Total Asesmen', $data['totalAssessments']]);
        fputcsv($handle, ['Rata-rata Skill Gap', number_format($data['avgSkillGap'], 1) . '%']);
        fputcsv($handle, []);
        fputcsv($handle, ['Top Skills', 'Peminat']);
        foreach ($data['topSkills'] as $skill) {
            fputcsv($handle, [$skill['name'], $skill['count']]);
        }
        
        fclose($handle);
        exit;
    }

    private function getUserGrowthChartConfig($data)
    {
        return [
            'type' => 'line',
            'data' => [
                'labels' => $data['monthlyGrowth']['labels'],
                'datasets' => [[
                    'label' => 'Pengguna Baru',
                    'data' => $data['monthlyGrowth']['data'],
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true
                ]]
            ]
        ];
    }

    private function getTopSkillsChartConfig($data)
    {
        return [
            'type' => 'horizontalBar',
            'data' => [
                'labels' => array_column($data['topSkills'], 'name'),
                'datasets' => [[
                    'label' => 'Peminat',
                    'data' => array_column($data['topSkills'], 'count'),
                    'backgroundColor' => 'rgba(147, 51, 234, 0.6)'
                ]]
            ]
        ];
    }

    private function getChartBase64($config)
    {
        $url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($config));
        try {
            $imageContent = file_get_contents($url);
            if ($imageContent) {
                return 'data:image/png;base64,' . base64_encode($imageContent);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Chart Generation Failed: " . $e->getMessage());
        }
        return null;
    }
}
