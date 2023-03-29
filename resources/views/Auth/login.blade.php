<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/css/{{ $css }}.css">
    <link rel="stylesheet" href="<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
</head>
<body>

    <div class="containers">
        <div class="box-login">
            <div class="login-header" style="padding-bottom: 12px;margin-bottom: 15px;border-bottom:1px solid #ccc;">
                <img src="/asset/logo-sekolah.png" alt="">
                <div class="login-header-text">
                    <div>SMK Airlangga Balikpapan</div>
                    <div style="font-size:12px;padding-top:4px;padding-left:1px;">Pembayaran SPP Online SMK Airlangga Balikpapan</div>
                </div>
            </div>

            @if(session()->has('fail'))
            <div style="color:red;padding:5px;text-align:center;">{{ session('fail') }}</div>
            @endif
            

            <div class="login-form">
                <form action="/login/auth" class="form-login" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" required name="username_siswa" class="form-control" id="siswa" placeholder="name@example.com">
                        <label for="siswa">Nama Siswa</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" required name="password_siswa" class="form-control" id="nis" placeholder="Password">
                        <label for="nis">Password</label>
                        <div style="color:white;font-style:italic;font-size:12px;">*password diisi dengan nis + nisn siswa</div>
                    </div>
                    <input type="hidden" name="as" value="siswa">
                    <div style="display:flex;">
                    </div>
                    <button class="btn btn-primary mt-3 w-100" style="height: 50px;">Masuk Siswa</button>
                </form>
            </div>
            <div style="font-size:14px;color:#ccc;text-align:center;margin-top:5px;">Masuk sebagai, <a class="move" id="btn-change" attr-user="petugas" style="cursor:pointer;color:rgb(57, 202, 255);">Petugas</a></div>
        </div>
    </div>
    
    <script>
        const loginForm = $('.login-form')
        $('#btn-change').click(function(){
            if($(this).attr('attr-user') == 'petugas'){
                loginForm.html(`
                <form action="/login/auth" class="form-login" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" required name="username_petugas" class="form-control" id="username" placeholder="username">
                            <label for="username">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" required name="password_petugas" class="form-control" id="password" placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <input type="hidden" name="as" value="petugas">
                    <button class="btn btn-primary mt-3 w-100" style="height: 50px;">Masuk Petugas</button>
                </form>
                `)
                $('.move').html(' Siswa')
                $(this).attr('attr-user', 'siswa')
            }else{
                loginForm.html(`
                <form action="/login/auth" class="form-login" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" required name="username_siswa" class="form-control" id="siswa" placeholder="name@example.com">
                            <label for="siswa">Nama Siswa</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" required name="password_siswa" class="form-control" id="nis" placeholder="Password">
                            <label for="nis">Password</label>
                            <div style="color:white;font-style:italic;font-size:12px;">*password diisi dengan nis + nisn siswa</div>
                        </div>
                        <input type="hidden" name="as" value="siswa">
                        <button class="btn btn-primary mt-3 w-100" style="height: 50px;">Masuk Siswa</button>
                </form>
                `)
                $('.move').html(' Petugas')
                $(this).attr('attr-user', 'petugas')
            }
        })
        
    </script>
</body>
</html>