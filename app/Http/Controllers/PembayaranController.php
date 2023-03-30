<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Spp;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // ENTRY PEMBAYARAN SPP
    public function viewEntryPembayaranSpp(){
        if(Auth::guard('petugas')->check()){
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
        }else{
            return abort(403);
        }
    }
    public function createEntryPembayaranSpp(Request $request){
        if(Auth::guard('petugas')->check()){
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
                return back()->with('fail', 'NISN Siswa tidak ditemukan!');
            }
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
                        'id_spp' => $getSpp['id_spp'],
                        'id_kelas' => $checkNISN['id_kelas']
                    ];
                    array_push($finaldata, $createSingleDataArray);
                }
                
                DB::beginTransaction();
            try{
                Pembayaran::insert($finaldata);
                DB::commit(); // Data akan diinput jika query tidak terjadi error
                return back()->with('success',  count($inputMonth).' Data Pembayaran telah ditambahkan');
            }catch(Exception){
                DB::rollback();
                return back()->with('fail', 'Terjadi Kesalahan Input, Coba lagi!');
            }
        }else{
            return abort(403);
        }
    }
    public function viewHistoryPembayaran($nisn){
        if(Auth::guard('petugas')->check()){
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
        }else{
            return abort(403);
        }
    }
    public function searchEntryPembayaranSpp($val){
        if(Auth::guard('petugas')->check()){
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
                        return $getView;
            }catch(Exception){
                return abort(500);
            }
        }else{
            return abort(403);
        }
    }
    public function deleteHistoryPembayaran($id){
        if(Auth::guard('petugas')->check()){
            if(!is_numeric($id)){
                return abort(404);
            }
            try{
                Pembayaran::where('id_pembayaran', $id)->delete();
            }catch(Exception){
                return abort(500);
            }
            return back()->with('fail', '1 Data Pembayaran telah dihapus');
        }else{
            return abort(403);
        }
    }
    public function getMonthPembayaranSpp($nisn){
        if(Auth::guard('petugas')->check()){
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
        }else{
            return abort(403);
        }
    }
}
