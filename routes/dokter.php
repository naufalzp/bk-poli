<?php

use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\JanjiPeriksaController;
use App\Http\Controllers\Dokter\ObatController;
use App\Http\Controllers\Dokter\RiwayatPeriksaController;
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
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');        Route::get('/deleted', [ObatController::class, 'deleted'])->name('deleted');
        Route::post('/{id}/restore', [ObatController::class, 'restore'])->name('restore');
        Route::post('/restore-all', [ObatController::class, 'restoreAll'])->name('restoreAll');
        Route::delete('/{id}/force-delete', [ObatController::class, 'forceDelete'])->name('forceDelete');
        Route::delete('/force-delete-all', [ObatController::class, 'forceDeleteAll'])->name('forceDeleteAll');
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

    Route::prefix('janji-periksa')->name('dokter.janji-periksa.')->group(function () {
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('index');
        Route::get('/{id}/periksa', [JanjiPeriksaController::class, 'show'])->name('show');
        Route::post('/{id}/periksa', [JanjiPeriksaController::class, 'store'])->name('store');
    });
    
    Route::prefix('riwayat-periksa')->name('dokter.riwayat-periksa.')->group(function () {
        Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [RiwayatPeriksaController::class, 'edit'])->name('edit');
        Route::put('/{id}/edit', [RiwayatPeriksaController::class, 'update'])->name('update');
    });

});