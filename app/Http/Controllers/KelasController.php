<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // CONTROLLER DATA KELAS
    public function viewDataKelas(){
        return view('dashboard.datakelas.index',[
            'title' => 'Data Kelas | Dashboard',
            'css' => 'datakelas',
            'data' => Kelas::orderBy('nama_kelas', 'asc')->paginate(5)
        ]);
    }
    public function detailDataKelas($id){
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
    }
    public function createDataKelas(Request $request){
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

        return back();
    }
    public function editDataKelas(Request $request, $id){
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

        return back();
    }
    public function deleteDataKelas($id){
        if(!is_numeric($id)){
            return abort(404);
        }
        try{
            $getData = Kelas::where('id_kelas', $id)->first();
            if($getData == null){
                return abort(404);
            }
            else{
                Kelas::where('id_kelas', $id)->delete();
                return back();
            }
        }catch(Exception){
            return abort(500);
        }
    }
    public function searchDataKelas($val){
        try{
            $data = Kelas::where('kompetensi_keahlian', 'like', $val.'%')->orWhere('nama_kelas','like',$val.'%')->orderBy('nama_kelas', 'asc')->paginate(10);
        }catch(Exception){
            return abort(500);
        }
        $getView = view('dashboard.datakelas.search', [
            'data' => $data
        ]);

        return $getView;
    }
}
