<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_fasilitas',
        'tanggal_pinjam',
        'keperluan',
        'status',
    ];

    // Relasi ke tabel Fasilitas
    public function fasilitas() {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas');
    }
}