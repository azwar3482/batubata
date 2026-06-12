<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherCourse;
use App\Models\CourseModule;
use App\Models\CourseMaterial;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = TeacherCourse::where('teacher_id', Auth::id())
            ->withCount(['modules', 'classes'])
            ->with('competency')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $courses->items(),
            'meta' => [
                'current_page' => $courses->currentPage(),
                'last_page' => $courses->lastPage(),
                'total' => $courses->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['is_free'] = $request->input('is_free', false);
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = is_array($validated['tags'])
                ? $validated['tags']
                : array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('teacher/thumbnails', 'public');
        }

        $validated['teacher_id'] = Auth::id();
        $validated['status'] = 'draft';

        $course = TeacherCourse::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kursus berhasil dibuat.',
            'data' => $course
        ], 201);
    }

    public function show($id)
    {
        $course = TeacherCourse::with(['modules.materials', 'competency', 'classes.enrollments.user'])->findOrFail($id);

        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function update(Request $request, $id)
    {
        $course = TeacherCourse::findOrFail($id);

        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['is_free'] = $request->input('is_free', false);
        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = is_array($validated['tags'])
                ? $validated['tags']
                : array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail_path) {
                Storage::disk('public')->delete($course->thumbnail_path);
            }
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('teacher/thumbnails', 'public');
        }

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kursus berhasil diperbarui.',
            'data' => $course
        ]);
    }

    public function destroy($id)
    {
        $course = TeacherCourse::findOrFail($id);

        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if ($course->thumbnail_path) {
            Storage::disk('public')->delete($course->thumbnail_path);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kursus berhasil dihapus.'
        ]);
    }

    public function publish($id)
    {
        $course = TeacherCourse::findOrFail($id);

        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $course->update(['status' => 'published']);

        return response()->json([
            'success' => true,
            'message' => 'Kursus berhasil dipublikasikan.',
            'data' => $course
        ]);
    }

    public function unpublish($id)
    {
        $course = TeacherCourse::findOrFail($id);

        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $course->update(['status' => 'draft']);

        return response()->json([
            'success' => true,
            'message' => 'Kursus berhasil dikembalikan ke draft.',
            'data' => $course
        ]);
    }

    // Module Management
    public function storeModule(Request $request, $courseId)
    {
        $course = TeacherCourse::findOrFail($courseId);

        if ($course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['course_id'] = $course->id;
        $validated['order_number'] = $course->modules()->count() + 1;

        $module = CourseModule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil ditambahkan.',
            'data' => $module
        ], 201);
    }

    public function updateModule(Request $request, $moduleId)
    {
        $module = CourseModule::with('course')->findOrFail($moduleId);

        if ($module->course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $module->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil diperbarui.',
            'data' => $module
        ]);
    }

    public function destroyModule($moduleId)
    {
        $module = CourseModule::with('course')->findOrFail($moduleId);

        if ($module->course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $module->delete();

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil dihapus.'
        ]);
    }

    // Material Management
    public function storeMaterial(Request $request, $moduleId)
    {
        $module = CourseModule::with('course')->findOrFail($moduleId);

        if ($module->course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,link,assignment,quiz',
            'content' => 'nullable|string',
            'external_url' => 'nullable|url|max:500',
            'file' => 'nullable|file|max:51200',
            'is_downloadable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['is_downloadable'] = $request->input('is_downloadable', false);
        $validated['module_id'] = $module->id;
        $validated['order_number'] = $module->materials()->count() + 1;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('teacher/materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        $material = CourseMaterial::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil ditambahkan.',
            'data' => $material
        ], 201);
    }

    public function updateMaterial(Request $request, $materialId)
    {
        $material = CourseMaterial::with('module.course')->findOrFail($materialId);

        if ($material->module->course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,link,assignment,quiz',
            'content' => 'nullable|string',
            'external_url' => 'nullable|url|max:500',
            'file' => 'nullable|file|max:51200',
            'is_downloadable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['is_downloadable'] = $request->input('is_downloadable', false);

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

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil diperbarui.',
            'data' => $material
        ]);
    }

    public function destroyMaterial($materialId)
    {
        $material = CourseMaterial::with('module.course')->findOrFail($materialId);

        if ($material->module->course->teacher_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil dihapus.'
        ]);
    }
}
