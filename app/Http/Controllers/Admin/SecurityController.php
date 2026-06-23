<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecurityLog;
use App\Services\SecurityService;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    protected SecurityService $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * Security dashboard
     */
    public function index()
    {
        $data = $this->securityService->getDashboardData();
        return view('admin.security.index', $data);
    }

    /**
     * Show security log details
     */
    public function show(int $id)
    {
        $log = SecurityLog::with(['user', 'resolver'])->findOrFail($id);
        return view('admin.security.show', compact('log'));
    }

    /**
     * Resolve a security log
     */
    public function resolve(Request $request, int $id)
    {
        $request->validate([
            'resolution_notes' => 'required|string|max:1000',
        ]);

        $log = SecurityLog::findOrFail($id);
        $log->resolve(Auth::user(), $request->input('resolution_notes'));

        return back()->with('success', 'Security alert berhasil diselesaikan.');
    }

    /**
     * Get security logs API
     */
    public function logs(Request $request)
    {
        $query = SecurityLog::with('user');

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->has('unresolved')) {
            $query->unresolved();
        }

        $logs = $query->latest()->paginate(20);

        return response()->json($logs);
    }
}
