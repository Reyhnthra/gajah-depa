<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PencapaianSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pencapaian_siswa')->insert([
            [
                'id_siswa'       => 1, // Ahmad Rizki
                'gaya_renang'    => 'Gaya Bebas',
                'catatan_waktu'  => '00:45.12',
                'teknik'         => 3,
                'kecepatan'      => 3,
                'ketahanan'      => 5,
                'catatan'        => 'Progres bagus, perlu perbaiki start.',
                'kejuaraan'      => 'Juara 2 — Kejurnas Jakarta Open 2026',
                'tanggal_catat'  => '2026-06-15 10:00:00',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_siswa'       => 2, // Sari Dewi
                'gaya_renang'    => 'Gaya Kupu-kupu',
                'catatan_waktu'  => '01:05.30',
                'teknik'         => 3,
                'kecepatan'      => 3,
                'ketahanan'      => 3,
                'catatan'        => 'Masih belajar koordinasi.',
                'kejuaraan'      => null,
                'tanggal_catat'  => '2026-06-14 10:00:00',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
