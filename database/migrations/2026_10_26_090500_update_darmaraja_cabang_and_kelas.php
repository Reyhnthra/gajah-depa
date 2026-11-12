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
        // 1. Tambah lokasi kolam renang sutra muda tirta di Cabang 2 (Darmaraja)
        DB::table('cabang')->where('id', 2)->update([
            'alamat' => "Kolam Renang Diffa\nKolam Renang Sutra Muda Tirta",
        ]);

        // 2. Update Kelas Cabang 2 (Darmaraja)
        // Pemula A
        DB::table('kelas')->where('id', 5)->update([
            'nama' => 'Kelas Pemula A',
            'harga' => 25000,
            'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak",
        ]);

        // Pemula B
        DB::table('kelas')->where('id', 6)->update([
            'nama' => 'Kelas Pemula B',
            'harga' => 25000,
            'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah",
        ]);

        // Lanjutan
        DB::table('kelas')->where('id', 7)->update([
            'nama' => 'Kelas Lanjutan',
            'harga' => 25000,
            'deskripsi' => "Penyempurnaan 4 teknik gaya renang, efisiensi kayuhan dan napas, serta penguatan stamina untuk persiapan perlombaan",
        ]);

        // Prestasi (Senior)
        DB::table('kelas')->where('id', 8)->update([
            'nama' => 'Kelas Prestasi',
            'harga' => 25000,
            'deskripsi' => "Penajaman kecepatan 4 gaya, efisiensi teknik start dan pembalikan, serta pembentukan daya tahan atlet untuk mencetak limit waktu terbaik",
        ]);

        // 3. Update Jadwal Cabang 2
        DB::table('jadwal')->where('id_cabang', 2)->update([
            'hari' => 'Selasa, Kamis, dan Minggu',
            'jam' => '15.00 WIB',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('cabang')->where('id', 2)->update([
            'alamat' => 'Kolam Renang Diffa',
        ]);

        DB::table('kelas')->where('id', 5)->update([
            'nama' => 'Kelas Pemula A',
            'harga' => 25000,
            'deskripsi' => "Rp 25.000 / pertemuan\nKamis & Minggu jam 15.00 (Durasi 1 jam)\nDibimbing pelatih profesional\nFasilitas latihan lengkap & bermain sambil belajar\nPendaftaran Rp 100.000 include papan renang",
        ]);

        DB::table('kelas')->where('id', 6)->update([
            'nama' => 'Kelas Pemula B',
            'harga' => 25000,
            'deskripsi' => "Rp 25.000 / pertemuan\nKamis & Minggu jam 15.00 (Durasi 1 jam)\nDibimbing pelatih profesional\nFasilitas latihan lengkap & bermain sambil belajar",
        ]);

        DB::table('kelas')->where('id', 7)->update([
            'nama' => 'Kelas Lanjutan',
            'harga' => 25000,
            'deskripsi' => "Rp 25.000 / pertemuan\nSelasa, Kamis & Minggu (Durasi 90 menit)\nDibimbing pelatih profesional\nLatihan dryland & fokus perkembangan atlet",
        ]);

        DB::table('kelas')->where('id', 8)->update([
            'nama' => 'Kelas Senior',
            'harga' => 25000,
            'deskripsi' => "Lanjutan & Prestasi: Rp 25.000 / pertemuan\nSelasa, Kamis & Minggu (Durasi 90 menit)\nDibimbing pelatih profesional & latihan dryland\nFokus pada perkembangan atlet & kompetisi",
        ]);

        DB::table('jadwal')->where('id_cabang', 2)->update([
            'hari' => 'Selasa, Kamis, dan Minggu',
            'jam' => '',
        ]);
    }
};
