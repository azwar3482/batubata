<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isIndustry()) {
            if (!$user->company) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Profil perusahaan belum dibuat.'], 403);
                }
                return redirect()->route('industry.jobs.index')
                    ->with('error', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
            }

            if (!$user->company->isVerified()) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Perusahaan Anda belum diverifikasi oleh admin.'], 403);
                }
                return redirect()->route('industry.jobs.index')
                    ->with('error', 'Perusahaan Anda belum terverifikasi. Silakan unggah dokumen legalitas dan tunggu verifikasi admin.');
            }
        }

        return $next($request);
    }
}
