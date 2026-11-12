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
        // 1. Alihkan relasi siswa & pendaftaran_baru dari id_kelas 10, 11, 12 ke id_kelas 9 (Kelas Pemula Cimanggung)
        DB::table('siswa')->whereIn('id_kelas', [10, 11, 12])->update([
            'id_kelas' => 9,
            'tingkat_kelas' => 'Pemula',
        ]);

        DB::table('pendaftaran_baru')->whereIn('id_kelas', [10, 11, 12])->update([
            'id_kelas' => 9,
        ]);

        // 2. Hapus jadwal terkait id_kelas 10, 11, 12 untuk cabang Cimanggung (id_cabang = 3)
        DB::table('jadwal')->where('id_cabang', 3)->whereIn('id_kelas', [10, 11, 12])->delete();

        // 3. Pastikan jadwal untuk kelas 9 ada dan benar
        DB::table('jadwal')->where('id_cabang', 3)->where('id_kelas', 9)->update([
            'hari' => 'Senin dan Kamis',
            'jam' => '',
        ]);

        // 4. Hapus kelas 10, 11, 12 dari tabel kelas
        DB::table('kelas')->whereIn('id', [10, 11, 12])->delete();

        // 5. Update data kelas id 9 menjadi 'Kelas Pemula' Cimanggung
        DB::table('kelas')->where('id', 9)->update([
            'nama' => 'Kelas Pemula',
            'harga' => 150000,
            'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, serta membangun rasa percaya diri dan kemandirian anak dalam berenang.",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
