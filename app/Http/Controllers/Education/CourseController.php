<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('competency', 'creator')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('education.courses.index', compact('courses'));
    }

    public function create()
    {
        $competencies = Competency::orderBy('name')->get();
        return view('education.courses.create', compact('competencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'provider' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'duration_hours' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'url' => 'required|url|max:255',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'skills_covered' => 'nullable|string',
            'image_url' => 'nullable|url|max:500',
        ]);

        $validated['is_free'] = $request->has('is_free');
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        if (!empty($validated['skills_covered'])) {
            $validated['skills_covered'] = array_map('trim', explode(',', $validated['skills_covered']));
        }

        $validated['created_by'] = Auth::id();

        Course::create($validated);

        return redirect()->route('education.courses.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function edit(Course $course)
    {
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit kursus ini.');
        }

        $competencies = Competency::orderBy('name')->get();
        return view('education.courses.edit', compact('course', 'competencies'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit kursus ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'provider' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'duration_hours' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'url' => 'required|url|max:255',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'skills_covered' => 'nullable|string',
            'image_url' => 'nullable|url|max:500',
        ]);

        $validated['is_free'] = $request->has('is_free');
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        if (!empty($validated['skills_covered'])) {
            $validated['skills_covered'] = array_map('trim', explode(',', $validated['skills_covered']));
        }

        $course->update($validated);

        return redirect()->route('education.courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus kursus ini.');
        }

        $course->delete();

        return redirect()->route('education.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }
}
