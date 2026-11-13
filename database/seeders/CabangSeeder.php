<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cabang')->insert([
            [
                'id' => 1,
                'nama' => 'Gajah Depa Akuatik Sumedang',
                'alamat' => "Kolam Renang Gajah Depa\nKolam Renang Hanjuang Hegar\nKolam Tirtamas Kiansantang",
                'email' => 'Akutiksumedanggajahdepa@gmail.com',
                'no_whatsapp' => '081312303829',
                'info_pendaftaran' => "150.000 include jersey (reguler)\n250.000 include jersey (private)",
                'no_rekening' => 'BCA 7741276937 Suwandini Susilawati',
                'tanggal_didirikan' => '2010-05-15',
            ],
            [
                'id' => 2,
                'nama' => 'SSC Gajah Depa Darmaraja',
                'alamat' => "Kolam Renang Diffa\nKolam Renang Sutra Muda Tirta",
                'email' => 'swimmingclass13@gmail.com',
                'no_whatsapp' => '0857-5032-8172',
                'info_pendaftaran' => '100.000 include pertemuan pertama dan papan renang',
                'no_rekening' => 'SeaBank 901298468609 Firda',
                'tanggal_didirikan' => '2025-05-13',
            ],
            [
                'id' => 3,
                'nama' => 'Gajah Depa Cimanggung',
                'alamat' => 'Kolam Renang Cibogo Indah',
                'email' => 'gdascimanggung@gmail.com',
                'no_whatsapp' => '0896-1673-2799',
                'info_pendaftaran' => '150.000 include jersey',
                'no_rekening' => 'BCA 7741150917 Fajar Adhi Nugraha',
                'tanggal_didirikan' => '2026-01-10',
            ],
        ]);
    }
}
