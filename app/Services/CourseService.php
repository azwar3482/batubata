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

        if (!empty($filters['level'])) {
            $query->where('level', $filters['level']);
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
        return Course::with('competency', 'creator')->findOrFail($id);
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
     * Update user's course progress.
     */
    public function updateProgress(int $userId, int $courseId, int $progressPercentage)
    {
        $progress = UserCourseProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $progress->update([
            'progress_percentage' => $progressPercentage,
            'status' => $progressPercentage >= 100 ? 'completed' : 'in_progress',
            'completed_at' => $progressPercentage >= 100 ? now() : null,
        ]);

        return $progress;
    }

    /**
     * Mark course as completed.
     */
    public function completeCourse(int $userId, int $courseId)
    {
        $progress = UserCourseProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $progress->update([
            'status' => 'completed',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        return $progress;
    }

    /**
     * Get all progress records for a user.
     */
    public function getAllUserProgress(int $userId)
    {
        return UserCourseProgress::with('course.competency')
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->get();
    }
}
