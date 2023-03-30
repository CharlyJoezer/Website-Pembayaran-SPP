@extends('Template.template')
@section('content')
    
<div class="wrapper-all">
    <div class="header" style="padding:5px 1px;">
        <div style="font-size:18px;font-weight:500;color:#555;display:flex;align-items:center;">
            <i class="fa-solid fa-file-lines" style="color:rgb(0, 173, 189);font-size:28px;"></i>
            <div style="font-size:17px;padding-left: 7px;">
                <div>Riwayat Pembayaran</div>
                <div style="font-size:10px;padding-left:1px;">Smk Airlangga Balikpapan</div>
            </div>
        </div>
    </div>
    <div style="background-color:rgb(0, 173, 189) ;height:3px;margin:5px 0px;border-radius:3px;"></div>


    <div class="detail-header">
        <div class="nisn">NISN : {{ $data->nisn }}</div>
    </div>
    
    <div class="wrapper-data-siswa-and-history">
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
        <div class="wrapper-list-history-pembayaran">
            <div style="font-weight: 600;margin-bottom:15px;border-bottom: 2px solid #aaa;padding-bottom: 10px;">
                <i class="fa-solid fa-list"></i> 
                <span>List Riwayat Pembayaran</span>
            </div>
            @foreach ($history as $item)
            <div class="box-history-pembayaran">
                <div class="left">
                    <div style="margin-bottom: 5px;">
                        <div style="font-weight: 600;">
                            <i class="fa-solid fa-receipt"></i> Riwayat Pembayaran
                        </div>
                        <div style="font-weight: 600;color:#555;font-size:10px;padding-left:15px;">
                            by : {{ $item->petugas->nama_petugas }}
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td>NISN</td>
                            <td>:</td>
                            <td>{{ $data->nisn }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $data->nama }}</td>
                        </tr>
                        <tr>
                            <td>Tahun SPP</td>
                            <td>:</td>
                            <td>{{ $item->spp->tahun }}</td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td>:</td>
                            <td>{{ $item->bulan_dibayar }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Pembayaran</td>
                            <td>:</td>
                            <td style="color:green;font-weight:600;">Rp. {{ number_format($item->jumlah_bayar,0,'.','.') }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal dibayar</td>
                            <td>:</td>
                            <td>{{ str_replace('-',' ', date('d-F-Y', strtotime($item->tgl_dibayar))) }}</td>
                        </tr>
                    </table>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
</div>






@endsection