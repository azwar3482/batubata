<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution;

        if (!$institution) {
            return response()->json([
                'success' => false,
                'message' => 'Institusi tidak ditemukan.'
            ], 404);
        }

        $programs = Program::where('institution_id', $institution->id)
            ->withCount('enrollments')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $programs->items(),
            'meta' => [
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
                'total' => $programs->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution;

        if (!$institution) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus memiliki profil institusi terlebih dahulu.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'max_students' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'industry_partners' => 'nullable', // array or string
            'curriculum_file' => 'nullable|file|max:51200',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['institution_id'] = $institution->id;
        $validated['status'] = 'active';

        if (!empty($validated['industry_partners'])) {
            $validated['industry_partners'] = is_array($validated['industry_partners'])
                ? $validated['industry_partners']
                : array_map('trim', explode(',', $validated['industry_partners']));
        }

        if ($request->hasFile('curriculum_file')) {
            $validated['curriculum_path'] = $request->file('curriculum_file')->store('curriculum', 'public');
        }

        $program = Program::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil ditambahkan!',
            'data' => $program
        ], 201);
    }
}
