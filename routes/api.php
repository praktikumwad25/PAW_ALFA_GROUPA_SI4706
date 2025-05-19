<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;

Route::get('/login', function (Request $request) {
    return response()->json(['message' => 'Unauthorized'], 401);
});

//TODO
//Tambahkan route untuk proses register dan login user.
//Pastikan mengarahkan ke method register dan login pada AuthController.
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/login', [Authcontroller::class, 'login']);
//TODO
//Buat group route dengan middleware 'auth:sanctum'.
//Di dalam group ini, tambahkan route untuk logout user dan resource route untuk Mahasiswa dan MataKuliah agar dapat menggunakan APInya
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [Authcontroller::class, 'logout']);

    Route::apiResource('mahasiswa', MahasiswaController::class);
    Route::apiResource('mata-Kuliah', MataKuliahController::class);
});