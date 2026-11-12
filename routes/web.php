<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminPelatihController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminKeuanganController;
use App\Http\Controllers\AdminPenilaianController;
use App\Http\Controllers\AdminPengaturanController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\ParentsController;
use Illuminate\Support\Facades\Route;

// Rute untuk menampilkan landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Rute untuk memproses data postingan form pendaftaran
Route::post('/daftar-baru', [LandingPageController::class, 'store'])->name('pendaftaran.store');

// Rute Autentikasi (Login, Register & Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/check-email-registration', [AuthController::class, 'checkEmailRegistration'])->name('register.check_email');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Lupa & Reset Password
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Rute Dashboard & Fitur Admin (Proteksi Login & Role Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (!\Illuminate\Support\Facades\Cache::has('bm_test_cleared_nov2026') || request()->has('reset_bm')) {
            if (\Illuminate\Support\Facades\Schema::hasTable('best_swimmer')) {
                \Illuminate\Support\Facades\DB::table('best_swimmer')->truncate();
            }
            \Illuminate\Support\Facades\Cache::forever('bm_test_cleared_nov2026', true);
        }
        return view('dashboard.admin');
    })->name('admin.dashboard');

    // Tetapkan Best Member of the Month secara manual oleh Admin
    Route::post('/admin/best-swimmer', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'id_siswa' => 'required|integer',
            'tahun'    => 'required|integer',
            'bulan'    => 'required|integer',
            'catatan'  => 'nullable|string|max:500',
        ]);

        $adminCabang = \Illuminate\Support\Facades\Auth::user()->id_cabang ?? null;
        $siswa = \Illuminate\Support\Facades\DB::table('siswa')->where('id', $request->id_siswa)->first();
        if (!$siswa) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        $idCabang = $adminCabang ?: ($siswa->id_cabang ?? 1);

        if (!\Illuminate\Support\Facades\Schema::hasTable('best_swimmer')) {
            \Illuminate\Support\Facades\Schema::create('best_swimmer', function ($table) {
                $table->id();
                $table->unsignedBigInteger('id_siswa');
                $table->unsignedBigInteger('id_cabang');
                $table->integer('bulan');
                $table->integer('tahun');
                $table->unsignedBigInteger('id_admin')->nullable();
                $table->text('catatan')->nullable();
                $table->timestamps();
                $table->unique(['id_cabang', 'tahun', 'bulan']);
            });
        }

        // Cek tanggal pemilihan (hanya dibuka mulai tanggal 25 setiap bulannya)
        if ((int) date('j') < 25) {
            return redirect()->back()->with('error', 'Penetapan Best Member baru dapat dilakukan mulai tanggal 25 setiap bulannya agar data latihan bulan berjalan terkumpul lengkap.');
        }

        // Cek apakah Best Member bulan ini sudah pernah ditetapkan
        $existing = \Illuminate\Support\Facades\DB::table('best_swimmer')
            ->where('id_cabang', $idCabang)
            ->where('tahun', (int) $request->tahun)
            ->where('bulan', (int) $request->bulan)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Best Member bulan ini sudah pernah ditetapkan dan tidak dapat diganti selama sebulan.');
        }

        \Illuminate\Support\Facades\DB::table('best_swimmer')->insert([
            'id_cabang'  => $idCabang,
            'tahun'      => (int) $request->tahun,
            'bulan'      => (int) $request->bulan,
            'id_siswa'   => (int) $request->id_siswa,
            'id_admin'   => \Illuminate\Support\Facades\Auth::id(),
            'catatan'    => $request->catatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('sukses_swimmer', "Berhasil! {$siswa->nama} resmi ditetapkan sebagai Best Member of the Month untuk bulan ini.");
    })->name('admin.best_swimmer.store');

    // Fitur Manajemen Pelatih (Admin)
    Route::get('/admin/pelatih', [AdminPelatihController::class, 'index'])->name('admin.pelatih.index');
    Route::get('/admin/pelatih/export', [AdminPelatihController::class, 'export'])->name('admin.pelatih.export');
    Route::get('/admin/pelatih/absensi/export', [AdminPelatihController::class, 'exportAbsensi'])->name('admin.pelatih.absensi.export');
    Route::post('/admin/pelatih', [AdminPelatihController::class, 'store'])->name('admin.pelatih.store');
    Route::post('/admin/pelatih/absensi', [AdminPelatihController::class, 'storeAbsensi'])->name('admin.pelatih.absensi.store');
    Route::post('/admin/pelatih/absensi/{id}/update', [AdminPelatihController::class, 'updateAbsensi'])->name('admin.pelatih.absensi.update');
    Route::get('/admin/pelatih/absensi/{id}/update', function () {
        return redirect()->route('admin.pelatih.index');
    });
    Route::post('/admin/pelatih/absensi/{id}/delete', [AdminPelatihController::class, 'deleteAbsensi'])->name('admin.pelatih.absensi.delete');
    Route::get('/admin/pelatih/absensi/{id}/delete', function () {
        return redirect()->route('admin.pelatih.index');
    });
    Route::post('/admin/pelatih/{id}/update', [AdminPelatihController::class, 'update'])->name('admin.pelatih.update');
    Route::get('/admin/pelatih/{id}/update', function () {
        return redirect()->route('admin.pelatih.index');
    });
    Route::post('/admin/pelatih/{id}/delete', [AdminPelatihController::class, 'destroy'])->name('admin.pelatih.delete');
    Route::get('/admin/pelatih/{id}/delete', function () {
        return redirect()->route('admin.pelatih.index');
    });

    // Fitur Manajemen Siswa & Verifikasi Pendaftaran Baru (Admin)
    Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa.index');
    Route::get('/admin/siswa/export', [AdminSiswaController::class, 'export'])->name('admin.siswa.export');
    Route::get('/admin/siswa/absensi/export', [AdminSiswaController::class, 'exportAbsensi'])->name('admin.siswa.absensi.export');
    Route::post('/admin/siswa', [AdminSiswaController::class, 'store'])->name('admin.siswa.store');
    Route::post('/admin/siswa/{id}/update', [AdminSiswaController::class, 'update'])->name('admin.siswa.update');
    Route::get('/admin/siswa/{id}/update', function () {
        return redirect()->route('admin.siswa.index');
    });
    Route::post('/admin/siswa/{id}/delete', [AdminSiswaController::class, 'destroy'])->name('admin.siswa.delete');
    Route::get('/admin/siswa/{id}/delete', function () {
        return redirect()->route('admin.siswa.index');
    });
    Route::post('/admin/siswa/acc/{id}', [AdminSiswaController::class, 'acc'])->name('admin.siswa.acc');
    Route::post('/admin/siswa/tolak/{id}', [AdminSiswaController::class, 'tolak'])->name('admin.siswa.tolak');

    // Fitur Keuangan (Admin)
    Route::get('/admin/keuangan', [AdminKeuanganController::class, 'index'])->name('admin.keuangan.index');
    Route::get('/admin/keuangan/export', [AdminKeuanganController::class, 'export'])->name('admin.keuangan.export');
    Route::post('/admin/keuangan', [AdminKeuanganController::class, 'store'])->name('admin.keuangan.store');
    Route::post('/admin/keuangan/{id}/update', [AdminKeuanganController::class, 'update'])->name('admin.keuangan.update');
    Route::get('/admin/keuangan/{id}/update', function () {
        return redirect()->route('admin.keuangan.index');
    });
    Route::post('/admin/keuangan/{id}/delete', [AdminKeuanganController::class, 'destroy'])->name('admin.keuangan.delete');
    Route::get('/admin/keuangan/{id}/delete', function () {
        return redirect()->route('admin.keuangan.index');
    });

    // Fitur Penilaian (Admin)
    Route::get('/admin/penilaian', [AdminPenilaianController::class, 'index'])->name('admin.penilaian.index');

    // Fitur Pengaturan (Admin)
    Route::get('/admin/pengaturan', [AdminPengaturanController::class, 'index'])->name('admin.pengaturan.index');
    Route::post('/admin/pengaturan', [AdminPengaturanController::class, 'update'])->name('admin.pengaturan.update');
});

