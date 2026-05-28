<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('dokumen_mou')->nullable()->after('keperluan');
            $table->string('bukti_bayar')->nullable()->after('dokumen_mou');
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['dokumen_mou', 'bukti_bayar']);
        });
    }
};