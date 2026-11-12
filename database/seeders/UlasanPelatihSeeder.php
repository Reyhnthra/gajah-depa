<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UlasanPelatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ulasan_pelatih')->insert([
            [
                'id_pelatih'      => 1, // Rahadian Sugihbandana
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Rahadian sangat profesional dan mengajarkan teknik renang dengan sangat baik.',
                'created_at'      => now()->subDays(1),
                'updated_at'      => now()->subDays(1),
            ],
            [
                'id_pelatih'      => 2, // Nugraha Ramadhan
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Nugraha sangat sabar dan ramah. Anak saya sangat cepat berani masuk ke kolam dalam!',
                'created_at'      => now()->subDays(2),
                'updated_at'      => now()->subDays(2),
            ],
            [
                'id_pelatih'      => 3, // Suwandini Susilawati
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Pelatih Suwandini mantap sekali teknik renang gayanya. Anak langsung lancar gaya dada.',
                'created_at'      => now()->subDays(3),
                'updated_at'      => now()->subDays(3),
            ],
            [
                'id_pelatih'      => 4, // Deddy Iqbal
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Deddy sangat baik saat mengajar pemula, anak jadi tidak takut air lagi.',
                'created_at'      => now()->subDays(4),
                'updated_at'      => now()->subDays(4),
            ],
            [
                'id_pelatih'      => 5, // Rahesta Ardhya Pramesti
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Rahesta sangat telaten dan detail mengoreksi teknik gerakan renang.',
                'created_at'      => now()->subDays(5),
                'updated_at'      => now()->subDays(5),
            ],
            [
                'id_pelatih'      => 6, // Syamsul Anwar
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Syamsul sangat asyik dan memotivasi anak-anak untuk terus bersemangat latihan.',
                'created_at'      => now()->subDays(6),
                'updated_at'      => now()->subDays(6),
            ],
        ]);
    }
}
