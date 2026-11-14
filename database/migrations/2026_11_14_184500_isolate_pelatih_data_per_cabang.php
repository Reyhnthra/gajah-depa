<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Isolasi profil pelatih per cabang pada tabel cabang_pelatih
     * dan isolasi absensi pelatih per cabang pada absensi_pelatih.
     */
    public function up(): void
    {
        if (Schema::hasTable('cabang_pelatih')) {
            Schema::table('cabang_pelatih', function (Blueprint $table) {
                if (!Schema::hasColumn('cabang_pelatih', 'nama')) {
                    $table->string('nama')->nullable()->after('id_cabang');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'no_hp')) {
                    $table->string('no_hp', 30)->nullable()->after('nama');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'tempat_lahir')) {
                    $table->string('tempat_lahir')->nullable()->after('no_hp');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'tanggal_lahir')) {
                    $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'no_rek')) {
                    $table->string('no_rek')->nullable()->after('tanggal_lahir');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'foto')) {
                    $table->string('foto')->nullable()->after('no_rek');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'hapus_foto')) {
                    $table->boolean('hapus_foto')->default(false)->after('foto');
                }
                if (!Schema::hasColumn('cabang_pelatih', 'status')) {
                    $table->string('status', 20)->nullable()->default('aktif')->after('hapus_foto');
                }
            });
        }

        if (Schema::hasTable('absensi_pelatih') && !Schema::hasColumn('absensi_pelatih', 'id_cabang')) {
            Schema::table('absensi_pelatih', function (Blueprint $table) {
                $table->unsignedBigInteger('id_cabang')->nullable()->after('id_pelatih');
            });
        }

        // Pulihkan foto master Fajar jika sempat hilang akibat unlink/sync sebelumnya
        $fajarFoto = file_exists(public_path('images/fajar.png')) ? 'images/fajar.png' : null;
        if ($fajarFoto) {
            DB::table('users')
                ->whereRaw('LOWER(email) = ?', ['fajaran16@gmail.com'])
                ->where(function ($q) {
                    $q->whereNull('foto')->orWhere('foto', '');
                })
                ->update(['foto' => $fajarFoto]);
        }

        // Salin profil awal dari tabel users & pelatih ke masing-masing baris cabang_pelatih yang belum terisi
        if (Schema::hasTable('cabang_pelatih')) {
            $rows = DB::table('cabang_pelatih')
                ->join('pelatih', 'cabang_pelatih.id_pelatih', '=', 'pelatih.id')
                ->join('users', 'pelatih.id_user', '=', 'users.id')
                ->select(
                    'cabang_pelatih.id as cp_id',
                    'cabang_pelatih.nama as cp_nama',
                    'cabang_pelatih.foto as cp_foto',
                    'cabang_pelatih.hapus_foto as cp_hapus_foto',
                    'users.nama as user_nama',
                    'users.no_hp as user_no_hp',
                    'users.foto as user_foto',
                    'users.status as user_status',
                    'users.email as user_email',
                    'pelatih.tempat_lahir',
                    'pelatih.tanggal_lahir',
                    'pelatih.no_rek'
                )
                ->get();

            foreach ($rows as $r) {
                $resolvedFoto = $r->cp_foto ?: $r->user_foto;
                if (strtolower($r->user_email ?? '') === 'fajaran16@gmail.com' && empty($resolvedFoto) && $fajarFoto) {
                    $resolvedFoto = $fajarFoto;
                }

                $updateData = [];
                if (empty($r->cp_nama)) {
                    $updateData = [
                        'nama'          => $r->user_nama,
                        'no_hp'         => $r->user_no_hp,
                        'tempat_lahir'  => $r->tempat_lahir,
                        'tanggal_lahir' => $r->tanggal_lahir,
                        'no_rek'        => $r->no_rek,
                        'foto'          => $resolvedFoto,
                        'hapus_foto'    => false,
                        'status'        => $r->user_status ?: 'aktif',
                    ];
                } elseif (empty($r->cp_foto) && !$r->cp_hapus_foto && !empty($resolvedFoto)) {
                    $updateData['foto'] = $resolvedFoto;
                }

                if (!empty($updateData)) {
                    DB::table('cabang_pelatih')->where('id', $r->cp_id)->update($updateData);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cabang_pelatih')) {
            Schema::table('cabang_pelatih', function (Blueprint $table) {
                $cols = ['nama', 'no_hp', 'tempat_lahir', 'tanggal_lahir', 'no_rek', 'foto', 'hapus_foto', 'status'];
                $toDrop = array_filter($cols, fn($col) => Schema::hasColumn('cabang_pelatih', $col));
                if (!empty($toDrop)) {
                    $table->dropColumn($toDrop);
                }
            });
        }

        if (Schema::hasTable('absensi_pelatih') && Schema::hasColumn('absensi_pelatih', 'id_cabang')) {
            Schema::table('absensi_pelatih', function (Blueprint $table) {
                $table->dropColumn('id_cabang');
            });
        }
    }
};

