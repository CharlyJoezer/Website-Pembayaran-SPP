@extends('Template.template')
@section('content')
    
<div class="header">
    <div style="font-size:16px;font-weight:500;color:#555;">Data Kelas &rarr; Detail &rarr; {{ $data->nama_kelas.'-'.$data->kompetensi_keahlian }}</div>
    <div style="background-color:#aaa;height:3px;margin:5px 0px;border-radius:3px;"></div>
</div>

<div class="detail-header">
    <div class="petugas"><i class="fa-solid fa-people-roof"></i> {{ $data->nama_kelas.'-'.$data->kompetensi_keahlian }}</div>
</div>
<div class="data-kelas">
    <div class="detail-wrapper-data-kelas">
        <div class="detail-data-kelas-left">
            <img src="https://cdn.medcom.id/images/content/2022/11/26/1507127/ruBcG4Ym5Z.png" alt="">
        </div>
        <div class="detail-data-kelas-right">
            <div class="biodata-kelas">
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ $data->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td>:</td>
                        <td>{{ $data->kompetensi_keahlian }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Siswa</td>
                        <td>:</td>
                        <td>{{ count($data->user) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    {{-- TABEL SISWA --}}
    <div class="wrapper-tabel-data-siswa">
        <table border="1" cellpadding="5">
            <thead>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>NIS</th>
            </thead>
            <tbody id="data-table">
                @foreach ($data->user as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nis }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>








<div class="detail-back-button">
    <a onclick="history.back()" ><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

@endsection