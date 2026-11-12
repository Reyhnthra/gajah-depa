<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('absensi_siswa')->insert([
            // 2026-06-18
            ['tanggal_kehadiran' => '2026-06-18', 'id_siswa' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_siswa' => 4, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_siswa' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_siswa' => 3, 'status_kehadiran' => 'izin', 'keterangan' => 'Sakit flu'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_siswa' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_siswa' => 7, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],

            // 2026-06-17
            ['tanggal_kehadiran' => '2026-06-17', 'id_siswa' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_siswa' => 4, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_siswa' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_siswa' => 3, 'status_kehadiran' => 'tidak_hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_siswa' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_siswa' => 7, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],

            // 2026-06-16
            ['tanggal_kehadiran' => '2026-06-16', 'id_siswa' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_siswa' => 4, 'status_kehadiran' => 'tidak_hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_siswa' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_siswa' => 3, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_siswa' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
        ]);
    }
}
