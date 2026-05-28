<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Services\ProgramService;

class ProgramController extends Controller
{
    protected $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index()
    {
        $data = $this->programService->getProgramsData();
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
}
