<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Bersihkan data relasi pelatih bodong
        DB::table('cabang_pelatih')->truncate();
        DB::table('absensi_pelatih')->truncate();
        DB::table('ulasan_pelatih')->truncate();
        DB::table('pelatih')->truncate();

        // Hapus data user pelatih lama
        DB::table('users')->where('role', 'pelatih')->delete();

        // Rapikan ID user admin & parents agar urut dan tidak bertabrakan dengan ID 1-6 (urutan mundur agar tidak duplikat PK)
        DB::table('users')->where('email', 'admin.cimanggung@gajahdepa.com')->update(['id' => 10]);
        DB::table('users')->where('email', 'admin.darmaraja@gajahdepa.com')->update(['id' => 9]);
        DB::table('users')->where('email', 'myradesianti@gmail.com')->update(['id' => 8]);
        DB::table('users')->where('email', 'admin.sumedang@gajahdepa.com')->update(['id' => 7]);

        // Pastikan parents mengarah ke Myra Desianti (id_user: 8)
        DB::table('parents')->update(['id_user' => 8]);

        // 2. Tambahkan 6 Data User Pelatih Asli dari Excel
        $pelatihUsers = [
            [
                'id' => 1,
                'nama' => 'Rahadian Sugihbandana',
                'no_hp' => null,
                'email' => 'Rahadian.sugihbandana22@gmail.com',
                'jenis_kelamin' => 'laki-laki',
                'password' => Hash::make('Pelatih123'),
                'role' => 'pelatih',
                'status' => 'aktif',
                'id_cabang' => 1,
            ],
            [
                'id' => 2,
                'nama' => 'Nugraha Ramadhan',
                'no_hp' => null,
                'email' => 'nugraharamadhan862@gmail.com',
                'jenis_kelamin' => 'laki-laki',
                'password' => Hash::make('Pelatih123'),
                'role' => 'pelatih',
                'status' => 'aktif',
                'id_cabang' => null,
            ],
            [
                'id' => 3,
                'nama' => 'Suwandini Susilawati',
                'no_hp' => null,
                'email' => 'suwandinisusilawati@gmail.com',
                'jenis_kelamin' => 'perempuan',
                'password' => Hash::make('Pelatih123'),
                'role' => 'pelatih',
                'status' => 'aktif',
                'id_cabang' => 1,
            ],
            [
                'id' => 4,
                'nama' => 'Deddy Iqbal',
                'no_hp' => null,
                'email' => 'deddyiqbal0212@gmail.com',
                'jenis_kelamin' => 'laki-laki',
                'password' => Hash::make('Pelatih123'),
                'role' => 'pelatih',
                'status' => 'aktif',
                'id_cabang' => null,
            ],
            [
                'id' => 5,
                'nama' => 'Rahesta Ardhya Pramesti',
                'no_hp' => null,
                'email' => 'rahestadhy@gmail.com',
                'jenis_kelamin' => 'perempuan',
                'password' => Hash::make('Pelatih123'),
                'role' => 'pelatih',
                'status' => 'aktif',
                'id_cabang' => null,
            ],
            [
                'id' => 6,
                'nama' => 'Syamsul Anwar',
                'no_hp' => null,
                'email' => 'anwarsyamsul1104@gmail.com',
                'jenis_kelamin' => 'laki-laki',
                'password' => Hash::make('Pelatih123'),
                'role' => 'pelatih',
                'status' => 'aktif',
                'id_cabang' => null,
            ],
        ];
        DB::table('users')->insert($pelatihUsers);

        // 3. Tambahkan profil pelatih ke tabel pelatih
        $pelatihProfiles = [
            [
                'id' => 1,
                'id_user' => 1,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2002-12-27',
                'no_rek' => '901969282649 - Seabank',
                'alamat' => 'Sumedang',
                'keahlian' => 'Pelatih Renang',
            ],
            [
                'id' => 2,
                'id_user' => 2,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2003-11-09',
                'no_rek' => '901107578867 (Sea Bank)',
                'alamat' => 'Sumedang',
                'keahlian' => 'Pelatih Renang',
            ],
            [
                'id' => 3,
                'id_user' => 3,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '1994-08-10',
                'no_rek' => '442801051359537 BRI suwandini susilawati',
                'alamat' => 'Sumedang',
                'keahlian' => 'Pelatih Renang',
            ],
            [
                'id' => 4,
                'id_user' => 4,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2003-12-02',
                'no_rek' => '2102838249 - BNI',
                'alamat' => 'Sumedang',
                'keahlian' => 'Pelatih Renang',
            ],
            [
                'id' => 5,
                'id_user' => 5,
                'tempat_lahir' => 'Jombang',
                'tanggal_lahir' => '2003-08-31',
                'no_rek' => '901033284570 - SEA BANK',
                'alamat' => 'Jombang',
                'keahlian' => 'Pelatih Renang',
            ],
            [
                'id' => 6,
                'id_user' => 6,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2004-04-11',
                'no_rek' => '1310024807093 - Mandiri',
                'alamat' => 'Sumedang',
                'keahlian' => 'Pelatih Renang',
            ],
        ];
        DB::table('pelatih')->insert($pelatihProfiles);

        // 4. Hubungkan pelatih ke cabang masing-masing di cabang_pelatih
        $cabangPelatih = [
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

            // 6. Syamsul Anwar (Sumedang dan Darmaraja)
            ['id_pelatih' => 6, 'id_cabang' => 1],
            ['id_pelatih' => 6, 'id_cabang' => 2],
        ];
        DB::table('cabang_pelatih')->insert($cabangPelatih);

        // 5. Tambahkan riwayat absensi pelatih
        $absensi = [
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-15', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-14', 'id_pelatih' => 1, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 2, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-15', 'id_pelatih' => 2, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 3, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_pelatih' => 3, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 4, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-17', 'id_pelatih' => 4, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-16', 'id_pelatih' => 5, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-18', 'id_pelatih' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
            ['tanggal_kehadiran' => '2026-06-15', 'id_pelatih' => 6, 'status_kehadiran' => 'hadir', 'keterangan' => '-'],
        ];
        DB::table('absensi_pelatih')->insert($absensi);

        // 6. Tambahkan data ulasan pelatih
        $ulasan = [
            [
                'id_pelatih'      => 1,
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Rahadian sangat profesional dan mengajarkan teknik renang dengan sangat baik.',
                'created_at'      => now()->subDays(1),
                'updated_at'      => now()->subDays(1),
            ],
            [
                'id_pelatih'      => 2,
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Nugraha sangat sabar dan ramah. Anak saya sangat cepat berani masuk ke kolam dalam!',
                'created_at'      => now()->subDays(2),
                'updated_at'      => now()->subDays(2),
            ],
            [
                'id_pelatih'      => 3,
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Pelatih Suwandini mantap sekali teknik renang gayanya. Anak langsung lancar gaya dada.',
                'created_at'      => now()->subDays(3),
                'updated_at'      => now()->subDays(3),
            ],
            [
                'id_pelatih'      => 4,
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Deddy sangat baik saat mengajar pemula, anak jadi tidak takut air lagi.',
                'created_at'      => now()->subDays(4),
                'updated_at'      => now()->subDays(4),
            ],
            [
                'id_pelatih'      => 5,
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Rahesta sangat telaten dan detail mengoreksi teknik gerakan renang.',
                'created_at'      => now()->subDays(5),
                'updated_at'      => now()->subDays(5),
            ],
            [
                'id_pelatih'      => 6,
                'id_parents'      => 1,
                'bintang_rating'  => 5,
                'komentar_rating' => 'Coach Syamsul sangat asyik dan memotivasi anak-anak untuk terus bersemangat latihan.',
                'created_at'      => now()->subDays(6),
                'updated_at'      => now()->subDays(6),
            ],
        ];
        DB::table('ulasan_pelatih')->insert($ulasan);

        // Sinkronisasi id_pelatih di tabel keuangan
        DB::table('keuangan')->whereNotNull('id_pelatih')->update(['id_pelatih' => 1]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
