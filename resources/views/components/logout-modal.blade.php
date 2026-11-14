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

<!-- Global Web Confirmation Modal -->
<div id="webConfirmModal" class="fixed inset-0 z-[100] bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true" aria-labelledby="webConfirmTitle" onclick="if (event.target === this) closeWebConfirmModal()">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 max-w-sm w-full p-6 text-center animate-in fade-in zoom-in-95 duration-200">
        <div id="webConfirmIconBox" class="w-14 h-14 bg-sky-50 text-[#00a5ec] rounded-full flex items-center justify-center mx-auto mb-4">
            <svg id="webConfirmIcon" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 id="webConfirmTitle" class="text-lg font-extrabold text-slate-800">Konfirmasi Tindakan</h3>
        <p id="webConfirmMessage" class="text-xs text-slate-500 mt-1.5 leading-relaxed">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>
        <div class="grid grid-cols-2 gap-3 mt-6">
            <button type="button" onclick="closeWebConfirmModal()" class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">Batal</button>
            <button type="button" id="webConfirmSubmitBtn" onclick="proceedWebConfirmModal()" class="w-full py-2.5 rounded-xl bg-[#00a5ec] text-white text-xs font-bold hover:bg-[#0092d1] transition shadow-xs">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script>
    let _pendingConfirmForm = null;
    let _pendingConfirmSubmitter = null;

    function openLogoutModal() {
        const m = document.getElementById('logoutModal');
        if (m) {
            m.classList.remove('hidden');
        } else {
            const form = document.querySelector('form[action*="logout"]');
            if (form) openWebConfirmModal(form, 'Apakah Anda yakin ingin keluar dari akun ini?', 'Konfirmasi Keluar');
        }
    }

    function closeLogoutModal() {
        const m = document.getElementById('logoutModal');
        if (m) m.classList.add('hidden');
    }

    function openWebConfirmModal(form, message, title, submitter) {
        const m = document.getElementById('webConfirmModal');
        if (!m) return;

        _pendingConfirmForm = form;
        _pendingConfirmSubmitter = submitter || null;

        const msgEl = document.getElementById('webConfirmMessage');
        const titleEl = document.getElementById('webConfirmTitle');
        const iconBox = document.getElementById('webConfirmIconBox');
        const iconEl = document.getElementById('webConfirmIcon');
        const submitBtn = document.getElementById('webConfirmSubmitBtn');

        const msg = message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        if (msgEl) msgEl.textContent = msg;

        const isDanger = /hapus|batal|reset/i.test(msg);
        const isSend = /mengirim|penilaian/i.test(msg);

        if (titleEl) {
            titleEl.textContent = title || (isDanger ? 'Konfirmasi Tindakan' : (isSend ? 'Konfirmasi Pengiriman' : 'Konfirmasi Simpan Perubahan'));
        }

        if (iconBox && iconEl && submitBtn) {
            if (isDanger) {
                iconBox.className = 'w-14 h-14 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4';
                submitBtn.className = 'w-full py-2.5 rounded-xl bg-rose-500 text-white text-xs font-bold hover:bg-rose-600 transition shadow-xs';
                iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            } else {
                iconBox.className = 'w-14 h-14 bg-sky-50 text-[#00a5ec] rounded-full flex items-center justify-center mx-auto mb-4';
                submitBtn.className = 'w-full py-2.5 rounded-xl bg-[#00a5ec] text-white text-xs font-bold hover:bg-[#0092d1] transition shadow-xs';
                iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            }
        }

        m.classList.remove('hidden');
    }

    function closeWebConfirmModal() {
        const m = document.getElementById('webConfirmModal');
        if (m) m.classList.add('hidden');
        _pendingConfirmForm = null;
        _pendingConfirmSubmitter = null;
    }

    function proceedWebConfirmModal() {
        const form = _pendingConfirmForm;
        const submitter = _pendingConfirmSubmitter;
        closeWebConfirmModal();
        if (!form) return;

        form.dataset.webConfirmed = '1';
        if (typeof form.requestSubmit === 'function') {
            if (submitter && form.contains(submitter) && !submitter.disabled) {
                form.requestSubmit(submitter);
            } else {
                form.requestSubmit();
            }
        } else {
            HTMLFormElement.prototype.submit.call(form);
        }
    }

    if (!window.__webConfirmInitialized) {
        window.__webConfirmInitialized = true;
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) return;
            const msg = form.getAttribute('data-confirm');
            if (!msg) return;

            if (form.dataset.webConfirmed === '1') {
                delete form.dataset.webConfirmed;
                return;
            }

            e.preventDefault();
            e.stopPropagation();
            openWebConfirmModal(form, msg, form.getAttribute('data-confirm-title'), e.submitter || null);
        }, true);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLogoutModal();
            closeWebConfirmModal();
        }
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

