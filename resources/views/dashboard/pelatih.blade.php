<!DOCTYPE html>
<html lang="id" class="bg-[#f4f8fb]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html,
        body {
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
    <title>Dashboard Pelatih - Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body
    class="bg-[#f4f8fb] min-h-screen text-slate-800 flex flex-col md:flex-row antialiased selection:bg-[#00a5ec] selection:text-white relative">

    <!-- Top Bar Header for Mobile -->
    <header
        class="md:hidden bg-[#093c56] text-white px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileSidebar()"
                class="p-2 text-slate-200 hover:text-white rounded-lg focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <span class="font-bold text-base tracking-wide">Gajah Depa</span>
        </div>
        <div class="text-xs px-2.5 py-1 bg-amber-400 text-amber-950 font-bold rounded-full">
            Pelatih
        </div>
    </header>

    <!-- Overlay backdrop for Mobile Sidebar -->
    <div id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Left -->
    <aside id="mainSidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-[#093c56] text-white flex flex-col justify-between h-screen md:min-h-screen md:sticky md:top-0 shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto shrink-0">
        <div>
            <!-- Header Sidebar (Logo & Title) -->
            <div class="p-6 flex flex-col items-center text-center border-b border-white/10">
                <div class="mb-3 relative">
                    @if(file_exists(public_path('images/logo.jpg')))
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa"
                            class="h-20 w-20 rounded-full object-cover shadow-md border-2 border-amber-300">
                    @else
                        <div
                            class="h-20 w-20 rounded-full bg-gradient-to-tr from-amber-400 to-yellow-300 flex flex-col items-center justify-center text-blue-900 border-2 border-amber-300 shadow-md">
                            <i class="fa-solid fa-elephant text-2xl text-gray-700 mb-0.5"></i>
                            <span class="text-[9px] font-black tracking-wider">GAJAH DEPA</span>
                        </div>
                    @endif
                </div>
                <h2 class="text-base font-bold text-white tracking-wide leading-snug px-1">
                    {{ $namaCabang ?? 'Gajah Depa' }}</h2>
            </div>

            <!-- Select Cabang Melatih Dropdown / Switcher -->
            <div class="px-4 mt-5 mb-2">
                <label
                    class="block text-[10px] font-bold text-sky-300 uppercase tracking-wider mb-1.5 opacity-80">Cabang
                    Melatih</label>
                <form action="{{ route('pelatih.switch_cabang') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <select name="id_cabang" onchange="this.form.submit()"
                            class="w-full bg-[#0c4a6b] border border-sky-400/50 text-white rounded-xl px-3.5 py-2 text-xs font-semibold appearance-none focus:outline-none focus:ring-2 focus:ring-sky-400 cursor-pointer pr-8 transition">
                            @if(isset($cabangPelatihList) && count($cabangPelatihList) > 0)
                                @foreach($cabangPelatihList as $cb)
                                    <option value="{{ $cb->id }}" class="bg-[#093c56] text-white" {{ ($idCabang ?? null) == $cb->id ? 'selected' : '' }}>{{ $cb->nama }}</option>
                                @endforeach
                            @else
                                <option value="{{ $idCabang ?? 1 }}" class="bg-[#093c56] text-white">
                                    {{ $namaCabang ?? 'Gajah Depa' }}</option>
                            @endif
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-sky-300 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <!-- Navigation Links -->
            <nav class="px-4 py-4 space-y-2">
                <!-- Dashboard (Active) -->
                <a href="{{ route('pelatih.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold text-sm shadow-sm transition">
                    <i class="fa-solid fa-table-cells-large text-base text-sky-400"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Siswa -->
                <a href="{{ route('pelatih.siswa') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 font-medium text-sm transition">
                    <i class="fa-solid fa-graduation-cap text-base"></i>
                    <span>Siswa</span>
                </a>

                <!-- Absensi -->
                <a href="{{ route('pelatih.absensi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 font-medium text-sm transition">
                    <i class="fa-regular fa-calendar-check text-base"></i>
                    <span>Absensi</span>
                </a>

                <!-- Penilaian -->
                <a href="{{ route('pelatih.penilaian') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 font-medium text-sm transition">
                    <i class="fa-regular fa-star text-base"></i>
                    <span>Penilaian</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('pelatih.pengaturan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pelatih.pengaturan*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i
                        class="fa-solid fa-gear text-base {{ request()->routeIs('pelatih.pengaturan*') ? 'text-sky-400' : '' }}"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer (Profile Info & Logout) -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                @if(auth()->user()->foto && file_exists(public_path(auth()->user()->foto)))
                    <img src="{{ asset(auth()->user()->foto) }}" alt="{{ auth()->user()->nama }}"
                        class="w-10 h-10 rounded-full object-cover border-2 border-amber-400 shrink-0 shadow-sm">
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-amber-400 text-amber-900 font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'PL', 0, 2)) }}
                    </div>
                @endif
                <div class="truncate">
                    <div class="text-sm font-bold text-white truncate">{{ auth()->user()->nama ?? 'Pelatih' }}</div>
                    <div class="text-[11px] text-slate-300 truncate">{{ auth()->user()->email ?? 'pelatih@gajahdepa.com'
                        }}</div>
                </div>
            </div>

            <button type="button" onclick="openLogoutModal()" title="Keluar"
                class="p-2 text-slate-300 hover:text-rose-400 hover:bg-white/10 rounded-lg transition shrink-0 ml-1 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto min-w-0">

        <!-- Flash Message Success -->
        @if(session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- Flash Message Error -->
        @if(session('error'))
            <div
                class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Selamat datang,
                {{ auth()->user()->nama ?? 'Pelatih' }}!</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan aktivitas Anda — {{ $namaCabang ?? 'Gajah Depa' }}</p>
        </div>

        <!-- Metric Cards Row -->
        <div id="pelatihCardsContainer"
            class="flex overflow-x-auto pb-3 pt-1 gap-3 snap-x snap-mandatory scroll-smooth cards-scrollbar md:no-scrollbar md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-6 md:pb-0 md:pt-0 mb-8">

            <!-- Card 1: Total Siswa -->
            <div
                class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-[#008cc9] relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Total
                        Siswa</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-cyan-50 text-[#008cc9] flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $totalSiswa ?? 0 }}</div>
                    <div class="text-[11px] sm:text-xs text-slate-400 mt-1 truncate">{{ $totalSiswaAktif ?? 0 }} aktif
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Kehadiran Saya -->
            <div
                class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-emerald-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Total
                        Kehadiran Saya</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                        {{ $totalHadir ?? 0 }}/{{ $totalRecord ?? 0 }}</div>
                    <div class="text-[11px] sm:text-xs text-slate-400 mt-1 truncate">{{ $totalIzin ?? 0 }} izin ·
                        {{ $totalSakit ?? 0 }} sakit</div>
                </div>
            </div>

            <!-- Card 3: Rating Saya -->
            <div
                class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-purple-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Rating
                        Saya</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800 flex items-center gap-1.5">
                        <span>{{ $avgRating ?? 0 }}</span>
                        <i class="fa-solid fa-star text-lg sm:text-2xl text-amber-400"></i>
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-400 mt-1 truncate">dari {{ $totalUlasan ?? 0 }} ulasan
                    </div>
                </div>
            </div>

            <!-- Card 4: Best Member of the Month -->
            <div
                class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-amber-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Best
                        Member of the Month</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        @if($bestMember)
                            <div
                                class="w-11 h-11 sm:w-14 sm:h-14 rounded-full p-0.5 border-2 border-amber-400 shrink-0 overflow-hidden bg-sky-50 flex items-center justify-center shadow-xs">
                                @if(!empty($bestMember->foto) && file_exists(public_path($bestMember->foto)))
                                    <img src="{{ asset($bestMember->foto) }}" alt="{{ $bestMember->nama }}"
                                        class="w-full h-full rounded-full object-cover">
                                @elseif(!empty($bestMember->foto) && file_exists(public_path('storage/' . $bestMember->foto)))
                                    <img src="{{ asset('storage/' . $bestMember->foto) }}" alt="{{ $bestMember->nama }}"
                                        class="w-full h-full rounded-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full rounded-full bg-gradient-to-br from-[#00b4db] to-[#0083b0] text-white font-extrabold text-xs sm:text-sm flex items-center justify-center">
                                        {{ strtoupper(substr($bestMember->nama ?? 'BM', 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm sm:text-lg font-extrabold text-slate-800 leading-tight truncate">
                                    {{ $bestMember->nama ?? 'Siswa Teladan' }}</div>
                                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate">
                                    {{ $namaBulan ?? 'Bulan Ini' }} {{ $tahun ?? date('Y') }} ·
                                    {{ $bestMember->nama_cabang ?? $namaCabang ?? 'Gajah Depa' }}</div>
                            </div>
                        @else
                            <div
                                class="w-11 h-11 sm:w-14 sm:h-14 rounded-full border-2 border-dashed border-amber-300 shrink-0 bg-amber-50/60 flex items-center justify-center text-amber-500 shadow-xs">
                                <i class="fa-solid fa-user-clock text-base sm:text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm sm:text-base font-bold text-slate-500 leading-tight truncate">
                                    Belum Ditetapkan</div>
                                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate">
                                    {{ $namaBulan ?? 'Bulan Ini' }} {{ $tahun ?? date('Y') }} ·
                                    {{ $namaCabang ?? 'Gajah Depa' }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Bar Chart Card: Grafik Kehadiran Siswa -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Grafik Kehadiran Siswa</h3>
                    <p class="text-xs text-slate-400 mt-0.5">
                        @if(!empty($tanggal))
                            {{ $namaCabang ?? 'Cabang' }} — <span
                                class="font-bold text-[#00a5ec]">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</span>
                        @else
                            {{ $namaCabang ?? 'Cabang' }} —
                            {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
                        @endif
                    </p>
                </div>

                <!-- Dropdown Month & Year Filters -->
                <form method="GET" action="{{ route('pelatih.dashboard') }}" class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <select name="bulan" onchange="this.form.submit()"
                            class="bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-3.5 py-2 pr-8 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer">
                            @foreach([
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ] as $key => $namaBulan)
                                <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $namaBulan }}</option>
                            @endforeach
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <select name="tahun" onchange="this.form.submit()"
                            class="bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-3.5 py-2 pr-8 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer">
                            @foreach($listTahun ?? [date('Y')] as $thn)
                                <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <!-- Canvas Bar Chart -->
            <div class="h-72 w-full">
                @if(isset($chartDates) && count($chartDates) > 0)
                    <canvas id="kehadiranSiswaChart"></canvas>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-regular fa-calendar-xmark text-4xl mb-2 text-slate-300"></i>
                        <p class="text-sm font-medium">Tidak ada data kehadiran siswa pada periode ini.</p>
                    </div>
                @endif
            </div>

            @if(isset($chartDates) && count($chartDates) > 0)
                <!-- Custom Legend -->
                <div class="flex items-center justify-center gap-6 mt-4 text-xs font-medium text-slate-600">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 bg-emerald-500 rounded-sm inline-block"></span>
                        <span>Hadir</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 bg-rose-400 rounded-sm inline-block"></span>
                        <span>Tidak Hadir</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- 3 Cards Row: Siswa, Ulasan Saya, Ulasan Club -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Card 1: Siswa — Cabang -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-3 mb-5">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight truncate">
                            Siswa — {{ $namaCabang ?? 'Kemang' }}
                        </h3>
                        <a href="{{ route('pelatih.siswa') }}"
                            class="text-xs font-semibold text-[#00a5ec] hover:text-[#008cc9] transition shrink-0">
                            Lihat semua
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentSiswa as $siswa)
                            @php
                                $nama = $siswa->nama ?? 'Siswa';
                                $parts = explode(' ', trim($nama));
                                $in1 = strtoupper(substr($parts[0] ?? '', 0, 1));
                                $in2 = isset($parts[1]) && !empty($parts[1]) ? strtoupper(substr($parts[1], 0, 1)) : '';
                                $initials = $in1 . $in2 ?: 'SW';
                                $tingkat = $siswa->tingkat_kelas ?? ($siswa->nama_kelas ?? 'Pemula A');
                            @endphp
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                                        <img src="{{ asset($siswa->foto) }}" alt="{{ $nama }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0 shadow-xs">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#00a5ec] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-sm font-bold text-slate-800 leading-snug truncate">{{ $nama }}
                                        </div>
                                        <div class="text-xs text-slate-400 truncate">{{ $tingkat }}</div>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-0.5 rounded-full border border-emerald-400 text-emerald-500 bg-emerald-50/50 text-[11px] font-semibold tracking-wide shrink-0">
                                    Aktif
                                </span>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-users-slash text-2xl mb-2 text-slate-300 block"></i>
                                <p class="text-xs font-medium">Belum ada data siswa di cabang ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Card 2: Ulasan Saya -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-3 mb-5">
                        <div class="flex items-center gap-2 min-w-0">
                            <i class="fa-solid fa-arrow-trend-up text-[#00a5ec] text-sm shrink-0"></i>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight truncate">
                                Ulasan Saya
                            </h3>
                        </div>
                        <a href="{{ route('pelatih.penilaian', ['tab' => 'penilaian_saya']) }}"
                            class="text-xs font-semibold text-[#00a5ec] hover:text-[#008cc9] transition shrink-0">
                            Lihat semua
                        </a>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentUlasanSaya as $us)
                            <div
                                class="rounded-xl border border-slate-100 bg-slate-50/50 p-3.5 transition hover:bg-slate-50">
                                <div class="flex items-center justify-between gap-2 mb-0.5">
                                    <span class="text-xs font-bold text-slate-800 truncate">
                                        {{ $us->nama_parent ?? 'Orang Tua' }}
                                    </span>
                                    <div class="flex items-center gap-0.5 text-amber-400 shrink-0">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($us->bintang_rating ?? 5))
                                                <i class="fa-solid fa-star text-[10px]"></i>
                                            @else
                                                <i class="fa-regular fa-star text-slate-300 text-[10px]"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-[11px] text-slate-400 mb-1.5 truncate">
                                    untuk {{ $us->nama_siswa ?? 'Siswa' }}
                                </div>
                                <p class="text-xs italic text-slate-600 leading-relaxed line-clamp-2">
                                    "{{ $us->komentar_rating ?? '-' }}"
                                </p>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-400">
                                <i class="fa-regular fa-comment-dots text-2xl mb-2 text-slate-300 block"></i>
                                <p class="text-xs font-medium">Belum ada ulasan untuk Anda.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Card 3: Ulasan Club -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-3 mb-5">
                        <div class="flex items-center gap-2 min-w-0">
                            <i class="fa-regular fa-flag text-indigo-500 text-sm shrink-0"></i>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight truncate">
                                Ulasan Club
                            </h3>
                        </div>
                        <a href="{{ route('pelatih.penilaian', ['tab' => 'penilaian_club']) }}"
                            class="text-xs font-semibold text-[#00a5ec] hover:text-[#008cc9] transition shrink-0">
                            Lihat semua
                        </a>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentUlasanClub as $uc)
                            <div
                                class="rounded-xl border border-slate-100 bg-slate-50/50 p-3.5 transition hover:bg-slate-50">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="text-xs font-bold text-slate-800 truncate">
                                        {{ $uc->nama_parent ?? 'Orang Tua' }}
                                    </span>
                                    <div class="flex items-center gap-0.5 text-amber-400 shrink-0">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($uc->bintang_rating ?? 5))
                                                <i class="fa-solid fa-star text-[10px]"></i>
                                            @else
                                                <i class="fa-regular fa-star text-slate-300 text-[10px]"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-1.5">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-lg border border-purple-200 bg-purple-50 text-purple-600 text-[10px] font-semibold capitalize">
                                        {{ ucfirst($uc->kategori ?? 'Fasilitas') }}
                                    </span>
                                </div>
                                <p class="text-xs italic text-slate-600 leading-relaxed line-clamp-2">
                                    "{{ $uc->komentar_rating ?? '-' }}"
                                </p>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-400">
                                <i class="fa-regular fa-flag text-2xl mb-2 text-slate-300 block"></i>
                                <p class="text-xs font-medium">Belum ada ulasan untuk club di cabang ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan"
        class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Chart.js Script for Kehadiran Siswa & Mobile Sidebar Helper -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
        @if(isset($chartDates) && count($chartDates) > 0)
            const ctxKehadiran = document.getElementById('kehadiranSiswaChart').getContext('2d');
            new Chart(ctxKehadiran, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartDates) !!},
                    datasets: [
                        {
                            label: 'Hadir',
                            data: {!! json_encode($chartHadir) !!},
                            backgroundColor: '#10b981',
                            borderRadius: 4,
                            barPercentage: 0.4,
                            categoryPercentage: 0.6
                        },
                        {
                            label: 'Tidak Hadir',
                            data: {!! json_encode($chartAbsen) !!},
                            backgroundColor: '#f87171',
                            borderRadius: 4,
                            barPercentage: 0.4,
                            categoryPercentage: 0.6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            grid: { borderDash: [3, 3] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        @endif
    </script>

    @include('components.logout-modal')
</body>

</html>