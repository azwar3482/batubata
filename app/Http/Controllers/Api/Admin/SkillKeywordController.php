<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillKeywordController extends Controller
{
    public function index(Request $request)
    {
        $query = SkillKeyword::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keyword', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $skillKeywords = $query->orderBy('category')
                               ->orderBy('keyword')
                               ->get();

        return response()->json([
            'success' => true,
            'data' => $skillKeywords
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'keyword' => 'required|string|max:255|unique:skill_keywords,keyword',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['keyword'] = strtolower($validated['keyword']);
        $validated['is_active'] = $request->input('is_active', true);

        $skillKeyword = SkillKeyword::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Keyword berhasil ditambahkan.',
            'data' => $skillKeyword
        ], 201);
    }

    public function show($id)
    {
        $skillKeyword = SkillKeyword::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $skillKeyword
        ]);
    }

    public function update(Request $request, $id)
    {
        $skillKeyword = SkillKeyword::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'keyword' => 'required|string|max:255|unique:skill_keywords,keyword,' . $skillKeyword->id,
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['keyword'] = strtolower($validated['keyword']);
        $validated['is_active'] = $request->input('is_active', true);

        $skillKeyword->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Keyword berhasil diperbarui.',
            'data' => $skillKeyword
        ]);
    }

    public function destroy($id)
    {
        $skillKeyword = SkillKeyword::findOrFail($id);
        $skillKeyword->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keyword berhasil dihapus.'
        ]);
    }
}
