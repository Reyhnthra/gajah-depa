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
        Schema::create('pencapaian_siswa', function (Blueprint $table) {
            $table->id(); 
            
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->string('gaya_renang'); 
            $table->string('catatan_waktu', 20)->nullable(); 
            
            $table->unsignedTinyInteger('teknik');    
            $table->unsignedTinyInteger('kecepatan'); 
            $table->unsignedTinyInteger('ketahanan'); 
            
            $table->text('catatan')->nullable(); 
            $table->string('kejuaraan')->nullable(); 
            
            $table->timestamp('tanggal_catat')->useCurrent(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencapaian_siswa');
    }
};