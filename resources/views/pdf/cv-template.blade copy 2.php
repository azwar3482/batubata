<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1F262C;
            background: #f5f5f5;
        }

        .cv-container {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        /* Left Column */
        .cv-left {
            width: 35%;
            background: #1F262C;
            color: white;
        }

        .cv-left-photo {
            width: 100%;
        }

        .cv-left-content {
            padding: 5px 20px 20px 20px;
        }

        .cv-photo {
            width: 100%;
            aspect-ratio: 1/1;
            border-radius: 6px;
            overflow: hidden;
        }

        .cv-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cv-photo-placeholder {
            width: 100%;
            aspect-ratio: 3/4;
            border-radius: 6px;
            background: #3a4a5c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #6b7b8d;
        }

        .cv-left-content {
            padding: 20px 20px 30px 20px;
        }

        .cv-section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #D4A574;
            color: #1F262C;
            border-radius: 4px;
        }

        .cv-left-item {
            margin-bottom: 15px;
        }

        .cv-left-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #8a9aaa;
            margin-bottom: 3px;
        }

        .cv-left-value {
            font-size: 12px;
            color: #fff;
            word-break: break-all;
        }

        .cv-left-value a {
            color: #6db3f2;
            text-decoration: underline;
            word-break: break-all;
        }

        .cv-left-value a:hover {
            color: #9dcbf5;
        }

        /* Right Column */
        .cv-right {
            width: 65%;
            padding: 30px 25px;
        }

        .cv-name {
            font-size: 28px;
            font-weight: 700;
            color: #1F262C;
            margin-bottom: 5px;
        }

        .cv-position {
            font-size: 16px;
            font-style: italic;
            color: #666;
            margin-bottom: 25px;
        }

        .cv-right-section {
            margin-bottom: 25px;
        }

        .cv-right-title {
            font-size: 14px;
            font-weight: 700;
            color: #1F262C;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #D4A574;
            border-radius: 4px;
        }

        .cv-bio {
            font-size: 12px;
            line-height: 1.6;
            color: #444;
        }

        .cv-bio ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 5px 0;
        }

        .cv-bio ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin: 5px 0;
        }

        .cv-bio p {
            margin-bottom: 5px;
        }

        .cv-edu-item,
        .cv-exp-item {
            margin-bottom: 15px;
        }

        .cv-edu-header,
        .cv-exp-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 5px;
        }

        .cv-edu-title,
        .cv-exp-title {
            font-size: 13px;
            font-weight: 700;
            color: #1F262C;
        }

        .cv-edu-year,
        .cv-exp-date {
            font-size: 11px;
            color: #1A4632;
            font-weight: 600;
        }

        .cv-edu-institution,
        .cv-exp-company {
            font-size: 12px;
            color: #555;
            margin-bottom: 5px;
        }

        .cv-exp-desc {
            font-size: 11px;
            line-height: 1.5;
            color: #666;
        }

        .cv-skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .cv-skill-tag {
            background: #f0f0f0;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            color: #333;
        }

        /* PDF specific styles */
        @media print {
            body {
                background: white;
            }

            .cv-container {
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="cv-container">
        <!-- Left Column -->
        <div class="cv-left">
            <!-- Photo -->
            @php $photoDoc = $user->documents()->where('document_type', 'photo')->first(); @endphp
            <div class="cv-left-photo">
                @if($photoDoc)
                <div class="cv-photo">
                    <img src="{{ asset('storage/' . $photoDoc->file_path) }}" alt="Foto {{ $user->name }}">
                </div>
                @else
                <div class="cv-photo-placeholder">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                @endif
            </div>

            <div class="cv-left-content">
                <!-- Data Diri -->
                <div class="cv-section-title">Data Diri</div>

            @if($user->birth_place || $user->birth_date)
            <div class="cv-left-item">
                <div class="cv-left-label">Tempat / Tanggal Lahir</div>
                <div class="cv-left-value">
                    {{ $user->birth_place ?? '-' }}, {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F Y') : '-' }}
                </div>
            </div>
            @endif

            @if($user->gender)
            <div class="cv-left-item">
                <div class="cv-left-label">Jenis Kelamin</div>
                <div class="cv-left-value">{{ $user->gender }}</div>
            </div>
            @endif

            @if($user->marital_status)
            <div class="cv-left-item">
                <div class="cv-left-label">Status</div>
                <div class="cv-left-value">{{ $user->marital_status }}</div>
            </div>
            @endif

            <div class="cv-left-item">
                <div class="cv-left-label">Kewarganegaraan</div>
                <div class="cv-left-value">{{ $user->nationality ?? 'Indonesia' }}</div>
            </div>

            @if($user->address)
            <div class="cv-left-item">
                <div class="cv-left-label">Alamat Domisili</div>
                <div class="cv-left-value">{{ $user->address }}</div>
            </div>
            @endif

            <!-- Kontak -->
            <div class="cv-section-title" style="margin-top: 25px;">Kontak</div>

            @if($user->phone)
            <div class="cv-left-item">
                <div class="cv-left-label">Telepon</div>
                <div class="cv-left-value">{{ $user->phone }}</div>
            </div>
            @endif

            @if($user->email)
            <div class="cv-left-item">
                <div class="cv-left-label">Email</div>
                <div class="cv-left-value">{{ $user->email }}</div>
            </div>
            @endif

            <!-- Sosial Media -->
            <div class="cv-section-title" style="margin-top: 25px;">Sosial Media</div>

            @if($user->linkedin_url)
            <div class="cv-left-item">
                <div class="cv-left-label">LinkedIn</div>
                <div class="cv-left-value">
                    <a href="{{ $user->linkedin_url }}" target="_blank">{{ $user->linkedin_url }}</a>
                </div>
            </div>
            @endif

            @if($user->portfolio_url)
            <div class="cv-left-item">
                <div class="cv-left-label">Portfolio / GitHub</div>
                <div class="cv-left-value">
                    <a href="{{ $user->portfolio_url }}" target="_blank">{{ $user->portfolio_url }}</a>
                </div>
            </div>
            @elseif($user->github_url)
            <div class="cv-left-item">
                <div class="cv-left-label">GitHub</div>
                <div class="cv-left-value">
                    <a href="{{ $user->github_url }}" target="_blank">{{ $user->github_url }}</a>
                </div>
            </div>
            @endif
            </div>
        </div>

        <!-- Right Column -->
        <div class="cv-right">
            <!-- Nama & Posisi -->
            <div class="cv-name">{{ strtoupper($user->name) }}</div>
            <div class="cv-position">
                @php
                    $jobPositions = [];
                    if (is_array($user->expected_jobs)) {
                        foreach ($user->expected_jobs as $job) {
                            if (!empty($job['position'])) {
                                $jobPositions[] = $job['position'];
                            }
                        }
                    }
                @endphp
                {{ count($jobPositions) > 0 ? implode(' / ', $jobPositions) : 'Profesional' }}
            </div>

            <!-- Ringkasan Profesional -->
            @if($user->bio)
            <div class="cv-right-section">
                <div class="cv-right-title">Ringkasan Profesional</div>
                <div class="cv-bio">{!! $user->bio !!}</div>
            </div>
            @endif

            <!-- Pendidikan -->
            @if($user->education_level || $user->institution)
            <div class="cv-right-section">
                <div class="cv-right-title">Pendidikan</div>
                <div class="cv-edu-item">
                    <div class="cv-edu-header">
                        <div class="cv-edu-title">
                            {{ $user->education_level ?? '-' }}{{ $user->major ? ' - ' . $user->major : '' }}
                        </div>
                        @if($user->graduation_year)
                        <div class="cv-edu-year">{{ $user->graduation_year }}</div>
                        @endif
                    </div>
                    @if($user->institution)
                    <div class="cv-edu-institution">{{ $user->institution->name }}</div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Pengalaman Kerja -->
            @if($user->careerHistories && count($user->careerHistories) > 0)
            <div class="cv-right-section">
                <div class="cv-right-title">Pengalaman Kerja</div>
                @foreach($user->careerHistories as $history)
                <div class="cv-exp-item">
                    <div class="cv-exp-header">
                        <div class="cv-exp-title">{{ $history->position }}</div>
                        @if($history->start_date)
                        <div class="cv-exp-date">
                            {{ \Carbon\Carbon::parse($history->start_date)->format('M Y') }}
                            @if($history->end_date)
                            - {{ \Carbon\Carbon::parse($history->end_date)->format('M Y') }}
                            @else
                            - Sekarang
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="cv-exp-company">{{ $history->company_name }}</div>
                    @if($history->description)
                    <div class="cv-exp-desc">{{ strip_tags($history->description) }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Keahlian -->
            @if($user->skills && count($user->skills) > 0)
            <div class="cv-right-section">
                <div class="cv-right-title">Keahlian</div>
                <div class="cv-skills-list">
                    @foreach($user->skills as $skill)
                    <span class="cv-skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @if(!request()->is('*/download*'))
    <div class="no-print" style="position: fixed; bottom: 30px; right: 30px; display: flex; gap: 15px; z-index: 9999;">
        <button onclick="window.print()" style="background-color: #4F46E5; color: white; padding: 12px 20px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 8px; font-family: sans-serif;">
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print
        </button>
        <a href="{{ request()->routeIs('cv.preview') ? route('cv.download') : str_replace('preview', 'download', request()->url()) }}" style="background-color: #059669; color: white; padding: 12px 20px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 8px; font-family: sans-serif;">
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF
        </a>
    </div>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .cv-container { box-shadow: none !important; margin: 0 !important; max-width: none !important; }
        }
    </style>
    @endif
</body>
</html>
