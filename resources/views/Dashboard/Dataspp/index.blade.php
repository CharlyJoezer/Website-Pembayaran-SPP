@extends('Template.template')
@section('content')
    
<div class="header">
    <div style="font-size:16px;font-weight:500;color:#555;">Data SPP</div>
    <div style="background-color:#aaa;height:3px;margin:5px 0px;border-radius:3px;"></div>
</div>

<div class="feature">
    <div style="display:flex;">
        <div class="button-filter-data" id="filter-data">
            <i class="fa-solid fa-filter"></i>
            <span>Filter Data</span>
        </div>
        <div class="button-add-data" id="add-data">
            <i class="fa-solid fa-square-plus"></i>
            <span>Tambah Data</span>
        </div>
    </div>
    <div class="button-search-data">
        <input id="input-search" type="text" placeholder="Cari Tahun SPP...">
        <span id="button-search"><i class="fa-solid fa-magnifying-glass"></i></span>
    </div>
</div>


{{-- TABEL kelas --}}
<div class="wrapper-tabel-data-spp">
    <table border="1" cellpadding="5">
        <thead>
            <th>Tahun</th>
            <th>Nominal Pembayaran</th>
            <th>Tanggal</th>
            <th>Action</th>
        </thead>
        <tbody id="data-table">
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->tahun }}</td>
                <td>{{ number_format($item->nominal,0,'.','.') }}</td>
                <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                <td>
                    <div class="wrapper-action">
                        {{-- <a href="/dashboard/data-kelas/detail/{{ $item->id_kelas }}">
                            <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
                        </a> --}}
                        <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
                        <i title="Delete" attr-id="{{ $item->id_spp }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div class="wrapper-popup">
    <div class="popup-add-data" attr-mode="">
        <form action="data-spp/create" class="form-input-data-spp" method="POST">
            @csrf
            <div class="add-data-header">
                <span><i class="fa-solid fa-people-group"></i> <span id="text-header-popup">Form Data SPP</span></span>
                <span class="close-form">&#9587;</span>
            </div>
            <div class="table-form">
                <table>
                    <tr class="box-input">
                        <td>Tahun</td>
                        <td>:</td>
                        <td>
                            <input id="input-tahun" required type="number" placeholder="Tahun" name="tahun" style="@error('tahun') border-color:red; @enderror" value="{{ old('tahun') }}">
                            @error('tahun')
                                <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr class="box-input">
                        <td>Nominal</td>
                        <td>:</td>
                        <td>
                            <input id="input-nominal" required type="text" placeholder="Nominal Pembayaran (Rp.xxx.xxx)" style="@error('nominal') border-color:red; @enderror" value="{{ old('nominal') }}">
                            <input id="input-nominal-hidden" type="hidden"  name="nominal" value="{{ old('nominal') }}">
                            @error('nominal')
                                <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </table>
            </div>
            <div class="button-form">
                <button class="cancel-form">Batalkan</button>
                <button class="save-form" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
    
<div class="wrapper-popup2">
    <div class="popup-delete-data">
        <div class="popup-delete-header">
            <span>Hapus SPP</span>
            <span class="close-delete">&#9587;</span>
        </div>
        <div class="content-popup-delete">
            Anda yakin akan menghapus spp ini ?
        </div>
        <div class="button-confirm-delete">
            <a id="confirm-delete-button" href="">Hapus</a>
            <a class="cancel-delete">Batalkan</a>
        </div>
    </div>
</div>


<script src="/js/dataspp.js"></script>
@endsection