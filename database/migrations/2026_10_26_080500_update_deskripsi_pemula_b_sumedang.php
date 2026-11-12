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
        DB::table('kelas')->where('id', 2)->update([
            'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kelas')->where('id', 2)->update([
            'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah\nSenin & Rabu : Kolam renang Gajah Depa\nSabtu : Kolam renang Hanjuang\nDurasi : 60 Menit\n12 Pertemuan : Senin, Rabu, Sabtu\n8 Pertemuan : Rabu & Sabtu\n4 Pertemuan : Rabu & Sabtu"
        ]);
    }
};
