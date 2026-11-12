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
        DB::table('jadwal')->where('id_cabang', 2)->update([
            'jam' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('jadwal')->where('id_cabang', 2)->update([
            'jam' => '15.00 WIB',
        ]);
    }
};
