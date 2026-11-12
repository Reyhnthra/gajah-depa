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
        Schema::create('cabang', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama'); 
            $table->text('alamat'); 
            $table->string('email')->nullable();
            $table->string('no_whatsapp')->nullable();
            $table->text('info_pendaftaran')->nullable();
            $table->date('tanggal_didirikan')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang');
    }
};