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