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
    </style>
    <title>Manajemen Siswa - Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        <!-- Flash Alert Notification -->
        @if(session('sukses'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-800 flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="font-medium">{{ session('sukses') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
                    <span>Terdapat kesalahan pengisian data:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Manajemen Siswa</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data siswa dan pendaftar baru</p>
        </div>

        <!-- Banner Alert Pendaftar Menunggu Verifikasi -->
        @if($total_pending > 0)
            <div class="mb-8 p-5 bg-amber-50/90 border border-amber-200/80 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-amber-100 border border-amber-300 text-amber-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-exclamation text-base"></i>
                    </div>
                    <div>
                        <span class="font-bold text-amber-900 text-sm"><span class="text-amber-600">{{ $total_pending }} pendaftar baru</span> menunggu verifikasi</span>
                    </div>
                </div>
                <a href="#tabelPendaftarBaru" class="bg-amber-400 hover:bg-amber-500 text-amber-950 text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 shrink-0">
                    <i class="fa-regular fa-eye text-xs"></i>
                    <span>Lihat Pendaftar</span>
                </a>
            </div>
        @endif

        <!-- KPI Summary Cards Jumlah Siswa (4 Cards) -->
        <div class="flex overflow-x-auto pb-3 pt-1 gap-3 snap-x snap-mandatory scroll-smooth no-scrollbar md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-5 md:pb-0 md:pt-0 mb-8">
            <!-- Card 1: Total Siswa Aktif -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-[#00a5ec] relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Siswa Aktif</p>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-[#093c56] mt-1 truncate">
                            {{ $total_siswa ?? count($data_siswa) }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-sky-50 flex items-center justify-center text-[#00a5ec] text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#00a5ec]"></span> Aktif
                </p>
            </div>

            <!-- Card 2: Level Pemula -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-emerald-500 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Level Pemula</p>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-[#093c56] mt-1 truncate">
                            {{ $siswa_pemula ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-person-swimming"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span> Tingkat pemula
                </p>
            </div>

            <!-- Card 3: Level Lanjutan -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-cyan-500 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Level Lanjutan</p>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-[#093c56] mt-1 truncate">
                            {{ $siswa_lanjutan ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600 text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-award"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-cyan-500"></span> Tingkat lanjutan
                </p>
            </div>

            <!-- Card 4: Level Senior -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-amber-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Level Senior</p>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-[#093c56] mt-1 truncate">
                            {{ $siswa_senior ?? 0 }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-amber-400"></span> Tingkat senior
                </p>
            </div>
        </div>

        <!-- Container 1: Daftar Siswa Aktif Card Table -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Daftar Siswa Aktif</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Klik baris untuk melihat detail siswa</p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <!-- Search Input Bar Siswa -->
                    <div class="relative w-full sm:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" id="searchSiswaInput" oninput="filterSiswaTable()" value="{{ request('search_siswa') }}" placeholder="Cari nama, ID, kelas..."
                            class="w-full pl-9 pr-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                    </div>
                    <button type="button" onclick="exportDataSiswa()" title="Download Data Master Siswa (CSV)" class="bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2 group">
                        <i class="fa-solid fa-download text-xs text-[#00a5ec] group-hover:scale-110 transition-transform"></i>
                        <span>Export</span>
                    </button>
                    <button type="button" onclick="openModal('modalTambahSiswa')" class="bg-[#00a5ec] hover:bg-[#0092d1] active:scale-[0.98] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Siswa</span>
                    </button>
                </div>
            </div>

            <!-- Table Data Siswa Aktif -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-4">ID Siswa</th>
                            <th class="py-3.5 px-4">Nama Lengkap</th>
                            <th class="py-3.5 px-4">Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data_siswa as $siswa)
                            @php
                                $formattedId = 'GD' . str_pad($siswa->id_siswa, 3, '0', STR_PAD_LEFT);
                                $tingkatLabel = ucfirst($siswa->tingkat_kelas ?? 'pemula');

                                // Statistik absensi & pencapaian
                                $riwayatAbsensi = isset($absensi_per_siswa) ? $absensi_per_siswa->get($siswa->id_siswa, collect([])) : collect([]);
                                $riwayatPencapaian = isset($pencapaian_per_siswa) ? $pencapaian_per_siswa->get($siswa->id_siswa, collect([])) : collect([]);

                                $jmlHadir = $riwayatAbsensi->where('status_kehadiran', 'hadir')->count();
                                $jmlIzin  = $riwayatAbsensi->where('status_kehadiran', 'izin')->count();
                                $jmlSakit = $riwayatAbsensi->where('status_kehadiran', 'sakit')->count();
                                $jmlAlpha = $riwayatAbsensi->where('status_kehadiran', 'tidak_hadir')->count();
                                $totalSesi = $riwayatAbsensi->count();
                                $persenHadir = $totalSesi > 0 ? round(($jmlHadir / $totalSesi) * 100) : 0;

                                $siswaDetailPayload = [
                                    'id'                      => $siswa->id_siswa,
                                    'formatted_id'            => $formattedId,
                                    'nama'                    => $siswa->nama_siswa,
                                    'tempat_lahir'            => $siswa->tempat_lahir ?? '-',
                                    'tanggal_lahir_raw'       => $siswa->tanggal_lahir ?? '',
                                    'tanggal_lahir_formatted' => $siswa->tanggal_lahir ? date('d/m/Y', strtotime($siswa->tanggal_lahir)) : '-',
                                    'umur'                    => $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->age : null,
                                    'jenis_kelamin'           => $siswa->jenis_kelamin ?? 'laki-laki',
                                    'tingkat_kelas'           => $siswa->tingkat_kelas ?? 'Pemula A',
                                    'sekolah'                 => $siswa->sekolah ?? '-',
                                    'tanggal_masuk_formatted' => $siswa->tanggal_masuk ? date('d/m/Y', strtotime($siswa->tanggal_masuk)) : '-',
                                    'riwayat_penyakit'        => $siswa->riwayat_penyakit ?: '-',
                                    'catatan_khusus'          => $siswa->catatan_khusus ?: '-',
                                    'id_kelas'                => $siswa->id_kelas,
                                    'id_cabang'               => $siswa->id_cabang,
                                    'nama_kelas'              => $siswa->nama_kelas ?? 'Pemula A',
                                    'nama_cabang'             => $siswa->nama_cabang ?? 'Kemang',
                                    'foto'                    => ($siswa->foto && file_exists(public_path($siswa->foto))) ? asset($siswa->foto) : null,
                                    'orang_tua'               => [
                                        'nama'   => $siswa->nama_orang_tua ?? '-',
                                        'email'  => $siswa->email_orang_tua ?? '-',
                                        'no_hp'  => $siswa->no_hp_orang_tua ?? '-',
                                        'alamat' => $siswa->alamat_orang_tua ?? '-',
                                    ],
                                    'absensi'                 => [
                                        'hadir'   => $jmlHadir,
                                        'izin'    => $jmlIzin,
                                        'sakit'   => $jmlSakit,
                                        'alpha'   => $jmlAlpha,
                                        'total'   => $totalSesi,
                                        'persen'  => $persenHadir,
                                        'riwayat' => $riwayatAbsensi->map(fn($a) => [
                                            'tanggal'    => $a->tanggal_kehadiran,
                                            'status'     => $a->status_kehadiran,
                                            'keterangan' => $a->keterangan ?? '-',
                                        ])->values(),
                                    ],
                                    'pencapaian'              => $riwayatPencapaian->map(fn($p) => [
                                        'gaya_renang'   => $p->gaya_renang,
                                        'catatan_waktu' => $p->catatan_waktu ?? '-',
                                        'teknik'        => (int)$p->teknik,
                                        'kecepatan'     => (int)$p->kecepatan,
                                        'ketahanan'     => (int)$p->ketahanan,
                                        'catatan'       => $p->catatan ?? '-',
                                        'kejuaraan'     => $p->kejuaraan ?? null,
                                        'tanggal_raw'   => $p->tanggal_catat ? date('Y-m-d', strtotime($p->tanggal_catat)) : null,
                                        'tanggal_catat' => $p->tanggal_catat ? date('d/m/Y', strtotime($p->tanggal_catat)) : '-',
                                    ])->values(),
                                ];
                            @endphp
                            @php
                                $searchDataStr = strtolower($formattedId . ' ' . $siswa->nama_siswa . ' ' . ($siswa->nama_kelas ?? '') . ' ' . ($siswa->tingkat_kelas ?? '') . ' ' . ($siswa->nama_cabang ?? '') . ' ' . ($siswa->sekolah ?? ''));
                            @endphp
                            <tr class="hover:bg-sky-50/50 hover:shadow-xs transition cursor-pointer group row-siswa-item"
                                style="{{ $loop->index >= 15 ? 'display: none;' : '' }}"
                                data-search="{{ $searchDataStr }}"
                                onclick="openDetailSiswa({{ json_encode($siswaDetailPayload) }})">
                                <td class="py-3.5 px-4 font-semibold text-[#00a5ec] whitespace-nowrap">{{ $formattedId }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-800">
                                    <div class="flex items-center gap-2.5">
                                        @if($siswa->foto && file_exists(public_path($siswa->foto)))
                                            <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama_siswa }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-cyan-100 text-[#008cc9] font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="truncate">
                                            <div class="group-hover:text-[#008cc9] transition">{{ $siswa->nama_siswa }}</div>
                                            @if($siswa->tempat_lahir || $siswa->tanggal_lahir)
                                                <div class="text-[10px] text-slate-400 font-normal truncate">
                                                    {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? date('d/m/Y', strtotime($siswa->tanggal_lahir)) : '-' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-[#008cc9] border border-sky-100">
                                        {{ $siswa->tingkat_kelas ?? $siswa->nama_kelas ?? 'Pemula A' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400">
                                    Belum ada siswa aktif terdaftar.
                                </td>
                            </tr>
                        @endforelse
                        <tr id="siswaNotFoundRow" class="hidden">
                            <td colspan="3" class="py-10 text-center text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-2xl text-slate-300 mb-2 block"></i>
                                Tidak ada data siswa yang cocok dengan kata kunci pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer Siswa (15 baris per halaman) -->
            <div id="siswaPaginationContainer" class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-5 mt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500 font-medium">
                    Menampilkan <span id="siswaPageStart" class="font-bold text-slate-700">1</span> - <span id="siswaPageEnd" class="font-bold text-slate-700">{{ min(15, count($data_siswa)) }}</span> dari <span id="siswaTotalRows" class="font-bold text-slate-700">{{ count($data_siswa) }}</span> siswa
                </p>
                <div class="flex items-center gap-1.5 flex-wrap justify-center" id="siswaPaginationButtons">
                    <!-- Tombol halaman di-generate via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Container 2: Monitoring Absensi Sesi Latihan -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-8">

            <!-- Header & Filter -->
            <div class="flex flex-col gap-4 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            <span class="w-7 h-7 bg-[#00a5ec]/10 text-[#00a5ec] rounded-lg flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </span>
                            Monitoring Absensi Sesi Latihan
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5 ml-9">Pantau kehadiran siswa per sesi latihan — klik baris untuk lihat detail</p>
                    </div>
                    <button type="button" onclick="openModalExportAbsensi('sesi')" class="self-start sm:self-auto bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2 shrink-0 group">
                        <i class="fa-solid fa-download text-xs text-[#00a5ec] group-hover:scale-110 transition-transform"></i>
                        <span>Export Absensi</span>
                    </button>
                </div>

                <!-- Filter Bar -->
                <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex flex-wrap items-end justify-end gap-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    @foreach(request()->except(['bulan_absensi','tahun_absensi','filter_kelas_absensi']) as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach

                    <div class="flex flex-col gap-1 min-w-[110px]">
                        <label class="text-[10px] font-semibold text-slate-500 uppercase tracking-wide">Bulan</label>
                        <select name="bulan_absensi" class="bg-white border border-slate-200 rounded-xl text-xs text-slate-700 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] transition">
                            @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $nama)
                                <option value="{{ $num }}" {{ $bulan_absensi == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-1 min-w-[90px]">
                        <label class="text-[10px] font-semibold text-slate-500 uppercase tracking-wide">Tahun</label>
                        <select name="tahun_absensi" class="bg-white border border-slate-200 rounded-xl text-xs text-slate-700 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] transition">
                            @foreach($listTahunAbsensi ?? [date('Y')] as $y)
                                <option value="{{ $y }}" {{ $tahun_absensi == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-1 min-w-[120px]">
                        <label class="text-[10px] font-semibold text-slate-500 uppercase tracking-wide">Kelas</label>
                        <select name="filter_kelas_absensi" class="bg-white border border-slate-200 rounded-xl text-xs text-slate-700 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] transition">
                            <option value="">Semua Kelas</option>
                            @foreach($master_kelas as $k)
                                <option value="{{ $k->id }}" {{ $filter_kelas_absensi == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-[#00a5ec] hover:bg-[#0092d1] text-white text-xs font-semibold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 active:scale-[0.98]">
                        <i class="fa-solid fa-filter text-xs"></i>
                        Terapkan
                    </button>
                    @if(request()->hasAny(['bulan_absensi','tahun_absensi','filter_kelas_absensi']))
                        <a href="{{ route('admin.siswa.index') }}" class="text-xs text-slate-400 hover:text-rose-500 py-2.5 flex items-center gap-1 transition">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- KPI Ringkasan Bulan -->
            @php
                $namabulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            @endphp
            <div class="flex overflow-x-auto gap-3 pb-3 no-scrollbar sm:grid sm:grid-cols-5 sm:gap-4 sm:pb-0 mb-6">
                <div class="shrink-0 min-w-[140px] sm:min-w-0 bg-gradient-to-br from-[#00a5ec] to-[#0088cc] text-white rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                    <p class="text-[10px] font-semibold uppercase tracking-wider opacity-80">Total Sesi</p>
                    <p class="text-2xl font-extrabold mt-1">{{ $rekap_bulan['total_sesi'] }}</p>
                    <p class="text-[10px] opacity-70 mt-1">{{ $namabulan[$bulan_absensi] ?? '' }} {{ $tahun_absensi }}</p>
                </div>
                <div class="shrink-0 min-w-[140px] sm:min-w-0 bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-semibold text-emerald-600 uppercase tracking-wider">Hadir</p>
                        <i class="fa-solid fa-check-circle text-emerald-400 text-sm"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-emerald-700 mt-1">{{ $rekap_bulan['total_hadir'] }}</p>
                    <p class="text-[10px] text-emerald-500 mt-1">entri kehadiran</p>
                </div>
                <div class="shrink-0 min-w-[140px] sm:min-w-0 bg-amber-50 border border-amber-100 rounded-2xl p-4 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-semibold text-amber-600 uppercase tracking-wider">Izin</p>
                        <i class="fa-solid fa-file-circle-minus text-amber-400 text-sm"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-amber-700 mt-1">{{ $rekap_bulan['total_izin'] }}</p>
                    <p class="text-[10px] text-amber-500 mt-1">entri izin</p>
                </div>
                <div class="shrink-0 min-w-[140px] sm:min-w-0 bg-sky-50 border border-sky-100 rounded-2xl p-4 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-semibold text-sky-600 uppercase tracking-wider">Sakit</p>
                        <i class="fa-solid fa-heart-pulse text-sky-400 text-sm"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-sky-700 mt-1">{{ $rekap_bulan['total_sakit'] }}</p>
                    <p class="text-[10px] text-sky-500 mt-1">entri sakit</p>
                </div>
                <div class="shrink-0 min-w-[140px] sm:min-w-0 bg-rose-50 border border-rose-100 rounded-2xl p-4 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-semibold text-rose-600 uppercase tracking-wider">Alpha</p>
                        <i class="fa-solid fa-circle-xmark text-rose-400 text-sm"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-rose-700 mt-1">{{ $rekap_bulan['total_absen'] }}</p>
                    <p class="text-[10px] text-rose-500 mt-1">tidak hadir</p>
                </div>
            </div>

            <!-- Tabel Sesi Latihan -->
            @if($absensi_per_sesi->isEmpty())
                <div class="py-14 text-center">
                    <i class="fa-regular fa-calendar-xmark text-4xl text-slate-200 mb-3 block"></i>
                    <p class="text-sm font-semibold text-slate-400">Belum ada data absensi</p>
                    <p class="text-xs text-slate-300 mt-1">untuk {{ $namabulan[$bulan_absensi] ?? '' }} {{ $tahun_absensi }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="py-3.5 px-4">Tanggal Sesi</th>
                                <th class="py-3.5 px-4">Kelas</th>
                                <th class="py-3.5 px-4 text-center">Total Siswa</th>
                                <th class="py-3.5 px-4 text-center">
                                    <span class="text-emerald-600">Hadir</span>
                                </th>
                                <th class="py-3.5 px-4 text-center">
                                    <span class="text-amber-600">Izin</span>
                                </th>
                                <th class="py-3.5 px-4 text-center">
                                    <span class="text-sky-600">Sakit</span>
                                </th>
                                <th class="py-3.5 px-4 text-center">
                                    <span class="text-rose-600">Alpha</span>
                                </th>
                                <th class="py-3.5 px-4 text-center">% Hadir</th>
                                <th class="py-3.5 px-4 text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($absensi_per_sesi as $idx => $sesi)
                                @php
                                    $pctHadir = $sesi['total'] > 0 ? round(($sesi['hadir'] / $sesi['total']) * 100) : 0;
                                    $barColor = $pctHadir >= 80 ? 'bg-emerald-400' : ($pctHadir >= 50 ? 'bg-amber-400' : 'bg-rose-400');
                                    $hariIndo = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
                                    $hariNama = $hariIndo[date('l', strtotime($sesi['tanggal']))] ?? date('l', strtotime($sesi['tanggal']));
                                    $sesiJson = json_encode($sesi['detail']->map(fn($d) => [
                                        'nama'         => $d->nama_siswa,
                                        'status'       => $d->status_kehadiran,
                                        'keterangan'   => $d->keterangan ?? '-',
                                        'kelas'        => $d->nama_kelas ?? $d->tingkat_kelas ?? '-',
                                        'cabang'       => $d->nama_cabang ?? '-',
                                    ])->values());
                                    $tanggalFmt = date('d M Y', strtotime($sesi['tanggal']));
                                @endphp
                                <tr class="hover:bg-sky-50/40 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-slate-800">{{ $tanggalFmt }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $hariNama }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-sky-50 text-[#008cc9] border border-sky-100 shadow-2xs">
                                            <i class="fa-solid fa-graduation-cap mr-1.5 text-sky-500 text-[11px]"></i>
                                            {{ $sesi['nama_kelas'] ?? 'Kelas Renang' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="font-semibold text-slate-700">{{ $sesi['total'] }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 font-extrabold">{{ $sesi['hadir'] }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-50 text-amber-600 font-extrabold">{{ $sesi['izin'] }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-sky-50 text-sky-600 font-extrabold">{{ $sesi['sakit'] }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-rose-50 text-rose-500 font-extrabold">{{ $sesi['tidak_hadir'] }}</span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="h-2 rounded-full {{ $barColor }} transition-all duration-500" style="width: {{ $pctHadir }}%"></div>
                                            </div>
                                            <span class="text-[11px] font-bold {{ $pctHadir >= 80 ? 'text-emerald-600' : ($pctHadir >= 50 ? 'text-amber-600' : 'text-rose-500') }} w-9 text-right shrink-0">{{ $pctHadir }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <button type="button"
                                            onclick="openDetailSesi('{{ $tanggalFmt }}', '{{ $hariNama }}', {{ $sesi['total'] }}, {{ $sesi['hadir'] }}, {{ $sesi['izin'] }}, {{ $sesi['sakit'] }}, {{ $sesi['tidak_hadir'] }}, {{ $pctHadir }}, {{ $sesiJson }}, '{{ $sesi['tanggal'] }}', '{{ addslashes($sesi['nama_kelas'] ?? 'Kelas Renang') }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#00a5ec]/10 hover:bg-[#00a5ec]/20 text-[#00a5ec] rounded-lg text-[11px] font-semibold transition">
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                            Lihat
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Modal Detail Sesi Latihan -->
        <div id="modalDetailSesi" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
            <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 shadow-2xl border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b border-slate-100 shrink-0">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-7 h-7 bg-[#00a5ec]/10 text-[#00a5ec] rounded-lg flex items-center justify-center text-sm shrink-0">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </span>
                            <h3 class="text-base font-bold text-slate-800" id="sesiModalTitle">Detail Sesi Latihan</h3>
                        </div>
                        <p class="text-xs text-slate-400 ml-9" id="sesiModalSubtitle">-</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="exportSesiIni()" title="Export Absensi Sesi Ini ke CSV" class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-download text-xs text-[#00a5ec]"></i>
                            <span>Export Sesi</span>
                        </button>
                        <button type="button" onclick="closeModal('modalDetailSesi')" class="text-slate-400 hover:text-slate-600 text-lg p-1 rounded-lg hover:bg-slate-100 transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal KPI mini -->
                <div class="grid grid-cols-4 gap-3 p-6 shrink-0 bg-slate-50 border-b border-slate-100">
                    <div class="text-center">
                        <div class="text-xl font-extrabold text-[#00a5ec]" id="sesiKpiTotal">-</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">Total</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-extrabold text-emerald-600" id="sesiKpiHadir">-</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">Hadir</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-extrabold text-amber-600" id="sesiKpiIzin">-</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">Izin/Sakit</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-extrabold text-rose-500" id="sesiKpiAlpha">-</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">Alpha</div>
                    </div>
                </div>

                <!-- Progress bar besar -->
                <div class="px-6 pt-4 pb-2 shrink-0">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-semibold text-slate-600">Tingkat Kehadiran</span>
                        <span class="text-sm font-extrabold" id="sesiKpiPct">-%</span>
                    </div>
                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div id="sesiProgressBar" class="h-3 rounded-full bg-emerald-400 transition-all duration-700" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Search & Filter status di dalam modal -->
                <div class="px-6 pt-3 pb-2 shrink-0 flex items-center gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                        <input type="text" id="sesiDetailSearch" oninput="filterSesiDetail()" placeholder="Cari nama siswa..."
                            class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                    </div>
                    <select id="sesiDetailFilter" onchange="filterSesiDetail()" class="bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] transition">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="tidak_hadir">Alpha</option>
                    </select>
                </div>

                <!-- Tabel Detail Peserta -->
                <div class="overflow-y-auto flex-1 px-6 pb-6">
                    <table class="w-full text-left text-xs text-slate-700 mt-2">
                        <thead class="sticky top-0 bg-white border-b border-slate-100 z-10">
                            <tr>
                                <th class="py-2.5 pr-4 font-bold text-slate-500 uppercase tracking-wider text-[10px]">#</th>
                                <th class="py-2.5 pr-4 font-bold text-slate-500 uppercase tracking-wider text-[10px]">Nama Siswa</th>
                                <th class="py-2.5 pr-4 font-bold text-slate-500 uppercase tracking-wider text-[10px]">Kelas</th>
                                <th class="py-2.5 font-bold text-slate-500 uppercase tracking-wider text-[10px]">Status</th>
                                <th class="py-2.5 font-bold text-slate-500 uppercase tracking-wider text-[10px]">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="sesiDetailBody" class="divide-y divide-slate-50">
                        </tbody>
                    </table>
                    <div id="sesiDetailEmpty" class="hidden py-8 text-center text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass text-slate-300 text-xl mb-2 block"></i>
                        Tidak ada data yang cocok.
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Export Absensi Siswa (Rentang & Kriteria Kustom) -->
        <div id="modalExportAbsensi" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
            <div class="bg-white rounded-2xl w-full max-w-lg mx-4 shadow-2xl border border-slate-100 flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b border-slate-100 shrink-0">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 bg-[#00a5ec]/10 text-[#00a5ec] rounded-xl flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-file-excel"></i>
                        </span>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Export Rekap Absensi Siswa</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Atur rentang waktu tanggal sebelum diexport</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('modalExportAbsensi')" class="text-slate-400 hover:text-slate-600 text-lg p-1 rounded-lg hover:bg-slate-100 transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Form Export -->
                <form id="formExportSiswa" method="GET" action="{{ route('admin.siswa.absensi.export') }}" target="_blank" class="p-6 space-y-4">
                    <!-- Pilihan Format Export: Rekap per Siswa vs Log per Sesi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilihan Format Export</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="relative flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                                <input type="radio" name="format" id="radioExportRekap" value="rekap" onchange="switchExportFormat('rekap')" checked class="text-[#00a5ec] focus:ring-[#00a5ec] mr-2.5">
                                <div>
                                    <span class="block text-xs font-bold text-slate-800">Rekap Per Siswa</span>
                                    <span class="block text-[10px] text-slate-400">Total hadir, izin, sakit, alfa</span>
                                </div>
                            </label>
                            <label class="relative flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                                <input type="radio" name="format" id="radioExportSesi" value="sesi" onchange="switchExportFormat('sesi')" class="text-[#00a5ec] focus:ring-[#00a5ec] mr-2.5">
                                <div>
                                    <span class="block text-xs font-bold text-slate-800">Log Per Sesi</span>
                                    <span class="block text-[10px] text-slate-400">Rincian absensi harian per sesi</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Rentang Tanggal -->
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-slate-700">Rentang Tanggal</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Dari Tanggal (Mulai)</label>
                                <input type="date" name="start_date" id="exportStartDate"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Sampai Tanggal (Selesai)</label>
                                <input type="date" name="end_date" id="exportEndDate"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>
                        </div>

                        <!-- Tombol Shortcut Rentang Cepat -->
                        <div class="flex items-center gap-1.5 flex-wrap pt-1">
                            <span class="text-[10px] text-slate-400 font-semibold mr-1">Preset:</span>
                            <button type="button" onclick="setQuickRange('7d')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">7 Hari Terakhir</button>
                            <button type="button" onclick="setQuickRange('30d')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">30 Hari Terakhir</button>
                            <button type="button" onclick="setQuickRange('this_month')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">Bulan Ini</button>
                            <button type="button" onclick="setQuickRange('last_month')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">Bulan Lalu</button>
                            <button type="button" onclick="setQuickRange('all')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">Semua Tanggal</button>
                        </div>
                    </div>

                    <!-- Info box -->
                    <div class="p-3 bg-sky-50/60 border border-sky-100 rounded-xl flex items-start gap-2.5 text-xs text-slate-600">
                        <i class="fa-solid fa-circle-info text-[#00a5ec] mt-0.5 text-sm shrink-0"></i>
                        <p id="exportInfoText" class="text-[11px] leading-relaxed">
                            Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat rangkuman per siswa: Nama Siswa, Kelas, Total Hadir, Total Izin, Total Sakit, dan Total Alfa.
                        </p>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="closeModal('modalExportAbsensi')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-[#00a5ec] hover:bg-[#0092d1] active:scale-[0.98] text-white rounded-xl text-xs font-semibold shadow-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-file-arrow-down text-sm"></i>
                            <span>Download File Export</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Container 3: Pendaftar Baru (Menunggu Verifikasi) Card Table -->
        <div id="tabelPendaftarBaru" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 border-t-4 border-t-amber-400">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Pendaftar Baru (Menunggu Verifikasi)</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Klik baris atau tombol Detail untuk memeriksa seluruh data sebelum di-ACC</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        {{ $total_pending }} Menunggu Review
                    </span>
                </div>
            </div>

            <!-- Table Data Pendaftar Pending -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-4">Tanggal Daftar</th>
                            <th class="py-3.5 px-4">Nama Lengkap</th>
                            <th class="py-3.5 px-4">Umur</th>
                            <th class="py-3.5 px-4">Plotting Kelas</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendaftaran_pending as $pending)
                            @php
                                $age = $pending->tanggal_lahir ? \Carbon\Carbon::parse($pending->tanggal_lahir)->age : '-';
                                $fotoUrl = $pending->foto_siswa ? (str_starts_with($pending->foto_siswa, 'uploads/') ? asset($pending->foto_siswa) : (file_exists(public_path('uploads/pendaftaran/foto/' . $pending->foto_siswa)) ? asset('uploads/pendaftaran/foto/' . $pending->foto_siswa) : asset($pending->foto_siswa))) : '';
                                $buktiUrl = $pending->bukti_pembayaran ? (str_starts_with($pending->bukti_pembayaran, 'uploads/') ? asset($pending->bukti_pembayaran) : (file_exists(public_path('uploads/pendaftaran/bukti/' . $pending->bukti_pembayaran)) ? asset('uploads/pendaftaran/bukti/' . $pending->bukti_pembayaran) : asset($pending->bukti_pembayaran))) : '';
                                $suratUrl = $pending->surat_perjanjian ? (str_starts_with($pending->surat_perjanjian, 'uploads/') ? asset($pending->surat_perjanjian) : (file_exists(public_path('uploads/pendaftaran/perjanjian/' . $pending->surat_perjanjian)) ? asset('uploads/pendaftaran/perjanjian/' . $pending->surat_perjanjian) : asset($pending->surat_perjanjian))) : '';

                                $pendingJson = json_encode([
                                    'id'                 => $pending->id,
                                    'nama_siswa'         => $pending->nama_siswa,
                                    'tempat_lahir'       => $pending->tempat_lahir ?? '-',
                                    'tanggal_lahir'      => $pending->tanggal_lahir ?? '',
                                    'tanggal_lahir_fmt'  => $pending->tanggal_lahir ? date('d M Y', strtotime($pending->tanggal_lahir)) : '-',
                                    'umur'               => $age,
                                    'sekolah'            => $pending->sekolah ?? '-',
                                    'nama_kelas'         => $pending->nama_kelas ?? 'Pemula A',
                                    'nama_cabang'        => $pending->nama_cabang ?? 'Kemang',
                                    'riwayat_penyakit'   => $pending->riwayat_penyakit ?? '-',
                                    'catatan_khusus'     => $pending->catatan_khusus ?? '-',
                                    'nama_orang_tua'     => $pending->nama_orang_tua ?? '-',
                                    'no_hp'              => $pending->no_hp ?? '-',
                                    'email'              => $pending->email ?? '-',
                                    'alamat'             => $pending->alamat ?? '-',
                                    'pilihan_pembayaran' => $pending->pilihan_pembayaran ?? 'cash',
                                    'foto_siswa'         => $fotoUrl,
                                    'bukti_pembayaran'   => $buktiUrl,
                                    'surat_perjanjian'   => $suratUrl,
                                    'created_at_fmt'     => date('d M Y, H:i', strtotime($pending->created_at)) . ' WIB',
                                ]);
                            @endphp
                            <tr class="hover:bg-amber-50/50 cursor-pointer transition group" onclick="openDetailPendaftar({{ $pendingJson }})">
                                <td class="py-3.5 px-4 font-medium text-slate-500">{{ date('d M Y', strtotime($pending->created_at)) }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-800">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs shrink-0">
                                            {{ strtoupper(substr($pending->nama_siswa, 0, 1)) }}
                                        </div>
                                        <span class="group-hover:text-[#008cc9] transition">{{ $pending->nama_siswa }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">{{ $age }} tahun</td>
                                <td class="py-3.5 px-4 font-medium text-slate-600" onclick="event.stopPropagation()">
                                    @php
                                        $cabangKelas = $master_kelas->where('id_cabang', $pending->id_cabang);
                                        if ($cabangKelas->isEmpty()) {
                                            $cabangKelas = $master_kelas;
                                        }
                                    @endphp
                                    <select name="id_kelas" form="form-acc-{{ $pending->id }}" class="text-xs py-1.5 px-2 bg-sky-50/80 border border-sky-200 rounded-lg font-bold text-[#008cc9] focus:outline-none focus:ring-1 focus:ring-[#00a5ec] cursor-pointer shadow-2xs">
                                        @foreach($cabangKelas as $k)
                                            <option value="{{ $k->id }}" {{ ($pending->id_kelas == $k->id || str_contains(strtolower($k->nama), 'pemula a')) ? 'selected' : '' }}>
                                                {{ $k->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-3.5 px-4" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Form ACC / Terima & Plotting -->
                                        <form id="form-acc-{{ $pending->id }}" action="{{ route('admin.siswa.acc', $pending->id) }}" method="POST">
                                            @csrf
                                            <button type="button" onclick="konfirmasiAccPendaftar('form-acc-{{ $pending->id }}', '{{ addslashes($pending->nama_siswa) }}')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-3.5 py-1.5 rounded-lg transition flex items-center gap-1.5 shadow-sm cursor-pointer whitespace-nowrap" title="Setujui dan plotting ke siswa aktif">
                                                <i class="fa-solid fa-check text-xs"></i>
                                                <span>ACC</span>
                                            </button>
                                        </form>

                                        <!-- Form Tolak -->
                                        <form id="form-tolak-{{ $pending->id }}" action="{{ route('admin.siswa.tolak', $pending->id) }}" method="POST">
                                            @csrf
                                            <button type="button" onclick="konfirmasiTolakPendaftar('form-tolak-{{ $pending->id }}', '{{ addslashes($pending->nama_siswa) }}')" class="border border-rose-300 text-rose-600 hover:bg-rose-50 font-semibold text-xs px-3.5 py-1.5 rounded-lg transition flex items-center gap-1.5 cursor-pointer" title="Tolak pendaftaran ini">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Tidak ada pendaftaran baru yang menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal Tambah Siswa Baru -->
    <div id="modalTambahSiswa" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-[#00a5ec]">Tambah Siswa Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Lengkapi data siswa untuk mendaftar</p>
                </div>
                <button type="button" onclick="closeModal('modalTambahSiswa')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf

                <!-- Nama Lengkap Siswa -->
                <div>
                    <label for="nama_siswa" class="block font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required placeholder="Masukkan nama lengkap siswa"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Tempat & Tanggal Lahir Siswa -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="tempat_lahir" class="block font-semibold text-slate-700 mb-1.5">Tempat Lahir <span class="text-rose-500">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota kelahiran (contoh: Sumedang)"
                            class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block font-semibold text-slate-700 mb-1.5">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>
                </div>

                <!-- Asal Sekolah -->
                <div>
                    <label for="sekolah" class="block font-semibold text-slate-700 mb-1.5">Asal Sekolah <span class="text-rose-500">*</span></label>
                    <input type="text" id="sekolah" name="sekolah" value="{{ old('sekolah') }}" required placeholder="Nama asal sekolah (contoh: SDN 1 Sumedang)"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Pilihan Level Kelas (Pemula A, Pemula B, Lanjutan, Senior) -->
                <div>
                    <label for="tingkat_kelas" class="block font-semibold text-slate-700 mb-1.5">Pilihan Level Kelas <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="tingkat_kelas" name="tingkat_kelas" required
                            class="w-full appearance-none px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] pr-8">
                            <option value="Pemula A" {{ old('tingkat_kelas', 'Pemula A') == 'Pemula A' ? 'selected' : '' }}>Pemula A</option>
                            <option value="Pemula B" {{ old('tingkat_kelas') == 'Pemula B' ? 'selected' : '' }}>Pemula B</option>
                            <option value="Lanjutan" {{ old('tingkat_kelas') == 'Lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                            <option value="Senior" {{ old('tingkat_kelas') == 'Senior' ? 'selected' : '' }}>Senior</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Foto Anak -->
                <div>
                    <label for="foto" class="block font-semibold text-slate-700 mb-1.5">Foto Anak</label>
                    <input type="file" id="foto" name="foto" accept="image/*"
                        class="w-full px-3.5 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-[#008cc9] hover:file:bg-sky-100 focus:outline-none">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format gambar: JPG, PNG, WEBP (Maksimal 2MB, opsional)</span>
                </div>

                <!-- Data Orang Tua / Wali -->
                <div class="pt-3 border-t border-slate-100 space-y-3">
                    <h4 class="font-bold text-slate-800 text-sm">Data Orang Tua / Wali</h4>

                    <!-- Nama Orang Tua -->
                    <div>
                        <label for="nama_orang_tua" class="block font-semibold text-slate-700 mb-1.5">Nama Ortu / Wali <span class="text-rose-500">*</span></label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required placeholder="Masukkan nama lengkap orang tua/wali"
                            class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>

                    <!-- Email & No WhatsApp -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block font-semibold text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com"
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>
                        <div>
                            <label for="no_hp" class="block font-semibold text-slate-700 mb-1.5">No. WhatsApp <span class="text-rose-500">*</span></label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required placeholder="0812-xxxx-xxxx"
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>
                    </div>
                </div>

                <!-- Modal Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modalTambahSiswa')" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-xl font-semibold shadow-sm transition">
                        Simpan Siswa
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Detail & Edit Siswa -->
    <div id="modalDetailSiswa" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-3xl shadow-2xl border border-slate-100 relative max-h-[92vh] flex flex-col mx-4 overflow-hidden">

            <!-- Header Modal -->
            <div class="flex items-start justify-between p-5 sm:p-6 border-b border-slate-100 shrink-0 bg-gradient-to-r from-sky-50/60 via-white to-sky-50/40">
                <div class="flex items-center gap-4 min-w-0">
                    <div id="dsAvatar" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-[#00a5ec] to-sky-400 text-white font-bold text-xl sm:text-2xl flex items-center justify-center shadow-sm shrink-0 overflow-hidden border-2 border-white"></div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 id="dsNama" class="text-base sm:text-lg font-bold text-slate-800 truncate"></h3>
                            <span id="dsIdBadge" class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-100 text-[#008cc9]"></span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 mt-1.5 text-xs text-slate-500">
                            <span id="dsLevelBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0 ml-3">
                    <button type="button" onclick="konfirmasiHapusSiswa()" class="flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-semibold text-rose-500 border border-rose-200 hover:bg-rose-50 rounded-xl transition">
                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                        <span class="hidden sm:inline">Hapus</span>
                    </button>
                    <button type="button" onclick="closeModal('modalDetailSiswa')" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Tab Navigation Bar -->
            <div class="flex border-b border-slate-100 shrink-0 px-4 sm:px-6 overflow-x-auto no-scrollbar bg-slate-50/50">
                <button id="tabSiswaProfilBtn" onclick="switchSiswaTab('profil')" class="py-3 px-3.5 text-xs font-semibold text-[#008cc9] border-b-2 border-[#008cc9] -mb-px transition flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-user text-xs"></i>
                    <span>Profil & Ortu</span>
                </button>
                <button id="tabSiswaAbsensiBtn" onclick="switchSiswaTab('absensi')" class="py-3 px-3.5 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-calendar-check text-xs"></i>
                    <span>Absensi</span>
                </button>
                <button id="tabSiswaPencapaianBtn" onclick="switchSiswaTab('pencapaian')" class="py-3 px-3.5 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-medal text-xs"></i>
                    <span>Pencapaian</span>
                </button>
                <button id="tabSiswaEditBtn" onclick="switchSiswaTab('edit')" class="py-3 px-3.5 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    <span>Edit Data</span>
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="overflow-y-auto flex-1 p-5 sm:p-6">

                <!-- ===== TAB 1: PROFIL & DATA ORANG TUA ===== -->
                <div id="tabSiswaProfil" class="space-y-5">
                    <!-- Section: Biodata Anak -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-id-card text-sky-500"></i>
                            <span>Biodata Anak</span>
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Tempat, Tgl Lahir</p>
                                <p id="dsTTL" class="font-bold text-slate-700"></p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Jenis Kelamin</p>
                                <p id="dsJenisKelamin" class="font-bold text-slate-700 capitalize"></p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Asal Sekolah</p>
                                <p id="dsSekolah" class="font-bold text-slate-700"></p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Level Kelas</p>
                                <p id="dsLevelText" class="font-bold text-slate-700"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Data Orang Tua / Wali -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-users text-sky-500"></i>
                                <span>Data Orang Tua / Wali</span>
                            </h4>
                            <a id="dsWaDirectBtn" href="#" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                                <span>Chat WA Ortu</span>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div class="p-3.5 bg-slate-50 rounded-xl">
                                <p class="text-slate-400 text-[11px] mb-0.5">Nama Orang Tua / Wali</p>
                                <p id="dsNamaOrtu" class="font-bold text-slate-800 text-sm"></p>
                            </div>
                            <div class="p-3.5 bg-slate-50 rounded-xl">
                                <p class="text-slate-400 text-[11px] mb-0.5">Email</p>
                                <p id="dsEmailOrtu" class="font-bold text-slate-800 text-sm"></p>
                            </div>
                            <div class="p-3.5 bg-slate-50 rounded-xl">
                                <p class="text-slate-400 text-[11px] mb-0.5">Nomor WhatsApp / HP</p>
                                <p id="dsNoHpOrtu" class="font-bold text-slate-800 text-sm"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== TAB 2: ABSENSI & KEHADIRAN ===== -->
                <div id="tabSiswaAbsensi" class="space-y-5 hidden">
                    <!-- Rekap Stat Absensi -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold text-slate-700">Rekapitulasi Kehadiran</h4>
                            <span id="dsAbsensiRate" class="text-xs font-bold text-[#00a5ec]"></span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-3.5 text-center">
                                <p id="dsJmlHadir" class="text-2xl font-black text-emerald-600">0</p>
                                <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">Hadir</p>
                            </div>
                            <div class="rounded-xl bg-amber-50 border border-amber-100 p-3.5 text-center">
                                <p id="dsJmlIzin" class="text-2xl font-black text-amber-500">0</p>
                                <p class="text-[11px] text-amber-600 font-semibold mt-0.5">Izin</p>
                            </div>
                            <div class="rounded-xl bg-rose-50 border border-rose-100 p-3.5 text-center">
                                <p id="dsJmlSakit" class="text-2xl font-black text-rose-500">0</p>
                                <p class="text-[11px] text-rose-600 font-semibold mt-0.5">Sakit</p>
                            </div>
                            <div class="rounded-xl bg-slate-100 border border-slate-200 p-3.5 text-center">
                                <p id="dsJmlAlpha" class="text-2xl font-black text-slate-600">0</p>
                                <p class="text-[11px] text-slate-600 font-semibold mt-0.5">Tidak Hadir</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Riwayat Absensi -->
                    <div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 mb-3">
                            <h4 class="text-xs font-bold text-slate-700">Riwayat Kehadiran Siswa</h4>
                            <!-- Filter Bulan & Tahun Absensi -->
                            <div class="flex items-center gap-2">
                                <select id="dsFilterBulanAbsensi" onchange="filterRiwayatAbsensi()" class="text-[11px] bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                    <option value="semua">Semua Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <select id="dsFilterTahunAbsensi" onchange="filterRiwayatAbsensi()" class="text-[11px] bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                    <option value="semua">Semua Tahun</option>
                                </select>
                            </div>
                        </div>
                        <div class="overflow-x-auto rounded-xl border border-slate-100">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                                    <tr>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="dsAbsensiBody" class="divide-y divide-slate-100 text-slate-700">
                                    <!-- Diisi via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ===== TAB 3: PENCAPAIAN & PRESTASI ===== -->
                <div id="tabSiswaPencapaian" class="space-y-5 hidden">
                    <!-- 3 Ringkasan Progres Penilaian Cards -->
                    <div class="grid grid-cols-3 gap-2.5 sm:gap-4">
                        <div class="bg-sky-50/70 rounded-xl p-3 sm:p-4 border border-sky-200 text-center">
                            <p id="dsPenilaianTotal" class="text-xl sm:text-2xl font-extrabold text-[#00a5ec]">0</p>
                            <p class="text-[11px] font-bold text-slate-700 mt-0.5">Total Penilaian</p>
                            <p class="text-[10px] text-slate-400">dari pelatih</p>
                        </div>
                        <div class="bg-amber-50/70 rounded-xl p-3 sm:p-4 border border-amber-200 text-center">
                            <p id="dsPenilaianAvg" class="text-xl sm:text-2xl font-extrabold text-amber-500">0.0</p>
                            <p class="text-[11px] font-bold text-slate-700 mt-0.5">Rata-rata Nilai</p>
                            <p class="text-[10px] text-slate-400">dari skala 5</p>
                        </div>
                        <div class="bg-emerald-50/70 rounded-xl p-3 sm:p-4 border border-emerald-200 text-center">
                            <p id="dsPenilaianPersen" class="text-xl sm:text-2xl font-extrabold text-emerald-600">0%</p>
                            <p class="text-[11px] font-bold text-slate-700 mt-0.5">Progres Penilaian</p>
                            <p class="text-[10px] text-slate-400">penguasaan materi</p>
                        </div>
                    </div>

                    <!-- Progres Setiap Gaya & Best Time -->
                    <div>
                        <div class="flex items-center justify-between mb-2.5">
                            <div>
                                <h4 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-person-swimming text-[#00a5ec]"></i>
                                    <span>Progres Setiap Gaya & Best Time</span>
                                </h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Rekapitulasi penguasaan gaya renang dan catatan waktu tercepat (Best Time)</p>
                            </div>
                        </div>
                        <div id="dsProgresGayaContainer" class="flex flex-nowrap overflow-x-auto pb-2 gap-3 snap-x snap-mandatory scroll-smooth no-scrollbar">
                            <!-- Diisi via JavaScript -->
                        </div>
                    </div>

                    <!-- Riwayat Penilaian dari Pelatih -->
                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 mb-3">
                            <div>
                                <h4 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-clipboard-check text-[#00a5ec]"></i>
                                    <span>Riwayat Penilaian dari Pelatih</span>
                                </h4>
                                <span class="text-[11px] text-slate-400">Evaluasi per Sesi</span>
                            </div>
                            <!-- Filter Bulan & Tahun -->
                            <div class="flex items-center gap-2">
                                <select id="dsFilterBulanPencapaian" onchange="filterRiwayatPencapaian()" class="text-[11px] bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                    <option value="semua">Semua Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <select id="dsFilterTahunPencapaian" onchange="filterRiwayatPencapaian()" class="text-[11px] bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-[#00a5ec] transition cursor-pointer">
                                    <option value="semua">Semua Tahun</option>
                                </select>
                            </div>
                        </div>
                        <div id="dsPencapaianContainer" class="space-y-3">
                            <!-- Diisi via JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- ===== TAB 4: EDIT DATA SISWA ===== -->
                <div id="tabSiswaEdit" class="hidden">
                    <form id="formEditSiswa" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs" data-confirm="Apakah Anda yakin ingin menyimpan perubahan data profil siswa ini?">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <!-- Foto Profil Siswa -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Foto Profil Siswa</label>
                            <div class="flex items-center gap-4 p-3 bg-[#f8fafc] border border-dashed border-slate-300 rounded-xl">
                                <div class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    <img id="editSiswaFotoPreview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                                    <div id="editSiswaFotoPlaceholder" class="w-full h-full bg-[#00a5ec] text-white font-bold text-lg flex items-center justify-center"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <label for="editSiswaFotoInput" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-lg font-semibold text-xs cursor-pointer shadow-sm transition">
                                            <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                            <span>Ganti Foto</span>
                                        </label>
                                        <button type="button" id="btnHapusEditSiswaFoto" onclick="hapusEditSiswaFoto()" class="hidden text-rose-500 hover:text-rose-600 font-semibold text-xs transition">
                                            Hapus Foto
                                        </button>
                                    </div>
                                    <input type="file" id="editSiswaFotoInput" name="foto" accept="image/*" class="hidden" onchange="previewEditSiswaFoto(event)">
                                    <input type="hidden" id="editSiswaHapusFotoInput" name="hapus_foto" value="0">
                                    <p id="editSiswaFotoInfo" class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB, opsional)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nama Siswa -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                            <input type="text" id="editNamaSiswa" name="nama_siswa" required
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">Tempat Lahir</label>
                                <input type="text" id="editTempatLahir" name="tempat_lahir"
                                    class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                <input type="date" id="editTanggalLahir" name="tanggal_lahir" required
                                    class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            </div>
                        </div>

                        <input type="hidden" id="editJenisKelamin" name="jenis_kelamin" value="laki-laki">
                        <input type="hidden" id="editAlamatOrtu" name="alamat" value="">

                        <!-- Asal Sekolah -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Asal Sekolah <span class="text-rose-500">*</span></label>
                            <input type="text" id="editSekolah" name="sekolah" required
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>

                        <!-- Tingkat Kelas -->
                        <input type="hidden" id="editIdCabang" name="id_cabang" value="{{ Auth::user()->id_cabang }}">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Tingkat Level Kelas <span class="text-rose-500">*</span></label>
                            <select id="editTingkatKelas" name="tingkat_kelas" required
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                                <option value="Pemula A">Pemula A</option>
                                <option value="Pemula B">Pemula B</option>
                                <option value="Lanjutan">Lanjutan</option>
                                <option value="Senior">Senior</option>
                            </select>
                        </div>

                        <!-- Data Orang Tua / Wali -->
                        <div class="pt-3 border-t border-slate-100 space-y-3">
                            <h4 class="font-bold text-slate-800 text-xs">Data Orang Tua / Wali</h4>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">Nama Orang Tua <span class="text-rose-500">*</span></label>
                                <input type="text" id="editNamaOrtu" name="nama_orang_tua" required
                                    class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1.5">Email Orang Tua <span class="text-rose-500">*</span></label>
                                    <input type="email" id="editEmailOrtu" name="email" required
                                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1.5">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                                    <input type="text" id="editNoHpOrtu" name="no_hp" required
                                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                                </div>
                            </div>
                        </div>

                        <!-- Buttons Form Edit -->
                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                            <button type="button" onclick="switchSiswaTab('profil')" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition text-xs">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-xl font-semibold shadow-sm transition text-xs">
                                <i class="fa-solid fa-floppy-disk mr-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Hidden Form Delete Siswa -->
    <form id="formDeleteSiswa" method="POST" action="" class="hidden">
        @csrf
    </form>

    <!-- Modal Konfirmasi Hapus Siswa -->
    <div id="modalKonfirmasiHapusSiswa" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-rose-500 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Hapus Data Siswa?</h3>
                <p class="text-xs text-slate-500 mb-1">Anda akan menghapus siswa:</p>
                <p id="konfirmNamaSiswa" class="text-sm font-bold text-rose-600 mb-3"></p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Semua riwayat absensi, pencapaian, serta akun orang tua terkait akan otomatis dihapus permanen.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalKonfirmasiHapusSiswa')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" onclick="deleteSiswa()"
                        class="flex-1 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold text-xs shadow-sm transition cursor-pointer">
                        <i class="fa-solid fa-trash-can mr-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Tolak Pendaftar -->
    <div id="modalKonfirmasiTolakPendaftar" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-xmark text-rose-500 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Tolak Pendaftaran?</h3>
                <p class="text-xs text-slate-500 mb-1">Apakah Anda yakin ingin menolak pendaftaran calon siswa:</p>
                <p id="konfirmTolakNamaPendaftar" class="text-sm font-bold text-rose-600 mb-2"></p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Pendaftaran ini akan dihapus dari antrean verifikasi pendaftar baru.</p>
                <div class="flex gap-3">
                    <button type="button" id="btnKonfirmasiTolakBatal" onclick="closeModal('modalKonfirmasiTolakPendaftar')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" id="btnKonfirmasiTolakSubmit" onclick="eksekusiTolakPendaftar()"
                        class="flex-1 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold text-xs shadow-sm transition cursor-pointer flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-xmark mr-1"></i>Ya, Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi ACC Pendaftar -->
    <div id="modalKonfirmasiAccPendaftar" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-check text-emerald-600 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Setujui & ACC Siswa?</h3>
                <p class="text-xs text-slate-500 mb-1">Anda akan menerima calon siswa:</p>
                <p id="konfirmAccNamaPendaftar" class="text-sm font-bold text-emerald-600 mb-2"></p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Calon siswa akan resmi dimasukkan ke dalam daftar Siswa Aktif pada kelas yang dipilih.</p>
                <div class="flex gap-3">
                    <button type="button" id="btnKonfirmasiAccBatal" onclick="closeModal('modalKonfirmasiAccPendaftar')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" id="btnKonfirmasiAccSubmit" onclick="eksekusiAccPendaftar()"
                        class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-xs shadow-sm transition cursor-pointer flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-check mr-1"></i>Ya, ACC
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pendaftar Baru (Review Sebelum ACC) -->
    <div id="modalDetailPendaftarBaru" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden p-4">
        <div class="bg-white rounded-3xl w-full max-w-2xl mx-auto shadow-2xl border border-slate-100 flex flex-col max-h-[92vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-start justify-between p-5 sm:p-6 border-b border-slate-100 shrink-0 bg-slate-50/60">
                <div class="flex items-center gap-3.5">
                    <div id="mdpAvatar" class="w-12 h-12 rounded-full bg-amber-400 text-amber-900 font-extrabold text-base flex items-center justify-center shrink-0 shadow-sm overflow-hidden border-2 border-white">
                        <!-- JS fills this -->
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 id="mdpNamaSiswa" class="text-base sm:text-lg font-bold text-slate-800">Nama Calon Siswa</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                Menunggu Verifikasi
                            </span>
                        </div>
                        <p id="mdpTanggalDaftar" class="text-xs text-slate-400 mt-0.5 flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-slate-400"></i>
                            <span>Daftar pada -</span>
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalDetailPendaftarBaru')" class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 transition text-base cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="overflow-y-auto flex-1 p-5 sm:p-6 space-y-5 text-xs text-slate-700">
                <!-- Section 1: Informasi Calon Siswa -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-graduation-cap text-[#00a5ec]"></i>
                        <span>Data Calon Siswa</span>
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">Tempat, Tgl Lahir</p>
                            <p id="mdpTTL" class="font-bold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">Umur</p>
                            <p id="mdpUmur" class="font-bold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">Asal Sekolah</p>
                            <p id="mdpSekolah" class="font-bold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">Pilihan Kelas</p>
                            <p id="mdpKelasCabang" class="font-bold text-[#008cc9]"></p>
                        </div>
                    </div>

                    <!-- Riwayat Penyakit & Catatan Khusus -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-1.5 text-slate-500 font-semibold mb-1">
                                <i class="fa-solid fa-heart-pulse text-rose-500"></i>
                                <span>Riwayat Penyakit / Medis</span>
                            </div>
                            <p id="mdpRiwayatPenyakit" class="text-slate-700 font-medium pl-4"></p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-1.5 text-slate-500 font-semibold mb-1">
                                <i class="fa-solid fa-note-sticky text-amber-500"></i>
                                <span>Catatan Khusus</span>
                            </div>
                            <p id="mdpCatatanKhusus" class="text-slate-700 font-medium pl-4"></p>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Orang Tua / Wali -->
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-user-group text-[#00a5ec]"></i>
                            <span>Data Orang Tua / Wali</span>
                        </h4>
                        <a id="mdpBtnWa" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition cursor-pointer">
                            <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                            <span>Hubungi via WhatsApp</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">Nama Orang Tua / Wali</p>
                            <p id="mdpNamaOrtu" class="font-bold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">No. WhatsApp / HP</p>
                            <p id="mdpNoHpOrtu" class="font-bold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-slate-400 text-[11px] mb-0.5">Email</p>
                            <p id="mdpEmailOrtu" class="font-bold text-slate-700 truncate"></p>
                        </div>
                    </div>
                    <div class="mt-2.5 p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-slate-400 text-[11px] mb-0.5">Alamat Tempat Tinggal</p>
                        <p id="mdpAlamatOrtu" class="font-medium text-slate-700"></p>
                    </div>
                </div>

                <!-- Section 3: Pembayaran & Berkas -->
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-receipt text-[#00a5ec]"></i>
                        <span>Pembayaran & Lampiran Berkas</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Metode Pembayaran -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex flex-col justify-between">
                            <div>
                                <p class="text-slate-400 text-[11px] mb-1">Metode Pembayaran</p>
                                <div id="mdpMetodePembayaranBadge"></div>
                            </div>
                            <div class="mt-3">
                                <p class="text-slate-400 text-[11px] mb-1">Bukti Transfer / Pembayaran</p>
                                <div id="mdpBuktiPembayaranContainer"></div>
                            </div>
                        </div>

                        <!-- Surat Perjanjian -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex flex-col justify-between">
                            <div>
                                <p class="text-slate-400 text-[11px] mb-1">Surat Perjanjian / Berkas Fisik</p>
                                <div id="mdpSuratPerjanjianContainer"></div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">
                                Pastikan berkas dan pembayaran telah sesuai sebelum menyetujui pendaftar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer (Actions) -->
            <div class="flex items-center justify-between p-4 sm:p-5 border-t border-slate-100 bg-slate-50/80 shrink-0">
                <!-- Form Tolak -->
                <form id="mdpFormTolak" method="POST" action="">
                    @csrf
                    <button type="button" onclick="konfirmasiTolakPendaftar('mdpFormTolak', document.getElementById('mdpNamaSiswa').textContent)" class="border border-rose-300 text-rose-600 hover:bg-rose-50 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-xmark text-xs"></i>
                        <span>Tolak Pendaftaran</span>
                    </button>
                </form>

                <div class="flex items-center gap-2.5">
                    <button type="button" onclick="closeModal('modalDetailPendaftarBaru')" class="border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-xs px-4 py-2.5 rounded-xl transition cursor-pointer">
                        Tutup
                    </button>
                    <!-- Form ACC / Terima -->
                    <form id="mdpFormAcc" method="POST" action="">
                        @csrf
                        <button type="button" onclick="konfirmasiAccPendaftar('mdpFormAcc', document.getElementById('mdpNamaSiswa').textContent)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm active:scale-[0.98] cursor-pointer">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Setujui & ACC Siswa</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan" class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Modal & Mobile Sidebar Toggle Script -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
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

        // Global variables for detail siswa
        let _currentSiswaId = null;
        let _currentSiswaNama = '';
        let _currentSiswaFotoUrl = null;
        let _currentSiswaInitials = '';
        let _currentSiswaPencapaian = [];
        let _currentSiswaAbsensi = [];

        function switchSiswaTab(tab) {
            const tabs = ['profil', 'absensi', 'pencapaian', 'edit'];
            tabs.forEach(t => {
                const content = document.getElementById('tabSiswa' + t.charAt(0).toUpperCase() + t.slice(1));
                const btn = document.getElementById('tabSiswa' + t.charAt(0).toUpperCase() + t.slice(1) + 'Btn');
                if (content && btn) {
                    if (t === tab) {
                        content.classList.remove('hidden');
                        btn.className = 'py-3 px-3.5 text-xs font-semibold text-[#008cc9] border-b-2 border-[#008cc9] -mb-px transition flex items-center gap-1.5 whitespace-nowrap';
                    } else {
                        content.classList.add('hidden');
                        btn.className = 'py-3 px-3.5 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition flex items-center gap-1.5 whitespace-nowrap';
                    }
                }
            });
        }

        function openDetailSiswa(data) {
            _currentSiswaId = data.id;
            _currentSiswaNama = data.nama;
            _currentSiswaFotoUrl = data.foto;

            // Buat inisial nama
            const words = data.nama.trim().split(/\s+/);
            let initials = '';
            for (let i = 0; i < Math.min(2, words.length); i++) {
                initials += words[i].charAt(0).toUpperCase();
            }
            _currentSiswaInitials = initials || 'GD';

            // 1. Header Modal
            const avatar = document.getElementById('dsAvatar');
            if (data.foto) {
                avatar.innerHTML = `<img src="${data.foto}" alt="${data.nama}" class="w-full h-full object-cover">`;
            } else {
                avatar.textContent = _currentSiswaInitials;
            }

            document.getElementById('dsNama').textContent = data.nama;
            document.getElementById('dsIdBadge').textContent = data.formatted_id;
            document.getElementById('dsLevelBadge').textContent = data.tingkat_kelas || 'Pemula A';
            if (document.getElementById('dsCabangBadge')) {
                document.getElementById('dsCabangBadge').textContent = 'Cabang ' + (data.nama_cabang || 'Kemang');
            }

            // 2. Tab Profil & Biodata
            const ageText = data.umur !== null ? ` (${data.umur} tahun)` : '';
            if (document.getElementById('dsTTL')) {
                document.getElementById('dsTTL').textContent = `${data.tempat_lahir || '-'}, ${data.tanggal_lahir_formatted}${ageText}`;
            }
            if (document.getElementById('dsJenisKelamin')) {
                document.getElementById('dsJenisKelamin').textContent = data.jenis_kelamin || '-';
            }
            if (document.getElementById('dsSekolah')) {
                document.getElementById('dsSekolah').textContent = data.sekolah || '-';
            }
            if (document.getElementById('dsLevelText')) {
                document.getElementById('dsLevelText').textContent = data.tingkat_kelas || '-';
            }
            if (document.getElementById('dsCabangText')) {
                document.getElementById('dsCabangText').textContent = data.nama_cabang || '-';
            }

            // Data Orang Tua
            if (document.getElementById('dsNamaOrtu')) {
                document.getElementById('dsNamaOrtu').textContent = data.orang_tua.nama || '-';
            }
            if (document.getElementById('dsEmailOrtu')) {
                document.getElementById('dsEmailOrtu').textContent = data.orang_tua.email || '-';
            }
            if (document.getElementById('dsNoHpOrtu')) {
                document.getElementById('dsNoHpOrtu').textContent = data.orang_tua.no_hp || '-';
            }

            // Tombol WA Direct
            const waBtn = document.getElementById('dsWaDirectBtn');
            if (data.orang_tua.no_hp && data.orang_tua.no_hp !== '-') {
                let cleanPhone = data.orang_tua.no_hp.replace(/[^0-9]/g, '');
                if (cleanPhone.startsWith('0')) {
                    cleanPhone = '62' + cleanPhone.substring(1);
                }
                waBtn.href = `https://wa.me/${cleanPhone}?text=Halo%20Bapak%2FIbu%20${encodeURIComponent(data.orang_tua.nama)}%2C%20kami%20dari%20Gajah%20Depa%20Swimming%20Club`;
                waBtn.classList.remove('hidden');
            } else {
                waBtn.classList.add('hidden');
            }

            // 3. Tab Absensi
            const abs = data.absensi || {};
            _currentSiswaAbsensi = Array.isArray(abs.riwayat) ? abs.riwayat : [];

            // Inisialisasi dropdown filter Tahun & Bulan Absensi
            const tahunAbsSelect = document.getElementById('dsFilterTahunAbsensi');
            if (tahunAbsSelect) {
                const currentYear = new Date().getFullYear();
                const yearsSet = new Set([currentYear]);
                _currentSiswaAbsensi.forEach(a => {
                    if (a.tanggal) {
                        const parts = a.tanggal.split('-');
                        if (parts.length >= 1) {
                            const y = parseInt(parts[0], 10);
                            if (!isNaN(y)) yearsSet.add(y);
                        }
                    }
                });
                const sortedYears = Array.from(yearsSet).sort((a, b) => b - a);
                tahunAbsSelect.innerHTML = '<option value="semua">Semua Tahun</option>' +
                    sortedYears.map(y => `<option value="${y}">${y}</option>`).join('');
                tahunAbsSelect.value = currentYear.toString();
            }
            const bulanAbsSelect = document.getElementById('dsFilterBulanAbsensi');
            if (bulanAbsSelect) {
                bulanAbsSelect.value = (new Date().getMonth() + 1).toString();
            }

            renderRiwayatAbsensi();

            // 4. Tab Pencapaian (Ringkasan Progres, Progres Setiap Gaya & Best Time, Riwayat Penilaian)
            const pencapaianList = Array.isArray(data.pencapaian) ? data.pencapaian : [];
            const totalPenilaian = pencapaianList.length;
            let sumAllAvg = 0;
            pencapaianList.forEach(p => {
                sumAllAvg += ((Number(p.teknik) || 0) + (Number(p.kecepatan) || 0) + (Number(p.ketahanan) || 0)) / 3;
            });
            const overallAvg = totalPenilaian > 0 ? (sumAllAvg / totalPenilaian) : 0;
            const overallPersen = totalPenilaian > 0 ? Math.min(100, Math.round((overallAvg / 5) * 100)) : 0;

            if (document.getElementById('dsPenilaianTotal')) document.getElementById('dsPenilaianTotal').textContent = totalPenilaian;
            if (document.getElementById('dsPenilaianAvg')) document.getElementById('dsPenilaianAvg').textContent = overallAvg.toFixed(1);
            if (document.getElementById('dsPenilaianPersen')) document.getElementById('dsPenilaianPersen').textContent = `${overallPersen}%`;

            const parseWaktuToCs = (waktuStr) => {
                if (!waktuStr) return null;
                const w = String(waktuStr).trim();
                if (w === '-' || w === '00:00.00' || w === '00:00:00' || w === '0:0.0') return null;
                const m = w.match(/^(\d+):(\d+)(?:\.(\d+))?$/);
                if (m) {
                    const mm = parseInt(m[1], 10);
                    const ss = parseInt(m[2], 10);
                    const ms = m[3] ? parseInt(m[3].substring(0, 2).padEnd(2, '0'), 10) : 0;
                    const total = (mm * 6000) + (ss * 100) + ms;
                    return total > 0 ? total : null;
                }
                return null;
            };

            const daftarGaya = [
                { label: 'Gaya Bebas', key: 'bebas' },
                { label: 'Gaya Dada', key: 'dada' },
                { label: 'Gaya Punggung', key: 'punggung' },
                { label: 'Gaya Kupu-kupu', key: 'kupu' }
            ];

            const progresGayaContainer = document.getElementById('dsProgresGayaContainer');
            if (progresGayaContainer) {
                progresGayaContainer.innerHTML = '';
                daftarGaya.forEach(g => {
                    const itemsGaya = pencapaianList.filter(p => String(p.gaya_renang || '').toLowerCase().includes(g.key));
                    const sesiCount = itemsGaya.length;
                    let avgGaya = 0;
                    let persenGaya = 0;
                    let bestTimeStr = null;
                    let bestTimeCs = null;

                    if (sesiCount > 0) {
                        let sumGaya = 0;
                        itemsGaya.forEach(item => {
                            sumGaya += ((Number(item.teknik) || 0) + (Number(item.kecepatan) || 0) + (Number(item.ketahanan) || 0)) / 3;
                            const cs = parseWaktuToCs(item.catatan_waktu);
                            if (cs !== null && (bestTimeCs === null || cs < bestTimeCs)) {
                                bestTimeCs = cs;
                                bestTimeStr = item.catatan_waktu;
                            }
                        });
                        avgGaya = sumGaya / sesiCount;
                        persenGaya = Math.min(100, Math.round((avgGaya / 5) * 100));
                    }

                    progresGayaContainer.innerHTML += `
                        <div class="w-[78%] sm:w-[46%] shrink-0 snap-start rounded-2xl border border-slate-200/80 bg-[#f8fbff] p-3.5 sm:p-4 flex flex-col justify-between hover:border-sky-300 transition shadow-2xs">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div>
                                    <h5 class="font-extrabold text-[#093c56] text-xs sm:text-sm leading-tight">${g.label}</h5>
                                    <span class="text-[10px] text-slate-400 font-medium">${sesiCount > 0 ? `${sesiCount} sesi dinilai` : 'Belum ada penilaian'}</span>
                                </div>
                                <div class="px-2 py-1 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center gap-1.5 shrink-0">
                                    <i class="fa-solid fa-stopwatch text-amber-500 text-[10px]"></i>
                                    <div class="text-right">
                                        <span class="block text-[8px] font-bold uppercase tracking-wider text-amber-500 leading-none">Best Time</span>
                                        <span class="font-extrabold text-[11px] text-amber-900 leading-tight">${bestTimeStr ? bestTimeStr : 'Belum ada'}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-baseline justify-between mb-1">
                                    <span class="text-[11px] font-semibold text-slate-500">Progres Penguasaan</span>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-base font-black ${sesiCount > 0 ? 'text-[#00a5ec]' : 'text-slate-400'}">${persenGaya}%</span>
                                        <span class="text-[10px] font-semibold text-slate-400">(${avgGaya.toFixed(1)}/5)</span>
                                    </div>
                                </div>
                                <div class="w-full bg-slate-200/70 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-[#00b4db] to-[#0083b0] h-2 rounded-full transition-all duration-500" style="width: ${persenGaya}%"></div>
                                </div>
                            </div>
                        </div>`;
                });
            }

            _currentSiswaPencapaian = pencapaianList;

            // Inisialisasi dropdown filter Tahun & Bulan
            const tahunSelect = document.getElementById('dsFilterTahunPencapaian');
            if (tahunSelect) {
                const currentYear = new Date().getFullYear();
                const yearsSet = new Set([currentYear]);
                _currentSiswaPencapaian.forEach(p => {
                    if (p.tanggal_raw) {
                        const y = parseInt(p.tanggal_raw.split('-')[0], 10);
                        if (!isNaN(y)) yearsSet.add(y);
                    }
                });
                const sortedYears = Array.from(yearsSet).sort((a, b) => b - a);
                tahunSelect.innerHTML = '<option value="semua">Semua Tahun</option>' +
                    sortedYears.map(y => `<option value="${y}">${y}</option>`).join('');
                tahunSelect.value = currentYear.toString();
            }
            const bulanSelect = document.getElementById('dsFilterBulanPencapaian');
            if (bulanSelect) {
                bulanSelect.value = (new Date().getMonth() + 1).toString();
            }

            renderRiwayatPencapaian();

            // 5. Populate Form Edit
            const formEdit = document.getElementById('formEditSiswa');
            formEdit.action = '{{ url('/admin/siswa') }}/' + data.id + '/update';

            if (document.getElementById('editNamaSiswa')) document.getElementById('editNamaSiswa').value = data.nama;
            if (document.getElementById('editTempatLahir')) document.getElementById('editTempatLahir').value = data.tempat_lahir !== '-' ? data.tempat_lahir : '';
            if (document.getElementById('editTanggalLahir')) document.getElementById('editTanggalLahir').value = data.tanggal_lahir_raw;
            if (document.getElementById('editJenisKelamin')) document.getElementById('editJenisKelamin').value = data.jenis_kelamin || 'laki-laki';
            if (document.getElementById('editTingkatKelas')) document.getElementById('editTingkatKelas').value = data.tingkat_kelas || 'Pemula A';
            if (document.getElementById('editSekolah')) document.getElementById('editSekolah').value = data.sekolah !== '-' ? data.sekolah : '';
            if (document.getElementById('editIdCabang') && data.id_cabang) {
                document.getElementById('editIdCabang').value = data.id_cabang;
            }

            if (document.getElementById('editNamaOrtu')) document.getElementById('editNamaOrtu').value = data.orang_tua.nama !== '-' ? data.orang_tua.nama : '';
            if (document.getElementById('editEmailOrtu')) document.getElementById('editEmailOrtu').value = data.orang_tua.email !== '-' ? data.orang_tua.email : '';
            if (document.getElementById('editNoHpOrtu')) document.getElementById('editNoHpOrtu').value = data.orang_tua.no_hp !== '-' ? data.orang_tua.no_hp : '';
            if (document.getElementById('editAlamatOrtu')) document.getElementById('editAlamatOrtu').value = data.orang_tua.alamat !== '-' ? data.orang_tua.alamat : '';

            // Foto Edit Preview
            const editImg = document.getElementById('editSiswaFotoPreview');
            const editHolder = document.getElementById('editSiswaFotoPlaceholder');
            const editInput = document.getElementById('editSiswaFotoInput');
            const hapusInput = document.getElementById('editSiswaHapusFotoInput');
            const btnHapus = document.getElementById('btnHapusEditSiswaFoto');
            const fotoInfo = document.getElementById('editSiswaFotoInfo');

            if (editInput) editInput.value = '';
            if (hapusInput) hapusInput.value = '0';
            if (fotoInfo) fotoInfo.textContent = 'Format: JPG, PNG, WEBP (Maks. 2MB, opsional)';

            if (data.foto) {
                editImg.src = data.foto;
                editImg.classList.remove('hidden');
                editHolder.classList.add('hidden');
                if (btnHapus) btnHapus.classList.remove('hidden');
            } else {
                editImg.src = '';
                editImg.classList.add('hidden');
                editHolder.textContent = _currentSiswaInitials;
                editHolder.classList.remove('hidden');
                if (btnHapus) btnHapus.classList.add('hidden');
            }

            // Always open on Profil tab
            switchSiswaTab('profil');
            openModal('modalDetailSiswa');
        }

        // ---- Filter & Render Riwayat Absensi Siswa ----
        function filterRiwayatAbsensi() {
            renderRiwayatAbsensi();
        }

        function renderRiwayatAbsensi() {
            const absBody = document.getElementById('dsAbsensiBody');
            if (!absBody) return;

            const bulanVal = document.getElementById('dsFilterBulanAbsensi')?.value || 'semua';
            const tahunVal = document.getElementById('dsFilterTahunAbsensi')?.value || 'semua';

            let filtered = _currentSiswaAbsensi;
            if (bulanVal !== 'semua') {
                const targetMonth = parseInt(bulanVal, 10);
                filtered = filtered.filter(a => {
                    if (!a.tanggal) return false;
                    const parts = a.tanggal.split('-');
                    return parts.length >= 2 && parseInt(parts[1], 10) === targetMonth;
                });
            }
            if (tahunVal !== 'semua') {
                const targetYear = parseInt(tahunVal, 10);
                filtered = filtered.filter(a => {
                    if (!a.tanggal) return false;
                    const parts = a.tanggal.split('-');
                    return parts.length >= 1 && parseInt(parts[0], 10) === targetYear;
                });
            }

            // Update rekapitulasi cards sesuai data yang terfilter
            let jmlHadir = 0, jmlIzin = 0, jmlSakit = 0, jmlAlpha = 0;
            filtered.forEach(item => {
                if (item.status === 'hadir') jmlHadir++;
                else if (item.status === 'izin') jmlIzin++;
                else if (item.status === 'sakit') jmlSakit++;
                else jmlAlpha++;
            });
            const totalSesi = filtered.length;
            const persenHadir = totalSesi > 0 ? Math.round((jmlHadir / totalSesi) * 100) : 0;

            if (document.getElementById('dsJmlHadir')) document.getElementById('dsJmlHadir').textContent = jmlHadir;
            if (document.getElementById('dsJmlIzin')) document.getElementById('dsJmlIzin').textContent = jmlIzin;
            if (document.getElementById('dsJmlSakit')) document.getElementById('dsJmlSakit').textContent = jmlSakit;
            if (document.getElementById('dsJmlAlpha')) document.getElementById('dsJmlAlpha').textContent = jmlAlpha;
            if (document.getElementById('dsAbsensiRate')) document.getElementById('dsAbsensiRate').textContent = `${persenHadir}% Kehadiran (${totalSesi} Sesi)`;

            absBody.innerHTML = '';
            if (filtered.length === 0) {
                absBody.innerHTML = `<tr><td colspan="3" class="py-6 text-center text-slate-400">${_currentSiswaAbsensi.length === 0 ? 'Belum ada riwayat absensi tercatat.' : 'Tidak ada riwayat absensi pada bulan/tahun yang dipilih.'}</td></tr>`;
                return;
            }

            filtered.forEach(item => {
                const d = new Date(item.tanggal);
                const tgl = !isNaN(d.getTime()) ? d.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) : (item.tanggal || '-');
                let badge = '';
                if (item.status === 'hadir') {
                    badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">Hadir</span>';
                } else if (item.status === 'izin') {
                    badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">Izin</span>';
                } else if (item.status === 'sakit') {
                    badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-500 border border-rose-200">Sakit</span>';
                } else {
                    badge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">' + (item.status === 'tidak_hadir' ? 'Tidak Hadir' : item.status) + '</span>';
                }
                absBody.innerHTML += `<tr class="hover:bg-slate-50/50 transition">
                    <td class="py-3 px-4 font-medium">${tgl}</td>
                    <td class="py-3 px-4">${badge}</td>
                    <td class="py-3 px-4 text-slate-500">${item.keterangan || '-'}</td>
                </tr>`;
            });
        }

        // ---- Filter & Render Riwayat Penilaian Pencapaian ----
        function filterRiwayatPencapaian() {
            renderRiwayatPencapaian();
        }

        function renderRiwayatPencapaian() {
            const pencapaianContainer = document.getElementById('dsPencapaianContainer');
            if (!pencapaianContainer) return;

            const bulanVal = document.getElementById('dsFilterBulanPencapaian')?.value || 'semua';
            const tahunVal = document.getElementById('dsFilterTahunPencapaian')?.value || 'semua';

            let filtered = _currentSiswaPencapaian;
            if (bulanVal !== 'semua') {
                const targetMonth = parseInt(bulanVal, 10);
                filtered = filtered.filter(p => {
                    if (!p.tanggal_raw) return false;
                    return parseInt(p.tanggal_raw.split('-')[1], 10) === targetMonth;
                });
            }
            if (tahunVal !== 'semua') {
                const targetYear = parseInt(tahunVal, 10);
                filtered = filtered.filter(p => {
                    if (!p.tanggal_raw) return false;
                    return parseInt(p.tanggal_raw.split('-')[0], 10) === targetYear;
                });
            }

            pencapaianContainer.innerHTML = '';
            if (filtered.length === 0) {
                pencapaianContainer.innerHTML = `
                    <div class="py-8 text-center text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                        <i class="fa-solid fa-award text-2xl text-slate-300 mb-2 block"></i>
                        <p class="text-xs">${_currentSiswaPencapaian.length === 0 ? 'Belum ada riwayat penilaian pelatih untuk siswa ini.' : 'Tidak ada riwayat penilaian pada bulan/tahun yang dipilih.'}</p>
                    </div>`;
                return;
            }

            filtered.forEach((p, idx) => {
                const originalIdx = _currentSiswaPencapaian.indexOf(p);
                const sesiNumber = originalIdx !== -1 ? (_currentSiswaPencapaian.length - originalIdx) : (filtered.length - idx);
                const avgSesi = (((Number(p.teknik) || 0) + (Number(p.kecepatan) || 0) + (Number(p.ketahanan) || 0)) / 3).toFixed(1);
                const renderDots = (score, activeColor) => {
                    let dots = '';
                    for (let s = 1; s <= 5; s++) {
                        dots += `<span class="w-2.5 h-2.5 rounded-full ${s <= score ? activeColor : 'bg-slate-200'}"></span>`;
                    }
                    return dots;
                };

                let kejuaraanHtml = '';
                if (p.kejuaraan) {
                    kejuaraanHtml = `
                        <div class="mt-2.5 p-2 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fa-solid fa-trophy text-amber-500"></i>
                            <span>${p.kejuaraan}</span>
                        </div>`;
                }

                pencapaianContainer.innerHTML += `
                    <div class="p-4 bg-white border border-slate-200/80 rounded-2xl shadow-2xs">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div>
                                <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                    <span class="px-2.5 py-0.5 bg-sky-100 text-[#00a5ec] font-bold text-[10px] rounded-full">Sesi ${sesiNumber}</span>
                                    <span class="px-2.5 py-0.5 bg-cyan-50 text-[#008cc9] border border-cyan-200 font-semibold text-[10px] rounded-full"><i class="fa-solid fa-person-swimming mr-1 text-[9px]"></i>${p.gaya_renang}</span>
                                    ${p.catatan_waktu && p.catatan_waktu !== '-' ? `<span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold"><i class="fa-solid fa-stopwatch text-amber-500 mr-1 text-[9px]"></i>${p.catatan_waktu}</span>` : ''}
                                </div>
                                <p class="text-xs font-bold text-slate-700">Dicatat pada: ${p.tanggal_catat}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-[10px] text-slate-400 block">Rata-rata</span>
                                <span class="text-lg font-extrabold text-[#00a5ec]">${avgSesi} <span class="text-[10px] font-normal text-slate-400">/5</span></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 my-3 text-xs">
                            <div class="bg-[#f0f9ff] rounded-xl p-2.5 text-center border border-sky-100">
                                <span class="text-[10px] font-semibold text-slate-600 block mb-0.5">Teknik</span>
                                <div class="text-base font-extrabold text-[#00a5ec] mb-1">${p.teknik}</div>
                                <div class="flex justify-center gap-1">${renderDots(p.teknik, 'bg-[#00a5ec]')}</div>
                            </div>
                            <div class="bg-[#ecfdf5] rounded-xl p-2.5 text-center border border-emerald-100">
                                <span class="text-[10px] font-semibold text-slate-600 block mb-0.5">Kecepatan</span>
                                <div class="text-base font-extrabold text-emerald-600 mb-1">${p.kecepatan}</div>
                                <div class="flex justify-center gap-1">${renderDots(p.kecepatan, 'bg-emerald-500')}</div>
                            </div>
                            <div class="bg-[#fffbeb] rounded-xl p-2.5 text-center border border-amber-100">
                                <span class="text-[10px] font-semibold text-slate-600 block mb-0.5">Ketahanan</span>
                                <div class="text-base font-extrabold text-amber-500 mb-1">${p.ketahanan}</div>
                                <div class="flex justify-center gap-1">${renderDots(p.ketahanan, 'bg-amber-400')}</div>
                            </div>
                        </div>

                        ${p.catatan && p.catatan !== '-' ? `
                            <div class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <span class="font-semibold text-slate-700 block text-[11px] mb-0.5"><i class="fa-regular fa-comment-dots mr-1 text-sky-500"></i>Catatan Pelatih:</span>
                                <p class="italic text-slate-600">"${p.catatan}"</p>
                            </div>` : ''}

                        ${kejuaraanHtml}
                    </div>`;
            });
        }

        // ---- Photo Preview for Edit Siswa ----
        function previewEditSiswaFoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('editSiswaFotoPreview');
            const placeholder = document.getElementById('editSiswaFotoPlaceholder');
            const btnHapus = document.getElementById('btnHapusEditSiswaFoto');
            const hapusFotoInput = document.getElementById('editSiswaHapusFotoInput');
            const fotoInfo = document.getElementById('editSiswaFotoInfo');

            if (file) {
                if (hapusFotoInput) hapusFotoInput.value = '0';
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    if (btnHapus) btnHapus.classList.remove('hidden');
                    if (fotoInfo) fotoInfo.textContent = file.name;
                }
                reader.readAsDataURL(file);
            }
        }

        function hapusEditSiswaFoto() {
            const input = document.getElementById('editSiswaFotoInput');
            const preview = document.getElementById('editSiswaFotoPreview');
            const placeholder = document.getElementById('editSiswaFotoPlaceholder');
            const btnHapus = document.getElementById('btnHapusEditSiswaFoto');
            const hapusFotoInput = document.getElementById('editSiswaHapusFotoInput');
            const fotoInfo = document.getElementById('editSiswaFotoInfo');

            // Jika user baru saja memilih file baru yang belum disimpan, batalkan pilihan
            if (input && input.files && input.files.length > 0) {
                input.value = '';
                if (_currentSiswaFotoUrl) {
                    preview.src = _currentSiswaFotoUrl;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    if (btnHapus) btnHapus.classList.remove('hidden');
                    if (fotoInfo) fotoInfo.textContent = 'Foto tersimpan';
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.textContent = _currentSiswaInitials;
                    placeholder.classList.remove('hidden');
                    if (btnHapus) btnHapus.classList.add('hidden');
                    if (fotoInfo) fotoInfo.textContent = 'Format: JPG, PNG, WEBP (Maks. 2MB, opsional)';
                }
                if (hapusFotoInput) hapusFotoInput.value = '0';
                return;
            }

            // Jika memang ingin menghapus foto yang ada di database
            if (input) input.value = '';
            if (hapusFotoInput) hapusFotoInput.value = '1';
            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
            if (placeholder) {
                placeholder.textContent = _currentSiswaInitials;
                placeholder.classList.remove('hidden');
            }
            if (btnHapus) btnHapus.classList.add('hidden');
            if (fotoInfo) fotoInfo.textContent = 'Foto akan dihapus saat disimpan';
        }

        // ---- Hapus Siswa ----
        function konfirmasiHapusSiswa() {
            if (!_currentSiswaId) return;
            document.getElementById('konfirmNamaSiswa').textContent = _currentSiswaNama;
            openModal('modalKonfirmasiHapusSiswa');
        }

        function deleteSiswa() {
            if (!_currentSiswaId) return;
            const form = document.getElementById('formDeleteSiswa');
            form.action = '{{ url('/admin/siswa') }}/' + _currentSiswaId + '/delete';
            form.submit();
        }

        // ---- Pagination & Live Search Filter Siswa ----
        const SISWA_PER_PAGE = 15;
        let _currentSiswaPage = 1;
        let _filteredSiswaRows = [];

        function filterSiswaTable(resetPage = true) {
            const input = document.getElementById('searchSiswaInput');
            const query = input ? input.value.toLowerCase().trim() : '';
            const allRows = Array.from(document.querySelectorAll('.row-siswa-item'));

            _filteredSiswaRows = allRows.filter(row => {
                const searchData = row.getAttribute('data-search') || '';
                return searchData.includes(query);
            });

            if (resetPage) {
                _currentSiswaPage = 1;
            }

            renderSiswaTablePage();
        }

        function changeSiswaPage(newPage) {
            const totalPages = Math.ceil(_filteredSiswaRows.length / SISWA_PER_PAGE) || 1;
            if (newPage < 1 || newPage > totalPages) return;
            _currentSiswaPage = newPage;
            renderSiswaTablePage();

            // Smooth scroll to top of table if scrolled down
            const container = document.getElementById('siswaPaginationContainer');
            if (container) {
                container.closest('.bg-white')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function renderSiswaTablePage() {
            const allRows = document.querySelectorAll('.row-siswa-item');
            const notFoundRow = document.getElementById('siswaNotFoundRow');
            const paginationContainer = document.getElementById('siswaPaginationContainer');
            const totalFiltered = _filteredSiswaRows.length;
            const totalPages = Math.ceil(totalFiltered / SISWA_PER_PAGE) || 1;

            if (_currentSiswaPage > totalPages) _currentSiswaPage = totalPages;
            if (_currentSiswaPage < 1) _currentSiswaPage = 1;

            const startIndex = (_currentSiswaPage - 1) * SISWA_PER_PAGE;
            const endIndex = startIndex + SISWA_PER_PAGE;

            // Hide all rows first
            allRows.forEach(row => row.style.display = 'none');

            // Show only rows for the current page
            _filteredSiswaRows.slice(startIndex, endIndex).forEach(row => {
                row.style.display = '';
            });

            // Not found row handling
            if (notFoundRow) {
                if (allRows.length > 0 && totalFiltered === 0) {
                    notFoundRow.classList.remove('hidden');
                } else {
                    notFoundRow.classList.add('hidden');
                }
            }

            // Pagination info and buttons
            if (paginationContainer) {
                if (totalFiltered === 0) {
                    paginationContainer.classList.add('hidden');
                } else {
                    paginationContainer.classList.remove('hidden');

                    const pageStartEl = document.getElementById('siswaPageStart');
                    const pageEndEl = document.getElementById('siswaPageEnd');
                    const totalRowsEl = document.getElementById('siswaTotalRows');

                    if (pageStartEl) pageStartEl.textContent = startIndex + 1;
                    if (pageEndEl) pageEndEl.textContent = Math.min(endIndex, totalFiltered);
                    if (totalRowsEl) totalRowsEl.textContent = totalFiltered;

                    renderSiswaPaginationButtons(totalPages);
                }
            }
        }

        function renderSiswaPaginationButtons(totalPages) {
            const container = document.getElementById('siswaPaginationButtons');
            if (!container) return;

            let html = '';

            // Tombol Previous
            const prevDisabled = _currentSiswaPage === 1 ? 'disabled' : '';
            html += `<button type="button" onclick="changeSiswaPage(${_currentSiswaPage - 1})" ${prevDisabled}
                class="px-2.5 sm:px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition flex items-center gap-1 cursor-pointer">
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                <span class="hidden sm:inline">Sebelumnya</span>
            </button>`;

            // Nomor Halaman
            const createPageBtn = (p) => {
                const isActive = p === _currentSiswaPage;
                if (isActive) {
                    return `<button type="button" class="w-8 h-8 flex items-center justify-center text-xs font-bold rounded-lg bg-[#00a5ec] text-white shadow-xs">${p}</button>`;
                }
                return `<button type="button" onclick="changeSiswaPage(${p})" class="w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer">${p}</button>`;
            };

            if (totalPages <= 7) {
                for (let i = 1; i <= totalPages; i++) {
                    html += createPageBtn(i);
                }
            } else {
                html += createPageBtn(1);
                if (_currentSiswaPage > 3) {
                    html += `<span class="w-6 text-center text-xs text-slate-400">...</span>`;
                }

                const start = Math.max(2, _currentSiswaPage - 1);
                const end = Math.min(totalPages - 1, _currentSiswaPage + 1);
                for (let i = start; i <= end; i++) {
                    html += createPageBtn(i);
                }

                if (_currentSiswaPage < totalPages - 2) {
                    html += `<span class="w-6 text-center text-xs text-slate-400">...</span>`;
                }
                html += createPageBtn(totalPages);
            }

            // Tombol Next
            const nextDisabled = _currentSiswaPage === totalPages ? 'disabled' : '';
            html += `<button type="button" onclick="changeSiswaPage(${_currentSiswaPage + 1})" ${nextDisabled}
                class="px-2.5 sm:px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition flex items-center gap-1 cursor-pointer">
                <span class="hidden sm:inline">Selanjutnya</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>`;

            container.innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', function() {
            filterSiswaTable(true);
        });

        // ---- Detail Sesi Latihan ----
        let _sesiDetailData = [];
        let _currentSesiRawDate = '';

        function openDetailSesi(tanggal, hari, total, hadir, izin, sakit, alpha, pct, detail, rawDate, namaKelas) {
            _sesiDetailData = detail;
            _currentSesiRawDate = rawDate || '';

            // Isi header
            document.getElementById('sesiModalTitle').textContent = 'Sesi ' + (namaKelas ? namaKelas + ' · ' : '') + tanggal;
            document.getElementById('sesiModalSubtitle').textContent = hari + (namaKelas ? ' · ' + namaKelas : '') + ' · ' + total + ' siswa tercatat';

            // KPI
            document.getElementById('sesiKpiTotal').textContent = total;
            document.getElementById('sesiKpiHadir').textContent = hadir;
            document.getElementById('sesiKpiIzin').textContent = (izin + sakit);
            document.getElementById('sesiKpiAlpha').textContent = alpha;

            // Progress bar
            const pctEl = document.getElementById('sesiKpiPct');
            const bar = document.getElementById('sesiProgressBar');
            pctEl.textContent = pct + '%';
            pctEl.className = 'text-sm font-extrabold ' + (pct >= 80 ? 'text-emerald-600' : pct >= 50 ? 'text-amber-600' : 'text-rose-500');
            bar.className = 'h-3 rounded-full transition-all duration-700 ' + (pct >= 80 ? 'bg-emerald-400' : pct >= 50 ? 'bg-amber-400' : 'bg-rose-400');
            setTimeout(() => { bar.style.width = pct + '%'; }, 50);

            // Reset search/filter
            const searchEl = document.getElementById('sesiDetailSearch');
            const filterEl = document.getElementById('sesiDetailFilter');
            if (searchEl) searchEl.value = '';
            if (filterEl) filterEl.value = '';

            renderSesiDetail(detail);
            openModal('modalDetailSesi');
        }

        function renderSesiDetail(data) {
            const tbody = document.getElementById('sesiDetailBody');
            const empty = document.getElementById('sesiDetailEmpty');
            if (!tbody) return;

            if (!data || data.length === 0) {
                tbody.innerHTML = '';
                if (empty) empty.classList.remove('hidden');
                return;
            }

            if (empty) empty.classList.add('hidden');

            tbody.innerHTML = data.map((d, i) => {
                const badge = statusBadgeSesi(d.status);
                return `<tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 pr-4 text-slate-400 font-medium">${i + 1}</td>
                    <td class="py-2.5 pr-4 font-bold text-slate-800 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-cyan-100 text-[#008cc9] font-extrabold text-[10px] flex items-center justify-center shrink-0">
                                ${d.nama.charAt(0).toUpperCase()}
                            </div>
                            ${d.nama}
                        </div>
                    </td>
                    <td class="py-2.5 pr-4 text-slate-500 whitespace-nowrap">${d.kelas}</td>
                    <td class="py-2.5 whitespace-nowrap">${badge}</td>
                    <td class="py-2.5 text-slate-400 max-w-[140px] truncate">${d.keterangan}</td>
                </tr>`;
            }).join('');
        }

        function statusBadgeSesi(status) {
            const map = {
                'hadir':        '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200"><i class="fa-solid fa-check text-[8px]"></i> Hadir</span>',
                'izin':         '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-600 border border-amber-200"><i class="fa-solid fa-minus text-[8px]"></i> Izin</span>',
                'sakit':        '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-sky-50 text-sky-600 border border-sky-200"><i class="fa-solid fa-heart-pulse text-[8px]"></i> Sakit</span>',
                'tidak_hadir':  '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-500 border border-rose-200"><i class="fa-solid fa-xmark text-[8px]"></i> Alpha</span>',
            };
            return map[status] || `<span class="text-slate-400">${status}</span>`;
        }

        function filterSesiDetail() {
            const search = (document.getElementById('sesiDetailSearch')?.value || '').toLowerCase().trim();
            const status = document.getElementById('sesiDetailFilter')?.value || '';

            const filtered = _sesiDetailData.filter(d => {
                const matchName   = !search || d.nama.toLowerCase().includes(search);
                const matchStatus = !status || d.status === status;
                return matchName && matchStatus;
            });

            renderSesiDetail(filtered);
        }

        function exportDataSiswa() {
            const searchInput = document.getElementById('searchSiswaInput');
            const searchVal   = searchInput ? searchInput.value.trim() : '';
            let url = '{{ route('admin.siswa.export') }}';
            if (searchVal) {
                url += '?search_siswa=' + encodeURIComponent(searchVal);
            }
            window.location.href = url;
        }

        function exportSesiIni() {
            if (!_currentSesiRawDate) return;
            const url = '{{ route('admin.siswa.absensi.export') }}?format=sesi&start_date=' + encodeURIComponent(_currentSesiRawDate) + '&end_date=' + encodeURIComponent(_currentSesiRawDate);
            window.open(url, '_blank');
        }

        // ---- Modal Export Absensi: Rekap Per Siswa & Log Per Sesi ----
        let _currentExportFormat = 'rekap';

        function switchExportFormat(format) {
            _currentExportFormat = format;
            const form = document.getElementById('formExportSiswa');
            const radioRekap = document.getElementById('radioExportRekap');
            const radioSesi  = document.getElementById('radioExportSesi');
            const titleEl    = document.querySelector('#modalExportAbsensi h3');
            const infoText   = document.getElementById('exportInfoText');

            if (form) form.action = '{{ route('admin.siswa.absensi.export') }}';

            if (format === 'sesi') {
                if (radioSesi) radioSesi.checked = true;
                if (titleEl) titleEl.textContent = 'Export Log Kehadiran Per Sesi Siswa';
                if (infoText) infoText.innerHTML = 'Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat rincian absensi harian per sesi: Tanggal Kehadiran, ID Siswa, Nama Siswa, Kelas, Cabang, Status Kehadiran, dan Keterangan.';
            } else {
                if (radioRekap) radioRekap.checked = true;
                if (titleEl) titleEl.textContent = 'Export Rekap Absensi Per Siswa';
                if (infoText) infoText.innerHTML = 'Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat rangkuman per siswa: ID Siswa, Nama Siswa, Kelas, Cabang, Total Hadir, Total Izin, Total Sakit, dan Total Alfa.';
            }
        }

        function openModalExportAbsensi(initialFormat = 'rekap') {
            switchExportFormat(initialFormat);

            const startInput = document.getElementById('exportStartDate');
            const endInput   = document.getElementById('exportEndDate');
            if (startInput && endInput && !startInput.value && !endInput.value) {
                setQuickRange('this_month');
            }

            openModal('modalExportAbsensi');
        }

        function setQuickRange(type) {
            const startInput = document.getElementById('exportStartDate');
            const endInput   = document.getElementById('exportEndDate');
            if (!startInput || !endInput) return;

            const today = new Date();
            const fmt = (d) => {
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            if (type === '7d') {
                const past = new Date();
                past.setDate(today.getDate() - 7);
                startInput.value = fmt(past);
                endInput.value = fmt(today);
            } else if (type === '30d') {
                const past = new Date();
                past.setDate(today.getDate() - 30);
                startInput.value = fmt(past);
                endInput.value = fmt(today);
            } else if (type === 'this_month') {
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                const lastDay  = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                startInput.value = fmt(firstDay);
                endInput.value = fmt(lastDay);
            } else if (type === 'last_month') {
                const firstDay = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                const lastDay  = new Date(today.getFullYear(), today.getMonth(), 0);
                startInput.value = fmt(firstDay);
                endInput.value = fmt(lastDay);
            } else if (type === 'all') {
                startInput.value = '';
                endInput.value = '';
            }
        }

        function openDetailPendaftar(data) {
            // Header
            document.getElementById('mdpNamaSiswa').textContent = data.nama_siswa;
            document.getElementById('mdpTanggalDaftar').innerHTML = `<i class="fa-regular fa-clock text-slate-400"></i> <span>Daftar pada ${data.created_at_fmt}</span>`;

            // Avatar
            const avatar = document.getElementById('mdpAvatar');
            if (data.foto_siswa) {
                avatar.innerHTML = `<img src="${data.foto_siswa}" alt="${data.nama_siswa}" class="w-full h-full object-cover">`;
            } else {
                avatar.textContent = (data.nama_siswa.charAt(0) || 'P').toUpperCase();
            }

            // Data Siswa
            const ttl = (data.tempat_lahir && data.tempat_lahir !== '-' ? data.tempat_lahir + ', ' : '') + (data.tanggal_lahir_fmt || '-');
            document.getElementById('mdpTTL').textContent = ttl;
            document.getElementById('mdpUmur').textContent = (data.umur ? data.umur + ' Tahun' : '-');
            document.getElementById('mdpSekolah').textContent = data.sekolah || '-';
            document.getElementById('mdpKelasCabang').textContent = data.nama_kelas || '-';

            document.getElementById('mdpRiwayatPenyakit').textContent = (data.riwayat_penyakit && data.riwayat_penyakit !== '-') ? data.riwayat_penyakit : 'Tidak ada riwayat penyakit';
            document.getElementById('mdpCatatanKhusus').textContent = (data.catatan_khusus && data.catatan_khusus !== '-') ? data.catatan_khusus : '-';

            // Data Ortu
            document.getElementById('mdpNamaOrtu').textContent = data.nama_orang_tua || '-';
            document.getElementById('mdpNoHpOrtu').textContent = data.no_hp || '-';
            document.getElementById('mdpEmailOrtu').textContent = data.email || '-';
            document.getElementById('mdpAlamatOrtu').textContent = data.alamat || '-';

            // WhatsApp link
            const waBtn = document.getElementById('mdpBtnWa');
            if (data.no_hp && data.no_hp !== '-') {
                let cleanPhone = data.no_hp.replace(/\D/g, '');
                if (cleanPhone.startsWith('0')) {
                    cleanPhone = '62' + cleanPhone.slice(1);
                }
                const msg = encodeURIComponent(`Halo Bpk/Ibu ${data.nama_orang_tua}, kami dari Tim Administrasi Gajah Depa Akuatik ingin mengonfirmasi pendaftaran ananda ${data.nama_siswa}.`);
                waBtn.href = `https://wa.me/${cleanPhone}?text=${msg}`;
                waBtn.classList.remove('hidden');
            } else {
                waBtn.classList.add('hidden');
            }

            // Pembayaran Badge
            const payBadge = document.getElementById('mdpMetodePembayaranBadge');
            if (data.pilihan_pembayaran === 'transfer') {
                payBadge.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-[#008cc9] border border-sky-200"><i class="fa-solid fa-credit-card"></i> Transfer Bank</span>`;
            } else {
                payBadge.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"><i class="fa-solid fa-money-bill-wave"></i> Tunai (Cash di Lokasi)</span>`;
            }

            // Bukti Pembayaran
            const buktiCont = document.getElementById('mdpBuktiPembayaranContainer');
            if (data.bukti_pembayaran) {
                buktiCont.innerHTML = `
                    <div class="relative group mt-1 inline-block">
                        <img src="${data.bukti_pembayaran}" alt="Bukti Pembayaran" class="h-24 w-auto max-w-full rounded-xl object-cover border border-slate-200 shadow-2xs">
                        <a href="${data.bukti_pembayaran}" target="_blank" class="absolute inset-0 bg-slate-900/50 rounded-xl opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white font-semibold text-xs gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-magnifying-glass-plus"></i> Lihat Bukti
                        </a>
                    </div>
                `;
            } else {
                buktiCont.innerHTML = `<span class="text-xs text-slate-400 italic">Tidak ada lampiran bukti bayar</span>`;
            }

            // Surat Perjanjian
            const suratCont = document.getElementById('mdpSuratPerjanjianContainer');
            if (data.surat_perjanjian) {
                suratCont.innerHTML = `
                    <a href="${data.surat_perjanjian}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-slate-200 hover:border-[#00a5ec] text-slate-700 hover:text-[#008cc9] transition text-xs font-semibold shadow-2xs mt-1 cursor-pointer">
                        <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                        <span>Buka Surat Perjanjian</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                    </a>
                `;
            } else {
                suratCont.innerHTML = `<span class="text-xs text-slate-400 italic">Belum melampirkan surat perjanjian</span>`;
            }

            // Action Forms
            document.getElementById('mdpFormAcc').action = '{{ url('/admin/siswa/acc') }}/' + data.id;
            document.getElementById('mdpFormTolak').action = '{{ url('/admin/siswa/tolak') }}/' + data.id;

            openModal('modalDetailPendaftarBaru');
        }

        // ---- Konfirmasi ACC & Tolak Pendaftar Baru ----
        let _targetPendaftarFormToSubmit = null;
        let _isSubmittingPendaftar = false;

        function konfirmasiTolakPendaftar(formIdOrElement, namaSiswa) {
            if (_isSubmittingPendaftar) return;
            _targetPendaftarFormToSubmit = (typeof formIdOrElement === 'string') ? document.getElementById(formIdOrElement) : formIdOrElement;
            const el = document.getElementById('konfirmTolakNamaPendaftar');
            if (el) el.textContent = namaSiswa ? namaSiswa.trim() : 'Calon Siswa Ini';

            const btnTolak = document.getElementById('btnKonfirmasiTolakSubmit');
            if (btnTolak) {
                btnTolak.disabled = false;
                btnTolak.classList.remove('opacity-70', 'cursor-not-allowed');
                btnTolak.innerHTML = '<i class="fa-solid fa-xmark mr-1"></i>Ya, Tolak';
            }
            const btnBatal = document.getElementById('btnKonfirmasiTolakBatal');
            if (btnBatal) {
                btnBatal.disabled = false;
                btnBatal.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            openModal('modalKonfirmasiTolakPendaftar');
        }

        function eksekusiTolakPendaftar() {
            if (_isSubmittingPendaftar) return;
            if (_targetPendaftarFormToSubmit) {
                _isSubmittingPendaftar = true;
                const btnTolak = document.getElementById('btnKonfirmasiTolakSubmit');
                if (btnTolak) {
                    btnTolak.disabled = true;
                    btnTolak.classList.add('opacity-70', 'cursor-not-allowed');
                    btnTolak.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-1.5"></i>Memproses...';
                }
                const btnBatal = document.getElementById('btnKonfirmasiTolakBatal');
                if (btnBatal) {
                    btnBatal.disabled = true;
                    btnBatal.classList.add('opacity-50', 'cursor-not-allowed');
                }
                _targetPendaftarFormToSubmit.submit();
            }
        }

        function konfirmasiAccPendaftar(formIdOrElement, namaSiswa) {
            if (_isSubmittingPendaftar) return;
            _targetPendaftarFormToSubmit = (typeof formIdOrElement === 'string') ? document.getElementById(formIdOrElement) : formIdOrElement;
            const el = document.getElementById('konfirmAccNamaPendaftar');
            if (el) el.textContent = namaSiswa ? namaSiswa.trim() : 'Calon Siswa Ini';

            const btnAcc = document.getElementById('btnKonfirmasiAccSubmit');
            if (btnAcc) {
                btnAcc.disabled = false;
                btnAcc.classList.remove('opacity-70', 'cursor-not-allowed');
                btnAcc.innerHTML = '<i class="fa-solid fa-check mr-1"></i>Ya, ACC';
            }
            const btnBatal = document.getElementById('btnKonfirmasiAccBatal');
            if (btnBatal) {
                btnBatal.disabled = false;
                btnBatal.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            openModal('modalKonfirmasiAccPendaftar');
        }

        function eksekusiAccPendaftar() {
            if (_isSubmittingPendaftar) return;
            if (_targetPendaftarFormToSubmit) {
                _isSubmittingPendaftar = true;
                const btnAcc = document.getElementById('btnKonfirmasiAccSubmit');
                if (btnAcc) {
                    btnAcc.disabled = true;
                    btnAcc.classList.add('opacity-70', 'cursor-not-allowed');
                    btnAcc.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-1.5"></i>Memproses ACC...';
                }
                const btnBatal = document.getElementById('btnKonfirmasiAccBatal');
                if (btnBatal) {
                    btnBatal.disabled = true;
                    btnBatal.classList.add('opacity-50', 'cursor-not-allowed');
                }
                _targetPendaftarFormToSubmit.submit();
            }
        }

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openModal('modalTambahSiswa');
            });
        @endif
    </script>

    @include('components.logout-modal')
</body>
</html>
