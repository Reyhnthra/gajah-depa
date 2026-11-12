<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Mail\PendaftaranDisetujuiOrtuMail;

class AdminSiswaController extends Controller
{
    // Menampilkan halaman Manajemen Siswa & Pendaftar Baru
    public function index(Request $request)
    {
        // 1. Data Siswa Aktif
        $query_siswa = DB::table('siswa')
            ->leftJoin('parents', 'siswa.id_parents', '=', 'parents.id')
            ->leftJoin('users', 'parents.id_user', '=', 'users.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->select(
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
                'siswa.tempat_lahir',
                'siswa.tanggal_lahir',
                'siswa.jenis_kelamin',
                'siswa.tingkat_kelas',
                'siswa.foto',
                'siswa.tanggal_masuk',
                'siswa.sekolah',
                'siswa.riwayat_penyakit',
                'siswa.catatan_khusus',
                'siswa.id_kelas',
                'siswa.id_cabang',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang',
                'users.nama as nama_orang_tua',
                'users.email as email_orang_tua',
                'users.no_hp as no_hp_orang_tua',
                'parents.alamat as alamat_orang_tua'
            )
            ->orderBy('siswa.nama', 'asc');

        // Batasi data siswa hanya untuk cabang milik Admin yang sedang login
        $adminCabang = Auth::user()->id_cabang ?? null;
        if ($adminCabang) {
            $query_siswa->where('siswa.id_cabang', $adminCabang);
        }

        // Simpan semua data siswa untuk perhitungan KPI card statistik (agar tidak berubah saat difilter)
        $all_siswa = (clone $query_siswa)->get();

        if ($request->filled('search_siswa')) {
            $search = trim($request->search_siswa);
            $query_siswa->where(function ($q) use ($search) {
                $cleanId = ltrim(preg_replace('/[^0-9]/', '', $search), '0');
                $q->where('siswa.nama', 'like', "%{$search}%")
                  ->orWhere('kelas.nama', 'like', "%{$search}%")
                  ->orWhere('cabang.nama', 'like', "%{$search}%")
                  ->orWhere('siswa.tingkat_kelas', 'like', "%{$search}%");

                if (!empty($cleanId)) {
                    $q->orWhere('siswa.id', $cleanId);
                }
            });
        }

        $data_siswa = $query_siswa->get();

        // 2. Data Absensi per Siswa (untuk modal detail)
        $absensi_per_siswa = DB::table('absensi_siswa')
            ->select('id_siswa', 'tanggal_kehadiran', 'status_kehadiran', 'keterangan')
            ->orderBy('tanggal_kehadiran', 'desc')
            ->get()
            ->groupBy('id_siswa');

        // 3. Data Pencapaian / Penilaian per Siswa
        $pencapaian_per_siswa = DB::table('pencapaian_siswa')
            ->select('id_siswa', 'gaya_renang', 'catatan_waktu', 'teknik', 'kecepatan', 'ketahanan', 'catatan', 'kejuaraan', 'tanggal_catat')
            ->orderBy('tanggal_catat', 'desc')
            ->get()
            ->groupBy('id_siswa');

        // 4b. Data Absensi Monitoring Sesi Latihan (grouped by tanggal)
        $bulan_absensi  = $request->filled('bulan_absensi')  ? $request->bulan_absensi  : date('m');
        $tahun_absensi  = $request->filled('tahun_absensi')  ? $request->tahun_absensi  : date('Y');
        $filter_cabang_absensi = $request->filter_cabang_absensi ?? '';
        $filter_kelas_absensi  = $request->filter_kelas_absensi  ?? '';

        $query_absensi_sesi = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->select(
                'absensi_siswa.tanggal_kehadiran',
                'absensi_siswa.id_siswa',
                'absensi_siswa.status_kehadiran',
                'absensi_siswa.keterangan',
                'siswa.nama as nama_siswa',
                'siswa.tingkat_kelas',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang'
            )
            ->whereMonth('absensi_siswa.tanggal_kehadiran', $bulan_absensi)
            ->whereYear('absensi_siswa.tanggal_kehadiran', $tahun_absensi)
            ->orderBy('absensi_siswa.tanggal_kehadiran', 'desc');

        if ($adminCabang) {
            $query_absensi_sesi->where('siswa.id_cabang', $adminCabang);
        } elseif (!empty($filter_cabang_absensi)) {
            $query_absensi_sesi->where('siswa.id_cabang', $filter_cabang_absensi);
        }
        if (!empty($filter_kelas_absensi)) {
            $query_absensi_sesi->where('siswa.id_kelas', $filter_kelas_absensi);
        }

        $absensi_sesi_raw = $query_absensi_sesi->get();

        // Group by tanggal untuk tabel monitoring sesi
        $absensi_per_sesi = $absensi_sesi_raw->groupBy('tanggal_kehadiran')->map(function ($records) {
            return [
                'tanggal'   => $records->first()->tanggal_kehadiran,
                'hadir'     => $records->where('status_kehadiran', 'hadir')->count(),
                'izin'      => $records->where('status_kehadiran', 'izin')->count(),
                'sakit'     => $records->where('status_kehadiran', 'sakit')->count(),
                'tidak_hadir' => $records->where('status_kehadiran', 'tidak_hadir')->count(),
                'total'     => $records->count(),
                'detail'    => $records->values(),
            ];
        })->sortByDesc('tanggal')->values();

        // Ringkasan bulan ini
        $rekap_bulan = [
            'total_sesi'  => $absensi_per_sesi->count(),
            'total_hadir' => $absensi_sesi_raw->where('status_kehadiran', 'hadir')->count(),
            'total_izin'  => $absensi_sesi_raw->where('status_kehadiran', 'izin')->count(),
            'total_sakit' => $absensi_sesi_raw->where('status_kehadiran', 'sakit')->count(),
            'total_absen' => $absensi_sesi_raw->where('status_kehadiran', 'tidak_hadir')->count(),
        ];

        // 4. Data Pendaftar Baru (Status Pending / Menunggu Verifikasi) - Dibatasi sesuai Cabang Admin
        $query_pending = DB::table('pendaftaran_baru')
            ->leftJoin('kelas', 'pendaftaran_baru.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'pendaftaran_baru.id_cabang', '=', 'cabang.id')
            ->select(
                'pendaftaran_baru.*',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang'
            )
            ->where('pendaftaran_baru.status_pendaftaran', 'pending');

        if ($adminCabang) {
            $query_pending->where('pendaftaran_baru.id_cabang', $adminCabang);
        }

        $pendaftaran_pending = $query_pending
            ->orderBy('pendaftaran_baru.created_at', 'desc')
            ->get();

        // Hitung total pending
        $total_pending = count($pendaftaran_pending);

        // Ambil data master cabang & kelas untuk dropdown modal (disesuaikan dengan cabang admin)
        $master_cabang = $adminCabang
            ? DB::table('cabang')->where('id', $adminCabang)->get()
            : DB::table('cabang')->get();

        $master_kelas = $adminCabang
            ? DB::table('kelas')->where('id_cabang', $adminCabang)->get()
            : DB::table('kelas')->get();

        // Hitung ringkasan jumlah siswa (berdasarkan seluruh data siswa aktif)
        $total_siswa    = $all_siswa->count();
        $siswa_pemula   = $all_siswa->filter(function ($s) {
            $lvl = strtolower($s->tingkat_kelas ?? '');
            return str_contains($lvl, 'pemula') || str_contains($lvl, 'dasar');
        })->count();
        $siswa_lanjutan = $all_siswa->filter(function ($s) {
            $lvl = strtolower($s->tingkat_kelas ?? '');
            return str_contains($lvl, 'lanjutan');
        })->count();
        $siswa_senior   = $all_siswa->filter(function ($s) {
            $lvl = strtolower($s->tingkat_kelas ?? '');
            return str_contains($lvl, 'senior');
        })->count();

        $dbYearsAbsensiSiswa = DB::table('absensi_siswa')
            ->selectRaw('DISTINCT YEAR(tanggal_kehadiran) as yr')
            ->whereNotNull('tanggal_kehadiran')
            ->pluck('yr')->map(fn($y) => (int)$y)->toArray();
        $listTahunAbsensi = array_values(array_unique(array_merge([(int)date('Y')], $dbYearsAbsensiSiswa)));
        rsort($listTahunAbsensi);

        return view('admin.siswa', compact(
            'data_siswa',
            'pendaftaran_pending',
            'total_pending',
            'master_cabang',
            'master_kelas',
            'absensi_per_siswa',
            'pencapaian_per_siswa',
            'total_siswa',
            'siswa_pemula',
            'siswa_lanjutan',
            'siswa_senior',
            'absensi_per_sesi',
            'rekap_bulan',
            'bulan_absensi',
            'tahun_absensi',
            'filter_cabang_absensi',
            'filter_kelas_absensi',
            'listTahunAbsensi'
        ));
    }

    // Export 1: Data Master Siswa ke file CSV (ID Siswa, Nama Lengkap, TTL, JK, Kelas, Cabang, Sekolah, Ortu, No HP, Riwayat Medis, dan Rekap Kehadiran)
    public function export(Request $request)
    {
        $query = DB::table('siswa')
            ->leftJoin('parents', 'siswa.id_parents', '=', 'parents.id')
            ->leftJoin('users', 'parents.id_user', '=', 'users.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->select(
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
                'siswa.tempat_lahir',
                'siswa.tanggal_lahir',
                'siswa.jenis_kelamin',
                'siswa.tingkat_kelas',
                'siswa.tanggal_masuk',
                'siswa.sekolah',
                'siswa.riwayat_penyakit',
                'siswa.catatan_khusus',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang',
                'users.nama as nama_orang_tua',
                'users.email as email_orang_tua',
                'users.no_hp as no_hp_orang_tua',
                'parents.alamat as alamat_orang_tua'
            );

        if ($request->filled('search_siswa')) {
            $search = trim($request->search_siswa);
            $query->where(function ($q) use ($search) {
                $cleanId = ltrim(preg_replace('/[^0-9]/', '', $search), '0');
                $q->where('siswa.nama', 'like', "%{$search}%")
                  ->orWhere('kelas.nama', 'like', "%{$search}%")
                  ->orWhere('cabang.nama', 'like', "%{$search}%")
                  ->orWhere('siswa.tingkat_kelas', 'like', "%{$search}%")
                  ->orWhere('users.nama', 'like', "%{$search}%");

                if (!empty($cleanId)) {
                    $q->orWhere('siswa.id', $cleanId);
                }
            });
        }

        $adminCabang = Auth::user()->id_cabang ?? null;
        if ($adminCabang) {
            $query->where('siswa.id_cabang', $adminCabang);
        }

        $data_siswa = $query->orderBy('siswa.nama', 'asc')->get();

        // Query ringkasan absensi per siswa
        $absensi = DB::table('absensi_siswa')
            ->select('id_siswa', 'status_kehadiran')
            ->get()
            ->groupBy('id_siswa');

        $filename = 'data_siswa_gajah_depa_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($data_siswa, $absensi) {
            $handle = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Microsoft Excel membaca karakter dengan benar
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'ID Siswa',
                'Nama Lengkap Siswa',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'Tingkat / Level Kelas',
                'Cabang Latihan',
                'Tanggal Masuk',
                'Asal Sekolah',
                'Nama Orang Tua / Wali',
                'No. HP / WA Orang Tua',
                'Email Orang Tua',
                'Alamat Orang Tua',
                'Riwayat Penyakit',
                'Catatan Khusus',
                'Total Hadir',
                'Total Izin',
                'Total Sakit',
                'Total Alfa',
            ]);

