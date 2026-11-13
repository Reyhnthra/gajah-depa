<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Gajah Depa Akuatik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        header,
        .sticky-nav {
            position: fixed !important;
            top: 0px !important;
            left: 0px !important;
            right: 0px !important;
            width: 100% !important;
            z-index: 99999 !important;
            background-color: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08) !important;
            border-bottom: 1px solid #f1f5f9 !important;
            margin: 0 !important;
            transform: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <header id="mainHeader"
        style="position: fixed !important; top: 0px !important; left: 0px !important; right: 0px !important; width: 100% !important; z-index: 99999 !important; background-color: rgba(255, 255, 255, 0.98) !important; backdrop-filter: blur(10px) !important; -webkit-backdrop-filter: blur(10px) !important; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08) !important; border-bottom: 1px solid #f1f5f9 !important; margin: 0 !important; transform: none !important;"
        class="sticky-nav fixed top-0 left-0 right-0 w-full z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8">
            <div class="flex items-center gap-x-2">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa Akuatik"
                    class="h-10 w-10 rounded-full object-cover shadow-sm">
                <span class="text-xl font-bold tracking-tight text-[#008cc9]">Gajah Depa Akuatik</span>
            </div>
            <div class="hidden md:flex md:gap-x-8 lg:gap-x-10">
                <a href="#keunggulan"
                    class="text-sm font-medium text-gray-600 hover:text-[#008cc9] transition">Keunggulan</a>
                <a href="#galeri" class="text-sm font-medium text-gray-600 hover:text-[#008cc9] transition">Galeri</a>
                <a href="#pelatih" class="text-sm font-medium text-gray-600 hover:text-[#008cc9] transition">Pelatih</a>
                <a href="#cabang" class="text-sm font-medium text-gray-600 hover:text-[#008cc9] transition">Cabang</a>
                <a href="#program" class="text-sm font-medium text-gray-600 hover:text-[#008cc9] transition">Program</a>
                <a href="#daftar" class="text-sm font-medium text-gray-600 hover:text-[#008cc9] transition">Daftar</a>
            </div>
            <div class="flex items-center gap-x-3">
                <a href="{{ route('login') }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold text-[#008cc9] border border-[#008cc9] hover:bg-cyan-50 transition">Masuk</a>
                <a href="{{ route('register') }}"
                    class="rounded-lg bg-[#008cc9] px-4 py-2 text-sm font-semibold text-white hover:bg-cyan-600 transition">Daftar
                    Akun</a>
            </div>
        </nav>
    </header>

    <section
        class="relative min-h-[92vh] flex flex-col justify-center items-center text-white px-6 pt-28 pb-36 sm:pt-32 sm:pb-44 overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 165, 236, 0.92) 0%, rgba(0, 110, 160, 0.95) 100%), url('https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">

        <!-- Subtle Water Light Texture Overlay -->
        <div
            class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1.5px,transparent_1.5px)] [background-size:20px_20px] pointer-events-none">
        </div>

        <div class="relative mx-auto max-w-7xl w-full z-10 py-8 lg:py-12">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-center">

                <!-- Kolom Kiri: Logo Resmi Gajah Depa Akuatik -->
                <div class="lg:col-span-5 relative flex justify-center mb-6 lg:mb-0">
                    <div class="relative flex items-center justify-center">

                        <!-- Glow effect di belakang logo -->
                        <div
                            class="absolute -inset-4 bg-gradient-to-tr from-cyan-300/40 to-sky-400/40 rounded-full blur-2xl opacity-80 pointer-events-none">
                        </div>

                        <!-- Logo Lingkaran Utama (List Putih Tipis) -->
                        <div
                            class="relative w-56 h-56 sm:w-72 sm:h-72 rounded-full border-2 border-white/40 shadow-[0_15px_35px_rgba(0,0,0,0.25)] bg-white overflow-hidden p-0.5 transition-transform duration-500 hover:scale-105">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa Akuatik"
                                class="w-full h-full rounded-full object-cover">
                        </div>

                    </div>
                </div>

                <!-- Kolom Kanan: Teks & Aksi Utama -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-cyan-100 text-xs sm:text-sm font-semibold mb-6 shadow-sm">
                        <i class="fa-solid fa-medal text-amber-300"></i>
                        <span>Club Renang Resmi & Terpercaya</span>
                    </div>

                    <h1
                        class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight drop-shadow-sm leading-tight">
                        Gajah Depa Akuatik
                    </h1>

                    <p
                        class="mt-3 sm:mt-4 text-base sm:text-lg lg:text-xl font-bold tracking-wide text-cyan-100 whitespace-normal lg:whitespace-nowrap">
                        “Temani Perjalanan Anak Bertumbuh Kembang Melalui Renang”
                    </p>

                    <p class="mt-5 max-w-2xl text-sm sm:text-base leading-relaxed text-cyan-50/95">
                        Berdiri sejak tahun 2021 dan telah dipercaya oleh ratusan orang tua. Kami berfokus pada
                        pembinaan potensi anak dari usia balita, pemula, hingga atlet muda dengan pelatih profesional,
                        metode ramah anak, dan pemantauan perkembangan secara digital.
                    </p>

                    <div class="mt-8 flex justify-center">
                        <a href="#daftar"
                            class="inline-flex items-center justify-center rounded-xl bg-white px-10 py-3.5 text-sm sm:text-base font-bold text-[#008cc9] shadow-lg hover:bg-cyan-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            <span>Daftar Sekarang</span>
                        </a>
                    </div>

                    <!-- Statistik / Social Proof -->
                    <div
                        class="mt-10 pt-8 border-t border-white/20 grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 text-center lg:text-left">
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-white">150+</div>
                            <div class="text-[11px] sm:text-xs text-cyan-100/80 font-medium mt-0.5">Siswa Terbina</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-white">10+</div>
                            <div class="text-[11px] sm:text-xs text-cyan-100/80 font-medium mt-0.5">Pelatih Berlisensi
                            </div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-white">3</div>
                            <div class="text-[11px] sm:text-xs text-cyan-100/80 font-medium mt-0.5">Cabang Latihan</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-white">4</div>
                            <div class="text-[11px] sm:text-xs text-cyan-100/80 font-medium mt-0.5">Tingkatan Kelas
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-0 select-none pointer-events-none">
            <svg class="relative block w-full h-[50px] md:h-[80px]" data-name="Layer 1"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,42.4V120H0Z"
                    fill="#ffffff" opacity="0.15"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,104,26,42.24,21.19,84.6,43.14,131,53.22,44.52,9.68,88.16,1.43,129.54-15,40.67-16.15,76.51-40.42,117.37-53.51,55.6-17.81,117.72-9.1,174,15.65,26.47,11.64,51,26.33,76.88,38.16,21.65,9.9,43.76,18.78,66.6,24.47V120H0Z"
                    fill="#ffffff" opacity="0.35"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.38V120H0Z"
                    fill="#ffffff"></path>
            </svg>
        </div>
    </section>

    <!-- Section Keunggulan Kami (Dengan Foto & Deskripsi Menarik) -->
    <section id="keunggulan" class="bg-slate-50 py-20 px-6 lg:px-8 border-b border-slate-100">
        <div class="mx-auto max-w-7xl">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-wider text-[#008cc9] bg-cyan-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Mengapa Memilih Kami?
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Keunggulan Gajah Depa Akuatik
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                    Kami hadir mendampingi setiap langkah buah hati Anda untuk menguasai keterampilan renang dengan
                    aman, gembira, dan berprestasi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Card 1 -->
                <div
                    class="bg-white rounded-[24px] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:border-cyan-300 transition-all duration-300 flex flex-col group">
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/menyenangkan.jpeg')) ? asset('images/menyenangkan.jpeg') : (file_exists(public_path('images/menyenangkan.jpg')) ? asset('images/menyenangkan.jpg') : asset('images/menyenangkan.png')) }}"
                            alt="Metode Ramah Anak" style="object-position: center 60%;"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <span
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-cyan-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                            Ramah Anak
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div
                            class="w-10 h-10 rounded-xl bg-cyan-50 text-[#008cc9] flex items-center justify-center -mt-11 mb-3 shadow-md border-2 border-white relative z-10">
                            <i class="fa-solid fa-face-smile text-base"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-[#008cc9] transition">
                            Metode Menyenangkan
                        </h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                            Belajar renang dengan pendekatan bermain dan psikologi anak, menghilangkan rasa takut air
                            secara alami dan sabar.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white rounded-[24px] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:border-cyan-300 transition-all duration-300 flex flex-col group">
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/profesional.jpeg')) ? asset('images/profesional.jpeg') : (file_exists(public_path('images/profesional.jpg')) ? asset('images/profesional.jpg') : asset('images/profesional.png')) }}"
                            alt="Pelatih Bersertifikat"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <span
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-cyan-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                            Profesional
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div
                            class="w-10 h-10 rounded-xl bg-cyan-50 text-[#008cc9] flex items-center justify-center -mt-11 mb-3 shadow-md border-2 border-white relative z-10">
                            <i class="fa-solid fa-certificate text-base"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-[#008cc9] transition">
                            Pelatih Berlisensi
                        </h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                            Dibimbing oleh pelatih-pelatih bersertifikasi resmi, berlatar belakang pendidikan olahraga
                            dan perenang berpengalaman.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white rounded-[24px] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:border-cyan-300 transition-all duration-300 flex flex-col group">
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/higienis.jpeg')) ? asset('images/higienis.jpeg') : (file_exists(public_path('images/higienis.jpg')) ? asset('images/higienis.jpg') : asset('images/higienis.png')) }}"
                            alt="Fasilitas Kolam Terawat"
                            style="object-position: center top;"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <span
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-cyan-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                            Standar Aman
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div
                            class="w-10 h-10 rounded-xl bg-cyan-50 text-[#008cc9] flex items-center justify-center -mt-11 mb-3 shadow-md border-2 border-white relative z-10">
                            <i class="fa-solid fa-water-ladder text-base"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-[#008cc9] transition">
                            Fasilitas Kolam Higienis
                        </h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                            Kualitas air bersih, kedalaman terstandar, dan keselamatan selalu diprioritaskan di setiap
                            cabang latihan.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-white rounded-[24px] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:border-cyan-300 transition-all duration-300 flex flex-col group">
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/nilai.jpeg')) ? asset('images/nilai.jpeg') : (file_exists(public_path('images/nilai.jpg')) ? asset('images/nilai.jpg') : asset('images/nilai.png')) }}"
                            alt="Raport & Evaluasi Digital"
                            style="object-position: center bottom;"
                            class="w-full h-full object-cover object-bottom group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <span
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-cyan-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                            Transparan
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div
                            class="w-10 h-10 rounded-xl bg-cyan-50 text-[#008cc9] flex items-center justify-center -mt-11 mb-3 shadow-md border-2 border-white relative z-10">
                            <i class="fa-solid fa-chart-line text-base"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-[#008cc9] transition">
                            Pantau Nilai & Absensi
                        </h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                            Orang tua memiliki dashboard khusus untuk memantau presensi dan grafik perkembangan anak.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section Galeri & Dokumentasi Kegiatan (Foto-Foto Kegiatan Menarik) -->
    <section id="galeri" class="bg-white py-20 px-6 lg:px-8 border-b border-slate-100">
        <div class="mx-auto max-w-7xl">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-wider text-[#008cc9] bg-cyan-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Dokumentasi
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Galeri Kegiatan Siswa
                </h2>
                <p class="mt-2 text-sm sm:text-base text-slate-500">
                    Suasana seru latihan, pengenalan air, dan pembinaan teknik renang di Gajah Depa Akuatik.
                </p>
            </div>

            <!-- Grid Foto Galeri -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Galeri 1 -->
                <div
                    class="group relative rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 bg-slate-100 border border-slate-100">
                    <div class="h-64 sm:h-72 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/pemula.jpeg')) ? asset('images/pemula.jpeg') : (file_exists(public_path('images/pemula.jpg')) ? asset('images/pemula.jpg') : asset('images/pemula.png')) }}"
                            alt="Pengenalan Air Usia Dini"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <span
                            class="inline-block self-start text-[10px] font-bold uppercase tracking-wider text-amber-300 bg-amber-400/20 backdrop-blur-md px-2.5 py-0.5 rounded-full mb-2 border border-amber-300/30">
                            Kelas Pemula
                        </span>
                        <h4 class="text-base font-bold text-white leading-snug">Pengenalan Air Ceria</h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2">Latihan motorik dan adaptasi air dengan
                            suasana riang serta dampingan penuh pelatih.</p>
                    </div>
                </div>

                <!-- Galeri 2 -->
                <div
                    class="group relative rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 bg-slate-100 border border-slate-100">
                    <div class="h-64 sm:h-72 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/teknik.jpeg')) ? asset('images/teknik.jpeg') : (file_exists(public_path('images/teknik.jpg')) ? asset('images/teknik.jpg') : asset('images/teknik.png')) }}"
                            alt="Koreksi Teknik Renang"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <span
                            class="inline-block self-start text-[10px] font-bold uppercase tracking-wider text-cyan-300 bg-cyan-400/20 backdrop-blur-md px-2.5 py-0.5 rounded-full mb-2 border border-cyan-300/30">
                            Teknik 4 Gaya
                        </span>
                        <h4 class="text-base font-bold text-white leading-snug">Penguasaan Gaya Renang</h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2">Fokus pada kayuhan efektif, streamline
                            tubuh, dan efisiensi tarikan napas.</p>
                    </div>
                </div>

                <!-- Galeri 3 -->
                <div
                    class="group relative rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 bg-slate-100 border border-slate-100">
                    <div class="h-64 sm:h-72 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/atelet.jpeg')) ? asset('images/atelet.jpeg') : (file_exists(public_path('images/atelet.jpg')) ? asset('images/atelet.jpg') : asset('images/atelet.png')) }}"
                            alt="Pembinaan Atlet Muda"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <span
                            class="inline-block self-start text-[10px] font-bold uppercase tracking-wider text-emerald-300 bg-emerald-400/20 backdrop-blur-md px-2.5 py-0.5 rounded-full mb-2 border border-emerald-300/30">
                            Jalur Prestasi
                        </span>
                        <h4 class="text-base font-bold text-white leading-snug">Pembinaan Atlet Muda</h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2">Program latihan intensif untuk persiapan
                            kejuaraan renang antarpelajar dan daerah.</p>
                    </div>
                </div>

                <!-- Galeri 4 -->
                <div
                    class="group relative rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 bg-slate-100 border border-slate-100">
                    <div class="h-64 sm:h-72 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/higienis.jpeg')) ? asset('images/higienis.jpeg') : (file_exists(public_path('images/higienis.jpg')) ? asset('images/higienis.jpg') : asset('images/higienis.png')) }}"
                            alt="Fasilitas Kolam Renang Bersih"
                            style="object-position: center top; transform: scale(1.18); transform-origin: center top;"
                            class="w-full h-full object-cover object-top group-hover:scale-125 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <span
                            class="inline-block self-start text-[10px] font-bold uppercase tracking-wider text-sky-300 bg-sky-400/20 backdrop-blur-md px-2.5 py-0.5 rounded-full mb-2 border border-sky-300/30">
                            Fasilitas
                        </span>
                        <h4 class="text-base font-bold text-white leading-snug">Kolam Renang Nyaman & Jernih</h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2">Sirkulasi air terawat dengan baik menjamin
                            kenyamanan anak saat berenang berjam-jam.</p>
                    </div>
                </div>

                <!-- Galeri 5 -->
                <div
                    class="group relative rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 bg-slate-100 border border-slate-100">
                    <div class="h-64 sm:h-72 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/safety.jpeg')) ? asset('images/safety.jpeg') : (file_exists(public_path('images/safety.jpg')) ? asset('images/safety.jpg') : asset('images/safety.png')) }}"
                            alt="Water Safety & Ketahanan Air"
                            style="object-position: center 85%; transform: scale(1.35); transform-origin: center 85%;"
                            class="w-full h-full object-cover group-hover:scale-145 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <span
                            class="inline-block self-start text-[10px] font-bold uppercase tracking-wider text-indigo-300 bg-indigo-400/20 backdrop-blur-md px-2.5 py-0.5 rounded-full mb-2 border border-indigo-300/30">
                            Water Safety
                        </span>
                        <h4 class="text-base font-bold text-white leading-snug">Keterampilan Bertahan di Air</h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2">Edukasi menyelamatkan diri (water safety
                            skills) sebagai proteksi utama anak.</p>
                    </div>
                </div>

                <!-- Galeri 6 -->
                <div
                    class="group relative rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 bg-slate-100 border border-slate-100">
                    <div class="h-64 sm:h-72 overflow-hidden">
                        <img src="{{ file_exists(public_path('images/sahabat.jpeg')) ? asset('images/sahabat.jpeg') : (file_exists(public_path('images/sahabat.jpg')) ? asset('images/sahabat.jpg') : asset('images/sahabat.png')) }}"
                            alt="Kekompakan & Sesi Latihan Bersama"
                            style="object-position: center bottom; transform: scale(1.1); transform-origin: center bottom;"
                            class="w-full h-full object-cover object-bottom group-hover:scale-120 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <span
                            class="inline-block self-start text-[10px] font-bold uppercase tracking-wider text-pink-300 bg-pink-400/20 backdrop-blur-md px-2.5 py-0.5 rounded-full mb-2 border border-pink-300/30">
                            Kebersamaan
                        </span>
                        <h4 class="text-base font-bold text-white leading-snug">Komunitas Positif & Sahabat Baru</h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2">Membangun sportivitas, mental tangguh, dan
                            pertemanan sehat antar-sesama siswa.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section Profil Pelatih (1 Baris Slide Horizontal) -->
    <section id="pelatih" class="bg-slate-50 py-16 px-6 lg:px-8 border-b border-gray-100">
        <div class="mx-auto max-w-7xl relative">
            <div class="text-center mb-10">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-wider text-[#008cc9] bg-cyan-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Instruktur Profesional
                </span>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Profil Pelatih</h2>
                <p class="mt-2 text-sm sm:text-base text-gray-500">Pelatih berpengalaman dan bersertifikasi di Gajah
                    Depa Akuatik</p>
            </div>

            <div class="relative group/slider">
                <!-- Tombol Slide Kiri -->
                <button type="button"
                    onclick="document.getElementById('pelatihSlider').scrollBy({ left: -280, behavior: 'smooth' })"
                    aria-label="Geser Kiri"
                    class="hidden sm:flex absolute -left-3 lg:-left-5 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-cyan-200 text-[#008cc9] hover:bg-[#008cc9] hover:text-white shadow-md items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>

                <!-- Container 1 Baris Horizontal -->
                <div id="pelatihSlider"
                    class="flex items-stretch gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 pt-1 px-1 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    @foreach(($data_pelatih ?? []) as $pelatih)
                        @php
                            $fotoPelatihUrl = (!empty($pelatih->foto) && file_exists(public_path($pelatih->foto)))
                                ? asset($pelatih->foto)
                                : null;
                            $inisialPelatih = strtoupper(collect(explode(' ', $pelatih->nama))->map(fn($w) => substr($w, 0, 1))->implode(''));
                            $inisialPelatih = substr($inisialPelatih, 0, 2) ?: 'PL';
                        @endphp
                        <div
                            class="w-48 sm:w-56 shrink-0 snap-start rounded-[24px] bg-white p-5 shadow-sm border border-cyan-100 hover:border-cyan-400 hover:shadow-md transition-all duration-300 flex flex-col items-center justify-center text-center group">
                            <div
                                class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-2 border-cyan-200 group-hover:border-[#008cc9] shadow-sm mb-4 bg-gradient-to-br from-[#00b4db] to-[#0083b0] flex items-center justify-center text-white font-extrabold text-2xl shrink-0 transition">
                                @if($fotoPelatihUrl)
                                    <img src="{{ $fotoPelatihUrl }}" alt="{{ $pelatih->nama }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span>{{ $inisialPelatih }}</span>
                                @endif
                            </div>
                            <h3
                                class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-[#008cc9] leading-snug transition">
                                {{ $pelatih->nama }}
                            </h3>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Slide Kanan -->
                <button type="button"
                    onclick="document.getElementById('pelatihSlider').scrollBy({ left: 280, behavior: 'smooth' })"
                    aria-label="Geser Kanan"
                    class="hidden sm:flex absolute -right-3 lg:-right-5 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-cyan-200 text-[#008cc9] hover:bg-[#008cc9] hover:text-white shadow-md items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>
    </section>

    <section id="cabang" class="mx-auto max-w-7xl py-16 px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Cabang Kami</h2>
            <p class="mt-3 text-lg text-gray-500">Pilih cabang untuk melihat program dan kelas yang tersedia</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($data_cabang as $cabang)
                @php
                    $namaCabangLower = strtolower($cabang->nama);
                    $fotoCabang = null;

                    if (str_contains($namaCabangLower, 'darmaraja')) {
                        if (file_exists(public_path('images/darmaraja.jpeg'))) {
                            $fotoCabang = asset('images/darmaraja.jpeg');
                        } elseif (file_exists(public_path('images/darmaraja.jpg'))) {
                            $fotoCabang = asset('images/darmaraja.jpg');
                        } elseif (file_exists(public_path('images/darmaraja.png'))) {
                            $fotoCabang = asset('images/darmaraja.png');
                        }
                    } elseif (str_contains($namaCabangLower, 'cimanggung')) {
                        if (file_exists(public_path('images/cimanggung.jpg'))) {
                            $fotoCabang = asset('images/cimanggung.jpg');
                        } elseif (file_exists(public_path('images/cimanggung.jpeg'))) {
                            $fotoCabang = asset('images/cimanggung.jpeg');
                        } elseif (file_exists(public_path('images/cimanggung.png'))) {
                            $fotoCabang = asset('images/cimanggung.png');
                        }
                    } elseif (str_contains($namaCabangLower, 'sumedang')) {
                        if (file_exists(public_path('images/sumedang.jpeg'))) {
                            $fotoCabang = asset('images/sumedang.jpeg');
                        } elseif (file_exists(public_path('images/sumedang.jpg'))) {
                            $fotoCabang = asset('images/sumedang.jpg');
                        } elseif (file_exists(public_path('images/sumedang.png'))) {
                            $fotoCabang = asset('images/sumedang.png');
                        }
                    }

                    if (!$fotoCabang) {
                        $fotoCabang = 'https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?auto=format&fit=crop&w=600&q=80';
                    }
                @endphp
                <div onclick="selectBranch('{{ $cabang->id }}', '{{ $cabang->nama }}')"
                    class="cursor-pointer rounded-[24px] bg-white shadow-sm border border-cyan-100 hover:border-cyan-400 hover:shadow-xl transition-all duration-300 flex flex-col justify-between group relative overflow-hidden text-center">

                    <!-- Foto Kolam Cabang -->
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ $fotoCabang }}" alt="{{ $cabang->nama }}"
                            style="{{ str_contains($namaCabangLower, 'darmaraja') ? 'object-position: center bottom;' : (str_contains($namaCabangLower, 'sumedang') ? 'object-position: center 60%;' : 'object-position: center center;') }}"
                            class="w-full h-full object-cover {{ str_contains($namaCabangLower, 'darmaraja') ? 'object-bottom' : 'object-center' }} group-hover:scale-108 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/25 to-transparent">
                        </div>
                        <span
                            class="absolute top-3 left-3 text-[11px] font-bold uppercase tracking-wider text-cyan-800 bg-white/95 backdrop-blur-md px-3 py-1 rounded-full border border-white/60 shadow-sm">
                            Cabang #{{ $cabang->id }}
                        </span>
                        <div class="absolute bottom-3 left-4 right-4 text-left">
                            <h3 class="text-lg font-bold text-white drop-shadow-sm group-hover:text-cyan-200 transition">
                                {{ $cabang->nama }}
                            </h3>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col items-center text-center">

                        <!-- Alamat / Lokasi Kolam -->
                        <div class="text-xs sm:text-sm text-slate-700 mb-4 leading-relaxed w-full">
                            <div class="space-y-1.5 font-medium">
                                @foreach(explode("\n", str_replace("\r", "", $cabang->alamat)) as $lokasi)
                                    @if(trim($lokasi) !== '')
                                        <div class="flex items-center justify-center gap-1.5">
                                            <i class="fa-solid fa-location-dot text-cyan-500 text-xs shrink-0"></i>
                                            <span>{{ trim($lokasi) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Jadwal Sesi Latihan -->
                        @if($cabang->jadwals && $cabang->jadwals->count() > 0)
                            <div class="space-y-2 pt-3 border-t border-slate-100 mb-4 w-full">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jadwal Sesi Latihan:
                                </p>
                                <div class="space-y-1.5">
                                    @foreach($cabang->jadwals->unique('hari') as $jadwal)
                                        <p class="text-xs text-slate-700 font-medium flex items-center justify-center gap-1.5">
                                            <i class="fa-regular fa-clock text-cyan-500 text-xs shrink-0"></i>
                                            <span><strong>{{ $jadwal->hari }}</strong>{{ !empty(trim($jadwal->jam)) ? ': ' . $jadwal->jam : '' }}</span>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Klik ke WhatsApp Admin -->
                        @if(!empty($cabang->no_whatsapp))
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $cabang->no_whatsapp);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                                $pesanWa = rawurlencode("Halo Admin {$cabang->nama}, saya ingin bertanya seputar jadwal dan pendaftaran renang.");
                            @endphp
                            <div class="mt-auto pt-3 border-t border-slate-100 w-full">
                                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $pesanWa }}" target="_blank"
                                    rel="noopener noreferrer" onclick="event.stopPropagation()"
                                    class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-3 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200 hover:border-emerald-600 font-semibold text-xs transition-all duration-200 shadow-2xs group/wa">
                                    <i
                                        class="fa-brands fa-whatsapp text-emerald-500 group-hover/wa:text-white text-base transition-colors"></i>
                                    <span>Hubungi WhatsApp Admin</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div id="empty-branch-state"
            class="mt-12 flex flex-col items-center justify-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-2xl bg-white shadow-sm">
            <div class="h-12 w-12 rounded-full bg-cyan-50 flex items-center justify-center text-[#008cc9] text-xl mb-3">
                <i class="fa-solid fa-location-crosshairs"></i>
            </div>
            <p class="text-lg font-semibold text-gray-900">Pilih cabang terlebih dahulu</p>
            <p class="text-sm text-gray-400 text-center mt-1">Klik salah satu kartu cabang di atas untuk memunculkan
                daftar pilihan program & kelas renang yang tersedia.</p>
        </div>

    </section>

    <section id="program" class="hidden bg-white py-20 px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="text-center mb-14 pb-8 border-b border-gray-100 flex flex-col items-center">
                <span id="selected-branch-badge"
                    class="inline-block text-xs font-bold tracking-widest text-[#008cc9] uppercase bg-cyan-100 px-4 py-1.5 rounded-full mb-3 shadow-2xs">
                    CABANG BELUM DIPILIH
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Program & Kelas
                </h2>

                {{-- Kotak Informasi Biaya Pendaftaran (Di Bawah Judul, Rata Tengah / Center) --}}
                <div class="mt-6 w-full flex justify-center">
                    @foreach($data_cabang as $cb)
                        <div class="info-pendaftaran-box hidden rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50/70 border border-amber-200/90 px-6 py-4 shadow-xs transition-all duration-300 text-center max-w-2xl"
                            data-cabang="{{ $cb->id }}">
                            <div class="flex items-center justify-center gap-2 mb-3">
                                <div
                                    class="w-7 h-7 rounded-lg bg-amber-500/15 text-amber-700 flex items-center justify-center shrink-0 border border-amber-200">
                                    <i class="fa-solid fa-tags text-xs"></i>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider text-amber-900">
                                    Biaya Pendaftaran:
                                </span>
                            </div>
                            <div
                                class="flex flex-wrap items-center justify-center gap-3 text-xs sm:text-sm font-semibold text-slate-800">
                                @foreach(explode("\n", str_replace("\r", "", $cb->info_pendaftaran)) as $line)
                                    @if(trim($line) !== '')
                                        <div
                                            class="inline-flex items-center gap-2 bg-white/85 px-3.5 py-1.5 rounded-full border border-amber-200/80 shadow-2xs">
                                            <i class="fa-solid fa-circle-check text-amber-600 text-xs shrink-0"></i>
                                            <span>{{ str_starts_with(trim($line), 'Rp') ? trim($line) : 'Rp ' . trim($line) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 justify-center items-stretch">
                @foreach($data_kelas as $kelas)

                    @php
                        // 🧠 JAVASCRIPT & BLADE: Tema warna konsisten dengan Biru Awal Banner Hero (#00b4db ke #0083b0)
                        $namaLower = strtolower($kelas->nama);
                        $headerClass = 'bg-gradient-to-r from-[#00b4db] to-[#0083b0]';
                        $btnClass = 'bg-[#008cc9] hover:bg-cyan-600';
                        $isPopular = false;

                        // 💡 Memecah paragraf database menjadi baris bercentang (berdasarkan baris baru)
                        $cleanedDesc = str_replace("\r", "", $kelas->deskripsi);
                        $perks = array_filter(array_map('trim', explode("\n", $cleanedDesc)));
                        $isPemulaSumedang = ($kelas->id_cabang == 1 && (str_contains($namaLower, 'pemula a') || str_contains($namaLower, 'pemula b')));
                        $isPemulaB = str_contains($namaLower, 'pemula b');
                        $activePillColor = 'bg-[#008cc9]';
                        $isLanjutanOrSeniorSumedang = ($kelas->id_cabang == 1 && (str_contains($namaLower, 'lanjutan') || str_contains($namaLower, 'senior')));
                        $isLanjutan = str_contains($namaLower, 'lanjutan');

                        // Khusus Cabang 2 (Darmaraja)
                        $isDarmaraja = ($kelas->id_cabang == 2);
                        $isPemulaDarmaraja = ($isDarmaraja && (str_contains($namaLower, 'pemula a') || str_contains($namaLower, 'pemula b')));
                        $isLanjutanOrPrestasiDarmaraja = ($isDarmaraja && (str_contains($namaLower, 'lanjutan') || str_contains($namaLower, 'prestasi') || str_contains($namaLower, 'senior')));

                        // Khusus Cabang 3 (Cimanggung)
                        $isCimanggung = ($kelas->id_cabang == 3);
                        $cardCustomClass = $isCimanggung ? 'sm:col-span-2 lg:col-span-2 lg:col-start-2 max-w-lg mx-auto w-full' : '';
                    @endphp

                    <div class="kelas-card flex flex-col rounded-[24px] bg-white shadow-sm border border-gray-200 overflow-hidden transform hover:-translate-y-1 transition duration-300 {{ $cardCustomClass }}"
                        data-cabang="{{ $kelas->id_cabang }}">

                        <div class="p-6 {{ $headerClass }} text-white">
                            <h3 class="text-xl font-bold tracking-wide">{{ $kelas->nama }}</h3>
                            <p class="text-xs mt-1 opacity-90 font-light">Gajah Depa Akuatik</p>
                        </div>

                        <div class="p-6 flex flex-col flex-1 justify-between bg-white">
                            <div class="space-y-4">
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span id="price-display-{{ $kelas->id }}"
                                            class="text-3xl font-extrabold text-gray-900 transition-all duration-200">
                                            Rp {{ number_format($kelas->harga, 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm font-medium text-gray-400">
                                            {{ $kelas->harga <= 50000 ? '/ pertemuan' : '/ bulan' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Khusus Kelas Pemula A & Pemula B Cabang 1: Pilihan Paket 4 / 8 / 12 Pertemuan Dinamis
                                --}}
                                @if($isPemulaSumedang)
                                    <div class="rounded-2xl bg-cyan-50/70 p-3.5 border border-cyan-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="block text-[11px] font-bold text-cyan-900 uppercase tracking-wider flex items-center gap-1.5">
                                                <i class="fa-solid fa-layer-group text-cyan-600"></i>
                                                Pilihan Paket:
                                            </span>
                                            <span
                                                class="text-[10px] text-cyan-700 font-semibold lowercase bg-cyan-100 px-2 py-0.5 rounded-full">pertemuan
                                                / sesi</span>
                                        </div>

                                        {{-- Tab Tombol Pilihan Sesi Cepat (Hanya Angka 4, 8, 12) --}}
                                        <div
                                            class="grid grid-cols-3 gap-1.5 p-1 bg-white/90 rounded-xl border border-cyan-200/60 shadow-2xs">
                                            <button type="button"
                                                onclick="setPemulaPackage({{ $kelas->id }}, '100000', '{{ $activePillColor }}')"
                                                id="btn-pkg-{{ $kelas->id }}-100000"
                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center {{ $activePillColor }} text-white shadow-xs">
                                                4
                                            </button>
                                            <button type="button"
                                                onclick="setPemulaPackage({{ $kelas->id }}, '150000', '{{ $activePillColor }}')"
                                                id="btn-pkg-{{ $kelas->id }}-150000"
                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center text-slate-600 hover:bg-cyan-50 hover:text-cyan-800">
                                                8
                                            </button>
                                            <button type="button"
                                                onclick="setPemulaPackage({{ $kelas->id }}, '180000', '{{ $activePillColor }}')"
                                                id="btn-pkg-{{ $kelas->id }}-180000"
                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center text-slate-600 hover:bg-cyan-50 hover:text-cyan-800">
                                                12
                                            </button>
                                        </div>

                                        {{-- Hidden select untuk sinkronisasi form pendaftaran --}}
                                        <select id="package-select-{{ $kelas->id }}" class="hidden">
                                            <option value="100000" selected>4 Pertemuan / bulan (Senin, Rabu & Sabtu)</option>
                                            <option value="150000">8 Pertemuan / bulan (Senin, Rabu & Sabtu)</option>
                                            <option value="180000">12 Pertemuan / bulan (Senin, Rabu & Sabtu)</option>
                                        </select>
                                    </div>

                                    {{-- Deskripsi Program Secara General --}}
                                    <div class="rounded-2xl bg-sky-50/70 border border-sky-100/90 p-3.5 shadow-2xs">
                                        <p id="desc-display-{{ $kelas->id }}"
                                            class="text-xs text-slate-600 leading-relaxed font-medium">
                                            {{ $isPemulaB ? 'Tahap transisi untuk mulai mendalami teknik renang dasar secara mandiri, rapi, dan terarah' : 'Pengenalan air dengan metode bermain yang aman, menyenangkan, dan membangun rasa percaya diri anak' }}
                                        </p>
                                    </div>

                                    {{-- Info untuk Pertemuan yang Dipilih --}}
                                    <div class="border-t border-gray-100 pt-3">
                                        <div class="flex items-center justify-between mb-2.5">
                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                                Info Paket Terpilih:
                                            </span>
                                            <span id="badge-sesi-{{ $kelas->id }}"
                                                class="text-[10px] font-extrabold text-[#0083b0] bg-cyan-50 border-cyan-100 px-2 py-0.5 rounded-full border">
                                                4 Pertemuan / bulan
                                            </span>
                                        </div>
                                        <ul id="perks-display-{{ $kelas->id }}"
                                            class="space-y-2.5 text-xs sm:text-[13px] text-gray-600 transition-opacity duration-200">
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i
                                                    class="fa-solid fa-calendar-check text-indigo-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700 font-semibold">4 Pertemuan / bulan</span>
                                            </li>
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i
                                                    class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700"><strong>Senin & Rabu:</strong> Kolam Renang Gajah
                                                    Depa</span>
                                            </li>
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i
                                                    class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700"><strong>Sabtu:</strong> Kolam Renang Hanjuang
                                                    Hegar</span>
                                            </li>
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i class="fa-regular fa-clock text-amber-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700">Jam <strong>15.00 WIB</strong> (Durasi 60
                                                    Menit)</span>
                                            </li>
                                        </ul>
                                    </div>
                                @elseif($isLanjutanOrSeniorSumedang)
                                                    {{-- Khusus Kelas Lanjutan & Senior Cabang 1: Pilihan Paket 12 / 16 Pertemuan --}}
                                                    <div class="rounded-2xl bg-cyan-50/70 p-3.5 border border-cyan-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span
                                                                class="block text-[11px] font-bold text-cyan-900 uppercase tracking-wider flex items-center gap-1.5">
                                                                <i class="fa-solid fa-layer-group text-cyan-600"></i>
                                                                Pilihan Paket:
                                                            </span>
                                                            <span
                                                                class="text-[10px] text-cyan-700 font-semibold lowercase bg-cyan-100 px-2 py-0.5 rounded-full">pertemuan
                                                                / sesi</span>
                                                        </div>

                                                        {{-- Tab Tombol Pilihan Sesi (12 & 16 Pertemuan) --}}
                                                        <div
                                                            class="grid grid-cols-2 gap-1.5 p-1 bg-white/90 rounded-xl border border-cyan-200/60 shadow-2xs">
                                                            <button type="button"
                                                                onclick="setLanjutanSeniorPackage({{ $kelas->id }}, '180000', '{{ $activePillColor }}')"
                                                                id="btn-pkg-{{ $kelas->id }}-180000"
                                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1.5 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center {{ $activePillColor }} text-white shadow-xs">
                                                                12
                                                            </button>
                                                            <button type="button"
                                                                onclick="setLanjutanSeniorPackage({{ $kelas->id }}, '250000', '{{ $activePillColor }}')"
                                                                id="btn-pkg-{{ $kelas->id }}-250000"
                                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1.5 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center text-slate-600 hover:bg-cyan-50 hover:text-cyan-800">
                                                                16
                                                            </button>
                                                        </div>

                                                        {{-- Hidden select untuk sinkronisasi form pendaftaran --}}
                                                        <select id="package-select-{{ $kelas->id }}" class="hidden">
                                                            <option value="180000" selected>12 Pertemuan / bulan</option>
                                                            <option value="250000">16 Pertemuan / bulan</option>
                                                        </select>
                                                    </div>

                                                    {{-- Deskripsi Program Secara General --}}
                                                    <div class="rounded-2xl bg-sky-50/70 border border-sky-100/90 p-3.5 shadow-2xs">
                                                        <p id="desc-display-{{ $kelas->id }}"
                                                            class="text-xs text-slate-600 leading-relaxed font-medium">
                                                            {{ $isLanjutan
                                    ? 'Penyempurnaan 4 teknik gaya renang, efisiensi kayuhan dan napas, serta penguatan stamina untuk persiapan perlombaan'
                                    : 'Penajaman kecepatan 4 gaya, efisiensi teknik start dan pembalikan, serta pembentukan daya tahan atlet untuk mencetak limit waktu terbaik' }}
                                                        </p>
                                                    </div>

                                                    {{-- Info untuk Pertemuan yang Dipilih --}}
                                                    <div class="border-t border-gray-100 pt-3">
                                                        <div class="flex items-center justify-between mb-2.5">
                                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                                                Jadwal & Info Latihan:
                                                            </span>
                                                            <span id="badge-sesi-{{ $kelas->id }}"
                                                                class="text-[10px] font-extrabold text-[#0083b0] bg-cyan-50 border-cyan-100 px-2 py-0.5 rounded-full border">
                                                                12 Pertemuan / bulan
                                                            </span>
                                                        </div>
                                                        <ul id="perks-display-{{ $kelas->id }}"
                                                            class="space-y-2.5 text-xs sm:text-[13px] text-gray-600 transition-opacity duration-200">
                                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                                <i
                                                                    class="fa-solid fa-calendar-check text-indigo-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                                <span class="text-slate-700 font-semibold">12 Pertemuan / bulan</span>
                                                            </li>
                                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                                <i
                                                                    class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                                <span class="text-slate-700">
                                                                    <strong>Selasa, Kamis & Sabtu:</strong> Kolam Renang Hanjuang Hegar
                                                                    <span class="text-slate-500 block text-[11px] mt-0.5 font-normal">
                                                                        <i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 16.00 WIB
                                                                        (Durasi 90–120 Menit)
                                                                    </span>
                                                                </span>
                                                            </li>
                                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                                <i
                                                                    class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                                <span class="text-slate-700">
                                                                    <strong>Minggu:</strong> Kolam Renang Tirta Mas Kiansantang
                                                                    <span class="text-slate-500 block text-[11px] mt-0.5 font-normal">
                                                                        <i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 14.00 WIB
                                                                        (Durasi 90–120 Menit)
                                                                    </span>
                                                                </span>
                                                            </li>
                                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                                <i
                                                                    class="fa-solid fa-person-running text-emerald-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                                <span class="text-slate-700">
                                                                    <strong>Jumat:</strong> Lapang IPP Sumedang (Dryland)
                                                                    <span class="text-slate-500 block text-[11px] mt-0.5 font-normal">
                                                                        <i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 16.00 WIB
                                                                        (Durasi 60 Menit)
                                                                    </span>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                @elseif($isDarmaraja)
                                    {{-- Khusus Cabang 2: SSC Gajah Depa Darmaraja --}}

                                    {{-- Deskripsi Program (Sama dengan Sumedang) --}}
                                    <div class="rounded-2xl bg-sky-50/70 border border-sky-100/90 p-3.5 shadow-2xs">
                                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                            {{ $kelas->deskripsi }}
                                        </p>
                                    </div>

                                    {{-- Jadwal & Info Latihan --}}
                                    <div class="border-t border-gray-100 pt-3">
                                        <div class="mb-2.5">
                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                                Jadwal & Info Latihan:
                                            </span>
                                        </div>
                                        <ul class="space-y-2.5 text-xs sm:text-[13px] text-gray-600">
                                            @if($isPemulaDarmaraja)
                                                <li class="flex items-start gap-x-2.5 leading-tight">
                                                    <i
                                                        class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                    <span class="text-slate-700"><strong>Kamis & Minggu:</strong> Kolam Renang
                                                        Diffa</span>
                                                </li>
                                                <li class="flex items-start gap-x-2.5 leading-tight">
                                                    <i class="fa-regular fa-clock text-amber-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                    <span class="text-slate-700">Jam <strong>15.00 WIB</strong> (Durasi 1
                                                        Jam)</span>
                                                </li>
                                            @elseif($isLanjutanOrPrestasiDarmaraja)
                                                <li class="flex items-start gap-x-2.5 leading-tight">
                                                    <i
                                                        class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                    <span class="text-slate-700"><strong>Selasa:</strong> Kolam Renang Sutra Muda
                                                        Tirta</span>
                                                </li>
                                                <li class="flex items-start gap-x-2.5 leading-tight">
                                                    <i
                                                        class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                    <span class="text-slate-700"><strong>Kamis & Minggu:</strong> Kolam Renang
                                                        Diffa</span>
                                                </li>
                                                <li class="flex items-start gap-x-2.5 leading-tight">
                                                    <i class="fa-regular fa-clock text-amber-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                    <span class="text-slate-700">Jam <strong>15.00 WIB</strong> (Durasi 1
                                                        Jam)</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    {{-- Hidden select untuk sinkronisasi modal pendaftaran --}}
                                    <select id="package-select-{{ $kelas->id }}" class="hidden">
                                        <option value="{{ $kelas->harga }}" selected>Per Pertemuan</option>
                                    </select>
                                @elseif($isCimanggung)
                                    {{-- Khusus Cabang 3 (Cimanggung): 1 Kelas Pemula dengan 2 Pilihan Paket Dinamis --}}
                                    <div class="rounded-2xl bg-cyan-50/70 p-3.5 border border-cyan-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="block text-[11px] font-bold text-cyan-900 uppercase tracking-wider flex items-center gap-1.5">
                                                <i class="fa-solid fa-layer-group text-cyan-600"></i>
                                                Pilihan Paket:
                                            </span>
                                            <span
                                                class="text-[10px] text-cyan-700 font-semibold lowercase bg-cyan-100 px-2 py-0.5 rounded-full">pertemuan
                                                / sesi</span>
                                        </div>

                                        {{-- Tab Tombol Pilihan Sesi Cepat (Hanya Angka 4 dan 8) --}}
                                        <div
                                            class="grid grid-cols-2 gap-1.5 p-1 bg-white/90 rounded-xl border border-cyan-200/60 shadow-2xs">
                                            <button type="button"
                                                onclick="setCimanggungPackage({{ $kelas->id }}, '150000', 'bg-[#008cc9]')"
                                                id="btn-pkg-{{ $kelas->id }}-150000"
                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center bg-[#008cc9] text-white shadow-xs">
                                                4
                                            </button>
                                            <button type="button"
                                                onclick="setCimanggungPackage({{ $kelas->id }}, '200000', 'bg-[#008cc9]')"
                                                id="btn-pkg-{{ $kelas->id }}-200000"
                                                class="pkg-pill-btn-{{ $kelas->id }} py-2 px-1 rounded-lg text-xs sm:text-sm font-extrabold transition-all duration-200 text-center text-slate-600 hover:bg-cyan-50 hover:text-cyan-800">
                                                8
                                            </button>
                                        </div>

                                        {{-- Hidden select untuk sinkronisasi form pendaftaran --}}
                                        <select id="package-select-{{ $kelas->id }}" class="hidden">
                                            <option value="150000" selected>4 Pertemuan / bulan (Senin/ Kamis : Kolam Renang
                                                Cibogo Indah - Durasi 60 menit) - Rp 150.000</option>
                                            <option value="200000">8 Pertemuan / bulan (Senin dan Kamis : Kolam Renang Cibogo
                                                Indah - Durasi 60 menit) - Rp 200.000</option>
                                        </select>
                                    </div>

                                    {{-- Deskripsi Program Secara General --}}
                                    <div class="rounded-2xl bg-sky-50/70 border border-sky-100/90 p-3.5 shadow-2xs">
                                        <p id="desc-display-{{ $kelas->id }}"
                                            class="text-xs text-slate-600 leading-relaxed font-medium">
                                            Pengenalan air dengan metode bermain yang aman, menyenangkan, serta membangun rasa
                                            percaya diri dan kemandirian anak dalam berenang.
                                        </p>
                                    </div>

                                    {{-- Info untuk Pertemuan yang Dipilih --}}
                                    <div class="border-t border-gray-100 pt-3">
                                        <div class="flex items-center justify-between mb-2.5">
                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                                Info Paket Terpilih:
                                            </span>
                                            <span id="badge-sesi-{{ $kelas->id }}"
                                                class="text-[10px] font-extrabold text-[#0083b0] bg-cyan-50 border-cyan-100 px-2 py-0.5 rounded-full border">
                                                4 Pertemuan / bulan
                                            </span>
                                        </div>
                                        <ul id="perks-display-{{ $kelas->id }}"
                                            class="space-y-2.5 text-xs sm:text-[13px] text-gray-600 transition-opacity duration-200">
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i
                                                    class="fa-solid fa-calendar-check text-indigo-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700 font-semibold">4 Pertemuan / bulan</span>
                                            </li>
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i
                                                    class="fa-solid fa-location-dot text-cyan-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700"><strong>Senin/ Kamis :</strong> Kolam Renang Cibogo
                                                    Indah</span>
                                            </li>
                                            <li class="flex items-start gap-x-2.5 leading-tight">
                                                <i class="fa-regular fa-clock text-amber-500 mt-0.5 text-xs flex-shrink-0"></i>
                                                <span class="text-slate-700">Durasi <strong>60 menit</strong></span>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <ul class="space-y-2.5 text-sm text-gray-600 border-t border-gray-100 pt-4">
                                        @foreach($perks as $perk)
                                            @if(trim($perk) != '')
                                                @php
                                                    $perkLower = strtolower($perk);
                                                    if (str_starts_with($perkLower, 'durasi')) {
                                                        $icon = 'fa-regular fa-clock text-amber-500';
                                                    } elseif (str_contains($perkLower, 'kolam') || str_contains($perkLower, 'renang')) {
                                                        $icon = 'fa-solid fa-location-dot text-cyan-500';
                                                    } elseif (str_contains($perkLower, 'pertemuan')) {
                                                        $icon = 'fa-solid fa-calendar-check text-indigo-500';
                                                    } else {
                                                        $icon = 'fa-solid fa-circle-check text-emerald-500';
                                                    }
                                                @endphp
                                                <li class="flex items-start gap-x-2.5 leading-tight text-xs sm:text-[13px]">
                                                    <i class="{{ $icon }} mt-0.5 text-xs flex-shrink-0"></i>
                                                    <span class="text-slate-700">{{ trim($perk) }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </section>
    <section id="daftar" class="bg-[#f8fafc] py-20 px-6 lg:px-8 relative">
        @if(session('sukses'))
            <div id="toast-success"
                class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 bg-white rounded-2xl px-6 py-4 shadow-[0_10px_30px_rgba(0,0,0,0.08)] border border-gray-100 flex items-center gap-x-3 transition-all duration-500 animate-fade-in">
                <div class="h-6 w-6 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="text-sm font-bold text-slate-800 tracking-wide">
                    {{ session('sukses') }}
                </p>
            </div>
        @endif


        <div class="mx-auto max-w-4xl">

            @if(session('nama_siswa'))
                <div
                    class="bg-white rounded-[24px] p-10 md:p-16 shadow-[0_8px_40px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col items-center text-center max-w-xl mx-auto my-10 animate-fade-in">

                    <div
                        class="h-20 w-20 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500 text-3xl mb-8 shadow-inner">
                        <i class="fa-solid fa-check text-4xl"></i>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-6">
                        Pendaftaran Terkirim!
                    </h2>

                    <div class="space-y-4 text-sm md:text-base text-slate-600 tracking-wide max-w-md mb-10 leading-relaxed">
                        <p>Data <strong class="text-slate-900 font-extrabold">{{ session('nama_siswa') }}</strong> telah
                            kami terima.</p>
                        <p class="text-slate-400 font-medium">
                            Tim Gajah Depa akan menghubungi <strong
                                class="text-slate-800 font-bold">{{ session('no_hp') }}</strong> dalam 1×24 jam untuk
                            konfirmasi dan informasi selanjutnya.
                        </p>
                    </div>

                    <a href="#" onclick="resetForm(event)"
                        class="w-full rounded-2xl bg-[#008cc9] py-4 text-center text-base font-bold text-white shadow-md hover:bg-cyan-600 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                        Daftarkan Anggota Lain
                    </a>
                </div>

            @else
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold tracking-tight text-[#1e293b] sm:text-4xl">
                        Pendaftaran Baru
                    </h2>
                    <p class="mt-2 text-base text-gray-500 tracking-wide">
                        Mulai perjalanan renang Anda bersama Gajah Depa
                    </p>
                </div>

                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white rounded-[24px] p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100 space-y-8">
                    @csrf

                    @if ($errors->any())
                        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-600 space-y-1">
                            <p class="font-bold flex items-center gap-2 mb-1 text-red-700">
                                <i class="fa-solid fa-triangle-exclamation"></i> Pendaftaran Gagal. Mohon periksa kembali:
                            </p>
                            <ul class="list-disc pl-5 space-y-0.5 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- SEKSI 1: DATA CALON ANGGOTA --}}
                    <div class="space-y-6">
                        <h3 class="text-xs font-bold tracking-wider text-slate-400 uppercase pb-2 border-b border-gray-100">
                            Data Calon Anggota
                        </h3>

                        {{-- Nama & Tempat Lahir --}}
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Nama Lengkap Siswa <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama_siswa" required value="{{ old('nama_siswa') }}"
                                    placeholder="Sesuai akta kelahiran"
                                    class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-800">Tempat Lahir <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" required value="{{ old('tempat_lahir') }}"
                                    placeholder="Kota tempat lahir"
                                    class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                            </div>
                        </div>

                        {{-- Tanggal Lahir & Level/Kelas --}}
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Tanggal Lahir <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}"
                                    class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-medium text-slate-700 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-800">Asal Sekolah <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="sekolah" required value="{{ old('sekolah') }}"
                                    placeholder="Nama sekolah saat ini"
                                    class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                            </div>
                        </div>

                        {{-- Foto Siswa --}}
                        <div>
                            <label class="text-sm font-bold text-slate-800">Foto Siswa</label>
                            <div
                                class="mt-2 flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-[#f8fafc] px-6 py-5 text-center cursor-pointer relative hover:border-cyan-400 transition group min-h-[140px]">
                                <input type="file" id="foto-siswa-input" name="foto_siswa" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div id="foto-placeholder"
                                    class="flex flex-col items-center justify-center z-10 transition duration-200">
                                    <i
                                        class="fa-solid fa-user-circle text-3xl text-gray-400 mb-2 group-hover:text-cyan-500 transition"></i>
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-cyan-600 transition">Klik
                                        untuk upload foto siswa</p>
                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max. 2MB)</p>
                                </div>
                                <div id="foto-preview-container"
                                    class="hidden flex flex-col items-center justify-center z-10 w-full p-2">
                                    <img id="foto-preview-img" src="" alt="Preview Foto Siswa"
                                        class="max-h-36 rounded-xl object-contain shadow-md border border-gray-100 bg-white p-1">
                                    <p
                                        class="text-xs text-emerald-600 font-bold mt-2.5 flex items-center gap-1 bg-emerald-50 px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-circle-check"></i> Foto berhasil dimuat (klik untuk ganti)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 2: DATA ORANG TUA / WALI --}}
                    <div class="space-y-6 pt-4">
                        <h3 class="text-xs font-bold tracking-wider text-slate-400 uppercase pb-2 border-b border-gray-100">
                            Data Orang Tua / Wali
                        </h3>

                        <div>
                            <label class="text-sm font-bold text-slate-800">Nama Orang Tua / Wali <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_orang_tua" required value="{{ old('nama_orang_tua') }}"
                                placeholder="Nama lengkap ayah / ibu / wali"
                                class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    placeholder="alamat-email@gmail.com"
                                    class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-800">No. WhatsApp <span
                                        class="text-red-500">*</span></label>
                                <div class="relative mt-2">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 font-bold text-sm pointer-events-none">
                                        <i class="fa-brands fa-whatsapp text-green-500 mr-1"></i> +62
                                    </span>
                                    <input type="tel" name="no_hp" required
                                        value="{{ preg_replace('/^(\+?62|0)/', '', old('no_hp', '')) }}"
                                        placeholder="8123456789" id="input_no_hp" oninput="cleanWhatsAppNumber(this)"
                                        onpaste="setTimeout(() => cleanWhatsAppNumber(this), 10)" maxlength="13"
                                        class="w-full rounded-xl border border-transparent bg-[#f1f5f9] py-3.5 pr-3.5 pl-16 text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 3: DATA LATIHAN --}}
                    <div class="space-y-6 pt-4">
                        <h3 class="text-xs font-bold tracking-wider text-slate-400 uppercase pb-2 border-b border-gray-100">
                            Pilihan Latihan
                        </h3>

                        <div>
                            <label class="text-sm font-bold text-slate-800">Cabang Berlatih <span
                                    class="text-red-500">*</span></label>
                            <select id="form-branch-select" name="id_cabang" required
                                onchange="handleCabangChange(this.value)"
                                class="mt-2 w-full rounded-xl border border-transparent bg-[#f1f5f9] p-3.5 text-sm font-bold text-slate-700 focus:border-cyan-400 focus:bg-white focus:outline-none transition-all duration-200 cursor-pointer">
                                <option value="" class="font-medium text-slate-400">-- Pilih Cabang --</option>
                                @foreach($data_cabang as $cabang)
                                    <option value="{{ $cabang->id }}" {{ old('id_cabang') == $cabang->id ? 'selected' : '' }}
                                        class="font-medium">
                                        {{ $cabang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-circle-info text-cyan-600"></i>
                                Penentuan level / kelas latihan akan di-plotting oleh tim admin & pelatih saat verifikasi
                                pendaftaran.
                            </p>
                            <input type="hidden" id="form-program-select" name="id_kelas" value="{{ old('id_kelas', '') }}">
                            <input type="hidden" id="form-package-note" name="catatan_khusus"
                                value="{{ old('catatan_khusus') }}">
                        </div>
                    </div>

                    {{-- SEKSI 4: PEMBAYARAN --}}
                    <div class="space-y-6 pt-4">
                        <h3 class="text-xs font-bold tracking-wider text-slate-400 uppercase pb-2 border-b border-gray-100">
                            Pembayaran
                        </h3>

                        {{-- Pilihan Pembayaran --}}
                        <div>
                            <label class="text-sm font-bold text-slate-800 block mb-3">Metode Pembayaran <span
                                    class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label
                                    class="payment-option relative flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-gray-200 bg-[#f8fafc] p-5 cursor-pointer transition-all duration-200 hover:border-cyan-400 has-[:checked]:border-cyan-500 has-[:checked]:bg-cyan-50 has-[:checked]:shadow-md group">
                                    <input type="radio" name="pilihan_pembayaran" value="cash" class="sr-only" {{ old('pilihan_pembayaran', 'cash') === 'cash' ? 'checked' : '' }}
                                        onchange="toggleBuktiPembayaran(this.value)">
                                    <div
                                        class="w-12 h-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center group-has-[:checked]:border-cyan-500 group-has-[:checked]:bg-cyan-50 transition-all duration-200 shadow-sm">
                                        <i
                                            class="fa-solid fa-money-bill-wave text-gray-400 text-xl group-has-[:checked]:text-cyan-600 transition"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-slate-700 group-has-[:checked]:text-cyan-700">Cash
                                            / Tunai</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Bayar langsung di lokasi</p>
                                    </div>
                                    <div
                                        class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center group-has-[:checked]:border-cyan-500 group-has-[:checked]:bg-cyan-500 transition-all duration-200">
                                        <i
                                            class="fa-solid fa-check text-white text-[9px] opacity-0 group-has-[:checked]:opacity-100"></i>
                                    </div>
                                </label>

                                <label
                                    class="payment-option relative flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-gray-200 bg-[#f8fafc] p-5 cursor-pointer transition-all duration-200 hover:border-cyan-400 has-[:checked]:border-cyan-500 has-[:checked]:bg-cyan-50 has-[:checked]:shadow-md group">
                                    <input type="radio" name="pilihan_pembayaran" value="transfer" class="sr-only" {{ old('pilihan_pembayaran') === 'transfer' ? 'checked' : '' }}
                                        onchange="toggleBuktiPembayaran(this.value)">
                                    <div
                                        class="w-12 h-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center group-has-[:checked]:border-cyan-500 group-has-[:checked]:bg-cyan-50 transition-all duration-200 shadow-sm">
                                        <i
                                            class="fa-solid fa-building-columns text-gray-400 text-xl group-has-[:checked]:text-cyan-600 transition"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-slate-700 group-has-[:checked]:text-cyan-700">
                                            Transfer Bank</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Via rekening bank</p>
                                    </div>
                                    <div
                                        class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center group-has-[:checked]:border-cyan-500 group-has-[:checked]:bg-cyan-500 transition-all duration-200">
                                        <i
                                            class="fa-solid fa-check text-white text-[9px] opacity-0 group-has-[:checked]:opacity-100"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Upload Bukti Pembayaran (muncul hanya jika Transfer) --}}
                        <div id="bukti-pembayaran-section" class="hidden transition-all duration-300">
                            {{-- Info Rekening Transfer Dinamis Berdasarkan Cabang --}}
                            <div class="mb-5 rounded-2xl bg-cyan-50/80 border border-cyan-200/80 p-4 shadow-2xs">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-[#008cc9] text-white flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                                        <i class="fa-solid fa-building-columns text-sm"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span
                                            class="block text-[11px] font-bold text-cyan-800 uppercase tracking-wider mb-1">
                                            Rekening Tujuan Transfer:
                                        </span>
                                        <div id="rekening-display-container">
                                            @foreach($data_cabang as $cb)
                                                <div class="rekening-cabang-item hidden" data-cabang="{{ $cb->id }}">
                                                    @if(!empty(trim($cb->no_rekening ?? '')))
                                                        <p
                                                            class="rekening-number-text text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                                                            {{ $cb->no_rekening }}
                                                        </p>
                                                        <p class="text-xs text-slate-500 mt-0.5">
                                                            Cabang: <strong class="text-slate-700">{{ $cb->nama }}</strong>
                                                        </p>
                                                    @else
                                                        <p class="text-sm font-semibold text-amber-700 flex items-center gap-1.5">
                                                            <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Rekening
                                                            transfer belum tersedia untuk cabang ini.
                                                        </p>
                                                        <p class="text-xs text-slate-500 mt-0.5">
                                                            Cabang: <strong class="text-slate-700">{{ $cb->nama }}</strong>
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                            <div id="rekening-placeholder"
                                                class="text-xs text-amber-700 font-medium flex items-center gap-1.5 py-1">
                                                <i class="fa-solid fa-circle-exclamation text-amber-500"></i>
                                                <span>Pilih cabang berlatih terlebih dahulu untuk melihat rekening
                                                    transfer</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="btn-copy-rekening" onclick="copyRekeningText()"
                                        class="hidden shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-cyan-200 text-cyan-700 hover:bg-cyan-600 hover:text-white hover:border-cyan-600 text-xs font-bold transition-all duration-200 shadow-2xs">
                                        <i class="fa-regular fa-copy"></i>
                                        <span id="copy-btn-label">Salin No. Rek</span>
                                    </button>
                                </div>
                            </div>

                            <label class="text-sm font-bold text-slate-800">Upload Bukti Pembayaran</label>
                            <div
                                class="mt-2 flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-[#f8fafc] px-6 py-6 text-center cursor-pointer relative hover:border-cyan-400 transition group min-h-[140px]">
                                <input type="file" id="form-upload-input" name="bukti_pembayaran" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div id="upload-placeholder"
                                    class="flex flex-col items-center justify-center z-10 transition duration-200">
                                    <i
                                        class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2 group-hover:text-cyan-500 transition"></i>
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-cyan-600 transition">Klik
                                        untuk upload bukti transfer</p>
                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max. 2MB)</p>
                                </div>
                                <div id="upload-preview-container"
                                    class="hidden flex flex-col items-center justify-center z-10 w-full p-2 animate-fade-in">
                                    <img id="upload-preview-img" src="" alt="Preview Bukti Transfer"
                                        class="max-h-44 rounded-xl object-contain shadow-md border border-gray-100 bg-white p-1">
                                    <p
                                        class="text-xs text-emerald-600 font-bold mt-2.5 flex items-center gap-1 bg-emerald-50 px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-circle-check"></i> Foto berhasil dimuat (Klik ulang untuk
                                        mengganti)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full rounded-2xl bg-[#008cc9] py-4 text-center text-base font-bold text-white shadow-md hover:bg-cyan-600 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-x-2 mt-2">
                        <i class="fa-regular fa-paper-plane"></i> Kirim Pendaftaran
                    </button>
                </form>
            @endif

        </div>
    </section>
    <footer class="bg-[#0b1329] text-gray-400 pt-16 pb-8 px-6 lg:px-8 border-t border-slate-900">
        <div class="mx-auto max-w-7xl">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">

                <div class="lg:col-span-4 space-y-4">
                    <h3 class="text-2xl font-bold text-[#008cc9] tracking-wide">
                        Gajah Depa Akuatik
                    </h3>
                    <p class="text-sm leading-relaxed max-w-sm text-slate-400">
                        Club renang terpercaya untuk mengembangkan kemampuan dan prestasi di air
                    </p>
                </div>

                <div class="lg:col-span-4 space-y-3">
                    <h4 class="text-white font-bold text-base mb-4 tracking-wide">Kontak Cabang</h4>
                    <a href="https://wa.me/6281312303829" target="_blank" rel="noopener noreferrer"
                        class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                        <span><strong class="text-white">Sumedang:</strong> 0813-1230-3829</span>
                    </a>
                    <a href="https://wa.me/6285750328172" target="_blank" rel="noopener noreferrer"
                        class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                        <span><strong class="text-white">Darmaraja:</strong> 0857-5032-8172</span>
                    </a>
                    <a href="https://wa.me/6289616732799" target="_blank" rel="noopener noreferrer"
                        class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                        <span><strong class="text-white">Cimanggung:</strong> 0896-1673-2799</span>
                    </a>
                </div>

                <div class="lg:col-span-4 space-y-3">
                    <h4 class="text-white font-bold text-base mb-4 tracking-wide">Ikuti Kami</h4>

                    <div class="space-y-3">
                        <a href="https://www.instagram.com/gajahdepakuatik.smd?psln=Z2hpOHFsb3ZwZDNq" target="_blank"
                            rel="noopener noreferrer"
                            class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                            <i class="fa-brands fa-instagram text-pink-400 text-sm"></i>
                            <span><strong class="text-white">Sumedang:</strong> @gajahdepakuatik.smd</span>
                        </a>

                        <a href="https://www.instagram.com/ssc.gajahdepa?dlrf=MWpoNGlwN3cwNGJobg==" target="_blank"
                            rel="noopener noreferrer"
                            class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                            <i class="fa-brands fa-instagram text-pink-400 text-sm"></i>
                            <span><strong class="text-white">Darmaraja:</strong> @ssc.gajahdepa</span>
                        </a>

                        <a href="https://www.instagram.com/gajahdepacmg?srtk=emJ2OXNiNWJndjg1" target="_blank"
                            rel="noopener noreferrer"
                            class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                            <i class="fa-brands fa-instagram text-pink-400 text-sm"></i>
                            <span><strong class="text-white">Cimanggung:</strong> @gajahdepacmg</span>
                        </a>

                        <a href="https://www.tiktok.com/@gajahdepakuatik?_r=1&_t=ZS-9AroLD9kZuv" target="_blank"
                            rel="noopener noreferrer"
                            class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                            <i class="fa-brands fa-tiktok text-slate-200 text-sm"></i>
                            <span>@gajahdepakuatik</span>
                        </a>
                    </div>
                </div>

            </div>

            <div
                class="mt-12 pt-6 border-t border-slate-800/60 text-center text-xs text-slate-500 tracking-wide flex flex-wrap items-center justify-center gap-x-2 gap-y-1">
                <span>© {{ date('Y') }} Gajah Depa Akuatik Sumedang. All rights reserved.</span>
                <span class="hidden sm:inline text-slate-700">•</span>
                <span>Created by reyhnthra</span>
            </div>

        </div>
    </footer>

    <script>
        function cleanWhatsAppNumber(input) {
            if (!input) return;
            let val = input.value.replace(/[^0-9]/g, '');
            if (val.startsWith('62')) {
                val = val.substring(2);
            }
            while (val.startsWith('0')) {
                val = val.substring(1);
            }
            input.value = val;
        }

        let allProgramOptions = [];

        document.addEventListener("DOMContentLoaded", function () {
            const noHpInput = document.getElementById('input_no_hp');
            if (noHpInput) {
                cleanWhatsAppNumber(noHpInput);
                noHpInput.addEventListener('input', function () { cleanWhatsAppNumber(this); });
                noHpInput.addEventListener('paste', function () { setTimeout(() => cleanWhatsAppNumber(this), 10); });
                noHpInput.addEventListener('blur', function () { cleanWhatsAppNumber(this); });
            }
            // --- 1. MENGUNCI CACHE DROPDOWN PROGRAM (JIKA BERUPA SELECT) ---
            const programSelect = document.getElementById('form-program-select');
            if (programSelect && programSelect.tagName === 'SELECT' && programSelect.options) {
                allProgramOptions = Array.from(programSelect.options);
            }

            const branchSelect = document.getElementById('form-branch-select');
            if (branchSelect) {
                branchSelect.addEventListener('change', function () {
                    handleCabangChange(this.value);
                });
                if (branchSelect.value) {
                    updateRekeningDisplay(branchSelect.value);
                }
            }

            // --- 2. LOGIKA LIVE PREVIEW FOTO SISWA ---
            const fotoSiswaInput = document.getElementById('foto-siswa-input');
            if (fotoSiswaInput) {
                fotoSiswaInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById('foto-preview-img').src = e.target.result;
                            document.getElementById('foto-placeholder').classList.add('hidden');
                            document.getElementById('foto-preview-container').classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // --- 3. LOGIKA LIVE PREVIEW UPLOAD BUKTI TRANSFER ---
            const uploadInput = document.getElementById('form-upload-input');
            const uploadPlaceholder = document.getElementById('upload-placeholder');
            const previewContainer = document.getElementById('upload-preview-container');
            const previewImg = document.getElementById('upload-preview-img');

            if (uploadInput) {
                uploadInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            uploadPlaceholder.classList.add('hidden');
                            previewContainer.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // --- 5. INISIALISASI TOGGLE BUKTI PEMBAYARAN SAAT LOAD ---
            const checkedPayment = document.querySelector('input[name="pilihan_pembayaran"]:checked');
            if (checkedPayment) {
                toggleBuktiPembayaran(checkedPayment.value);
            }

            // --- 6. LOGIKA TOAST HILANG DALAM 5 DETIK ---
            const successToast = document.getElementById('toast-success');
            if (successToast) {
                setTimeout(() => {
                    successToast.style.opacity = '0';
                    successToast.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => {
                        successToast.remove();
                    }, 500);
                }, 5000);
            }

            // --- 7. AUTO-SCROLL KE UTAMA SAAT BERHASIL / ERROR VALIDASI ---
            @if(session('nama_siswa') || $errors->any())
                const daftarSection = document.getElementById('daftar');
                if (daftarSection) {
                    setTimeout(() => {
                        daftarSection.scrollIntoView({ behavior: 'smooth' });
                    }, 300);
                }
            @endif
        });

        // --- 🎯 FUNGSI KUNCI: RESET FORM TANPA URLL BARU ---
        function resetForm(event) {
            event.preventDefault();
            // Set URL agar tetap rapi mengarah ke #daftar tanpa query string aneh
            window.location.href = window.location.origin + window.location.pathname + '#daftar';
            // Paksa reload halaman agar session sukses Laravel terhapus bersih
            window.location.reload();
        }

        // --- FUNGSI HANDLE PERUBAHAN CABANG ---
        function handleCabangChange(branchId) {
            filterProgramDropdown(branchId);
            updateRekeningDisplay(branchId);
        }

        // --- FUNGSI FILTER DROPDOWN ---
        function filterProgramDropdown(branchId) {
            const programSelect = document.getElementById('form-program-select');
            if (!programSelect || programSelect.tagName !== 'SELECT' || allProgramOptions.length === 0) return;

            programSelect.innerHTML = '';
            programSelect.appendChild(allProgramOptions[0]);
            programSelect.value = "";

            if (!branchId) return;

            allProgramOptions.forEach(function (option, index) {
                if (index === 0) return;
                const optionBranchId = option.getAttribute('data-cabang');
                if (optionBranchId === branchId) {
                    programSelect.appendChild(option);
                }
            });
        }

        // --- FUNGSI TOGGLE BUKTI PEMBAYARAN ---
        function toggleBuktiPembayaran(value) {
            const buktiSection = document.getElementById('bukti-pembayaran-section');
            if (!buktiSection) return;
            if (value === 'transfer') {
                buktiSection.classList.remove('hidden');
                buktiSection.style.animation = 'fadeIn 0.3s ease';
                const branchSelect = document.getElementById('form-branch-select');
                if (branchSelect) {
                    updateRekeningDisplay(branchSelect.value);
                }
            } else {
                buktiSection.classList.add('hidden');
            }
        }

        // --- FUNGSI KLIK KARTU CABANG ---
        function selectBranch(branchId, branchName) {
            const emptyState = document.getElementById('empty-branch-state');
            if (emptyState) emptyState.classList.add('hidden');

            const programSection = document.getElementById('program');
            if (programSection) programSection.classList.remove('hidden');

            const badge = document.getElementById('selected-branch-badge');
            if (badge) badge.innerText = "CABANG " + branchName.toUpperCase();

            const branchSelect = document.getElementById('form-branch-select');
            if (branchSelect) branchSelect.value = branchId;

            filterProgramDropdown(branchId);

            document.querySelectorAll('.kelas-card').forEach(card => card.classList.add('hidden'));
            document.querySelectorAll(`.kelas-card[data-cabang="${branchId}"]`).forEach(card => card.classList.remove('hidden'));

            // Tampilkan info pendaftaran cabang yang sesuai di samping judul Program & Kelas
            document.querySelectorAll('.info-pendaftaran-box').forEach(box => box.classList.add('hidden'));
            document.querySelectorAll(`.info-pendaftaran-box[data-cabang="${branchId}"]`).forEach(box => box.classList.remove('hidden'));

            if (String(branchId) === '3') {
                setCimanggungPackage(9, '150000');
            }

            updateRekeningDisplay(branchId);

            if (programSection) {
                programSection.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // --- FUNGSI UPDATE TAMPILAN NO REKENING BERDASARKAN CABANG TERPILIH ---
        function updateRekeningDisplay(branchId) {
            const items = document.querySelectorAll('.rekening-cabang-item');
            const placeholder = document.getElementById('rekening-placeholder');
            const copyBtn = document.getElementById('btn-copy-rekening');

            items.forEach(item => {
                item.classList.add('hidden');
                item.classList.remove('animate-fade-in');
            });

            if (!branchId) {
                if (placeholder) placeholder.classList.remove('hidden');
                if (copyBtn) copyBtn.classList.add('hidden');
                return;
            }

            const targetItem = document.querySelector(`.rekening-cabang-item[data-cabang="${branchId}"]`);
            if (targetItem) {
                targetItem.classList.remove('hidden');
                targetItem.classList.add('animate-fade-in');
                if (placeholder) placeholder.classList.add('hidden');

                const hasValidRekening = targetItem.querySelector('.rekening-number-text') !== null;
                if (copyBtn) {
                    if (hasValidRekening) {
                        copyBtn.classList.remove('hidden');
                    } else {
                        copyBtn.classList.add('hidden');
                    }
                }
            } else {
                if (placeholder) placeholder.classList.remove('hidden');
                if (copyBtn) copyBtn.classList.add('hidden');
            }
        }

        // --- FUNGSI SALIN NOMOR REKENING ---
        function copyRekeningText() {
            const branchSelect = document.getElementById('form-branch-select');
            const branchId = branchSelect ? branchSelect.value : null;
            if (!branchId) return;

            const targetItem = document.querySelector(`.rekening-cabang-item[data-cabang="${branchId}"] .rekening-number-text`)
                || document.querySelector(`.rekening-cabang-item[data-cabang="${branchId}"] p`);
            if (!targetItem) return;

            const fullText = targetItem.innerText.trim();
            const numbersOnly = fullText.match(/\d+/);
            const textToCopy = numbersOnly ? numbersOnly[0] : fullText;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    handleCopyFeedback();
                }).catch(() => fallbackCopy(textToCopy));
            } else {
                fallbackCopy(textToCopy);
            }
        }

        function fallbackCopy(text) {
            const temp = document.createElement('textarea');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            handleCopyFeedback();
        }

        function handleCopyFeedback() {
            const label = document.getElementById('copy-btn-label');
            if (label) {
                const original = label.innerText;
                label.innerText = 'Tersalin!';
                setTimeout(() => {
                    label.innerText = original;
                }, 2000);
            }
        }

        // --- DATA PAKET KELAS PEMULA (SUMEDANG: PEMULA A & B) ---
        const pemulaPackages = {
            '100000': {
                sesi: '4 Pertemuan / bulan',
                price: 100000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">4 Pertemuan / bulan</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Senin & Rabu:</strong> Kolam Renang Gajah Depa' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Sabtu:</strong> Kolam Renang Hanjuang Hegar' },
                    { icon: 'fa-regular fa-clock text-amber-500', text: 'Jam <strong>15.00 WIB</strong> (Durasi 60 Menit)' }
                ]
            },
            '150000': {
                sesi: '8 Pertemuan / bulan',
                price: 150000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">8 Pertemuan / bulan</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Senin & Rabu:</strong> Kolam Renang Gajah Depa' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Sabtu:</strong> Kolam Renang Hanjuang Hegar' },
                    { icon: 'fa-regular fa-clock text-amber-500', text: 'Jam <strong>15.00 WIB</strong> (Durasi 60 Menit)' }
                ]
            },
            '180000': {
                sesi: '12 Pertemuan / bulan',
                price: 180000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">12 Pertemuan / bulan</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Senin & Rabu:</strong> Kolam Renang Gajah Depa' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Sabtu:</strong> Kolam Renang Hanjuang Hegar' },
                    { icon: 'fa-regular fa-clock text-amber-500', text: 'Jam <strong>15.00 WIB</strong> (Durasi 60 Menit)' }
                ]
            }
        };

        // --- FUNGSI UPDATE PAKET KELAS PEMULA A & B (HARGA, BADGE & INFO PERTEMUAN) ---
        function updatePemulaPackage(kelasId, priceValue, activeColorClass = 'bg-[#008cc9]') {
            const pkg = pemulaPackages[priceValue];
            if (!pkg) return;

            // 1. Sinkronkan nilai select dropdown
            const select = document.getElementById('package-select-' + kelasId);
            if (select && select.value !== String(priceValue)) {
                select.value = priceValue;
            }

            // 2. Sinkronkan tombol pill pilihan cepat
            document.querySelectorAll('.pkg-pill-btn-' + kelasId).forEach(btn => {
                btn.classList.remove('bg-blue-600', 'bg-sky-600', 'bg-[#008cc9]', 'text-white', 'shadow-xs');
                btn.classList.add('text-slate-600');
            });
            const activeBtn = document.getElementById(`btn-pkg-${kelasId}-${priceValue}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-600');
                activeBtn.classList.add(activeColorClass, 'text-white', 'shadow-xs');
            }

            // 3. Update Harga dengan animasi scale highlight
            const priceDisplay = document.getElementById('price-display-' + kelasId);
            if (priceDisplay) {
                const formatted = new Intl.NumberFormat('id-ID').format(pkg.price);
                priceDisplay.innerText = 'Rp ' + formatted;
                priceDisplay.classList.add('scale-105');
                setTimeout(() => {
                    priceDisplay.classList.remove('scale-105');
                }, 200);
            }

            // 4. Update Badge Sesi
            const badgeSesi = document.getElementById('badge-sesi-' + kelasId);
            if (badgeSesi) {
                badgeSesi.innerText = pkg.sesi;
            }

            // 5. Update Info Perks List dengan transisi halus
            const perksList = document.getElementById('perks-display-' + kelasId);
            if (perksList) {
                perksList.style.opacity = '0';
                setTimeout(() => {
                    perksList.innerHTML = pkg.perks.map(p => `
                        <li class="flex items-start gap-x-2.5 leading-tight">
                            <i class="${p.icon} mt-0.5 text-xs flex-shrink-0"></i>
                            <span class="text-slate-700">${p.text}</span>
                        </li>
                    `).join('');
                    perksList.style.opacity = '1';
                }, 150);
            }
        }

        function setPemulaPackage(kelasId, priceValue, activeColorClass) {
            updatePemulaPackage(kelasId, priceValue, activeColorClass);
        }

        function updatePemulaAPackage(kelasId, priceValue) {
            updatePemulaPackage(kelasId, priceValue, 'bg-[#008cc9]');
        }

        function setPemulaAPackage(kelasId, priceValue) {
            updatePemulaPackage(kelasId, priceValue, 'bg-[#008cc9]');
        }

        // --- DATA PAKET KELAS LANJUTAN & SENIOR KHUSUS CABANG SUMEDANG ---
        const lanjutanSeniorPackages = {
            '180000': {
                sesi: '12 Pertemuan / bulan',
                price: 180000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">12 Pertemuan / bulan</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Selasa, Kamis & Sabtu:</strong> Kolam Renang Hanjuang Hegar <span class="text-slate-500 block text-[11px] mt-0.5 font-normal"><i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 16.00 WIB (Durasi 90–120 Menit)</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Minggu:</strong> Kolam Renang Tirta Mas Kiansantang <span class="text-slate-500 block text-[11px] mt-0.5 font-normal"><i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 14.00 WIB (Durasi 90–120 Menit)</span>' },
                    { icon: 'fa-solid fa-person-running text-emerald-500', text: '<strong>Jumat:</strong> Lapang IPP Sumedang (Dryland) <span class="text-slate-500 block text-[11px] mt-0.5 font-normal"><i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 16.00 WIB (Durasi 60 Menit)</span>' }
                ]
            },
            '250000': {
                sesi: '16 Pertemuan / bulan',
                price: 250000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">16 Pertemuan / bulan (Intensif)</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Selasa, Kamis & Sabtu:</strong> Kolam Renang Hanjuang Hegar <span class="text-slate-500 block text-[11px] mt-0.5 font-normal"><i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 16.00 WIB (Durasi 90–120 Menit)</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Minggu:</strong> Kolam Renang Tirta Mas Kiansantang <span class="text-slate-500 block text-[11px] mt-0.5 font-normal"><i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 14.00 WIB (Durasi 90–120 Menit)</span>' },
                    { icon: 'fa-solid fa-person-running text-emerald-500', text: '<strong>Jumat:</strong> Lapang IPP Sumedang (Dryland) <span class="text-slate-500 block text-[11px] mt-0.5 font-normal"><i class="fa-regular fa-clock text-amber-500 mr-1"></i>Jam 16.00 WIB (Durasi 60 Menit)</span>' },
                    { icon: 'fa-solid fa-star text-amber-500', text: '<span class="font-semibold text-slate-800">Sesi Tambahan:</span> Pemantapan Limit Waktu & Simulasi Lomba' }
                ]
            }
        };

        function setLanjutanSeniorPackage(kelasId, priceValue, activeColorClass = 'bg-[#008cc9]') {
            const pkg = lanjutanSeniorPackages[priceValue];
            if (!pkg) return;

            const select = document.getElementById('package-select-' + kelasId);
            if (select && select.value !== String(priceValue)) {
                select.value = priceValue;
            }

            document.querySelectorAll('.pkg-pill-btn-' + kelasId).forEach(btn => {
                btn.classList.remove('bg-blue-600', 'bg-sky-600', 'bg-[#008cc9]', 'text-white', 'shadow-xs');
                btn.classList.add('text-slate-600');
            });
            const activeBtn = document.getElementById('btn-pkg-' + kelasId + '-' + priceValue);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-600');
                activeBtn.classList.add(activeColorClass, 'text-white', 'shadow-xs');
            }

            const priceDisplay = document.getElementById('price-display-' + kelasId);
            if (priceDisplay) {
                const formatted = new Intl.NumberFormat('id-ID').format(pkg.price);
                priceDisplay.innerText = 'Rp ' + formatted;
                priceDisplay.classList.add('scale-105');
                setTimeout(() => {
                    priceDisplay.classList.remove('scale-105');
                }, 200);
            }

            const badgeSesi = document.getElementById('badge-sesi-' + kelasId);
            if (badgeSesi) {
                badgeSesi.innerText = pkg.sesi;
            }

            const perksList = document.getElementById('perks-display-' + kelasId);
            if (perksList) {
                perksList.style.opacity = '0';
                setTimeout(() => {
                    perksList.innerHTML = pkg.perks.map(p => `
                        <li class="flex items-start gap-x-2.5 leading-tight">
                            <i class="${p.icon} mt-0.5 text-xs flex-shrink-0"></i>
                            <span class="text-slate-700">${p.text}</span>
                        </li>
                    `).join('');
                    perksList.style.opacity = '1';
                }, 150);
            }
        }

        // --- DATA PAKET KELAS PEMULA KHUSUS CABANG CIMANGGUNG ---
        const cimanggungPackages = {
            '150000': {
                sesi: '4 Pertemuan / bulan',
                price: 150000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">4 Pertemuan / bulan</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Senin/ Kamis :</strong> Kolam Renang Cibogo Indah' },
                    { icon: 'fa-regular fa-clock text-amber-500', text: 'Durasi <strong>60 menit</strong>' }
                ]
            },
            '200000': {
                sesi: '8 Pertemuan / bulan',
                price: 200000,
                perks: [
                    { icon: 'fa-solid fa-calendar-check text-indigo-500', text: '<span class="font-semibold text-slate-800">8 Pertemuan / bulan</span>' },
                    { icon: 'fa-solid fa-location-dot text-cyan-500', text: '<strong>Senin dan Kamis :</strong> Kolam Renang Cibogo Indah' },
                    { icon: 'fa-regular fa-clock text-amber-500', text: 'Durasi <strong>60 menit</strong>' }
                ]
            }
        };

        function setCimanggungPackage(kelasId, priceValue, activeColorClass = 'bg-[#008cc9]') {
            const pkg = cimanggungPackages[priceValue];
            if (!pkg) return;

            // 1. Sinkronkan nilai select dropdown
            const select = document.getElementById('package-select-' + kelasId);
            if (select && select.value !== String(priceValue)) {
                select.value = priceValue;
            }

            // 2. Sinkronkan tombol pill pilihan cepat
            document.querySelectorAll('.pkg-pill-btn-' + kelasId).forEach(btn => {
                btn.classList.remove('bg-blue-600', 'bg-sky-600', 'bg-[#008cc9]', 'text-white', 'shadow-xs');
                btn.classList.add('text-slate-600');
            });
            const activeBtn = document.getElementById(`btn-pkg-${kelasId}-${priceValue}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-600');
                activeBtn.classList.add(activeColorClass, 'text-white', 'shadow-xs');
            }

            // 3. Update Harga dengan animasi scale highlight
            const priceDisplay = document.getElementById('price-display-' + kelasId);
            if (priceDisplay) {
                const formatted = new Intl.NumberFormat('id-ID').format(pkg.price);
                priceDisplay.innerText = 'Rp ' + formatted;
                priceDisplay.classList.add('scale-105');
                setTimeout(() => {
                    priceDisplay.classList.remove('scale-105');
                }, 200);
            }

            // 4. Update Badge Sesi
            const badgeSesi = document.getElementById('badge-sesi-' + kelasId);
            if (badgeSesi) {
                badgeSesi.innerText = pkg.sesi;
            }

            // 5. Update Info Perks List dengan transisi halus
            const perksList = document.getElementById('perks-display-' + kelasId);
            if (perksList) {
                perksList.style.opacity = '0';
                setTimeout(() => {
                    perksList.innerHTML = pkg.perks.map(p => `
                        <li class="flex items-start gap-x-2.5 leading-tight text-xs sm:text-[13px]">
                            <i class="${p.icon} mt-0.5 text-xs flex-shrink-0"></i>
                            <span class="text-slate-700">${p.text}</span>
                        </li>
                    `).join('');
                    perksList.style.opacity = '1';
                }, 150);
            }

            // 6. Sinkronkan catatan form pendaftaran
            const noteInput = document.getElementById('form-package-note');
            if (noteInput && select) {
                const optionText = select.options[select.selectedIndex].text;
                noteInput.value = optionText;
            }
        }

        // --- FUNGSI UPDATE HARGA KARTU BERDASARKAN PILIHAN PAKET PERTEMUAN (KELAS LAIN) ---
        function updateCardPrice(kelasId, price) {
            const priceDisplay = document.getElementById('price-display-' + kelasId);
            if (priceDisplay) {
                const formatted = new Intl.NumberFormat('id-ID').format(price);
                priceDisplay.innerText = 'Rp ' + formatted;

                // Efek animasi highlight halus
                priceDisplay.classList.add('text-cyan-600', 'scale-105');
                setTimeout(() => {
                    priceDisplay.classList.remove('text-cyan-600', 'scale-105');
                }, 200);
            }
        }

        // --- FUNGSI KLIK TOMBOL PILIHAN PAKET KELAS ---
        function selectPackage(packageId, branchId) {
            const branchSelect = document.getElementById('form-branch-select');
            if (branchSelect && branchId) {
                branchSelect.value = branchId;
                updateRekeningDisplay(branchId);
            }

            const programSelect = document.getElementById('form-program-select');
            if (programSelect) {
                programSelect.value = packageId;
            }

            const packageSelect = document.getElementById('package-select-' + packageId);
            const noteInput = document.getElementById('form-package-note');
            if (packageSelect && noteInput) {
                const optionText = packageSelect.options[packageSelect.selectedIndex].text;
                const formattedPrice = new Intl.NumberFormat('id-ID').format(packageSelect.value);
                noteInput.value = `${optionText} (Rp ${formattedPrice})`;
            }

            const daftarSection = document.getElementById('daftar');
            if (daftarSection) {
                daftarSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
</body>

</html>