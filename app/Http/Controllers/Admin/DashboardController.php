<?php

namespace App\Http\Controllers\Admin;

use App\Services\JobMatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\JobListing;
use App\Models\UserAssessment;
use App\Models\UserCompetencyScore;
use App\Models\Competency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\ReportExportService;
use App\Jobs\SendDashboardReportJob;

class DashboardController extends Controller
{
    public function index() 
    {
        $stats = Cache::remember('admin.dashboard.stats', 300, function () {
            return [
                'total_users' => User::count(),
                'total_assessments' => UserAssessment::count(),
                'active_jobs' => JobListing::where('is_active', true)->count(),
                'latest_users' => User::latest()->take(5)->get(),
            ];
        });
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        
        $stats = Cache::remember('admin.users.stats', 300, function () {
            return [
                'total' => User::count(),
                'job_seeker' => User::where('role', 'job_seeker')->count(),
                'industry' => User::where('role', 'industry')->count(),
                'education' => User::where('role', 'education')->count(),
            ];
        });

        return view('admin.users', compact('users', 'stats'));
    }

    public function competencies()
    {
        $competencies = Competency::latest()->paginate(10);
        return view('admin.competencies', compact('competencies'));
    }

    public function reports(Request $request, ReportExportService $exportService)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date|before_or_equal:today',
            'end_date' => 'nullable|date|before_or_equal:today|after_or_equal:start_date',
        ]);

        $startDate = $validated['start_date'] ?? now()->subMonth()->format('Y-m-d');
        $endDate = $validated['end_date'] ?? now()->format('Y-m-d');

        // Basic Stats
        $totalUsers = User::count();
        $totalAssessments = UserAssessment::count();
        
        // Stats compared to last month
        $lastMonthUsers = User::where('created_at', '<', now()->subMonth())->count();
        $userGrowth = $lastMonthUsers > 0 ? (($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 0;

        $lastMonthAssessments = UserAssessment::where('created_at', '<', now()->subMonth())->count();
        $assessmentGrowth = $lastMonthAssessments > 0 ? (($totalAssessments - $lastMonthAssessments) / $lastMonthAssessments) * 100 : 0;

        // Skill Gap Average
        $avgSkillGap = UserAssessment::avg('total_gap_percentage') ?? 0;

        // Top Skills berdasarkan jumlah asesmen kompetensi
        $topSkills = UserCompetencyScore::join('competencies', 'user_competency_scores.competency_id', '=', 'competencies.id')
            ->select('competencies.name', DB::raw('COUNT(*) as count'))
            ->groupBy('competencies.id', 'competencies.name')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->toArray();

        // Pertumbuhan pengguna per bulan (6 bulan terakhir) - single query
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        $monthlyData = User::where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, COUNT(*) as count")
            ->groupBy('month_key')
            ->pluck('count', 'month_key')
            ->toArray();

        $monthlyGrowth = collect(range(5, 0))->map(function ($monthsAgo) use ($monthlyData) {
            $date = now()->subMonths($monthsAgo);
            $key = $date->format('Y-m');
            return [
                'label' => $date->format('M'),
                'count' => $monthlyData[$key] ?? 0,
            ];
        })->toArray();

        $monthlyGrowth = [
            'labels' => array_column($monthlyGrowth, 'label'),
            'data' => array_column($monthlyGrowth, 'count'),
        ];

        $data = compact('totalUsers', 'totalAssessments', 'userGrowth', 'assessmentGrowth', 'avgSkillGap', 'topSkills', 'startDate', 'endDate', 'monthlyGrowth');

        if ($request->has('export')) {
            if ($request->export === 'pdf') {
                return $exportService->exportPDF($data);
            } elseif ($request->export === 'excel') {
                return $exportService->exportExcel($data);
            }
        }

        return view('admin.reports', $data);
    }

    public function sendEmail(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        SendDashboardReportJob::dispatch(auth()->user()->email, $startDate, $endDate);

        return back()->with('success', 'Laporan sedang diproses di latar belakang dan akan segera dikirim ke email Anda (' . auth()->user()->email . ')');
    }

    /**
     * Halaman Alur Kerja AI & Diagnostik Sistem
     */
    public function aiWorkflow()
    {
        // Mendapatkan statistik dasar antrean dokumen
        $queueStats = [
            'total_documents' => \App\Models\UserDocument::count(),
            'pending_documents' => \App\Models\UserDocument::where('status', \App\Models\UserDocument::STATUS_PENDING ?? 'pending')->count(),
            'processing_documents' => \App\Models\UserDocument::where('status', 'processing')->count(),
            'completed_documents' => \App\Models\UserDocument::where('status', \App\Models\UserDocument::STATUS_COMPLETED ?? 'completed')->count(),
        ];

        // Dapatkan semua pelamar (job seeker) untuk dropdown diagnostik
        $users = \App\Models\User::where('role', 'job_seeker')->get();

        return view('admin.ai_workflow', compact('queueStats', 'users'));
    }

    /**
     * Dapatkan daftar dokumen milik user via AJAX
     */
    public function getUserDocuments($userId)
    {
        $documents = \App\Models\UserDocument::where('user_id', $userId)->get();
        return response()->json([
            'documents' => $documents,
            'success' => true
        ]);
    }

    /**
     * Ekstrak teks dokumen riil secara on-the-fly untuk kebutuhan Diagnostik Live via AJAX
     */
    public function extractDocumentText($documentId, \App\Services\DocumentExtractionService $extractionService)
    {
        try {
            $document = \App\Models\UserDocument::findOrFail($documentId);
            $text = $extractionService->extractTextFromFile($document);
            return response()->json([
                'text' => $text,
                'document_type' => $document->document_type,
                'success' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal ekstrak dokumen', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => 'Gagal memproses dokumen. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * API Diagnostik Live AI
     */
    public function runDiagnostic(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:ping,nlp,matching',
            'cv_text' => 'nullable|string|max:5000',
            'document_type' => 'nullable|string|max:50',
            'target_position' => 'nullable|string|max:100',
        ]);

        $type = $validated['type'];

        switch ($type) {
            case 'ping':
                $startTime = microtime(true);
                $url = config('services.python_api.url', 'http://localhost:5000/api');
                $baseUrl = str_replace('/api', '', $url);
                try {
                    $response = \Illuminate\Support\Facades\Http::timeout(3)->get($baseUrl);
                    $latency = round((microtime(true) - $startTime) * 1000, 1);
                    return response()->json([
                        'status' => 'online',
                        'url' => $baseUrl,
                        'latency_ms' => $latency,
                        'response_code' => $response->status(),
                        'success' => true
                    ]);
                } catch (\Exception $e) {
                    Log::error('Diagnostic API offline', ['url' => $baseUrl, 'error' => $e->getMessage()]);
                    return response()->json([
                        'status' => 'offline',
                        'url' => $baseUrl,
                        'error' => 'Layanan tidak dapat dijangkau.',
                        'success' => false
                    ]);
                }

            case 'nlp':
                $cvText = $request->input('cv_text', '');
                $docType = strtolower($request->input('document_type', 'cv'));
                $targetPosition = $request->input('target_position', 'General');
                $payload = [
                    'text' => $cvText,
                    'target_position' => $targetPosition,
                    'user_id' => auth()->id(),
                    'document_type' => $docType
                ];
                $url = config('services.python_api.url', 'http://localhost:5000/api') . '/extract-document';

                $startTime = microtime(true);
                try {
                    $response = \Illuminate\Support\Facades\Http::timeout(5)->post($url, $payload);
                    $latency = round((microtime(true) - $startTime) * 1000, 1);
                    if ($response->successful()) {
                        return response()->json([
                            'mode' => 'live',
                            'endpoint' => $url,
                            'latency_ms' => $latency,
                            'input_payload' => $payload,
                            'output_response' => $response->json(),
                            'success' => true
                        ]);
                    } else {
                        throw new \Exception("Flask returned status: " . $response->status() . " with body: " . $response->body());
                    }
                } catch (\Exception $e) {
                    // Fallback Simulation Mode - ambil kompetensi dari database
                    $extracted = [];
                    $skillsToCheck = ['python', 'laravel', 'sql', 'seo', 'communication', 'php', 'javascript', 'css', 'html', 'react', 'git'];
                    foreach ($skillsToCheck as $skill) {
                        if (str_contains(strtolower($cvText), $skill)) {
                            $extracted[] = [
                                'skill_name' => ucfirst($skill),
                                'category' => in_array($skill, ['python', 'laravel', 'php', 'sql', 'javascript', 'react']) ? 'programming' : 'general',
                                'confidence' => round(0.7 + (rand(0, 25) / 100), 2)
                            ];
                        }
                    }

                    // Ambil target skills dari database berdasarkan posisi
                    $targetPosition = $request->input('target_position', 'General');
                    $position = \App\Models\Position::where('name', 'like', "%{$targetPosition}%")->first();
                    $targetSkillsFromDb = $position
                        ? \App\Models\Competency::where('position_id', $position->id)
                            ->select('name', 'min_level_required', 'category')
                            ->get()
                            ->map(fn($c) => [
                                'skill_name' => $c->name,
                                'required_level' => $c->min_level_required / 5,
                                'category' => $c->category === 'soft_skill' ? 'soft_skills' : 'programming',
                            ])
                            ->toArray()
                        : [];

                    // Fallback jika tidak ada kompetensi di DB
                    if (empty($targetSkillsFromDb)) {
                        $targetSkillsFromDb = [
                            ['skill_name' => 'Python', 'required_level' => 1.0, 'category' => 'programming'],
                            ['skill_name' => 'SQL', 'required_level' => 0.8, 'category' => 'database'],
                            ['skill_name' => 'Laravel', 'required_level' => 0.9, 'category' => 'web_development'],
                        ];
                    }

                    // Hitung detailed_gap berdasarkan extracted skills
                    $detailedGap = [];
                    foreach ($targetSkillsFromDb as $ts) {
                        $skillLower = strtolower($ts['skill_name']);
                        $found = collect($extracted)->first(fn($e) => strtolower($e['skill_name']) === $skillLower);
                        $userLevel = $found ? $found['confidence'] : 0.0;
                        $targetLevel = $ts['required_level'];
                        $gap = max(0, $targetLevel - $userLevel);
                        $detailedGap[$skillLower] = [
                            'target_level' => $targetLevel,
                            'user_level' => $userLevel,
                            'gap' => $gap,
                            'gap_percentage' => round($gap * 100, 1),
                            'priority' => $gap > 0.3 ? 'HIGH' : 'LOW',
                        ];
                    }

                    return response()->json([
                        'mode' => 'simulation',
                        'endpoint' => $url,
                        'error_message' => 'Flask offline. Menggunakan fallback.',
                        'explanation' => 'Flask offline. Menggunakan Fallback NLP Keyword Extraction berbasis Regex Laravel.',
                        'input_payload' => $payload,
                        'output_response' => [
                            'extracted_skills' => $extracted,
                            'target_skills' => $targetSkillsFromDb,
                            'skill_gap' => [
                                'cosine_similarity' => empty($extracted) ? 0.0 : round(0.6 + (rand(0, 30) / 100), 2),
                                'overall_match_percentage' => empty($extracted) ? 0.0 : round(60 + rand(0, 30), 1),
                                'detailed_gap' => $detailedGap,
                            ]
                        ],
                        'success' => true
                    ]);
                }

            case 'cosine':
                $userSkillsRaw = $request->input('user_skills', '');
                $targetSkillsRaw = $request->input('target_skills', '');

                $userSkills = [];
                foreach (explode(',', $userSkillsRaw) as $item) {
                    $parts = explode(':', trim($item));
                    if (count($parts) == 2) {
                        $userSkills[strtolower(trim($parts[0]))] = (float)trim($parts[1]);
                    }
                }

                $targetSkills = [];
                foreach (explode(',', $targetSkillsRaw) as $item) {
                    $parts = explode(':', trim($item));
                    if (count($parts) == 2) {
                        $targetSkills[strtolower(trim($parts[0]))] = (float)trim($parts[1]);
                    }
                }

                $weights = [
                    'programming' => 0.3,
                    'web_development' => 0.25,
                    'database' => 0.15,
                    'data_science' => 0.2,
                    'cloud' => 0.15,
                    'soft_skills' => 0.1,
                    'general' => 0.15
                ];

                $skillCategories = [
                    'python' => 'programming',
                    'sql' => 'database',
                    'laravel' => 'web_development',
                    'react' => 'web_development',
                    'seo' => 'general',
                    'communication' => 'soft_skills'
                ];

                $vectorUser = [];
                $vectorTarget = [];
                $allSkillNames = array_unique(array_merge(array_keys($userSkills), array_keys($targetSkills)));

                $dotProduct = 0.0;
                $magnitudeUserSq = 0.0;
                $magnitudeTargetSq = 0.0;
                $steps = [];

                foreach ($allSkillNames as $skill) {
                    $uConfidence = $userSkills[$skill] ?? 0.0;
                    $tRequired = $targetSkills[$skill] ?? 0.0;

                    $cat = $skillCategories[$skill] ?? 'general';
                    $weight = $weights[$cat] ?? 0.15;

                    $uWeighted = $uConfidence * $weight;
                    $tWeighted = $tRequired * $weight;

                    $vectorUser[$skill] = $uWeighted;
                    $vectorTarget[$skill] = $tWeighted;

                    $prod = $uWeighted * $tWeighted;
                    $dotProduct += $prod;

                    $magnitudeUserSq += $uWeighted ** 2;
                    $magnitudeTargetSq += $tWeighted ** 2;

                    $steps[] = [
                        'skill' => ucfirst($skill),
                        'category' => $cat,
                        'weight' => $weight,
                        'user_confidence' => $uConfidence,
                        'user_weighted' => $uWeighted,
                        'target_required' => $tRequired,
                        'target_weighted' => $tWeighted,
                        'dot_product_term' => $prod
                    ];
                }

                $magnitudeUser = sqrt($magnitudeUserSq);
                $magnitudeTarget = sqrt($magnitudeTargetSq);

                $cosineSim = ($magnitudeUser == 0 || $magnitudeTarget == 0) ? 0.0 : $dotProduct / ($magnitudeUser * $magnitudeTarget);
                $similarityPercentage = round($cosineSim * 100, 1);

                return response()->json([
                    'steps' => $steps,
                    'dot_product' => $dotProduct,
                    'magnitude_user_sq' => $magnitudeUserSq,
                    'magnitude_user' => $magnitudeUser,
                    'magnitude_target_sq' => $magnitudeTargetSq,
                    'magnitude_target' => $magnitudeTarget,
                    'cosine_similarity' => $cosineSim,
                    'similarity_percentage' => $similarityPercentage,
                    'success' => true
                ]);

            case 'haversine':
                $lat1 = (float)$request->input('lat1', -6.2088);
                $lon1 = (float)$request->input('lon1', 106.8456);
                $lat2 = (float)$request->input('lat2', -6.9175);
                $lon2 = (float)$request->input('lon2', 107.6191);

                $dLat = deg2rad($lat2 - $lat1);
                $dLon = deg2rad($lon2 - $lon1);

                $a = sin($dLat / 2) * sin($dLat / 2)
                   + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
                   * sin($dLon / 2) * sin($dLon / 2);

                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $earthRadius = 6371;
                $distance = $earthRadius * $c;

                return response()->json([
                    'input' => [
                        'coord1' => ['lat' => $lat1, 'lon' => $lon1],
                        'coord2' => ['lat' => $lat2, 'lon' => $lon2]
                    ],
                    'steps' => [
                        'dLat_rad' => $dLat,
                        'dLon_rad' => $dLon,
                        'term_a' => $a,
                        'term_c' => $c,
                        'earth_radius_km' => $earthRadius
                    ],
                    'distance_km' => round($distance, 2),
                    'success' => true
                ]);

            default:
                return response()->json(['error' => 'Diagnostik tidak valid', 'success' => false], 400);
        }
    }
}
