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
            $user = new User([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(16)),
            ]);
            $user->email_verified_at = now();
            $user->role = $role;
            $user->save();
        } else {
            $hasUpdates = false;
            if (!$user->provider) {
                $user->provider = 'google';
                $user->provider_id = $googleUser->getId();
                $hasUpdates = true;
            }
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $hasUpdates = true;
            }
            if ($hasUpdates) {
                $user->save();
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
        $mockEmail = 'mock.' . $role . '@google.com';
        $user = User::where('email', $mockEmail)->first();
        
        if (!$user) {
            $user = new User([
                'name' => 'Mock Google User (' . $role . ')',
                'email' => $mockEmail,
                'password' => Hash::make('password'),
            ]);
            $user->email_verified_at = now();
            $user->role = $role;
            $user->save();
        } elseif (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
        }

        return $user;
    }
}
