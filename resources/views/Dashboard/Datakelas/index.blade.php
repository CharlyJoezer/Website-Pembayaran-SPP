@extends('Template.template')
@section('content')

<div class="header">
    <div style="font-size:16px;font-weight:500;color:#555;">Data Kelas</div>
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
        <input id="input-search" type="text" placeholder="Cari Kelas...">
        <span id="button-search"><i class="fa-solid fa-magnifying-glass"></i></span>
    </div>
</div>


{{-- TABEL kelas --}}
<div class="wrapper-tabel-data-kelas">
    <table border="1" cellpadding="5">
        <thead>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Action</th>
        </thead>
        <tbody id="data-table">
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->nama_kelas }}</td>
                <td>{{ $item->kompetensi_keahlian }}</td>
                <td>
                    <div class="wrapper-action">
                        <a href="/dashboard/data-kelas/detail/{{ $item->id_kelas }}">
                            <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
                        </a>
                        <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
                        <i title="Delete" attr-id="{{ $item->id_kelas }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="wrapper-popup">
    <div class="popup-add-data" attr-mode="">
        <form action="data-kelas/create" class="form-input-data-kelas" method="POST">
            @csrf
            <div class="add-data-header">
                <span><i class="fa-solid fa-people-group"></i> <span id="text-header-popup">Form Data kelas</span></span>
                <span class="close-form">&#9587;</span>
            </div>
            <div class="table-form">
                <table>
                    <tr class="box-input">
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>
                            <input id="input-kelas" required type="text" placeholder="Kelas(X, XI, XII)" name="kelas" style="@error('kelas') border-color:red; @enderror" value="{{ old('kelas') }}">
                            @error('kelas')
                                <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr class="box-input">
                        <td>Jurusan</td>
                        <td>:</td>
                        <td>
                            <input id="input-jurusan" required type="text" placeholder="Jurusan(RPL,MM,TKJ,dll)" name="jurusan" style="@error('jurusan') border-color:red; @enderror" value="{{ old('jurusan') }}">
                            @error('jurusan')
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
            <span>Hapus Kelas</span>
            <span class="close-delete">&#9587;</span>
        </div>
        <div class="content-popup-delete">
            Anda yakin akan menghapus kelas ini ?
        </div>
        <div class="button-confirm-delete">
            <a id="confirm-delete-button">Hapus</a>
            <a class="cancel-delete">Batalkan</a>
        </div>
    </div>
</div>

<script src="/js/datakelas.js"></script>
@endsection