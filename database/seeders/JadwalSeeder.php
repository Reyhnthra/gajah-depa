<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        DB::table('jadwal')->insert([
            // Cabang 1: Gajah Depa Akuatik Sumedang
            [
                'hari' => 'Setiap Hari',
                'jam' => '',
                'id_kelas' => 1, // Pemula A
                'id_cabang' => 1,
            ],
            [
                'hari' => 'Setiap Hari',
                'jam' => '',
                'id_kelas' => 2, // Pemula B
                'id_cabang' => 1,
            ],
            [
                'hari' => 'Setiap Hari',
                'jam' => '',
                'id_kelas' => 3, // Lanjutan
                'id_cabang' => 1,
            ],
            [
                'hari' => 'Setiap Hari',
                'jam' => '',
                'id_kelas' => 4, // Senior
                'id_cabang' => 1,
            ],

            // Cabang 2: SSC Gajah Depa Darmaraja
            [
                'hari' => 'Selasa, Kamis, dan Minggu',
                'jam' => '',
                'id_kelas' => 5, // Pemula A
                'id_cabang' => 2,
            ],
            [
                'hari' => 'Selasa, Kamis, dan Minggu',
                'jam' => '',
                'id_kelas' => 6, // Pemula B
                'id_cabang' => 2,
            ],
            [
                'hari' => 'Selasa, Kamis, dan Minggu',
                'jam' => '',
                'id_kelas' => 7, // Lanjutan
                'id_cabang' => 2,
            ],
            [
                'hari' => 'Selasa, Kamis, dan Minggu',
                'jam' => '',
                'id_kelas' => 8, // Senior
                'id_cabang' => 2,
            ],

            // Cabang 3: Gajah Depa Cimanggung
            [
                'hari' => 'Senin dan Kamis',
                'jam' => '',
                'id_kelas' => 9, // Pemula
                'id_cabang' => 3,
            ],
        ]);
    }
}
