<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//// day 2 progress
use Illuminate\Support\Facades\Auth;
//// day 3 progress User Controller
use App\Http\Controllers\UserController;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');
    
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

Route::middleware('auth')->get('/komoditas/{slug}', function ($slug) {

    $komoditas = [

        'bawang-putih' => [

            'nama' => 'Bawang Putih',
            'target' => 5000,
            'realisasi' => 683,

        ],

        'bawang-merah' => [

            'nama' => 'Bawang Merah',
            'target' => 150,
            'realisasi' => 0,

        ],

        'cabai' => [

            'nama' => 'Cabai',
            'target' => 2953,
            'realisasi' => 278,

        ],

        'durian' => [

            'nama' => 'Durian',
            'target' => 2337,
            'realisasi' => 0,

        ],

        'p2b' => [

            'nama' => 'P2B',
            'target' => 411,
            'realisasi' => 156,

        ],

    ];

    abort_unless(isset($komoditas[$slug]), 404);

    $data = $komoditas[$slug];

    $persentase = $data['target'] > 0
        ? round(($data['realisasi'] / $data['target']) * 100, 1)
        : 0;

    return view('komoditas.show', [

        'slug' => $slug,

        'namaKomoditas' => $data['nama'],

        'target' => $data['target'],

        'realisasi' => $data['realisasi'],

        'persentase' => $persentase,

    ]);

})->name('komoditas.show');

//day 5 progress, route untuk menampilkan halaman data management, hanya bisa diakses oleh super admin dan admin direktorat
Route::middleware(['auth', 'role:Super Admin,Admin Direktorat'])
    ->get('/data-management', function () {
        return view('datamanagement.data-management');
})->name('data-management');


//day 5 progress, route untuk menampilkan halaman rekap data wilayah
Route::middleware(['auth'])->get('/rekap-data', function () {
    return view('rekapdata.rekap-data');
})->name('rekap-data');

Route::middleware('auth')->get('/debug-user', function () {
    return [
        'role_id' => auth()->user()->role_id,
        'nama_role' => auth()->user()->role->name,
        'isSuperAdmin' => auth()->user()->isSuperAdmin(),
        'isAdminDirektorat' => auth()->user()->isAdminDirektorat(),
    ];
});

require __DIR__.'/auth.php';

