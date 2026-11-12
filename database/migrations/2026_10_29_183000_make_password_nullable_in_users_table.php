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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            if (!Schema::hasColumn('users', 'password_set')) {
                $table->boolean('password_set')->default(true)->after('password');
            }
        });

        // Set password_set = true for all existing users with non-empty passwords
        DB::table('users')->whereNotNull('password')->where('password', '!=', '')->update(['password_set' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'password_set')) {
                $table->dropColumn('password_set');
            }
            $table->string('password')->nullable(false)->change();
        });
    }
};
