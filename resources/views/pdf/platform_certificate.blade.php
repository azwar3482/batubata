<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Apresiasi - {{ $progress->user->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alex+Brush&family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
        
        @page {
            size: 842pt 595pt;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            font-family: 'Montserrat', sans-serif;
            color: #334155;
            width: 842pt;
            height: 595pt;
            margin: 0;
            padding: 0;
        }
        
        .page {
            width: 842pt;
            height: 595pt;
            background-color: #1e293b;
            padding: 24pt;
        }
        .white-area {
            width: 794pt;
            height: 547pt;
            background-color: #ffffff;
            position: relative;
        }
        .gold-frame {
            position: absolute;
            top: 4pt;
            left: 4pt;
            right: 4pt;
            bottom: 4pt;
            border: 3px double #d4af37;
            background-color: #ffffff;
            padding: 14pt 28pt 10pt 28pt;
        }
        
        .corner-tl { position: absolute; top: 4pt; left: 4pt; }
        .corner-tr { position: absolute; top: 4pt; right: 4pt; }
        .corner-bl { position: absolute; bottom: 4pt; left: 4pt; }
        .corner-br { position: absolute; bottom: 4pt; right: 4pt; }
        
        .header-logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 18pt;
            font-weight: 800;
            letter-spacing: 4pt;
            color: #1e293b;
            margin-bottom: 4pt;
        }
        .header-title {
            font-family: 'Playfair Display', serif;
            font-size: 34pt;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: 1.5pt;
            margin-bottom: 3pt;
        }
        .header-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 2pt;
            color: #d4af37;
            text-transform: uppercase;
        }
        .divider {
            width: 60pt;
            height: 1.5px;
            background-color: #d4af37;
            margin: 5pt auto 0 auto;
        }
        
        .recipient-label {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #64748b;
            font-size: 12pt;
            margin-bottom: 4pt;
        }
        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 26pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            display: inline-block;
            padding: 0 20pt 2pt 20pt;
            margin-bottom: 5pt;
        }
        .recipient-desc {
            font-family: 'Montserrat', sans-serif;
            font-size: 9pt;
            color: #64748b;
        }
        
        .course-title {
            font-family: 'Playfair Display', serif;
            font-size: 22pt;
            font-weight: bold;
            color: #1e1b4b;
            margin-bottom: 3pt;
        }
        .course-meta {
            font-family: 'Montserrat', sans-serif;
            font-size: 10pt;
            color: #475569;
        }
        
        .sigs {
            width: 100%;
            border-collapse: collapse;
        }
        .sigs td {
            width: 25%;
            text-align: center;
            vertical-align: bottom;
        }
        
        .photo-box {
            width: 56pt;
            height: 78pt;
            border: 1.5px solid #d4af37;
            padding: 1.5px;
            background-color: #ffffff;
            margin: 0 auto;
        }
        .photo-img {
            width: 100%;
            height: 100%;
        }
        .photo-placeholder {
            width: 100%;
            height: 100%;
            background-color: #f8fafc;
            text-align: center;
            padding-top: 18pt;
        }
        .photo-placeholder svg {
            display: block;
            margin: 0 auto 2pt auto;
        }
        .photo-placeholder-text {
            font-size: 6pt;
            font-weight: bold;
            color: #94a3b8;
            letter-spacing: 0.5pt;
            text-transform: uppercase;
        }
        .photo-label {
            font-family: 'Montserrat', sans-serif;
            font-size: 7pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            margin-top: 4pt;
        }
        
        .sig-name {
            font-family: 'Alex Brush', cursive;
            font-size: 28pt;
            color: #3730a3;
            line-height: 1;
            margin-bottom: 4pt;
        }
        .sig-line {
            width: 100pt;
            height: 1px;
            background-color: #cbd5e1;
            margin: 0 auto 3pt auto;
        }
        .sig-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 9pt;
            font-weight: bold;
            color: #1e293b;
        }
        .sig-org {
            font-family: 'Montserrat', sans-serif;
            font-size: 7.5pt;
            color: #64748b;
        }
        
        .seal-wrap {
            position: relative;
            width: 66pt;
            height: 66pt;
            margin: 0 auto;
        }
        .seal-text {
            position: absolute;
            top: 22pt;
            left: 0;
            width: 100%;
            text-align: center;
            color: #c5a028;
            line-height: 1.2;
        }
        .seal-text-main {
            font-size: 5.5pt;
            font-weight: bold;
            letter-spacing: 1pt;
        }
        .seal-text-seal {
            font-size: 6.5pt;
            font-weight: bold;
            letter-spacing: 2pt;
        }
        .seal-text-sub {
            font-size: 5pt;
            font-weight: bold;
            letter-spacing: 1pt;
        }
        
        .bottom-bar {
            width: 100%;
            border-top: 1px solid #f1f5f9;
            padding-top: 5pt;
            margin-top: 6pt;
        }
        .bottom-table {
            width: 100%;
            border-collapse: collapse;
        }
        .bottom-table td {
            vertical-align: middle;
        }
        .bottom-date {
            font-family: monospace;
            font-size: 8pt;
            color: #94a3b8;
        }
        .bottom-code-text {
            font-family: 'Montserrat', sans-serif;
            font-size: 6.5pt;
            font-weight: bold;
            color: #64748b;
            letter-spacing: 0.75pt;
        }
        .bottom-code-id {
            font-family: monospace;
            font-size: 8pt;
            color: #94a3b8;
            margin-top: 1pt;
        }
        .qr-box {
            width: 34pt;
            height: 34pt;
            border: 1px solid #d4af37;
            padding: 1.5px;
            background-color: #ffffff;
        }
        .qr-box img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="white-area">
            <div class="gold-frame">
                <!-- Corner Decorations -->
                <div class="corner-tl">
                    <svg width="28" height="28" fill="#d4af37" opacity="0.6" viewBox="0 0 24 24">
                        <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                    </svg>
                </div>
                <div class="corner-tr">
                    <svg width="28" height="28" fill="#d4af37" opacity="0.6" viewBox="0 0 24 24">
                        <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                    </svg>
                </div>
                <div class="corner-bl">
                    <svg width="28" height="28" fill="#d4af37" opacity="0.6" viewBox="0 0 24 24">
                        <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                    </svg>
                </div>
                <div class="corner-br">
                    <svg width="28" height="28" fill="#d4af37" opacity="0.6" viewBox="0 0 24 24">
                        <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                    </svg>
                </div>
                
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 8pt;">
                    <div class="header-logo">BATUBATA</div>
                    <div class="header-title">SERTIFIKAT APRESIASI</div>
                    <div class="header-subtitle">Certificate of Appreciation</div>
                    <div class="divider"></div>
                </div>
                
                <!-- Recipient -->
                <div style="text-align: center; margin-bottom: 8pt;">
                    <div class="recipient-label">Sertifikat ini diberikan kepada:</div>
                    <div class="recipient-name">{{ $progress->user->name }}</div>
                    <div class="recipient-desc">
                        Atas partisipasi aktif dan keberhasilan menyelesaikan program pembelajaran mandiri:
                    </div>
                </div>
                
                <!-- Course Details -->
                <div style="text-align: center; margin-bottom: 10pt;">
                    <div class="course-title">{{ $progress->course->title }}</div>
                    <div class="course-meta">
                        Platform Pembelajaran: <strong>{{ $progress->course->platform }}</strong> &middot; Status: <strong>Selesai (100% Progres)</strong>
                    </div>
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
                
                <!-- Signatures -->
                <table class="sigs">
                    <tr>
                        <td>
                            <div class="photo-box">
                                @if($photoPath)
                                    <img src="{{ $photoPath }}" class="photo-img">
                                @else
                                    <div class="photo-placeholder">
                                        <svg width="20" height="20" fill="#cbd5e1" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                        <div class="photo-placeholder-text">FOTO 3X4</div>
                                    </div>
                                @endif
                            </div>
                            <div class="photo-label">Penerima</div>
                        </td>
                        <td>
                            <div class="sig-name">Batubata Director</div>
                            <div class="sig-line"></div>
                            <div class="sig-title">Direktur Eksekutif</div>
                            <div class="sig-org">Batubata Academy</div>
                        </td>
                        <td>
                            <div class="seal-wrap">
                                <svg width="100%" height="100%" fill="#d4af37" viewBox="0 0 100 100">
                                    <polygon points="50,5 53,15 63,10 63,21 73,18 70,29 79,29 73,38 80,41 72,48 77,54 68,58 71,67 61,68 62,78 52,76 50,86 48,76 38,78 39,68 29,67 32,58 23,54 28,48 20,41 27,38 21,29 30,29 27,18 37,21 37,10 47,15" />
                                    <circle cx="50" cy="50" r="33" fill="#ffffff" stroke="#d4af37" stroke-width="2" />
                                    <circle cx="50" cy="50" r="28" fill="#d4af37" />
                                    <circle cx="50" cy="50" r="24" fill="#ffffff" />
                                </svg>
                                <div class="seal-text">
                                    <div class="seal-text-main">OFFICIAL</div>
                                    <div class="seal-text-seal">SEAL</div>
                                    <div class="seal-text-sub">BATUBATA</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="sig-name">Tim Akademik</div>
                            <div class="sig-line"></div>
                            <div class="sig-title">Tim Kurikulum</div>
                            <div class="sig-org">Batubata Academy</div>
                        </td>
                    </tr>
                </table>
                
                <!-- Bottom Bar -->
                <div class="bottom-bar">
                    <table class="bottom-table">
                        <tr>
                            <td style="text-align: left; width: 50%;">
                                <span class="bottom-date">Tanggal Penyelesaian: {{ $progress->completed_at ? $progress->completed_at->format('d M Y') : '-' }}</span>
                            </td>
                            <td style="text-align: right; width: 50%;">
                                <table style="border-collapse: collapse; margin-left: auto;">
                                    <tr>
                                        <td style="padding-right: 8pt; text-align: right;">
                                            <div class="bottom-code-text">VERIFIKASI RESMI</div>
                                            <div class="bottom-code-id">ID: {{ $progress->certificate_code }}</div>
                                        </td>
                                        <td>
                                            <div class="qr-box">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($progress->certificate_code) }}">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
