<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Category;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $query = Position::latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $positions = $query->paginate(10)->withQueryString();
        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        $categories = Category::where('type', 'position')->orderBy('name')->get();
        return view('admin.positions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Position::create($validated);
        return redirect()->route('admin.positions.index')->with('success', 'Posisi berhasil ditambahkan!');
    }

    public function edit(Position $position)
    {
        $categories = Category::where('type', 'position')->orderBy('name')->get();
        return view('admin.positions.edit', compact('position', 'categories'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $position->update($validated);
        return redirect()->route('admin.positions.index')->with('success', 'Posisi berhasil diupdate!');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('admin.positions.index')->with('success', 'Posisi berhasil dihapus!');
    }
}

