<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//// day 2 progress
use Illuminate\Support\Facades\Auth;
//// day 3 progress User Controller
use App\Http\Controllers\UserController;
use Illuminate\Support\Str;

use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\RekapDataController;


Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');

Route::get('/dashboard/map-data', [DashboardController::class, 'mapData'])
    ->name('dashboard.mapData');
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//// day 2 progress ( cek jika user sudah login dan memiliki direktorat )
Route::middleware('auth')->get('/tes-direktorat', function () {
    dd(Auth::User()->direktorat);

});

Route::middleware('auth')->get('/tes-role', function () {
    dd(Auth::User()->role);

});


Route::middleware('auth')->get('/tes-helper', function () {

    dd(auth()->user()->isSuperAdmin());


});


// day 3 progress
// route untuk testing middleware role super admin

Route::middleware(['auth', 'role:Super Admin'])
    ->get('/tes-superadmin', function () {
        return 'halo super admin';
    });

        // management data hanya bisa diakses oleh super admin dan admin direktorat
Route::middleware(['auth', 'role:Super Admin,Admin Direktorat'])
    ->get('/management-data', function () {
        return "Halaman Management Data";
    });
        // user management hanya bisa diakses oleh super admin
Route::middleware(['auth','role:Super Admin'])
    ->resource('users', UserController::class);

Route::middleware('auth')->get('/cek-role', function () {

    dd(
        auth()->user()->role_id,
        auth()->user()->role,
        auth()->user()->role->name
    );

});

// day 5 progress, route untuk menampilkan bawang merah, bawang putih, cabai, durian, dan p2b

// day 5 progress, route komoditas dinamis

Route::get('/komoditas/{komoditas}', [KomoditasController::class, 'show'])
    ->name('komoditas.show');

Route::get('/dashboard/get-kabupaten', [DashboardController::class, 'getKabupaten'])
    ->name('dashboard.getKabupaten');

Route::get('/dashboard/map-data', [DashboardController::class, 'mapData'])
    ->name('dashboard.mapData');

Route::get('/dashboard/kabupaten', [DashboardController::class, 'getKabupaten'])
    ->name('dashboard.kabupaten');

Route::get('/dashboard/kabupaten',
    [DashboardController::class,'getKabupaten']);

Route::get('/dashboard/rekap-table',
    [DashboardController::class,'filterTable']);
    
//day 5 progress, route untuk menampilkan halaman data management, hanya bisa diakses oleh super admin dan admin direktorat
Route::middleware(['auth', 'role:Super Admin,Admin Direktorat'])
    ->get('/data-management', function () {
        return view('datamanagement.data-management');
})->name('data-management');


//day 5 progress, route untuk menampilkan halaman rekap data wilayah
Route::middleware('auth')
    ->get('/rekap-data', [RekapDataController::class, 'index'])
    ->name('rekap-data');

Route::middleware('auth')
    ->get('/rekap-data/get-kabupaten', [RekapDataController::class, 'getKabupaten'])
    ->name('rekap-data.getKabupaten');

Route::middleware('auth')->get('/debug-user', function () {
    return [
        'role_id' => auth()->user()->role_id,
        'nama_role' => auth()->user()->role->name,
        'isSuperAdmin' => auth()->user()->isSuperAdmin(),
        'isAdminDirektorat' => auth()->user()->isAdminDirektorat(),
    ];
});

require __DIR__.'/auth.php';

