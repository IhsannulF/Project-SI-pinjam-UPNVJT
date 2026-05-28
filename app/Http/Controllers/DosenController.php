<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use Carbon\Carbon;
use App\Models\Fasilitas;

class DosenController extends Controller
{
    public function index()
    {
        // Pastikan Dosen sudah login
        $userId = Auth::id();

        // 1. Hitung Jadwal Aktif (Menunggu atau Disetujui) milik Dosen yang sedang login
        $jadwal_aktif = Peminjaman::where('id_user', $userId)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        // 2. Hitung Total Riwayat (Ditolak atau Diblokir) milik Dosen yang sedang login
        $total_riwayat = Peminjaman::where('id_user', $userId)
            ->whereIn('status', ['ditolak', 'diblokir'])
            ->count();

        return view('dosen.dashboard', compact('jadwal_aktif', 'total_riwayat'));
    }

    public function fasilitas()
    {
        // 1. Ambil data fasilitas
        $fasilitas = \App\Models\Fasilitas::all();
        
        // 2. Ambil data jadwal booking untuk kalender interaktif
        $peminjaman = \App\Models\Peminjaman::whereIn('status', ['disetujui', 'menunggu', 'diblokir'])->get();

        $jadwal_booking = [];
        foreach ($peminjaman as $p) {
            $id = $p->id_fasilitas;
            $start = \Carbon\Carbon::parse($p->tanggal_mulai);
            $end = \Carbon\Carbon::parse($p->tanggal_berakhir);
            
            for ($date = $start; $date->lte($end); $date->addDay()) {
                $tanggal = $date->format('Y-m-d');
                $jadwal_booking[$id][$tanggal] = $p->keperluan ?? 'Telah dibooking / penuh';
            }
        }
        
        // Lempar $fasilitas dan $jadwal_booking ke view
        return view('dosen.fasilitas', compact('fasilitas', 'jadwal_booking'));
    }

    // 1. Menampilkan Halaman Form Reservasi Prioritas
    public function createReservasi()
    {
        // Tarik semua fasilitas tanpa terkecuali (Akses All-Area)
        $fasilitas = Fasilitas::all();
        return view('dosen.reservasi', compact('fasilitas'));
    }

    // 2. Memproses Data Reservasi (Auto-Approve)
    public function storeReservasi(Request $request)
    {
        $request->validate([
            'id_fasilitas' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string|max:255',
        ]);

        // Simpan data langsung dengan status 'disetujui'
        Peminjaman::create([
            'id_user' => Auth::id(),
            'id_fasilitas' => $request->id_fasilitas,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'keperluan' => $request->keperluan,
            'surat_pengantar' => null, // Bebas birokrasi, tidak perlu file
            'status' => 'disetujui' // APPROVAL INSTAN VIP
        ]);

        // Lempar kembali ke dashboard dengan pesan sukses
        return redirect()->route('dosen.dashboard')->with('success', 'Reservasi Prioritas berhasil dibuat dan telah disetujui secara otomatis oleh sistem!');
    }

    // 3. Menampilkan Riwayat Pengajuan Dosen
    public function riwayat()
    {
        $userId = Auth::id();
        
        // Ambil data peminjaman khusus milik Dosen yang sedang login beserta relasinya
        $riwayat = Peminjaman::with(['fasilitas', 'user'])
                    ->where('id_user', $userId)
                    ->orderBy('id_peminjaman', 'desc')
                    ->get();

        return view('dosen.riwayat', compact('riwayat'));
    }

    // 4. Membatalkan Pengajuan (Ubah Status)
    public function batalkan($id)
    {
        // Pastikan data yang dibatalkan adalah milik dosen yang sedang login
        $peminjaman = Peminjaman::where('id_peminjaman', $id)
                        ->where('id_user', Auth::id())
                        ->firstOrFail();

        // Ubah status menjadi dibatalkan
        $peminjaman->update([
            'status' => 'dibatalkan'
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}