<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Cabang;
use App\Mail\PendaftarBaruAdminMail;

class LandingPageController extends Controller
{
    // 🏢 1. MENAMPILKAN HALAMAN UTAMA (LANDING PAGE)
    public function index()
    {
        // Ambil data master cabang beserta jadwalnya
        $data_cabang = Cabang::with('jadwals')->get();
        
        // Ambil data master kelas terurut id
        $data_kelas = DB::table('kelas')->orderBy('id')->get();

        // Ambil daftar pelatih (nama & foto dari tabel users)
        $dbPelatih = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id')
            ->select('pelatih.id', 'users.nama', 'users.foto')
            ->orderBy('pelatih.id', 'asc')
            ->get();

        $daftarPelatihResmi = [
            'Rahadian Sugihbandana, S.Pd',
            'Nugraha Ramadhan, S.Pd',
            'Suwandini Susilawati, S.Pd',
            'Deddy Iqbal, S.Pd',
            'Rahesta Ardhya Pramesti, S.Pd',
            'Syamsul Anwar, S.Pd',
            'Resti Tisnasari, M.Pd',
            'Fajar Adhi Nugraha, S.Pd',
            'Ranjellia Julian Pratiwi',
            'AHMAD SYUKUR, M.Pd',
            'Ramlan Mubarok, S.Pd',
            'Rizki Sugiharti, S.Pd',
        ];

        $data_pelatih = collect($dbPelatih);
        foreach ($daftarPelatihResmi as $idx => $namaResmi) {
            $exists = $data_pelatih->contains(function ($p) use ($namaResmi) {
                return strtolower(trim($p->nama)) === strtolower(trim($namaResmi));
            });
            if (!$exists) {
                $userMatch = DB::table('users')
                    ->whereRaw('LOWER(TRIM(nama)) = ?', [strtolower(trim($namaResmi))])
                    ->first();
                $data_pelatih->push((object)[
                    'id'   => $idx + 1,
                    'nama' => $userMatch->nama ?? $namaResmi,
                    'foto' => $userMatch->foto ?? null,
                ]);
            }
        }

        $data_pelatih = $data_pelatih
            ->sortBy(fn($p) => strtolower(trim($p->nama ?? '')))
            ->values();

        // 🎯 KUNCI PERBAIKAN: Fungsi index HARUS me-return view halaman awal
        return view('landing', compact('data_cabang', 'data_kelas', 'data_pelatih'));
    }

