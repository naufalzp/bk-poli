<?php

use App\Http\Controllers\Pasien\DashboardController;
use App\Http\Controllers\Pasien\RiwayatPeriksaController;
use App\Http\Controllers\Pasien\JanjiPeriksaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('pasien.dashboard');

    Route::prefix('janji-periksa')->name('pasien.janji-periksa.')->group(function () {
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('index');
        Route::post('/', [JanjiPeriksaController::class, 'store'])->name('store');
    });
    
    Route::prefix('riwayat-periksa')->name('pasien.riwayat-periksa.')->group(function () {
        Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('index');
        Route::get('/{id}/detail', [RiwayatPeriksaController::class, 'detail'])->name('detail');
        Route::get('/{id}/riwayat', [RiwayatPeriksaController::class, 'riwayat'])->name('riwayat');
    });
});