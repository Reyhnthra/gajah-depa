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
    <title>Dashboard Keuangan - Gajah Depa Swimming Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f4f8fb] min-h-screen text-slate-800 flex flex-col md:flex-row antialiased selection:bg-[#00a5ec] selection:text-white relative">

    <!-- Top Bar Header for Mobile -->
    <header class="md:hidden bg-[#093c56] text-white px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileSidebar()" class="p-2 text-slate-200 hover:text-white rounded-lg focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <span class="font-bold text-sm sm:text-base tracking-wide truncate max-w-[220px]">{{ Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa' }}</span>
        </div>
        <div class="text-xs px-2.5 py-1 bg-amber-400 text-amber-950 font-bold rounded-full">
            Admin
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

        <!-- Top Header & Net Balance Pill -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-[#008cc9] tracking-tight">Dashboard Keuangan</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola keuangan {{ Auth::user()->cabang ? Auth::user()->cabang->nama : 'Gajah Depa' }}</p>
            </div>

            <!-- Net Balance Pill -->
            <div class="bg-[#008cc9] text-white px-6 py-3.5 rounded-2xl shadow-md min-w-[240px]">
                <p class="text-xs font-medium text-sky-100 uppercase tracking-wider">Net Balance (Periode Ini)</p>
                <h3 class="text-2xl font-bold tracking-tight mt-0.5">
                    {{ $netBalance < 0 ? '-Rp ' . number_format(abs($netBalance), 0, ',', '.') : 'Rp ' . number_format($netBalance, 0, ',', '.') }}
                </h3>
                <div class="text-[11px] text-sky-100 mt-2 flex items-center justify-between gap-3 border-t border-white/20 pt-1.5">
                    <span class="opacity-90">Kas Bersih Cabang:</span>
                    <span class="font-bold tracking-tight">{{ $saldoKasAllTime < 0 ? '-Rp ' . number_format(abs($saldoKasAllTime), 0, ',', '.') : 'Rp ' . number_format($saldoKasAllTime, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- 3 KPI Summary Cards -->
        <div class="flex overflow-x-auto pb-3 pt-1 gap-3 snap-x snap-mandatory scroll-smooth no-scrollbar md:grid md:grid-cols-3 md:gap-6 md:pb-0 md:pt-0 mb-8">
            <!-- Card 1: Total Pemasukan -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-cyan-500 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-medium text-slate-500">Total Pemasukan</p>
                        <h3 class="text-base sm:text-2xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-500 text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate">Pemasukan periode ini</p>
            </div>

            <!-- Card 2: Total Pengeluaran -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-orange-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-medium text-slate-500">Total Pengeluaran</p>
                        <h3 class="text-base sm:text-2xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-400 text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate">Pengeluaran periode ini</p>
            </div>

            <!-- Card 3: Total Transaksi -->
            <div class="w-[calc(50%-6px)] min-w-[calc(50%-6px)] md:w-auto md:min-w-0 shrink-0 snap-start bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 border-t-4 border-t-sky-400 relative overflow-hidden flex flex-col justify-between">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <div>
                        <p class="text-[11px] sm:text-xs font-medium text-slate-500">Total Transaksi</p>
                        <h3 class="text-base sm:text-2xl font-extrabold text-[#093c56] mt-1.5 truncate">
                            {{ $totalTransaksi }}
                        </h3>
                    </div>
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-sky-50 flex items-center justify-center text-[#00a5ec] text-xs sm:text-lg font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                </div>
                <p class="text-[10px] sm:text-xs font-medium text-slate-400 mt-2 truncate">Transaksi periode ini</p>
            </div>
        </div>

        <!-- Section: Riwayat Transaksi Keuangan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <!-- Table Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Riwayat Transaksi Keuangan</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Catatan seluruh arus kas pemasukan dan pengeluaran klub (klik baris untuk mengedit transaksi)</p>
                </div>
                
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <!-- Export Button (Opens Export Modal with Date Picker) -->
                    <button type="button" onclick="openModal('modalExportKeuangan')" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition flex items-center gap-2 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-download text-[#00a5ec] text-xs"></i>
                        <span>Export</span>
                    </button>

                    <!-- Tambah Transaksi Button -->
                    <button type="button" onclick="openModal('tambahTransaksiModal')" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-[#00a5ec] rounded-xl hover:bg-[#008cc9] shadow-sm transition flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Transaksi</span>
                    </button>
                </div>
            </div>

            <!-- Filter Controls Form (Langsung Tampil) -->
            <div class="mb-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <form id="formFilterKeuangan" method="GET" action="{{ route('admin.keuangan.index') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                        <!-- Cari Deskripsi -->
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Cari Deskripsi</label>
                            <div class="relative">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik deskripsi..."
                                    onkeydown="if(event.key==='Enter'){ this.form.submit(); }"
                                    class="w-full pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            </div>
                        </div>

                        <!-- Tipe Transaksi -->
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Tipe Transaksi</label>
                            <div class="relative">
                                <select name="jenis_transaksi" onchange="this.form.submit()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] appearance-none pr-8 cursor-pointer">
                                    <option value="semua" {{ request('jenis_transaksi') == 'semua' || !request('jenis_transaksi') ? 'selected' : '' }}>Semua Tipe</option>
                                    <option value="pemasukan" {{ request('jenis_transaksi') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                    <option value="pengeluaran" {{ request('jenis_transaksi') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Pilih Bulan -->
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Pilih Bulan</label>
                            <div class="relative">
                                @php
                                    $namaBulan = [
                                        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
                                        '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
                                        '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                    ];
                                @endphp
                                <select name="bulan" onchange="this.form.submit()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] appearance-none pr-8 cursor-pointer">
                                    <option value="semua" {{ (string)($bulan ?? request('bulan')) === 'semua' ? 'selected' : '' }}>Semua Bulan</option>
                                    @foreach($namaBulan as $mNum => $mName)
                                        <option value="{{ $mNum }}" {{ (string)($bulan ?? request('bulan', date('n'))) === (string)$mNum ? 'selected' : '' }}>
                                            {{ $mName }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Pilih Tahun -->
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Pilih Tahun</label>
                            <div class="relative">
                                <select name="tahun" onchange="this.form.submit()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] appearance-none pr-8 cursor-pointer">
                                    <option value="semua" {{ (string)($tahun ?? request('tahun')) === 'semua' ? 'selected' : '' }}>Semua Tahun</option>
                                    @foreach($listTahun ?? [date('Y')] as $yr)
                                        <option value="{{ $yr }}" {{ (string)($tahun ?? request('tahun', date('Y'))) === (string)$yr ? 'selected' : '' }}>
                                            {{ $yr }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    @if(request()->filled('search') || (request()->filled('jenis_transaksi') && request('jenis_transaksi') !== 'semua') || (request()->has('bulan') && request('bulan') !== (string)date('n')) || (request()->has('tahun') && request('tahun') !== (string)date('Y')) || request()->filled('from_date') || request()->filled('to_date'))
                        <div class="flex items-center justify-between pt-2.5 mt-2.5 border-t border-slate-200/60 text-xs">
                            <span class="text-slate-500 text-[11px] flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#00a5ec]"></span>
                                Filter aktif diterapkan
                            </span>
                            <a href="{{ route('admin.keuangan.index') }}" class="text-[#00a5ec] hover:text-[#008cc9] font-semibold text-xs flex items-center gap-1.5 hover:underline">
                                <i class="fa-solid fa-rotate-left text-[11px]"></i>
                                <span>Reset Filter (Kembali ke Bulan Ini)</span>
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto min-w-0">
                <table class="w-full text-left border-collapse min-w-[500px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500 text-sm font-semibold">
                            <th class="pb-3 px-4">Tanggal</th>
                            <th class="pb-3 px-4">Tipe</th>
                            <th class="pb-3 px-4">Nominal</th>
                            <th class="pb-3 px-4">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($transaksi as $item)
                            <tr class="hover:bg-sky-50/60 cursor-pointer transition group"
                                onclick="openEditTransaksi({{ $item->id }}, '{{ $item->tanggal_transaksi }}', '{{ $item->jenis_transaksi }}', {{ $item->nominal }}, '{{ addslashes($item->keterangan) }}')">
                                <!-- Tanggal -->
                                <td class="py-4 px-4 font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d M Y') }}
                                </td>

                                <!-- Tipe Badge -->
                                <td class="py-4 px-4">
                                    @if($item->jenis_transaksi === 'pemasukan')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-500 border border-rose-200">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <!-- Nominal -->
                                <td class="py-4 px-4 font-bold">
                                    @if($item->jenis_transaksi === 'pemasukan')
                                        <span class="text-emerald-600">+Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-rose-500">-Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                    @endif
                                </td>

                                <!-- Deskripsi -->
                                <td class="py-4 px-4 text-slate-700">
                                    {{ $item->keterangan }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">
                                    Belum ada transaksi keuangan terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- MODAL: Tambah Transaksi Baru -->
    <div id="tambahTransaksiModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
            
            <!-- Close Button -->
            <button onclick="closeModal('tambahTransaksiModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Modal Title -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-[#008cc9]">Tambah Transaksi Baru</h3>
                <p class="text-slate-500 text-sm mt-1">Masukkan detail transaksi keuangan klub renang</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.keuangan.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Tipe Transaksi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Tipe Transaksi</label>
                    <select name="jenis_transaksi" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] focus:ring-1 focus:ring-[#00a5ec]">
                        <option value="" disabled selected>Pilih tipe</option>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>

                <!-- Nominal -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Nominal</label>
                    <input type="number" name="nominal" required placeholder="0" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] focus:ring-1 focus:ring-[#00a5ec]">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Deskripsi</label>
                    <textarea name="keterangan" rows="3" required placeholder="Deskripsi transaksi..." class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] focus:ring-1 focus:ring-[#00a5ec] resize-none"></textarea>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal_transaksi" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] focus:ring-1 focus:ring-[#00a5ec]">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('tambahTransaksiModal')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#00a5ec] rounded-xl hover:bg-[#008cc9] shadow-sm transition">
                        Simpan Transaksi
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- MODAL: Export Laporan Keuangan (Rentang Tanggal Kustom) -->
    <div id="modalExportKeuangan" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 sm:p-7 relative max-h-[92vh] overflow-y-auto border border-slate-100">
            <!-- Modal Header -->
            <div class="flex items-start justify-between pb-5 border-b border-slate-100 mb-5">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-[#00a5ec]/10 text-[#00a5ec] rounded-xl flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-file-excel"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Export Laporan Keuangan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Atur rentang tanggal transaksi sebelum diexport</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalExportKeuangan')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Form Export -->
            <form id="formExportKeuangan" method="GET" action="{{ route('admin.keuangan.export') }}" target="_blank" class="space-y-4 text-xs">
                <!-- Pilihan Tipe Transaksi -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Pilihan Tipe Transaksi</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                            <input type="radio" name="jenis_transaksi" value="semua" checked class="text-[#00a5ec] focus:ring-[#00a5ec] mr-1.5">
                            <span class="font-semibold text-slate-700">Semua</span>
                        </label>
                        <label class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                            <input type="radio" name="jenis_transaksi" value="pemasukan" class="text-[#00a5ec] focus:ring-[#00a5ec] mr-1.5">
                            <span class="font-semibold text-slate-700">Pemasukan</span>
                        </label>
                        <label class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#00a5ec] has-[:checked]:bg-sky-50/50">
                            <input type="radio" name="jenis_transaksi" value="pengeluaran" class="text-[#00a5ec] focus:ring-[#00a5ec] mr-1.5">
                            <span class="font-semibold text-slate-700">Pengeluaran</span>
                        </label>
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="space-y-3">
                    <label class="block font-bold text-slate-700">Rentang Tanggal</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Dari Tanggal (Mulai)</label>
                            <input type="date" name="from_date" id="exportKeuanganStartDate"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Sampai Tanggal (Selesai)</label>
                            <input type="date" name="to_date" id="exportKeuanganEndDate"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                        </div>
                    </div>

                    <!-- Preset Shortcut Rentang Cepat -->
                    <div class="flex items-center gap-1.5 flex-wrap pt-1">
                        <span class="text-[10px] text-slate-400 font-semibold mr-1">Preset:</span>
                        <button type="button" onclick="setQuickRangeKeuangan('today')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition cursor-pointer">Hari Ini</button>
                        <button type="button" onclick="setQuickRangeKeuangan('7d')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition cursor-pointer">7 Hari Terakhir</button>
                        <button type="button" onclick="setQuickRangeKeuangan('30d')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition cursor-pointer">30 Hari Terakhir</button>
                        <button type="button" onclick="setQuickRangeKeuangan('this_month')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition cursor-pointer">Bulan Ini</button>
                        <button type="button" onclick="setQuickRangeKeuangan('last_month')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition cursor-pointer">Bulan Lalu</button>
                        <button type="button" onclick="setQuickRangeKeuangan('all')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 rounded-lg text-[10px] font-medium transition cursor-pointer">Semua Tanggal</button>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-3 bg-sky-50/60 border border-sky-100 rounded-xl flex items-start gap-2.5 text-xs text-slate-600">
                    <i class="fa-solid fa-circle-info text-[#00a5ec] mt-0.5 text-sm shrink-0"></i>
                    <p class="text-[11px] leading-relaxed">
                        Data akan diexport dalam format <strong>CSV (Excel compatible)</strong> memuat: Tanggal Transaksi, Tipe Transaksi, Nominal (Rp), Deskripsi, serta Rangkuman Total Pemasukan, Total Pengeluaran, dan Saldo Bersih.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modalExportKeuangan')" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-[#00a5ec] hover:bg-[#0092d1] text-white rounded-xl font-semibold shadow-sm transition flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-file-arrow-down text-sm"></i>
                        <span>Download File Export</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Transaksi Keuangan -->
    <div id="modalEditTransaksi" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
            
            <!-- Close Button -->
            <button type="button" onclick="closeModal('modalEditTransaksi')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 text-lg p-1 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <span class="w-10 h-10 rounded-xl bg-sky-50 text-[#00a5ec] flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Edit Transaksi Keuangan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Perbarui rincian arus kas keuangan klub</p>
                </div>
            </div>

            <form id="formEditTransaksi" method="POST" action="" class="space-y-4 text-xs" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data transaksi ini?')">
                @csrf
                <input type="hidden" name="id" id="editTransaksiId">

                <!-- Tipe Transaksi (Pemasukan / Pengeluaran) -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Tipe Transaksi</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/50">
                            <input type="radio" name="jenis_transaksi" id="editJenisPemasukan" value="pemasukan" class="text-emerald-600 focus:ring-emerald-500 mr-2">
                            <span class="font-bold text-emerald-700 text-xs">Pemasukan (+)</span>
                        </label>
                        <label class="flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/50">
                            <input type="radio" name="jenis_transaksi" id="editJenisPengeluaran" value="pengeluaran" class="text-rose-600 focus:ring-rose-500 mr-2">
                            <span class="font-bold text-rose-700 text-xs">Pengeluaran (-)</span>
                        </label>
                    </div>
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" id="editTanggalTransaksi" required
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Nominal -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-bold text-slate-400 text-xs">Rp</span>
                        <input type="number" name="nominal" id="editNominalTransaksi" min="0" required placeholder="Contoh: 150000"
                            class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>
                </div>

                <!-- Deskripsi / Keterangan -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Deskripsi / Keterangan</label>
                    <input type="text" name="keterangan" id="editKeteranganTransaksi" required placeholder="Contoh: Iuran bulanan, beli pelampung..."
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button type="button" onclick="konfirmasiHapusTransaksi()" class="px-3.5 py-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl font-semibold transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalEditTransaksi')" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-[#00a5ec] hover:bg-[#008cc9] text-white rounded-xl font-semibold shadow-sm transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <!-- Hidden Form Hapus Transaksi -->
            <form id="formHapusTransaksi" method="POST" action="" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Transaksi -->
    <div id="modalKonfirmasiHapusTransaksi" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-slate-100 mx-4">
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-rose-500 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Hapus Transaksi Keuangan?</h3>
                <p class="text-xs text-slate-500 mb-1">Apakah Anda yakin ingin menghapus catatan transaksi ini?</p>
                <p id="konfirmDeskripsiTransaksi" class="text-sm font-bold text-rose-600 mb-2 truncate px-2"></p>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Tindakan ini tidak dapat dibatalkan dan akan mempengaruhi catatan kas klub.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalKonfirmasiHapusTransaksi')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" onclick="eksekusiHapusTransaksi()"
                        class="flex-1 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold text-xs shadow-sm transition cursor-pointer">
                        <i class="fa-solid fa-trash-can mr-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal & Mobile Sidebar Helper Script -->
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

        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.remove('hidden');
            if (id === 'modalExportKeuangan') {
                const startInput = document.getElementById('exportKeuanganStartDate');
                const endInput   = document.getElementById('exportKeuanganEndDate');
                if (startInput && endInput && !startInput.value && !endInput.value) {
                    setQuickRangeKeuangan('this_month');
                }
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        }

        function setQuickRangeKeuangan(type) {
            const startInput = document.getElementById('exportKeuanganStartDate');
            const endInput   = document.getElementById('exportKeuanganEndDate');
            if (!startInput || !endInput) return;

            const today = new Date();
            const fmt = (d) => {
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            if (type === 'today') {
                startInput.value = fmt(today);
                endInput.value   = fmt(today);
            } else if (type === '7d') {
                const past = new Date();
                past.setDate(today.getDate() - 7);
                startInput.value = fmt(past);
                endInput.value   = fmt(today);
            } else if (type === '30d') {
                const past = new Date();
                past.setDate(today.getDate() - 30);
                startInput.value = fmt(past);
                endInput.value   = fmt(today);
            } else if (type === 'this_month') {
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                const lastDay  = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                startInput.value = fmt(firstDay);
                endInput.value   = fmt(lastDay);
            } else if (type === 'last_month') {
                const firstDay = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                const lastDay  = new Date(today.getFullYear(), today.getMonth(), 0);
                startInput.value = fmt(firstDay);
                endInput.value   = fmt(lastDay);
            } else if (type === 'all') {
                startInput.value = '';
                endInput.value   = '';
            }
        }

        function openEditTransaksi(id, tanggal, jenis, nominal, keterangan) {
            document.getElementById('editTransaksiId').value = id;
            document.getElementById('editTanggalTransaksi').value = tanggal;
            document.getElementById('editNominalTransaksi').value = nominal;
            document.getElementById('editKeteranganTransaksi').value = keterangan;

            if (jenis === 'pemasukan') {
                document.getElementById('editJenisPemasukan').checked = true;
            } else {
                document.getElementById('editJenisPengeluaran').checked = true;
            }

            const form = document.getElementById('formEditTransaksi');
            form.action = '{{ url('/admin/keuangan') }}/' + id + '/update';

            const formHapus = document.getElementById('formHapusTransaksi');
            formHapus.action = '{{ url('/admin/keuangan') }}/' + id + '/delete';

            openModal('modalEditTransaksi');
        }

        function konfirmasiHapusTransaksi() {
            const deskripsi = document.getElementById('editDeskripsi')?.value || 'Transaksi Keuangan';
            const deskripsiEl = document.getElementById('konfirmDeskripsiTransaksi');
            if (deskripsiEl) {
                deskripsiEl.textContent = `"${deskripsi}"`;
            }
            openModal('modalKonfirmasiHapusTransaksi');
        }

        function eksekusiHapusTransaksi() {
            document.getElementById('formHapusTransaksi').submit();
        }
    </script>

    @include('components.logout-modal')
</body>
</html>
