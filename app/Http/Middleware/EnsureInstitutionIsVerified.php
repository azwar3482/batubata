<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstitutionIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isEducation()) {
            if (!$user->institution) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Profil institusi belum dibuat.'], 403);
                }
                return redirect()->route('education.dashboard')
                    ->with('error', 'Silakan lengkapi profil institusi Anda terlebih dahulu.');
            }

            if (!$user->institution->isVerified()) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Institusi Anda belum diverifikasi oleh admin.'], 403);
                }
                return redirect()->route('education.dashboard')
                    ->with('error', 'Institusi Anda belum terverifikasi. Silakan unggah dokumen legalitas dan tunggu verifikasi admin.');
            }
        }

        return $next($request);
    }
}
