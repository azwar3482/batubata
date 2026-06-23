<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ManualReviewService;
use App\Models\ManualReviewRequest;

class ManualReviewController extends Controller
{
    protected ManualReviewService $reviewService;

    public function __construct(ManualReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Show review request form
     */
    public function index()
    {
        $user = Auth::user();
        $requests = $this->reviewService->getUserRequests($user);
        $hasPending = ManualReviewRequest::where('user_id', $user->id)
            ->where('status', ManualReviewRequest::STATUS_PENDING)
            ->exists();

        return view('manual-review.index', compact('requests', 'hasPending'));
    }

    /**
     * Create a new review request
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $reviewRequest = $this->reviewService->createRequest(
                Auth::user(),
                $request->input('job_listing_id'),
                $request->input('notes')
            );

            return redirect()->route('manual-review.payment', $reviewRequest->id)
                ->with('success', 'Permintaan review berhasil dibuat. Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show payment page
     */
    public function payment(int $id)
    {
        $reviewRequest = ManualReviewRequest::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($reviewRequest->payment_status === ManualReviewRequest::PAYMENT_PAID) {
            return redirect()->route('manual-review.index')
                ->with('info', 'Pembayaran sudah dilakukan.');
        }

        return view('manual-review.payment', compact('reviewRequest'));
    }

    /**
     * Process payment (simulate - in production use payment gateway)
     */
    public function processPayment(Request $request, int $id)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card',
        ]);

        $reviewRequest = ManualReviewRequest::where('user_id', Auth::id())
            ->findOrFail($id);

        // Simulate payment (in production, integrate with Midtrans/Xendit/etc)
        $paymentReference = 'PAY-' . strtoupper(uniqid());

        try {
            $this->reviewService->processPayment(
                $id,
                $request->input('payment_method'),
                $paymentReference
            );

            return redirect()->route('manual-review.index')
                ->with('success', 'Pembayaran berhasil! Permintaan review Anda sedang diproses.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cancel a review request
     */
    public function cancel(int $id)
    {
        try {
            $this->reviewService->cancelRequest($id, 'Dibatalkan oleh user');
            return back()->with('success', 'Permintaan review berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
