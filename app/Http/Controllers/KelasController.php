<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    // CONTROLLER DATA KELAS
    public function viewDataKelas(){
        if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
            return view('dashboard.datakelas.index',[
                'title' => 'Data Kelas | Dashboard',
                'css' => 'datakelas',
                'data' => Kelas::orderBy('nama_kelas', 'asc')->paginate(5)
            ]);
        }else{
            return abort(403);
        }
    }
    public function detailDataKelas($id){
        if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
            if(!is_numeric($id)){
                return abort(404);
            }
            try{
                $kelas = Kelas::with(['user' => function($query){
                    $query->select('id_kelas','nisn','nis','nama',);
                    }])->where('id_kelas', $id)->first();
                if($kelas == null){
                    return abort(404);
                }
            }catch(Exception){
                return abort(500);
            }
            return view('dashboard.datakelas.detail',[
                'title' => 'Detail Kelas | Dashboard',
                'css' => 'datakelas',
                'data' => $kelas,
                'no' => 1
            ]);
        }else{
            return abort(403);
        }
    }
    public function createDataKelas(Request $request){
        if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
            $request->validate([
                'kelas' => 'required',
                'jurusan' => 'required',
            ]);
    
            $finalData = [
                'nama_kelas' => $request->kelas,
                'kompetensi_keahlian' => $request->jurusan,
            ];
            try{
                Kelas::create($finalData);
            }catch(Exception){
                abort(500);
                die();
            }
    
            return back()->with('success', '1 Kelas telah ditambahkan');
        }else{
            return abort(403);
        }
    }
    public function editDataKelas(Request $request, $id){
        if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
            $request->validate([
                'kelas' => 'required',
                'jurusan' => 'required',
            ]);
    
            $finalData = [
                'nama_kelas' => $request->kelas,
                'kompetensi_keahlian' => $request->jurusan,
            ];
    
            try{
                Kelas::where('id_kelas', $id)->update($finalData);
            }catch(Exception){
                abort(500);
                die();
            }
    
            return back()->with('success','1 Data Kelas telah diubah');
        }else{
            return abort(403);
        }
    }
    public function deleteDataKelas($id){
        if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
            if(!is_numeric($id)){
                return abort(404);
            }
            $getData = Kelas::where('id_kelas', $id)->first();
            if($getData != null){
                try{
                    DB::beginTransaction();
                        User::where('id_kelas', $id)->delete();
                        Pembayaran::where('id_kelas', $id)->delete();
                        Kelas::where('id_kelas', $id)->delete();
                    DB::commit();
                    return back()->with('success', '1 Data Kelas telah dihapus');
                }catch(Exception){
                    DB::rollback();
                    return back()->with('fail', 'Terjadi Kesalahan Input, Coba lagi!');
                }
            }else{
                return abort(404);
            }
        }else{
            return abort(403);
        }
    }
    public function searchDataKelas($val){
        if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
            try{
                $data = Kelas::where('kompetensi_keahlian', 'like', $val.'%')->orWhere('nama_kelas','like',$val.'%')->orderBy('nama_kelas', 'asc')->paginate(10);
            }catch(Exception){
                return abort(500);
            }
            $getView = view('dashboard.datakelas.search', [
                'data' => $data
            ]);
            return $getView;
        }else{
            return abort(403);
        }
    }
}
