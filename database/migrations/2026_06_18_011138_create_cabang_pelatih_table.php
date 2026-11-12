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
        Schema::create('cabang_pelatih', function (Blueprint $table) {
            $table->id(); // Primary Key
            
            // Hubungan Relasi 
            $table->foreignId('id_pelatih')->constrained('pelatih')->onDelete('cascade');
            $table->foreignId('id_cabang')->constrained('cabang')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang_pelatih');
    }
};