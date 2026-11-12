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
        Schema::create('ulasan_club', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->enum('kategori', ['fasilitas', 'manajemen', 'program', 'harga', 'umum']);
            $table->tinyInteger('bintang_rating'); 
            $table->text('komentar_rating')->nullable();
            
            // Foreign Keys
            $table->foreignId('id_cabang')->constrained('cabang')->onDelete('cascade');
            $table->foreignId('id_parents')->constrained('parents')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan_club');
    }
};