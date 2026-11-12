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
            'no_whatsapp' => '0857-5032-8172'
        ]);

        DB::table('cabang')->where('id', 3)->update([
            'no_whatsapp' => '0896-1673-2799'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('cabang')->where('id', 2)->update([
            'no_whatsapp' => '+62 857-5032-8172'
        ]);

        DB::table('cabang')->where('id', 3)->update([
            'no_whatsapp' => '+62 896-1673-2799'
        ]);
    }
};
