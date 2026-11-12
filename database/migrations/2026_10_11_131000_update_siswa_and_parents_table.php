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
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('siswa', 'foto')) {
                $table->string('foto')->nullable()->after('tingkat_kelas');
            }
            // Ubah tingkat_kelas menjadi string agar mendukung Pemula A, Pemula B, Lanjutan, Senior
            $table->string('tingkat_kelas')->default('Pemula A')->change();
        });

        Schema::table('parents', function (Blueprint $table) {
            $table->text('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'tempat_lahir')) {
                $table->dropColumn('tempat_lahir');
            }
            if (Schema::hasColumn('siswa', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }
};
