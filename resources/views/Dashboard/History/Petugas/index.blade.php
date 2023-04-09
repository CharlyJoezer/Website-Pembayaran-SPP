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


    @if (Auth::guard('siswa')->check())
        
    @elseif(Auth::guard('petugas')->check())
        <div class="search-siswa">
            {{-- <div class="text-header"">Cek Riwayat Pembayaran</div> --}}
            <div class="input-search-data">
                <input type="text" name="value" placeholder="Cari Siswa...." id="input-search">
                <div class="button-search" id="button-search">Cari Siswa</div>
            </div>
            <div class="info-key-search">
                <ul>
                    <li>Cari berdasarkan <b>NISN</b></li>
                    <li>Cari berdasarkan <b>NIS</b></li>
                    <li>Cari berdasarkan <b>Nama Siswa</b></li>
                </ul>
            </div>
        </div>


        <div class="wrapper-tabel-data-siswa">
            <table border="1" cellpadding="5">
                <thead>
                    <th>NISN</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Action</th>
                </thead>
                <tbody id="data-table">
                    <tr>
                        <td colspan="5" style="padding: 20px;" id="default-text-table">Belum ada Data yang dicari</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    // FITUR SEARCH
    $('#button-search').click(function(){
        const getSearch = $('#input-search').val()
        if(getSearch.trim() === ""){
            return false;
        }
        fetch(`/dashboard/history-pembayaran/search/${getSearch}`)
        .then(response => response.json())
        .then(data => {
            if(data.status == 'true'){
                $('#data-table').html(data.data)
            }
            if(data.status == 'false'){
                $('#data-table').html(`
                <tr>
                    <td colspan="5" style="padding: 20px;" id="default-text-table" style="color:red;">`+data.message+`</td>
                </tr>
                `)

            }
        })
        .catch(error => {
            return false;
        })
        })
        
        $('#input-search').on('keydown', function(event){
        if (event.keyCode === 13) {
            $('#button-search').trigger('click')
        }
    });
</script>
@endsection