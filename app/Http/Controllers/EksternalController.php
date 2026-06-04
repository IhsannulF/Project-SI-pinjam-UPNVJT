<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class EksternalController extends Controller
{
    // 1. Menampilkan Form Reservasi Khusus Eksternal
    public function formReservasi()
    {
        // FILTER KETAT: Hanya tampilkan fasilitas GSG dan Lapangan/Olahraga
        $fasilitas = Fasilitas::whereIn('kategori', ['GSG', 'Lapangan', 'Olahraga', 'Umum'])->get();
        
        return view('eksternal.reservasi', compact('fasilitas'));
    }

    // 2. Memproses Pengajuan Awal Eksternal (Hanya Upload MoU)
    public function storeReservasi(Request $request)
    {
        // Validasi Ketat (Bukti bayar dihapus dari validasi awal)
        $request->validate([
            'id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
            'dokumen_mou' => 'required|file|mimes:pdf|max:2048', // Wajib PDF, max 2MB
        ]);

        // Proses Upload File MoU
        $fileMou = $request->file('dokumen_mou');
        $namaMou = time() . '_MoU_' . Auth::id() . '.' . $fileMou->getClientOriginalExtension();
        
        // Tetap menggunakan path lama Anda (public_path) agar tidak membingungkan
        $fileMou->move(public_path('uploads/mou'), $namaMou);

        // Simpan ke Database dengan Status Baru
        Peminjaman::create([
            'id_user' => Auth::id(),
            'id_fasilitas' => $request->id_fasilitas,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'keperluan' => $request->keperluan,
            'dokumen_mou' => $namaMou,
            // bukti_bayar dibiarkan kosong
            'status' => 'Menunggu Verifikasi MoU' // Status awal untuk alur baru
        ]);

        return redirect()->route('eksternal.riwayat')->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu verifikasi MoU oleh Admin.');
    }

   // 3. Menampilkan Dashboard Eksternal
    public function dashboard()
    {
        $userId = Auth::id();
        
        // Hitung Statistik
        $stat_pending = Peminjaman::where('id_user', $userId)->whereIn('status', ['menunggu', 'pending', 'Menunggu Verifikasi MoU', 'Menunggu Pembayaran', 'Menunggu Konfirmasi Jadwal'])->count();
        $stat_disetujui = Peminjaman::where('id_user', $userId)->where('status', 'disetujui')->count();
        $stat_ditolak = Peminjaman::where('id_user', $userId)->where('status', 'ditolak')->count();
        $dibatalkan = Peminjaman::where('id_user', $userId)->where('status', 'dibatalkan')->count();

        // Ambil Data Terakhir (Diperbaiki: Ganti latest() dengan orderBy)
        $pengajuan_terakhir = Peminjaman::with('fasilitas')->where('id_user', $userId)->orderBy('id_peminjaman', 'desc')->first();
        $riwayat_singkat = Peminjaman::with('fasilitas')->where('id_user', $userId)->orderBy('id_peminjaman', 'desc')->take(5)->get();

        return view('eksternal.dashboard', compact(
            'stat_pending', 'stat_disetujui', 'stat_ditolak', 'dibatalkan', 'pengajuan_terakhir', 'riwayat_singkat'
        ));
    }

    // 4. Menampilkan Halaman Riwayat Eksternal Lengkap
    public function riwayat()
    {
        $userId = Auth::id();
        
        // (Diperbaiki: Ganti latest() dengan orderBy)
        $riwayat = Peminjaman::with('fasilitas')->where('id_user', $userId)->orderBy('id_peminjaman', 'desc')->get();
        
        return view('eksternal.riwayat', compact('riwayat'));
    }

    // 5. Menampilkan Halaman Cari Fasilitas & Kalender Eksternal
    public function cariFasilitas()
    {
        // 1. Ambil daftar fasilitas (HANYA UNTUK EKSTERNAL: GSG, Lapangan, Umum)
        $fasilitas = Fasilitas::whereIn('kategori', ['GSG', 'Lapangan', 'Olahraga', 'Umum'])->get();
        
        // 2. Ambil jadwal booking untuk fasilitas tersebut
        $peminjaman = Peminjaman::whereHas('fasilitas', function($q) {
                $q->whereIn('kategori', ['GSG', 'Lapangan', 'Olahraga', 'Umum']);
            })
            ->whereIn('status', ['disetujui', 'pending', 'menunggu', 'diblokir', 'Menunggu Pembayaran', 'Menunggu Konfirmasi Jadwal'])
            ->get();

        // 3. Format struktur array SAMA PERSIS dengan format Mahasiswa (Looping per hari)
        $events = [];
        
        foreach ($peminjaman as $p) {
            $id = $p->id_fasilitas;
            
            // Konversi ke Carbon agar bisa di-loop per hari
            $start = \Carbon\Carbon::parse($p->tanggal_mulai ?? $p->tanggal_pinjam);
            // Jika tanggal berakhir kosong, samakan dengan tanggal mulai (booking 1 hari)
            $end = $p->tanggal_berakhir ? \Carbon\Carbon::parse($p->tanggal_berakhir) : $start->copy();
            
            // Loop untuk setiap hari di rentang waktu booking
            for ($date = $start; $date->lte($end); $date->addDay()) {
                $tanggal = $date->format('Y-m-d');
                // Masukkan format JSON: events[id_fasilitas][tanggal] = alasan
                $events[$id][$tanggal] = $p->keperluan ?? 'Telah dibooking / penuh';
            }
        }

        // Kirim $events ini, lalu di file Blade (.blade.php) 
        // akan dikonversi ke JSON dan ditangkap oleh window.dataJadwalBooking
        return view('eksternal.cari_fasilitas', compact('fasilitas', 'events'));
    }

    // 6. Menampilkan Halaman Panduan, Download MoU, dan Info Pembayaran
    public function informasi()
    {
        return view('eksternal.informasi');
    }

    // Fungsi untuk memproses upload bukti pembayaran eksternal
    public function storePembayaran(Request $request)
    {
        // 1. Validasi File Bukti Transfer
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ], [
            'bukti_bayar.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_bayar.mimes' => 'Format file harus berupa JPG, PNG, atau PDF.',
            'bukti_bayar.max' => 'Ukuran file maksimal adalah 2MB.'
        ]);

        $peminjaman = \App\Models\Peminjaman::findOrFail($request->id_peminjaman);

        // 2. Proses Upload Fisik File ke public/uploads/bukti_bayar
        $fileBukti = $request->file('bukti_bayar');
        $namaBukti = time() . '_Bukti_' . \Illuminate\Support\Facades\Auth::id() . '.' . $fileBukti->getClientOriginalExtension();
        $fileBukti->move(public_path('uploads/bukti_bayar'), $namaBukti);

        // 3. Update Kolom bukti_bayar dan Naikkan Status
        $peminjaman->update([
            'bukti_bayar' => $namaBukti,
            'status' => 'Menunggu Konfirmasi Jadwal' // Status naik ke tahap verifikasi akhir admin
        ]);

        // 4. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Silakan menunggu konfirmasi akhir jadwal dari Admin.');
    }


    public function detailFasilitas()
    {
        // Ambil semua data fasilitas
        $q_fasilitas = \App\Models\Fasilitas::all();
        
        return view('eksternal.detail_fasilitas', compact('q_fasilitas'));
    }
}