<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    protected $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'type']);
        $data = $this->programService->getProgramsData($filters);
        return view('education.programs', $data);
    }

    public function create()
    {
        $options = $this->programService->getProgramFormOptions();
        return view('education.programs-create', $options);
    }

    public function store(StoreProgramRequest $request)
    {
        $this->programService->storeProgram($request->validated(), $request->file('curriculum_file'));

        return redirect()->route('education.programs')->with('success', 'Program berhasil ditambahkan!');
    }

    public function edit(Program $program)
    {
        $options = $this->programService->getProgramFormOptions();
        return view('education.programs-edit', array_merge($options, compact('program')));
    }

    public function update(UpdateProgramRequest $request, Program $program)
    {
        $validated = $request->validated();

        $validated['max_students'] = $validated['target_students'];
        unset($validated['target_students']);

        if ($request->hasFile('curriculum_file')) {
            $validated['curriculum_path'] = $request->file('curriculum_file')->store('curriculum', 'public');
        }

        $validated = $this->programService->sanitizeData($validated);

        $program->update($validated);

        return redirect()->route('education.programs')->with('success', 'Program berhasil diperbarui!');
    }

    public function destroy(Program $program)
    {
        try {
            $program->delete();
            return redirect()->route('education.programs')->with('success', 'Program berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('education.programs')->with('error', 'Gagal menghapus program: ' . $e->getMessage());
        }
    }

    public function report(Program $program)
    {
        $enrollments = $program->enrollments()->with('user')->get();
        $totalEnrolled = $enrollments->count();
        $completionRate = $totalEnrolled > 0 ? round(($enrollments->where('status', 'completed')->count() / $totalEnrolled) * 100, 1) : 0;

        return view('education.programs-report', compact('program', 'enrollments', 'totalEnrolled', 'completionRate'));
    }
}
