<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    // 1. Beri tahu Laravel nama tabel aslinya
    protected $table = 'fasilitas'; 

    // 2. Beri tahu Laravel bahwa Primary Key-nya bukan 'id'
    protected $primaryKey = 'id_fasilitas';

    // 3. Matikan fitur waktu otomatis karena tabel lama tidak punya kolom ini
    public $timestamps = false; 
    
    // 4. Daftarkan semua kolom yang ada di database Anda
    protected $fillable = [
        'nama_fasilitas', 
        'kategori', 
        'kapasitas', 
        'ikon', 
        'foto_fasilitas', 
        'status'
    ]; 
}