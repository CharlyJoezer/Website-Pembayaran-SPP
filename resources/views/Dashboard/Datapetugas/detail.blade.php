@extends('Template.template')
@section('content')

<div class="header">
    <div style="font-size:16px;font-weight:500;color:#555;">Data Petugas &rarr; Detail &rarr; {{ $data->nama_petugas }}</div>
    <div style="background-color:#aaa;height:3px;margin:5px 0px;border-radius:3px;"></div>
</div>

<div class="detail-header">
    <div class="petugas"><i class="fa-solid fa-user-tie" style="margin-right:3px;"></i> @if($data->level == 'admin')  Administrator @else   Petugas @endif</div>
</div>
<div class="detail-wrapper-data-petugas">
    <div class="detail-data-petugas-left">
        <img src="https://img.freepik.com/free-vector/illustration-businessman_53876-5856.jpg?w=740&t=st=1679310834~exp=1679311434~hmac=94071d701abdc8e5bcc3528214656f999c0f7b05ea25f3e1b59bbdefffd9b453" alt="">
    </div>
    <div class="detail-data-petugas-right">
        <div class="biodata-petugas">
            <table>
                <tr>
                    <td>Nama Petugas</td>
                    <td>:</td>
                    <td>{{ $data->nama_petugas }}</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td>{{ $data->username }}</td>
                </tr>
                <tr>
                    <td>Level</td>
                    <td>:</td>
                    <td>{{ $data->level }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="detail-back-button">
    <a onclick="history.back()" ><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>


    
@endsection