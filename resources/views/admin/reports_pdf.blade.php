<!DOCTYPE html>
<html>
<head>
    <title>Laporan Platform KOMPASKARIR</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; }
        .header h1 { margin: 0; color: #1e3a8a; }
        .header p { margin: 5px 0 0 0; color: #666; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 18px; font-bold; margin-bottom: 15px; color: #1e40af; border-left: 4px solid #3b82f6; padding-left: 10px; }
        .metrics-grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .metrics-grid td { width: 50%; padding: 15px; border: 1px solid #e5e7eb; }
        .metric-label { font-size: 12px; color: #6b7280; text-transform: uppercase; }
        .metric-value { font-size: 24px; font-weight: bold; color: #111827; }
        .metric-growth { font-size: 12px; margin-top: 5px; }
        .growth-up { color: #059669; }
        .growth-down { color: #dc2626; }
        .skills-table { width: 100%; border-collapse: collapse; }
        .skills-table th { background-color: #f3f4f6; text-align: left; padding: 10px; border: 1px solid #e5e7eb; }
        .skills-table td { padding: 10px; border: 1px solid #e5e7eb; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; padding: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KOMPASKARIR</h1>
        <p>Laporan Analitik Platform</p>
        <p style="font-size: 12px;">Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <div class="section">
        <div class="section-title">Metrik Utama</div>
        <table class="metrics-grid">
            <tr>
                <td>
                    <div class="metric-label">Total Pengguna</div>
                    <div class="metric-value">{{ number_format($totalUsers) }}</div>
                    <div class="metric-growth {{ $userGrowth >= 0 ? 'growth-up' : 'growth-down' }}">
                        {{ $userGrowth >= 0 ? '↑' : '↓' }} {{ abs(round($userGrowth, 1)) }}% dari bulan lalu
                    </div>
                </td>
                <td>
                    <div class="metric-label">Total Asesmen</div>
                    <div class="metric-value">{{ number_format($totalAssessments) }}</div>
                    <div class="metric-growth {{ $assessmentGrowth >= 0 ? 'growth-up' : 'growth-down' }}">
                        {{ $assessmentGrowth >= 0 ? '↑' : '↓' }} {{ abs(round($assessmentGrowth, 1)) }}% dari bulan lalu
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="metric-label">Rata-rata Skill Gap</div>
                    <div class="metric-value">{{ number_format($avgSkillGap, 1) }}%</div>
                </td>
                <td>
                    <div class="metric-label">Generated On</div>
                    <div class="metric-value" style="font-size: 16px;">{{ now()->format('d M Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Visualisasi Data</div>
        <div style="margin-bottom: 20px;">
            <p style="font-size: 14px; font-weight: bold; color: #4B5563;">Pertumbuhan Pengguna Baru</p>
            @if($userGrowthChartBase64)
                <img src="{{ $userGrowthChartBase64 }}" style="width: 100%; height: auto; max-height: 250px; border: 1px solid #e5e7eb; border-radius: 8px;">
            @else
                <div style="padding: 20px; text-align: center; border: 1px dashed #ccc;">Grafik tidak tersedia</div>
            @endif
        </div>
        <div>
            <p style="font-size: 14px; font-weight: bold; color: #4B5563;">Distribusi Top Skill</p>
            @if($topSkillsChartBase64)
                <img src="{{ $topSkillsChartBase64 }}" style="width: 100%; height: auto; max-height: 250px; border: 1px solid #e5e7eb; border-radius: 8px;">
            @else
                <div style="padding: 20px; text-align: center; border: 1px dashed #ccc;">Grafik tidak tersedia</div>
            @endif
        </div>
    </div>

    <div class="section">
        <div class="section-title">Top Skills Paling Diminati</div>
        <table class="skills-table">
            <thead>
                <tr>
                    <th>Skill</th>
                    <th>Jumlah Peminat</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $totalSkillCount = collect($topSkills)->sum('count'); @endphp
                @foreach($topSkills as $skill)
                <tr>
                    <td>{{ $skill['name'] }}</td>
                    <td>{{ number_format($skill['count']) }}</td>
                    <td>{{ number_format(($skill['count'] / ($totalSkillCount ?: 1)) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem KOMPASKARIR pada {{ now() }}.
    </div>
</body>
</html>
