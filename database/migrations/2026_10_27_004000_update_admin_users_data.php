<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update Admin Cabang 1: Sumedang
        DB::table('users')->where('id', 7)->update([
            'nama' => 'Gajah Depa Akuatik Sumedang',
            'no_hp' => '081312303829',
            'email' => 'akuatiksumedanggajahdepa@gmail.com',
            'jenis_kelamin' => 'perempuan',
            'password' => Hash::make('Password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'id_cabang' => 1,
        ]);

        // Update Admin Cabang 2: Darmaraja
        DB::table('users')->where('id', 9)->update([
            'nama' => 'SSC Gajah Depa Darmaraja',
            'no_hp' => '085750328172',
            'email' => 'swimmingclass13@gmail.com',
            'jenis_kelamin' => 'perempuan',
            'password' => Hash::make('Password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'id_cabang' => 2,
        ]);

        // Update Admin Cabang 3: Cimanggung
        DB::table('users')->where('id', 10)->update([
            'nama' => 'Gajah Depa Akuatik Cimanggung',
            'no_hp' => '081234567899',
            'email' => 'admin.cimanggung@gajahdepa.com',
            'jenis_kelamin' => 'laki-laki',
            'password' => Hash::make('Password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'id_cabang' => 3,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('id', 7)->update([
            'nama' => 'Admin Sumedang (Firda)',
            'email' => 'admin.sumedang@gajahdepa.com',
        ]);

        DB::table('users')->where('id', 9)->update([
            'nama' => 'Admin Darmaraja (Rerey)',
            'email' => 'admin.darmaraja@gajahdepa.com',
        ]);

        DB::table('users')->where('id', 10)->update([
            'nama' => 'Admin Cimanggung',
            'email' => 'admin.cimanggung@gajahdepa.com',
        ]);
    }
};
