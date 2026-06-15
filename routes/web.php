<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;

// ============================================================
// AUTH — publik (belum login)
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// Logout (perlu login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Redirect root ke login
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'guru')  return redirect()->route('guru.dashboard');
        return redirect()->route('siswa.dashboard');
    }
    return redirect()->route('login');
});

// ============================================================
// ADMIN
// ============================================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard',   [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('store-kelas');
    Route::post('/admin/siswa/{id}/reset-kelas', [\App\Http\Controllers\AdminController::class, 'resetKelasSiswa'])->name('admin.siswa.reset-kelas');
    Route::get('/admin/kelola-siswa', [\App\Http\Controllers\AdminController::class, 'kelolaSiswa'])->name('admin.kelola-siswa');
    Route::get('/permintaan-keluar', [AdminController::class, 'kelolaSiswa'])->name('permintaan-keluar');

    // Kelola user
    Route::get('/kelola-user', [AdminController::class, 'kelolaUser'])->name('kelola-user');
    Route::patch('/kelola-user/{user}/role', [AdminController::class, 'updateRole'])->name('update-role');
    Route::delete('/kelola-user/{user}',     [AdminController::class, 'deleteUser'])->name('delete-user');

    // Tambah akun guru
    Route::get('/tambah-guru',  [AdminController::class, 'tambahGuru'])->name('tambah-guru');
    Route::post('/tambah-guru', [AdminController::class, 'storeGuru'])->name('store-guru');

    // Analitik, nilai, kelas
    Route::get('/analitik', [AdminController::class, 'analitik'])->name('analitik');
    Route::get('/nilai',    [AdminController::class, 'nilai'])->name('nilai');
    Route::get('/kelas',    [AdminController::class, 'kelas'])->name('kelas');
});

// ============================================================
// GURU
// ============================================================
Route::middleware(['auth', 'guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

    Route::get('/dashboard',    [GuruController::class, 'dashboard'])->name('dashboard');

    // Nilai
    Route::get('/input-nilai',  [GuruController::class, 'inputNilai'])->name('input-nilai');
    Route::post('/input-nilai', [GuruController::class, 'storeNilai'])->name('store-nilai');
    Route::get('/daftar-nilai', [GuruController::class, 'daftarNilai'])->name('daftar-nilai');
    Route::delete('/nilai/{grade}', [GuruController::class, 'destroyNilai'])->name('destroy-nilai');

    // Kelas
    Route::get('/kelas', [GuruController::class, 'kelas'])->name('kelas');
});

// ============================================================
// SISWA
// ============================================================
Route::middleware(['auth', 'siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        
        // Dashboard & Profil
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/nilai-saya', [SiswaController::class, 'nilaiSaya'])->name('nilai-saya');
        
        // Kelas & Jadwal
        Route::get('/kelas', [SiswaController::class, 'kelas'])->name('kelas');
        Route::get('/jadwal', [SiswaController::class, 'jadwal'])->name('jadwal');
        Route::post('/ajukan-keluar', [SiswaController::class, 'ajukanKeluar'])->name('ajukan-keluar');
        
        // Pemilihan Kelas
        Route::get('/pilih-kelas', [SiswaController::class, 'pilihKelas'])->name('pilih-kelas');
        Route::post('/pilih-kelas', [SiswaController::class, 'simpanKelas'])->name('simpan-kelas');
    });

