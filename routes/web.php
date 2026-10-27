<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Damkar\DashboardController;
use App\Http\Controllers\Damkar\KendaraanController;
use App\Http\Controllers\Damkar\LaporanController as DamkarLaporanController;
use App\Http\Controllers\Damkar\PosDamkarController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasyarakatProfileController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman utama langsung diarahkan ke Beranda Masyarakat
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/portal', fn () => redirect()->route('beranda'))->name('portal');

// Halaman antarmuka Masyarakat (Publik)
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/peta', [PetaController::class, 'publik'])->name('peta');
Route::get('/lapor', [LaporanController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
Route::get('/lapor/sukses/{id}', [LaporanController::class, 'sukses'])->name('lapor.sukses');
Route::get('/laporan-saya', [LaporanController::class, 'index'])->name('laporan.saya');
Route::get('/laporan/{laporan}/lacak', [LaporanController::class, 'lacak'])->name('laporan.lacak');

// Halaman profil publik Masyarakat (tanpa middleware auth / tanpa login)
Route::get('/masyarakat/profile', [MasyarakatProfileController::class, 'index'])->name('masyarakat.profile');

// Halaman edukasi & antisipasi kebakaran publik (tanpa middleware auth)
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/metode-tata', [EdukasiController::class, 'tata'])->name('edukasi.tata');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel admin damkar (gate 'damkar' mencegah akses user masyarakat)
Route::prefix('damkar')->name('damkar.')->middleware(['auth', 'can:damkar'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cek-laporan', [DashboardController::class, 'cek'])->name('cek-laporan');
    Route::post('/reset-demo', [DashboardController::class, 'resetDemo'])->name('reset-demo');
    Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan');
    Route::get('/pos-damkar', [PosDamkarController::class, 'index'])->name('pos-damkar');
    Route::get('/peta', [PetaController::class, 'index'])->name('peta');
    Route::get('/peta/isokron/{posDamkar}', [PetaController::class, 'isokron'])->name('peta.isokron');
    Route::get('/peta/sumber-air', [PetaController::class, 'sumberAir'])->name('peta.sumber-air');
    Route::get('/peta/rawan-bencana', [PetaController::class, 'rawanBencana'])->name('peta.rawan-bencana');
    Route::get('/laporan', [DamkarLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/berita', [DamkarLaporanController::class, 'berita'])->name('laporan.berita');
    Route::get('/laporan/{laporan}', [DamkarLaporanController::class, 'show'])->name('laporan.show')->missing(fn () => redirect()->route('damkar.dashboard')->with('error', 'Laporan tidak ditemukan.'));
    Route::get('/laporan/{laporan}/foto', [DamkarLaporanController::class, 'foto'])->name('laporan.foto');
    Route::get('/laporan/{laporan}/penugasan-kendaraan', [DamkarLaporanController::class, 'penugasanKendaraan'])->name('laporan.penugasan-kendaraan')->missing(fn () => redirect()->route('damkar.dashboard')->with('error', 'Laporan tidak ditemukan.'));
    Route::patch('/laporan/{laporan}/penugasan-kendaraan', [DamkarLaporanController::class, 'storePenugasanKendaraan'])->name('laporan.store-penugasan-kendaraan');
    Route::get('/laporan/{laporan}/navigasi-rute', [DamkarLaporanController::class, 'navigasiRute'])->name('laporan.navigasi-rute')->missing(fn () => redirect()->route('damkar.dashboard')->with('error', 'Laporan tidak ditemukan.'));
    Route::get('/laporan/{laporan}/penanganan-tkp', [DamkarLaporanController::class, 'penangananTkp'])->name('laporan.penanganan-tkp')->missing(fn () => redirect()->route('damkar.dashboard')->with('error', 'Laporan tidak ditemukan.'));
    Route::match(['get', 'post', 'patch'], '/laporan/{laporan}/selesai', [DamkarLaporanController::class, 'selesai'])->name('laporan.selesai')->missing(fn () => redirect()->route('damkar.dashboard')->with('error', 'Laporan tidak ditemukan di database server. Silakan buat atau pilih laporan baru dari dashboard.'));
    Route::get('/laporan/{laporan}/hasil', [DamkarLaporanController::class, 'hasil'])->name('laporan.hasil')->missing(fn () => redirect()->route('damkar.dashboard')->with('error', 'Laporan tidak ditemukan.'));
    Route::patch('/laporan/{laporan}/hasil', [DamkarLaporanController::class, 'simpanHasil'])->name('laporan.simpan-hasil');
    Route::patch('/laporan/{laporan}/kendaraan', [DamkarLaporanController::class, 'assignKendaraan'])->name('laporan.kendaraan');
    Route::patch('/laporan/{laporan}/tolak', [DamkarLaporanController::class, 'tolak'])->name('laporan.tolak');
    Route::patch('/laporan/{laporan}/status', [DamkarLaporanController::class, 'updateStatus'])->name('laporan.status');
});

require __DIR__.'/auth.php';
