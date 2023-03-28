<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
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
}
