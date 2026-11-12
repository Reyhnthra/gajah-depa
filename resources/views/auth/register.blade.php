<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru - Gajah Depa Akademik Swimming</title>
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

            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Buat Akun</h1>
            <p class="text-sm text-slate-500 mt-1">Aktivasi akun untuk Orang Tua & Pelatih terdaftar</p>
        </div>

        <!-- Card Form Register -->
        <div class="w-full max-w-[420px] bg-white rounded-2xl p-7 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100/80">
            
            <!-- Info Box Keterangan Akun -->
            <div class="mb-5 p-3.5 bg-sky-50 border border-sky-200/80 rounded-xl text-xs text-sky-800 flex items-start gap-2.5 leading-relaxed">
                <i class="fa-solid fa-circle-info text-sky-500 text-sm mt-0.5 shrink-0"></i>
                <span>Gunakan <strong>email yang sudah didaftarkan</strong> oleh Anda atau Admin. Data Anda sudah tersimpan di sistem, Anda cukup membuat password akun di sini.</span>
            </div>

            @if($errors->any())
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-600 flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm mt-0.5 shrink-0"></i>
                    <span class="leading-relaxed">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4" id="formRegister">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Terdaftar <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="email@orangtua.com" 
                            class="w-full pl-10 pr-10 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]/40 focus:border-[#00a5ec] focus:bg-white transition duration-150">
                        <div id="emailSpinner" class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-spinner fa-spin text-xs"></i>
                        </div>
                    </div>

                    <!-- Live Email Verification Feedback Badge -->
                    <div id="emailFeedback" class="hidden mt-2 p-2.5 rounded-xl text-xs flex items-start gap-2 leading-snug transition-all duration-200">
                        <i id="emailFeedbackIcon" class="mt-0.5 text-xs shrink-0"></i>
                        <span id="emailFeedbackText"></span>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Buat Password Baru <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            placeholder="Min. 8 karakter (huruf besar, kecil & angka)" 
                            class="w-full pl-10 pr-10 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]/40 focus:border-[#00a5ec] focus:bg-white transition duration-150">
                        <button type="button" onclick="togglePasswordVisibility('password', 'toggleEyeIcon1')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="toggleEyeIcon1" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-[#00a5ec] text-xs"></i>
                        <span>Min. 8 karakter, kombinasi huruf besar, kecil, & angka.</span>
                    </p>
                </div>

                <!-- Konfirmasi Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Ulangi Password <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            placeholder="Ulangi password di atas" 
                            class="w-full pl-10 pr-10 py-2.5 bg-[#f8fafc] border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#00a5ec]/40 focus:border-[#00a5ec] focus:bg-white transition duration-150">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'toggleEyeIcon2')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="toggleEyeIcon2" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" id="btnSubmit" class="w-full bg-[#00a5ec] hover:bg-[#0092d1] active:scale-[0.99] text-white font-semibold py-3 px-4 rounded-xl shadow-sm text-sm transition duration-200 flex justify-center items-center gap-2 mt-2">
                    <i class="fa-solid fa-key text-xs"></i>
                    <span>Buat Password & Masuk</span>
                </button>
            </form>

            <!-- Separator / Footer Card -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-center space-y-2 text-xs text-slate-500">
                <div>
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-[#00a5ec] hover:underline">Masuk di sini</a>
                </div>
                <div class="text-[11px] text-slate-400">
                    Belum mendaftarkan les anak? <a href="{{ route('landing') }}#daftar" class="font-semibold text-slate-600 hover:text-[#00a5ec] hover:underline">Daftar Renang Sekarang</a>
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

    <!-- Password Toggle Script -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Live verification of email registration status
        const emailInput = document.getElementById('email');
        const emailSpinner = document.getElementById('emailSpinner');
        const emailFeedback = document.getElementById('emailFeedback');
        const emailFeedbackIcon = document.getElementById('emailFeedbackIcon');
        const emailFeedbackText = document.getElementById('emailFeedbackText');
        let checkTimeout = null;

        function checkEmailStatus() {
            const email = (emailInput.value || '').trim();
            if (!email || !email.includes('@') || !email.includes('.')) {
                emailFeedback.classList.add('hidden');
                return;
            }

            emailSpinner.classList.remove('hidden');

            fetch(`{{ route('register.check_email') }}?email=${encodeURIComponent(email)}`)
                .then(res => res.json())
                .then(data => {
                    emailSpinner.classList.add('hidden');
                    emailFeedback.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-200', 'bg-amber-50', 'text-amber-700', 'border-amber-200', 'bg-rose-50', 'text-rose-700', 'border-rose-200', 'bg-sky-50', 'text-sky-700', 'border-sky-200');
                    emailFeedbackIcon.className = '';

                    if (data.status === 'ready') {
                        emailFeedback.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-200');
                        emailFeedbackIcon.className = 'fa-solid fa-circle-check text-emerald-500 mt-0.5 shrink-0';
                        if (data.role === 'pelatih') {
                            emailFeedbackText.innerHTML = `<strong>Data Terverifikasi:</strong> ${data.nama} (Pelatih - ${data.cabang}). Silakan tentukan password Anda.`;
                        } else {
                            emailFeedbackText.innerHTML = `<strong>Data Terverifikasi:</strong> ${data.nama} (Orang tua dari <strong>${data.anak}</strong> - ${data.cabang}). Silakan tentukan password Anda.`;
                        }
                    } else if (data.status === 'pending') {
                        emailFeedback.classList.add('bg-amber-50', 'text-amber-700', 'border', 'border-amber-200');
                        emailFeedbackIcon.className = 'fa-solid fa-clock text-amber-500 mt-0.5 shrink-0';
                        emailFeedbackText.innerHTML = `<strong>Pendaftaran Masih Menunggu ACC:</strong> Data anak Anda (${data.anak}) sedang ditinjau oleh Admin. Akun baru dapat diaktifkan setelah di-ACC.`;
                    } else if (data.status === 'already_active') {
                        emailFeedback.classList.add('bg-sky-50', 'text-sky-700', 'border', 'border-sky-200');
                        emailFeedbackIcon.className = 'fa-solid fa-circle-info text-sky-500 mt-0.5 shrink-0';
                        emailFeedbackText.innerHTML = `<strong>Akun Sudah Aktif:</strong> Email ini sudah memiliki password. Silakan <a href="{{ route('login') }}" class="underline font-bold">langsung masuk (login)</a>.`;
                    } else {
                        emailFeedback.classList.add('bg-rose-50', 'text-rose-700', 'border', 'border-rose-200');
                        emailFeedbackIcon.className = 'fa-solid fa-circle-xmark text-rose-500 mt-0.5 shrink-0';
                        emailFeedbackText.innerHTML = `<strong>Belum Dapat Didaftarkan:</strong> ${data.message || 'Email belum terdaftar atau belum disetujui (ACC) oleh Admin.'}`;
                    }
                })
                .catch(() => {
                    emailSpinner.classList.add('hidden');
                });
        }

        emailInput.addEventListener('input', function() {
            clearTimeout(checkTimeout);
            checkTimeout = setTimeout(checkEmailStatus, 500);
        });

        emailInput.addEventListener('blur', checkEmailStatus);

        if (emailInput.value) {
            checkEmailStatus();
        }
    </script>
</body>
</html>
