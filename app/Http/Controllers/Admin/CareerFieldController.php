<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerField;
use App\Models\CareerPath;
use Illuminate\Http\Request;

class CareerFieldController extends Controller
{
    public function index(Request $request)
    {
        $query = CareerField::withCount('paths');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fields = $query->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.career-fields.index', compact('fields'));
    }

    public function create()
    {
        return view('admin.career-fields.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:career_fields,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:20',
            'job_titles' => 'nullable|string',
            'industries' => 'nullable|string',
            'avg_salary_min' => 'nullable|numeric|min:0',
            'avg_salary_max' => 'nullable|numeric|min:0',
            'demand_score' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        // Parse comma-separated ke array
        $validated['job_titles'] = $request->filled('job_titles')
            ? array_map('trim', explode(',', $request->job_titles))
            : null;
        $validated['industries'] = $request->filled('industries')
            ? array_map('trim', explode(',', $request->industries))
            : null;
        $validated['is_active'] = $request->boolean('is_active', true);

        CareerField::create($validated);

        return redirect()->route('admin.career-fields.index')->with('success', 'Bidang karir berhasil ditambahkan!');
    }

    public function edit(CareerField $careerField)
    {
        $careerField->load('paths');
        return view('admin.career-fields.edit', compact('careerField'));
    }

    public function update(Request $request, CareerField $careerField)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:career_fields,slug,' . $careerField->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:20',
            'job_titles' => 'nullable|string',
            'industries' => 'nullable|string',
            'avg_salary_min' => 'nullable|numeric|min:0',
            'avg_salary_max' => 'nullable|numeric|min:0',
            'demand_score' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['job_titles'] = $request->filled('job_titles')
            ? array_map('trim', explode(',', $request->job_titles))
            : null;
        $validated['industries'] = $request->filled('industries')
            ? array_map('trim', explode(',', $request->industries))
            : null;
        $validated['is_active'] = $request->boolean('is_active', true);

        $careerField->update($validated);

        return redirect()->route('admin.career-fields.index')->with('success', 'Bidang karir berhasil diupdate!');
    }

    public function destroy(CareerField $careerField)
    {
        // Hapus semua path terkait
        $careerField->paths()->delete();
        $careerField->delete();

        return redirect()->route('admin.career-fields.index')->with('success', 'Bidang karir berhasil dihapus!');
    }

    // ========================
    // CAREER PATH MANAGEMENT
    // ========================

    public function paths(CareerField $careerField)
    {
        $careerField->load('paths');
        return view('admin.career-fields.paths', compact('careerField'));
    }

    public function createPath(CareerField $careerField)
    {
        return view('admin.career-fields.create-path', compact('careerField'));
    }

    public function storePath(Request $request, CareerField $careerField)
    {
        $validated = $request->validate([
            'level' => 'required|string|max:50',
            'level_label' => 'required|string|max:100',
            'year_range_min' => 'nullable|integer|min:0',
            'year_range_max' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'skills_required' => 'nullable|string',
            'certifications' => 'nullable|string',
            'courses' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'tips' => 'nullable|string',
        ]);

        $validated['career_field_id'] = $careerField->id;
        $validated['skills_required'] = $request->filled('skills_required')
            ? array_map('trim', explode(',', $request->skills_required)) : null;
        $validated['certifications'] = $request->filled('certifications')
            ? array_map('trim', explode(',', $request->certifications)) : null;
        $validated['courses'] = $request->filled('courses')
            ? array_map('trim', explode(',', $request->courses)) : null;
        $validated['sort_order'] = $careerField->paths()->count();

        CareerPath::create($validated);

        return redirect()->route('admin.career-fields.paths', $careerField)->with('success', 'Level karir berhasil ditambahkan!');
    }

    public function editPath(CareerField $careerField, CareerPath $path)
    {
        return view('admin.career-fields.edit-path', compact('careerField', 'path'));
    }

    public function updatePath(Request $request, CareerField $careerField, CareerPath $path)
    {
        $validated = $request->validate([
            'level' => 'required|string|max:50',
            'level_label' => 'required|string|max:100',
            'year_range_min' => 'nullable|integer|min:0',
            'year_range_max' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'skills_required' => 'nullable|string',
            'certifications' => 'nullable|string',
            'courses' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'tips' => 'nullable|string',
        ]);

        $validated['skills_required'] = $request->filled('skills_required')
            ? array_map('trim', explode(',', $request->skills_required)) : null;
        $validated['certifications'] = $request->filled('certifications')
            ? array_map('trim', explode(',', $request->certifications)) : null;
        $validated['courses'] = $request->filled('courses')
            ? array_map('trim', explode(',', $request->courses)) : null;

        $path->update($validated);

        return redirect()->route('admin.career-fields.paths', $careerField)->with('success', 'Level karir berhasil diupdate!');
    }

    public function destroyPath(CareerField $careerField, CareerPath $path)
    {
        $path->delete();
        return redirect()->route('admin.career-fields.paths', $careerField)->with('success', 'Level karir berhasil dihapus!');
    }
}
