<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Gajah Depa Akuatik</title>
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

                <!-- Nilai -->
                <a href="{{ route('parents.nilai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('parents.nilai*') ? 'border border-sky-400/80 bg-[#0c4a6b] text-white font-semibold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5 font-medium' }} text-sm transition">
                    <i class="fa-regular fa-star text-base {{ request()->routeIs('parents.nilai*') ? 'text-sky-400' : '' }}"></i>
                    <span>Nilai</span>
                </a>

                <!-- Pengaturan (Active) -->
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

        @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                <div class="flex items-center gap-2 mb-1 text-sm font-bold">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <span>Gagal Menyimpan Perubahan</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-rose-600">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#008cc9] tracking-tight">Pengaturan Profil</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data profil orang tua, foto profil anak, dan kata sandi akun Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Left Column: Settings Form -->
            <div class="md:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100">
                <form action="{{ route('parents.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" data-confirm="Apakah Anda yakin ingin menyimpan perubahan data profil Anda?">
                    @csrf

                    <!-- Section Foto Profil Anak -->
                    <div class="bg-gradient-to-r from-sky-50 to-blue-50/40 border border-sky-100 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                        <div class="relative group shrink-0">
                            <div id="fotoAnakPreviewContainer" class="w-20 h-20 rounded-full bg-amber-400 text-amber-950 font-black text-2xl flex items-center justify-center border-2 border-amber-300 shadow-md overflow-hidden">
                                @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                                    <img id="fotoAnakPreviewImg" src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama ?? 'Foto Anak' }}" class="w-full h-full object-cover">
                                @else
                                    <span id="fotoAnakInitials">{{ strtoupper(substr($siswa->nama ?? 'AR', 0, 2)) }}</span>
                                @endif
                            </div>
                            <label for="fotoAnakInput" class="absolute bottom-0 right-0 w-7 h-7 bg-[#00a5ec] hover:bg-[#008cc9] text-white rounded-full flex items-center justify-center shadow-md cursor-pointer transition" title="Pilih Foto Anak">
                                <i class="fa-solid fa-camera text-xs"></i>
                            </label>
                        </div>

                        <div class="flex-1 text-center sm:text-left">
                            <div class="flex items-center justify-center sm:justify-start gap-2">
                                <h4 class="text-sm font-bold text-slate-800">Foto Profil Anak ({{ $siswa->nama ?? 'Nama Anak' }})</h4>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-100 text-[#008cc9]">Foto Profil</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Gunakan foto anak yang jelas. Format: JPG, JPEG, PNG, atau WEBP (Maks. 3MB).</p>
                            
                            <div class="mt-3 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                                <label for="fotoAnakInput" class="px-3.5 py-1.5 bg-[#00a5ec] hover:bg-[#008cc9] text-white text-xs font-bold rounded-xl cursor-pointer shadow-xs transition inline-flex items-center gap-2">
                                    <i class="fa-solid fa-upload text-[11px]"></i>
                                    <span>Pilih / Ganti Foto</span>
                                </label>
                                <span id="fotoAnakFileName" class="text-[11px] text-slate-500 italic truncate max-w-[200px]">Belum ada file baru dipilih</span>
                            </div>
                            <input type="file" id="fotoAnakInput" name="foto_anak" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="previewFotoAnak(event)">
                            <input type="hidden" name="id_siswa" value="{{ $siswa->id ?? '' }}">
                        </div>
                    </div>

                    <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-4 pt-2 flex items-center gap-2">
                        <i class="fa-regular fa-user text-[#00a5ec]"></i>
                        <span>Informasi Profil Orang Tua</span>
                    </h3>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama ?? 'Hendra Rizki') }}" required
                                class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                    </div>

                    <!-- Email & No HP -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? 'orangtua@gajahdepa.com') }}" required
                                    class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp ?? '081234567890') }}"
                                    class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec] resize-none">{{ old('alamat', $parent->alamat ?? 'Dusun Kaum Kaler 03/01') }}</textarea>
                    </div>

                    <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-4 pt-4 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-[#00a5ec]"></i>
                        <span>Ubah Kata Sandi (Opsional)</span>
                    </h3>

                    <!-- Password Baru & Konfirmasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Min. 8 karakter (huruf besar, kecil & angka)"
                                    class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                            <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak diubah. Jika diisi, min. 8 karakter (huruf besar, kecil, angka).</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                                    class="w-full bg-slate-100/80 border border-slate-200 text-slate-800 text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3.5 px-6 bg-[#00a5ec] hover:bg-[#008cc9] text-white font-bold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk text-sm"></i>
                        <span>Simpan Perubahan</span>
                    </button>

                </form>
            </div>

            <!-- Right Column: Student Info Badge Card -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-[#093c56] to-[#0c4a6b] rounded-3xl p-6 text-white shadow-md relative overflow-hidden">
                    <div class="text-[10px] font-bold text-sky-300 uppercase tracking-widest opacity-80 mb-2">PROFIL ANAK TERHUBUNG</div>
                    
                    <div class="flex items-center gap-4 mb-4">
                        <div class="relative shrink-0">
                            <div id="fotoAnakRightCard" class="w-16 h-16 rounded-full bg-amber-400 text-amber-950 font-black text-xl flex items-center justify-center border-2 border-amber-300 shadow-md shrink-0 overflow-hidden">
                                @if(!empty($siswa->foto) && file_exists(public_path($siswa->foto)))
                                    <img src="{{ asset($siswa->foto) }}" alt="{{ $siswa->nama ?? 'Anak' }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($siswa->nama ?? 'AR', 0, 2)) }}
                                @endif
                            </div>
                            <label for="fotoAnakInput" class="absolute -bottom-1 -right-1 w-6 h-6 bg-amber-400 hover:bg-amber-300 text-amber-950 rounded-full flex items-center justify-center shadow-md cursor-pointer transition text-[10px] font-bold" title="Ubah Foto Anak">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-base font-bold text-white truncate">{{ $siswa->nama ?? 'Ahmad Rizki' }}</h4>
                            <p class="text-xs text-sky-200">{{ ucfirst($siswa->nama_kelas ?? 'Pemula A') }}</p>
                            <label for="fotoAnakInput" class="text-[11px] text-amber-300 hover:underline cursor-pointer font-medium mt-0.5 inline-flex items-center gap-1">
                                <i class="fa-solid fa-camera text-[10px]"></i>
                                <span>Ubah Foto</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs text-sky-100 border-t border-white/10 pt-4">
                        <div class="flex justify-between">
                            <span class="opacity-70">Cabang:</span>
                            <span class="font-semibold text-white">{{ $siswa->nama_cabang ?? 'Gajah Depa Akuatik Sumedang' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="opacity-70">Sekolah:</span>
                            <span class="font-semibold text-white">{{ $siswa->sekolah ?? 'SDN 01 Sumedang' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-3xl p-5 text-amber-900 text-xs space-y-2">
                    <div class="flex items-center gap-2 font-bold text-amber-950">
                        <i class="fa-solid fa-circle-info text-amber-500 text-sm"></i>
                        <span>Informasi Pendaftaran</span>
                    </div>
                    <p class="leading-relaxed text-amber-800">
                        Jika terdapat perubahan data anak (seperti pindah kelas atau cabang), silakan hubungi tim administrasi Gajah Depa Akuatik.
                    </p>
                </div>
            </div>

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

        function openDataAnakModal() {
            document.getElementById('modalDataAnak').classList.remove('hidden');
        }

        function closeDataAnakModal() {
            document.getElementById('modalDataAnak').classList.add('hidden');
        }

        function previewFotoAnak(event) {
            const input = event.target;
            const file = input.files && input.files[0];
            const fileNameSpan = document.getElementById('fotoAnakFileName');
            const previewContainer = document.getElementById('fotoAnakPreviewContainer');
            const rightCard = document.getElementById('fotoAnakRightCard');

            if (file) {
                if (fileNameSpan) fileNameSpan.innerText = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewContainer) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview Foto Anak" class="w-full h-full object-cover">`;
                    }
                    if (rightCard) {
                        rightCard.innerHTML = `<img src="${e.target.result}" alt="Preview Foto Anak" class="w-full h-full object-cover">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    @include('components.logout-modal')
</body>
</html>
