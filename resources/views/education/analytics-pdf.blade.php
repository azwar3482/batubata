<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.laporan_analitik_kompetensi_lulusan') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background: white;
            padding: 40px;
        }

        .report-container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header Section */
        .report-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
        }

        .report-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .report-subtitle {
            font-size: 16px;
            color: #6b7280;
            font-weight: 400;
        }

        .report-date {
            margin-top: 15px;
            font-size: 14px;
            color: #9ca3af;
        }

        /* Executive Summary */
        .executive-summary {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 35px;
            border-left: 5px solid #3b82f6;
        }

        .executive-summary h2 {
            font-size: 20px;
            color: #1e40af;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .executive-summary p {
            color: #374151;
            font-size: 15px;
            line-height: 1.7;
        }

        /* Key Statistics */
        .key-statistics {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 25px;
            border: 1px solid #e5e7eb;
        }

        .stat-card h3 {
            font-size: 13px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
        }

        .stat-card .change {
            font-size: 13px;
            margin-top: 5px;
        }

        .stat-card .change.positive {
            color: #059669;
        }

        .stat-card .change.negative {
            color: #dc2626;
        }

        /* Section Styling */
        .section {
            margin-bottom: 35px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .data-table th {
            background: #f3f4f6;
            padding: 12px 15px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }

        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .data-table tr:hover td {
            background: #fafafa;
        }

        /* Priority Badges */
        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .priority-tinggi {
            background: #fef2f2;
            color: #dc2626;
        }

        .priority-sedang {
            background: #fffbeb;
            color: #d97706;
        }

        .priority-rendah {
            background: #f0fdf4;
            color: #16a34a;
        }

        /* Competency Card */
        .competency-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #3b82f6;
        }

        .competency-card h4 {
            font-size: 16px;
            color: #111827;
            margin-bottom: 10px;
        }

        .competency-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .competency-details .detail-item {
            text-align: center;
        }

        .competency-details .detail-label {
            font-size: 12px;
            color: #6b7280;
            display: block;
        }

        .competency-details .detail-value {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        /* Recommendations */
        .recommendation-box {
            background: #f0fdf4;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #22c55e;
        }

        .recommendation-box h4 {
            color: #166534;
            margin-bottom: 8px;
        }

        .recommendation-box p {
            color: #166534;
            font-size: 14px;
        }

        /* Chart Placeholder */
        .chart-placeholder {
            background: #f9fafb;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            border: 2px dashed #e5e7eb;
            margin-bottom: 25px;
        }

        .chart-placeholder p {
            color: #6b7280;
            font-size: 14px;
        }

        /* Footer */
        .report-footer {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }

        /* Page Break Control */
        .page-break {
            page-break-before: always;
        }

        /* Responsive for Print */
        @media print {
            body {
                padding: 20px;
            }

            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="report-header">
            <h1 class="report-title">{{ __('messages.laporan_analitik_kompetensi_lulusan') }}</h1>
            <p class="report-subtitle">{{ __('messages.dashboard_monitoring_analisis_kompetensi') }}</p>
            <p class="report-date">{{ __('messages.dicetak_tanggal') }}: {{ now()->format('d M Y') }} | {{ __('messages.periode') }}: {{ __('messages.semester_genap_2024_2025') }}</p>
        </div>

        <!-- Executive Summary -->
        <div class="executive-summary">
            <h2>📋 {{ __('messages.ringkasan_eksekutif') }}</h2>
            <p>
                {!! __('messages.laporan_ringkasan_analitik') !!}
            </p>
        </div>

        <!-- Key Statistics -->
        <div class="section">
            <h2 class="section-title">📊 {{ __('messages.statistik_kunci') }}</h2>
            <div class="key-statistics">
                <div class="stat-card">
                    <h3>{{ __('messages.total_dasar_sampel') }}</h3>
                    <div class="value">1,245</div>
                    <div class="change positive">↑ 15% {{ __('messages.dari_semester_sebelumnya') }}</div>
                </div>
                <div class="stat-card">
                    <h3>{{ __('messages.persentase_pencapaian_kompetensi') }}</h3>
                    <div class="value">68.5%</div>
                    <div class="change positive">↑ 5% {{ __('messages.penilaian_positif') }}</div>
                </div>
                <div class="stat-card">
                    <h3>{{ __('messages.skill_gap_rata_rata') }}</h3>
                    <div class="value">31.5%</div>
                    <div class="change positive">↓ 5% {{ __('messages.penurunan_gap') }}</div>
                </div>
                <div class="stat-card">
                    <h3>{{ __('messages.kepuasan_mitra_industri') }}</h3>
                    <div class="value">4.2/5</div>
                    <div class="change positive">↑ 0.3 {{ __('messages.poin_dari_semester_lalu') }}</div>
                </div>
            </div>
        </div>

        <!-- Skill Gap Analysis by Department -->
        <div class="section">
            <h2 class="section-title">📈 {{ __('messages.analisis_skill_gap_per_jurusan') }}</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.nama_jurusan') }}</th>
                        <th>{{ __('messages.jumlah_lulusan') }}</th>
                        <th>{{ __('messages.skill_gap_rata_rata') }}</th>
                        <th>{{ __('messages.kompetensi_paling_lemah') }}</th>
                        <th>{{ __('messages.tren') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Teknik Informatika</td>
                        <td>312</td>
                        <td>38%</td>
                        <td>Cloud Computing</td>
                        <td style="color: #059669;">↑ Membaik</td>
                    </tr>
                    <tr>
                        <td>Sistem Informasi</td>
                        <td>287</td>
                        <td>42%</td>
                        <td>Data Analysis</td>
                        <td style="color: #dc2626;">↓ Menurun</td>
                    </tr>
                    <tr>
                        <td>Manajemen</td>
                        <td>256</td>
                        <td>35%</td>
                        <td>Digital Marketing</td>
                        <td style="color: #059669;">↑ Membaik</td>
                    </tr>
                    <tr>
                        <td>Komunikasi</td>
                        <td>218</td>
                        <td>48%</td>
                        <td>Project Management</td>
                        <td style="color: #d97706;">→ Stabil</td>
                    </tr>
                    <tr>
                        <td>Akuntansi</td>
                        <td>172</td>
                        <td>30%</td>
                        <td>Financial Analytics</td>
                        <td style="color: #059669;">↑ Membaik</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Top 5 Competency Gaps -->
        <div class="section">
            <h2 class="section-title">🔴 {{ __('messages.top_5_kompetensi_gap_tertinggi') }}</h2>

            <div class="competency-card">
                <h4>1. Data Analysis & Interpretation</h4>
                <div class="competency-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_industri') }}</span>
                        <span class="detail-value">85%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_lulusan') }}</span>
                        <span class="detail-value">48%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.gap') }}</span>
                        <span class="detail-value" style="color: #dc2626;">52%</span>
                    </div>
                </div>
            </div>

            <div class="competency-card">
                <h4>2. Digital Marketing Strategy</h4>
                <div class="competency-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_industri') }}</span>
                        <span class="detail-value">80%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_lulusan') }}</span>
                        <span class="detail-value">55%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.gap') }}</span>
                        <span class="detail-value" style="color: #dc2626;">45%</span>
                    </div>
                </div>
            </div>

            <div class="competency-card">
                <h4>3. Project Management (Agile/Scrum)</h4>
                <div class="competency-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_industri') }}</span>
                        <span class="detail-value">82%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_lulusan') }}</span>
                        <span class="detail-value">57%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.gap') }}</span>
                        <span class="detail-value" style="color: #d97706;">38%</span>
                    </div>
                </div>
            </div>

            <div class="competency-card">
                <h4>4. Cloud Computing (AWS/Azure)</h4>
                <div class="competency-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_industri') }}</span>
                        <span class="detail-value">78%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_lulusan') }}</span>
                        <span class="detail-value">48%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.gap') }}</span>
                        <span class="detail-value" style="color: #d97706;">35%</span>
                    </div>
                </div>
            </div>

            <div class="competency-card">
                <h4>5. Cybersecurity Fundamentals</h4>
                <div class="competency-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_industri') }}</span>
                        <span class="detail-value">75%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.skor_lulusan') }}</span>
                        <span class="detail-value">48%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('messages.gap') }}</span>
                        <span class="detail-value" style="color: #d97706;">32%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Curriculum Recommendations -->
        <div class="section page-break">
            <h2 class="section-title">💡 {{ __('messages.rekomendasi_penyesuaian_kurikulum') }}</h2>

            <div class="recommendation-box">
                <h4>{{ __('messages.prioritas_tinggi') }}</h4>
                <p>
                    {!! __('messages.tambah_mata_kuliah_praktis_analytics') !!}
                </p>
            </div>

            <div class="recommendation-box">
                <h4>{{ __('messages.prioritas_sedang') }}</h4>
                <p>
                    {!! __('messages.kolaborasi_mitra_industri_studi_kasus') !!}
                </p>
            </div>

            <div class="recommendation-box">
                <h4>{{ __('messages.prioritas_rendah') }}</h4>
                <p>
                    {!! __('messages.workshop_public_speaking_komunikasi') !!}
                </p>
            </div>
        </div>

        <!-- Placement Rate by Major -->
        <div class="section">
            <h2 class="section-title">💼 {{ __('messages.tingkat_penempatan_per_jurusan') }}</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.nama_jurusan') }}</th>
                        <th>{{ __('messages.persentase_penempatan') }}</th>
                        <th>{{ __('messages.rata_rata_waktu_tunggu') }}</th>
                        <th>{{ __('messages.sektor_industri_teratas') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Teknik Informatika</td>
                        <td>78%</td>
                        <td>2.1 bulan</td>
                        <td>{{ __('messages.teknologi_fintech') }}</td>
                    </tr>
                    <tr>
                        <td>Sistem Informasi</td>
                        <td>72%</td>
                        <td>2.8 bulan</td>
                        <td>{{ __('messages.konsult_it_korporat') }}</td>
                    </tr>
                    <tr>
                        <td>Manajemen</td>
                        <td>68%</td>
                        <td>3.2 bulan</td>
                        <td>{{ __('messages.retail_konsultasi') }}</td>
                    </tr>
                    <tr>
                        <td>Komunikasi</td>
                        <td>65%</td>
                        <td>3.5 bulan</td>
                        <td>{{ __('messages.media_periklanan') }}</td>
                    </tr>
                    <tr>
                        <td>Akuntansi</td>
                        <td>82%</td>
                        <td>1.8 bulan</td>
                        <td>{{ __('messages.akuntansi_perbankan') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Methodology Note -->
        <div class="section">
            <h2 class="section-title">📝 {{ __('messages.catatan_metodologi') }}</h2>
            <div style="background: #f9fafb; padding: 20px; border-radius: 10px; border: 1px solid #e5e7eb;">
                <p style="font-size: 14px; color: #4b5563; margin-bottom: 10px;">
                    {{ __('messages.data_dikumpulkan_melalui') }}
                </p>
                <ul style="font-size: 14px; color: #4b5563; margin-left: 20px;">
                    <li>{{ __('messages.pengisian_kuesioner_online') }}</li>
                    <li>{{ __('messages.wawancara_mitra_industri') }}</li>
                    <li>{{ __('messages.analisis_dokumen_penilaian') }}</li>
                    <li>{{ __('messages.follow_up_penempatan_kerja') }}</li>
                </ul>
                <p style="font-size: 14px; color: #4b5563; margin-top: 15px;">
                    {{ __('messages.margin_error_tiga_persen') }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="report-footer">
            <p>{{ __('messages.dokumen_rahasia_institusional') }}</p>
            <p>{{ __('messages.hak_cipta_perguruan_tinggi') }} © {{ date('Y') }}</p>
            <p style="margin-top: 5px;">{{ __('messages.hanya_keperluan_audit') }}</p>
        </div>
    </div>
</body>
</html>
