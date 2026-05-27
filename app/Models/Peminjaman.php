<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;
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

    // Relasi ke tabel User
    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
}