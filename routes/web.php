<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ManagementTargetController;
use App\Http\Controllers\ManagementRealisasiController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/map-data', [DashboardController::class, 'mapData'])
            ->name('mapData');

        Route::get('/get-kabupaten', [DashboardController::class, 'getKabupaten'])
            ->name('getKabupaten');

        Route::get('/rekap-table', [DashboardController::class, 'filterTable'])
            ->name('filterTable');

        // compatibility route lama
        Route::get('/kabupaten', [DashboardController::class, 'getKabupaten'])
            ->name('kabupaten');

    });

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    Route::get('/tes-direktorat', function () {
        dd(Auth::user()->direktorat);
    });

    Route::get('/tes-role', function () {
        dd(Auth::user()->role);
    });

    Route::get('/tes-helper', function () {
        dd(auth()->user()->isSuperAdmin());
    });

    Route::get('/cek-role', function () {

        dd(
            auth()->user()->role_id,
            auth()->user()->role,
            auth()->user()->role->name
        );

    });

    Route::get('/debug-user', function () {

        return [
            'role_id'            => auth()->user()->role_id,
            'nama_role'          => auth()->user()->role->name,
            'isSuperAdmin'       => auth()->user()->isSuperAdmin(),
            'isAdminDirektorat'  => auth()->user()->isAdminDirektorat(),
        ];

    });

    /*
    |--------------------------------------------------------------------------
    | Komoditas
    |--------------------------------------------------------------------------
    */

    Route::get('/komoditas/{komoditas}', [KomoditasController::class, 'show'])
        ->name('komoditas.show');

    /*
    |--------------------------------------------------------------------------
    | Rekap Data
    |--------------------------------------------------------------------------
    */

    Route::get('/rekap-data', [RekapDataController::class, 'index'])
        ->name('rekap-data');

    Route::get('/rekap-data/get-kabupaten', [RekapDataController::class, 'getKabupaten'])
        ->name('rekap-data.getKabupaten');

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Super Admin')
        ->resource('users', UserController::class);

    Route::middleware('role:Super Admin')
        ->get('/tes-superadmin', function () {
            return 'halo super admin';
        });

    /*
    |--------------------------------------------------------------------------
    | Management Data
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Super Admin,Admin Direktorat')
        ->get('/data-management', [ManagementController::class, 'index'])
        ->name('data-management');

    Route::middleware('role:Super Admin,Admin Direktorat')
        ->prefix('data-management')
        ->group(function () {

            /*
            |--------------------------
            | Target
            |--------------------------
            */

            Route::get('/target', [ManagementTargetController::class, 'table'])
                ->name('management.target');

            Route::post('/target', [ManagementTargetController::class, 'store'])
                ->name('management.target.store');

            Route::get('/target/{target}', [ManagementTargetController::class, 'show'])
            ->name('management.target.show');

            Route::put('/target/{target}', [ManagementTargetController::class, 'update'])
                ->name('management.target.update');

            Route::delete('/target/{target}', [ManagementTargetController::class, 'destroy'])
                ->name('management.target.destroy');

            /*
            |--------------------------
            | Realisasi
            |--------------------------
            */

            Route::get('/realisasi', [ManagementRealisasiController::class, 'table'])
                ->name('management.realisasi');

        });

});

require __DIR__.'/auth.php';