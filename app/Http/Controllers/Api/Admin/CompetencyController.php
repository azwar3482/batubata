<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    public function index()
    {
        $competencies = Competency::with('position')->paginate(20);
        return response()->json($competencies);
    }

    public function show(Competency $competency)
    {
        $competency->load('position');
        return response()->json($competency);
    }
}
