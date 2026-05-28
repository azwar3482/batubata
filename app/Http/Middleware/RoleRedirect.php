<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Jika user mencoba mengakses dashboard umum, arahkan sesuai role
        if ($request->path() === 'dashboard') {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isIndustryOrStaff()) {
                return redirect()->route('industry.dashboard');
            } elseif ($user->isEducation()) {
                return redirect()->route('education.dashboard');
            }
        }

        // Keamanan: Cek apakah user berhak mengakses route tertentu (Opsional, bisa diperketat nanti)
        // Contoh: Jika url mengandung 'admin' tapi role bukan admin
        
        return $next($request);
    }
}