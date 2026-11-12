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
    <title>Penilaian & Ulasan - Admin Gajah Depa</title>
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

        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Penilaian & Ulasan</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau feedback dan rating kepuasan orang tua terhadap pelatih serta layanan klub</p>
        </div>

        <!-- Navigation Tabs: Penilaian Pelatih | Penilaian Club -->
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('admin.penilaian.index', ['tab' => 'pelatih']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-2 {{ $activeTab === 'pelatih' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-sky-100/60 text-[#008cc9] hover:bg-sky-100' }}">
                <i class="fa-solid fa-user-tie text-xs"></i>
                <span>Penilaian Pelatih</span>
            </a>

            <a href="{{ route('admin.penilaian.index', ['tab' => 'club']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-2 {{ $activeTab === 'club' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-sky-100/60 text-[#008cc9] hover:bg-sky-100' }}">
                <i class="fa-solid fa-shield-halved text-xs"></i>
                <span>Penilaian Club</span>
            </a>
        </div>

        <!-- 3 KPI Summary Cards (Persis Style Absensi Pelatih & Siswa) -->
        <div class="flex overflow-x-auto pb-3 pt-1 gap-3 snap-x snap-mandatory scroll-smooth no-scrollbar md:grid md:grid-cols-3 md:gap-6 md:pb-0 md:pt-0 mb-8">
            <!-- Card 1: Total Ulasan -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-[#00a5ec] relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Ulasan</p>
                        <h3 class="text-xl sm:text-3xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            {{ $totalUlasan }}
                        </h3>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-sky-50 flex items-center justify-center text-[#00a5ec] text-sm sm:text-xl font-bold shadow-xs shrink-0">
                        <i class="fa-regular fa-comments"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#00a5ec]"></span> Dari orang tua siswa
                </p>
            </div>

            <!-- Card 2: Rata-Rata Rating -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-amber-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Rata-Rata Rating</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <h3 class="text-xl sm:text-3xl font-extrabold text-[#093c56] truncate">
                                {{ number_format($avgRating, 1) }}
                            </h3>
                            <div class="flex text-amber-400 text-sm">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 text-sm sm:text-xl font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-amber-400"></span> Skala 1.0 s/d 5.0
                </p>
            </div>

            <!-- Card 3: Ulasan Positif -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-emerald-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Ulasan Positif</p>
                        <h3 class="text-xl sm:text-3xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            {{ $positiveCount }}
                        </h3>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 text-sm sm:text-xl font-bold shadow-xs shrink-0">
                        <i class="fa-regular fa-thumbs-up"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span> {{ $totalUlasan > 0 ? round(($positiveCount / $totalUlasan) * 100) : 0 }}% rating bintang 4 & 5
                </p>
            </div>
        </div>

        <!-- Container Card Tabel Penilaian (Menyatu Seperti di Absensi Pelatih) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <!-- Header Card Tabel -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">
                        {{ $activeTab === 'pelatih' ? 'Penilaian Pelatih' : 'Penilaian Layanan Club' }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ $activeTab === 'pelatih' ? 'Catatan ulasan orang tua siswa untuk semua pelatih (klik baris untuk melihat detail)' : 'Catatan ulasan orang tua untuk fasilitas dan operasional klub (klik baris untuk detail)' }}
                    </p>
                </div>
            </div>

            <!-- Filter Controls Form -->
            @php
                $daftarBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $selectedBulan = $bulan ?? request('bulan', (string)date('n'));
                $selectedTahun = $tahun ?? request('tahun', (string)date('Y'));
            @endphp
            <form action="{{ route('admin.penilaian.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 text-xs">
                <input type="hidden" name="tab" value="{{ $activeTab }}">

                <!-- 1. Bar Pencarian -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">
                        {{ $activeTab === 'pelatih' ? 'Cari Pelatih / Wali / Ulasan' : 'Cari Wali / Siswa / Ulasan' }}
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" id="searchPenilaianInput" name="search" value="{{ request('search') }}" placeholder="Cari nama atau ulasan..."
                            oninput="filterPenilaianRows()"
                            onkeydown="if(event.key==='Enter'){ this.form.submit(); }"
                            class="w-full pl-9 pr-3.5 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>
                </div>

                <!-- 2. Pilih Bulan -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Pilih Bulan</label>
                    <div class="relative">
                        <select name="bulan" onchange="this.form.submit()" class="w-full appearance-none px-3.5 py-2 bg-[#f8fafc] border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] pr-8 cursor-pointer">
                            <option value="semua" {{ $selectedBulan === 'semua' ? 'selected' : '' }}>Semua Bulan</option>
                            @foreach($daftarBulan as $num => $namaBulan)
                                <option value="{{ $num }}" {{ (string)$selectedBulan === (string)$num ? 'selected' : '' }}>{{ $namaBulan }}</option>
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
                            <option value="semua" {{ $selectedTahun === 'semua' ? 'selected' : '' }}>Semua Tahun</option>
                            @foreach($listTahun ?? [date('Y')] as $y)
                                <option value="{{ $y }}" {{ (string)$selectedTahun === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
            </form>

            @if(request()->filled('search') || (request()->has('bulan') && request('bulan') !== (string)date('n')) || (request()->has('tahun') && request('tahun') !== (string)date('Y')))
                <div class="flex items-center justify-end mb-4 text-xs">
                    <a href="{{ route('admin.penilaian.index', ['tab' => $activeTab]) }}" class="text-xs text-rose-500 hover:text-rose-600 flex items-center gap-1 font-semibold transition">
                        <i class="fa-solid fa-rotate-left text-[10px]"></i>
                        <span>Reset Filter</span>
                    </a>
                </div>
            @endif

            <!-- Table Data Penilaian -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-4">Tanggal</th>
                            @if($activeTab === 'pelatih')
                                <th class="py-3.5 px-4">Nama Pelatih</th>
                            @else
                                <th class="py-3.5 px-4">Cabang</th>
                            @endif
                            <th class="py-3.5 px-4">Orang Tua & Siswa</th>
                            <th class="py-3.5 px-4">Rating</th>
                            <th class="py-3.5 px-4">Komentar / Ulasan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reviews as $item)
                            @php
                                $bintang = (int) ($item->bintang_rating ?? 5);
                                $tanggalFormatted = $item->created_at ? date('d M Y, H:i', strtotime($item->created_at)) : '-';
                            @endphp
                            <tr class="penilaian-row hover:bg-sky-50/60 cursor-pointer transition group"
                                onclick="openDetailPenilaian(
                                    '{{ $activeTab }}',
                                    '{{ addslashes($tanggalFormatted) }}',
                                    '{{ addslashes($activeTab === 'pelatih' ? ($item->nama_pelatih ?? '-') : ($item->nama_cabang ?? 'Kemang')) }}',
                                    '',
                                    '{{ addslashes($item->nama_parent ?? 'Orang Tua') }}',
                                    '{{ addslashes($item->nama_siswa ?? '-') }}',
                                    {{ $bintang }},
                                    '{{ addslashes($item->komentar_rating ?? '-') }}'
                                )">
                                
                                <!-- Tanggal -->
                                <td class="py-3.5 px-4 font-medium text-slate-500 whitespace-nowrap">
                                    {{ $tanggalFormatted }}
                                </td>

                                <!-- Pelatih / Cabang -->
                                @if($activeTab === 'pelatih')
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            @if($item->foto_pelatih && file_exists(public_path($item->foto_pelatih)))
                                                <img src="{{ asset($item->foto_pelatih) }}" alt="{{ $item->nama_pelatih }}" class="w-8 h-8 rounded-full object-cover shrink-0 border border-slate-200">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-[#00a5ec] text-white font-bold text-xs flex items-center justify-center shrink-0">
                                                    {{ strtoupper(substr($item->nama_pelatih ?? 'P', 0, 2)) }}
                                                </div>
                                            @endif
                                            <span class="font-bold text-slate-800">{{ $item->nama_pelatih ?? 'Pelatih' }}</span>
                                        </div>
                                    </td>
                                @else
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-lg text-[11px]">
                                            <i class="fa-solid fa-location-dot text-[#00a5ec] mr-1"></i>{{ $item->nama_cabang ?? 'Kemang' }}
                                        </span>
                                    </td>
                                @endif

                                <!-- Orang Tua & Siswa -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="font-semibold text-slate-800">{{ $item->nama_parent ?? 'Orang Tua' }}</div>
                                    <div class="text-[11px] text-slate-400">Siswa: {{ $item->nama_siswa ?? '-' }}</div>
                                </td>

                                <!-- Rating Bintang -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex text-amber-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $bintang)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-slate-200"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="font-bold text-slate-700 text-xs ml-0.5">{{ $bintang }}.0</span>
                                    </div>
                                </td>

                                <!-- Komentar / Ulasan -->
                                <td class="py-3.5 px-4 max-w-xs md:max-w-md">
                                    <p class="text-slate-600 line-clamp-2 leading-relaxed italic">
                                        "{{ $item->komentar_rating ?? '-' }}"
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fa-regular fa-comment-dots text-slate-300 text-3xl mb-2"></i>
                                        <span class="font-semibold text-slate-600">Tidak ada data penilaian ditemukan</span>
                                        <span class="text-xs text-slate-400 mt-0.5">Coba sesuaikan kata kunci pencarian atau bulan & tahun</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="penilaianSearchNotFound" class="hidden">
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-magnifying-glass text-slate-300 text-2xl mb-2"></i>
                                    <span class="font-semibold text-slate-600">Tidak ada data yang cocok dengan pencarian</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal 1: Detail Penilaian & Ulasan -->
    <div id="modalDetailPenilaian" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 flex items-start justify-between">
                <div>
                    <span id="detailBadgeType" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-[#008cc9] uppercase tracking-wider">
                        Detail Penilaian
                    </span>
                    <h3 id="detailTargetName" class="text-lg font-bold text-slate-800 mt-1">Nama Target</h3>
                    <p id="detailTanggal" class="text-xs text-slate-400 mt-0.5">Waktu ulasan</p>
                </div>
                <button type="button" onclick="closeModal('modalDetailPenilaian')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="p-6 space-y-4 text-xs">
                <!-- Bintang Rating -->
                <div class="bg-amber-50/70 border border-amber-200/80 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <span class="text-slate-500 font-semibold block text-[11px]">Nilai Rating Diberikan</span>
                        <div id="detailStarIcons" class="flex text-amber-400 text-sm mt-1 gap-1"></div>
                    </div>
                    <div id="detailScoreNumber" class="text-2xl font-black text-amber-600">
                        5.0
                    </div>
                </div>

                <!-- Info Orang Tua & Siswa -->
                <div class="bg-slate-50 rounded-xl p-4 space-y-2 border border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Orang Tua / Wali:</span>
                        <span id="detailParentName" class="font-bold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Siswa:</span>
                        <span id="detailStudentName" class="font-semibold text-slate-700">-</span>
                    </div>
                    <div id="rowDetailKategori" class="flex items-center justify-between hidden">
                        <span class="text-slate-400 font-medium">Kategori Ulasan:</span>
                        <span id="detailCategoryName" class="font-semibold text-[#008cc9]">-</span>
                    </div>
                </div>

                <!-- Komentar / Pesan Lengkap -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Pesan / Ulasan Lengkap:</label>
                    <div class="bg-[#f8fafc] border border-slate-200 rounded-xl p-4 text-slate-700 leading-relaxed text-xs italic" id="detailKomentar">
                        "Komentar ulasan..."
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeModal('modalDetailPenilaian')" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan" class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Scripts -->
    <script>
        // Toggle Mobile Sidebar
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

        // Modal Open / Close
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.remove('hidden');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        }

        // Detail Penilaian Modal
        function openDetailPenilaian(tab, tanggal, targetName, kategori, parentName, studentName, bintang, komentar) {
            document.getElementById('detailBadgeType').textContent = tab === 'pelatih' ? 'Penilaian Pelatih' : 'Penilaian Club';
            document.getElementById('detailTargetName').textContent = targetName;
            document.getElementById('detailTanggal').textContent = tanggal;
            document.getElementById('detailParentName').textContent = parentName;
            document.getElementById('detailStudentName').textContent = studentName;
            document.getElementById('detailScoreNumber').textContent = bintang + '.0';
            document.getElementById('detailKomentar').textContent = '"' + komentar + '"';

            const rowKategori = document.getElementById('rowDetailKategori');
            if (tab === 'club' && kategori) {
                rowKategori.classList.remove('hidden');
                document.getElementById('detailCategoryName').textContent = kategori;
            } else {
                rowKategori.classList.add('hidden');
            }

            // Star icons
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= bintang) {
                    starsHtml += '<i class="fa-solid fa-star"></i>';
                } else {
                    starsHtml += '<i class="fa-regular fa-star text-slate-300"></i>';
                }
            }
            document.getElementById('detailStarIcons').innerHTML = starsHtml;

            openModal('modalDetailPenilaian');
        }

        function filterPenilaianRows() {
            const input = document.getElementById('searchPenilaianInput');
            const query = input ? input.value.toLowerCase().trim() : '';
            const rows = document.querySelectorAll('.penilaian-row');
            const emptyRow = document.getElementById('penilaianSearchNotFound');
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
