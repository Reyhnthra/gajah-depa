<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 🟢 TAHAP 1: Tabel Master Utama (Induk Tanpa FK)
            CabangSeeder::class,
            UsersSeeder::class,
            KelasSeeder::class,

            // 🟡 TAHAP 2: Profil Pengguna & Pegawai (Mengikat ke Users / Cabang)
            PelatihSeeder::class,
            ParentsSeeder::class,

            // 🟠 TAHAP 3: Jadwal & Relasi Antar Master
            JadwalSeeder::class,
            CabangPelatihSeeder::class,
            PendaftaranBaruSeeder::class,

            // 🔵 TAHAP 4: Entitas Siswa Aktif (Butuh Parents, Kelas, Cabang)
            SiswaSeeder::class,

            // 🔴 TAHAP 5: Transaksi, Absensi, Penilaian & Ulasan (Paling Akhir)
            AbsensiPelatihSeeder::class,
            AbsensiSiswaSeeder::class, 
            PencapaianSiswaSeeder::class,
            UlasanClubSeeder::class,
            UlasanPelatihSeeder::class,
            KeuanganSeeder::class,
        ]);
    }
}