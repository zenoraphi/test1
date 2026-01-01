<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    SiswaController,
    LoginController,
    JurusanController,
    PembimbingController,
    DudiController,
    SuratController
};

Route::redirect('/', '/dashboard');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ⭐ API ROUTE HARUS DI LUAR & DI ATAS - TANPA PREFIX 'surat'
Route::middleware(['auth'])->group(function () {
    Route::get('/api/dudi/{id}', [SuratController::class, 'getDudi'])->name('api.dudi');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
});

Route::middleware(['auth', 'role:super_admin,admin_jurusan'])->group(function () {
    // SISWA
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    // PEMBIMBING
    Route::get('/pembimbing', [PembimbingController::class, 'index'])->name('pembimbing.index');
    Route::get('/pembimbing/create', [PembimbingController::class, 'create'])->name('pembimbing.create');
    Route::post('/pembimbing', [PembimbingController::class, 'store'])->name('pembimbing.store');
    Route::get('/pembimbing/{pembimbing}', [PembimbingController::class, 'show'])->name('pembimbing.show');
    Route::get('/pembimbing/{pembimbing}/edit', [PembimbingController::class, 'edit'])->name('pembimbing.edit');
    Route::put('/pembimbing/{pembimbing}', [PembimbingController::class, 'update'])->name('pembimbing.update');
    Route::delete('/pembimbing/{pembimbing}', [PembimbingController::class, 'destroy'])->name('pembimbing.destroy');

    // DUDI
    Route::resource('dudi', DudiController::class);
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
});

Route::middleware(['auth', 'role:super_admin,admin_jurusan'])->group(function () {
    Route::get('/jurusan/{jurusan}', [JurusanController::class, 'show'])->name('jurusan.show');
    Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
});

// 📄 SURAT ROUTES
Route::middleware(['auth'])->prefix('surat')->name('surat.')->group(function () {
    Route::get('/', [SuratController::class, 'index'])->name('index');
    Route::get('/penjajakan', [SuratController::class, 'penjajakan'])->name('penjajakan');
    Route::post('/penjajakan/preview', [SuratController::class, 'penjajakanPreview'])->name('penjajakan.preview');
    Route::get('/temp/{filename}', [SuratController::class, 'serveTemp'])->name('temp.serve');
    Route::post('/penjajakan/download', [SuratController::class, 'download'])->name('penjajakan.download');
});