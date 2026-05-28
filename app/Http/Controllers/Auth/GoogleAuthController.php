<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    /**
     * @var GoogleAuthService
     */
    protected $googleAuthService;

    /**
     * GoogleAuthController constructor.
     *
     * @param GoogleAuthService $googleAuthService
     */
    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    /**
     * Redirect to Google for authentication.
     */
    public function redirectToGoogle(Request $request)
    {
        // Save role to session if provided (for registration)
        if ($request->has('role')) {
            session(['social_role' => $request->role]);
        }

        if (!$this->googleAuthService->isSocialiteAvailable()) {
            return $this->handleMockLogin();
        }

        try {
            return $this->googleAuthService->redirectToGoogle();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google: ' . $e->getMessage());
        }
    }

    /**
     * Handle the callback from Google.
     */
    public function handleGoogleCallback()
    {
        if (!$this->googleAuthService->isSocialiteAvailable()) {
            return redirect()->route('dashboard');
        }

        try {
            $role = session('social_role', 'job_seeker');
            session()->forget('social_role');

            $user = $this->googleAuthService->handleGoogleUser($role);

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    /**
     * Mock login for development without Socialite/Credentials.
     */
    protected function handleMockLogin()
    {
        $role = session('social_role', 'job_seeker');
        session()->forget('social_role');

        $user = $this->googleAuthService->getOrCreateMockUser($role);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Logged in via Mock Google (Socialite / Credentials not detected)');
    }
}
