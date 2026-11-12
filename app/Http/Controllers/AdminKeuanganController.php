<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('keuangan');

        if ($adminCabang) {
            $query->where('id_cabang', $adminCabang);
        }

        // Filter Pencarian Deskripsi / Keterangan
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('keterangan', 'like', "%{$search}%");
        }

        // Filter Tipe Transaksi (pemasukan / pengeluaran)
        if ($request->filled('jenis_transaksi') && $request->jenis_transaksi !== 'semua') {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // Filter Periode (Default: bulan dan tahun berjalan)
        $bulan = $request->has('bulan') ? $request->bulan : (string)date('n');
        $tahun = $request->has('tahun') ? $request->tahun : (string)date('Y');

        // Filter Bulan
        if ($bulan !== 'semua' && !empty($bulan)) {
            $query->whereMonth('tanggal_transaksi', (int)$bulan);
        }

        // Filter Tahun
        if ($tahun !== 'semua' && !empty($tahun)) {
            $query->whereYear('tanggal_transaksi', (int)$tahun);
        }

        // Filter Dari Tanggal
        if ($request->filled('from_date')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->from_date);
        }

        // Filter Sampai Tanggal
        if ($request->filled('to_date')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->to_date);
        }

        // Ambil transaksi keuangan sesuai filter
        $transaksi = $query->orderBy('tanggal_transaksi', 'desc')->get();

        // Daftar tahun yang ada pada catatan transaksi keuangan
        $currentYear = (int)date('Y');
        $dbYearsQuery = DB::table('keuangan')
            ->selectRaw('DISTINCT YEAR(tanggal_transaksi) as yr')
            ->whereNotNull('tanggal_transaksi');
        if ($adminCabang) {
            $dbYearsQuery->where('id_cabang', $adminCabang);
        }
        $dbYears = $dbYearsQuery->pluck('yr')->map(fn($y) => (int)$y)->toArray();
        $listTahun = array_values(array_unique(array_merge([$currentYear], $dbYears)));
        rsort($listTahun);

        // Query statistik yang tersinkronisasi dengan cabang dan filter periode
        $baseStatQuery = DB::table('keuangan');
        if ($adminCabang) {
            $baseStatQuery->where('id_cabang', $adminCabang);
        }
        if ($bulan !== 'semua' && !empty($bulan)) {
            $baseStatQuery->whereMonth('tanggal_transaksi', (int)$bulan);
        }
        if ($tahun !== 'semua' && !empty($tahun)) {
            $baseStatQuery->whereYear('tanggal_transaksi', (int)$tahun);
        }
        if ($request->filled('from_date')) {
            $baseStatQuery->whereDate('tanggal_transaksi', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $baseStatQuery->whereDate('tanggal_transaksi', '<=', $request->to_date);
        }

        // Hitung total pemasukan
        $totalPemasukan = (clone $baseStatQuery)->where('jenis_transaksi', 'pemasukan')->sum('nominal');

        // Hitung total pengeluaran
        $totalPengeluaran = (clone $baseStatQuery)->where('jenis_transaksi', 'pengeluaran')->sum('nominal');

        // Hitung saldo bersih (Net Balance)
        $netBalance = $totalPemasukan - $totalPengeluaran;

        // Total transaksi tercatat
        $totalTransaksi = (clone $baseStatQuery)->count();

        // Hitung saldo kas riil keseluruhan cabang (all-time)
        $allTimeQuery = DB::table('keuangan');
        if ($adminCabang) {
            $allTimeQuery->where('id_cabang', $adminCabang);
        }
        $totalMasukAll = (clone $allTimeQuery)->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalKeluarAll = (clone $allTimeQuery)->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldoKasAllTime = $totalMasukAll - $totalKeluarAll;

        return view('admin.keuangan', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'netBalance', 'totalTransaksi', 'listTahun', 'bulan', 'tahun', 'saldoKasAllTime'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi'   => 'required|in:pemasukan,pengeluaran',
            'nominal'           => 'required|numeric|min:0',
            'keterangan'        => 'required|string|max:255',
            'tanggal_transaksi' => 'required|date',
        ], [
            'jenis_transaksi.required'   => 'Tipe transaksi wajib dipilih.',
            'nominal.required'           => 'Nominal transaksi wajib diisi.',
            'nominal.numeric'            => 'Nominal transaksi harus berupa angka.',
            'keterangan.required'        => 'Deskripsi transaksi wajib diisi.',
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
        ]);

        $adminCabang = Auth::user()->id_cabang ?? 1;

        DB::table('keuangan')->insert([
            'jenis_transaksi'   => $request->jenis_transaksi,
            'nominal'           => $request->nominal,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'status'            => 'lunas',
            'id_cabang'         => $adminCabang,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi keuangan berhasil ditambahkan.');
    }

    // Memperbarui Data Transaksi Keuangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_transaksi'   => 'required|in:pemasukan,pengeluaran',
            'nominal'           => 'required|numeric|min:0',
            'keterangan'        => 'required|string|max:255',
            'tanggal_transaksi' => 'required|date',
        ], [
            'jenis_transaksi.required'   => 'Tipe transaksi wajib dipilih.',
            'nominal.required'           => 'Nominal transaksi wajib diisi.',
            'nominal.numeric'            => 'Nominal transaksi harus berupa angka.',
            'keterangan.required'        => 'Deskripsi transaksi wajib diisi.',
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
        ]);

        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('keuangan')->where('id', $id);
        if ($adminCabang) {
            $query->where('id_cabang', $adminCabang);
        }
        $transaksi = $query->first();

        if (!$transaksi) {
            return redirect()->back()->withErrors(['msg' => 'Data transaksi tidak ditemukan atau bukan milik cabang Anda.']);
        }

        DB::table('keuangan')->where('id', $id)->update([
            'jenis_transaksi'   => $request->jenis_transaksi,
            'nominal'           => $request->nominal,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'updated_at'        => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    // Menghapus Transaksi Keuangan
    public function destroy($id)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('keuangan')->where('id', $id);
        if ($adminCabang) {
            $query->where('id_cabang', $adminCabang);
        }
        $transaksi = $query->first();

        if (!$transaksi) {
            return redirect()->back()->withErrors(['msg' => 'Data transaksi tidak ditemukan atau bukan milik cabang Anda.']);
        }

        DB::table('keuangan')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Transaksi keuangan berhasil dihapus.');
    }

    // Export Laporan Keuangan ke format CSV (Excel) dengan Pengaturan Rentang Tanggal
    public function export(Request $request)
    {
        $adminCabang = Auth::user()->id_cabang ?? null;
        $query = DB::table('keuangan');

        if ($adminCabang) {
            $query->where('id_cabang', $adminCabang);
        }

        $startDate = $request->input('from_date') ?: $request->input('start_date');
        $endDate   = $request->input('to_date') ?: $request->input('end_date');

        $labelRentang = 'semua_waktu';
        if (!empty($startDate) || !empty($endDate)) {
            if (!empty($startDate)) {
                $query->whereDate('tanggal_transaksi', '>=', $startDate);
            }
            if (!empty($endDate)) {
                $query->whereDate('tanggal_transaksi', '<=', $endDate);
            }
            $labelRentang = ($startDate ?: 'awal') . '_sd_' . ($endDate ?: 'akhir');
        }

        if ($request->filled('bulan') && $request->bulan !== 'semua') {
            $query->whereMonth('tanggal_transaksi', (int)$request->bulan);
            $labelRentang = 'bulan_' . $request->bulan . '_' . $labelRentang;
        }

        if ($request->filled('tahun') && $request->tahun !== 'semua') {
            $query->whereYear('tanggal_transaksi', (int)$request->tahun);
            $labelRentang = 'tahun_' . $request->tahun . '_' . $labelRentang;
        }

        if ($request->filled('jenis_transaksi') && $request->jenis_transaksi !== 'semua') {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $data_transaksi = $query->orderBy('tanggal_transaksi', 'desc')->get();

        $filename = 'laporan_keuangan_gajah_depa_' . $labelRentang . '_' . date('His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($data_transaksi) {
            $handle = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Excel menampilkan karakter dengan benar
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Kolom CSV Keuangan
            fputcsv($handle, [
                'No',
                'Tanggal Transaksi',
                'Tipe Transaksi',
                'Nominal (Rp)',
                'Deskripsi / Keterangan',
            ]);

            $no = 1;
            $totalMasuk = 0;
            $totalKeluar = 0;

            foreach ($data_transaksi as $row) {
                $tipe = $row->jenis_transaksi === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran';
                $tgl  = date('d/m/Y', strtotime($row->tanggal_transaksi));

                if ($row->jenis_transaksi === 'pemasukan') {
                    $totalMasuk += $row->nominal;
                } else {
                    $totalKeluar += $row->nominal;
                }

                fputcsv($handle, [
                    $no++,
                    $tgl,
                    $tipe,
                    $row->nominal,
                    $row->keterangan ?? '-',
                ]);
            }

            // Baris Rangkuman Total
            fputcsv($handle, []);
            fputcsv($handle, ['', '', 'Total Pemasukan', $totalMasuk, '']);
            fputcsv($handle, ['', '', 'Total Pengeluaran', $totalKeluar, '']);
            fputcsv($handle, ['', '', 'Saldo Bersih (Net Balance)', ($totalMasuk - $totalKeluar), '']);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
