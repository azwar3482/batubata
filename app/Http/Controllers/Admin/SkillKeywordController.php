<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillKeyword;
use Illuminate\Http\Request;

class SkillKeywordController extends Controller
{
    public function index(Request $request)
    {
        $query = SkillKeyword::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('keyword', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $skillKeywords = $query->orderBy('category')
                               ->orderBy('keyword')
                               ->paginate(15)
                               ->withQueryString();

        return view('admin.skill_keywords.index', compact('skillKeywords'));
    }

    public function create()
    {
        return view('admin.skill_keywords.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'keyword' => 'required|string|max:255|unique:skill_keywords,keyword',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['keyword'] = strtolower($validated['keyword']);

        SkillKeyword::create($validated);

        return redirect()->route('admin.skill-keywords.index')->with('success', 'Keyword berhasil ditambahkan.');
    }

    public function edit(SkillKeyword $skillKeyword)
    {
        return view('admin.skill_keywords.edit', compact('skillKeyword'));
    }

    public function update(Request $request, SkillKeyword $skillKeyword)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'keyword' => 'required|string|max:255|unique:skill_keywords,keyword,' . $skillKeyword->id,
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['keyword'] = strtolower($validated['keyword']);

        $skillKeyword->update($validated);

        return redirect()->route('admin.skill-keywords.index')->with('success', 'Keyword berhasil diperbarui.');
    }

    public function destroy(SkillKeyword $skillKeyword)
    {
        $skillKeyword->delete();
        return redirect()->route('admin.skill-keywords.index')->with('success', 'Keyword berhasil dihapus.');
    }
}
