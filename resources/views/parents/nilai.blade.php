<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berikan Penilaian - Gajah Depa Swimming Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f8fb] min-h-screen text-slate-800 flex flex-col md:flex-row antialiased selection:bg-[#00a5ec] selection:text-white relative">

    <!-- Top Bar Header for Mobile -->
    <header class="md:hidden bg-[#093c56] text-white px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileSidebar()" class="p-2 text-slate-200 hover:text-white rounded-lg focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <span class="font-bold text-sm tracking-wide truncate">{{ $siswa->nama_cabang ?? 'Gajah Depa' }}</span>
        </div>
        <div class="text-xs px-2.5 py-1 bg-amber-400 text-amber-950 font-bold rounded-full shrink-0">
            Orang Tua
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
                <h2 class="text-base font-bold text-white tracking-wide leading-snug px-1">{{ $siswa->nama_cabang ?? 'Gajah Depa' }}</h2>
            </div>

            <!-- Card Anak Saya -->
            <div class="px-4 mt-5 mb-2">
                <div class="bg-[#0c4a6b] border border-sky-400/40 rounded-2xl p-4 text-white shadow-sm">
                    <div class="flex items-center justify-between mb-1">
                        <div class="text-[10px] font-bold text-sky-300 uppercase tracking-wider opacity-80">ANAK SAYA</div>
                        @if(isset($siswaList) && count($siswaList) > 1)
                            <span class="text-[10px] font-semibold bg-sky-400/20 text-sky-200 px-2 py-0.5 rounded-full border border-sky-400/30">
                                {{ count($siswaList) }} Anak
                            </span>
                        @endif
                    </div>
                    @if(isset($siswaList) && count($siswaList) > 1)
                        <form action="{{ route('parents.switch_anak') }}" method="POST" class="mt-1.5 mb-1.5">
                            @csrf
                            <div class="relative">
                                <select name="id_siswa" onchange="this.form.submit()" class="w-full bg-[#093c56] border border-sky-400/50 text-white rounded-xl px-3 py-2 text-xs font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-sky-400 cursor-pointer pr-8 transition">
                                    @foreach($siswaList as $anak)
                                        <option value="{{ $anak->id }}" class="bg-[#093c56] text-white" {{ ($siswa->id ?? null) == $anak->id ? 'selected' : '' }}>
                                            {{ $anak->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[11px] text-sky-300 pointer-events-none"></i>
                            </div>
                        </form>
                    @else
                        <div class="text-sm font-bold text-white">{{ $siswa->nama ?? 'Ahmad Rizki' }}</div>
                    @endif
                    <div class="text-xs text-sky-200 opacity-90 mt-0.5">{{ ucfirst($siswa->nama_kelas ?? 'Pemula A') }} · {{ $siswa->nama_cabang ?? 'Kemang' }}</div>
                    <button type="button" onclick="openDataAnakModal()" class="inline-block text-[11px] text-sky-300 font-medium hover:underline mt-2.5 text-left focus:outline-none">Ketuk untuk lihat data →</button>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="px-4 py-3 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('parents.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.dashboard') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-table-cells-large text-base {{ request()->routeIs('parents.dashboard') ? 'text-sky-400' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Absensi -->
                <a href="{{ route('parents.absensi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.absensi') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-calendar-check text-base {{ request()->routeIs('parents.absensi') ? 'text-sky-400' : '' }}"></i>
                    <span>Absensi</span>
                </a>

                <!-- Penilaian -->
                <a href="{{ route('parents.penilaian_anak') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.penilaian_anak') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-file-lines text-base {{ request()->routeIs('parents.penilaian_anak') ? 'text-sky-400' : '' }}"></i>
                    <span>Penilaian</span>
                </a>

                <!-- Nilai (Active) -->
                <a href="{{ route('parents.nilai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.nilai*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-star text-base {{ request()->routeIs('parents.nilai*') ? 'text-sky-400' : '' }}"></i>
                    <span>Nilai</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('parents.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.pengaturan*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-solid fa-gear text-base {{ request()->routeIs('parents.pengaturan*') ? 'text-sky-400' : '' }}"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-full bg-amber-400 text-amber-950 font-bold text-sm flex items-center justify-center shrink-0 shadow-sm overflow-hidden border border-amber-300">
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

            <button type="button" onclick="openLogoutModal()" title="Keluar" class="p-2 text-slate-300 hover:text-rose-400 hover:bg-white/10 rounded-lg transition shrink-0 ml-1 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto min-w-0">
        
        <!-- Flash Alert Success -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Header Page -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Berikan Penilaian</h1>
            <p class="text-sm text-slate-500 mt-1">Berikan penilaian dan ulasan untuk pelatih serta club kami (1 kali setiap bulan untuk masing-masing pelatih & club)</p>
        </div>

        <!-- Tabs Pill Navigation -->
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('parents.nilai', ['tab' => 'pelatih']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs font-bold transition {{ $activeTab === 'pelatih' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-sky-100/70 text-[#008cc9] hover:bg-sky-100' }}">
                Nilai Pelatih
            </a>
            <a href="{{ route('parents.nilai', ['tab' => 'club']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs font-bold transition {{ $activeTab === 'club' ? 'bg-[#00a5ec] text-white shadow-xs' : 'bg-sky-100/70 text-[#008cc9] hover:bg-sky-100' }}">
                Nilai Club
            </a>
        </div>

        <!-- Tab 1: Nilai Pelatih Form (Image 3) -->
        @if($activeTab === 'pelatih')
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 w-full">
                @if($coaches->isEmpty())
                    <div class="py-12 px-4 text-center">
                        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 border border-amber-200 flex items-center justify-center mx-auto mb-4 text-2xl shadow-xs">
                            <i class="fa-solid fa-user-xmark"></i>
                        </div>
                        <h4 class="text-base font-bold text-slate-800">Belum Ada Pelatih Terdaftar di Cabang Ini</h4>
                        <p class="text-xs text-slate-500 mt-1.5 max-w-md mx-auto">
                            Saat ini belum ada pelatih yang terdaftar pada cabang <strong>{{ $cabang->nama ?? ($siswa->nama_cabang ?? 'ini') }}</strong>. Silakan hubungi admin untuk informasi lebih lanjut.
                        </p>
                    </div>
                @else
                    <form action="{{ route('parents.nilai_pelatih.store') }}" method="POST" class="space-y-6" onsubmit="return confirm('Apakah Anda yakin ingin mengirim penilaian untuk pelatih ini?')">
                        @csrf
                        
                        @php
                            $ratedIds = $ratedCoachIdsThisMonth ?? [];
                            $coachesIds = $coaches->pluck('id')->map(fn($id) => (int)$id)->toArray();
                            $ratedCountInBranch = count(array_intersect($ratedIds, $coachesIds));
                            $defaultCoach = $coaches->first(fn($item) => !in_array((int)$item->id, $ratedIds)) ?? $coaches->first();
                            $selectedCoachId = $defaultCoach->id ?? null;
                            $selectedCoachName = $defaultCoach->nama ?? 'Belum ada pelatih';
                            $selectedCoachFoto = (!empty($defaultCoach->foto) && file_exists(public_path($defaultCoach->foto))) ? asset($defaultCoach->foto) : '';
                            $selectedCoachIsRated = $selectedCoachId ? in_array((int)$selectedCoachId, $ratedIds) : false;
                            $selectedCoachInitials = strtoupper(collect(explode(' ', $selectedCoachName))->map(fn($w) => substr($w, 0, 1))->implode(''));
                            $selectedCoachInitials = substr($selectedCoachInitials, 0, 2) ?: 'PL';

                            $selectedCoachReview = $selectedCoachId ? ($ulasanPelatihBulanIni[$selectedCoachId] ?? null) : null;
                            $selectedCoachRating = $selectedCoachReview ? (int) $selectedCoachReview->bintang_rating : 5;
                            $selectedCoachKomentar = $selectedCoachReview ? $selectedCoachReview->komentar_rating : '';
                            $selectedCoachTanggal = $selectedCoachReview ? \Carbon\Carbon::parse($selectedCoachReview->created_at)->translatedFormat('d F Y, H:i') : '';
                        @endphp

                        <!-- Pilih Pelatih Custom Dropdown (Tampil Foto & Nama) -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-slate-700">Pilih Pelatih (Cabang {{ $cabang->nama ?? ($siswa->nama_cabang ?? 'Gajah Depa') }})</label>
                                <span class="text-[11px] font-semibold text-slate-400">
                                    {{ $ratedCountInBranch }}/{{ count($coaches) }} pelatih dinilai bulan ini ({{ $namaBulanIni ?? date('F Y') }})
                                </span>
                            </div>
                        <input type="hidden" id="selectPelatih" name="id_pelatih" value="{{ $selectedCoachId }}">

                        <div class="relative" id="coachDropdownContainer">
                            <!-- Trigger Button -->
                            <button type="button" onclick="toggleCoachDropdown()" id="coachDropdownBtn"
                                class="w-full bg-slate-100 hover:bg-slate-200/70 border border-slate-200 text-slate-800 text-xs font-semibold rounded-xl px-3.5 py-2.5 flex items-center justify-between gap-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div id="dropdownSelectedAvatar" class="w-8 h-8 rounded-full bg-[#00a5ec] text-white font-bold text-[11px] flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 shadow-2xs">
                                        @if($selectedCoachFoto)
                                            <img src="{{ $selectedCoachFoto }}" alt="{{ $selectedCoachName }}" class="w-full h-full object-cover">
                                        @else
                                            {{ $selectedCoachInitials }}
                                        @endif
                                    </div>
                                    <div class="truncate text-left">
                                        <span id="dropdownSelectedName" class="font-bold text-slate-800">{{ $selectedCoachName }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span id="dropdownSelectedBadge" class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-bold {{ $selectedCoachIsRated ? '' : 'hidden' }}">Sudah</span>
                                    <i id="coachDropdownIcon" class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200"></i>
                                </div>
                            </button>

                            <!-- Dropdown Options List -->
                            <div id="coachDropdownMenu" class="hidden absolute left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-2xl shadow-xl z-30 max-h-64 overflow-y-auto divide-y divide-slate-100">
                                @foreach($coaches as $c)
                                    @php
                                        $isRated = in_array((int)$c->id, $ratedIds);
                                        $coachFotoUrl = (!empty($c->foto) && file_exists(public_path($c->foto))) ? asset($c->foto) : '';
                                        $cInitials = strtoupper(collect(explode(' ', $c->nama))->map(fn($w) => substr($w, 0, 1))->implode(''));
                                        $cInitials = substr($cInitials, 0, 2) ?: 'PL';
                                    @endphp
                                    <button type="button"
                                            onclick="selectCoachOption({{ $c->id }}, '{{ addslashes($c->nama) }}', '{{ $coachFotoUrl }}', '{{ $cInitials }}', {{ $isRated ? 'true' : 'false' }})"
                                            class="coach-option-item w-full px-3.5 py-2.5 flex items-center justify-between gap-3 hover:bg-sky-50/80 transition text-left cursor-pointer {{ (int)$c->id === (int)$selectedCoachId ? 'bg-sky-50/60' : '' }}"
                                            data-id="{{ $c->id }}">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-full bg-[#00a5ec] text-white font-bold text-xs flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 shadow-2xs">
                                                @if($coachFotoUrl)
                                                    <img src="{{ $coachFotoUrl }}" alt="{{ $c->nama }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ $cInitials }}
                                                @endif
                                            </div>
                                            <div class="truncate">
                                                <div class="text-xs font-bold text-slate-800 truncate">{{ $c->nama }}</div>
                                            </div>
                                        </div>
                                        @if($isRated)
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-bold shrink-0">Sudah</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Selected Coach Info Badge -->
                    <div class="flex items-center justify-between gap-3.5 pt-2">
                        <div class="flex items-center gap-3.5">
                            <div id="coachAvatar" class="w-12 h-12 rounded-full bg-[#00a5ec] text-white font-extrabold text-sm flex items-center justify-center shrink-0 shadow-xs overflow-hidden border border-slate-200">
                                @if($selectedCoachFoto)
                                    <img src="{{ $selectedCoachFoto }}" alt="{{ $selectedCoachName }}" class="w-full h-full object-cover">
                                @else
                                    {{ $selectedCoachInitials }}
                                @endif
                            </div>
                            <div>
                                <h4 id="coachName" class="text-base font-bold text-slate-800">{{ $selectedCoachName }}</h4>
                                <p id="coachRateStatus" class="text-[11px] font-semibold {{ $selectedCoachIsRated ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ $selectedCoachIsRated ? 'Sudah dinilai pada bulan ' . ($namaBulanIni ?? 'ini') : 'Belum dinilai pada bulan ' . ($namaBulanIni ?? 'ini') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notice if Selected Coach Already Rated This Month -->
                    <div id="alreadyRatedPelatihNotice" class="{{ $selectedCoachIsRated ? '' : 'hidden' }} p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex flex-col gap-2.5">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0 mt-0.5"></i>
                            <div>
                                <span class="font-bold block text-slate-800">Penilaian Bulan Ini Sudah Terkirim</span>
                                <span class="text-slate-600">Anda sudah memberikan penilaian untuk pelatih ini pada bulan <strong>{{ $namaBulanIni ?? date('F Y') }}</strong>. Silakan pilih pelatih lainnya pada dropdown di atas jika ingin menilai pelatih lain.</span>
                            </div>
                        </div>

                        <!-- Preview Ulasan yang Sudah Diberikan -->
                        <div id="ratedReviewPreview" class="{{ $selectedCoachIsRated ? '' : 'hidden' }} bg-white/90 border border-amber-200/80 rounded-xl p-3.5 mt-1 shadow-2xs">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-star text-amber-500"></i>
                                    Penilaian yang Anda Berikan:
                                </span>
                                <span id="ratedReviewDate" class="text-[11px] font-semibold text-slate-400">
                                    {{ $selectedCoachTanggal ? 'Dikirim pada ' . $selectedCoachTanggal . ' WIB' : '' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                <div id="ratedReviewStars" class="flex items-center gap-1 text-amber-400 text-sm">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="fa-solid fa-star {{ $s <= $selectedCoachRating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                    <span class="text-xs font-bold text-slate-700 ml-1.5">({{ $selectedCoachRating }}/5)</span>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-100 text-xs text-slate-700 italic">
                                <span id="ratedReviewComment">
                                    {{ !empty($selectedCoachKomentar) ? '"' . $selectedCoachKomentar . '"' : '(Tanpa komentar ulasan tertulis)' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Pelatih Interactive Stars -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Rating Pelatih</label>
                        <input type="hidden" name="bintang_rating" id="ratingPelatihValue" value="{{ $selectedCoachRating }}" required>
                        <div class="flex items-center gap-2 text-3xl text-slate-300" id="starContainerPelatih">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" {{ $selectedCoachIsRated ? 'disabled' : '' }} onclick="setRatingPelatih({{ $i }})" class="star-btn hover:scale-110 transition focus:outline-none disabled:cursor-not-allowed">
                                    <i class="fa-regular fa-star star-icon text-amber-400" data-star="{{ $i }}"></i>
                                </button>
                            @endfor
                        </div>
                    </div>

                    <!-- Komentar / Ulasan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Komentar / Ulasan</label>
                        <textarea id="komentarPelatihInput" name="komentar_rating" rows="4" placeholder="Bagikan pengalaman Anda mengenai {{ $selectedCoachName }}..." 
                                  {{ $selectedCoachIsRated ? 'disabled' : '' }}
                                  class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] resize-none disabled:opacity-75 disabled:cursor-not-allowed">{{ $selectedCoachKomentar }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button id="btnSubmitPelatih" type="submit" {{ $selectedCoachIsRated ? 'disabled' : '' }} class="w-full py-3.5 px-6 {{ $selectedCoachIsRated ? 'bg-slate-300 cursor-not-allowed' : 'bg-[#70d3f7] hover:bg-[#5bcbf5]' }} text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                        <i class="fa-regular fa-paper-plane text-sm"></i>
                        <span id="btnSubmitPelatihText">{{ $selectedCoachIsRated ? 'Sudah Dinilai Bulan Ini' : 'Kirim Penilaian Pelatih' }}</span>
                    </button>

                </form>
                @endif
            </div>
        @else
            <!-- Tab 2: Nilai Club Form (Image 4) -->
            @php
                $isClubRated = !empty($clubReviewThisMonth);
                $clubRating = $clubReviewThisMonth ? (int) $clubReviewThisMonth->bintang_rating : 5;
                $clubKomentar = $clubReviewThisMonth ? $clubReviewThisMonth->komentar_rating : '';
                $clubTanggal = $clubReviewThisMonth ? \Carbon\Carbon::parse($clubReviewThisMonth->created_at)->translatedFormat('d F Y, H:i') : '';
            @endphp
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 w-full">
                <form action="{{ route('parents.nilai_club.store') }}" method="POST" class="space-y-6" onsubmit="return confirm('Apakah Anda yakin ingin mengirim penilaian untuk club ini?')">
                    @csrf

                    <!-- Club Header Badge -->
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                        @if(file_exists(public_path('images/logo.jpg')))
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo {{ $siswa->nama_cabang ?? 'Gajah Depa' }}" class="w-12 h-12 rounded-full object-cover shadow-md border-2 border-amber-300 shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-amber-400 to-yellow-300 flex flex-col items-center justify-center text-blue-900 border-2 border-amber-300 shadow-md shrink-0">
                                <span class="text-[9px] font-black tracking-wider">GD</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-base font-bold text-slate-800">{{ $siswa->nama_cabang ?? 'Gajah Depa Akuatik Sumedang' }}</h3>
                            <p class="text-[11px] font-semibold {{ $isClubRated ? 'text-emerald-600' : 'text-slate-400' }} mt-0.5">
                                {{ $isClubRated ? 'Sudah dinilai pada bulan ' . ($namaBulanIni ?? 'ini') : 'Penilaian bulan ' . ($namaBulanIni ?? date('F Y')) }}
                            </p>
                        </div>
                    </div>

                    @if($isClubRated)
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex flex-col gap-2.5">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0 mt-0.5"></i>
                                <div>
                                    <span class="font-bold block text-slate-800">Penilaian Club Bulan Ini Sudah Terkirim</span>
                                    <span class="text-slate-600">Anda sudah memberikan penilaian untuk club pada bulan <strong>{{ $namaBulanIni ?? date('F Y') }}</strong>. Penilaian club hanya dapat diberikan 1 kali setiap bulan.</span>
                                </div>
                            </div>

                            <!-- Preview Ulasan Club yang Diberikan -->
                            <div class="bg-white/90 border border-amber-200/80 rounded-xl p-3.5 mt-1 shadow-2xs">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-star text-amber-500"></i>
                                        Penilaian yang Anda Berikan:
                                    </span>
                                    <span class="text-[11px] font-semibold text-slate-400">
                                        {{ $clubTanggal ? 'Dikirim pada ' . $clubTanggal . ' WIB' : '' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex items-center gap-1 text-amber-400 text-sm">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fa-solid fa-star {{ $s <= $clubRating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                        @endfor
                                        <span class="text-xs font-bold text-slate-700 ml-1.5">({{ $clubRating }}/5)</span>
                                    </div>
                                </div>
                                <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-100 text-xs text-slate-700 italic">
                                    {{ !empty($clubKomentar) ? '"' . $clubKomentar . '"' : '(Tanpa komentar ulasan tertulis)' }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Rating Club Interactive Stars -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Rating Club</label>
                        <input type="hidden" name="bintang_rating" id="ratingClubValue" value="{{ $clubRating }}" required>
                        <div class="flex items-center gap-2 text-3xl text-slate-300" id="starContainerClub">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" {{ $isClubRated ? 'disabled' : '' }} onclick="setRatingClub({{ $i }})" class="star-btn-club hover:scale-110 transition focus:outline-none disabled:cursor-not-allowed">
                                    <i class="fa-regular fa-star star-icon-club text-amber-400" data-star-club="{{ $i }}"></i>
                                </button>
                            @endfor
                        </div>
                    </div>

                    <!-- Komentar / Ulasan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Komentar / Ulasan</label>
                        <textarea name="komentar_rating" rows="4" {{ $isClubRated ? 'disabled' : '' }} placeholder="Ceritakan pengalaman Anda dengan club kami..." 
                                  class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-[#9366f6] resize-none disabled:opacity-75 disabled:cursor-not-allowed">{{ $clubKomentar }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" {{ $isClubRated ? 'disabled' : '' }} class="w-full py-3.5 px-6 {{ $isClubRated ? 'bg-slate-300 cursor-not-allowed' : 'bg-[#b9a5f6] hover:bg-[#a78ef5]' }} text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                        <i class="fa-regular fa-paper-plane text-sm"></i>
                        <span>{{ $isClubRated ? 'Sudah Dinilai Bulan Ini' : 'Kirim Penilaian Club' }}</span>
                    </button>

                </form>
            </div>
        @endif

        <!-- Section: Riwayat Penilaian Saya Per Bulannya -->
        <div class="mt-8 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 w-full">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-sky-50 text-[#00a5ec] flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight">Riwayat Penilaian Anda</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Daftar ulasan & bintang rating yang telah Anda kirimkan per bulannya</p>
                </div>

                <!-- Filter Bulan & Tahun Form -->
                <form method="GET" action="{{ route('parents.nilai') }}" class="flex items-center gap-2">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <div class="relative">
                        <select name="bulan" onchange="this.form.submit()" class="bg-slate-100/80 hover:bg-slate-200/60 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl px-3 py-2 pr-7 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer transition">
                            @foreach($namaBulanList as $code => $name)
                                <option value="{{ $code }}" {{ $filterBulan == $code ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <select name="tahun" onchange="this.form.submit()" class="bg-slate-100/80 hover:bg-slate-200/60 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl px-3 py-2 pr-7 appearance-none focus:outline-none focus:ring-2 focus:ring-[#00a5ec] cursor-pointer transition">
                            @foreach($tahunTersedia as $thn)
                                <option value="{{ $thn }}" {{ $filterTahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <!-- Content Riwayat: Tab Pelatih -->
            @if($activeTab === 'pelatih')
                @if($riwayatUlasanPelatih->isEmpty())
                    <div class="py-12 px-4 text-center">
                        <div class="w-14 h-14 rounded-full bg-slate-50 text-slate-400 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-xl">
                            <i class="fa-regular fa-comment-dots"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700">Belum Ada Penilaian di Bulan {{ $namaBulanTerpilih }}</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                            Anda belum memberikan penilaian untuk pelatih pada periode ini. Silakan gunakan formulir di atas untuk memberikan penilaian.
                        </p>
                    </div>
                @else
                    <div class="mt-6 space-y-4">
                        <div class="text-xs font-bold text-slate-500 mb-2">
                            Menampilkan {{ count($riwayatUlasanPelatih) }} ulasan pelatih pada bulan {{ $namaBulanTerpilih }}:
                        </div>
                        @foreach($riwayatUlasanPelatih as $item)
                            @php
                                $coachFoto = (!empty($item->foto_pelatih) && file_exists(public_path($item->foto_pelatih))) ? asset($item->foto_pelatih) : '';
                                $coachInit = strtoupper(collect(explode(' ', $item->nama_pelatih))->map(fn($w) => substr($w, 0, 1))->implode(''));
                                $coachInit = substr($coachInit, 0, 2) ?: 'PL';
                                $tglUlasan = \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i');
                            @endphp
                            <div class="bg-slate-50/70 hover:bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sm:p-5 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-[#00a5ec] text-white font-bold text-xs flex items-center justify-center shrink-0 overflow-hidden border border-slate-200 shadow-2xs">
                                            @if($coachFoto)
                                                <img src="{{ $coachFoto }}" alt="{{ $item->nama_pelatih }}" class="w-full h-full object-cover">
                                            @else
                                                {{ $coachInit }}
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800">{{ $item->nama_pelatih }}</h4>
                                            <span class="text-[11px] text-slate-400">{{ $tglUlasan }} WIB</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 self-start sm:self-center">
                                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <i class="fa-solid fa-star {{ $s <= $item->bintang_rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                            {{ $item->bintang_rating }}.0 / 5
                                        </span>
                                    </div>
                                </div>

                                @if(!empty($item->komentar_rating))
                                    <div class="bg-white rounded-xl p-3.5 border border-slate-200/70 text-xs text-slate-700 leading-relaxed italic">
                                        "{{ $item->komentar_rating }}"
                                    </div>
                                @else
                                    <div class="text-xs text-slate-400 italic">
                                        (Penilaian diberikan tanpa ulasan tertulis)
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <!-- Content Riwayat: Tab Club -->
                @if($riwayatUlasanClub->isEmpty())
                    <div class="py-12 px-4 text-center">
                        <div class="w-14 h-14 rounded-full bg-slate-50 text-slate-400 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-xl">
                            <i class="fa-regular fa-comment-dots"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700">Belum Ada Penilaian Club di Bulan {{ $namaBulanTerpilih }}</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                            Anda belum memberikan penilaian untuk club pada periode ini.
                        </p>
                    </div>
                @else
                    <div class="mt-6 space-y-4">
                        @foreach($riwayatUlasanClub as $itemClub)
                            @php
                                $tglClub = \Carbon\Carbon::parse($itemClub->created_at)->translatedFormat('d F Y, H:i');
                            @endphp
                            <div class="bg-purple-50/40 border border-purple-100 rounded-2xl p-4 sm:p-5 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-[#9366f6] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                            <i class="fa-solid fa-water-ladder text-sm"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800">{{ $itemClub->nama_cabang ?? 'Gajah Depa Akuatik Sumedang' }}</h4>
                                            <span class="text-[11px] text-slate-400">{{ $tglClub }} WIB</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 self-start sm:self-center">
                                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <i class="fa-solid fa-star {{ $s <= $itemClub->bintang_rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                            {{ $itemClub->bintang_rating }}.0 / 5
                                        </span>
                                    </div>
                                </div>

                                @if(!empty($itemClub->komentar_rating))
                                    <div class="bg-white rounded-xl p-3.5 border border-purple-100 text-xs text-slate-700 leading-relaxed italic">
                                        "{{ $itemClub->komentar_rating }}"
                                    </div>
                                @else
                                    <div class="text-xs text-slate-400 italic">
                                        (Penilaian diberikan tanpa ulasan tertulis)
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>

    </main>

    <!-- Modal Data Anak -->
    <div id="modalDataAnak" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
        <div class="bg-white text-slate-800 w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl relative border border-slate-100 p-6 md:p-8 max-h-[90vh] overflow-y-auto">
            
            <!-- Header Modal & Close Button -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#008cc9] tracking-tight">Data Anak</h3>
                    <p class="text-xs text-slate-500 mt-1">Informasi data {{ $siswa->nama ?? 'Ahmad Rizki' }} — sinkron dengan sistem admin</p>
                </div>
                <button onclick="closeDataAnakModal()" class="text-slate-400 hover:text-slate-600 text-xl p-1 focus:outline-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Top Profile Card Badge (Light Sky Blue Container) -->
            <div class="bg-[#f0f9ff] border border-sky-200/70 rounded-2xl p-4 flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-full bg-amber-400 text-amber-950 font-black text-lg flex items-center justify-center shrink-0 shadow-sm overflow-hidden border border-amber-300">
                    @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                        <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama ?? 'Foto Anak' }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($siswa->nama ?? 'AR', 0, 2)) }}
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-lg font-bold text-[#008cc9]">{{ $siswa->nama ?? 'Ahmad Rizki' }}</h4>
                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-300 font-semibold text-[11px] rounded-full">
                            {{ $siswa->status ?? 'Aktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        ID: {{ $siswa->kode_siswa ?? 'GD001' }} · {{ $siswa->nama_kelas ?? 'Pemula A' }} · Cabang {{ $siswa->nama_cabang ?? 'Kemang' }}
                    </p>
                </div>
            </div>

            <!-- Section 1: Data Siswa -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-[#093c56] border-b border-sky-400/30 pb-2 mb-4">Data Siswa</h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Tanggal Lahir</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->tgl_lahir_format ?? '14 Maret 2012' }}</span>
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
                <h4 class="text-sm font-bold text-[#093c56] border-b border-sky-400/30 pb-2 mb-4">Data Orang Tua / Wali</h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Nama</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->nama_parent ?? 'Hendra Rizki' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">No. Handphone</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->phone_parent ?? '0812-1111-2222' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Email</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->email_parent ?? 'hendra@email.com' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Alamat</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->alamat_parent ?? 'Jl. Kemang Raya No. 5, Jakarta Selatan' }}</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Synchronized Info Box & Tombol WhatsApp Admin Cabang -->
            <div class="bg-[#ecfdf5] border border-emerald-200/80 rounded-2xl p-4 text-emerald-800 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-emerald-500 text-base shrink-0 mt-0.5"></i>
                    <p class="leading-relaxed font-medium">
                        Data ini sinkron dengan sistem admin. Jika ada kesalahan, hubungi admin cabang {{ $siswa->nama_cabang ?? 'Kemang' }}.
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

    <!-- Floating Help Button -->
    <a href="#" title="Bantuan" class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold z-40">
        ?
    </a>

    <!-- Interactive Scripts -->
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

        const namaBulanIniStr = @json($namaBulanIni ?? date('F Y'));

        const reviewsPelatihData = {
            @if(isset($ulasanPelatihBulanIni))
                @foreach($ulasanPelatihBulanIni as $pId => $rev)
                    {{ $pId }}: {
                        rating: {{ (int) $rev->bintang_rating }},
                        komentar: @json($rev->komentar_rating ?? ''),
                        tanggal: @json(\Carbon\Carbon::parse($rev->created_at)->translatedFormat('d F Y, H:i'))
                    },
                @endforeach
            @endif
        };

        function toggleCoachDropdown() {
            const menu = document.getElementById('coachDropdownMenu');
            const icon = document.getElementById('coachDropdownIcon');
            if (!menu) return;
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
            }
        }

        document.addEventListener('click', function(e) {
            const container = document.getElementById('coachDropdownContainer');
            const menu = document.getElementById('coachDropdownMenu');
            const icon = document.getElementById('coachDropdownIcon');
            if (container && menu && !container.contains(e.target)) {
                menu.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
            }
        });

        function selectCoachOption(id, text, foto, initials, isRated) {
            const hiddenInput = document.getElementById('selectPelatih');
            if (hiddenInput) hiddenInput.value = id;

            // Update trigger button
            const dropName = document.getElementById('dropdownSelectedName');
            const dropBadge = document.getElementById('dropdownSelectedBadge');
            const dropAvatar = document.getElementById('dropdownSelectedAvatar');
            if (dropName) dropName.innerText = text;
            if (dropBadge) {
                if (isRated) dropBadge.classList.remove('hidden');
                else dropBadge.classList.add('hidden');
            }
            if (dropAvatar) {
                if (foto) {
                    dropAvatar.innerHTML = `<img src="${foto}" alt="${text}" class="w-full h-full object-cover">`;
                } else {
                    dropAvatar.innerHTML = '';
                    dropAvatar.innerText = initials || 'PL';
                }
            }

            // Highlight active item in dropdown list
            document.querySelectorAll('.coach-option-item').forEach(btn => {
                if (String(btn.getAttribute('data-id')) === String(id)) {
                    btn.classList.add('bg-sky-50/60');
                } else {
                    btn.classList.remove('bg-sky-50/60');
                }
            });

            // Close dropdown
            const menu = document.getElementById('coachDropdownMenu');
            const icon = document.getElementById('coachDropdownIcon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');

            // Update Selected Coach Info Badge below dropdown
            const coachNameEl = document.getElementById('coachName');
            if (coachNameEl) coachNameEl.innerText = text;

            const avatarEl = document.getElementById('coachAvatar');
            if (avatarEl) {
                if (foto) {
                    avatarEl.innerHTML = `<img src="${foto}" alt="${text}" class="w-full h-full object-cover">`;
                } else {
                    avatarEl.innerHTML = '';
                    avatarEl.innerText = initials || 'PL';
                }
            }

            const statusEl = document.getElementById('coachRateStatus');
            if (statusEl) {
                statusEl.innerText = isRated
                    ? ('Sudah dinilai pada bulan ' + namaBulanIniStr)
                    : ('Belum dinilai pada bulan ' + namaBulanIniStr);
                statusEl.className = 'text-[11px] font-semibold ' + (isRated ? 'text-emerald-600' : 'text-slate-400');
            }

            const noticeEl = document.getElementById('alreadyRatedPelatihNotice');
            if (noticeEl) {
                if (isRated) noticeEl.classList.remove('hidden');
                else noticeEl.classList.add('hidden');
            }

            const rev = reviewsPelatihData[id];
            const komentarInput = document.getElementById('komentarPelatihInput');
            const reviewPreview = document.getElementById('ratedReviewPreview');
            const ratedReviewStars = document.getElementById('ratedReviewStars');
            const ratedReviewComment = document.getElementById('ratedReviewComment');
            const ratedReviewDate = document.getElementById('ratedReviewDate');
            const ratingInput = document.getElementById('ratingPelatihValue');

            if (isRated && rev) {
                currentRatingPelatih = rev.rating;
                if (ratingInput) ratingInput.value = rev.rating;
                if (komentarInput) {
                    komentarInput.value = rev.komentar || '';
                    komentarInput.disabled = true;
                }
                if (reviewPreview) reviewPreview.classList.remove('hidden');
                if (ratedReviewStars) {
                    let starsHtml = '';
                    for (let s = 1; s <= 5; s++) {
                        starsHtml += `<i class="fa-solid fa-star ${s <= rev.rating ? 'text-amber-400' : 'text-slate-200'}"></i>`;
                    }
                    starsHtml += `<span class="text-xs font-bold text-slate-700 ml-1.5">(${rev.rating}/5)</span>`;
                    ratedReviewStars.innerHTML = starsHtml;
                }
                if (ratedReviewComment) {
                    ratedReviewComment.innerText = rev.komentar ? `"${rev.komentar}"` : '(Tanpa komentar ulasan tertulis)';
                }
                if (ratedReviewDate) {
                    ratedReviewDate.innerText = rev.tanggal ? ('Dikirim pada ' + rev.tanggal + ' WIB') : '';
                }
            } else {
                currentRatingPelatih = 5;
                if (ratingInput) ratingInput.value = 5;
                if (komentarInput) {
                    komentarInput.value = '';
                    komentarInput.disabled = false;
                    komentarInput.placeholder = 'Bagikan pengalaman Anda mengenai ' + text + '...';
                }
                if (reviewPreview) reviewPreview.classList.add('hidden');
            }
            renderStarsPelatih();

            // Disable/enable star buttons
            document.querySelectorAll('.star-btn').forEach(btn => {
                btn.disabled = isRated;
            });

            const btnSubmit = document.getElementById('btnSubmitPelatih');
            const btnText = document.getElementById('btnSubmitPelatihText');
            if (btnSubmit && btnText) {
                btnSubmit.disabled = isRated;
                btnText.innerText = isRated ? 'Sudah Dinilai Bulan Ini' : 'Kirim Penilaian Pelatih';
                if (isRated) {
                    btnSubmit.classList.remove('bg-[#70d3f7]', 'hover:bg-[#5bcbf5]');
                    btnSubmit.classList.add('bg-slate-300', 'cursor-not-allowed');
                } else {
                    btnSubmit.classList.remove('bg-slate-300', 'cursor-not-allowed');
                    btnSubmit.classList.add('bg-[#70d3f7]', 'hover:bg-[#5bcbf5]');
                }
            }
        }

        let currentRatingPelatih = {{ $selectedCoachRating ?? 5 }};
        function setRatingPelatih(val) {
            const btnSubmit = document.getElementById('btnSubmitPelatih');
            if (btnSubmit && btnSubmit.disabled) return;
            currentRatingPelatih = val;
            document.getElementById('ratingPelatihValue').value = val;
            renderStarsPelatih();
        }

        function renderStarsPelatih() {
            const icons = document.querySelectorAll('.star-icon');
            icons.forEach(icon => {
                const s = parseInt(icon.getAttribute('data-star'));
                if (s <= currentRatingPelatih) {
                    icon.classList.remove('fa-regular', 'text-slate-300');
                    icon.classList.add('fa-solid', 'text-amber-400');
                } else {
                    icon.classList.remove('fa-solid', 'text-amber-400');
                    icon.classList.add('fa-regular', 'text-slate-300');
                }
            });
        }

        let currentRatingClub = {{ (int)($clubReviewThisMonth->bintang_rating ?? 5) }};
        function setRatingClub(val) {
            currentRatingClub = val;
            document.getElementById('ratingClubValue').value = val;
            renderStarsClub();
        }

        function renderStarsClub() {
            const icons = document.querySelectorAll('.star-icon-club');
            icons.forEach(icon => {
                const s = parseInt(icon.getAttribute('data-star-club'));
                if (s <= currentRatingClub) {
                    icon.classList.remove('fa-regular', 'text-slate-300');
                    icon.classList.add('fa-solid', 'text-amber-400');
                } else {
                    icon.classList.remove('fa-solid', 'text-amber-400');
                    icon.classList.add('fa-regular', 'text-slate-300');
                }
            });
        }

        function selectCategory(cat) {
            document.getElementById('kategoriClubValue').value = cat;
            const buttons = document.querySelectorAll('.cat-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-[#9366f6]', 'text-white', 'shadow-xs');
                btn.classList.add('bg-purple-50', 'text-purple-700');
            });
            const activeBtn = document.getElementById('catBtn-' + cat);
            if (activeBtn) {
                activeBtn.classList.remove('bg-purple-50', 'text-purple-700');
                activeBtn.classList.add('bg-[#9366f6]', 'text-white', 'shadow-xs');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('starContainerPelatih')) renderStarsPelatih();
            if (document.getElementById('starContainerClub')) renderStarsClub();
        });
    </script>

    @include('components.logout-modal')
</body>
</html>
