@extends('template.template')
@section('content')

<div class="big-panel">
    <div class="main-text">
        <div style="font-size:20px;font-weight:600;color:#333;">Selamat Datang di Website Pembayaran SPP </div>
        <div style="font-size:14px;margin-bottom:10px;">Smk Airlangga Balikpapan</div>
        <div class="card-user-login">
            <div class="navbar-header" style="border-bottom: 1px solid #ccc;">
                <img src="/asset/logo-sekolah.png" alt="">
                <div class="text-header">
                    <h4>SMK Airlangga Balikpapan</h4>
                    <div style="font-size:11px;">Pembayaran SPP Online</div>
                </div>
            </div>

            <div style="margin-bottom:13px;">
                <table class="table-biodat-auth">
                    <tr>
                        <td style="font-weight:bold;">Nama</td>
                        <td>:</td>
                        
                        <td>
                            @if(Auth::guard('petugas')->check())
                                <span style="text-transform:capitalize;">{{ Auth::guard('petugas')->user()->nama_petugas }}</span>
                            @elseif(Auth::guard('siswa')->check())
                                <span style="text-transform:capitalize;">{{ Auth::guard('siswa')->user()->nama }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Status</td>
                        <td>:</td>
                        
                        <td>
                            @if(Auth::guard('petugas')->check())
                                <span style="text-transform:capitalize;">{{ Auth::guard('petugas')->user()->level }}</span>
                            @elseif(Auth::guard('siswa')->check())
                                <span style="text-transform:capitalize;">Siswa</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="info-all-data" style="display:flex;flex-wrap:wrap;">
                <div class="box-info-dashboard" style="background-image:linear-gradient(to left top,rgb(0, 187, 255) 5%,rgb(0, 128, 175) 95%);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-user-large"></i> Jumlah Siswa</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $siswa }} Siswa</div>
                </div>
                <div class="box-info-dashboard" style="background-image:linear-gradient(to left top,rgba(0, 218, 211, 0.856) 5%,rgb(0, 175, 169) 95%);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-file-invoice-dollar"></i> Data SPP</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $spp }} Spp</div>
                </div>
                <div class="box-info-dashboard" style="background-image:linear-gradient(to left top,rgb(0, 132, 241) 5%,rgb(0, 96, 175) 95%);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-school"></i> Data Kelas</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $kelas }} Kelas</div>
                </div>
                <div class="box-info-dashboard" style="background-image:linear-gradient(to left top,rgb(0, 202, 224) 5%,rgb(0, 157, 175) 95%);">
                    <div style="font-weight:bold;"><i class="fa-solid fa-money-bills"></i> Data Pembayaran</div>
                    <div style="padding-top:15px;font-size:14px;">{{ $pembayaran }} Pembayaran</div>
                </div>
            </div>
        </div>


    </div>

    

</div>
    
@endsection