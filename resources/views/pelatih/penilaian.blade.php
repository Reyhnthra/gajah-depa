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
    <title>Penilaian - Gajah Depa Akuatik</title>
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
        
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-[#008cc9] tracking-tight">Penilaian</h1>
            <p class="text-slate-500 text-sm mt-1">Rating dan ulasan dari orang tua siswa</p>
        </div>

        <!-- Navigation Tabs (Penilaian Saya | Penilaian Club) -->
        <div class="flex items-center gap-3 mb-8">
            <!-- Tab 1: Penilaian Saya -->
            <a href="{{ route('pelatih.penilaian', ['tab' => 'penilaian_saya']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ $activeTab === 'penilaian_saya' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-sky-100/60 text-[#008cc9] hover:bg-sky-100' }}">
                Penilaian Saya
            </a>

            <!-- Tab 2: Penilaian Club -->
            <a href="{{ route('pelatih.penilaian', ['tab' => 'penilaian_club']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ $activeTab === 'penilaian_club' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-sky-100/60 text-[#008cc9] hover:bg-sky-100' }}">
                Penilaian Club
            </a>
        </div>

        <!-- 3 KPI Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Rata-rata Rating -->
            <div class="bg-white rounded-2xl p-6 shadow-xs border-t-4 border-t-amber-400 border-x border-b border-slate-100 text-center">
                <!-- Stars Row -->
                <div class="flex justify-center gap-1.5 text-amber-400 text-lg mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($avgRating >= $i)
                            <i class="fa-solid fa-star"></i>
                        @elseif($avgRating >= ($i - 0.5))
                            <i class="fa-solid fa-star-half-stroke"></i>
                        @else
                            <i class="fa-regular fa-star text-slate-300"></i>
                        @endif
                    @endfor
                </div>
                <h3 class="text-4xl font-extrabold text-amber-500 tracking-tight">{{ number_format($avgRating, 1) }}</h3>
                <p class="text-sm font-semibold text-slate-600 mt-2">Rata-rata Rating</p>
                <p class="text-xs text-slate-400 mt-1">dari 5 bintang</p>
            </div>

            <!-- Card 2: Total Ulasan -->
            <div class="bg-white rounded-2xl p-6 shadow-xs border-t-4 border-t-sky-400 border-x border-b border-slate-100 text-center">
                <h3 class="text-4xl font-extrabold text-[#00a5ec] tracking-tight">{{ $totalUlasan }}</h3>
                <p class="text-sm font-semibold text-slate-600 mt-2">Total Ulasan</p>
                <p class="text-xs text-slate-400 mt-1">dari orang tua siswa</p>
            </div>

            <!-- Card 3: Rating Positif -->
            <div class="bg-white rounded-2xl p-6 shadow-xs border-t-4 border-t-emerald-500 border-x border-b border-slate-100 text-center">
                <h3 class="text-4xl font-extrabold text-emerald-500 tracking-tight">{{ $positiveCount }}</h3>
                <p class="text-sm font-semibold text-slate-600 mt-2">Rating Positif</p>
                <p class="text-xs text-slate-400 mt-1">rating ≥ 4 bintang</p>
            </div>
        </div>

        <!-- 2 Column Section: Distribusi Rating & Ulasan Terbaru -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Card: Distribusi Rating -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Distribusi Rating</h2>
                
                <div class="space-y-4">
                    @for($star = 5; $star >= 1; $star--)
                        @php
                            $count = $distribusi[$star] ?? 0;
                            $percentage = $totalUlasan > 0 ? ($count / $totalUlasan) * 100 : 0;
                            $barColor = $star >= 4 ? 'bg-emerald-500' : ($star === 3 ? 'bg-amber-400' : 'bg-slate-300');
                        @endphp
                        <div class="flex items-center gap-3 text-sm font-medium">
                            <span class="w-8 text-slate-600 flex items-center gap-1 font-semibold">
                                {{ $star }} <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            </span>

                            <div class="flex-1 bg-slate-100 rounded-full h-3 overflow-hidden">
                                <div class="{{ $barColor }} h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%;"></div>
                            </div>

                            <span class="w-6 text-right text-slate-400 font-semibold">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Right Card: Ulasan Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Ulasan Terbaru</h2>

                <div class="max-h-[360px] overflow-y-auto space-y-4 pr-2">
                    @forelse($reviews as $item)
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 space-y-2">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ $item->nama_parent ?? 'Orang Tua' }}</h4>
                                    @if($activeTab !== 'penilaian_club')
                                        <p class="text-xs text-slate-400 mt-0.5">untuk {{ $item->nama_siswa ?? 'Ahmad Rizki' }}</p>
                                    @endif
                                </div>

                                <!-- Stars -->
                                <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                                    @for($s = 1; $s <= 5; $s++)
                                        @if($s <= $item->bintang_rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star text-slate-300"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <p class="text-xs text-slate-600 italic">
                                "{{ $item->komentar_rating }}"
                            </p>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400">
                            Belum ada ulasan dari orang tua siswa.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>

    <!-- Mobile Sidebar Helper Script -->
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
