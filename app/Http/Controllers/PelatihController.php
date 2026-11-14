<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PelatihController extends Controller
{
    /**
     * Helper untuk mendapatkan pelatih dan cabang yang dibina/aktif
     */
    private function getPelatihAndCabang()
    {
        $user = Auth::user();
        $pelatih = DB::table('pelatih')->where('id_user', $user->id ?? 0)->first();
        $pelatihId = $pelatih->id ?? 1;

        // Ambil daftar cabang yang dibina oleh pelatih ini
        $cabangPelatihList = DB::table('cabang_pelatih')
            ->join('cabang', 'cabang_pelatih.id_cabang', '=', 'cabang.id')
            ->where('cabang_pelatih.id_pelatih', $pelatihId)
            ->select('cabang.id', 'cabang.nama')
            ->orderBy('cabang.id', 'asc')
            ->get();

        // Fallback jika belum ada relasi di cabang_pelatih
        if ($cabangPelatihList->isEmpty()) {
            $defaultCabang = DB::table('cabang')->orderBy('id', 'asc')->first();
            if ($defaultCabang) {
                $cabangPelatihList = collect([$defaultCabang]);
            }
        }

        // Ambil id cabang dari session jika valid untuk pelatih ini
        $sessionCabangId = session('pelatih_id_cabang');
        $validCabang = $cabangPelatihList->firstWhere('id', $sessionCabangId);

        if (!$validCabang) {
            $validCabang = $cabangPelatihList->first();
            if ($validCabang) {
                session(['pelatih_id_cabang' => $validCabang->id]);
            }
        }

        $idCabang = $validCabang->id ?? 1;
        $namaCabang = $validCabang->nama ?? 'Gajah Depa Akuatik Sumedang';

        return [
            'pelatih'           => $pelatih,
            'pelatihId'         => $pelatihId,
            'cabangPelatihList' => $cabangPelatihList,
            'idCabang'          => $idCabang,
            'namaCabang'        => $namaCabang,
        ];
    }

    /**
     * Switch Cabang Aktif untuk Pelatih
     */
    public function switchCabang(Request $request)
    {
        $data = $this->getPelatihAndCabang();
        $cabangPelatihList = $data['cabangPelatihList'];

        $idCabang = (int) $request->input('id_cabang');
        $selectedCabang = $cabangPelatihList->firstWhere('id', $idCabang);

        if ($selectedCabang) {
            session(['pelatih_id_cabang' => $idCabang]);
            return redirect()->back()->with('success', "Berhasil beralih ke cabang {$selectedCabang->nama}.");
        }

        return redirect()->back()->with('error', 'Anda tidak terdaftar melatih di cabang tersebut.');
    }

    /**
     * Helper untuk menghitung Best Member of the Month per Cabang
     */
    private function getBestMemberForCabang($idCabang, $tahun, $bulan, $namaCabang = 'Gajah Depa')
    {
        $kandidatSiswa = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->where('siswa.id_cabang', $idCabang)
            ->select(
                'siswa.id',
                'siswa.nama',
                'siswa.foto',
                'siswa.tingkat_kelas',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang'
            )
            ->get();

        if ($kandidatSiswa->isEmpty()) {
            return (object)[
                'id'          => 1,
                'nama'        => 'Belum Ada Siswa',
                'foto'        => null,
                'nama_kelas'  => 'Pemula A',
                'nama_cabang' => $namaCabang,
                'avg_score'   => 0,
                'progres_pct' => 0,
                'total_hadir' => 0,
            ];
        }

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
        $rankedKandidat = $kandidatSiswa->map(function ($k) use ($hitungStatBulanan, $tahun, $bulan, $riwayatBestMemberCount, $namaCabang) {
            $stat = $hitungStatBulanan($k->id, $tahun, $bulan);
            $k->total_hadir = $stat['total_hadir'];
            $k->avg_score   = $stat['avg_score'];
            $k->progres_pct = $stat['progres_pct'];
            $k->skor_utama  = $stat['skor_utama'];
            $k->pernah_bm   = $riwayatBestMemberCount[$k->id] ?? 0;
            $k->nama_cabang = $k->nama_cabang ?? $namaCabang;
            $k->nama_kelas  = $k->nama_kelas ?? $k->tingkat_kelas ?? 'Pemula A';
            return $k;
        })->sort(function ($a, $b) {
            if ($a->skor_utama !== $b->skor_utama) {
                return $b->skor_utama <=> $a->skor_utama;
            }
            $aBelumPernah = $a->pernah_bm === 0 ? 1 : 0;
            $bBelumPernah = $b->pernah_bm === 0 ? 1 : 0;
            if ($aBelumPernah !== $bBelumPernah) {
                return $bBelumPernah <=> $aBelumPernah;
            }
            if ($a->pernah_bm !== $b->pernah_bm) {
                return $a->pernah_bm <=> $b->pernah_bm;
            }
            return strcasecmp($a->nama, $b->nama);
        })->values();

        // Jika Admin telah memilih Best Member secara manual di tabel best_swimmer
        if (\Illuminate\Support\Facades\Schema::hasTable('best_swimmer')) {
            $manualId = DB::table('best_swimmer')
                ->where('id_cabang', $idCabang)
                ->where('tahun', (int) $tahun)
                ->where('bulan', (int) $bulan)
                ->value('id_siswa');

            if ($manualId) {
                $manualWinner = $rankedKandidat->firstWhere('id', $manualId);
                if (!$manualWinner) {
                    $manualWinner = DB::table('siswa')
                        ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                        ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
                        ->where('siswa.id', $manualId)
                        ->select('siswa.*', 'kelas.nama as nama_kelas', 'cabang.nama as nama_cabang')
                        ->first();
                }
                if ($manualWinner) {
                    return $manualWinner;
                }
            }
        }

        // Jika belum ada pemenang yang ditetapkan untuk bulan ini, kosongkan
        return null;
    }

    /**
     * Dashboard Pelatih
     */
    public function dashboard(Request $request)
    {
        $data = $this->getPelatihAndCabang();
        $pelatihId          = $data['pelatihId'];
        $cabangPelatihList  = $data['cabangPelatihList'];
        $idCabang           = $data['idCabang'];
        $namaCabang         = $data['namaCabang'];

        $latestDate = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->orderBy('absensi_siswa.tanggal_kehadiran', 'desc')
            ->value('absensi_siswa.tanggal_kehadiran');

        $tanggal = $request->input('tanggal');

        if ($tanggal) {
            $carbonTgl = Carbon::parse($tanggal);
            $bulan = $carbonTgl->format('m');
            $tahun = $carbonTgl->format('Y');
        } else {
            $defaultBulan = $latestDate ? Carbon::parse($latestDate)->format('m') : date('m');
            $defaultTahun = $latestDate ? Carbon::parse($latestDate)->format('Y') : date('Y');

            $bulan = $request->input('bulan', $defaultBulan);
            $tahun = $request->input('tahun', $defaultTahun);
        }

        // Metric 1: Total Siswa di Cabang ini
        $totalSiswa = DB::table('siswa')->where('id_cabang', $idCabang)->count();
        $totalSiswaAktif = $totalSiswa;

        // Metric 2: Total Kehadiran Pelatih (Saya)
        $absensiQuery = DB::table('absensi_pelatih')
            ->where('id_pelatih', $pelatihId);

        $totalHadir  = (clone $absensiQuery)->where('status_kehadiran', 'hadir')->count();
        $totalRecord = (clone $absensiQuery)->count();
        $totalIzin   = (clone $absensiQuery)->where('status_kehadiran', 'izin')->count();
        $totalSakit  = (clone $absensiQuery)->where('status_kehadiran', 'sakit')->count();

        // Metric 3: Rating Saya
        $ulasanQuery = DB::table('ulasan_pelatih')->where('id_pelatih', $pelatihId);
        $totalUlasan = (clone $ulasanQuery)->count();
        $avgRating   = $totalUlasan > 0 ? round((clone $ulasanQuery)->avg('bintang_rating'), 1) : 0;

        // Grafik Kehadiran Siswa di Cabang ini
        $chartQuery = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->whereYear('absensi_siswa.tanggal_kehadiran', $tahun)
            ->whereMonth('absensi_siswa.tanggal_kehadiran', $bulan);

        if ($tanggal) {
            $chartQuery->whereDate('absensi_siswa.tanggal_kehadiran', $tanggal);
        }

        $datesGrouped = $chartQuery
            ->select('tanggal_kehadiran', 'status_kehadiran', DB::raw('count(*) as count'))
            ->groupBy('tanggal_kehadiran', 'status_kehadiran')
            ->orderBy('tanggal_kehadiran', 'asc')
            ->get();

        $chartDates = [];
        $chartHadir = [];
        $chartAbsen = [];
        $temp = [];

        foreach ($datesGrouped as $row) {
            $tgl = Carbon::parse($row->tanggal_kehadiran)->format('d M');
            if (!isset($temp[$tgl])) {
                $temp[$tgl] = ['hadir' => 0, 'absen' => 0];
            }
            if ($row->status_kehadiran === 'hadir') {
                $temp[$tgl]['hadir'] += $row->count;
            } else {
                $temp[$tgl]['absen'] += $row->count;
            }
        }

        foreach ($temp as $tgl => $c) {
            $chartDates[] = $tgl;
            $chartHadir[] = $c['hadir'];
            $chartAbsen[] = $c['absen'];
        }

        // 1. Data Siswa untuk Dashboard (Ringkasan 3 Siswa)
        $dbSiswa = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->where('siswa.id_cabang', $idCabang)
            ->select('siswa.*', 'kelas.nama as nama_kelas')
            ->orderBy('siswa.id', 'asc')
            ->limit(3)
            ->get();

        $recentSiswa = collect($dbSiswa);
        if ($recentSiswa->count() < 3) {
            $defaultSiswa = [
                (object)['nama' => 'Ahmad Rizki', 'tingkat_kelas' => 'Pemula A', 'status' => 'Aktif'],
                (object)['nama' => 'Sari Dewi', 'tingkat_kelas' => 'Menengah A', 'status' => 'Aktif'],
                (object)['nama' => 'Reza Kurniawan', 'tingkat_kelas' => 'Lanjutan A', 'status' => 'Aktif'],
            ];
            foreach ($defaultSiswa as $ds) {
                if ($recentSiswa->count() >= 3) break;
                if (!$recentSiswa->contains('nama', $ds->nama)) {
                    $recentSiswa->push($ds);
                }
            }
        }

        // 2. Data Ulasan Saya (Ringkasan 3 Ulasan)
        $dbUlasanSaya = DB::table('ulasan_pelatih')
            ->leftJoin('parents', 'ulasan_pelatih.id_parents', '=', 'parents.id')
            ->leftJoin('users', 'parents.id_user', '=', 'users.id')
            ->leftJoin('siswa', 'siswa.id_parents', '=', 'parents.id')
            ->where('ulasan_pelatih.id_pelatih', $pelatihId)
            ->select(
                'ulasan_pelatih.*',
                'users.nama as nama_parent',
                'siswa.nama as nama_siswa'
            )
            ->orderBy('ulasan_pelatih.created_at', 'desc')
            ->limit(3)
            ->get();

        $recentUlasanSaya = collect($dbUlasanSaya);
        if ($recentUlasanSaya->count() < 3) {
            $defaultUlasanSaya = [
                (object)[
                    'nama_parent' => 'Hendra Rizki',
                    'nama_siswa' => 'Ahmad Rizki',
                    'bintang_rating' => 5,
                    'komentar_rating' => 'Pelatih sangat sabar dan profesional. Anak saya sangat cepat berkembang.',
                ],
                (object)[
                    'nama_parent' => 'Dewi Lestari',
                    'nama_siswa' => 'Sari Dewi',
                    'bintang_rating' => 4,
                    'komentar_rating' => 'Metode pengajaran bagus, komunikasi dengan orang tua juga sangat responsif.',
                ],
                (object)[
                    'nama_parent' => 'Agus Salim',
                    'nama_siswa' => 'Siti Nurhaliza',
                    'bintang_rating' => 5,
                    'komentar_rating' => 'Profesional dan peduli. Anak kami sangat senang latihan bersama.',
                ],
            ];
            foreach ($defaultUlasanSaya as $dus) {
                if ($recentUlasanSaya->count() >= 3) break;
                $recentUlasanSaya->push($dus);
            }
        }

        // 3. Data Ulasan Club (Ringkasan 3 Ulasan)
        $dbUlasanClub = DB::table('ulasan_club')
            ->leftJoin('parents', 'ulasan_club.id_parents', '=', 'parents.id')
            ->leftJoin('users', 'parents.id_user', '=', 'users.id')
            ->where('ulasan_club.id_cabang', $idCabang)
            ->select(
                'ulasan_club.*',
                'users.nama as nama_parent'
            )
            ->orderBy('ulasan_club.created_at', 'desc')
            ->limit(3)
            ->get();

        $recentUlasanClub = collect($dbUlasanClub);
        if ($recentUlasanClub->count() < 3) {
            $defaultUlasanClub = [
                (object)[
                    'nama_parent' => 'Hendra Rizki',
                    'kategori' => 'Fasilitas',
                    'bintang_rating' => 5,
                    'komentar_rating' => 'Fasilitas kolam sangat bersih dan terawat. Jadwal latihan juga sangat fleksibel.',
                ],
                (object)[
                    'nama_parent' => 'Agus Salim',
                    'kategori' => 'Manajemen',
                    'bintang_rating' => 4,
                    'komentar_rating' => 'Manajemen club cukup baik, komunikasi dengan orang tua cukup responsif.',
                ],
                (object)[
                    'nama_parent' => 'Wati Pratama',
                    'kategori' => 'Program',
                    'bintang_rating' => 5,
                    'komentar_rating' => 'Program latihan terstruktur dengan baik. Anak kami maju dengan pesat.',
                ],
            ];
            foreach ($defaultUlasanClub as $duc) {
                if ($recentUlasanClub->count() >= 3) break;
                $recentUlasanClub->push($duc);
            }
        }

        $dbYearsAbsensi = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->whereNotNull('absensi_siswa.tanggal_kehadiran')
            ->selectRaw('DISTINCT YEAR(absensi_siswa.tanggal_kehadiran) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $listTahun = array_values(array_unique($dbYearsAbsensi));
        if (empty($listTahun)) {
            $listTahun = [(string)date('Y')];
        }
        rsort($listTahun);

        // Best Member of the Month untuk Cabang Aktif
        $bestMember = $this->getBestMemberForCabang($idCabang, $tahun, $bulan, $namaCabang);

        $listNamaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $namaBulan = $listNamaBulan[sprintf('%02d', (int)$bulan)] ?? 'Bulan Ini';

        return view('dashboard.pelatih', compact(
            'cabangPelatihList',
            'idCabang',
            'namaCabang',
            'totalSiswa',
            'totalSiswaAktif',
            'totalHadir',
            'totalRecord',
            'totalIzin',
            'totalSakit',
            'avgRating',
            'totalUlasan',
            'chartDates',
            'chartHadir',
            'chartAbsen',
            'bulan',
            'tahun',
            'tanggal',
            'recentSiswa',
            'recentUlasanSaya',
            'recentUlasanClub',
            'listTahun',
            'bestMember',
            'namaBulan'
        ));
    }

    /**
     * Halaman Absensi Kehadiran Pelatih (Riwayat saya)
     */
    public function absensi(Request $request)
    {
        $data = $this->getPelatihAndCabang();
        $pelatihId          = $data['pelatihId'];
        $cabangPelatihList  = $data['cabangPelatihList'];
        $idCabang           = $data['idCabang'];
        $namaCabang         = $data['namaCabang'];

        $tanggal = $request->input('tanggal');

        $latestDate = DB::table('absensi_pelatih')
            ->where('id_pelatih', $pelatihId)
            ->orderBy('tanggal_kehadiran', 'desc')
            ->value('tanggal_kehadiran');

        if ($tanggal) {
            $carbonTgl = Carbon::parse($tanggal);
            $bulan = $carbonTgl->format('m');
            $tahun = $carbonTgl->format('Y');
        } else {
            $defaultBulan = $latestDate ? Carbon::parse($latestDate)->format('m') : date('m');
            $defaultTahun = $latestDate ? Carbon::parse($latestDate)->format('Y') : date('Y');

            $bulan = $request->input('bulan', $defaultBulan);
            $tahun = $request->input('tahun', $defaultTahun);
        }

        $absensiQuery = DB::table('absensi_pelatih')
            ->where('id_pelatih', $pelatihId)
            ->whereYear('tanggal_kehadiran', $tahun)
            ->whereMonth('tanggal_kehadiran', $bulan);

        $tableQuery = (clone $absensiQuery);
        if ($tanggal) {
            $tableQuery->whereDate('tanggal_kehadiran', $tanggal);
        }

        $absensiList = $tableQuery
            ->orderBy('tanggal_kehadiran', 'desc')
            ->get();

        $totalHadir = (clone $absensiQuery)->where('status_kehadiran', 'hadir')->count();
        $totalIzin  = (clone $absensiQuery)->where('status_kehadiran', 'izin')->count();
        $totalSakit = (clone $absensiQuery)->where('status_kehadiran', 'sakit')->count();

        $recordsAsc = (clone $absensiQuery)
            ->orderBy('tanggal_kehadiran', 'asc')
            ->get();

        $chartLabels = [];
        $chartData   = [];
        $cumulativeHadir = 0;

        foreach ($recordsAsc as $record) {
            $tglFormatted = Carbon::parse($record->tanggal_kehadiran)->translatedFormat('d M');
            if ($record->status_kehadiran === 'hadir') {
                $cumulativeHadir++;
            }
            $chartLabels[] = $tglFormatted;
            $chartData[]   = $cumulativeHadir;
        }

        $allAttendanceRecords = DB::table('absensi_pelatih')
            ->where('id_pelatih', $pelatihId)
            ->orderBy('tanggal_kehadiran', 'asc')
            ->get(['tanggal_kehadiran', 'status_kehadiran']);

        $chartRange = $request->input('chart_range', 'bulan');
        $chartStart = $request->input('chart_start');
        $chartEnd   = $request->input('chart_end');

        $dbYearsPelatih = DB::table('absensi_pelatih')
            ->where('id_pelatih', $pelatihId)
            ->whereNotNull('tanggal_kehadiran')
            ->selectRaw('DISTINCT YEAR(tanggal_kehadiran) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $listTahun = array_values(array_unique($dbYearsPelatih));
        if (empty($listTahun)) {
            $listTahun = [(string)date('Y')];
        }
        rsort($listTahun);

        return view('pelatih.absensi', compact(
            'absensiList',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'chartLabels',
            'chartData',
            'bulan',
            'tahun',
            'tanggal',
            'namaCabang',
            'cabangPelatihList',
            'idCabang',
            'allAttendanceRecords',
            'chartRange',
            'chartStart',
            'chartEnd',
            'listTahun'
        ));
    }

    /**
     * Halaman Siswa Pelatih (Tab 1: Data Siswa, Tab 2: Absensi Siswa, Tab 3: Penilaian Siswa)
     */
    public function siswa(Request $request)
    {
        $data = $this->getPelatihAndCabang();
        $pelatihId          = $data['pelatihId'];
        $cabangPelatihList  = $data['cabangPelatihList'];
        $idCabang           = $data['idCabang'];
        $namaCabang         = $data['namaCabang'];

        $activeTab       = $request->input('tab', 'data_siswa');
        $tanggal         = $request->input('tanggal');
        $search          = $request->input('search');
        $searchAbsensi   = $request->input('search_absensi');
        $searchPenilaian = $request->input('search_penilaian');

        $latestDate = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->orderBy('absensi_siswa.tanggal_kehadiran', 'desc')
            ->value('absensi_siswa.tanggal_kehadiran');

        if ($tanggal) {
            $carbonTgl = Carbon::parse($tanggal);
            $bulan = $carbonTgl->format('m');
            $tahun = $carbonTgl->format('Y');
        } else {
            $defaultBulan = $latestDate ? Carbon::parse($latestDate)->format('m') : date('m');
            $defaultTahun = $latestDate ? Carbon::parse($latestDate)->format('Y') : date('Y');

            $bulan = $request->input('bulan', $defaultBulan);
            $tahun = $request->input('tahun', $defaultTahun);
        }

        $selectedKelasId = $request->input('id_kelas');

        // Master Kelas di Cabang ini (Urutan logis: Pemula A, Pemula B, Lanjutan, Senior)
        $kelasList = DB::table('kelas')
            ->where('id_cabang', $idCabang)
            ->orderByRaw("FIELD(nama, 'Kelas Pemula A', 'Kelas Pemula B', 'Kelas Lanjutan', 'Kelas Senior', 'Kelas Pemula', 'Kelas Prestasi')")
            ->orderBy('id', 'asc')
            ->get();

        // Validasi jika kelas yang dipilih tidak ada pada cabang aktif ini
        if ($selectedKelasId && $selectedKelasId !== 'semua' && !$kelasList->contains('id', (int) $selectedKelasId)) {
            $selectedKelasId = null;
        }

        // 1. Data Siswa
        $siswaQuery = DB::table('siswa')
            ->leftJoin('parents', 'siswa.id_parents', '=', 'parents.id')
            ->leftJoin('users', 'parents.id_user', '=', 'users.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
            ->select(
                'siswa.*',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang',
                'users.nama as nama_parent',
                'users.email as email_parent',
                'users.no_hp as no_hp_parent',
                'parents.alamat as alamat_parent'
            )
            ->where('siswa.id_cabang', $idCabang)
            ->orderBy('siswa.nama', 'asc');

        // Filter berdasarkan pencarian nama siswa
        if ($search) {
            $siswaQuery->where('siswa.nama', 'like', '%' . $search . '%');
        }

        // Semua siswa cabang (untuk modal pilihan per kelas)
        $allSiswaList = (clone $siswaQuery)->get();

        // Filter berdasarkan kelas jika dipilih di halaman
        if ($selectedKelasId && $selectedKelasId !== 'semua') {
            $siswaQuery->where('siswa.id_kelas', $selectedKelasId);
        }
        $siswaList = $siswaQuery->get();

        // 2. Tab Absensi Siswa
        $absensiQuery = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->select(
                'absensi_siswa.*',
                'siswa.nama as nama_siswa',
                'siswa.id_kelas',
                'kelas.nama as nama_kelas',
                DB::raw('(SELECT COUNT(*) FROM pencapaian_siswa WHERE pencapaian_siswa.id_siswa = absensi_siswa.id_siswa AND (DATE(pencapaian_siswa.tanggal_catat) = absensi_siswa.tanggal_kehadiran OR DATE(pencapaian_siswa.created_at) = absensi_siswa.tanggal_kehadiran)) as jumlah_penilaian')
            )
            ->where('siswa.id_cabang', $idCabang)
            ->whereYear('absensi_siswa.tanggal_kehadiran', $tahun)
            ->whereMonth('absensi_siswa.tanggal_kehadiran', $bulan);

        if ($tanggal) {
            $absensiQuery->whereDate('absensi_siswa.tanggal_kehadiran', $tanggal);
        }

        if ($selectedKelasId && $selectedKelasId !== 'semua') {
            $absensiQuery->where('siswa.id_kelas', $selectedKelasId);
        }

        if ($searchAbsensi) {
            $kw = trim($searchAbsensi);
            $absensiQuery->where(function ($q) use ($kw) {
                $q->where('siswa.nama', 'like', "%{$kw}%")
                  ->orWhere('kelas.nama', 'like', "%{$kw}%")
                  ->orWhere('absensi_siswa.status_kehadiran', 'like', "%{$kw}%")
                  ->orWhere('absensi_siswa.keterangan', 'like', "%{$kw}%");
            });
        }

        $absensiSiswaList = $absensiQuery
            ->orderBy('absensi_siswa.tanggal_kehadiran', 'desc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('siswa.nama', 'asc')
            ->get();

        // Data Grafik Absensi Siswa
        $chartQuery = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->whereYear('absensi_siswa.tanggal_kehadiran', $tahun)
            ->whereMonth('absensi_siswa.tanggal_kehadiran', $bulan);

        if ($selectedKelasId && $selectedKelasId !== 'semua') {
            $chartQuery->where('siswa.id_kelas', $selectedKelasId);
        }

        if ($tanggal) {
            $chartQuery->whereDate('absensi_siswa.tanggal_kehadiran', $tanggal);
        }

        $datesGrouped = $chartQuery
            ->select('tanggal_kehadiran', 'status_kehadiran', DB::raw('count(*) as count'))
            ->groupBy('tanggal_kehadiran', 'status_kehadiran')
            ->orderBy('tanggal_kehadiran', 'asc')
            ->get();

        $absensiChartDates  = [];
        $absensiChartHadir  = [];
        $absensiChartAbsen  = [];

        $tempDates = [];
        foreach ($datesGrouped as $row) {
            $tgl = Carbon::parse($row->tanggal_kehadiran)->format('d M');
            if (!isset($tempDates[$tgl])) {
                $tempDates[$tgl] = ['hadir' => 0, 'absen' => 0];
            }
            if ($row->status_kehadiran === 'hadir') {
                $tempDates[$tgl]['hadir'] += $row->count;
            } else {
                $tempDates[$tgl]['absen'] += $row->count;
            }
        }

        foreach ($tempDates as $tgl => $counts) {
            $absensiChartDates[] = $tgl;
            $absensiChartHadir[] = $counts['hadir'];
            $absensiChartAbsen[] = $counts['absen'];
        }

        // 3. Tab Penilaian Siswa
        $penilaianQuery = DB::table('pencapaian_siswa')
            ->join('siswa', 'pencapaian_siswa.id_siswa', '=', 'siswa.id')
            ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('pelatih', 'pencapaian_siswa.id_pelatih', '=', 'pelatih.id')
            ->leftJoin('users as user_pelatih', 'pelatih.id_user', '=', 'user_pelatih.id')
            ->select(
                'pencapaian_siswa.*',
                'siswa.nama as nama_siswa',
                'siswa.id_kelas',
                'kelas.nama as nama_kelas',
                'user_pelatih.nama as nama_pelatih'
            )
            ->where('siswa.id_cabang', $idCabang);

        if ($selectedKelasId && $selectedKelasId !== 'semua') {
            $penilaianQuery->where('siswa.id_kelas', $selectedKelasId);
        }

        if ($searchPenilaian) {
            $kwPen = trim($searchPenilaian);
            $penilaianQuery->where(function ($q) use ($kwPen) {
                $q->where('siswa.nama', 'like', "%{$kwPen}%")
                  ->orWhere('kelas.nama', 'like', "%{$kwPen}%")
                  ->orWhere('pencapaian_siswa.gaya_renang', 'like', "%{$kwPen}%")
                  ->orWhere('pencapaian_siswa.catatan', 'like', "%{$kwPen}%");
            });
        }

        $penilaianList = $penilaianQuery
            ->orderBy('pencapaian_siswa.tanggal_catat', 'desc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('siswa.nama', 'asc')
            ->get();

        // Data absensi cabang untuk validasi siswa yang sudah absen per tanggal
        $semuaAbsensi = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->select('absensi_siswa.id_siswa', 'absensi_siswa.tanggal_kehadiran', 'absensi_siswa.status_kehadiran')
            ->get();

        $absensiMap = [];
        foreach ($semuaAbsensi as $abs) {
            $tgl = Carbon::parse($abs->tanggal_kehadiran)->format('Y-m-d');
            $absensiMap[$tgl][$abs->id_siswa] = $abs->status_kehadiran;
        }

        // Tanggal absensi terbaru yang memiliki siswa hadir di cabang ini
        $latestHadirDate = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->where('absensi_siswa.status_kehadiran', 'hadir')
            ->orderBy('absensi_siswa.tanggal_kehadiran', 'desc')
            ->value('absensi_siswa.tanggal_kehadiran');

        // Riwayat Absensi & Pencapaian per Siswa (untuk modal detail siswa seperti di Admin)
        $absensi_per_siswa = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->select('absensi_siswa.id_siswa', 'absensi_siswa.tanggal_kehadiran', 'absensi_siswa.status_kehadiran', 'absensi_siswa.keterangan')
            ->orderBy('absensi_siswa.tanggal_kehadiran', 'desc')
            ->get()
            ->groupBy('id_siswa');

        $pencapaian_per_siswa = DB::table('pencapaian_siswa')
            ->join('siswa', 'pencapaian_siswa.id_siswa', '=', 'siswa.id')
            ->leftJoin('pelatih', 'pencapaian_siswa.id_pelatih', '=', 'pelatih.id')
            ->leftJoin('users as user_pelatih', 'pelatih.id_user', '=', 'user_pelatih.id')
            ->where('siswa.id_cabang', $idCabang)
            ->select('pencapaian_siswa.id_siswa', 'pencapaian_siswa.gaya_renang', 'pencapaian_siswa.catatan_waktu', 'pencapaian_siswa.teknik', 'pencapaian_siswa.kecepatan', 'pencapaian_siswa.ketahanan', 'pencapaian_siswa.catatan', 'pencapaian_siswa.kejuaraan', 'pencapaian_siswa.tanggal_catat', 'user_pelatih.nama as nama_pelatih')
            ->orderBy('pencapaian_siswa.tanggal_catat', 'desc')
            ->get()
            ->groupBy('id_siswa');

        $dbYearsAbsensi = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->whereNotNull('absensi_siswa.tanggal_kehadiran')
            ->selectRaw('DISTINCT YEAR(absensi_siswa.tanggal_kehadiran) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $dbYearsPencapaian = DB::table('pencapaian_siswa')
            ->join('siswa', 'pencapaian_siswa.id_siswa', '=', 'siswa.id')
            ->where('siswa.id_cabang', $idCabang)
            ->whereNotNull('pencapaian_siswa.tanggal_catat')
            ->selectRaw('DISTINCT YEAR(pencapaian_siswa.tanggal_catat) as yr')
            ->pluck('yr')->map(fn($y) => (string)$y)->toArray();
        $listTahun = array_values(array_unique(array_merge($dbYearsAbsensi, $dbYearsPencapaian)));
        if (empty($listTahun)) {
            $listTahun = [(string)date('Y')];
        }
        rsort($listTahun);

        return view('pelatih.siswa', compact(
            'pelatihId',
            'activeTab',
            'namaCabang',
            'kelasList',
            'selectedKelasId',
            'allSiswaList',
            'siswaList',
            'absensiSiswaList',
            'absensiChartDates',
            'absensiChartHadir',
            'absensiChartAbsen',
            'penilaianList',
            'bulan',
            'tahun',
            'tanggal',
            'absensiMap',
            'latestHadirDate',
            'cabangPelatihList',
            'idCabang',
            'search',
            'searchAbsensi',
            'searchPenilaian',
            'absensi_per_siswa',
            'pencapaian_per_siswa',
            'listTahun'
        ));
    }

    /**
     * Halaman Penilaian Pelatih & Club oleh Orang Tua (Rating & Ulasan)
     */
    public function penilaian(Request $request)
    {
        $data = $this->getPelatihAndCabang();
        $pelatihId          = $data['pelatihId'];
        $cabangPelatihList  = $data['cabangPelatihList'];
        $idCabang           = $data['idCabang'];
        $namaCabang         = $data['namaCabang'];

        $activeTab = $request->input('tab', 'penilaian_saya');

        if ($activeTab === 'penilaian_club') {
            // Data ulasan club untuk cabang yang aktif
            $reviewsQuery = DB::table('ulasan_club')
                ->leftJoin('parents', 'ulasan_club.id_parents', '=', 'parents.id')
                ->leftJoin('users', 'parents.id_user', '=', 'users.id')
                ->where('ulasan_club.id_cabang', $idCabang)
                ->select(
                    'ulasan_club.*',
                    'users.nama as nama_parent'
                );

            $reviews = (clone $reviewsQuery)->orderBy('ulasan_club.created_at', 'desc')->get();
            $totalUlasan = (clone $reviewsQuery)->count();
            $avgRating = $totalUlasan > 0 ? round((clone $reviewsQuery)->avg('bintang_rating'), 1) : 0;
            $positiveCount = (clone $reviewsQuery)->where('bintang_rating', '>=', 4)->count();

            // Distribusi Rating (5 s/d 1)
            $distribusi = [
                5 => (clone $reviewsQuery)->where('bintang_rating', 5)->count(),
                4 => (clone $reviewsQuery)->where('bintang_rating', 4)->count(),
                3 => (clone $reviewsQuery)->where('bintang_rating', 3)->count(),
                2 => (clone $reviewsQuery)->where('bintang_rating', 2)->count(),
                1 => (clone $reviewsQuery)->where('bintang_rating', 1)->count(),
            ];
        } else {
            // Data ulasan pelatih (Penilaian Saya)
            $reviewsQuery = DB::table('ulasan_pelatih')
                ->leftJoin('parents', 'ulasan_pelatih.id_parents', '=', 'parents.id')
                ->leftJoin('users', 'parents.id_user', '=', 'users.id')
                ->leftJoin('siswa', 'siswa.id_parents', '=', 'parents.id')
                ->where('ulasan_pelatih.id_pelatih', $pelatihId)
                ->select(
                    'ulasan_pelatih.*',
                    'users.nama as nama_parent',
                    'siswa.nama as nama_siswa'
                );

            $reviews = (clone $reviewsQuery)->orderBy('ulasan_pelatih.created_at', 'desc')->get();
            $totalUlasan = (clone $reviewsQuery)->count();
            $avgRating = $totalUlasan > 0 ? round((clone $reviewsQuery)->avg('bintang_rating'), 1) : 0;
            $positiveCount = (clone $reviewsQuery)->where('bintang_rating', '>=', 4)->count();

            // Distribusi Rating (5 s/d 1)
            $distribusi = [
                5 => (clone $reviewsQuery)->where('bintang_rating', 5)->count(),
                4 => (clone $reviewsQuery)->where('bintang_rating', 4)->count(),
                3 => (clone $reviewsQuery)->where('bintang_rating', 3)->count(),
                2 => (clone $reviewsQuery)->where('bintang_rating', 2)->count(),
                1 => (clone $reviewsQuery)->where('bintang_rating', 1)->count(),
            ];
        }

        return view('pelatih.penilaian', compact(
            'activeTab',
            'namaCabang',
            'reviews',
            'avgRating',
            'totalUlasan',
            'positiveCount',
            'distribusi',
            'cabangPelatihList',
            'idCabang'
        ));
    }

    /**
     * Simpan Absensi Siswa per Kelas
     */
    public function storeAbsensiSiswa(Request $request)
    {
        $request->validate([
            'tanggal'          => 'required|date',
            'id_kelas'         => 'required|exists:kelas,id',
            'status_kehadiran' => 'required|array',
        ]);

        $tanggal = $request->tanggal;
        $idKelas = $request->id_kelas;

        foreach ($request->status_kehadiran as $idSiswa => $status) {
            $keterangan = $request->keterangan[$idSiswa] ?? null;

            DB::table('absensi_siswa')->updateOrInsert(
                [
                    'tanggal_kehadiran' => $tanggal,
                    'id_siswa'          => $idSiswa,
                ],
                [
                    'status_kehadiran'  => $status,
                    'keterangan'        => $keterangan,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]
            );
        }

        $carbonTgl = Carbon::parse($tanggal);
        $namaKelas = DB::table('kelas')->where('id', $idKelas)->value('nama') ?? 'Kelas';

        return redirect()->route('pelatih.siswa', [
            'tab'      => 'absensi_siswa',
            'id_kelas' => $idKelas,
            'bulan'    => $carbonTgl->format('m'),
            'tahun'    => $carbonTgl->format('Y'),
        ])->with('success', "Absensi siswa {$namaKelas} ({$carbonTgl->translatedFormat('d F Y')}) berhasil disimpan.");
    }

    /**
     * Simpan Penilaian Siswa
     */
    public function storePenilaianSiswa(Request $request)
    {
        $request->validate([
            'id_siswa'    => 'required|exists:siswa,id',
            'tanggal'     => 'required|date',
            'gaya_renang' => 'required|string|max:100',
            'teknik'      => 'required|integer|min:1|max:5',
            'kecepatan'   => 'required|integer|min:1|max:5',
            'ketahanan'   => 'required|integer|min:1|max:5',
        ]);

        $tanggal = $request->tanggal;
        $idSiswa = $request->id_siswa;

        $siswa = DB::table('siswa')->where('id', $idSiswa)->first();
        $namaSiswa = $siswa->nama ?? 'Siswa';
        $idKelas = $siswa->id_kelas ?? null;
        $tglFormatted = Carbon::parse($tanggal)->translatedFormat('d F Y');

        // Cek validasi absensi: Siswa harus sudah diabsen dan berstatus 'hadir'
        $absensi = DB::table('absensi_siswa')
            ->where('id_siswa', $idSiswa)
            ->where('tanggal_kehadiran', $tanggal)
            ->first();

        if (!$absensi) {
            return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $idKelas])
                ->withInput()
                ->with('error', "Gagal menambah penilaian: Siswa {$namaSiswa} belum melakukan absensi pada tanggal {$tglFormatted}. Penilaian hanya dapat diberikan jika siswa telah absen.");
        }

        if ($absensi->status_kehadiran !== 'hadir') {
            $statusLabels = [
                'izin' => 'Izin',
                'sakit' => 'Sakit',
                'tidak_hadir' => 'Tidak Hadir'
            ];
            $statusStr = $statusLabels[$absensi->status_kehadiran] ?? ucfirst($absensi->status_kehadiran);

            return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $idKelas])
                ->withInput()
                ->with('error', "Gagal menambah penilaian: Siswa {$namaSiswa} tercatat '{$statusStr}' pada tanggal {$tglFormatted}. Penilaian hanya dapat diberikan kepada siswa yang hadir.");
        }

        $waktu = null;
        if ($request->filled('waktu_mm') || $request->filled('waktu_ss') || $request->filled('waktu_ms')) {
            $mm = str_pad($request->input('waktu_mm', '00'), 2, '0', STR_PAD_LEFT);
            $ss = str_pad($request->input('waktu_ss', '00'), 2, '0', STR_PAD_LEFT);
            $ms = str_pad($request->input('waktu_ms', '00'), 2, '0', STR_PAD_LEFT);
            $waktu = "$mm:$ss.$ms";
        } elseif ($request->filled('catatan_waktu')) {
            $waktu = $request->catatan_waktu;
        }

        $data = $this->getPelatihAndCabang();
        $pelatihId = $data['pelatihId'];

        DB::table('pencapaian_siswa')->insert([
            'id_siswa'       => $idSiswa,
            'id_pelatih'     => $pelatihId,
            'gaya_renang'    => $request->gaya_renang,
            'catatan_waktu'  => $waktu,
            'teknik'         => $request->teknik,
            'kecepatan'      => $request->kecepatan,
            'ketahanan'      => $request->ketahanan,
            'catatan'        => $request->catatan,
            'kejuaraan'      => $request->kejuaraan,
            'tanggal_catat'  => Carbon::parse($tanggal)->setTime(now()->hour, now()->minute, now()->second),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $idKelas])
            ->with('success', "Penilaian untuk {$namaSiswa} ({$tglFormatted}) berhasil ditambahkan.");
    }

    /**
     * Update Penilaian Siswa
     */
    public function updatePenilaianSiswa(Request $request, $id)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'gaya_renang' => 'required|string|max:100',
            'teknik'      => 'required|integer|min:1|max:5',
            'kecepatan'   => 'required|integer|min:1|max:5',
            'ketahanan'   => 'required|integer|min:1|max:5',
        ]);

        $penilaian = DB::table('pencapaian_siswa')->where('id', $id)->first();
        if (!$penilaian) {
            return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa'])
                ->with('error', 'Data penilaian tidak ditemukan.');
        }

        $data = $this->getPelatihAndCabang();
        $pelatihId = $data['pelatihId'];

        // Cek hak akses: hanya pelatih yang menilai yang dapat mengubah
        if (!empty($penilaian->id_pelatih) && (int)$penilaian->id_pelatih !== (int)$pelatihId) {
            $pembuat = DB::table('pelatih')
                ->join('users', 'pelatih.id_user', '=', 'users.id')
                ->where('pelatih.id', $penilaian->id_pelatih)
                ->value('users.nama') ?? 'pelatih lain';

            return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $request->input('filter_kelas', $penilaian->id_kelas ?? null)])
                ->with('error', "Akses Ditolak: Penilaian ini dinilai oleh {$pembuat}. Anda tidak dapat mengubah penilaian dari pelatih lain.");
        }

        $siswa = DB::table('siswa')->where('id', $penilaian->id_siswa)->first();
        $namaSiswa = $siswa->nama ?? 'Siswa';
        $idKelas = $siswa->id_kelas ?? null;

        $waktu = null;
        if ($request->filled('waktu_mm') || $request->filled('waktu_ss') || $request->filled('waktu_ms')) {
            $mm = str_pad($request->input('waktu_mm', '00'), 2, '0', STR_PAD_LEFT);
            $ss = str_pad($request->input('waktu_ss', '00'), 2, '0', STR_PAD_LEFT);
            $ms = str_pad($request->input('waktu_ms', '00'), 2, '0', STR_PAD_LEFT);
            $waktu = "$mm:$ss.$ms";
        } elseif ($request->filled('catatan_waktu')) {
            $waktu = $request->catatan_waktu;
        }

        DB::table('pencapaian_siswa')->where('id', $id)->update([
            'gaya_renang'   => $request->gaya_renang,
            'catatan_waktu' => $waktu,
            'teknik'        => $request->teknik,
            'kecepatan'     => $request->kecepatan,
            'ketahanan'     => $request->ketahanan,
            'catatan'       => $request->catatan,
            'tanggal_catat' => Carbon::parse($request->tanggal)->setTime(now()->hour, now()->minute, now()->second),
            'updated_at'    => now(),
        ]);

        return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $request->input('filter_kelas', $idKelas)])
            ->with('success', "Penilaian {$namaSiswa} berhasil diperbarui.");
    }

    /**
     * Hapus Penilaian Siswa
     */
    public function deletePenilaianSiswa(Request $request, $id)
    {
        $penilaian = DB::table('pencapaian_siswa')->where('id', $id)->first();
        if (!$penilaian) {
            return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa'])
                ->with('error', 'Data penilaian tidak ditemukan.');
        }

        $data = $this->getPelatihAndCabang();
        $pelatihId = $data['pelatihId'];

        // Cek hak akses: hanya pelatih yang menilai yang dapat menghapus
        if (!empty($penilaian->id_pelatih) && (int)$penilaian->id_pelatih !== (int)$pelatihId) {
            $pembuat = DB::table('pelatih')
                ->join('users', 'pelatih.id_user', '=', 'users.id')
                ->where('pelatih.id', $penilaian->id_pelatih)
                ->value('users.nama') ?? 'pelatih lain';

            return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $request->input('filter_kelas', $penilaian->id_kelas ?? null)])
                ->with('error', "Akses Ditolak: Penilaian ini dinilai oleh {$pembuat}. Anda tidak dapat menghapus penilaian dari pelatih lain.");
        }

        DB::table('pencapaian_siswa')->where('id', $id)->delete();

        return redirect()->route('pelatih.siswa', ['tab' => 'penilaian_siswa', 'id_kelas' => $request->input('filter_kelas', $idKelas)])
            ->with('success', "Penilaian {$namaSiswa} berhasil dihapus.");
    }

    /**
     * Halaman Pengaturan Profil Pelatih
     */
    public function pengaturan(Request $request)
    {
        $data = $this->getPelatihAndCabang();
        $pelatih            = $data['pelatih'];
        $pelatihId          = $data['pelatihId'];
        $cabangPelatihList  = $data['cabangPelatihList'];
        $idCabang           = $data['idCabang'];
        $namaCabang         = $data['namaCabang'];

        $user = Auth::user();
        $pelatihDetail = DB::table('pelatih')->where('id_user', $user->id)->first();

        return view('pelatih.pengaturan', compact(
            'user',
            'pelatih',
            'pelatihDetail',
            'cabangPelatihList',
            'idCabang',
            'namaCabang'
        ));
    }

    /**
     * Update Pengaturan Profil Pelatih
     */
    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'         => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'tempat_lahir'  => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'no_rek'        => 'nullable|string|max:100',
            'password'      => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.unique'       => 'Email tersebut sudah digunakan oleh akun lain.',
            'password.min'       => 'Kata sandi minimal harus 8 karakter.',
            'password.regex'     => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'foto.image'         => 'Foto harus berupa file gambar.',
            'foto.mimes'         => 'Format foto harus jpeg, png, jpg, atau webp.',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        $updateUserData = [
            'nama'          => $request->nama,
            'email'         => $request->email,
            'no_hp'         => $request->filled('no_hp') ? $request->no_hp : null,
            'jenis_kelamin' => $request->jenis_kelamin ?? $user->jenis_kelamin ?? 'laki-laki',
            'updated_at'    => now(),
        ];

        $newFotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'pelatih_' . time() . '_' . uniqid() . '.' . strtolower($file->getClientOriginalExtension());
            $destPath = public_path('uploads/pelatih');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $filename);

            $newFotoPath = 'uploads/pelatih/' . $filename;
            $updateUserData['foto'] = $newFotoPath;
        }

        if ($request->filled('password')) {
            $updateUserData['password'] = bcrypt($request->password);
        }

        $fotosToDelete = [];

        DB::transaction(function () use ($request, $user, $updateUserData, $newFotoPath, &$fotosToDelete) {
            if ($newFotoPath && $user->foto) {
                $fotosToDelete[] = $user->foto;
            }

            DB::table('users')->where('id', $user->id)->update($updateUserData);

            // Update data global di tabel pelatih dan sinkronkan ke seluruh cabang_pelatih milik pelatih ini
            $pelatih = DB::table('pelatih')->where('id_user', $user->id)->first();
            if ($pelatih) {
                $updatePelatihData = [
                    'tempat_lahir' => $request->tempat_lahir,
                    'no_rek'       => $request->no_rek,
                ];
                if ($request->filled('tanggal_lahir')) {
                    $updatePelatihData['tanggal_lahir'] = $request->tanggal_lahir;
                }
                DB::table('pelatih')->where('id', $pelatih->id)->update($updatePelatihData);

                $updateCabangPelatih = [
                    'nama'         => $request->nama,
                    'no_hp'        => $updateUserData['no_hp'],
                    'tempat_lahir' => $request->tempat_lahir,
                    'no_rek'       => $request->no_rek,
                ];
                if ($request->filled('tanggal_lahir')) {
                    $updateCabangPelatih['tanggal_lahir'] = $request->tanggal_lahir;
                }
                if ($newFotoPath) {
                    $oldBranchFotos = DB::table('cabang_pelatih')
                        ->where('id_pelatih', $pelatih->id)
                        ->whereNotNull('foto')
                        ->pluck('foto')
                        ->all();
                    $fotosToDelete = array_merge($fotosToDelete, $oldBranchFotos);

                    $updateCabangPelatih['foto'] = $newFotoPath;
                    $updateCabangPelatih['hapus_foto'] = false;
                }

                DB::table('cabang_pelatih')
                    ->where('id_pelatih', $pelatih->id)
                    ->update($updateCabangPelatih);
            }
        });

        // Hapus foto lama hanya jika berada di uploads/ atau images/pelatih/ dan tidak lagi dipakai
        foreach (array_unique($fotosToDelete) as $oldFoto) {
            $normalized = ltrim(str_replace('\\', '/', $oldFoto), '/');
            if (!str_starts_with($normalized, 'uploads/') && !str_starts_with($normalized, 'images/pelatih/')) {
                continue;
            }
            $masihDipakai = DB::table('users')->where('foto', $oldFoto)->exists()
                || DB::table('cabang_pelatih')->where('foto', $oldFoto)->exists();
            if (!$masihDipakai && file_exists(public_path($oldFoto))) {
                @unlink(public_path($oldFoto));
            }
        }

        return redirect()->route('pelatih.pengaturan')->with('success', 'Profil dan pengaturan pelatih berhasil diperbarui.');
    }
}
