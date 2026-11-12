<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftarBaruAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $namaSiswa = $this->data['nama_siswa'] ?? 'Siswa Baru';
        return $this->subject("Pendaftar Baru: {$namaSiswa} - Gajah Depa Akuatik")
                    ->view('emails.pendaftar_baru_admin')
                    ->with('data', $this->data);
    }
}

