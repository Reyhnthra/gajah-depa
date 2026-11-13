<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kosongkan seluruh data transaksi keuangan, absensi, dan penilaian
     * tanpa menghapus data master (cabang, kelas, jadwal, pelatih, siswa, parents, users).
     */
    public function up(): void
    {
        $tables = [
            'keuangan',
            'absensi_siswa',
            'absensi_pelatih',
            'pencapaian_siswa',
            'ulasan_pelatih',
            'ulasan_club',
            'best_swimmer',
        ];

        Schema::disableForeignKeyConstraints();

        try {
            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data transaksi yang sudah dikosongkan tidak dapat dikembalikan otomatis.
    }
};
