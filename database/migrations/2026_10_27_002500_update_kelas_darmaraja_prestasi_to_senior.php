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
        DB::table('kelas')->where('id', 8)->update([
            'nama' => 'Kelas Senior',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kelas')->where('id', 8)->update([
            'nama' => 'Kelas Prestasi',
        ]);
    }
};
