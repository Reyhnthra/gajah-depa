<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update alamat Cabang 1 (Gajah Depa Akuatik Sumedang)
        DB::table('cabang')->where('id', 1)->update([
            'alamat' => "Kolam Renang Gajah Depa\nKolam Renang Hanjuang Hegar\nKolam Tirtamas Kiansantang",
        ]);

        // 2. Update jadwal Cabang 1 menjadi "Setiap Hari"
        DB::table('jadwal')->where('id_cabang', 1)->update([
            'hari' => 'Setiap Hari',
            'jam' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('cabang')->where('id', 1)->update([
            'alamat' => "Wisata Air Gajah Depa\nKolam Renang Hanjuang Hegar\nKolam Tirtamas Kiansantang",
        ]);

        DB::table('jadwal')->where('id_cabang', 1)->where('id_kelas', 1)->update([
            'hari' => 'Senin, Rabu, dan Sabtu',
            'jam' => '15.00 WIB',
        ]);
        DB::table('jadwal')->where('id_cabang', 1)->where('id_kelas', 2)->update([
            'hari' => 'Senin, Rabu, dan Sabtu',
            'jam' => '15.00 WIB',
        ]);
        DB::table('jadwal')->where('id_cabang', 1)->where('id_kelas', 3)->update([
            'hari' => 'Selasa, Kamis, Sabtu, dan Minggu',
            'jam' => '16.00 WIB',
        ]);
        DB::table('jadwal')->where('id_cabang', 1)->where('id_kelas', 4)->update([
            'hari' => 'Selasa, Kamis, Sabtu, dan Minggu',
            'jam' => '16.00 WIB',
        ]);
    }
};
