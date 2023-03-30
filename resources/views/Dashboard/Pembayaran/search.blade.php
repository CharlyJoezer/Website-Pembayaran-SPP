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
    <td style="display:flex;flex-direction:column;border:none;border-bottom:1px solid #ccc;">
        <a href="entry-pembayaran-spp/history/{{ $item->nisn }}" class="button-history" style="margin-bottom:8px;"><i class="fa-solid fa-file-lines"></i> Riwayat Pembayaran</a>
        @if (Auth::guard('petugas')->user()->level == 'admin')
        <a target="_blank" href="history-pembayaran/generate-laporan/{{ $item->nisn }}" class="button-generate-laporan"><i class="fa-solid fa-print"></i> Generate Laporan</a>
        @endif
    </td>
</tr>
@endforeach 