<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard AJAX / Data Endpoints
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/map-data', [DashboardController::class, 'mapData'])->name('mapData');
        Route::get('/get-kabupaten', [DashboardController::class, 'getKabupaten'])->name('getKabupaten');
        Route::get('/rekap-table', [DashboardController::class, 'filterTable'])->name('filterTable');
    });

    //// day 3 progress User Controller
    // user management hanya bisa diakses oleh super admin
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    //// day 5 progress, route komoditas dinamis
    Route::get('/komoditas/{komoditas}', [KomoditasController::class, 'show'])
        ->name('komoditas.show');

    //// day 5 progress, route untuk menampilkan halaman data management, hanya bisa diakses oleh super admin dan admin direktorat
    Route::middleware('role:Super Admin,Admin Direktorat')->group(function () {
        Route::get('/data-management', function () {
            return view('datamanagement.data-management');
        })->name('data-management');
    });

    //// day 5 progress, route untuk menampilkan halaman rekap data wilayah
    Route::get('/rekap-data', [RekapDataController::class, 'index'])
        ->name('rekap-data');

    Route::get('/rekap-data/get-kabupaten', [RekapDataController::class, 'getKabupaten'])
        ->name('rekap-data.getKabupaten');

});

require __DIR__.'/auth.php';