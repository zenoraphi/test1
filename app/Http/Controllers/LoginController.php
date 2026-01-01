<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'login.required' => 'Username atau NIS wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = $request->login;

        // Cari user: admin pakai username, siswa pakai NIS
        $user = User::where('username', $loginInput)
            ->orWhere('nis', $loginInput)
            ->first();

        if (!$user) {
            return back()->with('error', 'Akun tidak ditemukan.');
        }

        // Tentukan kredensial berdasarkan role
        if ($user->role === 'siswa') {
            $credentials = [
                'nis'      => $loginInput,
                'password' => $request->password,
            ];
        } else {
            $credentials = [
                'username' => $loginInput,
                'password' => $request->password,
            ];
        }

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Password salah.');
        }

        $request->session()->regenerate();

        // Redirect sesuai role
        if ($user->role === 'siswa') {
            return redirect()->route('siswa.create');
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
