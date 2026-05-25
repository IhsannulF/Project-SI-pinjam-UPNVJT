<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        // 1. Ambil 1 pengajuan paling terakhir untuk Banner
        $pengajuan_terakhir = \App\Models\Peminjaman::with('fasilitas')
                                ->where('id_user', $userId)
                                ->orderBy('id_peminjaman', 'desc')
                                ->first();

        // 2. Hitung statistik untuk Widget
        $stat_pending = \App\Models\Peminjaman::where('id_user', $userId)->where('status', 'pending')->count();
        $stat_disetujui = \App\Models\Peminjaman::where('id_user', $userId)->where('status', 'disetujui')->count();
        $stat_ditolak = \App\Models\Peminjaman::where('id_user', $userId)->where('status', 'ditolak')->count();

        // 3. Ambil 3 riwayat terbaru untuk tabel singkat
        $riwayat_singkat = \App\Models\Peminjaman::with('fasilitas')
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
        // 1. Validasi Input Dasar
        $request->validate([
            'id_fasilitas' => 'required',
            'tanggal_pinjam' => 'required|date|after_or_equal:today', // Tidak boleh pinjam tanggal yang sudah lewat
            'keperluan' => 'required|string',
            // 'dokumen' => 'nullable|file|mimes:pdf|max:2048' // Buka komentar ini jika nanti butuh upload surat/proposal
        ]);

        // 2. [VALIDASI SISTEM] Cek Bentrok Jadwal!
        // Memastikan tidak ada yang berstatus 'pending', 'disetujui', atau 'diblokir' di tanggal yang sama
        $cek_bentrok = Peminjaman::where('id_fasilitas', $request->id_fasilitas)
            ->where('tanggal_pinjam', $request->tanggal_pinjam)
            ->whereIn('status', ['pending', 'disetujui', 'diblokir'])
            ->exists();

        if ($cek_bentrok) {
            return back()->with('error', 'Validasi Sistem Gagal: Maaf, fasilitas ini sudah dipesan atau diblokir pada tanggal tersebut. Silakan pilih tanggal lain.');
        }

        // 3. Simpan Data Peminjaman (Status otomatis: pending)
        Peminjaman::create([
            'id_fasilitas' => $request->id_fasilitas,
            'id_user' => Auth::id(), // ID Mahasiswa yang sedang login
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'keperluan' => $request->keperluan,
            'status' => 'pending' // Sesuai alur: Menunggu Admin
        ]);

        // 4. Arahkan kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu validasi dari Admin.');
        
        // Catatan: Jika Anda punya halaman riwayat, bisa diubah menjadi:
        // return redirect()->route('mahasiswa.riwayat')->with('success', '...');
    }

    // Method untuk menampilkan halaman form pengajuan
    public function formPinjam()
    {
        // Ambil semua fasilitas untuk dimasukkan ke dropdown form
        $fasilitas = \App\Models\Fasilitas::orderBy('nama_fasilitas', 'asc')->get();
        
        return view('mahasiswa.formmahasiswa', compact('fasilitas'));
    }

    // Method untuk halaman Cari Fasilitas (dengan sidebar Mahasiswa)
    public function cariFasilitas()
    {
        $data_fasilitas = \App\Models\Fasilitas::all();
        $peminjaman = \App\Models\Peminjaman::whereIn('status', ['disetujui', 'pending', 'diblokir'])->get();

        $jadwal_booking = [];
        foreach ($peminjaman as $p) {
            $id = $p->id_fasilitas;
            $tanggal = date('Y-m-d', strtotime($p->tanggal_pinjam));
            $jadwal_booking[$id][$tanggal] = $p->keperluan ?? 'Telah dibooking / penuh';
        }

        return view('mahasiswa.carifasilitas', compact('data_fasilitas', 'jadwal_booking'));
    }

    // Method untuk halaman Riwayat Pengajuan
    public function riwayat()
    {
        // Mengambil data peminjaman milik user yang sedang login (Auth::id())
        // Menggunakan 'with' untuk memanggil relasi tabel fasilitas
        // Diurutkan dari yang terbaru (created_at desc)
        $riwayat = \App\Models\Peminjaman::with('fasilitas')
                    ->where('id_user', \Illuminate\Support\Facades\Auth::id())
                    ->orderBy('id_peminjaman', 'desc')
                    ->get();

        return view('mahasiswa.riwayat', compact('riwayat'));
    }
    

}