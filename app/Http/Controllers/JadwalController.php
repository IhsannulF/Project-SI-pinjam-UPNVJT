<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman; 
use Carbon\Carbon; // <-- WAJIB: Tambahkan ini untuk manipulasi rentang tanggal

class JadwalController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data fasilitas untuk ditampilkan di menu samping (Sidebar)
        $data_fasilitas = Fasilitas::all();
        
        // 2. UBAH: Ambil data jadwal (ganti 'pending' menjadi 'menunggu')
        $peminjaman = Peminjaman::whereIn('status', ['disetujui', 'menunggu', 'diblokir', 'blokir'])->get();

        // 3. Kelompokkan tanggal yang sudah di-booking berdasarkan ID Fasilitas
        $jadwal_booking = [];
        foreach ($peminjaman as $p) {
            $id = $p->id_fasilitas;
            
            // UBAH: Parsing rentang tanggal mulai dan berakhir
            $start = Carbon::parse($p->tanggal_mulai);
            $end = Carbon::parse($p->tanggal_berakhir);
            
            // LOOPING: Isi array untuk setiap hari di dalam rentang waktu tersebut
            for ($date = $start; $date->lte($end); $date->addDay()) {
                $tanggal = $date->format('Y-m-d');
                $jadwal_booking[$id][$tanggal] = $p->keperluan ?? 'Telah dibooking / penuh';
            }
        }

        // 4. Lempar datanya ke file jadwal_fasilitas.blade.php
        return view('jadwal_fasilitas', compact('data_fasilitas', 'jadwal_booking'));
    }
}