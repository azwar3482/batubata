<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use App\Services\InstitutionAnalyticsService;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    /**
     * Get graduate competency analytics.
     */
    public function index(InstitutionAnalyticsService $analyticsService)
    {
        $data = $analyticsService->getAnalyticsForUser(Auth::user());

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
