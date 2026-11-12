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
    <title>Pengaturan Akun Pelatih - Gajah Depa Swimming Club</title>
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
            <span class="font-bold text-base tracking-wide">{{ $namaCabang ?? 'Gajah Depa' }}</span>
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
                <div class="text-[10px] font-bold text-sky-300 uppercase tracking-wider px-1 mb-1.5 opacity-80">LOKASI CABANG MELATIH</div>
                <form action="{{ route('pelatih.switch_cabang') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <select name="id_cabang" onchange="this.form.submit()" class="w-full bg-[#0c4a6b] border border-sky-400/40 text-white rounded-xl px-3 py-2 text-xs font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-sky-400 cursor-pointer pr-8 shadow-xs transition">
                            @if(isset($cabangPelatihList) && count($cabangPelatihList) > 0)
                                @foreach($cabangPelatihList as $cb)
                                    <option value="{{ $cb->id }}" class="bg-[#093c56] text-white" {{ ($idCabang ?? 1) == $cb->id ? 'selected' : '' }}>
                                        {{ $cb->nama }}
                                    </option>
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
                <a href="{{ route('pelatih.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm text-sm transition">
                    <i class="fa-solid fa-gear text-base text-sky-400"></i>
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
                <div class="overflow-hidden">
                    <h4 class="text-sm font-bold text-white truncate">{{ Auth::user()->nama ?? 'Pelatih' }}</h4>
                    <p class="text-xs text-slate-300 truncate">{{ Auth::user()->email ?? 'pelatih@gajahdepa.com' }}</p>
                </div>
            </div>
            <button type="button" onclick="openLogoutModal()" title="Keluar / Logout" class="text-slate-300 hover:text-white p-2 rounded-lg hover:bg-white/10 transition cursor-pointer">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
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
        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-start justify-between shadow-sm">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mt-0.5"></i>
                    <div>
                        <div class="text-sm font-bold mb-1">Terjadi kesalahan pada data yang dimasukkan:</div>
                        <ul class="text-xs list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- Top Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#008cc9] tracking-tight">Pengaturan Akun & Profil</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Kelola data profil pelatih, foto profil, dan kata sandi akun Anda</p>
            </div>
        </div>

        <!-- Form & Sidebar Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left 2 Cols: Settings Form -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <form action="{{ route('pelatih.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Section 1: Profil Pelatih -->
                    <div>
                        <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="fa-regular fa-user text-[#00a5ec]"></i>
                            <span>Profil Pelatih</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>

                            <!-- No WhatsApp / HP -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp / HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition cursor-pointer">
                                    <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pelatihDetail->tempat_lahir ?? '') }}" placeholder="Kota kelahiran"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pelatihDetail->tanggal_lahir ?? '') }}"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>

                            <!-- Nomor Rekening -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Rekening Bank</label>
                                <input type="text" name="no_rek" value="{{ old('no_rek', $pelatihDetail->no_rek ?? '') }}" placeholder="Contoh: BCA 123456789 a.n Nama"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>

                            <!-- Foto Profil -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Profil</label>
                                <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#00a5ec]/10 file:text-[#008cc9] hover:file:bg-[#00a5ec]/20 transition p-2 cursor-pointer">
                                <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Ganti Kata Sandi -->
                    <div class="pt-2">
                        <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="fa-solid fa-lock text-[#00a5ec]"></i>
                            <span>Keamanan Akun (Ganti Password)</span>
                        </h3>
                        <p class="text-slate-400 text-xs mt-1">Biarkan kolom di bawah kosong jika Anda tidak ingin mengubah kata sandi.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                            <!-- Kata Sandi Baru -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                                <input type="password" name="password" placeholder="Min. 8 karakter (huruf besar, kecil & angka)"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                                <p class="text-[11px] text-slate-400 mt-1">Min. 8 karakter, wajib kombinasi huruf besar, kecil, & angka.</p>
                            </div>

                            <!-- Konfirmasi Kata Sandi -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                        <button type="submit" class="bg-[#00a5ec] hover:bg-[#008cc9] text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Col: Profile Summary Card -->
            <div class="space-y-6">
                <!-- Card Ringkasan Profil Pelatih -->
                <div class="bg-[#093c56] text-white rounded-3xl p-6 shadow-sm border border-slate-800 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 text-white/5 text-9xl pointer-events-none">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <div class="relative z-10">
                        <div class="text-[10px] font-bold text-amber-300 uppercase tracking-wider mb-4">RINGKASAN AKUN</div>
                        
                        <div class="flex items-center gap-4 mb-5">
                            @if($user->foto && file_exists(public_path($user->foto)))
                                <img src="{{ asset($user->foto) }}" alt="{{ $user->nama }}" class="w-14 h-14 rounded-full object-cover border-2 border-amber-300 shadow-sm shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-amber-400 text-amber-950 font-black text-xl flex items-center justify-center shrink-0 shadow-md">
                                    {{ strtoupper(substr($user->nama ?? 'PL', 0, 2)) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <h4 class="font-bold text-white text-base leading-snug truncate">{{ $user->nama }}</h4>
                                <span class="inline-block text-[10px] px-2 py-0.5 bg-amber-400 text-amber-950 font-bold rounded-md mt-1">
                                    Pelatih
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2.5 text-xs text-slate-300 border-t border-white/10 pt-4">
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">Email:</span>
                                <span class="font-medium text-white truncate max-w-[160px]">{{ $user->email }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">WhatsApp:</span>
                                <span class="font-medium text-white">{{ $user->no_hp ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-slate-400">Status Akun:</span>
                                <span class="font-bold text-emerald-400 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card Bantuan & Keamanan -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-3">
                    <div class="flex items-center gap-2.5 text-[#008cc9]">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                        <h4 class="font-bold text-xs uppercase tracking-wider text-slate-800">Keamanan & Validitas Data</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pastikan email dan nomor WhatsApp Anda selalu aktif untuk memudahkan koordinasi absensi, jadwal latihan, dan evaluasi siswa klub.
                    </p>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Nomor rekening bank digunakan untuk pencatatan transfer honorarium atau administrasi kepelatihan resmi.
                    </p>
                </div>
            </div>

        </div>

    </main>

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

