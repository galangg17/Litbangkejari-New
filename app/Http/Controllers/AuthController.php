<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        session([
            'is_logged_in' => true,
            'user' => [
                'name' => 'Admin LITBANG',
                'email' => $request->email,
                'role' => 'Administrator Utama',
            ]
        ]);

        return redirect()->route('dashboard.index')->with('toast', 'Selamat Datang, Admin LITBANG Adhyaksa!');
    }

    public function logout()
    {
        session()->forget(['is_logged_in', 'user']);
        return redirect()->route('landing.index')->with('toast', 'Anda telah keluar dari sistem.');
    }
}
