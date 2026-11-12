<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiPelatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder absensi pelatih resmi
        $absensi = [
            // Pelatih 1: Rahadian Sugihbandana
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-15', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-14', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-13', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-12', 'id_pelatih' => 1, 'status_kehadiran' => 'izin', 'keterangan' => 'Keperluan keluarga'],

            // Pelatih 2: Nugraha Ramadhan
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 2, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-15', 'id_pelatih' => 2, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],

            // Pelatih 3: Suwandini Susilawati
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 3, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_pelatih' => 3, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],

            // Pelatih 4: Deddy Iqbal
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 4, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_pelatih' => 4, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],

            // Pelatih 5: Rahesta Ardhya Pramesti
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_pelatih' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],

            // Pelatih 6: Syamsul Anwar
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-15', 'id_pelatih' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
        ];

        DB::table('absensi_pelatih')->insert($absensi);
    }
}
