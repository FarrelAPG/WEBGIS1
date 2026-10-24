<?php

namespace App\Console\Commands;

use App\Models\Kendaraan;
use App\Models\Laporan;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('damkar:reset-demo')]
#[Description('Reset status laporan kebakaran dan kendaraan armada untuk keperluan review dan demo')]
class ResetDemoReports extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // 1. Kembalikan semua armada ke status siaga
        Kendaraan::query()->update(['status' => 'siaga']);

        // 2. Reset laporan yang ada kembali ke status pending
        Laporan::query()->update([
            'status' => 'pending',
            'kendaraan_id' => null,
            'tanggal_penanganan' => null,
            'wilayah' => null,
            'jam_terima' => null,
            'tiba_tkp' => null,
            'selesai_pukul' => null,
            'dugaan_penyebab' => null,
            'kronologi_kejadian' => null,
            'korban_jiwa' => 0,
            'korban_luka' => 0,
            'catatan_medis' => null,
            'hasil_dibuat_pada' => null,
        ]);

        $this->info('✓ Semua kendaraan dikembalikan ke status siaga.');
        $this->info('✓ Laporan kebakaran berhasil di-reset kembali ke status pending (menunggu penugasan).');
        $this->info('Silakan refresh halaman dashboard untuk me-review kembali!');

        return Command::SUCCESS;
    }
}
