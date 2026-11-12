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
        DB::table('cabang')->where('id', 1)->update([
            'info_pendaftaran' => "150.000 include jersey (reguler)\n250.000 include jersey (private)"
        ]);

        DB::table('cabang')->where('id', 2)->update([
            'info_pendaftaran' => '100.000 gratis pertemuan pertama dan include papan renang'
        ]);

        DB::table('cabang')->where('id', 3)->update([
            'info_pendaftaran' => '150.000 include jersey'
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
