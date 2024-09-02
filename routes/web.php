<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenghitunganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BantuanController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# Auth Controller
Route::get('/', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);


# Middleware Group
Route::middleware(['IsAdmin'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    # Dashboard Controller
    Route::get('/dashboard', [DashboardController::class, 'index']);

    # Kriteria Controller
    Route::get('/data-kriteria', [KriteriaController::class, 'index']);
    Route::post('/data-kriteria', [KriteriaController::class, 'store']);
    Route::put('/data-kriteria/{id}', [KriteriaController::class, 'update']);
    Route::delete('/data-kriteria/{id}', [KriteriaController::class, 'destroy']);

    # Sub Kriteria Controller
    Route::get('/data-subkriteria', [SubKriteriaController::class, 'index']);
    Route::post('/data-subkriteria', [SubKriteriaController::class, 'store']);
    Route::put('/data-subkriteria/{id}', [SubKriteriaController::class, 'update']);
    Route::delete('/data-subkriteria/{id}', [SubKriteriaController::class, 'destroy']);

    # Anak Controller
    Route::get('/data-anak', [AnakController::class, 'index']);
    Route::post('/data-anak', [AnakController::class, 'store']);
    Route::put('/data-anak/{id}', [AnakController::class, 'update']);
    Route::delete('/data-anak/{id}', [AnakController::class, 'destroy']);

    # Bantuan Controller
    Route::get('/data-bantuan', [BantuanController::class, 'index']);
    Route::post('/data-bantuan', [BantuanController::class, 'store']);
    Route::put('/data-bantuan/{id}', [BantuanController::class, 'update']);
    Route::delete('/data-bantuan/{id}', [BantuanController::class, 'destroy']);

    # Penghitungan Controller
    Route::get('/data-penghitungan-hasil', [PenghitunganController::class, 'indexhasil']);
    Route::get('/data-penghitungan-detail', [PenghitunganController::class, 'indexdetail']);

    # Add Bantuan
    Route::post('/add-bantuan', [PenghitunganController::class, 'storebantuan']);
    Route::put('/update-bantuan/{id}', [PenghitunganController::class, 'updatebantuan']);
    Route::delete('/delete-bantuan/{id}', [PenghitunganController::class, 'destroybantuan']);
});
