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
    Route::POST('/dashboard/data-siswa/edit/{nisn}', [DashboardController::class, 'editDataSiswa']);
    Route::GET('/dashboard/data-siswa/delete/{nisn}', [DashboardController::class, 'deleteDataSiswa']);
    Route::GET('/dashboard/data-siswa/feature/search/{value}', [DashboardController::class, 'searchDataSiswa']);

    // PETUGAS
    Route::GET('/dashboard/data-petugas', [DashboardController::class, 'viewDataPetugas']);
    Route::POST('/dashboard/data-petugas/create', [DashboardController::class, 'createDataPetugas']);
    Route::GET('/dashboard/data-petugas/detail/{id}', [DashboardController::class, 'detailDataPetugas']);
    Route::POST('/dashboard/data-petugas/edit/{id}', [DashboardController::class, 'editDataPetugas']);
    Route::GET('/dashboard/data-petugas/delete/{id}', [DashboardController::class, 'deleteDataPetugas']);
    Route::GET('/dashboard/data-petugas/feature/search/{value}', [DashboardController::class, 'searchDataPetugas']);

    // ROUTE DATA KELAS
    Route::GET('/dashboard/data-kelas', [DashboardController::class, 'viewDataKelas']);
    Route::POST('/dashboard/data-kelas/create', [DashboardController::class, 'createDataKelas']);
    Route::GET('/dashboard/data-kelas/detail/{id}', [DashboardController::class, 'detailDataKelas']);
    Route::POST('/dashboard/data-kelas/edit/{id}', [DashboardController::class, 'editDataKelas']);
    Route::GET('/dashboard/data-kelas/delete/{id}', [DashboardController::class, 'deleteDataKelas']);
    Route::GET('/dashboard/data-kelas/feature/search/{value}', [DashboardController::class, 'searchDataKelas']);

    // ROUTE DATA SPP
    Route::GET('/dashboard/data-spp', [DashboardController::class, 'viewDataSpp']);
    Route::POST('/dashboard/data-spp/create', [DashboardController::class, 'createDataSpp']);
    Route::POST('/dashboard/data-spp/edit/{id}', [DashboardController::class, 'editDataSpp']);
    Route::GET('/dashboard/data-spp/delete/{id}', [DashboardController::class, 'deleteDataSpp']);
    Route::GET('/dashboard/data-spp/feature/search/{value}', [DashboardController::class, 'searchDataSpp']);


    // ENTRY PEMBAYARAN SPP
    Route::GET('/dashboard/entry-pembayaran-spp', [DashboardController::class, 'viewEntryPembayaranSpp']);
    Route::POST('/dashboard/entry-pembayaran-spp/create', [DashboardController::class, 'createEntryPembayaranSpp']);
    Route::GET('/dashboard/data-entry-pembayaran-spp/feature/search/{val}', [DashboardController::class, 'searchEntryPembayaranSpp']);
    
    // HISTORY PEMBAYARAN UNTUK PETUGAS
    Route::GET('/dashboard/entry-pembayaran-spp/history/{nisn}', [DashboardController::class, 'viewHistoryPembayaran']);
    Route::GET('/dashboard/data-history-pembayaran/delete/{id}', [DashboardController::class, 'deleteHistoryPembayaran']);
    
});