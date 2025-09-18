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
| Public Routes (Breeze Default)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard default Breeze → bisa kamu ganti dengan DashboardController kalau mau
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:rt,rw,kades,operator,admin'])->group(function () {

    // Profile bawaan Breeze (user edit profil sendiri)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard utama → redirect sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data-warga', [DashboardController::class, 'dataWarga'])->name('dashboard-warga');
    Route::get('/dashboard/data-permohonan', [DashboardController::class, 'dataPermohonan'])->name('dashboard-permohonan');
    Route::get('/dashboard/data-surat', [DashboardController::class, 'dataSurat'])->name('dashboard-surat');

    // Approval surat (RT → RW → Kades)
    Route::post('applications/{application}/approve', [ApplicationApprovalController::class, 'approve'])
        ->middleware(['auth', 'verified'])
        ->name('applications.approve');
        
    // Reject surat
    Route::post('applications/{application}/reject', [ApplicationApprovalController::class, 'reject'])
        ->middleware(['auth', 'verified'])
        ->name('applications.reject');

    /*
    |--------------------------------------------------------------------------
    | User Management (Opsional)
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Data RT / RW
    |--------------------------------------------------------------------------
    */
    Route::resource('rts', RtController::class)->middleware(['auth', 'verified']);
    Route::resource('rws', RwController::class)->middleware(['auth', 'verified']);

    /*
    |--------------------------------------------------------------------------
    | Surat (Applications) & Jenis Surat (Application Types)
    |--------------------------------------------------------------------------
    */
});

Route::resource('applications', ApplicationController::class)->middleware(['auth', 'verified']);
Route::resource('application-types', ApplicationTypeController::class)->middleware(['auth', 'verified']);
// Ambil syarat permohonan berdasarkan jenis surat (AJAX)
Route::get('/requirements/{applicationType}', [ApplicationTypeController::class, 'requirements'])
    ->middleware(['auth', 'verified'])
    ->name('application-types.requirements');
Route::get('/applications/{application}/generate-pdf', [ApplicationController::class, 'generatePdf'])
    ->name('applications.generatePdf');


/*
|--------------------------------------------------------------------------
| Fitur Tambahan
|--------------------------------------------------------------------------
*/
// Sistem Antrean
Route::get('/antrean', [AntreanController::class, 'index'])->name('antrean.index');
Route::post('/antrean/ambil', [AntreanController::class, 'ambil'])->name('antrean.ambil');

// Tracking Status Permohonan
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');

// Notifikasi Otomatis (WhatsApp/SMS)
Route::post('/notifications/{application}', [NotificationController::class, 'kirim'])
    ->name('notifications.kirim');

/*
|--------------------------------------------------------------------------
| Auth Scaffolding Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
