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
        DB::table('cabang')->where('id', 2)->update([
            'info_pendaftaran' => '100.000 include pertemuan pertama dan papan renang',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('cabang')->where('id', 2)->update([
            'info_pendaftaran' => '100.000 gratis pertemuan pertama dan include papan renang',
        ]);
    }
};
