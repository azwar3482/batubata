<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen" id="ai-workflow-page">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Premium Header -->
            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 rounded-3xl shadow-2xl p-8 text-white">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center space-x-2 bg-indigo-500/20 text-indigo-300 px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase mb-3">
                            <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                            <span>System Control Center</span>
                        </div>
                        <h2 class="text-3xl font-black tracking-tight">Alur Kerja & Diagnostik Modul AI</h2>
                        <p class="mt-2 text-indigo-200/80 text-sm max-w-2xl">
                            Pantau pergerakan data dari CV/dokumen hingga pencocokan lowongan, jelajahi formula matematika yang digunakan, dan lakukan pengujian fungsionalitas modul AI Python Flask secara real-time.
                        </p>
                    </div>
                    <div class="flex items-center space-x-4 bg-white/5 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/10 shrink-0">
                        <div class="text-right">
                            <p class="text-xs text-indigo-300 font-bold uppercase tracking-wider">Flask Microservice</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="relative flex h-2.5 w-2.5" id="flask-ping-indicator">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                                </span>
                                <span class="font-bold text-sm" id="flask-status-text">Checking...</span>
                            </div>
                        </div>
                        <button onclick="pingFlaskService()" class="p-2.5 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white rounded-xl shadow-md transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 bg-violet-600/10 rounded-full blur-2xl"></div>
            </div>

            <!-- Documents Queue Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4 hover:shadow-md transition">
                    <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase">Total Dokumen</p>
                        <h4 class="text-2xl font-black text-slate-800 tracking-tight mt-1">{{ $queueStats['total_documents'] }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4 hover:shadow-md transition">
                    <div class="p-3.5 bg-amber-50 text-amber-600 rounded-xl">
                        <svg class="w-6 h-6 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase">Dalam Antrean</p>
                        <h4 class="text-2xl font-black text-slate-800 tracking-tight mt-1">{{ $queueStats['pending_documents'] }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4 hover:shadow-md transition">
                    <div class="p-3.5 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase">Diproses AI</p>
                        <h4 class="text-2xl font-black text-slate-800 tracking-tight mt-1">{{ $queueStats['processing_documents'] }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4 hover:shadow-md transition">
                    <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase">Selesai Ekstrak</p>
                        <h4 class="text-2xl font-black text-slate-800 tracking-tight mt-1">{{ $queueStats['completed_documents'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Premium Tabs Navigation -->
            <div class="border-b border-slate-200">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button onclick="switchTab('tab-flow')" id="btn-tab-flow" class="tab-btn py-4 px-1 border-b-2 border-indigo-600 text-indigo-600 font-bold text-sm transition-all focus:outline-none flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>Visual Alur Kerja</span>
                    </button>
                    <button onclick="switchTab('tab-formulas')" id="btn-tab-formulas" class="tab-btn py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-semibold text-sm transition-all focus:outline-none flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span>Formula Matematika & Variabel</span>
                    </button>
                    <button onclick="switchTab('tab-diagnostics')" id="btn-tab-diagnostics" class="tab-btn py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-semibold text-sm transition-all focus:outline-none flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Control Room Diagnostik Live</span>
                    </button>
                </nav>
            </div>

            <!-- Tab 1: Visual Alur Kerja -->
            <div id="tab-flow-content" class="tab-pane space-y-8">
                <!-- Tahap 1: Pre-compute -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 font-bold text-white shadow-md text-sm">1</span>
                        <h3 class="text-xl font-bold text-slate-800">Tahap 1: Pemrosesan Dokumen di Latar Belakang (Pre-compute)</h3>
                    </div>
                    <p class="text-sm text-slate-500 mb-8 max-w-4xl">
                        Alur kerja asinkron ini dipicu saat pengguna mengunggah dokumen baru (seperti CV, Portofolio, Sertifikat) di halaman profil mereka. Laravel akan mendelegasikan tugas ekstraksi NLP yang berat ke Python Flask melalui antrean (Queue) agar pengalaman pengguna tetap lancar tanpa hambatan loading.
                    </p>

                    <!-- Interactive Step flow representation -->
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 relative">
                        <div class="flex flex-col p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-200 transition group relative">
                            <span class="absolute top-4 right-4 text-xs font-bold text-slate-300 group-hover:text-indigo-400 transition-colors uppercase">Step 01</span>
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl w-fit mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800">Unggah Multi-Dokumen</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Pengguna mengunggah CV / Sertifikat di profil. Controller memvalidasi file dan memicu `ProcessDocumentsJob` ke antrean database.
                            </p>
                        </div>

                        <div class="flex flex-col p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-200 transition group relative">
                            <span class="absolute top-4 right-4 text-xs font-bold text-slate-300 group-hover:text-indigo-400 transition-colors uppercase">Step 02</span>
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl w-fit mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800">Job Queue Dispatch</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Pekerja antrean (`Queue Worker`) mengambil Job secara asinkron dan memanggil `PythonAIService` dengan melempar file CV / Dokumen.
                            </p>
                        </div>

                        <div class="flex flex-col p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-200 transition group relative">
                            <span class="absolute top-4 right-4 text-xs font-bold text-slate-300 group-hover:text-indigo-400 transition-colors uppercase">Step 03</span>
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl w-fit mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800">Python Flask NLP Core</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Flask API menerima payload, mengekstrak teks dengan pembaca file, mencari keyword NLP / spaCy, dan menghasilkan Vektor Vektor Skill.
                            </p>
                        </div>

                        <div class="flex flex-col p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-200 transition group relative">
                            <span class="absolute top-4 right-4 text-xs font-bold text-slate-300 group-hover:text-indigo-400 transition-colors uppercase">Step 04</span>
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl w-fit mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800">Database Storage</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Laravel menyimpan hasil parsing (extracted_skills, embedding_vector, overall_score) ke tabel `user_document_scores` dengan status `completed`.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2: Lazy Resolve -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 font-bold text-white shadow-md text-sm">2</span>
                        <h3 class="text-xl font-bold text-slate-800">Tahap 2: Penilaian & Pencocokan Lowongan secara Instan (Lazy Resolve)</h3>
                    </div>
                    <p class="text-sm text-slate-500 mb-8 max-w-4xl">
                        Saat pencari kerja menjelajah atau membuka lowongan kerja spesifik, Laravel backend langsung menyajikan kecocokan (Blended Score) dan geolokasi terdekat dengan seketika. Hal ini dikarenakan proses pemrosesan CV yang memakan waktu sudah diselesaikan terlebih dahulu di Tahap 1.
                    </p>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 relative group">
                            <div class="absolute -right-3 -top-3 w-10 h-10 bg-indigo-500/5 group-hover:scale-150 rounded-full transition-all duration-300"></div>
                            <h4 class="text-base font-bold text-slate-800 flex items-center mb-3">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                                1. Ambil Bobot Dinamis
                            </h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Sistem mengambil bobot dokumen lowongan tersebut (apakah kustom khusus per lowongan oleh Perusahaan, atau menggunakan Bobot Default dari Admin).
                            </p>
                        </div>

                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 relative group">
                            <div class="absolute -right-3 -top-3 w-10 h-10 bg-indigo-500/5 group-hover:scale-150 rounded-full transition-all duration-300"></div>
                            <h4 class="text-base font-bold text-slate-800 flex items-center mb-3">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                                2. Blended Matching Score
                            </h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                `DocumentScoringService` mengalkulasikan total weighted score dari seluruh dokumen (Bobot 60%) dan menggabungkannya dengan Asesmen Kompetensi Mandiri user (Bobot 40%).
                            </p>
                        </div>

                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 relative group">
                            <div class="absolute -right-3 -top-3 w-10 h-10 bg-indigo-500/5 group-hover:scale-150 rounded-full transition-all duration-300"></div>
                            <h4 class="text-base font-bold text-slate-800 flex items-center mb-3">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                                3. Haversine Geo-Sorting
                            </h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Jika pencarian didasarkan pada lowongan terdekat, `GeoLocationService` menghitung radius koordinat GPS secara real-time dan melakukan pengurutan otomatis berdasarkan jarak KM.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Formula & Variabel Matematika -->
            <div id="tab-formulas-content" class="tab-pane hidden space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- NLP Confidence Score -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-800">NLP Confidence Score (Ekstraksi Kata)</h4>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Mengukur tingkat keyakinan (confidence) sistem NLP Python bahwa sebuah kata dalam CV benar-benar merepresentasikan skill kandidat, berdasarkan frekuensi dan konteks teks di sekitarnya.
                        </p>

                        <!-- Math Formula Box -->
                        <div class="bg-slate-900 text-slate-200 p-6 rounded-2xl font-mono text-xs flex flex-col items-center justify-center space-y-3 leading-relaxed shadow-inner">
                            <div class="text-[10px] text-indigo-400 uppercase font-bold tracking-widest">Formula</div>
                            <div class="text-center font-bold text-sm text-white py-2">
                                BaseScore = min(Freq &times; 0.2, 0.6)<br>
                                Conf = min(BaseScore + ContextBonus, 1.0)
                            </div>
                        </div>

                        <!-- Variables Table -->
                        <div class="space-y-3">
                            <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Variabel Input/Output</h5>
                            <div class="border border-slate-50 rounded-xl overflow-hidden text-xs">
                                <table class="w-full text-left">
                                    <tr class="bg-slate-50">
                                        <th class="px-4 py-2 font-bold text-slate-600">Variabel</th>
                                        <th class="px-4 py-2 font-bold text-slate-600">Keterangan</th>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">Freq</td>
                                        <td class="px-4 py-2.5 text-slate-400">Frekuensi kemunculan kata skill dalam teks CV.</td>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">ContextBonus</td>
                                        <td class="px-4 py-2.5 text-slate-400">+0.2 jika dekat judul 'Skills', +0.2 jika ada kata tahun/pengalaman.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">Conf (Confidence)</td>
                                        <td class="px-4 py-2.5 text-slate-500 font-bold">Output keyakinan (0.0 - 1.0) sebagai Vektor Awal.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Cosine Similarity -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-800">Cosine Similarity (Skill Gap)</h4>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Digunakan untuk mengukur kemiripan antara vektor skill yang dimiliki kandidat dengan vektor skill target lowongan. Skala berkisar antara 0.0 (tidak mirip sama sekali) hingga 1.0 (sangat mirip).
                        </p>

                        <!-- Math Formula Box -->
                        <div class="bg-slate-900 text-slate-200 p-6 rounded-2xl font-mono text-xs flex flex-col items-center justify-center space-y-3 leading-relaxed shadow-inner">
                            <div class="text-[10px] text-indigo-400 uppercase font-bold tracking-widest">Formula</div>
                            <div class="text-center font-bold text-sm text-white py-2">
                                CosSim(A, B) = &Sigma;(A<sub>i</sub> &times; B<sub>i</sub>) / ( &radic;&Sigma;A<sub>i</sub><sup>2</sup> &times; &radic;&Sigma;B<sub>i</sub><sup>2</sup> )
                            </div>
                        </div>

                        <!-- Variables Table -->
                        <div class="space-y-3">
                            <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Variabel Input/Output</h5>
                            <div class="border border-slate-50 rounded-xl overflow-hidden text-xs">
                                <table class="w-full text-left">
                                    <tr class="bg-slate-50">
                                        <th class="px-4 py-2 font-bold text-slate-600">Variabel</th>
                                        <th class="px-4 py-2 font-bold text-slate-600">Keterangan</th>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">user_skills (A)</td>
                                        <td class="px-4 py-2.5 text-slate-400">Tingkat keyakinan skill user (confidence).</td>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">target_skills (B)</td>
                                        <td class="px-4 py-2.5 text-slate-400">Tingkat keahlian minimal yang diminta.</td>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">category_weights</td>
                                        <td class="px-4 py-2.5 text-slate-400">Bobot berdasarkan kategori (misal: programming = 0.3).</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">Cosine Similarity</td>
                                        <td class="px-4 py-2.5 text-slate-500 font-bold">Output kemiripan (0.0 - 1.0)</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Blended Matching Score -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-800">Blended Match Score</h4>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Menggabungkan hasil penilaian dokumen berbasis AI NLP (bobot 60%) dengan asesmen mandiri kompetensi manual (bobot 40%). Jika dokumen belum diunggah, otomatis fallback menggunakan 100% asesmen.
                        </p>

                        <!-- Math Formula Box -->
                        <div class="bg-slate-900 text-slate-200 p-6 rounded-2xl font-mono text-xs flex flex-col items-center justify-center space-y-3 leading-relaxed shadow-inner">
                            <div class="text-[10px] text-indigo-400 uppercase font-bold tracking-widest">Formula</div>
                            <div class="text-center font-bold text-sm text-white py-2">
                                Blended = (DocScore &times; 0.6) + (AssScore &times; 0.4)
                            </div>
                        </div>

                        <!-- Variables Table -->
                        <div class="space-y-3">
                            <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Variabel Input/Output</h5>
                            <div class="border border-slate-50 rounded-xl overflow-hidden text-xs">
                                <table class="w-full text-left">
                                    <tr class="bg-slate-50">
                                        <th class="px-4 py-2 font-bold text-slate-600">Variabel</th>
                                        <th class="px-4 py-2 font-bold text-slate-600">Keterangan</th>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">DocScore</td>
                                        <td class="px-4 py-2.5 text-slate-400">Total skor dari multiplikasi user_document_scores & bobot perusahaan.</td>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">AssScore</td>
                                        <td class="px-4 py-2.5 text-slate-400">Skor rata-rata dari kompetensi yang telah di-asesmen sendiri.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">Blended Score</td>
                                        <td class="px-4 py-2.5 text-slate-500 font-bold">Output persentase kecocokan (0 - 100%)</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Haversine GPS Distance -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-800">Haversine GPS Formula</h4>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Digunakan untuk menghitung jarak lingkaran besar antara dua koordinat latitude dan longitude di permukaan bola bumi. Sangat penting untuk fitur rekomendasi lowongan kerja terdekat.
                        </p>

                        <!-- Math Formula Box -->
                        <div class="bg-slate-900 text-slate-200 p-6 rounded-2xl font-mono text-xs flex flex-col items-center justify-center space-y-3 leading-relaxed shadow-inner">
                            <div class="text-[10px] text-indigo-400 uppercase font-bold tracking-widest">Formula</div>
                            <div class="text-center font-bold text-xs text-white py-1">
                                a = sin<sup>2</sup>(&Delta;lat/2) + cos(lat1)&middot;cos(lat2)&middot;sin<sup>2</sup>(&Delta;lon/2)<br>
                                c = 2 &middot; atan2(&radic;a, &radic;(1-a))<br>
                                d = R &middot; c
                            </div>
                        </div>

                        <!-- Variables Table -->
                        <div class="space-y-3">
                            <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Variabel Input/Output</h5>
                            <div class="border border-slate-50 rounded-xl overflow-hidden text-xs">
                                <table class="w-full text-left">
                                    <tr class="bg-slate-50">
                                        <th class="px-4 py-2 font-bold text-slate-600">Variabel</th>
                                        <th class="px-4 py-2 font-bold text-slate-600">Keterangan</th>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">lat1, lon1</td>
                                        <td class="px-4 py-2.5 text-slate-400">Koordinat GPS posisi pencari kerja (User).</td>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">lat2, lon2</td>
                                        <td class="px-4 py-2.5 text-slate-400">Koordinat GPS lokasi kantor Perusahaan (Job).</td>
                                    </tr>
                                    <tr class="border-b border-slate-50">
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">R</td>
                                        <td class="px-4 py-2.5 text-slate-400">Jari-jari bola bumi (tetapan: 6371 kilometer).</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2.5 font-semibold text-indigo-600">d (Distance)</td>
                                        <td class="px-4 py-2.5 text-slate-500 font-bold">Output jarak dalam KM.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Control Room Diagnostik Live -->
            <div id="tab-diagnostics-content" class="tab-pane hidden space-y-8">
                <div class="grid grid-cols-1 gap-8">
                    <!-- Diagnostic 1: Ping Microservice -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800">1. Ping Flask Microservice Connection</h4>
                                    <p class="text-xs text-slate-400 mt-1">Uji latensi koneksi API backend Laravel menuju server Flask.</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 bg-slate-900 rounded-2xl text-slate-300 font-mono text-xs space-y-3 leading-relaxed shadow-inner">
                            <div class="flex justify-between items-center text-[10px] text-indigo-400 border-b border-slate-800 pb-2 font-bold uppercase tracking-wider">
                                <span>Terminal Output</span>
                                <span id="ping-badge" class="bg-slate-800 text-slate-400 px-2 py-0.5 rounded">Ready</span>
                            </div>
                            <div id="ping-terminal-log" class="h-32 overflow-y-auto space-y-1 scrollbar-thin">
                                <span class="text-slate-500">// Klik tombol di bawah untuk memulai tes...</span>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-3 w-full">
                            <button onclick="copyTerminalText('ping-terminal-log')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] text-slate-700 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Copy Text</span>
                            </button>
                            <button onclick="stopTerminalLog('ping-terminal-log', 'ping-badge', '// Terminal dihentikan. Klik mulai lagi...')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 active:scale-[0.98] text-rose-600 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span>Stop</span>
                            </button>
                            <button onclick="runPingDiagnostic()" class="flex-[1.5] flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white rounded-2xl text-sm font-bold shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                <span>Mulai Lagi</span>
                            </button>
                        </div>
                    </div>

                    <!-- Diagnostic 2: Test NLP CV Extractor -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">2. Test Multi-Document NLP Extractor</h4>
                                <p class="text-xs text-slate-400 mt-1">Simulasikan pembacaan berkas (CV, Ijazah, Sertifikat) oleh parser NLP Python.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="space-y-2 md:col-span-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pelamar</label>
                                <select id="user-identity-input" onchange="loadUserDocuments(this.value)" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                                    <option value="">-- Pilih Pelamar --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Dokumen Pelamar</label>
                                <select id="doc-type-input" onchange="loadDocumentText(this.value)" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                                    <option value="">-- Pilih Dokumen --</option>
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Teks dari Dokumen Uji Coba</label>
                                <textarea id="cv-text-input" readonly rows="3" class="w-full bg-slate-50/50 border border-slate-200 rounded-2xl p-4 text-xs font-medium text-slate-500 focus:outline-none transition" placeholder="Teks dokumen akan otomatis diekstrak ketika dokumen dipilih di dropdown..."></textarea>
                            </div>
                        </div>

                        <div class="p-5 bg-slate-900 rounded-2xl text-slate-300 font-mono text-xs space-y-3 leading-relaxed shadow-inner">
                            <div class="flex justify-between items-center text-[10px] text-indigo-400 border-b border-slate-800 pb-2 font-bold uppercase tracking-wider">
                                <span>Output Ekstraksi & Modul Status</span>
                                <span id="nlp-badge" class="bg-slate-800 text-slate-400 px-2 py-0.5 rounded">Ready</span>
                            </div>
                            <div id="nlp-terminal-log" class="h-32 overflow-y-auto space-y-1 scrollbar-thin">
                                <span class="text-slate-500">// Tulis teks CV di atas lalu klik jalankan...</span>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-3 w-full">
                            <button onclick="copyTerminalText('nlp-terminal-log')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] text-slate-700 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Copy Text</span>
                            </button>
                            <button onclick="stopTerminalLog('nlp-terminal-log', 'nlp-badge', '// Terminal dihentikan. Klik mulai lagi...')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 active:scale-[0.98] text-rose-600 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span>Stop</span>
                            </button>
                            <button onclick="runNlpDiagnostic()" class="flex-[1.5] flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white rounded-2xl text-sm font-bold shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                <span>Mulai Lagi</span>
                            </button>
                        </div>
                    </div>

                    <!-- Diagnostic 3: Cosine Similarity Simulator -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">3. Cosine Similarity & Vector Calculator</h4>
                                <p class="text-xs text-slate-400 mt-1">Simulasikan perhitungan matematis dot product antara skill kandidat vs target.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Skill User (Kandidat)</label>
                                <input type="text" id="user-skills-input" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20" value="Python:0.8, SQL:0.5, Laravel:0.9">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Skill Target (Lowongan)</label>
                                <input type="text" id="target-skills-input" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20" value="Python:0.9, SQL:0.8, Laravel:0.8, React:0.7">
                            </div>
                        </div>

                        <div class="p-5 bg-slate-900 rounded-2xl text-slate-300 font-mono text-xs space-y-3 leading-relaxed shadow-inner">
                            <div class="flex justify-between items-center text-[10px] text-indigo-400 border-b border-slate-800 pb-2 font-bold uppercase tracking-wider">
                                <span>Hasil Langkah & Perhitungan</span>
                                <span id="cosine-badge" class="bg-slate-800 text-slate-400 px-2 py-0.5 rounded">Ready</span>
                            </div>
                            <div id="cosine-terminal-log" class="h-32 overflow-y-auto space-y-1 scrollbar-thin">
                                <span class="text-slate-500">// Tekan tombol jalankan untuk melihat kalkulasi detail...</span>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-3 w-full">
                            <button onclick="copyTerminalText('cosine-terminal-log')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] text-slate-700 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Copy Text</span>
                            </button>
                            <button onclick="stopTerminalLog('cosine-terminal-log', 'cosine-badge', '// Terminal dihentikan. Klik mulai lagi...')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 active:scale-[0.98] text-rose-600 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span>Stop</span>
                            </button>
                            <button onclick="runCosineDiagnostic()" class="flex-[1.5] flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white rounded-2xl text-sm font-bold shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                <span>Mulai Lagi</span>
                            </button>
                        </div>
                    </div>

                    <!-- Diagnostic 4: Geolocator Calculator -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">4. Haversine Geo-distance Calculator</h4>
                                <p class="text-xs text-slate-400 mt-1">Hitung jarak antara dua koordinat GPS di permukaan bumi.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Koordinat 1 (Lat, Lon)</label>
                                <input type="text" id="coord1-input" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20" value="-6.2088, 106.8456">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Koordinat 2 (Lat, Lon)</label>
                                <input type="text" id="coord2-input" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20" value="-6.9175, 107.6191">
                            </div>
                        </div>

                        <div class="p-5 bg-slate-900 rounded-2xl text-slate-300 font-mono text-xs space-y-3 leading-relaxed shadow-inner">
                            <div class="flex justify-between items-center text-[10px] text-indigo-400 border-b border-slate-800 pb-2 font-bold uppercase tracking-wider">
                                <span>Hasil Langkah & Perhitungan Jarak</span>
                                <span id="geo-badge" class="bg-slate-800 text-slate-400 px-2 py-0.5 rounded">Ready</span>
                            </div>
                            <div id="geo-terminal-log" class="h-32 overflow-y-auto space-y-1 scrollbar-thin">
                                <span class="text-slate-500">// Tekan tombol jalankan untuk menghitung jarak GPS...</span>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-3 w-full">
                            <button onclick="copyTerminalText('geo-terminal-log')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] text-slate-700 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Copy Text</span>
                            </button>
                            <button onclick="stopTerminalLog('geo-terminal-log', 'geo-badge', '// Terminal dihentikan. Klik mulai lagi...')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 active:scale-[0.98] text-rose-600 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span>Stop</span>
                            </button>
                            <button onclick="runGeoDiagnostic()" class="flex-[1.5] flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white rounded-2xl text-sm font-bold shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                <span>Mulai Lagi</span>
                            </button>
                        </div>
                    </div>

                    <!-- Diagnostic 5: Blended Match Score Calculator -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">5. Blended Match Score Calculator</h4>
                                <p class="text-xs text-slate-400 mt-1">Gabungkan hasil penilaian dokumen NLP (Bobot 60%) dengan input manual Asesmen Kompetensi (Bobot 40%).</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Skor Dokumen (Dari Cosine)</label>
                                <input type="number" id="doc-score-input" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20" value="85" min="0" max="100">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Skor Asesmen Manual (Profil)</label>
                                <input type="number" id="ass-score-input" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20" value="90" min="0" max="100">
                            </div>
                        </div>

                        <div class="p-5 bg-slate-900 rounded-2xl text-slate-300 font-mono text-xs space-y-3 leading-relaxed shadow-inner">
                            <div class="flex justify-between items-center text-[10px] text-indigo-400 border-b border-slate-800 pb-2 font-bold uppercase tracking-wider">
                                <span>Hasil Blended Score</span>
                                <span id="blended-badge" class="bg-slate-800 text-slate-400 px-2 py-0.5 rounded">Ready</span>
                            </div>
                            <div id="blended-terminal-log" class="h-24 overflow-y-auto space-y-1 scrollbar-thin">
                                <span class="text-slate-500">// Tekan tombol jalankan untuk menggabungkan skor...</span>
                            </div>
                        </div>

                        <div class="flex flex-row space-x-3 w-full">
                            <button onclick="copyTerminalText('blended-terminal-log')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] text-slate-700 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Copy Text</span>
                            </button>
                            <button onclick="stopTerminalLog('blended-terminal-log', 'blended-badge', '// Terminal dihentikan. Klik mulai lagi...')" class="flex-1 flex items-center justify-center space-x-2 py-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 active:scale-[0.98] text-rose-600 rounded-2xl text-xs font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span>Stop</span>
                            </button>
                            <button onclick="runBlendedDiagnostic()" class="flex-[1.5] flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white rounded-2xl text-sm font-bold shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                <span>Mulai Lagi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Live diagnostic scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ping Flask Server on page load to set the initial status
            pingFlaskService();
        });

        function switchTab(tabId) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(function(pane) {
                pane.classList.add('hidden');
            });
            
            // Show active pane
            document.getElementById(tabId + '-content').classList.remove('hidden');

            // Reset tab styles
            document.querySelectorAll('.tab-btn').forEach(function(btn) {
                btn.classList.remove('border-indigo-600', 'text-indigo-600');
                btn.classList.add('border-transparent', 'text-slate-500');
            });

            // Set active tab button style
            document.getElementById('btn-' + tabId).classList.add('border-indigo-600', 'text-indigo-600');
            document.getElementById('btn-' + tabId).classList.remove('border-transparent', 'text-slate-500');
        }

        // Helper Functions for Buttons
        function loadUserDocuments(userId) {
            const docSelect = document.getElementById('doc-type-input');
            const cvTextArea = document.getElementById('cv-text-input');
            
            // Reset fields
            docSelect.innerHTML = '<option value="">-- Pilih Dokumen --</option>';
            cvTextArea.value = '';
            
            if (!userId) return;

            // Show loading in select
            docSelect.innerHTML = '<option value="">⏳ Memuat Dokumen...</option>';

            fetch(`/admin/ai-workflow/user-documents/${userId}`)
                .then(res => res.json())
                .then(data => {
                    docSelect.innerHTML = '<option value="">-- Pilih Dokumen --</option>';
                    if (data.success && data.documents && data.documents.length > 0) {
                        data.documents.forEach(doc => {
                            const option = document.createElement('option');
                            option.value = doc.id;
                            // mapping document types to readable labels
                            const typeLabels = {
                                'cv': 'CV / Resume',
                                'ijazah': 'Ijazah',
                                'transkrip': 'Transkrip Nilai',
                                'sertifikat': 'Sertifikat',
                                'portofolio': 'Portofolio'
                            };
                            const typeLabel = typeLabels[doc.document_type] || doc.document_type.toUpperCase();
                            option.textContent = `${typeLabel} - ${doc.original_name}`;
                            docSelect.appendChild(option);
                        });
                    } else {
                        docSelect.innerHTML = '<option value="">❌ Tidak ada dokumen di-upload (Nilai = 0)</option>';
                        cvTextArea.value = 'User tidak memiliki dokumen apapun yang diunggah. Secara aktual, nilai kecocokan dokumen NLP pelamar ini di database adalah 0.';
                    }
                })
                .catch(err => {
                    console.error(err);
                    docSelect.innerHTML = '<option value="">❌ Gagal memuat dokumen</option>';
                });
        }

        function loadDocumentText(docId) {
            const cvTextArea = document.getElementById('cv-text-input');
            if (!docId) {
                cvTextArea.value = '';
                return;
            }

            cvTextArea.value = '⏳ Mengekstrak teks dokumen fisik via PHP parser...';

            fetch(`/admin/ai-workflow/extract-text/${docId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        cvTextArea.value = data.text;
                    } else {
                        cvTextArea.value = '❌ Gagal mengekstrak teks dari dokumen: ' + (data.error || 'Unknown error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    cvTextArea.value = '❌ Terjadi kesalahan saat memproses ekstraksi teks: ' + err.message;
                });
        }

        function copyTerminalText(elementId) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const textToCopy = el.innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                // Optional: show a small toast, but alert is fine for diagnostic tool
                alert('Teks log berhasil disalin ke clipboard!');
            }).catch(err => {
                console.error('Gagal menyalin:', err);
            });
        }

        function stopTerminalLog(logId, badgeId, defaultMsg) {
            const logTerm = document.getElementById(logId);
            const badge = document.getElementById(badgeId);
            
            if(badge) {
                badge.innerText = 'STOPPED';
                badge.className = 'bg-rose-500/20 text-rose-400 px-2 py-0.5 rounded';
            }
            if(logTerm) {
                logTerm.innerHTML = `<span class="text-slate-500">${defaultMsg}</span>`;
            }
        }

        function pingFlaskService() {
            const indicator = document.getElementById('flask-ping-indicator');
            const statusText = document.getElementById('flask-status-text');

            // Set state to pinging
            statusText.innerText = 'Checking...';
            indicator.innerHTML = `
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
            `;

            fetch('{{ route("admin.ai-workflow.diagnostic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: 'ping' })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'online') {
                    statusText.innerText = 'Online (' + data.latency_ms + 'ms)';
                    statusText.className = 'font-bold text-sm text-green-400';
                    indicator.innerHTML = `
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    `;
                } else {
                    statusText.innerText = 'Offline';
                    statusText.className = 'font-bold text-sm text-rose-400';
                    indicator.innerHTML = `
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                    `;
                }
            })
            .catch(err => {
                statusText.innerText = 'Offline';
                statusText.className = 'font-bold text-sm text-rose-400';
                indicator.innerHTML = `
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                `;
            });
        }

        function runPingDiagnostic() {
            const logTerm = document.getElementById('ping-terminal-log');
            const badge = document.getElementById('ping-badge');
            
            badge.innerText = 'PENDING';
            badge.className = 'bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded';
            logTerm.innerHTML = `<span class="text-indigo-400">> Mengirim permintaan ping koneksi...</span><br>`;

            fetch('{{ route("admin.ai-workflow.diagnostic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: 'ping' })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.status === 'online') {
                    badge.innerText = 'ONLINE';
                    badge.className = 'bg-green-500/20 text-green-300 px-2 py-0.5 rounded';
                    logTerm.innerHTML += `
                        <span class="text-green-400">[SUKSES] Koneksi Python Flask terhubung!</span><br>
                        <span class="text-slate-300">Base URL: ${data.url}</span><br>
                        <span class="text-slate-300">Respons HTTP: ${data.response_code} OK</span><br>
                        <span class="text-slate-300">Kecepatan Respons: ${data.latency_ms} ms</span>
                    `;
                } else {
                    badge.innerText = 'OFFLINE';
                    badge.className = 'bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded';
                    logTerm.innerHTML += `
                        <span class="text-rose-400">[GAGAL] Flask Server offline atau tidak dapat dijangkau.</span><br>
                        <span class="text-slate-400">Target URL: ${data.url || 'http://localhost:5000'}</span><br>
                        <span class="text-slate-400">Penyebab: ${data.error || 'Connection timed out.'}</span>
                    `;
                }
            })
            .catch(err => {
                badge.innerText = 'ERROR';
                badge.className = 'bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded';
                logTerm.innerHTML += `<span class="text-rose-400">[EXCEPTION] Gagal melakukan request: ${err.message}</span>`;
            });
        }

        function runNlpDiagnostic() {
            const cvText = document.getElementById('cv-text-input').value.trim();
            const docSelect = document.getElementById('doc-type-input');
            const docType = docSelect.selectedIndex >= 0 ? docSelect.options[docSelect.selectedIndex].text : 'Tidak ditentukan';
            const userSelect = document.getElementById('user-identity-input');
            const userIdentity = userSelect.selectedIndex >= 0 ? userSelect.options[userSelect.selectedIndex].text : 'Tidak ditentukan';
            const logTerm = document.getElementById('nlp-terminal-log');
            const badge = document.getElementById('nlp-badge');

            if (!cvText || cvText.startsWith('User tidak memiliki dokumen') || cvText.startsWith('❌') || cvText.startsWith('⏳')) {
                logTerm.innerHTML = `<span class="text-amber-400">[WARNING] Harap pilih pelamar dengan dokumen valid terlebih dahulu.</span>`;
                return;
            }

            badge.innerText = 'PARSING';
            badge.className = 'bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded';
            logTerm.innerHTML = `<span class="text-indigo-400">> Memanggil Flask NLP parser (/api/analyze-skill-gap)...</span><br>
                                 <span class="text-slate-400">Target Pelamar: <strong>${userIdentity}</strong></span><br>
                                 <span class="text-slate-400">Tipe Dokumen Terdeteksi: <strong>${docType.toUpperCase()}</strong></span><br>`;

            fetch('{{ route("admin.ai-workflow.diagnostic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: 'nlp', cv_text: cvText })
            })
            .then(res => res.json())
            .then(data => {
                badge.innerText = data.mode === 'live' ? 'LIVE' : 'SIMULATED';
                badge.className = data.mode === 'live' 
                    ? 'bg-green-500/20 text-green-300 px-2 py-0.5 rounded' 
                    : 'bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded';

                if (data.mode === 'simulation') {
                    logTerm.innerHTML += `<span class="text-blue-400">[FALLBACK] ${data.explanation}</span><br>`;
                } else {
                    logTerm.innerHTML += `<span class="text-green-400">[LIVE] Berhasil mengambil respons dari Flask Engine dalam ${data.latency_ms} ms.</span><br>`;
                }

                const skills = data.output_response.extracted_skills;
                if (skills.length === 0) {
                    logTerm.innerHTML += `<span class="text-slate-400">> Tidak ada skill yang berhasil diekstrak. Coba masukkan kata kunci seperti 'Python' atau 'Laravel'.</span>`;
                } else {
                    logTerm.innerHTML += `<span class="text-slate-200">> Skill berhasil diekstrak (${skills.length}):</span><br>`;
                    skills.forEach(s => {
                        logTerm.innerHTML += `<span class="text-indigo-300">&nbsp;&nbsp;&bull; ${s.skill_name} (${s.category}) - Confidence: ${Math.round(s.confidence * 100)}%</span><br>`;
                    });
                }
            })
            .catch(err => {
                badge.innerText = 'ERROR';
                badge.className = 'bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded';
                logTerm.innerHTML += `<span class="text-rose-400">[EXCEPTION] Gagal parsing CV: ${err.message}</span>`;
            });
        }

        function runCosineDiagnostic() {
            const userSkills = document.getElementById('user-skills-input').value.trim();
            const targetSkills = document.getElementById('target-skills-input').value.trim();
            const logTerm = document.getElementById('cosine-terminal-log');
            const badge = document.getElementById('cosine-badge');

            badge.innerText = 'CALCULATING';
            badge.className = 'bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded';
            logTerm.innerHTML = `<span class="text-indigo-400">> Memulai simulasi perkalian dot product vektor...</span><br>`;

            fetch('{{ route("admin.ai-workflow.diagnostic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: 'cosine', user_skills: userSkills, target_skills: targetSkills })
            })
            .then(res => res.json())
            .then(data => {
                badge.innerText = 'CALCULATED';
                badge.className = 'bg-green-500/20 text-green-300 px-2 py-0.5 rounded';

                logTerm.innerHTML += `
                    <span class="text-slate-200">1. Vektor Skill Bobot Kategori (Confidence &times; Weight):</span><br>
                `;

                data.steps.forEach(s => {
                    logTerm.innerHTML += `
                        <span class="text-slate-400">&nbsp;&nbsp;&bull; ${s.skill} (w=${s.weight}): User = ${s.user_confidence} &rarr; ${s.user_weighted.toFixed(3)}, Target = ${s.target_required} &rarr; ${s.target_weighted.toFixed(3)} (Dot Product Term: ${s.dot_product_term.toFixed(4)})</span><br>
                    `;
                });

                logTerm.innerHTML += `
                    <span class="text-slate-200 mt-2 block">2. Magnitudo Vektor:</span><br>
                    <span class="text-slate-400">&nbsp;&nbsp;&bull; Magnitudo User: &radic;(${data.magnitude_user_sq.toFixed(4)}) = ${data.magnitude_user.toFixed(4)}</span><br>
                    <span class="text-slate-400">&nbsp;&nbsp;&bull; Magnitudo Target: &radic;(${data.magnitude_target_sq.toFixed(4)}) = ${data.magnitude_target.toFixed(4)}</span><br>
                    <span class="text-indigo-300 mt-2 block font-bold">> Cosine Similarity: ${data.cosine_similarity.toFixed(4)} (&rarr; Kecocokan Final: ${data.similarity_percentage}%)</span>
                `;
            })
            .catch(err => {
                badge.innerText = 'ERROR';
                badge.className = 'bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded';
                logTerm.innerHTML += `<span class="text-rose-400">[EXCEPTION] Gagal menghitung cosine: ${err.message}</span>`;
            });
        }

        function runGeoDiagnostic() {
            const coord1 = document.getElementById('coord1-input').value.trim();
            const coord2 = document.getElementById('coord2-input').value.trim();
            const logTerm = document.getElementById('geo-terminal-log');
            const badge = document.getElementById('geo-badge');

            badge.innerText = 'CALCULATING';
            badge.className = 'bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded';
            logTerm.innerHTML = `<span class="text-indigo-400">> Memulai penghitungan Haversine Trigonometri...</span><br>`;

            const [lat1, lon1] = coord1.split(',').map(n => parseFloat(n.trim()));
            const [lat2, lon2] = coord2.split(',').map(n => parseFloat(n.trim()));

            fetch('{{ route("admin.ai-workflow.diagnostic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: 'haversine', lat1, lon1, lat2, lon2 })
            })
            .then(res => res.json())
            .then(data => {
                badge.innerText = 'CALCULATED';
                badge.className = 'bg-green-500/20 text-green-300 px-2 py-0.5 rounded';

                logTerm.innerHTML += `
                    <span class="text-slate-400">1. Konversi Radian: &Delta;Lat = ${data.steps.dLat_rad.toFixed(4)} rad, &Delta;Lon = ${data.steps.dLon_rad.toFixed(4)} rad</span><br>
                    <span class="text-slate-400">2. Term A (Sinus Kuadrat): ${data.steps.term_a.toFixed(6)}</span><br>
                    <span class="text-slate-400">3. Term C (Sudut Kelengkungan): ${data.steps.term_c.toFixed(6)} rad</span><br>
                    <span class="text-indigo-300 mt-2 block font-bold">> Jarak Lingkaran Besar: R &times; c = ${data.distance_km} KM</span>
                `;
            })
            .catch(err => {
                badge.innerText = 'ERROR';
                badge.className = 'bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded';
                logTerm.innerHTML += `<span class="text-rose-400">[EXCEPTION] Gagal menguji GPS geolocator: ${err.message}</span>`;
            });
        }

        function runBlendedDiagnostic() {
            const docScore = parseFloat(document.getElementById('doc-score-input').value);
            const assScore = parseFloat(document.getElementById('ass-score-input').value);
            const logTerm = document.getElementById('blended-terminal-log');
            const badge = document.getElementById('blended-badge');

            if (isNaN(docScore) || isNaN(assScore)) {
                logTerm.innerHTML = `<span class="text-amber-400">[WARNING] Masukkan angka valid untuk kedua skor.</span>`;
                return;
            }

            badge.innerText = 'CALCULATING';
            badge.className = 'bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded';
            logTerm.innerHTML = `<span class="text-indigo-400">> Menggabungkan Bobot AI (60%) dan Bobot Manual (40%)...</span><br>`;

            setTimeout(() => {
                const weightedDoc = docScore * 0.6;
                const weightedAss = assScore * 0.4;
                const finalScore = weightedDoc + weightedAss;

                badge.innerText = 'CALCULATED';
                badge.className = 'bg-green-500/20 text-green-300 px-2 py-0.5 rounded';

                logTerm.innerHTML += `
                    <span class="text-slate-400">1. Skor Dokumen (${docScore}) &times; 60% = ${weightedDoc.toFixed(2)}</span><br>
                    <span class="text-slate-400">2. Skor Asesmen (${assScore}) &times; 40% = ${weightedAss.toFixed(2)}</span><br>
                    <span class="text-indigo-300 mt-2 block font-bold">> Final Blended Match Score: ${finalScore.toFixed(2)}%</span>
                `;
            }, 500); // Simulate processing time
        }
    </script>
</x-app-layout>
