<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/css/dashboard.css">
    @if(isset($css))
    <link rel="stylesheet" href="/css/ {{ $css }}.css">
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
                <h3>SMK Airlangga Balikpapan</h3>
                <div style="font-size:12px;">Pembayaran SPP Online</div>
            </div>
        </div>

        <div class="navbar-item">
            <div class="auth-user">
                <i class="fa-regular fa-user"></i>
                <span style="margin-right: 5px;">
                    @if(Auth::guard('petugas')->check())
                        {{ auth()->guard('petugas')->user()->username }}
                    @elseif(Auth::guard('siswa')->check())
                        {{ auth()->guard('siswa')->user()->nama }}
                    @endif
                </span>
                <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i></a>
                
            </div>
        </div>
    </div>

    <div class="sidebar">
        <div class="sidebar-search">
            <input type="text" placeholder="Search">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        
        <div class="sidebar-item">
            <a class="sidebar-item-link">
                <i class="fa-sharp fa-solid fa-house" style="color:rgb(0, 204, 255);"></i> Dashboard
            </a>
            <a class="sidebar-item-link">
                <i class="fa-solid fa-coins"></i> Pembayaran Sekolah
            </a>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script src="/js/dashboard.js"></script>
</body>
</html>