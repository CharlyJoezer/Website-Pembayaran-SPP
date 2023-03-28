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
            <img style="box-shadow:0 0 5px #aaa;border-radius:5px;" src="https://images.all-free-download.com/images/graphicwebp/student_graduation_background_boy_education_design_elements_icons_6837816.webp" alt="">
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
        <a onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>



@endsection