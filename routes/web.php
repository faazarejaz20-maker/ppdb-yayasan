<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\YayasanController;
use Illuminate\Support\Facades\Route;

// Auth routes (harus sebelum route /{slug})
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/cek-pendaftaran', [PublicController::class, 'checkRegistration'])->name('check-registration');
Route::post('/cek-pendaftaran', [PublicController::class, 'checkRegistrationSubmit'])->name('check-registration.submit');

// Pendaftaran
Route::get('/pendaftaran/sukses/{nomorPeserta}', [RegistrationController::class, 'success'])->name('registration.success');
Route::get('/pendaftaran/cetak/{nomorPeserta}', [RegistrationController::class, 'print'])->name('registration.print');

// Dashboard panitia & admin sekolah
Route::middleware('role:panitia,admin_sekolah')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/tambah', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::post('/dashboard/tambah', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::post('/dashboard/reset', [DashboardController::class, 'reset'])->name('dashboard.reset');

    Route::get('/dashboard/akun', [DashboardController::class, 'accounts'])->name('dashboard.accounts');
    Route::get('/dashboard/periode', [DashboardController::class, 'periods'])->name('dashboard.periods');

    Route::get('/dashboard/{nomorPeserta}', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::post('/dashboard/{nomorPeserta}/status', [DashboardController::class, 'updateStatus'])->name('dashboard.status');
    Route::post('/dashboard/{nomorPeserta}/berkas', [DashboardController::class, 'verifyBerkas'])->name('dashboard.berkas');
    Route::post('/dashboard/{nomorPeserta}/pengumuman', [DashboardController::class, 'markAnnouncement'])->name('dashboard.pengumuman');
    Route::get('/dashboard/{nomorPeserta}/whatsapp', [DashboardController::class, 'whatsapp'])->name('dashboard.whatsapp');
});

// Dashboard yayasan (read-only)
Route::middleware('role:yayasan')->group(function () {
    Route::get('/yayasan', [YayasanController::class, 'index'])->name('yayasan');
});

// Dashboard super admin
Route::middleware('role:super_admin')->group(function () {
    Route::get('/super-admin', [SuperAdminController::class, 'schools'])->name('super-admin');
    Route::post('/super-admin/sekolah/{code}/toggle', [SuperAdminController::class, 'toggleSchool'])->name('super-admin.school.toggle');

    Route::get('/super-admin/akun/{scope}', [SuperAdminController::class, 'accounts'])->name('super-admin.accounts');
    Route::post('/super-admin/akun/{scope}', [SuperAdminController::class, 'storeAccount'])->name('super-admin.accounts.store');
    Route::post('/super-admin/akun/{scope}/{email}/toggle', [SuperAdminController::class, 'toggleAccount'])->name('super-admin.accounts.toggle');
    Route::post('/super-admin/akun/{scope}/{email}/reset', [SuperAdminController::class, 'resetPassword'])->name('super-admin.accounts.reset');

    Route::get('/super-admin/pengaturan', [SuperAdminController::class, 'settings'])->name('super-admin.settings');
});

// Wizard pendaftaran
Route::get('/{slug}/daftar', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/{slug}/daftar', [RegistrationController::class, 'store'])->name('registration.store');

// Route sekolah harus paling akhir agar tidak menangkap /login dan /cek-pendaftaran
Route::get('/{slug}', [PublicController::class, 'school'])->name('school');
