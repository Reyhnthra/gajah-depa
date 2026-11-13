<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua - Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Sleek horizontal scrollbar for cards */
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
            <span class="font-bold text-sm tracking-wide truncate">{{ $siswa->nama_cabang ?? 'Gajah Depa' }}</span>
        </div>
        <div class="text-xs px-2.5 py-1 bg-amber-400 text-amber-950 font-bold rounded-full shrink-0">
            Orang Tua
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
                    {{ $siswa->nama_cabang ?? 'Gajah Depa' }}</h2>
            </div>

            <!-- Card Anak Saya -->
            <div class="px-4 mt-5 mb-2">
                <div class="bg-[#0c4a6b] border border-sky-400/40 rounded-2xl p-4 text-white shadow-sm">
                    <div class="flex items-center justify-between mb-1">
                        <div class="text-[10px] font-bold text-sky-300 uppercase tracking-wider opacity-80">ANAK SAYA
                        </div>
                        @if(isset($siswaList) && count($siswaList) > 1)
                            <span
                                class="text-[10px] font-semibold bg-sky-400/20 text-sky-200 px-2 py-0.5 rounded-full border border-sky-400/30">
                                {{ count($siswaList) }} Anak
                            </span>
                        @endif
                    </div>
                    @if(isset($siswaList) && count($siswaList) > 1)
                        <form action="{{ route('parents.switch_anak') }}" method="POST" class="mt-1.5 mb-1.5">
                            @csrf
                            <div class="relative">
                                <select name="id_siswa" onchange="this.form.submit()"
                                    class="w-full bg-[#093c56] border border-sky-400/50 text-white rounded-xl px-3 py-2 text-xs font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-sky-400 cursor-pointer pr-8 transition">
                                    @foreach($siswaList as $anak)
                                        <option value="{{ $anak->id }}" class="bg-[#093c56] text-white" {{ ($siswa->id ?? null) == $anak->id ? 'selected' : '' }}>
                                            {{ $anak->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <i
                                    class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[11px] text-sky-300 pointer-events-none"></i>
                            </div>
                        </form>
                    @else
                        <div class="text-sm font-bold text-white">{{ $siswa->nama ?? 'Ahmad Rizki' }}</div>
                    @endif
                    <div class="text-xs text-sky-200 opacity-90 mt-0.5">{{ ucfirst($siswa->nama_kelas ?? 'Pemula A') }}
                        · {{ $siswa->nama_cabang ?? 'Kemang' }}</div>
                    <button type="button" onclick="openDataAnakModal()"
                        class="inline-block text-[11px] text-sky-300 font-medium hover:underline mt-2.5 text-left focus:outline-none">Ketuk
                        untuk lihat data →</button>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="px-4 py-3 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('parents.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.dashboard') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i
                        class="fa-solid fa-table-cells-large text-base {{ request()->routeIs('parents.dashboard') ? 'text-sky-400' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Absensi -->
                <a href="{{ route('parents.absensi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.absensi') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i
                        class="fa-regular fa-calendar-check text-base {{ request()->routeIs('parents.absensi') ? 'text-sky-400' : '' }}"></i>
                    <span>Absensi</span>
                </a>

                <!-- Penilaian -->
                <a href="{{ route('parents.penilaian_anak') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.penilaian_anak') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i
                        class="fa-regular fa-file-lines text-base {{ request()->routeIs('parents.penilaian_anak') ? 'text-sky-400' : '' }}"></i>
                    <span>Penilaian</span>
                </a>

                <!-- Nilai -->
                <a href="{{ route('parents.nilai') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.nilai*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i
                        class="fa-regular fa-star text-base {{ request()->routeIs('parents.nilai*') ? 'text-sky-400' : '' }}"></i>
                    <span>Nilai</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('parents.pengaturan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.pengaturan*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i
                        class="fa-solid fa-gear text-base {{ request()->routeIs('parents.pengaturan*') ? 'text-sky-400' : '' }}"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer (Profile Info & Logout) -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div
                    class="w-10 h-10 rounded-full bg-amber-400 text-amber-950 font-bold text-sm flex items-center justify-center shrink-0 shadow-sm overflow-hidden border border-amber-300">
                    @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                        <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama ?? 'Foto Anak' }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($siswa->nama ?? (Auth::user()->nama ?? 'AN'), 0, 2)) }}
                    @endif
                </div>
                <div class="truncate">
                    <div class="text-sm font-bold text-white truncate">{{ Auth::user()->nama ?? 'Hendra Rizki' }}</div>
                    <div class="text-[11px] text-slate-300 truncate">Orang Tua dari {{ $siswa->nama ?? 'Anak' }}</div>
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

        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Selamat datang,
                {{ Auth::user()->nama ?? 'Hendra Rizki' }}!</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau perkembangan {{ $siswa->nama ?? 'Ahmad Rizki' }} di
                {{ $siswa->nama_cabang ?? 'Gajah Depa Akuatik' }}</p>
        </div>

        <!-- 3 Metric Cards Row -->
        <div id="parentCardsContainer"
            class="flex overflow-x-auto pb-4 pt-1 gap-3.5 snap-x snap-mandatory scroll-smooth cards-scrollbar md:no-scrollbar md:grid md:grid-cols-3 md:gap-6 md:pb-0 md:pt-0 mb-8">

            <!-- Card 1: Total Kehadiran Bulan Ini -->
            <div
                class="w-[82%] min-w-[82%] sm:w-[calc(46%-8px)] sm:min-w-[calc(46%-8px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-emerald-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Total
                        Kehadiran Bulan Ini</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-800">{{ $totalHadir }}</div>
                    <div class="text-[11px] sm:text-xs text-slate-400 mt-1 truncate">{{ $totalIzin }} izin ·
                        {{ $totalSakit }} sakit</div>
                </div>
            </div>

            <!-- Card 2: Progres Anak Bulan Ini -->
            <div
                class="w-[82%] min-w-[82%] sm:w-[calc(46%-8px)] sm:min-w-[calc(46%-8px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-sky-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Progres
                        Anak Bulan Ini</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-cyan-50 text-[#00a5ec] flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#00a5ec]">{{ $progresNilaiPersen ?? 0 }}%
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 mb-1.5 overflow-hidden">
                        <div class="bg-[#00a5ec] h-1.5 rounded-full transition-all duration-500"
                            style="width: {{ $progresNilaiPersen ?? 0 }}%"></div>
                    </div>
                    @if(($totalPenilaianBulanIni ?? 0) > 0)
                        <div class="text-[11px] sm:text-xs text-slate-400 truncate">Rata-rata {{ $avgScoreBulanIni }}/5 ·
                            {{ $totalPenilaianBulanIni }} latihan ({{ $namaBulan ?? 'Bulan Ini' }})</div>
                    @else
                        <div class="text-[11px] sm:text-xs text-slate-400 truncate">Belum ada penilaian ·
                            {{ $namaBulan ?? 'Bulan Ini' }}</div>
                    @endif
                </div>
            </div>

            <!-- Card 3: Best Member of the Month -->
            <div
                class="w-[82%] min-w-[82%] sm:w-[calc(46%-8px)] sm:min-w-[calc(46%-8px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 border-t-4 border-t-amber-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                    <span class="text-[11px] sm:text-xs font-bold text-[#008cc9] tracking-wide leading-tight">Best
                        Member of the Month</span>
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xs sm:text-base shrink-0">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <div>
                    @if($bestMember)
                        <div class="flex items-center gap-3">
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
                                <div class="text-sm sm:text-lg font-extrabold text-[#008cc9] leading-tight truncate">
                                    {{ $bestMember->nama }}</div>
                                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate">
                                    {{ $namaBulan ?? 'Bulan Ini' }} {{ $tahun ?? date('Y') }} ·
                                    {{ $bestMember->nama_cabang ?? $siswa->nama_cabang ?? 'Gajah Depa' }}</div>
                            </div>
                        </div>

                        @if($isBestMember ?? false)
                            <button type="button" onclick="openBestMemberModal()"
                                class="mt-3 w-full py-2 px-3 bg-gradient-to-r from-[#00b4db] to-[#0083b0] hover:from-[#00a0c4] hover:to-[#007198] text-white text-[11px] sm:text-xs font-bold rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                                <span>Lihat Ucapan</span>
                            </button>
                        @endif
                    @else
                        <div class="flex items-center gap-3">
                            <div
                                class="w-11 h-11 sm:w-14 sm:h-14 rounded-full border-2 border-dashed border-amber-300 shrink-0 bg-amber-50/60 flex items-center justify-center text-amber-500 shadow-2xs">
                                <i class="fa-solid fa-user-clock text-base sm:text-lg"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm sm:text-base font-bold text-slate-400 leading-tight truncate">
                                    Belum Ditetapkan
                                </div>
                                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-slate-300 mr-1.5 shrink-0"></span> {{ $namaBulan ?? 'Bulan Ini' }} {{ $tahun ?? date('Y') }} · {{ $siswa->nama_cabang ?? 'Gajah Depa' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>


        <!-- Card Grafik Penilaian -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Grafik Penilaian</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Perkembangan rata-rata nilai setiap sesi latihan</p>
                </div>

                <!-- Filter Bulan & Tahun -->
                <form action="{{ route('parents.dashboard') }}" method="GET" class="flex items-center gap-2 shrink-0">
                    <div class="relative">
                        <select name="bulan" onchange="this.form.submit()"
                            class="bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-3.5 py-2 pr-8 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer shadow-2xs hover:bg-slate-50 transition">
                            <option value="01" {{ ($bulan ?? date('m')) == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ ($bulan ?? date('m')) == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ ($bulan ?? date('m')) == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ ($bulan ?? date('m')) == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ ($bulan ?? date('m')) == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ ($bulan ?? date('m')) == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ ($bulan ?? date('m')) == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ ($bulan ?? date('m')) == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ ($bulan ?? date('m')) == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ ($bulan ?? date('m')) == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ ($bulan ?? date('m')) == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ ($bulan ?? date('m')) == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <select name="tahun" onchange="this.form.submit()"
                            class="bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-3.5 py-2 pr-8 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer shadow-2xs hover:bg-slate-50 transition">
                            @foreach($listTahun ?? [date('Y')] as $thn)
                                <option value="{{ $thn }}" {{ ($tahun ?? date('Y')) == $thn ? 'selected' : '' }}>{{ $thn }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <!-- Custom Legend -->
            <div class="flex flex-wrap items-center gap-5 text-xs font-semibold mb-4">
                <span class="inline-flex items-center gap-2 text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#00a5ec]"></span> Rata-rata
                </span>
            </div>

            <!-- Chart Canvas Container (Selalu tampilkan grafik meskipun tidak ada data / bernilai 0) -->
            <div class="h-64 sm:h-72 w-full relative">
                <canvas id="penilaianChart"></canvas>
            </div>
        </div>

    </main>

    <!-- Modal Data Anak -->
    <div id="modalDataAnak"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
        <div
            class="bg-white text-slate-800 w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl relative border border-slate-100 p-6 md:p-8 max-h-[90vh] overflow-y-auto">

            <!-- Header Modal & Close Button -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#008cc9] tracking-tight">Data Anak</h3>
                    <p class="text-xs text-slate-500 mt-1">Informasi data {{ $siswa->nama ?? 'Ahmad Rizki' }} — sinkron
                        dengan sistem admin</p>
                </div>
                <button onclick="closeDataAnakModal()"
                    class="text-slate-400 hover:text-slate-600 text-xl p-1 focus:outline-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Top Profile Card Badge (Light Sky Blue Container) -->
            <div class="bg-[#f0f9ff] border border-sky-200/70 rounded-2xl p-4 flex items-center gap-4 mb-6">
                @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                    <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama }}"
                        class="w-14 h-14 rounded-full object-cover border border-sky-200 shrink-0 shadow-sm">
                @else
                    <div
                        class="w-14 h-14 rounded-full bg-[#00a5ec] text-white font-black text-lg flex items-center justify-center shrink-0 shadow-sm">
                        {{ strtoupper(substr($siswa->nama ?? 'AR', 0, 2)) }}
                    </div>
                @endif
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-lg font-bold text-[#008cc9]">{{ $siswa->nama ?? 'Ahmad Rizki' }}</h4>
                        <span
                            class="px-2.5 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-300 font-semibold text-[11px] rounded-full">
                            {{ $siswa->status ?? 'Aktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        ID: {{ $siswa->kode_siswa ?? 'GD001' }} · {{ $siswa->nama_kelas ?? 'Pemula A' }} · Cabang
                        {{ $siswa->nama_cabang ?? 'Kemang' }}
                    </p>
                </div>
            </div>

            <!-- Section 1: Data Siswa -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-[#093c56] border-b border-sky-400/30 pb-2 mb-4">Data Siswa</h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Tanggal Lahir</span>
                        <span
                            class="font-bold text-slate-800 text-sm">{{ $siswa->tgl_lahir_format ?? '14 Maret 2012' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Kelas / Level</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->nama_kelas ?? 'Pemula A' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block mb-0.5 font-medium">Sekolah</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->sekolah ?? 'SDN 01 Sumedang' }}</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Data Orang Tua / Wali -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-[#093c56] border-b border-sky-400/30 pb-2 mb-4">Data Orang Tua / Wali
                </h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Nama</span>
                        <span
                            class="font-bold text-slate-800 text-sm">{{ $siswa->nama_parent ?? 'Hendra Rizki' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">No. Handphone</span>
                        <span
                            class="font-bold text-slate-800 text-sm">{{ $siswa->phone_parent ?? '0812-1111-2222' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Email</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->email_parent ?? 'hendra@email.com'
                            }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Alamat</span>
                        <span
                            class="font-bold text-slate-800 text-sm">{{ $siswa->alamat_parent ?? 'Jl. Kemang Raya No. 5, Jakarta Selatan' }}</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Synchronized Info Box & Tombol WhatsApp Admin Cabang -->
            <div
                class="bg-[#ecfdf5] border border-emerald-200/80 rounded-2xl p-4 text-emerald-800 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-emerald-500 text-base shrink-0 mt-0.5"></i>
                    <p class="leading-relaxed font-medium">
                        Data ini sinkron dengan sistem admin. Jika ada kesalahan, hubungi admin cabang
                        {{ $siswa->nama_cabang ?? 'Kemang' }}.
                    </p>
                </div>
                @if(!empty($siswa->wa_admin_url))
                    <a href="{{ $siswa->wa_admin_url }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-xs transition shrink-0">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>Chat Admin</span>
                    </a>
                @endif
            </div>

        </div>
    </div>

    @if($isBestMember ?? false)
        <!-- Best Member of the Month Greeting Story Modal (Hanya untuk Best Member) -->
        <div id="bestMemberModal" onclick="if(event.target === this) closeBestMemberModal()"
            class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div class="flex flex-col items-center w-full max-w-[340px] my-auto">

                <!-- 9:16 IG Story Card Preview -->
                <div id="bestMemberCardPreview"
                    class="w-full aspect-[9/16] rounded-3xl overflow-hidden shadow-2xl relative border border-white/25 flex flex-col items-center justify-between p-6 text-center text-white select-none bg-gradient-to-b from-[#00b4db] to-[#0083b0]">

                    <!-- Custom Photo Background Layer -->
                    <img id="bestMemberBgImage" src="" alt=""
                        class="hidden absolute inset-0 w-full h-full object-cover z-0">
                    <div id="bestMemberBgOverlay"
                        class="hidden absolute inset-0 bg-gradient-to-b from-[#0083b0]/50 via-[#093c56]/55 to-[#093c56]/70 z-0">
                    </div>

                    <!-- Decorative Dot Pattern -->
                    <div
                        class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none z-0">
                    </div>

                    <!-- Top Brand Header -->
                    <div class="relative z-10 flex flex-col items-center pt-1">
                        <div
                            class="w-14 h-14 rounded-full overflow-hidden border-2 border-amber-300 shadow-lg mb-2 bg-gradient-to-tr from-amber-400 to-yellow-300 flex items-center justify-center text-blue-950 font-black">
                            @if(file_exists(public_path('images/logo.jpg')))
                                <img id="bestMemberLogoImg" src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa"
                                    class="w-full h-full object-cover" crossorigin="anonymous">
                            @else
                                <span>GD</span>
                            @endif
                        </div>
                        <h4 id="bestMemberCabangTitle"
                            class="font-extrabold text-xs tracking-wide text-white uppercase drop-shadow-xs px-2 leading-snug">
                            {{ $bestMember->nama_cabang ?? $siswa->nama_cabang ?? 'Gajah Depa Akuatik Sumedang' }}
                        </h4>
                    </div>

                    <!-- Center Best Member Certificate Card -->
                    <div
                        class="relative z-10 w-full bg-white/[0.06] backdrop-blur-[2px] rounded-2xl p-5 border border-white/25 shadow-lg space-y-2.5 my-auto">
                        <div
                            class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-amber-400 text-amber-950 font-extrabold text-[11px] uppercase tracking-wider rounded-full shadow-xs">
                            <i class="fa-solid fa-trophy"></i>
                            <span>Best Member of the Month</span>
                        </div>

                        <p id="bestMemberPeriode" class="text-xs font-bold text-amber-200 tracking-wide uppercase">
                            {{ $namaBulan ?? 'Oktober' }} {{ $tahun ?? date('Y') }}
                        </p>

                        <!-- Member Avatar / Trophy Circle -->
                        <div class="py-1 flex justify-center">
                            <div
                                class="w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-amber-400 to-yellow-200 shadow-lg">
                                @if(!empty($bestMember->foto) && file_exists(public_path($bestMember->foto)))
                                    <img id="bestMemberAvatarImg" src="{{ asset($bestMember->foto) }}"
                                        alt="{{ $bestMember->nama }}" class="w-full h-full rounded-full object-cover"
                                        crossorigin="anonymous">
                                @elseif(!empty($bestMember->foto) && file_exists(public_path('storage/' . $bestMember->foto)))
                                    <img id="bestMemberAvatarImg" src="{{ asset('storage/' . $bestMember->foto) }}"
                                        alt="{{ $bestMember->nama }}" class="w-full h-full rounded-full object-cover"
                                        crossorigin="anonymous">
                                @else
                                    <div
                                        class="w-full h-full rounded-full bg-[#093c56] text-amber-300 font-black text-2xl flex items-center justify-center">
                                        {{ strtoupper(substr($bestMember->nama ?? 'AR', 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="text-[11px] text-cyan-100 block font-medium">Selamat & Apresiasi Kepada</span>
                            <h5 id="bestMemberNama" class="text-xl font-black text-white tracking-tight mt-0.5">
                                {{ $bestMember->nama ?? $siswa->nama ?? 'Ahmad Rizki' }}</h5>
                            <p id="bestMemberKelas" class="text-[11px] text-cyan-50 font-semibold mt-0.5">Kelas
                                {{ $bestMember->nama_kelas ?? $siswa->nama_kelas ?? 'Pemula A' }}</p>
                        </div>

                        <!-- 2 Highlight Metrics -->
                        <div class="grid grid-cols-2 gap-2 pt-1 text-xs">
                            <div class="bg-white/[0.07] border border-white/20 p-2.5 rounded-xl">
                                <span class="text-cyan-50 text-[10px] block mb-0.5 font-medium">Total Kehadiran</span>
                                <div id="bestMemberHadir" class="font-extrabold text-emerald-300 text-base">
                                    {{ $bestMember->total_hadir ?? $totalHadir ?? 0 }} Sesi</div>
                            </div>
                            <div class="bg-white/[0.07] border border-white/20 p-2.5 rounded-xl">
                                <span class="text-cyan-50 text-[10px] block mb-0.5 font-medium">Progres Bulan Ini</span>
                                <div id="bestMemberProgres" class="font-extrabold text-amber-300 text-base">
                                    {{ $bestMember->progres_pct ?? $progresNilaiPersen ?? 0 }}%</div>
                            </div>
                        </div>

                        <p id="bestMemberQuote"
                            class="text-[11px] italic text-white/95 pt-2 border-t border-white/20 leading-relaxed">
                            "Selamat atas terpilihnya sebagai Best Member bulan {{ $namaBulan ?? 'Oktober' }}
                            {{ $tahun ?? date('Y') }}! Terus semangat berlatih dan raih prestasi terbaikmu!"
                        </p>
                    </div>

                    <!-- Bottom Footer -->
                    <div class="relative z-10 pb-1">
                        <p class="text-[11px] text-cyan-50 font-semibold tracking-wide opacity-90">gajahdepa.my.id</p>
                    </div>
                </div>

                <!-- Action Buttons Below 9:16 Card -->
                <div class="w-full mt-3 space-y-2">
                    <div class="flex items-center gap-2">
                        <label for="bestMemberPhotoInput"
                            class="flex-1 py-2.5 px-3 bg-white/15 hover:bg-white/25 text-white border border-white/20 rounded-xl font-semibold text-xs cursor-pointer transition flex items-center justify-center gap-2">
                            <i class="fa-regular fa-image"></i>
                            <span id="bestMemberPhotoLabel">Tambah Latar Foto</span>
                        </label>
                        <input type="file" id="bestMemberPhotoInput" accept="image/*" class="hidden"
                            onchange="handleBestMemberBgUpload(event)">
                        <button type="button" id="resetBestMemberBgBtn" onclick="resetBestMemberBg()"
                            class="hidden py-2.5 px-3 bg-rose-500/80 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition"
                            title="Hapus Latar Foto">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>

                    <button type="button" onclick="downloadBestMemberStory()"
                        class="w-full py-3 bg-[#008cc9] hover:bg-[#0077ad] text-white rounded-xl font-bold text-xs tracking-wider uppercase shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-download"></i>
                        <span>Simpan</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan"
        class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Helper Scripts -->
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

        function openDataAnakModal() {
            document.getElementById('modalDataAnak').classList.remove('hidden');
        }

        function closeDataAnakModal() {
            document.getElementById('modalDataAnak').classList.add('hidden');
        }

        // --- Best Member Story Modal & Download ---
        let customBestMemberBgDataUrl = null;

        function openBestMemberModal() {
            const modal = document.getElementById('bestMemberModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeBestMemberModal() {
            const modal = document.getElementById('bestMemberModal');
            if (modal) modal.classList.add('hidden');
        }

        function handleBestMemberBgUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                customBestMemberBgDataUrl = e.target.result;
                const bgImg = document.getElementById('bestMemberBgImage');
                const bgOverlay = document.getElementById('bestMemberBgOverlay');
                bgImg.src = customBestMemberBgDataUrl;
                bgImg.classList.remove('hidden');
                bgOverlay.classList.remove('hidden');
                document.getElementById('bestMemberPhotoLabel').innerText = 'Ganti Latar Foto';
                document.getElementById('resetBestMemberBgBtn').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function resetBestMemberBg() {
            customBestMemberBgDataUrl = null;
            const bgImg = document.getElementById('bestMemberBgImage');
            const bgOverlay = document.getElementById('bestMemberBgOverlay');
            bgImg.src = '';
            bgImg.classList.add('hidden');
            bgOverlay.classList.add('hidden');
            document.getElementById('bestMemberPhotoInput').value = '';
            document.getElementById('bestMemberPhotoLabel').innerText = 'Tambah Latar Foto';
            document.getElementById('resetBestMemberBgBtn').classList.add('hidden');
        }

        function drawRoundedRectBM(ctx, x, y, width, height, radius) {
            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo(x + width, y + height - radius);
            ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x + radius, y + height);
            ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
        }

        function wrapTextBM(ctx, text, x, y, maxWidth, lineHeight) {
            const words = text.split(' ');
            let line = '';
            let lines = [];
            for (let n = 0; n < words.length; n++) {
                const testLine = line + words[n] + ' ';
                const metrics = ctx.measureText(testLine);
                if (metrics.width > maxWidth && n > 0) {
                    lines.push(line.trim());
                    line = words[n] + ' ';
                } else {
                    line = testLine;
                }
            }
            lines.push(line.trim());
            lines.forEach((l, i) => {
                ctx.fillText(l, x, y + (i * lineHeight));
            });
            return lines.length;
        }

        async function downloadBestMemberStory() {
            const canvas = document.createElement('canvas');
            const W = 1080;
            const H = 1920;
            canvas.width = W;
            canvas.height = H;
            const ctx = canvas.getContext('2d');

            // 1. Background (Custom Photo or Landing Page Blue Gradient)
            if (customBestMemberBgDataUrl) {
                const bgImg = new Image();
                bgImg.src = customBestMemberBgDataUrl;
                await new Promise(resolve => { bgImg.onload = resolve; bgImg.onerror = resolve; });
                const imgRatio = bgImg.width / bgImg.height;
                const canvasRatio = W / H;
                let drawW = W, drawH = H, offsetX = 0, offsetY = 0;
                if (imgRatio > canvasRatio) {
                    drawW = H * imgRatio;
                    offsetX = -(drawW - W) / 2;
                } else {
                    drawH = W / imgRatio;
                    offsetY = -(drawH - H) / 2;
                }
                ctx.drawImage(bgImg, offsetX, offsetY, drawW, drawH);

                const overlayGrad = ctx.createLinearGradient(0, 0, 0, H);
                overlayGrad.addColorStop(0, 'rgba(0, 131, 176, 0.50)');
                overlayGrad.addColorStop(0.5, 'rgba(9, 60, 86, 0.55)');
                overlayGrad.addColorStop(1, 'rgba(9, 60, 86, 0.70)');
                ctx.fillStyle = overlayGrad;
                ctx.fillRect(0, 0, W, H);
            } else {
                const grad = ctx.createLinearGradient(0, 0, 0, H);
                grad.addColorStop(0, '#00b4db');
                grad.addColorStop(1, '#0083b0');
                ctx.fillStyle = grad;
                ctx.fillRect(0, 0, W, H);
            }

            // Subtle dot pattern
            ctx.fillStyle = 'rgba(255, 255, 255, 0.08)';
            for (let gx = 24; gx < W; gx += 48) {
                for (let gy = 24; gy < H; gy += 48) {
                    ctx.beginPath();
                    ctx.arc(gx, gy, 2.5, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            // 2. Top Logo & Branch Title
            const logoEl = document.getElementById('bestMemberLogoImg');
            const logoY = 200;
            const logoR = 90;
            if (logoEl && logoEl.complete && logoEl.naturalWidth > 0) {
                ctx.save();
                ctx.beginPath();
                ctx.arc(W / 2, logoY, logoR, 0, Math.PI * 2);
                ctx.closePath();
                ctx.clip();
                ctx.drawImage(logoEl, W / 2 - logoR, logoY - logoR, logoR * 2, logoR * 2);
                ctx.restore();

                ctx.beginPath();
                ctx.arc(W / 2, logoY, logoR, 0, Math.PI * 2);
                ctx.lineWidth = 6;
                ctx.strokeStyle = '#fcd34d';
                ctx.stroke();
            } else {
                ctx.beginPath();
                ctx.arc(W / 2, logoY, logoR, 0, Math.PI * 2);
                ctx.fillStyle = '#fbbf24';
                ctx.fill();
                ctx.fillStyle = '#172554';
                ctx.font = '900 54px Inter, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('GD', W / 2, logoY + 18);
            }

            const cabangTitle = (document.getElementById('bestMemberCabangTitle')?.innerText || 'GAJAH DEPA AKUATIK SUMEDANG').toUpperCase();
            ctx.fillStyle = '#ffffff';
            ctx.font = '800 36px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(cabangTitle, W / 2, logoY + logoR + 60);

            // 3. Center Glass Card
            const cardX = 85;
            const cardY = 440;
            const cardW = W - 170;
            const cardH = 1200;

            ctx.fillStyle = 'rgba(255, 255, 255, 0.06)';
            drawRoundedRectBM(ctx, cardX, cardY, cardW, cardH, 48);
            ctx.fill();
            ctx.lineWidth = 3;
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.25)';
            ctx.stroke();

            // Badge BEST MEMBER OF THE MONTH
            ctx.fillStyle = '#fbbf24';
            drawRoundedRectBM(ctx, W / 2 - 280, cardY + 55, 560, 68, 34);
            ctx.fill();
            ctx.fillStyle = '#451a03';
            ctx.font = '800 28px Inter, sans-serif';
            ctx.fillText('🏆 BEST MEMBER OF THE MONTH', W / 2, cardY + 99);

            // Periode Bulan & Tahun
            const periodeText = (document.getElementById('bestMemberPeriode')?.innerText || '').toUpperCase();
            ctx.fillStyle = '#fde68a';
            ctx.font = '800 34px Inter, sans-serif';
            ctx.fillText(periodeText, W / 2, cardY + 180);

            // Member Avatar Circle
            const avatarY = cardY + 325;
            const avatarR = 105;
            const avatarEl = document.getElementById('bestMemberAvatarImg');
            if (avatarEl && avatarEl.complete && avatarEl.naturalWidth > 0) {
                ctx.save();
                ctx.beginPath();
                ctx.arc(W / 2, avatarY, avatarR, 0, Math.PI * 2);
                ctx.closePath();
                ctx.clip();
                ctx.drawImage(avatarEl, W / 2 - avatarR, avatarY - avatarR, avatarR * 2, avatarR * 2);
                ctx.restore();
            } else {
                ctx.beginPath();
                ctx.arc(W / 2, avatarY, avatarR, 0, Math.PI * 2);
                ctx.fillStyle = '#093c56';
                ctx.fill();

                const namaForInit = document.getElementById('bestMemberNama')?.innerText || 'AR';
                const initials = namaForInit.substring(0, 2).toUpperCase();
                ctx.fillStyle = '#fcd34d';
                ctx.font = '900 72px Inter, sans-serif';
                ctx.fillText(initials, W / 2, avatarY + 25);
            }

            ctx.beginPath();
            ctx.arc(W / 2, avatarY, avatarR, 0, Math.PI * 2);
            ctx.lineWidth = 8;
            ctx.strokeStyle = '#fbbf24';
            ctx.stroke();

            // Selamat & Nama Siswa
            ctx.fillStyle = '#bae6fd';
            ctx.font = '600 30px Inter, sans-serif';
            ctx.fillText('Selamat & Apresiasi Kepada', W / 2, cardY + 495);

            const namaText = document.getElementById('bestMemberNama')?.innerText || 'Ahmad Rizki';
            ctx.fillStyle = '#ffffff';
            ctx.font = '900 64px Inter, sans-serif';
            ctx.fillText(namaText, W / 2, cardY + 570);

            const kelasText = document.getElementById('bestMemberKelas')?.innerText || 'Kelas Pemula A';
            ctx.fillStyle = '#e0f2fe';
            ctx.font = '600 32px Inter, sans-serif';
            ctx.fillText(kelasText, W / 2, cardY + 625);

            // 2 Metric Subcards (Progres Bulan Ini & Rata-rata Nilai)
            const boxW = 360;
            const boxH = 185;
            const gap = 36;
            const startX = (W - (boxW * 2 + gap)) / 2;
            const boxY = cardY + 675;

            const metrics = [
                { label: 'Total Kehadiran', val: document.getElementById('bestMemberHadir')?.innerText || '0 Sesi', color: '#6ee7b7' },
                { label: 'Progres Bulan Ini', val: document.getElementById('bestMemberProgres')?.innerText || '0%', color: '#fde047' }
            ];

            metrics.forEach((m, idx) => {
                const bx = startX + idx * (boxW + gap);
                ctx.fillStyle = 'rgba(255, 255, 255, 0.07)';
                drawRoundedRectBM(ctx, bx, boxY, boxW, boxH, 32);
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.22)';
                ctx.stroke();

                ctx.fillStyle = '#e0f2fe';
                ctx.font = '600 28px Inter, sans-serif';
                ctx.fillText(m.label, bx + boxW / 2, boxY + 65);

                ctx.fillStyle = m.color;
                ctx.font = '800 54px Inter, sans-serif';
                ctx.fillText(m.val, bx + boxW / 2, boxY + 140);
            });

            // Divider line
            ctx.beginPath();
            ctx.moveTo(cardX + 70, cardY + 915);
            ctx.lineTo(cardX + cardW - 70, cardY + 915);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.22)';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Congratulatory Quote
            const quoteText = document.getElementById('bestMemberQuote')?.innerText || '';
            ctx.fillStyle = '#ffffff';
            ctx.font = 'italic 500 32px Inter, sans-serif';
            wrapTextBM(ctx, quoteText, W / 2, cardY + 980, cardW - 130, 46);

            // Footer URL
            ctx.fillStyle = 'rgba(224, 242, 254, 0.9)';
            ctx.font = '600 32px Inter, sans-serif';
            ctx.fillText('gajahdepa.my.id', W / 2, H - 115);

            // Download PNG
            const link = document.createElement('a');
            const safeName = namaText.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const safePeriode = periodeText.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            link.download = `best-member-${safeName}-${safePeriode}.png`;
            link.href = canvas.toDataURL('image/png');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }


        // --- 2. Chart Penilaian Siswa ---
        const rawPenilaianData = {!! json_encode($chartPenilaianData ?? []) !!};
        let penilaianChartInstance = null;

        function renderPenilaianChart() {
            const canvas = document.getElementById('penilaianChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            let labels = [];
            let rataRataData = [];

            if (rawPenilaianData.length > 0) {
                labels = rawPenilaianData.map(item => item.sesi ? `${item.sesi} (${item.tgl_short || item.tanggal})` : (item.tgl_short || item.tanggal));
                rataRataData = rawPenilaianData.map(item => item.rata_rata || Math.round(((item.teknik + item.kecepatan + item.ketahanan) / 3) * 10) / 10);
            } else {
                // Selalu tampilkan grafik walaupun belum ada data penilaian (nilai 0)
                labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
                rataRataData = [0, 0, 0, 0];
            }

            if (penilaianChartInstance) {
                penilaianChartInstance.data.labels = labels;
                penilaianChartInstance.data.datasets[0].data = rataRataData;
                penilaianChartInstance.update();
                return;
            }

            penilaianChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Rata-rata',
                            data: rataRataData,
                            borderColor: '#00a5ec',
                            backgroundColor: 'rgba(0, 165, 236, 0.12)',
                            borderWidth: 2.5,
                            tension: 0.35,
                            fill: true,
                            pointBackgroundColor: '#00a5ec',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
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
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${context.parsed.y} / 5`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 5,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                callback: function (val) {
                                    return val;
                                }
                            },
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [3, 3]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderPenilaianChart();
        });
    </script>

    @include('components.logout-modal')
</body>

</html>