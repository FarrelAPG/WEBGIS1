<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->foreignId('pos_damkar_id')->nullable()->after('nama')->constrained('pos_damkars')->nullOnDelete();
            $table->string('jenis')->nullable()->after('pos_damkar_id');       // Fire Truck / Fire Tanker / Quick Response
            $table->string('spesifikasi')->nullable()->after('jenis');          // Hino 500, Hino Dutro, ...
            $table->string('ukuran')->nullable()->after('spesifikasi');         // Besar / Kecil
        });
    }

    public function down(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pos_damkar_id');
            $table->dropColumn(['jenis', 'spesifikasi', 'ukuran']);
        });
    }
};
