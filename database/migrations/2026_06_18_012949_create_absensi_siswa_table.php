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
        Schema::create('absensi_siswa', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->date('tanggal_kehadiran'); 
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'tidak_hadir'])->default('hadir'); 
            $table->string('keterangan')->nullable();
            
            // Foreign Keys
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_jadwal')->nullable()->constrained('jadwal')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_siswa');
    }
};