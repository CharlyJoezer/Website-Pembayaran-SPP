@extends('Template.template')
@section('content')
    
    <div class="header">
        <div style="font-size:16px;font-weight:500;color:#555;">DataSiswa &rarr; Detail Siswa &rarr; {{ $data->nama }}</div>
        <div style="background-color:#aaa;height:3px;margin:5px 0px;border-radius:3px;"></div>
    </div>

    <div class="detail-header">
        <div class="nisn">NISN : {{ $data->nisn }}</div>
    </div>
    <div class="detail-wrapper-data-siswa">
        <div class="detail-data-siswa-left">
            <img src="/storage/image/{{ $data->foto }}" alt="">
        </div>
        <div class="detail-data-siswa-right">
            <div class="biodata-siswa">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ $data->kelas->nama_kelas.'-'.$data->kelas->kompetensi_keahlian }}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td>{{ $data->nisn }}</td>
                    </tr>
                    <tr>
                        <td>NIS</td>
                        <td>:</td>
                        <td>{{ $data->nis }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $data->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    
    <div class="detail-back-button">
        <a href="/dashboard/data-siswa"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>



@endsection