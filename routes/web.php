<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//// day 2 progress
use illuminate\Support\Facades\Auth;

Route::get('/tes-role', function () {
    dd(Auth::user());
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
require __DIR__.'/auth.php';
