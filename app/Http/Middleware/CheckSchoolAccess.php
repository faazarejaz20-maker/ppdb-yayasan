<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = session('user_role');
        $userSchool = session('user_school_code');
        
        // Super admin dan yayasan bisa akses semua sekolah
        if (in_array($userRole, ['super_admin', 'yayasan'])) {
            return $next($request);
        }

        // Panitia dan admin sekolah hanya bisa akses sekolah mereka
        if (in_array($userRole, ['panitia', 'admin_sekolah'])) {
            // Cek dari route parameter atau request
            $schoolCode = $request->route('school_code') ?? $request->input('school_code');
            
            if ($schoolCode && $schoolCode !== $userSchool) {
                abort(403, 'Anda tidak memiliki akses ke sekolah ini.');
            }
        }

        return $next($request);
    }
}
