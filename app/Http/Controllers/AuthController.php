<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // -------------------------------------------------------
    // Login
    // -------------------------------------------------------
    public function showLogin()
    {
        // Jika sudah login, langsung redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user()->role);
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password salah.']);
    }

    // -------------------------------------------------------
    // Register — hanya untuk Siswa
    // -------------------------------------------------------
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => [
                'required', 'string', 'min:3', 'max:30',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9._]+$/',
            ],
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.min'       => 'Username minimal 3 karakter.',
            'username.max'       => 'Username maksimal 30 karakter.',
            'username.unique'    => 'Username sudah digunakan, coba yang lain.',
            'username.regex'     => 'Username hanya boleh huruf, angka, titik (.), dan underscore (_).',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => strtolower($request->username),
            'password' => bcrypt($request->password),
            'role'     => 'siswa', // selalu siswa, tidak bisa dimanipulasi
        ]);

        Auth::login($user);

        return redirect()->route('siswa.dashboard');
    }

    // -------------------------------------------------------
    // Logout
    // -------------------------------------------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // -------------------------------------------------------
    // Helper: redirect sesuai role
    // -------------------------------------------------------
    private function redirectByRole(string $role)
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru'  => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
