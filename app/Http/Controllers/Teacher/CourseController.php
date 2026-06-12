<?php

namespace App\Http\Controllers\Teacher;

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

        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        $competencies = Competency::orderBy('name')->get();
        return view('teacher.courses.create', compact('competencies'));
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

        return redirect()->route('teacher.courses.index')->with('success', 'Kursus berhasil dibuat.');
    }

    public function show(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->load(['modules.materials', 'competency', 'classes.enrollments.user']);

        return view('teacher.courses.show', compact('course'));
    }

    public function edit(TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $competencies = Competency::orderBy('name')->get();
        return view('teacher.courses.edit', compact('course', 'competencies'));
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

        return redirect()->route('teacher.courses.index')->with('success', 'Kursus berhasil diperbarui.');
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

        return redirect()->route('teacher.courses.index')->with('success', 'Kursus berhasil dihapus.');
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

    // Module Management
    public function storeModule(Request $request, TeacherCourse $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $validated['course_id'] = $course->id;
        $validated['order_number'] = $course->modules()->count() + 1;

        CourseModule::create($validated);

        return back()->with('success', 'Modul berhasil ditambahkan.');
    }

    public function updateModule(Request $request, CourseModule $module)
    {
        if ($module->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $module->update($validated);

        return back()->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroyModule(CourseModule $module)
    {
        if ($module->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $module->delete();

        return back()->with('success', 'Modul berhasil dihapus.');
    }

    // Material Management
    public function storeMaterial(Request $request, CourseModule $module)
    {
        if ($module->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,link,assignment,quiz',
            'content' => 'nullable|string',
            'external_url' => 'nullable|url|max:500',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,avi,mov,mp3,jpg,jpeg,png,gif,webp,zip,rar',
            'is_downloadable' => 'boolean',
        ]);

        $validated['is_downloadable'] = $request->has('is_downloadable');
        $validated['module_id'] = $module->id;
        $validated['order_number'] = $module->materials()->count() + 1;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('teacher/materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        CourseMaterial::create($validated);

        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function updateMaterial(Request $request, CourseMaterial $material)
    {
        if ($material->module->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,link,assignment,quiz',
            'content' => 'nullable|string',
            'external_url' => 'nullable|url|max:500',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,avi,mov,mp3,jpg,jpeg,png,gif,webp,zip,rar',
            'is_downloadable' => 'boolean',
        ]);

        $validated['is_downloadable'] = $request->has('is_downloadable');

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('teacher/materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        $material->update($validated);

        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroyMaterial(CourseMaterial $material)
    {
        if ($material->module->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }

    public function downloadMaterial(CourseMaterial $material)
    {
        if ($material->module->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }
}
