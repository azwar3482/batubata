<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthService
{
    /**
     * Check if Socialite is installed and Google credentials are set.
     *
     * @return bool
     */
    public function isSocialiteAvailable(): bool
    {
        return class_exists('\Laravel\Socialite\Facades\Socialite') && 
               config('services.google.client_id') && 
               config('services.google.client_secret');
    }

    /**
     * Get the redirect to Google.
     *
     * @return mixed
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Socialite callback user logic.
     *
     * @param string $role
     * @return \App\Models\User
     */
    public function handleGoogleUser(string $role): User
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'photo' => $googleUser->getAvatar(), // Save Google avatar
                'password' => Hash::make(Str::random(16)),
                'role' => $role,
                'email_verified_at' => now(),
            ]);
        } else {
            // Update photo if it's empty
            if (empty($user->photo)) {
                $user->update(['photo' => $googleUser->getAvatar()]);
            }
        }

        return $user;
    }

    /**
     * Get or create a mock Google user for development.
     *
     * @param string $role
     * @return \App\Models\User
     */
    public function getOrCreateMockUser(string $role): User
    {
        $user = User::where('role', $role)->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Mock Google User (' . $role . ')',
                'email' => 'mock.' . $role . '@google.com',
                'password' => Hash::make('password'),
                'role' => $role,
                'email_verified_at' => now(),
            ]);
        }

        return $user;
    }
}
