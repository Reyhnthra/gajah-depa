<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_baru', function (Blueprint $table) {
            // Tambah kolom baru setelah nama_siswa
            $table->string('tempat_lahir')->nullable()->after('nama_siswa');
            $table->string('foto_siswa')->nullable()->after('tanggal_lahir');
            $table->enum('pilihan_pembayaran', ['cash', 'transfer'])->default('cash')->after('id_cabang');
            $table->string('surat_perjanjian')->nullable()->after('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_baru', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'foto_siswa', 'pilihan_pembayaran', 'surat_perjanjian']);
        });
    }
};
