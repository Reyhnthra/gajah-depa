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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('hari');
            $table->string('jam');
            
            // Foreign Keys
            $table->foreignId('id_kelas')->constrained('kelas')->onDelete('restrict');
            $table->foreignId('id_cabang')->constrained('cabang')->onDelete('restrict');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};