<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UlasanClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ulasan_club')->insert([
            [
                'id_cabang'       => 1,
                'id_parents'      => 1,
                'kategori'        => 'fasilitas',
                'bintang_rating'  => 5,
                'komentar_rating' => 'Fasilitas kolam sangat bersih dan terawat. Jadwal latihan juga sangat fleksibel.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id_cabang'       => 1,
                'id_parents'      => 1,
                'kategori'        => 'manajemen',
                'bintang_rating'  => 4,
                'komentar_rating' => 'Manajemen club cukup baik, komunikasi dengan orang tua responsif.',
                'created_at'      => now()->subDays(1),
                'updated_at'      => now()->subDays(1),
            ],
            [
                'id_cabang'       => 1,
                'id_parents'      => 1,
                'kategori'        => 'program',
                'bintang_rating'  => 5,
                'komentar_rating' => 'Program latihan terstruktur dengan baik untuk anak-anak.',
                'created_at'      => now()->subDays(2),
                'updated_at'      => now()->subDays(2),
            ],
            [
                'id_cabang'       => 1,
                'id_parents'      => 1,
                'kategori'        => 'harga',
                'bintang_rating'  => 5,
                'komentar_rating' => 'Harga iuran sebanding dengan kualitas fasilitas yang didapat.',
                'created_at'      => now()->subDays(3),
                'updated_at'      => now()->subDays(3),
            ],
            [
                'id_cabang'       => 1,
                'id_parents'      => 1,
                'kategori'        => 'fasilitas',
                'bintang_rating'  => 4,
                'komentar_rating' => 'Kamar ganti dan area tribun penonton sangat bersih.',
                'created_at'      => now()->subDays(4),
                'updated_at'      => now()->subDays(4),
            ],
            [
                'id_cabang'       => 1,
                'id_parents'      => 1,
                'kategori'        => 'umum',
                'bintang_rating'  => 3,
                'komentar_rating' => 'Secara umum cukup bagus, parkiran kolam bisa diperluas lagi.',
                'created_at'      => now()->subDays(5),
                'updated_at'      => now()->subDays(5),
            ],
            [
                'id_cabang'       => 2,
                'id_parents'      => 1,
                'kategori'        => 'fasilitas',
                'bintang_rating'  => 5,
                'komentar_rating' => 'Kolam renang Diffa Darmaraja suasananya asri dan bersih.',
                'created_at'      => now()->subDays(2),
                'updated_at'      => now()->subDays(2),
            ],
            [
                'id_cabang'       => 3,
                'id_parents'      => 1,
                'kategori'        => 'fasilitas',
                'bintang_rating'  => 5,
                'komentar_rating' => 'Fasilitas di cabang Cimanggung sangat nyaman dan pelatihnya sabar.',
                'created_at'      => now()->subDays(1),
                'updated_at'      => now()->subDays(1),
            ],
        ]);
    }
}
