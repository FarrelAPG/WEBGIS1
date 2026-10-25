<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('laporans', 'device_id')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->string('device_id', 64)->nullable()->index()->after('user_id');
            });
        }

        // Tandai seluruh laporan lama yang belum punya device_id agar tidak memblokir device pengunjung baru
        DB::table('laporans')->whereNull('device_id')->update([
            'device_id' => 'legacy_demo_seed',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('laporans', 'device_id')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->dropIndex(['device_id']);
                $table->dropColumn('device_id');
            });
        }
    }
};
