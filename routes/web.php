<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AgendaKegiatanController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\JenisAgendaController;
use App\Models\SuratMasuk;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal langsung ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (Bisa diakses Admin & User)
Route::get('/dashboard', function () {
    // Ambil 5 surat terakhir + Relasi Kategorinya
    $recents = SuratMasuk::with('kategori')
                ->latest('tanggal_diterima')
                ->take(3)
                ->get();

    return view('dashboard', compact('recents'));
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP ROUTE UNTUK USER LOGIN ---
Route::middleware('auth')->group(function () {
    
    // 1. Profil (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Operasional (Admin & User bisa akses)
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::resource('agenda', AgendaKegiatanController::class);

    // 3. Master Data (KHUSUS ADMIN)
    // Menggunakan alias 'admin' yang sudah Anda daftarkan di bootstrap/app.php
    Route::middleware('admin')->group(function () {
        Route::resource('kategori-surat', KategoriSuratController::class);
        Route::resource('jenis-agenda', JenisAgendaController::class);
    });

});

require __DIR__.'/auth.php';