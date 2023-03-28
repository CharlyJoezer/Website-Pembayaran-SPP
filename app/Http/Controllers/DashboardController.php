<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Spp;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Petugas;
use App\Models\Pembayaran;
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
            'alamat' => 'required|string',
            'image' => 'required'
        ]);
        $dataEntry = [
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->kelas, 
            'id_spp' => $request->spp,
            'no_telp' => $request->telp,
            'alamat' => $request->alamat,
            'foto' => null
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

    // CONTROLLER PETUGAS
    public function viewDataPetugas(){
        return view('dashboard.datapetugas.index',[
            'title' => 'Data Petugas | Dashboard',
            'css' => 'datapetugas',
            'data' => Petugas::paginate(5)
        ]);
    }
    public function detailDataPetugas($id){
        if(!is_numeric($id)){
            return abort(404);
        }
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


    // DATA SPP
    public function viewDataSpp(){
        return view('dashboard.dataspp.index',[
            'title' => 'Data SPP | Dashboard',
            'css' => 'dataspp',
            'data' => Spp::orderBy('tahun', 'desc')->paginate(10)
        ]);
    }
    public function createDataSpp(Request $request){
        $request->validate([
            'tahun' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);

        $finalData = [
            'tahun' => $request->tahun,
            'nominal' => $request->nominal,
        ];
        try{
            Spp::create($finalData);
        }catch(Exception){
            abort(500);
            die();
        }

        return back();
    }
    public function editDataSpp(Request $request, $id){
        $request->validate([
            'tahun' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);

        $finalData = [
            'tahun' => $request->tahun,
            'nominal' => $request->nominal,
        ];

        try{
            Spp::where('id_spp', $id)->update($finalData);
        }catch(Exception){
            abort(500);
            die();
        }

        return back();
    }
    public function deleteDataSpp($id){
        if(!is_numeric($id)){
            return abort(404);
        }
        try{
            $getData = Spp::where('id_spp', $id)->first();
            if($getData == null){
                return abort(404);
            }
            else{
                Spp::where('id_spp', $id)->delete();
                return back();
            }
        }catch(Exception){
            return abort(500);
        }
    }
    public function searchDataSpp($val){
        try{
            $data = Spp::where('tahun', 'like', $val.'%')->orderBy('tahun', 'desc')->paginate(10);
        }catch(Exception){
            return abort(500);
        }
        $getView = view('dashboard.dataspp.search', [
            'data' => $data
        ]);

        return $getView;
    }


        // ENTRY PEMBAYARAN SPP
    public function viewEntryPembayaranSpp(){
        return view('dashboard.pembayaran.index',[
            'title' => 'Entry Pembayaran SPP | Dashboard',
            'css' => 'entry_pembayaran',
            'data' => User::with([
                'spp',
                'pembayaran',
                'kelas'])->paginate(5),
            'spp' => Spp::all(),
            'getMonth' => function($array){
                            $data = [];
                            foreach($array['pembayaran'] as $num){
                                if($array['id_spp'] == $num['id_spp']){
                                    array_push($data, $num['bulan_dibayar']);
                                }
                            }
                            return end($data);
                        }
         ]);
    }
    public function createEntryPembayaranSpp(Request $request){
        $request->validate([
            'nisn' => 'required|numeric',
            'tahun_spp' => 'required|numeric',
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $allMonth = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        $inputMonth = [];
        for($i = 0; $i < 12; $i++){
            $getMon = (String)$request->input($allMonth[$i]);
            if($getMon != null){
                array_push($inputMonth, $allMonth[$i]);
            }
        }
        if(count($inputMonth) <= 0){
            return back()->with('fail', 'Terjadi Kesalahan Input, Coba lagi!');
        }


        $checkNISN = User::where('nisn', $request->nisn)->first();
        if($checkNISN == null){
            return back()->with('fail', 'Gagal membuat data, NISN Siswa tidak ditemukan!');
        }
        try{
            $getSpp = Spp::where('id_spp', $request->tahun_spp)->first();
            if($getSpp == null){
                return abort(404);
            }


            $finaldata = [];
            for($i = 0; $i < count($inputMonth); $i++){
                $createSingleDataArray = [
                    'nisn' => $request->nisn,
                    'tahun_dibayar' => $request->tahun_spp,
                    'bulan_dibayar' => $inputMonth[$i],
                    'tgl_dibayar' => $request->tanggal,
                    'jumlah_bayar' => $request->jumlah,
                    'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                    'id_spp' => $getSpp['id_spp']
                ];
                array_push($finaldata, $createSingleDataArray);
            }


            Pembayaran::insert($finaldata);
            return back();
            
        }catch(Exception){
            return abort(500);
        }
    }
    public function viewHistoryPembayaran($nisn){
        if(!is_numeric($nisn)){
            return abort(404);
        }
        $getData = Pembayaran::where('nisn', $nisn)->get();
        $getSiswa = User::where('nisn', $nisn)->first();
        if($getSiswa == null){
            return abort(404);
        }
        return view('dashboard.pembayaran.history',[
            'title' => 'History Pembayaran | Dashboard',
            'css' => 'entry_pembayaran',
            'history' => $getData,
            'siswa' => $getSiswa
        ]);
    }
    public function searchEntryPembayaranSpp($val){
        try{
            $data = User::with([
                    'kelas' => function($query){
                    $query->select('id_kelas','nama_kelas', 'kompetensi_keahlian');
                    }, 
                    'spp', 'pembayaran'])->where('nisn', 'like', $val.'%')->orWhere('nama','like',$val.'%')->orWhereHas('kelas', function($query) use ($val){
                        $query->where('kompetensi_keahlian', 'like', '%'.$val);
                    })->paginate(10,['nisn','nis','nama','id_kelas','id_spp','alamat','no_telp','foto']);
                    
                    $getView = view('dashboard.pembayaran.search', [
                        'data' => $data,
                        'getSum' => function($array){
                                        $total = 0;
                                        foreach($array['pembayaran'] as $num){
                                            if($array['id_spp'] == $num['id_spp']){
                                                $total += $num['jumlah_bayar'];
                                            }
                                        }
                                        return $total;
                                    }
                    ]);
                    return $getView;
        }catch(Exception){
            return abort(500);
        }
    }
    public function deleteHistoryPembayaran($id){
        if(!is_numeric($id)){
            return abort(404);
        }
        try{
            Pembayaran::where('id_pembayaran', $id)->delete();
        }catch(Exception){
            return abort(500);
        }
        return back();
    }
    public function getMonthPembayaranSpp($nisn){
        if(auth()->guard('petugas')->user()->level == 'admin' || auth()->guard('petugas')->user()->level == 'petugas'){

            $allMonth = [
                'Januari' => '1',
                'Februari' => '2',
                'Maret' => '3',
                'April' => '4',
                'Mei' => '5',
                'Juni' => '6',
                'Juli' => '7',
                'Agustus' => '8',
                'September' => '9',
                'Oktober' => '10',
                'November' => '11',
                'Desember' => '12',
            ];
    
    
            $getSiswa = User::where('nisn', $nisn)->first();
            if(!isset($getSiswa['nisn'])){
                return response()->json(['status' => 'false','message' => 'NISN tidak ditemukan!']);
            }
            $getPembayaran = Pembayaran::where([
                ['nisn', $nisn],
                ['id_spp', $getSiswa['id_spp']]
            ])->get();
    
            if($getPembayaran == null){
                return response()->json(['status' => 'true', 'monthx`' => $allMonth]);
            }
    
    
            foreach($getPembayaran as $mon){
                if(isset($allMonth[$mon['bulan_dibayar']])){
                    unset($allMonth[$mon['bulan_dibayar']]);
                }
            }
            return response()->json(['status' => 'true','month' => $allMonth]);
        }else{
            return response()->json(['status' => 'False','message' => 'Forbidden'], 403);
        }
    }




}
