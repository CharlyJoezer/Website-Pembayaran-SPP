<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Spp;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    // CONTROLLER SISWA
    public function viewDataSiswa(){
        return view('dashboard.datasiswa.index',[
            'title' => 'Data Siswa | Dashboard',
            'css' => 'datasiswa',
            'data' => User::with(['kelas','spp'])->orderBy('created_at','desc')->paginate(5,['nisn','nis','nama','alamat','no_telp','foto', 'id_kelas','id_spp']),
            'kelas' => Kelas::all(['id_kelas','nama_kelas', 'kompetensi_keahlian']),
            'spp' => Spp::all(['id_spp', 'tahun', 'nominal'])
        ]);
    }

    public function createDataSiswa(Request $request){
        $request->validate([
            'nisn' => 'required|numeric',
            'nis' => 'required|numeric',
            'nama' => 'required|string',
            'kelas' => 'required|string',
            'spp' => 'required|numeric',
            'telp' => 'required|numeric',
            'alamat' => 'required|string'
        ]);
        $dataEntry = [
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->kelas, 
            'id_spp' => $request->spp,
            'no_telp' => $request->telp,
            'alamat' => $request->alamat
        ];
        try{
            $checkAlreadyUser = User::where('nisn', $dataEntry['nisn'])->first();
            $checkSpp = Spp::where('id_spp', $dataEntry['id_spp'])->first();
            if($checkAlreadyUser != null){
                return back()->with('fail', 'NISN dengan nomor '.$dataEntry['nisn'].' sudah terdaftar!');
            }
            if($checkSpp == null){
                return abort(500);
            }

            $dataEntry['password'] = $request->nis.$request->nisn;
            User::create($dataEntry);
            return back()->with('success', '1 Data telah ditambahkan');
        }catch(Exception){
            return abort(500);
        }

    }

    public function deleteDataSiswa($id){
        if(Auth::guard('petugas')->check()){
            $checkDataRequest = User::where('nisn', $id)->first();
            if($checkDataRequest != null){
                User::where('nisn', $id)->delete();
                Pembayaran::where('nisn', $id)->delete();
                return back()->with('success', '1 Data Siswa telah dihapus');
            }else{
                return back()->with('fail', 'Data tidak ditemukan!');
            }
        }else{
            abort(403);
        }
    }

    public function editDataSiswa(Request $request, $id){
        if(Auth::guard('petugas')->check()){
            $request->validate([
                'nisn' => 'required|numeric',
                'nis' => 'required|numeric',
                'nama' => 'required|string',
                'kelas' => 'required|string',
                'spp' => 'required|numeric',
                'telp' => 'required|numeric',
                'alamat' => 'required|string',
            ]);
            $dataEntry = [
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'id_kelas' => $request->kelas,
                'id_spp' => $request->spp,
                'no_telp' => $request->telp,
                'alamat' => $request->alamat,
            ];
            User::where('nisn', $id)->update($dataEntry);
            return back()->with('success', 'Data NISN '.$dataEntry['nisn'].' berhasil diubah!');
        }else{
            abort(404);
        }
    }

    public function detailDataSiswa($id){
        if(!is_numeric($id)){
            return abort(404);
        }
        if($id == null){
            abort(404, 'nisn tidak ditemukan');
        }
        try{
            $data = User::where('nisn', $id)->first();
            if($data == null){
                abort(404, 'Data Not Found');    
            }
        }catch(Exception){
            return abort(500);
        }
        return view('dashboard.datasiswa.detail',[
            'title' => $data->nama.' | Detail',
            'data' => $data,
            'css' => 'datasiswa'
        ]);
    }

    public function searchDataSiswa($val){
        try{
            $data = User::with(['kelas' => function($query){
                    $query->select('id_kelas','nama_kelas', 'kompetensi_keahlian');
                    },'spp'])->where('nisn', 'like', $val.'%')->orWhere('nama','like',$val.'%')->paginate(10,['nisn','nis','nama','id_kelas','id_spp','alamat','no_telp','foto']);
        }catch(Exception){
            return abort(500);
        }

        $getView = view('dashboard.datasiswa.search', [
            'data' => $data
        ]);

        return $getView;
    }
}
