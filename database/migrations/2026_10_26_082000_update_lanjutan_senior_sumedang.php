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
        DB::table('kelas')->where('id', 3)->update([
            'harga' => 180000,
            'deskripsi' => "Penyempurnaan 4 teknik gaya renang, efisiensi kayuhan dan napas, serta penguatan stamina untuk persiapan perlombaan"
        ]);

        DB::table('kelas')->where('id', 4)->update([
            'harga' => 180000,
            'deskripsi' => "Penajaman kecepatan 4 gaya, efisiensi teknik start dan pembalikan, serta pembentukan daya tahan atlet untuk mencetak limit waktu terbaik"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kelas')->where('id', 3)->update([
            'harga' => 100000,
        ]);

        DB::table('kelas')->where('id', 4)->update([
            'harga' => 100000,
        ]);
    }
};
