<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NjopController;
use App\Http\Controllers\NpoptkpController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/', [PermohonanController::class, 'index'])->name('index');
        Route::get('/create', [PermohonanController::class, 'create'])->name('create');
        Route::post('/', [PermohonanController::class, 'store'])->name('store');
        Route::get('/{permohonan}/edit', [PermohonanController::class, 'edit'])->name('edit');
        Route::put('/{permohonan}', [PermohonanController::class, 'update'])->name('update');
        Route::get('/{permohonan}', [PermohonanController::class, 'show'])->name('show');
        Route::delete('/{permohonan}', [PermohonanController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('role:admin')->group(function () {
        Route::prefix('njop')->name('njop.')->group(function () {
            Route::get('/', [NjopController::class, 'index'])->name('index');
            Route::post('/', [NjopController::class, 'store'])->name('store');
            Route::put('/{njop}', [NjopController::class, 'update'])->name('update');
            Route::delete('/{njop}', [NjopController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
            Route::get('/verifikasi/{permohonan}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
            Route::post('/verifikasi/{permohonan}', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        });

        Route::prefix('npoptkp')->name('npoptkp.')->group(function () {
            Route::get('/', [NpoptkpController::class, 'index'])->name('index');
            Route::post('/', [NpoptkpController::class, 'store'])->name('store');
            Route::put('/{npoptkp}', [NpoptkpController::class, 'update'])->name('update');
            Route::delete('/{npoptkp}', [NpoptkpController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::post('/', [PembayaranController::class, 'store'])->name('store');
        Route::get('/{permohonan}/download', [PembayaranController::class, 'downloadSspd'])->name('download');
    });

    Route::middleware('role:admin,ppat')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Address API
Route::prefix('api/address')->group(function () {
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities', [AddressController::class, 'getCities']);
    Route::get('/districts', [AddressController::class, 'getDistricts']);
    Route::get('/villages', [AddressController::class, 'getVillages']);
});

Route::get('/api/calculate', [CalculationController::class, 'calculate']);

require __DIR__.'/auth.php';
