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
    <title>Absensi Pelatih - Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#f4f8fb] min-h-screen text-slate-800 flex flex-col md:flex-row antialiased selection:bg-[#00a5ec] selection:text-white relative">

    <!-- Top Bar Header for Mobile -->
    <header class="md:hidden bg-[#093c56] text-white px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileSidebar()" class="p-2 text-slate-200 hover:text-white rounded-lg focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <span class="font-bold text-base tracking-wide">Gajah Depa</span>
        </div>
        <div class="text-xs px-2.5 py-1 bg-amber-400 text-amber-950 font-bold rounded-full">
            Pelatih
        </div>
    </header>

    <!-- Overlay backdrop for Mobile Sidebar -->
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
                <h2 class="text-base font-bold text-white tracking-wide leading-snug px-1">{{ $namaCabang ?? 'Gajah Depa' }}</h2>
            </div>

            <!-- Select Cabang Melatih Dropdown / Switcher -->
            <div class="px-4 mt-5 mb-2">
                <label class="block text-[10px] font-bold text-sky-300 uppercase tracking-wider mb-1.5 opacity-80">Cabang Melatih</label>
                <form action="{{ route('pelatih.switch_cabang') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <select name="id_cabang" onchange="this.form.submit()" class="w-full bg-[#0c4a6b] border border-sky-400/50 text-white rounded-xl px-3.5 py-2 text-xs font-semibold appearance-none focus:outline-none focus:ring-2 focus:ring-sky-400 cursor-pointer pr-8 transition">
                            @if(isset($cabangPelatihList) && count($cabangPelatihList) > 0)
                                @foreach($cabangPelatihList as $cb)
                                    <option value="{{ $cb->id }}" class="bg-[#093c56] text-white" {{ ($idCabang ?? null) == $cb->id ? 'selected' : '' }}>{{ $cb->nama }}</option>
                                @endforeach
                            @else
                                <option value="{{ $idCabang ?? 1 }}" class="bg-[#093c56] text-white">{{ $namaCabang ?? 'Gajah Depa' }}</option>
                            @endif
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-sky-300 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <!-- Navigation Links -->
            <nav class="px-4 py-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('pelatih.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pelatih.dashboard') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-table-cells-large text-base {{ request()->routeIs('pelatih.dashboard') ? 'text-sky-400' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Siswa -->
                <a href="{{ route('pelatih.siswa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pelatih.siswa') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-graduation-cap text-base {{ request()->routeIs('pelatih.siswa') ? 'text-sky-400' : '' }}"></i>
                    <span>Siswa</span>
                </a>

                <!-- Absensi -->
                <a href="{{ route('pelatih.absensi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pelatih.absensi') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-calendar-check text-base {{ request()->routeIs('pelatih.absensi') ? 'text-sky-400' : '' }}"></i>
                    <span>Absensi</span>
                </a>

                <!-- Penilaian -->
                <a href="{{ route('pelatih.penilaian') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pelatih.penilaian') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-star text-base {{ request()->routeIs('pelatih.penilaian') ? 'text-sky-400' : '' }}"></i>
                    <span>Penilaian</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('pelatih.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pelatih.pengaturan*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-gear text-base {{ request()->routeIs('pelatih.pengaturan*') ? 'text-sky-400' : '' }}"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer (Profile Info & Logout Button) -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                    <img src="{{ asset(Auth::user()->foto) }}" alt="{{ Auth::user()->nama }}" class="w-10 h-10 rounded-full object-cover border-2 border-amber-400 shrink-0 shadow-sm">
                @else
                    <div class="w-10 h-10 rounded-full bg-amber-400 text-amber-900 font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'PL', 0, 2)) }}
                    </div>
                @endif
                <div class="truncate">
                    <div class="text-sm font-bold text-white truncate">{{ Auth::user()->nama ?? 'Pelatih' }}</div>
                    <div class="text-[11px] text-slate-300 truncate">{{ Auth::user()->email ?? 'pelatih@gajahdepa.com' }}</div>
                </div>
            </div>

            <button type="button" onclick="openLogoutModal()" title="Keluar / Logout" class="p-2 text-slate-300 hover:text-rose-400 hover:bg-white/10 rounded-lg transition shrink-0 ml-1 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content Right -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto min-w-0">

        <!-- Flash Message Success -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- Flash Message Error -->
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
        
        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-[#008cc9] tracking-tight">Absensi</h1>
            <p class="text-slate-500 text-sm mt-1">Riwayat kehadiran yang dicatat oleh admin</p>
        </div>

        <!-- 3 KPI Stat Cards -->
        @php
            $displayBulanName = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');
        @endphp
        <div class="grid grid-cols-3 gap-3 md:gap-6 mb-8">
            <!-- Card 1: Total Hadir -->
            <div class="bg-white rounded-2xl p-3.5 sm:p-6 shadow-xs border-t-4 border-t-emerald-500 border-x border-b border-slate-100 text-center flex flex-col justify-center">
                <h3 class="text-2xl sm:text-4xl font-extrabold text-emerald-500 tracking-tight">{{ $totalHadir }}</h3>
                <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 sm:mt-2">Total Hadir</p>
                <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5 sm:mt-1 truncate">{{ $displayBulanName }} {{ $tahun }}</p>
            </div>

            <!-- Card 2: Total Izin -->
            <div class="bg-white rounded-2xl p-3.5 sm:p-6 shadow-xs border-t-4 border-t-amber-400 border-x border-b border-slate-100 text-center flex flex-col justify-center">
                <h3 class="text-2xl sm:text-4xl font-extrabold text-amber-500 tracking-tight">{{ $totalIzin }}</h3>
                <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 sm:mt-2">Total Izin</p>
                <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5 sm:mt-1 truncate">{{ $displayBulanName }} {{ $tahun }}</p>
            </div>

            <!-- Card 3: Total Sakit -->
            <div class="bg-white rounded-2xl p-3.5 sm:p-6 shadow-xs border-t-4 border-t-rose-500 border-x border-b border-slate-100 text-center flex flex-col justify-center">
                <h3 class="text-2xl sm:text-4xl font-extrabold text-rose-500 tracking-tight">{{ $totalSakit }}</h3>
                <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 sm:mt-2">Total Sakit</p>
                <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5 sm:mt-1 truncate">{{ $displayBulanName }} {{ $tahun }}</p>
            </div>
        </div>

        <!-- Section: Tabel Riwayat Kehadiran -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-800 tracking-tight">Riwayat Kehadiran</h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Data dicatat oleh Admin 
                    </p>
                </div>

                <!-- Filter Bulan & Tahun inside Card -->
                <form method="GET" action="{{ route('pelatih.absensi') }}" class="flex items-center gap-2">
                    <select name="bulan" onchange="this.form.submit()" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer">
                        @foreach([
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ] as $k => $namaBulan)
                            <option value="{{ $k }}" {{ $bulan == $k ? 'selected' : '' }}>{{ $namaBulan }}</option>
                        @endforeach
                    </select>

                    <select name="tahun" onchange="this.form.submit()" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer">
                        @foreach($listTahun ?? [date('Y')] as $thn)
                            <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto min-w-0">
                <table class="w-full text-left border-collapse min-w-[500px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500 text-sm font-semibold">
                            <th class="pb-3 px-4">Tanggal</th>
                            <th class="pb-3 px-4">Status</th>
                            <th class="pb-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($absensiList as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <!-- Tanggal (Format: Kamis, 18 Jun 2026) -->
                                <td class="py-4 px-4 font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kehadiran)->translatedFormat('l, d M Y') }}
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-4">
                                    @if($item->status_kehadiran === 'hadir')
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-300">
                                            Hadir
                                        </span>
                                    @elseif($item->status_kehadiran === 'izin')
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-300">
                                            Izin
                                        </span>
                                    @elseif($item->status_kehadiran === 'sakit')
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-500 border border-rose-300">
                                            Sakit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-500 border border-slate-300">
                                            Tidak Hadir
                                        </span>
                                    @endif
                                </td>

                                <!-- Keterangan -->
                                <td class="py-4 px-4 text-slate-600">
                                    {{ $item->keterangan && $item->keterangan !== '' ? $item->keterangan : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400">
                                    @if(!empty($tanggal))
                                        Tidak ada catatan kehadiran pada tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}.
                                    @else
                                        Belum ada data riwayat absensi untuk bulan {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Mobile Sidebar Helper -->
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
    </script>

    @include('components.logout-modal')
</body>
</html>
