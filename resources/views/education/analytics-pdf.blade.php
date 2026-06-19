<!DOCTYPE html>
<html>
<head>
    <title>Laporan Analitik Kompetensi Lulusan</title>
    <style>
        body { font-family: sans-serif; color: #333; font-size: 13px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 22px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 12px; color: #1e40af; border-left: 4px solid #3b82f6; padding-left: 10px; }
        .metrics-grid { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .metrics-grid td { width: 25%; padding: 12px; border: 1px solid #e5e7eb; vertical-align: top; }
        .metric-label { font-size: 11px; color: #6b7280; text-transform: uppercase; }
        .metric-value { font-size: 22px; font-weight: bold; color: #111827; margin-top: 4px; }
        .table-data { width: 100%; border-collapse: collapse; }
        .table-data th { background-color: #f3f4f6; text-align: left; padding: 8px 10px; border: 1px solid #e5e7eb; font-size: 11px; text-transform: uppercase; color: #6b7280; }
        .table-data td { padding: 8px 10px; border: 1px solid #e5e7eb; }
        .priority-tinggi { background-color: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .priority-sedang { background-color: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .priority-rendah { background-color: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; padding: 10px 0; border-top: 1px solid #e5e7eb; }
        .chart-placeholder { padding: 15px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 15px; }
        .bar { display: inline-block; height: 18px; background: #3b82f6; border-radius: 3px; margin-right: 8px; vertical-align: middle; }
        .bar-red { background: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KOMPASKARIR INDONESIA</h1>
        <p>Laporan Analitik Kompetensi Lulusan</p>
        <p style="font-size: 12px;">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        <table class="metrics-grid">
            <tr>
                <td>
                    <div class="metric-label">Total Lulusan Terdaftar</div>
                    <div class="metric-value">{{ number_format($totalGraduates) }}</div>
                </td>
                <td>
                    <div class="metric-label">Rata-rata Skill Gap</div>
                    <div class="metric-value">{{ $avgSkillGap }}%</div>
                </td>
                <td>
                    <div class="metric-label">Rate Penempatan Kerja</div>
                    <div class="metric-value">{{ $jobPlacementRate }}%</div>
                </td>
                <td>
                    <div class="metric-label">Asesmen Diselesaikan</div>
                    <div class="metric-value">{{ number_format($assessmentsCompleted) }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Skill Gap Rata-rata per Jurusan</div>
        <table class="table-data">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 35%">Jurusan</th>
                    <th style="width: 15%">Skill Gap</th>
                    <th style="width: 45%">Visualisasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurusanData['labels'] as $i => $jurusan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $jurusan }}</td>
                    <td><strong>{{ $jurusanData['data'][$i] }}%</strong></td>
                    <td><span class="bar" style="width: {{ $jurusanData['data'][$i] * 2 }}px;"></span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Top 5 Kompetensi dengan Gap Tertinggi</div>
        <table class="table-data">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 35%">Kompetensi</th>
                    <th style="width: 15%">Gap</th>
                    <th style="width: 45%">Visualisasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($competencyData['labels'] as $i => $comp)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $comp }}</td>
                    <td><strong>{{ $competencyData['data'][$i] }}%</strong></td>
                    <td><span class="bar bar-red" style="width: {{ $competencyData['data'][$i] * 2 }}px;"></span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Rekomendasi Penyesuaian Kurikulum</div>
        <table class="table-data">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 20%">Kompetensi</th>
                    <th style="width: 12%">Gap</th>
                    <th style="width: 43%">Rekomendasi</th>
                    <th style="width: 12%">Prioritas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recommendations as $rec)
                <tr>
                    <td>{{ $rec['no'] }}</td>
                    <td>{{ $rec['competency'] }}</td>
                    <td>{{ $rec['gap'] }}</td>
                    <td>{{ $rec['recommendation'] }}</td>
                    <td>
                        @if($rec['priority'] === 'Tinggi')
                            <span class="priority-tinggi">{{ $rec['priority'] }}</span>
                        @elseif($rec['priority'] === 'Sedang')
                            <span class="priority-sedang">{{ $rec['priority'] }}</span>
                        @else
                            <span class="priority-rendah">{{ $rec['priority'] }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem KOMPASKARIR INDONESIA pada {{ now()->format('d F Y H:i:s') }}.
    </div>
</body>
</html>
