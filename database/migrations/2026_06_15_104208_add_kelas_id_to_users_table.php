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
    Schema::table('users', function (Blueprint $table) {
        // Menambahkan kelas_id, boleh kosong (nullable) karena Admin/Guru tidak butuh kelas
        $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['kelas_id']);
        $table->dropColumn('kelas_id');
    });
}
};