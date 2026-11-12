<!-- Modal Konfirmasi Logout -->
<div id="logoutModal" onclick="if(event.target === this) closeLogoutModal()" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 transform transition-all animate-in fade-in zoom-in-95 duration-150">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 border border-rose-100 text-rose-500 flex items-center justify-center text-2xl mx-auto mb-4 shadow-xs">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Keluar</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin keluar dari akun ini? Anda harus login kembali untuk mengakses sistem.</p>
        <div class="grid grid-cols-2 gap-3">
            <button type="button" onclick="closeLogoutModal()"
                class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition cursor-pointer">
                Batal
            </button>
            <form id="confirmedLogoutForm" action="{{ route('logout') }}" method="POST" class="w-full m-0">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 px-4 bg-rose-500 hover:bg-rose-600 text-white font-bold text-sm rounded-xl shadow-md shadow-rose-500/20 transition cursor-pointer">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        const m = document.getElementById('logoutModal');
        if (m) {
            m.classList.remove('hidden');
        } else if (confirm('Apakah Anda yakin ingin keluar dari akun ini?')) {
            const form = document.querySelector('form[action*="logout"]');
            if (form) form.submit();
        }
    }

    function closeLogoutModal() {
        const m = document.getElementById('logoutModal');
        if (m) m.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLogoutModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[action*="logout"]').forEach(form => {
            if (form.id === 'confirmedLogoutForm') return;
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                openLogoutModal();
            });
        });

        // ==========================================
        // AUTO-LOGOUT 20 MENIT INAKTIF (IDLE TIMEOUT)
        // ==========================================
        const INACTIVITY_LIMIT_MS = 20 * 60 * 1000; // 20 Menit (1.200.000 ms)
        const STORAGE_KEY = 'gd_last_active_time';
        let lastRecordedTime = Date.now();

        function recordActivity() {
            const now = Date.now();
            // Throttle penyimpanan agar tidak membebani localStorage setiap pergerakan pixel mouse (tiap 3 detik)
            if (now - lastRecordedTime > 3000) {
                lastRecordedTime = now;
                try {
                    localStorage.setItem(STORAGE_KEY, String(now));
                } catch (e) {}
            }
        }

        // Catat aktivitas awal saat halaman dibuka
        recordActivity();

        // Pantau interaksi pengguna di browser
        ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click'].forEach(evt => {
            window.addEventListener(evt, recordActivity, { passive: true });
        });

        // Pengecekan berkala setiap 5 detik
        setInterval(function() {
            let lastActive = parseInt(localStorage.getItem(STORAGE_KEY) || '0', 10);
            if (!lastActive || isNaN(lastActive)) {
                lastActive = lastRecordedTime;
            }

            const elapsed = Date.now() - lastActive;
            if (elapsed >= INACTIVITY_LIMIT_MS) {
                // Bersihkan penanda waktu agar tab lain tidak looping
                try {
                    localStorage.removeItem(STORAGE_KEY);
                } catch (e) {}

                // Redirect logout dengan query timeout agar menampilkan pesan yang tepat
                window.location.href = "{{ route('logout') }}?timeout=1";
            }
        }, 5000);
    });
</script>

