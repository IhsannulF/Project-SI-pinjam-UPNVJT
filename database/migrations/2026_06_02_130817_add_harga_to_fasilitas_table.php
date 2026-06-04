<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            // Menambahkan kolom harga (integer) setelah kolom kategori/deskripsi. 
            // Kita set default 0 agar data lama tidak error.
            $table->integer('harga_per_hari')->default(0)->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->dropColumn('harga_per_hari');
        });
    }
};