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
        if (!Schema::hasTable('best_swimmer')) {
            Schema::create('best_swimmer', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_siswa');
                $table->unsignedBigInteger('id_cabang');
                $table->integer('bulan');
                $table->integer('tahun');
                $table->unsignedBigInteger('id_admin')->nullable();
                $table->text('catatan')->nullable();
                $table->timestamps();

                $table->unique(['id_cabang', 'tahun', 'bulan']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('best_swimmer');
    }
};

