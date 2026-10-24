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
        Schema::table('pos_damkars', function (Blueprint $table) {
            $table->string('nama');
            $table->string('unit');
            $table->string('alamat');
            $table->double('latitude');
            $table->double('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_damkars', function (Blueprint $table) {
            $table->dropColumn(['nama', 'unit', 'alamat', 'latitude', 'longitude']);
        });
    }
};
