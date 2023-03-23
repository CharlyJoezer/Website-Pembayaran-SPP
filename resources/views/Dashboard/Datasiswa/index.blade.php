@extends('template.template')
@section('content')

<div class="wrapper-all" style="">
    <div class="header" style="padding:5px 1px;">
        <div style="font-size:16px;font-weight:500;color:#555;display:flex;align-items:flex-end;">
            <i class="fa-solid fa-user-large" style="color:rgb(0, 173, 189);font-size:20px;"></i>
            <span style="font-size:17px;padding-left: 5px;">Data Siswa</span>
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
            <input id="input-search" type="text" placeholder="Cari Siswa...">
            <span id="button-search"><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
    </div>

    <div class="wrapper-tabel-data-siswa">
        <table border="1" cellpadding="5">
            <thead>
                <th>NISN</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Action</th>
            </thead>
            <tbody id="data-table">
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kelas->nama_kelas.'-'.$item->kelas->kompetensi_keahlian }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>
                        <div class="wrapper-action">
                            <a href="/dashboard/data-siswa/detail/{{ $item->nisn }}">
                                <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
                            </a>
                            <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
                            <i title="Delete" attr-nisn="{{ $item->nisn }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="wrapper-popup">
        <div class="popup-add-data" attr-mode="">
            <form action="data-siswa/create" class="form-input-data-siswa" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="add-data-header">
                    <span><i class="fa-solid fa-people-group"></i> <span id="text-header-popup">Form Data Siswa</span></span>
                    <span class="close-form">&#9587;</span>
                </div>
                <div class="table-form">
                    <table>
                        <tr class="box-input">
                            <td>NIS</td>
                            <td>:</td>
                            <td>
                                <input id="input-nis" required type="number" placeholder="NIS" name="nis" style="@error('nis') border-color:red; @enderror" value="{{ old('nis') }}">
                                @error('nis')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>NISN</td>
                            <td>:</td>
                            <td>
                                <input id="input-nisn" required type="number" placeholder="NISN" name="nisn" style="@error('nisn') border-color:red; @enderror" value="{{ old('nisn') }}">
                                @error('nisn')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Nama Siswa</td>
                            <td>:</td>
                            <td>
                                <input id="input-nama" required type="text" name="nama" placeholder="Nama Lengkap" style="@error('nama') border-color:red; @enderror" value="{{ old('nama') }}">
                                @error('nama')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Kelas</td>
                            <td>:</td>
                            <td>
                                <select required name="kelas" style="@error('kelas') border-color:red; @enderror">
                                    <option value="" selected style="color:#ccc;">Pilih Kelas-Jurusan</option>
                                    @foreach ($kelas as $item)
                                    <option id="kelas{{ $item->id_kelas }}" value="{{ $item->id_kelas }}" {{ old('kelas') == $item->id_kelas ? 'selected' : '' }}>{{ $item->nama_kelas.'-'.$item->kompetensi_keahlian }}</option>
                                    @endforeach
                                </select>
                                @error('kelas')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>No. Telepon</td>
                            <td>:</td>
                            <td>
                                <input id="input-telepon" required type="number" name="telp" placeholder="Nomor Telepon" style="@error('telp') border-color:red; @enderror" value="{{ old('telp') }}">
                                @error('telp')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Alamat</td>
                            <td>:</td>
                            <td>
                                <textarea id="input-alamat" name="alamat" placeholder="Alamat Siswa" rows="5" style="@error('alamat') border-color:red; @enderror" value="{{ old('alamat') }}"></textarea>
                                @error('alamat')
                                    <div style="font-size:10px;color:red;font-style:italic;">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="box-input">
                            <td>Foto Siswa</td>
                            <td>:</td>
                            <td class="box-input-file">
                                <img id="preview-image" src="" alt="" width="50%" height="200" style="display:none;margin-bottom: 5px;object-fit:cover;">
                                <input id="input-image" required type="file" accept="image/*" name="image" style="@error('image') border-color:red; @enderror">
                                <small style="font-size:12px;color:grey;display:none;"><i>*kosongkan jika tidak mengubah gambar</i></small>
                                @error('image')
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
</div>


<script src="/js/datasiswa.js"></script>

@if($errors->any())
<script>$('#add-data').trigger('click')</script>
@endif

@endsection