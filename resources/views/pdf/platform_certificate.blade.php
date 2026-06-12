<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Apresiasi - {{ $progress->user->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #1e293b; /* Slate 800 frame */
        }
        .inner {
            border: 4px double #d4af37; /* Gold border */
            height: 94%;
            background-color: #fcfdfd;
            padding: 40px;
            box-sizing: border-box;
            text-align: center;
            position: relative;
        }
        .header {
            margin-top: 10px;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #1e293b;
        }
        .title {
            font-size: 32px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 10px;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 11px;
            color: #d4af37;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 25px;
        }
        .divider {
            width: 80px;
            height: 2px;
            background-color: #d4af37;
            margin: 0 auto 30px auto;
        }
        .presented-to {
            font-style: italic;
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .name {
            font-size: 34px;
            font-weight: bold;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .description {
            font-size: 13px;
            color: #4b5563;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .course-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 15px 0 10px 0;
        }
        .class-meta {
            font-size: 12px;
            color: #4b5563;
            margin-bottom: 30px;
        }
        .signatures-table {
            width: 100%;
            margin-top: 40px;
            border: none;
        }
        .signatures-table td {
            border: none;
            text-align: center;
            vertical-align: bottom;
            width: 25%;
        }
        .sig-name {
            font-family: 'Times New Roman', serif;
            font-style: italic;
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .sig-line {
            width: 140px;
            height: 1px;
            background-color: #ccc;
            margin: 5px auto;
        }
        .sig-label {
            font-size: 11px;
            color: #333;
            font-weight: bold;
        }
        .sig-sublabel {
            font-size: 9px;
            color: #666;
        }
        .footer-table {
            width: 100%;
            position: absolute;
            bottom: 25px;
            left: 40px;
            right: 40px;
            border: none;
        }
        .footer-table td {
            border: none;
            font-family: monospace;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="inner">
            <div class="header">
                <div class="logo">BATUBATA</div>
                <div class="title">SERTIFIKAT APRESIASI</div>
                <div class="subtitle">CERTIFICATE OF APPRECIATION</div>
                <div class="divider"></div>
            </div>

            <div class="presented-to">Sertifikat ini diberikan kepada:</div>
            <div class="name">{{ $progress->user->name }}</div>
            
            <div class="description">
                Atas partisipasi aktif dan keberhasilan menyelesaikan program pembelajaran mandiri:
            </div>
            <div class="course-title">{{ $progress->course->title }}</div>
            <div class="class-meta">
                Platform Pembelajaran: <strong>{{ $progress->course->platform }}</strong> &middot; Status: <strong>Selesai (100% Progres)</strong>
            </div>

            @php
                $photoDoc = $progress->user->documents->where('document_type', 'photo')->first();
                $photoPath = null;
                if ($photoDoc) {
                    $photoPath = storage_path('app/public/' . $photoDoc->file_path);
                    if (!file_exists($photoPath)) {
                        $photoPath = null;
                    }
                }
            @endphp

            <table class="signatures-table">
                <tr>
                    <!-- Student Photo -->
                    <td>
                        <div style="text-align: center; margin: 0 auto; width: 75px;">
                            @if($photoPath)
                                <img src="{{ $photoPath }}" style="width: 75px; height: 100px; object-fit: cover; border: 2px double #d4af37; padding: 2px; background-color: #ffffff;">
                            @else
                                <div style="width: 75px; height: 100px; border: 2px double #d4af37; background-color: #f3f4f6; margin: 0 auto; box-sizing: border-box; text-align: center; color: #9ca3af; padding-top: 30px;">
                                    <div style="font-size: 8px; font-weight: bold; letter-spacing: 0.5px; font-family: sans-serif;">FOTO</div>
                                    <div style="font-size: 8px; font-weight: bold; letter-spacing: 0.5px; margin-top: 2px; font-family: sans-serif;">3X4</div>
                                </div>
                            @endif
                            <div style="font-size: 9px; color: #666; font-weight: bold; margin-top: 5px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.5px;">Penerima</div>
                        </div>
                    </td>
                    <td>
                        <div class="sig-name">Batubata Director</div>
                        <div class="sig-line"></div>
                        <div class="sig-label">Direktur Eksekutif</div>
                        <div class="sig-sublabel">Batubata Academy</div>
                    </td>
                    <td>
                        <div style="text-align: center; margin: 0 auto; width: 70px;">
                            <!-- Official seal representation -->
                            <div style="border: 2px solid #d4af37; border-radius: 50%; width: 66px; height: 66px; background-color: #d4af37; padding: 2px; box-sizing: border-box;">
                                <div style="border: 1px solid #ffffff; border-radius: 50%; width: 60px; height: 60px; background-color: #d4af37; color: #ffffff; text-align: center;">
                                    <div style="font-size: 6px; font-weight: bold; margin-top: 15px; letter-spacing: 0.5px;">OFFICIAL</div>
                                    <div style="font-size: 8px; font-weight: bold; margin-top: 1px; letter-spacing: 1px;">SEAL</div>
                                    <div style="font-size: 5px; margin-top: 2px; letter-spacing: 0.5px;">BATUBATA</div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="sig-name">Tim Akademik</div>
                        <div class="sig-line"></div>
                        <div class="sig-label font-sans">Tim Kurikulum</div>
                        <div class="sig-sublabel font-sans">Batubata Academy</div>
                    </td>
                </tr>
            </table>

            <table class="footer-table">
                <tr>
                    <td align="left" style="vertical-align: bottom;">Tanggal Penyelesaian: {{ $progress->completed_at ? $progress->completed_at->format('d M Y') : '-' }}</td>
                    <td align="right" style="vertical-align: bottom;">
                        <table style="border: none; margin-left: auto; width: auto; border-collapse: collapse;">
                            <tr>
                                <td align="right" style="font-family: sans-serif; font-size: 9px; line-height: 1.2; color: #4b5563; padding-right: 8px; border: none; vertical-align: middle; width: auto;">
                                    <div style="font-weight: bold; font-size: 8px; color: #6b7280; letter-spacing: 0.5px;">VERIFIKASI RESMI</div>
                                    <div style="font-family: monospace; font-size: 9px; color: #9ca3af; margin-top: 2px;">ID: {{ $progress->certificate_code }}</div>
                                </td>
                                <td style="border: none; vertical-align: middle; width: 48px; padding: 0;">
                                    <div style="border: 1px solid #d4af37; background-color: #ffffff; padding: 2px; width: 44px; height: 44px;">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($progress->certificate_code) }}" style="width: 44px; height: 44px;">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
