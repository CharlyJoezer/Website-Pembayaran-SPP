@foreach ($data as $item)
<tr>
    <td>{{ $item->nisn }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->kelas->nama_kelas.'-'.$item->kelas->kompetensi_keahlian }}</td>
    <td>{{ $item->spp->tahun }}</td>
    <td>Rp. {{ number_format($item->spp->nominal,0,'.','.') }}</td>
    <td>
        @if (isset($item->pembayaran[0]))
        <span style="font-weight:bold;">{{ $item->pembayaran[0]['bulan_dibayar'] }}</span>
        @else
        <span>Belum ada Pembayaran</span>
        @endif
    </td>
    <td>
        <a href="entry-pembayaran-spp/history/{{ $item->nisn }}" class="button-history">History</a>
    </td>
</tr>
@endforeach 