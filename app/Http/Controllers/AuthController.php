<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'petugas' || $user->role === 'admin') {
                return redirect('/dashboard');
            } elseif ($user->role === 'pasien') {
                return redirect('/pasien/dashboard');
            } elseif ($user->role === 'keluarga') {
                return redirect('/keluarga/dashboard');
            }
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        // Format phone number if it's not an email
        if ($field === 'phone_number') {
            $login = trim($login);
            if (substr($login, 0, 1) !== '0' && substr($login, 0, 1) !== '+') {
                $login = '0' . $login;
            }
        }

        $credentials = [
            $field => $login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'petugas' || $user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'pasien') {
                return redirect()->intended('/pasien/dashboard');
            } elseif ($user->role === 'keluarga') {
                return redirect()->intended('/keluarga/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Email/Nomor HP atau password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
