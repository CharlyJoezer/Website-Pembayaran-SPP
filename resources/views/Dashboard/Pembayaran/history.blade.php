@extends('Template.template')
@section('content')
    
<div class="header">
    <div style="font-size:16px;font-weight:500;color:#555;">History Pembayaran &rarr; {{ $siswa->nama }}</div>
    <div style="background-color:#aaa;height:3px;margin:5px 0px;border-radius:3px;"></div>
</div>

<div class="detail-header">
    <div class="nisn">NISN : {{ $siswa->nisn }}</div>
</div>

<div class="wrapper-data-siswa-and-history">
    <div class="detail-wrapper-data-siswa">
        <div class="detail-data-siswa-left">
            <img src="/storage/image/{{ $siswa->foto }}" alt="">
        </div>
        <div class="detail-data-siswa-right">
            <div class="biodata-siswa">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ $siswa->kelas->nama_kelas.'-'.$siswa->kelas->kompetensi_keahlian }}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td>{{ $siswa->nisn }}</td>
                    </tr>
                    <tr>
                        <td>NIS</td>
                        <td>:</td>
                        <td>{{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $siswa->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="wrapper-list-history-pembayaran">
        <div style="font-weight: 600;margin-bottom:15px;border-bottom: 2px solid #aaa;padding-bottom:5px;"><i class="fa-solid fa-list"></i> List Riwayat Pembayaran</div>
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
                        <td>{{ $siswa->nisn }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $siswa->nama }}</td>
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
            
            <div class="right">
                <div class="button-delete-history-pembayaran" attr-id="{{ $item->id_pembayaran }}">
                    <i class="fa-solid fa-trash-can"></i> 
                    <span>Hapus</span>
                </div>
            </div>
            
        </div>
        @endforeach
    </div>
</div>


<div class="wrapper-popup2">
    <div class="popup-delete-data">
        <div class="popup-delete-header">
            <span>Hapus History Pembayaran</span>
            <span class="close-delete">&#9587;</span>
        </div>
        <div class="content-popup-delete">
            Anda yakin akan menghapus Entry Pembayaran ini ?
        </div>
        <div class="button-confirm-delete">
            <a id="confirm-delete-button" href="">Hapus</a>
            <a class="cancel-delete">Batalkan</a>
        </div>
    </div>
</div>

<script>
$(document).on('click','.button-delete-history-pembayaran',function(){
    console.log('test');
    $('#confirm-delete-button').attr('href', '/dashboard/data-history-pembayaran/delete/'+$(this).attr('attr-id'))
    $('.wrapper-popup2').toggleClass('display')
    setTimeout(() => {
        $('.popup-delete-data').toggleClass('down')
    }, 0);
    const deleteURL = '/dashboard/data-history-pembayaran/delete/'+$(this).attr('attr-id')
    $(document).on('keydown', function(event){
        if (event.keyCode === 13) {
            window.location = deleteURL
            $(this).off('keydown')
        }
    });
})

$('.wrapper-popup2, .close-delete, .cancel-delete').click(function(){
    $('.popup-delete-data').toggleClass('down')
    $('.wrapper-popup2').toggleClass('display')
})
$('.popup-delete-data').click(function(event){
        event.stopPropagation();
})
</script>
@endsection