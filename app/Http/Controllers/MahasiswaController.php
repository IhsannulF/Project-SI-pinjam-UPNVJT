<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // WAJIB ditambahkan untuk manipulasi rentang tanggal

class MahasiswaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil 1 pengajuan paling terakhir untuk Banner
        $pengajuan_terakhir = Peminjaman::with('fasilitas')
                                ->where('id_user', $userId)
                                ->orderBy('id_peminjaman', 'desc')
                                ->first();

        // 2. Hitung statistik untuk Widget
        $stat_pending = Peminjaman::where('id_user', $userId)->where('status', 'pending')->count();
        $stat_disetujui = Peminjaman::where('id_user', $userId)->where('status', 'disetujui')->count();
        $stat_ditolak = Peminjaman::where('id_user', $userId)->where('status', 'ditolak')->count();

        // 3. Ambil 3 riwayat terbaru untuk tabel singkat
        $riwayat_singkat = Peminjaman::with('fasilitas')
                                ->where('id_user', $userId)
                                ->orderBy('id_peminjaman', 'desc')
                                ->take(3)
                                ->get();

        return view('mahasiswa.dashboard', compact(
            'pengajuan_terakhir', 'stat_pending', 'stat_disetujui', 'stat_ditolak', 'riwayat_singkat'
        ));
    }

    public function storePeminjaman(Request $request)
    {
        // 1. Validasi Input Rentang Waktu
        $request->validate([
            'id_fasilitas'     => 'required',
            'tanggal_mulai'    => 'required|date|after_or_equal:today',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai', // Berakhir harus >= Mulai
            'keperluan'        => 'required|string',
        ]);

        // 2. [VALIDASI SISTEM] Cek Bentrok Jadwal Rentang Waktu!
        // Algoritma: Jadwal bentrok jika (Mulai Baru <= Berakhir Lama) DAN (Berakhir Baru >= Mulai Lama)
        $cek_bentrok = Peminjaman::where('id_fasilitas', $request->id_fasilitas)
            ->whereIn('status', ['menunggu', 'disetujui', 'diblokir'])
            ->where(function ($query) use ($request) {
                $query->where('tanggal_mulai', '<=', $request->tanggal_berakhir)
                      ->where('tanggal_berakhir', '>=', $request->tanggal_mulai);
            })
            ->exists();

        if ($cek_bentrok) {
            return back()->with('error', 'Validasi Sistem Gagal: Maaf, fasilitas ini sudah dipesan atau diblokir pada rentang tanggal tersebut. Silakan pilih jadwal lain.');
        }

        // 3. Simpan Data Peminjaman (Status otomatis: menunggu)
        Peminjaman::create([
            'id_fasilitas'     => $request->id_fasilitas,
            'id_user'          => Auth::id(),
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'keperluan'        => $request->keperluan,
            'status'           => 'menunggu' 
        ]);

        // 4. Arahkan kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu validasi dari Admin.');
    }

    // Method untuk menampilkan halaman form pengajuan
    public function formPinjam()
    {
        $fasilitas = Fasilitas::orderBy('nama_fasilitas', 'asc')->get();
        return view('mahasiswa.formmahasiswa', compact('fasilitas'));
    }

    // Method untuk halaman Cari Fasilitas (dengan sidebar Mahasiswa)
    public function cariFasilitas()
    {
        $data_fasilitas = Fasilitas::all();
        $peminjaman = Peminjaman::whereIn('status', ['disetujui', 'pending', 'diblokir'])->get();

        $jadwal_booking = [];
        
        // Looping untuk mendaftarkan semua hari di antara rentang tanggal ke dalam array kalender
        foreach ($peminjaman as $p) {
            $id = $p->id_fasilitas;
            
            $start = Carbon::parse($p->tanggal_mulai);
            $end = Carbon::parse($p->tanggal_berakhir);
            
            // Isi array untuk setiap hari penyewaan
            for ($date = $start; $date->lte($end); $date->addDay()) {
                $tanggal = $date->format('Y-m-d');
                $jadwal_booking[$id][$tanggal] = $p->keperluan ?? 'Telah dibooking / penuh';
            }
        }

        return view('mahasiswa.carifasilitas', compact('data_fasilitas', 'jadwal_booking'));
    }

    // Method untuk halaman Riwayat Pengajuan
    public function riwayat()
    {
        $riwayat = Peminjaman::with('fasilitas')
                    ->where('id_user', Auth::id())
                    ->orderBy('id_peminjaman', 'desc')
                    ->get();

        return view('mahasiswa.riwayat', compact('riwayat'));
    }
}