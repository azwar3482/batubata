<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use App\Models\Position;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetencyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $companyId = $user->company_id;

        $query = Competency::with('position')
            ->where('company_id', $companyId)
            ->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $competencies = $query->paginate(10)->withQueryString();
        $positions = Position::all();

        return view('industry.competencies.index', compact('competencies', 'positions'));
    }

    public function create()
    {
        $positions = Position::all();
        $jobs = JobListing::where('company_id', Auth::user()->company_id)
            ->where('is_active', true)
            ->get();

        return view('industry.competencies.create', compact('positions', 'jobs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'code' => 'required|unique:competencies,code',
            'name' => 'required|string|max:255',
            'category' => 'required|in:technical,soft_skill',
            'position_id' => 'nullable|exists:positions,id',
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'min_level_required' => 'required|integer|min:1|max:10',
            'source_reference' => 'nullable|string',
        ]);

        $validated['company_id'] = $user->company_id;

        // If job_listing_id provided, get position_id from job
        if ($request->filled('job_listing_id') && !$request->filled('position_id')) {
            $job = JobListing::find($request->job_listing_id);
            if ($job && $job->position_id) {
                $validated['position_id'] = $job->position_id;
            }
        }

        Competency::create($validated);

        return redirect()->route('industry.competencies.index')->with('success', 'Kompetensi berhasil ditambahkan!');
    }

    public function edit(Competency $competency)
    {
        // Ensure company can only edit their own competencies
        if ($competency->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $positions = Position::all();
        $jobs = JobListing::where('company_id', Auth::user()->company_id)
            ->where('is_active', true)
            ->get();

        return view('industry.competencies.edit', compact('competency', 'positions', 'jobs'));
    }

    public function update(Request $request, Competency $competency)
    {
        if ($competency->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $validated = $request->validate([
            'code' => 'required|unique:competencies,code,' . $competency->id,
            'name' => 'required|string|max:255',
            'category' => 'required|in:technical,soft_skill',
            'position_id' => 'nullable|exists:positions,id',
            'min_level_required' => 'required|integer|min:1|max:10',
        ]);

        $competency->update($validated);

        return redirect()->route('industry.competencies.index')->with('success', 'Kompetensi berhasil diupdate!');
    }

    public function destroy(Competency $competency)
    {
        if ($competency->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $competency->delete();

        return redirect()->route('industry.competencies.index')->with('success', 'Kompetensi berhasil dihapus!');
    }
}
