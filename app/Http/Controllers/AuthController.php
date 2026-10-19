<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        $schools = DemoData::schools();
        return view('auth.login', compact('schools'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:super_admin,admin_sekolah,panitia,yayasan',
            'school_code' => 'required_if:role,admin_sekolah,panitia'
        ]);

        session([
            'user_role' => $request->role,
            'user_school_code' => $request->school_code
        ]);

        // Redirect berdasarkan role
        return match($request->role) {
            'super_admin' => redirect('/super-admin'),
            'yayasan' => redirect('/yayasan'),
            default => redirect('/dashboard')
        };
    }

    public function logout()
    {
        session()->forget(['user_role', 'user_school_code']);
        return redirect('/');
    }
}
