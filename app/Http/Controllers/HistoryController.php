<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function viewHistoryPembayaran(){
        if(Auth::guard('siswa')->check()){
            return view('dashboard.history.siswa.index',[
                'title' => 'History Pembayaran',
                'css' => 'historySiswa',
                'data' => User::where('nisn', Auth::guard('siswa')->user()->nisn)->first(),
                'history' => Pembayaran::where('nisn', Auth::guard('siswa')->user()->nisn)->orderBy('id_pembayaran', 'desc')->get()
            ]);
        }elseif(Auth::guard('petugas')->check()){
            return view('dashboard.history.petugas.index',[
                'title' => 'History Pembayaran',
                'css' => 'history'
            ]);
        }
    }

    public function getHistoryPembayaran($val){
        try{
            $data = User::with(['kelas' => function($query){
                    $query->select('id_kelas','nama_kelas', 'kompetensi_keahlian');
                    }])->where('nisn', 'like', $val.'%')->orWhere('nama','like',$val.'%')->orWhere('nis','like',$val.'%')->paginate(10,['nisn','nis','nama','id_kelas','id_spp','alamat','no_telp','foto']);
                    
                    if(count($data) <= 0){
                        return response()->json(['message' => 'Data tidak ditemukan', 'status' => 'false']);
                    }
        }catch(Exception){
            return abort(500);
        }
        $getView = view('dashboard.history.petugas.search', [
            'data' => $data
        ]);
        return response()->json(['data' => (String)$getView, 'status' => 'true'], 200);
    }

}
