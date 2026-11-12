<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran_baru', function (Blueprint $table) {
            $table->id(); // Primary Key (id_pendaftaran)

            $table->string('nama_siswa');
            $table->date('tanggal_lahir');
            $table->string('sekolah')->nullable(); 
            $table->text('riwayat_penyakit')->nullable(); 
            $table->string('catatan_khusus')->nullable(); 

            $table->string('nama_orang_tua');
            $table->string('no_hp', 15);
            $table->string('email')->unique(); 
            $table->text('alamat')->nullable(); 
            

            $table->string('bukti_pembayaran')->nullable(); 
            
            // 🔗 Foreign Key 
            $table->foreignId('id_kelas')->constrained('kelas')->onDelete('restrict');
            $table->foreignId('id_cabang')->constrained('cabang')->onDelete('restrict');

            $table->enum('status_pendaftaran', ['pending', 'disetujui', 'ditolak'])->default('pending');
            
            // Menggunakan timestamps agar admin tahu kapan orang tua ini melakukan klik kirim daftar
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_baru');
    }
};