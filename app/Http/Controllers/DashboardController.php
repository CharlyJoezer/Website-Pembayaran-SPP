<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('beranda',[
            'title' => 'Beranda | Dashboard'
        ]);
    }
    public function viewDataSiswa(){
        return view('dashboard.datasiswa.index',[
            'title' => 'Data Siswa | Dashboard',
            'css' => 'datasiswa',
            'data' => User::with('kelas')->orderBy('created_at','desc')->get(['nisn','nis','nama','alamat','no_telp','foto', 'id_kelas']),
            'kelas' => Kelas::all(['id_kelas','nama_kelas', 'kompetensi_keahlian'])
        ]);
    }

    public function createDataSiswa(Request $request){
        $request->validate([
            'nisn' => 'required|numeric',
            'nis' => 'required|numeric',
            'nama' => 'required|string',
            'kelas' => 'required|string',
            'telp' => 'required|numeric',
            'alamat' => 'required|string',
            'image' => 'required'
        ]);
        $dataEntry = [
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->kelas, 
            'id_spp' => 1,
            'no_telp' => $request->telp,
            'alamat' => $request->alamat,
            'foto' => null
        ];
        try{
            $checkAlreadyData = User::where('nisn', $dataEntry['nisn'])->first();
            if($checkAlreadyData != null){
                return back()->with('fail', 'NISN dengan nomor '.$dataEntry['nisn'].' sudah terdaftar!');
            }
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = Str::random(40).now().'.'.$image->getClientOriginalExtension();
                $hashImageName = str_replace([' ', ':', '-'],'',$imageName);
                $imagepath = $image->storeAs('image', $hashImageName ,'public');
                $dataEntry['foto'] = $hashImageName;
            }
    
            $dataEntry['password'] = $request->nis.$request->nisn;
            User::create($dataEntry);
            return back();
        }catch(Exception){
            return abort(500);
        }

    }

    public function deleteDataSiswa($id){
        if(Auth::guard('petugas')->check()){
            $checkDataRequest = User::where('nisn', $id)->first();
            if($checkDataRequest != null){
                Storage::disk('public')->delete('image/'.$checkDataRequest->foto);
                User::where('nisn', $id)->delete();
                return back();
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
                'telp' => 'required|numeric',
                'alamat' => 'required|string',
            ]);
            $dataEntry = [
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'id_kelas' => $request->kelas,
                'no_telp' => $request->telp,
                'alamat' => $request->alamat,
            ];
            if($request->file('image')){
                $getImage = User::where('nisn', $id)->first('foto');
                Storage::disk('public')->delete('image/'.$getImage->foto);
                $image = $request->file('image');
                $imageName = Str::random(40).now().'.'.$image->getClientOriginalExtension();
                $hashImageName = str_replace([' ', ':', '-'],'',$imageName);
                $imagepath = $image->storeAs('image', $hashImageName ,'public');
                $dataEntry['foto'] = $hashImageName;
            }
            User::where('nisn', $id)->update($dataEntry);
            return back()->with('success', 'Data NISN '.$dataEntry['nisn'].' berhasil diubah!');
        }else{
            abort(404);
        }
    }

    public function detailDataSiswa($id){

        if($id == null){
            abort(404, 'nisn tidak ditemukan');
        }
        $data = User::where('nisn', $id)->first();
        if($data == null){
            abort(404, 'Data Not Found');    
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
                    }])->where('nisn', 'like', $val.'%')->orWhere('nama','like',$val.'%')->paginate(10,['nisn','nis','nama','id_kelas','alamat','no_telp','foto']);
        }catch(Exception){
            return abort(500);
        }
        $getView = view('dashboard.datasiswa.search', [
            'data' => $data
        ]);

        return $getView;
    }

    public function viewDataPetugas(){
        return view('dashboard.datapetugas.index',[
            'title' => 'Data Petugas | Dashboard',
            'css' => 'datapetugas',
            'data' => Petugas::all()
        ]);
    }



    // PETUGAS

    public function detailDataPetugas($id){
        try{
            $petugas = Petugas::where('id_petugas', $id)->first();
            if($petugas == null){
                return abort(404);
            }
        }catch(Exception){
            return abort(500);
        }
        return view('dashboard.datapetugas.detail',[
            'title' => 'Detail Petugas | Dashboard',
            'css' => 'datapetugas',
            'data' => $petugas
        ]);
    }
    public function createDataPetugas(Request $request){
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'level' => 'required',
            'password' => 'required|min:8',
        ]);
        if($request->level != 'admin' && $request->level != 'petugas'){
            return abort(404);
        }
        $finalData = [
            'username' => $request->username,
            'nama_petugas' => $request->nama,
            'level' => $request->level,
            'password' => Hash::make($request->password),
        ];
        try{
            Petugas::create($finalData);
        }catch(Exception){
            abort(500);
            die();
        }

        return back();
    }

    public function editDataPetugas(Request $request, $id){
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'level' => 'required',
        ]);
        if($request->level != 'admin' && $request->level != 'petugas'){
            return abort(404);
        }
        $finalData = [
            'username' => $request->username,
            'nama_petugas' => $request->nama,
            'level' => $request->level,
        ];
        try{
            Petugas::where('id_petugas', $id)->update($finalData);
        }catch(Exception){
            abort(500);
            die();
        }

        return back();
    }

    public function deleteDataPetugas($id){
        if(!is_numeric($id)){
            return abort(404);
        }
        try{
            $getData = Petugas::where('id_petugas', $id)->first();
            if($getData == null){
                return abort(404);
            }
            else{
                Petugas::where('id_petugas', $id)->delete();
                return back();
            }
        }catch(Exception){
            return abort(500);
        }

    }

    public function searchDataPetugas($val){
        try{
            $data = Petugas::where('username', 'like', $val.'%')->orWhere('nama_petugas','like',$val.'%')->paginate(10);
        }catch(Exception){
            return abort(500);
        }
        $getView = view('dashboard.datapetugas.search', [
            'data' => $data
        ]);

        return $getView;
    }
}
