<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranController;

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
    
    // SISWA
    Route::controller(SiswaController::class)->group(function(){
        Route::GET('/dashboard/data-siswa', 'viewDataSiswa');
        Route::POST('/dashboard/data-siswa/create', 'createDataSiswa');
        Route::GET('/dashboard/data-siswa/detail/{nisn}', 'detailDataSiswa');
        Route::POST('/dashboard/data-siswa/edit/{nisn}', 'editDataSiswa');
        Route::GET('/dashboard/data-siswa/delete/{nisn}', 'deleteDataSiswa');
        Route::GET('/dashboard/data-siswa/feature/search/{value}', 'searchDataSiswa');
    });

    // PETUGAS
    Route::controller(PetugasController::class)->group(function(){
        Route::GET('/dashboard/data-petugas', 'viewDataPetugas');
        Route::POST('/dashboard/data-petugas/create', 'createDataPetugas');
        Route::GET('/dashboard/data-petugas/detail/{id}', 'detailDataPetugas');
        Route::POST('/dashboard/data-petugas/edit/{id}', 'editDataPetugas');
        Route::GET('/dashboard/data-petugas/delete/{id}', 'deleteDataPetugas');
        Route::GET('/dashboard/data-petugas/feature/search/{value}', 'searchDataPetugas');
    });

    // KELAS
    Route::controller(KelasController::class)->group(function(){
        Route::GET('/dashboard/data-kelas', 'viewDataKelas');
        Route::POST('/dashboard/data-kelas/create', 'createDataKelas');
        Route::GET('/dashboard/data-kelas/detail/{id}', 'detailDataKelas');
        Route::POST('/dashboard/data-kelas/edit/{id}', 'editDataKelas');
        Route::GET('/dashboard/data-kelas/delete/{id}', 'deleteDataKelas');
        Route::GET('/dashboard/data-kelas/feature/search/{value}', 'searchDataKelas');
    });

    // SPP
    Route::controller(SppController::class)->group(function(){
        Route::GET('/dashboard/data-spp', 'viewDataSpp');
        Route::POST('/dashboard/data-spp/create', 'createDataSpp');
        Route::POST('/dashboard/data-spp/edit/{id}', 'editDataSpp');
        Route::GET('/dashboard/data-spp/delete/{id}', 'deleteDataSpp');
        Route::GET('/dashboard/data-spp/feature/search/{value}', 'searchDataSpp');
    });

    // PEMBAYARAN SPP
    Route::controller(PembayaranController::class)->group(function(){
        Route::GET('/dashboard/entry-pembayaran-spp', 'viewEntryPembayaranSpp');
        Route::POST('/dashboard/entry-pembayaran-spp/create', 'createEntryPembayaranSpp');
        Route::GET('/dashboard/data-entry-pembayaran/fetch/month/{nisn}', 'getMonthPembayaranSpp');
        Route::GET('/dashboard/data-entry-pembayaran-spp/feature/search/{val}', 'searchEntryPembayaranSpp');
        Route::GET('/dashboard/entry-pembayaran-spp/history/{nisn}', 'viewHistoryPembayaran');
        Route::GET('/dashboard/data-history-pembayaran/delete/{id}', 'deleteHistoryPembayaran');
    });

});