<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    public function viewLogin(){
        return view('auth.login',[
            'title' => 'Masuk',
            'css' => "login"
        ]);
    }


    public function authLogin(Request $request)
    {   
        try{
            if($request->as == 'siswa'){
                $data = $request->validate([
                    'username_siswa' => 'required',
                    'password_siswa' => 'required',
                ]);
                if(Auth::guard('siswa')->attempt(['nama' => $request->username_siswa, 'password' => $request->password_siswa])){
                    $request->session()->regenerate();
                    return redirect('/');
                }
                return back()->with('siswa_fail', 'Nama atau Password salah!');
            }elseif($request->as == 'petugas'){
                $data = $request->validate([
                    'username_petugas' => 'required',
                    'password_petugas' => 'required',
                ]);
                if(Auth::guard('petugas')->attempt(['username' => $request->username_petugas, 'password' => $request->password_petugas])){
                    $request->session()->regenerate();
                    return redirect('/');
                }
                return back()->with('petugas_fail', 'Username atau Password salah!');
            }else{
                return back();
            }
        }catch(Exception){
            return abort(500);
        }

    }


    public function logout(Request $request){
        if(auth::guard('petugas')->check()){
            Auth::guard('petugas')->logout();
        }
        Auth::guard('siswa')->logout();
        Auth::guard('petugas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');        
    }
}
