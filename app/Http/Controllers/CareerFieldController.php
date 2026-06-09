<?php

namespace App\Http\Controllers;

use App\Models\CareerField;
use Illuminate\Http\Request;

class CareerFieldController extends Controller
{
    /**
     * Daftar semua bidang karir
     */
    public function index(Request $request)
    {
        $query = CareerField::active()->with('paths');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('job_titles', $search)
                  ->orWhereJsonContains('industries', $search);
            });
        }

        $fields = $query->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('seeker.career-fields.index', compact('fields'));
    }

    /**
     * Detail bidang karir dan roadmap
     */
    public function show($slug)
    {
        $field = CareerField::where('slug', $slug)
            ->active()
            ->with('paths')
            ->firstOrFail();

        // Ambil user yang sedang login untuk cek skill match
        $user = auth()->user();
        $userSkills = $user->skills ?? [];

        // Hitung skill match per level
        $paths = $field->paths->map(function ($path) use ($userSkills) {
            $requiredSkills = $path->skills_required ?? [];
            $matchedSkills = array_intersect($userSkills, $requiredSkills);
            $matchPercentage = count($requiredSkills) > 0
                ? round((count($matchedSkills) / count($requiredSkills)) * 100)
                : 0;

            return [
                'path' => $path,
                'matched_skills' => $matchedSkills,
                'missing_skills' => array_diff($requiredSkills, $userSkills),
                'match_percentage' => $matchPercentage,
            ];
        });

        return view('seeker.career-fields.show', compact('field', 'paths', 'userSkills'));
    }
}
