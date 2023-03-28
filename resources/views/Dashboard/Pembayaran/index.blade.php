@extends('Template.template')
@section('content')


<div class="wrapper-all">
    <div class="header" style="padding:5px 1px;">
        <div style="font-size:16px;font-weight:500;color:#555;display:flex;align-items:flex-end;">
            <i class="fa-solid fa-money-bills" style="color:rgb(0, 173, 189);font-size:20px;"></i>
            <span style="font-size:17px;padding-left: 5px;">Entry Pembayaran Spp</span>
        </div>
    </div>
    <div style="background-color:rgb(0, 173, 189) ;height:3px;margin:5px 0px;border-radius:3px;"></div>
        
    
    <div class="feature">
        <div style="display:flex;">
            <div class="button-filter-data" id="filter-data">
                <i class="fa-solid fa-filter"></i>
                <span>Filter Data</span>
            </div>
            <div class="button-add-data" id="add-data">
                <i class="fa-solid fa-square-plus"></i>
                <span>Tambah Pembayaran</span>
            </div>
        </div>
        <div class="button-search-data">
            <input id="input-search" type="text" placeholder="Cari Data...">
            <span id="button-search"><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
    </div>
    
    
    {{-- TABEL Entry Pembayaran --}}
    <div class="wrapper-tabel-data-eps">
        <table border="1" cellpadding="5">
            <thead>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>SPP Tahun</th>
                <th>Nominal</th>
                <th>Pembayaran Terakhir</th>
                <th>Action</th>
            </thead>
            <tbody id="data-table">
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kelas->nama_kelas.'-'.$item->kelas->kompetensi_keahlian }}</td>
                    <td>{{ $item->spp->tahun }}</td>
                    <td>Rp. {{ number_format($item->spp->nominal,0,'.','.') }}</td>
                    <td>
                        @if ( $getMonth($item) != null )
                        <span style="font-weight:bold;">{{ $getMonth($item) }}</span>
                        @else
                        <span>Belum ada Pembayaran</span>
                        @endif
                    </td>
                    <td>
                        <a href="entry-pembayaran-spp/history/{{ $item->nisn }}" class="button-history">History</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
    <div class="wrapper-popup">
        <div class="popup-add-data" attr-mode="">
            <div class="add-data-header">
                <span><i class="fa-solid fa-people-group"></i> <span id="text-header-popup">Entry Pembayaran SPP</span></span>
                <span class="close-form">&#9587;</span>
            </div>
            <form action="entry-pembayaran-spp/create" class="form-input-data-eps" method="POST">
                @csrf
                <div class="table-form">
                    <table>
                        <tr class="box-input">
                            <td>NISN</td>
                            <td>:</td>
                            <td>
                                <input id="input-nisn" required placeholder="NISN" name="nisn" type="number" style="@error('nisn') border-color:red; @enderror" value="{{ old('nisn') }}">
                                <div style="font-size:10px;color:red;" id="info-nisn"></div>
                                @error('nisn')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Tahun SPP</td>
                            <td>:</td>
                            <td>
                                <select required name="tahun_spp" id="">
                                    <option value="" disabled selected>Pilih Tahun SPP</option>
                                    @foreach ($spp as $item)
                                        <option value="{{ $item->id_spp }}">{{ $item->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('tahun_spp')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Bulan dibayar</td>
                            <td>:</td>
                            <td style="vertical-align: middle;">
                                <div class="wrapper-bulan" style="display:flex;flex-wrap:wrap;flex-direction:column;">
                                </div>

                                <div style="font-size:10px;" id="info-select-bulan">*Masukkan NISN lebih dahulu</div>
                                @error('bulan_spp')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Tanggal bayar</td>
                            <td>:</td>
                            <td>
                                <input id="input-tanggal" required type="date"  name="tanggal" style="@error('tanggal') border-color:red; @enderror" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Jumlah dibayar</td>
                            <td>:</td>
                            <td>
                                <input id="input-jumlah-dibayar" required type="text" placeholder="Jumlah dibayar" name="jumlah" style="@error('jumlah') border-color:red; @enderror" value="{{ old('jumlah') }}">
                                @error('jumlah')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="button-form">
                    <button class="cancel-form">Batalkan</button>
                    <button class="save-form" style="background-color:#999;color:white;cursor:no-drop;" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="pagination">
    <div class="wrapper-button-pagination">
        <a class="previous-page"
        @if ($data->previousPageUrl() == null)
        style="color:ccc;cursor:no-drop;"
        @else
        href="{{ $data->previousPageUrl() }}"
        @endif>&#10094;</a>

        <div class="page-now">{{ $data->currentPage() }}</div>

        <a class="next-page"
        @if ($data->nextPageUrl() == null)
        style="color:#ccc;cursor:no-drop;"
        @else
        href="{{ $data->nextPageUrl() }}"
        @endif>&#10095;</a>
    </div>
    <div class="info-pagination" style="text-align:center;font-size:12px;">
        <div>Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }} </div>
        <div style="font-size:11px;color:#888;">Total data : {{ $data->total() }}</div>
    </div>
</div>

<script src="/js/entry_pembayaran.js"></script>
<script>
    $('#input-nisn').focus(function(){
        $('#input-nisn').off('keyup')
        
        $('#input-nisn').keyup(function(){
            $('#input-nisn').off('blur')
            
            $('#input-nisn').blur(function(){
                $('#input-nisn').off('blur')
                const getValue = $('#input-nisn').val()
                if(/^\d+$/.test(getValue) == false){
                    $('#info-nisn').html('Input wajib berisi angka!')
                    return false;
                }
                $('.save-form').attr('type','submit')
                $('.save-form').removeAttr('disabled')
                $('.save-form').css({
                    'background-color' :' rgb(0, 219, 73)',
                    'cursor':'pointer',
                    'color': 'white'
                })
                $('.wrapper-bulan').html(``)
                fetch(`/dashboard/data-entry-pembayaran/fetch/month/${getValue}`)
                .then(response => response.json())
                .then(data => {
                    if(data.status == 'true'){
                        $('#info-nisn').html('')
                        const allMonth = [
                            'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        ];
                        for(i = 0; i < 12; i++){
                            if(data.month[allMonth[i]] != undefined){
                                $('.wrapper-bulan').append(`
                                    <div style="display:flex;align-items:center;border:1px solid #aaa; padding:5px;width:fit-content;margin-bottom:3px;margin-right:4px;border-radius:3px;">
                                        <input type="checkbox" value="`+allMonth[i]+`" name="`+allMonth[i]+`" style="width:12px;margin:0px;margin-right:5px;">
                                        <div style="font-size:12px;">`+allMonth[i]+`</div>
                                    </div>
                                `)
                            }
                        }
                    }
                    else if(data.status == 'false'){
                        $('#info-nisn').html(data.message)
                        $('.save-form').attr('disabled', 'disabled')
                        $('.save-form').css({
                            'background-color' :'#999',
                            'cursor':'no-drop',
                            'color': 'white'
                        })
                    }
                })
                .catch(error => {
                    return false;
                })
            })


        })
    })




    
</script>
@endsection