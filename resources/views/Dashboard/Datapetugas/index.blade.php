@extends('Template.template')
@section('content')
    
<div class="wrapper-all">
    <div class="header" style="padding:5px 1px;">
        <div style="font-size:16px;font-weight:500;color:#555;display:flex;align-items:flex-end;">
            <i class="fa-solid fa-user-gear" style="color:rgb(0, 173, 189);font-size:20px;"></i>
            <span style="font-size:17px;padding-left: 5px;">Data Petugas</span>
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
                <span>Tambah Data</span>
            </div>
        </div>
        <div class="button-search-data">
            <input id="input-search" type="text" placeholder="Cari Petugas...">
            <span id="button-search"><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
    </div>


    {{-- TABEL PETUGAS --}}
    <div class="wrapper-tabel-data-petugas">
        <table border="1" cellpadding="5">
            <thead>
                <th>Username</th>
                <th>Nama Petugas</th>
                <th>Level</th>
                <th>Action</th>
            </thead>
            <tbody id="data-table">
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->nama_petugas }}</td>
                    <td>{{ $item->level }}</td>
                    <td>
                        <div class="wrapper-action">
                            <a href="/dashboard/data-petugas/detail/{{ $item->id_petugas }}">
                                <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
                            </a>
                            <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
                            <i title="Delete" attr-id="{{ $item->id_petugas }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

   
    <div class="wrapper-popup">
        <div class="popup-add-data" attr-mode="">
            <form action="data-petugas/create" class="form-input-data-petugas" method="POST">
                @csrf
                <div class="add-data-header">
                    <span><i class="fa-solid fa-people-group"></i> <span id="text-header-popup">Form Data petugas</span></span>
                    <span class="close-form">&#9587;</span>
                </div>
                <div class="table-form">
                    <table>
                        <tr class="box-input">
                            <td>Username</td>
                            <td>:</td>
                            <td>
                                <input id="input-username" required type="text" placeholder="Username" name="username" style="@error('username') border-color:red; @enderror" value="{{ old('username') }}">
                                @error('username')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Nama Petugas</td>
                            <td>:</td>
                            <td>
                                <input id="input-nama" required type="text" placeholder="Nama Petugas" name="nama" style="@error('nama') border-color:red; @enderror" value="{{ old('nama') }}">
                                @error('nama')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input box-input-password">
                            <td>Password</td>
                            <td>:</td>
                            <td>
                                <input id="input-password" required type="password" placeholder="Password Petugas" name="password" style="@error('password') border-color:red; @enderror">
                                @error('password')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Level</td>
                            <td>:</td>
                            <td>
                                <select required name="level" style="@error('level') border-color:red; @enderror">
                                    <option value="" selected disabled style="color:#ccc;">Pilih Level</option>
                                    <option id="level-petugas" value="petugas">Petugas</option>
                                    <option id="level-admin" value="admin">Admin</option>
                                </select>
                                @error('level')
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
                <span>Hapus Data Siswa</span>
                <span class="close-delete">&#9587;</span>
            </div>
            <div class="content-popup-delete">
                Anda yakin akan menghapus data siswa ini ?
            </div>
            <div class="button-confirm-delete">
                <a id="confirm-delete-button">Hapus</a>
                <a class="cancel-delete">Batalkan</a>
            </div>
        </div>
    </div>
    
    <div class="pagination">
        <div class="wrapper-button-pagination">
            <a class="previous-page"
            @if ($data->previousPageUrl() == null)
            style="color:#ccc;cursor:no-drop;"
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
</div>


<script src="/js/datapetugas.js"></script>
    
@if($errors->any())
    <script>$('#add-data').trigger('click')</script>
@endif

@endsection