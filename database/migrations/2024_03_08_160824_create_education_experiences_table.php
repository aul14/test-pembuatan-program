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
        Schema::create('education_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained('experiences')->cascadeOnDelete();
            $table->string('nama_sekolah');
            $table->string('jurusan', 100);
            $table->year('tahun_masuk');
            $table->year('tahun_lulus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_experiences');
    }
};
