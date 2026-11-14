<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian - Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    {{ $siswa->nama_cabang ?? 'Gajah Depa' }}
                </h2>
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

                <!-- Penilaian (Active) -->
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

        <!-- Sidebar Footer -->
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

        <!-- Header Page & Filter Bulan -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Penilaian</h1>
                <p class="text-sm text-slate-500 mt-1">Penilaian dari pelatih untuk {{ $siswa->nama ?? 'Ahmad Rizki' }}
                </p>
            </div>

            <!-- Filter Bulan & Tahun untuk Progres Bulanan -->
            <form action="{{ route('parents.penilaian_anak') }}" method="GET" class="flex items-center gap-2 shrink-0">
                <div class="relative">
                    <select name="bulan" onchange="this.form.submit()"
                        class="bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-4 py-2.5 pr-8 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer shadow-xs">
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
                        class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                </div>

                <div class="relative">
                    <select name="tahun" onchange="this.form.submit()"
                        class="bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-4 py-2.5 pr-8 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer shadow-xs">
                        @foreach($listTahun ?? [date('Y')] as $thn)
                            <option value="{{ $thn }}" {{ ($tahun ?? date('Y')) == $thn ? 'selected' : '' }}>{{ $thn }}
                            </option>
                        @endforeach
                    </select>
                    <i
                        class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                </div>
            </form>
        </div>

        <!-- 3 Summary Cards Row -->
        <div class="grid grid-cols-3 gap-3 md:gap-6 mb-8">

            <!-- Card 1: Total Penilaian -->
            <div
                class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-sky-400 border-2 flex flex-col items-center justify-center text-center">
                <div class="text-2xl sm:text-4xl font-extrabold text-[#00a5ec] mb-1">{{ $totalPenilaian }}</div>
                <div class="text-xs sm:text-sm font-bold text-slate-700">Total Penilaian</div>
                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate max-w-full">dari pelatih</div>
            </div>

            <!-- Card 2: Rata-rata Nilai -->
            <div
                class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-amber-400 border-2 flex flex-col items-center justify-center text-center">
                <div class="text-2xl sm:text-4xl font-extrabold text-amber-500 mb-1">{{ $rataRataNilai }}</div>
                <div class="text-xs sm:text-sm font-bold text-slate-700">Rata-rata Nilai</div>
                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5">dari skala 5</div>
            </div>

            <!-- Card 3: Persentase Progres Penilaian Per Bulan -->
            <div
                class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-emerald-400 border-2 flex flex-col items-center justify-center text-center">
                <div class="text-2xl sm:text-4xl font-extrabold text-emerald-500 mb-1">{{ $progresNilaiPersen ?? 0 }}%
                </div>
                <div class="text-xs sm:text-sm font-bold text-slate-700">Progres Penilaian</div>
                <div class="text-[11px] sm:text-xs text-slate-400 mt-0.5 truncate max-w-full">
                    @if(($totalPenilaianBulanIni ?? 0) > 0)
                        Rata-rata {{ $avgScoreBulanIni }}/5 · {{ $namaBulan ?? 'Bulan Ini' }}
                    @else
                        Bulan {{ $namaBulan ?? 'Ini' }} {{ $tahun ?? '' }}
                    @endif
                </div>
            </div>

        </div>

        <!-- Progres Setiap Gaya & Best Time Section -->
        @if(!empty($progresGayaList) && count($progresGayaList) > 0)
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-person-swimming text-[#00a5ec]"></i>
                            <span>Progres Setiap Gaya & Best Time</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Rekapitulasi progres nilai dan catatan waktu tercepat (Best
                            Time) untuk setiap gaya renang yang diperoleh {{ $siswa->nama ?? 'Ahmad Rizki' }}</p>
                    </div>
                </div>

                <div class="flex flex-nowrap overflow-x-auto pb-2 gap-4 snap-x snap-mandatory scroll-smooth no-scrollbar">
                    @foreach($progresGayaList as $gItem)
                        <div
                            class="w-[82%] sm:w-[46%] lg:w-[calc(25%-12px)] shrink-0 snap-start rounded-2xl border border-slate-200/80 bg-[#f8fbff] p-4 sm:p-5 flex flex-col justify-between hover:border-sky-300 transition shadow-2xs">
                            <div>
                                <!-- Top Row: Gaya Name & Sesi Count + Best Time Badge -->
                                <div class="flex items-start justify-between gap-2 mb-4">
                                    <div>
                                        <h4 class="font-extrabold text-[#093c56] text-sm sm:text-base leading-tight">
                                            {{ $gItem->gaya }}
                                        </h4>
                                        <span class="text-[11px] text-slate-400 font-medium">
                                            {{ $gItem->total_sesi > 0 ? $gItem->total_sesi . ' sesi dinilai' : 'Belum ada penilaian' }}
                                        </span>
                                    </div>
                                    <div class="px-2.5 py-1 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center gap-1.5 shrink-0"
                                        title="Catatan Waktu Tercepat (Best Time)">
                                        <i class="fa-solid fa-stopwatch text-amber-500 text-xs"></i>
                                        <div class="text-right">
                                            <span
                                                class="block text-[9px] font-bold uppercase tracking-wider text-amber-500 leading-none">Best
                                                Time</span>
                                            <span
                                                class="font-extrabold text-xs text-amber-900 leading-tight">{{ !empty($gItem->best_time) ? $gItem->best_time : 'Belum ada' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Row: Progress Percentage & Progress Bar -->
                                <div>
                                    <div class="flex items-baseline justify-between mb-1.5">
                                        <span class="text-xs font-semibold text-slate-500">Progres Penguasaan</span>
                                        <div class="flex items-baseline gap-1.5">
                                            <span
                                                class="text-xl font-black {{ $gItem->total_sesi > 0 ? 'text-[#00a5ec]' : 'text-slate-400' }}">{{ $gItem->progres_persen }}%</span>
                                            <span
                                                class="text-[11px] font-semibold text-slate-400">({{ $gItem->rata_rata }}/5)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-200/70 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-[#00b4db] to-[#0083b0] h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $gItem->progres_persen }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- List of Sessions Cards -->
        <div class="space-y-6">
            @forelse($penilaianList as $item)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative">

                    <!-- Top Info Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span
                                    class="inline-block px-3 py-1 bg-sky-100 text-[#00a5ec] font-semibold text-xs rounded-full">
                                    {{ $item->sesi }}
                                </span>
                                @if(!empty($item->gaya_renang))
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-cyan-50 text-[#008cc9] border border-cyan-200 font-semibold text-xs rounded-full">
                                        <i class="fa-solid fa-person-swimming text-[10px]"></i>
                                        <span>{{ $item->gaya_renang }}</span>
                                    </span>
                                @endif
                                @if(!empty($item->catatan_waktu) && $item->catatan_waktu !== '00:00.00')
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 font-bold text-xs rounded-full">
                                        <i class="fa-solid fa-stopwatch text-amber-500 text-[10px]"></i>
                                        <span>{{ $item->catatan_waktu }}</span>
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">{{ $item->tanggal }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">oleh {{ $item->pelatih }}</p>
                        </div>

                        <div class="text-left sm:text-right">
                            <span class="text-xs text-slate-400 block">Rata-rata</span>
                            <div class="text-2xl font-extrabold text-[#00a5ec]">
                                {{ $item->rata_rata }} <span class="text-xs font-normal text-slate-400">/5</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Rating Breakdown Subcards -->
                    <div class="grid grid-cols-3 gap-2.5 md:gap-4 mb-5">

                        <!-- 1. Teknik -->
                        <div class="bg-[#f0f9ff] rounded-2xl p-3 sm:p-4 text-center border border-sky-100">
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block mb-1">Teknik</span>
                            <div class="text-xl sm:text-2xl font-extrabold text-[#00a5ec] mb-2">{{ $item->teknik }}</div>
                            <!-- Dots indicator (5 dots) -->
                            <div class="flex justify-center gap-1 sm:gap-1.5">
                                @for($d = 1; $d <= 5; $d++)
                                    <span
                                        class="w-2 h-2 sm:w-3 sm:h-3 rounded-full {{ $d <= $item->teknik ? 'bg-[#00a5ec]' : 'bg-slate-200' }}"></span>
                                @endfor
                            </div>
                        </div>

                        <!-- 2. Kecepatan -->
                        <div class="bg-[#ecfdf5] rounded-2xl p-3 sm:p-4 text-center border border-emerald-100">
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block mb-1">Kecepatan</span>
                            <div class="text-xl sm:text-2xl font-extrabold text-emerald-600 mb-2">{{ $item->kecepatan }}
                            </div>
                            <!-- Dots indicator (5 dots) -->
                            <div class="flex justify-center gap-1 sm:gap-1.5">
                                @for($d = 1; $d <= 5; $d++)
                                    <span
                                        class="w-2 h-2 sm:w-3 sm:h-3 rounded-full {{ $d <= $item->kecepatan ? 'bg-emerald-500' : 'bg-slate-200' }}"></span>
                                @endfor
                            </div>
                        </div>

                        <!-- 3. Ketahanan -->
                        <div class="bg-[#fffbeb] rounded-2xl p-3 sm:p-4 text-center border border-amber-100">
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block mb-1">Ketahanan</span>
                            <div class="text-xl sm:text-2xl font-extrabold text-amber-500 mb-2">{{ $item->ketahanan }}</div>
                            <!-- Dots indicator (5 dots) -->
                            <div class="flex justify-center gap-1 sm:gap-1.5">
                                @for($d = 1; $d <= 5; $d++)
                                    <span
                                        class="w-2 h-2 sm:w-3 sm:h-3 rounded-full {{ $d <= $item->ketahanan ? 'bg-amber-400' : 'bg-slate-200' }}"></span>
                                @endfor
                            </div>
                        </div>

                    </div>

                    <!-- Comment/Note Box -->
                    <div class="bg-sky-50/70 border border-sky-100 rounded-xl p-4 mb-5">
                        <p class="text-xs text-slate-700 italic font-medium">
                            "{{ $item->catatan }}"
                        </p>
                    </div>

                    <!-- Bagikan Penilaian Button -->
                    <button type="button"
                        onclick="shareStory('{{ $siswa->nama ?? 'Ahmad Rizki' }}', '{{ $item->sesi }}', '{{ $item->tanggal }}', '{{ $item->rata_rata }}', '{{ $item->teknik }}', '{{ $item->kecepatan }}', '{{ $item->ketahanan }}', '{{ addslashes($item->catatan) }}')"
                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-[#00b4db] to-[#0083b0] hover:from-[#00a0c4] hover:to-[#007198] text-white text-xs font-bold shadow-md transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-share-nodes text-sm"></i>
                        <span>Bagikan Penilaian</span>
                    </button>

                </div>
            @empty
                <div class="bg-white rounded-3xl p-8 sm:p-14 text-center border border-slate-100 shadow-xs">
                    <div
                        class="w-16 h-16 rounded-2xl bg-sky-50 text-[#00a5ec] flex items-center justify-center text-2xl mx-auto mb-4 border border-sky-100 shadow-2xs">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Belum Ada Riwayat Penilaian</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1.5 max-w-md mx-auto">
                        Pelatih belum menginput penilaian latihan untuk {{ $siswa->nama ?? 'anak Anda' }}. Penilaian akan
                        otomatis tampil di sini setelah pelatih mencatat hasil evaluasi sesi latihan.
                    </p>
                </div>
            @endforelse
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
                <div
                    class="w-14 h-14 rounded-full bg-amber-400 text-amber-950 font-black text-lg flex items-center justify-center shrink-0 shadow-sm overflow-hidden border border-amber-300">
                    @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                        <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama ?? 'Foto Anak' }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($siswa->nama ?? 'AR', 0, 2)) }}
                    @endif
                </div>
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
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->sekolah ?? 'SDN 01 Kemang' }}</span>
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

    <!-- Instagram Story Modal Preview -->
    <div id="storyModal"
        class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
        <div class="flex flex-col items-center w-full max-w-[340px] my-auto">

            <!-- Top Bar Controls (Close) -->
            <div class="w-full flex items-center justify-between mb-2.5 px-1">
                <span class="text-xs font-bold text-white/90 tracking-wide flex items-center gap-1.5">
                    <i class="fa-brands fa-instagram text-sm"></i> Penilaian harian
                </span>
                <button onclick="closeStoryModal()"
                    class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- 9:16 IG Story Card Canvas Preview -->
            <div id="storyCardPreview"
                class="w-full aspect-[9/16] rounded-3xl overflow-hidden shadow-2xl relative border border-white/25 flex flex-col items-center justify-between p-6 text-center text-white select-none bg-gradient-to-b from-[#00b4db] to-[#0083b0]">

                <!-- Custom Photo Background Layer -->
                <img id="storyBgImage" src="" alt="" class="hidden absolute inset-0 w-full h-full object-cover z-0">
                <div id="storyBgOverlay"
                    class="hidden absolute inset-0 bg-gradient-to-b from-[#0083b0]/50 via-[#093c56]/55 to-[#093c56]/70 z-0">
                </div>

                <!-- Decorative Dot Pattern (Matching Landing Page) -->
                <div
                    class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none z-0">
                </div>

                <!-- Top Brand Header -->
                <div class="relative z-10 flex flex-col items-center pt-2">
                    <div
                        class="w-16 h-16 rounded-full overflow-hidden border-2 border-amber-300 shadow-lg mb-2.5 bg-gradient-to-tr from-amber-400 to-yellow-300 flex items-center justify-center text-blue-950 font-black">
                        @if(file_exists(public_path('images/logo.jpg')))
                            <img id="storyLogoImg" src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa"
                                class="w-full h-full object-cover" crossorigin="anonymous">
                        @else
                            <span>GD</span>
                        @endif
                    </div>
                    <h4 id="storyCabangTitle"
                        class="font-extrabold text-sm tracking-wide text-white uppercase drop-shadow-xs px-2 leading-snug">
                        {{ $siswa->nama_cabang ?? 'Gajah Depa Akuatik' }}
                    </h4>
                </div>

                <!-- Bottom Footer -->
                <div class="relative z-10 pb-1">
                    <p class="text-[11px] text-cyan-50 font-semibold tracking-wide opacity-90">gajahdepaakuatik.my.id
                    </p>
                </div>
            </div>

            <!-- Action Buttons Below 9:16 Card (Upload Background Photo & Save) -->
            <div class="w-full mt-3 space-y-2">
                <div class="flex items-center gap-2">
                    <label for="storyPhotoInput"
                        class="flex-1 py-2.5 px-3 bg-white/15 hover:bg-white/25 text-white border border-white/20 rounded-xl font-semibold text-xs cursor-pointer transition flex items-center justify-center gap-2">
                        <i class="fa-regular fa-image"></i>
                        <span id="storyPhotoLabel">Tambah Latar Foto</span>
                    </label>
                    <input type="file" id="storyPhotoInput" accept="image/*" class="hidden"
                        onchange="handleStoryBgUpload(event)">
                    <button type="button" id="resetStoryBgBtn" onclick="resetStoryBg()"
                        class="hidden py-2.5 px-3 bg-rose-500/80 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition"
                        title="Hapus Latar Foto">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>

                <button type="button" onclick="downloadOrShareStory()"
                    class="w-full py-3 bg-[#008cc9] hover:bg-[#0077ad] text-white rounded-xl font-bold text-xs tracking-wider uppercase shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-download"></i>
                    <span>Simpan</span>
                </button>
            </div>

        </div>
    </div>

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan"
        class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Mobile Sidebar & Modal Helper Script -->
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

        let customStoryBgDataUrl = null;

        function shareStory(nama, sesi, tanggal, avg, teknik, kecepatan, ketahanan, note) {
            document.getElementById('storyNama').innerText = nama;
            document.getElementById('storySesi').innerText = sesi;
            document.getElementById('storyTanggal').innerText = tanggal;
            document.getElementById('storyScore').innerText = avg + ' / 5';
            document.getElementById('storyTeknik').innerText = teknik;
            document.getElementById('storyKecepatan').innerText = kecepatan;
            document.getElementById('storyKetahanan').innerText = ketahanan;
            document.getElementById('storyNote').innerText = '"' + note + '"';
            document.getElementById('storyModal').classList.remove('hidden');
        }

        function closeStoryModal() {
            document.getElementById('storyModal').classList.add('hidden');
        }

        function handleStoryBgUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                customStoryBgDataUrl = e.target.result;
                const bgImg = document.getElementById('storyBgImage');
                const bgOverlay = document.getElementById('storyBgOverlay');
                bgImg.src = customStoryBgDataUrl;
                bgImg.classList.remove('hidden');
                bgOverlay.classList.remove('hidden');
                document.getElementById('storyPhotoLabel').innerText = 'Ganti Latar Foto';
                document.getElementById('resetStoryBgBtn').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function resetStoryBg() {
            customStoryBgDataUrl = null;
            const bgImg = document.getElementById('storyBgImage');
            const bgOverlay = document.getElementById('storyBgOverlay');
            bgImg.src = '';
            bgImg.classList.add('hidden');
            bgOverlay.classList.add('hidden');
            document.getElementById('storyPhotoInput').value = '';
            document.getElementById('storyPhotoLabel').innerText = 'Tambah Latar Foto';
            document.getElementById('resetStoryBgBtn').classList.add('hidden');
        }

        function drawRoundedRect(ctx, x, y, width, height, radius) {
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

        function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
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

        async function downloadOrShareStory() {
            const canvas = document.createElement('canvas');
            const W = 1080;
            const H = 1920;
            canvas.width = W;
            canvas.height = H;
            const ctx = canvas.getContext('2d');

            // 1. Background (Custom Photo or Landing Page Blue Gradient)
            if (customStoryBgDataUrl) {
                const bgImg = new Image();
                bgImg.src = customStoryBgDataUrl;
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
            const logoEl = document.getElementById('storyLogoImg');
            const logoY = 210;
            const logoR = 95;
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
                ctx.font = '900 56px Inter, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('GD', W / 2, logoY + 20);
            }

            const cabangTitle = (document.getElementById('storyCabangTitle')?.innerText || 'GAJAH DEPA AKUATIK').toUpperCase();
            ctx.fillStyle = '#ffffff';
            ctx.font = '800 38px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(cabangTitle, W / 2, logoY + logoR + 65);

            // 3. Center Glass Card
            const cardX = 90;
            const cardY = 480;
            const cardW = W - 180;
            const cardH = 1120;

            ctx.fillStyle = 'rgba(255, 255, 255, 0.06)';
            drawRoundedRect(ctx, cardX, cardY, cardW, cardH, 48);
            ctx.fill();
            ctx.lineWidth = 3;
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.25)';
            ctx.stroke();

            // Sesi Badge
            const sesiText = document.getElementById('storySesi').innerText;
            ctx.fillStyle = '#fbbf24';
            drawRoundedRect(ctx, W / 2 - 120, cardY + 65, 240, 68, 34);
            ctx.fill();
            ctx.fillStyle = '#451a03';
            ctx.font = '800 32px Inter, sans-serif';
            ctx.fillText(sesiText, W / 2, cardY + 110);

            // Nama Siswa & Tanggal
            const namaText = document.getElementById('storyNama').innerText;
            const tanggalText = document.getElementById('storyTanggal').innerText;
            ctx.fillStyle = '#ffffff';
            ctx.font = '800 62px Inter, sans-serif';
            ctx.fillText(namaText, W / 2, cardY + 230);

            ctx.fillStyle = '#e0f2fe';
            ctx.font = '500 32px Inter, sans-serif';
            ctx.fillText(tanggalText, W / 2, cardY + 290);

            // Rata-rata Nilai
            ctx.fillStyle = '#bae6fd';
            ctx.font = '600 30px Inter, sans-serif';
            ctx.fillText('Rata-rata Nilai', W / 2, cardY + 385);

            const scoreText = document.getElementById('storyScore').innerText;
            ctx.fillStyle = '#fde047';
            ctx.font = '900 115px Inter, sans-serif';
            ctx.fillText(scoreText, W / 2, cardY + 505);

            // 3 Subcards (Teknik, Kecepatan, Ketahanan)
            const boxW = 240;
            const boxH = 190;
            const gap = 30;
            const startX = (W - (boxW * 3 + gap * 2)) / 2;
            const boxY = cardY + 580;

            const items = [
                { label: 'Teknik', val: document.getElementById('storyTeknik').innerText, color: '#ffffff' },
                { label: 'Kecepatan', val: document.getElementById('storyKecepatan').innerText, color: '#6ee7b7' },
                { label: 'Ketahanan', val: document.getElementById('storyKetahanan').innerText, color: '#fde047' }
            ];

            items.forEach((it, idx) => {
                const bx = startX + idx * (boxW + gap);
                ctx.fillStyle = 'rgba(255, 255, 255, 0.07)';
                drawRoundedRect(ctx, bx, boxY, boxW, boxH, 32);
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.22)';
                ctx.stroke();

                ctx.fillStyle = '#e0f2fe';
                ctx.font = '600 28px Inter, sans-serif';
                ctx.fillText(it.label, bx + boxW / 2, boxY + 65);

                ctx.fillStyle = it.color;
                ctx.font = '800 56px Inter, sans-serif';
                ctx.fillText(it.val, bx + boxW / 2, boxY + 145);
            });

            // Divider line
            ctx.beginPath();
            ctx.moveTo(cardX + 70, cardY + 840);
            ctx.lineTo(cardX + cardW - 70, cardY + 840);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.22)';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Coach Note
            const noteText = document.getElementById('storyNote').innerText;
            ctx.fillStyle = '#ffffff';
            ctx.font = 'italic 500 34px Inter, sans-serif';
            wrapText(ctx, noteText, W / 2, cardY + 915, cardW - 140, 48);

            // Footer URL
            ctx.fillStyle = 'rgba(224, 242, 254, 0.9)';
            ctx.font = '600 32px Inter, sans-serif';
            ctx.fillText('gajahdepaakuatik.my.id', W / 2, H - 120);

            // Download PNG
            const link = document.createElement('a');
            const safeName = namaText.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const safeSesi = sesiText.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            link.download = `story-penilaian-${safeName}-${safeSesi}.png`;
            link.href = canvas.toDataURL('image/png');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

    @include('components.logout-modal')
</body>

</html>