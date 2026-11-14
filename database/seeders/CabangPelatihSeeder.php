<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangPelatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            // 1. Rahadian Sugihbandana (Sumedang)
            ['id_pelatih' => 1, 'id_cabang' => 1],

            // 2. Nugraha Ramadhan (Sumedang dan Darmaraja)
            ['id_pelatih' => 2, 'id_cabang' => 1],
            ['id_pelatih' => 2, 'id_cabang' => 2],

            // 3. Suwandini Susilawati (Sumedang)
            ['id_pelatih' => 3, 'id_cabang' => 1],

            // 4. Deddy Iqbal (Sumedang dan Darmaraja)
            ['id_pelatih' => 4, 'id_cabang' => 1],
            ['id_pelatih' => 4, 'id_cabang' => 2],

            // 5. Rahesta Ardhya Pramesti (Sumedang dan Darmaraja)
            ['id_pelatih' => 5, 'id_cabang' => 1],
            ['id_pelatih' => 5, 'id_cabang' => 2],

            // 6. Syamsul Anwar, S.Pd (Sumedang dan Darmaraja)
            ['id_pelatih' => 6, 'id_cabang' => 1],
            ['id_pelatih' => 6, 'id_cabang' => 2],

            // 7. Resti Tisnasari, M.Pd (Sumedang)
            ['id_pelatih' => 7, 'id_cabang' => 1],

            // 8. Fajar Adhi Nugraha, S.Pd (Sumedang, Darmaraja, dan Cimanggung)
            ['id_pelatih' => 8, 'id_cabang' => 1],
            ['id_pelatih' => 8, 'id_cabang' => 2],
            ['id_pelatih' => 8, 'id_cabang' => 3],

            // 9. Ranjellia Julian Pratiwi (Sumedang)
            ['id_pelatih' => 9, 'id_cabang' => 1],

            // 10. AHMAD SYUKUR, M.Pd (Sumedang)
            ['id_pelatih' => 10, 'id_cabang' => 1],
        ];

        foreach ($rows as $row) {
            DB::table('cabang_pelatih')->updateOrInsert($row, $row);
        }
    }
}
