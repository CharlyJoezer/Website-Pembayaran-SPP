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
            'title' => 'Beranda | Dashboard',
            'siswa' => count(User::all()),
            'kelas' => count(Kelas::all()),
            'spp' => count(Spp::all()),
            'pembayaran' => count(Pembayaran::all())
        ]);
    }

}