            $no = 1;
            foreach ($data_siswa as $item) {
                $riwayat = $absensi->get($item->id_siswa, collect([]));
                $hadir   = $riwayat->where('status_kehadiran', 'hadir')->count();
                $izin    = $riwayat->where('status_kehadiran', 'izin')->count();
                $sakit   = $riwayat->where('status_kehadiran', 'sakit')->count();
                $alfa    = $riwayat->whereIn('status_kehadiran', ['tidak_hadir', 'alfa'])->count();

                $formattedId = 'GD' . str_pad($item->id_siswa, 3, '0', STR_PAD_LEFT);
                $tglLahir    = $item->tanggal_lahir ? date('d/m/Y', strtotime($item->tanggal_lahir)) : '-';
                $tglMasuk    = $item->tanggal_masuk ? date('d/m/Y', strtotime($item->tanggal_masuk)) : '-';
                $jk          = $item->jenis_kelamin ? ($item->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : 'Perempuan') : '-';
                $levelKelas  = $item->tingkat_kelas ?: ($item->nama_kelas ?: '-');
                $cabang      = $item->nama_cabang ?: '-';
                $noHp        = $item->no_hp_orang_tua ? "'" . $item->no_hp_orang_tua : '-';

                fputcsv($handle, [
                    $no++,
                    $formattedId,
                    $item->nama_siswa,
                    $item->tempat_lahir ?? '-',
                    $tglLahir,
                    $jk,
                    $levelKelas,
                    $cabang,
                    $tglMasuk,
                    $item->sekolah ?? '-',
                    $item->nama_orang_tua ?? '-',
                    $noHp,
                    $item->email_orang_tua ?? '-',
                    $item->alamat_orang_tua ?? '-',
                    $item->riwayat_penyakit ?? '-',
                    $item->catatan_khusus ?? '-',
                    $hadir,
                    $izin,
                    $sakit,
                    $alfa,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export 2: Absensi Siswa ke file CSV (Mendukung format 'rekap' per siswa atau 'sesi' log per sesi latihan)
    public function exportAbsensi(Request $request)
    {
        $format    = $request->input('format') ?: $request->input('export_format_choice', 'rekap');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $labelRentang = 'semua_waktu';
        if (!empty($startDate) || !empty($endDate)) {
            $labelRentang = ($startDate ?: 'awal') . '_sd_' . ($endDate ?: 'akhir');
        }

        // Pilihan 1: Log Kehadiran Per Sesi Latihan (Tanggal, ID Siswa, Nama Siswa, Kelas, Cabang, Status, Keterangan)
        if ($format === 'sesi') {
            $query = DB::table('absensi_siswa')
                ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
                ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
                ->select(
                    'absensi_siswa.id',
                    'absensi_siswa.tanggal_kehadiran',
                    'absensi_siswa.status_kehadiran',
                    'absensi_siswa.keterangan',
                    'siswa.id as id_siswa',
                    'siswa.nama as nama_siswa',
                    'siswa.tingkat_kelas',
                    'kelas.nama as nama_kelas',
                    'cabang.nama as nama_cabang'
                );

            if (!empty($startDate)) {
                $query->whereDate('absensi_siswa.tanggal_kehadiran', '>=', $startDate);
            }
            if (!empty($endDate)) {
                $query->whereDate('absensi_siswa.tanggal_kehadiran', '<=', $endDate);
            }

            $adminCabang = Auth::user()->id_cabang ?? null;
            if ($adminCabang) {
                $query->where('siswa.id_cabang', $adminCabang);
            }

            $query->orderBy('absensi_siswa.tanggal_kehadiran', 'desc')
                  ->orderBy('siswa.nama', 'asc');

            $data_absensi = $query->get();

            $filename = 'log_absensi_siswa_per_sesi_' . $labelRentang . '_' . date('His') . '.csv';

            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma'              => 'no-cache',
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Expires'             => '0',
            ];

            $callback = function () use ($data_absensi) {
                $handle = fopen('php://output', 'w');
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                fputcsv($handle, [
                    'No',
                    'Tanggal Kehadiran',
                    'ID Siswa',
                    'Nama Siswa',
                    'Kelas',
                    'Cabang',
                    'Status Kehadiran',
                    'Keterangan',
                ]);

                $no = 1;
                foreach ($data_absensi as $row) {
                    $status = match($row->status_kehadiran) {
                        'hadir'                 => 'Hadir',
                        'izin'                  => 'Izin',
                        'sakit'                 => 'Sakit',
                        'tidak_hadir', 'alfa'   => 'Alpha',
                        default                 => ucfirst($row->status_kehadiran),
                    };

                    $formattedId = 'GD' . str_pad($row->id_siswa, 3, '0', STR_PAD_LEFT);
                    $tgl         = date('d/m/Y', strtotime($row->tanggal_kehadiran));
                    $namaKelas   = $row->tingkat_kelas ?: ($row->nama_kelas ?: '-');

                    fputcsv($handle, [
                        $no++,
                        $tgl,
                        $formattedId,
                        $row->nama_siswa,
                        $namaKelas,
                        $row->nama_cabang ?? '-',
                        $status,
                        $row->keterangan ?? '-',
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Pilihan 2: Rekap Absensi Per Siswa (No, ID Siswa, Nama Siswa, Kelas, Cabang, Total Hadir, Total Izin, Total Sakit, Total Alfa)
        $query = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->select(
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
                'siswa.tingkat_kelas',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang'
            );

        $adminCabang = Auth::user()->id_cabang ?? null;
        if ($adminCabang) {
            $query->where('siswa.id_cabang', $adminCabang);
        }

        $data_siswa = $query->orderBy('siswa.nama', 'asc')->get();

        // Query absensi siswa (difilter rentang tanggal jika disediakan)
        $queryAbsensi = DB::table('absensi_siswa')->select('id_siswa', 'status_kehadiran');

        if (!empty($startDate)) {
            $queryAbsensi->whereDate('tanggal_kehadiran', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $queryAbsensi->whereDate('tanggal_kehadiran', '<=', $endDate);
        }

        $absensi = $queryAbsensi->get()->groupBy('id_siswa');

        $filename = 'rekap_absensi_siswa_' . $labelRentang . '_' . date('His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($data_siswa, $absensi) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'ID Siswa',
                'Nama Siswa',
                'Kelas',
                'Cabang',
                'Total Hadir',
                'Total Izin',
                'Total Sakit',
                'Total Alfa',
            ]);

            $no = 1;
            foreach ($data_siswa as $item) {
                $riwayat = $absensi->get($item->id_siswa, collect([]));
                $hadir   = $riwayat->where('status_kehadiran', 'hadir')->count();
                $izin    = $riwayat->where('status_kehadiran', 'izin')->count();
                $sakit   = $riwayat->where('status_kehadiran', 'sakit')->count();
                $alfa    = $riwayat->whereIn('status_kehadiran', ['tidak_hadir', 'alfa'])->count();

                $formattedId = 'GD' . str_pad($item->id_siswa, 3, '0', STR_PAD_LEFT);
                $namaKelas   = $item->tingkat_kelas ?: ($item->nama_kelas ?: '-');

                fputcsv($handle, [
                    $no++,
                    $formattedId,
                    $item->nama_siswa,
                    $namaKelas,
                    $item->nama_cabang ?? '-',
                    $hadir,
                    $izin,
                    $sakit,
                    $alfa,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ACC / Setujui Pendaftaran Baru (Pindah ke Siswa & User Parents)
    public function acc(Request $request, $id)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('pendaftaran_baru')->where('id', $id);
        if ($adminCabang) {
            $query->where('id_cabang', $adminCabang);
        }
        $pendaftar = $query->first();

        if (!$pendaftar) {
            return redirect()->back()->withErrors(['msg' => 'Data pendaftaran tidak ditemukan atau bukan milik cabang Anda.']);
        }

        // Jika pendaftaran sudah disetujui sebelumnya, cegah eksekusi berulang
        if ($pendaftar->status_pendaftaran === 'disetujui') {
            return redirect()->back()->with('sukses', 'Pendaftaran ' . $pendaftar->nama_siswa . ' sudah pernah disetujui (ACC) sebelumnya.');
        }

        $finalKelasNama = 'Pemula A';

        DB::transaction(function () use ($pendaftar, $request, $id, &$finalKelasNama) {
            // Kunci baris pendaftaran_baru untuk mencegah race condition (klik ganda bersamaan)
            $pendaftarLocked = DB::table('pendaftaran_baru')->where('id', $id)->lockForUpdate()->first();
            if (!$pendaftarLocked || $pendaftarLocked->status_pendaftaran === 'disetujui') {
                return;
            }

            // 1. Cek atau buat akun User Parents (Data tersimpan, password menunggu dibuat oleh orang tua di halaman register)
            $userParent = User::where('email', $pendaftarLocked->email)->first();
            if (!$userParent) {
                $userParent = User::create([
                    'nama'          => $pendaftarLocked->nama_orang_tua,
                    'no_hp'         => $pendaftarLocked->no_hp,
                    'email'         => $pendaftarLocked->email,
                    'jenis_kelamin' => 'laki-laki',
                    'password'      => null,
                    'password_set'  => false,
                    'role'          => 'parents',
                    'status'        => 'aktif',
                    'id_cabang'     => $pendaftarLocked->id_cabang,
                ]);
            }

            // 2. Cek atau buat profil Parents
            $parent = DB::table('parents')->where('id_user', $userParent->id)->first();
            if (!$parent) {
                $parentId = DB::table('parents')->insertGetId([
                    'id_user' => $userParent->id,
                    'alamat'  => $pendaftarLocked->alamat,
                ]);
            } else {
                $parentId = $parent->id;
            }

            // Penentuan kelas plotting (dari pilihan admin saat ACC, atau dari data pendaftar, atau default Pemula A)
            $kelasId = $request->id_kelas ?: $pendaftarLocked->id_kelas;
            if (!$kelasId) {
                $kelasId = DB::table('kelas')
                    ->where('id_cabang', $pendaftarLocked->id_cabang)
                    ->where('nama', 'like', '%Pemula A%')
                    ->value('id')
                    ?? DB::table('kelas')->where('id_cabang', $pendaftarLocked->id_cabang)->value('id')
                    ?? 1;
            }

            $kelasNama = DB::table('kelas')->where('id', $kelasId)->value('nama') ?? 'Pemula A';
            $finalKelasNama = $kelasNama;

            $fotoSiswaPath = null;
            if ($pendaftarLocked->foto_siswa) {
                $fotoSiswaPath = str_starts_with($pendaftarLocked->foto_siswa, 'uploads/')
                    ? $pendaftarLocked->foto_siswa
                    : 'uploads/pendaftaran/foto/' . $pendaftarLocked->foto_siswa;
            }

            $namaSiswa = mb_convert_case(trim($pendaftarLocked->nama_siswa), MB_CASE_TITLE, 'UTF-8');
            $tempatLahir = $pendaftarLocked->tempat_lahir ? mb_convert_case(trim($pendaftarLocked->tempat_lahir), MB_CASE_TITLE, 'UTF-8') : null;

            // Pastikan tidak ada data siswa ganda dengan nama, tanggal lahir, dan parent yang sama
            $existingSiswa = DB::table('siswa')
                ->where('id_parents', $parentId)
                ->where('nama', $namaSiswa)
                ->where('tanggal_lahir', $pendaftarLocked->tanggal_lahir)
                ->first();

            if (!$existingSiswa) {
                // 3. Masukkan ke tabel `siswa`
                DB::table('siswa')->insert([
                    'nama'             => $namaSiswa,
                    'tempat_lahir'     => $tempatLahir,
                    'tanggal_lahir'    => $pendaftarLocked->tanggal_lahir,
                    'jenis_kelamin'    => 'laki-laki',
                    'tingkat_kelas'    => $kelasNama,
                    'foto'             => $fotoSiswaPath,
                    'tanggal_masuk'    => now(),
                    'sekolah'          => $pendaftarLocked->sekolah,
                    'riwayat_penyakit' => $pendaftarLocked->riwayat_penyakit ?? null,
                    'catatan_khusus'   => $pendaftarLocked->catatan_khusus ?? null,
                    'id_parents'       => $parentId,
                    'id_kelas'         => $kelasId,
                    'id_cabang'        => $pendaftarLocked->id_cabang,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            // 4. Update status pendaftaran_baru menjadi 'disetujui' dan simpan id_kelas yang di-plotting
            DB::table('pendaftaran_baru')
                ->where('id', $pendaftarLocked->id)
                ->update([
                    'status_pendaftaran' => 'disetujui',
                    'id_kelas'           => $kelasId,
                    'updated_at'         => now(),
                ]);
        });

        // 📧 Kirim notifikasi email ke Orang Tua bahwa pendaftaran telah disetujui (ACC)
        if (!empty($pendaftar->email)) {
            try {
                $cabangNama = DB::table('cabang')->where('id', $pendaftar->id_cabang)->value('nama') ?? 'Gajah Depa Akuatik';
                $userParent = User::where('email', $pendaftar->email)->first();
                $needsPassword = !$userParent || empty($userParent->password) || !$userParent->password_set;

                Mail::to($pendaftar->email)->send(new PendaftaranDisetujuiOrtuMail([
                    'nama_siswa'     => $pendaftar->nama_siswa,
                    'nama_orang_tua' => $pendaftar->nama_orang_tua,
                    'email'          => $pendaftar->email,
                    'nama_cabang'    => $cabangNama,
                    'nama_kelas'     => $finalKelasNama,
                    'needs_password' => $needsPassword,
                    'action_url'     => $needsPassword ? url('/register') : url('/login'),
                ]));
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim email notifikasi ACC ke orang tua: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('sukses', 'Pendaftaran ' . $pendaftar->nama_siswa . ' berhasil disetujui (ACC) dan resmi menjadi Siswa Aktif!');
    }

    // Tolak Pendaftaran Baru
    public function tolak(Request $request, $id)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('pendaftaran_baru')->where('id', $id);
        if ($adminCabang) {
            $query->where('id_cabang', $adminCabang);
        }
        $pendaftar = $query->first();

        if ($pendaftar) {
            if ($pendaftar->status_pendaftaran === 'ditolak') {
                return redirect()->back()->with('sukses', 'Pendaftaran ' . $pendaftar->nama_siswa . ' sudah ditolak sebelumnya.');
            }

            DB::table('pendaftaran_baru')
                ->where('id', $id)
                ->update(['status_pendaftaran' => 'ditolak', 'updated_at' => now()]);

            return redirect()->back()->with('sukses', 'Pendaftaran ' . $pendaftar->nama_siswa . ' telah ditolak.');
        }

        return redirect()->back()->withErrors(['msg' => 'Data tidak ditemukan atau bukan milik cabang Anda.']);
    }

    // Tambah Siswa Baru Manual oleh Admin
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa'     => 'required|string|max:255',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'sekolah'        => 'required|string|max:255',
            'tingkat_kelas'  => 'required|string|in:Pemula A,Pemula B,Lanjutan,Senior',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_orang_tua' => 'required|string|max:255',
            'email'          => 'required|email',
            'no_hp'          => 'required|string|max:20',
        ], [
            'nama_siswa.required'     => 'Nama lengkap siswa wajib diisi.',
            'tempat_lahir.required'   => 'Tempat lahir siswa wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal lahir siswa wajib diisi.',
            'sekolah.required'        => 'Asal sekolah wajib diisi.',
            'tingkat_kelas.required'  => 'Pilihan level kelas wajib dipilih.',
            'tingkat_kelas.in'        => 'Level kelas harus salah satu dari: Pemula A, Pemula B, Lanjutan, Senior.',
            'foto.image'              => 'Foto anak harus berupa file gambar.',
            'foto.max'                => 'Ukuran foto anak maksimal 2MB.',
            'nama_orang_tua.required' => 'Nama orang tua/wali wajib diisi.',
            'email.required'          => 'Email orang tua wajib diisi.',
            'no_hp.required'          => 'Nomor WhatsApp / HP wajib diisi.',
        ]);

        DB::transaction(function () use ($request) {
            $namaOrtu = mb_convert_case(trim($request->nama_orang_tua), MB_CASE_TITLE, 'UTF-8');
            $namaSiswa = mb_convert_case(trim($request->nama_siswa), MB_CASE_TITLE, 'UTF-8');
            $tempatLahir = mb_convert_case(trim($request->tempat_lahir), MB_CASE_TITLE, 'UTF-8');

            $cleanNoHp = preg_replace('/[^0-9]/', '', (string)$request->no_hp);
            if (str_starts_with($cleanNoHp, '62')) {
                $cleanNoHp = '0' . substr($cleanNoHp, 2);
            } elseif (!str_starts_with($cleanNoHp, '0') && !empty($cleanNoHp)) {
                $cleanNoHp = '0' . $cleanNoHp;
            }

            // 1. User Parent
            $userParent = User::where('email', $request->email)->first();
            if (!$userParent) {
                $userParent = User::create([
                    'nama'          => $namaOrtu,
                    'no_hp'         => $cleanNoHp,
                    'email'         => $request->email,
                    'jenis_kelamin' => 'laki-laki',
                    'password'      => null,
                    'password_set'  => false,
                    'role'          => 'parents',
                    'status'        => 'aktif',
                ]);
            } else {
                $userParent->update([
                    'nama'  => $namaOrtu,
                    'no_hp' => $cleanNoHp,
                ]);
            }

            // 2. Profile Parent
            $parent = DB::table('parents')->where('id_user', $userParent->id)->first();
            if (!$parent) {
                $parentId = DB::table('parents')->insertGetId([
                    'id_user' => $userParent->id,
                    'alamat'  => null,
                ]);
            } else {
                $parentId = $parent->id;
            }

            // 3. Upload Foto Anak jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = 'siswa_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destPath = public_path('uploads/siswa');
                if (!file_exists($destPath)) {
                    mkdir($destPath, 0755, true);
                }
                $file->move($destPath, $filename);
                $fotoPath = 'uploads/siswa/' . $filename;
            }

            $adminCabang = Auth::user()->id_cabang ?? null;
            $kelasQuery = DB::table('kelas')->where('nama', 'like', '%' . $request->tingkat_kelas . '%');
            if ($adminCabang) {
                $kelasQuery->where('id_cabang', $adminCabang);
            }
            $kelas = $kelasQuery->first();
            $idKelas = $kelas ? $kelas->id : (DB::table('kelas')->where('id_cabang', $adminCabang)->value('id') ?? DB::table('kelas')->first()->id ?? null);
            $idCabang = $adminCabang ?: ($kelas ? $kelas->id_cabang : (DB::table('cabang')->first()->id ?? 1));

            // 4. Siswa
            DB::table('siswa')->insert([
                'nama'             => $namaSiswa,
                'tempat_lahir'     => $tempatLahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'jenis_kelamin'    => 'laki-laki',
                'tingkat_kelas'    => $request->tingkat_kelas,
                'foto'             => $fotoPath,
                'tanggal_masuk'    => now(),
                'sekolah'          => $request->sekolah,
                'riwayat_penyakit' => null,
                'catatan_khusus'   => null,
                'id_parents'       => $parentId,
                'id_kelas'         => $idKelas,
                'id_cabang'        => $idCabang,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('sukses', 'Siswa baru berhasil ditambahkan!');
    }

    // Update Data Siswa oleh Admin
    public function update(Request $request, $id)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $querySiswa = DB::table('siswa')->where('id', $id);
        if ($adminCabang) {
            $querySiswa->where('id_cabang', $adminCabang);
        }
        $siswa = $querySiswa->first();

        if (!$siswa) {
            return redirect()->route('admin.siswa.index')->withErrors(['msg' => 'Data siswa tidak ditemukan atau bukan milik cabang Anda.']);
        }

        $request->validate([
            'nama_siswa'       => 'required|string|max:255',
            'tempat_lahir'     => 'nullable|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'jenis_kelamin'    => 'nullable|in:laki-laki,perempuan',
            'tingkat_kelas'    => 'required|string|max:100',
            'sekolah'          => 'nullable|string|max:255',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'catatan_khusus'   => 'nullable|string|max:255',
            'id_cabang'        => 'nullable|integer',
            'id_kelas'         => 'nullable|integer',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_orang_tua'   => 'required|string|max:255',
            'email'            => 'required|email',
            'no_hp'            => 'required|string|max:20',
            'alamat'           => 'nullable|string|max:500',
        ], [
            'nama_siswa.required'     => 'Nama lengkap siswa wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal lahir siswa wajib diisi.',
            'tingkat_kelas.required'  => 'Pilihan level kelas wajib dipilih.',
            'nama_orang_tua.required' => 'Nama orang tua/wali wajib diisi.',
            'email.required'          => 'Email orang tua wajib diisi.',
            'no_hp.required'          => 'Nomor WhatsApp / HP wajib diisi.',
            'foto.image'              => 'Foto harus berupa file gambar.',
            'foto.max'                => 'Ukuran foto maksimal 2MB.',
        ]);

        DB::transaction(function () use ($request, $id, $siswa) {
            $namaOrtu = mb_convert_case(trim($request->nama_orang_tua), MB_CASE_TITLE, 'UTF-8');
            $namaSiswa = mb_convert_case(trim($request->nama_siswa), MB_CASE_TITLE, 'UTF-8');
            $tempatLahir = $request->filled('tempat_lahir') ? mb_convert_case(trim($request->tempat_lahir), MB_CASE_TITLE, 'UTF-8') : null;

            $fotoPath = $siswa->foto;

            // Jika upload foto baru
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = 'siswa_' . time() . '_' . uniqid() . '.' . $extension;
                $destPath = public_path('uploads/siswa');
                if (!file_exists($destPath)) {
                    mkdir($destPath, 0755, true);
                }
                $file->move($destPath, $filename);

                // Hapus foto lama jika ada
                if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                    @unlink(public_path($siswa->foto));
                }
                $fotoPath = 'uploads/siswa/' . $filename;
            } elseif ($request->boolean('hapus_foto')) {
                // Hapus foto jika diminta
                if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                    @unlink(public_path($siswa->foto));
                }
                $fotoPath = null;
            }

            $cleanNoHp = preg_replace('/[^0-9]/', '', (string)$request->no_hp);
            if (str_starts_with($cleanNoHp, '62')) {
                $cleanNoHp = '0' . substr($cleanNoHp, 2);
            } elseif (!str_starts_with($cleanNoHp, '0') && !empty($cleanNoHp)) {
                $cleanNoHp = '0' . $cleanNoHp;
            }

            // Update data Orang Tua & User Parent
            $targetParentId = $siswa->id_parents;
            $existingUserByEmail = DB::table('users')
                ->whereRaw('LOWER(email) = ?', [strtolower(trim($request->email))])
                ->first();

            if ($existingUserByEmail) {
                DB::table('users')->where('id', $existingUserByEmail->id)->update([
                    'nama'       => $namaOrtu,
                    'no_hp'      => $cleanNoHp,
                    'updated_at' => now(),
                ]);

                $existingParent = DB::table('parents')->where('id_user', $existingUserByEmail->id)->first();
                if ($existingParent) {
                    $targetParentId = $existingParent->id;
                    DB::table('parents')->where('id', $targetParentId)->update([
                        'alamat' => $request->alamat,
                    ]);
                } else {
                    $targetParentId = DB::table('parents')->insertGetId([
                        'id_user' => $existingUserByEmail->id,
                        'alamat'  => $request->alamat,
                    ]);
                }
            } elseif ($siswa->id_parents) {
                $parent = DB::table('parents')->where('id', $siswa->id_parents)->first();
                if ($parent) {
                    DB::table('parents')->where('id', $siswa->id_parents)->update([
                        'alamat' => $request->alamat,
                    ]);

                    if ($parent->id_user) {
                        DB::table('users')->where('id', $parent->id_user)->update([
                            'nama'       => $namaOrtu,
                            'email'      => $request->email,
                            'no_hp'      => $cleanNoHp,
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Update data Siswa
            $siswaUpdateData = [
                'id_parents'       => $targetParentId,
                'nama'             => $namaSiswa,
                'tempat_lahir'     => $tempatLahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'jenis_kelamin'    => $request->jenis_kelamin ?? 'laki-laki',
                'tingkat_kelas'    => $request->tingkat_kelas,
                'sekolah'          => $request->sekolah,
                'riwayat_penyakit' => null,
                'catatan_khusus'   => null,
                'foto'             => $fotoPath,
                'updated_at'       => now(),
            ];

            if ($adminCabang) {
                $siswaUpdateData['id_cabang'] = $adminCabang;
            } elseif ($request->filled('id_cabang')) {
                $siswaUpdateData['id_cabang'] = $request->id_cabang;
            }
            if ($request->filled('id_kelas')) {
                $siswaUpdateData['id_kelas'] = $request->id_kelas;
            }

            DB::table('siswa')->where('id', $id)->update($siswaUpdateData);
        });

        return redirect()->route('admin.siswa.index')->with('sukses', 'Data siswa ' . $request->nama_siswa . ' berhasil diperbarui!');
    }

    // Hapus Data Siswa oleh Admin
    public function destroy(Request $request, $id)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $querySiswa = DB::table('siswa')->where('id', $id);
        if ($adminCabang) {
            $querySiswa->where('id_cabang', $adminCabang);
        }
        $siswa = $querySiswa->first();

        if (!$siswa) {
            return redirect()->route('admin.siswa.index')->withErrors(['msg' => 'Data siswa tidak ditemukan atau bukan milik cabang Anda.']);
        }

        $namaSiswa = $siswa->nama;
        $parentId  = $siswa->id_parents;

        DB::transaction(function () use ($siswa, $id, $parentId) {
            // Hapus file foto jika ada
            if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                @unlink(public_path($siswa->foto));
            }

            // Hapus absensi siswa
            DB::table('absensi_siswa')->where('id_siswa', $id)->delete();

            // Hapus pencapaian siswa
            DB::table('pencapaian_siswa')->where('id_siswa', $id)->delete();

            // Hapus data siswa
            DB::table('siswa')->where('id', $id)->delete();

            // Otomatis hapus akun orang tua jika tidak ada anak lain
            if ($parentId) {
                // Periksa apakah orang tua ini masih memiliki data anak lain yang terdaftar aktif
                $anakLain = DB::table('siswa')->where('id_parents', $parentId)->count();
                if ($anakLain === 0) {
                    $parent = DB::table('parents')->where('id', $parentId)->first();
                    if ($parent) {
                        $idUserParent = $parent->id_user;
                        $userParent = $idUserParent ? DB::table('users')->where('id', $idUserParent)->first() : null;

                        // Hapus ulasan dari orang tua ini jika ada
                        DB::table('ulasan_club')->where('id_parents', $parentId)->delete();
                        DB::table('ulasan_pelatih')->where('id_parents', $parentId)->delete();

                        // Hapus data orang tua di tabel parents
                        DB::table('parents')->where('id', $parentId)->delete();

                        // Hapus akun user orang tua di tabel users
                        if ($idUserParent) {
                            DB::table('users')->where('id', $idUserParent)->where('role', 'parents')->delete();
                        }

                        // Bersihkan pendaftaran baru terkait jika ada
                        if ($userParent && $userParent->email) {
                            DB::table('pendaftaran_baru')->where('email', $userParent->email)->delete();
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.siswa.index')->with('sukses', 'Data siswa ' . $namaSiswa . ' beserta akun orang tua terkait berhasil dihapus dari sistem.');
    }
}
