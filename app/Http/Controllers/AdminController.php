<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // --- 1. FUNGSI UTAMA INI YANG HILANG/BELUM ADA ---
    public function index()
    {
        // Menghitung data statistik untuk Card
        $count_pending = Peminjaman::where('status', 'pending')->count();
        $count_disetujui = Peminjaman::where('status', 'disetujui')->count();
        $count_fasilitas = Fasilitas::count();

        // Mengambil data peminjaman terbaru
        $recent_bookings = Peminjaman::with('fasilitas')
                            ->where('status', '!=', 'diblokir')
                            ->orderBy('id_peminjaman', 'desc')
                            ->take(5)
                            ->get();

        // Pastikan file-nya ada di resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', compact('count_pending', 'count_disetujui', 'count_fasilitas', 'recent_bookings'));
    }

    // 2. Fungsi untuk halaman kelola fasilitas
    public function fasilitas()
    {
        $q_fasilitas = Fasilitas::orderBy('kategori', 'asc')->get();
        $q_blokir = Peminjaman::with('fasilitas')->where('status', 'diblokir')->get();
        return view('admin.fasilitas', compact('q_fasilitas', 'q_blokir'));
    }

    // --- FUNGSI CRUD LAINNYA ---
    public function storeFasilitas(Request $request)
    {
        $foto_nama = "";
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto_nama = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/fasilitas'), $foto_nama);
        }
        Fasilitas::create([
            'nama_fasilitas' => $request->nama,
            'kategori' => $request->kategori,
            'kapasitas' => $request->kapasitas,
            'ikon' => $request->ikon,
            'foto_fasilitas' => $foto_nama,
            'status' => 'tersedia'
        ]);
        return back()->with('success', 'Fasilitas berhasil ditambah!');
    }

    public function updateFasilitas(Request $request)
    {
        $fasilitas = Fasilitas::findOrFail($request->id_edit);
        $foto_final = $fasilitas->foto_fasilitas;
        if ($request->hasFile('foto_baru')) {
            if ($foto_final && File::exists(public_path('assets/images/fasilitas/'.$foto_final))) {
                File::delete(public_path('assets/images/fasilitas/'.$foto_final));
            }
            $file = $request->file('foto_baru');
            $foto_final = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/fasilitas'), $foto_final);
        }
        $fasilitas->update([
            'nama_fasilitas' => $request->nama,
            'kategori' => $request->kategori,
            'kapasitas' => $request->kapasitas,
            'foto_fasilitas' => $foto_final
        ]);
        return back()->with('success', 'Fasilitas diperbarui!');
    }

    public function destroyFasilitas(Request $request)
    {
        $fasilitas = Fasilitas::findOrFail($request->id_hapus);
        if ($fasilitas->foto_fasilitas && File::exists(public_path('assets/images/fasilitas/'.$fasilitas->foto_fasilitas))) {
            File::delete(public_path('assets/images/fasilitas/'.$fasilitas->foto_fasilitas));
        }
        $fasilitas->delete();
        return back()->with('success', 'Fasilitas dihapus!');
    }

    public function blockSchedule(Request $request)
    {
        $begin = new \DateTime($request->tanggal_mulai);
        $end = new \DateTime($request->tanggal_selesai);
        $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            Peminjaman::firstOrCreate([
                'id_fasilitas' => $request->id_fasilitas_blokir,
                'tanggal_pinjam' => $dt->format("Y-m-d")
            ], [
                'id_user' => null,
                'keperluan' => $request->keperluan,
                'status' => 'diblokir'
            ]);
        }
        return back()->with('success', 'Jadwal diblokir!');
    }

    public function unblockSchedule(Request $request)
    {
        Peminjaman::destroy($request->id_buka_blokir);
        return back()->with('success', 'Blokir dibuka!');
    }
}