<?php

namespace App\Services;

use App\Models\CoursePayment;
use App\Models\Course;
use App\Models\TeacherCourse;
use Illuminate\Support\Facades\Auth;

class CoursePaymentService
{
    /**
     * Check if user has paid for a course (admin/platform course).
     */
    public function hasPaidForCourse(int $userId, int $courseId): bool
    {
        return CoursePayment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', CoursePayment::STATUS_PAID)
            ->exists();
    }

    /**
     * Check if user has paid for a teacher course.
     */
    public function hasPaidForTeacherCourse(int $userId, int $teacherCourseId): bool
    {
        return CoursePayment::where('user_id', $userId)
            ->where('teacher_course_id', $teacherCourseId)
            ->where('status', CoursePayment::STATUS_PAID)
            ->exists();
    }

    /**
     * Create a pending payment for an admin/platform course.
     */
    public function createCoursePayment(int $userId, int $courseId): CoursePayment
    {
        $course = Course::findOrFail($courseId);

        if ($course->is_free) {
            throw new \Exception('Kursus ini gratis, tidak perlu pembayaran.');
        }

        $existing = CoursePayment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', CoursePayment::STATUS_PAID)
            ->first();

        if ($existing) {
            throw new \Exception('Anda sudah membayar kursus ini.');
        }

        $pending = CoursePayment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', CoursePayment::STATUS_PENDING)
            ->first();

        if ($pending) {
            return $pending;
        }

        return CoursePayment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => CoursePayment::STATUS_PENDING,
            'amount' => $course->price,
        ]);
    }

    /**
     * Create a pending payment for a teacher course.
     */
    public function createTeacherCoursePayment(int $userId, int $teacherCourseId): CoursePayment
    {
        $teacherCourse = TeacherCourse::findOrFail($teacherCourseId);

        if ($teacherCourse->is_free) {
            throw new \Exception('Kursus ini gratis, tidak perlu pembayaran.');
        }

        $existing = CoursePayment::where('user_id', $userId)
            ->where('teacher_course_id', $teacherCourseId)
            ->where('status', CoursePayment::STATUS_PAID)
            ->first();

        if ($existing) {
            throw new \Exception('Anda sudah membayar kursus ini.');
        }

        $pending = CoursePayment::where('user_id', $userId)
            ->where('teacher_course_id', $teacherCourseId)
            ->where('status', CoursePayment::STATUS_PENDING)
            ->first();

        if ($pending) {
            return $pending;
        }

        return CoursePayment::create([
            'user_id' => $userId,
            'teacher_course_id' => $teacherCourseId,
            'status' => CoursePayment::STATUS_PENDING,
            'amount' => $teacherCourse->price,
        ]);
    }

    /**
     * Process payment (simulate - in production integrate with Midtrans/Xendit).
     */
    public function processPayment(int $paymentId, string $paymentMethod): CoursePayment
    {
        $payment = CoursePayment::findOrFail($paymentId);

        $paymentReference = 'CRS-' . strtoupper(uniqid());

        $payment->update([
            'status' => CoursePayment::STATUS_PAID,
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
            'paid_at' => now(),
        ]);

        return $payment;
    }

    /**
     * Get payment by ID for a specific user.
     */
    public function getPayment(int $userId, int $paymentId): CoursePayment
    {
        return CoursePayment::where('user_id', $userId)
            ->findOrFail($paymentId);
    }

    /**
     * Get all payments for a user.
     */
    public function getUserPayments(int $userId)
    {
        return CoursePayment::with(['course', 'teacherCourse'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
    }
}