// Rute Fitur Pelatih & Orang Tua (Proteksi Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/pelatih/dashboard', [PelatihController::class, 'dashboard'])->name('pelatih.dashboard');
    Route::post('/pelatih/switch-cabang', [PelatihController::class, 'switchCabang'])->name('pelatih.switch_cabang');

    Route::get('/pelatih/absensi', [PelatihController::class, 'absensi'])->name('pelatih.absensi');

    // Fitur Manajemen Siswa, Absensi & Penilaian Siswa (Pelatih)
    Route::get('/pelatih/siswa', [PelatihController::class, 'siswa'])->name('pelatih.siswa');
    Route::post('/pelatih/siswa/absensi', [PelatihController::class, 'storeAbsensiSiswa'])->name('pelatih.siswa.absensi.store');
    Route::post('/pelatih/siswa/penilaian', [PelatihController::class, 'storePenilaianSiswa'])->name('pelatih.siswa.penilaian.store');
    Route::post('/pelatih/siswa/penilaian/{id}/update', [PelatihController::class, 'updatePenilaianSiswa'])->name('pelatih.siswa.penilaian.update');
    Route::post('/pelatih/siswa/penilaian/{id}/delete', [PelatihController::class, 'deletePenilaianSiswa'])->name('pelatih.siswa.penilaian.delete');

    // Fitur Penilaian Saya & Penilaian Club (Rating & Ulasan dari Orang Tua)
    Route::get('/pelatih/penilaian', [PelatihController::class, 'penilaian'])->name('pelatih.penilaian');

    // Fitur Pengaturan Profil Pelatih
    Route::get('/pelatih/pengaturan', [PelatihController::class, 'pengaturan'])->name('pelatih.pengaturan');
    Route::post('/pelatih/pengaturan', [PelatihController::class, 'updatePengaturan'])->name('pelatih.pengaturan.update');

    // Fitur Portal Orang Tua (Dashboard, Penilaian Anak, Absensi, Nilai, Pengaturan)
    Route::get('/parents/dashboard', [ParentsController::class, 'dashboard'])->name('parents.dashboard');
    Route::post('/parents/switch-anak', [ParentsController::class, 'switchAnak'])->name('parents.switch_anak');
    Route::get('/parents/penilaian-anak', [ParentsController::class, 'penilaianAnak'])->name('parents.penilaian_anak');
    Route::get('/parents/absensi', [ParentsController::class, 'absensi'])->name('parents.absensi');
    Route::get('/parents/nilai', [ParentsController::class, 'nilai'])->name('parents.nilai');
    Route::post('/parents/nilai/pelatih', [ParentsController::class, 'storeUlasanPelatih'])->name('parents.nilai_pelatih.store');
    Route::post('/parents/nilai/club', [ParentsController::class, 'storeUlasanClub'])->name('parents.nilai_club.store');
    Route::get('/parents/pengaturan', [ParentsController::class, 'pengaturan'])->name('parents.pengaturan');
    Route::post('/parents/pengaturan', [ParentsController::class, 'updatePengaturan'])->name('parents.pengaturan.update');
});