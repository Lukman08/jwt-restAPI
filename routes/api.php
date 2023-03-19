<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/auth')->group(function () {
    
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('api.auth.refresh');

    Route::middleware('auth:api')->group(function () {
        Route::post('/me', [AuthController::class, 'me'])->name('api.auth.me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    });
});

Route::middleware('auth:api')->prefix('/pegawai')->group(function () {
    Route::get('/', [PegawaiController::class, 'index'])->name('api.pegawai.index');
    Route::get('/show/{id}', [PegawaiController::class, 'show'])->name('api.pegawai.show');
    Route::post('/create', [PegawaiController::class, 'store'])->name('api.pegawai.create');
    Route::post('update/{id}', [PegawaiController::class, 'update'])->name('api.pegawai.update');
    Route::delete('/{id}', [PegawaiController::class, 'destroy'])->name('api.pegawai.destroy');
});