<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('cabang', 'no_rekening')) {
            Schema::table('cabang', function (Blueprint $table) {
                $table->string('no_rekening')->nullable()->after('info_pendaftaran');
            });
        }

        DB::table('cabang')->where('id', 1)->update([
            'no_rekening' => 'BCA 7741276937 Suwandini Susilawati'
        ]);

        DB::table('cabang')->where('id', 2)->update([
            'no_rekening' => 'SeaBank 901298468609 Firda'
        ]);

        DB::table('cabang')->where('id', 3)->update([
            'no_rekening' => 'BCA 12345678 Fajar'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('cabang', 'no_rekening')) {
            Schema::table('cabang', function (Blueprint $table) {
                $table->dropColumn('no_rekening');
            });
        }
    }
};
