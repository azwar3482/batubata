<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetencyController extends Controller
{
    public function index()
    {
        $competencies = Competency::with('position')
            ->whereNull('company_id') // Standard competencies
            ->latest()
            ->paginate(20);
            
        return response()->json([
            'success' => true,
            'data' => $competencies->items(),
            'meta' => [
                'current_page' => $competencies->currentPage(),
                'last_page' => $competencies->lastPage(),
                'total' => $competencies->total(),
            ]
        ]);
    }

    public function show(Competency $competency)
    {
        $competency->load('position');
        return response()->json([
            'success' => true,
            'data' => $competency
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:competencies,code',
            'name' => 'required|string|max:255',
            'category' => 'required|in:technical,soft_skill',
            'position_id' => 'required|exists:positions,id',
            'min_level_required' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $competency = Competency::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kompetensi berhasil ditambahkan.',
            'data' => $competency
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $competency = Competency::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:competencies,code,' . $competency->id,
            'name' => 'required|string|max:255',
            'category' => 'required|in:technical,soft_skill',
            'position_id' => 'required|exists:positions,id',
            'min_level_required' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $competency->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kompetensi berhasil diperbarui.',
            'data' => $competency
        ]);
    }

    public function destroy($id)
    {
        $competency = Competency::findOrFail($id);
        $competency->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kompetensi berhasil dihapus.'
        ]);
    }
}
