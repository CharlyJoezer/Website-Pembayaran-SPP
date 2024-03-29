<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
        public function viewDataPetugas(){
            try{
                if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
                    return view('dashboard.datapetugas.index',[
                        'title' => 'Data Petugas | Dashboard',
                        'css' => 'datapetugas',
                        'data' => Petugas::paginate(5)
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


        public function detailDataPetugas($id){
            try{
                if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
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


        public function createDataPetugas(Request $request){
            try{
                if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
                    $request->validate([
                        'username' => 'required',
                        'nama' => 'required',
                        'level' => 'required',
                        'password' => 'required|min:8',
                    ]);
                    if($request->level != 'Admin' && $request->level != 'Petugas'){
                        return abort(403);
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
            
                    return back()->with('success', '1 '.$finalData['level'].' telah ditambahkan');
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


        public function editDataPetugas(Request $request, $id){
            try{
                if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
                    $request->validate([
                        'username' => 'required',
                        'nama' => 'required',
                        'level' => 'required',
                    ]);
                    
                    if($request->level != 'Admin' && $request->level != 'Petugas'){
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
            
                    return back()->with('success', '1 Data telah diubah');

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


        public function deleteDataPetugas($id){
            try{
                if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
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
                            return back()->with('success', '1 Data '.$getData['level'].' telah dihapus');
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


        public function searchDataPetugas($val){
            try{
                if(Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level == 'admin'){
                    try{
                        $data = Petugas::where('username', 'like', $val.'%')->orWhere('nama_petugas','like',$val.'%')->paginate(10);
                    }catch(Exception){
                        return abort(500);
                    }
    
                    $getView = view('dashboard.datapetugas.search', [
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
