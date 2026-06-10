<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; font-size: 11pt; background: #f1f5f9; }
        .page { max-width: 210mm; margin: 20px auto; padding: 30mm 25mm; background: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }

        /* Header */
        .header { display: flex; align-items: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 3px solid #2563eb; }
        .photo { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #7c3aed); display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; font-weight: bold; margin-right: 20px; flex-shrink: 0; overflow: hidden; }
        .photo img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .header-info { flex: 1; }
        .header-info h1 { font-size: 22pt; color: #1e293b; margin-bottom: 4px; letter-spacing: 1px; }
        .header-info .subtitle { font-size: 11pt; color: #2563eb; font-weight: 600; margin-bottom: 8px; }
        .contact-row { display: flex; flex-wrap: wrap; gap: 15px; font-size: 9pt; color: #64748b; }
        .contact-item { display: flex; align-items: center; gap: 5px; }

        /* Sections */
        .section { margin-bottom: 20px; }
        .section-title { font-size: 12pt; font-weight: bold; color: #2563eb; text-transform: uppercase; letter-spacing: 2px; padding-bottom: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 12px; }

        /* Summary */
        .summary { font-size: 10pt; color: #475569; line-height: 1.8; background: #f8fafc; padding: 12px 15px; border-left: 4px solid #2563eb; border-radius: 0 8px 8px 0; }
        .summary p { margin-bottom: 8px; }
        .summary p:last-child { margin-bottom: 0; }

        /* Skills */
        .skills-grid { display: flex; flex-wrap: wrap; gap: 8px; }
        .skill-tag { padding: 4px 12px; background: #eff6ff; color: #2563eb; border-radius: 20px; font-size: 9pt; font-weight: 600; border: 1px solid #bfdbfe; }
        .skill-tag.primary { background: #2563eb; color: white; border-color: #2563eb; }

        /* Experience & Education */
        .timeline-item { margin-bottom: 15px; padding-left: 15px; border-left: 3px solid #e2e8f0; }
        .timeline-item:last-child { border-left-color: transparent; }
        .timeline-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px; }
        .timeline-title { font-weight: bold; font-size: 11pt; color: #1e293b; }
        .timeline-date { font-size: 9pt; color: #94a3b8; font-weight: 600; white-space: nowrap; }
        .timeline-company { font-size: 10pt; color: #2563eb; font-weight: 600; margin-bottom: 4px; }
        .timeline-desc { font-size: 9.5pt; color: #64748b; line-height: 1.6; }
        .timeline-desc ul { padding-left: 15px; margin-top: 5px; }
        .timeline-desc li { margin-bottom: 3px; }

        /* Languages */
        .languages { display: flex; gap: 20px; flex-wrap: wrap; }
        .language-item { display: flex; align-items: center; gap: 8px; }
        .language-name { font-weight: 600; font-size: 10pt; }
        .language-level { font-size: 9pt; color: #64748b; }
        .dots { display: flex; gap: 3px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: #e2e8f0; }
        .dot.filled { background: #2563eb; }

        /* Two columns */
        .two-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }

        /* Footer */
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; text-align: center; font-size: 8pt; color: #94a3b8; }

        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; background: white; }
            .page { padding: 15mm 20mm; box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>
<div class="page">
    {{-- HEADER --}}
    <div class="header">
        <div class="photo">
            @php $photoDoc = $user->documents()->where('document_type', 'photo')->first(); @endphp
            @if($photoDoc)
                <img src="{{ asset('storage/' . $photoDoc->file_path) }}" alt="Foto">
            @else
                {{ substr($user->name, 0, 2) }}
            @endif
        </div>
        <div class="header-info">
            <h1>{{ strtoupper($user->name) }}</h1>
            <div class="subtitle">{{ $user->target_position ?? 'Profesional' }}</div>
            <div class="contact-row">
                @if($user->email)
                <span class="contact-item">&#9993; {{ $user->email }}</span>
                @endif
                @if($user->phone)
                <span class="contact-item">&#9742; {{ $user->phone }}</span>
                @endif
                @if($user->address)
                <span class="contact-item">&#9906; {{ $user->address }}</span>
                @endif
                @if($user->linkedin_url)
                <span class="contact-item">&#128279; LinkedIn</span>
                @endif
            </div>
        </div>
    </div>

    {{-- RINGKASAN PROFESIONAL --}}
    @if($user->bio)
    <div class="section">
        <div class="section-title">Ringkasan Profesional</div>
        <div class="summary">{!! $user->bio !!}</div>
    </div>
    @endif

    {{-- KEAHLIAN --}}
    @if($user->skills && count($user->skills) > 0)
    <div class="section">
        <div class="section-title">Keahlian</div>
        <div class="skills-grid">
            @foreach($user->skills as $i => $skill)
            <span class="skill-tag {{ $i < 5 ? 'primary' : '' }}">{{ $skill }}</span>
            @endforeach
        </div>
    </div>
    @endif

    <div class="two-cols">
        {{-- PENGALAMAN KERJA --}}
        @if($user->careerHistories && $user->careerHistories->count() > 0)
        <div class="section">
            <div class="section-title">Pengalaman Kerja</div>
            @foreach($user->careerHistories as $history)
            <div class="timeline-item">
                <div class="timeline-header">
                    <span class="timeline-title">{{ $history->position }}</span>
                    <span class="timeline-date">
                        @if($history->start_date)
                            {{ \Carbon\Carbon::parse($history->start_date)->format('M Y') }}
                            @if($history->end_date)
                                - {{ \Carbon\Carbon::parse($history->end_date)->format('M Y') }}
                            @else
                                - Sekarang
                            @endif
                        @endif
                    </span>
                </div>
                <div class="timeline-company">{{ $history->company_name }}</div>
                @if($history->description)
                <div class="timeline-desc">{!! nl2br(e($history->description)) !!}</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- PENDIDIKAN --}}
        <div class="section">
            <div class="section-title">Pendidikan</div>
            <div class="timeline-item">
                <div class="timeline-header">
                    <span class="timeline-title">{{ $user->education_level ?? '-' }}</span>
                    @if($user->graduation_year)
                    <span class="timeline-date">{{ $user->graduation_year }}</span>
                    @endif
                </div>
                @if($user->major)
                <div class="timeline-company">{{ $user->major }}</div>
                @endif
                @if($user->institution)
                <div class="timeline-desc">{{ $user->institution->name }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- BAHASA --}}
    @if($user->languages && count($user->languages) > 0)
    <div class="section">
        <div class="section-title">Bahasa</div>
        <div class="languages">
            @foreach($user->languages as $lang)
            <div class="language-item">
                <span class="language-name">{{ $lang }}</span>
                <div class="dots">
                    <span class="dot filled"></span>
                    <span class="dot filled"></span>
                    <span class="dot filled"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- SERTIFIKAT & DOKUMEN --}}
    @php
        $sertifikatDocs = $user->documents->where('document_type', 'sertifikat');
        $portofolioDocs = $user->documents->where('document_type', 'portofolio');
    @endphp
    @if($sertifikatDocs->count() > 0 || $portofolioDocs->count() > 0)
    <div class="section">
        <div class="section-title">Sertifikat & Dokumen</div>
        <div class="timeline-desc">
            <ul>
                @foreach($sertifikatDocs as $doc)
                <li>{{ $doc->original_name }}</li>
                @endforeach
                @foreach($portofolioDocs as $doc)
                <li>Portofolio: {{ $doc->original_name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        CV ini dibuat secara otomatis oleh KOMPASKARIR &middot; {{ now()->format('d F Y') }}
    </div>
</div>
</body>
</html>
