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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->date('tanggal_transaksi'); 
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran']);
            $table->bigInteger('nominal');
            $table->text('keterangan')->nullable(); 
            $table->enum('status', ['lunas', 'pending', 'batal'])->default('pending'); // Otomatis pending jika tidak diisi
            
            // Foreign Key 
            $table->foreignId('id_cabang')->constrained('cabang')->onDelete('restrict');
            $table->foreignId('id_pelatih')->nullable()->constrained('pelatih')->onDelete('set null');
            $table->foreignId('id_siswa')->nullable()->constrained('siswa')->onDelete('set null');
            
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};