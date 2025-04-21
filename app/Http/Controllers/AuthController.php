<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Controller untuk mengelola autentikasi (login, register, logout)
class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses login pengguna
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mencoba login dengan kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect ke halaman admin jika admin, atau halaman utama jika user
            return redirect()->intended(Auth::user()->role === 'admin' ? '/products' : '/');
        }

        // Kembali dengan pesan error jika login gagal
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registration successful');
    }

    // Memproses logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Redirect ke halaman login
        return redirect('/login');
    }
}
