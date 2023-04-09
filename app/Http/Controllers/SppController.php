<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SppController extends Controller
{
    public function viewDataSpp(){
        try{
            if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
                return view('dashboard.dataspp.index',[
                    'title' => 'Data SPP | Dashboard',
                    'css' => 'dataspp',
                    'data' => Spp::orderBy('tahun', 'desc')->paginate(10)
                ]);
            }else{
                return abort(403);
            }

        }catch(Exception){
            return abort(500, json_encode([
                'status' => 500,
                'message' => 'Server Error'
            ]));
        }
    }
    public function createDataSpp(Request $request){
        try{
            if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
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
        
                return back()->with('success', '1 Data Spp telah ditambahkan');
            }else{
                return abort(403);
            }

        }catch(Exception){
            return abort(500, json_encode([
                'status' => 500,
                'message' => 'Server Error'
            ]));
        }
    }
    public function editDataSpp(Request $request, $id){
        try{
            if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
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
        
                return back()->with('success', '1 Data Spp telah diubah');
            }else{
                return abort(403);
            }
            
        }catch(Exception){
            return abort(500, json_encode([
                'status' => 500,
                'message' => 'Server Error'
            ]));
        }
    }
    public function deleteDataSpp($id){
        try{
            if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
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
                        return back()->with('success', '1 Data Spp telah dihapus');
                    }
                }catch(Exception){
                    return abort(500);
                }
            }else{
                return abort(403);
            }
            
        }catch(Exception){
            return abort(500, json_encode([
                'status' => 500,
                'message' => 'Server Error'
            ]));
        }
    }
    public function searchDataSpp($val){
        try{
            if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
                try{
                    $data = Spp::where('tahun', 'like', $val.'%')->orderBy('tahun', 'desc')->paginate(10);
                }catch(Exception){
                    return abort(500);
                }
                $getView = view('dashboard.dataspp.search', [
                    'data' => $data
                ]);
        
                return $getView;
            }else{
                return abort(403);
            }
            
        }catch(Exception){
            return abort(500, json_encode([
                'status' => 500,
                'message' => 'Server Error'
            ]));
        }
    }
}
