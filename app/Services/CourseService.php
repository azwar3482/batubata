<?php

namespace App\Services;

use App\Models\Course;
use App\Models\UserCourseProgress;

class CourseService
{
    /**
     * Get paginated courses with filters.
     */
    public function getCourses(array $filters, int $perPage = 12)
    {
        $query = Course::with('competency')->latest();
        
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($perPage);
    }

    /**
     * Get recommended courses based on weak competencies.
     */
    public function getRecommendedCourses(array $competencyIds, int $limit = 3)
    {
        if (empty($competencyIds)) return collect();

        return Course::with('competency')
            ->whereIn('competency_id', $competencyIds)
            ->take($limit)
            ->get();
    }

    /**
     * Get array of course IDs that the user is currently enrolled in.
     */
    public function getUserProgressIds(int $userId): array
    {
        return UserCourseProgress::where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();
    }

    /**
     * Get course details.
     */
    public function getCourseDetails($id)
    {
        return Course::with('competency')->findOrFail($id);
    }

    /**
     * Get user progress for a specific course.
     */
    public function getUserCourseProgress(int $userId, int $courseId)
    {
        return UserCourseProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
    }

    /**
     * Enroll user in a course.
     */
    public function enrollUser(int $userId, int $courseId)
    {
        return UserCourseProgress::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $courseId],
            ['status' => 'in_progress', 'started_at' => now(), 'progress_percentage' => 0]
        );
    }

    /**
     * Get all progress records for a user.
     */
    public function getAllUserProgress(int $userId)
    {
        return UserCourseProgress::with('course')
            ->where('user_id', $userId)
            ->get();
    }
}
