<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sinkronisasi penugasan cabang pelatih:
     * - Sumedang: seluruh pelatih (termasuk yang belum terdaftar di cabang)
     * - Darmaraja: hanya Syamsul, Deddy, Nugraha, dan Rahesta
     * - Cimanggung: hanya Fajar
     */
    public function up(): void
    {
        if (!Schema::hasTable('cabang_pelatih') || !Schema::hasTable('pelatih') || !Schema::hasTable('users')) {
            return;
        }

        $sumedangId   = $this->resolveCabangId('%sumedang%', 1);
        $darmarajaId  = $this->resolveCabangId('%darmaraja%', 2);
        $cimanggungId = $this->resolveCabangId('%cimanggung%', 3);

        $darmarajaEmails = [
            'nugraharamadhan862@gmail.com',
            'deddyiqbal0212@gmail.com',
            'rahestadhy@gmail.com',
            'anwarsyamsul1104@gmail.com',
        ];
        $darmarajaNamePrefixes = [
            'nugraha ramadhan',
            'deddy iqbal',
            'rahesta ardhya',
            'syamsul anwar',
        ];
        $cimanggungEmails = ['fajaran16@gmail.com'];
        $cimanggungNamePrefixes = ['fajar adhi nugraha'];

        $coaches = DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id')
            ->select(
                'pelatih.id as pelatih_id',
                'pelatih.tempat_lahir',
                'pelatih.tanggal_lahir',
                'pelatih.no_rek',
                'users.nama',
                'users.email',
                'users.no_hp',
                'users.foto',
                'users.status'
            )
            ->orderBy('pelatih.id')
            ->get();

        $darmarajaPelatihIds = [];
        $cimanggungPelatihIds = [];

        foreach ($coaches as $coach) {
            $email = strtolower(trim((string) ($coach->email ?? '')));
            $nama  = strtolower(trim((string) ($coach->nama ?? '')));

            if ($this->matchesCoach($email, $nama, $darmarajaEmails, $darmarajaNamePrefixes)) {
                $darmarajaPelatihIds[] = $coach->pelatih_id;
            }
            if ($this->matchesCoach($email, $nama, $cimanggungEmails, $cimanggungNamePrefixes)) {
                $cimanggungPelatihIds[] = $coach->pelatih_id;
            }
        }

        // Pastikan Darmaraja hanya berisi Syamsul, Deddy, Nugraha, dan Rahesta
        $darmarajaDeleteQuery = DB::table('cabang_pelatih')->where('id_cabang', $darmarajaId);
        if (!empty($darmarajaPelatihIds)) {
            $darmarajaDeleteQuery->whereNotIn('id_pelatih', $darmarajaPelatihIds);
        }
        $darmarajaDeleteQuery->delete();

        // Pastikan Cimanggung hanya berisi Fajar
        $cimanggungDeleteQuery = DB::table('cabang_pelatih')->where('id_cabang', $cimanggungId);
        if (!empty($cimanggungPelatihIds)) {
            $cimanggungDeleteQuery->whereNotIn('id_pelatih', $cimanggungPelatihIds);
        }
        $cimanggungDeleteQuery->delete();

        $hasProfileColumns = Schema::hasColumn('cabang_pelatih', 'nama');

        foreach ($coaches as $coach) {
            $this->upsertAssignment($coach->pelatih_id, $sumedangId, $coach, $hasProfileColumns);

            if (in_array($coach->pelatih_id, $darmarajaPelatihIds, true)) {
                $this->upsertAssignment($coach->pelatih_id, $darmarajaId, $coach, $hasProfileColumns);
            }

            if (in_array($coach->pelatih_id, $cimanggungPelatihIds, true)) {
                $this->upsertAssignment($coach->pelatih_id, $cimanggungId, $coach, $hasProfileColumns);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pembagian penugasan cabang tidak dikembalikan secara otomatis.
    }

    private function resolveCabangId(string $pattern, int $fallback): int
    {
        if (!Schema::hasTable('cabang')) {
            return $fallback;
        }

        $id = DB::table('cabang')
            ->whereRaw('LOWER(nama) LIKE ?', [$pattern])
            ->value('id');

        return $id ? (int) $id : $fallback;
    }

    private function matchesCoach(string $email, string $nama, array $emails, array $namePrefixes): bool
    {
        if ($email !== '' && in_array($email, $emails, true)) {
            return true;
        }

        foreach ($namePrefixes as $prefix) {
            if ($nama !== '' && str_starts_with($nama, $prefix)) {
                return true;
            }
        }

        return false;
    }

    private function upsertAssignment(int $pelatihId, int $cabangId, object $coach, bool $hasProfileColumns): void
    {
        $resolvedFoto = $coach->foto;
        if (empty($resolvedFoto) && strtolower(trim((string) ($coach->email ?? ''))) === 'fajaran16@gmail.com' && file_exists(public_path('images/fajar.png'))) {
            $resolvedFoto = 'images/fajar.png';
        }

        $profileData = $hasProfileColumns ? [
            'nama'          => $coach->nama,
            'no_hp'         => $coach->no_hp,
            'tempat_lahir'  => $coach->tempat_lahir,
            'tanggal_lahir' => $coach->tanggal_lahir,
            'no_rek'        => $coach->no_rek,
            'foto'          => $resolvedFoto,
            'hapus_foto'    => false,
            'status'        => $coach->status ?: 'aktif',
        ] : [];

        $existing = DB::table('cabang_pelatih')
            ->where('id_pelatih', $pelatihId)
            ->where('id_cabang', $cabangId)
            ->first();

        if (!$existing) {
            DB::table('cabang_pelatih')->insert(array_merge([
                'id_pelatih' => $pelatihId,
                'id_cabang'  => $cabangId,
            ], $profileData));

            return;
        }

        if ($hasProfileColumns && empty($existing->nama)) {
            DB::table('cabang_pelatih')
                ->where('id', $existing->id)
                ->update($profileData);
        } elseif ($hasProfileColumns && Schema::hasColumn('cabang_pelatih', 'foto') && empty($existing->foto) && empty($existing->hapus_foto) && !empty($resolvedFoto)) {
            DB::table('cabang_pelatih')
                ->where('id', $existing->id)
                ->update(['foto' => $resolvedFoto]);
        }
    }
};
