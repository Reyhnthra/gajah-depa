<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            // Cabang 1: Gajah Depa Akuatik Sumedang (4 Kelas: Pemula A, Pemula B, Lanjutan, Senior)
            [
                'id' => 1,
                'nama' => 'Kelas Pemula A',
                'harga' => 100000,
                'id_cabang' => 1,
                'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak",
            ],
            [
                'id' => 2,
                'nama' => 'Kelas Pemula B',
                'harga' => 100000,
                'id_cabang' => 1,
                'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah",
            ],
            [
                'id' => 3,
                'nama' => 'Kelas Lanjutan',
                'harga' => 180000,
                'id_cabang' => 1,
                'deskripsi' => "Penyempurnaan 4 teknik gaya renang, efisiensi kayuhan dan napas, serta penguatan stamina untuk persiapan perlombaan",
            ],
            [
                'id' => 4,
                'nama' => 'Kelas Senior',
                'harga' => 180000,
                'id_cabang' => 1,
                'deskripsi' => "Penajaman kecepatan 4 gaya, efisiensi teknik start dan pembalikan, serta pembentukan daya tahan atlet untuk mencetak limit waktu terbaik",
            ],

            // Cabang 2: SSC Gajah Depa Darmaraja
            [
                'id' => 5,
                'nama' => 'Kelas Pemula A',
                'harga' => 25000,
                'id_cabang' => 2,
                'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak",
            ],
            [
                'id' => 6,
                'nama' => 'Kelas Pemula B',
                'harga' => 25000,
                'id_cabang' => 2,
                'deskripsi' => "Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah",
            ],
            [
                'id' => 7,
                'nama' => 'Kelas Lanjutan',
                'harga' => 25000,
                'id_cabang' => 2,
                'deskripsi' => "Penyempurnaan 4 teknik gaya renang, efisiensi kayuhan dan napas, serta penguatan stamina untuk persiapan perlombaan",
            ],
            [
                'id' => 8,
                'nama' => 'Kelas Senior',
                'harga' => 25000,
                'id_cabang' => 2,
                'deskripsi' => "Penajaman kecepatan 4 gaya, efisiensi teknik start dan pembalikan, serta pembentukan daya tahan atlet untuk mencetak limit waktu terbaik",
            ],

            // Cabang 3: Gajah Depa Cimanggung
            [
                'id' => 9,
                'nama' => 'Kelas Pemula',
                'harga' => 150000,
                'id_cabang' => 3,
                'deskripsi' => "Pengenalan air dengan metode bermain yang aman, menyenangkan, serta membangun rasa percaya diri dan kemandirian anak dalam berenang.",
            ],
        ]);
    }
}
