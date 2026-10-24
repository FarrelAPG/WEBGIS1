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
        Schema::table('laporans', function (Blueprint $table) {
            // Waktu petugas mulai menangani di TKP (tahap "Sedang Ditangani" di sisi masyarakat)
            $table->timestamp('mulai_penanganan_at')->nullable()->after('kendaraan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('mulai_penanganan_at');
        });
    }
};
