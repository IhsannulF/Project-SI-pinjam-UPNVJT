<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT SEMUA CONTROLLER ---
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\JadwalController;


/*
|--------------------------------------------------------------------------
| Web Routes - SI-PINJAM UPNVJT
|--------------------------------------------------------------------------
*/

// --- 1. JALUR UMUM (BISA DIAKSES SIAPA SAJA) ---
Route::get('/', [App\Http\Controllers\FasilitasController::class, 'index'])->name('home');
Route::get('/jadwal-fasilitas', [JadwalController::class, 'index'])->name('jadwal.index');

Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
Route::get('/fasilitas/{id}', [FasilitasController::class, 'show'])->name('fasilitas.detail');


// --- 2. JALUR AUTENTIKASI (LOGIN & REGISTER) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 3. JALUR PROTEKSI (WAJIB LOGIN) ---
Route::middleware(['auth'])->group(function () {

    // --- AREA ADMIN ---
    // Dashboard Utama (Statistik)
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Rute untuk memproses pengajuan pinjaman dari Mahasiswa
    Route::post('/mahasiswa/ajukan-pinjam', [App\Http\Controllers\MahasiswaController::class, 'storePeminjaman'])->name('mahasiswa.pinjam.store');
    
    // Kelola Fasilitas (Halaman CRUD)
    Route::get('/admin/fasilitas', [AdminController::class, 'fasilitas'])->name('admin.fasilitas');
    Route::post('/admin/fasilitas/store', [AdminController::class, 'storeFasilitas'])->name('admin.fasilitas.store');
    Route::post('/admin/fasilitas/update', [AdminController::class, 'updateFasilitas'])->name('admin.fasilitas.update');
    Route::post('/admin/fasilitas/delete', [AdminController::class, 'destroyFasilitas'])->name('admin.fasilitas.delete');
    
    // Blokir Jadwal
    Route::post('/admin/block', [AdminController::class, 'blockSchedule'])->name('admin.block');
    Route::post('/admin/unblock-bulk', [App\Http\Controllers\AdminController::class, 'bulkUnblockJadwal'])->name('admin.unblock.bulk');
    Route::post('/admin/unblock-range', [App\Http\Controllers\AdminController::class, 'unblockRange'])->name('admin.unblock.range');

    Route::get('/admin/antrean', [App\Http\Controllers\AdminController::class, 'antrean'])->name('admin.antrean');
    Route::post('/admin/antrean/{id}/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])->name('admin.antrean.status');
    Route::get('/admin/pengguna', [App\Http\Controllers\AdminController::class, 'pengguna'])->name('admin.pengguna');
    Route::post('/admin/pengguna', [App\Http\Controllers\AdminController::class, 'storePengguna'])->name('admin.pengguna.store');
    // Rute untuk Edit dan Hapus Riwayat Antrean
    Route::put('/admin/antrean/{id}', [App\Http\Controllers\AdminController::class, 'updateJadwal'])->name('admin.antrean.update');
    // Rute untuk Edit dan Batalkan Riwayat Antrean
    Route::put('/admin/antrean/{id}/batal', [App\Http\Controllers\AdminController::class, 'batalkanJadwal'])->name('admin.antrean.batal');

    Route::put('/dosen/riwayat/{id}/batal', [App\Http\Controllers\DosenController::class, 'batalkan'])->name('dosen.riwayat.batal');
    


    // --- AREA DOSEN & TENDIK ---
    Route::get('/dashboard/dosen', [DosenController::class, 'index'])->name('dosen.dashboard');
    Route::get('/dosen/fasilitas', [DosenController::class, 'fasilitas'])->name('dosen.fasilitas');
    Route::get('/dosen/reservasi', [App\Http\Controllers\DosenController::class, 'createReservasi'])->name('dosen.reservasi');
    Route::post('/dosen/reservasi', [App\Http\Controllers\DosenController::class, 'storeReservasi'])->name('dosen.reservasi.store');
    Route::get('/dosen/riwayat', [App\Http\Controllers\DosenController::class, 'riwayat'])->name('dosen.riwayat');
    Route::get('/dosen/dashboard', [App\Http\Controllers\DosenController::class, 'dashboard'])->name('dosen.dashboard');


    // --- AREA MAHASISWA ---
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    // 1. Rute untuk membuka halaman Form Pengajuan (Ini yang memicu error tadi)
    Route::get('/mahasiswa/form-pinjam', [MahasiswaController::class, 'formPinjam'])->name('mahasiswa.pinjam.form');
    // 2. Rute untuk memproses data saat tombol "Ajukan Peminjaman" ditekan
    Route::post('/mahasiswa/ajukan-pinjam', [MahasiswaController::class, 'storePeminjaman'])->name('mahasiswa.pinjam.store');
    Route::get('/mahasiswa/cari-fasilitas', [App\Http\Controllers\MahasiswaController::class, 'cariFasilitas'])->name('mahasiswa.cari_fasilitas');
    // 3. Rute untuk memproses data saat tombol "Riwayat" ditekan
    Route::get('/mahasiswa/riwayat', [App\Http\Controllers\MahasiswaController::class, 'riwayat'])->name('mahasiswa.riwayat');

});

// ==========================================
// ROLE: PIHAK EKSTERNAL
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Rute Dashboard
    Route::get('/eksternal/dashboard', [App\Http\Controllers\EksternalController::class, 'dashboard'])->name('eksternal.dashboard');
    
    // Rute Reservasi (Form & Submit)
    Route::get('/eksternal/reservasi', [App\Http\Controllers\EksternalController::class, 'formReservasi'])->name('eksternal.reservasi');
    Route::post('/eksternal/reservasi', [App\Http\Controllers\EksternalController::class, 'storeReservasi'])->name('eksternal.reservasi.store');
    
    // Rute Riwayat
    Route::get('/eksternal/riwayat', [App\Http\Controllers\EksternalController::class, 'riwayat'])->name('eksternal.riwayat');
    Route::post('/eksternal/pembayaran', [App\Http\Controllers\EksternalController::class, 'storePembayaran'])->name('eksternal.pembayaran.store');

    Route::get('/eksternal/cari-fasilitas', [App\Http\Controllers\EksternalController::class, 'cariFasilitas'])->name('eksternal.cari_fasilitas');

    Route::get('/eksternal/detail-fasilitas', [App\Http\Controllers\EksternalController::class, 'detailFasilitas'])->name('eksternal.detail_fasilitas');
    // Rute Informasi & Template MoU
    Route::get('/eksternal/informasi', [App\Http\Controllers\EksternalController::class, 'informasi'])->name('eksternal.informasi');

    Route::get('/eksternal/fasilitas/{id}', [App\Http\Controllers\EksternalController::class, 'detailFasilitas'])->name('eksternal.detail_fasilitas');
});