<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $fields = $query->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => $fields->map(function ($field) {
                return [
                    'id' => $field->id,
                    'name' => $field->name,
                    'slug' => $field->slug,
                    'description' => $field->description,
                    'icon' => $field->icon,
                    'color' => $field->color,
                    'job_titles' => $field->job_titles,
                    'industries' => $field->industries,
                    'avg_salary_min' => $field->avg_salary_min,
                    'avg_salary_max' => $field->avg_salary_max,
                    'demand_score' => $field->demand_score,
                    'demand_label' => $field->demand_label,
                    'paths_count' => $field->paths->count(),
                ];
            }),
        ]);
    }

    /**
     * Detail bidang karir dan roadmap
     */
    public function show($slug)
    {
        $field = CareerField::where('slug', $slug)
            ->active()
            ->with('paths')
            ->first();

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Bidang karir tidak ditemukan',
            ], 404);
        }

        // Ambil user yang sedang login untuk cek skill match
        $user = auth()->user();
        $userSkills = $user->skills ?? [];

        // Hitung skill match per level
        $paths = $field->paths->map(function ($path) use ($userSkills) {
            $requiredSkills = $path->skills_required ?? [];
            $matchedSkills = array_intersect($userSkills, $requiredSkills);
            $missingSkills = array_diff($requiredSkills, $userSkills);
            $matchPercentage = count($requiredSkills) > 0
                ? round((count($matchedSkills) / count($requiredSkills)) * 100)
                : 0;

            return [
                'id' => $path->id,
                'level' => $path->level,
                'level_label' => $path->level_label,
                'year_range_min' => $path->year_range_min,
                'year_range_max' => $path->year_range_max,
                'description' => $path->description,
                'skills_required' => $path->skills_required,
                'certifications' => $path->certifications,
                'courses' => $path->courses,
                'salary_min' => $path->salary_min,
                'salary_max' => $path->salary_max,
                'tips' => $path->tips,
                'matched_skills' => array_values($matchedSkills),
                'missing_skills' => array_values($missingSkills),
                'match_percentage' => $matchPercentage,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $field->id,
                'name' => $field->name,
                'slug' => $field->slug,
                'description' => $field->description,
                'icon' => $field->icon,
                'color' => $field->color,
                'job_titles' => $field->job_titles,
                'industries' => $field->industries,
                'avg_salary_min' => $field->avg_salary_min,
                'avg_salary_max' => $field->avg_salary_max,
                'demand_score' => $field->demand_score,
                'demand_label' => $field->demand_label,
                'paths' => $paths,
            ],
        ]);
    }
}
