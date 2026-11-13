<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('pencapaian_siswa')) {
            Schema::table('pencapaian_siswa', function (Blueprint $table) {
                if (!Schema::hasColumn('pencapaian_siswa', 'id_pelatih')) {
                    $table->unsignedBigInteger('id_pelatih')->nullable()->after('id_siswa');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pencapaian_siswa')) {
            Schema::table('pencapaian_siswa', function (Blueprint $table) {
                if (Schema::hasColumn('pencapaian_siswa', 'id_pelatih')) {
                    $table->dropColumn('id_pelatih');
                }
            });
        }
    }
};

