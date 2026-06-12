<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\TeacherCourse;
use App\Models\CourseModule;
use App\Models\CourseMaterial;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = TeacherCourse::where('teacher_id', Auth::id())
            ->withCount(['modules', 'classes'])
            ->with('competency')
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
            'objectives' => 'nullable|string',
            'competency_id' => 'nullable|exists:competencies,id',
            'category' => 'required|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_hours' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'tags' => 'nullable|string',
            'max_students' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['is_free'] = $request->has('is_free');
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('teacher/thumbnails', 'public');
        }

        $validated['teacher_id'] = Auth::id();
        $validated['status'] = 'draft';

        TeacherCourse::create($validated);

        return redirect()->route('education.courses.index')->with('success', 'Kursus berhasil dibuat.');
    }

    public function show(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->load(['modules.materials', 'competency', 'classes.enrollments.user']);

        return view('education.courses.show', compact('course'));
    }

    public function edit(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $competencies = Competency::orderBy('name')->get();
        return view('education.courses.edit', compact('course', 'competencies'));
    }

    public function update(Request $request, TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'nullable|string',
            'competency_id' => 'nullable|exists:competencies,id',
            'category' => 'required|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_hours' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'tags' => 'nullable|string',
            'max_students' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['is_free'] = $request->has('is_free');
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail_path) {
                Storage::disk('public')->delete($course->thumbnail_path);
            }
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('teacher/thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('education.courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($course->thumbnail_path) {
            Storage::disk('public')->delete($course->thumbnail_path);
        }

        $course->delete();

        return redirect()->route('education.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }

    public function publish(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->update(['status' => 'published']);

        return back()->with('success', 'Kursus berhasil dipublikasikan.');
    }

    public function unpublish(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->update(['status' => 'draft']);

        return back()->with('success', 'Kursus dikembalikan ke draft.');
    }
}
