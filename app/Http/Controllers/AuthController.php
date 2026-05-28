<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'identitas' => $request->username,
            'password'  => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            // PENGATURAN REDIRECT YANG BENAR
            if ($role === 'admin') {
                return redirect('admin/dashboard');
            } elseif ($role === 'umum') { 
                // KUNCI UTAMA: Jika rolenya 'umum', lempar ke panel 'eksternal'
                return redirect()->route('eksternal.dashboard'); 
            } elseif ($role === 'dosen' || $role === 'tendik') {
                return redirect('dosen/dashboard'); 
            } else {
                return redirect('dashboard/' . $role);
            }
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->with('error', 'Identitas atau password yang Anda masukkan salah!');
    }

    // --- FUNGSI REGISTER --- //

    public function showRegister()
    {
        return view('register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'identitas'    => 'required|unique:users,identitas',
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'role'         => 'required|in:mahasiswa,dosen,tendik,umum' // KEMBALIKAN KE UMUM
        ], [
            'identitas.unique' => 'NPM / NIP / NIK tersebut sudah terdaftar!',
            'email.unique'     => 'Email tersebut sudah digunakan!'
        ]);

        \App\Models\User::create([
            'identitas'    => $request->identitas,
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => \Illuminate\Support\Facades\Hash::make($request->password), 
            'role'         => $request->role,
        ]);

        // Setelah registrasi berhasil, arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan Log In dengan password baru Anda.');
    }

    // --- FUNGSI LOGOUT --- //
    public function logout(Request $request)
    {
        // 1. Keluarkan user dari sistem Laravel
        Auth::logout();

        // 2. Hapus semua memori sesi yang tertinggal
        $request->session()->invalidate();

        // 3. Buat ulang token keamanan baru
        $request->session()->regenerateToken();

        // 4. Arahkan kembali ke pintu depan (Beranda)
        return redirect('/');
    }
}