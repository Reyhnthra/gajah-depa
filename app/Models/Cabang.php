<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    // 1. Kasih tahu Laravel kalau nama tabelnya di HeidiSQL adalah 'cabang'
    protected $table = 'cabang';

    // 2. Daftarkan relasi: 1 Cabang punya BANYAK Jadwal (Has Many)
    public function jadwals()
    {
        // 'id_cabang' adalah nama kolom Foreign Key yang ada di tabel jadwal kamu
        return $this->hasMany(Jadwal::class, 'id_cabang');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_cabang');
    }
}