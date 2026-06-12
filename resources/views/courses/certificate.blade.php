<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $enrollment->user->name }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        signature: ['Alex Brush', 'cursive'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Printable layout settings */
        @media print {
            body {
                background: white;
                color: black;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                position: absolute;
                top: 0;
                left: 0;
                border-radius: 0 !important;
            }
            .cert-border-inner {
                margin: 0 !important;
                height: calc(100vh - 40px) !important;
            }
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
        
        /* Certificate border & seal styling */
        .cert-bg {
            background-image: radial-gradient(circle, #ffffff 60%, #f6f8fb 100%);
        }
        .cert-border {
            border: 24px solid #1e293b; /* Slate-800 */
        }
        .cert-border-inner {
            border: 4px double #d4af37; /* Gold */
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-between py-6">

    <!-- Top Navigation / Controls -->
    <div class="no-print max-w-5xl mx-auto w-full px-6 flex justify-between items-center mb-4">
        <a href="{{ route('seeker.courses.my-progress') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition flex items-center gap-1">
            &larr; Kembali ke Progres Belajar
        </a>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg font-bold shadow transition flex items-center gap-1.5 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Halaman
            </button>
            <a href="{{ route('courses.certificate.pdf', $enrollment->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold shadow transition flex items-center gap-1.5 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh PDF Resmi
            </a>
        </div>
    </div>

    <!-- Certificate Container -->
    <div class="print-container max-w-5xl mx-auto w-full aspect-[1.414/1] bg-white shadow-2xl relative overflow-hidden flex flex-col justify-between cert-border rounded-xl">
        <div class="m-4 flex-1 cert-border-inner cert-bg p-8 sm:p-12 relative flex flex-col justify-between">
            
            <!-- Corner Decorations -->
            <div class="absolute top-2 left-2 text-[#d4af37] opacity-60">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                </svg>
            </div>
            <div class="absolute top-2 right-2 text-[#d4af37] opacity-60 rotate-90">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                </svg>
            </div>
            <div class="absolute bottom-2 left-2 text-[#d4af37] opacity-60 -rotate-90">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                </svg>
            </div>
            <div class="absolute bottom-2 right-2 text-[#d4af37] opacity-60 rotate-180">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h4v2H6v2H4V4zm16 0h-4v2h2v2h2V4zM4 20h4v-2H6v-2H4v4zm16 0h-4v-2h2v-2h2v4z"/>
                </svg>
            </div>

            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center items-center gap-2 mb-2">
                    <span class="text-2xl font-extrabold tracking-widest text-slate-800 font-sans">BATUBATA</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-serif font-bold text-slate-800 tracking-wider mb-2">SERTIFIKAT KELULUSAN</h1>
                <p class="text-xs sm:text-sm font-semibold tracking-widest text-[#d4af37] uppercase">Certificate of Completion</p>
                <div class="w-24 h-0.5 bg-[#d4af37] mx-auto mt-3"></div>
            </div>

            <!-- Recipient -->
            <div class="text-center my-6">
                <p class="text-slate-500 font-serif italic mb-2">Sertifikat ini dengan bangga diberikan kepada:</p>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-slate-900 border-b border-slate-200 inline-block px-8 pb-1 mb-2">
                    {{ $enrollment->user->name }}
                </h2>
                <p class="text-xs text-slate-500 font-medium tracking-wide">
                    Atas kelulusannya dalam menyelesaikan seluruh kriteria pembelajaran kelas pelatihan:
                </p>
            </div>

            <!-- Course / Class Details -->
            <div class="text-center my-4">
                <h3 class="text-2xl sm:text-3xl font-serif font-bold text-indigo-950 mb-2">
                    {{ $enrollment->classRoom->course->title }}
                </h3>
                <p class="text-sm text-slate-600 font-medium">
                    Kelas: <strong>{{ $enrollment->classRoom->name }}</strong> &middot; Predikat: <strong>Sangat Baik</strong> (Nilai Kelulusan: <strong>{{ $enrollment->final_score }}%</strong>)
                </p>
            </div>

            @php
                $photoDoc = $enrollment->user->documents->where('document_type', 'photo')->first();
            @endphp

            <!-- Footer & Signatures -->
            <div class="grid grid-cols-4 items-end text-center mt-6">
                <!-- Student Photo -->
                <div class="flex flex-col items-center">
                    <div class="relative w-16 h-22 sm:w-20 sm:h-28 border-2 border-[#d4af37] p-0.5 bg-white shadow-md flex items-center justify-center overflow-hidden">
                        @if($photoDoc)
                            <img src="{{ asset('storage/' . $photoDoc->file_path) }}" alt="{{ $enrollment->user->name }}" class="w-full h-full object-cover">
                        @else
                            <!-- Beautiful Silhouette Placeholder -->
                            <div class="w-full h-full bg-slate-50 flex flex-col items-center justify-center text-slate-300 relative">
                                <svg class="w-8 h-8 text-slate-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                <span class="text-[8px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">FOTO 3X4</span>
                            </div>
                        @endif
                    </div>
                    <p class="text-[9px] text-slate-500 mt-1 uppercase tracking-wider font-semibold">Penerima</p>
                </div>

                <!-- Instructor Signature -->
                <div class="flex flex-col items-center">
                    <div class="h-12 flex items-end">
                        <span class="font-signature text-4xl text-indigo-800 leading-none">
                            {{ $enrollment->classRoom->teacher->name }}
                        </span>
                    </div>
                    <div class="w-28 sm:w-36 h-px bg-slate-300 my-1"></div>
                    <p class="text-xs font-bold text-slate-850">{{ $enrollment->classRoom->teacher->name }}</p>
                    <p class="text-[10px] text-slate-500">Pengajar / Instruktur</p>
                </div>

                <!-- Gold Seal -->
                <div class="flex justify-center relative -bottom-2">
                    <div class="relative w-20 h-20 sm:w-24 sm:h-24 flex items-center justify-center">
                        <svg class="w-full h-full text-[#d4af37] drop-shadow-md" fill="currentColor" viewBox="0 0 100 100">
                            <!-- Outer spikes -->
                            <polygon points="50,5 53,15 63,10 63,21 73,18 70,29 79,29 73,38 80,41 72,48 77,54 68,58 71,67 61,68 62,78 52,76 50,86 48,76 38,78 39,68 29,67 32,58 23,54 28,48 20,41 27,38 21,29 30,29 27,18 37,21 37,10 47,15" />
                            <!-- Inner circle -->
                            <circle cx="50" cy="50" r="33" fill="#ffffff" stroke="#d4af37" stroke-width="2" />
                            <circle cx="50" cy="50" r="28" fill="#d4af37" />
                            <!-- Tiny text or icon -->
                            <circle cx="50" cy="50" r="24" fill="#ffffff" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-[#c5a028] text-center p-2 leading-none font-bold">
                            <span class="text-[6px] sm:text-[7px] tracking-wider uppercase font-sans">OFFICIAL</span>
                            <span class="text-[7px] sm:text-[8px] font-extrabold tracking-widest my-0.5 font-sans">SEAL</span>
                            <span class="text-[5px] sm:text-[6px] tracking-widest font-sans">BATUBATA</span>
                        </div>
                    </div>
                </div>

                <!-- Admin Signature -->
                <div class="flex flex-col items-center">
                    <div class="h-12 flex items-end">
                        <span class="font-signature text-4xl text-indigo-800 leading-none">Tim Batubata</span>
                    </div>
                    <div class="w-28 sm:w-36 h-px bg-slate-300 my-1"></div>
                    <p class="text-xs font-bold text-slate-850 font-sans">Tim Akademik</p>
                    <p class="text-[10px] text-slate-500 font-sans">Batubata Learning Platform</p>
                </div>
            </div>

            <!-- Bottom Code -->
            <div class="mt-6 flex justify-between items-center text-[10px] text-slate-400 font-mono pt-4 border-t border-slate-100">
                <div>
                    Tanggal Kelulusan: {{ $enrollment->completed_at ? $enrollment->completed_at->format('d M Y') : '-' }}
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right leading-tight font-sans">
                        <span class="block text-[8px] font-bold text-slate-500 tracking-wider">VERIFIKASI RESMI</span>
                        <span class="font-mono text-[10px]">ID: {{ $enrollment->certificate_code }}</span>
                    </div>
                    <div class="w-12 h-12 border border-[#d4af37] bg-white p-0.5 rounded shadow-sm flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($enrollment->certificate_code) }}" alt="QR Code" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Standalone Footer (only visible on screen) -->
    <div class="no-print text-center text-xs text-slate-550 mt-6">
        <p>&copy; {{ date('Y') }} Batubata. Semua hak cipta dilindungi.</p>
    </div>

</body>
</html>
