<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use App\Models\Position;
use App\Models\Category;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Competency::with('position')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $competencies = $query->paginate(5)->withQueryString();
        $categories = Category::all();
        return view('admin.competencies', compact('competencies', 'categories'));
    }



    public function create()
    {
        $positions = Position::all();
        $categories = Category::all();
        return view('admin.competencies.create', compact('positions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:competencies,code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'min_level_required' => 'required|integer|min:1|max:5',
            'source_reference' => 'nullable|string',
        ]);

        Competency::create($validated);

        return redirect()->route('admin.competencies')->with('success', 'Kompetensi berhasil ditambahkan!');
    }

    public function edit(Competency $competency)
    {
        $positions = Position::all();
        $categories = Category::all();
        return view('admin.competencies.edit', compact('competency', 'positions', 'categories'));
    }

    public function update(Request $request, Competency $competency)
    {
        $validated = $request->validate([
            'code' => 'required|unique:competencies,code,' . $competency->id,
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'min_level_required' => 'required|integer|min:1|max:5',
        ]);


        $competency->update($validated);

        return redirect()->route('admin.competencies')->with('success', 'Kompetensi berhasil diupdate!');
    }

    public function destroy(Competency $competency)
    {
        $competency->delete();
        return redirect()->route('admin.competencies')->with('success', 'Kompetensi berhasil dihapus!');
    }
}
