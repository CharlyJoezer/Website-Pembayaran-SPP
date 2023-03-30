<!DOCTYPE html>
<html lang="en">
<head>
    <title>Generate Laporan</title>
    <link rel="stylesheet" href="/css/laporan.css">
</head>
<body>

    <div class="wrapper">
        <div class="body-paper">
            <img src="/asset/logo-sekolah.png" width="50">
            <div class="header">SMK AIRLANGGA BALIKPAPAN</div>
            <div class="alamat">Jl. Letjen S. Parman Jl. Gn. Guntur No.14, Gunungsari Ulu, Kec. Balikpapan Tengah, Kota Balikpapan, Kalimantan Timur 76113</div>
            <div style="min-height:2px;background-color:#ccc;width:100%;margin-top: 20px;margin-bottom:20px;"></div>

            <div class="main-title">LAPORAN PEMBAYARAN SPP</div>
            <div class="wrapper-biodata-siswa">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td style="text-transform: capitalize;">{{ $siswa->nama }}</td>
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
                </table>
            </div>


            <div class="wrapper-data-pembayaran">
                <div class="wrapper-tabel-data-eps">
                    <table border="1" cellpadding="5">
                        <thead>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tahun SPP</th>
                            <th>Bulan Dibayar</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </thead>
                        <tbody id="data-table">
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->tgl_dibayar }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->kelas->nama_kelas.'-'.$siswa->kelas->kompetensi_keahlian }}</td>
                                <td>{{ $item->spp->tahun }}</td>
                                <td>{{ $item->bulan_dibayar }}</td>
                                <td>{{ number_format($item->jumlah_bayar,0,'.','.') }}</td>
                                <td>Lunas</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>


        </div>
    </div>
    
    <script>
        window.print()
    </script>
</body>
</html>