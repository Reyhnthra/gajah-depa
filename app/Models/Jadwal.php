<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // 1. Kasih tahu Laravel kalau nama tabelnya di HeidiSQL adalah 'jadwal'
    protected $table = 'jadwal';

    // 2. Relasi balik: Setiap jadwal dimiliki oleh 1 Cabang (Belongs To)
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}