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
        Schema::create('zona_rawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ciri')->nullable(); // Contoh: kawasan niaga, gang sempit
            $table->double('latitude');
            $table->double('longitude');
            $table->unsignedInteger('radius_m'); // Radius zona dalam meter
            $table->unsignedInteger('jumlah_kejadian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_rawans');
    }
};
