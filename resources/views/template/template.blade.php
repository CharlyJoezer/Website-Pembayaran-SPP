<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/css/dashboard.css">
    @if(isset($css))
    <link rel="stylesheet" href="/css/{{ $css }}.css">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
</head>
<body>

    <div class="navbar">
        <div class="navbar-header">
            <img src="/asset/logo-sekolah.png" alt="">
            <div class="text-header">
                <h4>SMK Airlangga Balikpapan</h4>
                <div style="font-size:11px;">Pembayaran SPP Online</div>
            </div>
        </div>

        <div class="navbar-item">
            <div class="auth-user">
                <span style="margin-right: 15px;font-size:14px;">
                    @if(Auth::guard('petugas')->check())
                        <span style="font-weight:500;">{{ auth()->guard('petugas')->user()->nama_petugas }}</span>
                        <div style="font-size:10px;color:#aaa;">Level : {{ auth()->guard('petugas')->user()->level }}</div>
                    @elseif(Auth::guard('siswa')->check())
                        {{ auth()->guard('siswa')->user()->nama }}
                        <div style="font-size:10px;color:#aaa;">Siswa</div>
                    @endif
                </span>
                <a href="/logout" title="Logout" style="font-size:14px;color:red;"><i class="fa-solid fa-right-from-bracket"></i></a>
                
            </div>
        </div>
    </div>

    <div class="sidebar">
        <div class="sidebar-top">
            @if(Auth::guard('petugas')->check())
                <img src="https://img.freepik.com/free-vector/illustration-businessman_53876-5856.jpg?w=740&t=st=1679310834~exp=1679311434~hmac=94071d701abdc8e5bcc3528214656f999c0f7b05ea25f3e1b59bbdefffd9b453">
                <div class="auth-user-biodata" style="padding-left: 8px;">
                    <div style="font-size:14px;font-weight:600;">{{ auth()->guard('petugas')->user()->nama_petugas }}</div>
                    <div style="font-size:10px;color:#555;">
                        Level : {{ auth()->guard('petugas')->user()->level }}
                    </div>
                </div>
            @elseif(Auth::guard('siswa')->check())
                <div class="auth-user-biodata">
                    <div>{{ auth()->guard('siswa')->user()->nama }}</div>
                    <div style="font-size:10px;color:#aaa;">Siswa</div>
                </div>
            @endif
        </div>
        <div class="sidebar-item">
            <a class="sidebar-item-link" href="/" style="@if(Request::is('/')) background-color: #eee; border-left:4px solid rgb(0, 173, 189); @endif">
                <i class="fa-sharp fa-solid fa-house" style="color: #aaa;"></i>
                <span>Dashboard</span>
            </a>
            @if (Auth::guard('siswa')->check())
                
            @elseif(Auth::guard('petugas')->check())
            <a class="sidebar-item-link" href="/dashboard/data-siswa" style="@if(Request::is('dashboard/data-siswa')) background-color: #eee; border-left:4px solid rgb(0, 173, 189); @endif">
                <i class="fa-solid fa-user-large" style="color:rgb(0, 146, 0);"></i>
                <span>Data Siswa</span>
            </a>
            <a class="sidebar-item-link" href="/dashboard/data-petugas" style="@if(Request::is('dashboard/data-petugas')) background-color: #eee; border-left:4px solid rgb(0, 173, 189); @endif">
                <i class="fa-solid fa-user-gear" style="color:rgb(219, 0, 0);"></i>
                <span>Data Petugas</span>
            </a>
            <a class="sidebar-item-link" href="/dashboard/data-kelas" style="@if(Request::is('dashboard/data-kelas')) background-color: #eee; border-left:4px solid rgb(0, 173, 189); @endif">
                <i class="fa-solid fa-school" style="color:rgb(0, 145, 255)"></i>
                <span>Data Kelas</span>
            </a>
            <a class="sidebar-item-link" href="/dashboard/data-spp" style="@if(Request::is('dashboard/data-spp')) background-color: #eee; border-left:4px solid rgb(0, 173, 189); @endif">
                <i class="fa-solid fa-file-invoice-dollar" style="color:orange;"></i>
                <span>Data SPP</span>
            </a>
            @endif
            <a class="sidebar-item-link" href="/dashboard/entry-pembayaran-spp" @if(Request::is('dashboard/entry-pembayaran-spp')) style="background-color: #eee; border-left:4px solid rgb(0, 173, 189);" @endif>
                <i class="fa-solid fa-money-bills" style="color:rgb(96, 240, 0);"></i>
                <span>Entry Pembayaran</span>
            </a>
            <a class="sidebar-item-link" href="" @if(Request::is('dashboard/history-pembayaran-spp')) style="background-color: #eee; border-left:4px solid rgb(0, 173, 189);" @endif>
                <i class="fa-solid fa-file-lines" style="color:#555;"></i>
                <span>Riwayat Pembayaran</span>
            </a>
        </div>

    </div>


    {{-- POPUP IF FAIL --}}
    <div class="notif" style="@if(session()->has('fail')) background-color:red;  @endif display:flex;align-items:center;">
        @if (session()->has('success'))
            <div><i class="fa-solid fa-circle-check" style="font-size:20px;margin-right:10px;"></i></div>
            <div>{{ session('success') }}</div>
        @else
            <div><i class="fa-solid fa-triangle-exclamation" style="font-size:20px;margin-right:10px;"></i></div>
            <div>{{ session('fail') }}</div>
        @endif
    </div>

    
    <div class="content">
        @yield('content')
        {{-- <div class="copyright">Copyright &#169; Smk Airlangga Balikpapan 2023</div> --}}
    </div>
    
    <script src="/js/dashboard.js"></script>
    @if (session()->has('fail') || session()->has('success'))
        <script>showNotif()</script>
    @endif
</body>
</html>