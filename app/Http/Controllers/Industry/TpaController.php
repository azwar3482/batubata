<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\TpaQuestion;
use App\Models\TpaTest;
use App\Models\TpaResult;
use App\Models\TpaTestSession;
use App\Models\UserJobApplication;
use App\Models\JobListing;
use App\Services\TpaService;
use App\Imports\TpaQuestionImport;
use App\Exports\TpaQuestionTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TpaController extends Controller
{
    protected $tpaService;

    public function __construct(TpaService $tpaService)
    {
        $this->tpaService = $tpaService;
    }

    /**
     * Daftar tes TPA milik perusahaan
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');

        $tests = TpaTest::whereIn('job_listing_id', $jobIds)
            ->orWhere('created_by', $user->id)
            ->with('jobListing')
            ->latest()
            ->paginate(15);

        return view('industry.tpa.index', compact('tests'));
    }

    /**
     * Form buat tes TPA baru
     */
    public function create()
    {
        $user = Auth::user();
        $jobs = JobListing::where('user_id', $user->id)->where('is_active', true)->get();

        return view('industry.tpa.create', compact('jobs'));
    }

    /**
     * Simpan tes TPA baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:10|max:180',
            'verbal_count' => 'required|integer|min:0|max:50',
            'numerik_count' => 'required|integer|min:0|max:50',
            'logika_count' => 'required|integer|min:0|max:50',
            'spasial_count' => 'required|integer|min:0|max:50',
            'passing_score' => 'required|numeric|min:0|max:100',
            'verbal_weight' => 'required|numeric|min:0|max:100',
            'numerik_weight' => 'required|numeric|min:0|max:100',
            'logika_weight' => 'required|numeric|min:0|max:100',
            'spasial_weight' => 'required|numeric|min:0|max:100',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'show_result_after' => 'boolean',
        ]);

        // Validasi bahwa total weight = 100
        $totalWeight = $validated['verbal_weight'] + $validated['numerik_weight'] +
                       $validated['logika_weight'] + $validated['spasial_weight'];
        if ($totalWeight != 100) {
            return back()->withErrors(['verbal_weight' => 'Total bobot harus 100%.'])->withInput();
        }

        $this->tpaService->createTest($validated, auth()->id());

        // Aktifkan TPA di job listing jika dipilih
        if (!empty($validated['job_listing_id'])) {
            JobListing::where('id', $validated['job_listing_id'])->update(['use_tpa' => true]);
        }

        return redirect()->route('industry.tpa.index')->with('success', 'Tes TPA berhasil dibuat!');
    }

    /**
     * Edit tes TPA
     */
    public function edit(TpaTest $test)
    {
        $user = Auth::user();

        // Pastikan milik user ini
        if ($test->created_by !== $user->id) {
            abort(403);
        }

        $jobs = JobListing::where('user_id', $user->id)->where('is_active', true)->get();

        return view('industry.tpa.edit', compact('test', 'jobs'));
    }

    /**
     * Update tes TPA
     */
    public function update(Request $request, TpaTest $test)
    {
        $user = Auth::user();
        if ($test->created_by !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:10|max:180',
            'verbal_count' => 'required|integer|min:0|max:50',
            'numerik_count' => 'required|integer|min:0|max:50',
            'logika_count' => 'required|integer|min:0|max:50',
            'spasial_count' => 'required|integer|min:0|max:50',
            'passing_score' => 'required|numeric|min:0|max:100',
            'verbal_weight' => 'required|numeric|min:0|max:100',
            'numerik_weight' => 'required|numeric|min:0|max:100',
            'logika_weight' => 'required|numeric|min:0|max:100',
            'spasial_weight' => 'required|numeric|min:0|max:100',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'show_result_after' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $this->tpaService->updateTest($test, $validated);

        return redirect()->route('industry.tpa.index')->with('success', 'Tes TPA berhasil diupdate!');
    }

    /**
     * Hapus tes TPA
     */
    public function destroy(TpaTest $test)
    {
        $user = Auth::user();
        if ($test->created_by !== $user->id) {
            abort(403);
        }

        $test->delete();
        return redirect()->route('industry.tpa.index')->with('success', 'Tes TPA berhasil dihapus!');
    }

    /**
     * Kirim undangan TPA ke pelamar
     */
    public function inviteCandidate(Request $request, TpaTest $test)
    {
        $request->validate([
            'application_id' => 'required|exists:user_job_applications,id',
        ]);

        $application = UserJobApplication::findOrFail($request->application_id);

        // Pastikan lowongan milik user ini
        $job = JobListing::findOrFail($application->job_listing_id);
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        // Cek apakah sudah ada sesi untuk aplikasi ini
        $existingSession = TpaTestSession::where('job_application_id', $application->id)
            ->where('tpa_test_id', $test->id)
            ->whereIn('status', ['invited', 'in_progress'])
            ->first();

        if ($existingSession) {
            return back()->with('error', 'Kandidat ini sudah memiliki undangan TPA yang aktif.');
        }

        $this->tpaService->inviteCandidate($application, $test);

        return back()->with('success', 'Undangan TPA berhasil dikirim ke kandidat!');
    }

    /**
     * Kirim undangan TPA ke banyak pelamar sekaligus (bulk invite)
     */
    public function bulkInvite(Request $request)
    {
        $request->validate([
            'tpa_test_id' => 'required|exists:tpa_tests,id',
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'exists:user_job_applications,id',
        ]);

        $test = TpaTest::findOrFail($request->tpa_test_id);
        $user = auth()->user();

        // Pastikan tes milik user ini
        if ($test->created_by !== $user->id) {
            abort(403);
        }

        $successCount = 0;
        $failCount = 0;
        $errors = [];

        foreach ($request->application_ids as $appId) {
            $application = UserJobApplication::find($appId);

            if (!$application) {
                $failCount++;
                continue;
            }

            // Pastikan lowongan milik user ini
            $job = JobListing::find($application->job_listing_id);
            if (!$job || $job->user_id !== $user->id) {
                $failCount++;
                continue;
            }

            // Cek apakah sudah ada sesi aktif
            $existingSession = TpaTestSession::where('job_application_id', $application->id)
                ->where('tpa_test_id', $test->id)
                ->whereIn('status', ['invited', 'in_progress'])
                ->first();

            if ($existingSession) {
                $failCount++;
                $errors[] = "Kandidat {$application->user->name} sudah memiliki undangan aktif.";
                continue;
            }

            try {
                $this->tpaService->inviteCandidate($application, $test);
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                $errors[] = "Gagal mengundang {$application->user->name}: " . $e->getMessage();
            }
        }

        $message = "Berhasil mengirim {$successCount} undangan TPA.";
        if ($failCount > 0) {
            $message .= " {$failCount} gagal.";
        }

        return redirect()->route('industry.tpa.index')
            ->with('success', $message)
            ->with('invite_errors', $errors);
    }

    /**
     * Kirim undangan TPA offline ke banyak pelamar sekaligus
     */
    public function bulkInviteOffline(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'exists:user_job_applications,id',
            'offline_title' => 'nullable|string|max:255',
            'offline_instructions' => 'required|string',
            'offline_scheduled_at' => 'required|date',
            'offline_location' => 'required|string|max:255',
            'offline_contact_person' => 'nullable|string|max:255',
            'offline_contact_phone' => 'nullable|string|max:50',
            'offline_passing_score' => 'nullable|numeric|min:0|max:100',
            'offline_notes' => 'nullable|string',
        ]);

        $user = auth()->user();

        $offlineData = [
            'title' => $request->offline_title ?? 'Tes TPA Offline',
            'instructions' => $request->offline_instructions,
            'scheduled_at' => $request->offline_scheduled_at,
            'location' => $request->offline_location,
            'contact_person' => $request->offline_contact_person,
            'contact_phone' => $request->offline_contact_phone,
            'passing_score' => $request->offline_passing_score ?? 60,
            'notes' => $request->offline_notes,
        ];

        $successCount = 0;
        $failCount = 0;
        $errors = [];

        foreach ($request->application_ids as $appId) {
            $application = UserJobApplication::find($appId);

            if (!$application) {
                $failCount++;
                continue;
            }

            $job = JobListing::find($application->job_listing_id);
            if (!$job || $job->user_id !== $user->id) {
                $failCount++;
                continue;
            }

            $existingSession = TpaTestSession::where('job_application_id', $application->id)
                ->whereIn('status', ['invited', 'in_progress'])
                ->first();

            if ($existingSession) {
                $failCount++;
                $errors[] = "Kandidat {$application->user->name} sudah memiliki undangan aktif.";
                continue;
            }

            try {
                $this->tpaService->inviteOffline($application, null, $offlineData);
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                $errors[] = "Gagal mengundang {$application->user->name}: " . $e->getMessage();
            }
        }

        $message = "Berhasil mengirim {$successCount} undangan TPA offline.";
        if ($failCount > 0) {
            $message .= " {$failCount} gagal.";
        }

        return redirect()->route('industry.tpa.index')
            ->with('success', $message)
            ->with('invite_errors', $errors);
    }

    /**
     * Input hasil TPA offline
     */
    public function submitOfflineResult(Request $request, TpaTestSession $session)
    {
        $request->validate([
            'offline_score' => 'required|numeric|min:0|max:100',
            'offline_is_passed' => 'required|boolean',
            'offline_result_notes' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Pastikan session milik perusahaan user
        if ($session->jobApplication) {
            $job = JobListing::find($session->jobApplication->job_listing_id);
            if (!$job || $job->user_id !== $user->id) {
                abort(403);
            }
        }

        $this->tpaService->submitOfflineResult(
            $session,
            $request->offline_score,
            $request->offline_is_passed,
            $request->offline_result_notes
        );

        return redirect()->route('industry.tpa.index')->with('success', 'Hasil TPA offline berhasil disimpan!');
    }

    /**
     * Lihat hasil TPA untuk lowongan tertentu
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');

        $query = TpaResult::with(['user', 'tpaTest', 'session.jobApplication'])
            ->whereHas('tpaTest', function ($q) use ($jobIds) {
                $q->whereIn('job_listing_id', $jobIds);
            })
            ->latest();

        if ($request->filled('test_id')) {
            $query->where('tpa_test_id', $request->test_id);
        }
        if ($request->filled('passed')) {
            $query->where('is_passed', $request->passed === '1');
        }

        $results = $query->paginate(20)->withQueryString();
        $tests = TpaTest::whereIn('job_listing_id', $jobIds)->get();

        return view('industry.tpa.results', compact('results', 'tests'));
    }

    /**
     * Detail hasil TPA
     */
    public function showResult(TpaResult $result)
    {
        $result->load(['user', 'tpaTest', 'session.answers.question']);

        return view('industry.tpa.show-result', compact('result'));
    }

    /**
     * Dashboard statistik TPA industry
     */
    public function dashboard()
    {
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');
        $testIds = TpaTest::whereIn('job_listing_id', $jobIds)->pluck('id');

        $stats = $this->tpaService->getStats();
        $totalTests = $testIds->count();
        $recentResults = TpaResult::with(['user', 'tpaTest'])
            ->whereIn('tpa_test_id', $testIds)
            ->latest()
            ->limit(10)
            ->get();

        return view('industry.tpa.dashboard', compact('stats', 'totalTests', 'recentResults'));
    }

    // ========================
    // BANK SOAL MANAGEMENT
    // ========================

    /**
     * Daftar bank soal TPA milik industri + soal global admin
     */
    public function questions(Request $request)
    {
        $user = Auth::user();

        $query = TpaQuestion::where(function ($q) use ($user, $request) {
            // Filter sumber
            if ($request->source === 'mine') {
                $q->where('created_by', $user->id);
            } elseif ($request->source === 'global') {
                $q->whereNull('created_by');
            } else {
                $q->where('created_by', $user->id)->orWhereNull('created_by');
            }
        })->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }
        if ($request->filled('search')) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }

        $questions = $query->paginate(20)->withQueryString();

        return view('industry.tpa.questions', compact('questions'));
    }

    /**
     * Form tambah soal baru
     */
    public function createQuestion()
    {
        return view('industry.tpa.create-question');
    }

    /**
     * Simpan soal baru
     */
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:verbal,numerik,logika,spasial',
            'subcategory' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|max:2048',
            'options' => 'required|array|min:2',
            'options.*.key' => 'required|string|max:5',
            'options.*.text' => 'required|string',
            'correct_answer' => 'required|string|max:5',
            'explanation' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;

        if ($request->hasFile('question_image')) {
            $validated['question_image'] = $request->file('question_image')->store('tpa/images', 'public');
        }

        TpaQuestion::create($validated);

        return redirect()->route('industry.tpa.questions')->with('success', 'Soal TPA berhasil ditambahkan!');
    }

    /**
     * Form edit soal
     */
    public function editQuestion(TpaQuestion $question)
    {
        $user = Auth::user();

        // Hanya bisa edit soal milik sendiri, bukan soal global admin
        if ($question->created_by !== $user->id) {
            abort(403, 'Anda hanya bisa mengedit soal milik sendiri.');
        }

        return view('industry.tpa.edit-question', compact('question'));
    }

    /**
     * Update soal
     */
    public function updateQuestion(Request $request, TpaQuestion $question)
    {
        $user = Auth::user();

        if ($question->created_by !== $user->id) {
            abort(403, 'Anda hanya bisa mengedit soal milik sendiri.');
        }

        $validated = $request->validate([
            'category' => 'required|in:verbal,numerik,logika,spasial',
            'subcategory' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|max:2048',
            'options' => 'required|array|min:2',
            'options.*.key' => 'required|string|max:5',
            'options.*.text' => 'required|string',
            'correct_answer' => 'required|string|max:5',
            'explanation' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('question_image')) {
            $validated['question_image'] = $request->file('question_image')->store('tpa/images', 'public');
        }

        $question->update($validated);

        return redirect()->route('industry.tpa.questions')->with('success', 'Soal TPA berhasil diupdate!');
    }

    /**
     * Hapus soal
     */
    public function destroyQuestion(TpaQuestion $question)
    {
        $user = Auth::user();

        if ($question->created_by !== $user->id) {
            abort(403, 'Anda hanya bisa menghapus soal milik sendiri.');
        }

        $question->delete();

        return redirect()->route('industry.tpa.questions')->with('success', 'Soal TPA berhasil dihapus!');
    }

    /**
     * Download template Excel untuk import soal
     */
    public function downloadTemplate()
    {
        return Excel::download(new TpaQuestionTemplateExport, 'template_import_soal_tpa.xlsx');
    }

    /**
     * Import soal dari Excel/CSV
     */
    public function importQuestions(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $user = Auth::user();

        try {
            $import = new TpaQuestionImport($user->id);
            Excel::import($import, $request->file('file'));

            $importedCount = $import->getImportedCount() ?? 'beberapa';
            $failures = $import->failures();

            $message = "Import berhasil! {$importedCount} soal telah ditambahkan.";

            if ($failures->isNotEmpty()) {
                $failureMessages = [];
                foreach ($failures->take(5) as $failure) {
                    $failureMessages[] = "Baris " . $failure->row() . ": " . implode(', ', $failure->errors());
                }
                $message .= " Ada " . $failures->count() . " baris yang gagal: " . implode(' | ', $failureMessages);
            }

            return redirect()->route('industry.tpa.questions')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('industry.tpa.questions')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    /**
     * Download hasil TPA dalam format PDF
     */
    public function downloadPdf(TpaResult $result)
    {
        // Pastikan hasil ini milik perusahaan user
        $user = Auth::user();
        $jobIds = JobListing::where('user_id', $user->id)->pluck('id');
        $testIds = TpaTest::whereIn('job_listing_id', $jobIds)->pluck('id');

        if (!in_array($result->tpa_test_id, $testIds->toArray())) {
            abort(403, 'Anda tidak memiliki akses ke hasil ini.');
        }

        $result->load(['user', 'tpaTest', 'session.answers.question']);

        $pdf = Pdf::loadView('pdf.tpa-result', compact('result'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Helvetica',
            ]);

        $filename = 'TPA_Result_' . str_replace(' ', '_', $result->user->name) . '_' . $result->created_at->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
