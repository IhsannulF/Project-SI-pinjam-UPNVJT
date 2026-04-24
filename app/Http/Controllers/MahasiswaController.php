<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Nantinya kita bisa menarik data peminjaman asli dari database di sini
        return view('mahasiswa.dashboard');
    }
}