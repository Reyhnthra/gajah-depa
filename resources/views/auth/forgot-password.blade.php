<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Gajah Depa Akademik Swimming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f8fb] min-h-screen flex flex-col justify-between items-center px-4 py-8 antialiased selection:bg-[#00a5ec] selection:text-white relative">

    <!-- Tombol Keluar / Kembali ke Landing Page -->
    <a href="{{ route('landing') }}" title="Kembali ke Landing Page" class="fixed top-5 left-5 z-50 inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 shadow-sm hover:shadow-md rounded-full text-xs font-semibold text-slate-600 hover:text-[#00a5ec] transition duration-200">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        <span>Kembali ke Beranda</span>
    </a>

    <div class="w-full flex-1 flex flex-col justify-center items-center">
        
        <!-- Header Logo & Judul -->
        <div class="mb-6 text-center flex flex-col items-center">
            <a href="{{ route('landing') }}" class="group mb-3 block inline-block transition transform hover:scale-105 duration-200">
                @if(file_exists(public_path('images/logo.jpg')))
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Gajah Depa" class="h-20 w-20 rounded-full object-cover shadow-md border-2 border-white">
                @else
                    <div class="h-20 w-20 rounded-full bg-gradient-to-tr from-amber-400 to-yellow-300 flex flex-col items-center justify-center text-blue-900 border-2 border-amber-300 shadow-md">
                        <i class="fa-solid fa-elephant text-2xl text-gray-700 mb-0.5"></i>
                        <span class="text-[9px] font-black tracking-wider">GAJAH DEPA</span>
                        <span class="text-[7px] font-bold opacity-80">SUMEDANG</span>
                    </div>
                @endif
            </a>

            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Lupa Password?</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xs sm:max-w-sm">Masukkan email Anda untuk menerima link reset password</p>
        </div>

        <!-- Card Form Lupa Password -->
        <div class="w-full max-w-[420px] bg-white rounded-2xl p-7 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100/80">
            
            @if(session('status'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-700 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-600 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Terdaftar -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email terdaftar <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="email@contoh.com" 
                            class="w-full pl-10 pr-4 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]/40 focus:border-[#00a5ec] focus:bg-white transition duration-150">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Link reset password akan dikirim ke email ini.</p>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-[#00a5ec] hover:bg-[#0092d1] active:scale-[0.99] text-white font-semibold py-3 px-4 rounded-xl shadow-sm text-sm transition duration-200 flex justify-center items-center gap-2 mt-2">
                    <span>Kirim Link Reset</span>
                </button>
            </form>

            <!-- Separator / Footer Card -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500 flex flex-col gap-2">
                <div>
                    Ingat password Anda? <a href="{{ route('login') }}" class="font-semibold text-[#00a5ec] hover:underline">Masuk di sini</a>
                </div>
                <div>
                    Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-[#00a5ec] hover:underline">Daftar sekarang</a>
                </div>
            </div>

        </div>

        <!-- Footer Copyright -->
        <div class="mt-8 text-center text-xs text-slate-400">
            © {{ date('Y') }} Gajah Depa Akademik Swimming
        </div>

    </div>

    <!-- Floating Help Button (Bottom Right) -->
    <a href="#" title="Pusat Bantuan" class="fixed bottom-5 right-5 w-9 h-9 bg-white border border-slate-200 shadow-md rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-lg transition duration-200 text-xs font-bold">
        ?
    </a>

</body>
</html>
