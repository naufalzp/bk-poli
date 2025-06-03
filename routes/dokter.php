<?php

use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\ObatController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    // Obat routes
    Route::prefix('obat')->name('dokter.obat.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/create', [ObatController::class, 'create'])->name('create');
        Route::post('/', [ObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jadwal-periksa')->name('dokter.jadwal-periksa.')->group(function () {
        Route::get('/', [JadwalPeriksaController::class, 'index'])->name('index');
        Route::get('/create', [JadwalPeriksaController::class, 'create'])->name('create');
        Route::post('/', [JadwalPeriksaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JadwalPeriksaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JadwalPeriksaController::class, 'update'])->name('update');
        Route::patch('/{id}', [JadwalPeriksaController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [JadwalPeriksaController::class, 'destroy'])->name('destroy');
    });
});