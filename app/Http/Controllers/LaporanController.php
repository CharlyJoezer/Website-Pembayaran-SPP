<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LaporanController extends Controller
{
    public function generateLaporanPembayaran($nisn){
        if(Auth::guard('petugas')->check()){
            if(Auth::guard('petugas')->user()->level == 'admin'){
                $data = [
                    'siswa' => User::where('nisn', $nisn)->first(),
                    'data' => Pembayaran::where('nisn', $nisn)->get() 
                ];
                return view('dashboard.laporan.index',$data);
            }else{
                return abort(403);
            }
        }else{
            return abort(403);
        }
    }
}
