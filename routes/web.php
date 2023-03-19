<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::middleware('guest')->group(function(){
    Route::GET('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::POST('/login/auth', [AuthController::class, 'authLogin']);

});
Route::middleware('auth:siswa,petugas')->group(function(){
    Route::GET('/logout', [AuthController::class, 'logout']);
    Route::GET('/', [DashboardController::class, 'dashboard']);
});
Route::middleware('auth:petugas')->group(function(){
    Route::GET('/dashboard/data-siswa', [DashboardController::class, 'viewDataSiswa']);
    Route::POST('/dashboard/data-siswa/create', [DashboardController::class, 'createDataSiswa']);
    Route::GET('/dashboard/data-siswa/detail/{nisn}', [DashboardController::class, 'detailDataSiswa']);
    Route::GET('/dashboard/data-siswa/delete/{nisn}', [DashboardController::class, 'deleteDataSiswa']);
    Route::POST('/dashboard/data-siswa/edit/{nisn}', [DashboardController::class, 'editDataSiswa']);
    Route::GET('/dashboard/data-siswa/feature/search/{value}', [DashboardController::class, 'searchDataSiswa']);
});