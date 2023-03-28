@extends('template.template')
@section('content')
{{-- 
@if(Auth::guard('petugas')->check())
    <span>Anda Masuk sebagai, <b>Petugas</b></span>
@elseif(Auth::guard('siswa')->check())
    <span>Anda Masuk sebagai, <b>Siswa</b></span>
@endif --}}



<div class="big-panel">
    <div class="main-text">
        <div style="font-size:25px;font-weight:600;color:#333;">Selamat Datang di Website Pembayaran Spp </div>
        <div style="font-size:12px;">Smk Airlangga Balikpapan</div>
        <div style="background-color:rgb(0, 173, 189) ;height:3px;margin:5px 0px;border-radius:3px;margin-bottom:15px;"></div>
        <div class="card-user-login">
            <div class="navbar-header">
                <img src="/asset/logo-sekolah.png" alt="">
                <div class="text-header">
                    <h4>SMK Airlangga Balikpapan</h4>
                    <div style="font-size:11px;">Pembayaran SPP Online</div>
                </div>
            </div>

            <div>
                <table class="table-biodat-auth">
                    <tr>
                        <td style="font-weight:bold;">Nama</td>
                        <td>:</td>
                        
                        <td>
                            @if(Auth::guard('petugas')->check())
                                <span>{{ Auth::guard('petugas')->user()->nama_petugas }}</span>
                            @elseif(Auth::guard('siswa')->check())
                                <span>{{ Auth::guard('siswa')->user()->nama }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Status</td>
                        <td>:</td>
                        
                        <td>
                            @if(Auth::guard('petugas')->check())
                                <span>{{ Auth::guard('petugas')->user()->level }}</span>
                            @elseif(Auth::guard('siswa')->check())
                                <span>{{ Auth::guard('siswa')->user()->nama }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="info-all-data" style="display:flex;flex-wrap:wrap;">
                <div class="box-info-dashboard" style="background-color:rgb(0, 128, 175);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-user-large"></i> Jumlah Siswa</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $siswa }} Siswa</div>
                </div>
                <div class="box-info-dashboard" style="background-color:rgb(0, 175, 169);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-file-invoice-dollar"></i> Data SPP</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $spp }} Spp</div>
                </div>
                <div class="box-info-dashboard" style="background-color:rgb(0, 96, 175);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-school"></i> Data Kelas</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $kelas }} Kelas</div>
                </div>
                <div class="box-info-dashboard" style="background-color:rgb(0, 157, 175);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-money-bills"></i> Data Pembayaran</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $pembayaran }} Pembayaran</div>
                </div>
            </div>
        </div>


    </div>

    

</div>
    
@endsection