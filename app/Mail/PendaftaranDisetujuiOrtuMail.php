<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftaranDisetujuiOrtuMail extends Mailable
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
        $namaSiswa = $this->data['nama_siswa'] ?? 'Siswa';
        return $this->subject("Selamat! Pendaftaran {$namaSiswa} Telah Disetujui - Gajah Depa Akuatik")
                    ->view('emails.pendaftaran_disetujui_ortu')
                    ->with('data', $this->data);
    }
}

