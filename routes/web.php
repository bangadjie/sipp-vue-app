<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermohonanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/HomeUser', function () {
//     return Inertia::render('Home_User');
// })->middleware(['auth', 'verified'])->name('HomeUser');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ROUTE SUPER ADMININ


// Route::middleware('grup:admin')->group(function () {
//     Route::get('/management_user', function () {
//         return Inertia::render('Management_user');
//     })->name('management_user');

//     Route::get('/management_grup', function () {
//         return Inertia::render('Management_grup');
//     })->name('management_grup');
// });

// Route::middleware('grup:admin_pdo')->group(function () {
//     Route::get('/permohonan', function () {
//         return Inertia::render('Permohonan');
//     })->name('permohonan');

//     Route::get('/detail_permohonan', function () {
//         return Inertia::render('Detail_Permohonan');
//     })->name('detail_permohonan');
// });

// require __DIR__.'/auth.php';


Route::get('/management_user', function () {
    return Inertia::render('Admin/ManagementUser');
})->middleware(['auth', 'verified'])->name('management_user');

Route::get('/management_grup', function () {
    return Inertia::render('Admin/ManagementGrup');
})->middleware(['auth', 'verified'])->name('management_grup');

Route::get('/management_instansi', function () {
    return Inertia::render('Admin/ManagementInstansi');
})->middleware(['auth', 'verified'])->name('management_instansi');

Route::get('/Permohonan', function () {
    return Inertia::render('Admin/Permohonan');
})->middleware(['auth', 'verified'])->name('Permohonan');

Route::get('/permohonan', function () {
    return Inertia::render('AdminOpd/Permohonan');
})->middleware(['auth', 'verified'])->name('permohonan');

Route::get('/detail_permohonan', function () {
    return Inertia::render('AdminOpd/DetailPermohonan');
})->middleware(['auth', 'verified'])->name('detail_permohonan');


// Route::get('/permohonans', [PermohonanController::class, 'index'])->name('permohonans.index');
require __DIR__ . '/auth.php';
