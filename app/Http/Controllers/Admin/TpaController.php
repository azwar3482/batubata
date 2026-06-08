<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpaQuestion;
use App\Models\TpaTest;
use App\Models\TpaResult;
use App\Services\TpaService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TpaController extends Controller
{
    protected $tpaService;

    public function __construct(TpaService $tpaService)
    {
        $this->tpaService = $tpaService;
    }

    // ========================
    // BANK SOAL MANAGEMENT
    // ========================

    public function questions(Request $request)
    {
        $query = TpaQuestion::latest();

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

        return view('admin.tpa.questions', compact('questions'));
    }

    public function createQuestion()
    {
        return view('admin.tpa.create-question');
    }

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

        return redirect()->route('admin.tpa.questions')->with('success', 'Soal TPA berhasil ditambahkan!');
    }

    public function editQuestion(TpaQuestion $question)
    {
        return view('admin.tpa.edit-question', compact('question'));
    }

    public function updateQuestion(Request $request, TpaQuestion $question)
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
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('question_image')) {
            $validated['question_image'] = $request->file('question_image')->store('tpa/images', 'public');
        }

        $question->update($validated);

        return redirect()->route('admin.tpa.questions')->with('success', 'Soal TPA berhasil diupdate!');
    }

    public function destroyQuestion(TpaQuestion $question)
    {
        $question->delete();
        return redirect()->route('admin.tpa.questions')->with('success', 'Soal TPA berhasil dihapus!');
    }

    // ========================
    // TES MANAGEMENT
    // ========================

    public function tests(Request $request)
    {
        $query = TpaTest::with('jobListing')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tests = $query->paginate(15)->withQueryString();

        return view('admin.tpa.tests', compact('tests'));
    }

    public function createTest()
    {
        return view('admin.tpa.create-test');
    }

    public function storeTest(Request $request)
    {
        $validated = $request->validate([
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

        $this->tpaService->createTest($validated, auth()->id());

        return redirect()->route('admin.tpa.tests')->with('success', 'Tes TPA berhasil dibuat!');
    }

    public function editTest(TpaTest $test)
    {
        return view('admin.tpa.edit-test', compact('test'));
    }

    public function updateTest(Request $request, TpaTest $test)
    {
        $validated = $request->validate([
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

        return redirect()->route('admin.tpa.tests')->with('success', 'Tes TPA berhasil diupdate!');
    }

    public function destroyTest(TpaTest $test)
    {
        $test->delete();
        return redirect()->route('admin.tpa.tests')->with('success', 'Tes TPA berhasil dihapus!');
    }

    // ========================
    // STATISTIK & HASIL
    // ========================

    public function results(Request $request)
    {
        $query = TpaResult::with(['user', 'tpaTest', 'session'])->latest();

        if ($request->filled('test_id')) {
            $query->where('tpa_test_id', $request->test_id);
        }
        if ($request->filled('passed')) {
            $query->where('is_passed', $request->passed === '1');
        }

        $results = $query->paginate(20)->withQueryString();
        $tests = TpaTest::all();

        return view('admin.tpa.results', compact('results', 'tests'));
    }

    public function showResult(TpaResult $result)
    {
        $result->load(['user', 'tpaTest', 'session.answers.question']);
        return view('admin.tpa.show-result', compact('result'));
    }

    public function dashboard()
    {
        $stats = $this->tpaService->getStats();
        $totalQuestions = TpaQuestion::active()->count();
        $totalTests = TpaTest::count();
        $recentResults = TpaResult::with(['user', 'tpaTest'])->latest()->limit(10)->get();

        return view('admin.tpa.dashboard', compact('stats', 'totalQuestions', 'totalTests', 'recentResults'));
    }

    /**
     * Download hasil TPA dalam format PDF
     */
    public function downloadPdf(TpaResult $result)
    {
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
