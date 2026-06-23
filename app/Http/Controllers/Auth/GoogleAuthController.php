<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            Log::error('Gagal redirect ke Google OAuth', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google. Silakan coba lagi.');
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

            Log::info('Google callback started', ['role' => $role]);

            $user = $this->googleAuthService->handleGoogleUser($role);

            Log::info('Google user retrieved', ['email' => $user->email, 'name' => $user->name]);

            Auth::login($user);

            Log::info('User logged in successfully', ['user_id' => $user->id]);

            return $this->redirectByRole($user);
        } catch (\Exception $e) {
            Log::error('Google OAuth callback error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google: ' . $e->getMessage());
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

        return $this->redirectByRole($user)->with('status', 'Logged in via Mock Google (Socialite / Credentials not detected)');
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectByRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isIndustryOrStaff()) {
            return redirect()->route('industry.dashboard');
        } elseif ($user->isEducation()) {
            return redirect()->route('education.dashboard');
        } elseif ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
