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
            $table->date('tanggal_penanganan')->nullable()->after('status');
            $table->string('wilayah')->nullable()->after('tanggal_penanganan');
            $table->string('jam_terima')->nullable()->after('wilayah');
            $table->string('tiba_tkp')->nullable()->after('jam_terima');
            $table->string('selesai_pukul')->nullable()->after('tiba_tkp');
            $table->string('dugaan_penyebab')->nullable()->after('selesai_pukul');
            $table->text('kronologi_kejadian')->nullable()->after('dugaan_penyebab');
            $table->integer('korban_jiwa')->default(0)->after('kronologi_kejadian');
            $table->integer('korban_luka')->default(0)->after('korban_jiwa');
            $table->text('catatan_medis')->nullable()->after('korban_luka');
            $table->timestamp('hasil_dibuat_pada')->nullable()->after('catatan_medis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_penanganan',
                'wilayah',
                'jam_terima',
                'tiba_tkp',
                'selesai_pukul',
                'dugaan_penyebab',
                'kronologi_kejadian',
                'korban_jiwa',
                'korban_luka',
                'catatan_medis',
                'hasil_dibuat_pada',
            ]);
        });
    }
};
