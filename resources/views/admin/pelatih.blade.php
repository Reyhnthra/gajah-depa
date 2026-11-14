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
    </style>
    <title>Manajemen Pelatih - Gajah Depa Akuatik</title>
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
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Manajemen Pelatih</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data pelatih dan absensi harian</p>
        </div>

        <!-- KPI Summary Cards Jumlah Pelatih -->
        <div class="flex overflow-x-auto pb-3 pt-1 gap-3 snap-x snap-mandatory scroll-smooth no-scrollbar md:grid md:grid-cols-3 md:gap-6 md:pb-0 md:pt-0 mb-8">
            <!-- Card 1: Total Pelatih -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-[#00a5ec] relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pelatih</p>
                        <h3 class="text-xl sm:text-3xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            {{ $total_pelatih ?? count($data_pelatih) }}
                        </h3>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-sky-50 flex items-center justify-center text-[#00a5ec] text-sm sm:text-xl font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#00a5ec]"></span> Terdaftar
                </p>
            </div>

            <!-- Card 2: Pelatih Aktif -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-emerald-500 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelatih Aktif</p>
                        <h3 class="text-xl sm:text-3xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            {{ $pelatih_aktif ?? $data_pelatih->where('status', 'aktif')->count() }}
                        </h3>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-sm sm:text-xl font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span> Siap melatih
                </p>
            </div>

            <!-- Card 3: Pelatih Non-Aktif -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-slate-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelatih Non-Aktif</p>
                        <h3 class="text-xl sm:text-3xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            {{ $pelatih_nonaktif ?? $data_pelatih->where('status', 'nonaktif')->count() }}
                        </h3>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 text-sm sm:text-xl font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-slate-400"></span> Sedang tidak aktif / off
                </p>
            </div>
        </div>

        <!-- Container 1: Daftar Pelatih Card Grid -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Daftar Pelatih</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar seluruh instruktur dan pelatih klub</p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <!-- Search Input Bar -->
                    <div class="relative w-full sm:w-60">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" id="searchPelatihInput" oninput="filterPelatihCards()" value="{{ request('search_pelatih') }}" placeholder="Cari nama / email..."
                            class="w-full pl-9 pr-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                    </div>
                    <!-- Navigasi Slide Pelatih -->
                    <div class="hidden sm:flex items-center gap-1 bg-slate-50 p-1 border border-slate-200 rounded-xl">
                        <button type="button" onclick="slidePelatih('left')" title="Geser ke kiri" class="w-8 h-8 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 hover:text-[#00a5ec] text-slate-600 flex items-center justify-center transition shadow-xs active:scale-95">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button type="button" onclick="slidePelatih('right')" title="Geser ke kanan" class="w-8 h-8 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 hover:text-[#00a5ec] text-slate-600 flex items-center justify-center transition shadow-xs active:scale-95">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                    <button type="button" onclick="exportDataPelatih()" title="Download Data Master Pelatih (CSV)" class="bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2 group">
                        <i class="fa-solid fa-download text-xs text-[#00a5ec] group-hover:scale-110 transition-transform"></i>
                        <span>Export</span>
                    </button>
                    <button type="button" onclick="openModal('modalTambahPelatih')" class="bg-[#00a5ec] hover:bg-[#0092d1] active:scale-[0.98] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Pelatih</span>
                    </button>
                </div>
            </div>

            <!-- Cards Slider Pelatih (Horizontal Carousel) -->
            <div class="relative group/slider">
                <!-- Floating Nav Button Prev -->
                <button type="button" onclick="slidePelatih('left')" title="Geser ke kiri"
                    class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-lg border border-slate-200 text-slate-600 hover:text-[#00a5ec] hover:border-[#00a5ec] items-center justify-center transition z-20 opacity-0 group-hover/slider:opacity-100 active:scale-90">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <!-- Floating Nav Button Next -->
                <button type="button" onclick="slidePelatih('right')" title="Geser ke kanan"
                    class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-lg border border-slate-200 text-slate-600 hover:text-[#00a5ec] hover:border-[#00a5ec] items-center justify-center transition z-20 opacity-0 group-hover/slider:opacity-100 active:scale-90">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>

                <!-- Slider Container -->
                <div id="gridDaftarPelatih" class="flex overflow-x-auto pb-4 pt-1 gap-5 snap-x snap-mandatory scroll-smooth no-scrollbar">
                    @forelse($data_pelatih as $pelatih)
                        @php
                            $words = explode(' ', $pelatih->nama);
                            $initials = '';
                            foreach($words as $w) { $initials .= strtoupper(substr($w, 0, 1)); }
                            $initials = substr($initials, 0, 2);

                            // Hitung statistik absensi pelatih ini (khusus bulan & tahun berjalan saja)
                            $currentBulanNum = (int) date('n');
                            $currentTahunNum = (int) date('Y');

                            $riwayatSemua = $absensi_per_pelatih->get($pelatih->id_pelatih, collect([]));
                            
                            $riwayatBulanIni = $riwayatSemua->filter(function($r) use ($currentTahunNum, $currentBulanNum) {
                                if (empty($r->tanggal_kehadiran)) return false;
                                $time = strtotime($r->tanggal_kehadiran);
                                return ((int)date('Y', $time) === $currentTahunNum && (int)date('n', $time) === $currentBulanNum);
                            });

                            $jml_hadir = $riwayatBulanIni->where('status_kehadiran', 'hadir')->count();
                            $jml_izin  = $riwayatBulanIni->where('status_kehadiran', 'izin')->count();
                            $jml_sakit = $riwayatBulanIni->where('status_kehadiran', 'sakit')->count();
                            $jml_total = $riwayatBulanIni->count();

                            // Encode riwayat ke JSON untuk JS (tetap bawa seluruh riwayat untuk tabel riwayat)
                            $riwayat_json = $riwayatSemua->map(fn($r) => [
                                'tanggal' => $r->tanggal_kehadiran,
                                'status'  => $r->status_kehadiran,
                                'ket'     => $r->keterangan ?? '-',
                            ])->values()->toJson();

                            $pelatihFotoUrl = ($pelatih->foto && file_exists(public_path($pelatih->foto))) ? asset($pelatih->foto) : '';
                        @endphp
                        <div class="card-pelatih-item w-[280px] sm:w-[calc((100%-20px)/2)] md:w-[calc((100%-40px)/3)] lg:w-[calc((100%-60px)/4)] shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-sky-200 hover:-translate-y-0.5 transition cursor-pointer group"
                            data-nama="{{ strtolower($pelatih->nama) }}" data-email="{{ strtolower($pelatih->email) }}" data-rek="{{ strtolower($pelatih->no_rek ?? '') }}"
                            onclick="openDetailPelatih({{ $pelatih->id_pelatih }}, '{{ addslashes($pelatih->nama) }}', '{{ addslashes($initials) }}', '{{ addslashes($pelatih->email) }}', '{{ addslashes($pelatih->tempat_lahir ?? '-') }}', '{{ $pelatih->tanggal_lahir ?? '' }}', '{{ $pelatih->tanggal_lahir ? date('d/m/Y', strtotime($pelatih->tanggal_lahir)) : '-' }}', '{{ addslashes($pelatih->no_rek ?? '-') }}', '{{ $pelatih->status }}', '{{ $pelatihFotoUrl }}', {{ $jml_hadir }}, {{ $jml_izin }}, {{ $jml_sakit }}, {{ $jml_total }}, {{ $riwayat_json }}, '{{ addslashes($pelatih->no_hp ?? '') }}')">
                        <div>
                            <div class="flex items-start justify-between gap-1 mb-3 sm:mb-4">
                                @if($pelatih->foto && file_exists(public_path($pelatih->foto)))
                                    <img src="{{ asset($pelatih->foto) }}" alt="{{ $pelatih->nama }}" class="w-11 h-11 sm:w-14 sm:h-14 rounded-full object-cover shadow-sm shrink-0 border-2 border-sky-100">
                                @else
                                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-[#00a5ec] text-white font-bold text-sm sm:text-lg flex items-center justify-center shadow-sm shrink-0">
                                        {{ $initials }}
                                    </div>
                                @endif
                                @if($pelatih->status === 'aktif')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold border border-emerald-400 text-emerald-600 bg-emerald-50 shrink-0">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold border border-slate-300 text-slate-500 bg-slate-50 shrink-0">Non-Aktif</span>
                                @endif
                            </div>

                            <h4 class="text-sm sm:text-base font-bold text-[#008cc9] mb-1 truncate">{{ $pelatih->nama }}</h4>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium mb-2 truncate">{{ $pelatih->email }}</p>

                            <div class="space-y-0.5 sm:space-y-1 text-[10px] sm:text-[11px] text-slate-400 mb-3">
                                <div class="truncate">
                                    <i class="fa-solid fa-cake-candles mr-1"></i>{{ $pelatih->tempat_lahir ?? '-' }}, {{ $pelatih->tanggal_lahir ? date('d/m/Y', strtotime($pelatih->tanggal_lahir)) : '-' }}
                                </div>
                                <div class="truncate">
                                    <i class="fa-regular fa-credit-card mr-1"></i>Rek: {{ $pelatih->no_rek ?? '-' }}
                                </div>
                                @if(!empty($pelatih->no_hp))
                                    <div class="truncate text-emerald-600 font-semibold">
                                        <i class="fa-brands fa-whatsapp mr-1 text-emerald-500"></i>{{ $pelatih->no_hp }}
                                    </div>
                                @endif
                            </div>

                            <!-- Stat kehadiran mini -->
                            <div class="flex flex-wrap items-center gap-1.5 text-[10px]">
                                <span class="flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full font-semibold border border-emerald-200">
                                    <i class="fa-solid fa-check text-[9px]"></i> {{ $jml_hadir }} Hadir
                                </span>
                                <span class="flex items-center gap-1 px-2 py-0.5 bg-amber-50 text-amber-600 rounded-full font-semibold border border-amber-200">
                                    <i class="fa-solid fa-minus text-[9px]"></i> {{ $jml_izin }} Izin
                                </span>
                                <span class="flex items-center gap-1 px-2 py-0.5 bg-rose-50 text-rose-500 rounded-full font-semibold border border-rose-200">
                                    <i class="fa-solid fa-xmark text-[9px]"></i> {{ $jml_sakit }} Sakit
                                </span>
                            </div>
                        </div>

                        <!-- Click hint -->
                        <p class="mt-3 text-[10px] text-slate-300 text-center group-hover:text-sky-300 transition">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>Klik untuk detail
                        </p>
                    </div>
                @empty
                    <div class="w-full col-span-full py-8 text-center text-slate-400 text-xs">
                        Belum ada data pelatih. Klik "+ Tambah Pelatih" untuk menambah data.
                    </div>
                @endforelse
                    <div id="pelatihNotFound" class="hidden shrink-0 w-80 py-10 text-center text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass text-slate-300 text-xl mb-2 block"></i>
                        <span>Pelatih yang dicari tidak ditemukan.</span>
                    </div>
                </div><!-- end #gridDaftarPelatih -->
            </div><!-- end .relative.group/slider -->
        </div><!-- end container Daftar Pelatih -->

        <!-- Container 2: Absensi Pelatih Table Card -->
        @php
            $daftarBulanPelatih = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $selectedBulanAbsensi = $bulanAbsensi ?? request('bulan', (string)date('n'));
            $selectedTahunAbsensi = $tahunAbsensi ?? request('tahun', (string)date('Y'));
            $labelPeriodeAbsensi = ($selectedBulanAbsensi !== 'semua' && isset($daftarBulanPelatih[(int)$selectedBulanAbsensi]))
                ? $daftarBulanPelatih[(int)$selectedBulanAbsensi] . ' ' . ($selectedTahunAbsensi !== 'semua' ? $selectedTahunAbsensi : date('Y'))
                : ($selectedTahunAbsensi !== 'semua' ? 'Tahun ' . $selectedTahunAbsensi : 'Semua Periode');
        @endphp
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Absensi Pelatih - {{ $labelPeriodeAbsensi }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Catatan kehadiran seluruh pelatih (klik baris untuk mengedit data absensi)</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="openModalExportAbsensiPelatih('rekap')" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 group">
                        <i class="fa-solid fa-download text-xs text-[#00a5ec] group-hover:scale-110 transition-transform"></i>
                        <span>Export Absensi</span>
                    </button>
                    <button type="button" onclick="openModal('modalInputAbsensi')" class="bg-[#00a5ec] hover:bg-[#0092d1] active:scale-[0.98] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Input Absensi</span>
                    </button>
                </div>
            </div>

            <!-- Filter Controls Form -->
            <form action="{{ route('admin.pelatih.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 text-xs">
                <!-- 1. Cari Nama Pelatih -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nama Pelatih</label>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" id="searchAbsensiPelatihInput" name="search_nama" value="{{ request('search_nama') }}" placeholder="Cari nama..."
                            oninput="filterAbsensiPelatihRows()"
                            onkeydown="if(event.key==='Enter'){ this.form.submit(); }"
                            class="w-full pl-9 pr-3.5 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>
                </div>

                <!-- 2. Pilih Bulan -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Pilih Bulan</label>
                    <div class="relative">
                        <select name="bulan" onchange="this.form.submit()" class="w-full appearance-none px-3.5 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] pr-8 cursor-pointer">
                            <option value="semua" {{ $selectedBulanAbsensi === 'semua' || $selectedBulanAbsensi === '' ? 'selected' : '' }}>Semua Bulan</option>
                            @foreach($daftarBulanPelatih as $num => $namaBln)
                                <option value="{{ $num }}" {{ (string)$selectedBulanAbsensi === (string)$num ? 'selected' : '' }}>{{ $namaBln }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- 3. Pilih Tahun -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Pilih Tahun</label>
                    <div class="relative">
                        <select name="tahun" onchange="this.form.submit()" class="w-full appearance-none px-3.5 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] pr-8 cursor-pointer">
                            <option value="semua" {{ $selectedTahunAbsensi === 'semua' || $selectedTahunAbsensi === '' ? 'selected' : '' }}>Semua Tahun</option>
                            @foreach($listTahun ?? [date('Y')] as $y)
                                <option value="{{ $y }}" {{ (string)$selectedTahunAbsensi === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
            </form>

            @if(request()->filled('search_nama') || ($selectedBulanAbsensi !== (string)date('n')) || ($selectedTahunAbsensi !== (string)date('Y')))
                <div class="flex items-center justify-end mb-4 text-xs">
                    <a href="{{ route('admin.pelatih.index') }}" class="text-xs text-rose-500 hover:text-rose-600 flex items-center gap-1 font-semibold transition hover:underline">
                        <i class="fa-solid fa-rotate-left text-[10px]"></i>
                        <span>Reset Filter (Kembali ke Bulan Ini)</span>
                    </a>
                </div>
            @endif

            <!-- Bulk Action Bar (Muncul ketika data absensi dipilih) -->
            <div id="bulkActionBar" class="hidden items-center justify-between bg-sky-50 border border-sky-200 px-4 py-2.5 rounded-xl mb-4 transition-all">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-700">
                    <i class="fa-solid fa-circle-check text-[#00a5ec]"></i>
                    <span><span id="selectedCount" class="font-bold text-[#00a5ec]">0</span> data absensi dipilih</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="cancelBulkSelection()" class="px-3 py-1.5 text-xs text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 font-medium transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" onclick="openModalBulkDeleteAbsensi()" class="px-3.5 py-1.5 text-xs text-white bg-rose-500 hover:bg-rose-600 rounded-lg font-semibold shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </div>
            </div>

            <!-- Table Data Absensi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-4 w-10 text-center">
                                <input type="checkbox" id="selectAllAbsensi" onchange="toggleSelectAllAbsensi(this)" class="w-4 h-4 text-[#00a5ec] rounded border-slate-300 focus:ring-[#00a5ec] cursor-pointer">
                            </th>
                            <th class="py-3.5 px-4">Tanggal</th>
                            <th class="py-3.5 px-4">Nama Pelatih</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data_absensi as $absensi)
                            <tr class="absensi-pelatih-row hover:bg-sky-50/60 cursor-pointer transition group"
                                onclick="handleRowClick(event, {{ $absensi->id }}, '{{ addslashes($absensi->nama_pelatih) }}', '{{ $absensi->tanggal_kehadiran }}', '{{ $absensi->status_kehadiran }}', '{{ addslashes($absensi->keterangan ?? '') }}')">
                                <td class="py-3.5 px-4 text-center" onclick="event.stopPropagation()">
                                    <input type="checkbox" value="{{ $absensi->id }}" onchange="updateBulkActionUI()" class="checkbox-absensi w-4 h-4 text-[#00a5ec] rounded border-slate-300 focus:ring-[#00a5ec] cursor-pointer">
                                </td>
                                <td class="py-3.5 px-4 font-medium">{{ date('d M Y', strtotime($absensi->tanggal_kehadiran)) }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $absensi->nama_pelatih }}</td>
                                <td class="py-3.5 px-4">
                                    @if($absensi->status_kehadiran === 'hadir')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-300">
                                            Hadir
                                        </span>
                                    @elseif($absensi->status_kehadiran === 'izin')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-300">
                                            Izin
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-600 border border-rose-300">
                                            {{ ucfirst($absensi->status_kehadiran) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $absensi->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Tidak ada data absensi pelatih ditemukan.
                                </td>
                            </tr>
                        @endforelse
                        <tr id="absensiPelatihSearchNotFound" class="hidden">
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Tidak ada data absensi pelatih yang cocok dengan pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal 1: Tambah Pelatih Baru -->
    <div id="modalTambahPelatih" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-[#00a5ec]">Tambah Pelatih Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Masukkan informasi lengkap pelatih baru</p>
                </div>
                <button type="button" onclick="closeModal('modalTambahPelatih')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.pelatih.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf

                <!-- Foto Profil Pelatih -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Foto Profil</label>
                    <div class="flex items-center gap-4 p-3 bg-[#f8fafc] border border-dashed border-slate-300 rounded-xl">
                        <div class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                            <img id="tambahFotoPreview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <i id="tambahFotoPlaceholder" class="fa-solid fa-camera text-xl text-slate-400"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <label for="foto" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-lg font-semibold text-xs cursor-pointer shadow-sm transition">
                                    <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                    <span>Pilih Foto</span>
                                </label>
                                <button type="button" id="btnHapusTambahFoto" onclick="hapusTambahFoto()" class="hidden text-rose-500 hover:text-rose-600 font-semibold text-xs transition">
                                    Hapus
                                </button>
                            </div>
                            <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewTambahFoto(event)">
                            <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB, opsional)</p>
                        </div>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block font-semibold text-slate-700 mb-1.5">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" required placeholder="Contoh: Jakarta / Sumedang"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block font-semibold text-slate-700 mb-1.5">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" required placeholder="email@example.com"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- No WhatsApp -->
                <div>
                    <label for="tambah_no_hp" class="block font-semibold text-slate-700 mb-1.5">No. WhatsApp / HP</label>
                    <input type="text" id="tambah_no_hp" name="no_hp" placeholder="Contoh: 081234567890 (opsional)"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- No Rekening -->
                <div>
                    <label for="no_rek" class="block font-semibold text-slate-700 mb-1.5">No. Rekening</label>
                    <input type="text" id="no_rek" name="no_rek" required placeholder="Masukkan nomor rekening"
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Modal Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modalTambahPelatih')" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-xl font-semibold shadow-sm transition">
                        Simpan Pelatih
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal 2: Input Absensi Pelatih -->
    <div id="modalInputAbsensi" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-xl p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-[#00a5ec]">Input Absensi Pelatih</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih tanggal dan update status kehadiran pelatih</p>
                </div>
                <button type="button" onclick="closeModal('modalInputAbsensi')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.pelatih.absensi.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <!-- Tanggal Absensi -->
                <div>
                    <label for="tanggal_kehadiran" class="block font-semibold text-slate-700 mb-1.5">Tanggal Absensi</label>
                    <input type="date" id="tanggal_kehadiran" name="tanggal_kehadiran" value="{{ date('Y-m-d') }}" required
                        class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Status Kehadiran Pelatih List -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block font-semibold text-slate-700">Status Kehadiran Pelatih</label>
                        <span class="text-[10px] text-slate-400 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-circle-info text-[#00a5ec]"></i> Pelatih non-aktif tidak ditampilkan
                        </span>
                    </div>

                    <!-- Search Bar Nama Pelatih -->
                    <div class="relative mb-2.5">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" id="searchAbsensiPelatihInput" oninput="filterAbsensiPelatihModal()" placeholder="Cari nama pelatih..."
                            autocomplete="off"
                            class="w-full pl-9 pr-8 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                        <button type="button" id="clearSearchAbsensiPelatih" onclick="clearSearchAbsensiPelatihModal()" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 text-xs transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div id="containerListAbsensiPelatih" class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        @php
                            $pelatih_bisa_absen = $data_pelatih->filter(fn($p) => strtolower($p->status ?? '') === 'aktif');
                        @endphp
                        @forelse($pelatih_bisa_absen as $pelatih)
                            @php
                                $words = explode(' ', $pelatih->nama);
                                $initials = '';
                                foreach($words as $w) { $initials .= strtoupper(substr($w, 0, 1)); }
                                $initials = substr($initials, 0, 2);
                            @endphp
                            <div class="item-absensi-pelatih p-3.5 bg-white border border-sky-300/80 rounded-2xl flex flex-col gap-2 transition" data-nama="{{ strtolower($pelatih->nama) }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        @if($pelatih->foto && file_exists(public_path($pelatih->foto)))
                                            <img src="{{ asset($pelatih->foto) }}" alt="{{ $pelatih->nama }}" class="w-8 h-8 rounded-full object-cover shrink-0 border border-slate-200">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-[#00a5ec] text-white font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                        <span class="font-bold text-slate-800 text-sm">{{ $pelatih->nama }}</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border border-emerald-400 text-emerald-600 bg-emerald-50 shrink-0">Aktif</span>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mt-1">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Status Kehadiran</label>
                                        <select name="absensi[{{ $pelatih->id_pelatih }}][status]" class="w-full px-3 py-1.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                                            <option value="hadir" selected>Hadir</option>
                                            <option value="izin">Izin</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="tidak_hadir">Tidak Hadir</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Keterangan</label>
                                        <input type="text" name="absensi[{{ $pelatih->id_pelatih }}][keterangan]" placeholder="Opsional"
                                            class="w-full px-3 py-1.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-slate-50 border border-dashed border-slate-200 rounded-2xl">
                                <i class="fa-solid fa-user-slash text-slate-300 text-2xl mb-2 block"></i>
                                <p class="text-xs font-bold text-slate-700">Tidak ada pelatih yang dapat diabsen</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Semua pelatih saat ini berstatus Non-Aktif (Off).</p>
                            </div>
                        @endforelse

                        <!-- Empty state saat pencarian tidak ditemukan -->
                        <div id="absensiPelatihSearchEmpty" class="hidden p-6 text-center bg-slate-50 border border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-solid fa-magnifying-glass text-slate-300 text-xl mb-1.5 block"></i>
                            <p class="text-xs font-bold text-slate-700">Pelatih tidak ditemukan</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada pelatih aktif dengan nama yang dicari.</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modalInputAbsensi')" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition">
                        Batal
                    </button>
                    @if($pelatih_bisa_absen->isNotEmpty())
                        <button type="submit" class="px-5 py-2.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-xl font-semibold shadow-sm transition">
                            Simpan Absensi
                        </button>
                    @else
                        <button type="button" disabled class="px-5 py-2.5 bg-slate-100 text-slate-400 rounded-xl font-semibold cursor-not-allowed border border-slate-200">
                            Simpan Absensi
                        </button>
                    @endif
                </div>
            </form>

        </div>
    </div>

    <!-- Modal 3: Detail + Edit Pelatih -->
    <div id="modalDetailPelatih" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-100 relative max-h-[92vh] flex flex-col">

            <!-- Header Modal -->
            <div class="flex items-start justify-between p-5 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-4">
                    <div id="dpAvatar" class="w-14 h-14 rounded-full bg-[#00a5ec] text-white font-bold text-xl flex items-center justify-center shadow-sm shrink-0 overflow-hidden"></div>
                    <div>
                        <h3 id="dpNama" class="text-lg font-bold text-[#00a5ec]"></h3>
                        <p id="dpEmail" class="text-xs text-slate-500"></p>
                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            <span id="dpStatusBadge" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold border"></span>
                            <a id="dpWaHeader" href="#" target="_blank" class="hidden inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-300 hover:bg-emerald-100 transition shadow-2xs">
                                <i class="fa-brands fa-whatsapp text-xs text-emerald-500"></i>
                                <span id="dpNoHp"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" id="btnHapusPelatih" onclick="konfirmasiHapus()"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-semibold text-rose-500 border border-rose-200 hover:bg-rose-50 rounded-xl transition">
                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                        Hapus
                    </button>
                    <button type="button" onclick="closeModal('modalDetailPelatih')" class="text-slate-400 hover:text-slate-600 text-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Tab Switcher -->
            <div class="flex border-b border-slate-100 shrink-0 px-5">
                <button id="tabInfoBtn" onclick="switchTab('info')" class="py-3 px-4 text-xs font-semibold text-[#008cc9] border-b-2 border-[#008cc9] -mb-px transition">
                    <i class="fa-solid fa-circle-info mr-1.5"></i>Info & Kehadiran
                </button>
                <button id="tabEditBtn" onclick="switchTab('edit')" class="py-3 px-4 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition">
                    <i class="fa-solid fa-pen-to-square mr-1.5"></i>Edit Data
                </button>
            </div>

            <div class="overflow-y-auto flex-1">

                <!-- ===== TAB: INFO ===== -->
                <div id="tabInfo" class="p-5 space-y-5">

                    <!-- Info Biodata -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-0.5">Tempat, Tgl Lahir</p>
                            <p id="dpTTL" class="font-semibold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 flex flex-col justify-between">
                            <div>
                                <p class="text-slate-400 mb-0.5">No. WhatsApp</p>
                                <p id="dpNoHpCard" class="font-semibold text-slate-700">-</p>
                            </div>
                            <a id="dpWaBtn" href="#" target="_blank" class="hidden inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 hover:text-emerald-700 mt-1 transition">
                                <i class="fa-brands fa-whatsapp text-xs text-emerald-500"></i>
                                <span>Hubungi WA</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                            </a>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-0.5">No. Rekening</p>
                            <p id="dpRek" class="font-semibold text-slate-700"></p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-0.5">Total Sesi</p>
                            <p id="dpTotal" class="font-semibold text-slate-700"></p>
                        </div>
                    </div>

                    <!-- Statistik Kehadiran -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold text-slate-700">Rekap Kehadiran</h4>
                            <span class="text-[11px] text-slate-400 font-medium">Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</span>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-center">
                                <p id="dpJmlHadir" class="text-3xl font-black text-emerald-600"></p>
                                <p class="text-[11px] text-emerald-500 font-semibold mt-0.5">Hadir</p>
                            </div>
                            <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4 text-center">
                                <p id="dpJmlIzin" class="text-3xl font-black text-amber-500"></p>
                                <p class="text-[11px] text-amber-500 font-semibold mt-0.5">Izin</p>
                            </div>
                            <div class="rounded-2xl bg-rose-50 border border-rose-100 p-4 text-center">
                                <p id="dpJmlSakit" class="text-3xl font-black text-rose-500"></p>
                                <p class="text-[11px] text-rose-400 font-semibold mt-0.5">Sakit / Alpha</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Riwayat Kehadiran -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-700 mb-3">Riwayat Kehadiran</h4>
                        <div class="overflow-x-auto rounded-xl border border-slate-100">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                    <tr>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="dpRiwayatBody" class="divide-y divide-slate-100 text-slate-700">
                                    <!-- diisi via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ===== TAB: EDIT ===== -->
                <div id="tabEdit" class="p-5 hidden">
                    <form id="formEditPelatih" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data profil pelatih ini?')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <!-- Foto Profil Pelatih -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Foto Profil</label>
                            <div class="flex items-center gap-4 p-3 bg-[#f8fafc] border border-dashed border-slate-300 rounded-xl">
                                <div class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    <img id="editFotoPreview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                                    <div id="editFotoPlaceholder" class="w-full h-full bg-[#00a5ec] text-white font-bold text-lg flex items-center justify-center"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <label for="editFotoInput" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-lg font-semibold text-xs cursor-pointer shadow-sm transition">
                                            <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                            <span>Ganti Foto</span>
                                        </label>
                                        <button type="button" id="btnHapusEditFoto" onclick="hapusEditFoto()" class="hidden text-rose-500 hover:text-rose-600 font-semibold text-xs transition">
                                            Hapus Foto
                                        </button>
                                    </div>
                                    <input type="file" id="editFotoInput" name="foto" accept="image/*" class="hidden" onchange="previewEditFoto(event)">
                                    <input type="hidden" id="editHapusFotoInput" name="hapus_foto" value="0">
                                    <p id="editFotoInfo" class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB, opsional)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nama -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" id="editNama" name="nama" required
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="editEmail" name="email" required
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>

                        <!-- No WhatsApp -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">No. WhatsApp / HP</label>
                            <input type="text" id="editNoHp" name="no_hp" placeholder="Contoh: 081234567890"
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>

                        <!-- Tempat & Tgl Lahir -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">Tempat Lahir <span class="text-rose-500">*</span></label>
                                <input type="text" id="editTempatLahir" name="tempat_lahir" required
                                    class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                <input type="date" id="editTglLahir" name="tanggal_lahir" required
                                    class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            </div>
                        </div>

                        <!-- No Rekening -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">No. Rekening <span class="text-rose-500">*</span></label>
                            <input type="text" id="editNoRek" name="no_rek" required
                                class="w-full px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select id="editStatus" name="status" required
                                    class="w-full appearance-none px-3.5 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] pr-8">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non-Aktif</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                            <button type="button" onclick="switchTab('info')" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition text-xs">
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

    <!-- Hidden Form Delete Pelatih -->
    <form id="formDeletePelatih" method="POST" action="">
        @csrf
    </form>

    <!-- Modal Konfirmasi Hapus Pelatih -->
    <div id="modalKonfirmasiHapus" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-rose-500 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Hapus Pelatih?</h3>
                <p class="text-xs text-slate-500 mb-1">Anda akan menghapus data pelatih:</p>
                <p id="konfirmNama" class="text-sm font-bold text-rose-600 mb-3"></p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Tindakan ini akan menghapus semua riwayat absensi, akun login, dan profil pelatih secara permanen dari sistem.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalKonfirmasiHapus')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition">
                        Batal
                    </button>
                    <button type="button" onclick="deletePelatih()"
                        class="flex-1 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold text-xs shadow-sm transition">
                        <i class="fa-solid fa-trash-can mr-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Export Pelatih & Absensi (Rentang & Kustom) -->
    <div id="modalExportPelatih" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg mx-4 shadow-2xl border border-slate-100 flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="flex items-start justify-between p-6 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-[#00a5ec]/10 text-[#00a5ec] rounded-xl flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-file-excel"></i>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Export Absensi Pelatih</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Atur rentang waktu data sebelum diexport</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalExportPelatih')" class="text-slate-400 hover:text-slate-600 text-lg p-1 rounded-lg hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form Export Absensi Pelatih -->
            <form id="formExportPelatih" method="GET" action="{{ route('admin.pelatih.absensi.export') }}" target="_blank" class="p-6 space-y-4">
                <!-- Pilihan Format Export: Rekap per Pelatih vs Log per Sesi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilihan Format Export</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="relative flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                            <input type="radio" name="format" id="radioPelatihRekap" value="rekap" onchange="switchExportPelatihFormat('rekap')" checked class="text-[#00a5ec] focus:ring-[#00a5ec] mr-2.5">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Rekap Per Pelatih</span>
                                <span class="block text-[10px] text-slate-400">Total hadir, izin, dan sakit</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                            <input type="radio" name="format" id="radioPelatihSesi" value="sesi" onchange="switchExportPelatihFormat('sesi')" class="text-[#00a5ec] focus:ring-[#00a5ec] mr-2.5">
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
                            <input type="date" name="start_date" id="exportPelatihStartDate"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Sampai Tanggal (Selesai)</label>
                            <input type="date" name="end_date" id="exportPelatihEndDate"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                        </div>
                    </div>

                    <!-- Tombol Shortcut Rentang Cepat -->
                    <div class="flex items-center gap-1.5 flex-wrap pt-1">
                        <span class="text-[10px] text-slate-400 font-semibold mr-1">Preset:</span>
                        <button type="button" onclick="setQuickRangePelatih('7d')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">7 Hari Terakhir</button>
                        <button type="button" onclick="setQuickRangePelatih('30d')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">30 Hari Terakhir</button>
                        <button type="button" onclick="setQuickRangePelatih('this_month')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">Bulan Ini</button>
                        <button type="button" onclick="setQuickRangePelatih('last_month')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">Bulan Lalu</button>
                        <button type="button" onclick="setQuickRangePelatih('all')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition">Semua Tanggal</button>
                    </div>
                </div>

                <!-- Info box -->
                <div class="p-3 bg-sky-50/60 border border-sky-100 rounded-xl flex items-start gap-2.5 text-xs text-slate-600">
                    <i class="fa-solid fa-circle-info text-[#00a5ec] mt-0.5 text-sm shrink-0"></i>
                    <p id="exportPelatihInfoText" class="text-[11px] leading-relaxed">
                        Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat rangkuman per pelatih: Nama Pelatih, Total Hadir, Total Izin, dan Total Sakit.
                    </p>
                </div>

                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalExportPelatih')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
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

    <!-- Modal 4: Edit Absensi Pelatih -->
    <div id="modalEditAbsensiPelatih" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-start justify-between mb-5 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-sky-50 text-[#00a5ec] flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Edit Absensi Pelatih</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Perbarui tanggal, status, atau catatan kehadiran</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalEditAbsensiPelatih')" class="text-slate-400 hover:text-slate-600 text-lg p-1 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="formEditAbsensiPelatih" method="POST" action="" class="space-y-4 text-xs" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data absensi pelatih ini?')">
                @csrf
                <input type="hidden" name="id" id="editAbsensiId">

                <!-- Info Pelatih (Read-only) -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nama Pelatih</label>
                    <div class="flex items-center gap-2.5 p-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        <i class="fa-solid fa-user text-[#00a5ec] text-xs"></i>
                        <span id="editAbsensiNamaPelatih" class="font-bold text-slate-800 text-xs"></span>
                    </div>
                </div>

                <!-- Tanggal Kehadiran -->
                <div>
                    <label for="editAbsensiTanggal" class="block font-semibold text-slate-700 mb-1">Tanggal Kehadiran</label>
                    <input type="date" id="editAbsensiTanggal" name="tanggal_kehadiran" required
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Status Kehadiran (Pilihan Radio) -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Status Kehadiran</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="flex items-center justify-center p-2 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/60">
                            <input type="radio" name="status_kehadiran" id="editStatusHadir" value="hadir" class="text-emerald-600 focus:ring-emerald-500 mr-1.5">
                            <span class="font-semibold text-emerald-700">Hadir</span>
                        </label>
                        <label class="flex items-center justify-center p-2 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/60">
                            <input type="radio" name="status_kehadiran" id="editStatusIzin" value="izin" class="text-amber-600 focus:ring-amber-500 mr-1.5">
                            <span class="font-semibold text-amber-700">Izin</span>
                        </label>
                        <label class="flex items-center justify-center p-2 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/60">
                            <input type="radio" name="status_kehadiran" id="editStatusSakit" value="sakit" class="text-rose-600 focus:ring-rose-500 mr-1.5">
                            <span class="font-semibold text-rose-700">Sakit</span>
                        </label>
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="editAbsensiKeterangan" class="block font-semibold text-slate-700 mb-1">Keterangan / Catatan</label>
                    <textarea id="editAbsensiKeterangan" name="keterangan" rows="2" placeholder="Catatan opsional (misal: izin sakit flu)..."
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button type="button" onclick="konfirmasiHapusAbsensiPelatih()" class="px-3.5 py-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl font-semibold transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalEditAbsensiPelatih')" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-xl font-semibold shadow-sm transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <!-- Hidden Form Hapus Absensi Pelatih -->
            <form id="formHapusAbsensiPelatih" method="POST" action="" class="hidden">
                @csrf
            </form>

        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Absensi Pelatih -->
    <div id="modalKonfirmasiHapusAbsensiPelatih" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-rose-500 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Hapus Absensi Pelatih?</h3>
                <p class="text-xs text-slate-500 mb-1">Apakah Anda yakin ingin menghapus catatan absensi:</p>
                <p id="konfirmNamaPelatihAbsensi" class="text-sm font-bold text-rose-600 mb-2 truncate px-2"></p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Catatan kehadiran pelatih ini akan dihapus permanen dari riwayat absensi.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalKonfirmasiHapusAbsensiPelatih')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" onclick="eksekusiHapusAbsensiPelatih()"
                        class="flex-1 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold text-xs shadow-sm transition cursor-pointer">
                        <i class="fa-solid fa-trash-can mr-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Massal (Bulk Delete) Absensi Pelatih -->
    <div id="modalBulkDeleteAbsensi" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-rose-500 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Hapus Absensi Terpilih?</h3>
                <p class="text-xs text-slate-500 mb-1">Anda akan menghapus sekaligus:</p>
                <p class="text-sm font-bold text-rose-600 mb-2 px-2"><span id="bulkDeleteCountText">0</span> Data Absensi</p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Catatan kehadiran pelatih yang dipilih akan dihapus permanen dari riwayat absensi.</p>
                <form id="formBulkDeleteAbsensi" method="POST" action="{{ route('admin.pelatih.absensi.bulk_delete') }}">
                    @csrf
                    <div id="bulkDeleteInputsContainer"></div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('modalBulkDeleteAbsensi')"
                            class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold text-xs shadow-sm transition cursor-pointer">
                            <i class="fa-solid fa-trash-can mr-1"></i>Ya, Hapus Semua
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan" class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Modal & Drawer Script -->
    <script>
        function openModal(modalId) {
            const el = document.getElementById(modalId);
            if (el) el.classList.remove('hidden');
            if (modalId === 'modalInputAbsensi') {
                clearSearchAbsensiPelatihModal();
            }
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            if (sidebar && backdrop) {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }
        }

        function switchTab(tab) {
            const infoTab   = document.getElementById('tabInfo');
            const editTab   = document.getElementById('tabEdit');
            const infoBtn   = document.getElementById('tabInfoBtn');
            const editBtn   = document.getElementById('tabEditBtn');

            if (tab === 'info') {
                infoTab.classList.remove('hidden');
                editTab.classList.add('hidden');
                infoBtn.className = 'py-3 px-4 text-xs font-semibold text-[#008cc9] border-b-2 border-[#008cc9] -mb-px transition';
                editBtn.className = 'py-3 px-4 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition';
            } else {
                infoTab.classList.add('hidden');
                editTab.classList.remove('hidden');
                infoBtn.className = 'py-3 px-4 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent -mb-px transition';
                editBtn.className = 'py-3 px-4 text-xs font-semibold text-[#008cc9] border-b-2 border-[#008cc9] -mb-px transition';
            }
        }

        let _currentFotoUrl = '';
        let _currentInitials = '';

        function formatWaUrl(phone) {
            if (!phone) return '#';
            let clean = phone.replace(/[^0-9]/g, '');
            if (clean.startsWith('0')) {
                clean = '62' + clean.slice(1);
            } else if (!clean.startsWith('62')) {
                clean = '62' + clean;
            }
            return 'https://wa.me/' + clean;
        }

        function openDetailPelatih(id, nama, initials, email, tempatLahir, tglLahirRaw, tglLahirFormatted, noRek, status, fotoUrl, jmlHadir, jmlIzin, jmlSakit, jmlTotal, riwayat, noHp) {
            _hapusId   = id;
            _hapusNama = nama;
            _currentFotoUrl = fotoUrl || '';
            _currentInitials = initials || '';

            // Populate header avatar
            const dpAvatar = document.getElementById('dpAvatar');
            if (fotoUrl) {
                dpAvatar.innerHTML = `<img src="${fotoUrl}" alt="${nama}" class="w-full h-full object-cover">`;
            } else {
                dpAvatar.innerHTML = initials;
            }

            document.getElementById('dpNama').textContent     = nama;
            document.getElementById('dpEmail').textContent    = email;
            document.getElementById('dpTTL').textContent      = tempatLahir + ', ' + tglLahirFormatted;
            document.getElementById('dpRek').textContent      = noRek;
            document.getElementById('dpTotal').textContent    = jmlTotal + ' sesi bulan ini';
            document.getElementById('dpJmlHadir').textContent = jmlHadir;
            document.getElementById('dpJmlIzin').textContent  = jmlIzin;
            document.getElementById('dpJmlSakit').textContent = jmlSakit;

            // WhatsApp Handling
            const waHeader = document.getElementById('dpWaHeader');
            const noHpSpan = document.getElementById('dpNoHp');
            const waCard = document.getElementById('dpNoHpCard');
            const waBtn = document.getElementById('dpWaBtn');
            const editNoHp = document.getElementById('editNoHp');

            if (editNoHp) editNoHp.value = (noHp && noHp !== '-') ? noHp : '';

            if (noHp && noHp.trim() !== '' && noHp.trim() !== '-') {
                const waUrl = formatWaUrl(noHp);
                if (noHpSpan) noHpSpan.textContent = noHp;
                if (waHeader) {
                    waHeader.href = waUrl;
                    waHeader.classList.remove('hidden');
                }
                if (waCard) waCard.textContent = noHp;
                if (waBtn) {
                    waBtn.href = waUrl;
                    waBtn.classList.remove('hidden');
                }
            } else {
                if (waHeader) waHeader.classList.add('hidden');
                if (waCard) waCard.textContent = 'Belum diisi';
                if (waBtn) waBtn.classList.add('hidden');
            }

            // Status badge
            const badge = document.getElementById('dpStatusBadge');
            if (status === 'aktif') {
                badge.textContent = 'Aktif';
                badge.className   = 'inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold border border-emerald-400 text-emerald-600 bg-emerald-50';
            } else {
                badge.textContent = 'Non-Aktif';
                badge.className   = 'inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold border border-slate-300 text-slate-500 bg-slate-50';
            }

            // Populate edit form
            const form = document.getElementById('formEditPelatih');
            form.action = '{{ url('/admin/pelatih') }}/' + id + '/update';
            document.getElementById('editNama').value        = nama;
            document.getElementById('editEmail').value       = email;
            document.getElementById('editTempatLahir').value = tempatLahir !== '-' ? tempatLahir : '';
            document.getElementById('editTglLahir').value    = tglLahirRaw;
            document.getElementById('editNoRek').value       = noRek !== '-' ? noRek : '';
            document.getElementById('editStatus').value      = status;

            // Populate edit photo preview
            const editImg = document.getElementById('editFotoPreview');
            const editHolder = document.getElementById('editFotoPlaceholder');
            const editInput = document.getElementById('editFotoInput');
            const hapusFotoInput = document.getElementById('editHapusFotoInput');
            const btnHapusFoto = document.getElementById('btnHapusEditFoto');
            const fotoInfo = document.getElementById('editFotoInfo');

            if (editInput) editInput.value = '';
            if (hapusFotoInput) hapusFotoInput.value = '0';
            if (fotoInfo) fotoInfo.textContent = 'Format: JPG, PNG, WEBP (Maks. 2MB, opsional)';

            if (fotoUrl) {
                editImg.src = fotoUrl;
                editImg.classList.remove('hidden');
                editHolder.classList.add('hidden');
                if (btnHapusFoto) btnHapusFoto.classList.remove('hidden');
            } else {
                editImg.src = '';
                editImg.classList.add('hidden');
                editHolder.textContent = initials;
                editHolder.classList.remove('hidden');
                if (btnHapusFoto) btnHapusFoto.classList.add('hidden');
            }

            // Riwayat kehadiran rows
            const tbody = document.getElementById('dpRiwayatBody');
            tbody.innerHTML = '';
            if (!riwayat || riwayat.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="py-6 text-center text-slate-400">Belum ada riwayat kehadiran.</td></tr>';
            } else {
                riwayat.forEach(function(item) {
                    const d   = new Date(item.tanggal);
                    const tgl = d.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'});
                    let badgeHtml = '';
                    if (item.status === 'hadir') {
                        badgeHtml = '<span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">Hadir</span>';
                    } else if (item.status === 'izin') {
                        badgeHtml = '<span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">Izin</span>';
                    } else if (item.status === 'sakit') {
                        badgeHtml = '<span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-500 border border-rose-200">Sakit</span>';
                    } else {
                        badgeHtml = '<span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">' + item.status + '</span>';
                    }
                    tbody.innerHTML += `<tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-medium">${tgl}</td>
                        <td class="py-3 px-4">${badgeHtml}</td>
                        <td class="py-3 px-4 text-slate-500">${item.ket}</td>
                    </tr>`;
                });
            }

            // Always open on Info tab
            switchTab('info');
            openModal('modalDetailPelatih');
        }

        // ---- Hapus Pelatih ----
        let _hapusId   = null;
        let _hapusNama = null;

        function konfirmasiHapus() {
            if (!_hapusId) return;
            document.getElementById('konfirmNama').textContent = _hapusNama;
            openModal('modalKonfirmasiHapus');
        }

        function deletePelatih() {
            if (!_hapusId) return;
            const form = document.getElementById('formDeletePelatih');
            form.action = '{{ url('/admin/pelatih') }}/' + _hapusId + '/delete';
            form.submit();
        }

        // ---- Photo Preview Functions ----
        function previewTambahFoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('tambahFotoPreview');
            const placeholder = document.getElementById('tambahFotoPlaceholder');
            const btnHapus = document.getElementById('btnHapusTambahFoto');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    if (btnHapus) btnHapus.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function hapusTambahFoto() {
            const input = document.getElementById('foto');
            const preview = document.getElementById('tambahFotoPreview');
            const placeholder = document.getElementById('tambahFotoPlaceholder');
            const btnHapus = document.getElementById('btnHapusTambahFoto');
            if (input) input.value = '';
            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
            if (placeholder) placeholder.classList.remove('hidden');
            if (btnHapus) btnHapus.classList.add('hidden');
        }

        function previewEditFoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('editFotoPreview');
            const placeholder = document.getElementById('editFotoPlaceholder');
            const btnHapus = document.getElementById('btnHapusEditFoto');
            const hapusFotoInput = document.getElementById('editHapusFotoInput');
            const fotoInfo = document.getElementById('editFotoInfo');

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

        function hapusEditFoto() {
            const input = document.getElementById('editFotoInput');
            const preview = document.getElementById('editFotoPreview');
            const placeholder = document.getElementById('editFotoPlaceholder');
            const btnHapus = document.getElementById('btnHapusEditFoto');
            const hapusFotoInput = document.getElementById('editHapusFotoInput');
            const fotoInfo = document.getElementById('editFotoInfo');

            // Jika user baru saja memilih file baru yang belum disimpan, batalkan pilihan tersebut
            if (input && input.files && input.files.length > 0) {
                input.value = '';
                if (_currentFotoUrl) {
                    preview.src = _currentFotoUrl;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    if (btnHapus) btnHapus.classList.remove('hidden');
                    if (fotoInfo) fotoInfo.textContent = 'Foto saat ini tersimpan';
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.textContent = _currentInitials;
                    placeholder.classList.remove('hidden');
                    if (btnHapus) btnHapus.classList.add('hidden');
                    if (fotoInfo) fotoInfo.textContent = 'Format: JPG, PNG, WEBP (Maks. 2MB, opsional)';
                }
                if (hapusFotoInput) hapusFotoInput.value = '0';
                return;
            }

            if (btnHapus) btnHapus.classList.add('hidden');
            if (fotoInfo) fotoInfo.textContent = 'Foto akan dihapus saat disimpan';
        }

        // Slider Navigasi Pelatih
        function slidePelatih(direction) {
            const slider = document.getElementById('gridDaftarPelatih');
            if (!slider) return;
            // Ambil lebar satu card (dengan gap)
            const card = slider.querySelector('.card-pelatih-item:not([style*="none"])');
            const slideAmount = card ? (card.offsetWidth + 20) * 4 : slider.clientWidth;
            if (direction === 'left') {
                slider.scrollBy({ left: -slideAmount, behavior: 'smooth' });
            } else {
                slider.scrollBy({ left: slideAmount, behavior: 'smooth' });
            }
        }

        // Live Search Filter Pelatih
        function filterPelatihCards() {
            const input = document.getElementById('searchPelatihInput');
            if (!input) return;
            const query = input.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.card-pelatih-item');
            let found = 0;

            cards.forEach(card => {
                const nama = card.getAttribute('data-nama') || '';
                const email = card.getAttribute('data-email') || '';
                const rek = card.getAttribute('data-rek') || '';
                if (nama.includes(query) || email.includes(query) || rek.includes(query)) {
                    card.style.display = '';
                    found++;
                } else {
                    card.style.display = 'none';
                }
            });

            const emptyState = document.getElementById('pelatihNotFound');
            if (emptyState) {
                if (found === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        // Live Search Filter Pelatih di Modal Input Absensi
        function filterAbsensiPelatihModal() {
            const input = document.getElementById('searchAbsensiPelatihInput');
            const clearBtn = document.getElementById('clearSearchAbsensiPelatih');
            const query = input ? input.value.toLowerCase().trim() : '';
            const items = document.querySelectorAll('.item-absensi-pelatih');
            const emptyState = document.getElementById('absensiPelatihSearchEmpty');

            if (clearBtn) {
                if (query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            let found = 0;
            items.forEach(item => {
                const nama = item.getAttribute('data-nama') || '';
                if (nama.includes(query)) {
                    item.style.display = '';
                    found++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (emptyState) {
                if (found === 0 && items.length > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        function clearSearchAbsensiPelatihModal() {
            const input = document.getElementById('searchAbsensiPelatihInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            filterAbsensiPelatihModal();
        }

        // ---- Export Data Pelatih & Export Absensi Pelatih ----
        function exportDataPelatih() {
            const searchInput = document.getElementById('searchPelatihInput');
            const searchVal   = searchInput ? searchInput.value.trim() : '';
            let url = '{{ route('admin.pelatih.export') }}';
            if (searchVal) {
                url += '?search_pelatih=' + encodeURIComponent(searchVal);
            }
            window.location.href = url;
        }

        let _currentExportPelatihFormat = 'rekap';

        function switchExportPelatihFormat(format) {
            _currentExportPelatihFormat = format;
            const radioRekap = document.getElementById('radioPelatihRekap');
            const radioSesi  = document.getElementById('radioPelatihSesi');
            const titleEl    = document.querySelector('#modalExportPelatih h3');
            const infoEl     = document.getElementById('exportPelatihInfoText');

            if (format === 'sesi') {
                if (radioSesi) radioSesi.checked = true;
                if (titleEl) titleEl.textContent = 'Export Log Kehadiran Per Sesi Pelatih';
                if (infoEl) infoEl.innerHTML = 'Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat rincian absensi harian per sesi: Tanggal Kehadiran, Nama Pelatih, Status Kehadiran, dan Keterangan.';
            } else {
                if (radioRekap) radioRekap.checked = true;
                if (titleEl) titleEl.textContent = 'Export Rekap Absensi Per Pelatih';
                if (infoEl) infoEl.innerHTML = 'Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat rangkuman per pelatih: Nama Pelatih, Total Hadir, Total Izin, dan Total Sakit.';
            }
        }

        function openModalExportAbsensiPelatih(initialFormat = 'rekap') {
            switchExportPelatihFormat(initialFormat);

            const startInput = document.getElementById('exportPelatihStartDate');
            const endInput   = document.getElementById('exportPelatihEndDate');
            if (startInput && endInput && !startInput.value && !endInput.value) {
                setQuickRangePelatih('this_month');
            }

            openModal('modalExportPelatih');
        }

        function openModalExportPelatih(type) {
            if (type === 'data_pelatih') {
                exportDataPelatih();
            } else {
                openModalExportAbsensiPelatih(type === 'sesi' ? 'sesi' : 'rekap');
            }
        }

        function setQuickRangePelatih(type) {
            const startInput = document.getElementById('exportPelatihStartDate');
            const endInput   = document.getElementById('exportPelatihEndDate');
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

        function handleRowClick(event, id, nama, tanggal, status, keterangan) {
            if (event.target.tagName === 'INPUT' || event.target.closest('td')?.querySelector('input[type="checkbox"]')) {
                return;
            }
            openEditAbsensiPelatih(id, nama, tanggal, status, keterangan);
        }

        function toggleSelectAllAbsensi(masterCheckbox) {
            const rows = document.querySelectorAll('.absensi-pelatih-row');
            rows.forEach(row => {
                if (!row.classList.contains('hidden')) {
                    const cb = row.querySelector('.checkbox-absensi');
                    if (cb) cb.checked = masterCheckbox.checked;
                }
            });
            updateBulkActionUI();
        }

        function updateBulkActionUI() {
            const checkedBoxes = document.querySelectorAll('.checkbox-absensi:checked');
            const allVisibleBoxes = Array.from(document.querySelectorAll('.absensi-pelatih-row'))
                .filter(r => !r.classList.contains('hidden'))
                .map(r => r.querySelector('.checkbox-absensi'))
                .filter(Boolean);

            const bar = document.getElementById('bulkActionBar');
            const countEl = document.getElementById('selectedCount');
            const masterCheckbox = document.getElementById('selectAllAbsensi');

            if (checkedBoxes.length > 0) {
                bar.classList.remove('hidden');
                bar.classList.add('flex');
                if (countEl) countEl.textContent = checkedBoxes.length;
            } else {
                bar.classList.add('hidden');
                bar.classList.remove('flex');
            }

            if (masterCheckbox && allVisibleBoxes.length > 0) {
                masterCheckbox.checked = allVisibleBoxes.every(cb => cb.checked);
            } else if (masterCheckbox) {
                masterCheckbox.checked = false;
            }
        }

        function cancelBulkSelection() {
            const checkboxes = document.querySelectorAll('.checkbox-absensi');
            checkboxes.forEach(cb => cb.checked = false);
            const masterCheckbox = document.getElementById('selectAllAbsensi');
            if (masterCheckbox) masterCheckbox.checked = false;
            updateBulkActionUI();
        }

        function openModalBulkDeleteAbsensi() {
            const checked = document.querySelectorAll('.checkbox-absensi:checked');
            if (checked.length === 0) return;

            document.getElementById('bulkDeleteCountText').textContent = checked.length;
            const container = document.getElementById('bulkDeleteInputsContainer');
            container.innerHTML = '';

            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });

            openModal('modalBulkDeleteAbsensi');
        }

        function openEditAbsensiPelatih(id, nama, tanggal, status, keterangan) {
            document.getElementById('editAbsensiId').value = id;
            document.getElementById('editAbsensiNamaPelatih').textContent = nama;
            document.getElementById('editAbsensiTanggal').value = tanggal;
            document.getElementById('editAbsensiKeterangan').value = (keterangan && keterangan !== '-') ? keterangan : '';

            // set status radio
            if (status === 'hadir') {
                document.getElementById('editStatusHadir').checked = true;
            } else if (status === 'izin') {
                document.getElementById('editStatusIzin').checked = true;
            } else if (status === 'sakit') {
                document.getElementById('editStatusSakit').checked = true;
            } else {
                document.getElementById('editStatusHadir').checked = true;
            }

            const form = document.getElementById('formEditAbsensiPelatih');
            form.action = '{{ url('/admin/pelatih/absensi') }}/' + id + '/update';

            const formHapus = document.getElementById('formHapusAbsensiPelatih');
            formHapus.action = '{{ url('/admin/pelatih/absensi') }}/' + id + '/delete';

            openModal('modalEditAbsensiPelatih');
        }

        function konfirmasiHapusAbsensiPelatih() {
            const nama = document.getElementById('editAbsensiNamaPelatih')?.textContent || 'Pelatih';
            const namaEl = document.getElementById('konfirmNamaPelatihAbsensi');
            if (namaEl) {
                namaEl.textContent = nama;
            }
            openModal('modalKonfirmasiHapusAbsensiPelatih');
        }

        function eksekusiHapusAbsensiPelatih() {
            document.getElementById('formHapusAbsensiPelatih').submit();
        }

        function filterAbsensiPelatihRows() {
            const input = document.getElementById('searchAbsensiPelatihInput');
            const query = input ? input.value.toLowerCase().trim() : '';
            const rows = document.querySelectorAll('.absensi-pelatih-row');
            const emptyRow = document.getElementById('absensiPelatihSearchNotFound');
            let visible = 0;

            rows.forEach(row => {
                const text = (row.textContent || '').toLowerCase();
                if (!query || text.includes(query)) {
                    row.classList.remove('hidden');
                    visible++;
                } else {
                    row.classList.add('hidden');
                }
            });

            if (emptyRow) {
                if (rows.length > 0 && visible === 0) {
                    emptyRow.classList.remove('hidden');
                } else {
                    emptyRow.classList.add('hidden');
                }
            }
        }
    </script>

    @include('components.logout-modal')
</body>
</html>
