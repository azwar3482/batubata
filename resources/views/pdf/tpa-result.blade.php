<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil TPA - {{ $result->user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #7c3aed; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { font-size: 24px; color: #7c3aed; margin-bottom: 5px; }
        .header h2 { font-size: 16px; color: #666; font-weight: normal; }
        .header .date { font-size: 11px; color: #999; margin-top: 10px; }
        .badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 14px; }
        .badge-pass { background: #dcfce7; color: #166534; border: 2px solid #86efac; }
        .badge-fail { background: #fef2f2; color: #991b1b; border: 2px solid #fca5a5; }
        .score-box { background: linear-gradient(135deg, #7c3aed, #4f46e5); color: white; text-align: center; padding: 25px; border-radius: 12px; margin: 20px 0; }
        .score-box .big { font-size: 48px; font-weight: bold; }
        .score-box .label { font-size: 12px; opacity: 0.9; }
        .score-box .grade { font-size: 16px; margin-top: 10px; }
        .info-grid { display: table; width: 100%; margin: 20px 0; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; padding: 8px 15px; background: #f8fafc; border: 1px solid #e2e8f0; font-weight: bold; width: 200px; }
        .info-value { display: table-cell; padding: 8px 15px; border: 1px solid #e2e8f0; }
        .category-scores { margin: 20px 0; }
        .category-row { display: table; width: 100%; margin-bottom: 10px; }
        .category-name { display: table-cell; width: 120px; font-weight: bold; vertical-align: middle; }
        .category-bar { display: table-cell; vertical-align: middle; }
        .bar-bg { background: #e2e8f0; height: 24px; border-radius: 12px; overflow: hidden; position: relative; }
        .bar-fill { height: 100%; border-radius: 12px; transition: width 0.3s; }
        .bar-fill.high { background: linear-gradient(90deg, #22c55e, #16a34a); }
        .bar-fill.medium { background: linear-gradient(90deg, #eab308, #ca8a04); }
        .bar-fill.low { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .category-score { display: table-cell; width: 80px; text-align: center; font-weight: bold; font-size: 16px; vertical-align: middle; }
        .stats-grid { display: table; width: 100%; margin: 20px 0; }
        .stat-cell { display: table-cell; text-align: center; padding: 15px; border: 1px solid #e2e8f0; }
        .stat-number { font-size: 28px; font-weight: bold; }
        .stat-label { font-size: 11px; color: #666; }
        .stat-correct .stat-number { color: #16a34a; }
        .stat-wrong .stat-number { color: #dc2626; }
        .stat-unanswered .stat-number { color: #9ca3af; }
        .answers-section { margin-top: 30px; }
        .answers-section h3 { font-size: 16px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0; }
        .answer-item { padding: 12px; margin-bottom: 8px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .answer-item.correct { background: #f0fdf4; border-color: #86efac; }
        .answer-item.wrong { background: #fef2f2; border-color: #fca5a5; }
        .answer-item.unanswered { background: #f9fafb; border-color: #d1d5db; }
        .answer-header { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .answer-category { font-size: 10px; background: white; padding: 2px 8px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .answer-status { font-weight: bold; font-size: 12px; }
        .answer-status.correct { color: #16a34a; }
        .answer-status.wrong { color: #dc2626; }
        .answer-status.unanswered { color: #9ca3af; }
        .answer-question { font-size: 11px; color: #666; margin-bottom: 5px; }
        .answer-detail { font-size: 11px; color: #666; }
        .explanation { font-size: 10px; color: #666; background: white; padding: 8px; border-radius: 6px; margin-top: 8px; border-left: 3px solid #7c3aed; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #e2e8f0; text-align: center; font-size: 10px; color: #999; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 80px; color: rgba(124, 58, 237, 0.05); font-weight: bold; z-index: -1; }
        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .container { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="watermark">KOMPASKARIR</div>
    <div class="container">
        <div class="header">
            <h1>Laporan Hasil Tes Potensi Akademik</h1>
            <h2>{{ $result->tpaTest->title }}</h2>
            <div class="date">Dicetak pada: {{ now()->format('d F Y H:i') }}</div>
        </div>

        <div class="score-box">
            <div class="label">SKOR BAPPENAS</div>
            <div class="big">{{ $result->bappenas_score }}</div>
            <div class="grade">
                @if($result->is_passed)
                <span class="badge badge-pass">LULUS</span>
                @else
                <span class="badge badge-fail">TIDAK LULUS</span>
                @endif
                &nbsp; Grade: {{ $result->score_grade }}
            </div>
        </div>

        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Peserta</div>
                <div class="info-value">{{ $result->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $result->user->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Tes</div>
                <div class="info-value">{{ $result->created_at->format('d F Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Durasi Pengerjaan</div>
                <div class="info-value">{{ floor($result->session->time_spent_seconds / 60) }} menit {{ $result->session->time_spent_seconds % 60 }} detik</div>
            </div>
            <div class="info-row">
                <div class="info-label">Skor Total (Weighted)</div>
                <div class="info-value"><strong>{{ $result->total_score }}%</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Passing Score</div>
                <div class="info-value">{{ $result->passing_score }}%</div>
            </div>
        </div>

        <h3 style="margin: 25px 0 15px; font-size: 14px;">Skor per Kategori</h3>
        <div class="category-scores">
            @foreach(['verbal' => 'Verbal', 'numerik' => 'Numerik', 'logika' => 'Logika', 'spasial' => 'Spasial'] as $key => $label)
            @php $score = $result->{$key . '_score'}; @endphp
            <div class="category-row">
                <div class="category-name">{{ $label }}</div>
                <div class="category-bar">
                    <div class="bar-bg">
                        <div class="bar-fill {{ $score >= 70 ? 'high' : ($score >= 50 ? 'medium' : 'low') }}" style="width: {{ $score }}%"></div>
                    </div>
                </div>
                <div class="category-score">{{ $score }}%</div>
            </div>
            @endforeach
        </div>

        <div class="stats-grid">
            <div class="stat-cell stat-correct">
                <div class="stat-number">{{ $result->total_correct }}</div>
                <div class="stat-label">Jawaban Benar</div>
            </div>
            <div class="stat-cell stat-wrong">
                <div class="stat-number">{{ $result->total_wrong }}</div>
                <div class="stat-label">Jawaban Salah</div>
            </div>
            <div class="stat-cell stat-unanswered">
                <div class="stat-number">{{ $result->total_unanswered }}</div>
                <div class="stat-label">Tidak Dijawab</div>
            </div>
            <div class="stat-cell">
                <div class="stat-number" style="color: #7c3aed;">{{ $result->total_questions }}</div>
                <div class="stat-label">Total Soal</div>
            </div>
        </div>

        <div class="answers-section">
            <h3>Detail Jawaban</h3>
            @foreach($result->session->answers as $i => $answer)
            @php
                $isCorrect = $answer->is_correct;
                $hasAnswer = !is_null($answer->selected_answer);
                $statusClass = $isCorrect ? 'correct' : ($hasAnswer ? 'wrong' : 'unanswered');
                $statusText = $isCorrect ? 'Benar' : ($hasAnswer ? 'Salah' : 'Tidak Dijawab');
            @endphp
            <div class="answer-item {{ $statusClass }}">
                <div style="display: table; width: 100%;">
                    <div style="display: table-cell;">
                        <span class="answer-category">{{ $answer->question->category_label }}</span>
                    </div>
                    <div style="display: table-cell; text-align: right;">
                        <span class="answer-status {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                </div>
                <div class="answer-question">{!! Str::limit(strip_tags($answer->question->question_text), 150) !!}</div>
                @if($hasAnswer)
                <div class="answer-detail">
                    Jawaban: <strong>{{ $answer->selected_answer }}</strong>
                    @if(!$isCorrect)
                    | Jawaban Benar: <strong style="color: #16a34a;">{{ $answer->question->correct_answer }}</strong>
                    @endif
                </div>
                @endif
                @if($answer->question->explanation && !$isCorrect)
                <div class="explanation">
                    <strong>Penjelasan:</strong> {!! $answer->question->explanation !!}
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="footer">
            <p>Dokumen ini digenerate secara otomatis oleh sistem KOMPASKARIR</p>
            <p>{{ url('/') }}</p>
        </div>
    </div>
</body>
</html>
