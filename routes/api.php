<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SuratMasukController; // Kita pakai controller yang sama untuk contoh

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. Route Public (Login untuk dapat Token)
Route::post('/login', [AuthController::class, 'login']);

// 2. Route Protected (Harus pakai Token Bearer)
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Contoh API: Ambil data User yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Contoh API: Ambil data Surat Masuk (Sesuai tugas)
    // Kita buat endpoint manual sederhana saja
    Route::get('/surat-masuk', function() {
        return \App\Models\SuratMasuk::with('kategori')->get();
    });
});