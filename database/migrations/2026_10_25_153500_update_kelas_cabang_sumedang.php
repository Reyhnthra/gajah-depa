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
        // 1. Alihkan relasi siswa & pendaftaran_baru dari id_kelas 2 (Pemula B) ke id_kelas 1 (Pemula)
        DB::table('siswa')->where('id_kelas', 2)->update(['id_kelas' => 1]);
        DB::table('pendaftaran_baru')->where('id_kelas', 2)->update(['id_kelas' => 1]);
        
        // 2. Hapus jadwal terkait id_kelas 2
        DB::table('jadwal')->where('id_kelas', 2)->delete();

        // 3. Hapus kelas id 2
        DB::table('kelas')->where('id', 2)->delete();

        // 4. Update data kelas cabang 1 (Pemula, Lanjutan, Senior)
        DB::table('kelas')->where('id', 1)->update([
            'nama' => 'Kelas Pemula',
            'harga' => 100000,
            'deskripsi' => "Cocok untuk anak-anak atau pemula yang baru mulai belajar berenang\nDurasi: 60 Menit / sesi (Pukul 15.00 WIB)\nSenin & Rabu di Kolam Gajah Depa, Sabtu di Kolam Hanjuang\nPengenalan teknik pernapasan, gaya dada & gaya bebas\nInclude jersey renang saat pendaftaran",
        ]);

        DB::table('kelas')->where('id', 3)->update([
            'nama' => 'Kelas Lanjutan',
            'harga' => 100000,
            'deskripsi' => "Dikhususkan untuk pendalaman teknik & pembinaan fisik\nDurasi: 90 – 120 Menit / sesi\nSelasa, Kamis, & Sabtu: 16.00 WIB (Kolam Hanjuang)\nMinggu: 14.00 WIB (Kolam Tirtamas Kiansantang)\nPengembangan 4 gaya renang & teknik balikan",
        ]);

        DB::table('kelas')->where('id', 4)->update([
            'nama' => 'Kelas Senior',
            'harga' => 100000,
            'deskripsi' => "Program pembinaan atlet prestasi & persiapan kompetisi\nDurasi: 90 – 120 Menit / sesi\nSelasa, Kamis, & Sabtu: 16.00 WIB (Kolam Hanjuang)\nMinggu: 14.00 WIB (Kolam Tirtamas Kiansantang)\nLatihan ketahanan fisik, aerobik & persiapan lomba",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert data if needed
    }
};
