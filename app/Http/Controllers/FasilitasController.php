<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas; // Jembatan ke database
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
public function index()
    {
        // Hanya mengambil fasilitas yang statusnya 'tersedia'
        $data_fasilitas = \App\Models\Fasilitas::where('status', 'tersedia')->get();

        return view('jadwal_fasilitas', compact('data_fasilitas'));
    }

    // --- TAMBAHKAN FUNGSI INI DI BAWAH FUNGSI index() ---

    public function show($id)
    {
        // 1. Cari fasilitas berdasarkan ID
        $data = \App\Models\Fasilitas::find($id);

        // 2. Jika ID tidak ditemukan di database, kembalikan ke Beranda
        if (!$data) {
            return redirect('/');
        }

        // 3. Trik Gambar Dinamis (Dipindah ke Controller agar View lebih bersih)
        $kumpulan_gambar = [
            1  => "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200", // GSG
            17 => "https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=1200", // Giri Loka
            12 => "https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=1200", // Seminar GKB
            18 => "https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1200", // Perpustakaan
            2  => "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200", // Lab Komputer 1
            3  => "https://images.unsplash.com/photo-1577415124269-ce1140073282?q=80&w=1200"  // Kelas Kuliah Bersama
        ];

        // Cek gambar, jika tidak ada pakai gambar default
        $gambar_tampil = isset($kumpulan_gambar[$id]) ? $kumpulan_gambar[$id] : "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200";

        // 4. Kirim data dan gambar ke tampilan Blade
        return view('detail_fasilitas', compact('data', 'gambar_tampil'));
    }
}