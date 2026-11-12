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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            
            // Data Lengkap Anak dari Formulir Pendaftaran
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->default('laki-laki');
            $table->string('tingkat_kelas')->default('Pemula A');
            $table->string('foto')->nullable();
            $table->date('tanggal_masuk')->nullable(); 
            $table->string('sekolah')->nullable(); 
            $table->text('riwayat_penyakit')->nullable(); 
            $table->string('catatan_khusus')->nullable(); 
            
            // Kunci Relasi (Foreign Keys)
            $table->foreignId('id_parents')->nullable()->constrained('parents')->onDelete('cascade');
            $table->foreignId('id_kelas')->nullable()->constrained('kelas')->onDelete('set null');
            $table->foreignId('id_cabang')->nullable()->constrained('cabang')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};