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
        $branchEmails = [
            1 => 'Akutiksumedanggajahdepa@gmail.com',
            2 => 'swimmingclass13@gmail.com',
            3 => 'gdascimanggung@gmail.com',
        ];

        foreach ($branchEmails as $cabangId => $email) {
            DB::table('cabang')
                ->where('id', $cabangId)
                ->update(['email' => $email]);

            DB::table('users')
                ->where('role', 'admin')
                ->where('id_cabang', $cabangId)
                ->update([
                    'email' => $email,
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak membalikkan email resmi admin cabang
    }
};
