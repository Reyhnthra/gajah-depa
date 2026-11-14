<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan penugasan pelatih Fajar Adhi Nugraha ke cabang Cimanggung
     * beserta profil cabang terisolasinya.
     */
    public function up(): void
    {
        if (!Schema::hasTable('cabang_pelatih') || !Schema::hasTable('pelatih') || !Schema::hasTable('users')) {
            return;
        }

        $fajar = $this->findFajar();
        $cimanggungId = $this->findCimanggungId();

        if (!$fajar || !$cimanggungId) {
            return;
        }

        $resolvedFoto = $fajar->foto;
        if (empty($resolvedFoto) && file_exists(public_path('images/fajar.png'))) {
            $resolvedFoto = 'images/fajar.png';
        }

        $profileData = Schema::hasColumn('cabang_pelatih', 'nama') ? [
            'nama'          => $fajar->nama,
            'no_hp'         => $fajar->no_hp,
            'tempat_lahir'  => $fajar->tempat_lahir,
            'tanggal_lahir' => $fajar->tanggal_lahir,
            'no_rek'        => $fajar->no_rek,
            'foto'          => $resolvedFoto,
            'hapus_foto'    => false,
            'status'        => $fajar->status ?: 'aktif',
        ] : [];

        $existing = DB::table('cabang_pelatih')
            ->where('id_pelatih', $fajar->pelatih_id)
            ->where('id_cabang', $cimanggungId)
            ->first();

        if (!$existing) {
            DB::table('cabang_pelatih')->insert(array_merge([
                'id_pelatih' => $fajar->pelatih_id,
                'id_cabang'  => $cimanggungId,
            ], $profileData));

            return;
        }

        if (!empty($profileData) && empty($existing->nama)) {
            DB::table('cabang_pelatih')
                ->where('id', $existing->id)
                ->update($profileData);
        } elseif (Schema::hasColumn('cabang_pelatih', 'foto') && empty($existing->foto) && empty($existing->hapus_foto) && !empty($resolvedFoto)) {
            DB::table('cabang_pelatih')
                ->where('id', $existing->id)
                ->update(['foto' => $resolvedFoto]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('cabang_pelatih') || !Schema::hasTable('pelatih') || !Schema::hasTable('users')) {
            return;
        }

        $fajar = $this->findFajar();
        $cimanggungId = $this->findCimanggungId();

        if (!$fajar || !$cimanggungId) {
            return;
        }

        DB::table('cabang_pelatih')
            ->where('id_pelatih', $fajar->pelatih_id)
            ->where('id_cabang', $cimanggungId)
            ->delete();
    }

    private function findFajar(): ?object
    {
        return DB::table('pelatih')
            ->join('users', 'pelatih.id_user', '=', 'users.id')
            ->where(function ($q) {
                $q->whereRaw('LOWER(users.email) = ?', ['fajaran16@gmail.com'])
                  ->orWhere('users.nama', 'like', 'Fajar Adhi Nugraha%');
            })
            ->select(
                'pelatih.id as pelatih_id',
                'pelatih.tempat_lahir',
                'pelatih.tanggal_lahir',
                'pelatih.no_rek',
                'users.nama',
                'users.no_hp',
                'users.foto',
                'users.status'
            )
            ->first();
    }

    private function findCimanggungId(): ?int
    {
        if (!Schema::hasTable('cabang')) {
            return null;
        }

        $id = DB::table('cabang')
            ->whereRaw('LOWER(nama) LIKE ?', ['%cimanggung%'])
            ->value('id');

        return $id ? (int) $id : null;
    }
};
