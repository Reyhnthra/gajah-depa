<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan halaman register / aktivasi akun orang tua
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.register');
    }

    // Endpoint pengecekan status email pendaftaran (live check via AJAX)
    public function checkEmailRegistration(Request $request)
    {
        $email = strtolower(trim($request->query('email', '')));

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'invalid', 'message' => 'Format email tidak valid.']);
        }

        $user = User::where('email', $email)->first();
        $pendaftaran = DB::table('pendaftaran_baru')
            ->leftJoin('cabang', 'pendaftaran_baru.id_cabang', '=', 'cabang.id')
            ->where('pendaftaran_baru.email', $email)
            ->select('pendaftaran_baru.*', 'cabang.nama as nama_cabang')
            ->first();

        // 1. Akun sudah aktif (sudah punya password)
        if ($user && $user->password_set && !empty($user->password)) {
            return response()->json([
                'status' => 'already_active',
                'message' => 'Akun dengan email ini sudah aktif. Silakan langsung masuk (login).',
                'nama' => $user->nama,
            ]);
        }

        // 2. Pendaftaran masih pending
        if ($pendaftaran && $pendaftaran->status_pendaftaran === 'pending') {
            return response()->json([
                'status' => 'pending',
                'message' => 'Pendaftaran anak Anda (' . $pendaftaran->nama_siswa . ') masih berstatus PENDING (menunggu persetujuan Admin).',
                'nama' => $pendaftaran->nama_orang_tua,
                'anak' => $pendaftaran->nama_siswa,
            ]);
        }

        // 3. Pendaftaran ditolak
        if ($pendaftaran && $pendaftaran->status_pendaftaran === 'ditolak') {
            return response()->json([
                'status' => 'ditolak',
                'message' => 'Pendaftaran anak dengan email ini ditolak oleh Admin.',
            ]);
        }

        // 4a. Pelatih terdaftar tapi belum set password -> SIAP BUAT PASSWORD
        if ($user && $user->role === 'pelatih') {
            $cabang = DB::table('cabang_pelatih')
                ->join('pelatih', 'cabang_pelatih.id_pelatih', '=', 'pelatih.id')
                ->join('cabang', 'cabang_pelatih.id_cabang', '=', 'cabang.id')
                ->where('pelatih.id_user', $user->id)
                ->pluck('cabang.nama')
                ->implode(', ');

            if (empty($cabang) && $user->id_cabang) {
                $cabang = DB::table('cabang')->where('id', $user->id_cabang)->value('nama');
            }
            $cabang = !empty($cabang) ? $cabang : 'Gajah Depa';

            return response()->json([
                'status'  => 'ready',
                'role'    => 'pelatih',
                'message' => 'Data Pelatih terverifikasi!',
                'nama'    => $user->nama,
                'anak'    => 'Pelatih Resmi',
                'cabang'  => $cabang,
            ]);
        }

        // 4b. Pendaftaran disetujui atau user parent ada tapi belum set password -> SIAP BUAT PASSWORD
        if (($pendaftaran && $pendaftaran->status_pendaftaran === 'disetujui') || ($user && $user->role === 'parents')) {
            $namaOrtu = $user->nama ?? $pendaftaran->nama_orang_tua ?? 'Orang Tua';

            $siswaInfo = null;
            if ($user) {
                $siswaInfo = DB::table('siswa')
                    ->join('parents', 'siswa.id_parents', '=', 'parents.id')
                    ->leftJoin('cabang', 'siswa.id_cabang', '=', 'cabang.id')
                    ->where('parents.id_user', $user->id)
                    ->select('siswa.nama as nama_siswa', 'cabang.nama as nama_cabang')
                    ->first();
            }

            $namaAnak = $pendaftaran->nama_siswa ?? ($siswaInfo->nama_siswa ?? 'Siswa');
            $cabang = $pendaftaran->nama_cabang ?? ($siswaInfo->nama_cabang ?? null);
            if (!$cabang && $user && $user->id_cabang) {
                $cabang = DB::table('cabang')->where('id', $user->id_cabang)->value('nama');
            }
            $cabang = $cabang ?? 'Gajah Depa';

            return response()->json([
                'status'  => 'ready',
                'role'    => 'parents',
                'message' => 'Pendaftaran terverifikasi! Data anak ditemukan.',
                'nama'    => $namaOrtu,
                'anak'    => $namaAnak,
                'cabang'  => $cabang,
            ]);
        }

        // 5. Belum terdaftar sama sekali
        return response()->json([
            'status' => 'not_found',
            'message' => 'Email belum terdaftar atau pendaftaran anak belum disetujui (ACC) oleh Admin.',
        ]);
    }

    // Memproses pembuatan password / registrasi akun Orang Tua
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
        ], [
            'email.required' => 'Email orang tua wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = strtolower(trim($validated['email']));

        // Cari data pendaftaran anak berdasarkan email
        $pendaftaran = DB::table('pendaftaran_baru')->where('email', $email)->first();

        // Cari user yang sudah tersimpan
        $user = User::where('email', $email)->first();

        // 1. Cek apakah ada pendaftaran yang masih pending
        if ($pendaftaran && $pendaftaran->status_pendaftaran === 'pending') {
            return back()->withErrors([
                'email' => 'Pendaftaran anak Anda (' . $pendaftaran->nama_siswa . ') masih berstatus PENDING (menunggu persetujuan Admin). Pembuatan akun baru dapat dilakukan setelah di-ACC oleh Admin.',
            ])->withInput();
        }

        // 2. Cek apakah ada pendaftaran yang ditolak
        if ($pendaftaran && $pendaftaran->status_pendaftaran === 'ditolak') {
            return back()->withErrors([
                'email' => 'Pendaftaran anak dengan email ini ditolak oleh Admin. Silakan hubungi admin cabang untuk info lebih lanjut.',
            ])->withInput();
        }

        // 3. Cek apakah pendaftaran sudah di-ACC (orang tua) atau terdaftar sebagai pelatih
        $isApproved = ($pendaftaran && $pendaftaran->status_pendaftaran === 'disetujui') ||
            ($user && in_array($user->role, ['parents', 'pelatih']));

        if (!$isApproved) {
            return back()->withErrors([
                'email' => 'Email belum terdaftar atau pendaftaran belum disetujui (ACC) oleh Admin. Pembuatan akun hanya dapat dilakukan jika data sudah terdaftar dan disetujui Admin.',
            ])->withInput();
        }

        // 4. Cek apakah akun ini sudah pernah dibuat password-nya (sudah aktif)
        if ($user && $user->password_set && !empty($user->password)) {
            return back()->withErrors([
                'email' => 'Akun dengan email ini sudah aktif dan memiliki password. Silakan langsung masuk (login).',
            ])->withInput();
        }

        // 5. Simpan / Buat akun & password baru
        DB::transaction(function () use (&$user, $pendaftaran, $email, $validated) {
            if ($user) {
                // Update password untuk user yang sudah dibuat saat ACC
                $user->password = Hash::make($validated['password']);
                $user->password_set = true;
                $user->status = 'aktif';
                $user->save();
            } else {
                // Jika user belum ada (misal pendaftaran berstatus disetujui tapi user belum dibuat), buat user baru
                $user = User::create([
                    'nama' => $pendaftaran->nama_orang_tua ?? 'Orang Tua',
                    'email' => $email,
                    'no_hp' => $pendaftaran->no_hp ?? '-',
                    'jenis_kelamin' => 'laki-laki',
                    'password' => Hash::make($validated['password']),
                    'password_set' => true,
                    'role' => 'parents',
                    'status' => 'aktif',
                    'id_cabang' => $pendaftaran->id_cabang ?? null,
                ]);

                $parent = DB::table('parents')->where('id_user', $user->id)->first();
                if (!$parent) {
                    $parentId = DB::table('parents')->insertGetId([
                        'id_user' => $user->id,
                        'alamat' => $pendaftaran->alamat ?? '-',
                    ]);
                    DB::table('siswa')->where('nama', $pendaftaran->nama_siswa)->whereNull('id_parents')->update(['id_parents' => $parentId]);
                }
            }

            Auth::login($user);
        });

        return redirect()->route('parents.dashboard')->with('sukses', 'Akun berhasil dibuat! Selamat datang di Gajah Depa Swimming.');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.login');
    }

    // Memproses otentikasi login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek jika akun orang tua tidak memiliki data anak (atau data anak telah dihapus admin)
        $userCheck = User::where('email', $credentials['email'])->first();
        if ($userCheck && $userCheck->role === 'parents') {
            $hasChild = DB::table('parents')
                ->join('siswa', 'parents.id', '=', 'siswa.id_parents')
                ->where('parents.id_user', $userCheck->id)
                ->exists();

            if (!$hasChild) {
                // Bersihkan record orphaned jika masih tersisa
                DB::table('parents')->where('id_user', $userCheck->id)->delete();
                DB::table('users')->where('id', $userCheck->id)->delete();

                return back()->withErrors([
                    'email' => 'Data anak untuk akun ini telah dihapus oleh Admin, sehingga akun orang tua sudah tidak aktif.',
                ])->onlyInput('email');
            }

            if (!$userCheck->password_set || empty($userCheck->password)) {
                return back()->withErrors([
                    'email' => 'Pendaftaran anak Anda sudah disetujui (ACC), namun Anda belum membuat password. Silakan buat password di halaman Daftar Akun.',
                ])->onlyInput('email');
            }
        }

        // Cek jika pelatih baru belum membuat password
        if ($userCheck && $userCheck->role === 'pelatih' && (!$userCheck->password_set || empty($userCheck->password))) {
            return back()->withErrors([
                'email' => 'Akun Anda sudah terdaftar sebagai Pelatih, namun Anda belum membuat password. Silakan buat password di halaman Daftar Akun.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek jika status akun nonaktif
            if (isset($user->status) && $user->status === 'nonaktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda sedang nonaktif. Silakan hubungi admin.',
                ])->onlyInput('email');
            }

            // Validasi data anak aktif untuk role parents
            if ($user->role === 'parents') {
                $hasChild = DB::table('parents')
                    ->join('siswa', 'parents.id', '=', 'siswa.id_parents')
                    ->where('parents.id_user', $user->id)
                    ->exists();

                if (!$hasChild) {
                    DB::table('parents')->where('id_user', $user->id)->delete();
                    DB::table('users')->where('id', $user->id)->delete();

                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'Data anak untuk akun ini telah dihapus oleh Admin, sehingga akun orang tua sudah tidak aktif.',
                    ])->onlyInput('email');
                }
            }

            return $this->redirectUserByRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $pesan = $request->has('timeout')
            ? 'Sesi Anda telah berakhir.'
            : 'Anda telah berhasil keluar.';

        return redirect()->route('login')->with('sukses', $pesan);
    }

    // Helper redirect berdasarkan role
    protected function redirectUserByRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
            case 'pelatih':
                return redirect()->intended('/pelatih/dashboard');
            case 'parents':
                return redirect()->intended('/parents/dashboard');
            default:
                return redirect()->intended('/');
        }
    }
}
