<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AdminPelatihController extends Controller
{
    /**
     * Kolom select profil pelatih terisolasi per cabang.
     */
    private function selectPelatihCabangColumns(bool $withEmailAndFoto = true): array
    {
        $columns = [
            'pelatih.id as id_pelatih',
            DB::raw('COALESCE(cabang_pelatih.tempat_lahir, pelatih.tempat_lahir) as tempat_lahir'),
            DB::raw('COALESCE(cabang_pelatih.tanggal_lahir, pelatih.tanggal_lahir) as tanggal_lahir'),
            DB::raw('COALESCE(cabang_pelatih.no_rek, pelatih.no_rek) as no_rek'),
            'users.id as id_user',
            DB::raw('COALESCE(cabang_pelatih.nama, users.nama) as nama'),
            DB::raw('COALESCE(cabang_pelatih.no_hp, users.no_hp) as no_hp'),
            'users.email',
            DB::raw('COALESCE(cabang_pelatih.status, users.status) as status'),
        ];

        if ($withEmailAndFoto) {
            $columns[] = DB::raw('CASE WHEN cabang_pelatih.hapus_foto = 1 THEN NULL ELSE COALESCE(cabang_pelatih.foto, users.foto) END as foto');
        }

        return $columns;
    }

    /**
     * Hapus file foto upload secara aman tanpa menyentuh aset bawaan di public/images/
     * dan tanpa menghapus foto yang masih dipakai baris users atau cabang_pelatih lain.
     */
    private function hapusFotoAman(?string $path): void
    {
        if (!$path) {
            return;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');
        if (!str_starts_with($normalized, 'uploads/')) {
            return;
        }

        $masihDipakaiUser = DB::table('users')->where('foto', $path)->exists();
        $masihDipakaiCabang = DB::table('cabang_pelatih')->where('foto', $path)->exists();

        if ($masihDipakaiUser || $masihDipakaiCabang) {
            return;
        }

        if (file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
    }

    /**
     * Upload foto pelatih ke public/uploads/pelatih.
     */
    private function uploadFotoPelatih(Request $request): ?string
    {
        if (!$request->hasFile('foto')) {
            return null;
        }

        $file = $request->file('foto');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = 'pelatih_' . time() . '_' . uniqid() . '.' . $extension;
        $destPath = public_path('uploads/pelatih');
        if (!file_exists($destPath)) {
            mkdir($destPath, 0755, true);
        }
        $file->move($destPath, $filename);

        return 'uploads/pelatih/' . $filename;
    }

    // Menampilkan halaman Manajemen Pelatih
    public function index(Request $request)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;

        // 1. Ambil daftar pelatih beserta data user-nya (terisolasi per cabang jika admin cabang)
        $query_pelatih = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id');

        if ($adminCabang) {
            $query_pelatih->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                          ->where('cabang_pelatih.id_cabang', $adminCabang)
                          ->select($this->selectPelatihCabangColumns(true));
        } else {
            $query_pelatih->select(
                'pelatih.id as id_pelatih',
                'pelatih.tempat_lahir',
                'pelatih.tanggal_lahir',
                'pelatih.no_rek',
                'users.id as id_user',
                'users.nama',
                'users.no_hp',
                'users.email',
                'users.foto',
                'users.status'
            );
        }

        if ($request->filled('search_pelatih')) {
            $searchPelatih = $request->search_pelatih;
            $query_pelatih->where(function ($q) use ($searchPelatih, $adminCabang) {
                if ($adminCabang) {
                    $q->whereRaw('COALESCE(cabang_pelatih.nama, users.nama) like ?', ['%' . $searchPelatih . '%']);
                } else {
                    $q->where('users.nama', 'like', '%' . $searchPelatih . '%');
                }
                $q->orWhere('users.email', 'like', '%' . $searchPelatih . '%');
            });
        }

        $data_pelatih = $query_pelatih->orderBy('nama', 'asc')->get();

        // 2. Absensi per pelatih (untuk modal detail) - difilter per cabang agar tidak tercampur antar cabang
        $absensiPerPelatihQuery = DB::table('absensi_pelatih')
            ->select('id', 'id_pelatih', 'tanggal_kehadiran', 'status_kehadiran', 'keterangan');
        if ($adminCabang) {
            $absensiPerPelatihQuery->where(function ($q) use ($adminCabang) {
                $q->where('id_cabang', $adminCabang)
                  ->orWhereNull('id_cabang');
            });
        }
        $absensi_per_pelatih = $absensiPerPelatihQuery
            ->orderBy('tanggal_kehadiran', 'desc')
            ->get()
            ->groupBy('id_pelatih');

        // 3. Query data absensi pelatih dengan filter (untuk tabel bawah)
        $query_absensi = DB::table('absensi_pelatih')
            ->join('pelatih', 'absensi_pelatih.id_pelatih', '=', 'pelatih.id')
            ->join('users', 'pelatih.id_user', '=', 'users.id');

        if ($adminCabang) {
            $query_absensi->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                          ->where('cabang_pelatih.id_cabang', $adminCabang)
                          ->where(function ($q) use ($adminCabang) {
                              $q->where('absensi_pelatih.id_cabang', $adminCabang)
                                ->orWhereNull('absensi_pelatih.id_cabang');
                          })
                          ->select(
                              'absensi_pelatih.id',
                              'absensi_pelatih.tanggal_kehadiran',
                              'absensi_pelatih.status_kehadiran',
                              'absensi_pelatih.keterangan',
                              DB::raw('COALESCE(cabang_pelatih.nama, users.nama) as nama_pelatih')
                          );
        } else {
            $query_absensi->select(
                'absensi_pelatih.id',
                'absensi_pelatih.tanggal_kehadiran',
                'absensi_pelatih.status_kehadiran',
                'absensi_pelatih.keterangan',
                'users.nama as nama_pelatih'
            );
        }

        // Filter Periode Absensi (Default: bulan dan tahun berjalan jika belum difilter)
        $bulanAbsensi = $request->has('bulan') ? $request->bulan : (string)date('n');
        $tahunAbsensi = $request->has('tahun') ? $request->tahun : (string)date('Y');

        // Filter Nama
        if ($request->filled('search_nama')) {
            if ($adminCabang) {
                $query_absensi->whereRaw('COALESCE(cabang_pelatih.nama, users.nama) like ?', ['%' . $request->search_nama . '%']);
            } else {
                $query_absensi->where('users.nama', 'like', '%' . $request->search_nama . '%');
            }
        }

        // Filter Bulan
        if ($bulanAbsensi !== 'semua' && !empty($bulanAbsensi)) {
            $query_absensi->whereMonth('absensi_pelatih.tanggal_kehadiran', (int) $bulanAbsensi);
        }

        // Filter Tahun
        if ($tahunAbsensi !== 'semua' && !empty($tahunAbsensi)) {
            $query_absensi->whereYear('absensi_pelatih.tanggal_kehadiran', (int) $tahunAbsensi);
        }

        // Filter Status
        if ($request->filled('filter_status') && $request->filter_status !== 'semua') {
            $query_absensi->where('absensi_pelatih.status_kehadiran', $request->filter_status);
        }

        // Filter Dari Tanggal
        if ($request->filled('from_date')) {
            $query_absensi->whereDate('absensi_pelatih.tanggal_kehadiran', '>=', $request->from_date);
        }

        // Filter Sampai Tanggal
        if ($request->filled('to_date')) {
            $query_absensi->whereDate('absensi_pelatih.tanggal_kehadiran', '<=', $request->to_date);
        }

        $data_absensi = $query_absensi->orderBy('absensi_pelatih.tanggal_kehadiran', 'desc')->get();

        // Hitung ringkasan jumlah pelatih pada cabang ini
        $allPelatihQuery = DB::table('pelatih')->join('users', 'pelatih.id_user', '=', 'users.id');
        if ($adminCabang) {
            $allPelatihQuery->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                            ->where('cabang_pelatih.id_cabang', $adminCabang)
                            ->select(DB::raw('COALESCE(cabang_pelatih.status, users.status) as status'));
        } else {
            $allPelatihQuery->select('users.status');
        }
        $all_pelatih   = $allPelatihQuery->get();
        $total_pelatih = $all_pelatih->count();
        $pelatih_aktif = $all_pelatih->where('status', 'aktif')->count();
        $pelatih_nonaktif = $all_pelatih->where('status', 'nonaktif')->count();

        // Ambil daftar tahun unik yang memiliki data absensi pelatih
        $dbYearsAbsensiQuery = DB::table('absensi_pelatih')
            ->selectRaw('DISTINCT YEAR(tanggal_kehadiran) as yr')
            ->whereNotNull('tanggal_kehadiran');
        if ($adminCabang) {
            $dbYearsAbsensiQuery->join('cabang_pelatih', 'absensi_pelatih.id_pelatih', '=', 'cabang_pelatih.id_pelatih')
                ->where('cabang_pelatih.id_cabang', $adminCabang)
                ->where(function ($q) use ($adminCabang) {
                    $q->where('absensi_pelatih.id_cabang', $adminCabang)
                      ->orWhereNull('absensi_pelatih.id_cabang');
                });
        }
        $dbYearsAbsensi = $dbYearsAbsensiQuery->pluck('yr')->map(fn($y) => (int)$y)->toArray();
        $listTahun = array_values(array_unique(array_merge([(int)date('Y')], $dbYearsAbsensi)));
        rsort($listTahun);

        return view('admin.pelatih', compact('data_pelatih', 'data_absensi', 'absensi_per_pelatih', 'total_pelatih', 'pelatih_aktif', 'pelatih_nonaktif', 'bulanAbsensi', 'tahunAbsensi', 'listTahun'));
    }

    // Export 1: Data Master Pelatih ke file CSV (ID Pelatih, Nama, Email, No HP, TTL, No Rekening, Keahlian, Alamat, Status, Total Hadir/Izin/Sakit)
    public function export(Request $request)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id');

        if ($adminCabang) {
            $query->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                  ->where('cabang_pelatih.id_cabang', $adminCabang)
                  ->select($this->selectPelatihCabangColumns(false));
        } else {
            $query->select(
                'pelatih.id as id_pelatih',
                'pelatih.tempat_lahir',
                'pelatih.tanggal_lahir',
                'pelatih.no_rek',
                'users.id as id_user',
                'users.nama',
                'users.no_hp',
                'users.email',
                'users.status'
            );
        }

        if ($request->filled('search_pelatih')) {
            $searchPelatih = $request->search_pelatih;
            $query->where(function ($q) use ($searchPelatih, $adminCabang) {
                if ($adminCabang) {
                    $q->whereRaw('COALESCE(cabang_pelatih.nama, users.nama) like ?', ['%' . $searchPelatih . '%']);
                } else {
                    $q->where('users.nama', 'like', '%' . $searchPelatih . '%');
                }
                $q->orWhere('users.email', 'like', '%' . $searchPelatih . '%');
            });
        }

        $pelatih = $query->orderBy('nama', 'asc')->get();

        $absensiQuery = DB::table('absensi_pelatih')
            ->select('id_pelatih', 'status_kehadiran');
        if ($adminCabang) {
            $absensiQuery->where(function ($q) use ($adminCabang) {
                $q->where('id_cabang', $adminCabang)
                  ->orWhereNull('id_cabang');
            });
        }
        $absensi = $absensiQuery->get()->groupBy('id_pelatih');

        $filename = 'data_pelatih_gajah_depa_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($pelatih, $absensi) {
            $handle = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Microsoft Excel membaca karakter dengan benar
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'ID Pelatih',
                'Nama Lengkap',
                'Email',
                'No. HP / WhatsApp',
                'Tempat Lahir',
                'Tanggal Lahir',
                'No. Rekening',
                'Status',
                'Total Hadir',
                'Total Izin',
                'Total Sakit',
            ]);

            $no = 1;
            foreach ($pelatih as $item) {
                $riwayat = $absensi->get($item->id_pelatih, collect([]));
                $hadir   = $riwayat->where('status_kehadiran', 'hadir')->count();
                $izin    = $riwayat->where('status_kehadiran', 'izin')->count();
                $sakit   = $riwayat->where('status_kehadiran', 'sakit')->count();

                $formattedId = 'PL' . str_pad($item->id_pelatih, 3, '0', STR_PAD_LEFT);
                $tglLahir    = $item->tanggal_lahir ? date('d/m/Y', strtotime($item->tanggal_lahir)) : '-';

                fputcsv($handle, [
                    $no++,
                    $formattedId,
                    $item->nama,
                    $item->email,
                    $item->no_hp ?? '-',
                    $item->tempat_lahir ?? '-',
                    $tglLahir,
                    $item->no_rek ? "'" . $item->no_rek : '-',
                    ucfirst($item->status),
                    $hadir,
                    $izin,
                    $sakit,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export 2: Absensi Pelatih ke file CSV (Mendukung format 'rekap' per pelatih atau format 'sesi' log per sesi)
    public function exportAbsensi(Request $request)
    {
        $format    = $request->input('format') ?: $request->input('export_type', 'rekap');
        $startDate = $request->input('start_date') ?: $request->input('from_date');
        $endDate   = $request->input('end_date') ?: $request->input('to_date');

        $labelRentang = 'semua_waktu';
        if (!empty($startDate) || !empty($endDate)) {
            $labelRentang = ($startDate ?: 'awal') . '_sd_' . ($endDate ?: 'akhir');
        }

        // Pilihan 1: Log Kehadiran Per Sesi Pelatih (No, Tanggal, Nama, Status, Keterangan)
        if ($format === 'sesi') {
            $adminCabang = Auth::user()->id_cabang ?? null;
            $query_absensi = DB::table('absensi_pelatih')
                ->join('pelatih', 'absensi_pelatih.id_pelatih', '=', 'pelatih.id')
                ->join('users', 'pelatih.id_user', '=', 'users.id');

            if ($adminCabang) {
                $query_absensi->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                              ->where('cabang_pelatih.id_cabang', $adminCabang)
                              ->where(function ($q) use ($adminCabang) {
                                  $q->where('absensi_pelatih.id_cabang', $adminCabang)
                                    ->orWhereNull('absensi_pelatih.id_cabang');
                              })
                              ->select(
                                  'absensi_pelatih.id',
                                  'absensi_pelatih.tanggal_kehadiran',
                                  'absensi_pelatih.status_kehadiran',
                                  'absensi_pelatih.keterangan',
                                  DB::raw('COALESCE(cabang_pelatih.nama, users.nama) as nama_pelatih')
                              );
            } else {
                $query_absensi->select(
                    'absensi_pelatih.id',
                    'absensi_pelatih.tanggal_kehadiran',
                    'absensi_pelatih.status_kehadiran',
                    'absensi_pelatih.keterangan',
                    'users.nama as nama_pelatih'
                );
            }

            if (!empty($startDate)) {
                $query_absensi->whereDate('absensi_pelatih.tanggal_kehadiran', '>=', $startDate);
            }
            if (!empty($endDate)) {
                $query_absensi->whereDate('absensi_pelatih.tanggal_kehadiran', '<=', $endDate);
            }
            if ($request->filled('search_nama')) {
                if ($adminCabang) {
                    $query_absensi->whereRaw('COALESCE(cabang_pelatih.nama, users.nama) like ?', ['%' . $request->search_nama . '%']);
                } else {
                    $query_absensi->where('users.nama', 'like', '%' . $request->search_nama . '%');
                }
            }
            if ($request->filled('filter_status') && $request->filter_status !== 'semua') {
                $query_absensi->where('absensi_pelatih.status_kehadiran', $request->filter_status);
            }

            $absensi = $query_absensi->orderBy('absensi_pelatih.tanggal_kehadiran', 'desc')
                                     ->orderBy('nama_pelatih', 'asc')
                                     ->get();

            $filename = 'log_absensi_pelatih_' . $labelRentang . '_' . date('His') . '.csv';

            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma'              => 'no-cache',
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Expires'             => '0',
            ];

            $callback = function () use ($absensi) {
                $handle = fopen('php://output', 'w');
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                fputcsv($handle, [
                    'No',
                    'Tanggal Kehadiran',
                    'Nama Pelatih',
                    'Status Kehadiran',
                    'Keterangan',
                ]);

                $no = 1;
                foreach ($absensi as $row) {
                    $status = match($row->status_kehadiran) {
                        'hadir' => 'Hadir',
                        'izin'  => 'Izin',
                        'sakit' => 'Sakit',
                        default => ucfirst($row->status_kehadiran),
                    };

                    $tgl = date('d/m/Y', strtotime($row->tanggal_kehadiran));

                    fputcsv($handle, [
                        $no++,
                        $tgl,
                        $row->nama_pelatih,
                        $status,
                        $row->keterangan ?? '-',
                    ]);
                }
                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Pilihan 2: Rekap Per Pelatih (No, Nama Pelatih, Total Hadir, Total Izin, Total Sakit)
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id');

        if ($adminCabang) {
            $query->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                  ->where('cabang_pelatih.id_cabang', $adminCabang)
                  ->select(
                      'pelatih.id as id_pelatih',
                      DB::raw('COALESCE(cabang_pelatih.nama, users.nama) as nama_pelatih')
                  );
        } else {
            $query->select(
                'pelatih.id as id_pelatih',
                'users.nama as nama_pelatih'
            );
        }

        if ($request->filled('search_nama')) {
            if ($adminCabang) {
                $query->whereRaw('COALESCE(cabang_pelatih.nama, users.nama) like ?', ['%' . $request->search_nama . '%']);
            } else {
                $query->where('users.nama', 'like', '%' . $request->search_nama . '%');
            }
        }

        $pelatih = $query->orderBy('nama_pelatih', 'asc')->get();

        $queryAbsensi = DB::table('absensi_pelatih')->select('id_pelatih', 'status_kehadiran');
        if ($adminCabang) {
            $queryAbsensi->where(function ($q) use ($adminCabang) {
                $q->where('id_cabang', $adminCabang)
                  ->orWhereNull('id_cabang');
            });
        }
        if (!empty($startDate)) {
            $queryAbsensi->whereDate('tanggal_kehadiran', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $queryAbsensi->whereDate('tanggal_kehadiran', '<=', $endDate);
        }

        $absensi = $queryAbsensi->get()->groupBy('id_pelatih');

        $filename = 'rekap_absensi_pelatih_' . $labelRentang . '_' . date('His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($pelatih, $absensi) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'Nama Pelatih',
                'Total Hadir',
                'Total Izin',
                'Total Sakit',
            ]);

            $no = 1;
            foreach ($pelatih as $item) {
                $riwayat = $absensi->get($item->id_pelatih, collect([]));
                $hadir   = $riwayat->where('status_kehadiran', 'hadir')->count();
                $izin    = $riwayat->where('status_kehadiran', 'izin')->count();
                $sakit   = $riwayat->where('status_kehadiran', 'sakit')->count();

                fputcsv($handle, [
                    $no++,
                    $item->nama_pelatih,
                    $hadir,
                    $izin,
                    $sakit,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Memproses Tambah Pelatih Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'email'         => 'required|email',
            'no_hp'         => 'nullable|string|max:30',
            'no_rek'        => 'required|string|max:50',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required'          => 'Nama lengkap pelatih wajib diisi.',
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'no_rek.required'        => 'Nomor rekening wajib diisi.',
            'foto.image'             => 'File foto harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpeg, png, jpg, atau webp.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ]);

        $adminCabang = Auth::user()->id_cabang ?? null;
        $existingUser = DB::table('users')
            ->whereRaw('LOWER(email) = ?', [strtolower(trim($request->email))])
            ->first();

        if ($existingUser) {
            if ($existingUser->role !== 'pelatih' || !$adminCabang) {
                return redirect()->back()
                    ->withErrors(['email' => 'Email ini sudah terdaftar di sistem.'])
                    ->withInput();
            }

            $existingPelatih = DB::table('pelatih')->where('id_user', $existingUser->id)->first();
            if ($existingPelatih) {
                $alreadyInBranch = DB::table('cabang_pelatih')
                    ->where('id_pelatih', $existingPelatih->id)
                    ->where('id_cabang', $adminCabang)
                    ->exists();

                if ($alreadyInBranch) {
                    return redirect()->back()
                        ->withErrors(['email' => 'Pelatih dengan email ini sudah terdaftar di cabang ini.'])
                        ->withInput();
                }
            }

            DB::transaction(function () use ($request, $existingUser, $existingPelatih, $adminCabang) {
                $fotoPath = $this->uploadFotoPelatih($request) ?? $existingUser->foto;

                if ($existingPelatih) {
                    $pelatihId = $existingPelatih->id;
                } else {
                    $pelatihId = DB::table('pelatih')->insertGetId([
                        'id_user'       => $existingUser->id,
                        'tempat_lahir'  => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'no_rek'        => $request->no_rek,
                    ]);
                }

                DB::table('cabang_pelatih')->insert([
                    'id_pelatih'    => $pelatihId,
                    'id_cabang'     => $adminCabang,
                    'nama'          => $request->nama,
                    'no_hp'         => $request->filled('no_hp') ? $request->no_hp : null,
                    'tempat_lahir'  => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'no_rek'        => $request->no_rek,
                    'foto'          => $fotoPath,
                    'hapus_foto'    => false,
                    'status'        => 'aktif',
                ]);
            });

            return redirect()->back()->with('sukses', 'Pelatih berhasil ditambahkan ke cabang ini!');
        }

        DB::transaction(function () use ($request, $adminCabang) {
            $fotoPath = $this->uploadFotoPelatih($request);

            // 1. Buat User baru dengan role pelatih (password kosong, aktivasi mandiri di halaman Register)
            $user = User::create([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'no_hp'         => $request->filled('no_hp') ? $request->no_hp : null,
                'jenis_kelamin' => 'laki-laki',
                'password'      => null,
                'password_set'  => false,
                'role'          => 'pelatih',
                'foto'          => $fotoPath,
                'status'        => 'aktif',
                'id_cabang'     => $adminCabang,
            ]);

            // 2. Buat profil pelatih
            $pelatihId = DB::table('pelatih')->insertGetId([
                'id_user'       => $user->id,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_rek'        => $request->no_rek,
            ]);

            if ($adminCabang) {
                DB::table('cabang_pelatih')->insert([
                    'id_pelatih'    => $pelatihId,
                    'id_cabang'     => $adminCabang,
                    'nama'          => $request->nama,
                    'no_hp'         => $request->filled('no_hp') ? $request->no_hp : null,
                    'tempat_lahir'  => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'no_rek'        => $request->no_rek,
                    'foto'          => $fotoPath,
                    'hapus_foto'    => false,
                    'status'        => 'aktif',
                ]);
            }
        });

        return redirect()->back()->with('sukses', 'Pelatih baru berhasil ditambahkan!');
    }

    // Memproses Input Absensi Pelatih secara Batch
    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'tanggal_kehadiran' => 'required|date',
            'absensi'           => 'required|array',
        ], [
            'absensi.required' => 'Tidak ada data pelatih yang dikirim untuk diabsen.',
        ]);

        $tanggal = $request->tanggal_kehadiran;
        $adminCabang = Auth::user()->id_cabang ?? null;
        $savedCount = 0;

        foreach ($request->absensi as $id_pelatih => $item) {
            // Pelatih dengan status nonaktif (off) pada cabang ini tidak bisa diabsen
            $pelatihQuery = DB::table('pelatih')
                ->join('users', 'pelatih.id_user', '=', 'users.id')
                ->where('pelatih.id', $id_pelatih);

            if ($adminCabang) {
                $pelatihQuery->join('cabang_pelatih', 'pelatih.id', '=', 'cabang_pelatih.id_pelatih')
                             ->where('cabang_pelatih.id_cabang', $adminCabang)
                             ->select(DB::raw('COALESCE(cabang_pelatih.status, users.status) as status'));
            } else {
                $pelatihQuery->select('users.status');
            }

            $pelatih = $pelatihQuery->first();

            if (!$pelatih || strtolower($pelatih->status) !== 'aktif') {
                continue; // Lewati pelatih yang nonaktif
            }

            $matchWhere = [
                'id_pelatih'        => $id_pelatih,
                'tanggal_kehadiran' => $tanggal,
            ];
            if ($adminCabang) {
                $matchWhere['id_cabang'] = $adminCabang;
            }

            DB::table('absensi_pelatih')->updateOrInsert(
                $matchWhere,
                [
                    'id_cabang'        => $adminCabang,
                    'status_kehadiran' => $item['status'] ?? 'hadir',
                    'keterangan'       => $item['keterangan'] ?? '-',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );
            $savedCount++;
        }

        if ($savedCount === 0) {
            return redirect()->back()->withErrors(['msg' => 'Tidak ada absensi yang disimpan karena pelatih yang dipilih sedang berstatus nonaktif (off).']);
        }

        return redirect()->back()->with('sukses', "Data absensi ({$savedCount} pelatih aktif) berhasil disimpan!");
    }

    // Memperbarui Data Absensi Pelatih
    public function updateAbsensi(Request $request, $id)
    {
        $request->validate([
            'tanggal_kehadiran' => 'required|date',
            'status_kehadiran'  => 'required|in:hadir,izin,sakit,tidak_hadir',
            'keterangan'        => 'nullable|string|max:255',
        ], [
            'tanggal_kehadiran.required' => 'Tanggal kehadiran wajib diisi.',
            'status_kehadiran.required'  => 'Status kehadiran wajib dipilih.',
            'status_kehadiran.in'        => 'Status kehadiran tidak valid.',
        ]);

        $absensi = DB::table('absensi_pelatih')->where('id', $id)->first();
        if (!$absensi) {
            return redirect()->back()->withErrors(['msg' => 'Data absensi pelatih tidak ditemukan.']);
        }

        DB::table('absensi_pelatih')->where('id', $id)->update([
            'tanggal_kehadiran' => $request->tanggal_kehadiran,
            'status_kehadiran'  => $request->status_kehadiran,
            'keterangan'        => $request->keterangan ?: '-',
            'updated_at'        => now(),
        ]);

        return redirect()->back()->with('sukses', 'Data absensi pelatih berhasil diperbarui.');
    }

    // Menghapus Data Absensi Pelatih
    public function deleteAbsensi($id)
    {
        $absensi = DB::table('absensi_pelatih')->where('id', $id)->first();
        if (!$absensi) {
            return redirect()->back()->withErrors(['msg' => 'Data absensi pelatih tidak ditemukan.']);
        }

        DB::table('absensi_pelatih')->where('id', $id)->delete();

        return redirect()->back()->with('sukses', 'Data absensi pelatih berhasil dihapus.');
    }

    // Menghapus Banyak Data Absensi Pelatih Sekaligus (Bulk Delete)
    public function bulkDeleteAbsensi(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return redirect()->back()->withErrors(['msg' => 'Tidak ada data absensi pelatih yang dipilih.']);
        }

        $count = DB::table('absensi_pelatih')->whereIn('id', $ids)->delete();

        return redirect()->back()->with('sukses', $count . ' data absensi pelatih berhasil dihapus.');
    }

    // Update Data Pelatih oleh Admin (terisolasi per cabang jika Admin Cabang)
    public function update(Request $request, $id)
    {
        $pelatih = DB::table('pelatih')->where('id', $id)->first();
        if (!$pelatih) {
            return redirect()->back()->withErrors(['msg' => 'Data pelatih tidak ditemukan.']);
        }

        $adminCabang = Auth::user()->id_cabang ?? null;
        if ($adminCabang) {
            $terdaftarDiCabang = DB::table('cabang_pelatih')
                ->where('id_pelatih', $id)
                ->where('id_cabang', $adminCabang)
                ->exists();
            if (!$terdaftarDiCabang) {
                return redirect()->back()->withErrors(['msg' => 'Data pelatih tidak terdaftar di cabang ini.']);
            }
        }

        $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'email'         => 'required|email|unique:users,email,' . $pelatih->id_user,
            'no_hp'         => 'nullable|string|max:30',
            'no_rek'        => 'required|string|max:50',
            'status'        => 'required|in:aktif,nonaktif',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required'          => 'Nama lengkap pelatih wajib diisi.',
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email ini sudah digunakan akun lain.',
            'no_rek.required'        => 'Nomor rekening wajib diisi.',
            'status.required'        => 'Status pelatih wajib dipilih.',
            'foto.image'             => 'File foto harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpeg, png, jpg, atau webp.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ]);

        $newFotoPath = $this->uploadFotoPelatih($request);
        $fotosToDelete = [];

        DB::transaction(function () use ($request, $id, $pelatih, $adminCabang, $newFotoPath, &$fotosToDelete) {
            if ($adminCabang) {
                $cabangPelatih = DB::table('cabang_pelatih')
                    ->where('id_pelatih', $id)
                    ->where('id_cabang', $adminCabang)
                    ->first();

                $branchUpdateData = [
                    'nama'          => $request->nama,
                    'no_hp'         => $request->filled('no_hp') ? $request->no_hp : null,
                    'tempat_lahir'  => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'no_rek'        => $request->no_rek,
                    'status'        => $request->status,
                ];

                $oldBranchFoto = $cabangPelatih->foto ?? null;
                if ($newFotoPath) {
                    $branchUpdateData['foto'] = $newFotoPath;
                    $branchUpdateData['hapus_foto'] = false;
                    if ($oldBranchFoto) {
                        $fotosToDelete[] = $oldBranchFoto;
                    }
                } elseif ($request->boolean('hapus_foto')) {
                    $branchUpdateData['foto'] = null;
                    $branchUpdateData['hapus_foto'] = true;
                    if ($oldBranchFoto) {
                        $fotosToDelete[] = $oldBranchFoto;
                    }
                }

                DB::table('cabang_pelatih')->updateOrInsert(
                    ['id_pelatih' => $id, 'id_cabang' => $adminCabang],
                    $branchUpdateData
                );

                $hasOtherBranch = DB::table('cabang_pelatih')
                    ->where('id_pelatih', $id)
                    ->where('id_cabang', '!=', $adminCabang)
                    ->exists();

                if ($hasOtherBranch) {
                    // Pelatih terdaftar di cabang lain: jangan ubah profil/foto/status global agar cabang lain tetap utuh
                    DB::table('users')->where('id', $pelatih->id_user)->update([
                        'email'      => $request->email,
                        'updated_at' => now(),
                    ]);
                    return;
                }
            }

            $userUpdateData = [
                'nama'       => $request->nama,
                'email'      => $request->email,
                'no_hp'      => $request->filled('no_hp') ? $request->no_hp : null,
                'status'     => $request->status,
                'updated_at' => now(),
            ];

            $oldUserFoto = DB::table('users')->where('id', $pelatih->id_user)->value('foto');
            if ($newFotoPath) {
                $userUpdateData['foto'] = $newFotoPath;
                if ($oldUserFoto) {
                    $fotosToDelete[] = $oldUserFoto;
                }
            } elseif ($request->boolean('hapus_foto')) {
                $userUpdateData['foto'] = null;
                if ($oldUserFoto) {
                    $fotosToDelete[] = $oldUserFoto;
                }
            }

            // Update tabel users
            DB::table('users')->where('id', $pelatih->id_user)->update($userUpdateData);

            // Update tabel pelatih
            $pelatihUpdateData = [
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_rek'        => $request->no_rek,
            ];

            if (Schema::hasColumn('pelatih', 'updated_at')) {
                $pelatihUpdateData['updated_at'] = now();
            }

            DB::table('pelatih')->where('id', $id)->update($pelatihUpdateData);
        });

        foreach (array_unique($fotosToDelete) as $oldFoto) {
            $this->hapusFotoAman($oldFoto);
        }

        return redirect()->route('admin.pelatih.index')->with('sukses', 'Data pelatih ' . $request->nama . ' berhasil diperbarui!');
    }

    // Hapus Data Pelatih oleh Admin (hanya dari cabang ini jika masih terdaftar di cabang lain)
    public function destroy(Request $request, $id)
    {
        $pelatih = DB::table('pelatih')->where('id', $id)->first();

        if (!$pelatih) {
            return redirect()->back()->withErrors(['msg' => 'Data pelatih tidak ditemukan.']);
        }

        $adminCabang = Auth::user()->id_cabang ?? null;
        $user = DB::table('users')->where('id', $pelatih->id_user)->first();
        $cabangPelatih = $adminCabang
            ? DB::table('cabang_pelatih')->where('id_pelatih', $id)->where('id_cabang', $adminCabang)->first()
            : null;
        $namaPelatih = ($cabangPelatih->nama ?? null) ?: ($user ? $user->nama : 'Pelatih');
        $fotosToDelete = [];

        DB::transaction(function () use ($pelatih, $id, $user, $adminCabang, $cabangPelatih, &$fotosToDelete) {
            if ($adminCabang) {
                if ($cabangPelatih && $cabangPelatih->foto) {
                    $fotosToDelete[] = $cabangPelatih->foto;
                }

                // 1. Hapus data absensi pelatih khusus cabang ini
                DB::table('absensi_pelatih')
                    ->where('id_pelatih', $id)
                    ->where('id_cabang', $adminCabang)
                    ->delete();

                // 2. Hapus relasi cabang ini saja
                DB::table('cabang_pelatih')
                    ->where('id_pelatih', $id)
                    ->where('id_cabang', $adminCabang)
                    ->delete();

                $remainingBranches = DB::table('cabang_pelatih')
                    ->where('id_pelatih', $id)
                    ->count();

                if ($remainingBranches > 0) {
                    // Masih terdaftar di cabang lain: pastikan users.id_cabang mengarah ke cabang aktif yang tersisa
                    $otherBranchId = DB::table('cabang_pelatih')->where('id_pelatih', $id)->value('id_cabang');
                    if ($user && (int)$user->id_cabang === (int)$adminCabang && $otherBranchId) {
                        DB::table('users')->where('id', $user->id)->update(['id_cabang' => $otherBranchId]);
                    }
                    return;
                }
            }

            // Jika tidak ada lagi di cabang mana pun (atau admin pusat): hapus permanen akun & profil pelatih
            if ($user && $user->foto) {
                $fotosToDelete[] = $user->foto;
            }
            $cpFotos = DB::table('cabang_pelatih')->where('id_pelatih', $id)->whereNotNull('foto')->pluck('foto')->all();
            $fotosToDelete = array_merge($fotosToDelete, $cpFotos);

            DB::table('absensi_pelatih')->where('id_pelatih', $id)->delete();
            DB::table('ulasan_pelatih')->where('id_pelatih', $id)->delete();
            DB::table('cabang_pelatih')->where('id_pelatih', $id)->delete();
            DB::table('pelatih')->where('id', $id)->delete();
            DB::table('users')->where('id', $pelatih->id_user)->delete();
        });

        foreach (array_unique($fotosToDelete) as $oldFoto) {
            $this->hapusFotoAman($oldFoto);
        }

        return redirect()->back()->with('sukses', 'Data pelatih ' . $namaPelatih . ' berhasil dihapus dari cabang ini.');
    }
}
