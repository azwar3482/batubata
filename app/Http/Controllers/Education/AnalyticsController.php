<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private function getAnalyticsData()
    {
        return [
            'totalGraduates' => 1245,
            'avgSkillGap' => 38.5,
            'jobPlacementRate' => 72,
            'assessmentsCompleted' => 892,
            'jurusanData' => [
                'labels' => ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Komunikasi', 'Akuntansi'],
                'data' => [38, 42, 35, 48, 30],
            ],
            'competencyData' => [
                'labels' => ['Data Analysis', 'Digital Marketing', 'Project Management', 'Cloud Computing', 'Cybersecurity'],
                'data' => [52, 45, 38, 35, 32],
            ],
            'recommendations' => [
                ['no' => 1, 'competency' => 'Data Analysis', 'gap' => '52%', 'recommendation' => 'Tambah mata kuliah praktis Data Analytics', 'priority' => 'Tinggi'],
                ['no' => 2, 'competency' => 'Digital Marketing', 'gap' => '45%', 'recommendation' => 'Kolaborasi dengan industri untuk studi kasus', 'priority' => 'Sedang'],
                ['no' => 3, 'competency' => 'Project Management', 'gap' => '38%', 'recommendation' => 'Integrasi metode Agile/Scrum dalam pembelajaran', 'priority' => 'Sedang'],
                ['no' => 4, 'competency' => 'Communication', 'gap' => '25%', 'recommendation' => 'Workshop presentasi dan public speaking', 'priority' => 'Rendah'],
            ],
        ];
    }

    public function exportExcel()
    {
        $data = $this->getAnalyticsData();
        $filename = 'laporan-analitik-kompetensi-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // BOM for UTF-8 Excel compatibility
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($handle, ['LAPORAN ANALITIK KOMPETENSI LULUSAN']);
        fputcsv($handle, ['KOMPASKARIR INDONESIA']);
        fputcsv($handle, ['Tanggal Cetak', now()->format('d F Y H:i')]);
        fputcsv($handle, []);

        fputcsv($handle, ['RINGKASAN STATISTIK']);
        fputcsv($handle, ['Metrik', 'Nilai']);
        fputcsv($handle, ['Total Lulusan Terdaftar', number_format($data['totalGraduates'])]);
        fputcsv($handle, ['Rata-rata Skill Gap', $data['avgSkillGap'] . '%']);
        fputcsv($handle, ['Rate Penempatan Kerja', $data['jobPlacementRate'] . '%']);
        fputcsv($handle, ['Asesmen Diselesaikan', number_format($data['assessmentsCompleted'])]);
        fputcsv($handle, []);

        fputcsv($handle, ['SKILL GAP PER JURUSAN']);
        fputcsv($handle, ['Jurusan', 'Skill Gap (%)']);
        foreach ($data['jurusanData']['labels'] as $i => $jurusan) {
            fputcsv($handle, [$jurusan, $data['jurusanData']['data'][$i] . '%']);
        }
        fputcsv($handle, []);

        fputcsv($handle, ['TOP 5 KOMPETENSI DENGAN GAP TERTINGGI']);
        fputcsv($handle, ['Kompetensi', 'Gap (%)']);
        foreach ($data['competencyData']['labels'] as $i => $comp) {
            fputcsv($handle, [$comp, $data['competencyData']['data'][$i] . '%']);
        }
        fputcsv($handle, []);

        fputcsv($handle, ['REKOMENDASI PENYESUAIAN KURIKULUM']);
        fputcsv($handle, ['No', 'Kompetensi', 'Gap Rata-rata', 'Rekomendasi', 'Prioritas']);
        foreach ($data['recommendations'] as $rec) {
            fputcsv($handle, [$rec['no'], $rec['competency'], $rec['gap'], $rec['recommendation'], $rec['priority']]);
        }

        fclose($handle);
        exit;
    }

    public function exportPdf()
    {
        $data = $this->getAnalyticsData();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('education.analytics-pdf', $data);
        return $pdf->download('laporan-analitik-kompetensi-' . now()->format('Y-m-d') . '.pdf');
    }
}
