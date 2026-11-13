<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ParentsController extends Controller
{
    /**
     * Sinkronisasi otomatis data pelatih dari Data Pelatih (Responses).xlsx ke database
     */
    public static function syncDataPelatihExcel(): void
    {
        try {
            $pelatihExcel = [
                [
                    'nama'          => 'Rahadian Sugihbandana, S.Pd',
                    'nama_lama'     => 'Rahadian Sugihbandana',
                    'email'         => 'Rahadian.sugihbandana22@gmail.com',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '2002-12-27',
                    'no_rek'        => '901969282649 - Seabank',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/raha.png',
                    'cabang_ids'    => [1],
                ],
                [
                    'nama'          => 'Nugraha Ramadhan, S.Pd',
                    'nama_lama'     => 'Nugraha Ramadhan',
                    'email'         => 'nugraharamadhan862@gmail.com',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '2003-11-09',
                    'no_rek'        => '901107578867 (Sea Bank)',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/rama.png',
                    'cabang_ids'    => [1, 2],
                ],
                [
                    'nama'          => 'Suwandini Susilawati, S.Pd',
                    'nama_lama'     => 'Suwandini Susilawati',
                    'email'         => 'suwandinisusilawati@gmail.com',
                    'jenis_kelamin' => 'perempuan',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '1994-08-10',
                    'no_rek'        => '442801051359537 BRI suwandini susilawati',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/dini.png',
                    'cabang_ids'    => [1],
                ],
                [
                    'nama'          => 'Deddy Iqbal, S.Pd',
                    'nama_lama'     => 'Deddy Iqbal',
                    'email'         => 'deddyiqbal0212@gmail.com',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '2003-12-02',
                    'no_rek'        => '2102838249 - BNI',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/iqbal.png',
                    'cabang_ids'    => [1, 2],
                ],
                [
                    'nama'          => 'Rahesta Ardhya Pramesti, S.Pd',
                    'nama_lama'     => 'Rahesta Ardhya Pramesti',
                    'email'         => 'rahestadhy@gmail.com',
                    'jenis_kelamin' => 'perempuan',
                    'tempat_lahir'  => 'Jombang',
                    'tanggal_lahir' => '2003-08-31',
                    'no_rek'        => '901033284570 - SEA BANK',
                    'alamat'        => 'Jombang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/rara.png',
                    'cabang_ids'    => [1, 2],
                ],
                [
                    'nama'          => 'Syamsul Anwar, S.Pd',
                    'nama_lama'     => 'Syamsul Anwar',
                    'email'         => 'anwarsyamsul1104@gmail.com',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '2004-04-11',
                    'no_rek'        => '1310024807093 - Mandiri',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/syamsul.png',
                    'cabang_ids'    => [1, 2],
                ],
                [
                    'nama'          => 'Resti Tisnasari, M.Pd',
                    'nama_lama'     => 'Resti Tisnasari',
                    'email'         => 'Restitisnasari30@gmail.com',
                    'jenis_kelamin' => 'perempuan',
                    'tempat_lahir'  => 'Tanggerang',
                    'tanggal_lahir' => '1994-12-30',
                    'no_rek'        => '009401094338502 - BRI',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/resti.png',
                    'cabang_ids'    => [1],
                ],
                [
                    'nama'          => 'Fajar Adhi Nugraha, S.Pd',
                    'nama_lama'     => 'Fajar Adhi Nugraha',
                    'email'         => 'fajaran16@gmail.com',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '1995-04-16',
                    'no_rek'        => '7741150917 - BCA',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/fajar.png',
                    'cabang_ids'    => [1, 2],
                ],
                [
                    'nama'          => 'Ranjellia Julian Pratiwi',
                    'nama_lama'     => 'Ranjellia Julian Pratiwi',
                    'email'         => 'ranjelliajulianpratiwi@gmail.com',
                    'jenis_kelamin' => 'perempuan',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '2005-07-17',
                    'no_rek'        => '901600961674 - Seabank',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/ranjel.png',
                    'cabang_ids'    => [1],
                ],
                [
                    'nama'          => 'AHMAD SYUKUR, M.Pd',
                    'nama_lama'     => 'Ahmad Syukur',
                    'email'         => 'ahmadsyukur04@gmail.com',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '1991-04-04',
                    'no_rek'        => '009401016637530 - BRI',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/ahmad.png',
                    'cabang_ids'    => [1],
                ],
                [
                    'nama'          => 'Ramlan Mubarok, S.Pd',
                    'nama_lama'     => 'Ramlan Mubarok',
                    'email'         => 'Ramlan743@guru.sdbelajar.id',
                    'jenis_kelamin' => 'laki-laki',
                    'tempat_lahir'  => 'Karawang',
                    'tanggal_lahir' => '1995-04-17',
                    'no_rek'        => '7741506398  - BCA',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/ramlan.png',
                    'cabang_ids'    => [1],
                ],
                [
                    'nama'          => 'Rizki Sugiharti, S.Pd',
                    'nama_lama'     => 'Rizki Sugiharti',
                    'email'         => 'sugihartirizki@gmail.com',
                    'jenis_kelamin' => 'perempuan',
                    'tempat_lahir'  => 'Sumedang',
                    'tanggal_lahir' => '1999-12-01',
                    'no_rek'        => '7741567389  - BCA',
                    'alamat'        => 'Sumedang',
                    'keahlian'      => 'Pelatih Renang',
                    'foto'          => 'images/rizki.png',
                    'cabang_ids'    => [1],
                ],
            ];

            foreach ($pelatihExcel as $row) {
                try {
                    $existingUser = DB::table('users')
                        ->whereRaw('LOWER(email) = ?', [strtolower($row['email'])])
                        ->orWhere('nama', $row['nama'])
                        ->orWhere('nama', $row['nama_lama'])
                        ->first();

                    if (!$existingUser) {
                        $userId = DB::table('users')->insertGetId([
                            'nama'          => $row['nama'],
                            'no_hp'         => null,
                            'email'         => $row['email'],
                            'jenis_kelamin' => $row['jenis_kelamin'],
                            'password'      => Hash::make('Pelatih123'),
                            'role'          => 'pelatih',
                            'foto'          => $row['foto'] ?? null,
                            'status'        => 'aktif',
                            'id_cabang'     => 1,
                        ]);
                    } else {
                        $userId = $existingUser->id;
                        $updates = [];
                        if ($existingUser->nama !== $row['nama']) {
                            $updates['nama'] = $row['nama'];
                        }
                        if (empty($existingUser->id_cabang)) {
                            $updates['id_cabang'] = 1;
                        }
                        if (!empty($row['foto']) && $existingUser->foto !== $row['foto']) {
                            $updates['foto'] = $row['foto'];
                        }
                        if (!empty($updates)) {
                            DB::table('users')->where('id', $userId)->update($updates);
                        }
                    }

                    $existingPelatih = DB::table('pelatih')->where('id_user', $userId)->first();
                    if (!$existingPelatih) {
                        $pelatihId = DB::table('pelatih')->insertGetId([
                            'id_user'       => $userId,
                            'tempat_lahir'  => $row['tempat_lahir'],
                            'tanggal_lahir' => $row['tanggal_lahir'],
                            'no_rek'        => $row['no_rek'],
                        ]);
                    } else {
                        $pelatihId = $existingPelatih->id;
                        DB::table('pelatih')->where('id', $pelatihId)->update([
                            'tempat_lahir'  => $existingPelatih->tempat_lahir ?: $row['tempat_lahir'],
                            'tanggal_lahir' => $existingPelatih->tanggal_lahir ?: $row['tanggal_lahir'],
                            'no_rek'        => $existingPelatih->no_rek ?: $row['no_rek'],
                        ]);
                    }

                    foreach ($row['cabang_ids'] as $cabangId) {
                        $existsCabang = DB::table('cabang_pelatih')
                            ->where('id_pelatih', $pelatihId)
                            ->where('id_cabang', $cabangId)
                            ->exists();
                        if (!$existsCabang) {
                            DB::table('cabang_pelatih')->insert([
                                'id_pelatih' => $pelatihId,
                                'id_cabang'  => $cabangId,
                            ]);
                        }
                    }
                } catch (\Throwable $innerEx) {
                    // Continue syncing next coach
                }
            }
        } catch (\Throwable $e) {
            // Ignore DB sync issues if tables are unavailable
        }
    }

    /**
     * Helper to get current parent details and active child data
     */
    private function getParentAndChildData()
    {
        self::syncDataPelatihExcel();

        $user = Auth::user();

        // Get Parent record linked to logged in user
        $parent = DB::table('parents')->where('id_user', $user->id ?? 0)->first();

        if (!$parent) {
            $parentId = 1;
            $parentName = $user->nama ?? 'Hendra Rizki';
            $parentEmail = $user->email ?? 'hendra@email.com';
            $parentPhone = $user->no_hp ?? '0812-1111-2222';
            $parentAddress = 'Jl. Kemang Raya No. 5, Jakarta Selatan';
        } else {
            $parentId = $parent->id;
            $parentName = $user->nama;
            $parentEmail = $user->email;
            $parentPhone = $user->no_hp ?? '0812-1111-2222';
            $parentAddress = $parent->alamat ?? 'Jl. Kemang Raya No. 5, Jakarta Selatan';
        }

        // Kumpulkan semua id_parents yang terhubung dengan akun orang tua ini (berdasarkan id_user, email, atau nama yang sama)
        $parentIds = DB::table('parents')
            ->leftJoin('users', 'parents.id_user', '=', 'users.id')
            ->where(function ($q) use ($user, $parentId) {
                $q->where('parents.id', $parentId);
                if (!empty($user->id)) {
                    $q->orWhere('parents.id_user', $user->id);
                }
                if (!empty($user->email)) {
                    $q->orWhereRaw('LOWER(users.email) = ?', [strtolower(trim($user->email))]);
                }
                if (!empty($user->nama)) {
                    $q->orWhereRaw('LOWER(TRIM(users.nama)) = ?', [strtolower(trim($user->nama))]);
                }
            })
            ->pluck('parents.id')
            ->unique()
            ->values()
            ->all();

        if (empty($parentIds)) {
            $parentIds = [$parentId];
        }

        // Ambil seluruh data anak (Siswa) milik orang tua ini
        $siswaList = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->whereIn('siswa.id_parents', $parentIds)
            ->select(
                'siswa.*',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang',
                'cabang.id as id_cabang',
                'cabang.no_whatsapp as wa_cabang'
            )
            ->orderBy('siswa.id', 'asc')
            ->get()
            ->map(function ($item) {
                $item->kode_siswa  = 'GD' . str_pad($item->id, 3, '0', STR_PAD_LEFT);
                $item->nama_kelas  = $item->nama_kelas ?? $item->tingkat_kelas ?? 'Pemula A';
                $item->nama_cabang = $item->nama_cabang ?? 'Gajah Depa Akuatik Sumedang';
                return $item;
            });

        // Tentukan anak yang sedang aktif dipilih dari session (fallback ke anak pertama)
        $selectedSiswaId = session('parents_id_siswa');
        $siswa = null;
        if ($selectedSiswaId && $siswaList->isNotEmpty()) {
            $siswa = $siswaList->firstWhere('id', (int) $selectedSiswaId);
        }
        if (!$siswa && $siswaList->isNotEmpty()) {
            $siswa = $siswaList->first();
            session(['parents_id_siswa' => $siswa->id]);
        }

        // Get Coach info based on child's branch (or all coaches)
        $idCabangSiswa = $siswa->id_cabang ?? 1;
        $pelatihCabangList = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id')
            ->leftJoin('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
            ->where('cabang_pelatih.id_cabang', $idCabangSiswa)
            ->select('pelatih.id', 'users.nama as nama_pelatih')
            ->distinct()
            ->get();

        if ($pelatihCabangList->isEmpty()) {
            $pelatihCabangList = DB::table('pelatih')
                ->join('users', 'pelatih.id_user', '=', 'users.id')
                ->select('pelatih.id', 'users.nama as nama_pelatih')
                ->get();
        }

        if ($pelatihCabangList->isEmpty()) {
            $pelatihCabangList = collect([
                (object)['id' => 1, 'nama_pelatih' => 'Rahadian Sugihbandana, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 2, 'nama_pelatih' => 'Nugraha Ramadhan, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 3, 'nama_pelatih' => 'Suwandini Susilawati, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 4, 'nama_pelatih' => 'Deddy Iqbal, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 5, 'nama_pelatih' => 'Rahesta Ardhya Pramesti, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 6, 'nama_pelatih' => 'Syamsul Anwar, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 7, 'nama_pelatih' => 'Resti Tisnasari, M.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 8, 'nama_pelatih' => 'Fajar Adhi Nugraha, S.Pd', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 9, 'nama_pelatih' => 'Ranjellia Julian Pratiwi', 'keahlian' => 'Pelatih Renang'],
                (object)['id' => 10, 'nama_pelatih' => 'AHMAD SYUKUR, M.Pd', 'keahlian' => 'Pelatih Renang'],
            ]);
        }

        $pelatih = $pelatihCabangList->first();
        $namaPelatih = $pelatih->nama_pelatih ?? 'Rahadian Sugihbandana, S.Pd';
        $idPelatih   = $pelatih->id ?? 1;
        $daftarPelatih = $pelatihCabangList->pluck('nama_pelatih')->implode(', ');

        if (!$siswa) {
            // Default fallback matching the screenshot
            $siswa = (object)[
                'id'               => 1,
                'kode_siswa'       => 'GD001',
                'nama'             => 'Ahmad Rizki',
                'status'           => 'Aktif',
                'tanggal_lahir'    => '2012-03-14',
                'tgl_lahir_format' => '14 Maret 2012',
                'nama_kelas'       => 'Pemula A',
                'nama_cabang'      => 'Gajah Depa Akuatik Sumedang',
                'id_cabang'        => 1,
                'tingkat_kelas'    => 'pemula',
                'sekolah'          => 'SDN 01 Sumedang',
                'riwayat_penyakit' => '-',
                'catatan_khusus'   => '-',
                'nama_pelatih'     => $namaPelatih,
                'daftar_pelatih'   => $daftarPelatih,
            ];
        } else {
            $siswa->kode_siswa       = 'GD' . str_pad($siswa->id, 3, '0', STR_PAD_LEFT);
            $siswa->status           = 'Aktif';
            $siswa->tgl_lahir_format = isset($siswa->tanggal_lahir) ? Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '14 Maret 2012';
            $siswa->nama_kelas       = $siswa->nama_kelas ?? 'Pemula A';
            $siswa->nama_cabang      = $siswa->nama_cabang ?? 'Gajah Depa Akuatik Sumedang';
            $siswa->sekolah          = $siswa->sekolah ?? 'SDN 01 Sumedang';
            $siswa->riwayat_penyakit = $siswa->riwayat_penyakit ?? '-';
            $siswa->catatan_khusus   = $siswa->catatan_khusus ?? '-';
            $siswa->nama_pelatih     = $namaPelatih;
            $siswa->daftar_pelatih   = $daftarPelatih;
        }

        // Attach Parent Details into Siswa Object for easy modal access
        $siswa->nama_parent   = $parentName;
        $siswa->email_parent  = $parentEmail;
        $siswa->phone_parent  = $parentPhone;
        $siswa->alamat_parent = $parentAddress;

        // Nomor WhatsApp Admin sesuai Cabang Siswa
        $adminWaFallback = [
            1 => '081312303829',
            2 => '085750328172',
            3 => '089616732799',
        ];
        $idCabangAktif = (int) ($siswa->id_cabang ?? 1);
        $rawWaAdmin = ($siswa->wa_cabang ?? null)
            ?: DB::table('cabang')->where('id', $idCabangAktif)->value('no_whatsapp')
            ?: DB::table('users')->where('role', 'admin')->where('id_cabang', $idCabangAktif)->value('no_hp')
            ?: ($adminWaFallback[$idCabangAktif] ?? '081312303829');

        $cleanWa = preg_replace('/[^0-9]/', '', (string) $rawWaAdmin);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
        } elseif (!str_starts_with($cleanWa, '62')) {
            $cleanWa = '62' . $cleanWa;
        }

        $waMessage = rawurlencode('Halo Admin ' . ($siswa->nama_cabang ?? 'Gajah Depa') . ', saya orang tua dari ' . ($siswa->nama ?? 'Siswa') . ' (' . ($siswa->kode_siswa ?? 'GD001') . ').');
        $siswa->wa_admin_phone = $rawWaAdmin;
        $siswa->wa_admin_url   = "https://wa.me/{$cleanWa}?text={$waMessage}";

        if ($siswaList->isEmpty()) {
            $siswaList = collect([$siswa]);
        }

        return compact(
            'user',
            'parent',
            'parentId',
            'parentName',
            'parentEmail',
            'parentPhone',
            'parentAddress',
            'siswa',
            'siswaList',
            'namaPelatih',
            'idPelatih'
        );
    }

    /**
     * Ganti data anak aktif (jika orang tua memiliki lebih dari 1 anak)
     */
    public function switchAnak(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|integer',
        ]);

        $data = $this->getParentAndChildData();
        $siswaList = $data['siswaList'] ?? collect();

        $target = $siswaList->firstWhere('id', (int) $request->id_siswa);
        if ($target) {
            session(['parents_id_siswa' => (int) $target->id]);
        }

        return redirect()->back();
    }

    /**
     * Dashboard Orang Tua
     */
    public function dashboard(Request $request)
    {
        $data = $this->getParentAndChildData();
        extract($data);

        $bulan = sprintf('%02d', $request->input('bulan', date('m')));
        $tahun = $request->input('tahun', date('Y'));

        $namaBulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $namaBulan = $namaBulanList[$bulan] ?? 'Oktober';

        // Attendance stats for child
        $absensiQuery = DB::table('absensi_siswa')
            ->where('id_siswa', $siswa->id)
            ->whereYear('tanggal_kehadiran', $tahun)
            ->whereMonth('tanggal_kehadiran', $bulan);

        $totalHadir = (clone $absensiQuery)->where('status_kehadiran', 'hadir')->count();
        $totalIzin  = (clone $absensiQuery)->where('status_kehadiran', 'izin')->count();
        $totalSakit = (clone $absensiQuery)->where('status_kehadiran', 'sakit')->count();
        $totalSesi  = (clone $absensiQuery)->count();

        // Nilai Terakhir
        $nilaiTerakhir = DB::table('pencapaian_siswa')
            ->where('id_siswa', $siswa->id)
            ->orderBy('tanggal_catat', 'desc')
            ->first();

        if ($nilaiTerakhir) {
            $avgScore = round(($nilaiTerakhir->teknik + $nilaiTerakhir->kecepatan + $nilaiTerakhir->ketahanan) / 3, 1);
            $lastGrade = [
                'score' => $avgScore,
                'gaya'  => $nilaiTerakhir->gaya_renang,
                'date'  => Carbon::parse($nilaiTerakhir->tanggal_catat)->translatedFormat('d M'),
            ];
        } else {
            $lastGrade = [
                'score' => 0,
                'gaya'  => '-',
                'date'  => '-',
            ];
        }

        // Progres Penilaian Bulan Ini Records (untuk progres nilai selama sebulan & progres penilaian)
        $penilaianBulanIniRecords = DB::table('pencapaian_siswa')
            ->where('id_siswa', $siswa->id)
            ->where(function ($q) use ($tahun, $bulan) {
                $q->where(function ($q2) use ($tahun, $bulan) {
                    $q2->whereYear('tanggal_catat', $tahun)
                       ->whereMonth('tanggal_catat', $bulan);
                })->orWhere(function ($q2) use ($tahun, $bulan) {
                    $q2->whereNull('tanggal_catat')
                       ->whereYear('created_at', $tahun)
                       ->whereMonth('created_at', $bulan);
                });
            })
            ->orderBy('tanggal_catat', 'asc')
            ->get();

        $totalPenilaianBulanIni = $penilaianBulanIniRecords->count();

        // Rata-rata nilai 3 indikator selama sebulan & konversi ke persentase progres (skala maks 5 = 100%)
        if ($totalPenilaianBulanIni > 0) {
            $avgScoreBulanIni = round($penilaianBulanIniRecords->avg(function ($item) {
                return ($item->teknik + $item->kecepatan + $item->ketahanan) / 3;
            }), 1);
            $progresNilaiPersen = min(100, round(($avgScoreBulanIni / 5) * 100));
        } else {
            $avgScoreBulanIni = 0;
            $progresNilaiPersen = 0;
        }

        // Hitung persentase progres penilaian per bulan
        if ($totalHadir > 0) {
            $progresPenilaianPersen = min(100, round(($totalPenilaianBulanIni / $totalHadir) * 100));
        } elseif ($totalSesi > 0) {
            $progresPenilaianPersen = min(100, round(($totalPenilaianBulanIni / $totalSesi) * 100));
        } else {
            $progresPenilaianPersen = $totalPenilaianBulanIni > 0 ? 100 : 0;
        }

        // Total Penilaian
        $totalPenilaianCount = DB::table('pencapaian_siswa')
            ->where('id_siswa', $siswa->id)
            ->count();

        // Data Penilaian untuk Grafik
        $penilaianRecords = DB::table('pencapaian_siswa')
            ->where('id_siswa', $siswa->id)
            ->orderBy('tanggal_catat', 'asc')
            ->get();

        $chartPenilaianData = $penilaianRecords->values()->map(function ($item, $index) {
            $tgl = $item->tanggal_catat ?? $item->created_at;
            return [
                'sesi'      => 'Sesi ' . ($index + 1),
                'tanggal'   => Carbon::parse($tgl)->translatedFormat('d M Y'),
                'tgl_short' => Carbon::parse($tgl)->translatedFormat('d M'),
                'gaya'      => $item->gaya_renang,
                'teknik'    => (int) $item->teknik,
                'kecepatan' => (int) $item->kecepatan,
                'ketahanan' => (int) $item->ketahanan,
                'rata_rata' => round(($item->teknik + $item->kecepatan + $item->ketahanan) / 3, 1),
            ];
        })->values();

        // Data Absensi untuk Grafik
        $absensiRecords = DB::table('absensi_siswa')
            ->where('id_siswa', $siswa->id)
            ->orderBy('tanggal_kehadiran', 'asc')
            ->get();

        $chartAbsensiData = $absensiRecords->map(function ($item) {
            return [
                'tanggal'    => $item->tanggal_kehadiran,
                'tgl_format' => Carbon::parse($item->tanggal_kehadiran)->translatedFormat('d M Y'),
                'tgl_short'  => Carbon::parse($item->tanggal_kehadiran)->translatedFormat('d M'),
                'status'     => strtolower($item->status_kehadiran ?? 'hadir'),
                'keterangan' => $item->keterangan ?? '-',
            ];
        })->values();

        // Tentukan Best Member of the Month khusus per cabang anak pada bulan & tahun terpilih
        $idCabangSiswa = $siswa->id_cabang ?? Auth::user()->id_cabang ?? 1;
        $cabangObj = DB::table('cabang')->where('id', $idCabangSiswa)->first();
        $namaCabangAktif = $siswa->nama_cabang ?? ($cabangObj ? $cabangObj->nama : 'Gajah Depa');

        $kandidatSiswa = DB::table('siswa')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->where('siswa.id_cabang', $idCabangSiswa)
            ->select(
                'siswa.id',
                'siswa.nama',
                'siswa.foto',
                'siswa.tingkat_kelas',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang'
            )
            ->get();

        $bestMember = null;
        if ($kandidatSiswa->isNotEmpty()) {
            $kandidatIds = $kandidatSiswa->pluck('id')->all();

            // Helper untuk menghitung skor bulanan murni dari Total Kehadiran & Persentase Progres (%)
            $hitungStatBulanan = function ($idSiswa, $thn, $bln) {
                $hadir = DB::table('absensi_siswa')
                    ->where('id_siswa', $idSiswa)
                    ->whereYear('tanggal_kehadiran', $thn)
                    ->whereMonth('tanggal_kehadiran', $bln)
                    ->where('status_kehadiran', 'hadir')
                    ->count();

                $nilaiBulan = DB::table('pencapaian_siswa')
                    ->where('id_siswa', $idSiswa)
                    ->where(function ($q) use ($thn, $bln) {
                        $q->where(function ($q2) use ($thn, $bln) {
                            $q2->whereYear('tanggal_catat', $thn)
                               ->whereMonth('tanggal_catat', $bln);
                        })->orWhere(function ($q2) use ($thn, $bln) {
                            $q2->whereNull('tanggal_catat')
                               ->whereYear('created_at', $thn)
                               ->whereMonth('created_at', $bln);
                        });
                    })
                    ->get();

                if ($nilaiBulan->isNotEmpty()) {
                    $avgBulan = round($nilaiBulan->avg(fn($r) => ($r->teknik + $r->kecepatan + $r->ketahanan) / 3), 1);
                    $progresPct = (int) min(100, round(($avgBulan / 5) * 100));
                } else {
                    $avgBulan = 0;
                    $progresPct = 0;
                }

                // Skor murni dari Total Kehadiran dan Persentase Progres bulan tersebut
                $skorUtama = ($hadir * 100) + $progresPct;

                return [
                    'total_hadir' => $hadir,
                    'avg_score'   => $avgBulan,
                    'progres_pct' => $progresPct,
                    'skor_utama'  => $skorUtama,
                ];
            };

            // Lacak riwayat Best Member pada bulan-bulan sebelumnya di cabang ini
            $targetPeriode = sprintf('%04d-%02d', (int) $tahun, (int) $bulan);

            $periodeAbsensi = DB::table('absensi_siswa')
                ->whereIn('id_siswa', $kandidatIds)
                ->selectRaw("DATE_FORMAT(tanggal_kehadiran, '%Y-%m') as ym")
                ->distinct()
                ->pluck('ym')
                ->filter(fn($ym) => !empty($ym) && $ym < $targetPeriode);

            $periodePenilaian = DB::table('pencapaian_siswa')
                ->whereIn('id_siswa', $kandidatIds)
                ->selectRaw("DATE_FORMAT(COALESCE(tanggal_catat, created_at), '%Y-%m') as ym")
                ->distinct()
                ->pluck('ym')
                ->filter(fn($ym) => !empty($ym) && $ym < $targetPeriode);

            $periodeSebelumnya = $periodeAbsensi
                ->merge($periodePenilaian)
                ->unique()
                ->sort()
                ->values();

            $riwayatBestMemberCount = [];
            foreach ($periodeSebelumnya as $ym) {
                [$thnHist, $blnHist] = explode('-', $ym);
                $kandidatBulanHist = $kandidatSiswa->map(function ($k) use ($hitungStatBulanan, $thnHist, $blnHist, $riwayatBestMemberCount) {
                    $stat = $hitungStatBulanan($k->id, $thnHist, $blnHist);
                    return (object)[
                        'id'         => $k->id,
                        'skor_utama' => $stat['skor_utama'],
                        'pernah_bm'  => $riwayatBestMemberCount[$k->id] ?? 0,
                    ];
                })->filter(fn($item) => $item->skor_utama > 0);

                if ($kandidatBulanHist->isNotEmpty()) {
                    $pemenangHist = $kandidatBulanHist->sort(function ($a, $b) {
                        if ($a->skor_utama !== $b->skor_utama) {
                            return $b->skor_utama <=> $a->skor_utama;
                        }
                        // Jika skor sama, pilih yang belum pernah jadi Best Member
                        $aBelumPernah = $a->pernah_bm === 0 ? 1 : 0;
                        $bBelumPernah = $b->pernah_bm === 0 ? 1 : 0;
                        if ($aBelumPernah !== $bBelumPernah) {
                            return $bBelumPernah <=> $aBelumPernah;
                        }
                        if ($a->pernah_bm !== $b->pernah_bm) {
                            return $a->pernah_bm <=> $b->pernah_bm;
                        }
                        return $a->id <=> $b->id;
                    })->first();

                    if ($pemenangHist) {
                        $riwayatBestMemberCount[$pemenangHist->id] = ($riwayatBestMemberCount[$pemenangHist->id] ?? 0) + 1;
                    }
                }
            }

            // Hitung Best Member untuk bulan & tahun yang dipilih
            $rankedKandidat = $kandidatSiswa->map(function ($k) use ($hitungStatBulanan, $tahun, $bulan, $riwayatBestMemberCount) {
                $stat = $hitungStatBulanan($k->id, $tahun, $bulan);
                $k->total_hadir = $stat['total_hadir'];
                $k->avg_score   = $stat['avg_score'];
                $k->progres_pct = $stat['progres_pct'];
                $k->skor_utama  = $stat['skor_utama'];
                $k->pernah_bm   = $riwayatBestMemberCount[$k->id] ?? 0;
                $k->nama_cabang = $k->nama_cabang ?? $namaCabangAktif;
                $k->nama_kelas  = $k->nama_kelas ?? $k->tingkat_kelas ?? 'Pemula A';
                return $k;
            })->sort(function ($a, $b) {
                // 1. Bandingkan murni dari skor kehadiran & progres bulan ini
                if ($a->skor_utama !== $b->skor_utama) {
                    return $b->skor_utama <=> $a->skor_utama;
                }
                // 2. Jika skor sama, prioritaskan yang BELUM PERNAH jadi Best Member
                $aBelumPernah = $a->pernah_bm === 0 ? 1 : 0;
                $bBelumPernah = $b->pernah_bm === 0 ? 1 : 0;
                if ($aBelumPernah !== $bBelumPernah) {
                    return $bBelumPernah <=> $aBelumPernah;
                }
                // 3. Jika keduanya sudah pernah, pilih yang jumlah pernahnya lebih sedikit
                if ($a->pernah_bm !== $b->pernah_bm) {
                    return $a->pernah_bm <=> $b->pernah_bm;
                }
                return $a->id <=> $b->id;
            })->values();

            // Hanya tetapkan Best Member jika SUDAH resmi dipilih oleh Admin di tabel best_swimmer
            $bestMember = null;
            if (\Illuminate\Support\Facades\Schema::hasTable('best_swimmer')) {
                $manualId = DB::table('best_swimmer')
                    ->where('id_cabang', $siswa->id_cabang ?? 1)
                    ->where('tahun', (int) $tahun)
                    ->where('bulan', (int) $bulan)
                    ->value('id_siswa');

                if ($manualId) {
                    $bestMember = $rankedKandidat->firstWhere('id', $manualId);
                    if (!$bestMember) {
                        $bestMember = DB::table('siswa')
                            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
                            ->where('siswa.id', $manualId)
                            ->select('siswa.*', 'kelas.nama as nama_kelas', 'cabang.nama as nama_cabang')
                            ->first();
                    }
                }
            }
        } else {
            $bestMember = null;
        }

        $isBestMember = ($bestMember && isset($siswa->id) && (int)$bestMember->id === (int)$siswa->id);

        $dbYearsAbsensi = DB::table('absensi_siswa')
            ->where('id_siswa', $siswa->id)
            ->whereNotNull('tanggal_kehadiran')
            ->selectRaw('DISTINCT YEAR(tanggal_kehadiran) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $listTahun = array_values(array_unique($dbYearsAbsensi));
        if (empty($listTahun)) {
            $listTahun = [(string)date('Y')];
        }
        rsort($listTahun);

        return view('dashboard.parents', compact(
            'user',
            'parent',
            'siswa',
            'siswaList',
            'namaPelatih',
            'bulan',
            'tahun',
            'namaBulan',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalSesi',
            'lastGrade',
            'avgScoreBulanIni',
            'progresNilaiPersen',
            'totalPenilaianCount',
            'totalPenilaianBulanIni',
            'progresPenilaianPersen',
            'bestMember',
            'isBestMember',
            'chartPenilaianData',
            'chartAbsensiData',
            'listTahun'
        ));
    }

    /**
     * Halaman Penilaian Anak
     */
    public function penilaianAnak(Request $request)
    {
        $data = $this->getParentAndChildData();
        extract($data);

        $bulan = sprintf('%02d', $request->input('bulan', date('m')));
        $tahun = $request->input('tahun', date('Y'));

        $namaBulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $namaBulan = $namaBulanList[$bulan] ?? 'Oktober';

        // Hitung persentase progres penilaian per bulan yang dipilih
        $penilaianBulanIniRecords = DB::table('pencapaian_siswa')
            ->where('id_siswa', $siswa->id)
            ->where(function ($q) use ($tahun, $bulan) {
                $q->where(function ($q2) use ($tahun, $bulan) {
                    $q2->whereYear('tanggal_catat', $tahun)
                       ->whereMonth('tanggal_catat', $bulan);
                })->orWhere(function ($q2) use ($tahun, $bulan) {
                    $q2->whereNull('tanggal_catat')
                       ->whereYear('created_at', $tahun)
                       ->whereMonth('created_at', $bulan);
                });
            })
            ->orderBy('tanggal_catat', 'asc')
            ->get();

        $totalPenilaianBulanIni = $penilaianBulanIniRecords->count();
        if ($totalPenilaianBulanIni > 0) {
            $avgScoreBulanIni = round($penilaianBulanIniRecords->avg(function ($item) {
                return ($item->teknik + $item->kecepatan + $item->ketahanan) / 3;
            }), 1);
            $progresNilaiPersen = min(100, round(($avgScoreBulanIni / 5) * 100));
        } else {
            $avgScoreBulanIni = 0;
            $progresNilaiPersen = 0;
        }

        // Fetch all ratings/achievements recorded for this child
        $penilaianListRaw = DB::table('pencapaian_siswa')
            ->leftJoin('pelatih', 'pencapaian_siswa.id_pelatih', '=', 'pelatih.id')
            ->leftJoin('users as user_pelatih', 'pelatih.id_user', '=', 'user_pelatih.id')
            ->select('pencapaian_siswa.*', 'user_pelatih.nama as nama_pelatih')
            ->where('pencapaian_siswa.id_siswa', $siswa->id)
            ->orderBy('pencapaian_siswa.tanggal_catat', 'desc')
            ->get();

        $penilaianList = [];
        if ($penilaianListRaw->count() > 0) {
            $sesiNum = $penilaianListRaw->count();
            foreach ($penilaianListRaw as $item) {
                $avg = round(($item->teknik + $item->kecepatan + $item->ketahanan) / 3, 1);
                $penilaianList[] = (object)[
                    'sesi'          => 'Sesi ' . $sesiNum--,
                    'tanggal'       => Carbon::parse($item->tanggal_catat ?? $item->created_at)->translatedFormat('l, d F Y'),
                    'pelatih'       => $item->nama_pelatih ?? $namaPelatih,
                    'gaya_renang'   => $item->gaya_renang ?? 'Gaya Bebas',
                    'catatan_waktu' => $item->catatan_waktu,
                    'rata_rata'     => number_format($avg, 1),
                    'teknik'        => $item->teknik,
                    'kecepatan'     => $item->kecepatan,
                    'ketahanan'     => $item->ketahanan,
                    'catatan'       => $item->catatan ?? 'Progres baik dan disiplin dalam berlatih.',
                    'kejuaraan'     => $item->kejuaraan,
                ];
            }
        }

        // Helper konversi waktu "mm:ss.ms" ke milidetik/centidetik untuk mencari Best Time tercepat
        $parseWaktuToMs = function ($waktuStr) {
            if (empty($waktuStr)) return null;
            $w = trim($waktuStr);
            if ($w === '-' || $w === '00:00.00' || $w === '00:00:00' || $w === '0:0.0') {
                return null;
            }
            if (preg_match('/^(\d+):(\d+)(?:\.(\d+))?$/', $w, $m)) {
                $mm = (int) $m[1];
                $ss = (int) $m[2];
                $ms = isset($m[3]) ? (int) str_pad(substr($m[3], 0, 2), 2, '0', STR_PAD_RIGHT) : 0;
                $totalCs = ($mm * 6000) + ($ss * 100) + $ms;
                return $totalCs > 0 ? $totalCs : null;
            }
            if (is_numeric($w) && (float) $w > 0) {
                return (int) round(((float) $w) * 100);
            }
            return null;
        };

        // Daftar 4 Gaya Renang Utama (selalu ditampilkan meskipun belum ada penilaian)
        $daftarEmpatGaya = [
            'Gaya Bebas'     => 'bebas',
            'Gaya Dada'      => 'dada',
            'Gaya Punggung'  => 'punggung',
            'Gaya Kupu-kupu' => 'kupu',
        ];

        $progresGayaList = collect($daftarEmpatGaya)->map(function ($keyword, $namaGaya) use ($penilaianList, $parseWaktuToMs) {
            $items = collect($penilaianList)->filter(function ($item) use ($keyword) {
                $kat = strtolower(trim($item->gaya_renang ?? ''));
                return str_contains($kat, $keyword);
            })->values();

            $count = $items->count();
            if ($count > 0) {
                $avgTotal = round($items->avg(function ($i) {
                    return ($i->teknik + $i->kecepatan + $i->ketahanan) / 3;
                }), 1);
                $progresPct = (int) min(100, round(($avgTotal / 5) * 100));
            } else {
                $avgTotal   = 0;
                $progresPct = 0;
            }

            $bestTimeStr = null;
            $bestTimeVal = null;
            foreach ($items as $it) {
                $val = $parseWaktuToMs($it->catatan_waktu ?? null);
                if ($val !== null && ($bestTimeVal === null || $val < $bestTimeVal)) {
                    $bestTimeVal = $val;
                    $bestTimeStr = trim($it->catatan_waktu);
                }
            }

            return (object)[
                'gaya'           => $namaGaya,
                'total_sesi'     => $count,
                'rata_rata'      => number_format($avgTotal, 1),
                'progres_persen' => $progresPct,
                'best_time'      => $bestTimeStr,
            ];
        })->values();

        $totalPenilaian = count($penilaianList);
        $totalSum = array_reduce($penilaianList, function($carry, $item) {
            return $carry + floatval($item->rata_rata);
        }, 0);
        $rataRataNilai = $totalPenilaian > 0 ? number_format($totalSum / $totalPenilaian, 1) : '0';

        $dbYearsPencapaian = DB::table('pencapaian_siswa')
            ->where('id_siswa', $siswa->id)
            ->whereNotNull('tanggal_catat')
            ->selectRaw('DISTINCT YEAR(tanggal_catat) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $listTahun = array_values(array_unique($dbYearsPencapaian));
        if (empty($listTahun)) {
            $listTahun = [(string)date('Y')];
        }
        rsort($listTahun);

        return view('parents.penilaian_anak', compact(
            'user',
            'parent',
            'siswa',
            'siswaList',
            'namaPelatih',
            'bulan',
            'tahun',
            'namaBulan',
            'totalPenilaianBulanIni',
            'avgScoreBulanIni',
            'progresNilaiPersen',
            'progresGayaList',
            'penilaianList',
            'totalPenilaian',
            'rataRataNilai',
            'listTahun'
        ));
    }

    /**
     * Halaman Absensi Anak
     */
    public function absensi(Request $request)
    {
        $data = $this->getParentAndChildData();
        extract($data);

        $bulan = sprintf('%02d', (int) $request->input('bulan', date('m')));
        $tahun = (string) $request->input('tahun', date('Y'));

        $absensiQuery = DB::table('absensi_siswa')
            ->where('id_siswa', $siswa->id)
            ->whereYear('tanggal_kehadiran', $tahun)
            ->whereMonth('tanggal_kehadiran', sprintf('%02d', $bulan));

        $absensiList = (clone $absensiQuery)
            ->orderBy('tanggal_kehadiran', 'desc')
            ->get();

        $totalHadir = (clone $absensiQuery)->where('status_kehadiran', 'hadir')->count();
        $totalIzin  = (clone $absensiQuery)->where('status_kehadiran', 'izin')->count();
        $totalSakit = (clone $absensiQuery)->where('status_kehadiran', 'sakit')->count();

        // Nama Bulan Indonesia
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ][sprintf('%02d', $bulan)] ?? 'Oktober';

        $chartAbsensiData = (clone $absensiQuery)
            ->orderBy('tanggal_kehadiran', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal'    => $item->tanggal_kehadiran,
                    'tgl_format' => Carbon::parse($item->tanggal_kehadiran)->translatedFormat('d M Y'),
                    'tgl_short'  => Carbon::parse($item->tanggal_kehadiran)->translatedFormat('d M'),
                    'status'     => strtolower($item->status_kehadiran ?? 'hadir'),
                    'keterangan' => $item->keterangan ?? '-',
                ];
            })->values();

        $dbYearsAbsensi = DB::table('absensi_siswa')
            ->where('id_siswa', $siswa->id)
            ->whereNotNull('tanggal_kehadiran')
            ->selectRaw('DISTINCT YEAR(tanggal_kehadiran) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $listTahun = array_values(array_unique($dbYearsAbsensi));
        if (empty($listTahun)) {
            $listTahun = [(string)date('Y')];
        }
        rsort($listTahun);

        return view('parents.absensi', compact(
            'user',
            'parent',
            'siswa',
            'siswaList',
            'namaPelatih',
            'absensiList',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'bulan',
            'tahun',
            'namaBulan',
            'chartAbsensiData',
            'listTahun'
        ));
    }

    /**
     * Halaman Berikan Penilaian (Ulasan Pelatih & Ulasan Club)
     */
    public function nilai(Request $request)
    {
        $data = $this->getParentAndChildData();
        extract($data);

        $activeTab = $request->input('tab', 'pelatih');
        $filterBulan = sprintf('%02d', (int) $request->input('bulan', date('m')));
        $filterTahun = (string) $request->input('tahun', date('Y'));

        $namaBulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $namaBulanTerpilih = ($namaBulanList[$filterBulan] ?? 'November') . ' ' . $filterTahun;

        $idCabangSiswa = $siswa->id_cabang ?? null;

        // Fetch list of coaches for dropdown selection - Hanya pelatih yang terdaftar di cabang siswa ini
        $coachesQuery = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id')
            ->select('pelatih.id', 'users.nama', 'users.foto')
            ->orderBy('pelatih.id', 'asc');

        if ($idCabangSiswa) {
            $coachesQuery->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                         ->where('cabang_pelatih.id_cabang', $idCabangSiswa)
                         ->distinct();
        }

        $coaches = $coachesQuery->get();

        // Fetch cabang info
        $cabang = DB::table('cabang')->where('id', $siswa->id_cabang ?? 1)->first();

        $currentMonth = now()->month;
        $currentYear  = now()->year;
        $namaBulanIni = Carbon::now()->translatedFormat('F Y');

        // Daftar ulasan pelatih yang sudah diberikan oleh parent ini pada bulan berjalan
        $ulasanPelatihBulanIni = DB::table('ulasan_pelatih')
            ->where('id_parents', $parentId)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get()
            ->keyBy('id_pelatih');

        $ratedCoachIdsThisMonth = $ulasanPelatihBulanIni->keys()->map(fn($id) => (int) $id)->toArray();

        // Riwayat ulasan pelatih oleh parent ini berdasarkan filter bulan & tahun
        $riwayatUlasanPelatih = DB::table('ulasan_pelatih')
            ->join('pelatih', 'ulasan_pelatih.id_pelatih', '=', 'pelatih.id')
            ->join('users', 'pelatih.id_user', '=', 'users.id')
            ->where('ulasan_pelatih.id_parents', $parentId)
            ->whereYear('ulasan_pelatih.created_at', (int) $filterTahun)
            ->whereMonth('ulasan_pelatih.created_at', (int) $filterBulan)
            ->select(
                'ulasan_pelatih.*',
                'users.nama as nama_pelatih',
                'users.foto as foto_pelatih'
            )
            ->orderBy('ulasan_pelatih.created_at', 'desc')
            ->get();

        // Cek apakah club sudah dinilai oleh parent ini pada bulan berjalan
        $clubReviewThisMonth = DB::table('ulasan_club')
            ->where('id_parents', $parentId)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        // Riwayat ulasan club oleh parent ini berdasarkan filter bulan & tahun
        $riwayatUlasanClub = DB::table('ulasan_club')
            ->leftJoin('cabang', 'ulasan_club.id_cabang', '=', 'cabang.id')
            ->where('ulasan_club.id_parents', $parentId)
            ->whereYear('ulasan_club.created_at', (int) $filterTahun)
            ->whereMonth('ulasan_club.created_at', (int) $filterBulan)
            ->select('ulasan_club.*', 'cabang.nama as nama_cabang')
            ->orderBy('ulasan_club.created_at', 'desc')
            ->get();

        // Tahun yang tersedia untuk dropdown filter
        $tahunTersedia = DB::table('ulasan_pelatih')
            ->where('id_parents', $parentId)
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->pluck('tahun')
            ->push((int) date('Y'))
            ->unique()
            ->sortDesc()
            ->values();

        return view('parents.nilai', compact(
            'user',
            'parent',
            'siswa',
            'siswaList',
            'activeTab',
            'coaches',
            'cabang',
            'namaPelatih',
            'namaBulanIni',
            'namaBulanTerpilih',
            'namaBulanList',
            'filterBulan',
            'filterTahun',
            'tahunTersedia',
            'ulasanPelatihBulanIni',
            'ratedCoachIdsThisMonth',
            'riwayatUlasanPelatih',
            'clubReviewThisMonth',
            'riwayatUlasanClub'
        ));
    }

    /**
     * Store Ulasan Pelatih (Maksimal 1x per bulan untuk setiap pelatih)
     */
    public function storeUlasanPelatih(Request $request)
    {
        $request->validate([
            'id_pelatih'     => 'required',
            'bintang_rating' => 'required|integer|min:1|max:5',
            'komentar_rating'=> 'nullable|string',
        ]);

        $data = $this->getParentAndChildData();
        $siswa = $data['siswa'] ?? null;
        $idCabangSiswa = $siswa->id_cabang ?? null;

        // Pastikan pelatih memang terdaftar di cabang siswa ini
        if ($idCabangSiswa) {
            $isAssigned = DB::table('cabang_pelatih')
                ->where('id_pelatih', $request->id_pelatih)
                ->where('id_cabang', $idCabangSiswa)
                ->exists();

            if (!$isAssigned) {
                return redirect()->route('parents.nilai', ['tab' => 'pelatih'])
                    ->with('error', 'Pelatih yang dipilih tidak terdaftar di cabang siswa Anda.');
            }
        }

        $alreadyRated = DB::table('ulasan_pelatih')
            ->where('id_parents', $data['parentId'])
            ->where('id_pelatih', $request->id_pelatih)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->exists();

        if ($alreadyRated) {
            return redirect()->route('parents.nilai', ['tab' => 'pelatih'])
                ->with('error', 'Anda sudah memberikan penilaian untuk pelatih ini pada bulan ini. Setiap pelatih hanya dapat dinilai 1 kali per bulan.');
        }

        DB::table('ulasan_pelatih')->insert([
            'id_pelatih'      => $request->id_pelatih,
            'id_parents'      => $data['parentId'],
            'bintang_rating'  => $request->bintang_rating,
            'komentar_rating' => $request->komentar_rating,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('parents.nilai', ['tab' => 'pelatih'])
            ->with('success', 'Terima kasih! Penilaian untuk pelatih berhasil dikirim.');
    }

    /**
     * Store Ulasan Club (Maksimal 1x per bulan)
     */
    public function storeUlasanClub(Request $request)
    {
        $request->validate([
            'kategori'       => 'nullable|in:fasilitas,manajemen,program,harga,umum',
            'bintang_rating' => 'required|integer|min:1|max:5',
            'komentar_rating'=> 'nullable|string',
        ]);

        $data = $this->getParentAndChildData();

        $alreadyRatedClub = DB::table('ulasan_club')
            ->where('id_parents', $data['parentId'])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->exists();

        if ($alreadyRatedClub) {
            return redirect()->route('parents.nilai', ['tab' => 'club'])
                ->with('error', 'Anda sudah memberikan penilaian untuk club pada bulan ini. Penilaian club hanya dapat diberikan 1 kali per bulan.');
        }

        DB::table('ulasan_club')->insert([
            'id_cabang'       => $data['siswa']->id_cabang ?? 1,
            'id_parents'      => $data['parentId'],
            'kategori'        => $request->input('kategori', 'umum') ?: 'umum',
            'bintang_rating'  => $request->bintang_rating,
            'komentar_rating' => $request->komentar_rating,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('parents.nilai', ['tab' => 'club'])
            ->with('success', 'Terima kasih! Penilaian untuk club berhasil dikirim.');
    }

    /**
     * Halaman Pengaturan Profile Orang Tua
     */
    public function pengaturan(Request $request)
    {
        $data = $this->getParentAndChildData();
        extract($data);

        return view('parents.pengaturan', compact(
            'user',
            'parent',
            'siswa',
            'siswaList',
            'namaPelatih'
        ));
    }

    /**
     * Update Profile Orang Tua
     */
    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'     => 'nullable|string|max:20',
            'alamat'    => 'nullable|string',
            'password'  => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'foto_anak' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email tersebut sudah digunakan oleh akun lain.',
            'password.min'       => 'Kata sandi minimal harus 8 karakter.',
            'password.regex'     => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'foto_anak.image'    => 'File foto profil anak harus berupa gambar.',
            'foto_anak.mimes'    => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'foto_anak.max'      => 'Ukuran file foto profil anak maksimal 3MB.',
        ]);

        $userData = [
            'nama'  => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id', $user->id)->update($userData);

        $parent = DB::table('parents')->where('id_user', $user->id)->first();
        if ($parent) {
            DB::table('parents')->where('id', $parent->id)->update([
                'alamat' => $request->alamat,
            ]);
        }

        // Proses update foto profil anak
        $data = $this->getParentAndChildData();
        $targetSiswaId = $request->input('id_siswa', $data['siswa']->id ?? null);
        $targetSiswa = $targetSiswaId ? DB::table('siswa')->where('id', $targetSiswaId)->first() : null;

        if ($request->hasFile('foto_anak') && $targetSiswa) {
            $file = $request->file('foto_anak');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'siswa_' . time() . '_' . uniqid() . '.' . $extension;
            $destPath = public_path('uploads/siswa');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $filename);

            // Hapus foto lama jika ada
            if (!empty($targetSiswa->foto) && file_exists(public_path($targetSiswa->foto))) {
                @unlink(public_path($targetSiswa->foto));
            }

            DB::table('siswa')->where('id', $targetSiswa->id)->update([
                'foto' => 'uploads/siswa/' . $filename,
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('parents.pengaturan')
            ->with('success', 'Profil dan foto profil anak berhasil diperbarui.');
    }
}
