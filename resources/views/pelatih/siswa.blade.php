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
    <title>Siswa Pelatih - Gajah Depa Swimming Club</title>
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

        @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="text-sm font-bold">Terdapat kesalahan pengisian:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-600">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Header Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-[#008cc9] tracking-tight">Siswa — Cabang {{ $namaCabang }}</h1>
            <p class="text-slate-500 text-sm mt-1">{{ $siswaList->count() }} siswa terdaftar di cabang ini</p>
        </div>

        <!-- Sub Navigation Tabs (Data Siswa | Absensi Siswa | Penilaian Siswa) -->
        <div class="flex flex-wrap items-center gap-2 mb-4 bg-sky-50/50 p-1.5 rounded-2xl border border-sky-100 max-w-full sm:max-w-fit">
            <!-- Tab 1: Data Siswa -->
            <a href="{{ route('pelatih.siswa', array_merge(request()->query(), ['tab' => 'data_siswa'])) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2.5 transition {{ $activeTab === 'data_siswa' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-transparent text-slate-600 hover:bg-white/60' }}">
                <i class="fa-solid fa-users text-sm"></i>
                <span>Data Siswa</span>
            </a>

            <!-- Tab 2: Absensi Siswa -->
            <a href="{{ route('pelatih.siswa', array_merge(request()->query(), ['tab' => 'absensi_siswa'])) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2.5 transition {{ $activeTab === 'absensi_siswa' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-transparent text-slate-600 hover:bg-white/60' }}">
                <i class="fa-regular fa-calendar-check text-sm"></i>
                <span>Absensi Siswa</span>
            </a>

            <!-- Tab 3: Penilaian Siswa -->
            <a href="{{ route('pelatih.siswa', array_merge(request()->query(), ['tab' => 'penilaian_siswa'])) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2.5 transition {{ $activeTab === 'penilaian_siswa' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-transparent text-slate-600 hover:bg-white/60' }}">
                <i class="fa-solid fa-star text-sm"></i>
                <span>Penilaian Siswa</span>
            </a>
        </div>

        <!-- Filter Kelas Pills Bar -->
        <div class="flex items-center gap-2 mb-8 overflow-x-auto pb-1">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-2 shrink-0 flex items-center gap-1.5">
                <i class="fa-solid fa-layer-group text-slate-400"></i>
                <span>Kelas:</span>
            </span>
            <a href="{{ route('pelatih.siswa', array_merge(request()->query(), ['id_kelas' => 'semua'])) }}" 
               class="px-4 py-1.5 rounded-xl text-xs font-semibold shrink-0 transition {{ empty($selectedKelasId) || $selectedKelasId === 'semua' ? 'bg-[#093c56] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Semua Kelas
            </a>
            @foreach($kelasList as $k)
                <a href="{{ route('pelatih.siswa', array_merge(request()->query(), ['id_kelas' => $k->id])) }}" 
                   class="px-4 py-1.5 rounded-xl text-xs font-semibold shrink-0 transition {{ ($selectedKelasId ?? '') == $k->id ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                    {{ $k->nama }}
                </a>
            @endforeach
        </div>

        <!-- TAB 1: DATA SISWA -->
        @if($activeTab === 'data_siswa')
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Daftar Siswa</h2>
                        <p class="text-xs text-slate-400 mt-0.5">
                            @if(!empty($search))
                                Hasil pencarian: <span class="font-bold text-[#00a5ec]">"{{ $search }}"</span> · 
                            @endif
                            Klik kartu siswa untuk melihat detail
                        </p>
                    </div>

                    <!-- Search Input Form -->
                    <form method="GET" action="{{ route('pelatih.siswa') }}" class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="hidden" name="tab" value="data_siswa">
                        @if(!empty($selectedKelasId) && $selectedKelasId !== 'semua')
                            <input type="hidden" name="id_kelas" value="{{ $selectedKelasId }}">
                        @endif

                        <div class="relative w-full sm:w-72">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            <input type="text" 
                                   id="searchSiswaInput"
                                   name="search" 
                                   value="{{ $search ?? '' }}" 
                                   placeholder="Cari nama siswa..." 
                                   autocomplete="off"
                                   class="w-full pl-9 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition shadow-2xs">
                            @if(!empty($search))
                                <a href="{{ route('pelatih.siswa', array_filter(['tab' => 'data_siswa', 'id_kelas' => $selectedKelasId])) }}" 
                                   title="Hapus pencarian"
                                   class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-slate-400 hover:text-rose-500 transition">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="space-y-4" id="siswaListContainer">
                    @forelse($siswaList as $siswa)
                        @php
                            $initials = strtoupper(substr($siswa->nama, 0, 2));
                            $formattedId = 'GD' . str_pad($siswa->id, 3, '0', STR_PAD_LEFT);
                            $riwayatAbsensi = isset($absensi_per_siswa) ? $absensi_per_siswa->get($siswa->id, collect([])) : collect([]);
                            $riwayatPencapaian = isset($pencapaian_per_siswa) ? $pencapaian_per_siswa->get($siswa->id, collect([])) : collect([]);

                            $jmlHadir = $riwayatAbsensi->where('status_kehadiran', 'hadir')->count();
                            $jmlIzin  = $riwayatAbsensi->where('status_kehadiran', 'izin')->count();
                            $jmlSakit = $riwayatAbsensi->where('status_kehadiran', 'sakit')->count();
                            $jmlAlpha = $riwayatAbsensi->where('status_kehadiran', 'tidak_hadir')->count();
                            $totalSesi = $riwayatAbsensi->count();
                            $persenHadir = $totalSesi > 0 ? round(($jmlHadir / $totalSesi) * 100) : 0;

                            $siswaDetailPayload = [
                                'id'                      => $siswa->id,
                                'formatted_id'            => $formattedId,
                                'nama'                    => $siswa->nama,
                                'tempat_lahir'            => $siswa->tempat_lahir ?? '-',
                                'tanggal_lahir_raw'       => $siswa->tanggal_lahir ?? '',
                                'tanggal_lahir_formatted' => $siswa->tanggal_lahir ? date('d/m/Y', strtotime($siswa->tanggal_lahir)) : '-',
                                'umur'                    => $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->age : null,
                                'jenis_kelamin'           => $siswa->jenis_kelamin ?? 'laki-laki',
                                'tingkat_kelas'           => $siswa->tingkat_kelas ?? $siswa->nama_kelas ?? 'Pemula A',
                                'sekolah'                 => $siswa->sekolah ?? '-',
                                'tanggal_masuk_formatted' => !empty($siswa->tanggal_masuk) ? date('d/m/Y', strtotime($siswa->tanggal_masuk)) : '-',
                                'riwayat_penyakit'        => !empty($siswa->riwayat_penyakit) ? $siswa->riwayat_penyakit : '-',
                                'catatan_khusus'          => !empty($siswa->catatan_khusus) ? $siswa->catatan_khusus : '-',
                                'nama_kelas'              => $siswa->nama_kelas ?? 'Pemula A',
                                'nama_cabang'             => $siswa->nama_cabang ?? $namaCabang ?? '-',
                                'foto'                    => (!empty($siswa->foto) && file_exists(public_path($siswa->foto))) ? asset($siswa->foto) : null,
                                'orang_tua'               => [
                                    'nama'   => $siswa->nama_parent ?? '-',
                                    'email'  => $siswa->email_parent ?? '-',
                                    'no_hp'  => $siswa->no_hp_parent ?? '-',
                                    'alamat' => $siswa->alamat_parent ?? '-',
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
                                    'nama_pelatih'  => $p->nama_pelatih ?? null,
                                ])->values(),
                            ];
                        @endphp
                        <div onclick="openDetailSiswa({{ json_encode($siswaDetailPayload) }})"
                             class="siswa-card p-4 rounded-2xl border border-slate-100 hover:border-sky-200 bg-white hover:bg-sky-50/30 hover:shadow-xs transition cursor-pointer group flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                             data-nama-siswa="{{ strtolower($siswa->nama) }}">
                            <div class="flex items-center gap-4">
                                <!-- Avatar Circle -->
                                @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                                    <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama }}" class="w-12 h-12 rounded-full object-cover border border-slate-200 shadow-xs shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-[#00a5ec] text-white font-bold text-base flex items-center justify-center shadow-xs shrink-0">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div>
                                    <div class="flex items-center gap-2.5">
                                        <h4 class="font-bold text-slate-800 group-hover:text-[#008cc9] transition text-base">{{ $siswa->nama }}</h4>
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-full text-xs font-semibold">
                                            Aktif
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1 font-medium">
                                        ID: <span class="text-[#00a5ec] font-semibold">{{ $formattedId }}</span> · {{ $siswa->tingkat_kelas ?? $siswa->nama_kelas ?? 'Pemula A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Parent Info -->
                            <div class="text-left sm:text-right flex sm:block items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-slate-500">Orang tua: {{ $siswa->nama_parent ?? 'Orang Tua' }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $siswa->no_hp_parent ?? '0812-1111-2222' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400">
                            @if(!empty($search))
                                Tidak ada siswa dengan nama "<span class="font-bold text-slate-600">{{ $search }}</span>".
                            @else
                                Belum ada siswa terdaftar di cabang ini.
                            @endif
                        </div>
                    @endforelse

                    <!-- Empty state for client-side live search -->
                    <div id="clientSearchEmptyState" class="hidden p-8 text-center text-slate-400">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-300 flex items-center justify-center text-xl mx-auto mb-2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Tidak ada siswa yang cocok</p>
                        <p class="text-xs text-slate-400 mt-0.5">Coba gunakan kata kunci pencarian yang lain.</p>
                    </div>
                </div>
            </div>

        <!-- TAB 2: ABSENSI SISWA -->
        @elseif($activeTab === 'absensi_siswa')
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <!-- Header Control Bar -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Absensi Siswa</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Cabang {{ $namaCabang }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('pelatih.siswa') }}" class="flex flex-wrap items-center gap-2">
                            <input type="hidden" name="tab" value="absensi_siswa">
                            @if(!empty($selectedKelasId) && $selectedKelasId !== 'semua')
                                <input type="hidden" name="id_kelas" value="{{ $selectedKelasId }}">
                            @endif

                            <select name="bulan" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer">
                                @foreach([
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ] as $key => $namaBulan)
                                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                @endforeach
                            </select>
                            <select name="tahun" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer">
                                @foreach($listTahun ?? [date('Y')] as $thn)
                                    <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </form>

                        <button onclick="openModal('inputAbsensiModal')" class="px-4 py-2 bg-[#00a5ec] hover:bg-[#008cc9] text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-2">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Input Absensi per Kelas</span>
                        </button>
                    </div>
                </div>

                <!-- Grafik Kehadiran Siswa -->
                <div class="mb-8 p-4 bg-slate-50/50 rounded-2xl border border-slate-100">
                    <p class="text-xs font-medium text-slate-400 mb-3">
                        @if(!empty($tanggal))
                            Grafik kehadiran — <span class="font-bold text-[#00a5ec]">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</span>
                        @else
                            Grafik kehadiran — {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
                        @endif
                    </p>
                    <div class="h-48 w-full">
                        @if(count($absensiChartDates) > 0)
                            <canvas id="absensiSiswaChart"></canvas>
                        @else
                            <div class="h-full flex flex-col items-center justify-center text-slate-400 py-6">
                                <i class="fa-regular fa-calendar-xmark text-3xl mb-1.5 text-slate-300"></i>
                                <p class="text-xs font-medium">
                                    @if(!empty($tanggal))
                                        Tidak ada data kehadiran siswa pada tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}.
                                    @else
                                        Tidak ada data kehadiran siswa pada periode {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Section: Tabel Riwayat Absensi Siswa -->
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Riwayat Absensi Siswa</h3>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Menampilkan seluruh absensi bulan {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
                            </p>
                        </div>

                        <!-- Filter Cari, Bulan & Tahun pada Tabel -->
                        <form method="GET" action="{{ route('pelatih.siswa') }}" class="flex flex-wrap items-center gap-2">
                            <input type="hidden" name="tab" value="absensi_siswa">
                            @if(!empty($selectedKelasId) && $selectedKelasId !== 'semua')
                                <input type="hidden" name="id_kelas" value="{{ $selectedKelasId }}">
                            @endif

                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text"
                                       id="searchRiwayatAbsensiInput"
                                       name="search_absensi"
                                       value="{{ $searchAbsensi ?? '' }}"
                                       oninput="filterRiwayatAbsensiTable(this.value)"
                                       placeholder="Cari nama siswa / kelas..."
                                       class="pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]/20 focus:border-[#00a5ec] w-48 sm:w-56 transition">
                            </div>

                            <select name="bulan" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer">
                                @foreach([
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ] as $key => $namaBulan)
                                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                @endforeach
                            </select>
                            <select name="tahun" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer">
                                @foreach($listTahun ?? [date('Y')] as $thn)
                                    <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="overflow-x-auto min-w-0">
                        <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500 text-sm font-semibold">
                                <th class="pb-3 px-4">Tanggal</th>
                                <th class="pb-3 px-4">Kelas</th>
                                <th class="pb-3 px-4">Nama Siswa</th>
                                <th class="pb-3 px-4">Status</th>
                                <th class="pb-3 px-4">Keterangan</th>
                                <th class="pb-3 px-4 text-center">Aksi Penilaian</th>
                            </tr>
                        </thead>
                        <tbody id="riwayatAbsensiTbody" class="divide-y divide-slate-100 text-sm">
                            @forelse($absensiSiswaList as $abs)
                                <tr class="riwayat-absensi-row hover:bg-slate-50/80 transition"
                                    data-search="{{ strtolower(($abs->nama_siswa ?? '') . ' ' . ($abs->nama_kelas ?? '') . ' ' . ($abs->status_kehadiran ?? '') . ' ' . ($abs->keterangan ?? '')) }}">
                                    <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($abs->tanggal_kehadiran)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 bg-sky-50 text-sky-700 font-semibold rounded-lg text-xs border border-sky-100">
                                            {{ $abs->nama_kelas ?? 'Kelas' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        {{ $abs->nama_siswa }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if($abs->status_kehadiran === 'hadir')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-300">
                                                Hadir
                                            </span>
                                        @elseif($abs->status_kehadiran === 'izin')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-300">
                                                Izin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-500 border border-rose-300">
                                                Tidak Hadir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">
                                        {{ $abs->keterangan ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        @if($abs->status_kehadiran === 'hadir')
                                            @if(($abs->jumlah_penilaian ?? 0) > 0)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200" title="Siswa sudah dinilai pada sesi absensi ini">
                                                    <i class="fa-solid fa-check text-[11px]"></i> Sudah Dinilai
                                                </span>
                                            @else
                                                <button type="button" 
                                                        onclick="openTambahPenilaianModalWith({{ $abs->id_siswa }}, '{{ \Carbon\Carbon::parse($abs->tanggal_kehadiran)->format('Y-m-d') }}', {{ $abs->id_kelas ?? 'null' }})" 
                                                        class="px-3 py-1.5 bg-sky-50 text-[#00a5ec] hover:bg-[#00a5ec] hover:text-white rounded-xl text-xs font-semibold border border-sky-200 hover:border-[#00a5ec] transition inline-flex items-center gap-1.5 shadow-2xs">
                                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                                    <span>Beri Nilai</span>
                                                </button>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] text-slate-400 font-medium">
                                                <i class="fa-solid fa-ban text-[10px] text-slate-300"></i> Tidak Hadir
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        @if(!empty($tanggal))
                                            Tidak ada data absensi siswa pada tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}.
                                        @else
                                            Belum ada data absensi siswa pada filter ini.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                            <tr id="riwayatAbsensiEmptySearchRow" class="hidden">
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Tidak ada data absensi siswa yang cocok dengan pencarian Anda.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- TAB 3: PENILAIAN SISWA -->
        @elseif($activeTab === 'penilaian_siswa')
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <!-- Header Control Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Penilaian Siswa</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Penilaian teknik renang khusus bagi siswa yang telah tercatat Hadir pada absensi</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text"
                                   id="searchPenilaianSiswaInput"
                                   value="{{ $searchPenilaian ?? '' }}"
                                   oninput="filterPenilaianSiswaCards(this.value)"
                                   placeholder="Cari nama siswa / gaya..."
                                   class="pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]/20 focus:border-[#00a5ec] w-48 sm:w-56 transition">
                        </div>

                        <button onclick="openModal('tambahPenilaianModal')" class="px-4 py-2 bg-[#00a5ec] hover:bg-[#008cc9] text-white text-sm font-semibold rounded-xl shadow-xs transition flex items-center gap-2">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Tambah Penilaian</span>
                        </button>
                    </div>
                </div>

                <!-- Evaluasi List -->
                <div class="space-y-6">
                    @forelse($penilaianList as $pen)
                        @php
                            $avg = number_format(($pen->teknik + $pen->kecepatan + $pen->ketahanan) / 3.0, 1);
                            $tglYmd = \Carbon\Carbon::parse($pen->tanggal_catat)->format('Y-m-d');
                            $isOwner = empty($pen->id_pelatih) || ((int)($pen->id_pelatih ?? 0) === (int)($pelatihId ?? 0));
                        @endphp
                        <div class="penilaian-siswa-card p-6 rounded-2xl border border-slate-100 bg-white hover:shadow-xs transition"
                             data-search="{{ strtolower(($pen->nama_siswa ?? '') . ' ' . ($pen->nama_kelas ?? '') . ' ' . ($pen->gaya_renang ?? '') . ' ' . ($pen->nama_pelatih ?? '') . ' ' . ($pen->catatan ?? '')) }}">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <h3 class="text-lg font-bold text-slate-800">{{ $pen->nama_siswa }}</h3>
                                        <span class="px-2.5 py-0.5 bg-sky-50 text-[#008cc9] border border-sky-200 rounded-full text-xs font-semibold">{{ $pen->nama_kelas ?? 'Kelas Renang' }}</span>
                                        @if(!empty($pen->catatan_waktu))
                                            <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-semibold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-stopwatch text-[10px]"></i>
                                                {{ $pen->catatan_waktu }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400 mt-1">
                                        <span>{{ \Carbon\Carbon::parse($pen->tanggal_catat)->translatedFormat('d F Y') }} · {{ $pen->gaya_renang }}</span>
                                        <span>·</span>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-[#008cc9] border border-sky-100">
                                            <i class="fa-solid fa-user-check text-[10px]"></i>
                                            Dinilai oleh: {{ $pen->nama_pelatih ?? 'Pelatih' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-4">
                                    <div class="text-left sm:text-right">
                                        <p class="text-[11px] font-semibold text-slate-400">Rata-rata</p>
                                        <p class="text-2xl font-extrabold text-[#00a5ec] mt-0.5">{{ $avg }}</p>
                                    </div>
                                    <div class="flex items-center gap-1.5 border-l border-slate-100 pl-3">
                                        @if($isOwner)
                                            <button type="button"
                                                    onclick="openEditPenilaianModal({{ json_encode([
                                                        'id' => $pen->id,
                                                        'nama_siswa' => $pen->nama_siswa,
                                                        'nama_kelas' => $pen->nama_kelas ?? 'Kelas Renang',
                                                        'tanggal' => $tglYmd,
                                                        'gaya_renang' => $pen->gaya_renang,
                                                        'catatan_waktu' => $pen->catatan_waktu ?? '',
                                                        'teknik' => $pen->teknik,
                                                        'kecepatan' => $pen->kecepatan,
                                                        'ketahanan' => $pen->ketahanan,
                                                        'catatan' => $pen->catatan ?? '',
                                                    ]) }})"
                                                    title="Edit Penilaian"
                                                    class="px-2.5 py-1.5 bg-sky-50 hover:bg-sky-100 text-[#008cc9] border border-sky-200 rounded-xl text-xs font-semibold transition flex items-center gap-1.5">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Edit</span>
                                            </button>
                                            <button type="button"
                                                    onclick="openDeletePenilaianModal({{ $pen->id }}, {{ json_encode($pen->nama_siswa) }}, {{ json_encode($pen->gaya_renang . ' (' . \Carbon\Carbon::parse($pen->tanggal_catat)->translatedFormat('d M Y') . ')') }})"
                                                    title="Hapus Penilaian"
                                                    class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-xl text-xs font-semibold transition flex items-center gap-1.5">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Hapus</span>
                                            </button>
                                        @else
                                            <div class="px-2.5 py-1.5 bg-slate-100 text-slate-400 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-1.5 cursor-not-allowed" title="Dinilai oleh {{ $pen->nama_pelatih ?? 'pelatih lain' }}. Hanya beliau yang dapat mengedit/menghapus penilaian ini.">
                                                <i class="fa-solid fa-lock text-[10px]"></i>
                                                <span>Terkunci</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 3 Score Pillars -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                                <!-- Teknik -->
                                <div class="bg-sky-50/50 p-3.5 rounded-xl border border-sky-100 text-center">
                                    <p class="text-xs font-semibold text-slate-600 mb-1.5">Teknik</p>
                                    <div class="flex justify-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="w-3.5 h-3.5 rounded-full {{ $i <= $pen->teknik ? 'bg-[#00a5ec]' : 'bg-slate-200' }}"></span>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Kecepatan -->
                                <div class="bg-emerald-50/50 p-3.5 rounded-xl border border-emerald-100 text-center">
                                    <p class="text-xs font-semibold text-slate-600 mb-1.5">Kecepatan</p>
                                    <div class="flex justify-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="w-3.5 h-3.5 rounded-full {{ $i <= $pen->kecepatan ? 'bg-emerald-500' : 'bg-slate-200' }}"></span>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Ketahanan -->
                                <div class="bg-amber-50/50 p-3.5 rounded-xl border border-amber-100 text-center">
                                    <p class="text-xs font-semibold text-slate-600 mb-1.5">Ketahanan</p>
                                    <div class="flex justify-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="w-3.5 h-3.5 rounded-full {{ $i <= $pen->ketahanan ? 'bg-amber-400' : 'bg-slate-200' }}"></span>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan -->
                            @if($pen->catatan)
                                <p class="text-xs text-slate-500 italic bg-slate-50 p-3 rounded-xl">
                                    "{{ $pen->catatan }}"
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400">
                            Belum ada penilaian siswa.
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </main>

    <!-- MODAL 1: INPUT ABSENSI SISWA (Mockup 3) -->
    <div id="inputAbsensiModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-xl p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
            
            <button onclick="closeModal('inputAbsensiModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-[#008cc9]">Input Absensi Siswa</h3>
                <p class="text-slate-500 text-sm mt-1">Cabang {{ $namaCabang }} — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>

            <form action="{{ route('pelatih.siswa.absensi.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-1.5">Tanggal Absensi <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] font-medium">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-1.5">Pilih Kelas <span class="text-rose-500">*</span></label>
                        <select id="absensiKelasSelect" name="id_kelas" required onchange="filterAbsensiSiswaByKelas()" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] font-semibold">
                            <option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ ($selectedKelasId ?? '') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Info panduan pilih kelas -->
                <div id="absensiPromptPilihKelas" class="p-6 bg-sky-50/60 border border-dashed border-sky-200 rounded-2xl text-center">
                    <i class="fa-solid fa-chalkboard-user text-sky-400 text-2xl mb-2"></i>
                    <p class="text-sm font-bold text-slate-700">Pilih Kelas Terlebih Dahulu</p>
                    <p class="text-xs text-slate-500 mt-1">Silakan pilih kelas di atas terlebih dahulu untuk menampilkan daftar siswa yang akan diabsen.</p>
                </div>

                <!-- Alert kelas kosong -->
                <div id="absensiKelasKosongAlert" class="hidden p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center text-slate-500 text-xs">
                    <i class="fa-solid fa-users-slash text-slate-400 text-xl mb-1"></i>
                    <p>Tidak ada siswa yang terdaftar di kelas ini.</p>
                </div>

                <div id="absensiSiswaContainer" class="space-y-4 pt-2 hidden">
                    <div class="flex items-center justify-between gap-3 bg-sky-50/70 p-3.5 rounded-2xl border border-sky-100">
                        <div class="flex items-center gap-2">
                            <label class="block text-sm font-bold text-slate-800">Daftar Kehadiran Siswa</label>
                            <span id="absensiCountBadge" class="text-xs font-semibold px-2.5 py-0.5 bg-white text-sky-700 rounded-full border border-sky-200 shadow-2xs"></span>
                        </div>
                    </div>
                    
                    @foreach($allSiswaList as $siswa)
                        <div class="absensi-siswa-card p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-3" data-id-kelas="{{ $siswa->id_kelas }}">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold text-slate-800 text-sm">{{ $siswa->nama }}</h4>
                                <span class="text-xs px-2 py-0.5 bg-white border border-slate-200 rounded-md text-slate-500 font-medium">{{ $siswa->nama_kelas ?? 'Kelas' }}</span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Status</label>
                                    <select name="status_kehadiran[{{ $siswa->id }}]" class="absensi-input-status w-full px-3 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                                        <option value="hadir" selected>Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="tidak_hadir">Tidak Hadir</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Keterangan</label>
                                    <input type="text" name="keterangan[{{ $siswa->id }}]" placeholder="Opsional" class="absensi-input-keterangan w-full px-3 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('inputAbsensiModal')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSimpanAbsensi" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#00a5ec] rounded-xl hover:bg-[#008cc9] shadow-sm transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Simpan Absensi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: TAMBAH PENILAIAN SISWA (Mockup 5) -->
    <div id="tambahPenilaianModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
            
            <button onclick="closeModal('tambahPenilaianModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-[#008cc9]">Tambah Penilaian Siswa</h3>
                <p class="text-slate-500 text-sm mt-1">Cabang {{ $namaCabang }}</p>
            </div>

            <form action="{{ route('pelatih.siswa.penilaian.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Tanggal Latihan / Penilaian -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-sm font-semibold text-slate-800">Tanggal Latihan / Penilaian <span class="text-rose-500">*</span></label>
                        @if(!empty($latestHadirDate))
                            <button type="button" onclick="setTanggalPenilaian('{{ $latestHadirDate }}')" class="text-[11px] text-[#00a5ec] font-semibold hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-clock-rotate-left text-[10px]"></i>
                                <span>Gunakan sesi terakhir ({{ \Carbon\Carbon::parse($latestHadirDate)->translatedFormat('d M Y') }})</span>
                            </button>
                        @endif
                    </div>
                    <input type="date" id="penilaianTanggal" name="tanggal" value="{{ old('tanggal', $latestHadirDate ?? date('Y-m-d')) }}" required onchange="updateSiswaOptions()" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] font-medium">
                </div>

                <!-- Pilih Kelas -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Pilih Kelas <span class="text-rose-500">*</span></label>
                    <select id="penilaianKelasSelect" name="id_kelas" required onchange="onPenilaianKelasChanged()" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] font-semibold">
                        <option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ ($selectedKelasId ?? '') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Alert Belum Ada Siswa Hadir di Kelas Ini -->
                <div id="penilaianBelumAbsenAlert" class="hidden p-3.5 bg-amber-50 border border-amber-200 rounded-2xl text-amber-900 text-xs">
                    <div class="flex items-start gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-base mt-0.5 shrink-0"></i>
                        <div class="flex-1">
                            <p class="font-bold text-amber-800">Belum ada siswa kelas ini yang absen Hadir</p>
                            <p class="text-amber-700 mt-0.5">Siswa di kelas yang dipilih belum diabsen atau tidak berstatus hadir pada tanggal ini. Siswa harus absen terlebih dahulu sebelum dapat dinilai.</p>
                            <div class="mt-2.5 flex items-center gap-2">
                                <button type="button" onclick="switchToAbsensiModal()" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-calendar-check text-[10px]"></i>
                                    <span>Input Absensi Kelas Ini</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nama Siswa -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Nama Siswa <span class="text-rose-500">*</span></label>
                    <select id="penilaianSiswaSelect" name="id_siswa" required onchange="onSiswaSelected()" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>
                    </select>
                </div>

                <!-- Gaya Renang -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-sm font-semibold text-slate-800">Gaya Renang <span class="text-rose-500">*</span></label>
                        <button type="button" 
                                id="btnToggleGayaRenang" 
                                onclick="toggleGayaRenangManual()" 
                                class="text-xs text-[#00a5ec] font-semibold cursor-pointer hover:underline focus:outline-none">
                            Isi manual
                        </button>
                    </div>

                    <!-- Dropdown Pilihan Gaya Renang -->
                    <div id="gayaRenangSelectWrapper">
                        <select id="gayaRenangSelect" name="gaya_renang" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                            <option value="Gaya Bebas">Gaya Bebas</option>
                            <option value="Gaya Dada">Gaya Dada</option>
                            <option value="Gaya Punggung">Gaya Punggung</option>
                            <option value="Gaya Kupu-kupu">Gaya Kupu-kupu</option>
                            <option value="Gaya Ganti">Gaya Ganti</option>
                        </select>
                    </div>

                    <!-- Input Manual Text (Tersembunyi secara default) -->
                    <div id="gayaRenangManualWrapper" class="hidden">
                        <input type="text" 
                               id="gayaRenangManualInput" 
                               placeholder="Ketik gaya renang / materi khusus (contoh: Gaya Ganti, Drill Kaki)..." 
                               disabled 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                    </div>
                </div>

                <!-- Catatan Waktu (mm : ss . ms) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Catatan Waktu</label>
                    <div class="flex items-center gap-2 text-slate-400 font-bold">
                        <input type="text" name="waktu_mm" placeholder="mm" maxlength="2" class="w-16 text-center px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <span>:</span>
                        <input type="text" name="waktu_ss" placeholder="ss" maxlength="2" class="w-16 text-center px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <span>.</span>
                        <input type="text" name="waktu_ms" placeholder="ms" maxlength="2" class="w-16 text-center px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <span class="text-xs text-slate-400 font-normal ml-2">mm : ss . ms</span>
                    </div>
                </div>

                <!-- 3 Pillars (Teknik, Kecepatan, Ketahanan) -->
                <div class="grid grid-cols-3 gap-3 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Teknik (1–5)</label>
                        <select name="teknik" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-[#00a5ec]">
                            <option value="3" selected>3</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kecepatan (1–5)</label>
                        <select name="kecepatan" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-[#00a5ec]">
                            <option value="3" selected>3</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ketahanan (1–5)</label>
                        <select name="ketahanan" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-[#00a5ec]">
                            <option value="3" selected>3</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Catatan</label>
                    <textarea name="catatan" rows="2" placeholder="Catatan perkembangan siswa..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] resize-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('tambahPenilaianModal')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSimpanPenilaian" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#00a5ec] rounded-xl hover:bg-[#008cc9] shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: EDIT PENILAIAN SISWA -->
    <div id="editPenilaianModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('editPenilaianModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-[#008cc9]">Edit Penilaian Siswa</h3>
                <p id="editPenilaianSubtitle" class="text-slate-500 text-sm mt-1">Perbarui nilai perkembangan siswa</p>
            </div>

            <form id="editPenilaianForm" method="POST" class="space-y-4" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan penilaian siswa ini?')">
                @csrf
                <input type="hidden" name="filter_kelas" value="{{ $selectedKelasId ?? 'semua' }}">

                <!-- Info Siswa (Readonly) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Nama Siswa</label>
                    <input type="text" id="editPenilaianNamaSiswa" readonly class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 text-sm font-bold cursor-not-allowed">
                </div>

                <!-- Tanggal Latihan / Penilaian -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Tanggal Latihan / Penilaian <span class="text-rose-500">*</span></label>
                    <input type="date" id="editPenilaianTanggal" name="tanggal" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] font-medium">
                </div>

                <!-- Gaya Renang -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-sm font-semibold text-slate-800">Gaya Renang <span class="text-rose-500">*</span></label>
                        <button type="button"
                                id="btnToggleEditGayaRenang"
                                onclick="toggleEditGayaRenangManual()"
                                class="text-xs text-[#00a5ec] font-semibold cursor-pointer hover:underline focus:outline-none">
                            Isi manual
                        </button>
                    </div>

                    <div id="editGayaRenangSelectWrapper">
                        <select id="editGayaRenangSelect" name="gaya_renang" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                            <option value="Gaya Bebas">Gaya Bebas</option>
                            <option value="Gaya Dada">Gaya Dada</option>
                            <option value="Gaya Punggung">Gaya Punggung</option>
                            <option value="Gaya Kupu-kupu">Gaya Kupu-kupu</option>
                            <option value="Gaya Ganti">Gaya Ganti</option>
                        </select>
                    </div>

                    <div id="editGayaRenangManualWrapper" class="hidden">
                        <input type="text"
                               id="editGayaRenangManualInput"
                               placeholder="Ketik gaya renang / materi khusus..."
                               disabled
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec]">
                    </div>
                </div>

                <!-- Catatan Waktu (mm : ss . ms) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Catatan Waktu</label>
                    <div class="flex items-center gap-2 text-slate-400 font-bold">
                        <input type="text" id="editWaktuMm" name="waktu_mm" placeholder="mm" maxlength="2" class="w-16 text-center px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <span>:</span>
                        <input type="text" id="editWaktuSs" name="waktu_ss" placeholder="ss" maxlength="2" class="w-16 text-center px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <span>.</span>
                        <input type="text" id="editWaktuMs" name="waktu_ms" placeholder="ms" maxlength="2" class="w-16 text-center px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#00a5ec]">
                        <span class="text-xs text-slate-400 font-normal ml-2">mm : ss . ms</span>
                    </div>
                </div>

                <!-- 3 Pillars (Teknik, Kecepatan, Ketahanan) -->
                <div class="grid grid-cols-3 gap-3 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Teknik (1–5)</label>
                        <select id="editPenilaianTeknik" name="teknik" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-[#00a5ec]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kecepatan (1–5)</label>
                        <select id="editPenilaianKecepatan" name="kecepatan" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-[#00a5ec]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ketahanan (1–5)</label>
                        <select id="editPenilaianKetahanan" name="ketahanan" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-[#00a5ec]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">Catatan</label>
                    <textarea id="editPenilaianCatatan" name="catatan" rows="2" placeholder="Catatan perkembangan siswa..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 text-sm focus:outline-none focus:border-[#00a5ec] resize-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('editPenilaianModal')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#00a5ec] rounded-xl hover:bg-[#008cc9] shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: HAPUS PENILAIAN SISWA -->
    <div id="deletePenilaianModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-6 sm:p-8 relative">
            <button onclick="closeModal('deletePenilaianModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl mb-4 border border-rose-100">
                <i class="fa-solid fa-trash-can"></i>
            </div>

            <h3 class="text-xl font-bold text-slate-800">Hapus Penilaian Siswa?</h3>
            <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
                Apakah Anda yakin ingin menghapus penilaian <span id="deletePenilaianNama" class="font-bold text-slate-800"></span> untuk materi <span id="deletePenilaianDetail" class="font-semibold text-slate-700"></span>? Tindakan ini tidak dapat dibatalkan.
            </p>

            <form id="deletePenilaianForm" method="POST" class="mt-6 flex items-center justify-end gap-3">
                @csrf
                <input type="hidden" name="filter_kelas" value="{{ $selectedKelasId ?? 'semua' }}">
                <button type="button" onclick="closeModal('deletePenilaianModal')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-rose-500 hover:bg-rose-600 rounded-xl shadow-sm transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- MODAL 5: DETAIL SISWA (Sejenis Admin) -->
    <div id="modalDetailSiswa" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs hidden">
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
                            <span id="dsCabangBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700"></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0 ml-3">
                    <button type="button" onclick="closeModal('modalDetailSiswa')" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Tab Navigation Bar -->
            <div class="flex border-b border-slate-100 shrink-0 px-4 sm:px-6 overflow-x-auto bg-slate-50/50">
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
                                <p class="text-slate-400 mb-0.5 text-[11px]">Asal Sekolah</p>
                                <p id="dsSekolah" class="font-bold text-slate-700"></p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Level Kelas</p>
                                <p id="dsLevelText" class="font-bold text-slate-700"></p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Cabang Latihan</p>
                                <p id="dsCabangText" class="font-bold text-slate-700"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs mt-3">
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Riwayat Penyakit / Medis</p>
                                <p id="dsRiwayatPenyakit" class="font-bold text-slate-700"></p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-slate-400 mb-0.5 text-[11px]">Catatan Khusus</p>
                                <p id="dsCatatanKhusus" class="font-bold text-slate-700"></p>
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
                                <p id="dsEmailOrtu" class="font-bold text-slate-800 text-sm truncate"></p>
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
                        <div id="dsProgresGayaContainer" class="flex flex-nowrap overflow-x-auto pb-2 gap-3 snap-x snap-mandatory scroll-smooth">
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

            </div>
        </div>
    </div>

    <!-- Scripts -->
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
        const absensiMap = {!! json_encode($absensiMap ?? []) !!};
        const allSiswaList = {!! json_encode($allSiswaList ?? []) !!};

        // Filter daftar siswa pada modal absensi berdasarkan kelas yang dipilih
        function filterAbsensiSiswaByKelas() {
            const selectKelas = document.getElementById('absensiKelasSelect');
            const promptBox = document.getElementById('absensiPromptPilihKelas');
            const container = document.getElementById('absensiSiswaContainer');
            const emptyAlert = document.getElementById('absensiKelasKosongAlert');
            const countBadge = document.getElementById('absensiCountBadge');
            const submitBtn = document.getElementById('btnSimpanAbsensi');

            if (!selectKelas) return;

            const selectedKelasId = selectKelas.value;

            if (!selectedKelasId) {
                if (promptBox) promptBox.classList.remove('hidden');
                if (container) container.classList.add('hidden');
                if (emptyAlert) emptyAlert.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                return;
            }

            if (promptBox) promptBox.classList.add('hidden');

            const cards = document.querySelectorAll('.absensi-siswa-card');
            let matchCount = 0;

            cards.forEach(card => {
                const cardKelasId = card.getAttribute('data-id-kelas');
                const statusInput = card.querySelector('.absensi-input-status');
                const ketInput = card.querySelector('.absensi-input-keterangan');

                if (String(cardKelasId) === String(selectedKelasId)) {
                    card.classList.remove('hidden');
                    if (statusInput) statusInput.disabled = false;
                    if (ketInput) ketInput.disabled = false;
                    matchCount++;
                } else {
                    card.classList.add('hidden');
                    if (statusInput) statusInput.disabled = true;
                    if (ketInput) ketInput.disabled = true;
                }
            });

            if (matchCount === 0) {
                if (container) container.classList.add('hidden');
                if (emptyAlert) emptyAlert.classList.remove('hidden');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                if (container) container.classList.remove('hidden');
                if (emptyAlert) emptyAlert.classList.add('hidden');
                if (countBadge) countBadge.textContent = `${matchCount} siswa terdaftar`;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        // Menandai seluruh siswa pada kelas terpilih sebagai Hadir
        function setSemuaStatusAbsensi(status = 'hadir') {
            const cards = document.querySelectorAll('.absensi-siswa-card');
            let updatedCount = 0;
            cards.forEach(card => {
                if (!card.classList.contains('hidden')) {
                    const select = card.querySelector('.absensi-input-status');
                    if (select) {
                        select.value = status;
                        select.classList.add('ring-2', 'ring-emerald-400', 'bg-emerald-50/40');
                        setTimeout(() => {
                            select.classList.remove('ring-2', 'ring-emerald-400', 'bg-emerald-50/40');
                        }, 1200);
                        updatedCount++;
                    }
                }
            });

            const notif = document.getElementById('absensiHadirSemuaNotif');
            if (notif) {
                notif.classList.remove('hidden');
                setTimeout(() => {
                    notif.classList.add('hidden');
                }, 3500);
            }
        }

        // Buka modal absensi dengan kelas aktif terfilter dan langsung tandai Hadir Semua
        function openInputAbsensiHadirSemua() {
            openModal('inputAbsensiModal');

            const kelasSelect = document.getElementById('absensiKelasSelect');
            if (kelasSelect) {
                const activeFilterKelasId = '{{ $selectedKelasId ?? "" }}';
                if (activeFilterKelasId && activeFilterKelasId !== 'semua') {
                    kelasSelect.value = activeFilterKelasId;
                } else if (kelasSelect.options.length > 1) {
                    kelasSelect.selectedIndex = 1;
                }
                filterAbsensiSiswaByKelas();
                setSemuaStatusAbsensi('hadir');
            }
        }

        function setTanggalPenilaian(tgl) {
            const input = document.getElementById('penilaianTanggal');
            if (input) {
                input.value = tgl;
                updateSiswaOptions();
            }
        }

        function switchToAbsensiModal() {
            const tgl = document.getElementById('penilaianTanggal')?.value || '{{ date('Y-m-d') }}';
            const kls = document.getElementById('penilaianKelasSelect')?.value || '';
            closeModal('tambahPenilaianModal');
            openModal('inputAbsensiModal');
            const inputAbsTgl = document.querySelector('input[name="tanggal"]');
            if (inputAbsTgl) {
                inputAbsTgl.value = tgl;
            }
            const absKls = document.getElementById('absensiKelasSelect');
            if (absKls && kls) {
                absKls.value = kls;
            }
            filterAbsensiSiswaByKelas();
        }

        function onPenilaianKelasChanged() {
            updateSiswaOptions();
        }

        function updateSiswaOptions(preselectedSiswaId = null) {
            const tanggalInput = document.getElementById('penilaianTanggal');
            const kelasSelect = document.getElementById('penilaianKelasSelect');
            const siswaSelect = document.getElementById('penilaianSiswaSelect');
            const warningAlert = document.getElementById('penilaianBelumAbsenAlert');
            const submitBtn = document.getElementById('btnSimpanPenilaian');

            if (!tanggalInput || !siswaSelect) return;

            const selectedDate = tanggalInput.value;
            const selectedKelasId = kelasSelect ? kelasSelect.value : '';
            const dateAttendance = (absensiMap && absensiMap[selectedDate]) ? absensiMap[selectedDate] : {};

            siswaSelect.innerHTML = '';

            // Jika belum pilih kelas
            if (!selectedKelasId) {
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = '-- Pilih Kelas Terlebih Dahulu --';
                opt.disabled = true;
                opt.selected = true;
                siswaSelect.appendChild(opt);
                if (warningAlert) warningAlert.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                return;
            }

            // Filter siswa di kelas yang dipilih
            const siswaDiKelas = allSiswaList.filter(s => String(s.id_kelas) === String(selectedKelasId));

            let hadirCount = 0;
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '-- Pilih Siswa --';
            defaultOpt.disabled = true;
            defaultOpt.selected = !preselectedSiswaId;
            siswaSelect.appendChild(defaultOpt);

            siswaDiKelas.forEach(siswa => {
                const status = dateAttendance[siswa.id];

                if (status === 'hadir') {
                    const opt = document.createElement('option');
                    opt.value = siswa.id;
                    opt.textContent = siswa.nama;
                    opt.disabled = false;
                    opt.className = 'font-semibold text-slate-800';
                    hadirCount++;
                    if (preselectedSiswaId && String(siswa.id) === String(preselectedSiswaId)) {
                        opt.selected = true;
                    }
                    siswaSelect.appendChild(opt);
                }
            });

            if (hadirCount === 0) {
                if (warningAlert) warningAlert.classList.remove('hidden');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                if (warningAlert) warningAlert.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            onSiswaSelected();
        }

        function onSiswaSelected() {
            const siswaSelect = document.getElementById('penilaianSiswaSelect');
            const submitBtn = document.getElementById('btnSimpanPenilaian');

            if (siswaSelect && siswaSelect.value) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            } else {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        function openTambahPenilaianModalWith(siswaId, tanggal, idKelas = null) {
            openModal('tambahPenilaianModal');
            const tanggalInput = document.getElementById('penilaianTanggal');
            if (tanggalInput && tanggal) {
                tanggalInput.value = tanggal;
            }
            const kelasSelect = document.getElementById('penilaianKelasSelect');
            if (kelasSelect && idKelas) {
                kelasSelect.value = idKelas;
            }
            updateSiswaOptions(siswaId);
        }

        let isGayaRenangManual = false;

        function toggleGayaRenangManual() {
            isGayaRenangManual = !isGayaRenangManual;
            const selectWrapper = document.getElementById('gayaRenangSelectWrapper');
            const manualWrapper = document.getElementById('gayaRenangManualWrapper');
            const selectEl = document.getElementById('gayaRenangSelect');
            const inputEl = document.getElementById('gayaRenangManualInput');
            const btnToggle = document.getElementById('btnToggleGayaRenang');

            if (isGayaRenangManual) {
                if (selectWrapper) selectWrapper.classList.add('hidden');
                if (manualWrapper) manualWrapper.classList.remove('hidden');

                if (selectEl) {
                    selectEl.disabled = true;
                    selectEl.removeAttribute('name');
                    selectEl.required = false;
                }

                if (inputEl) {
                    inputEl.disabled = false;
                    inputEl.setAttribute('name', 'gaya_renang');
                    inputEl.required = true;
                    inputEl.focus();
                }

                if (btnToggle) btnToggle.textContent = 'Pilih dari daftar';
            } else {
                if (selectWrapper) selectWrapper.classList.remove('hidden');
                if (manualWrapper) manualWrapper.classList.add('hidden');

                if (selectEl) {
                    selectEl.disabled = false;
                    selectEl.setAttribute('name', 'gaya_renang');
                    selectEl.required = true;
                }

                if (inputEl) {
                    inputEl.disabled = true;
                    inputEl.removeAttribute('name');
                    inputEl.required = false;
                }

                if (btnToggle) btnToggle.textContent = 'Isi manual';
            }
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            if (id === 'inputAbsensiModal') {
                filterAbsensiSiswaByKelas();
            } else if (id === 'tambahPenilaianModal') {
                updateSiswaOptions();
            }
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            if (id === 'tambahPenilaianModal' && isGayaRenangManual) {
                toggleGayaRenangManual();
                const inputEl = document.getElementById('gayaRenangManualInput');
                if (inputEl) inputEl.value = '';
            }
            if (id === 'editPenilaianModal' && isEditGayaRenangManual) {
                toggleEditGayaRenangManual();
                const inputEl = document.getElementById('editGayaRenangManualInput');
                if (inputEl) inputEl.value = '';
            }
        }

        let isEditGayaRenangManual = false;

        function toggleEditGayaRenangManual() {
            isEditGayaRenangManual = !isEditGayaRenangManual;
            const selectWrapper = document.getElementById('editGayaRenangSelectWrapper');
            const manualWrapper = document.getElementById('editGayaRenangManualWrapper');
            const selectEl = document.getElementById('editGayaRenangSelect');
            const inputEl = document.getElementById('editGayaRenangManualInput');
            const btnToggle = document.getElementById('btnToggleEditGayaRenang');

            if (isEditGayaRenangManual) {
                if (selectWrapper) selectWrapper.classList.add('hidden');
                if (manualWrapper) manualWrapper.classList.remove('hidden');

                if (selectEl) {
                    selectEl.disabled = true;
                    selectEl.removeAttribute('name');
                    selectEl.required = false;
                }

                if (inputEl) {
                    inputEl.disabled = false;
                    inputEl.setAttribute('name', 'gaya_renang');
                    inputEl.required = true;
                    inputEl.focus();
                }

                if (btnToggle) btnToggle.textContent = 'Pilih dari daftar';
            } else {
                if (selectWrapper) selectWrapper.classList.remove('hidden');
                if (manualWrapper) manualWrapper.classList.add('hidden');

                if (selectEl) {
                    selectEl.disabled = false;
                    selectEl.setAttribute('name', 'gaya_renang');
                    selectEl.required = true;
                }

                if (inputEl) {
                    inputEl.disabled = true;
                    inputEl.removeAttribute('name');
                    inputEl.required = false;
                }

                if (btnToggle) btnToggle.textContent = 'Isi manual';
            }
        }

        function openEditPenilaianModal(data) {
            const form = document.getElementById('editPenilaianForm');
            if (form) {
                form.action = `/pelatih/siswa/penilaian/${data.id}/update`;
            }

            const namaInput = document.getElementById('editPenilaianNamaSiswa');
            if (namaInput) {
                namaInput.value = `${data.nama_siswa} (${data.nama_kelas})`;
            }

            const tglInput = document.getElementById('editPenilaianTanggal');
            if (tglInput) {
                tglInput.value = data.tanggal || '';
            }

            // Gaya renang
            const standardStyles = ['Gaya Bebas', 'Gaya Dada', 'Gaya Punggung', 'Gaya Kupu-kupu', 'Gaya Ganti'];
            const selectEl = document.getElementById('editGayaRenangSelect');
            const manualInputEl = document.getElementById('editGayaRenangManualInput');

            if (standardStyles.includes(data.gaya_renang)) {
                if (isEditGayaRenangManual) toggleEditGayaRenangManual();
                if (selectEl) selectEl.value = data.gaya_renang;
            } else {
                if (!isEditGayaRenangManual) toggleEditGayaRenangManual();
                if (manualInputEl) manualInputEl.value = data.gaya_renang || '';
            }

            // Catatan waktu (mm:ss.ms)
            const mmInput = document.getElementById('editWaktuMm');
            const ssInput = document.getElementById('editWaktuSs');
            const msInput = document.getElementById('editWaktuMs');
            if (mmInput) mmInput.value = '';
            if (ssInput) ssInput.value = '';
            if (msInput) msInput.value = '';

            if (data.catatan_waktu) {
                const match = String(data.catatan_waktu).match(/^(\d{1,2}):(\d{1,2})(?:\.(\d{1,2}))?$/);
                if (match) {
                    if (mmInput) mmInput.value = match[1] || '';
                    if (ssInput) ssInput.value = match[2] || '';
                    if (msInput) msInput.value = match[3] || '';
                }
            }

            const teknikEl = document.getElementById('editPenilaianTeknik');
            const kecepatanEl = document.getElementById('editPenilaianKecepatan');
            const ketahananEl = document.getElementById('editPenilaianKetahanan');
            const catatanEl = document.getElementById('editPenilaianCatatan');

            if (teknikEl) teknikEl.value = data.teknik || 3;
            if (kecepatanEl) kecepatanEl.value = data.kecepatan || 3;
            if (ketahananEl) ketahananEl.value = data.ketahanan || 3;
            if (catatanEl) catatanEl.value = data.catatan || '';

            openModal('editPenilaianModal');
        }

        function openDeletePenilaianModal(id, namaSiswa, detail) {
            const form = document.getElementById('deletePenilaianForm');
            if (form) {
                form.action = `/pelatih/siswa/penilaian/${id}/delete`;
            }
            const namaEl = document.getElementById('deletePenilaianNama');
            const detailEl = document.getElementById('deletePenilaianDetail');
            if (namaEl) namaEl.textContent = namaSiswa;
            if (detailEl) detailEl.textContent = detail;

            openModal('deletePenilaianModal');
        }

        function switchSiswaTab(tab) {
            const tabs = ['profil', 'absensi', 'pencapaian'];
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

        let _currentSiswaPencapaian = [];
        let _currentSiswaAbsensi = [];

        function openDetailSiswa(data) {
            const words = (data.nama || '').trim().split(/\s+/);
            let initials = '';
            for (let i = 0; i < Math.min(2, words.length); i++) {
                initials += words[i].charAt(0).toUpperCase();
            }
            initials = initials || 'GD';

            // 1. Header Modal
            const avatar = document.getElementById('dsAvatar');
            if (data.foto) {
                avatar.innerHTML = `<img src="${data.foto}" alt="${data.nama}" class="w-full h-full object-cover">`;
            } else {
                avatar.textContent = initials;
            }

            document.getElementById('dsNama').textContent = data.nama;
            document.getElementById('dsIdBadge').textContent = data.formatted_id;
            document.getElementById('dsLevelBadge').textContent = data.tingkat_kelas || 'Pemula A';
            document.getElementById('dsCabangBadge').textContent = 'Cabang ' + (data.nama_cabang || '-');

            // 2. Tab Profil & Biodata
            const ageText = data.umur !== null ? ` (${data.umur} tahun)` : '';
            if (document.getElementById('dsTTL')) {
                document.getElementById('dsTTL').textContent = `${data.tempat_lahir || '-'}, ${data.tanggal_lahir_formatted}${ageText}`;
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
            if (document.getElementById('dsRiwayatPenyakit')) {
                document.getElementById('dsRiwayatPenyakit').textContent = data.riwayat_penyakit || '-';
            }
            if (document.getElementById('dsCatatanKhusus')) {
                document.getElementById('dsCatatanKhusus').textContent = data.catatan_khusus || '-';
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
                                <p class="text-xs font-bold text-slate-700">
                                    Dicatat pada: ${p.tanggal_catat}
                                    ${p.nama_pelatih ? `<span class="font-semibold text-[#008cc9] ml-1.5 inline-flex items-center gap-1 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-100 text-[11px]"><i class="fa-solid fa-user-check text-[10px]"></i> ${p.nama_pelatih}</span>` : ''}
                                </p>
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

        @if($activeTab === 'absensi_siswa' && count($absensiChartDates) > 0)
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('absensiSiswaChart').getContext('2d');
                const dates = {!! json_encode($absensiChartDates) !!};
                const hadir = {!! json_encode($absensiChartHadir) !!};
                const absen = {!! json_encode($absensiChartAbsen) !!};

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [
                            {
                                label: 'Hadir',
                                data: hadir,
                                backgroundColor: '#10b981',
                                borderRadius: 4,
                                barThickness: 45
                            },
                            {
                                label: 'Tidak Hadir',
                                data: absen,
                                backgroundColor: '#f87171',
                                borderRadius: 4,
                                barThickness: 45
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            });
        @endif

        function filterRiwayatAbsensiTable(val) {
            const q = (val || '').toLowerCase().trim();
            const rows = document.querySelectorAll('.riwayat-absensi-row');
            let visible = 0;

            rows.forEach(row => {
                const hay = (row.getAttribute('data-search') || '').toLowerCase();
                if (!q || hay.includes(q)) {
                    row.classList.remove('hidden');
                    visible++;
                } else {
                    row.classList.add('hidden');
                }
            });

            const emptyRow = document.getElementById('riwayatAbsensiEmptySearchRow');
            if (emptyRow) {
                if (rows.length > 0 && visible === 0) {
                    emptyRow.classList.remove('hidden');
                } else {
                    emptyRow.classList.add('hidden');
                }
            }
        }

        function filterPenilaianSiswaCards(val) {
            const q = (val || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.penilaian-siswa-card');

            cards.forEach(card => {
                const hay = (card.getAttribute('data-search') || '').toLowerCase();
                if (!q || hay.includes(q)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('searchSiswaInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase().trim();
                    const cards = document.querySelectorAll('.siswa-card');
                    let visibleCount = 0;

                    cards.forEach(card => {
                        const nama = card.getAttribute('data-nama-siswa') || '';
                        if (!query || nama.includes(query)) {
                            card.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    const emptyState = document.getElementById('clientSearchEmptyState');
                    if (emptyState) {
                        if (visibleCount === 0 && cards.length > 0) {
                            emptyState.classList.remove('hidden');
                        } else {
                            emptyState.classList.add('hidden');
                        }
                    }
                });
            }
        });
    </script>

    @include('components.logout-modal')
</body>
</html>
