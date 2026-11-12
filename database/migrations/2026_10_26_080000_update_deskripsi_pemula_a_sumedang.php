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
        DB::table('kelas')->where('id', 1)->update([
            'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kelas')->where('id', 1)->update([
            'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak\nSenin & Rabu : Kolam renang Gajah Depa\nSabtu : Kolam renang Hanjuang\nDurasi : 60 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu"
        ]);
    }
};
