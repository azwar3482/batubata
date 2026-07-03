<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\CoursePayment;
use App\Models\ClassEnrollment;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user()->ownedVendor;
        if (!$vendor) {
            return redirect()->route('vendor.dashboard');
        }

        $teacherIds = $vendor->teachers()->pluck('id');

        $query = CoursePayment::whereIn('teacher_course_id', function ($q) use ($teacherIds) {
            $q->select('id')->from('teacher_courses')->whereIn('teacher_id', $teacherIds);
        })->with(['user', 'teacherCourse.teacher']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(10);

        return view('vendor.payments.index', compact('vendor', 'payments'));
    }

    public function show($id)
    {
        $vendor = Auth::user()->ownedVendor;
        if (!$vendor) {
            abort(403);
        }

        $teacherIds = $vendor->teachers()->pluck('id');

        $payment = CoursePayment::whereIn('teacher_course_id', function ($q) use ($teacherIds) {
            $q->select('id')->from('teacher_courses')->whereIn('teacher_id', $teacherIds);
        })->with(['user', 'teacherCourse.teacher'])->findOrFail($id);

        return view('vendor.payments.show', compact('vendor', 'payment'));
    }

    public function verify(Request $request, $id)
    {
        $vendor = Auth::user()->ownedVendor;
        if (!$vendor) {
            abort(403);
        }

        $teacherIds = $vendor->teachers()->pluck('id');

        $payment = CoursePayment::whereIn('teacher_course_id', function ($q) use ($teacherIds) {
            $q->select('id')->from('teacher_courses')->whereIn('teacher_id', $teacherIds);
        })->findOrFail($id);

        $request->validate([
            'action' => 'required|in:approve,reject',
            'reason' => 'nullable|string|max:255',
        ]);

        if ($request->action === 'approve') {
            $payment->update([
                'status' => CoursePayment::STATUS_PAID,
                'paid_at' => now(),
            ]);

            // Auto-enroll the job seeker to the class associated with this teacher course
            // Find an active class for this teacher course
            $class = TeacherClass::where('course_id', $payment->teacher_course_id)
                ->where('status', 'active')
                ->first();

            if ($class) {
                ClassEnrollment::firstOrCreate(
                    ['class_id' => $class->id, 'user_id' => $payment->user_id],
                    ['status' => 'active', 'enrolled_at' => now()]
                );
            }

            return redirect()->route('vendor.payments.index')
                ->with('success', 'Pembayaran kursus berhasil disetujui. Siswa otomatis didaftarkan.');
        } else {
            $payment->update([
                'status' => CoursePayment::STATUS_FAILED,
            ]);

            return redirect()->route('vendor.payments.index')
                ->with('success', 'Pembayaran kursus ditolak. Alasan: ' . ($request->reason ?? 'Tidak ada alasan spesifik') . '.');
        }
    }
}
