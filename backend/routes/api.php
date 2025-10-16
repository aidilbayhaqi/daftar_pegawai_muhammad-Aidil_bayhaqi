<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UnitController;

Route::get('/test', function () {
    return response()->json(['message' => 'API Connected!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/karyawans', [KaryawanController::class, 'index']);   // List
    Route::get('/karyawans/{id}', [KaryawanController::class, 'show']); // Detail
    Route::post('/karyawans', [KaryawanController::class, 'store']);  // Tambah
    Route::put('/karyawans/{id}', [KaryawanController::class, 'update']); // Update
    Route::delete('/karyawans/{id}', [KaryawanController::class, 'destroy']); // Hapus

     Route::apiResource('/jabatans', JabatanController::class);
    Route::apiResource('/units', UnitController::class);
});
