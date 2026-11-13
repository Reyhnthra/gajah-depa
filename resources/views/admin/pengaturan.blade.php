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
    <title>Pengaturan Akun - Gajah Depa Swimming Club</title>
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
                <h1 class="text-3xl font-extrabold text-[#008cc9] tracking-tight">Pengaturan Akun & Cabang</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola data profil admin, kata sandi, dan informasi kontak operasional cabang</p>
            </div>
        </div>

        <!-- Form & Sidebar Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left 2 Cols: Settings Form -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-6" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data profil Anda?')">
                    @csrf

                    <!-- Section 1: Profil Admin -->
                    <div>
                        <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="fa-regular fa-user text-[#00a5ec]"></i>
                            <span>Profil Administrator</span>
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
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select name="jenis_kelamin" required
                                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition cursor-pointer">
                                    <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Keamanan Akun (Ganti Password) -->
                    <div class="pt-2">
                        <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="fa-solid fa-lock text-[#00a5ec]"></i>
                            <span>Keamanan Akun (Ganti Password)</span>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-1 mb-4">Biarkan kolom di bawah kosong jika Anda tidak ingin mengubah kata sandi.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                    @if($cabang)
                        <!-- Section 3: Informasi Operasional Cabang -->
                        <div class="pt-2">
                            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                                <i class="fa-solid fa-building-columns text-[#00a5ec]"></i>
                                <span>Informasi Cabang ({{ $cabang->nama }})</span>
                            </h3>

                            <div class="space-y-4 mt-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- No Rekening Pembayaran -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">No. Rekening Pembayaran Cabang</label>
                                        <input type="text" name="no_rekening" value="{{ old('no_rekening', $cabang->no_rekening ?? '') }}" placeholder="Contoh: BCA 7741276937 Suwandini"
                                               class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                                        <span class="text-[10px] text-slate-400 mt-1 block">Rekening tujuan transfer yang ditampilkan pada form pendaftaran siswa baru.</span>
                                    </div>

                                    <!-- No WhatsApp Cabang -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp Narahubung Cabang</label>
                                        <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $cabang->no_whatsapp ?? '') }}" placeholder="Contoh: 081234567890"
                                               class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition">
                                        <span class="text-[10px] text-slate-400 mt-1 block">Nomor konfirmasi dan bantuan orang tua siswa.</span>
                                    </div>
                                </div>

                                <!-- Alamat Cabang -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lokasi Kolam Cabang</label>
                                    <textarea name="alamat" rows="2" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] focus:bg-white transition resize-none">{{ old('alamat', $cabang->alamat ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#00a5ec] hover:bg-[#008cc9] text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk text-sm"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- Right 1 Col: Badges & Info -->
            <div class="space-y-6">
                <!-- Profile Summary Card -->
                <div class="bg-gradient-to-br from-[#093c56] to-[#0c4a6b] rounded-3xl p-6 text-white shadow-md relative overflow-hidden">
                    <div class="text-[10px] font-bold text-sky-300 uppercase tracking-widest opacity-80 mb-3">RINGKASAN AKUN</div>
                    
                    <div class="flex items-center gap-4 mb-4">
                        @if(file_exists(public_path('images/logo.jpg')))
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa" class="w-16 h-16 rounded-2xl object-cover border-2 border-amber-300 shadow-md shrink-0">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-amber-400 text-amber-950 font-black text-2xl flex items-center justify-center border-2 border-amber-300 shadow-md shrink-0">
                                {{ strtoupper(substr($user->nama ?? 'AD', 0, 2)) }}
                            </div>
                        @endif
                        <div class="overflow-hidden">
                            <h4 class="text-lg font-bold text-white truncate">{{ $user->nama ?? 'Administrator' }}</h4>
                            <p class="text-xs text-sky-200 capitalize">Role: {{ $user->role }}</p>
                        </div>
                    </div>

                    <div class="space-y-2.5 text-xs text-sky-100 border-t border-white/10 pt-4">
                        <div class="flex justify-between">
                            <span class="opacity-70">Cabang:</span>
                            <span class="font-semibold text-white">{{ $cabang->nama ?? 'Semua Cabang' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="opacity-70">Email:</span>
                            <span class="font-semibold text-white truncate max-w-[170px]">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="opacity-70">Status Akun:</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 capitalize">{{ $user->status ?? 'Aktif' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tips & Security Notice -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-3">
                    <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span>Keamanan & Validitas Data</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pastikan email dan kontak WhatsApp selalu aktif untuk memudahkan koordinasi dengan pelatih dan wali siswa.
                    </p>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Data rekening cabang akan digunakan secara otomatis saat calon siswa mendaftar melalui formulir pendaftaran baru di landing page.
                    </p>
                </div>
            </div>

        </div>

    </main>

    <!-- Mobile Sidebar Toggle Script -->
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

