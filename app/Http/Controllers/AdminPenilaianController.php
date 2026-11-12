<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminPenilaianController extends Controller
{
    /**
     * Menampilkan Halaman Penilaian Admin (Semua Pelatih & Club)
     */
    public function index(Request $request)
    {
        ParentsController::syncDataPelatihExcel();

        $adminCabang    = Auth::user()->id_cabang ?? null;
        $activeTab      = $request->input('tab', 'pelatih'); // 'pelatih' atau 'club'
        $search         = $request->input('search');
        $filterRating   = $request->input('filter_rating', 'semua');
        $bulan          = $request->has('bulan') ? $request->bulan : (string)date('n');
        $tahun          = $request->has('tahun') ? $request->tahun : (string)date('Y');
        $fromDate       = $request->input('from_date');
        $toDate         = $request->input('to_date');

        // Daftar tahun yang ada datanya
        $dbYearsPelatih = DB::table('ulasan_pelatih')
            ->selectRaw('DISTINCT YEAR(created_at) as yr')
            ->whereNotNull('created_at')
            ->pluck('yr')->map(fn($y) => (int)$y)->toArray();
        $dbYearsClub = DB::table('ulasan_club')
            ->selectRaw('DISTINCT YEAR(created_at) as yr')
            ->whereNotNull('created_at')
            ->pluck('yr')->map(fn($y) => (int)$y)->toArray();
        $listTahun = array_values(array_unique(array_merge([(int)date('Y')], $dbYearsPelatih, $dbYearsClub)));
        rsort($listTahun);

        // Master Pelatih untuk dropdown filter (dibatasi cabang admin jika ada)
        $listPelatihQuery = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id');

        if ($adminCabang) {
            $listPelatihQuery->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                             ->where('cabang_pelatih.id_cabang', $adminCabang);
        }

        $listPelatih = $listPelatihQuery
            ->select('pelatih.id', 'users.nama')
            ->orderBy('users.nama', 'asc')
            ->get();

        // Master Cabang untuk dropdown filter tab club
        $listCabang = $adminCabang
            ? DB::table('cabang')->where('id', $adminCabang)->orderBy('nama', 'asc')->get()
            : DB::table('cabang')->orderBy('nama', 'asc')->get();

        if ($activeTab === 'club') {
            $filterCabang   = $request->input('filter_cabang', 'semua');
            $filterKategori = $request->input('filter_kategori', 'semua');

            $query = DB::table('ulasan_club')
                ->leftJoin('cabang', 'ulasan_club.id_cabang', '=', 'cabang.id')
                ->leftJoin('parents', 'ulasan_club.id_parents', '=', 'parents.id')
                ->leftJoin('users', 'parents.id_user', '=', 'users.id')
                ->select(
                    'ulasan_club.id',
                    'ulasan_club.kategori',
                    'ulasan_club.bintang_rating',
                    'ulasan_club.komentar_rating',
                    'ulasan_club.created_at',
                    'cabang.nama as nama_cabang',
                    'users.nama as nama_parent',
                    'users.no_hp as no_hp_parent',
                    DB::raw('(SELECT GROUP_CONCAT(s.nama SEPARATOR ", ") FROM siswa s WHERE s.id_parents = parents.id) as nama_siswa')
                );

            if ($request->filled('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.nama', 'like', "%{$search}%")
                      ->orWhere('cabang.nama', 'like', "%{$search}%")
                      ->orWhere('ulasan_club.komentar_rating', 'like', "%{$search}%")
                      ->orWhereExists(function ($sub) use ($search) {
                          $sub->select(DB::raw(1))
                              ->from('siswa')
                              ->whereColumn('siswa.id_parents', 'parents.id')
                              ->where('siswa.nama', 'like', "%{$search}%");
                      });
                });
            }

            if ($adminCabang) {
                $query->where('ulasan_club.id_cabang', $adminCabang);
            } elseif ($filterCabang !== 'semua' && !empty($filterCabang)) {
                $query->where('ulasan_club.id_cabang', $filterCabang);
            }

            if ($filterKategori !== 'semua' && !empty($filterKategori)) {
                $query->where('ulasan_club.kategori', $filterKategori);
            }

            if ($filterRating !== 'semua' && !empty($filterRating)) {
                $query->where('ulasan_club.bintang_rating', $filterRating);
            }

            if ($bulan !== 'semua' && !empty($bulan)) {
                $query->whereMonth('ulasan_club.created_at', (int) $bulan);
            }
            if ($tahun !== 'semua' && !empty($tahun)) {
                $query->whereYear('ulasan_club.created_at', (int) $tahun);
            }

            if (!empty($fromDate)) {
                $query->whereDate('ulasan_club.created_at', '>=', $fromDate);
            }
            if (!empty($toDate)) {
                $query->whereDate('ulasan_club.created_at', '<=', $toDate);
            }

            $reviews = $query->orderBy('ulasan_club.created_at', 'desc')->get();

            // Statistik Ringkasan Club (disesuaikan dengan cabang dan filter periode)
            $baseClub = DB::table('ulasan_club');
            if ($adminCabang) {
                $baseClub->where('ulasan_club.id_cabang', $adminCabang);
            } elseif ($filterCabang !== 'semua' && !empty($filterCabang)) {
                $baseClub->where('ulasan_club.id_cabang', $filterCabang);
            }
            if ($filterKategori !== 'semua' && !empty($filterKategori)) {
                $baseClub->where('ulasan_club.kategori', $filterKategori);
            }
            if ($bulan !== 'semua' && !empty($bulan)) {
                $baseClub->whereMonth('ulasan_club.created_at', (int) $bulan);
            }
            if ($tahun !== 'semua' && !empty($tahun)) {
                $baseClub->whereYear('ulasan_club.created_at', (int) $tahun);
            }
            $totalUlasan = (clone $baseClub)->count();
            $avgRating = $totalUlasan > 0 ? round((clone $baseClub)->avg('bintang_rating'), 1) : 0;
            $positiveCount = (clone $baseClub)->where('bintang_rating', '>=', 4)->count();
            $distribusi = [
                5 => (clone $baseClub)->where('bintang_rating', 5)->count(),
                4 => (clone $baseClub)->where('bintang_rating', 4)->count(),
                3 => (clone $baseClub)->where('bintang_rating', 3)->count(),
                2 => (clone $baseClub)->where('bintang_rating', 2)->count(),
                1 => (clone $baseClub)->where('bintang_rating', 1)->count(),
            ];

            return view('admin.penilaian', compact(
                'activeTab', 'reviews', 'totalUlasan', 'avgRating', 'positiveCount',
                'distribusi', 'listPelatih', 'listCabang', 'search', 'filterRating',
                'bulan', 'tahun', 'fromDate', 'toDate', 'filterCabang', 'filterKategori', 'adminCabang', 'listTahun'
            ));

        } else {
            // Tab Penilaian Pelatih
            $filterPelatih = $request->input('filter_pelatih', 'semua');

            $query = DB::table('ulasan_pelatih')
                ->join('pelatih', 'ulasan_pelatih.id_pelatih', '=', 'pelatih.id')
                ->join('users as up', 'pelatih.id_user', '=', 'up.id')
                ->leftJoin('parents', 'ulasan_pelatih.id_parents', '=', 'parents.id')
                ->leftJoin('users as u_parent', 'parents.id_user', '=', 'u_parent.id')
                ->select(
                    'ulasan_pelatih.id',
                    'ulasan_pelatih.bintang_rating',
                    'ulasan_pelatih.komentar_rating',
                    'ulasan_pelatih.created_at',
                    'pelatih.id as id_pelatih',
                    'up.nama as nama_pelatih',
                    'up.foto as foto_pelatih',
                    'u_parent.nama as nama_parent',
                    'u_parent.no_hp as no_hp_parent',
                    DB::raw('(SELECT GROUP_CONCAT(s.nama SEPARATOR ", ") FROM siswa s WHERE s.id_parents = parents.id) as nama_siswa')
                );

            if ($adminCabang) {
                $query->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                      ->where('cabang_pelatih.id_cabang', $adminCabang);
            }

            if ($request->filled('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('up.nama', 'like', "%{$search}%")
                      ->orWhere('u_parent.nama', 'like', "%{$search}%")
                      ->orWhere('ulasan_pelatih.komentar_rating', 'like', "%{$search}%")
                      ->orWhereExists(function ($sub) use ($search) {
                          $sub->select(DB::raw(1))
                              ->from('siswa')
                              ->whereColumn('siswa.id_parents', 'parents.id')
                              ->where('siswa.nama', 'like', "%{$search}%");
                      });
                });
            }

            if ($filterPelatih !== 'semua' && !empty($filterPelatih)) {
                $query->where('ulasan_pelatih.id_pelatih', $filterPelatih);
            }

            if ($filterRating !== 'semua' && !empty($filterRating)) {
                $query->where('ulasan_pelatih.bintang_rating', $filterRating);
            }

            if ($bulan !== 'semua' && !empty($bulan)) {
                $query->whereMonth('ulasan_pelatih.created_at', (int) $bulan);
            }
            if ($tahun !== 'semua' && !empty($tahun)) {
                $query->whereYear('ulasan_pelatih.created_at', (int) $tahun);
            }

            if (!empty($fromDate)) {
                $query->whereDate('ulasan_pelatih.created_at', '>=', $fromDate);
            }
            if (!empty($toDate)) {
                $query->whereDate('ulasan_pelatih.created_at', '<=', $toDate);
            }

            $reviews = $query->orderBy('ulasan_pelatih.created_at', 'desc')->get();

            // Statistik Ringkasan Pelatih (disesuaikan dengan cabang dan filter periode)
            $basePelatih = DB::table('ulasan_pelatih');
            if ($adminCabang) {
                $basePelatih->join('cabang_pelatih', 'ulasan_pelatih.id_pelatih', '=', 'cabang_pelatih.id_pelatih')
                            ->where('cabang_pelatih.id_cabang', $adminCabang);
            }
            if ($filterPelatih !== 'semua' && !empty($filterPelatih)) {
                $basePelatih->where('ulasan_pelatih.id_pelatih', $filterPelatih);
            }
            if ($bulan !== 'semua' && !empty($bulan)) {
                $basePelatih->whereMonth('ulasan_pelatih.created_at', (int) $bulan);
            }
            if ($tahun !== 'semua' && !empty($tahun)) {
                $basePelatih->whereYear('ulasan_pelatih.created_at', (int) $tahun);
            }
            $totalUlasan = (clone $basePelatih)->count();
            $avgRating = $totalUlasan > 0 ? round((clone $basePelatih)->avg('bintang_rating'), 1) : 0;
            $positiveCount = (clone $basePelatih)->where('bintang_rating', '>=', 4)->count();
            $distribusi = [
                5 => (clone $basePelatih)->where('bintang_rating', 5)->count(),
                4 => (clone $basePelatih)->where('bintang_rating', 4)->count(),
                3 => (clone $basePelatih)->where('bintang_rating', 3)->count(),
                2 => (clone $basePelatih)->where('bintang_rating', 2)->count(),
                1 => (clone $basePelatih)->where('bintang_rating', 1)->count(),
            ];

            return view('admin.penilaian', compact(
                'activeTab', 'reviews', 'totalUlasan', 'avgRating', 'positiveCount',
                'distribusi', 'listPelatih', 'listCabang', 'search', 'filterRating',
                'bulan', 'tahun', 'fromDate', 'toDate', 'filterPelatih', 'adminCabang', 'listTahun'
            ));
        }
    }
}
