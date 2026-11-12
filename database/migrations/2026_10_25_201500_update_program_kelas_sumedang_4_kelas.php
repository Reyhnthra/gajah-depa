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
        // 1. Update id 1: Kelas Pemula A
        DB::table('kelas')->where('id', 1)->update([
            'nama' => 'Kelas Pemula A',
            'harga' => 100000,
            'id_cabang' => 1,
            'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak\nSenin & Rabu : Kolam renang Gajah Depa\nSabtu : Kolam renang Hanjuang\nDurasi : 60 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu",
        ]);

        // 2. Insert atau Update id 2: Kelas Pemula B
        $exists2 = DB::table('kelas')->where('id', 2)->exists();
        if ($exists2) {
            DB::table('kelas')->where('id', 2)->update([
                'nama' => 'Kelas Pemula B',
                'harga' => 100000,
                'id_cabang' => 1,
                'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah\nSenin & Rabu : Kolam renang Gajah Depa\nSabtu : Kolam renang Hanjuang\nDurasi : 60 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu",
            ]);
        } else {
            DB::table('kelas')->insert([
                'id' => 2,
                'nama' => 'Kelas Pemula B',
                'harga' => 100000,
                'id_cabang' => 1,
                'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah\nSenin & Rabu : Kolam renang Gajah Depa\nSabtu : Kolam renang Hanjuang\nDurasi : 60 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu",
            ]);
        }

        // 3. Update id 3: Kelas Lanjutan
        DB::table('kelas')->where('id', 3)->update([
            'nama' => 'Kelas Lanjutan',
            'harga' => 100000,
            'id_cabang' => 1,
            'deskripsi' => "Penyempurnaan 4 teknik gaya renang, efisiensi kayuhan dan napas, serta penguatan stamina untuk persiapan perlombaan\nSelasa, Kamis, Sabtu : Kolam renang Hanjuang\nMinggu : Kolam renang Tirtamas Kiansantang\nDurasi : 90 - 120 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu",
        ]);

        // 4. Update id 4: Kelas Senior
        DB::table('kelas')->where('id', 4)->update([
            'nama' => 'Kelas Senior',
            'harga' => 100000,
            'id_cabang' => 1,
            'deskripsi' => "Penajaman kecepatan 4 gaya, efisiensi teknik start dan pembalikan, serta pembentukan daya tahan atlet untuk mencetak limit waktu terbaik\nSelasa, Kamis, Sabtu : Kolam renang Hanjuang\nMinggu : Kolam renang Tirtamas Kiansantang\nDurasi : 90 - 120 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu",
        ]);

        // 5. Pastikan jadwal untuk kelas 2 tersedia
        DB::table('jadwal')->updateOrInsert(
            ['id_kelas' => 2, 'id_cabang' => 1],
            ['hari' => 'Senin, Rabu, dan Sabtu', 'jam' => '15.00 WIB']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
