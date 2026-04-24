<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class DosenController extends Controller
{
    public function index()
    {
        // Sementara kita buat data dummy 0 seperti di desain lama Anda
        $jadwal_aktif = 0;
        $total_riwayat = 0;

        return view('dosen.dashboard', compact('jadwal_aktif', 'total_riwayat'));
    }
}