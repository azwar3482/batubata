<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kompetensi - {{ $user->name }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #2563EB; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #2563EB; }
        .info-box { background: #f3f4f6; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        h2 { color: #1f2937; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #2563EB; color: white; }
        .priority-high { color: #dc2626; font-weight: bold; }
        .priority-medium { color: #d97706; font-weight: bold; }
        .priority-low { color: #059669; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge { padding: 2px 6px; border-radius: 4px; color: white; font-size: 10px; }
        .bg-blue { background-color: #2563EB; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">KOMPASKARIR</div>
        <div>Skill Gap Advisor Platform</div>
    </div>

    <!-- Info Pengguna -->
    <div class="info-box">
        <strong>Nama:</strong> {{ $user->name }}<br>
        <strong>Posisi Target:</strong> {{ $assessment->position->name }}<br>
        <strong>Tanggal Asesmen:</strong> {{ $assessment->assessment_date->format('d F Y') }}<br>
        <strong>Rata-rata Skill Gap:</strong> {{ number_format($assessment->total_gap_percentage, 1) }}%
    </div>

    <!-- Tabel Detail Kompetensi -->
    <h2>1. Analisis Detail Kompetensi</h2>
    <table>
        <thead>
            <tr>
                <th>Kompetensi</th>
                <th>Kategori</th>
                <th>Level Anda</th>
                <th>Target Industri</th>
                <th>Gap (%)</th>
                <th>Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assessment->scores as $score)
            <tr>
                <td>{{ $score->competency->name }}</td>
                <td>{{ ucfirst($score->competency->category) }}</td>
                <td align="center">{{ $score->self_assessed_level }}/5</td>
                <td align="center">{{ $score->competency->min_level_required }}/5</td>
                <td align="center">{{ number_format($score->gap_percentage, 1) }}%</td>
                <td align="center">
                    <span class="priority-{{ $score->priority }}">
                        {{ ucfirst($score->priority) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Rekomendasi Kursus -->
    <h2>2. Rekomendasi Upskilling Prioritas</h2>
    @if($recommendations->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nama Kursus</th>
                    <th>Platform</th>
                    <th>Durasi</th>
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recommendations as $rec)
                <tr>
                    <td>{{ $rec['course']->title }}</td>
                    <td>{{ $rec['course']->platform }}</td>
                    <td>{{ $rec['course']->duration_hours }} Jam</td>
                    <td>{{ $rec['reason'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada rekomendasi spesifik. Kinerja Anda sudah sangat baik!</p>
    @endif

    <!-- Roadmap Singkat -->
    <h2>3. Rencana Aksi (Roadmap)</h2>
    <p>Berdasarkan hasil analisis, berikut adalah fokus utama 3 bulan pertama:</p>
    <ul>
        <li><strong>Bulan 1:</strong> Fokus pada skill dengan prioritas <span class="priority-high">Tinggi</span>.</li>
        <li><strong>Bulan 2:</strong> Pendalaman teknis dan proyek mini.</li>
        <li><strong>Bulan 3:</strong> Penyusunan portofolio dan sertifikasi.</li>
    </ul>

    <!-- Footer & QR Code Placeholder -->
    <div class="footer">
        <p>Laporan ini digenerate otomatis oleh sistem KOMPASKARIR.</p>
        <p>Tanggal Cetak: {{ $generated_at }}</p>
        <p>Verifikasi keaslian laporan di: https://kompskarir.id/verify</p>
        <!-- Bisa tambahkan QR Code generator package nanti -->
    </div>

</body>
</html>