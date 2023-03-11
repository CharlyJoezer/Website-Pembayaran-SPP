<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/', function () {
        return view('beranda',[
            'title' => 'Beranda | Dashboard'
        ]);
    });
});