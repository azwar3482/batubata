<?php

namespace App\Http\Controllers\Admin;

use App\Services\JobMatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\JobListing;
use App\Models\UserAssessment;
use App\Models\Competency;
use Illuminate\Support\Facades\Auth;
use App\Services\ReportExportService;
use App\Jobs\SendDashboardReportJob;

class DashboardController extends Controller
{
    public function index() 
    {
        $stats = [
            'total_users' => User::count(),
            'total_assessments' => UserAssessment::count(),
            'active_jobs' => JobListing::where('is_active', true)->count(),
            'latest_users' => User::latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        
        $stats = [
            'total' => User::count(),
            'job_seeker' => User::where('role', 'job_seeker')->count(),
            'industry' => User::where('role', 'industry')->count(),
            'education' => User::where('role', 'education')->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    public function competencies()
    {
        $competencies = Competency::latest()->paginate(10);
        return view('admin.competencies', compact('competencies'));
    }

    public function reports(Request $request, ReportExportService $exportService)
    {
        $startDate = $request->input('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

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
        
        // Dummy data for top skills and user growth (simulating database query)
        $topSkills = [
            ['name' => 'Python', 'count' => 450],
            ['name' => 'SEO', 'count' => 380],
            ['name' => 'Google Analytics', 'count' => 350],
            ['name' => 'SQL', 'count' => 320],
            ['name' => 'Communication', 'count' => 300],
        ];

        $monthlyGrowth = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [120, 190, 300, 250, 280, 350]
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
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API Diagnostik Live AI
     */
    public function runDiagnostic(Request $request)
    {
        $type = $request->input('type');

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
                    return response()->json([
                        'status' => 'offline',
                        'url' => $baseUrl,
                        'error' => $e->getMessage(),
                        'success' => false
                    ]);
                }

            case 'nlp':
                $cvText = $request->input('cv_text', '');
                $docType = strtolower($request->input('document_type', 'cv')); // Default to cv for existing UI
                $payload = [
                    'text' => $cvText,
                    'target_position' => 'Web Developer',
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
                    // Fallback Simulation Mode
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

                    return response()->json([
                        'mode' => 'simulation',
                        'endpoint' => $url,
                        'error_message' => $e->getMessage(),
                        'explanation' => 'Flask offline. Menggunakan Fallback NLP Keyword Extraction berbasis Regex Laravel.',
                        'input_payload' => $payload,
                        'output_response' => [
                            'extracted_skills' => $extracted,
                            'target_skills' => [
                                ['skill_name' => 'Python', 'required_level' => 1.0, 'category' => 'programming'],
                                ['skill_name' => 'SQL', 'required_level' => 0.8, 'category' => 'database'],
                                ['skill_name' => 'Laravel', 'required_level' => 0.9, 'category' => 'web_development'],
                            ],
                            'skill_gap' => [
                                'cosine_similarity' => empty($extracted) ? 0.0 : round(0.6 + (rand(0, 30) / 100), 2),
                                'overall_match_percentage' => empty($extracted) ? 0.0 : round(60 + rand(0, 30), 1),
                                'detailed_gap' => [
                                    'python' => ['target_level' => 1.0, 'user_level' => str_contains(strtolower($cvText), 'python') ? 0.85 : 0.0, 'gap' => str_contains(strtolower($cvText), 'python') ? 0.15 : 1.0, 'gap_percentage' => str_contains(strtolower($cvText), 'python') ? 15.0 : 100.0, 'priority' => str_contains(strtolower($cvText), 'python') ? 'LOW' : 'HIGH'],
                                    'laravel' => ['target_level' => 0.9, 'user_level' => str_contains(strtolower($cvText), 'laravel') ? 0.9 : 0.0, 'gap' => str_contains(strtolower($cvText), 'laravel') ? 0.0 : 0.9, 'gap_percentage' => str_contains(strtolower($cvText), 'laravel') ? 0.0 : 100.0, 'priority' => str_contains(strtolower($cvText), 'laravel') ? 'LOW' : 'HIGH'],
                                    'sql' => ['target_level' => 0.8, 'user_level' => str_contains(strtolower($cvText), 'sql') ? 0.7 : 0.0, 'gap' => str_contains(strtolower($cvText), 'sql') ? 0.1 : 0.8, 'gap_percentage' => str_contains(strtolower($cvText), 'sql') ? 12.5 : 100.0, 'priority' => str_contains(strtolower($cvText), 'sql') ? 'LOW' : 'HIGH'],
                                ]
                            ]
                        ],
                        'success' => true
                    ]);
                }

            case 'cosine':
                $userSkillsRaw = $request->input('user_skills', 'Python:0.8, SQL:0.5, Laravel:0.9');
                $targetSkillsRaw = $request->input('target_skills', 'Python:0.9, SQL:0.8, Laravel:0.8, React:0.7');

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
