<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // 1. Beri tahu nama tabelnya
    protected $table = 'users';

    // 2. Beri tahu Primary Key-nya
    protected $primaryKey = 'id_user';

    // 3. Matikan fitur auto-update waktu karena tabel Anda tidak punya kolom 'updated_at'
    public $timestamps = false;

    // 4. Kolom apa saja yang boleh diisi
    protected $fillable = [
        'identitas',
        'nama_lengkap',
        'email',
        'password',
        'role',
    ];

    // 5. Sembunyikan password demi keamanan saat data ditarik
    protected $hidden = [
        'password',
    ];
}