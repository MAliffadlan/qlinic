<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/patient/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak cocok.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Honeypot anti-bot: kalau field 'company' terisi, pasti bot
        if (!empty($request->input('company'))) {
            abort(403, 'Bot detected');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'digits:16', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        Auth::login($user);

        // Tandai NIK & IP sebagai baru saja berhasil daftar (cooldown anti-spam)
        \Illuminate\Support\Facades\Cache::put('reg_rate_nik_' . $user->nik, true, now()->addDay());
        \Illuminate\Support\Facades\Cache::put('reg_success_ip_' . $request->ip(), now()->timestamp, now()->addHour());

        return redirect('/patient/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
