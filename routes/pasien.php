<?php

use App\Http\Controllers\Pasien\JanjiPeriksaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::prefix('janji-periksa')->name('pasien.janji-periksa.')->group(function () {
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('index');
        Route::post('/', [JanjiPeriksaController::class, 'store'])->name('store');
    });
});