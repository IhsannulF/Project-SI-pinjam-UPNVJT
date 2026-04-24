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
        // 1. Pastikan user mengisi kedua kolom
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // 2. Petakan inputan form ke kolom database Anda
        // Di form name="username", tapi di database dicocokkan ke kolom 'identitas'
        $credentials = [
            'identitas' => $request->username,
            'password'  => $request->password
        ];

        // 3. Proses Pengecekan Login menggunakan fitur ajaib Laravel
       if (Auth::attempt($credentials)) {
            // Jika berhasil, perbarui sesi (keamanan anti-hacker)
            $request->session()->regenerate();

            // Cek role user saat ini
            $role = Auth::user()->role;

            // Arahkan ke dashboard masing-masing sesuai role
            if ($role === 'admin') {
                return redirect('admin/dashboard');
            } else {
                // Untuk mahasiswa dan umum
                return redirect('dashboard/' . $role);
            }
        }

        // 4. Jika gagal (password/identitas salah), kembalikan dengan pesan error
        return back()->with('error', 'Identitas atau password yang Anda masukkan salah!');
    }

    // --- TAMBAHKAN KODE INI DI BAWAH --- //

    // Menampilkan halaman Register
    public function showRegister()
    {
        return view('register');
    }

    // Memproses data Register
    public function processRegister(Request $request)
    {
        // 1. Validasi Inputan (Pastikan identitas/email tidak boleh kembar di tabel users)
        $request->validate([
            'identitas'    => 'required|unique:users,identitas',
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'role'         => 'required|in:mahasiswa,umum'
        ], [
            // Pesan error jika kembar
            'identitas.unique' => 'NPM / NIP / NIK tersebut sudah terdaftar!',
            'email.unique'     => 'Email tersebut sudah digunakan!'
        ]);

        // 2. Simpan ke Database
        // WAJIB: Gunakan Hash::make() agar password diacak sebelum masuk ke database
        \App\Models\User::create([
            'identitas'    => $request->identitas,
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => \Illuminate\Support\Facades\Hash::make($request->password), 
            'role'         => $request->role,
        ]);

        // 3. Kembalikan ke halaman login dengan pesan sukses
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