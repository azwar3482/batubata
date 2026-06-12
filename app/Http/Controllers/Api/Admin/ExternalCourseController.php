<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExternalCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('competency')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'platform' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'duration_hours' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'url' => 'required|url|max:255',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['is_free'] = $request->input('is_free', false);
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        $course = Course::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kursus eksternal berhasil ditambahkan.',
            'data' => $course
        ], 201);
    }

    public function show($id)
    {
        $course = Course::with('competency')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'platform' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'duration_hours' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'url' => 'required|url|max:255',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['is_free'] = $request->input('is_free', false);
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kursus eksternal berhasil diperbarui.',
            'data' => $course
        ]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kursus eksternal berhasil dihapus.'
        ]);
    }
}
