<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Competency;
use App\Models\AdminCourseChapter;
use App\Models\AdminCourseMaterial;
use App\Models\AdminQuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('competency');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhereHas('competency', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($level = $request->input('level')) {
            $query->where('level', $level);
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $courses = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $competencies = Competency::orderBy('name')->get();
        return view('admin.courses.create', compact('competencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'platform' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'duration_hours' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'url' => 'nullable|url|max:255',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
        ]);

        $validated['is_free'] = $request->has('is_free');
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        $validated['created_by'] = auth()->id();

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        $course->load(['chapters.materials.quizQuestions', 'competency', 'creator']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $competencies = Competency::orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'competencies'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'platform' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'duration_hours' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'url' => 'nullable|url|max:255',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
        ]);

        $validated['is_free'] = $request->has('is_free');
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }

    // Chapter Management
    public function storeChapter(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $validated['course_id'] = $course->id;
        $validated['order_number'] = $course->chapters()->count() + 1;

        AdminCourseChapter::create($validated);

        return back()->with('success', 'Chapter berhasil ditambahkan.');
    }

    public function updateChapter(Request $request, AdminCourseChapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $chapter->update($validated);

        return back()->with('success', 'Chapter berhasil diperbarui.');
    }

    public function destroyChapter(AdminCourseChapter $chapter)
    {
        $chapter->delete();
        return back()->with('success', 'Chapter berhasil dihapus.');
    }

    // Material Management
    public function storeMaterial(Request $request, AdminCourseChapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,link,text,embed,assignment,quiz',
            'content' => 'nullable|string',
            'external_url' => 'nullable|string|max:500',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,avi,mov,mp3,jpg,jpeg,png,gif,webp,zip,rar',
            'is_downloadable' => 'boolean',
        ]);

        $validated['is_downloadable'] = $request->has('is_downloadable');
        $validated['chapter_id'] = $chapter->id;
        $validated['order_number'] = $chapter->materials()->count() + 1;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('admin/materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        AdminCourseMaterial::create($validated);

        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function updateMaterial(Request $request, AdminCourseMaterial $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,link,text,embed,assignment,quiz',
            'content' => 'nullable|string',
            'external_url' => 'nullable|string|max:500',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,avi,mov,mp3,jpg,jpeg,png,gif,webp,zip,rar',
            'is_downloadable' => 'boolean',
        ]);

        $validated['is_downloadable'] = $request->has('is_downloadable');

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('admin/materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        $material->update($validated);

        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroyMaterial(AdminCourseMaterial $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }

    public function downloadMaterial(AdminCourseMaterial $material)
    {
        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    // Quiz Question Management
    public function storeQuizQuestion(Request $request, AdminCourseMaterial $material)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'points' => 'nullable|integer|min:1',
        ]);

        $validated['material_id'] = $material->id;
        $validated['order_number'] = $material->quizQuestions()->count() + 1;
        $validated['points'] = $validated['points'] ?? 1;

        AdminQuizQuestion::create($validated);

        return back()->with('success', 'Soal kuis berhasil ditambahkan.');
    }

    public function updateQuizQuestion(Request $request, AdminQuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'points' => 'nullable|integer|min:1',
        ]);

        $validated['points'] = $validated['points'] ?? 1;

        $question->update($validated);

        return back()->with('success', 'Soal kuis berhasil diperbarui.');
    }

    public function destroyQuizQuestion(AdminQuizQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Soal kuis berhasil dihapus.');
    }
}
