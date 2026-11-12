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
            if (!Schema::hasColumn('pelatih', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('id');
            }
            if (!Schema::hasColumn('pelatih', 'no_rek')) {
                $table->string('no_rek')->nullable()->after('tanggal_lahir');
            }
            $table->text('alamat')->nullable()->change();
            $table->string('keahlian')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatih', function (Blueprint $table) {
            if (Schema::hasColumn('pelatih', 'tempat_lahir')) {
                $table->dropColumn('tempat_lahir');
            }
            if (Schema::hasColumn('pelatih', 'no_rek')) {
                $table->dropColumn('no_rek');
            }
        });
    }
};
