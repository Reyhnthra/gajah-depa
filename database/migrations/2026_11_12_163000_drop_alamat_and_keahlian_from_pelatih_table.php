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
        Schema::table('pelatih', function (Blueprint $table) {
            if (Schema::hasColumn('pelatih', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('pelatih', 'keahlian')) {
                $table->dropColumn('keahlian');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatih', function (Blueprint $table) {
            if (!Schema::hasColumn('pelatih', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_rek');
            }
            if (!Schema::hasColumn('pelatih', 'keahlian')) {
                $table->string('keahlian')->nullable()->after('alamat');
            }
        });
    }
};

