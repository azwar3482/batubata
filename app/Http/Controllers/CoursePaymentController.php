<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CoursePaymentService;
use App\Services\CourseService;
use App\Models\CoursePayment;

class CoursePaymentController extends Controller
{
    protected CoursePaymentService $paymentService;
    protected CourseService $courseService;

    public function __construct(CoursePaymentService $paymentService, CourseService $courseService)
    {
        $this->paymentService = $paymentService;
        $this->courseService = $courseService;
    }

    /**
     * Show payment page for a course.
     */
    public function payment(int $id, Request $request)
    {
        $type = $request->query('type', 'external');

        if ($type === 'teacher') {
            $payment = $this->paymentService->createTeacherCoursePayment(Auth::id(), $id);
            $course = \App\Models\TeacherCourse::findOrFail($id);
            $courseType = 'teacher';
        } else {
            $payment = $this->paymentService->createCoursePayment(Auth::id(), $id);
            $course = \App\Models\Course::findOrFail($id);
            $courseType = 'admin';
        }

        if ($payment->status === CoursePayment::STATUS_PAID) {
            return redirect()->route('seeker.courses.show', $id)
                ->with('info', 'Anda sudah membayar kursus ini.');
        }

        return view('courses.payment', compact('payment', 'course', 'courseType'));
    }

    /**
     * Process payment.
     */
    public function processPayment(Request $request, int $id)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card',
        ]);

        $payment = $this->paymentService->getPayment(Auth::id(), $id);

        if ($payment->status === CoursePayment::STATUS_PAID) {
            return redirect()->route('seeker.courses.show', $payment->course_id ?? $payment->teacher_course_id)
                ->with('info', 'Pembayaran sudah dilakukan.');
        }

        try {
            $this->paymentService->processPayment(
                $id,
                $request->input('payment_method')
            );

            $courseId = $payment->course_id ?? $payment->teacher_course_id;
            $type = $payment->teacher_course_id ? 'teacher' : 'external';

            return redirect()->route('seeker.courses.show', ['id' => $courseId, 'type' => $type])
                ->with('success', 'Pembayaran berhasil! Anda sekarang bisa mengakses kursus ini.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
