@foreach ($data as $item)
<tr>
    <td>{{ $item->nisn }}</td>
    <td>{{ $item->nis }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->kelas->nama_kelas.'-'.$item->kelas->kompetensi_keahlian }}</td>
    <td>
        <div class="wrapper-action">
            <a href="entry-pembayaran-spp/history/{{ $item->nisn }}" class="button-history">Lihat Riwayat Pembayaran</a>
        </div>
    </td>
</tr>
@endforeach