    // 📝 2. MENYIMPAN DATA DARI FORM PENDAFTARAN BARU
    public function store(Request $request)
    {
        // Normalisasi No. WhatsApp: hapus karakter non-digit, jika diawali 62/8 otomatis jadikan awalan '0' untuk database
        $cleanNoHp = preg_replace('/[^0-9]/', '', (string)$request->no_hp);
        if (str_starts_with($cleanNoHp, '62')) {
            $cleanNoHp = '0' . substr($cleanNoHp, 2);
        } elseif (!str_starts_with($cleanNoHp, '0') && !empty($cleanNoHp)) {
            $cleanNoHp = '0' . $cleanNoHp;
        }
        $request->merge(['no_hp' => $cleanNoHp]);

        // Validasi inputan form wajib diisi
        $validated = $request->validate([
            'nama_siswa'          => 'required|string|max:255',
            'tempat_lahir'        => 'required|string|max:100',
            'tanggal_lahir'       => 'required|date',
            'sekolah'             => 'required|string|max:255',
            'nama_orang_tua'      => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'no_hp'               => 'required|string|min:9|max:20',
            'id_cabang'           => 'required|integer',
            'id_kelas'            => 'nullable|integer',
            'pilihan_pembayaran'  => 'required|in:cash,transfer',
            'foto_siswa'          => 'nullable|image|max:2048',
            'bukti_pembayaran'    => 'nullable|image|max:2048',
            'surat_perjanjian'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'no_hp.required'      => 'Nomor WhatsApp wajib diisi.',
            'no_hp.min'           => 'Nomor WhatsApp minimal 9 digit angka.',
        ]);

        // Pastikan direktori uploads tersedia
        foreach (['uploads/pendaftaran/foto', 'uploads/pendaftaran/bukti', 'uploads/pendaftaran/perjanjian'] as $dir) {
            if (!file_exists(public_path($dir))) {
                mkdir(public_path($dir), 0755, true);
            }
        }

        // Proses upload foto siswa
        $foto_siswa = null;
        if ($request->hasFile('foto_siswa')) {
            $file = $request->file('foto_siswa');
            $foto_siswa = 'foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pendaftaran/foto'), $foto_siswa);
        }

        // Proses upload bukti pembayaran (hanya jika transfer)
        $bukti_pembayaran = null;
        if ($request->pilihan_pembayaran === 'transfer' && $request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $bukti_pembayaran = 'bukti_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pendaftaran/bukti'), $bukti_pembayaran);
        }

        // Proses upload surat perjanjian
        $surat_perjanjian = null;
        if ($request->hasFile('surat_perjanjian')) {
            $file = $request->file('surat_perjanjian');
            $surat_perjanjian = 'perjanjian_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pendaftaran/perjanjian'), $surat_perjanjian);
        }

        // Penentuan default kelas: jika pendaftar tidak memilih kelas, default ke Pemula A cabang tersebut
        $idKelas = $request->id_kelas;
        if (empty($idKelas)) {
            $idKelas = DB::table('kelas')
                ->where('id_cabang', $request->id_cabang)
                ->where('nama', 'like', '%Pemula A%')
                ->value('id')
                ?? DB::table('kelas')->where('id_cabang', $request->id_cabang)->value('id')
                ?? 1;
        }

        // Format nama dan tempat lahir menjadi Title Case (Huruf besar di awal kata)
        $namaSiswa = mb_convert_case(trim($request->nama_siswa), MB_CASE_TITLE, 'UTF-8');
        $tempatLahir = $request->filled('tempat_lahir') ? mb_convert_case(trim($request->tempat_lahir), MB_CASE_TITLE, 'UTF-8') : null;
        $namaOrtu = $request->filled('nama_orang_tua') ? mb_convert_case(trim($request->nama_orang_tua), MB_CASE_TITLE, 'UTF-8') : null;

        // Insert data pendaftar baru ke tabel database
        DB::table('pendaftaran_baru')->insert([
            'nama_siswa'         => $namaSiswa,
            'tempat_lahir'       => $tempatLahir,
            'tanggal_lahir'      => $request->tanggal_lahir,
            'sekolah'            => $request->sekolah,
            'riwayat_penyakit'   => null,
            'catatan_khusus'     => $request->catatan_khusus ?? null,
            'nama_orang_tua'     => $namaOrtu,
            'no_hp'              => $request->no_hp,
            'email'              => $request->email,
            'alamat'             => null,
            'foto_siswa'         => $foto_siswa,
            'id_kelas'           => $idKelas,
            'id_cabang'          => $request->id_cabang,
            'pilihan_pembayaran' => $request->pilihan_pembayaran,
            'bukti_pembayaran'   => $bukti_pembayaran,
            'surat_perjanjian'   => $surat_perjanjian,
            'status_pendaftaran' => 'pending',
            'created_at'         => now(),
        ]);

        // 📧 Kirim notifikasi email ke Admin Cabang / Admin Utama
        try {
            $namaCabang = DB::table('cabang')->where('id', $request->id_cabang)->value('nama') ?? 'Cabang Gajah Depa';
            $namaKelas = DB::table('kelas')->where('id', $idKelas)->value('nama') ?? 'Pemula A';

            // Ambil email admin cabang terkait atau admin utama
            $adminEmails = DB::table('users')
                ->where('role', 'admin')
                ->where('status', 'aktif')
                ->where(function($q) use ($request) {
                    $q->where('id_cabang', $request->id_cabang)
                      ->orWhereNull('id_cabang');
                })
                ->whereNotNull('email')
                ->pluck('email')
                ->filter()
                ->unique()
                ->toArray();

            if (empty($adminEmails)) {
                $adminEmails = DB::table('users')
                    ->where('role', 'admin')
                    ->where('status', 'aktif')
                    ->whereNotNull('email')
                    ->pluck('email')
                    ->filter()
                    ->unique()
                    ->toArray();
            }

            if (!empty($adminEmails)) {
                Mail::to($adminEmails)->send(new PendaftarBaruAdminMail([
                    'nama_siswa'         => $namaSiswa,
                    'nama_orang_tua'     => $namaOrtu,
                    'no_hp'              => $request->no_hp,
                    'email'              => $request->email,
                    'nama_cabang'        => $namaCabang,
                    'nama_kelas'         => $namaKelas,
                    'pilihan_pembayaran' => $request->pilihan_pembayaran,
                    'catatan_khusus'     => $request->catatan_khusus,
                    'waktu_daftar'       => now()->translatedFormat('d F Y, H:i'),
                    'admin_url'          => url('/admin/siswa'),
                ]));
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim notifikasi email pendaftar baru ke admin: ' . $e->getMessage());
        }

        // 🎯 Kembalikan halaman ke form dengan data flash session sukses
        return redirect()->back()->with([
            'sukses'     => 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda.',
            'nama_siswa' => $namaSiswa,
            'no_hp'      => $request->no_hp
        ]);
    }
}