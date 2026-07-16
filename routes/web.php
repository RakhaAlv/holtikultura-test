<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//// day 2 progress
use Illuminate\Support\Facades\Auth;
//// day 3 progress User Controller
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

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
        auth()->user()->role->nama_role
    );

});

require __DIR__.'/auth.php';
