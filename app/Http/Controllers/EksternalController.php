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

    // 2. Memproses Pengajuan Eksternal (Wajib Upload)
    public function storeReservasi(Request $request)
    {
        // Validasi Ketat
        $request->validate([
            'id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan' => 'required|string',
            'dokumen_mou' => 'required|file|mimes:pdf|max:2048', // Wajib PDF, max 2MB
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Wajib PDF/Gambar, max 2MB
        ]);

        // Proses Upload File MoU
        $fileMou = $request->file('dokumen_mou');
        $namaMou = time() . '_MoU_' . Auth::id() . '.' . $fileMou->getClientOriginalExtension();
        $fileMou->move(public_path('uploads/mou'), $namaMou);

        // Proses Upload Bukti Bayar
        $fileBukti = $request->file('bukti_bayar');
        $namaBukti = time() . '_Bukti_' . Auth::id() . '.' . $fileBukti->getClientOriginalExtension();
        $fileBukti->move(public_path('uploads/bukti_bayar'), $namaBukti);

        // Simpan ke Database dengan Status 'menunggu'
        Peminjaman::create([
            'id_user' => Auth::id(),
            'id_fasilitas' => $request->id_fasilitas,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'keperluan' => $request->keperluan,
            'dokumen_mou' => $namaMou,
            'bukti_bayar' => $namaBukti,
            'status' => 'menunggu' // Eksternal wajib menunggu validasi Admin
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim! Menunggu validasi Admin.');
    }
}