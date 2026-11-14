<!DOCTYPE html>
<html lang="id" class="bg-[#f4f8fb]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            background-color: #f4f8fb !important;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Horizontal scrollbar untuk card di mobile */
        .cards-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .cards-scrollbar::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 9999px;
        }
        .cards-scrollbar::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 9999px;
        }
        .cards-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        .cards-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 #e2e8f0;
        }
    </style>
    <title>Dashboard Admin - Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#f4f8fb] min-h-screen text-slate-800 flex flex-col md:flex-row antialiased selection:bg-[#00a5ec] selection:text-white relative">

    <!-- Mobile Top Navigation Header -->
    <header class="md:hidden bg-[#093c56] text-white p-4 flex items-center justify-between sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileSidebar()" class="p-2 text-white hover:bg-white/10 rounded-lg transition">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <span class="font-bold text-sm sm:text-base tracking-wide truncate max-w-[220px]">{{ Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa' }}</span>
        </div>
        <div class="text-xs font-semibold text-amber-400">Admin Panel</div>
    </header>

    <!-- Mobile Backdrop Overlay -->
    <div id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Left -->
    <aside id="mainSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#093c56] text-white flex flex-col justify-between h-screen md:min-h-screen md:sticky md:top-0 shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto shrink-0">
        <div>
            <!-- Header Sidebar (Logo & Title) -->
            <div class="p-6 flex flex-col items-center text-center border-b border-white/10">
                <div class="mb-3 relative">
                    @if(file_exists(public_path('images/logo.jpg')))
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa" class="h-20 w-20 rounded-full object-cover shadow-md border-2 border-amber-300">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gradient-to-tr from-amber-400 to-yellow-300 flex flex-col items-center justify-center text-blue-900 border-2 border-amber-300 shadow-md">
                            <i class="fa-solid fa-elephant text-2xl text-gray-700 mb-0.5"></i>
                            <span class="text-[9px] font-black tracking-wider">GAJAH DEPA</span>
                        </div>
                    @endif
                </div>
                <h2 class="text-base font-bold text-white tracking-wide leading-snug px-1">{{ Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa' }}</h2>
            </div>

            <!-- Navigation Links -->
            <nav class="px-4 py-6 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-table-cells-large text-base {{ request()->routeIs('admin.dashboard') ? 'text-sky-400' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Pelatih -->
                <a href="{{ route('admin.pelatih.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.pelatih.*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-user text-base {{ request()->routeIs('admin.pelatih.*') ? 'text-sky-400' : '' }}"></i>
                    <span>Pelatih</span>
                </a>

                <!-- Siswa -->
                <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.siswa.*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-graduation-cap text-base {{ request()->routeIs('admin.siswa.*') ? 'text-sky-400' : '' }}"></i>
                    <span class="flex-1">Siswa</span>
                    @if(!empty($sidebarPendingCount) && $sidebarPendingCount > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold bg-amber-500 text-white rounded-full shadow-xs animate-pulse">
                            {{ $sidebarPendingCount }}
                        </span>
                    @endif
                </a>

                <!-- Penilaian -->
                <a href="{{ route('admin.penilaian.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.penilaian.*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-star text-base {{ request()->routeIs('admin.penilaian.*') ? 'text-sky-400' : '' }}"></i>
                    <span>Penilaian</span>
                </a>

                <!-- Keuangan -->
                <a href="{{ route('admin.keuangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.keuangan.*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-wallet text-base {{ request()->routeIs('admin.keuangan.*') ? 'text-sky-400' : '' }}"></i>
                    <span>Keuangan</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.pengaturan.*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-gear text-base {{ request()->routeIs('admin.pengaturan.*') ? 'text-sky-400' : '' }}"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer (Profile Info & Logout) -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                @if(file_exists(public_path('images/logo.jpg')))
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa" class="w-10 h-10 rounded-full object-cover border border-amber-300 shadow-sm shrink-0">
                @else
                    <div class="w-10 h-10 rounded-full bg-amber-400 text-amber-900 font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'AD', 0, 2)) }}
                    </div>
                @endif
                <div class="truncate">
                    <div class="text-sm font-bold text-white truncate">{{ Auth::user()->nama ?? 'Admin' }}</div>
                    <div class="text-[11px] text-slate-300 truncate">{{ Auth::user()->email ?? 'admin@gajahdepa.com' }}</div>
                </div>
            </div>

            <button type="button" onclick="openLogoutModal()" title="Keluar / Logout" class="p-2 text-slate-300 hover:text-rose-400 hover:bg-white/10 rounded-lg transition shrink-0 ml-1 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 md:p-8 overflow-y-auto min-w-0">
        
        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Dashboard Ringkasan</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan aktivitas {{ Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa' }}</p>
        </div>

        @if(session('sukses_swimmer'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs animate-fadeIn">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-trophy text-base"></i>
                    </div>
                    <div>
                        <div class="font-bold text-sm text-emerald-900">Best Member of the Month Berhasil Ditetapkan!</div>
                        <div class="text-xs text-emerald-700 mt-0.5">{{ session('sukses_swimmer') }}</div>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg hover:bg-emerald-100/60 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs animate-fadeIn">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-lock text-base"></i>
                    </div>
                    <div>
                        <div class="font-bold text-sm text-rose-900">Pemberitahuan</div>
                        <div class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</div>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 p-1.5 rounded-lg hover:bg-rose-100/60 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        @php
            $adminCabang = Auth::user()->id_cabang ?? null;

            // Hitung data metrik 4 Card sesuai cabang admin
            $totalSiswa = $adminCabang
                ? \Illuminate\Support\Facades\DB::table('siswa')->where('id_cabang', $adminCabang)->count()
                : \Illuminate\Support\Facades\DB::table('siswa')->count();

            $pendaftarPendingCount = $adminCabang
                ? \Illuminate\Support\Facades\DB::table('pendaftaran_baru')->where('status_pendaftaran', 'pending')->where('id_cabang', $adminCabang)->count()
                : \Illuminate\Support\Facades\DB::table('pendaftaran_baru')->where('status_pendaftaran', 'pending')->count();

            $totalPelatihCount = $adminCabang
                ? \Illuminate\Support\Facades\DB::table('cabang_pelatih')->where('id_cabang', $adminCabang)->distinct('id_pelatih')->count('id_pelatih')
                : \App\Models\User::where('role', 'pelatih')->count();

            $pemasukanQuery = \Illuminate\Support\Facades\DB::table('keuangan')->where('jenis_transaksi', 'pemasukan');
            if ($adminCabang) $pemasukanQuery->where('id_cabang', $adminCabang);
            $totalMasuk = (int) $pemasukanQuery->sum('nominal');

            $pengeluaranQuery = \Illuminate\Support\Facades\DB::table('keuangan')->where('jenis_transaksi', 'pengeluaran');
            if ($adminCabang) $pengeluaranQuery->where('id_cabang', $adminCabang);
            $totalKeluar = (int) $pengeluaranQuery->sum('nominal');

            $saldoKas = $totalMasuk - $totalKeluar;

            // Hitung Best Member of the Month
            $tahunIni = (int) date('Y');
            $bulanIni = (int) date('m');
            $listNamaBulan = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ];
            $namaBulanIni = $listNamaBulan[date('m')] ?? 'Bulan Ini';
            $namaCabangAdmin = Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa';

            $kandidatQuery = \Illuminate\Support\Facades\DB::table('siswa')
                ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id');
            if ($adminCabang) {
                $kandidatQuery->where('siswa.id_cabang', $adminCabang);
            }
            $kandidatSiswa = $kandidatQuery->select(
                'siswa.id',
                'siswa.nama',
                'siswa.foto',
                'siswa.tingkat_kelas',
                'kelas.nama as nama_kelas',
                'cabang.nama as nama_cabang'
            )->get();

            if ($kandidatSiswa->isNotEmpty()) {
                $kandidatIds = $kandidatSiswa->pluck('id')->all();

                $hitungStatBulanan = function ($idSiswa, $thn, $bln) {
                    $hadir = \Illuminate\Support\Facades\DB::table('absensi_siswa')
                        ->where('id_siswa', $idSiswa)
                        ->whereYear('tanggal_kehadiran', $thn)
                        ->whereMonth('tanggal_kehadiran', $bln)
                        ->where('status_kehadiran', 'hadir')
                        ->count();

                    $nilaiBulan = \Illuminate\Support\Facades\DB::table('pencapaian_siswa')
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

                    $skorUtama = ($hadir * 100) + $progresPct;

                    return [
                        'total_hadir' => $hadir,
                        'avg_score'   => $avgBulan,
                        'progres_pct' => $progresPct,
                        'skor_utama'  => $skorUtama,
                    ];
                };

                $targetPeriode = sprintf('%04d-%02d', $tahunIni, $bulanIni);

                $periodeAbsensi = \Illuminate\Support\Facades\DB::table('absensi_siswa')
                    ->whereIn('id_siswa', $kandidatIds)
                    ->selectRaw("DATE_FORMAT(tanggal_kehadiran, '%Y-%m') as ym")
                    ->distinct()
                    ->pluck('ym')
                    ->filter(fn($ym) => !empty($ym) && $ym < $targetPeriode);

                $periodePenilaian = \Illuminate\Support\Facades\DB::table('pencapaian_siswa')
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

                $rankedKandidat = $kandidatSiswa->map(function ($k) use ($hitungStatBulanan, $tahunIni, $bulanIni, $riwayatBestMemberCount, $namaCabangAdmin) {
                    $stat = $hitungStatBulanan($k->id, $tahunIni, $bulanIni);
                    $k->total_hadir = $stat['total_hadir'];
                    $k->avg_score   = $stat['avg_score'];
                    $k->progres_pct = $stat['progres_pct'];
                    $k->skor_utama  = $stat['skor_utama'];
                    $k->pernah_bm   = $riwayatBestMemberCount[$k->id] ?? 0;
                    $k->nama_cabang = $k->nama_cabang ?? $namaCabangAdmin;
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

                $top5Kandidat = $rankedKandidat->take(5);
                $allKandidatSiswa = $rankedKandidat->sortBy('nama', SORT_NATURAL | SORT_FLAG_CASE)->values();

                $isLocked = false;
                $bestMember = null;
                if (\Illuminate\Support\Facades\Schema::hasTable('best_swimmer')) {
                    // Bersihkan data testing awal bulan berjalan sekali ini agar kosong bersih
                    if (!\Illuminate\Support\Facades\Cache::has('bm_test_cleared_nov2026') || request()->has('reset_bm')) {
                        \Illuminate\Support\Facades\DB::table('best_swimmer')->where('tahun', $tahunIni)->where('bulan', $bulanIni)->delete();
                        \Illuminate\Support\Facades\Cache::forever('bm_test_cleared_nov2026', true);
                    }

                    $selectedManualId = \Illuminate\Support\Facades\DB::table('best_swimmer')
                        ->where('id_cabang', $adminCabang ?: 1)
                        ->where('tahun', $tahunIni)
                        ->where('bulan', $bulanIni)
                        ->value('id_siswa');

                    if ($selectedManualId) {
                        $bestMember = $rankedKandidat->firstWhere('id', $selectedManualId);
                        if (!$bestMember) {
                            $dbSiswa = \Illuminate\Support\Facades\DB::table('siswa')
                                ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                                ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
                                ->where('siswa.id', $selectedManualId)
                                ->select(
                                    'siswa.id', 'siswa.nama', 'siswa.foto',
                                    'kelas.nama as nama_kelas', 'cabang.nama as nama_cabang'
                                )->first();
                            if ($dbSiswa) {
                                $bestMember = $dbSiswa;
                            }
                        }
                        $isLocked = true;
                    }
                }
                // Jika belum ditetapkan di bulan ini, biarkan $bestMember bernilai null (kosong)
            } else {
                $bestMember = null;
                $top5Kandidat = collect();
                $allKandidatSiswa = collect();
                $isLocked = false;
            }

            $tanggalHariIni = (int) date('j');
            $isBukaPemilihan = ($tanggalHariIni >= 25);
            $canClickCard = true; // Admin selalu dapat mengklik kartu untuk melihat detail kandidat atau membatalkan penetapan
        @endphp

        <!-- 5 Metric Cards Row (Termasuk Best Member of the Month) -->
        <div class="flex overflow-x-auto pb-3 pt-1 gap-3 snap-x snap-mandatory scroll-smooth cards-scrollbar sm:no-scrollbar sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 sm:gap-4 lg:gap-5 sm:pb-0 sm:pt-0 mb-8">
            
            <!-- Card 1: Total Siswa Aktif -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] sm:w-auto sm:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-[#008cc9] relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-800 tracking-wide leading-tight">Total Siswa Aktif</span>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-50 text-[#008cc9] flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                        {{ $totalSiswa }}
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 mt-1 truncate flex items-center">
                        <span class="w-2 h-2 rounded-full bg-[#008cc9] mr-1.5 shrink-0"></span> Siswa terdaftar aktif
                    </div>
                </div>
            </div>

            <!-- Card 2: Pendaftar Menunggu -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] sm:w-auto sm:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-orange-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-800 tracking-wide leading-tight">Pendaftar Menunggu</span>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-solid fa-exclamation"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                        {{ $pendaftarPendingCount }}
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 mt-1 truncate flex items-center">
                        <span class="w-2 h-2 rounded-full bg-orange-400 mr-1.5 shrink-0"></span> Menunggu verifikasi
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Pelatih -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] sm:w-auto sm:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-sky-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-800 tracking-wide leading-tight">Total Pelatih</span>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                        {{ $totalPelatihCount }}
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 mt-1 truncate flex items-center">
                        <span class="w-2 h-2 rounded-full bg-sky-400 mr-1.5 shrink-0"></span> Bertugas di cabang ini
                    </div>
                </div>
            </div>

            <!-- Card 4: Saldo Kas -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] sm:w-auto sm:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-emerald-500 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-800 tracking-wide leading-tight">Saldo Kas</span>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-regular fa-folder-closed"></i>
                    </div>
                </div>
                <div>
                    <div class="text-base sm:text-lg lg:text-xl font-extrabold text-slate-800 tracking-tight whitespace-nowrap">
                        {{ $saldoKas < 0 ? '-Rp ' . number_format(abs($saldoKas), 0, ',', '.') : 'Rp ' . number_format($saldoKas, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 mt-1 truncate flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 shrink-0"></span> Kas bersih cabang
                    </div>
                </div>
            </div>

            <!-- Card 5: Best Member of the Month -->
            <div @if($canClickCard) onclick="openBestMemberModal()" @endif class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] sm:w-auto sm:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 border-t-4 border-t-amber-400 relative overflow-hidden flex flex-col justify-between transition-all duration-200 @if($canClickCard) cursor-pointer hover:shadow-md group hover:-translate-y-0.5 @endif" title="{{ $isLocked ? 'Klik untuk melihat detail atau membatalkan penetapan Best Member' : ($isBukaPemilihan ? 'Klik untuk memilih Best Member of the Month' : 'Klik untuk melihat kandidat Best Member (Penetapan resmi dibuka tgl 25)') }}">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <div>
                        <span class="text-[11px] sm:text-xs font-bold text-slate-800 tracking-wide leading-tight block">Best Member of the Month</span>
                        @if(!$isLocked)
                            @if($isBukaPemilihan)
                                <span class="text-[10px] text-amber-600 font-semibold flex items-center gap-1 mt-0.5 group-hover:text-amber-700">
                                    <i class="fa-solid fa-hand-pointer text-[9px] animate-bounce"></i> Ketuk untuk pilih
                                </span>
                            @else
                                <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-1 mt-0.5" title="Penetapan Best Member dibuka mulai tanggal 25 {{ $namaBulanIni }}">
                                    <i class="fa-solid fa-clock text-[9px]"></i> Dibuka tgl 25 {{ $namaBulanIni }}
                                </span>
                            @endif
                        @else
                            <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1 mt-0.5 group-hover:text-emerald-700">
                                <i class="fa-solid fa-lock text-[9px]"></i> Telah Ditetapkan · Kelola
                            </span>
                        @endif
                    </div>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-amber-50 text-amber-500 @if($canClickCard) group-hover:bg-amber-100 @endif flex items-center justify-center text-xs sm:text-base shrink-0 shadow-2xs transition">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <div>
                    @if($bestMember)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full p-0.5 border-2 border-amber-400 shrink-0 overflow-hidden bg-sky-50 flex items-center justify-center shadow-xs">
                                @if(!empty($bestMember->foto) && file_exists(public_path($bestMember->foto)))
                                    <img src="{{ asset($bestMember->foto) }}" alt="{{ $bestMember->nama }}" class="w-full h-full rounded-full object-cover">
                                @elseif(!empty($bestMember->foto) && file_exists(public_path('storage/' . $bestMember->foto)))
                                    <img src="{{ asset('storage/' . $bestMember->foto) }}" alt="{{ $bestMember->nama }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-[#00b4db] to-[#0083b0] text-white font-extrabold text-xs sm:text-sm flex items-center justify-center">
                                        {{ strtoupper(substr($bestMember->nama ?? 'BM', 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm sm:text-base font-extrabold text-slate-800 leading-tight truncate @if($canClickCard) group-hover:text-[#008cc9] @endif transition" title="{{ $bestMember->nama }}">
                                    {{ $bestMember->nama }}
                                </div>
                                <div class="text-[11px] sm:text-xs text-slate-500 mt-0.5 truncate flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 mr-1.5 shrink-0"></span> {{ $namaBulanIni }} {{ date('Y') }} · {{ $bestMember->nama_cabang ?? 'Gajah Depa' }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-dashed border-amber-300 shrink-0 bg-amber-50/60 flex items-center justify-center text-amber-500 shadow-2xs">
                                <i class="fa-solid fa-user-clock text-sm sm:text-base"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm sm:text-base font-bold text-slate-400 leading-tight truncate">
                                    Belum Ditetapkan
                                </div>
                                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-slate-300 mr-1.5 shrink-0"></span> {{ $namaBulanIni }} {{ date('Y') }} · {{ $namaCabangAdmin }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        @php
            $bulanIndo = [
                '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
                '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
            ];

            // 1. Data Keuangan dari Database sesuai cabang
            $dbKeuanganQuery = \Illuminate\Support\Facades\DB::table('keuangan')
                ->where('status', 'lunas');
            if ($adminCabang) {
                $dbKeuanganQuery->where('id_cabang', $adminCabang);
            }
            $dbKeuanganRows = $dbKeuanganQuery->orderBy('tanggal_transaksi', 'asc')->get();

            $keuanganMap = [];
            $curSaldo = 0;
            foreach ($dbKeuanganRows as $kRow) {
                $t = $kRow->tanggal_transaksi;
                if (!isset($keuanganMap[$t])) {
                    $parts = explode('-', $t);
                    $lbl = (int)($parts[2] ?? 1) . ' ' . ($bulanIndo[$parts[1] ?? '01'] ?? $parts[1]);
                    $keuanganMap[$t] = [
                        'date' => $t,
                        'label' => $lbl,
                        'pemasukan' => 0,
                        'pengeluaran' => 0,
                        'saldo' => 0
                    ];
                }
                if ($kRow->jenis_transaksi === 'pemasukan') {
                    $keuanganMap[$t]['pemasukan'] += (int) $kRow->nominal;
                    $curSaldo += (int) $kRow->nominal;
                } else {
                    $keuanganMap[$t]['pengeluaran'] += (int) $kRow->nominal;
                    $curSaldo -= (int) $kRow->nominal;
                }
                $keuanganMap[$t]['saldo'] = $curSaldo;
            }

            ksort($keuanganMap);
            $finalKeuanganData = array_values($keuanganMap);

            // 2. Data Pendaftar Baru dari Database sesuai cabang
            $dbPendaftarQuery = \Illuminate\Support\Facades\DB::table('pendaftaran_baru')
                ->selectRaw('DATE(created_at) as tgl, count(*) as total');
            if ($adminCabang) {
                $dbPendaftarQuery->where('id_cabang', $adminCabang);
            }
            $dbPendaftarRows = $dbPendaftarQuery->groupBy('tgl')->orderBy('tgl', 'asc')->get();

            $pendaftarMap = [];
            foreach ($dbPendaftarRows as $pRow) {
                $t = $pRow->tgl;
                $parts = explode('-', $t);
                $lbl = (int)($parts[2] ?? 1) . ' ' . ($bulanIndo[$parts[1] ?? '01'] ?? $parts[1]);
                $pendaftarMap[$t] = [
                    'date' => $t,
                    'label' => $lbl,
                    'count' => (int) $pRow->total
                ];
            }

            ksort($pendaftarMap);
            $finalPendaftarData = array_values($pendaftarMap);

            // Default rentang bulan berjalan: awal bulan sampai akhir bulan ini secara dinamis
            $defaultMonthStart = date('Y-m-01');
            $defaultMonthEnd = date('Y-m-t');
        @endphp

        <!-- 2 Charts Grid Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Left Chart: Grafik Keuangan -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Grafik Keuangan</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Tren pemasukan, pengeluaran & saldo kas </p>
                        </div>

                        <!-- Filter Bulan & Tahun Grafik Keuangan (default: bulan ini) -->
                        <div class="flex items-center gap-2 text-xs shrink-0">
                            @php
                                $namaBulanGrafik = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                                $curMonth = (int)date('n');
                                $curYear = (int)date('Y');
                                $dbYearsKeuangan = \Illuminate\Support\Facades\DB::table('keuangan')
                                    ->selectRaw('DISTINCT YEAR(tanggal_transaksi) as yr')
                                    ->whereNotNull('tanggal_transaksi');
                                if ($adminCabang) {
                                    $dbYearsKeuangan->where('id_cabang', $adminCabang);
                                }
                                $dbYearsKeuanganList = $dbYearsKeuangan->pluck('yr')->map(fn($y) => (int)$y)->toArray();
                                $yearsOptions = array_values(array_unique(array_merge([$curYear], $dbYearsKeuanganList)));
                                rsort($yearsOptions);
                            @endphp
                            <select id="keuanganFilterBulan" onchange="filterKeuanganMonthYear()" class="text-xs bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                @foreach($namaBulanGrafik as $mKey => $mVal)
                                    <option value="{{ $mKey }}" {{ $mKey === $curMonth ? 'selected' : '' }}>{{ $mVal }}</option>
                                @endforeach
                            </select>
                            <select id="keuanganFilterTahun" onchange="filterKeuanganMonthYear()" class="text-xs bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                @foreach($yearsOptions as $yOpt)
                                    <option value="{{ $yOpt }}" {{ $yOpt === $curYear ? 'selected' : '' }}>{{ $yOpt }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="resetKeuanganMonthYear()" title="Reset ke Bulan Berjalan" class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-800 transition flex items-center gap-1 text-[11px] font-medium cursor-pointer shadow-2xs">
                                <i class="fa-solid fa-rotate-left text-[10px] text-slate-400"></i>
                                <span>Reset</span>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Kategori Pill (dengan titik warna di samping nama) -->
                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        <button type="button" onclick="filterKeuangan('all')" data-filter="all" class="filter-keuangan-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#00a5ec] text-white shadow-xs transition-all duration-200 cursor-pointer flex items-center">
                            Semua
                        </button>
                        <button type="button" onclick="filterKeuangan('pemasukan')" data-filter="pemasukan" class="filter-keuangan-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all duration-200 cursor-pointer flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#10b981] inline-block shrink-0"></span>
                            <span>Pemasukan</span>
                        </button>
                        <button type="button" onclick="filterKeuangan('pengeluaran')" data-filter="pengeluaran" class="filter-keuangan-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all duration-200 cursor-pointer flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#f97316] inline-block shrink-0"></span>
                            <span>Pengeluaran</span>
                        </button>
                        <button type="button" onclick="filterKeuangan('saldo')" data-filter="saldo" class="filter-keuangan-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all duration-200 cursor-pointer flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#00a5ec] inline-block shrink-0"></span>
                            <span>Saldo Kas</span>
                        </button>
                    </div>
                </div>

                <!-- Canvas Chart & Notice -->
                <div class="relative w-full">
                    <div id="keuanganEmptyNotice" class="hidden flex flex-col items-center justify-center h-64 text-slate-400 text-xs">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                        <span>Tidak ada data transaksi pada rentang tanggal yang dipilih</span>
                    </div>
                    <div id="keuanganChartContainer" class="h-64 w-full">
                        <canvas id="keuanganChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Chart: Grafik Pendaftar Baru -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <span>Grafik Pendaftar Baru</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-[#00a5ec] inline-block shrink-0" title="Pendaftar Baru"></span>
                            </h3>
                            <p class="text-xs text-slate-400 mt-0.5">Jumlah pendaftar per hari</p>
                        </div>

                        <!-- Filter Bulan & Tahun Grafik Pendaftar Baru (default: bulan ini) -->
                        <div class="flex items-center gap-2 text-xs shrink-0">
                            @php
                                $dbYearsPendaftar = \Illuminate\Support\Facades\DB::table('pendaftaran_baru')
                                    ->selectRaw('DISTINCT YEAR(created_at) as yr')
                                    ->whereNotNull('created_at');
                                if ($adminCabang) {
                                    $dbYearsPendaftar->where('id_cabang', $adminCabang);
                                }
                                $dbYearsPendaftarList = $dbYearsPendaftar->pluck('yr')->map(fn($y) => (int)$y)->toArray();
                                $pendaftarYearsOptions = array_values(array_unique(array_merge([$curYear], $dbYearsPendaftarList)));
                                rsort($pendaftarYearsOptions);
                            @endphp
                            <select id="pendaftarFilterBulan" onchange="filterPendaftarMonthYear()" class="text-xs bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                @foreach($namaBulanGrafik as $mKey => $mVal)
                                    <option value="{{ $mKey }}" {{ $mKey === $curMonth ? 'selected' : '' }}>{{ $mVal }}</option>
                                @endforeach
                            </select>
                            <select id="pendaftarFilterTahun" onchange="filterPendaftarMonthYear()" class="text-xs bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                @foreach($pendaftarYearsOptions as $yOpt)
                                    <option value="{{ $yOpt }}" {{ $yOpt === $curYear ? 'selected' : '' }}>{{ $yOpt }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="resetPendaftarMonthYear()" title="Reset ke Bulan Berjalan" class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-800 transition flex items-center gap-1 text-[11px] font-medium cursor-pointer shadow-2xs">
                                <i class="fa-solid fa-rotate-left text-[10px] text-slate-400"></i>
                                <span>Reset</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Canvas Chart & Notice -->
                <div class="relative w-full">
                    <div id="pendaftarEmptyNotice" class="hidden flex flex-col items-center justify-center h-64 text-slate-400 text-xs">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                        <span>Tidak ada pendaftar baru pada rentang tanggal yang dipilih</span>
                    </div>
                    <div id="pendaftarChartContainer" class="h-64 w-full">
                        <canvas id="pendaftarChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan" class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Chart.js Scripts Initialization -->
    <script>
        // Data Sumber dari Database / Mock
        const allKeuanganData = @json($finalKeuanganData);
        const allPendaftarData = @json($finalPendaftarData);
        const defaultMonthStart = @json($defaultMonthStart);
        const defaultMonthEnd = @json($defaultMonthEnd);
        let activeKeuanganType = 'all';

        // 1. Inisialisasi Grafik Keuangan
        const ctxKeuangan = document.getElementById('keuanganChart').getContext('2d');
        const chartKeuangan = new Chart(ctxKeuangan, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Saldo Kas',
                        data: [],
                        borderColor: '#00a5ec',
                        borderWidth: 2.5,
                        borderDash: [6, 4],
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        pointBackgroundColor: '#00a5ec',
                        pointRadius: 2.5,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Pemasukan',
                        data: [],
                        borderColor: '#10b981',
                        borderWidth: 2,
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        pointBackgroundColor: '#10b981',
                        pointRadius: 2.5,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Pengeluaran',
                        data: [],
                        borderColor: '#f97316',
                        borderWidth: 2,
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        pointBackgroundColor: '#f97316',
                        pointRadius: 2.5,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    const val = Number(context.parsed.y);
                                    label += (val < 0 ? '-Rp ' : 'Rp ') + Math.abs(val).toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(val) {
                                if (val === 0) return '0';
                                if (Math.abs(val) >= 1000000) return (val / 1000000).toLocaleString('id-ID') + 'jt';
                                if (Math.abs(val) >= 1000) return (val / 1000).toLocaleString('id-ID') + 'rb';
                                return val;
                            }
                        },
                        grid: { borderDash: [3, 3] }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { autoSkip: true, maxTicksLimit: 10 }
                    }
                }
            }
        });

        // Terapkan visibility dataset keuangan sesuai tipe yang dipilih (all, pemasukan, pengeluaran, saldo)
        function applyKeuanganTypeVisibility(type) {
            const showSaldo = (type === 'all' || type === 'saldo');
            const showPemasukan = (type === 'all' || type === 'pemasukan');
            const showPengeluaran = (type === 'all' || type === 'pengeluaran');

            if (typeof chartKeuangan.setDatasetVisibility === 'function') {
                chartKeuangan.setDatasetVisibility(0, showSaldo);
                chartKeuangan.setDatasetVisibility(1, showPemasukan);
                chartKeuangan.setDatasetVisibility(2, showPengeluaran);
            }
            if (chartKeuangan.data && chartKeuangan.data.datasets) {
                if (chartKeuangan.data.datasets[0]) chartKeuangan.data.datasets[0].hidden = !showSaldo;
                if (chartKeuangan.data.datasets[1]) chartKeuangan.data.datasets[1].hidden = !showPemasukan;
                if (chartKeuangan.data.datasets[2]) chartKeuangan.data.datasets[2].hidden = !showPengeluaran;
            }
        }

        const defaultMonthNum = {{ (int)date('n') }};
        const defaultYearNum = {{ (int)date('Y') }};

        // Render data grafik keuangan per bulan (selalu tampilkan titik harian kontinu meskipun tidak ada transaksi / 0)
        function renderKeuanganChart() {
            const bulanEl = document.getElementById('keuanganFilterBulan');
            const tahunEl = document.getElementById('keuanganFilterTahun');

            const selectedMonth = bulanEl ? parseInt(bulanEl.value, 10) : defaultMonthNum;
            const selectedYear = tahunEl ? parseInt(tahunEl.value, 10) : defaultYearNum;

            const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

            // Peta transaksi keuangan dari database
            const dataByDate = {};
            allKeuanganData.forEach(item => {
                dataByDate[item.date] = item;
            });

            // Pergerakan saldo kas untuk bulan yang dipilih (sinkron dengan filter periode di halaman Keuangan)
            let runningSaldo = 0;

            const labels = [];
            const pemasukanArr = [];
            const pengeluaranArr = [];
            const saldoArr = [];

            for (let d = 1; d <= daysInMonth; d++) {
                const dayStr = String(d).padStart(2, '0');
                const monthStr = String(selectedMonth).padStart(2, '0');
                const dateKey = `${selectedYear}-${monthStr}-${dayStr}`;

                labels.push(formatLabelDate(dateKey));

                if (dataByDate[dateKey]) {
                    const masuk = dataByDate[dateKey].pemasukan || 0;
                    const keluar = dataByDate[dateKey].pengeluaran || 0;
                    pemasukanArr.push(masuk);
                    pengeluaranArr.push(keluar);
                    runningSaldo += (masuk - keluar);
                    saldoArr.push(runningSaldo);
                } else {
                    pemasukanArr.push(0);
                    pengeluaranArr.push(0);
                    saldoArr.push(runningSaldo);
                }
            }

            const noticeEl = document.getElementById('keuanganEmptyNotice');
            const containerEl = document.getElementById('keuanganChartContainer');

            // Pastikan grafik selalu dimunculkan (tidak disembunyikan/kosong walau 0 data)
            if (noticeEl) noticeEl.classList.add('hidden');
            if (containerEl) containerEl.classList.remove('hidden');

            chartKeuangan.data.labels = labels;
            chartKeuangan.data.datasets[0].data = saldoArr;
            chartKeuangan.data.datasets[1].data = pemasukanArr;
            chartKeuangan.data.datasets[2].data = pengeluaranArr;

            applyKeuanganTypeVisibility(activeKeuanganType);
            chartKeuangan.update();
        }

        // Filter tipe dataset (Semua, Pemasukan, Pengeluaran, Saldo Kas)
        function filterKeuangan(type) {
            activeKeuanganType = type;
            applyKeuanganTypeVisibility(type);
            chartKeuangan.update();

            // Perbarui visual tombol filter aktif
            const filterButtons = document.querySelectorAll('.filter-keuangan-btn');
            filterButtons.forEach(btn => {
                const btnFilter = btn.getAttribute('data-filter');
                if (btnFilter === type) {
                    btn.className = 'filter-keuangan-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#00a5ec] text-white shadow-xs transition-all duration-200 cursor-pointer flex items-center gap-1.5';
                } else {
                    btn.className = 'filter-keuangan-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all duration-200 cursor-pointer flex items-center gap-1.5';
                }
            });
        }

        function filterKeuanganMonthYear() {
            renderKeuanganChart();
        }

        function resetKeuanganMonthYear() {
            const bulanEl = document.getElementById('keuanganFilterBulan');
            const tahunEl = document.getElementById('keuanganFilterTahun');
            if (bulanEl) bulanEl.value = defaultMonthNum;
            if (tahunEl) tahunEl.value = defaultYearNum;
            renderKeuanganChart();
        }

        const bulanIndoNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        function formatLabelDate(dateStr) {
            const parts = dateStr.split('-');
            if (parts.length < 3) return dateStr;
            const day = parseInt(parts[2], 10);
            const mIdx = parseInt(parts[1], 10) - 1;
            const monthName = bulanIndoNames[mIdx] || parts[1];
            return `${day} ${monthName}`;
        }

        // 2. Inisialisasi Grafik Pendaftar Baru
        const ctxPendaftar = document.getElementById('pendaftarChart').getContext('2d');
        const chartPendaftar = new Chart(ctxPendaftar, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Pendaftar Baru',
                    data: [],
                    borderColor: '#00a5ec',
                    borderWidth: 2,
                    backgroundColor: 'rgba(0, 165, 236, 0.08)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#00a5ec',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    pointRadius: 2.5,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Pendaftar Baru: ' + context.parsed.y + ' orang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { borderDash: [3, 3] }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { autoSkip: true, maxTicksLimit: 10 }
                    }
                }
            }
        });

        // Render data grafik pendaftar baru (selalu tampilkan grafik meskipun tidak ada pendaftar / bernilai 0)
        function renderPendaftarChart() {
            const bulanEl = document.getElementById('pendaftarFilterBulan');
            const tahunEl = document.getElementById('pendaftarFilterTahun');

            const selectedMonth = bulanEl ? parseInt(bulanEl.value, 10) : defaultMonthNum;
            const selectedYear = tahunEl ? parseInt(tahunEl.value, 10) : defaultYearNum;

            const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

            const noticeEl = document.getElementById('pendaftarEmptyNotice');
            const containerEl = document.getElementById('pendaftarChartContainer');

            // Pastikan grafik selalu dimunculkan (tidak disembunyikan/kosong walau 0 data)
            if (noticeEl) noticeEl.classList.add('hidden');
            if (containerEl) containerEl.classList.remove('hidden');

            // Petakan jumlah pendaftar per tanggal dari database
            const countMap = {};
            allPendaftarData.forEach(item => {
                countMap[item.date] = item.count;
            });

            const labels = [];
            const counts = [];

            for (let d = 1; d <= daysInMonth; d++) {
                const dayStr = String(d).padStart(2, '0');
                const monthStr = String(selectedMonth).padStart(2, '0');
                const dateKey = `${selectedYear}-${monthStr}-${dayStr}`;

                labels.push(formatLabelDate(dateKey));
                counts.push(countMap[dateKey] || 0);
            }

            chartPendaftar.data.labels = labels;
            chartPendaftar.data.datasets[0].data = counts;

            const maxCount = Math.max(3, ...counts);
            chartPendaftar.options.scales.y.max = maxCount + 1;

            chartPendaftar.update();
        }

        function filterPendaftarMonthYear() {
            renderPendaftarChart();
        }

        function resetPendaftarMonthYear() {
            const bulanEl = document.getElementById('pendaftarFilterBulan');
            const tahunEl = document.getElementById('pendaftarFilterTahun');
            if (bulanEl) bulanEl.value = defaultMonthNum;
            if (tahunEl) tahunEl.value = defaultYearNum;
            renderPendaftarChart();
        }

        // Render awal grafik setelah DOM siap
        renderKeuanganChart();
        renderPendaftarChart();

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            if (sidebar && backdrop) {
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }
        }

        // Modal Best Member of the Month
        function openBestMemberModal() {
            const m = document.getElementById('modalBestMember') || document.getElementById('modalBestSwimmer');
            if (m) {
                m.classList.remove('hidden');
                m.classList.add('flex');
            }
        }

        function closeBestMemberModal() {
            const m = document.getElementById('modalBestMember') || document.getElementById('modalBestSwimmer');
            if (m) {
                m.classList.add('hidden');
                m.classList.remove('flex');
            }
        }

        function openBestSwimmerModal() { openBestMemberModal(); }
        function closeBestSwimmerModal() { closeBestMemberModal(); }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBestMemberModal();
            }
        });
    </script>

    <!-- Modal Pemilihan Best Member of the Month -->
    <div id="modalBestMember" onclick="if(event.target === this) closeBestMemberModal()" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs items-center justify-center p-3 sm:p-4 hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-150">
            
            <!-- Header Modal -->
            <div class="p-5 sm:p-6 pb-4 border-b border-slate-100 flex items-start justify-between gap-4 bg-gradient-to-r from-amber-500/10 via-sky-500/5 to-transparent">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-amber-400 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-amber-400/25">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-800 leading-tight">Pilih Best Member of the Month</h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Periode <span class="font-bold text-slate-700">{{ $namaBulanIni }} {{ $tahunIni }}</span> · Cabang {{ Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa' }}
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeBestMemberModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition shrink-0 cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Content Modal (Scrollable) -->
            <div class="p-5 sm:p-6 overflow-y-auto space-y-6 flex-1 min-w-0">

                <!-- Info Box Kriteria / Status Kunci -->
                @if($isLocked)
                    <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-amber-900">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-lock text-amber-600 mt-0.5 text-sm shrink-0"></i>
                            <div>
                                <span class="font-bold text-amber-900">Pilihan Telah Terkunci:</span>
                                Best Member untuk bulan <span class="font-bold">{{ $namaBulanIni }} {{ $tahunIni }}</span> sudah resmi ditetapkan.
                            </div>
                        </div>
                        <form action="{{ route('admin.best_swimmer.reset') }}" method="POST" class="m-0 shrink-0" data-confirm="Apakah Anda yakin ingin membatalkan/mereset penetapan Best Member bulan ini? Status akan kembali menjadi Belum Ditetapkan.">
                            @csrf
                            <input type="hidden" name="tahun" value="{{ $tahunIni }}">
                            <input type="hidden" name="bulan" value="{{ $bulanIni }}">
                            <button type="submit" class="w-full sm:w-auto px-3.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                                <i class="fa-solid fa-arrow-rotate-left"></i> Batalkan Penetapan
                            </button>
                        </form>
                    </div>
                @else
                    <div class="p-3.5 rounded-2xl bg-sky-50 border border-sky-100 flex items-start gap-3 text-xs text-sky-900">
                        <i class="fa-solid fa-circle-info text-[#008cc9] mt-0.5 text-sm shrink-0"></i>
                        <div>
                            <span class="font-bold text-[#008cc9]">Kriteria Perhitungan Rekomendasi:</span>
                            Daftar Top 5 di bawah ini dihitung otomatis oleh sistem berdasarkan <span class="font-bold">Total Kehadiran</span> dan <span class="font-bold">Capaian Progres Renang</span> bulan {{ $namaBulanIni }} {{ $tahunIni }}. <span class="font-bold text-amber-700">Perhatian:</span> Penetapan hanya dapat dilakukan 1 kali dan tidak dapat diganti selama sebulan.
                        </div>
                    </div>
                @endif

                <!-- Bagian 1: Rekomendasi Top 5 Siswa -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <h4 class="text-sm font-bold text-slate-800">Rekomendasi Top 5 Kandidat Terbaik</h4>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Berdasarkan Kehadiran & Progres</span>
                    </div>

                    <div class="space-y-2.5">
                        @forelse($top5Kandidat as $index => $k)
                            @php
                                $isCurrentWinner = ($bestMember && $bestMember->id == $k->id);
                                $rankColors = [
                                    0 => ['bg' => 'bg-amber-100 text-amber-800 border-amber-300', 'icon' => 'fa-crown', 'label' => '#1'],
                                    1 => ['bg' => 'bg-slate-200 text-slate-700 border-slate-300', 'icon' => 'fa-medal', 'label' => '#2'],
                                    2 => ['bg' => 'bg-amber-50 text-amber-900 border-amber-200', 'icon' => 'fa-medal', 'label' => '#3'],
                                    3 => ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'icon' => 'fa-hashtag', 'label' => '4'],
                                    4 => ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'icon' => 'fa-hashtag', 'label' => '5'],
                                ];
                                $rk = $rankColors[$index] ?? ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'icon' => 'fa-hashtag', 'label' => (string)($index+1)];
                            @endphp

                            <div class="p-3 sm:p-3.5 rounded-2xl border {{ $isCurrentWinner ? 'border-amber-300 bg-amber-50/50 shadow-xs ring-2 ring-amber-300/40' : 'border-slate-200 bg-white hover:bg-slate-50/70 hover:border-slate-300' }} transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <!-- Rank Badge -->
                                    <div class="w-8 h-8 rounded-xl {{ $rk['bg'] }} border font-extrabold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                        @if($index === 0)
                                            <i class="fa-solid fa-crown text-[11px] text-amber-600 mr-0.5"></i>1
                                        @else
                                            {{ $rk['label'] }}
                                        @endif
                                    </div>

                                    <!-- Foto Siswa -->
                                    <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-200 shrink-0 bg-sky-50 flex items-center justify-center">
                                        @if(!empty($k->foto) && file_exists(public_path($k->foto)))
                                            <img src="{{ asset($k->foto) }}" alt="{{ $k->nama }}" class="w-full h-full object-cover">
                                        @elseif(!empty($k->foto) && file_exists(public_path('storage/' . $k->foto)))
                                            <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="font-extrabold text-xs text-[#008cc9]">{{ strtoupper(substr($k->nama ?? 'S', 0, 2)) }}</span>
                                        @endif
                                    </div>

                                    <!-- Info Siswa & Statistik -->
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <div class="text-sm font-bold text-slate-800 truncate" title="{{ $k->nama }}">
                                                {{ $k->nama }}
                                            </div>
                                            @if($isCurrentWinner)
                                                <span class="px-2 py-0.5 rounded-full bg-amber-400 text-white font-extrabold text-[10px] tracking-wide shrink-0">
                                                    Best Member
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5 truncate">
                                            {{ $k->nama_kelas }}
                                        </div>
                                        
                                        <!-- Metrik Kehadiran & Progres -->
                                        <div class="flex flex-wrap items-center gap-2 mt-1.5 text-[11px]">
                                            <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                                <i class="fa-solid fa-calendar-check text-emerald-500 text-[10px]"></i> {{ $k->total_hadir }}x Hadir
                                            </span>
                                            <span class="inline-flex items-center gap-1 font-semibold text-[#008cc9] bg-sky-50 px-2 py-0.5 rounded-md border border-sky-100">
                                                <i class="fa-solid fa-chart-line text-[10px]"></i> {{ round($k->progres_pct) }}% Progres
                                            </span>
                                            <span class="inline-flex items-center gap-1 font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-100" title="Skor gabungan kehadiran & capaian teknik">
                                                <i class="fa-solid fa-star text-amber-500 text-[10px]"></i> Skor: {{ number_format($k->skor_utama, 1) }}
                                            </span>
                                            @if(!empty($k->pernah_bm) && $k->pernah_bm > 0)
                                                <span class="text-[10px] text-slate-400" title="Pernah menang di bulan sebelumnya">
                                                    (Pernah {{ $k->pernah_bm }}x)
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="shrink-0 sm:self-center pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 flex sm:justify-end">
                                    @if($isCurrentWinner)
                                        <div class="w-full sm:w-auto px-3.5 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-xs flex items-center justify-center gap-1.5">
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Terpilih
                                        </div>
                                    @elseif($isLocked)
                                        <div class="w-full sm:w-auto px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs flex items-center justify-center gap-1.5 cursor-not-allowed">
                                            <i class="fa-solid fa-lock text-[10px]"></i> Terkunci
                                        </div>
                                    @else
                                        <form action="{{ route('admin.best_swimmer.store') }}" method="POST" class="w-full sm:w-auto m-0" data-confirm="Apakah Anda yakin ingin menetapkan {{ $k->nama }} sebagai Best Member of the Month? Pilihan ini hanya dapat dilakukan 1 kali dan tidak dapat diganti selama sebulan.">
                                            @csrf
                                            <input type="hidden" name="id_siswa" value="{{ $k->id }}">
                                            <input type="hidden" name="tahun" value="{{ $tahunIni }}">
                                            <input type="hidden" name="bulan" value="{{ $bulanIni }}">
                                            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-[#008cc9] hover:bg-[#0077ab] text-white font-bold text-xs shadow-xs hover:shadow transition cursor-pointer flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-award"></i> Pilih Siswa Ini
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center rounded-2xl bg-slate-50 border border-slate-200 text-slate-400 text-xs">
                                <i class="fa-solid fa-user-xmark text-2xl mb-2 text-slate-300"></i>
                                <div>Belum ada data siswa aktif yang dinilai untuk cabang ini pada bulan {{ $namaBulanIni }} {{ $tahunIni }}.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if(!$isLocked)
                <!-- Bagian 2: Atau Pilih dari Seluruh Siswa Cabang Ini -->
                <div class="pt-3 border-t border-slate-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Atau Pilih Siswa Lainnya di Cabang Ini</h4>
                    </div>
                    <form action="{{ route('admin.best_swimmer.store') }}" method="POST" class="space-y-3" data-confirm="Apakah Anda yakin ingin menetapkan siswa pilihan Anda sebagai Best Member? Pilihan ini hanya dapat dilakukan 1 kali dan tidak dapat diganti selama sebulan.">
                        @csrf
                        <input type="hidden" name="tahun" value="{{ $tahunIni }}">
                        <input type="hidden" name="bulan" value="{{ $bulanIni }}">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <div class="sm:col-span-2">
                                <select name="id_siswa" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#008cc9] text-xs font-medium text-slate-700 bg-white">
                                    <option value="">-- Pilih Siswa Cabang Ini (A-Z) --</option>
                                    @foreach($allKandidatSiswa as $ks)
                                        <option value="{{ $ks->id }}" {{ ($bestMember && $bestMember->id == $ks->id) ? 'selected' : '' }}>
                                            {{ $ks->nama }} ({{ $ks->nama_kelas }}) · Hadir: {{ $ks->total_hadir }}x · Progres: {{ round($ks->progres_pct) }}%
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="w-full py-2.5 px-4 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl transition cursor-pointer flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-check"></i> Tetapkan Pilihan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

            </div>

            <!-- Footer Modal -->
            <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/70 flex justify-end">
                <button type="button" onclick="closeBestMemberModal()" class="py-2 px-5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    @include('components.logout-modal')
</body>
</html>
