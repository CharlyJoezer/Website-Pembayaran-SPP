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
                <th>Sisa Pembayaran</th>
                <th>Telah dibayar</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody id="data-table">
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kelas->nama_kelas.'-'.$item->kelas->kompetensi_keahlian }}</td>
                    <td>{{ $item->spp->tahun }}</td>
                    <td>{{ number_format($item->spp->nominal,0,'.','.') }}</td>
                    <td style="@if($item->spp->nominal - $getSum($item->pembayaran) > 0) color:red;@else color:green; @endif">
                        Rp. {{  number_format($item->spp->nominal - $getSum($item->pembayaran),0,'.','.') }}
                    </td>
                    <td>Rp. {{ number_format($getSum($item->pembayaran),0,'.','.') }}</td>
                    <td>
                        @if($getSum($item->pembayaran) == $item->spp->nominal)
                        <span style="font-weight:600;color:green;">Lunas</span>
                        @else
                        <span style="font-weight:600;color:red;">Belum Lunas</span>
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
            <form action="entry-pembayaran-spp/create" class="form-input-data-eps" method="POST">
                @csrf
                <div class="add-data-header">
                    <span><i class="fa-solid fa-people-group"></i> <span id="text-header-popup">Entry Pembayaran SPP</span></span>
                    <span class="close-form">&#9587;</span>
                </div>
                <div class="table-form">
                    <table>
                        <tr class="box-input">
                            <td>NISN</td>
                            <td>:</td>
                            <td>
                                <input id="input-nisn" required placeholder="NISN" name="nisn" type="number" style="@error('nisn') border-color:red; @enderror" value="{{ old('nisn') }}">
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
                            <td>
                                <select required name="bulan_spp" id="" style="@error('bulan_spp') border-color:red; @enderror">
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
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
                    <button class="save-form" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="/js/entry_pembayaran.js"></script>
@endsection