<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tes TPA - {{ $session->tpaTest->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .timer-warning { color: #ef4444; animation: pulse 1s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .question-nav-btn { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 13px; cursor: pointer; border: 1px solid #d1d5db; background: white; }
        .question-nav-btn.answered { background: #10b981; color: white; border-color: #10b981; }
        .question-nav-btn.flagged { background: #f59e0b; color: white; border-color: #f59e0b; }
        .question-nav-btn.current { background: #3b82f6; color: white; border-color: #3b82f6; }
        .option-btn { display: block; width: 100%; text-align: left; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 8px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s; background: white; }
        .option-btn:hover { border-color: #93c5fd; background: #eff6ff; }
        .option-btn.selected { border-color: #3b82f6; background: #dbeafe; }
    </style>
</head>
<body class="bg-gray-100">
    {{-- FULLSCREEN WARNING --}}
    <div id="fullscreen-warning" class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white rounded-lg p-8 max-w-md text-center">
            <div class="text-4xl mb-4">&#9888;</div>
            <h2 class="text-xl font-bold mb-2">Peringatan!</h2>
            <p class="text-gray-600 mb-4">Anda telah keluar dari halaman tes. Silakan kembali ke halaman tes untuk melanjutkan.</p>
            <button onclick="goFullscreen()" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Kembali ke Tes</button>
        </div>
    </div>

    {{-- HEADER --}}
    <div class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div>
                <h1 class="font-bold text-lg">{{ $session->tpaTest->title }}</h1>
                <p class="text-sm text-gray-500">Soal {{ $currentIndex + 1 }} dari {{ count($allQuestions) }}</p>
            </div>
            <div class="flex items-center gap-4">
                {{-- TIMER --}}
                <div id="timer-display" class="text-right">
                    <div class="text-sm text-gray-500">Sisa Waktu</div>
                    <div id="timer" class="text-2xl font-mono font-bold text-gray-800">--:--</div>
                </div>
                {{-- SUBMIT BUTTON --}}
                <form action="{{ route('seeker.tpa.submit', $session) }}" method="POST" id="submit-form">
                    @csrf
                    <input type="hidden" name="confirm" value="" id="confirm-input">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Selesai
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6 flex gap-6">
        {{-- MAIN CONTENT --}}
        <div class="flex-1">
            @if($questionData)
            <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
                {{-- CATEGORY & DIFFICULTY --}}
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">{{ $questionData['category_label'] }}</span>
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">{{ $questionData['difficulty_label'] }}</span>
                    @if($questionData['is_flagged'])
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">&#9733; Ditandai</span>
                    @endif
                </div>

                {{-- QUESTION TEXT --}}
                <div class="text-lg text-gray-800 mb-6 leading-relaxed whitespace-pre-line">{!! $questionData['question_text'] !!}</div>

                @if($questionData['question_image'])
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $questionData['question_image']) }}" alt="Gambar Soal" class="max-w-full rounded">
                </div>
                @endif

                {{-- OPTIONS --}}
                <div id="options-container">
                    @foreach($questionData['options'] as $option)
                    <button type="button"
                        class="option-btn {{ $questionData['selected_answer'] === $option['key'] ? 'selected' : '' }}"
                        data-key="{{ $option['key'] }}"
                        onclick="selectOption('{{ $option['key'] }}')">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full border-2 mr-3 font-bold text-sm {{ $questionData['selected_answer'] === $option['key'] ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300' }}">
                            {{ $option['key'] }}
                        </span>
                        {{ $option['text'] }}
                    </button>
                    @endforeach
                </div>

                {{-- NAVIGATION --}}
                <div class="flex items-center justify-between mt-8 pt-4 border-t">
                    <div class="flex gap-2">
                        <button onclick="toggleFlag()" id="flag-btn" class="px-4 py-2 border rounded-lg text-sm {{ $questionData['is_flagged'] ? 'bg-yellow-100 text-yellow-700 border-yellow-300' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ $questionData['is_flagged'] ? '&#9733; Batalkan Tandai' : '&#9734; Tandai untuk Review' }}
                        </button>
                    </div>
                    <div class="flex gap-2">
                        @if($currentIndex > 0)
                        <a href="{{ route('seeker.tpa.test', ['session' => $session, 'q' => $currentIndex - 1]) }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                            &laquo; Sebelumnya
                        </a>
                        @endif
                        @if($currentIndex < count($allQuestions) - 1)
                        <a href="{{ route('seeker.tpa.test', ['session' => $session, 'q' => $currentIndex + 1]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                            Selanjutnya &raquo;
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-gray-500">Soal tidak ditemukan.</p>
            </div>
            @endif
        </div>

        {{-- SIDEBAR: QUESTION NAVIGATION --}}
        <div class="w-72 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-4 sticky top-20">
                <h3 class="font-bold text-sm mb-3">Navigasi Soal</h3>
                <div class="grid grid-cols-6 gap-1 mb-4" id="question-nav">
                    @foreach($allQuestions as $q)
                    <a href="{{ route('seeker.tpa.test', ['session' => $session, 'q' => $q['index']]) }}"
                       class="question-nav-btn {{ $q['index'] == $currentIndex ? 'current' : '' }} {{ $q['answered'] ? 'answered' : '' }} {{ $q['flagged'] ? 'flagged' : '' }}">
                        {{ $q['index'] + 1 }}
                    </a>
                    @endforeach
                </div>

                <div class="text-xs text-gray-500 space-y-1">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-500 rounded"></div> Sudah Dijawab
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div> Ditandai
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-white border rounded"></div> Belum Dijawab
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t">
                    <div class="text-sm text-gray-600">
                        Dijawab: <span id="answered-count">{{ collect($allQuestions)->where('answered', true)->count() }}</span> / {{ count($allQuestions) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // TIMER
        let remainingSeconds = {{ $remainingSeconds }};
        const timerEl = document.getElementById('timer');

        function updateTimer() {
            if (remainingSeconds <= 0) {
                timerEl.textContent = '00:00';
                timerEl.classList.add('timer-warning');
                // Auto submit with confirm=yes
                document.getElementById('confirm-input').value = 'yes';
                document.getElementById('submit-form').submit();
                return;
            }

            const hours = Math.floor(remainingSeconds / 3600);
            const mins = Math.floor((remainingSeconds % 3600) / 60);
            const secs = remainingSeconds % 60;

            if (hours > 0) {
                timerEl.textContent = `${hours}:${String(mins).padStart(2,'0')}:${String(secs).padStart(2,'0')}`;
            } else {
                timerEl.textContent = `${String(mins).padStart(2,'0')}:${String(secs).padStart(2,'0')}`;
            }

            if (remainingSeconds <= 300) {
                timerEl.classList.add('timer-warning');
            }

            remainingSeconds--;
        }

        setInterval(updateTimer, 1000);
        updateTimer();

        // SELECT OPTION
        let currentAnswer = '{{ $questionData['selected_answer'] ?? '' }}';
        let isFlagged = {{ $questionData['is_flagged'] ? 'true' : 'false' }};
        let questionId = {{ $questionData['id'] ?? 0 }};
        let startTime = Date.now();

        function selectOption(key) {
            currentAnswer = key;

            // Update UI
            document.querySelectorAll('.option-btn').forEach(btn => {
                const btnKey = btn.dataset.key;
                if (btnKey === key) {
                    btn.classList.add('selected');
                    btn.querySelector('span').classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    btn.querySelector('span').classList.remove('border-gray-300');
                } else {
                    btn.classList.remove('selected');
                    btn.querySelector('span').classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    btn.querySelector('span').classList.add('border-gray-300');
                }
            });

            // Auto-save
            saveAnswer();
        }

        function toggleFlag() {
            isFlagged = !isFlagged;
            const flagBtn = document.getElementById('flag-btn');
            if (isFlagged) {
                flagBtn.classList.add('bg-yellow-100', 'text-yellow-700', 'border-yellow-300');
                flagBtn.innerHTML = '&#9733; Batalkan Tandai';
            } else {
                flagBtn.classList.remove('bg-yellow-100', 'text-yellow-700', 'border-yellow-300');
                flagBtn.innerHTML = '&#9734; Tandai untuk Review';
            }
            saveAnswer();
        }

        function saveAnswer() {
            const timeSpent = Math.round((Date.now() - startTime) / 1000);

            fetch('{{ route("seeker.tpa.save-answer", $session) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    question_id: questionId,
                    selected_answer: currentAnswer || null,
                    time_spent: timeSpent,
                    is_flagged: isFlagged,
                })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    // Update nav button
                    const navBtns = document.querySelectorAll('.question-nav-btn');
                    const currentBtn = navBtns[{{ $currentIndex }}];
                    if (currentAnswer) {
                        currentBtn.classList.add('answered');
                    }
                    if (isFlagged) {
                        currentBtn.classList.add('flagged');
                    } else {
                        currentBtn.classList.remove('flagged');
                    }
                }
            }).catch(err => console.error('Save error:', err));
        }

        // VISIBILITY CHANGE DETECTION
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                document.getElementById('fullscreen-warning').style.display = 'flex';
            }
        });

        function goFullscreen() {
            document.getElementById('fullscreen-warning').style.display = 'none';
        }
    </script>
</body>
</html>
