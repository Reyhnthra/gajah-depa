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
        $pelatihFotoMap = [
            'Rahadian Sugihbandana'        => 'images/raha.jpeg',
            'Rahadian Sugihbandana, S.Pd'   => 'images/raha.jpeg',
            'Nugraha Ramadhan'              => 'images/rama.jpeg',
            'Nugraha Ramadhan, S.Pd'        => 'images/rama.jpeg',
            'Suwandini Susilawati'          => 'images/dini.jpeg',
            'Suwandini Susilawati, S.Pd'    => 'images/dini.jpeg',
            'Deddy Iqbal'                   => 'images/iqbal.jpeg',
            'Deddy Iqbal, S.Pd'             => 'images/iqbal.jpeg',
            'Rahesta Ardhya Pramesti'       => 'images/rara.jpeg',
            'Rahesta Ardhya Pramesti, S.Pd' => 'images/rara.jpeg',
            'Syamsul Anwar'                 => 'images/syamsul.jpeg',
            'Syamsul Anwar, S.Pd'           => 'images/syamsul.jpeg',
            'Resti Tisnasari'               => 'images/resti.jpeg',
            'Resti Tisnasari, M.Pd'         => 'images/resti.jpeg',
            'Fajar Adhi Nugraha'            => 'images/fajar.jpeg',
            'Fajar Adhi Nugraha, S.Pd'      => 'images/fajar.jpeg',
            'Ranjellia Julian Pratiwi'      => 'images/ranjel.jpeg',
            'Ahmad Syukur'                  => 'images/ahmad.jpeg',
            'AHMAD SYUKUR, M.Pd'            => 'images/ahmad.jpeg',
        ];

        foreach ($pelatihFotoMap as $nama => $foto) {
            DB::table('users')
                ->where('role', 'pelatih')
                ->where('nama', $nama)
                ->update(['foto' => $foto]);
        }

        // Juga update berdasarkan email pelatih untuk memastikan tidak terlewat
        $emailFotoMap = [
            'Rahadian.sugihbandana22@gmail.com' => 'images/raha.jpeg',
            'nugraharamadhan862@gmail.com'      => 'images/rama.jpeg',
            'suwandinisusilawati@gmail.com'     => 'images/dini.jpeg',
            'deddyiqbal0212@gmail.com'          => 'images/iqbal.jpeg',
            'rahestadhy@gmail.com'              => 'images/rara.jpeg',
            'anwarsyamsul1104@gmail.com'        => 'images/syamsul.jpeg',
            'Restitisnasari30@gmail.com'        => 'images/resti.jpeg',
            'fajaran16@gmail.com'               => 'images/fajar.jpeg',
            'ranjelliajulianpratiwi@gmail.com'  => 'images/ranjel.jpeg',
            'ahmadsyukur04@gmail.com'           => 'images/ahmad.jpeg',
        ];

        foreach ($emailFotoMap as $email => $foto) {
            DB::table('users')
                ->whereRaw('LOWER(email) = ?', [strtolower($email)])
                ->update(['foto' => $foto]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};

