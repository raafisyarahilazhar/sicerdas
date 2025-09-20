<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationTypeController;
use App\Http\Controllers\ApplicationApprovalController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/antrean', [AntreanController::class, 'index'])->name('antrean.index');
Route::post('/antrean/ambil', [AntreanController::class, 'ambil'])->name('antrean.ambil');


/*
|--------------------------------------------------------------------------
| Rute Terotentikasi (Hanya untuk user yang sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Rute Umum untuk Semua Peran (termasuk 'warga') ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Warga bisa membuat, melihat, dan melacak permohonan mereka
    Route::resource('applications', ApplicationController::class);
    Route::get('/applications/{application}/generate-pdf', [ApplicationController::class, 'generatePdf'])->name('applications.generatePdf');
    Route::get('/applications/{application}/download-pdf', [ApplicationController::class, 'downloadPdf'])->name('applications.downloadPdf');
    
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');

    
    // --- Grup Rute Khusus untuk Peran Aparat Desa (RT, RW, Kades, Operator, Admin) ---
    Route::middleware('role:rt,rw,kades,operator,admin')->group(function () {
        
        // Rute-rute Dashboard
        Route::prefix('dashboard')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/data-warga', [DashboardController::class, 'dataWarga'])->name('dashboard-warga');
            Route::get('/data-permohonan', [DashboardController::class, 'dataPermohonan'])->name('dashboard-permohonan');
            Route::get('/data-surat', [DashboardController::class, 'dataSurat'])->name('dashboard-surat');
        });

        // Rute Aksi Persetujuan
        Route::post('applications/{application}/approve', [ApplicationApprovalController::class, 'approve'])->name('applications.approve');
        Route::post('applications/{application}/reject', [ApplicationApprovalController::class, 'reject'])->name('applications.reject');
    });

    // --- Grup Rute Khusus untuk Manajemen (Hanya Admin & Operator) ---
    Route::middleware('role:admin,operator')->group(function() {
        Route::resource('users', UserController::class);
        Route::resource('rts', RtController::class);
        Route::resource('rws', RwController::class);
        Route::resource('application-types', ApplicationTypeController::class);
    });
});


/*
|--------------------------------------------------------------------------
| Rute Otentikasi Bawaan
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';