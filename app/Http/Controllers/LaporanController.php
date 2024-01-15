<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function generateLaporanPembayaran($nisn){
        try{
            if(Auth::guard('petugas')->check()){
                if(Auth::guard('petugas')->user()->level == 'admin'){
                    $data = [
                        'siswa' => User::where('nisn', $nisn)->first(),
                        'data' => Pembayaran::where('nisn', $nisn)->get() 
                    ];
                    if($data['siswa'] == null || $data['data'] == null){
                        abort(404);
                    }
                    return view('dashboard.laporan.index',$data);
                }else{
                    abort(403);
                }
            }else{
                abort(403);
            }
            
        }catch(Exception){
            return abort(500, json_encode([
                'status' => 500,
                'message' => 'Server Error'
            ]));
        }
    }
}
