<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod; // Wajib ditambahkan untuk mengelola rentang tanggal

class AdminController extends Controller
{
    // --- 1. HALAMAN DASHBOARD ---
    public function index()
    {
        // Menggabungkan semua status yang perlu diproses ke dalam hitungan "Pending"
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
        // Mengambil semua data blokir tanpa dibatasi (jangan pakai limit/take di sini)
        $q_blokir = Peminjaman::with('fasilitas')->where('status', 'diblokir')->get();
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

    // --- 4. LOGIKA BLOKIR JADWAL (SUDAH DIPERBAIKI) ---
    public function blockSchedule(Request $request)
    {
        // 1. Validasi input untuk keamanan
        $request->validate([
            'id_fasilitas_blokir' => 'required',
            'tanggal_mulai'       => 'required|date',
            'tanggal_berakhir'    => 'required|date|after_or_equal:tanggal_mulai', // Disesuaikan dengan form HTML
            'keperluan'           => 'required|string'
        ]);

        // 2. Buat rentang tanggal menggunakan fitur bawaan Laravel (Carbon)
        $period = CarbonPeriod::create($request->tanggal_mulai, $request->tanggal_berakhir);
        $berhasil = 0;
        $dilewati = 0;

        foreach ($period as $date) {
            $tgl = $date->format('Y-m-d');

            // 3. Cek Pintar: Apakah tanggal ini sudah terisi?
            $sudahAda = Peminjaman::where('id_fasilitas', $request->id_fasilitas_blokir)
                                  ->where('tanggal_pinjam', $tgl)
                                  ->whereIn('status', ['diblokir', 'disetujui', 'pending'])
                                  ->exists();

            if (!$sudahAda) {
                // Jika masih kosong, blokir!
                Peminjaman::create([
                    'id_fasilitas'   => $request->id_fasilitas_blokir,
                    'id_user' => Auth::id() ?? 1,
                    'tanggal_pinjam' => $tgl,
                    'keperluan'      => $request->keperluan,
                    'status'         => 'diblokir'
                ]);
                $berhasil++;
            } else {
                // Jika sudah ada jadwal di tanggal ini, catat sebagai 'dilewati'
                $dilewati++;
            }
        }

        // 4. Laporan yang informatif untuk Admin
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

    // --- 5. LOGIKA BUKA BLOKIR RENTANG TANGGAL (POP-UP SWEETALERT) ---
    public function unblockRange(Request $request)
    {
        $request->validate([
            'id_fasilitas_unblock' => 'required',
            'tanggal_mulai_unblock' => 'required|date',
            'tanggal_berakhir_unblock' => 'required|date|after_or_equal:tanggal_mulai_unblock',
        ]);

        // Hapus massal data blokir yang berada di dalam rentang tanggal
        $deleted = Peminjaman::where('id_fasilitas', $request->id_fasilitas_unblock)
            ->where('status', 'diblokir')
            ->whereBetween('tanggal_pinjam', [$request->tanggal_mulai_unblock, $request->tanggal_berakhir_unblock])
            ->delete();

        if($deleted) {
            return back()->with('success', "$deleted hari jadwal blokir berhasil dibuka pada rentang tersebut.");
        } else {
            return back()->with('error', 'Tidak ditemukan jadwal diblokir pada rentang tersebut.');
        }
    }
    
    // 1. Menampilkan Halaman Antrean Pinjaman
    public function antrean()
    {
        // 1. Antrean Baru (Belum selesai diproses)
        // DITAMBAHKAN: 'Menunggu Pembayaran' agar data tidak hilang dari pengawasan Admin
        $antrean_baru = Peminjaman::with(['user', 'fasilitas'])
            ->whereIn('status', [
                'menunggu', 
                'pending', 
                'Menunggu Verifikasi MoU', 
                'Menunggu Pembayaran', 
                'Menunggu Konfirmasi Jadwal'
            ])
            ->orderBy('id_peminjaman', 'asc') // Antrean yang masuk duluan berada di atas
            ->get();

        // 2. Riwayat (Sudah selesai diproses / final)
        // DITAMBAHKAN: 'dibatalkan' untuk merekam jadwal yang dibatalkan
        $riwayat_proses = \App\Models\Peminjaman::with(['user', 'fasilitas'])
            ->whereIn('status', ['disetujui', 'ditolak', 'diblokir', 'dibatalkan'])
            ->orderBy('id_peminjaman', 'desc') // Riwayat yang baru saja diproses berada di atas
            ->get();

        return view('admin.antrean', compact('antrean_baru', 'riwayat_proses'));
    }

    // 2. Memproses Perubahan Status (Terima / Tolak)
    public function updateStatus(Request $request, $id)
    {
    // 1. Validasi Cukup SEKALI Saja
    $request->validate([
        'status' => 'required|in:disetujui,ditolak,menunggu,diblokir,dibatalkan,Menunggu Verifikasi MoU,Menunggu Pembayaran,Menunggu Konfirmasi Jadwal'
    ]);

    // 2. Ambil Data dan Update Cukup SEKALI
    $peminjaman = \App\Models\Peminjaman::findOrFail($id);
    $peminjaman->update([
        'status' => $request->status
    ]);

    // 3. Logika Pesan Notifikasi Dinamis
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

    // 3. Menampilkan Halaman Data Pengguna
    public function pengguna()
    {
        // Mengambil semua user, diurutkan berdasarkan role lalu nama
        $users = \App\Models\User::orderBy('role')->orderBy('nama_lengkap', 'asc')->get();
        return view('admin.pengguna', compact('users'));
    }

    // Fungsi untuk menyimpan data pengguna baru dari Modal
    public function storePengguna(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'identitas'    => 'required|string|max:50|unique:users,identitas', // Tambahan validasi identitas
            'email'        => 'required|string|email|max:255|unique:users,email', 
            'password'     => 'required|string|min:8',
            'role'         => 'required|in:admin,dosen,mahasiswa,umum',
        ]);

        // Simpan ke database
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'identitas'    => $request->identitas, 
            'email'        => $request->email,
            'password'     => Hash::make($request->password), // Enkripsi password
            'role'         => $request->role,
        ]);

        return back()->with('success', 'Pengguna baru berhasil didaftarkan!');
    }

    // --- FITUR KELOLA RIWAYAT ---

    // 1. Fungsi Update Tanggal Riwayat
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

    // 2. Fungsi Batalkan Riwayat (Bukan Hapus Permanen)
    public function batalkanJadwal($id)
    {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        
        // Ubah status menjadi dibatalkan
        $peminjaman->update([
            'status' => 'dibatalkan'
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil dibatalkan!');
    }
}