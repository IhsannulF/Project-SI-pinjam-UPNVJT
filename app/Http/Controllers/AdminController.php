<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;

class AdminController extends Controller
{
    // --- 1. HALAMAN DASHBOARD ---
    public function index()
    {
        $count_pending = Peminjaman::whereIn('status', [
            'pending', 
            'menunggu', 
            'Menunggu Verifikasi MoU', 
            'Menunggu Pembayaran', 
            'Menunggu Konfirmasi Jadwal'
        ])->count();

        $count_disetujui = Peminjaman::where('status', 'disetujui')->count();
        $count_fasilitas = Fasilitas::count();

        $recent_bookings = Peminjaman::with('fasilitas')
                            ->where('status', '!=', 'diblokir')
                            ->orderBy('id_peminjaman', 'desc')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('count_pending', 'count_disetujui', 'count_fasilitas', 'recent_bookings'));
    }

    // --- 2. HALAMAN KELOLA FASILITAS ---
    public function fasilitas()
    {
        $q_fasilitas = Fasilitas::orderBy('kategori', 'asc')->get();
        
        // REVISI: Hanya mengambil data yang statusnya murni "diblokir" oleh Admin
        $q_blokir = Peminjaman::with('fasilitas')
            ->where('status', 'diblokir') // <--- Diubah menjadi spesifik hanya status ini
            ->where(function ($query) {
                // Tetap mempertahankan fitur otomatis hilang jika sudah kedaluwarsa
                $query->whereDate('tanggal_berakhir', '>=', now()->toDateString())
                      ->orWhereDate('tanggal_mulai', '>=', now()->toDateString());
            })
            ->orderBy('tanggal_mulai', 'asc')
            ->get();
            
        return view('admin.fasilitas', compact('q_fasilitas', 'q_blokir'));
    }

    // --- 3. CRUD FASILITAS ---
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
            'kategori'       => $request->kategori,
            'kapasitas'      => $request->kapasitas,
            'harga_per_hari' => $request->harga_per_hari,
            'ikon'           => $request->ikon,
            'foto_fasilitas' => $foto_nama,
            'status'         => 'tersedia'
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
            'kategori'       => $request->kategori,
            'kapasitas'      => $request->kapasitas,
            'harga_per_hari' => $request->harga_per_hari,
            'foto_fasilitas' => $foto_final,
            'ikon'           => $request->ikon,
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

    // --- 4. LOGIKA BLOKIR JADWAL ---
    public function blockSchedule(Request $request)
    {
        $request->validate([
            'id_fasilitas_blokir' => 'required',
            'tanggal_mulai'       => 'required|date',
            'tanggal_berakhir'    => 'required|date|after_or_equal:tanggal_mulai',
            'keperluan'           => 'required|string'
        ]);

        $period = CarbonPeriod::create($request->tanggal_mulai, $request->tanggal_berakhir);
        $berhasil = 0;
        $dilewati = 0;

        foreach ($period as $date) {
            $tgl = $date->format('Y-m-d');

            $sudahAda = Peminjaman::where('id_fasilitas', $request->id_fasilitas_blokir)
                                  ->where('tanggal_mulai', $tgl)
                                  ->whereIn('status', ['diblokir', 'disetujui', 'pending'])
                                  ->exists();

            if (!$sudahAda) {
                Peminjaman::create([
                    'id_fasilitas'     => $request->id_fasilitas_blokir,
                    'id_user'          => Auth::id() ?? 1,
                    'tanggal_mulai'    => $tgl,
                    'tanggal_berakhir' => $tgl, // PENTING: Harus diisi agar data valid untuk pop-up edit!
                    'keperluan'        => $request->keperluan,
                    'status'           => 'diblokir'
                ]);
                $berhasil++;
            } else {
                $dilewati++;
            }
        }

        if ($berhasil > 0) {
            $pesan = "$berhasil hari jadwal berhasil diblokir.";
            if ($dilewati > 0) {
                $pesan .= " ($dilewati hari dilewati karena sudah ada jadwal/blokir sebelumnya).";
            }
            return back()->with('success', $pesan);
        } else {
            return back()->with('error', 'Gagal memblokir. Seluruh tanggal di rentang tersebut sudah terisi sebelumnya.');
        }
    }

    // --- 5. LOGIKA BUKA BLOKIR RENTANG TANGGAL ---
    public function unblockRange(Request $request)
    {
        $request->validate([
            'id_fasilitas_unblock' => 'required',
            'tanggal_mulai_unblock' => 'required|date',
            'tanggal_berakhir_unblock' => 'required|date|after_or_equal:tanggal_mulai_unblock',
        ]);

        // PENTING: Menggunakan query where() yang mencari rentang overlap
        $deleted = Peminjaman::where('id_fasilitas', $request->id_fasilitas_unblock)
            ->where('status', 'diblokir')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai_unblock, $request->tanggal_berakhir_unblock])
                      ->orWhereBetween('tanggal_berakhir', [$request->tanggal_mulai_unblock, $request->tanggal_berakhir_unblock]);
            })
            ->delete();

        if($deleted) {
            return back()->with('success', "$deleted sesi jadwal blokir berhasil dihapus/dibuka pada rentang tersebut.");
        } else {
            return back()->with('error', 'Gagal membuka blokir. Pastikan rentang tanggal yang dipilih benar.');
        }
    }
    
    // --- 6. HALAMAN ANTREAN PINJAMAN ---
    public function antrean()
    {
        $antrean_baru = Peminjaman::with(['user', 'fasilitas'])
            ->whereIn('status', [
                'menunggu', 
                'pending', 
                'Menunggu Verifikasi MoU', 
                'Menunggu Pembayaran', 
                'Menunggu Konfirmasi Jadwal'
            ])
            ->orderBy('id_peminjaman', 'asc')
            ->get();

        $riwayat_proses = \App\Models\Peminjaman::with(['user', 'fasilitas'])
            ->whereIn('status', ['disetujui', 'ditolak', 'diblokir', 'dibatalkan'])
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        return view('admin.antrean', compact('antrean_baru', 'riwayat_proses'));
    }

    // --- 7. MEMPROSES PERUBAHAN STATUS ---
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,menunggu,diblokir,dibatalkan,Menunggu Verifikasi MoU,Menunggu Pembayaran,Menunggu Konfirmasi Jadwal'
        ]);

        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => $request->status
        ]);

        if ($request->status == 'disetujui') {
            $pesan = 'Pengajuan berhasil disetujui!';
        } elseif ($request->status == 'ditolak') {
            $pesan = 'Pengajuan berhasil ditolak!';
        } elseif ($request->status == 'Menunggu Pembayaran') {
            $pesan = 'Tagihan berhasil diterbitkan! Menunggu pembayaran dari instansi.';
        } elseif ($request->status == 'Menunggu Konfirmasi Jadwal') {
            $pesan = 'Bukti bayar telah diterima. Silakan atur jadwal terkait.';
        } else {
            $pesan = 'Status pengajuan berhasil diperbarui menjadi: ' . $request->status;
        }

        return back()->with('success', $pesan);
    }

    // --- 8. KELOLA PENGGUNA ---
    public function pengguna()
    {
        $users = \App\Models\User::orderBy('role')->orderBy('nama_lengkap', 'asc')->get();
        return view('admin.pengguna', compact('users'));
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'identitas'    => 'required|string|max:50|unique:users,identitas',
            'email'        => 'required|string|email|max:255|unique:users,email', 
            'password'     => 'required|string|min:8',
            'role'         => 'required|in:admin,dosen,mahasiswa,umum',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'identitas'    => $request->identitas, 
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);

        return back()->with('success', 'Pengguna baru berhasil didaftarkan!');
    }

    // --- 9. KELOLA RIWAYAT ---
    public function updateJadwal(Request $request, $id)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        $peminjaman->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->back()->with('success', 'Tanggal peminjaman berhasil diperbarui!');
    }

    public function batalkanJadwal($id)
    {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => 'dibatalkan'
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil dibatalkan!');
    }
}