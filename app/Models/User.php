<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'jenis_kelamin',
        'password',
        'role',
        'foto',
        'status',
        'id_cabang',
        'password_set',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Accessor for name attribute to map to nama column.
     */
    public function getNameAttribute()
    {
        return $this->nama;
    }

    /**
     * Relasi ke Cabang (khusus Admin Cabang)
     */
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    /**
     * Kirim notifikasi reset password dengan template kustom Gajah Depa
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
