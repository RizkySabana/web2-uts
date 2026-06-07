<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiAjaxController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── BUKU ──────────────────────────────────────────────
    // Semua bisa lihat
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create')->middleware('admin');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store')->middleware('admin');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit')->middleware('admin');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update')->middleware('admin');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy')->middleware('admin');

    // ── ANGGOTA ───────────────────────────────────────────
    // Hanya admin bisa kelola anggota
    Route::resource('anggota', AnggotaController::class)->middleware('admin');

    // ── TRANSAKSI ─────────────────────────────────────────
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    // Kembalikan hanya admin
    Route::patch('/transaksi/{transaksi}/kembali', [TransaksiController::class, 'kembali'])
        ->name('transaksi.kembali')->middleware('admin');
    // Hapus hanya admin
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])
        ->name('transaksi.destroy')->middleware('admin');

    // ── LAPORAN (hanya admin) ─────────────────────────────
    Route::prefix('laporan')->name('laporan.')->middleware('admin')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/pdf', [LaporanController::class, 'pdf'])->name('pdf');
        Route::get('/excel', [LaporanController::class, 'excel'])->name('excel');
    });

    // ── AJAX ──────────────────────────────────────────────
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::get('/transaksi', [TransaksiAjaxController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/data', [TransaksiAjaxController::class, 'data'])->name('transaksi.data');
        Route::get('/transaksi/{transaksi}/detail', [TransaksiAjaxController::class, 'detail'])->name('transaksi.detail');
        Route::patch('/transaksi/{transaksi}/kembali', [TransaksiAjaxController::class, 'kembali'])
            ->name('transaksi.kembali')->middleware('admin');
        Route::delete('/transaksi/{transaksi}', [TransaksiAjaxController::class, 'destroy'])
            ->name('transaksi.destroy')->middleware('admin');
    });

    // Storage file
    Route::get('/storage-file/{path}', function ($path) {
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath))
            abort(404);
        return response()->file($fullPath);
    })->where('path', '.*')->name('storage.file');

});