<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    /** Transisi status yang diizinkan per status saat ini. */
    private const TRANSISI_STATUS = [
        'pending' => ['diproses', 'ditolak'],
        'diproses' => ['selesai', 'ditolak'],
        'selesai' => [],
        'ditolak' => [],
    ];

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'device_id',
        'kendaraan_id',
        'nomor_telepon',
        'latitude',
        'longitude',
        'alamat',
        'foto',
        'keterangan',
        'status',
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
        'mulai_penanganan_at',
        'alasan_penolakan',
        'ditolak_pada',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'tanggal_penanganan' => 'date',
        'hasil_dibuat_pada' => 'datetime',
        'mulai_penanganan_at' => 'datetime',
        'ditolak_pada' => 'datetime',
        'korban_jiwa' => 'integer',
        'korban_luka' => 'integer',
    ];

    /** Pilihan alasan saat petugas menolak laporan. */
    public const ALASAN_PENOLAKAN = [
        'Laporan palsu / iseng',
        'Lokasi tidak ditemukan / tidak sesuai',
        'Laporan ganda (sudah dilaporkan)',
        'Bukan kejadian kebakaran',
        'Lainnya',
    ];

    /** Tahapan yang dilihat masyarakat (urutan = indeks tahap). */
    public const TAHAP_MASYARAKAT = ['Diterima', 'Verifikasi', 'Armada Meluncur', 'Sedang Ditangani', 'Selesai'];

    /**
     * Tahap laporan di sisi masyarakat (indeks TAHAP_MASYARAKAT).
     * "Selesai" baru tampil setelah petugas benar-benar menyimpan laporan hasil;
     * selama laporan akhir belum dibuat, masyarakat tetap melihat "Sedang Ditangani".
     */
    public function tahapMasyarakat(): int
    {
        if ($this->status === 'selesai') {
            return $this->hasil_dibuat_pada ? 4 : 3;
        }

        if ($this->status === 'diproses') {
            return $this->mulai_penanganan_at ? 3 : 2;
        }

        return 0;
    }

    /** Apakah laporan ini masih berjalan bagi masyarakat (belum selesai dengan laporan akhir, belum ditolak). */
    public function masihBerjalanMasyarakat(): bool
    {
        return in_array($this->status, ['pending', 'diproses'], true)
            || ($this->status === 'selesai' && ! $this->hasil_dibuat_pada);
    }

    /** Laporan yang masih berjalan bagi masyarakat (termasuk menunggu laporan akhir petugas). */
    public function scopeAktifMasyarakat($query)
    {
        return $query->where(function ($q) {
            $q->whereIn('status', ['pending', 'diproses'])
                ->orWhere(fn ($x) => $x->where('status', 'selesai')->whereNull('hasil_dibuat_pada'));
        });
    }

    /** Laporan yang sudah tuntas bagi masyarakat (laporan akhir sudah dibuat, atau ditolak/palsu). */
    public function scopeRiwayatMasyarakat($query)
    {
        return $query->where(function ($q) {
            $q->where(fn ($x) => $x->where('status', 'selesai')->whereNotNull('hasil_dibuat_pada'))
                ->orWhereIn('status', ['ditolak', 'palsu']);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    /** Status baru yang boleh dipilih dari status saat ini. @return list<string> */
    public function transisiTersedia(): array
    {
        return self::TRANSISI_STATUS[$this->status] ?? [];
    }

    /** Apakah perubahan ke status tujuan diizinkan. */
    public function bisaDiubahKe(string $status): bool
    {
        return in_array($status, $this->transisiTersedia(), true);
    }
}
