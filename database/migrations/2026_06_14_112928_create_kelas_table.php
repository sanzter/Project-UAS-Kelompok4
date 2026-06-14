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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas'); // Contoh: X IPA 1, XI IPS 2
            // Menghubungkan ke tabel users (ID Guru)
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('mata_pelajaran')->nullable(); // Jika ingin spesifik guru tersebut mengajar mapel apa di kelas itu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
