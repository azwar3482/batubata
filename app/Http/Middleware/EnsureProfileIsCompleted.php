<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAssessment;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isJobSeeker()) {
            // 1. Gating Profile Lengkap
            if (!$user->hasCompletedProfile()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Profil Anda belum lengkap (' . $user->profile_completion_percentage . '%). Silakan lengkapi profil Anda terlebih dahulu.'
                    ], 403);
                }

                return redirect()->route('dashboard')->with('error', 'Profil Anda belum lengkap (' . $user->profile_completion_percentage . '%). Silakan lengkapi profil dan unggah CV Anda terlebih dahulu untuk membuka semua fitur.');
            }

            // 2. Gating Skill Gap > 30% jika ingin melamar kerja
            // Rute ini berlaku jika request mengarah ke lamar kerja
            if ($request->routeIs('seeker.jobs.apply')) {
                $latestAssessment = UserAssessment::where('user_id', $user->id)->latest()->first();
                $avgGap = $latestAssessment ? $latestAssessment->total_gap_percentage : 0;

                if ($avgGap > 30) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Maaf, celah keahlian (Skill Gap) Anda sebesar ' . number_format($avgGap, 1) . '% melebihi batas maksimal 30%. Silakan ikuti kursus rekomendasi terlebih dahulu.'
                        ], 403);
                    }

                    return redirect()->route('dashboard')->with('error', 'Maaf, celah keahlian (Skill Gap) Anda sebesar ' . number_format($avgGap, 1) . '% masih melebihi batas maksimal 30%. Silakan selesaikan kursus yang direkomendasikan untuk menutup celah keahlian Anda terlebih dahulu.');
                }
            }
        }

        return $next($request);
    }
}
