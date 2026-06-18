<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'nullable|string|in:job_seeker,industry,education',
            'phone' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
        ]);
        $user->role = $validated['role'] ?? 'job_seeker';
        $user->save();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kredensial tidak valid'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ]);
    }

    public function loginGoogle(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'photo' => 'nullable|string', // Added photo
            'firebase_uid' => 'required|string',
            'role' => 'nullable|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            // Create new user if not exists
            $user = new User([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'provider' => 'google',
                'provider_id' => $validated['firebase_uid'],
                'password' => Hash::make(Str::random(16)),
            ]);
            $user->email_verified_at = now();
            $user->role = $request->role ?? 'job_seeker';
            $user->save();
        } else {
            $hasUpdates = false;
            if (!$user->provider) {
                $user->provider = 'google';
                $user->provider_id = $validated['firebase_uid'];
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

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }
}
